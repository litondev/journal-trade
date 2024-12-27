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
            
            "crypto_total_trade" => Trade::where("type","CRYPTO")->whereIn("result",["WIN","LOSS"])->count(),
            "crypto_win_trade" => Trade::where("type","CRYPTO")->where("result","WIN")->count(),
            "crypto_loss_trade" => Trade::where("type","CRYPTO")->where("result","LOSS")->count(),
            "crypto_win_rate" =>  Trade::where("type","CRYPTO")->count() ? (Trade::where("type","CRYPTO")->where("result","WIN")->count() / Trade::where("type","CRYPTO")->count()) * 100 : 0,

            "forex_total_trade" => Trade::where("type","FOREX")->whereIn("result",["WIN","LOSS"])->count(),
            "forex_win_trade" => Trade::where("type","FOREX")->where("result","WIN")->count(),
            "forex_loss_trade" => Trade::where("type","FOREX")->where("result","LOSS")->count(),
            "forex_win_rate" =>   Trade::where("type","FOREX")->count() ? (Trade::where("type","FOREX")->where("result","WIN")->count() / Trade::where("type","FOREX")->count()) * 100 : 0,
        ]);
    }

    public function store(Request $request){
        $area = "AREA-1";

        $last_trade = Trade::where("type",$request->type)
            ->orderBy("id","desc")
            ->first();

        if(
            $last_trade && 
            $request->is_same_trade === 'NO'
        ){
            $area = "AREA-" . intval(str_replace("AREA-","",$last_trade->area)) + 1;
        }

        Trade::create([
            "area" => $area
        ] + $request->all());

        return redirect()->to("/trade");
    }

    public function show(Trade $trade,Request $request){
        return view("trades",[
            "data" =>  Trade::orderBy("id","desc")->get(),
            "type" => $request->type ?? "CRYPTO",
            "trade" => $trade,

            "crypto_total_trade" => Trade::where("type","CRYPTO")->whereIn("result",["WIN","LOSS"])->count(),
            "crypto_win_trade" => Trade::where("type","CRYPTO")->where("result","WIN")->count(),
            "crypto_loss_trade" => Trade::where("type","CRYPTO")->where("result","LOSS")->count(),
            "crypto_win_rate" =>  Trade::where("type","CRYPTO")->count() ? (Trade::where("type","CRYPTO")->where("result","WIN")->count() / Trade::where("type","CRYPTO")->count()) * 100 : 0,

            "forex_total_trade" => Trade::where("type","FOREX")->whereIn("result",["WIN","LOSS"])->count(),
            "forex_win_trade" => Trade::where("type","FOREX")->where("result","WIN")->count(),
            "forex_loss_trade" => Trade::where("type","FOREX")->where("result","LOSS")->count(),
            "forex_win_rate" =>   Trade::where("type","FOREX")->count() ? (Trade::where("type","FOREX")->where("result","WIN")->count() / Trade::where("type","FOREX")->count()) * 100 : 0,
        ]);
    }

    public function update(Trade $trade,Request $request){
        $trade->update($request->all());

        return redirect()->to("/trade");
    }

    public function done(Trade $trade,Request $request){
        $trade->update([
            "status" => "DONE"
        ]);

        return redirect()->to("/trade");
    }
}
