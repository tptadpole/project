<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class AdminUserController extends Controller
{
    /**
     * Display the all users information
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->paginate(8);
        return view('adminUsers')->with(['users' => $users]);
    }

    /**
     * Create a new detail of user
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminCreateUser');
    }

    /**
     * Store a newly created user
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => 'required|in:user,manager,admin',
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
        ]);

        return redirect()->action('AdminUserController@index');
    }

    /**
     * edit the user's information.
     *
     * @param int $users_id
     * @return \Illuminate\Http\Response
     */
    public function edit($users_id)
    {
        if (!$user = User::find($users_id)) {
            abort(404);
        }

        $user = $user->toArray();
        return view('adminEditUser')->with([ 'user' => $user ]);
    }

    /**
     * Update the user's information.
     *
     * @param Request $request
     * @param int $users_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $users_id)
    {
        if (! $user = User::find($users_id)) {
            abort(404);
        }

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => 'required|in:user,manager,admin',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $status = $user->update($validatedData);

        return redirect()->action('AdminUserController@index');
    }

    /**
     * Remove the user's information.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        if (! $user = User::find($user_id)) {
            abort(404);
        }

        $status = $user->delete();
        return redirect()->action('AdminUserController@index');
    }
}
