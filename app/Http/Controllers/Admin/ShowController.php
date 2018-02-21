<?php

namespace App\Http\Controllers\Admin;

use App\Show;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
Use Illuminate\Support\Facades\Auth;

class ShowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$shows = Show::where('id', '<>', 1)->orderBy('name', 'asc')->paginate(10);

        $shows = Show::where('id', '!=', 1);

        if (count($request->all()) > 0)
        {
          if ($request->showId) {
            $shows = $shows->where('id', $request->showId);
          }

          if ($request->showDuration) {
            $shows = $shows->where('duration', $request->showDuration);
          }

          if ($request->showType) {
            $shows = $shows->where('type', $request->showType);
          }

          $showIds = $shows->pluck('id');
          $shows = Show::whereIn('id', $showIds)->orderBy('name', 'asc')->paginate(50);
        }
        else
        {
          $shows = $shows->orderBy('name', 'asc')->paginate(10);
        }
        return view('admin.shows.index')->withShows($shows)->withRequest($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shows.create');
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
          'name'        => 'required|unique:shows',
          'description' => 'required',
          'type'        => 'required',
          'duration'    => 'required|integer',
        ]);

        $show = new Show;

        $show->name        = $request->name;
        $show->description = $request->description;
        $show->type        = $request->type;
        $show->duration    = $request->duration;

        if ($request->cover == "")
          $show->cover = "/default.png";
        else
          $show->cover       = $request->cover;

        $show->creator_id  = Auth::user()->id;

        $show->save();

        Session::flash('success', 'The '.$show->type.' show '.$show->name.' has been added successfully!');
        return redirect()->route('admin.shows.show', $show);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function show(Show $show)
    {
        return view('admin.shows.show')->withShow($show);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function edit(Show $show)
    {
        return view('admin.shows.edit')->withShow($show);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Show $show)
    {

      $this->validate($request, [
        'name'        => 'required|unique:shows, ' . $show->id,
        'description' => 'required',
        'type'        => 'required',
        'duration'    => 'required|integer',
      ]);

      $show->name        = $request->input('name');
      $show->description = $request->input('description');
      $show->type        = $request->input('type');
      $show->duration    = $request->input('duration');

      if ($request->cover == "")
        $show->cover = "/default.png";
      else
        $show->cover       = $request->cover;

      $show->save();

      Session::flash('success', 'The '.$show->type.' show '.$show->name.' has been updated successfully!');

      return redirect()->route('admin.shows.show', $show);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function destroy(Show $show)
    {
        $temp = $show;

        $show->delete();

        Session::flash('success', 'The '.$temp->type.' show '.$temp->name.' was successfully deleted.');

        return redirect()->route('admin.shows.index');
    }

}
