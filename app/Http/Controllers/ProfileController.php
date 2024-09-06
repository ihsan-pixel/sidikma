<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function view()
    {
        $data['title'] = "Profile";
        $data['profile'] = DB::table('users')->select('users.*', 'kelas.nama_kelas', 'jurusan.nama_jurusan')->leftJoin('kelas', 'kelas.id', '=', 'users.kelas_id')->leftJoin('jurusan', 'jurusan.id', '=', 'users.jurusan_id')->where('users.id', request()->user()->id)->first();
        $data['totalsiswa'] = DB::table('users')->where('role', 2)->count('id');
        $data['totalkelas'] = DB::table('kelas')->count('id');
        $data['totaljurusan'] = DB::table('jurusan')->count('id');
        $data['temankelas'] = DB::table('users')->where('role', 2)->where('kelas_id', request()->user()->kelas_id)->get();
        $data['temanjurusan'] = DB::table('users')->where('role', 2)->where('jurusan_id', request()->user()->jurusan_id)->get();
        return view('backend.profile.view', $data);
    }
}
