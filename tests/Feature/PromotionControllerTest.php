<?php

namespace Tests\Feature;

use App\Models\Promotion;
use App\Models\User;
use Tests\TestCase;

class PromotionControllerTest extends TestCase
{
    public function testCanIndexPromotions()
    {
        $this->actingAs(
            User::factory()->create()
        );

        $response = $this->get(route('promotions.index'));

        $response->assertSeeInOrder([
            'Promociones',
            'Listado de promociónes',
            'Buscar promoción',
            'Nombre',
            'Código',
            'Descripción',
            'Fecha de Inicio',
            'Fecha de Fin',
            'Valor',
            'Acciones'
        ]);

        $response->assertStatus(200);
    }

    public function testCanCreatePromotion()
    {
        $this->actingAs(
            User::factory()->create()
        );

        $response = $this->get(route('promotions.create'));

        $response->assertSeeInOrder([
            'Crear promoción',
            'Nombre',
            'Descripción',
            'Código ',
            'Valor',
            'Guardar'
        ]);

        $response->assertStatus(200);
    }

    public function testCanStorePromotion()
    {
        $this->actingAs(
            User::factory()->create()
        );

        $response = $this->post(route('promotions.store'), [
            'name' => 'Promotion Name',
            'description' => 'Promotion Description',
            'code' => 'PROMO123',
            'type' => 'fixed',
            'value' => 10,
            'start_at' => now()->format('Y-m-d'),
            'end_at' => now()->addDays(10)->format('Y-m-d'),
            'applicable_models' => ['App\Models\Product'],
        ]);

        $response->assertRedirect(route('promotions.index'));
    }

    public function testCanDeletePromotion()
    {
        $this->actingAs(
            User::factory()->create()
        );

        $promotion = Promotion::factory()->create();

        $response = $this->delete(route('promotions.destroy', $promotion));

        $response->assertRedirect(route('promotions.index'));
    }

    public function testCanSearchPromotion()
    {
        $this->actingAs(
            User::factory()->create()
        );

        $promotion = Promotion::factory()->create();

        $response = $this->get(route('promotions.index', ['search' => $promotion->name]));

        $response->assertStatus(200);
    }

    public function testCantStorePromotionWithInvalidPercentageValue()
    {
        $this->actingAs(
            User::factory()->create()
        );

        $response = $this->post(route('promotions.store'), [
            'name' => 'Promotion Name',
            'description' => 'Promotion Description',
            'code' => 'PROMO123',
            'type' => 'percentage',
            'value' => 200,
            'start_at' => now()->format('Y-m-d'),
            'end_at' => now()->addDays(10)->format('Y-m-d'),
            'applicable_models' => ['App\Models\Product'],
        ]);

        $response->assertSessionHasErrors('value');

        $response->assertStatus(302);
    }

    public function testCantUpdatePromotionWithInvalidPercentageValue()
    {
        $this->actingAs(
            User::factory()->create()
        );

        $promotion = Promotion::factory()->create();

        $response = $this->put(route('promotions.update', $promotion), [
            'name' => 'Promotion Name',
            'description' => 'Promotion Description',
            'code' => 'PROMO123',
            'type' => 'percentage',
            'value' => 200,
            'start_at' => now()->format('Y-m-d'),
            'end_at' => now()->addDays(10)->format('Y-m-d'),
            'applicable_models' => ['App\Models\Product'],
        ]);

        $response->assertSessionHasErrors('value');

        $response->assertStatus(302);
    }

    public function testCanShowPromotion()
    {
        $this->actingAs(
            User::factory()->create()
        );

        $promotion = Promotion::factory()->create();

        $response = $this->get(route('promotions.show', $promotion));

        $response->assertSeeInOrder([
            'Detalles de la promoción',
            'Nombre',
            'Descripción',
            'Código',
            'Valor',
            'Volver'
        ]);

        $response->assertStatus(200);
    }

    public function testCanEditPromotion()
    {
        $this->actingAs(
            User::factory()->create()
        );

        $promotion = Promotion::factory()->create();

        $response = $this->get(route('promotions.edit', $promotion));

        $response->assertSeeInOrder([
            'Editar promoción',
            'Nombre',
            'Descripción',
            'Código',
            'Valor',
            'Guardar'
        ]);

        $response->assertStatus(200);
    }

    public function testCanUpdatePromotion()
    {
        $this->actingAs(
            User::factory()->create()
        );

        $promotion = Promotion::factory()->create();

        $response = $this->put(route('promotions.update', $promotion), [
            'name' => 'Promotion Name',
            'description' => 'Promotion Description',
            'code' => 'PROMO123',
            'type' => 'fixed',
            'value' => 10,
            'start_at' => now()->format('Y-m-d'),
            'end_at' => now()->addDays(10)->format('Y-m-d'),
            'applicable_models' => ['App\Models\Product'],
        ]);

        $response->assertRedirect(route('promotions.index'));
    }
}

