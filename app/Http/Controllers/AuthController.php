<?php

namespace App\Http\Controllers;

use App\Models\AksesProses;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login_page()
    {
        return view('auth.login',['title' => 'Login Page']);
    }

    public function login(Request $request)
    {
         $attributes = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        if(Auth::attempt($attributes)){

            $user = User::where('username', $request->username)->first();

            $dt_proses = AksesProses::where('user_id',$user->id)->get();

            $aksesProses = [];

            foreach ($dt_proses as $d) {
                $aksesProses [] = $d->proses_id;
            }

            session([
                'name' => $user->name,
                'jenis_user_id' => $user->jenis_user_id,
                'aksesProses' => $aksesProses,
            ]);

            if($user->aktif){
                if ($user->jenis_user_id == 4) {
                    return redirect(RouteServiceProvider::HOME);
                }elseif($user->jenis_user_id == 2){
                    return redirect(route('dashboard'));
                }else {
                    return redirect(route('listBerkas'));
                }
                
                
            }else{
                return redirect(route('login'))->with('error' , 'User tidak aktif');
            }

            

            
        }

        // $user = User::where('username', $request->username)->first();

        // if($user){
        //     if(Hash::check($request->password, $user->password)){
        //         dd($user);
        //         // Auth::login($user);
                
        //         // return redirect(route('dashboard'))->with('success','Selamat datang '. $user->name);
        //     }else{
        //         throw ValidationException::withMessages([
        //             'password' => 'Password salah'
        //         ]);
        //     }
        // }

        throw ValidationException::withMessages([
            'username' => 'Username atau password salah'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        session()->forget(['name', 'jenis_user_id','aksesProses']);
        return redirect(route('loginPage'))->with('success','Logout Berhasil');
    }

    public function nonActive()
    {
        Auth::logout();
        return redirect(route('loginPage'))->with('error','User anda tidak aktif');
    }

    public function block()
    {
        return view('auth.block');
    }
}
