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
     * Display a listing of the resource.
     *
     * @param   Request $request
     * @param   int     $schedule_id
     * @return  \Illuminate\Http\Response|AnonymousResourceCollection
     */
    public function index(Request $request, $schedule_id)
    {
        $expiresAt = now()->addDays(365);
        $entries = Cache::remember('entries.' . $schedule_id, $expiresAt, function () use ($schedule_id) {
            return Entry::whereHas('schedule.user', function ($query) {
                $query->where('user_id', Auth::id());
            })->where('schedule_id', $schedule_id)->orderBy('time', 'asc')->get();
        });

        if ($request->ajax()) {
            return EntryResource::collection($entries);
        }
        return view('entry.index', ['entries' => $entries, 'schedule_id' => $schedule_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param   int $schedule_id
     * @return  \Illuminate\Http\Response
     */
    public function create($schedule_id)
    {
        return view('entry.create', ['schedule_id' => $schedule_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param   EntryRequest    $request
     * @param   int             $schedule_id
     * @return  \Illuminate\Http\Response
     */
    public function store(EntryRequest $request, $schedule_id)
    {
        $entry = new Entry();
        $schedule = Schedule::find($schedule_id);

        $entry->time = $request->input('time');
        $entry->red = $request->input('red');
        $entry->green = $request->input('green');
        $entry->blue = $request->input('blue');
        $entry->warmwhite = $request->input('warmwhite');
        $entry->coldwhite = $request->input('coldwhite');
        $entry->schedule()->associate($schedule);
        $entry->save();

        Cache::forget('entries.' . $schedule_id);
        Cache::forget('schedule.' . $schedule_id);

        event(new ScheduleChanged(Schedule::find($schedule_id)));

        return redirect(route('schedule.entries', ['schedule_id' => $schedule_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param   EntryRequest    $request
     * @param   int             $schedule_id
     * @param   int             $id
     * @return  \Illuminate\Http\Response
     */
    public function edit(EntryRequest $request, $schedule_id, $id)
    {
        $entry = Entry::find($id);
        return view('entry.edit', ['entry' => $entry, 'schedule_id' => $schedule_id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param   EntryRequest $request
     * @param   int     $schedule_id
     * @param   int     $id
     * @return  \Illuminate\Http\Response
     */
    public function update(EntryRequest $request, $schedule_id, $id)
    {
        $entry = Entry::find($id);
        $entry->time = $request->input('time');
        $entry->red = $request->input('red');
        $entry->green = $request->input('green');
        $entry->blue = $request->input('blue');
        $entry->warmwhite = $request->input('warmwhite');
        $entry->coldwhite = $request->input('coldwhite');
        $entry->save();
        event(new ScheduleChanged(Schedule::find($schedule_id)));

        Cache::forget('entries.' . $schedule_id);
        Cache::forget('schedule.' . $schedule_id);

        return redirect(route('schedule.entries', ['schedule_id' => $schedule_id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param   EntryRequest $request
     * @param   int     $schedule_id
     * @return  \Illuminate\Http\Response
     */
    public function destroy(EntryRequest $request, $schedule_id)
    {
        Entry::destroy($request->input('id'));
        event(new ScheduleChanged(Schedule::find($schedule_id)));

        Cache::forget('entries.' . $schedule_id);

        return redirect(route('schedule.entries', ['schedule_id' => $schedule_id]));
    }
}
