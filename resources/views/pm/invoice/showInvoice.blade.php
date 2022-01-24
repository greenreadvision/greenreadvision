@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-center">
    <div class="col-lg-11">
        <div class="card border-0 shadow">
            <div class="card-body ">
                @if($data['invoice']['status'] == 'delete')
                <div style="position: absolute;width:100%;height:100%;display:flex;justify-content:center;align-items:center" >
                    <img style="width:70%" src="{{ URL::asset('gif/cancelled.png') }}" alt=""/>
                </div>
                @endif
                <div class="mb-3">
                    <div class="col-lg-12 d-flex justify-content-end">

                        <div class="col-lg-4 d-flex align-items-center justify-content-end">
                            @if ($data['invoice']['status'] == 'waiting')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>第一階段審核中</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-danger' role='progressbar' style='width: 0%' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif ($data['invoice']['status'] == 'waiting-fix')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>請款被撤回，請修改</small>
                                </div>
                                <div class='progress w-100' data-toggle='tooltip' data-placement='top' title='修改中'>
                                    <div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>

                            @elseif ($data['invoice']['status'] == 'check')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    @if(strpos(URL::full(),'other'))
                                        @if($data['invoice']['type'] =='other')
                                            @if($data['invoice']['price'] >=3000 && $data['invoice']['price'] < 10000) 
                                                <small>第二階段審核中 (1.列印紙本 2.主管簽名)</small>
                                            @elseif($data['invoice']['price'] >=10000)
                                                <small>第二階段審核中 (1.列印紙本 2.老闆簽名)</small>
                                            @else
                                                <small>第二階段審核中</small>
                                            @endif
                                        @else
                                            <small>第二階段審核中</small>
                                        @endif
                                    @else
                                        @if($data['invoice']['price'] >=3000 && $data['invoice']['price'] < 10000) 
                                            <small>第二階段審核中 (1.列印紙本 2.主管簽名)</small>
                                        @elseif($data['invoice']['price'] >=10000)
                                            <small>第二階段審核中 (1.列印紙本 2.老闆簽名)</small>
                                        @else
                                            <small>第二階段審核中</small>
                                        @endif
                                    @endif

                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-danger' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif ($data['invoice']['status'] == 'check-fix')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>請款被撤回，請修改</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>

                            @elseif ($data['invoice']['status'] == 'managed')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>請款中</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-warning' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif ($data['invoice']['status'] == 'matched')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>匯款中</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-success' role='progressbar' style='width: 75%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif ($data['invoice']['status'] == 'complete')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>匯款完成</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-info' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif($data['invoice']['status'] == 'complete_petty')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>零用金給付完成</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-info' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif($data['invoice']['status'] == 'delete')
                            <div class="w-100">
                                <div class="w-100" style="display: flex;justify-content: flex-end;">
                                    <span>已註銷，無法使用</span>
                                </div>
                            </div>
                            @endif
                        </div>
                        @if ($data['invoice']['status'] != 'waiting' && $data['invoice']['status'] != 'delete')
                        <button type="button" id="print_button" class="btn btn-blue rounded-pill"><span class="mx-2">列印</span></button>
                        @endif
                        @if($data['invoice']['status'] == 'delete')
                            <button class="ml-2 btn btn-gray rounded-pill"><span class="mx-2"> 無法{{__('customize.Edit')}}</span></button>
                        @elseif(\Auth::user()->user_id==$data['invoice']['user_id']||\Auth::user()->role=='administrator')
                            @if(strpos(URL::full(),'other'))
                            <button class="ml-2 btn btn-green rounded-pill" onclick="location.href='{{route('invoice.edit.other', $data['invoice']['other_invoice_id'])}}'"><span class="mx-2"> {{__('customize.Edit')}}</span></button>
                            @else
                            <button class="ml-2 btn btn-green rounded-pill" onclick="location.href='{{route('invoice.edit', $data['invoice']['invoice_id'])}}'"><span class="mx-2"> {{__('customize.Edit')}}</span></button>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="mb-3" id="print_box" name="print_box">
                    <!--print_start min-width:1043px;min-height:485px;-->
                    <div style="padding:2cm 2cm;text-align:center;color:black;font-size:1rem;font-family: DFKai-sb,Times New Roman,STKaiti;">
                        <div class="col-md-12" style="text-align:right   ;"><label>{{__('customize.id')}} : {{$data['invoice']['finished_id']}}</label></div>
                        <div class="col-md-12" style="text-align:right   ;">
                            <label>採購單號 :
                                @if($data['purchase'] == '')
                                {{$data['invoice']['purchase_id']}}
                                @else
                                <a style="text-decoration:none;color:black" target='_blank' href="{{ $data['purchase'] != '' ? route('purchase.review',$data['purchase']) : '' }}">{{$data['invoice']['purchase_id']}}</a>
                                @endif
                            </label>
                        </div>
                        <div class="col-md-12" style="text-align:right   ;">
                            <label>出差報告表單號：
                                @foreach ($data['businessTrips'] as $item)
                                <a style="text-decoration:none;color:black" target='_blank' href="{{route('businessTrip.show',$item['businessTrip_id'])}}">{{$item['final_id']}}</a></br>
                                @endforeach
                            </label>
                        </div>
                        <div class="col-md-12 table-style" style="text-align:center;">
                            @if($data['invoice']['company_name']=='grv')
                            <img src="{{ URL::asset('img/綠雷德LOGO.png') }}" height="50px">
                            <label style="font-size:xx-large;">綠雷德文創股份有限公司</label>
                            @elseif($data['invoice']['company_name']=='rv')
                            <img src="{{ URL::asset('img/rv_logo.png') }}" height="50px">
                            <label style="font-size:xx-large;">閱野文創股份有限公司</label>
                            @elseif($data['invoice']['company_name']=='grv_2')
                            <img src="{{ URL::asset('img/綠雷德創新logo.png') }}" height="50px">
                            <label style="font-size:xx-large;">綠雷德創新股份有限公司</label>
                            @endif

                            <h3 class="mb-2">請款申請書</h3>

                            <table class="table border border-dark">
                                <tbody>
                                    <tr class="border border-dark">
                                        <th width="10%" class="align-middle text-center border border-dark " style="white-space:nowrap;">請款日期</th>
                                        <td style="font-size: 16px" width="40%" class="border border-dark align-middle text-left">{{$data['invoice']['created_at']->format('Y-m-d')}}</td>
                                        <th width="10%" class="border border-dark align-middle text-center" style="white-space:nowrap;">請款金額</th>
                                        <td style="font-size: 16px" width="40%" class="border border-dark align-middle text-left">
                                            {{number_format($data['invoice']['price'])}}</td>
                                    </tr>
                                    <tr>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">請款項目</th>
                                        <td style="font-size: 16px" class="border border-dark align-middle text-left" style="white-space: pre-line;">{{$data['invoice']['title']}}</td>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">請款廠商</th>
                                        <td style="font-size: 16px" class="border border-dark align-middle text-left">{{$data['invoice']['company']}}</td>
                                    </tr>
                                    <tr>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">請款事項</th>
                                        <td style="font-size: 16px" colspan="3" class="border border-dark text-left" style="word-break: break-all;">
                                            {{$data['invoice']['content']}}
                                            @if($data['invoice']['status']=='complete_petty')
                                            <img height="40px" src="{{ URL::asset('img/零用金給付.png') }}" alt=""/>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">銀行帳戶</th>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">銀行名稱：</b></label><label style="font-size: 16px">{{$data['invoice']['bank']}}</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">分行：</b></label><label style="font-size: 16px">{{$data['invoice']['bank_branch']}}</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">帳號：</b></label><label style="font-size: 16px">{{$data['invoice']['bank_account_number']}}</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">戶名：</b></label><label style="font-size: 16px">{{$data['invoice']['bank_account_name']}}</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-11 row" style="margin: auto;">
                            @if ($data['invoice']['receipt'])
                            <div class="col-md-8" style="text-align:left;"><label>附{{__('customize.receipt')}}：有</label></div>
                            @else
                            <div class="col-md-8" style="text-align:left;"><label>附{{__('customize.receipt')}}：沒有，{{$data['invoice']['receipt_date']}}補上</label></div>
                            @endif
                        </div>
                        <div class="col-md-12 row" style="margin: auto; display:flex">
                            <div style="width:30%;text-align:left;"><label>匯款日期：</label><u>　{{$data['invoice']['status']=='complete'? $data['invoice']['remittance_date']:'　　'}}　.</u></div>
                            <div style="width:25%;text-align:left;"><label>帳務處理：</label><u>　{{$data['invoice']['status']=='complete'? $data['invoice']['matched']:'　　'}}　.</u></div>
                            <div style="width:25%;text-align:left;"><label>主管審核：</label><u>　{{$data['invoice']['status']!='waiting'? $data['invoice']['managed']:$data['invoice']['managed']}}　.</u></div>
                            <div style="width:20%;text-align:left;"><label>請款人：</label><u>　{{$data['invoice']->user->name}}　.</u></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-3 d-flex justify-content-center">
                    <div>
                        @if (is_array($data['invoice']['receipt_file']))
                        <a class="btn btn-blue rounded-pill" href="{{route('invoicedownload', $data['invoice']['receipt_file'])}}">發票影本</a>
                        @endif
                        @if (is_array($data['invoice']['detail_file']))
                        <a class="btn btn-blue rounded-pill ml-2" href="{{route('invoicedownload', $data['invoice']['detail_file'])}}">費用明細表</a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-12 d-flex justify-content-between">
                    <!-- waiting -->
                    @if($data['invoice']['status']=='waiting'&&(\Auth::user()->role=='administrator'))
                    <div class="col-lg-8 p-0" style="text-align:center;">
                        @if(strpos(URL::full(),'other'))
                        <form action="../withdraw/other" method="POST">
                            @else
                            <form action="withdraw" method="POST">
                                @endif
                                @csrf
                                <div class="form-row align-items-center">
                                    <div class="col-lg-6 my-1">
                                        <input autocomplete="off" type="text" class="rounded-pill form-control" name="reason" placeholder="原因" required>
                                    </div>
                                    <div class="float-left">
                                        <button type="submit" class="btn btn-red rounded-pill">撤回</button>
                                    </div>
                                </div>
                            </form>
                    </div>

                        @if(strpos(URL::full(),'other'))
                        <form action="../match/other" method="POST">
                            @else
                            <form action="match" method="POST">
                                @endif
                                @csrf
                                <!-- <input type="text" name="finished_id" class="form-control" placeholder="@lang('customize.finished_id')" required> -->
                                <button type="submit" class="btn btn-green rounded-pill"><span class="mx-2">第一階段審核</span></button>
                            </form>

                        <!-- waiting -->
                        <!-- check -->
                    @elseif($data['invoice']['status']=='check'&&($data['invoice']['reviewer'] == \Auth::user()->user_id||($data['invoice']['reviewer']==''&&((\Auth::user()->role=='administrator')||($data['invoice']['price'] >= 10000&&\Auth::user()->role=='proprietor')||($data['invoice']['price'] >= 3000&&$data['invoice']['price'] < 10000&&\Auth::user()->role=='supervisor')))))
                        <div class="col-lg-8 p-0" style="text-align:center;">
                            @if(strpos(URL::full(),'other'))
                            <form action="../withdraw/other" method="POST">
                            @else
                            <form action="withdraw" method="POST">
                                @endif
                                @csrf
                                <div class="form-row align-items-center">
                                    <div class="col-lg-6 ">
                                        <input autocomplete="off" type="text" class="rounded-pill form-control" name="reason" placeholder="原因" required>
                                    </div>
                                    <button type="submit" class="btn btn-red rounded-pill">撤回</button>
                                </div>
                            </form>
                        </div>

                        @if(strpos(URL::full(),'other'))
                        <form action="../match/other" method="POST" class="d-flex justify-content-between ">
                        @else
                        <form action="match" method="POST" class="d-flex justify-content-between">
                        @endif

                            @csrf
                            <button type="submit" class="btn btn-green rounded-pill"><span class="mx-2">第二階段審核</span></button>
                        </form>


                    @elseif($data['invoice']['status']=='managed'&&(\Auth::user()->role=='administrator'||(\Auth::user()->role=='proprietor')))
                    <div class="w-100">
                        @if(strpos(URL::full(),'other'))
                        <form action="../match/other" method="POST" class="d-flex justify-content-end">
                            @else
                            <form action="match" method="POST" class="d-flex justify-content-end">
                                @endif

                                @csrf
                                <button type="submit" class="btn btn-green rounded-pill"><span class="mx-2">請款審核</span></button>
                            </form>
                    </div>
                    @elseif($data['invoice']['status']=='matched'&&(\Auth::user()->role=='administrator'||(\Auth::user()->role=='proprietor')))
                    <div class="w-100">
                        @if(strpos(URL::full(),'other'))
                        <form action="../match/other" method="POST" class="d-flex justify-content-end">
                            @else
                            <form action="match" method="POST" class="d-flex justify-content-end">
                                @endif

                                @csrf
                                <div class="row" style="display: flex;justify-content: space-around;">
                                    <div class="form-group">
                                        <input type="date" class="rounded-pill form-control" id="matched_date" name="matched_date" />
                                    </div>
                                    <div class="form-group">
                                        <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                            <input type="text" id="radio_type" name='radio_type' value="remittance"  hidden/>
                                            <label class="btn btn-secondary active w-50" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px">
                                                <input type="radio" name="options" onchange="setMatchType(0)" autocomplete="off" checked> 匯款
                                            </label>
                                            <label class="btn btn-secondary w-50" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">
                                                <input type="radio" name="options" onchange="setMatchType(1)" autocomplete="off"> 零用金
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-green rounded-pill">匯款審核</button>
                                    </div>
                                </div>
                                
                            </form>
                    </div>
                    @endif

                </div>
            </div>
        </div>



    </div>
</div>


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

    function setMatchType(val){
        radio_type = document.getElementById('radio_type');
        if(val ==0){    //匯款
            radio_type.value = 'remittance'
        }
        else if(val == 1){  //零用金
            radio_type.value = 'pettyCash'
        }
        console.log(radio_type.value)
    }
</script>
@stop