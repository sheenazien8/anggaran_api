<?php

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create 10 users using the user factory
        $data = [
            ['name' => 'Income'],
            ['name' => 'Expense']
        ];
        Type::insert($data);
    }
}
