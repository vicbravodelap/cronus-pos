<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{

    public function index(): View
    {
        $categories = Category::query()
            ->paginate();

        confirmDelete();

        return View('categories.index', [
            'categories' => $categories
        ]);
    }

    public function create(): View
    {
        return View('categories.create');
    }

    public function show(Category $category)
    {
        return View('categories.show', [
            'category' => $category
        ]);
    }

    public function edit(Category $category)
    {
        return View('categories.edit', [
            'category' => $category
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::query()
            ->create(
                $request->validated()
            );

        toast('Categoría creada correctamente!', 'success');

        return redirect()->to(
            route('categories.index', ['category' => $category])
        );
    }

    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $category->update(
            $request->validated()
        );

        toast('Categoría actualizada correctamente!', 'success');

        return redirect()->to(
            route('categories.index', ['category' => $category])
        );
    }

    public function destroy(Category $category)
    {
        $category->delete();

        toast('Categoría eliminada correctamente!', 'info');

        return redirect()->to(
            route('categories.index')
        );
    }
}
