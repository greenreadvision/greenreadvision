@extends('layouts.app')
@section('content')

<section class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body">
                <div class="col-lg-12 d-flex justify-content-between">
                    <div style="text-align: left">
                        @if($businessTrip->invoice_type == 'invoice')
                        <span style="font-size: 16pt">請款單號：<a href="/invoice/{{$businessTrip->invoice['invoice_id']}}/review" target='_blank'>{{$businessTrip->invoice['finished_id']}}</a></span></br>
                        @elseif($businessTrip->invoice_type == 'otherinvoice')
                        <span style="font-size: 16pt">請款單號：<a href="/invoice/{{$businessTrip->otherinvoice['other_invoice_id']}}/review/other" target='_blank'>{{$businessTrip->otherinvoice['finished_id']}}</a></span></br>
                        @endif
                        <span style="font-size: 16pt">報告單單號：{{$businessTrip->final_id}}</span>
                    </div>
                    <div style="text-align: right">
                        @if(\Auth::user()->user_id==$businessTrip['user_id'])
                        <button class="ml-2 btn btn-green rounded-pill" onclick="location.href='{{route('businessTrip.edit', $businessTrip->businessTrip_id)}}'"><span class="mx-2"> {{__('customize.Edit')}}</span></button>
                        @endif
                        <button type="button" id="print_button" class="btn btn-blue rounded-pill"><span class="mx-2">列印</span></button>
                    </div>
                </div>
                <hr size="8px" align="center" width="100%">
                <div id="print_box">
                    <div style="padding:2cm 2cm;text-align:center;color:black;font-size:1rem;font-family: DFKai-sb,Times New Roman,STKaiti;">
                        <div class="col-md-12" style="text-align:right   ;"><label>{{__('customize.id')}} : {{$businessTrip->final_id}}</label></div>
                        <div class="col-md-12 table-style" style="text-align:center;">
                            @if($businessTrip->invoice_type =='invoice')
                                @if($businessTrip->invoice['company_name'] == 'grv')
                                <img src="{{ URL::asset('img/綠雷德LOGO.png') }}" height="50px">
                                <label style="font-size:xx-large;">綠雷德文創股份有限公司</label>
                                @elseif($businessTrip->invoice['company_name'] == 'rv')
                                <img src="{{ URL::asset('img/rv_logo.png') }}" height="50px">
                                <label style="font-size:xx-large;">閱野文創股份有限公司</label>
                                @elseif($businessTrip->invoice['company_name'] == 'grv_2')
                                <img src="{{ URL::asset('img/綠雷德創新logo.png') }}" height="50px">
                                <label style="font-size:xx-large;">綠雷德創新股份有限公司</label>
                                @endif
                            @elseif($businessTrip->invoice_type =='otherinvoice')
                                @if($businessTrip->otherinvoice['company_name'] == 'grv')
                                <img src="{{ URL::asset('img/綠雷德LOGO.png') }}" height="50px">
                                <label style="font-size:xx-large;">綠雷德文創股份有限公司</label>
                                @elseif($businessTrip->otherinvoice['company_name'] == 'rv')
                                <img src="{{ URL::asset('img/rv_logo.png') }}" height="50px">
                                <label style="font-size:xx-large;">閱野文創股份有限公司</label>
                                @elseif($businessTrip->otherinvoice['company_name'] == 'grv_2')
                                <img src="{{ URL::asset('img/綠雷德創新logo.png') }}" height="50px">
                                <label style="font-size:xx-large;">綠雷德創新股份有限公司</label>
                                @endif
                            @endif
                            <h3 class="mb-2">出差報告表</h3>
                        <table class="mb-3" style="margin-left: auto;margin-right: auto;font-size:12pt" width="90%" >
                            <tbody>
                                <tr style="text-align:center" >
                                    <th class="px-2" colspan="25" width="100%" style="border-top: 3px double #000;border-right: 1px solid #000;border-bottom: 1px solid #000;border-left: 1px solid #000">
                                        <label  class="label-style col-form-label">出差旅費報告表</label>
                                    </th>
                                </tr>
                                <tr style="text-align:center" >
                                    <th class="px-2" colspan="25" width="100%" style="border-right: 1px solid #000;border-bottom: 1px solid #000;border-left: 1px solid #000">
                                        <label  class="label-style col-form-label">民國 {{$year}} 年 {{$month}} 月 {{$day}} 日</label>
                                    </th>
                                </tr>
                                <tr style="text-align:center" >
                                    <th class="px-2" colspan="3" rowspan="2"  width="10%" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">事由</label>
                                    </th>
                                    <th class="px-2" colspan="7" rowspan="2"  width="40%" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">{{$businessTrip->title}}</label>
                                    </th>
                                    <th class="px-2" colspan="8" width="25%" style="border: 1px solid rgb(0, 0, 0)">
                                        <label  class="label-style col-form-label">摘要</label>
                                    </th>
                                    <th class="px-2" colspan="7" width="25%" style="border: 1px solid  #000">
                                        <label  class="label-style col-form-label">金額</label>
                                    </th>
                                </tr>
                                <tr style="text-align:center" >
                                    <th class="px-2" colspan="4" rowspan="3"  style="border :1px solid #000">
                                        <label  class="label-style col-form-label">車資</label>
                                    </th>
                                    <th class="px-2" colspan="5" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">火車</label>
                                    </th>
                                    <th class="px-2" colspan="7"  style="border :1px solid #000">
                                        <label  class="label-style col-form-label">{{$businessTrip->fare_train}}</label>
                                    </th>
                                </tr>
                                <tr style="text-align:center" >
                                    <th class="px-2" rowspan="2" colspan="3" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">旅程</label>
                                    </th>
                                    <th class="px-2" rowspan="2" colspan="7" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">{{$businessTrip->content}}</label>
                                    </th>
                                    <th class="px-2" colspan="5"  style="border :1px solid #000">
                                        <label  class="label-style col-form-label">汽車</label>
                                    </th>
                                    <th class="px-2" colspan="7"  style="border :1px solid #000">
                                        <label  class="label-style col-form-label">{{$businessTrip->fare_car}}</label>
                                    </th>
                                </tr>
                                <tr style="text-align:center" >
                                    <th class="px-2" colspan="5"  style="border :1px solid #000">
                                        <label  class="label-style col-form-label">其他</label>
                                    </th>
                                    <th class="px-2" colspan="7"  style="border :1px solid #000">
                                        <label  class="label-style col-form-label">{{$businessTrip->fare_other}}</label>
                                    </th>
                                </tr>
                                <tr style="text-align:center" >
                                    <th class="px-2" colspan="3" rowspan="2" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">日期</label>
                                    </th>
                                    <th class="px-2" colspan="7" rowspan="2" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">
                                            自民國 {{substr($businessTrip->start_date,0,4)-1911}} 年 {{substr($businessTrip->start_date,5,2)}} 月 {{substr($businessTrip->start_date,8,2)}}日起</br>
                                            自民國 {{substr($businessTrip->end_date,0,4)-1911}} 年 {{substr($businessTrip->end_date,5,2)}} 月 {{substr($businessTrip->end_date,8,2)}}日止
                                        </label>
                                    </th>
                                    <th class="px-2" colspan="4" rowspan="1" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">膳費</label>
                                    </th>
                                    <th class="px-2" colspan="5" rowspan="1" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">{{$businessTrip->meal_people}} 人 {{$businessTrip->meal_day}} 天</label>
                                    </th>
                                    <th class="px-2" colspan="7" rowspan="1" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">{{$businessTrip->meal_cost}}</label>
                                    </th>
                                </tr>
                                <tr style="text-align:center" >
                                    <th class="px-2" colspan="4" rowspan="1" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">宿費</label>
                                    </th>
                                    <th class="px-2" colspan="5" rowspan="1" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">{{$businessTrip->live_people}} 人 {{$businessTrip->live_day}} 天</label>
                                    </th>
                                    <th class="px-2" colspan="7" rowspan="1" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">{{$businessTrip->live_cost}}</label>
                                    </th>
                                </tr>
                                <tr style="text-align:center" >
                                    <th class="px-2" colspan="3" rowspan="3" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">附記</label>
                                    </th>
                                    <th class="px-2" colspan="7" rowspan="3" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">{{$businessTrip->other_content}}</label>
                                    </th>
                                    <th class="px-2" colspan="4" rowspan="2" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">什費</label>
                                    </th>
                                    <th class="px-2" colspan="5" rowspan="1" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">{{$businessTrip->othercontent_1}}</label>
                                    </th>
                                    <th class="px-2" colspan="7" rowspan="1" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">{{$businessTrip->othercontent_cost_1}}</label>
                                    </th>
                                </tr>
                                <tr style="text-align:center" >
                                    <th class="px-2" colspan="5" rowspan="1" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">{{$businessTrip->othercontent_2}}</label>
                                    </th>
                                    <th class="px-2" colspan="7" rowspan="1" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">{{$businessTrip->othercontent_cost_2}}</label>
                                    </th>
                                </tr>
                                <tr style="text-align:center" >
                                    <th class="px-2" colspan="8" rowspan="1" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">合計</label>
                                    </th>
                                    <th class="px-2" colspan="7" rowspan="1" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">{{$businessTrip->cost_total}}</label>
                                    </th>
                                </tr>
                                
                            </tbody>
                            <tfoot>
                                <tr style="text-align:center" >
                                    <th class="p-2" width="17%" colspan="4" style="border-left :1px solid #000;border-bottom :1px solid #000">
                                        <label  class="label-style col-form-label">核准</label>
                                    </th>
                                    
                                    <th class="p-2" width="16%" colspan="3" style="border :1px solid #000;">
                                        <label  class="label-style col-form-label">會計/主管</label>
                                    </th>
                                    
                                    <th class="p-2" width="16%" colspan="3" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">覆核</label>
                                    </th>
                                    
                                    <th class="p-2" width="16%" colspan="5" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">出納</label>
                                    </th>
                                    
                                    <th class="p-2" width="17%" colspan="5" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">登帳</label>
                                    </th>
                                    
                                    <th class="p-2" width="17%" colspan="4" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">出差人</label>
                                    </th>
                                </tr>
                                <tr style="text-align:center" >
                                    <th class="p-2" width="17%" colspan="4" style="border-left :1px solid #000;border-bottom :1px solid #000">
                                        
                                        @if($businessTrip->invoice_type =='invoice')
                                            @if($businessTrip->invoice['matched'] != null)
                                            <label  class="label-style col-form-label">{{$businessTrip->invoice['matched']}} </label>
                                            @endif
                                        @elseif($businessTrip->invoice_type =='otherinvoice')
                                        @if($businessTrip->otherinvoice['matched'] != null)
                                        <label  class="label-style col-form-label">{{$businessTrip->otherinvoice['matched']}} </label>
                                        @endif
                                        @endif
                                    </th>
                                    
                                    <th class="p-2" width="16%" colspan="3" style="border :1px solid #000;">
                                        <label  class="label-style col-form-label">{{$reviewer->name}}({{$reviewer->nickname}})</label>
                                    </th>
                                    
                                    <th class="p-2" width="16%" colspan="3" style="border :1px solid #000">
                                        @if($businessTrip->invoice_type =='invoice')
                                            @if($businessTrip->invoice['managed'] != null)
                                            <label  class="label-style col-form-label">{{$businessTrip->invoice['managed']}} </label>
                                            @endif
                                        @elseif($businessTrip->invoice_type =='otherinvoice')
                                            @if($businessTrip->otherinvoice['managed'] != null)
                                            <label  class="label-style col-form-label">{{$businessTrip->otherinvoice['managed']}} </label>
                                            @endif
                                        @endif
                                    </th>
                                    
                                    <th class="p-2" width="16%" colspan="5" style="border :1px solid #000">
                                        @if($businessTrip->invoice_type =='invoice')
                                            @if($businessTrip->invoice['status'] == "matched" || $businessTrip->invoice['status'] == "complete")
                                            <label  class="label-style col-form-label">{{$businessTrip->invoice['managed']}} </label>
                                            @endif
                                        @elseif($businessTrip->invoice_type =='otherinvoice')
                                            @if($businessTrip->otherinvoice['status'] == "matched" || $businessTrip->otherinvoice['status'] == "complete")
                                            <label  class="label-style col-form-label">{{$businessTrip->otherinvoice['managed']}} </label>
                                            @endif
                                        @endif
                                        
                                    </th>
                                    
                                    <th class="p-2" width="17%" colspan="5" style="border :1px solid #000">
                                        @if($businessTrip->invoice_type =='invoice')
                                            @if($businessTrip->invoice['status'] == "complete")
                                            <label  class="label-style col-form-label">{{$businessTrip->invoice['managed']}} </label>
                                            @endif
                                        @elseif($businessTrip->invoice_type =='otherinvoice')
                                            @if( $businessTrip->otherinvoice['status'] == "complete")
                                            <label  class="label-style col-form-label">{{$businessTrip->otherinvoice['managed']}} </label>
                                            @endif
                                        @endif
                                    </th>
                                    
                                    <th class="p-2" width="17%" colspan="4" style="border :1px solid #000">
                                        <label  class="label-style col-form-label">{{$businessTrip->user['name']}}({{$businessTrip->user['nickname']}})</label>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>               
            </div>
        </div>
    </div>
</section>

@stop
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(() => {
        $('#print_button').click(() => {
            let html = document.all['print_box'].innerHTML

            let bodyHtml = document.body.innerHTML
            document.body.innerHTML = html
            window.print()
            document.body.innerHTML = bodyHtml
            window.location.reload() //列印輸出後更新頁面
        })
    })
</script>
@stop