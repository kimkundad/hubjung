<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cardmoney;
use App\Http\Requests;

class WalletController extends Controller
{
    //

    public function index(){
      $objs = cardmoney::all();
      $data['objs'] = $objs;

      return view('wallet.index', $data);
    }
}
