<?php

namespace App\Http\Controllers;

use App\CrossbarClient;
use App\Http\Requests\ScheduleRequest;
use App\Schedule;
use App\Temperature;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CrossbarClient as CrossbarClientRecource;
use App\Http\Resources\Schedule as ScheduleResource;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getCrossbarClients()
    {
        return CrossbarClientRecource::collection(CrossbarClient::where('user_id', Auth::id())->get());
    }

    public function getSchedule(ScheduleRequest $request, $id)
    {
        return ScheduleResource::collection(Schedule::find($id));
    }

    public function logTemperature(Request $request) {
        $temperature = new Temperature();
        $temperature->temperature = (float) $request->input('temperature');
        $temperature->save();
        return response()->json()->setStatusCode(202);
    }
}
