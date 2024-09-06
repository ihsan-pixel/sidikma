<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    public function index()
    {
        $data['title'] = "Admin";
        $data['admin'] = DB::select("select * from users where role != '2'");
        return view('backend.admin.index', $data);
    }
    public function add()
    {
        $data['title'] = "Tambah Admin";
        return view('backend.admin.add', $data);
    }
    public function addProses(Request $request)
    {
        $file_path = public_path() . '/storage/images/users/' . $request->image;
        File::delete($file_path);
        $image = $request->file('image');
        $filename = $image->getClientOriginalName();
        $image->move(public_path('storage/images/users'), $filename);
        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_tlp' => $request->no_tlp,
            'tgl_lahir' => $request->tgl_lahir,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'role' => $request->role,
            'status' => "ON",
            'image' => $request->file('image')->getClientOriginalName(),
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
        Alert::success('Admin berhasil ditambah');
        return redirect('admin');
    }
    public function edit(Request $request)
    {
        $data['title'] = "Edit Admin";
        $data['role'] = ['1', '3'];
        $data['status'] = ['ON', 'OFF'];
        $data['admin'] = DB::table('users')->where('id', $request->id)->first();
        return view('backend.admin.edit', $data);
    }
    public function editProses(Request $request)
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
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'no_tlp' => $request->no_tlp,
                'tgl_lahir' => $request->tgl_lahir,
                'alamat' => $request->alamat,
                'role' => $request->role,
                'status' => $request->status,
                'image' => $request->file('image')->getClientOriginalName(),
                'updated_at' => now()
            ];
        } else {
            $data = [
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'no_tlp' => $request->no_tlp,
                'tgl_lahir' => $request->tgl_lahir,
                'alamat' => $request->alamat,
                'role' => $request->role,
                'status' => $request->status,
                'updated_at' => now()
            ];
        }

        // dd($data);
        DB::table('users')->where('id', $request->id)->update($data);
        Alert::success('Admin berhasil diubah');
        return redirect('admin');
    }
    public function delete($id)
    {
        try {
            $getImage = DB::table('users')->where('id', $id)->first();
            $file_path = public_path() . '/storage/images/users/' . $getImage->image;
            File::delete($file_path);
            DB::table('users')->where('id', $id)->delete();
            // Alert::success('Category was successful deleted!');
            return redirect()->route('admin');
        } catch (Exception $e) {
            return response([
                'success' => false,
                'msg' => 'Error : ' . $e->getMessage() . ' Line : ' . $e->getLine() . ' File : ' . $e->getFile()
            ]);
        }
    }
    function changeStatus($request)
    {
        dd($request->all());
    }
}
