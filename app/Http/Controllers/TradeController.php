<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trade;

class TradeController extends Controller
{
    public function index(Request $request){
        return view("trades",[
            "data" =>  Trade::orderBy("id","desc")->get(),
            "type" => $request->type ?? "CRYPTO",
            "trade" => null,
            
            "crypto_total_trade" => 0,
            "crypto_win_trade" => 0,
            "crypto_loss_trade" => 0,
            "crypto_win_rate" =>  0,

            "forex_total_trade" => 0,
            "forex_win_trade" => 0,
            "forex_loss_trade" => 0,
            "forex_win_rate" =>  0
        ]);
    }

    public function store(Request $request){    
        Trade::create($request->all());

        return redirect()->to("/trade");
    }

    public function show(Trade $trade,Request $request){
        return view("trades",[
            "data" =>  Trade::orderBy("id","desc")->get(),
            "type" => $request->type ?? "CRYPTO",
            "trade" => $trade,

            "crypto_total_trade" => 0,
            "crypto_win_trade" => 0,
            "crypto_loss_trade" => 0,
            "crypto_win_rate" =>  0,

            "forex_total_trade" => 0,
            "forex_win_trade" => 0,
            "forex_loss_trade" => 0,
            "forex_win_rate" =>  0
        ]);
    }

    public function update(Trade $trade,Request $request){
        $trade->update($request->all());

        return redirect()->to("/trade");
    }
}
