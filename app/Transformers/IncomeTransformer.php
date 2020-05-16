<?php
namespace App\Transformers;

use App\Models\Income;
use League\Fractal\TransformerAbstract;

class IncomeTransformer extends TransformerAbstract
{
    /**
     * Transform return for income
     * @param  Income $income
     * @return array
     */
    public function transform(Income $income): array
    {
        return [
            'id' => (int) $income->id,
            'money' => (int) $income->money,
            'date' => $income->date,
            'description' => $income->description,
            'user' => [
                'id' => (int) $income->user->id,
                'username' => $income->user->name,
                'email' => $income->user->email
            ],
            'category' => [
                'id' => (int) $income->category->id,
                'name' => $income->category->name
            ],
            'links' => [
                'url' => '/income/'.$income->id
            ]
        ];
    }
}
