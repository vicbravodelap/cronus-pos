<?php

namespace App\Http\Controllers;

use App\Models\AttendanceToken;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $attendanceToken = AttendanceToken::where('user_id', Auth::user()->id)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$attendanceToken) {
            AttendanceToken::where('user_id', Auth::user()->id)
                ->where('expires_at', '<=', Carbon::now())
                ->delete();

            $token = Hash::make(Auth::user()->id . Carbon::now()->timestamp);

            $attendanceToken = AttendanceToken::create([
                'user_id' => Auth::user()->id,
                'token' => $token,
                'expires_at' => Carbon::now()->addHours(2)
            ])->token;
        }

        $user = Auth::user()->load('membership');

        return view('home', [
            'token' => $attendanceToken->token ?? $attendanceToken,
            'user' => $user
        ]);
    }
}
