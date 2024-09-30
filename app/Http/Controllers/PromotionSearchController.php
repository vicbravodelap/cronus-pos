<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionSearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $search = $request->get('q');

        $promotions = Promotion::search($search)->get();

        return response()->json($promotions->map(function($promotion) {
            return ['id' => $promotion->id, 'text' => $promotion->name];
        }));
    }
}
