<?php

namespace Tests\Feature;

use App\Models\Membership;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class MembershipControllerTest extends TestCase
{
    public function testCanIndexMemberships(): void
    {
        $this->actingAs(
            User::factory()->create()
        );

        $this->get(
            route('memberships.index')
        )
        ->assertOk()
        ->assertSeeInOrder([
            'Membresías',
            'Nueva membresía',
            'Nombre',
            'Inicio',
            'Fin',
            'Dias restantes',
            'Estado',
            'Promoción',
            'Acciones'
        ])
        ->assertViewIs('memberships.index')
        ->assertViewHas('memberships');
    }

    public function testCanCreateMembership(): void
    {
        $this->actingAs(
            User::factory()->create()
        );

        $this->get(
            route('memberships.create')
        )
        ->assertOk()
        ->assertSeeInOrder([
            'Crear membresía',
            'Nombre',
            'Email',
            'Contraseña',
            'Confirmación de contraseña',
            'Inicia',
            'Termina',
            'Estatus',
            'Promoción',
            'Guardar'
        ])
        ->assertViewIs('memberships.create')
        ->assertViewHas('promotions');
    }

    public function testCanStoreMembership(): void
    {
        $this->actingAs(
            User::factory()->create()
        );

        $this->post(
            route('memberships.store'),
            [
                'name' => 'John Doe',
                'email' => 'email@email.com',
                'password' => 'password',
                'password_confirmation' => 'password',
                'start_at' => '2021-01-01',
                'end_at' => '2021-12-31',
                'status' => 'active'
            ]
        )
        ->assertRedirect(
            route('memberships.index')
        );

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'email@email.com',
        ]);
    }

    public function testCanDeleteMembership(): void
    {
        $this->actingAs(
            User::factory()->create()
        );

        $membership = Membership::factory()->create();

        $this->delete(
            route('memberships.destroy', $membership)
        )
        ->assertRedirect(
            route('memberships.index')
        );

        $this->assertSoftDeleted('memberships', [
            'id' => $membership->id,
        ]);
    }

    public function testCanUpdateMembership(): void
    {
        $this->actingAs(
            User::factory()->create()
        );

        $membership = Membership::factory()->create();

        $this->put(
            route('memberships.update', $membership),
            [
                'name' => 'John Doe',
                'email' => 'email@email.com',
                'start_at' => '2021-01-01',
                'end_at' => '2021-12-31',
                'status' => 'active'
            ]
        );

        $this->assertDatabaseHas('memberships', [
            'user_id' => $membership->user_id,
            'status' => 'active',
        ]);
    }

    public function testCanEditMembership(): void
    {
        $this->actingAs(
            User::factory()->create()
        );

        $membership = Membership::factory()->create();

        $this->get(
            route('memberships.edit', $membership)
        )
        ->assertOk()
        ->assertSeeInOrder([
            'Editar membresía',
            'Datos de la membresía',
            'Nombre',
            'Email',
            'Inicia',
            'Termina',
            'Estatus',
            'Promoción',
            'Guardar'
        ])
        ->assertViewIs('memberships.edit')
        ->assertViewHas('membership');
    }

    public function testGetDaysLeftScope(): void
    {
        $membership = Membership::factory()->create([
            'end_at' => Carbon::now()->addMonth()
        ]);

        $this->assertEquals(
            30,
            $membership->daysLeft
        );

        $membershipWithEndDateInThePast = Membership::factory()->create([
            'end_at' => Carbon::now()->subMonth()
        ]);

        $this->assertEquals(
            0,
            $membershipWithEndDateInThePast->daysLeft
        );
    }
}
