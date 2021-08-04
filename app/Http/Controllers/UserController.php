<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        // $users = User::all();
        Auth::user()->privilege_id == 1 ?
            $users = User::with('privilege', 'fireBrigadeUnit')->orderBy('name')->get()
            :
            $users = User::with('privilege', 'fireBrigadeUnit')->where('fire_brigade_unit_id', Auth::user()->fire_brigade_unit_id)->orderBy('name')->get();

        return Inertia::render('users', ['users' => $users]);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:32',
            'surname' => 'required|string|min:3|max:32',
            'email' => 'unique:users|required|email',
            'phone' => 'nullable|size:9',

        ])->validate();


        if (Auth::user()->privilege_id == 2)
            User::create(
                [
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make('qwerty'),
                    'privilege_id' => 3,
                    'fire_brigade_unit_id' => Auth::user()->fire_brigade_unit_id
                ]
            );
        // else
        //     User::create(
        //         [
        //             'name' => $request->name,
        //             'surname' => $request->surname,
        //             'email' => $request->email,
        //             // 'phone' => $request->phone,
        //             'password' => Hash::make('qwerty'),
        //             'privilege_id' => 2,
        //         ]
        //     );

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }

    public function update(Request $request)
    {
        if ($request->has('id'))
            $avoid = User::find($request->input('id'));


        Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:32',
            'surname' => 'required|string|min:3|max:32',
            'email' => ['required','email', Rule::unique('users')->ignore($avoid)],
            'phone' => 'nullable|size:9',
        ])->validate();

        if ($request->has('id')) {
            User::find($request->input('id'))->update($request->all());
            return redirect()->back()
                ->with('message', 'Post Updated Successfully.');
        }
    }

    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            User::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}
