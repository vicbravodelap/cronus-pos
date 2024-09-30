<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePromotionAssignmentRequest;
use App\Models\Membership;
use App\Models\Promotion;
use Illuminate\View\View;

class PromotionAssignmentController extends Controller
{
    public function store(StorePromotionAssignmentRequest $request)
    {
        $promotion = Promotion::findOrFail($request->promotion_id);

        $modelIds = [];

        foreach ($request->all() as $key => $value) {
            if (str_ends_with($key, '_ids')) {
                $modelName = str_replace('_ids', '', $key);
                $modelIds[$modelName] = $value;
            }
        }

        foreach ($modelIds as $modelName => $ids) {
            $modelClass = 'App\\Models\\' . ucfirst($modelName);
            if (in_array('all', $ids)) {
                $allInstances = $modelClass::all();
                foreach ($allInstances as $instance) {
                    $instance->promotions()->syncWithoutDetaching($promotion);
                }
            } else {
                foreach ($ids as $id) {
                    $modelInstance = $modelClass::find($id);
                    if ($modelInstance) {
                        $modelInstance->promotions()->syncWithoutDetaching($promotion);
                    }
                }
            }
        }

        toast('Promoción asignada correctamente!', 'success');

        return redirect()->route('promotions.index');
    }

    public function create(Promotion $promotion): View
    {
        $applicableModels = $promotion->applicable_models;

        $modelsData = [];

        foreach ($applicableModels as $applicableModel) {
            if ($applicableModel == Membership::class) {
                $modelsData[$applicableModel] = Membership::with('user')->get()->toArray();
                continue;
            }
            $modelsData[$applicableModel] = $applicableModel::all()->toArray();
        }

        return view('promotions.assignments.create', [
            'promotion' => $promotion,
            'modelsData' => $modelsData,
        ]);
    }
}
