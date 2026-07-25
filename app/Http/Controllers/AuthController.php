<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);

        if (!Auth::attempt($credentials)) {
            return back()
                ->withInput(
                    $request->only('username')
                )
                ->with(
                    'error',
                    'Username atau password salah.'
                );
        }

        /*
         * Cegah akun yang sudah dinonaktifkan
         * untuk masuk ke aplikasi.
         */
        if (!Auth::user()->is_active) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withInput(
                    $request->only('username')
                )
                ->with(
                    'error',
                    'Akun Anda telah dinonaktifkan. Silakan hubungi UPI.'
                );
        }

        $request->session()->regenerate();

        return match (Auth::user()->role) {
            'UPR' => redirect()->route('upr.dashboard'),
            'UMR' => redirect()->route('umr.dashboard'),
            'UPI' => redirect()->route('upi.dashboard'),

            default => $this->logoutPenggunaTidakValid(
                $request
            ),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login');
    }

    private function logoutPenggunaTidakValid(
        Request $request
    ) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with(
                'error',
                'Role akun tidak valid.'
            );
    }
}