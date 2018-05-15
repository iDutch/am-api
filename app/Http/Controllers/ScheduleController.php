<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use App\Http\Resources\Schedule as ScheduleResource;
use App\Http\Resources\ScheduleWithEntries as ScheduleWithEntriesResource;
use App\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response|AnonymousResourceCollection
     */
    public function index(Request $request)
    {

        $expiresAt = now()->addDays(365);
        $schedules = Cache::remember('schedules', $expiresAt, function () {
            return Schedule::where('user_id', Auth::id())->get();
        });

        if ($request->ajax()) {
            return ScheduleResource::collection($schedules);
        }

        return view('schedule.index', ['schedules' => $schedules]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        return view('schedule.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param   \App\Http\Requests\ScheduleRequest  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(ScheduleRequest $request)
    {
        $schedule = new Schedule();
        $schedule->name = $request->input('name');
        $schedule->user()->associate(Auth::user());
        $schedule->save();

        Cache::forget('schedules');

        return redirect(route('schedule.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param   ScheduleRequest $request
     * @param   int $id
     * @return  ScheduleResource
     */
    public function show(ScheduleRequest $request, $id)
    {
        $expiresAt = now()->addDays(365);
        $schedule = Cache::remember('schedule.' . $id, $expiresAt, function () use ($id) {
            return Schedule::with(['entries' => function ($query) {
                $query->orderBy('time', 'asc');
            }])->where('id', $id)->first();
        });

        return new ScheduleWithEntriesResource($schedule);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param   ScheduleRequest  $request
     * @param   int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit(ScheduleRequest $request, $id)
    {
        $schedule = new ScheduleResource(Schedule::where('id', $id)->first());

        return view('schedule.edit', ['schedule' => $schedule]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ScheduleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ScheduleRequest $request, $id)
    {
        $schedule = Schedule::find($id);
        $schedule->name = $request->input('name');
        $schedule->save();

        Cache::forget('schedule.' . $id);
        Cache::forget('schedules');

        return redirect(route('schedule.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ScheduleRequest  $request
     * @return  \Illuminate\Http\Response
     */
    public function destroy(ScheduleRequest $request)
    {
        $id = $request->input('id');
        Schedule::destroy($id);

        Cache::forget('schedule.' . $id);
        Cache::forget('schedules');

        return redirect(route('schedule.index'));
    }
}
