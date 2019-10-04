<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ExpenseController extends Controller
{
    public function index()
    {
        $incomes = Expense::with('category', 'user')
                            ->where('user_id', Cache::get('auth')->id)
                            ->orderBy('date', 'desc')->paginate(10);

        return response()->json([
            'incomes' => $incomes,
            'message' => 'Success!'
        ], 200);
    }

    public function getAll()
    {
        $incomes = Expense::with('category', 'user')
                            ->where('user_id', Cache::get('auth')->id)
                            ->orWhereNull('user_id')->orderBy('date', 'desc')->get();

        return response()->json([
            'incomes' => $incomes,
            'message' => 'Success!'
        ], 200);
    }

    public function detail($income)
    {
        $income = Expense::with('category', 'user')->find($income);

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
            $income = new Expense();
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
        $income = Expense::find($income);
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
        $income = Expense::find($income);
        $income->delete();

        return response()->json([
            'message' => 'Success!'
        ]);
    }

    public function search(Request $request)
    {
        $incomes = Expense::with('category', 'user')
                            ->where('description', 'LIKE', "%%".$request->input('q')."%%")
                            ->where('user_id', Cache::get('auth')->id)
                            ->orderBy('date', 'desc')->paginate(10);

        return response()->json([
            'message' => 'Success!',
            'incomes' => $incomes
        ]);
    }
}
