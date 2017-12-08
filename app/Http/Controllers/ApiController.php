<?php

namespace App\Http\Controllers;

use App\CrossbarClient;
use App\Schedule;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CrossbarClient as CrossbarClientRecource;
use App\Http\Resources\Schedule as ScheduleResource;

class ApiController extends Controller
{
    public function getCrossbarClients()
    {
        return CrossbarClientRecource::collection(CrossbarClient::where('user_id', Auth::id())->get());
    }

    public function getSchedules()
    {
        return ScheduleResource::collection(Schedule::where('user_id', Auth::id())->get());
    }
}
