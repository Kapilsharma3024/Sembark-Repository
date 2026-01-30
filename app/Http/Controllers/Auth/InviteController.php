<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\User;

class InviteController extends Controller
{
    public function create(){
        $user = Auth::user();

        if(! in_array($user->role, ['superadmin', 'admin'])){
            abort(403);
        }
        return view('auth.invite', compact('user'));

    }

    public function store(Request $request){

        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        if($user->role === 'superadmin'){
            $company_name = $request->validate([
                'company_name' => 'required|string|max:255',
            ]);

            $company = new Company();
            $company->name = $company_name['company_name'];
            $company->save();
            $role = 'admin';
            $companyId = $company->id;
        }else{
            $roledata = $request->validate(['role' => 'required|in:admin,member']);
            $role = $roledata['role'];
            $companyId = $user->company_id;
        }

        $add_user = new User();
        $add_user->name = $request->name;
        $add_user->email = $request->email;
        $add_user->password = $request->password;
        $add_user->role = $role;
        $add_user->company_id = $companyId;
        $add_user->save();

        return redirect()->route('dashboard')->with('success', 'User Created Successfully.');
    }
}
