<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberAssistanceRequest;
use App\Models\AttendanceToken;
use App\Models\MemberAssistance;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class MemberAssistanceController extends Controller
{
    public function index(): View
    {
        $records = MemberAssistance::whereDate('created_at', Carbon::today())
            ->with('user.membership')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('member-assistance.index', [
            'records' => $records
        ]);
    }

    public function store(StoreMemberAssistanceRequest $request)
    {
        $token = $request->input('token');

        $attendanceToken = AttendanceToken::where('token', $token)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        MemberAssistance::create([
            'user_id' => $attendanceToken->user_id
        ]);

        AttendanceToken::where('id', $attendanceToken->id)->delete();

        return response()->json([
            'message' => 'Asistencia registrada correctamente'
        ]);
    }
}
