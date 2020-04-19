<?php

use App\Models\Income;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class IncomeTest extends TestCase
{
    /**
     * Test Get Income
     * @return void
     */
    public function testGetIncome(): void
    {
        $user = User::first();
        $response = $this->get('/income', $this->headers($user));
        $this->seeStatusCode(200)
                ->seeJsonStructure([
                    'incomes'
                ]);
    }
    /**
     * Test Create income
     * @return void
     */
    public function testCreateIncome(): void
    {
        $data = [
            "category_id" => 3,
            "money" => 800000,
            "date" => "2020-04-20",
            "description" => "gaji bulan september"
        ];
        $user = User::first();
        $response = $this->post('/income', $data, $this->headers($user));
        $this->seeStatusCode(200)
                ->seeJsonStructure([
                    'income'
                ]);
    }
    /**
     * Test Update Income
     * @return void
     */
    public function testUpdateIncome(): void
    {
        $data = [
            'category_id' => 3,
            'money' => 500000,
            'date' => "2020-04-19",
            'description' => 'Gaji Bulan September'
        ];
        $randIncome = Income::find(rand(Income::first()->id, Income::latest()->first()->id));
        $user = User::first();
        $response = $this->put("/income/$randIncome->id", $data, $this->headers($user));
        $this->seeStatusCode(200)
                ->seeJsonStructure([
                    'message'
                ]);
    }
    /**
     * Test Delete Income
     * @return void
     */
    public function testtDeleteIncome(): void
    {
        $randIncome = Income::find(rand(Income::first()->id, Income::latest()->first()->id));
        $user = User::first();
        $response = $this->delete("/income/$randIncome->id", [], $this->headers($user));
        $this->seeStatusCode(200)
                ->seeJsonStructure([
                    'message'
                ]);
    }
    /**
     * Test Search Income
     * @return void
     */
    public function testSearchIncome(): void
    {
        $randChar = Str::random();
        $user = User::first();
        $response = $this->get("/income/search?q=$randChar", $this->headers($user));
        $this->seeStatusCode(200)
                ->seeJsonStructure([
                    'incomes'
                ]);
    }
}
