@extends('layouts.app')
@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6 mb-3">
            <!-- <h2>
            @if(strpos(URL::full(),'other'))
            {{__('customize.'.$data->type)}} 
            @else
            {{$data->project->name}}
            @endif
            - {{$data['title']}}</h2> -->
        </div>
        <div class="col-lg-6 mb-3">
            @if(\Auth::user()->user_id==$data['user_id']||\Auth::user()->role=='accountant')
            @if(strpos(URL::full(),'other'))
            <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('invoice.edit.other', $data['other_invoice_id'])}}'"><i class='fas fa-edit'></i><span class="ml-3"> {{__('customize.Edit')}}</span></button>
            @else
            <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('invoice.edit', $data['invoice_id'])}}'"><i class='fas fa-edit'></i><span class="ml-3"> {{__('customize.Edit')}}</span></button>
            @endif
            @endif
        </div>
    </div>
</div>
<div class="d-flex justify-content-center" style="overflow: auto;">
    <div class="col-lg-11">
        <div class="">
            <div class="card-body ">
                <div id="print_box" name="print_box">
                    <!--print_start-->
                    <div style="text-align:center;color:black;font-size:1rem;min-width:1043px;height:485px;">
                        <div class="col-md-12" style="text-align:right   ;"><label>{{__('customize.id')}} : {{$data['finished_id']}}</label></div>
                        <div class="col-md-12" style="text-align:right   ;"><label>採購單號 : {{$data['purchase_id']}}</label></div>
                        <div class="col-md-12 table-style" style="text-align:center;">
                            @if($data['company_name']=='grv')
                            <img src="{{ URL::asset('img/logo_Big.png') }}" height="50px">
                            <label style="font-size:xx-large;">綠雷德文創股份有限公司</label>
                            @else
                            <img src="{{ URL::asset('img/rv_logo.png') }}" height="50px">
                            <label style="font-size:xx-large;">閱野文創股份有限公司</label>
                            @endif

                            <h3>請款申請書</h3>

                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="align-middle text-center">請款日期</th>
                                        <td class="align-middle text-left">{{$data['created_at']->format('Y-m-d')}}</td>
                                        <th class="align-middle text-center">請款金額</th>
                                        <td class="align-middle text-left">{{number_format($data['price'])}}</td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle text-center">請款項目</th>
                                        <td class="align-middle text-left" style="white-space: pre-line;">{{$data['title']}}</td>
                                        <th class="align-middle text-center">請款廠商</th>
                                        <td class="align-middle text-left">{{$data['company']}}</td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle text-center">請款事項</th>
                                        <td colspan="3" class="text-left">
                                        {{$data['content']}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle text-center">銀行帳戶</th>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label><b>銀行名稱：</b></label><label>{{$data['bank']}}</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label><b>分行：</b></label><label>{{$data['bank_branch']}}</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label><b>帳號：</b></label><label>{{$data['bank_account_number']}}</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label><b>戶名：</b></label><label>{{$data['bank_account_name']}}</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-11 row" style="margin: auto;">
                            @if ($data['receipt'])
                            <div class="col-md-8" style="text-align:left;"><label>附發票/收據：有</label></div>
                            @else
                            <div class="col-md-8" style="text-align:left;"><label>附發票/收據：沒有，{{$data['receipt_date']}}補上</label></div>
                            @endif
                        </div>
                        <div class="col-md-12 row" style="margin: auto; display:flex">
                            <div style="width:30%;text-align:left;"><label>匯款日期：</label><u>　{{$data['status']=='complete'? $data['remittance_date']:'　　'}}　.</u></div>
                            <div style="width:25%;text-align:left;"><label>帳務處理：</label><u>　{{$data['status']=='complete'? $data['matched']:'　　'}}　.</u></div>
                            <div style="width:25%;text-align:left;"><label>主管審核：</label><u>　{{$data['status']!='waiting'? $data['managed']:$data['managed']}}　.</u></div>
                            <div style="width:20%;text-align:left;"><label>請款人：</label><u>　{{$data->user->name}}　.</u></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($data['status']=='waiting'&&\Auth::user()->role=='accountant')
        <div class="col-lg-12 p-0" style="text-align:center;">
        @if(strpos(URL::full(),'other'))
                <form action="../withdraw/other" method="POST" class="mt-3">
                    @else
                    <form action="withdraw" method="POST" class="mt-3">
                        @endif

                        @csrf
                        <div class="form-row align-items-center">
                            <div class="col-lg-6 my-1">
                                <input autocomplete="off" type="text" class="form-control" name="reason" placeholder="原因" required>
                            </div>
                            <button type="submit" class="btn btn-danger btn-danger-style">撤回</button>
                        </div>
                    </form>
        </div>
        <div class="float-left">
            @if(strpos(URL::full(),'other'))
            <form action="../match/other" method="POST">
                @else
                <form action="match" method="POST">
                    @endif

                    @csrf
                    <!-- <input type="text" name="finished_id" class="form-control" placeholder="@lang('customize.finished_id')" required> -->
                    <button type="submit" class="btn btn-primary btn-primary-style">審核</button>
                </form>

        </div>
        @elseif($data['status']=='check'&&\Auth::user()->role=='manager')
        <div class="col-lg-12 p-0" style="text-align:center;">
        @if(strpos(URL::full(),'other'))
                <form action="../withdraw/other" method="POST" class="mt-3">
                    @else
                    <form action="withdraw" method="POST" class="mt-3">
                        @endif

                        @csrf
                        <div class="form-row align-items-center">
                            <div class="col-lg-6 my-1">
                                <input autocomplete="off" type="text" class="form-control" name="reason" placeholder="原因" required>
                            </div>
                            <button type="submit" class="btn btn-danger btn-danger-style">撤回</button>
                        </div>
                    </form>
        </div>
        <div class="float-left">
            @if(strpos(URL::full(),'other'))
            <form action="../match/other" method="POST" class="d-flex justify-content-between ">
                @else
                <form action="match" method="POST" class="d-flex justify-content-between">
                    @endif

                    @csrf
                    <button type="submit" class="btn btn-primary btn-primary-style mb-2">審核</button>
                </form>
        </div>

        @elseif($data['status']=='managed'&&\Auth::user()->role=='accountant')
        <div class="float-left">
            @if(strpos(URL::full(),'other'))
            <form action="../match/other" method="POST" class="d-flex justify-content-between">
                @else
                <form action="match" method="POST" class="d-flex justify-content-between">
                    @endif

                    @csrf
                    <button type="submit" class="btn btn-primary btn-primary-style">審核</button>
                </form>
        </div>
        @elseif($data['status']=='matched'&&\Auth::user()->role=='accountant')
        <div class="float-left">
            @if(strpos(URL::full(),'other'))
            <form action="../match/other" method="POST" class="d-flex justify-content-between">
                @else
                <form action="match" method="POST" class="d-flex justify-content-between">
                    @endif

                    @csrf
                    <button type="submit" class="btn btn-primary btn-primary-style">審核</button>
                </form>
        </div>
        @endif
        <div style="float: right;">
            <button type="button" id="print_button" class="btn btn-primary btn-primary-style">{{__('customize.Print')}}</button>
        </div>

        <div style="float: center; text-align:center;">
            @if (is_array($data['receipt_file']))
            <a class="btn btn-primary " href="{{route('download', $data['receipt_file'])}}">{{__('customize.receipt_file')}}</a>

            @endif
            @if (is_array($data['detail_file']))

            <a class="btn btn-primary " href="{{route('download', $data['detail_file'])}}">{{__('customize.detail_file')}}</a>
            @endif
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