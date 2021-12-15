@extends('layouts.app') 
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12 col-xl-10">
            <div class="card" style="margin: 10px 0px;">
                <div class="card-header">
                    <h4>{{__('customize.Invoice')}}</h4>
                </div>
                <div class="card-body">
                    <div id="print_box" name="print_box">
                        <!--print_start-->
                        <div class="col-md-12" style="text-align:center;">
                            <img src="{{ URL::asset('img/logo_Big.png') }}" height="50px">
                            <label style="font-size:xx-large;">綠雷德文創股份有限公司</label>
                            <h3>請款申請書</h3>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="align-middle text-center">請款日期</th>
                                        <td class="align-middle text-center">{{$data['created_at']->format('Y-m-d')}}</td>
                                        <th class="align-middle text-center">請款金額</th>
                                        <td class="align-middle text-center">{{$data['price']}}</td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle text-center">請款事項</th>
                                        <td class="align-middle text-center" style="white-space: pre-line;">{{$data['content']}}</td>
                                        <th class="align-middle text-center">請款廠商</th>
                                        <td class="align-middle text-center">{{$data['company']}}</td>
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
                            <div class="col-md-4" style="text-align:left;"><label>勞務單：{{$data['remuneration']}}</label></div>
                        </div>
                        <div class="col-md-11 row" style="margin: auto;">
                            <div class="col-md-4" style="text-align:left;"><label>帳務處理：</label><u>　{{$data['status']!='waiting'? $data['matched']:'　　'}}　.</u></div>
                            <div class="col-md-4" style="text-align:left;"><label>主管審核：</label><u>　{{$data['status']=='managed'? $data['managed']:'　　'}}　.</u></div>
                            <div class="col-md-4" style="text-align:left;"><label>請款人　：</label><u>　{{$data->user->name}}　.</u></div>
                        </div>
                    </div>
                    <!--print_end-->
                    <hr>
                    @if($data['status']=='waiting'&&\Auth::user()->user_id==$data['user_id'])
                        <div style="float: left;">
                            <button type="submit" class="btn btn-primary mr-2" onclick="location.href='{{route('invoice.edit', $data['invoice_id'])}}'">{{__('customize.Edit')}}</button>
                        </div>
                    @endif
                    @if($data['status']=='waiting'&&\Auth::user()->role=='accountant')
                        <div class="float-left">
                            <button type="submit" class="btn btn-primary" onclick="location.href='{{route('invoice.match', $data['invoice_id'])}}'">{{__('customize.Match')}}</button>
                        </div>
                    @elseif($data['status']=='matched'&&\Auth::user()->role=='manager')
                        <div class="float-left">
                            <button type="submit" class="btn btn-primary" onclick="location.href='{{route('invoice.match', $data['invoice_id'])}}'">{{__('customize.Permit')}}</button>
                        </div>
                    @endif
                    <div style="float: right;">
                        <button type="button" id="print_button" class="btn btn-primary">{{__('customize.Print')}}</button>
                    </div>
                    <div style="float: center; text-align:center;">
                        @if (is_array($data['receipt_file']))
                            <a class="btn btn-primary" href="{{route('download', $data['receipt_file'])}}">{{__('customize.receipt_file')}}</a>
                        @endif
                        @if (is_array($data['detail_file']))
                            <a class="btn btn-primary" href="{{route('download', $data['detail_file'])}}">{{__('customize.detail_file')}}</a>
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
    $('#print_button').click(()=>{
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