<?php

namespace Tests\Feature;

use App\Models\Stock;
use App\Models\User;
use Tests\TestCase;

class StockMovementControllerTest extends  TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create()
        );
    }

    public function testCreate()
    {
        $stock = Stock::factory()->create();

        $response = $this->get(route('stock.movements.create', $stock));

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $stock = Stock::factory()->create();

        $response = $this->post(route('stock.movements.store', $stock), [
            'stock_id' => $stock->id,
            'date'=> '2021-10-10',
            'quantity' => 10,
            'type' => 'in',
            'reason' => 'Test',
        ]);

        $response->assertRedirect(route('stock.movements.create', $stock));
    }
}
