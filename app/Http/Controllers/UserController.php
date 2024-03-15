<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
//        dd($users);
        return view('admin_panel.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'fullName' => ['required', 'string', 'max:255'],
            'phoneNumber' => ['required', 'string', 'max:255'],
            'role' => ['string','nullable', 'max:255'],
            'status' => ['string','nullable', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

//        dd($request);

        $user = User::create([
            'name' => $request->name,
            'fullName' => $request->fullName,
            'phoneNumber' => $request->phoneNumber,
            'role' => $request->role ?? 'user',
            'status' => $request->status ?? null,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

//        event(new Registered($user));

//        Auth::login($user);

        return redirect()->route('user.index')->with('success', 'Foydalanuvchi muvaffaqiyatli qo\'shildi.');

    }


/**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|max:255',
            'fullName' => 'required|max:255',
            'phoneNumber' => 'required|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|in:admin,user',
            'status' => 'required|in:active,inactive',
            'password' => 'required|confirmed|min:8',
        ]);

        $user->update([
            'name' => $request->name,
            'fullName' => $request->fullName,
            'phoneNumber' => $request->phoneNumber,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->back()->with('success', 'Foydalanuvchi muvaffaqiyatli yangilandi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id); // Foydalanuvchini bazadan topish
        if ($user) {
            $user->delete(); // Foydalanuvchini o'chirish
            return redirect()->route('user.index')->with('success', 'Foydalanuvchi muvaffaqiyatli o`chirildi.');
        } else {
            return redirect()->route('user.index')->with('error', 'Foydalanuvchi topilmadi.');
        }
    }
}
