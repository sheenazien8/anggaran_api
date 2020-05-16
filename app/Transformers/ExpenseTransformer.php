<?php
namespace App\Transformers;

use App\Models\Expense;
use League\Fractal\TransformerAbstract;

class ExpenseTransformer extends TransformerAbstract
{
    /**
     * Transform return for expense
     * @param  Expense $expense
     * @return array
     */
    public function transform(Expense $expense): array
    {
        return [
            'id' => (int) $expense->id,
            'money' => (int) $expense->money,
            'date' => $expense->date,
            'description' => $expense->description,
            'user' => [
                'id' => (int) $expense->user->id,
                'username' => $expense->user->name,
                'email' => $expense->user->email
            ],
            'category' => [
                'id' => (int) $expense->category->id,
                'name' => $expense->category->name
            ],
            'links' => [
                'url' => '/expense/'.$expense->id
            ]
        ];
    }
}
