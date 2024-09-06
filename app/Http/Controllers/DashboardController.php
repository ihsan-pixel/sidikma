<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data['rankpayment'] = DB::select(
            "SELECT u.nama_lengkap, p.user_id, k.nama_kelas, u.alamat,  SUM(p.nilai) as total 
        FROM payment p 
        LEFT JOIN users u on u.id=p.user_id 
        LEFT JOIN kelas k on k.id=u.kelas_id 
        WHERE p.status = 'Lunas' GROUP BY p.user_id, u.nama_lengkap, p.user_id, u.kelas_id, u.alamat 
        ORDER BY total DESC LIMIT 7"
        );
        $data['totalById'] = request()->user()->role != 1 ?
            DB::table('payment')->where('user_id', request()->user()->id)->sum('nilai') :
            DB::table('payment')->sum('nilai');
        $data['totalBulanan'] = request()->user()->role != 1 ?
            DB::table('payment')->where('user_id', request()->user()->id)->where('bulan_id', '!=', null)->where('status', 'Lunas')->sum('nilai') :
            DB::table('payment')->where('bulan_id', '!=', null)->where('status', 'Lunas')->sum('nilai');
        $data['totalLainya'] = request()->user()->role != 1 ?
            DB::table('payment')->where('user_id', request()->user()->id)->where('bulan_id', '=', null)->where('status', 'Lunas')->sum('nilai') :
            DB::table('payment')->where('bulan_id', '=', null)->where('status', 'Lunas')->sum('nilai');
        $data['kepalasekolah'] = DB::table('users')->where('role', 3)->where('status', 'ON')->count('id');
        $data['kepalasekolahimage'] = DB::table('users')->where('role', 3)->where('status', 'ON')->get();
        $data['total'] = DB::table('users')->where('role', 1)->where('status', 'ON')->count('role');
        $data['img'] = DB::table('users')->where('role', 1)->where('status', 'ON')->get();
        $data['siswatotal'] = DB::table('users')->where('role', 2)->where('status', 'ON')->count('role');
        $data['siswaimg'] = DB::table('users')->where('role', 2)->where('status', 'ON')->get();
        $data['alluserstotal'] = DB::table('users')->where('status', 'ON')->count('role');
        $data['allusersimg'] = DB::table('users')->where('status', 'ON')->get();
        // dd($data['img']);
        return view('backend.dashboard.index', $data);
    }
}
