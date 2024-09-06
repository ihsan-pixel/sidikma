<?php

namespace App\Http\Controllers;

use App\Providers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class BroadcastController extends Controller
{
    public function view()
    {
        $data['title'] = "Broadcast";
        $data['siswa'] = DB::select("select no_ortu, nama_lengkap from users where role = '2'");
        return view('backend.broadcast.view', $data);
    }
    function sendMessage(Request $request)
    {

        foreach ($request->nomor as $no) {
            $response = Http::get('https://wa.dlhcode.com/send-message?api_key=' . Helper::apk()->token_whatsapp . '&sender=' . Helper::apk()->tlp . '&number=' . $no . '&message=' . $request->message . '');
        }

        echo json_encode($response);
    }
}
