<?php

namespace App\Http\Controllers\Admin;

use App\Show;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        // Filtering non-empty query strings


        $shows = Show::where('id', '!=', 1);

        if (count($request->query()) > 0)
        {
          if (isSet($request->id)) {
            $shows = $shows->where('id', $request->id);
          }

          if (isSet($request->duration)) {
            $shows = $shows->where('duration', $request->duration);
          }

          if (isSet($request->type)) {
            $shows = $shows->where('type', $request->type);
          }

          $showIds = $shows->pluck('id');
          $shows = Show::whereIn('id', $showIds)->orderBy('name', 'asc')->paginate(10);
        }
        else
        {
          $shows = $shows->orderBy('name', 'asc')->paginate(10);
        }

        return view('admin.shows.index')->withShows($shows);
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

        Session::flash('success', "The <strong>{$show->type}</strong> show <strong>{$show->name}</strong> has been added successfully!");

        // Log created event
        Log::info(Auth::user()->fullname . ' created Show ' . $show->name .' using admin');

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
        'name'        => 'required',
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

      Session::flash('success', "The <strong>{$show->type}</strong> show <strong>{$show->name}</strong> has been updated successfully!");

      // Log created event
      Log::info(Auth::user()->fullname . ' edited Show ' . $show->name .' using admin');

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
        // Log created event
        Log::info(Auth::user()->fullname . ' deleted Show ' . $show->name .' using admin');

        $temp = $show;

        $show->delete();

        Session::flash('success', 'The '.$temp->type.' show '.$temp->name.' was successfully deleted.');

        return redirect()->route('admin.shows.index');
    }

    public function delete(Show $show)
    {
        // How many events this show is part of, past and future
        $showings = \App\Event::where('show_id', $show->id)->count();

        // Check if there are any events have this show

        if ($showings == 0)
        {

          // Log created event
          Log::info(Auth::user()->fullname . ' deleted Show ' . $show->name .' using admin');

          $temp = $show;

          $show->delete();

          Session::flash('success', "The <strong>{$temp->type}</strong> show <strong>{$temp->name}</strong> was successfully deleted.");

          return redirect()->route('admin.shows.index');

        }
        else
        {

          Session::flash('info', "Unable to delete <strong>{$show->name}</strong> because it is/will be featured in <strong>$showings or more events</strong>.");

          return redirect()->route('admin.shows.show', $show);

        }


    }

}
