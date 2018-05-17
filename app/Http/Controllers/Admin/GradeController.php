<?php

namespace App\Http\Controllers\Admin;

use App\Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
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
        $this->validate($request, [
          'name' => 'required|min:5',
          'description' => 'required|min:5',
        ]);

        $grade = new Grade;

        $grade->name = $request->name;
        $grade->description = $request->description;
        $grade->creator_id = Auth::user()->id;

        $grade->save();

        Session::flash('success', "<strong>$grade->name</strong> added successfully!");

        return redirect()->to(route('admin.settings.index').'#grade');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show(Grade $grade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit(Grade $grade)
    {
        return view('admin.grades.edit')->withGrade($grade);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grade $grade)
    {
        $this->validate($request, [
          'name' => 'required|min:5',
          'description' => 'required|min:5',
        ]);

        $grade->name = $request->name;
        $grade->description = $request->description;

        $grade->save();

        Session::flash('success', "<strong>$grade->name</strong> updated successfully!");

        return redirect()->to(route('admin.settings.index').'#grade');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();

        Session::flash('success', "<strong>$grade->name</strong> deleted successfully!");

        return redirect()->to(route('admin.settings.index').'#grade');

    }
}
