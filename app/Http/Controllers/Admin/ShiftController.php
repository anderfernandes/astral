<?php

namespace App\Http\Controllers\Admin;

use App\{ Shift, Position, User };
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\{ Mail,  Log };

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$shifts = Shift::whereDate("start", now()->toDateString())->get();
        $shifts = Shift::all();

        return view("admin.shifts.index")->withShifts($shifts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $positions = Position::all();

        $users = User::where("staff", true)->get();

        $employees = $request->employees ?? 1;

        return view("admin.shifts.create")->withPositions($positions)
                                          ->withEmployees($employees)
                                          ->withUsers($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          "start.date"              => "required",
          "start.time"              => "required",
          "end.date"                => "required",
          "end.time"                => "required",
          "employees.*.user_id"     => "required|integer",
          "employees.*.position_id" => "required|integer",
        ]);

        $shift = new Shift;

        $shift->start = Carbon::parse("{$request->start['date']} {$request->start['time']}");
        $shift->end   = Carbon::parse("{$request->end['date']} {$request->end['time']}");
        $shift->creator_id = auth()->user()->id;

        $shift->save();

        //dd(array_column($request->employees, 'position_id'));
        $shift->employees()->attach(array_column($request->employees, 'user_id'));
        $shift->positions()->attach(array_column($request->employees, 'position_id'));

        /*foreach ($request->employees as $employee)
        {
          $user = User::find($employee['user_id']);
          $shift->positions()->attach($employee['position_id']);
        }*/

        // SEND EMAIL TO ALL USERS IN THIS SHIFT
        foreach ($shift->employees as $employee)
        {
          try {
            Mail::to($employee->email)
                ->bcc(auth()->user()->email)
                ->send(new \App\Mail\NewShift($shift, $employee));
          } catch (\Swift_TransportException $exception) {
            session()->flash('warning', "Unable send email to $employee->email: " . $exception->getMessage());
            Log::error($exception->getMessage());
            return redirect()->route("admin.shifts.show", $shift);
          }
        }

        session()->flash('success', "Shift created and emails sent succesfully!");

        return redirect()->route('admin.shifts.show', $shift);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shift)
    {
        return view("admin.shifts.show")->withShift($shift);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function edit(Shift $shift)
    {
        $positions = Position::all();

        $users = User::where("staff", true)->get();

        $employees = $request->employees ?? $shift->employees->count();


        return view("admin.shifts.edit")->withShift($shift)
                                        ->withPositions($positions)
                                        ->withEmployees($employees)
                                        ->withUsers($users);   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shift $shift)
    {
        $this->validate($request, [
          "start.date"              => "required",
          "start.time"              => "required",
          "end.date"                => "required",
          "end.time"                => "required",
          "employees.*.user_id"     => "required|integer",
          "employees.*.position_id" => "required|integer",
        ]);

        $shift->start = Carbon::parse("{$request->start['date']} {$request->start['time']}");
        $shift->end   = Carbon::parse("{$request->end['date']} {$request->end['time']}");
        $shift->creator_id = auth()->user()->id;

        $shift->save();

        //dd(array_column($request->employees, 'position_id'));
        $shift->employees()->detach();
        $shift->employees()->attach(array_column($request->employees, 'user_id'));

        $shift->positions()->detach();
        $shift->positions()->attach(array_column($request->employees, 'position_id'));

        // SEND EMAIL TO ALL USERS IN THIS SHIFT
        foreach ($shift->employees as $employee)
        {
          try {
            Mail::to($employee->email)
                ->bcc(auth()->user()->email)
                ->send(new \App\Mail\UpdatedShift($shift));
          } catch (\Swift_TransportException $exception) {
            session()->flash('warning', "Unable send email to $employee->email: " . $exception->getMessage());
            Log::error($exception->getMessage());
            return redirect()->route("admin.shifts.show", $shift);
          }
        }

        session()->flash('success', "Shift updated succesfully!");
        

        return redirect()->route('admin.shifts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shift $shift)
    {
        //
    }
}
