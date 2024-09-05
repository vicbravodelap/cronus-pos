<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    public function testCanIndexProducts(): void
    {
        $this->get(route('products.index'))
            ->assertStatus(200)
            ->assertViewIs('products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([
                'Productos'
            ]);
    }

    public function testCanCreateProduct(): void
    {
        $this->get(route('products.create'))
            ->assertStatus(200)
            ->assertViewIs('products.create')
            ->assertViewHas('categories')
            ->assertSeeInOrder([
                'Crear producto',
                'Nombre',
                'Categoría del producto',
                'SKU',
                'Descuento',
                'Estatus del producto',
                'Precio',
                'Descripción',
                'Imagen del producto',
                'Datos del stock',
                'Cantidad',
                'Nivel de reorden',
                'Nivel máximo',
                'Guardar'
            ]);
    }

    public function testCanStoreProduct(): void
    {
        $this->actingAs(
            User::factory()->create()
        );

        $categoryId = Category::factory()->create()->id;

        $productData = [
            'name' => 'Product 1',
            'price' => 100.00,
            'status' => 'active',
            'category_id' => $categoryId,
            'sku' => 'SKU-1',
            'discount' => 10,
            'description' => 'Description of product 1',
            'quantity' => 10,
            'reorder_level' => 5,
            'max_level' => 20
        ];

        $this->post(route('products.store'), $productData);

        $this->assertDatabaseHas('products', [
            'name' => 'Product 1',
            'price' => 100.00,
            'status' => 'active',
            'category_id' => $categoryId,
            'sku' => 'SKU-1',
            'discount' => 10,
            'description' => 'Description of product 1'
        ]);
    }
}
