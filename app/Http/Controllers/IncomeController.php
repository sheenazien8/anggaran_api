<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    /**
     * Get All Data income by paginate 10
     * @return Json Response
     */
    public function index()
    {
        $incomes = Income::with('category', 'user')
                            ->where('user_id', app('request')->auth->id)
                            ->orderBy('date', 'desc')->paginate(10);

        return response()->json([
            'incomes' => $incomes,
            'message' => 'Success!'
        ], 200);
    }
    /**
     * Get All Income Data
     * @return Reponse Json
     */
    public function getAll()
    {
        $incomes = Income::with('category', 'user')
                            ->where('user_id', app('request')->auth->id)
                            ->orWhereNull('user_id')->orderBy('date', 'desc')->get();

        return response()->json([
            'incomes' => $incomes,
            'message' => 'Success!'
        ], 200);
    }
    /**
     * Get Detail Income by Id $income
     * @param  Integer $income
     * @return  Json Response
     */
    public function detail($income)
    {
        $income = Income::with('category', 'user')->findOrFail($income);

        return response()->json([
            'message' => 'Success!',
            'income' => $income,
        ], 200);
    }
    /**
     * Store data income to database
     * @param  Request $request [
     *   'category_id', 'money', 'date
     * ]
     * @return Json Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'money' => 'required|int',
            'date' => 'required'
        ]);
        try {
            DB::beginTransaction();
            $category = Category::findOrFail($request->category_id);
            if ($category->type->name == 'Income') {
                $income = new Income();
                $income->fill($request->all());
                $income->category()->associate($category);
                $income->save();
            } else {
                DB::rollback();
                return response()->json([
                    "message" => "Category type is not allowed"
                ], 402);
            }
            DB::commit();

            return response()->json([
                'message' => 'Success!',
                'income' => $income,
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => true,
                'message' => $e->message
            ], 500);
        }
    }
    /**
     * Update data income
     * @param  Request $request [
     *   'category_id', 'money', 'date
     * ]
     * @param  Integer  $income
     * @return Json Response
     */
    public function update(Request $request, $income)
    {
        $income = Income::findOrFail($income);
        $this->validate($request, [
            'category_id' => 'required',
            'money' => 'required|int',
            'date' => 'required'
        ]);
        try {
            DB::beginTransaction();
            $category = Category::findOrFail($request->category_id);
            if ($category->type->name == 'Income') {
                $income->fill($request->all());
                $income->category()->associate($category);
                $income->save();
            } else {
                DB::rollback();
                return response()->json([
                    "message" => "Category type is not allowed"
                ], 402);
            }
            DB::commit();

            return response()->json([
                'message' => 'Success!',
                'income' => $income,
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => true,
                'message' => $e->message
            ], 500);
        }
    }
    /**
     * Delete data income
     * @param  Integer $income
     * @return Reponse Json
     */
    public function delete($income)
    {
        try {
            DB::beginTransaction();

            $income = Income::findOrFail($income);
            $income->delete();
            DB::commit();
            return response()->json([
                'message' => 'Success!'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => true,
                'message' => $e->message
            ]);
        }
    }
    /**
     * Search data income by description, user_id
     * @param  Request $request
     * @return Json Response
     */
    public function search(Request $request)
    {
        $incomes = Income::with('category', 'user')
                            ->where('description', 'LIKE', "%%".$request->input('q')."%%")
                            ->where('user_id', app('request')->auth->id)
                            ->orderBy('date', 'desc')->paginate(10);

        return response()->json([
            'message' => 'Success!',
            'incomes' => $incomes
        ]);
    }
}
