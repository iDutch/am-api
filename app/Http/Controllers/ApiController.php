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
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getCrossbarClients()
    {
        return CrossbarClientRecource::collection(CrossbarClient::where('user_id', Auth::id())->get());
    }

    /**
     * @param ScheduleRequest $request
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getSchedule(ScheduleRequest $request, Schedule $schedule)
    {
        return ScheduleResource::collection($schedule);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logTemperature(Request $request) {
        $temperature = new Temperature();
        $temperature->temperature = (float) $request->input('temperature');
        $temperature->save();
        return response()->json()->setStatusCode(202);
    }
}
