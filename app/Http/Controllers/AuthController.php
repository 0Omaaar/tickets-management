<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            switch(auth()->user()->type){
                case 'admin':
                    flash()->success('Bienvenue sur le tableau de bord administrateur');
                    return redirect()->route('admin.dashboard');
                default:
                    flash()->success('Bienvenue sur le tableau de bord utilisateur');
                    return redirect()->route('user.dashboard');
            }
        }

        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);

        flash()->success('Compte créé avec succès');
        return redirect()->intended('/');
    }


    public function signOut() {
        Session::flush();
        Auth::logout();

        flash()->success('Déconnexion réussie');
        return Redirect('login');
    }
}
