<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMembershipRequest;
use App\Http\Requests\UpdateMembershipRequest;
use App\Models\Membership;
use App\Models\Promotion;
use App\Models\User;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $memberships = Membership::with('user', 'promotions')
            ->orderBy('id', 'desc')
            ->paginate();

        confirmDelete();

        return view('memberships.index', [
            'memberships' => $memberships,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $promotions = Promotion::all();

        return view('memberships.create', [
            'promotions' => $promotions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMembershipRequest $request)
    {
        $user = User::create(
            $request->only('name', 'email', 'password')
        );

        $user->membership()->create($request->only(
            'start_at',
            'end_at',
            'status',
            'promotion_id'
        ));

        toast('Membresía creada correctamente!', 'success');

        return redirect()->route('memberships.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Membership $membership)
    {
        $membership->load('user');

        $promotions = Promotion::all();

        return view('memberships.edit', [
            'membership' => $membership,
            'promotions' => $promotions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMembershipRequest $request, Membership $membership)
    {
        $membership->user->update(
            $request->only('name', 'email')
        );

        $membership->update($request->only(
            'start_at',
            'end_at',
            'status',
            'promotion_id'
        ));

        toast('Membresía actualizada correctamente!', 'success');

        return redirect()->route('memberships.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Membership $membership)
    {
        $membership->user->delete();

        $membership->delete();

        toast('Membresía eliminada correctamente!', 'success');

        return redirect()->route('memberships.index');
    }
}
