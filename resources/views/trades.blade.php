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
        <h2>TRADE FOREX($1000) AND CRYPTO($25)</h2>

        <div style="overflow: auto;max-height: 250px;margin-bottom: 10px">
            <table style="width: 100%">
                <tr>
                    <td>Area</td>
                    <td>Tipe</td>
                    <td>Asset</td>
                    <td>Aksi</td>
                    <td>Status</td>
                    <td>Hasil</td>
                    <td style="width: 25%">Keterangan Akhir</td>
                    <td style="width: 5%">Aksi</td>
                </tr>

                @foreach($data as $item)
                <tr>
                    <td>{{ $item->area }}</td>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->asset }}</td>
                    <td>
                        @if($item->action === 'LONG')
                            <span style="font-weight: bold;color: green">Buy</span>
                        @elseif($item->action === 'SHORT')
                            <span style="font-weight: bold;color: danger">Sell</span>
                        @else 
                            Tidak Ada
                        @endif 
                    </td>
                    <td>
                        @if($item->status === 'PROSESS')
                            <span style="font-weight: bold;color: orange">PROSESS</span>
                        @else 
                            <span style="font-weight: bold;color: green">SELESAI</span>
                        @endif 
                    </td>
                    <td>
                        @if($item->result === 'NONE')
                            <span>Tidak Ada</span>
                        @elseif($item->result === 'WIN')
                            <span style="font-weight: bold;color: green">MENANG</span>
                        @else 
                            <span style="font-weight: bold;color: red">KALAH</span>
                        @endif 
                    </td>
                    <td>{{ $item->last_description ?? '-' }}</td>
                    <td>
                        @if($item->status === 'PROSESS')
                            <a href="{{ url('/trade/'.$item->id) }}">Edit</a>

                            <form  id="form-done" action="{{ url('/trade/done/'.$item->id) }}" method="post">
                                @csrf
                                <input type="hidden" name="_method" value="put" />
                                <a href="javascript:;" onclick="document.getElementById('form-done').submit();">Selesikan</a>
                            </form>
                        @endif
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

        Pilih : 
        @if($type === 'FOREX')
            <a href="{{ url('/trade?type=CRYPTO') }}">Crypto</a>
        @else 
            <a href="{{ url('/trade?type=FOREX') }}">Forex</a>
        @endif 
        
        <form method="POST"
            action="{{ url('/trade'.( (isset($trade) && $trade) ? '/'.$trade->id : '')) }}"
            class="flex-container"
            style="margin-top: 10px">   
            @csrf

            @if(isset($trade) && $trade)
                <input type="hidden" name="_method" value="put" />

                <input type="hidden"
                    value="{{ $trade->type }}"
                    name="type"/>
            @else 
                <input type="hidden"
                    value="{{ $type }}"
                    name="type"/>
            @endif 
   
            <div>
                Awal Trade <br/>
                <input type="datetime-local" 
                    name="start_trade"
                    value="{{ isset($trade) && $trade ? $trade->start_trade : ''}}">
            </div>
            
            <div>
                Akhir Trade <br/>
                <input type="datetime-local"
                    name="end_trade"
                    value="{{ isset($trade) && $trade ? $trade->end_trade : ''}}">
            </div>

            <div>
                Tanggal Edge <br/>
                <input type="date" 
                    name="edge_date"
                    value="{{ isset($trade) && $trade ? $trade->edge_date : ''}}">
            </div>

            <div>
                Trade Yang Sama
                <select name="is_same_trade"
                    value="{{ isset($trade) && $trade ? $trade->is_same_trade : 'NO'}}">
                    <option value="NO">Tidak</option>
                    <option value="YES">Ya</option>
                </select>
            </div>

            <div>
                Broker
                <select  
                    name="broker"
                    value="{{ isset($trade) && $trade ? $trade->broker : ( $type === 'FOREX' ? 'MIFX' : 'GATEIO' ) }}">
                    @if($type === "FOREX")
                        <option value="MIFX">Mifx</option>
                        <option value="OCTA">Octa</option>
                        <option value="FINEX">Finex</option>
                    @else 
                        <option value="GATEIO">Gate Io</option>
                        <option value="JUPITER">Jupiter</option>
                        <option value="BINANCE">Binance</option>
                    @endif
                </select>
            </div>
   
            <div>
                Waktu Trade 
                <select
                    name="time_trade"
                    value="{{ isset($trade) && $trade ? $trade->time_trade : 'MORNING'}}">
                    <option value="MORNING">Pagi</option>
                    <option value="EVENING">Siang</option>
                    <option value="NIGHT">Malam</option>
                </select>
            </div>

            <div>
                Asset 
                <select 
                    name="asset"
                    value="{{ isset($trade) && $trade ? $trade->asset : ( $type === 'FOREX' ? 'GOLD' : 'BTC' ) }}">
                    @if($type === "FOREX")  
                        <option value="GOLD">Gold</option>
                        <option value="OIL">Oil</option>
                        <option value="SILVER">Silver</option>
                    @else 
                        <option value="BTC">Btc</option>
                        <option value="ETH">Eth</option>
                        <option value="SOL">Sol</option>

                        <option value="DOGE">Doge</option>
                        <option value="BONK">Bonk</option>
                        <option value="SHIB">Shib</option>
                        <option value="FLOKI">Floki</option>
                        <option value="PEPE">Pepe</option>
                        <option value="PENGU">Pengu</option>
                        <option value="BOME">Bome</option>
                        <option value="SLERF">Slerf</option>
                        <option value="MEW">Mew</option>
                        <option value="CHILLGUY">ChillGuy</option>
                        <option value="WIF">Wif</option>
                        <option value="FARTCOIN">Fartcoin</option>
                    @endif  
                </select>
            </div>

            <div>
                Chart 
                <select
                    name="chart"
                    value="{{ isset($trade) && $trade ? $trade->chart : 'CANDLE'}}">
                    <option value="CANDLE">Candle</option>
                    <option value="HAKAI">Hakai</option>
                </select>
            </div>

            <div>
                <div>Tf 1d</div>
                <div>
                    Macd
                </div> 
                <div>
                    <select name="tf1d_macd"
                        value="{{ isset($trade) && $trade ? $trade->tf1d_macd : 'NONE'}}">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Bollinger Band 
                </div> 
                <div>
                    <select name="tf1d_bl"
                        value="{{ isset($trade) && $trade ? $trade->tf1d_bl : 'NONE'}}">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Rsi 
                </div> 
                <div>
                    <select name="tf1d_rsi"
                        value="{{ isset($trade) && $trade ? $trade->tf1d_rsi : 'NONE'}}">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
              
            </div>

            <div>
                <div>Tf 4h</div>
                <div>
                    Macd
                </div> 
                <div>
                    <select name="tf4h_macd"
                        value="{{ isset($trade) && $trade ? $trade->tf4h_macd : 'NONE'}}">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Bollinger Band 
                </div> 
                <div>
                    <select name="tf4h_bl"
                        value="{{ isset($trade) && $trade ? $trade->tf4h_bl : 'NONE'}}">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Rsi 
                </div> 
                <div>
                    <select name="tf4h_rsi"
                        value="{{ isset($trade) && $trade ? $trade->tf4h_rsi : 'NONE'}}">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
              
            </div>

            <div>
                <div>Tf 1h</div>
                <div>
                    Macd
                </div> 
                <div>
                    <select name="tf1h_macd"
                        value="{{ isset($trade) && $trade ? $trade->tf1h_macd : 'NONE'}}">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Bollinger Band 
                </div> 
                <div>
                    <select name="tf1h_bl"
                        value="{{ isset($trade) && $trade ? $trade->tf1h_bl : 'NONE'}}">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Rsi 
                </div> 
                <div>
                    <select name="tf1h_rsi"
                        value="{{ isset($trade) && $trade ? $trade->tf1h_rsi : 'NONE'}}">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
              
            </div>
            
            <div>
                <div>Tf 15m</div>
                <div>
                    Macd
                </div> 
                <div>
                    <select name="tf15m_macd"
                        value="{{ isset($trade) && $trade ? $trade->tf15m_macd : 'NONE'}}">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Bollinger Band 
                </div> 
                <div>
                    <select name="tf15m_bl"
                        value="{{ isset($trade) && $trade ? $trade->tf15m_bl : 'NONE'}}">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Rsi 
                </div> 
                <div>
                    <select name="tf15m_rsi"
                        value="{{ isset($trade) && $trade ? $trade->tf15m_rsi : 'NONE'}}">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
              
            </div>

            <div>
                <div>Tf 5m</div>
                <div>
                    Macd
                </div> 
                <div>
                    <select name="tf5m_macd"
                        value="{{ isset($trade) && $trade ? $trade->tf5m_macd : 'NONE'}}">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Bollinger Band 
                </div> 
                <div>
                    <select name="tf5m_bl"
                        value="{{ isset($trade) && $trade ? $trade->tf5m_bl : 'NONE'}}">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Rsi 
                </div> 
                <div>
                    <select name="tf5m_rsi"
                        value="{{ isset($trade) && $trade ? $trade->tf5m_rsi : 'NONE'}}">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
            </div>

            <div>
                Aksi <br/>
                <select name="action"
                    value="{{ isset($trade) && $trade ? $trade->action : 'NONE'}}">
                    <option value="NONE">Tidak Ada</option>
                    <option value="LONG">Long</option>
                    <option value="SHORT">Short</option>
                </select>
            </div>
            
            <div>
                Keterangan Awal <br/>
                <textarea
                    value="{{ isset($trade) && $trade ? $trade->start_description : ''}}"
                    name="start_description"></textarea>
            </div>

            <div>
                Margin Trade <br/>
                <input type="numeric"
                    value="{{ isset($trade) && $trade ? $trade->margin_trade : 0.00}}"
                    name="margin_trade">
            </div>

            @if($type === "FOREX")
            <div>
                Lot Trade <br/>
                <input type="numeric"
                    value="{{ isset($trade) && $trade ? $trade->lot_trade : 0.00}}"
                    name="lot_trade">
            </div>
            @endif

            @if($type === "CRYPTO")
            <div>
                Lev Trade <br/>
                <input type="numeric"
                    value="{{ isset($trade) && $trade ? $trade->lev_trade : 0.00}}"
                    name="lev_trade">
            </div>
            @endif

            <div>
                Sl Persentase <br/>
                <input type="numeric"
                    value="{{ isset($trade) && $trade ? $trade->sl_percentage : 0.00}}"
                    name="sl_percentage">
            </div>

            <div>
                Hasil <br/>
                <select name="result"
                    value="{{ isset($trade) && $trade ? $trade->result : 'NONE'}}">
                    <option value="NONE">Tidak Ada</option>
                    <option value="LOSS">Kalah</option>
                    <option value="WIN">Menang</option>
                </select>
            </div>

            <div>
                Menang Persentase <br/>
                <input type="numeric"
                    value="{{ isset($trade) && $trade ? $trade->win_percentage : 0.00}}"
                    name="win_percentage">
            </div>

            <div>
                Kalah Persentase <br/>
                <input type="numeric"
                    value="{{ isset($trade) && $trade ? $trade->lose_percentage : 0.00}}"
                    name="lose_percentage">
            </div>

            <div>
                Keterangan Akhir <br/>
                <textarea
                    value="{{ isset($trade) && $trade ? $trade->margin_trade : 0.00}}"
                    name="last_description"></textarea>
            </div>

            <div>
                <button type="submit">Kirim</button>
            </div>
        </form>

        <div class="flex-container">
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
        </div>
    </body>
</html>