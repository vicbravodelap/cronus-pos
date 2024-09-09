<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create()
        );
    }

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

    public function testCanIndexProductsWithSearchParam(): void
    {
        $product = Product::factory()->create([
            'name' => 'Product 1'
        ]);

        Stock::factory()
            ->count(1)
            ->for($product)
            ->create();

        $this->get(route('products.index', ['search' => 'Product 1']))
            ->assertStatus(200)
            ->assertViewIs('products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([
                'Productos',
                'Product 1'
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
                'Imagén del producto',
                'Datos del stock',
                'Cantidad',
                'Nivel de reorden',
                'Nivel máximo',
                'Guardar'
            ]);
    }

    public function testCanShowProduct(): void
    {
        $product = Product::factory()->create();

        Stock::factory()
            ->count(1)
            ->for($product)
            ->create();

        $this->get(route('products.show', $product->id))
            ->assertStatus(200)
            ->assertViewIs('products.show')
            ->assertViewHas('product')
            ->assertSeeInOrder([
                'Ver producto',
                'Nombre',
                'Categoría del producto',
                'SKU',
                'Descuento',
                'Estatus del producto',
                'Precio',
                'Descripción',
                'Imagén del producto',
                'Datos del stock',
                'Cantidad',
                'Nivel de reorden',
                'Nivel máximo'
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
            'max_level' => 20,
            'image' => UploadedFile::fake()->image('product.jpg')
        ];

        $this->post(route('products.store'), $productData)
            ->assertRedirect(route('products.index'));

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
    public function testCanEditProduct(): void
    {
        $product = Product::factory()->create();

        Stock::factory()
            ->count(1)
            ->for($product)
            ->create();

        $this->get(route('products.edit', $product->id))
            ->assertStatus(200)
            ->assertViewIs('products.edit')
            ->assertViewHas('product')
            ->assertViewHas('categories')
            ->assertSeeInOrder([
                'Editar producto',
                'Nombre',
                'Categoría del producto',
                'SKU',
                'Descuento',
                'Estatus del producto',
                'Precio',
                'Descripción',
                'Imagén del producto',
                'Datos del stock',
                'Cantidad',
                'Nivel de reorden',
                'Nivel máximo',
                'Guardar'
            ]);
    }

    public function testCanUpdateProduct(): void
    {
        $product = Product::factory()->create();

        Stock::factory()
            ->count(1)
            ->for($product)
            ->create();

        $categoryId = Category::factory()->create()->id;

        $productData = [
            'name' => 'Product 1',
            'price' => 100.00,
            'status' => 'active',
            'category_id' => $categoryId,
            'sku' => 'SKU-1',
            'discount' => 10,
            'description' => 'Description of product 1',
            'image' => UploadedFile::fake()->image('product.jpg'),
            'quantity' => 10,
            'reorder_level' => 5,
            'max_level' => 20
        ];

        $this->actingAs(
            User::factory()->create()
        );

        $this->put(route('products.update', $product->id), $productData)
            ->assertRedirect(route('products.edit', $product->id));

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

    public function testCanDeleteProduct(): void
    {
        $product = Product::factory()->create();

        Stock::factory()
            ->count(1)
            ->for($product)
            ->create();

        $this->actingAs(
            User::factory()->create()
        );

        $this->delete(route('products.destroy', $product->id))
            ->assertRedirect(route('products.index'));

        $this->assertSoftDeleted('products', [
            'id' => $product->id
        ]);

        $this->assertSoftDeleted('stocks', [
            'product_id' => $product->id
        ]);
    }
}
