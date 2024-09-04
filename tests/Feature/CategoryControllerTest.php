<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCategoryIndex(): void
    {
        $this->get(
            route('categories.index')
        )->assertSee('Categorías')
            ->assertViewIs('categories.index')
            ->assertViewHas('categories');
    }

    public function testCategoryCreate(): void
    {
        $this->get(
            route('categories.create')
        )->assertSeeInOrder([
            'Crear una categoría',
            'Datos de la categoría',
            'Nombre de la categoría',
            'Inserta una descripción...',
            'Guardar'
        ])
        ->assertViewIs('categories.create');
    }

    public function testCategoryEdit(): void
    {
        $category = Category::factory()->create();

        $this->get(
            route('categories.edit', ['category' => $category->id])
        )->assertSeeInOrder([
            'Editar categoría',
            'Datos de la categoría',
            $category->name,
            $category->description,
            'Actualizar'
        ])
        ->assertViewIs('categories.edit');
    }

    public function testCategoryShow(): void
    {
        $category = Category::factory()->create();

        $this->get(
            route('categories.show', ['category' => $category->id])
        )->assertSeeInOrder([
            'Ver categoría',
            'Datos de la categoría',
            $category->name,
            $category->description
        ])
        ->assertViewIs('categories.show');
    }

    public function testCategoryUpdate(): void
    {
        $this->actingAs(
            User::factory()->create()
        );

        $category = Category::factory()->create();

        $categoryData = [
            'name' => 'Category test',
            'description' => 'Description test'
        ];

        $response = $this->put(
            route('categories.update', ['category' => $category->id]),
            $categoryData
        );

        $response->assertRedirect(
            route('categories.edit', ['category' => $category->id])
        );

        $this->assertDatabaseHas('categories', $categoryData);
    }

    public function testCategoryStore(): void
    {
        $this->actingAs(
            User::factory()->create()
        );

        $categoryData = [
            'name' => 'Category test',
            'description' => 'Description test'
        ];

        $response = $this->post(
            route('categories.store'),
            $categoryData
        );

        $category = Category::query()->latest()->first();

        $this->assertNotNull($category, 'Category was not created');

        $response->assertRedirect(
            route('categories.edit', ['category' => $category->id])
        );

        $this->assertDatabaseHas('categories', $categoryData);
    }
}
