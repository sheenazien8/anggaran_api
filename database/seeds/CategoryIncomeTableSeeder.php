<?php

use App\Models\CategoryIncome;
use App\Models\Type;
use Illuminate\Database\Seeder;

class CategoryIncomeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = Type::where('name', 'Income')->first()->id;
        $data = [
            [
                'name' => 'Deposito',
                'type_id' => $type
            ],
            [
                'name' => 'Dividen',
                'type_id' => $type
            ],
            [
                'name' => 'Salary',
                'type_id' => $type
            ],
            [
                'name' => 'Grant',
                'type_id' => $type
            ],
            [
                'name' => 'Infestation',
                'type_id' => $type
            ],
            [
                'name' => 'Coupon',
                'type_id' => $type
            ],
            [
                'name' => 'Cashback',
                'type_id' => $type
            ],
            [
                'name' => 'Rewards',
                'type_id' => $type
            ],
            [
                'name' => 'Selling',
                'type_id' => $type
            ],
            [
                'name' => 'Rental',
                'type_id' => $type
            ],
            [
                'name' => 'Savings',
                'type_id' => $type
            ],
        ];
        CategoryIncome::insert($data);
    }
}
