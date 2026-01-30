<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Models\ShortUrl;
use \App\Models\Company;
use \App\Models\User;

class AuthController extends Controller
{


    public function homepage(){
        return view('home');
    }

    public function Dashboard(){
        $user = Auth::user();
        $members = User::with('shortUrls','company')->where('role', '!=', 'superadmin')->paginate(10);
        $companys = Company::with('users','shortUrls')->orderBy('created_at','desc')->paginate(10);
        $query = ShortUrl::query()->with(['user', 'company'])->latest();
        if ($user->role === 'admin') {
            $query->where('company_id', $user->company_id);
        } elseif ($user->role === 'member') {
            $query->where('user_id', $user->id);
        }
        $urls = $query->paginate(10);

        return view('dashboard', compact('urls','user','companys','members'));
        
    }

    
    public function login_page(){
        return view('auth.login');
    }

    public function login(Request $request){

        $rules = array(
            'email' => 'required',
            'password' => 'required',
        );

        $request->validate($rules);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withErrors(['email' => 'creadential do not match'])->onlyInput('email');
    }

    public function logout(Request $request){

        Auth::logout();

       $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
