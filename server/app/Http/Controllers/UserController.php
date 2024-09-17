<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private array $rules = [
        'firstname' => ['required', 'min:3', 'max:63'],
        'lastname' => ['required', 'min:3', 'max:127'],
        'email' => ['required', 'email', 'unique:users,email'],
        'address' => ['nullable', 'min:3', 'max:255'],
        'city' => ['nullable', 'min:3', 'max:63'],
        'state' => ['nullable', 'min:3', 'max:63'],
        'zip' => ['nullable', 'size:5'],
        'newsletter' => ['nullable']
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        if ($request->query('type') == 'individual') {
            $individuals = (new User)->where('type', 'individual')->with(['role'])->get();
            return response([ 'data' => $individuals ]);
        }

        $walk_up = (new User())->find(1);

        $users = (new User())->where([['type', 'individual'], ['staff', $request->has('staff')]]);

        if ($request->has('q')) {
            $q = $request->query('q');
            $users = $users->where('firstname', 'like', "%$q%")->orWhere('lastname', 'like', "%$q%");
        }

        //TODO: SIMPLE PAGINATE

        $users = $users->with(['role'])->orderBy('firstname')->get();

        if (!$request->has('staff')) {
            $users = [$walk_up, ...$users];
        }

        return response(['data' => $users], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $validator = Validator::make($request->input(), $this->rules);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }

        $visitor_role = DB::table('roles')->select('id')
            ->where('name', 'like', 'visitor')->first();

        $user = (new User)->create([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'zip' => $request->input('zip'),
            'newsletter' => $request->has('newsletter'),
            'password' => Hash::make($request->input("password")),
            'role_id' => $visitor_role->id
        ]);

        $user->sendEmailVerificationNotification();

        return response(['data' => $user->id], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if ($user->id == 1) {
            return response()->noContent(404);
        }

        return response($user->load(['role']), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): Response
    {
        array_pop($this->rules['email']);

        $validator = Validator::make($request->input(), $this->rules);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }

        $role = $user->role_id;

        if ($request->has('role_id')) {
            $role = Role::find($request->input('role_id'))->id;

            if ($role == null) {
                return response()->noContent(422);
            }
        }

        $user->update([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'zip' => $request->input('zip'),
            'newsletter' => $request->has('newsletter'),
            'password' => Hash::make($request->input("password")),
            'role_id' => $request->input('role_id')
        ]);

        $user->sendEmailVerificationNotification();

        return response(['data' => $user->id], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
