<?php

namespace App\Http\Controllers\Api\V1\Autentikasi;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\RoleUser;
use DB;
use App\Notifications\FirebasePushNotif;
use stdClass;
use App\Models\ConfirmationUser;
use Illuminate\Support\Str;
use App\Notifications\VerifikasiEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\EncapsulatedApiResponder;

class ConfirmationController extends Controller{
    use EncapsulatedApiResponder;
    public function send(Request $request){
        $rules = [
            'confirmation_type_id'     => 'required|integer|exists:confirmation_types,id',
            'email'                     => 'required|email',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $nomor_telepon = $request->nomor_telepon;
        if($nomor_telepon[0] == '0') $nomor_telepon = '+62'.substr($nomor_telepon, 1);
        $user          = User::where('nomor_telepon',$nomor_telepon)->first();
        if (!$user) {
            return $this->failure($nomor.' tidak ditemukan.');
        }
        ConfirmationUser::where('user_id',$user->id)->where('confirmation_types_id',$request->confirmation_types_id)->delete();
        $code = strtoupper(Str::random(5));
        while (ConfirmationUser::where('code',$code)->count()>0) {
            $code = strtoupper(Str::random(5));
        }
        $expired_at                                 = Carbon::now()->addHour()->toDateTimeString();
        $kodeKonfirmasiUser                         = new ConfirmationUser();
        $kodeKonfirmasiUser->code                   = $code;
        $kodeKonfirmasiUser->user_id                = $user->id;
        $kodeKonfirmasiUser->expired_at             = $expired_at;
        $kodeKonfirmasiUser->confirmation_types_id  = $request->confirmation_types_id;
        $kodeKonfirmasiUser->save();

        if (in_array($request->confirmation_types_id, [1,2])) {
            if ($request->confirmation_types_id == 1) { //Registrasi akun baru
                $user   = User::where('nomor_telepon',$nomor_telepon)->first();
                if ($user) {
                    if (isset($user->verified_at)) {
                        return $this->failure($nomor_telepon.' sudah terdaftar.');
                    }
                }else{
                    return $this->failure($nomor.' belum terdaftar.');
                }
            }
            $kodeOtpAktivasiAkun                        = new KodeOtpAktivasiAkun($user->nomor_telepon, $code);
            $user->notify($kodeOtpAktivasiAkun);
            $user->confirmation                         = $kodeKonfirmasiUser;
            if ($request->confirmation_types_id == 1) {
                return $this->success('Kode konfirmasi berhasil dikirim ke '.$nomor_telepon, $kodeKonfirmasiUser);
            }else if ($request->confirmation_types_id == 2) {
                return $this->success('Kode konfirmasi reset kata sandi berhasil dikirim ke '.$nomor_telepon, $kodeKonfirmasiUser);
            }
        }else if($request->confirmation_types_id ==  3){
            Mail::to($user->email)->send(new VerifikasiEmail($user->email, $code));
            return $this->success('Kode konfirmasi berhasil dikirim ke email '.$user->email, $kodeKonfirmasiUser);
        }else{
            return $this->failure($request->confirmation_types_id.' belum terdaftar.');
        }
        return $this->failure('Gagal.');
    }

    public function verify(Request $request){
        $rules = [
            'confirmation_type_id'  => 'required|integer|exists:confirmation_types,id',
            'email'                 => 'required|string',
            'code'                  => 'required|string',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $email              = $request->email;
        $user                       = User::where('email',$email)->first();
        $kodeKonfirmasiUser         = ConfirmationUser::where('code', $request->code)->where('user_id',$user->id)->where('confirmation_type_id',$request->confirmation_type_id)->first();
        if (!$kodeKonfirmasiUser) {
            return $this->failure('Kode salah.');
        }
        if ($kodeKonfirmasiUser->expired_at < Carbon::now()->toDateTimeString()) {
            return $this->failure('Kode konfirmasi sudah expired.');
        }
        if ($kodeKonfirmasiUser->expired_at<Carbon::now()->toDateTimeString()) {
            ConfirmationUser::where('code',$request->code)->delete();
            return $this->failure('Kode konfirmasi expired.');
        }
        ConfirmationUser::where('user_id',$user->id)->where('confirmation_type_id',$request->confirmation_type_id)->delete();
        if ($request->confirmation_type_id == 1) { //Verifikasi akun baru
            $user->email_verified_at          = Carbon::now()->toDateTimeString();
            $user->is_active          = 1;
            $user->save();
            
            return $this->success('Akun anda berhasil diaktifkan.');
        }else if ($request->confirmation_type_id == 2) { //Konfirmasi reset password
            if (!isset($request->password)) {
                return $this->failure('Kata sandi tidak ditemukan.');
            }
            $user->password             = $request->password;
            $user->save();
            return $this->success('Kata sandi berhasil diubah.');
        }else{
            return $this->failure($request->confirmation_type_id.' belum terdaftar.');
        }
    }
}