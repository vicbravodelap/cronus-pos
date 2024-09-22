<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{

    public function index(Request $request): View
    {
        $search = $request->input('search');

        $categories = Category::query()
            ->search($search)
            ->paginate()
            ->appends(['search' => $search]);

        confirmDelete();

        return view('categories.index', [
            'categories' => $categories
        ]);
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function show(Category $category)
    {
        return view('categories.show', [
            'category' => $category
        ]);
    }

    public function edit(Category $category)
    {
        return view('categories.edit', [
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
            route('categories.index')
        );
    }

    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $category->update(
            $request->validated()
        );

        toast('Categoría actualizada correctamente!', 'success');

        return redirect()->to(
            route('categories.index')
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
