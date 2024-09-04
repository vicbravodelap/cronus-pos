<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{

    public function index(): View
    {
        $categories = Category::query()
            ->paginate();

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

        return redirect()->to(
            route('categories.edit', ['category' => $category])
        );
    }

    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $category->update(
            $request->validated()
        );

        return redirect()->to(
            route('categories.edit', ['category' => $category])
        );
    }
}
