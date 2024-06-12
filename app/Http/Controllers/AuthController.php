<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\grade;
use App\Models\subject;
use App\Models\teacher;
use Laravel\Prompts\error;
use Illuminate\Support\Str;
use GuzzleHttp\Promise\Each;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index(){
        return view('index');
    }
    public function Register(){
        return view('Auth.RegisterAuth');
    }

    public function storeRegister(Request $request){
        try{
           $request->validate([
                'name'=>'required|string|min:3',
            'email'=>'required|email|unique:users',
            'password'=>'required|string|min:6',
            'cpassword'=>'required|same:password',
            'profile'=>'mimes:png,jpg,jpeg'
        ]);
        $token=Str::random(50);
        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'profile'=>$request->profile,
            'remember_token'=>$token,
        ]);
        $url=URL::to('/');
        $data['domain']=$url.'/email/token/'.$token;
        $data['email']=$request->email;
        $data['name']=$request->name;
        $data['title']="Verification token";
        Mail::send('Mail.template',["data"=>$data],function($message) use($data){
            $message->to($data['email'])->subject($data['title']);
        });
        return response()->json(['success'=>true]);
    }
    catch(\Exception $e){
        return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
    }
    }

    public function verify($token){
        $users=User::where('remember_token',$token)->get();
        if($users->count() >0){
            if($users[0]['is_verified']==1){
                return response()->json(['message'=>'Email already verified']);
            }else{
                User::where('id',$users[0]['id'])->update([
                    'is_verified'=>1,
                    'email_verified_at'=>date('Y-m-d H:i:s'),
                ]);
                return response()->json(['message'=>'Email has been verified']);
            }
        }else{
            return response()->json(['message'=>'Invalid token']);
        }
    }

    public function login(){
        return view('Auth.LoginAuth');
    }

    public function storeLogin(Request $request){
        try{
            $request->validate([
                'email'=>'required|email',
                'password'=>'required|string|min:6',
            ]);
            $data=$request->only('email','password');
            $user=User::where('email',$request->email)->get();
            if($user->count() >0){
                if(Auth::attempt($data)){
                    return response()->json(['success'=>true]);
                }else{
                    return response()->json(['success'=>false,'message'=>'Invalid Login Crediantials']);
                }
            }else{
                return response()->json(['success'=>false,'message'=>'Email not register yet']);
            }

            return response()->json(['success'=>true]);

        }catch(\Exception $e){
            return response()->json(['success'=>false, 'message'=>$e->getMessage()]);
        }
    }


    public function dashboard(){
        if(Auth::check()){
            $grade=grade::where('status',1)->count();
            $subject=subject::where('status',1)->count();
            $teacher=teacher::where('status',1)->count();
            $data=compact('grade','subject','teacher');
            return view('Content.dashboard',$data);
        }else{
            return redirect('/login');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }

    public function changePassword(Request $request){
        try{
            $request->validate([
                'oldpassword'=>'required',
                'newpassword'=>'required|string|min:6',
                'confirmpassword'=>'required|same:newpassword',
            ]);
            $currentpassword=$request->oldpassword;
            $newpassword=$request->newpassword;
                // $users=User::where('password',$currentpassword)->get();
                if(!Hash::check($currentpassword,Auth::user()->password)){
                    return response()->json(['success'=>false,'message'=>'Invalid password',419]);
                }else{
                    $users=Auth::user();
                    $users->password=Hash::make($newpassword);
                    $users->save();
                    return response()->json(['success'=>true,'message'=>$currentpassword,200]);
               }
            return response()->json(['success'=>true,'message'=>'success',200]);
        }catch(\Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage(),500]);
        }
    }
}
