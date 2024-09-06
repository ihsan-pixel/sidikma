<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;


class SiswaController extends Controller
{
    public function index()
    {
        $data['title'] = "Guru/Pegawai";
        $data['siswa'] = DB::select("select u.*, k.nama_kelas, j.nama_jurusan from users u left join kelas k on u.kelas_id=k.id left join jurusan j on u.jurusan_id=j.id where role = '2' and u.status != 'Lulus'");
        return view('backend.siswa.index', $data);
    }
    public function add()
    {
        $data['title'] = "Tambah Guru/Pegawai";
        $data['kelas'] = DB::select("select * from kelas");
        $data['jurusan'] = DB::select("select * from jurusan");
        return view('backend.siswa.add', $data);
    }
    public function addSiswa(Request $request)
    {
        $file_path = public_path() . '/storage/images/users/' . $request->image;
        File::delete($file_path);
        $image = $request->file('image');
        $filename = $image->getClientOriginalName();
        $image->move(public_path('storage/images/users'), $filename);
        $data = [
            'nis' => $request->nis,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_tlp' => $request->no_tlp,
            'kelas_id' => $request->kelas_id,
            'jurusan_id' => $request->jurusan_id,
            'tgl_lahir' => $request->tgl_lahir,
            'no_ortu' => $request->no_ortu,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'status' => "ON",
            'image' => $request->file('image')->getClientOriginalName(),
            'role' => 2,
            'created_at' => now()
        ];
        // dd($data);
        $cekUsers = DB::table('users')->where('email', $request->email)->first();
        // dd($cekUsers);
        if ($cekUsers != null) {
            Alert::error('Email sudah terdaftar!');
            return redirect()->back()->withInput();
        }
        DB::table('users')->insert($data);
        Alert::success('Guru/Pegawai berhasil ditambah');
        return redirect('siswa');
    }
    public function edit($id)
    {
        $data['title'] = "Edit Guru/Pegawai";
        $data['status'] = ['ON', 'OFF'];
        $data['siswa'] = DB::table('users')->where('id', $id)->first();
        $data['kelas'] = DB::select("select * from kelas");
        $data['jurusan'] = DB::select("select * from jurusan");
        return view('backend.siswa.edit', $data);
    }
    public function editProses(Request  $request)
    {
        if ($request->has('image') != null) {
            $getImage = DB::table('users')->where('id', $request->id)->first();
            $file_path = public_path() . '/storage/images/users/' . $getImage->image;
            File::delete($file_path);
            $image = $request->file('image');
            // dd($getImage->image);
            $filename = $image->getClientOriginalName();
            $image->move(public_path('storage/images/users'), $filename);
            $data = [
                'nis' => $request->nis,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'no_tlp' => $request->no_tlp,
                'kelas_id' => $request->kelas_id,
                'jurusan_id' => $request->jurusan_id,
                'tgl_lahir' => $request->tgl_lahir,
                'no_ortu' => $request->no_ortu,
                'alamat' => $request->alamat,
                'status' => $request->status,
                'image' => $request->file('image')->getClientOriginalName(),
                'role' => 2,
                'updated_at' => now()
            ];
        } else {
            $data = [
                'nis' => $request->nis,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'no_tlp' => $request->no_tlp,
                'kelas_id' => $request->kelas_id,
                'jurusan_id' => $request->jurusan_id,
                'tgl_lahir' => $request->tgl_lahir,
                'no_ortu' => $request->no_ortu,
                'alamat' => $request->alamat,
                'status' => $request->status,
                'role' => 2,
                'updated_at' => now()
            ];
        }

        // dd($data);
        DB::table('users')->where('id', $request->id)->update($data);
        Alert::success('Guru/Pegawai berhasil diubah');
        return redirect('siswa');
    }
    public function delete($id)
    {
        try {
            // dd($id);
            $getImage = DB::table('users')->where('id', $id)->first();
            $file_path = public_path() . '/storage/images/users/' . $getImage->image;
            File::delete($file_path);

            DB::table('users')->where('id', $id)->delete();
            Alert::success('Guru/Pegawai berhasil dihapus');
            return redirect()->route('siswa');
        } catch (Exception $e) {
            return response([
                'success' => false,
                'msg'     => 'Error : ' . $e->getMessage() . ' Line : ' . $e->getLine() . ' File : ' . $e->getFile()
            ]);
        }
    }
    public function alumni()
    {
        $data['title'] = "Alumni Siswa";
        $data['alumni'] = DB::select("select u.*, k.nama_kelas, j.nama_jurusan from users u left join kelas k on u.kelas_id=k.id left join jurusan j on u.jurusan_id=j.id where role = '2' and u.status = 'Lulus'");
        // $data['tunggakan'] = DB::table('tagihan')->where('status', 'Belum Lunas')->first();
        return view('backend.siswa.alumni', $data);
    }
    public function tunggakan($user_id)
    {
        $data['title'] = "Tunggakan Guru/Pegawai";
        $data['tunggakan'] = DB::select("SELECT z.*, z.tagihan - z.bayar AS tunggakan FROM (
  SELECT t.user_id, u.nama_lengkap, ta.tahun, jp.pembayaran,
  CASE
    WHEN t.jenis_pembayaran = 1 THEN t.nilai * 12
    ELSE t.nilai
    END AS tagihan, SUM(IFNULL(p.nilai, 0)) AS bayar
  FROM tagihan t
  LEFT JOIN payment p on p.tagihan_id=t.id
  LEFT JOIN tahun_ajaran ta on ta.id=t.thajaran_id
  LEFT JOIN jenis_pembayaran jp on jp.id=t.jenis_pembayaran
  INNER JOIN users u on u.id = t.user_id
  GROUP BY t.user_id, jp.pembayaran, ta.tahun, t.jenis_pembayaran, t.nilai
) z
WHERE z.user_id = '$user_id' ORDER BY tunggakan DESC");
        return view('backend.siswa.tunggakan', $data);
    }
}
