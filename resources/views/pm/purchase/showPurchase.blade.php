@extends('layouts.app')
@section('content')
<div class="col-lg-12">
    <div class="row">
    <div class="col-lg-6 mb-3">
            <!-- <h2>{{__('customize.Invoice')}}</h2> -->
        </div>
        <div class="col-lg-6 mb-3">
        <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('purchase.edit', $purchase->purchase_id)}}'"><i class='fas fa-edit'></i><span class="ml-3"> {{__('customize.Edit')}}</span></button>

        </div>
    </div>
</div>

<!--print_start-->
<div id="print_box" >
    <div style="padding:2cm 3cm;text-align:center;color:black;font-size:1rem;">
        @if($purchase->company_name=='grv')
        <img src="{{ URL::asset('img/logo_Big.png') }}" height="50px">
        <label style="font-size:xx-large;">綠雷德文創股份有限公司</label>
        @else
        <img src="{{ URL::asset('img/rv_logo.png') }}" height="50px">
        <label style="font-size:xx-large;">閱野文創股份有限公司</label>
        @endif
        <h3 class="mb-3">採購單</h3>
        <table width="100%" class="mb-3">
            <tbody>
                <tr width="100%">
                    <td class="p-1" style="display:flex;justify-content: space-between;"><span>採</span><span>購</span><span>單</span><span>號 : </span></td>
                    <td width="40%" class="p-1" style="text-align: left;">{{$purchase->id}}</td>
                    <td class="p-1" style="text-align:left;display:flex;justify-content: space-between;"><span>採</span><span>購</span><span>人 :</span></td>
                    <td width="40%" class="p-1" style="text-align: left;">{{$purchase->applicant}}</td>
                </tr>
                <tr width="100%">
                    <td class="p-1" style=" text-align: left;display:flex;justify-content: space-between;"><span>專</span><span>案</span><span>名</span><span>稱 : </span></td>
                    <td width="40%" class="p-1" style=" text-align: left;">{{$purchase->project->name}}</td>
                    <td  class="p-1" style=" text-align: left;display:flex;justify-content: space-between;"><span>採</span><span>購</span><span>日</span><span>期 : </span></td>
                    <td width="40%" class="p-1" style=" text-align: left;">{{$purchase->purchase_date}}</td>

                </tr>
                <tr>
                    <td class="p-1" style="text-align:left;display:flex;justify-content: space-between;"><span>廠</span><span>商</span><span>名</span><span>稱 : </span></td>
                    <td class="p-1" style="text-align:left;">{{$purchase->company}}</td>

                    <td class="p-1" style="text-align: left;display:flex;justify-content: space-between;"><span>交</span><span>貨</span><span>日</span><span>期 : </span></td>
                    <td class="p-1" style="text-align: left;">{{$purchase->delivery_date}}</td>

                </tr>
                <tr >
                    <td class="p-1" style="text-align:left;display:flex;justify-content: space-between;"><span>聯</span><span>絡</span><span>人 : </span></td>
                    <td class="p-1" style="text-align:left;">{{$purchase->contact_person}}</td>

                    <td class="p-1" style="text-align:left;white-space:pre-line;display:flex;justify-content: space-between;"><span>送</span><span>貨</span><span>地</span><span>址 : </span></td>
                    <td rowspan="3" class="p-1" style="text-align:left;white-space:pre-line;vertical-align:top">{{$purchase->address}}</td>

                </tr>
                <tr>
                    <td class="p-1" style="text-align:left;display:flex;justify-content: space-between;"><span>電</span><span>話 : </span></td>
                    <td class="p-1" style="text-align:left;">({{substr($purchase->phone,0,2)}}){{substr($purchase->phone,2,4)}}-{{substr($purchase->phone,6,4)}}</td>

                </tr>
                <tr>
                    <td class="p-1" style="text-align:left;display:flex;justify-content: space-between;"><span>傳</span><span>真 : </span></td>
                    <td class="p-1" style="text-align:left;">({{substr($purchase->fax,0,2)}}){{substr($purchase->fax,2,4)}}-{{substr($purchase->fax,6,4)}}</td>

                </tr>
            </tbody>
        </table>
        <table class="mb-3" width="100%" border=".5px" style="height:17cm;table-layout: fixed">
            <thead>
                <tr>
                    <th width="10%">
                        項次
                    </th>
                    <th width="30%">
                        品名
                    </th>
                    <th width="10%">
                        數量
                    </th>
                    <th width="15%">
                        單價
                    </th>
                    <th width="15%">
                        金額
                    </th>
                    <th width="20%">
                        備註
                    </th>
                </tr>
            </thead>
            <tbody valign="top">
                @foreach($purchase_item as $item)
                <tr style="height:.5cm">
                    <th style="text-align:right;border-bottom:none;border-top:none;padding:0 .1cm">{{$item->no}}</th>
                    <th style="text-align:left;border-bottom:none;border-top:none;padding:0 .1cm">{{$item->content}}</th>
                    <th style="text-align:right;border-bottom:none;border-top:none;padding:0 .1cm">{{$item->quantity}}</th>
                    <th style="text-align:right;border-bottom:none;border-top:none;padding:0 .1cm">{{number_format($item->price)}}</th>
                    <th style="text-align:right;border-bottom:none;border-top:none;padding:0 .1cm">{{number_format($item->amount)}}</th>
                    <th style="text-align:left;border-bottom:none;border-top:none;padding:0 .1cm">{{$item->note}}</th>
                </tr>
                @endforeach
                <tr>
                    <th style="text-align:right;border-bottom:none;border-top:none">&nbsp;</th>
                    <th style="text-align:center;border-bottom:none;border-top:none"> 《共&nbsp;{{$i}}&nbsp;筆》 </th>
                    <th style="text-align:right;border-bottom:none;border-top:none">&nbsp;</th>
                    <th style="text-align:right;border-bottom:none;border-top:none">&nbsp;</th>
                    <th style="text-align:right;border-bottom:none;border-top:none">&nbsp;</th>
                    <th style="text-align:right;border-bottom:none;border-top:none;">&nbsp;</th>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th style="vertical-align: text-top;text-align:left;padding:0 .1cm" rowspan="3" colspan="3">備註 : <br>{{$purchase->note}}</th>
                    <th style="text-align:right;padding:0 .1cm" colspan="1">金額</th>
                    <th style="text-align:right;padding:0 .1cm" colspan="2">{{number_format($purchase->amount)}}</th>
                </tr>
                <tr>
                    <th class="test" style="text-align:right;padding:0 .1cm" colspan="1">稅額</th>
                    <th style="text-align:right;padding:0 .1cm" colspan="2">{{number_format($purchase->tex)}}</th>
                </tr>
                <tr>
                    <th style="text-align:right;padding:0 .1cm" colspan="1">總金額</th>
                    <th style="text-align:right;padding:0 .1cm" colspan="2">{{number_format($purchase->total_amount)}}</th>
                </tr>
            </tfoot>
        </table>
        <table class="mb-3" width="100%" border=".5px">
            <tr>
                <th width="33%">採購人</th>
                <th width="33%">單位主管</th>
                <th width="33%">主管</th>
            </tr>
            <tr>
                <th style="padding:.75cm">&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
        </table>

        <table class="mb-3" width="100%" border=".5px">
            <tr>
                <th width="50%">廠商</th>
                <th width="50%">公司蓋章</th>
            </tr>
            <tr>
                <th style="padding:1cm">&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
        </table>
    </div>
</div>

<div style="float: right;">
    <button type="button" id="print_button" class="btn btn-primary btn-primary-style">{{__('customize.Print')}}</button>
</div>



@stop
@section('script')
<script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(() => {
        $('#print_button').click(() => {
            let html = document.getElementById('print_box').innerHTML
            console.log(html)
            let bodyHtml = document.body.innerHTML
            document.body.innerHTML = html
            window.print()
            document.body.innerHTML = bodyHtml
            window.location.reload() //列印輸出後更新頁面
        })
    })
</script>
@stop