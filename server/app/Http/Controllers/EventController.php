<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller implements HasMiddleware
{
    protected array $rules = [
        '*.title' => ['required_with:*.is_all_day'],
        '*.is_all_day' => ['nullable'],
        '*.is_public' => ['nullable'],
        '*.start' => ['required', 'date'],
        '*.end' => ['required_with:is_all_day', 'date'],
        '*.memo' => ['required', 'string', 'min:3', 'max:255'],
        '*.show_id' => ['required', 'integer'],
        '*.type_id' => ['required', 'integer'],
        '*.seats' => ['required', 'integer'], // TODO: invalidate seats greater than capacity,
    ];

    public static function middleware(): array
    {
        return [
            new Middleware(Authenticate::using('sanctum'), except: ['index', 'show'])
        ];
    }

    /**
     * Display a listing of the resource.
     * Application runtime timezone should always be UTC.
     * Read browser timezone and add that value to the UTC offset.
     */
    public function index(Request $request): Response
    {
        $start = $request->has('start')
            ? Carbon::parse($request->query('start'))->startOfDay()
            : Carbon::today();
        $end = $request->has('end')
            ? Carbon::parse($request->query('end'))->endOfDay()
            : Carbon::today();

        if ($end->unix() < $start->unix()) {
            $end = $start;
        }

        $events = (new Event())
            ->where('start', '>=', $start->addHours(6))
            ->where('start', '<=', $end->addHours(6))
            ->orderByDesc('start')
            ->with(['show.type', 'type'])
            ->get();

        if ($request->has('calendar')) {
            $dates = $events->map(function ($event) {
                return $event->start->startOfDay();
            })->unique()->sort()->values();

            $data = $dates->map(function ($date) use ($events) {
               return [
                   'date' => $date->format('Y-m-d'),
                   'events' => $events->filter(function ($event) use ($date) {
                        return $event->start->startOfDay() == $date;
                    })->sortBy('start')->values()
               ];
            });

            return response(['data' => $data]);
        }

        return response(['data' => $events, 'start' => $start, 'end' => $end], 200);
    }

    /**
     * Saves an array of events to the database.
     */
    public function store(Request $request): Response
    {
        $validator = Validator::make($request->input(), $this->rules);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }

        if (count($request->input()) <= 0) {
            return response(['message' => 'Invalid request', 'data' => $request->input()], 422);
        }

        $events = [];

        foreach ($request->input() as $event) {
            $memo = $event['memo'];
            $hasTitle = array_key_exists('is_all_day', $event) && array_key_exists('title', $event);
            $event = (new Event())->create([
                'is_all_day' => array_key_exists("is_all_day", $event),
                'is_public' => array_key_exists('is_public', $event),
                'creator_id' => $request->user()->id,
                'start' => $event['start'],
                'end' => Carbon::parse($event['end']),
                // Old memo field servers as title field for all day events.
                'memo' => $hasTitle ? $event['title'] : null,
                'show_id' => $event['show_id'],
                'type_id' => $event['type_id'],
                'seats' => $event['seats'],
            ]);

            $event->memos()->create([
                'message' => $memo,
                'author_id' => $request->user()->id
            ]);

            $events[] = $event->id;
        }

        //return response(['data' => $events[0], 'message' => count($events)], 201);
        return response(['data' => $events[count($events) - 1]], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): Response
    {
        return response($event->load(['show.type', 'type', 'memos.author.role']), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event): Response
    {
        $rules = [
            'title' => ['required_if:*.is_all_day,true'],
            'is_all_day' => ['nullable'],
            'is_public' => ['nullable'],
            'start' => ['required', 'date'],
            'end' => ['required_with:is_all_day', 'date'],
            'memo' => ['required', 'string', 'min:3', 'max:255'],
            'show_id' => ['required', 'integer'],
            'type_id' => ['required', 'integer'],
            'seats' => ['required', 'integer'], // TODO: invalidate seats greater than capacity,
        ];

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }

        $event->update([...$request->input(), 'seats' => $request->input('seats')]);

        $memo = $event['memo'];
        $hasTitle = $request->has('is_all_day') && $request->has('title');

        $event->memos()->create([
            'message' => $memo,
            'author_id' => $request->user()->id
        ]);

        return response(['data' => $event->id], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
