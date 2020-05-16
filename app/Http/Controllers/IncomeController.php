<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Income;
use App\Transformers\IncomeTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class IncomeController extends Controller
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
     * Get All Income
     * @return Illuminate\Http\Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginator = Income::with('category', 'user')
                            ->when(app('request')->search, function ($query) {
                                return $query->search(app('request')->search, ['description']);
                            })
                            ->where('user_id', app('request')->auth->id)
                            ->orWhereNull('user_id')->orderBy('date', 'desc')
                            ->paginate(app('request')->paginate ?? null);
        $expenses = $paginator->getCollection();
        $resources = new Collection($expenses, new IncomeTransformer());
        if (app('request')->paginate) {
            $resources->setPaginator(new IlluminatePaginatorAdapter($paginator));
        }
        $response = $this->fractal->createData($resources)->toArray();

        return response()->json($response);
    }
    /**
     * Get Detail Income data
     * @param  Int $expense
     * @return Illuminate\Http\JsonResponse
     */
    public function detail(int $expense): JsonResponse
    {
        $expense = Income::with('category', 'user')->findOrFail($expense);
        $resources = new Item($expense, new IncomeTransformer);
        $response = $this->fractal->createData($resources)->toArray();

        return response()->json($response);
    }
    /**
     * Store Data Income
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->validateRequest($request);
        $category = Category::findOrFail($request->category_id);
        try {
            DB::beginTransaction();
            $expense = new Income();
            $expense->fill($request->all());
            $expense->category()->associate($category);
            $expense->save();
            $resources = new Item($expense, new IncomeTransformer());
            $response = $this->fractal->createData($resources)->toArray();
            DB::commit();

            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json($e);
        }
    }
    /**
     * Update Date Income
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
            $expense = Income::findOrFail($expense);
            $expense->fill($request->all());
            $expense->category()->associate($category);
            $expense->update();
            $resources = new Item($expense, new IncomeTransformer());
            $response = $this->fractal->createData($resources)->toArray();
            DB::commit();

            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json($e);
        }
    }
    /**
     * Delete Income
     * @param  int    $expense
     * @return Illuminate\Http\JsonResponse
     */
    public function delete(int $expense): JsonResponse
    {
        try {
            DB::beginTransaction();
            $expense = Income::findOrFail($expense);
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
                if ($category->type->name != 'Income') {
                    return $fail('Category type is not allowed');
                }
            }],
            'money' => 'required|int',
            'date' => 'required'
        ]);
    }
}
