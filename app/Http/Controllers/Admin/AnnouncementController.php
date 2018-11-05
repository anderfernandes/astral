<?php

namespace App\Http\Controllers\Admin;

use App\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Date\Date;

class AnnouncementController extends Controller
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
          'start'     => 'required|date',
          'end'       => 'required|date',
          'title'     => 'required|string|max:64|min:3',
          'content'   => 'required|string',
        ]);

        $announcement = new Announcement;

        $announcement->start      = new Date($request->start);
        $announcement->end        = new Date($request->end);
        $announcement->title      = $request->title;
        $announcement->content    = $request->content;
        $announcement->creator_id = Auth::user()->id;

        $announcement->save();

        Session::flash('success', "Announcement <strong>{$announcement->title}</strong> created successfully!");
        return redirect()->to(route('admin.settings.index').'#announcements');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit')->withAnnouncement($announcement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcement $announcement)
    {
        $this->validate($request, [
          'start'     => 'required|date',
          'end'       => 'required|date',
          'title'     => 'required|string|max:64|min:3',
          'content'   => 'required|string',
        ]);

        $announcement->start      = new Date($request->start);
        $announcement->end        = new Date($request->end);
        $announcement->title      = $request->title;
        $announcement->content    = $request->content;

        $announcement->save();

        Session::flash('success', "Announcement <strong>{$announcement->title}</strong> updated successfully!");

        return redirect()->to(route('admin.settings.index').'#announcements');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
      $announcement->delete();
      Session::flash('success', "Announcement <strong>{$announcement->title}</strong> deleted successfully!");

      return redirect()->to(route('admin.settings.index').'#announcements');
    }
}
