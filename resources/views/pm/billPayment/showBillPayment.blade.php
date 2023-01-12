@extends('layouts.app')
@section('content')
<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <span class="page_title_span">款項管理</span>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a  href="/billPayment" class="page_title_a" >繳款單</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <span class="page_title_span">{{$data['billPayment']['finished_id']}}</span>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center" >
    <div class="col-lg-11">
        <div class="card border-0 shadow">
            <div class="card-body ">
                @if($data['billPayment']['status'] == 'delete')
                <div style="position: absolute;width:100%;height:100%;display:flex;justify-content:center;align-items:center;z-index:1;" >
                    <img style="width:70%" src="{{ URL::asset('gif/cancelled.png') }}" alt=""/>
                </div>
                @endif
                <div class="mb-3">
                    <div class="col-lg-12 d-flex justify-content-end">

                        <div class="col-lg-4 d-flex align-items-center justify-content-end">
                            @if ($data['billPayment']['status'] == 'waiting')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>待審核</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-danger' role='progressbar' style='width: 0%' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif ($data['billPayment']['status'] == 'waiting-fix')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>繳款被撤回，請修改</small>
                                </div>
                                <div class='progress w-100' data-toggle='tooltip' data-placement='top' title='修改中'>
                                    <div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>

                            @elseif ($data['billPayment']['status'] == 'managed')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>已審核</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-success' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif($data['billPayment']['status'] == 'delete')
                            <div class="w-100">
                                <div class="w-100" style="display: flex;justify-content: flex-end;">
                                    <span>已註銷，無法使用</span>
                                </div>
                            </div>
                            @endif
                        </div>
                        @if ($data['billPayment']['status'] != 'waiting' && $data['billPayment']['status'] != 'delete')
                        <button type="button" id="print_button" class="btn btn-blue rounded-pill"><span class="mx-2">列印</span></button>
                        @endif
                        @if($data['billPayment']['status'] == 'delete')
                            <button class="ml-2 btn btn-gray rounded-pill"><span class="mx-2"> 無法{{__('customize.Edit')}}</span></button>
                        @elseif(\Auth::user()->user_id==$data['billPayment']['user_id']||\Auth::user()->role=='administrator'|| \Auth::user()->role =='manager')
                            @if(strpos(URL::full(),'other'))
                            <button class="ml-2 btn btn-green rounded-pill" onclick="location.href='{{route('billPayment.edit.other', $data['billPayment']['other_payment_id'])}}'"><span class="mx-2"> {{__('customize.Edit')}}</span></button>
                            @else
                                @if($data['billPayment']['status'] != 'managed')
                                <button class="ml-2 btn btn-green rounded-pill" onclick="location.href='{{route('billPayment.edit', $data['billPayment']['payment_id'])}}'"><span class="mx-2"> {{__('customize.Edit')}}</span></button>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
                <div class="mb-3" id="print_box" name="print_box">
                    <!--print_start min-width:1043px;min-height:485px;-->
                    <div style="padding:2cm 2cm;text-align:center;color:black;font-size:1rem;font-family: DFKai-sb,Times New Roman,STKaiti;">
                        <div class="col-md-12" style="text-align:right   ;"><label>{{__('customize.id')}} : {{$data['billPayment']['finished_id']}}</label></div>
                        <div class="col-md-12 table-style" style="text-align:center;">
                            @if($data['billPayment']['company_name']=='grv')
                            <img src="{{ URL::asset('img/綠雷德LOGO.png') }}" height="50px">
                            <label style="font-size:xx-large;">綠雷德文創股份有限公司</label>
                            @elseif($data['billPayment']['company_name']=='rv')
                            <img src="{{ URL::asset('img/rv_logo.png') }}" height="50px">
                            <label style="font-size:xx-large;">閱野文創股份有限公司</label>
                            @elseif($data['billPayment']['company_name']=='grv_2')
                            <img src="{{ URL::asset('img/綠雷德創新logo.png') }}" height="50px">
                            <label style="font-size:xx-large;">綠雷德創新股份有限公司</label>
                            @endif

                            <h3 class="mb-2">繳款確認書</h3>

                            <table class="table border border-dark">
                                <tbody>
                                    <tr class="border border-dark">
                                        <th width="10%" class="align-middle text-center border border-dark " style="white-space:nowrap;">繳款日期</th>
                                        <td style="font-size: 16px" width="40%" class="border border-dark align-middle text-left">{{$data['billPayment']['receipt_date']}}</td>
                                        <th width="10%" class="border border-dark align-middle text-center" style="white-space:nowrap;">繳款金額</th>
                                        <td style="font-size: 16px" width="40%" class="border border-dark align-middle text-left">
                                            {{number_format($data['billPayment']['price'])}}</td>
                                    </tr>
                                    @if(strpos(URL::full(),'other'))
                                    <tr>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">繳款類別</th>
                                        <td style="font-size: 16px" class="border border-dark align-middle text-left" style="white-space: pre-line;">其他類</td>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">繳款類型</th>
                                        <td style="font-size: 16px" class="border border-dark align-middle text-left">{{__('customize.'.$data['billPayment']['type'])}}</td>
                                    </tr>
                                    @else
                                    <tr>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">繳款類別</th>
                                        <td style="font-size: 16px" class="border border-dark align-middle text-left" style="white-space: pre-line;">專案類</td>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">繳款專案</th>
                                        <td style="font-size: 16px" class="border border-dark align-middle text-left">{{$data['billPayment']['project']['name']}}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">繳款項目</th>
                                        <td style="font-size: 16px" class="border border-dark align-middle text-left" style="white-space: pre-line;">{{$data['billPayment']['title']}}</td>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">繳款人</th>
                                        <td style="font-size: 16px" class="border border-dark align-middle text-left">{{$data['billPayment']['remittancer']}}</td>
                                    </tr>
                                    <tr>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">繳款事項</th>
                                        <td style="font-size: 16px" colspan="3" class="border border-dark text-left" style="word-break: break-all;">
                                            {{$data['billPayment']['content']}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">銀行帳戶</th>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">銀行名稱：</b></label><label style="font-size: 16px">{{$data['billPayment']['bank']}}</label>
                                                </div>
                                                @if($data['billPayment']['bank'] == "華南銀行")
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">分行：</b></label><label style="font-size: 16px">板橋分行</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">帳號：</b></label><label style="font-size: 16px">160-10-008-665-8</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">戶名：</b></label><label style="font-size: 16px">綠雷德創新股份有限公司</label>
                                                </div>
                                                @elseif($data['billPayment']['bank'] == "第一銀行")
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">分行：</b></label><label style="font-size: 16px">雙和分行</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">帳號：</b></label><label style="font-size: 16px">23510036020</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">戶名：</b></label><label style="font-size: 16px">閱野文創股份有限公司</label>
                                                </div>
                                                @elseif($data['billPayment']['bank'] == "玉山銀行")
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">分行：</b></label><label style="font-size: 16px">中和分行</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">帳號：</b></label><label style="font-size: 16px">0439-9400-03803</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">戶名：</b></label><label style="font-size: 16px">閱野文創股份有限公司</label>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-11 row" style="margin: auto;">
                            @if ($data['billPayment']['receipt'])
                            <div class="col-md-8" style="text-align:left;"><label>相關匯款證明：有</label></div>
                            @else
                            <div class="col-md-8" style="text-align:left;"><label>相關匯款證明：沒有，待補</label></div>
                            @endif
                        </div>
                        <div class="col-md-12 row" style="margin: auto; display:flex">
                            <div style="width:40%;text-align:left;"><label>審核日期：</label><u>　{{$data['billPayment']['status']=='managed'? $data['billPayment']['review_date']:'　　'}}　.</u></div>
                            <div style="width:30%;text-align:left;"><label>審核人員：</label><u>　{{$data['billPayment']['status']=='managed'? '蔡貴瑄':'　　'}}　.</u></div>
                            <div style="width:30%;text-align:left;"><label>專案負責人：</label><u>　{{$data['billPayment']->project->user->name}}　.</u></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-3 d-flex justify-content-end">
                    <div>
                        @if (is_array($data['billPayment']['receipt_file']))
                        <a class="btn btn-blue rounded-pill" href="{{route('billPaymentdownload', $data['billPayment']['receipt_file'])}}">發票影本</a>
                        @endif
                        @if (is_array($data['billPayment']['detail_file']))
                        <a class="btn btn-blue rounded-pill ml-2" href="{{route('billPaymentdownload', $data['billPayment']['detail_file'])}}">費用明細表</a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-12 d-flex justify-content-between">
                    <!-- waiting -->
                    @if($data['billPayment']['status']=='waiting'&&(\Auth::user()->role=='administrator'))
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
                        <form action="../managed/other" method="POST">
                            @else
                            <form action="managed" method="POST">
                                @endif
                                @csrf
                                <button type="submit" class="btn btn-green rounded-pill"><span class="mx-2">通過審核</span></button>
                            </form>
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
    });

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