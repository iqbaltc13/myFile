<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use stdClass;


class EmailHelperController extends Controller
{
    public function sendMail($view,$dataParse){
        $data = [
            'dataParse'=>$dataParse,
        ];
        $mail = 1;
          
        try {
            $mail = Mail::send(['text'=>'mail.'.$dataParse->view], $data, function($message) use ($dataParse) {
                $message->to($dataParse->receiver_email, $dataParse->content)->subject($dataParse->subject);
                $message->from($dataParse->sender_email,$dataParse->sender_name);
            });
            
        }
        catch(Exception $e) {
      
        }
        return $mail;
    }
    public function testMail(){
        $account = new stdClass;
        $account->name             = 'Rifqi Maula Iqbal';
        $account->email            = 'rifqimaulaiqbal@gmail.com';
        $account->phone            = +62814094;
        $account->password         = '3577010200020001';
        $account->is_active        = 1;
        $account->built_in         = 0;
        $account->view             = 'new_account';
        $account->receiver_email   ='rifqimaulaiqbal@gmail.com';
        $account->content          = 'Akun Baru Sisprohaj Mobile';
        $account->subject          = 'Akun Baru Sisprohaj Mobile';
        $account->sender_email     = 'noreply@sisprohaj.id';
        $account->sender_name      = 'Admin Sisprohaj';
        $this->sendMail('new_account',$account);
    }
}
