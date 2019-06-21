<?php

namespace App\Http\Controllers\Admin;

use App\{ Shift, Position, User };
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shifts = Shift::whereDate("start", now()->toDateString())->get();

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

        foreach ($request->employees as $employee)
          $shift->employees()->attach($employee['user_id'], [ 'position_id' => $employee['position_id']]);

        return view("admin.shifts.index");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function edit(Shift $shift)
    {
        //
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
        //
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
