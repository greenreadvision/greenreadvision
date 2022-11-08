@extends('layouts.app')
@section('content')
@foreach($invoices as $invoice)
<div class="modal fade" id="purchase{{$invoice->invoice_id}}Modal" tabindex="-1" role="dialog" aria-labelledby="purchase{{$invoice->invoice_id}}ModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:90%" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="col-lg-12 d-flex justify-content-end">
                        <div class="col-lg-4 d-flex align-items-center justify-content-end">
                            @if ($invoice['status'] == 'waiting')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>第一階段審核中</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-danger' role='progressbar' style='width: 0%' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif ($invoice['status'] == 'waiting-fix')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>請款被撤回，請修改</small>
                                </div>
                                <div class='progress w-100' data-toggle='tooltip' data-placement='top' title='修改中'>
                                    <div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>

                            @elseif ($invoice['status'] == 'check')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    @if($invoice['price'] >=3000 && $invoice['price'] < 10000) <small>第二階段審核中 (1.列印紙本 2.主管簽名)</small>
                                        @elseif($invoice['price'] >=10000)
                                        <small>第二階段審核中 (1.列印紙本 2.老闆簽名)</small>
                                        @else
                                        <small>第二階段審核中</small>
                                        @endif
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-danger' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif ($invoice['status'] == 'check-fix')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>請款被撤回，請修改</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>

                            @elseif ($invoice['status'] == 'managed')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>請款中</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-warning' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif ($invoice['status'] == 'matched')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>匯款中</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-success' role='progressbar' style='width: 75%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif ($invoice['status'] == 'complete')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>匯款完成</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-info' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>

                            @endif
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <!--print_start min-width:1043px;min-height:485px;-->
                    <div style="padding:2cm 2cm;text-align:center;color:black;font-size:1rem;font-family: DFKai-sb,Times New Roman,STKaiti;">
                        <div class="col-md-12" style="text-align:right   ;">
                            <label>
                                <a style="text-decoration:none;color:black" target='_blank' href="{{route('invoice.review',$invoice['invoice_id'])}}">{{__('customize.id')}} : {{$invoice['finished_id']}}</a>
                            </label>
                        </div>
                        <div class="col-md-12" style="text-align:right   ;">
                            <label>採購單號 :
                                {{$invoice['purchase_id']}}
                            </label>
                        </div>
                        <div class="col-md-12 table-style" style="text-align:center;">
                            @if($invoice['company_name']=='grv')
                            <img src="{{ URL::asset('img/綠雷德LOGO.png') }}" height="50px">
                            <label style="font-size:xx-large;">綠雷德文創股份有限公司</label>
                            @elseif($invoice['company_name']=='grv_2')
                            <img src="{{ URL::asset('img/綠雷德創新logo.png') }}" height="50px">
                            <label style="font-size:xx-large;">綠雷德創新股份有限公司</label>
                            @else
                            <img src="{{ URL::asset('img/rv_logo.png') }}" height="50px">
                            <label style="font-size:xx-large;">閱野文創股份有限公司</label>
                            @endif

                            <h3 class="mb-2">請款申請書</h3>

                            <table class="table border border-dark">
                                <tbody>
                                    <tr class="border border-dark">
                                        <th width="10%" class="align-middle text-center border border-dark " style="white-space:nowrap;">請款日期</th>
                                        <td style="font-size: 16px" width="40%" class="border border-dark align-middle text-left">{{$invoice['created_at']->format('Y-m-d')}}</td>
                                        <th width="10%" class="border border-dark align-middle text-center" style="white-space:nowrap;">請款金額</th>
                                        <td style="font-size: 16px" width="40%" class="border border-dark align-middle text-left">
                                            {{number_format($invoice['price'])}}</td>
                                    </tr>
                                    <tr>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">請款項目</th>
                                        <td style="font-size: 16px" class="border border-dark align-middle text-left" style="white-space: pre-line;">{{$invoice['title']}}</td>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">請款廠商</th>
                                        <td style="font-size: 16px" class="border border-dark align-middle text-left">{{$invoice['company']}}</td>
                                    </tr>
                                    <tr>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">請款事項</th>
                                        <td style="font-size: 16px" colspan="3" class="border border-dark text-left" style="word-break: break-all;">
                                            {{$invoice['content']}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">銀行帳戶</th>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">銀行名稱：</b></label><label style="font-size: 16px">{{$invoice['bank']}}</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">分行：</b></label><label style="font-size: 16px">{{$invoice['bank_branch']}}</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">帳號：</b></label><label style="font-size: 16px">{{$invoice['bank_account_number']}}</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">戶名：</b></label><label style="font-size: 16px">{{$invoice['bank_account_name']}}</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-11 row" style="margin: auto;">
                            @if ($invoice['receipt'])
                            <div class="col-md-8" style="text-align:left;"><label>附發票/收據：有</label></div>
                            @else
                            <div class="col-md-8" style="text-align:left;"><label>附發票/收據：沒有，{{$invoice['receipt_date']}}補上</label></div>
                            @endif
                        </div>
                        <div class="col-md-12 row" style="margin: auto; display:flex">
                            <div style="width:30%;text-align:left;"><label>匯款日期：</label><u>　{{$invoice['status']=='complete'? $invoice['remittance_date']:'　　'}}　.</u></div>
                            <div style="width:25%;text-align:left;"><label>帳務處理：</label><u>　{{$invoice['status']=='complete'? $invoice['matched']:'　　'}}　.</u></div>
                            <div style="width:25%;text-align:left;"><label>主管審核：</label><u>　{{$invoice['status']!='waiting'? $invoice['managed']:$invoice['managed']}}　.</u></div>
                            <div style="width:20%;text-align:left;"><label>請款人：</label><u>　{{$invoice->user->name}}　.</u></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-3 d-flex justify-content-center">
                    <div>
                        @if (is_array($invoice['receipt_file']))
                        <a class="btn btn-blue rounded-pill" href="{{route('download', $invoice['receipt_file'])}}">發票影本</a>
                        @endif
                        @if (is_array($invoice['detail_file']))
                        <a class="btn btn-blue rounded-pill ml-2" href="{{route('download', $invoice['detail_file'])}}">費用明細表</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@foreach($other_invoices as $other_invoice)
<div class="modal fade" id="purchase{{$other_invoice->other_invoice_id}}Modal" tabindex="-1" role="dialog" aria-labelledby="purchase{{$other_invoice->other_invoice_id}}ModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:90%" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="mb-3">
                    <div class="col-lg-12 d-flex justify-content-end">
                        <div class="col-lg-4 d-flex align-items-center justify-content-end">
                            @if ($other_invoice['status'] == 'waiting')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>第一階段審核中</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-danger' role='progressbar' style='width: 0%' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif ($other_invoice['status'] == 'waiting-fix')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>請款被撤回，請修改</small>
                                </div>
                                <div class='progress w-100' data-toggle='tooltip' data-placement='top' title='修改中'>
                                    <div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>

                            @elseif ($other_invoice['status'] == 'check')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    @if($other_invoice['price'] >=3000 && $other_invoice['price'] < 10000) <small>第二階段審核中 (1.列印紙本 2.主管簽名)</small>
                                        @elseif($other_invoice['price'] >=10000)
                                        <small>第二階段審核中 (1.列印紙本 2.老闆簽名)</small>
                                        @else
                                        <small>第二階段審核中</small>
                                        @endif
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-danger' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif ($other_invoice['status'] == 'check-fix')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>請款被撤回，請修改</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>

                            @elseif ($other_invoice['status'] == 'managed')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>請款中</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-warning' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif ($other_invoice['status'] == 'matched')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>匯款中</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-success' role='progressbar' style='width: 75%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif ($other_invoice['status'] == 'complete')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>匯款完成</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-info' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>

                            @endif
                        </div>
                    </div>
                </div>
                <div class="mb-3" >
                    <!--print_start min-width:1043px;min-height:485px;-->
                    <div style="padding:2cm 2cm;text-align:center;color:black;font-size:1rem;font-family: DFKai-sb,Times New Roman,STKaiti;">
                        <div class="col-md-12" style="text-align:right   ;">
                            <label>
                                <a style="text-decoration:none;color:black" target='_blank' href="{{route('invoice.review.other',$other_invoice['other_invoice_id'])}}">{{__('customize.id')}} : {{$other_invoice['finished_id']}}</a>
                            </label>
                        </div>
                        <div class="col-md-12" style="text-align:right   ;">
                            <label>採購單號 :
                                {{$other_invoice['purchase_id']}}
                            </label>
                        </div>
                        <div class="col-md-12 table-style" style="text-align:center;">
                            @if($other_invoice['company_name']=='grv')
                            <img src="{{ URL::asset('img/綠雷德LOGO.png') }}" height="50px">
                            <label style="font-size:xx-large;">綠雷德文創股份有限公司</label>
                            @elseif($other_invoice['company_name']=='grv_2')
                            <img src="{{ URL::asset('img/綠雷德創新logo.png') }}" height="50px">
                            <label style="font-size:xx-large;">綠雷德創新股份有限公司</label>
                            @else
                            <img src="{{ URL::asset('img/rv_logo.png') }}" height="50px">
                            <label style="font-size:xx-large;">閱野文創股份有限公司</label>
                            @endif

                            <h3 class="mb-2">請款申請書</h3>

                            <table class="table border border-dark">
                                <tbody>
                                    <tr class="border border-dark">
                                        <th width="10%" class="align-middle text-center border border-dark " style="white-space:nowrap;">請款日期</th>
                                        <td style="font-size: 16px" width="40%" class="border border-dark align-middle text-left">{{$other_invoice['created_at']->format('Y-m-d')}}</td>
                                        <th width="10%" class="border border-dark align-middle text-center" style="white-space:nowrap;">請款金額</th>
                                        <td style="font-size: 16px" width="40%" class="border border-dark align-middle text-left">
                                            {{number_format($other_invoice['price'])}}</td>
                                    </tr>
                                    <tr>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">請款項目</th>
                                        <td style="font-size: 16px" class="border border-dark align-middle text-left" style="white-space: pre-line;">{{$other_invoice['title']}}</td>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">請款廠商</th>
                                        <td style="font-size: 16px" class="border border-dark align-middle text-left">{{$other_invoice['company']}}</td>
                                    </tr>
                                    <tr>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">請款事項</th>
                                        <td style="font-size: 16px" colspan="3" class="border border-dark text-left" style="word-break: break-all;">
                                            {{$other_invoice['content']}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">銀行帳戶</th>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">銀行名稱：</b></label><label style="font-size: 16px">{{$other_invoice['bank']}}</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">分行：</b></label><label style="font-size: 16px">{{$other_invoice['bank_branch']}}</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">帳號：</b></label><label style="font-size: 16px">{{$other_invoice['bank_account_number']}}</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><b style="font-size: 16px">戶名：</b></label><label style="font-size: 16px">{{$other_invoice['bank_account_name']}}</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-11 row" style="margin: auto;">
                            @if ($other_invoice['receipt'])
                            <div class="col-md-8" style="text-align:left;"><label>附發票/收據：有</label></div>
                            @else
                            <div class="col-md-8" style="text-align:left;"><label>附發票/收據：沒有，{{$other_invoice['receipt_date']}}補上</label></div>
                            @endif
                        </div>
                        <div class="col-md-12 row" style="margin: auto; display:flex">
                            <div style="width:30%;text-align:left;"><label>匯款日期：</label><u>　{{$other_invoice['status']=='complete'? $other_invoice['remittance_date']:'　　'}}　.</u></div>
                            <div style="width:25%;text-align:left;"><label>帳務處理：</label><u>　{{$other_invoice['status']=='complete'? $other_invoice['matched']:'　　'}}　.</u></div>
                            <div style="width:25%;text-align:left;"><label>主管審核：</label><u>　{{$other_invoice['status']!='waiting'? $other_invoice['managed']:$other_invoice['managed']}}　.</u></div>
                            <div style="width:20%;text-align:left;"><label>請款人：</label><u>　{{$other_invoice->user->name}}　.</u></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-3 d-flex justify-content-center">
                    <div>
                        @if (is_array($other_invoice['receipt_file']))
                        <a class="btn btn-blue rounded-pill" href="{{route('download', $other_invoice['receipt_file'])}}">發票影本</a>
                        @endif
                        @if (is_array($other_invoice['detail_file']))
                        <a class="btn btn-blue rounded-pill ml-2" href="{{route('download', $other_invoice['detail_file'])}}">費用明細表</a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
@endforeach
<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <span class="page_title_span">款項管理</span>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a  href="/purchase" class="page_title_a" >採購單</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <span class="page_title_span">{{$purchase->id}}</span>
        </div>
    </div>
</div>
<div class="row" >
    <div class="col-lg-9">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="mb-3">
                    <div class="col-lg-12 d-flex justify-content-end">
                        <button type="button" id="print_button" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Print')}}</span></button>
                        @if(\Auth::user()->user_id==$purchase['user_id']||\Auth::user()->role == "administrator")
                        <button class="btn btn-green rounded-pill ml-2" onclick="location.href='{{route('purchase.edit', $purchase->purchase_id)}}'"><span class="mx-2"> {{__('customize.Edit')}}</span></button>
                        @endif

                    </div>
                </div>
                <div id="print_box">
                    <div style="padding:2cm 3cm;text-align:center;color:black;font-size:1rem;">
                        @if($purchase['company_name']=='grv')
                            <img src="{{ URL::asset('img/綠雷德LOGO.png') }}" height="50px">
                            <label style="font-size:xx-large;">綠雷德文創股份有限公司</label>
                            @elseif($purchase['company_name']=='grv_2')
                            <img src="{{ URL::asset('img/綠雷德創新logo.png') }}" height="50px">
                            <label style="font-size:xx-large;">綠雷德創新股份有限公司</label>
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
                                    <td class="p-1" style="text-align:left;display:flex;justify-content: space-between;"><span>採</span><span>購</span><span>項</span><span>目 :</span></td>
                                    <td width="40%" class="p-1" style="text-align: left;">{{$purchase->title}}</td>
                                </tr>
                                <tr width="100%">
                                    <td class="p-1" style=" text-align: left;display:flex;justify-content: space-between;"><span>採</span><span>購</span><span>人 : </span></td>
                                    <td width="40%" class="p-1" style=" text-align: left;">{{$purchase->applicant}}</td>
                                    <td class="p-1" style=" text-align: left;display:flex;justify-content: space-between;"><span>專</span><span>案</span><span>名</span><span>稱 : </span></td>
                                    <td width="40%" class="p-1" style=" text-align: left;">{{$purchase->project->name}}</td>

                                </tr>
                                <tr>
                                    <td class="p-1" style="text-align:left;display:flex;justify-content: space-between;"><span>採</span><span>購</span><span>日</span><span>期 : </span></td>
                                    <td class="p-1" style="text-align:left;">{{$purchase->purchase_date}}</td>

                                    <td class="p-1" style="text-align: left;display:flex;justify-content: space-between;"><span>廠</span><span>商</span><span>名</span><span>稱 : </span></td>
                                    <td class="p-1" style="text-align: left;">{{$purchase->company}}</td>

                                </tr>
                                <tr>
                                    <td class="p-1" style="text-align:left;display:flex;justify-content: space-between;"><span>交</span><span>貨</span><span>日</span><span>期 : </td>
                                    <td class="p-1" style="text-align:left;">{{$purchase->delivery_date}}</td>

                                    <td class="p-1" style="text-align:left;white-space:pre-line;display:flex;justify-content: space-between;"><span>聯</span><span>絡</span><span>人 :</span></td>
                                    <td rowspan="3" class="p-1" style="text-align:left;white-space:pre-line;vertical-align:top">{{$purchase->contact_person}}</td>

                                </tr>
                                <tr>
                                    <td class="p-1" style="text-align:left;display:flex;justify-content: space-between;"><span>送</span><span>貨</span><span>地</span><span>址 : </span></td>
                                    <td class="p-1" style="text-align:left;">{{$purchase->address}}</td>

                                </tr>
                                <tr>
                                    <td class="p-1" style="text-align:left;display:flex;justify-content: space-between;"><span>電</span><span>話 : </span></td>
                                    <td class="p-1" style="text-align:left;">{{$purchase->phone}}</td>
                                    <td class="p-1" style="text-align:left;display:flex;justify-content: space-between;"><span>傳</span><span>真 : </span></td>
                                    <td class="p-1" style="text-align:left;">
                                        @if($purchase->fax != null)
                                        {{$purchase->fax}}
                                        @endif
                                    </td>

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
                                    <th style="text-align:right;border-bottom:none;border-top:none;padding:0 .1cm">{{$item->price}}</th>
                                    <th style="text-align:right;border-bottom:none;border-top:none;padding:0 .1cm">{{$item->amount}}</th>
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
                                    <th style="text-align:right;padding:0 .1cm" colspan="2">{{$purchase->amount}}</th>
                                </tr>
                                <tr>
                                    <th class="test" style="text-align:right;padding:0 .1cm" colspan="1">稅額</th>
                                    <th style="text-align:right;padding:0 .1cm" colspan="2">{{$purchase->tex}}</th>
                                </tr>
                                <tr>
                                    <th style="text-align:right;padding:0 .1cm" colspan="1">總金額</th>
                                    <th style="text-align:right;padding:0 .1cm" colspan="2">{{$purchase->total_amount}}</th>
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
                                <th style="padding:.75cm;font-size: 20px">&nbsp;{{$purchase->applicant}}</th>
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
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card border-0 shadow ">
            <div class="table-style-invoice">
                <table id="search-invoice">
                    <tbody>
                        <tr class="text-white">
                            <th>請款人</th>
                            <th>請款單號</th>
                            <th>請款費用</th>
                        </tr>
                        @foreach($invoices as $invoice)
                        <tr class="modal-style" data-toggle="modal" data-target="#purchase{{$invoice->invoice_id}}Modal">
                            <td>{{$invoice->user->name}}</td>

                            <td>{{$invoice->finished_id}}</td>
                            <td>{{number_format($invoice->price)}}</td>
                        </tr>
                        @endforeach
                        @foreach($other_invoices as $other_invoice)
                        <tr class="modal-style" data-toggle="modal" data-target="#purchase{{$other_invoice->other_invoice_id}}Modal">
                            <td>{{$other_invoice->user->name}}</td>

                            <td>{{$other_invoice->finished_id}}</td>
                            <td>{{number_format($other_invoice->price)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!--print_start-->






@stop
@section('script')
<!-- <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script> -->
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(() => {
        $('#print_button').click(() => {
            let html = document.getElementById('print_box').innerHTML
            let bodyHtml = document.body.innerHTML
            document.body.innerHTML = html
            window.print()
            document.body.innerHTML = bodyHtml
            window.location.reload() //列印輸出後更新頁面
        })
    })

    function commafy(num) {
        num = num + "";
        var re = /(-?\d+)(\d{3})/
        while (re.test(num)) {
            num = num.replace(re, "$1,$2")
        }
        return num;
    }
</script>
@stop