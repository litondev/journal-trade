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
                <select name="is_same_trade">
                    <option value="NO"
                        {{ (isset($trade) && $trade) ? ($trade->is_same_trade === 'NO' ? 'selected' : '') : ''}}>Tidak</option>
                    <option value="YES"
                    {{ (isset($trade) && $trade) ? ($trade->is_same_trade === 'YES' ? 'selected' : '') : ''}}>Ya</option>
                </select>
            </div>

            <div>
                Broker
                <select  
                    name="broker"
                    @if($type === "FOREX")
                        <option value="MIFX">
                            {{ (isset($trade) && $trade) ? ($trade->broker === 'MIFX' ? 'selected' : '') : ''}}>Mifx</option>
                        <option value="OCTA"
                            {{ (isset($trade) && $trade) ? ($trade->broker === 'OCTA' ? 'selected' : '') : ''}}>Octa</option>
                        <option value="FINEX"
                            {{ (isset($trade) && $trade) ? ($trade->broker === 'FINEX' ? 'selected' : '') : ''}}>Finex</option>
                    @else 
                        <option value="GATEIO"
                            {{ (isset($trade) && $trade) ? ($trade->broker === 'GATEIO' ? 'selected' : '') : ''}}>Gate Io</option>
                        <option value="JUPITER"
                            {{ (isset($trade) && $trade) ? ($trade->broker === 'JUPITER' ? 'selected' : '') : ''}}>Jupiter</option>
                        <option value="BINANCE"
                            {{ (isset($trade) && $trade) ? ($trade->broker === 'BINANCE' ? 'selected' : '') : ''}}>Binance</option>
                    @endif
                </select>
            </div>
   
            <div>
                Waktu Trade 
                <select
                    name="time_trade">
                    <option value="MORNING"
                        {{ (isset($trade) && $trade) ? ($trade->time_trade === 'MORNING' ? 'selected' : '') : ''}}>Pagi</option>
                    <option value="EVENING"
                        {{ (isset($trade) && $trade) ? ($trade->time_trade === 'EVENING' ? 'selected' : '') : ''}}>Siang</option>
                    <option value="NIGHT"
                        {{ (isset($trade) && $trade) ? ($trade->time_trade === 'NIGHT' ? 'selected' : '') : ''}}>Malam</option>
                </select>
            </div>

            <div>
                Asset 
                <select 
                    name="asset">
                    @if($type === "FOREX")  
                        <option value="GOLD"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'GOLD' ? 'selected' : '') : ''}}>Gold</option>
                        <option value="OIL"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'OIL' ? 'selected' : '') : ''}}>Oil</option>
                        <option value="SILVER"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'SILVER' ? 'selected' : '') : ''}}>Silver</option>
                    @else 
                        <option value="BTC"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'BTC' ? 'selected' : '') : ''}}>Btc</option>
                        <option value="ETH"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'ETH' ? 'selected' : '') : ''}}>Eth</option>
                        <option value="SOL"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'SOL' ? 'selected' : '') : ''}}>Sol</option>

                        <option value="DOGE"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'DOGE' ? 'selected' : '') : ''}}>Doge</option>
                        <option value="BONK"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'BONK' ? 'selected' : '') : ''}}>Bonk</option>
                        <option value="SHIB"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'SHIB' ? 'selected' : '') : ''}}>Shib</option>
                        <option value="FLOKI"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'FLOKI' ? 'selected' : '') : ''}}>Floki</option>
                        <option value="PEPE"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'PEPE' ? 'selected' : '') : ''}}>Pepe</option>
                        <option value="PENGU"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'PENGU' ? 'selected' : '') : ''}}>Pengu</option>
                        <option value="BOME"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'BOME' ? 'selected' : '') : ''}}>Bome</option>
                        <option value="SLERF"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'SLERF' ? 'selected' : '') : ''}}>Slerf</option>
                        <option value="MEW"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'MEW' ? 'selected' : '') : ''}}>Mew</option>
                        <option value="CHILLGUY"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'CHILLGUY' ? 'selected' : '') : ''}}>ChillGuy</option>
                        <option value="WIF"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'WIF' ? 'selected' : '') : ''}}>Wif</option>
                        <option value="FARTCOIN"
                            {{ (isset($trade) && $trade) ? ($trade->asset === 'FARTCOIN' ? 'selected' : '') : ''}}>Fartcoin</option>
                    @endif  
                </select>
            </div>

            <div>
                Chart 
                <select
                    name="chart"
                    value="{{ isset($trade) && $trade ? $trade->chart : 'CANDLE'}}">
                    <option value="CANDLE"
                        {{ (isset($trade) && $trade) ? ($trade->chart === 'CANDLE' ? 'selected' : '') : ''}}>Candle</option>
                    <option value="HAKAI"
                        {{ (isset($trade) && $trade) ? ($trade->chart === 'HAKAI' ? 'selected' : '') : ''}}>Hakai</option>
                </select>
            </div>

            <div>
                <div>Tf 1d</div>
                <div>
                    Macd
                </div> 
                <div>
                    <select name="tf1d_macd">
                        <option value="NONE"
                            {{ (isset($trade) && $trade) ? ($trade->tf1d_macd === 'NONE' ? 'selected' : '') : ''}}>Tidak Digunakan</option>
                        <option value="LONG"
                            {{ (isset($trade) && $trade) ? ($trade->tf1d_macd === 'LONG' ? 'selected' : '') : ''}}>Long</option>
                        <option value="SHORT"
                            {{ (isset($trade) && $trade) ? ($trade->tf1d_macd === 'SHORT' ? 'selected' : '') : ''}}>Short</option>
                    </select>
                </div>
                <div>
                    Bollinger Band 
                </div> 
                <div>
                    <select name="tf1d_bl">
                        <option value="NONE"
                            {{ (isset($trade) && $trade) ? ($trade->tf1d_bl === 'NONE' ? 'selected' : '') : ''}}>Tidak Digunakan</option>
                        <option value="LONG"
                            {{ (isset($trade) && $trade) ? ($trade->tf1d_bl === 'LONG' ? 'selected' : '') : ''}}>Long</option>
                        <option value="SHORT"
                            {{ (isset($trade) && $trade) ? ($trade->tf1d_bl === 'SHORT' ? 'selected' : '') : ''}}>Short</option>
                    </select>
                </div>
                <div>
                    Rsi 
                </div> 
                <div>
                    <select name="tf1d_rsi">
                        <option value="NONE"
                            {{ (isset($trade) && $trade) ? ($trade->tf1d_rsi === 'NONE' ? 'selected' : '') : ''}}>Tidak Digunakan</option>
                        <option value="LONG"
                            {{ (isset($trade) && $trade) ? ($trade->tf1d_rsi === 'LONG' ? 'selected' : '') : ''}}>Long</option>
                        <option value="SHORT"
                            {{ (isset($trade) && $trade) ? ($trade->tf1d_rsi === 'SHORT' ? 'selected' : '') : ''}}>Short</option>
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
                        <option value="NONE"
                            {{ (isset($trade) && $trade) ? ($trade->tf4h_macd === 'NONE' ? 'selected' : '') : ''}}>Tidak Digunakan</option>
                        <option value="LONG"
                            {{ (isset($trade) && $trade) ? ($trade->tf4h_macd === 'LONG' ? 'selected' : '') : ''}}>Long</option>
                        <option value="SHORT"
                            {{ (isset($trade) && $trade) ? ($trade->tf4h_macd === 'SHORT' ? 'selected' : '') : ''}}>Short</option>
                    </select>
                </div>
                <div>
                    Bollinger Band 
                </div> 
                <div>
                    <select name="tf4h_bl">
                        <option value="NONE"
                            {{ (isset($trade) && $trade) ? ($trade->tf4h_bl === 'NONE' ? 'selected' : '') : ''}}>Tidak Digunakan</option>
                        <option value="LONG"
                            {{ (isset($trade) && $trade) ? ($trade->tf4h_bl === 'LONG' ? 'selected' : '') : ''}}>Long</option>
                        <option value="SHORT"
                            {{ (isset($trade) && $trade) ? ($trade->tf4h_bl === 'SHORT' ? 'selected' : '') : ''}}>Short</option>
                    </select>
                </div>
                <div>
                    Rsi 
                </div> 
                <div>
                    <select name="tf4h_rsi">
                        <option value="NONE"
                            {{ (isset($trade) && $trade) ? ($trade->tf4h_rsi === 'NONE' ? 'selected' : '') : ''}}>Tidak Digunakan</option>
                        <option value="LONG"
                            {{ (isset($trade) && $trade) ? ($trade->tf4h_rsi === 'LONG' ? 'selected' : '') : ''}}>Long</option>
                        <option value="SHORT"
                            {{ (isset($trade) && $trade) ? ($trade->tf4h_rsi === 'SHORT' ? 'selected' : '') : ''}}>Short</option>
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
                        <option value="NONE"
                            {{ (isset($trade) && $trade) ? ($trade->tf1h_macd === 'NONE' ? 'selected' : '') : ''}}>Tidak Digunakan</option>
                        <option value="LONG"
                            {{ (isset($trade) && $trade) ? ($trade->tf1h_macd === 'LONG' ? 'selected' : '') : ''}}>Long</option>
                        <option value="SHORT"
                            {{ (isset($trade) && $trade) ? ($trade->tf1h_macd === 'SHORT' ? 'selected' : '') : ''}}>Short</option>
                    </select>
                </div>
                <div>
                    Bollinger Band 
                </div> 
                <div>
                    <select name="tf1h_bl">
                        <option value="NONE"
                            {{ (isset($trade) && $trade) ? ($trade->tf1h_bl === 'NONE' ? 'selected' : '') : ''}}>Tidak Digunakan</option>
                        <option value="LONG"
                            {{ (isset($trade) && $trade) ? ($trade->tf1h_bl === 'LONG' ? 'selected' : '') : ''}}>Long</option>
                        <option value="SHORT"
                            {{ (isset($trade) && $trade) ? ($trade->tf1h_bl === 'SHORT' ? 'selected' : '') : ''}}>Short</option>
                    </select>
                </div>
                <div>
                    Rsi 
                </div> 
                <div>
                    <select name="tf1h_rsi">
                        <option value="NONE"
                            {{ (isset($trade) && $trade) ? ($trade->tf1h_rsi === 'NONE' ? 'selected' : '') : ''}}>Tidak Digunakan</option>
                        <option value="LONG"
                            {{ (isset($trade) && $trade) ? ($trade->tf1h_rsi === 'LONG' ? 'selected' : '') : ''}}>Long</option>
                        <option value="SHORT"
                            {{ (isset($trade) && $trade) ? ($trade->tf1h_rsi === 'SHORT' ? 'selected' : '') : ''}}>Short</option>
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
                        <option value="NONE"
                            {{ (isset($trade) && $trade) ? ($trade->tf15m_macd === 'NONE' ? 'selected' : '') : ''}}>Tidak Digunakan</option>
                        <option value="LONG"
                            {{ (isset($trade) && $trade) ? ($trade->tf15m_macd === 'LONG' ? 'selected' : '') : ''}}>Long</option>
                        <option value="SHORT"
                            {{ (isset($trade) && $trade) ? ($trade->tf15m_macd === 'SHORT' ? 'selected' : '') : ''}}>Short</option>
                    </select>
                </div>
                <div>
                    Bollinger Band 
                </div> 
                <div>
                    <select name="tf15m_bl">
                        <option value="NONE"
                            {{ (isset($trade) && $trade) ? ($trade->tf15m_macd === 'NONE' ? 'selected' : '') : ''}}>Tidak Digunakan</option>
                        <option value="LONG"
                            {{ (isset($trade) && $trade) ? ($trade->tf15m_macd === 'LONG' ? 'selected' : '') : ''}}>Long</option>
                        <option value="SHORT"
                            {{ (isset($trade) && $trade) ? ($trade->tf15m_macd === 'SHORT' ? 'selected' : '') : ''}}>Short</option>
                    </select>
                </div>
                <div>
                    Rsi 
                </div> 
                <div>
                    <select name="tf15m_rsi">
                        <option value="NONE"
                            {{ (isset($trade) && $trade) ? ($trade->tf15m_macd === 'NONE' ? 'selected' : '') : ''}}>Tidak Digunakan</option>
                        <option value="LONG"
                            {{ (isset($trade) && $trade) ? ($trade->tf15m_macd === 'LONG' ? 'selected' : '') : ''}}>Long</option>
                        <option value="SHORT"
                            {{ (isset($trade) && $trade) ? ($trade->tf15m_macd === 'SHORT' ? 'selected' : '') : ''}}>Short</option>
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
                        <option value="NONE"
                            {{ (isset($trade) && $trade) ? ($trade->tf5m_macd === 'NONE' ? 'selected' : '') : ''}}>Tidak Digunakan</option>
                        <option value="LONG"
                            {{ (isset($trade) && $trade) ? ($trade->tf5m_macd === 'LONG' ? 'selected' : '') : ''}}>Long</option>
                        <option value="SHORT"
                            {{ (isset($trade) && $trade) ? ($trade->tf5m_macd === 'SHORT' ? 'selected' : '') : ''}}>Short</option>
                    </select>
                </div>
                <div>
                    Bollinger Band 
                </div> 
                <div>
                    <select name="tf5m_bl"
                        value="{{ isset($trade) && $trade ? $trade->tf5m_bl : 'NONE'}}">
                        <option value="NONE"
                            {{ (isset($trade) && $trade) ? ($trade->tf5m_bl === 'NONE' ? 'selected' : '') : ''}}>Tidak Digunakan</option>
                        <option value="LONG"
                            {{ (isset($trade) && $trade) ? ($trade->tf5m_bl === 'LONG' ? 'selected' : '') : ''}}>Long</option>
                        <option value="SHORT"
                            {{ (isset($trade) && $trade) ? ($trade->tf5m_bl === 'SHORT' ? 'selected' : '') : ''}}>Short</option>
                    </select>
                </div>
                <div>
                    Rsi 
                </div> 
                <div>
                    <select name="tf5m_rsi"
                        value="{{ isset($trade) && $trade ? $trade->tf5m_rsi : 'NONE'}}">
                        <option value="NONE"
                            {{ (isset($trade) && $trade) ? ($trade->tf5m_rsi === 'NONE' ? 'selected' : '') : ''}}>Tidak Digunakan</option>
                        <option value="LONG"
                            {{ (isset($trade) && $trade) ? ($trade->tf5m_rsi === 'LONG' ? 'selected' : '') : ''}}>Long</option>
                        <option value="SHORT"
                            {{ (isset($trade) && $trade) ? ($trade->tf5m_rsi === 'SHORT' ? 'selected' : '') : ''}}>Short</option>
                    </select>
                </div>
            </div>

            <div>
                Aksi <br/>
                <select name="action">
                    <option value="NONE"
                        {{ (isset($trade) && $trade) ? ($trade->action === 'NONE' ? 'selected' : '') : ''}}>Tidak Ada</option>
                    <option value="LONG"
                        {{ (isset($trade) && $trade) ? ($trade->action === 'LONG' ? 'selected' : '') : ''}}>Long</option>
                    <option value="SHORT"
                        {{ (isset($trade) && $trade) ? ($trade->action === 'SHORT' ? 'selected' : '') : ''}}>Short</option>
                </select>
            </div>
            
            <div>
                Keterangan Awal <br/>
                <textarea
                    name="start_description">{{ isset($trade) && $trade ? $trade->start_description : ''}}</textarea>
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
                    <option value="NONE"
                        {{ (isset($trade) && $trade) ? ($trade->result === 'NONE' ? 'selected' : '') : ''}}>Tidak Ada</option>
                    <option value="LOSS"
                        {{ (isset($trade) && $trade) ? ($trade->result === 'LOSS' ? 'selected' : '') : ''}}>Kalah</option>
                    <option value="WIN"
                        {{ (isset($trade) && $trade) ? ($trade->result === 'WIN' ? 'selected' : '') : ''}}>Menang</option>
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
                    name="last_description">{{ isset($trade) && $trade ? $trade->last_description : ''}}</textarea>
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