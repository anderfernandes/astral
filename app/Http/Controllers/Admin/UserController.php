<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role', '<>', 'walk-up')
                 ->orderBy('id', 'desc')->paginate(10);
                 
        return view('admin.users.index')->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
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
          'firstname'             => 'required',
          'lastname'              => 'required',
          'email'                 => 'required',
          'role'                  => 'required',
          'password'              => 'nullable|same:password_confirmation',
          'password_confirmation' => 'nullable'
        ]);

        $user = new User;

        $user->firstname = $request->firstname;
        $user->lastname  = $request->lastname;
        $user->email     = $request->email;
        $user->role      = $request->role;
        $user->password  = bcrypt($request->password);

        $user->save();

        Session::flash('success',
          ''.$user->firstname.' '.$user->lastname.
          '\'s account information has been added successfully!');

        return redirect()->route('admin.users.show', $user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show')->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit')->withUser($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
          'firstname'             => 'required',
          'lastname'              => 'required',
          'email'                 => 'required',
          'role'                  => 'required',
          'password'              => 'nullable|same:password_confirmation|min:6',
          'password_confirmation' => 'nullable|min:6'
        ]);

        $user->firstname = $request->input('firstname');
        $user->lastname  = $request->input('lastname');
        $user->email     = $request->input('email');
        $user->role      = $request->input('role');
        $user->password  = bcrypt($request->input('password'));

        $user->save();

        Session::flash('success',
          ''.$user->firstname.' '.$user->lastname.
          '\'s account information has been updated successfully!');

        return redirect()->route('admin.users.show', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
      $temp = $user;

      $user->delete();

      Session::flash('success',
        'The '.$temp->role.' user '.$user->firstname.'
        '.$user->lastname.' was successfully deleted.');

      return redirect()->route('admin.users.index');
    }
}
