<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();

            $table->string("area")->nullable();
            // AREA 1 
            // AREA 2 

            $table->string("type")->default("CRYPTO");
            // FOREX
            // CRYPTO
           
            $table->timestamp("start_trade")->nullable();
            $table->timestamp("end_trade")->nullable();
            
            $table->date("edge_date")->nullable();

            $table->string("is_same_trade")->default("NO");

            $table->string("broker")->default("GATEIO");
            // MIFX
            // GATEIO

            $table->string("time_trade")->default("MORNING");
            // MORNING
            // EVENING
            // NIGHT
   
            $table->string("asset")->default("BTC");
            // BTC
            // ETH
            // GOLD

            $table->string("chart")->default("CANDLE");
            // CANDLE
            // HAKAI
          
            $table->string("tf1d_bl")->default("NONE");
            $table->String("tf1d_rsi")->default("NONE");
            $table->string("tf1d_macd")->default("NONE");
            // LONG
            // SHORT
            // NONE

            $table->string("tf4h_bl")->default("NONE");
            $table->String("tf4h_rsi")->default("NONE");
            $table->string("tf4h_macd")->default("NONE");

            $table->string("tf1h_bl")->default("NONE");
            $table->String("tf1h_rsi")->default("NONE");
            $table->string("tf1h_macd")->default("NONE");

            $table->string("tf15m_bl")->default("NONE");
            $table->String("tf15m_rsi")->default("NONE");
            $table->string("tf15m_macd")->default("NONE");

            $table->string("tf5m_bl")->default("NONE");
            $table->String("tf5m_rsi")->default("NONE");
            $table->string("tf5m_macd")->default("NONE");
   
            $table->string("action")->default("NONE");
            // NONE
            // LONG
            // SHORT

            $table->text("start_description")->nullable();

            $table->decimal("margin_trade",20,2)->default(0.00);

            $table->decimal("lot_trade",20,2)->default(0.00);

            $table->decimal("lev_trade",20,2)->default(0.00);

            $table->decimal("sl_percentage",20,2)->default(0.00);
            
            $table->string("result")->default("NONE");
            // NONE
            // LOSS
            // WIN

            $table->decimal("win_percentage",20,2)->default(0.00);
            
            $table->decimal("lose_percentage",20,2)->default(0.00);

            $table->text("last_description")->nullable();

            $table->string("status")->default("PROSESS");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
