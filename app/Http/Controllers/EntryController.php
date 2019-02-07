<?php

namespace App\Http\Controllers;

use App\Events\ScheduleChanged;
use App\Http\Requests\EntryRequest;
use App\Http\Resources\Entry as EntryResource;
use App\Entry;
use App\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class EntryController extends Controller
{
    /**
     * @param Request $request
     * @param Schedule $schedule
     * @return \Illuminate\Contracts\View\Factory|AnonymousResourceCollection|\Illuminate\View\View
     */
    public function index(Request $request, Schedule $schedule)
    {
        $expiresAt = now()->addDays(365);
        $entries = Cache::remember('entries.' . $schedule->id, $expiresAt, function () use ($schedule) {
            return Entry::whereHas('schedule.user', function ($query) {
                $query->where('user_id', Auth::id());
            })->where('schedule_id', $schedule->id)->orderBy('time', 'asc')->get();
        });

        if ($request->ajax()) {
            return EntryResource::collection($entries);
        }
        return view('entry.index', ['entries' => $entries, 'schedule' => $schedule]);
    }

    /**
     * @param Schedule $schedule
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Schedule $schedule)
    {
        return view('entry.create', ['schedule' => $schedule]);
    }

    /**
     * @param EntryRequest $request
     * @param Schedule $schedule
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(EntryRequest $request, Schedule $schedule)
    {
        $entry = new Entry();

        $entry->time = $request->input('time');
        $entry->red = $request->input('red');
        $entry->green = $request->input('green');
        $entry->blue = $request->input('blue');
        $entry->warmwhite = $request->input('warmwhite');
        $entry->coldwhite = $request->input('coldwhite');
        $entry->schedule()->associate($schedule);
        $entry->save();

        Cache::forget('entries.' . $schedule->id);
        Cache::forget('schedule.' . $schedule->id);

        event(new ScheduleChanged($schedule));

        return redirect(route('schedule.entries', ['schedule' => $schedule]));
    }

    /**
     * @param EntryRequest $request
     * @param Schedule $schedule
     * @param Entry $entry
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(EntryRequest $request, Schedule $schedule, Entry $entry)
    {
        return view('entry.edit', ['entry' => $entry, 'schedule' => $schedule]);
    }

    /**
     * @param EntryRequest $request
     * @param Schedule $schedule
     * @param Entry $entry
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(EntryRequest $request, Schedule $schedule, Entry $entry)
    {
        $entry->time = $request->input('time');
        $entry->red = $request->input('red');
        $entry->green = $request->input('green');
        $entry->blue = $request->input('blue');
        $entry->warmwhite = $request->input('warmwhite');
        $entry->coldwhite = $request->input('coldwhite');
        $entry->save();
        event(new ScheduleChanged($schedule));

        Cache::forget('entries.' . $schedule->id);
        Cache::forget('schedule.' . $schedule->id);

        return redirect(route('schedule.entries', ['schedule' => $schedule]));
    }

    /**
     * @param EntryRequest $request
     * @param Schedule $schedule
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(EntryRequest $request, Schedule $schedule)
    {
        Entry::destroy($request->input('id'));
        event(new ScheduleChanged($schedule));

        Cache::forget('entries.' . $schedule->id);

        return redirect(route('schedule.entries', ['schedule' => $schedule]));
    }
}
