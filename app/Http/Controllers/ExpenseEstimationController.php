<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ExpenseEstimation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ExpenseEstimationController extends Controller
{
    public function index()
    {
        $incomes = ExpenseEstimation::with('category', 'user')
                            ->where('user_id', Cache::get('auth')->id)
                            ->latest()->paginate(10);

        return response()->json([
            'incomes' => $incomes,
            'message' => 'Success!'
        ], 200);
    }

    public function getAll()
    {
        $incomes = ExpenseEstimation::with('category', 'user')
                            ->where('user_id', Cache::get('auth')->id)
                            ->orWhereNull('user_id')->latest()->get();

        return response()->json([
            'incomes' => $incomes,
            'message' => 'Success!'
        ], 200);
    }

    public function detail($income)
    {
        $income = ExpenseEstimation::with('category', 'user')->find($income);

        return response()->json([
            'message' => 'Success!',
            'income' => $income,
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'money' => 'required',
            'date' => 'required'
        ]);
        $category = Category::find($request->category_id);
        if ($category->type->name == 'Expense') {
            $income = new ExpenseEstimation();
            $income->fill($request->all());
            $income->category()->associate($category);
            $income->save();
        }else {
            return response()->json([
                "message" => "Category type is not allowed"
            ], 402);
        }
        return response()->json([
            'message' => 'Success!',
            'income' => $income,
        ], 200);
    }

    public function update(Request $request, $income)
    {
        $income = ExpenseEstimation::find($income);
        $this->validate($request, [
            'category_id' => 'required',
            'money' => 'required',
            'date' => 'required'
        ]);
        $category = Category::find($request->category_id);
        if ($category->type->name == 'Expense') {
            $income->fill($request->all());
            $income->category()->associate($category);
            $income->save();
        }else {
            return response()->json([
                "message" => "Category type is not allowed"
            ], 402);
        }

        return response()->json([
            'message' => 'Success!',
            'income' => $income,
        ], 200);
    }


    public function delete($income)
    {
        $income = ExpenseEstimation::find($income);
        $income->delete();

        return response()->json([
            'message' => 'Success!'
        ]);
    }

    public function search(Request $request)
    {
        $incomes = ExpenseEstimation::with('category', 'user')
                            ->where('description', 'LIKE', "%%".$request->input('q')."%%")
                            ->where('user_id', Cache::get('auth')->id)
                            ->latest()->paginate(10);

        return response()->json([
            'message' => 'Success!',
            'incomes' => $incomes
        ]);
    }
}
