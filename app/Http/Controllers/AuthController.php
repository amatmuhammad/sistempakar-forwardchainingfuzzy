<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Gimmick: Jika admin iseng mengakses halaman login padahal sudah masuk session, 
        // langsung arahkan kembali ke dashboard demi efisiensi kerja.
        
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // dd($credentials);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->can('admin')) {
                return redirect()->route('dashboard')->with('success', 'Selamat datang, ' . $user->name . '!');
            }elseif($user->can('user')) {
                return redirect()->route('diagnosa.index')->with('success', 'Selamat datang, ' . $user->name . '!');
            }else {
                return redirect()->route('login')->with('error', 'Role tidak dikenali.'); // Tambahkan pesan error jika role tidak dikenali
            }

            // Default redirect jika tidak ada role
            return redirect('/login')->with('error', 'Role tidak dikenali.');
        }

        // Jika login gagal
        return redirect()->back()->withErrors(['error' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        // dd($request->all());
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Mengarahkan ke form diagnosa peternak setelah keluar, sudah sangat tepat
        return redirect('login')->with('success', 'Anda telah berhasil keluar. Terima kasih telah menggunakan sistem kami!');
    }
}