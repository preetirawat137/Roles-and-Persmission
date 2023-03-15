<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use App\Events\UserRegistered;

class SampleController extends Controller
{
 public function index(){

return view('CustomAuth.main');
 }

 public function registration(){
    return view('CustomAuth.registration');
 }

 public function validate_register(Request $request){
    $data = $request->validate([
        'name'         =>   'required',
        'email'        =>   'required|email|unique:users',
        'password'     =>   'required|min:6',

    ]);

    User::create([
        'name'  =>  $data['name'],
        'email' =>  $data['email'],
        'password'=> Hash::make($request['password'])
    ]);
   
    return Redirect('login')->with('success','Registration complete,now you can login');
 }

 public function login(Request $request){
    $request->validate([
        'email'         =>   'required',
        'password'     =>   'required|min:6' 
    ]);
    $loginValue=( filter_var(request('email'),FILTER_VALIDATE_EMAIL)?'email':'name');
   
    if(Auth::attempt(array($loginValue=>$request['email'],'password'=>$request['password']))){
        return view('CustomAuth.dashboard');
    }
     else{
    return redirect('login')->with('success', 'Login details are not valid');
    }

 }
 public function dashboard(){
    if(Auth::check()){
    return redirect('CustomAuth.login');
    }
    return redirect('login')->with('success','you are not allowed to access');
    
 }
 
public function logout(){
Session::flush();
Auth::logout();
return Redirect('login');
 }
 function loginview()
    {
        return view('CustomAuth.login');
    }
    public function forgetPasswordLoad(){
        return view('CustomAuth.forgetPassword');

    }

    public function forgetPasswordLink(Request $request){
        // dd($request->all());
        try{
            $User= User::where('email', $request->email)->get();
            if(count($User)>0){
                $token= Str::random(40);
                $domain= URL::to('/');
                $url = $domain.'/ResetPasswordLoad' . '/' .$token;
                // dd($url);

                $data['url'] = $url;
                $data['email']=$request->email;
                $data['title']='Password reset';
                $data['body']='Please click on below link to reset your password';
                
                Mail::send('CustomAuth.forgetPasswordMail',['data'=>$data], function($message) use($data){
                    $message->to($data['email'])->subject($data['title']);
                });
                $dateTime= Carbon::now()->format('Y-m-d H:i:s');
                // dd($request->_token);
                PasswordReset::updateorcreate(
                    // ['email'=>$request->email],

                    ['email'=>$request->email,
                    'token'=>$token,
                    'created_at'=>$dateTime
                    
                    ]
                );
                return back()->with('success','Please check your mail to reset your password!');
            }

            else{
                return back()->with('error','Email is not exist');
            }


        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
    public function ResetPasswordLoad(Request $request){

      $resetdata= PasswordReset::where('token',$request->token)->get();
    //   dd($resetdata);
      if(isset($request->token) && count($resetdata)>0){
           $user=User::where( 'email',$resetdata[0]['email'])->get();

            return view('CustomAuth.forgetPasswordLink',compact('user'));
        }
        else{
            return view('CustomAuth.404');
        }
    }
    public function Resetpassword(Request $request){
        $request->validate([
    'password' =>'required|string|min:6|confirmed'
]);

    $user=User::where('email',$request->email)->first();
    $user->password=Hash::make($request->password);
    $user->save();
    return  response()->json(['success','you password reset']);
    }

}