<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\tbl_user;

class Akun extends Controller
{

  public function Tambah(Request $request){
    $data = tbl_user::create([
        'name' => $request->name,
        'username' => $request->username,
        'password' => $request->password,
      ]);
    $res['message'] = 'Success!';
    $res['values'] = $data;
    return response($res);
  }

    public function Ubah(Request $request){
      $data = DB::table('tbl_user')->where('id',$request->id)->update([
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            ]);
      $res['message'] = 'Success!';
      $res['values'] = $data;
      return response($res);
    }

    public function getDetail($username){
      $data = DB::table('tbl_user')->where('username',$username)->get();
      if(count($data) > 0){
        $res['message'] = 'Success!';
        $res['values'] = $data;
        return response($res);
      }else{
        $res['message'] = 'Empty!!';
        return response($res);
      }
    }
}
