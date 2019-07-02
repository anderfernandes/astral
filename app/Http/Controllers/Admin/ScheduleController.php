<?php

namespace App\Http\Controllers\Admin;

use App\{ Schedule, Shift };
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
      $shifts = Shift::whereIn('id', str_getcsv($request->shifts))->pluck('id')->all();

      $schedule = new Schedule;

      $schedule->creator_id = auth()->user()->id;

      $schedule->save();

      $schedule->shifts()->sync($shifts);

      session()->flash('success', "Schedule created successfully!");

      return redirect()->route('admin.schedules.show', $schedule);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
      $shifts = Shift::where('start', '>=', now()->startOfDay()->toDateTimeString())
                     ->orderBy('start', 'asc')
                     ->get();

        return view('admin.schedules.show')->withSchedule($schedule)->withShifts($shifts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {

        $schedule->memo = $request->memo;

        $schedule->save();

        $shifts = Shift::whereIn('id', str_getcsv($request->shifts))->pluck('id')->all();

        $schedule->shifts()->sync($shifts);

        session()->flash('success', "Schedule created successfully!");

        return redirect()->route('admin.schedules.show', $schedule);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }

    public function mail(Schedule $schedule)
    {
      $employees = [];
      foreach ($schedule->shifts as $shift)
        foreach($shift->employees as $employee)
          array_push($employees, $employee);
      
      $employees = $employees->unique();

      foreach ($employee as $user)
      {
        try {
          Mail::to($user->email)->send(new \App\Mail\NewSchedule($schedule));
        } catch (\Swift_TransportException $exception) {
          session()->flash('warning', "Unable send email to $user->email: " . $exception->getMessage());
          Log::error($exception->getMessage());
          return redirect()->route("admin.schedules.show", $schedule);
        }
      }

      // Send copy to sender???

      session()->flash('success', "Schedule emailed succesfully!");

      return redirect()->route("admin.schedules.show", $schedule);

    }
}
