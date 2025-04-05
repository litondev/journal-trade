<!DOCTYPE html>
<html>
    <head>
        <style>
            .flex-container {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
            }

            .flex-container > div {
                padding-top: 10px;
                padding-bottom: 10px;
                margin-left: 15px;
                margin-right: 15px;
                font-size: 12px;
            }
        </style>
    </head>
    <body>
        <h2>TRADE FOREX AND CRYPTO</h2>

        <div style="overflow: auto;max-height: 250px;margin-bottom: 10px">
            <table style="width: 100%">
                <tr>
                    <td>Kode</td>
                    <td>Tipe</td>
                    <td>Asset</td>
                    <td>Hasil</td>
                    <td style="width: 5%">Aksi</td>
                </tr>

                @foreach($data as $item)
                <tr>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->asset }}</td>
                    <td>
                        @if($item->close_price && $item->close_trade)
                            HASIL
                        @else 
                            PROSESS
                        @endif 
                    </td>
                    <td>
                        <a href="{{ url('/trade/'.$item->id) }}">Edit</a>
                    </td>
                </tr> 
                @endforeach 

                @if(!count($data)) 
                <tr>
                    <td colspan="6">Tidak Ditemukan</td>
                </tr>
                @endif 
            </table>
        </div>

        <hr/>

        Pilih : 
        @if($type === 'FOREX')
            <a href="{{ url('/trade?type=CRYPTO') }}">Crypto</a>
        @else 
            <a href="{{ url('/trade?type=FOREX') }}">Forex</a>
        @endif 

        <!-- FORM --> 
        <form method="POST"
            action="{{ url('/trade'.( (isset($trade) && $trade) ? '/'.$trade->id : '')) }}"
            class="flex-container"
            style="margin-top: 10px">   
            @csrf

            @if(isset($trade) && $trade)
                <input type="hidden" name="_method" value="put" />
            @endif

            <div>
                Kode
                <input type="text"
                    value="{{ isset($trade) && $trade ? $trade->code : ''}}"
                    name="code"/>
            </div>

            <input type="hidden"
                value="LONG"
                name="type"/>

            @if($type === 'CRYPTO')
            <input type="hidden"
                value="JUP"
                name="broker"/>

            <input type="hidden"
                value="{{ isset($trade) && $trade ? $trade->fee_trade_percentage : 0.35}}"
                name="fee_trade_percentage"/>

            <input type="hidden"
                value="{{ isset($trade) && $trade ? $trade->leverage : 25}}"
                name="leverage"/>

            <input type="hidden"
                value="{{ isset($trade) && $trade ? $trade->lot : 0}}"
                name="lot"/>
            @else 
            <input type="hidden"
                value="EXNESS"
                name="broker"/>

            <input type="hidden"
                value="{{ isset($trade) && $trade ? $trade->fee_trade_percentage : 0.01}}"
                name="fee_trade_percentage"/>

            <input type="hidden"
                value="{{ isset($trade) && $trade ? $trade->leverage : 400}}"
                name="leverage"/>

            <div>
                Lot 
                <input type="numeric"
                    value="{{ isset($trade) && $trade ? $trade->lot : 0}}"
                    name="lot"/>
            </div>
            @endif 

            <div>
                Asset 
                <select 
                    name="asset"
                    {{ isset($trade) && $trade ? 'disabled' : ''}}>
                    @if($type === "FOREX")  
                        <option value="GOLD"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'GOLD' ? 'selected' : '') : ''}}>Gold</option>
                        <option value="S&P"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'S&P' ? 'selected' : '') : ''}}>S&P</option>
                        <option value="NASDAQ"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'NASDAQ' ? 'selected' : '') : ''}}>Nasdaq</option>
                    @else 
                        <option value="BTC"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'BTC' ? 'selected' : '') : ''}}>Btc</option>
                        <option value="ETH"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'ETH' ? 'selected' : '') : ''}}>Eth</option>
                        <option value="SOL"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'SOL' ? 'selected' : '') : ''}}>Sol</option>
                        @endif  
                </select>
            </div>

            <div>
                Awal Trade <br/>
                <input
                    type="datetime-local"
                    {{ isset($trade) && $trade ? 'disabled' : ''}}
                    name="open_trade"
                    value="{{ isset($trade) && $trade ? $trade->open_trade : ''}}">
            </div>
            
            @if(isset($trade) && $trade)
                <div>
                    Akhir Trade <br/>
                    <input 
                        type="datetime-local"
                        {{ isset($trade->close_trade) && $trade->close_trade ? 'disabled' : '' }}
                        name="close_trade"
                        value="{{ $trade->close_trade }}">
                </div>
            @endif

            <div>
                Awal Harga <br/>
                <input
                    type="numeric"
                    {{ isset($trade) && $trade ? 'disabled' : ''}}
                    name="open_price"
                    value="{{ isset($trade) && $trade ? $trade->open_price : 0.00}}">
            </div>
            
            @if(isset($trade) && $trade)
            <div>
                Akhir Harga <br/>
                <input 
                    type="numeric"
                    {{ isset($trade->close_price) && $trade->close_price && floatval($trade->close_price) > 0.00 ? 'disabled' : '' }}
                    name="close_price"
                    value="{{ $trade->close_price }}">
                </div>
            @endif

            <div>
                Total <br/>
                <input type="numeric"
                    {{ isset($trade) && $trade ? 'disabled' : ''}}
                    value="{{ isset($trade) && $trade ? $trade->amount : 0.00}}"
                    name="amount">
            </div>

            <div>
                Risk Persentase <br/>
                <input type="numeric"
                    {{ isset($trade) && $trade ? 'disabled' : ''}}
                    value="{{ isset($trade) && $trade ? $trade->risk_percentage : 0.00}}"
                    name="risk_percentage">
            </div>

            <div>
                <button type="submit">Kirim</button>
            </div>
        </form>
        <!-- FORM -->

        <hr/>

        <!-- SUMMARY --> 
        <div class="flex-container">
            @if($type === 'CRYPTO')
            <div>
                <b>Cyrpto</b> 
                <div>
                    Total Trade <br/>
                    {{ $crypto_total_trade}}
                </div>
                <div>
                    Win <br/>
                    {{ $crypto_win_trade }}
                </div>
                <div>
                    Lose <br/>
                    {{ $crypto_loss_trade }}
                </div>
                <div>
                    Win Rate <br/>
                    {{ $crypto_win_rate }}
                </div>
            </div>
            @endif 


            @if($type === 'FOREX')  
            <div>
                <b>Forex</b> 
                <div>
                    Total Trade <br/>
                    {{ $forex_total_trade}}
                </div>
                <div>
                    Win <br/>
                    {{ $forex_win_trade }}
                </div>
                <div>
                    Lose <br/>
                    {{ $forex_loss_trade }}
                </div>
                <div>
                    Win Rate <br/>
                    {{ $forex_win_rate }}
                </div>
            </div>
            @endif
        </div>
        <!-- SUMMARY -->
    </body>
</html>