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

            $table->string("code")->nullable();
            // W1BTC
            // W2BTC

            $table->string("type")->nullable();
            // LONG
            // SELL

            $table->string("broker")->nullable();
            // JUP
            // EXNESS

            $table->decimal("fee_trade_percentage",20,2)->default(0.00);
            // CRYPTO
                // 0.35
            // FOREX
                // 0.50

            $table->decimal("leverage",20,2)->default(0.00);
            // CRYPTO
                // 25
            // FOREX 
                // 400

            $table->decimal("lot",20,2)->default(0.00);
            // FOREX
                // 0.01
    
            $table->string("asset")->nullable();
            // CRYPTO
                // BTC
                // SOL
                // ETH
            // FOREX 
                // GOLD
                // NASDAQ
                // S&P
            
            $table->timestamp("open_trade")->nullable();
            $table->decimal("open_price",20,2)->default(0.00);
            // 122
            // 2400

            $table->timestamp("close_trade")->nullable();
            $table->decimal("close_price",20,2)->default(0.00);
            // 120
            // 1000

            $table->decimal("amount",20,2)->default(0.00);
            // 25$
            // 250$

            $table->decimal("risk_percentage",20,2)->default(0.00);
            // 50%
            // 75%

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
