<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\RoleUser;
use App\Models\NotifikasiBroadcast;
use Carbon\Carbon;
use App\Notifications\FirebasePushNotif;
use App\Models\Notifikasi;
use Auth;
use DataTables;
use App\Models\UserXRole;

class NotifikasiController extends Controller
{
    
    public function __construct()
    {
        $this->route      ='dashboard.notifikasi_broadcast.';
        $this->view       ='dashboard.notifikasi.';
       
        $this->sidebar    ='pengaturan'; 
    }
    
    public function index(){ 
        return view($this->view.'index');
    }

    public function getHistoryBroadcast(){
        $histories = NotifikasiBroadcast::select('id','judul','pesan','created_at')->orderBy('id','DESC')->get();
        foreach($histories as $idx => $history){
            $history->no = $idx+1;
            $history->tanggal = Carbon::parse($history->created_at)->format('d-m-Y H:i:s');
        }
        return DataTables::of($histories)->toJson();
    }
    public function getDetailBroadcast($id){
        $notif = NotifikasiBroadcast::find($id);
        $data_json = json_decode($notif->data_json);
        $notif->group = $data_json->group;
        $notif->subgroup = $data_json->subgroup;
        $notif->value = $data_json->value;
        return $this->success('data detail broadcast',$notif);
    }
    public function getDataCustomer(){
        $userId = UserXRole::where('role_id',2)->pluck('user_id')->toArray();
        $customers = User::whereIn('id',$userId)->select('id','name','phone')->get();
        foreach($customers as $customer){
            if(substr($customer->phone, 0, 3 ) === "+62")
                $customer->phone = '0'.substr($customer->phone,3);
            
        }
        return DataTables::of($customers)->toJson();
    }
    public function sendBroadcast(Request $req){
        $customerId = explode(',',$req->customer_id);
        $customers  = User::whereIn('id',$customerId)->get();
        $data_json = [
            'group'     => $req->group,
            'subgroup'  => $req->subgroup,
            'value'     => $req->value
        ];
        $judul  = $req->judul;
        $pesan  = $req->pesan;

        NotifikasiBroadcast::insert([
            'pengirim_id' => Auth::id(),
            'penerima_id' => $req->customer_id,
            'judul'       => $judul,
            'pesan'       => $pesan,
            'data_json'   => json_encode($data_json),
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);

        foreach($customers as $customer){
            $new_notifikasi = new Notifikasi;
            $new_notifikasi->pengirim_id = Auth::id();
            $new_notifikasi->penerima_id = $customer->id;
            $new_notifikasi->judul = $judul;
            $new_notifikasi->pesan = $pesan;
            $new_notifikasi->data_json = json_encode($data_json);
            $new_notifikasi->save();
            $customer->notify(new FirebasePushNotif($judul,$pesan, $data_json));
        } 

        return $this->success('berhasil mengirim pesan');
    }
}
