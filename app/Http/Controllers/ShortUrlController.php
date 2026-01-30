<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ShortUrlController extends Controller
{
    public function create(){

        if(Auth::user()->role === 'superadmin'){
            abort(403,'Super Admin can not create short Urls.');
        }

        return view('short-url.create');
    }

    public function store(Request $request){
        $user = Auth::user();

        if($user->role === 'superadmin'){
            abort(403);
        }

        $validate = $request->validate([
            'original_url' => 'required|url|max:2048',
        ]);

        $shortCode = Str::random(8);
        while(ShortUrl::where('short_code', $shortCode)->exists()) {
            $shortCode = Str::random(8);
        }

        $short_url = new ShortUrl();
        $short_url->user_id = $user->id;
        $short_url->company_id = $user->company_id;
        $short_url->original_url = $request->original_url;
        $short_url->short_code = $shortCode;
        $short_url->save();

        return redirect()->route('dashboard')->with('success', 'Url Has been Shorted Successfully');
    }

    public function redirect($short_code){
        $url = ShortUrl::where('short_code', $short_code)->firstOrFail();
        if($url->hit_count > 0){
            $url->hit_count += 1;
        }else{
            $url->hit_count = 1;
        }
        $url->save();
        return redirect($url->original_url);
    }

    public function index(){
        $user = Auth::user();
        $urls = collect();

        if($user->role === 'superadmin'){
            $urls = ShortUrl::with('user.company')->latest()->get();

        }elseif($user->role === 'admin'){
            $urls = ShortUrl::with('user')->where('company_id', $user->company_id)->latest()->get();
        }else{
            $urls = ShortUrl::where('user_id', $user->id)->latest()->get();
        }

        return view('short-url.index',compact('urls', 'user'));
    }
}
