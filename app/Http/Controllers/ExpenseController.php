<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use App\Transformers\ExpenseTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class ExpenseController extends Controller
{
    /**
     * Fractal Variable
     * @var Object
     */
    protected $fractal;
    public function __construct()
    {
        $this->fractal = new Manager();
    }
    /**
     * Get All Expense
     * @return Illuminate\Http\Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginator = Expense::with('category', 'user')
                            ->when(app('request')->search, function ($query) {
                                return $query->search(app('request')->search, ['description']);
                            })
                            ->where('user_id', app('request')->auth->id)
                            ->orWhereNull('user_id')->orderBy('date', 'desc')->paginate(app('request')->paginate ?? null);
        $expenses = $paginator->getCollection();
        $resources = new Collection($expenses, new ExpenseTransformer());
        if (app('request')->paginate) {
            $resources->setPaginator(new IlluminatePaginatorAdapter($paginator));
        }
        $response = $this->fractal->createData($resources)->toArray();

        return response()->json($response);
    }
    /**
     * Get Detail Expense data
     * @param  Int $expense
     * @return Illuminate\Http\JsonResponse
     */
    public function detail(int $expense): JsonResponse
    {
        $expense = Expense::with('category', 'user')->findOrFail($expense);
        $resources = new Item($expense, new ExpenseTransformer);
        $response = $this->fractal->createData($resources)->toArray();

        return response()->json($response);
    }
    /**
     * Store Data Expense
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->validateRequest($request);
        $category = Category::findOrFail($request->category_id);
        try {
            DB::beginTransaction();
            $expense = new Expense();
            $expense->fill($request->all());
            $expense->category()->associate($category);
            $expense->save();
            $resources = new Item($expense, new ExpenseTransformer());
            $response = $this->fractal->createData($resources)->toArray();
            DB::commit();

            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json($e);
        }
    }
    /**
     * Update Date Expense
     * @param  Request $request
     * @param  int     $expense
     * @return Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $expense): JsonResponse
    {
        $this->validateRequest($request);
        $category = Category::findOrFail($request->category_id);
        try {
            DB::beginTransaction();
            $expense = Expense::findOrFail($expense);
            $expense->fill($request->all());
            $expense->category()->associate($category);
            $expense->update();
            $resources = new Item($expense, new ExpenseTransformer());
            $response = $this->fractal->createData($resources)->toArray();
            DB::commit();

            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json($e);
        }
    }
    /**
     * Delete Expense
     * @param  int    $expense
     * @return Illuminate\Http\JsonResponse
     */
    public function delete(int $expense): JsonResponse
    {
        try {
            DB::beginTransaction();
            $expense = Expense::findOrFail($expense);
            $expense->delete();
            DB::commit();

            return response()->json(true);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json($e);
        }
    }
    /**
     * Validate Request
     * @param  Illuminate\Http\Request $request
     * @return void
     */
    protected function validateRequest($request): void
    {
        $this->validate($request, [
            'category_id' => ['required',
            function ($attribute, $value, $fail) {
                $category = Category::findOrFail($value);
                if ($category->type->name != 'Expense') {
                    return $fail('Category type is not allowed');
                }
            }],
            'money' => 'required|int',
            'date' => 'required'
        ]);
    }
}
