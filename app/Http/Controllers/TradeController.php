<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trade;

class TradeController extends Controller
{
    public function index(Request $request){
        return view("trades",[
            "data" =>  Trade::orderBy("id","desc")->get(),
            "type" => $request->type ?? "CRYPTO"
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
        return view("tardes",[
            "trade" => $trade 
        ]);
    }

    public function update(Trade $trade,Request $request){
        $trade->update($request->all());

        return redirect()->to("/trade");
    }
}
