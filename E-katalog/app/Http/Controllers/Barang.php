<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\tbl_katalog;
class Barang extends Controller
{
    public function store(Request $request){
      $this->validate($request, [
        'file' => 'required|max:2048'
      ]);

      //simpan data file yang diupload
      $file = $request->file('file');

      $nama_file = time()."_".$file->getClientOriginalName();

      $tujuan_upload = 'data_file';
      if($file->move($tujuan_upload,$nama_file)){
        $data = tbl_katalog::create([
          'nama_produk' => $request->nama_produk,
          'berat' => $request->berat,
          'harga' => $request->harga,
          'gambar' => $nama_file,
          'keterangan' => $request->keterangan
        ]);
        $res['message'] = 'Success!';
        $res['values'] = $data;
        return response($res);
      }else{
        $res['message'] = 'Error!';
        return response($res);
      }
    }

    public function getData(){
      $data = DB::table('tbl_katalog')->get();
      if(count($data) > 0){
        $res['message'] = 'Success!';
        $res['values'] = $data;
        return response($res);
      }else{
        $res['message'] = 'Empty!!';
        return response($res);
      }
    }

    public function hapus($id){
      $data = DB::table('tbl_katalog')->where('id',$id)->get();
      foreach ($data as $katalog) {
        $image_path = 'http://localhost/APIREST/public' .$katalog->gambar;
        if (file_exists(public_path('data_file/'.$katalog->gambar))){
          @unlink(public_path('data_file/'.$katalog->gambar));
          DB::table('tbl_katalog')->where('id', $id)->delete();
          $res['message'] = 'Berhasil Hapus !!!';
          return response($res);
        }else{
          $res['message'] = 'Empty!!';
          return response($res);
        }
      }
    }

    public function getDetail($id){
      $data = DB::table('tbl_katalog')->where('id',$id)->get();
      if(count($data) > 0){
        $res['message'] = 'Success!';
        $res['values'] = $data;
        return response($res);
      }else{
        $res['message'] = 'Empty!!';
        return response($res);
      }
    }

    public function update(Request $request){
      if(!empty($request->file)){
        $this->validate($request, [
          'file' => 'required|max:2048'
        ]);

        //simpan data file yang diupload
        $file = $request->file('file');

        $nama_file = time()."_".$file->getClientOriginalName();

        $tujuan_upload = 'data_file';
        $file->move($tujuan_upload,$nama_file);
        $data = DB::table('tbl_katalog')->where('id',$request->id)->get();
        foreach ($data as $katalog) {
          //fungsi hapus file
        @unlink(public_path('data_file/'.$katalog->gambar));
        //fungsi update data
        $ket = DB::table('tbl_katalog')->where('id',$request->id)->update([
              'nama_produk' => $request->nama_produk,
              'berat' => $request->berat,
              'harga' => $request->harga,
              'gambar' => $nama_file,
              'keterangan' => $request->keterangan
              ]);
        }
        $res['message'] = 'Success!';
        $res['values'] = $data;
        return response($res);
      }else{
        $data = DB::table('tbl_katalog')->where('id',$request->id)->get();
        foreach ($data as $katalog) {
        //fungsi update data
        $ket = DB::table('tbl_katalog')->where('id',$request->id)->update([
              'nama_produk' => $request->nama_produk,
              'berat' => $request->berat,
              'harga' => $request->harga,
              'keterangan' => $request->keterangan
              ]);
        $res['message'] = 'Success!';
        $res['values'] = $data;
        return response($res);
        }
      }
    }
}
