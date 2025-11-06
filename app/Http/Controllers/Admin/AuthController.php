<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('Admin.login');
    }

    public function login(Request $request)
    {
        if (
            Auth::guard('admin')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ])
        ) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Login successful!');
        }
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }
}
