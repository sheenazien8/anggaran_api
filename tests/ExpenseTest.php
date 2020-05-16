<?php

use App\Models\Expense;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ExpenseTest extends TestCase
{
    /**
     * Test Get Expense
     * @return void
     */
    public function testGetExpense(): void
    {
        $user = User::first();
        $response = $this->get('/expense', $this->headers($user));
        $this->seeStatusCode(200)
                ->seeJsonStructure([
                    'data'
                ]);
    }
    /**
     * Test Create expense
     * @return void
     */
    public function testCreateExpense(): void
    {
        $data = [
            "category_id" => 25,
            "money" => 800000,
            "date" => "2020-04-20",
            "description" => "gaji bulan september"
        ];
        $user = User::first();
        $response = $this->post('/expense', $data, $this->headers($user));
        $this->seeStatusCode(200)
                ->seeJsonStructure([
                    'data'
                ]);
    }
    /**
     * Test Update Expense
     * @return void
     */
    public function testUpdateExpense(): void
    {
        $data = [
            'category_id' => 25,
            'money' => 500000,
            'date' => "2020-04-19",
            'description' => 'Gaji Bulan September'
        ];
        $randExpense = Expense::find(rand(Expense::first()->id, Expense::latest()->first()->id));
        $user = User::first();
        $response = $this->put("/expense/$randExpense->id", $data, $this->headers($user));
        $this->seeStatusCode(200)
                ->seeJsonStructure([
                    'data'
                ]);
    }
    /**
     * Test Delete Expense
     * @return void
     */
    public function testtDeleteExpense(): void
    {
        $randExpense = Expense::find(rand(Expense::first()->id, Expense::latest()->first()->id));
        $user = User::first();
        $response = $this->delete("/expense/$randExpense->id", [], $this->headers($user));
        $this->seeStatusCode(200);
    }
}
