<?php

namespace Tests\Feature;

use App\Models\Membership;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\User;
use Tests\TestCase;

class PromotionAssignmentControllerTest extends TestCase
{
    public function testCanCreatePromotionAssignment()
    {
        $this->actingAs(User::factory()->create());

        Product::factory(10)->create();

        $promotion = Promotion::factory()->create();

        $response = $this->get(route('promotions.assignments.create', $promotion));

        $response->assertSeeInOrder([
            'Asignar promoción',
            'Product',
            'Guardar'
        ]);

        $response->assertStatus(200);
    }

    public function testStorePromotionAssignmentValidation()
    {
        $this->actingAs(User::factory()->create());

        $promotion = Promotion::factory()->create();

        Product::factory(3)->create();

        $modelData = [
            'promotion_id' => $promotion->id,
            'product_ids' => [999],
        ];

        $response = $this->post(route('promotions.assignments.store'), $modelData);

        $response->assertSessionHasErrors(['product_ids.0']);
    }

    public function testCanAssignPromotion()
    {
        $this->actingAs(User::factory()->create());

        $promotion = Promotion::factory()->create();

        $products = Product::factory(10)->create();

        $response = $this->post(route('promotions.assignments.store', [
            'promotion_id' => $promotion->id,
            'product_ids' => $products->pluck('id')->toArray()
        ]));

        $response->assertRedirect(route('promotions.index'));
    }

    public function testCanAssignPromotionToAllProducts()
    {
        $this->actingAs(User::factory()->create());

        $promotion = Promotion::factory()->create();

        Product::factory(10)->create();

        $response = $this->post(route('promotions.assignments.store', [
            'promotion_id' => $promotion->id,
            'product_ids' => ['all']
        ]));

        $response->assertRedirect(route('promotions.index'));
    }

    public function testPromotionHasManyMemberships()
    {
        $promotion = Promotion::factory()->create();
        $membership = Membership::factory()->create();

        $promotion->memberships()->attach($membership);

        $this->assertTrue($promotion->memberships->contains($membership));
    }

    public function testPromotionHasManyProducts()
    {
        $promotion = Promotion::factory()->create();
        $product = Product::factory()->create();

        $promotion->products()->attach($product);

        $this->assertTrue($promotion->products->contains($product));
    }
}
