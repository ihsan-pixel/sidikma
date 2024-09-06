<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function view()
    {
        $data['title'] = "Asal Madrasah";
        $data['kelas'] = DB::select("select * from kelas");
        return view('backend.kelas.view', $data);
    }
    
    public function add()
    {
        $data['title'] = "Tambah Asal Madrasah";
        return view('backend.kelas.add', $data);
    }
    public function addkelas(Request $request)
    {
        $data = [
            'nama_kelas' => $request->nama_kelas,
            'keterangan' => $request->keterangan,
            'created_at' => now()
        ];
        // dd($data);
        DB::table('kelas')->insert($data);
        return redirect('kelas');
    }
    public function edit(Request $request)
    {
        $data['title'] = "Edit Asal Madrasah";
        $data['kelas'] = DB::table('kelas')->where('id', $request->id)->first();
        return view('backend.kelas.edit', $data);
    }
    public function editProses(Request $request)
    {
        $data = [
            'nama_kelas' => $request->nama_kelas,
            'keterangan' => $request->keterangan,
            'updated_at' => now()
        ];

        // dd($request->id);
        DB::table('kelas')->where('id', $request->id)->update($data);
        return redirect('kelas');
    }
    public function delete($id)
    {
        try {
            // dd($id);
            DB::table('kelas')->where('id', $id)->delete();
            // Alert::success('Category was successful deleted!');
            return redirect()->route('kelas');
        } catch (Exception $e) {
            return response([
                'success' => false,
                'msg'     => 'Error : ' . $e->getMessage() . ' Line : ' . $e->getLine() . ' File : ' . $e->getFile()
            ]);
        }
    }
    public function movekelas()
    {
        $data['title'] = "Kenaikan Kelas";
        
        $data['kelas'] = DB::select("select * from kelas");
        $data['jurusan'] = DB::select("select * from jurusan");
        return view('backend.kelas.movekelas', $data);
    }
    public function load_data_moveKelasFrom(Request $request)
    {
        $data = DB::select("
        select u.id, u.nama_lengkap, k.nama_kelas, j.nama_jurusan from users u left join kelas k on k.id=u.kelas_id left join jurusan j on j.id=u.jurusan_id 
        where u.kelas_id = '$request->kelas_id_from' and u.jurusan_id = '$request->jurusan_id_from' and u.status != 'Lulus'");
        echo json_encode($data);
    }
    public function load_data_moveKelasTo(Request $request)
    {
        $data = DB::select("select u.id, u.nama_lengkap, k.nama_kelas, j.nama_jurusan 
        from users u left join kelas k on k.id=u.kelas_id left join jurusan j on j.id=u.jurusan_id 
        where u.kelas_id = '$request->kelas_id_to' and u.jurusan_id = '$request->jurusan_id_to' and u.status != 'Lulus'");
        echo json_encode($data);
    }
    function moveproses(Request $request)
    {
        foreach (explode(',', $request->user_id) as $uid) {
            $data = [
                'kelas_id' => $request->kelas_id_to,
                'jurusan_id' => $request->jurusan_id_to,
            ];
            DB::table('users')->where('id', $uid)->update($data);
           
        }
        echo json_encode($data);
    }
    function backproses(Request $request)
    {
        foreach (explode(',', $request->user_id) as $uid) {
            $data = [
                'kelas_id' => $request->kelas_id_from,
                'jurusan_id' => $request->jurusan_id_from,
            ];
            DB::table('users')->where('id', $uid)->update($data);
        }
        echo json_encode($data);
    }
    public function lulus()
    {
        $data['title'] = "Kelulusan";

        $data['kelas'] = DB::select("select * from kelas ORDER BY nama_kelas DESC LIMIT 1");
        $data['jurusan'] = DB::select("select * from jurusan");
        return view('backend.kelas.lulus', $data);
    }
    public function load_data_lulus(Request $request)
    {
        $data = DB::select("select u.id, u.nama_lengkap, k.nama_kelas, j.nama_jurusan 
        from users u left join kelas k on k.id=u.kelas_id left join jurusan j on j.id=u.jurusan_id 
        where u.kelas_id = '$request->kelas_id_from' and u.jurusan_id = '$request->jurusan_id_from' and u.status != 'Lulus'");
        echo json_encode($data);
    }
    function lulusproses(Request $request)
    {
        foreach (explode(',', $request->user_id) as $uid) {
            $data = [
                'status' => "Lulus",
            ];
            DB::table('users')->where('id', $uid)->update($data);
        }
        echo json_encode($data);
    }
}
