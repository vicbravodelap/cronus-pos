<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PromotionController extends Controller
{

    public function index(Request $request): View
    {
        $search = $request->input('search');

        $promotions = Promotion::search($search)->paginate()
            ->appends(['search' => $search]);

        confirmDelete();

        return view('promotions.index', [
            'promotions' => $promotions,
        ]);
    }

    public function create()
    {
        return view('promotions.create', [
            'availableModels' => Promotion::$availableModels,
        ]);
    }

    public function store(StorePromotionRequest $request)
    {
        $validated = $request->validated();

        Promotion::create($validated);

        toast('¡La promoción ha sido creada correctamente!', 'success');

        return redirect()->route('promotions.index');
    }

    public function show(Promotion $promotion)
    {
        return view('promotions.show', [
            'promotion' => $promotion,
        ]);
    }

    public function edit(Promotion $promotion)
    {
        return view('promotions.edit', [
            'promotion' => $promotion,
            'availableModels' => Promotion::$availableModels,
        ]);
    }

    public function update(UpdatePromotionRequest $request, Promotion $promotion)
    {
        $validated = $request->validated();

        $promotion->update($validated);

        toast('¡La promoción ha sido actualizada correctamente!', 'success');

        return redirect()->route('promotions.index');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        toast('¡La promoción ha sido eliminada correctamente!', 'success');

        return redirect()->route('promotions.index');
    }
}
