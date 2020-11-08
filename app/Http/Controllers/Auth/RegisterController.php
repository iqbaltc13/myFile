<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use stdClass;
use DateTime;
use DateInterval;
use DB;
use App\Http\Controllers\Helpers\WebHelperController;
use App\Http\Controllers\Helpers\EmailHelperController;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->email_helper = new EmailHelperController;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
           
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function newRegister(Request $request){
        $dateTime = new DateTime();
        if($request->method()=="POST"){
            $this->validate($request, [
                'name'                      =>'required|string|max:255',
                'email'                     =>'required|string|email|unique:users,email',
                'password'                  =>'required|string|confirmed'
               
            ]);
           
           
         
            $arrCreateUser=[
               
                    'name'                  => $request->name,
                    'email'                 => $request->email,
                   
                    'password'              => $request->password,
                    'status'                => 0,
                    
                   
            ];
            $createUser =User::create($arrCreateUser);

            $account = new stdClass;
            
            $account->view             = 'otp';
            $account->receiver_email   = $request->email;
            $account->content          = 'Akun Baru MyFile';
            $account->subject          = 'Akun Baru MyFile';
            $account->sender_email     = 'noreply@myfile.id';
            $account->sender_name      = 'Admin MyFile';
            $account->link_otp         = url('/').'/aktivasi-akun/'. md5($request->email).'?email='.$request->email;

            $this->email_helper->sendMail('otp',$account);
           
            

            return redirect()->route('login')->with('success', 'Registrasi Sukses, 
            silahkan aktivasi akun anda, link aktivasi telah dikirim ke email anda');
        }else{
            
            return redirect()->route('register');
        }
    }
    public function aktivasi(Request $request,$kode){
        
        $dateTime = new DateTime();
        
        if(md5($request->email)==$kode){
            User::where('email',$request->email)->update([
                'verified_at' => $dateTime->format('Y-m-d H:i:s'),
                'status'      => 1,  
            ]);
            return redirect()->route('login')->with('success', 'Aktivasi akun sukses');
        }
        return redirect()->route('login')->with('error', 'Aktivasi akun gagal');
        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
          
            'password' => Hash::make($data['password']),
        ]);
    }
}
