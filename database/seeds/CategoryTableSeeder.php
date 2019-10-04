<?php

use App\Models\Category;
use App\Models\Type;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
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
        Category::insert($data);

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
        Category::insert($data);
        $type = Type::where('name', 'Expense')->first()->id;
        $data = [
            [
                'name' => 'Insurance',
                'type_id' => $type
            ],
            [
                'name' => 'Baby',
                'type_id' => $type
            ],
            [
                'name' => 'Fruits',
                'type_id' => $type
            ],
            [
                'name' => 'Electronics',
                'type_id' => $type
            ],
            [
                'name' => 'Pet',
                'type_id' => $type
            ],
            [
                'name' => 'Entertainment',
                'type_id' => $type
            ],
            [
                'name' => 'Office',
                'type_id' => $type
            ],
            [
                'name' => 'Beuaty',
                'type_id' => $type
            ],
            [
                'name' => 'Health',
                'type_id' => $type
            ],
            [
                'name' => 'Other',
                'type_id' => $type
            ],
            [
                'name' => 'Food',
                'type_id' => $type
            ],
            [
                'name' => 'Car',
                'type_id' => $type
            ],
            [
                'name' => 'Motorcycle',
                'type_id' => $type
            ],
            [
                'name' => 'Wear',
                'type_id' => $type
            ],
            [
                'name' => 'Education',
                'type_id' => $type
            ],
            [
                'name' => 'Home',
                'type_id' => $type
            ],
            [
                'name' => 'Bill',
                'type_id' => $type
            ],
            [
                'name' => 'Phone',
                'type_id' => $type
            ],
            [
                'name' => 'Transportation',
                'type_id' => $type
            ],
        ];
        Category::insert($data);

    }
}
