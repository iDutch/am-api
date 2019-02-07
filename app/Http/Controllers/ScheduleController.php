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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|AnonymousResourceCollection|\Illuminate\View\View
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('schedule.create');
    }

    /**
     * @param ScheduleRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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
     * @param ScheduleRequest $request
     * @param Schedule $schedule
     * @return ScheduleWithEntriesResource
     */
    public function show(ScheduleRequest $request, Schedule $schedule)
    {
        $expiresAt = now()->addDays(365);
        $schedule = Cache::remember('schedule.' . $schedule->id, $expiresAt, function () use ($schedule) {
            return $schedule->with(['entries' => function ($query) {
                $query->orderBy('time', 'asc');
            }]);
        });

        return new ScheduleWithEntriesResource($schedule);
    }

    /**
     * @param ScheduleRequest $request
     * @param Schedule $schedule
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(ScheduleRequest $request, Schedule $schedule)
    {
        return view('schedule.edit', ['schedule' => $schedule]);
    }

    /**
     * @param ScheduleRequest $request
     * @param Schedule $schedule
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        $schedule->name = $request->input('name');
        $schedule->save();

        Cache::forget('schedule.' . $schedule->id);
        Cache::forget('schedules');

        return redirect(route('schedule.index'));
    }

    /**
     * @param ScheduleRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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
