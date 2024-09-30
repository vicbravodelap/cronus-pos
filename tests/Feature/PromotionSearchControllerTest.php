<?php

namespace Tests\Feature;

use App\Models\Promotion;
use Tests\TestCase;

class PromotionSearchControllerTest extends TestCase
{
    public function testCanSearchPromotions(): void
    {
        Promotion::factory()->create([
            'name' => 'foo',
        ]);

        $response = $this->get(
            route('promotions.search', ['q' => 'foo'])
        );

        $response->assertStatus(200)
            ->assertJsonFragment([
                'text' => 'foo',
            ]);
    }
}
