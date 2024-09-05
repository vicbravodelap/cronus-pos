<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::with(['category', 'stock'])->paginate();

        return view('products.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('products.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $file = $request->file('image');

        if ($file) {
            $path = $file->store('public/products');
            $request->merge(['image_path' => $path]);
        }

        $product = Product::create(
            $request->only([
                'name',
                'description',
                'category_id',
                'price',
                'discount',
                'sku',
                'status',
                'image_path'
            ])
        );

        Stock::firstOrCreate(
            ['product_id' => $product->id],
            [
                'quantity' => $request->quantity,
                'reorder_level' => $request->reorder_level,
                'max_level' => $request->max_level,
                'last_received_at' => Carbon::now()
            ]
        );

        return redirect()->to(
            route('products.index')
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
