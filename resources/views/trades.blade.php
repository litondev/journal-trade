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
                            Buy
                        @elseif($item->action === 'SHORT')
                            Sell
                        @else 
                            Tidak Ada
                        @endif 
                    </td>
                    <td>
                        @if($item->status === 'PROSESS')
                            PROSESS
                        @else 
                            SELESAI
                        @endif 
                    </td>
                    <td>
                        @if($item->result === 'NONE')
                            <span>Tidak Ada</span>
                        @elseif($item->result === 'WIN')
                            <span style="color: green">MENANG</span>
                        @else 
                            <span style="color: red">KALAH</span>
                        @endif 
                    </td>
                    <td>{{ $item->last_description ?? '-' }}</td>
                    <td>
                        <a href="">Edit</a>
                        <a href="">Selesikan</a>
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
            action="{{ url('/trade') }}"
            class="flex-container"
            style="margin-top: 10px">   
            @csrf

            @if(isset($trade))
                <input type="hidden" name="_method" value="put" />
            @endif
                
            <input type="hidden"
                value="{{ $type }}"
                name="type"/>
   
            <div>
                Awal Trade <br/>
                <input type="datetime-local" 
                    name="start_trade">
            </div>
            
            <div>
                Akhir Trade <br/>
                <input type="datetime-local"
                    name="end_trade">
            </div>

            <div>
                Tanggal Edge <br/>
                <input type="date" 
                    name="edge_date">
            </div>

            <div>
                Trade Yang Sama
                <select name="is_same_trade">
                    <option value="NO">Tidak</option>
                    <option value="YES">Ya</option>
                </select>
            </div>

            <div>
                Broker
                <select  
                    name="broker">
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
                    name="time_trade">
                    <option value="MORNING">Pagi</option>
                    <option value="EVENING">Siang</option>
                    <option value="NIGHT">Malam</option>
                </select>
            </div>

            <div>
                Asset 
                <select 
                    name="asset">
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
                    name="chart">
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
                    <select name="tf1d_macd">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Bollinger Band 
                </div> 
                <div>
                    <select name="tf1d_bl">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Rsi 
                </div> 
                <div>
                    <select name="tf1d_rsi">
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
                    <select name="tf4h_macd">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Bollinger Band 
                </div> 
                <div>
                    <select name="tf4h_bl">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Rsi 
                </div> 
                <div>
                    <select name="tf4h_rsi">
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
                    <select name="tf1h_macd">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Bollinger Band 
                </div> 
                <div>
                    <select name="tf1h_bl">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Rsi 
                </div> 
                <div>
                    <select name="tf1h_rsi">
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
                    <select name="tf15m_macd">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Bollinger Band 
                </div> 
                <div>
                    <select name="tf15m_bl">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Rsi 
                </div> 
                <div>
                    <select name="tf15m_rsi">
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
                    <select name="tf5m_macd">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Bollinger Band 
                </div> 
                <div>
                    <select name="tf5m_bl">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
                <div>
                    Rsi 
                </div> 
                <div>
                    <select name="tf5m_rsi">
                        <option value="NONE">Tidak Digunakan</option>
                        <option value="LONG">Long</option>
                        <option value="SHORT">Short</option>
                    </select>
                </div>
            </div>

            <div>
                Aksi <br/>
                <select name="action">
                    <option value="NONE">Tidak Ada</option>
                    <option value="LONG">Long</option>
                    <option value="SHORT">Short</option>
                </select>
            </div>
            
            <div>
                Keterangan Awal <br/>
                <textarea
                    name="start_description"></textarea>
            </div>

            <div>
                Margin Trade <br/>
                <input type="numeric"
                    value="0.00"
                    name="margin_trade">
            </div>

            @if($type === "FOREX")
            <div>
                Lot Trade <br/>
                <input type="numeric"
                    value="0.00"
                    name="lot_trade">
            </div>
            @endif

            @if($type === "CRYPTO")
            <div>
                Lev Trade <br/>
                <input type="numeric"
                    value="0.00"
                    name="lev_trade">
            </div>
            @endif

            <div>
                Sl Persentase <br/>
                <input type="numeric"
                    value="0.00"
                    name="sl_percentage">
            </div>

            <div>
                Hasil <br/>
                <select name="result">
                    <option value="NONE">Tidak Ada</option>
                    <option value="LOSS">Kalah</option>
                    <option value="WIN">Menang</option>
                </select>
            </div>

            <div>
                Menang Persentase <br/>
                <input type="numeric"
                    value="0.00"
                    name="win_percentage">
            </div>

            <div>
                Kalah Persentase <br/>
                <input type="numeric"
                    value="0.00"
                    name="lose_percentage">
            </div>

            <div>
                Keterangan Akhir <br/>
                <textarea
                    name="last_description"></textarea>
            </div>

            <div>
                <button type="submit">Kirim</button>
            </div>
        </form>
    </body>
</html>