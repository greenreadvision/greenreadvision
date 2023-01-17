@extends('layouts.app')
@section('content')

<div class="modal fade" id="transfer" tabindex="-1" role="dialog" aria-labelledby="transfer" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <label for="transfer" style="font-size: 20px;font-weight: bolder">確定與{{$data->user->nickname}}交接{{$data->name}}此專案嗎？</label>
                <form action="{{route('project.receive',[$data->project_id,'agree'])}}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-footer justify-content-center border-0">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#refuse">拒絕</button>
                        <button type="submit" class="btn btn-primary">同意</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="refuse" tabindex="-1" role="dialog" aria-labelledby="refuse" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('project.receive',[$data->project_id,'refuse'])}}" method="POST" class="mb-3">
                @method('PUT')
                @csrf
                <div class="modal-body text-center col-12">
                    <label for="refuse" style="font-size: 20px;font-weight: bolder">請填寫拒絕原因</label>
                    <textarea style="resize:none;" class="form-control rounded-pill"  name="refuse_content" id="refuse_content" rows="3" required></textarea>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary">送出</button>
                </div>
            </form>    
        </div>
    </div>
</div>

<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <span class="page_title_span">公司文案</span>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a  href="/project" class="page_title_a" >專案管理</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <span class="page_title_span">{{$data->name}}</span>
        </div>
    </div>
</div>
<div class="col-lg-12" >
    <div class="row">
        <div class="col-lg-8 mb-3 d-flex">
            <h2>
                <span style="background:{{$data->color}}">&nbsp;</span>&nbsp;({{__('customize.'.$data->company_name)}})&nbsp;{{$data->name}}
            </h2>
            @if($data->status=='unacceptable')
            <div class="d-flex align-items-center ml-3">
                <h2 style="color:rgb(255, 136, 0)">專案未得標</h2>
            </div>
            @elseif($data->status=='running')
            <div class="d-flex align-items-center ml-3">
                <h2 style="color:rgb(5, 161, 0)">專案執行中</h2>
            </div>
            @elseif($data->status=='close')
            <div class="d-flex align-items-center ml-3">
                <h2 style="color:rgb(255, 0, 0)">專案已結案</h2>
            </div>
            @endif
        </div>
        <div class="col-lg-4 mb-3">
            @if(\Auth::user()->user_id==$data['user_id'] ||\Auth::user()->role == 'manager' || \Auth::user()->user_id==$data['agent_id'])
            <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('project.edit', $data->project_id)}}'"><i class='fas fa-edit'></i><span class="ml-3"> {{__('customize.Edit')}}</span></button>
            @endif
            @if(\Auth::user()->user_id == $data['receiver'])
            <button class="float-right btn btn-primary btn-primary-style" data-toggle="modal" data-target="#transfer"><span> 轉讓確認</span></button>
            @endif
        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-6" >
                    <div class="card card-style"> 
                        <div class="px-3">
                            <div class="card-header bg-white">
                                <i class='fas fa-user-circle' style="font-size:1.5rem;"></i><label class="ml-2 col-form-label ">{{__('customize.User')}}</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-center"><label class="content-label-style col-form-label" style="text-align: center">{{$data->user->name}}({{$data->user->nickname}})</label></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" >
                    <div class="card card-style"> 
                        <div class="px-3">
                            <div class="card-header bg-white">
                                <i class='fas fa-user-circle' style="font-size:1.5rem;"></i><label class="ml-2 col-form-label ">{{__('customize.Agent')}}{{$data->agent_type == 'teacher'?'(導師)':'(協辦者)'}}</label>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($data->agent_id !=null)
                            <div class="d-flex justify-content-center"><label class="content-label-style col-form-label" style="text-align: center">{{$data->agent->name}}({{$data->agent->nickname}})</label></div>
                            @else
                            <div class="d-flex justify-content-center"><label class="content-label-style col-form-label" style="text-align: center">-無代理人-</label></div>
                            @endif
                        
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" {{$data->status == 'unacceptable'? 'hidden' : ''}}>
                    <div class="card card-style">   
                        <div class="px-3">
                            <div class="card-header bg-white">
                                <i class='fas fa-check-circle' style="font-size:1.5rem;"></i><label class="ml-2 col-form-label">{{__('customize.case_num')}}</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <label class="content-label-style col-form-label">{{$data->case_num==null? '-未填寫-': $data->case_num}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-style col-lg-12">
                <div class="px-3">
                    <div class="card-header bg-white">
                        <i class='fas fa-book-open' style="font-size:1.5rem;"></i><label class="ml-2 col-form-label ">專案備註</label>
                    </div>
                </div>
                <div class="card-body">
                    <p class="content-label-style col-form-label" id= 'project_note'>{{$data->project_note==null? '-未填寫-': $data->project_note}}</p>
                </div>
            </div>
            <div class="card card-style" {{$data->status == 'unacceptable'? 'hidden' : ''}}>
                <div class="px-3">
                    <div class="card-header bg-white">
                        <i class='fas fa-user-circle' style="font-size:1.5rem;"></i><label class="ml-2 col-form-label ">{{__('customize.project_sop')}}</label>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($data->projectSOP as $item)
                        <table style="border:none;">
                            <thead  >
                                <tr style="opacity: 0;">
                                    <th style="width:10%;border:none;"></th>
                                    <th style="width:40%;border:none;"></th>
                                    <th style="width:30%;border:none;"></th>
                                    <th style="width:20%;border:none;"></th>
                                </tr>
                                <tr style="background-color: #fff;color:#000">
                                    <th colspan="3" valign="top">{{$item->content}}</th>
                                    <th><a class="btn btn-blue rounded-pill" target="_blank" href="{{route('projectSOP.show', $item->projectSOP_id)}}">查看</a></th>

                                </tr>
                                <tr>
                                    <th valign="top">編號</th>
                                    <th valign="top">檔案名稱</th>
                                    <th colspan="2" valign="top">簡介</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($project_sop_item as $sop_item)
                                    @if($sop_item->projectSOP_id == $item->projectSOP_id)
                                    <tr>
                                        <td>{{$sop_item->no}}</td>
                                        <td>{{$sop_item->name}}</td>
                                        <td colspan="2">{{$sop_item->content}}</td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-style">   
                <div class="px-3">
                    <div class="card-header bg-white">
                        <i class='fas fa-calendar-alt' style="font-size:1.5rem;"></i>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <div>
                        <div class="time-line ">
                            <i class="time-i" style="background-color:#0acf97;"><i style="background-color:#96fde0;"></i></i>
                            <div class="ml-4">
                                <div class="ml-1">
                                    <span style="background-color:#0acf97;">截標日期</span>
                                    <p class="text-left">{{$data->deadline_date}}&nbsp;{{str_split($data->deadline_time,5)[0]}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="time-line">
                            <i class="time-i" style="background-color:#39afd1;"><i style="background-color:#9ae8ff;"></i></i>
                            <div class="ml-4">
                                <div class="ml-1">
                                    <span style="background-color:#39afd1;">開標日期</span>
                                    <p class="text-left">{{$data->open_date}}&nbsp;{{str_split($data->open_time,5)[0]}}</p>
                                </div>
                            </div>
                        </div>
                        @foreach ($data->acceptances as $item)
                            <div class="time-line" {{$data->status == 'unacceptable'? 'hidden' : ''}}>
                                <i class="time-i" style="background-color:#7338ff;"><i style="background-color:#b19df8;"></i></i> 
                                <div class="ml-4"> 
                                    <div class="ml-1"> 
                                        @if($loop->last)
                                        <span style="background-color:#7338ff;">期末結案驗收</span> 
                                        @else
                                        <span style="background-color:#7338ff;">第{{$item->no}}次期中驗收</span> 
                                        @endif
                                        <p class="text-left">{{$item->acceptance_date}}</p>

                                    </div>
                                </div>
                            </div>
                        
                        @endforeach
                        <div class="time-line">
                            <i class="time-i" style="background-color:#ffbc00;"><i style="background-color:#fbdd87;"></i></i>
                            <div class="ml-4">
                                <div class="ml-1">
                                    <span style="background-color:#ffbc00;">履約日期</span>
                                    <p class="text-left">{{$data->beginning_date==null? '-未填寫-': $data->beginning_date}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="time-line" {{$data->status == 'unacceptable'? 'hidden' : ''}}>
                            <i class="time-i" style="background-color:#fa5c7c;"><i style="background-color:#ff99ad;"></i></i>
                            <div class="ml-4">
                                <div class="ml-1">
                                    <span style="background-color:#fa5c7c;">結案日期</span>
                                    <p class="text-left">{{$data->closing_date}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card card-style">   
                <div class="card-body">
                    <!--@foreach($data->toArray() as $key => $value)
                    @if (strpos($key, '_at'))
                        @continue
                    @elseif (!is_Array($value))
                        @if($key=='contract_value'||$key=='default_fine'||$key=='')
                        <div>
                            <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.'.$key)}}</label></div>
                            <div class="d-flex justify-content-center"><label class="content-label-style col-form-label" id="{{$key}}">{{$value==null? '-未填寫-': number_format($value)}}</label></div>
                        </div>
                        @endif
                    @endif
                    @endforeach-->
                    <table>
                        
                        <thead>
                            <tr style="font-size:1.5rem;text-align:center" >
                                <th colspan="5">{{__('customize.contract_value')}}：{{number_format($data->contract_value)}}</th>
                            </tr>
                            <tr {{$data->status == 'unacceptable'? 'hidden' : ''}}>
                                <th style="width: 20%">驗收期數</th>
                                <th style="width: 20%">本期%數</th>
                                <th style="width: 20%">應稅價</th>
                                <th style="width: 20%">5%稅</th>
                                <th style="width: 20%">總計</th>
                            </tr>
                        </thead>
                        <tbody {{$data->status == 'unacceptable'? 'hidden' : ''}}>
                            @foreach($data->acceptances as $item)
                               
                                <tr>
                                    @if($loop->last)
                                    <td>期末結案驗收</td>
                                    @else
                                    <td>第{{$item->no}}次期中驗收</td>
                                    @endif
                                    <td>{{$item->persen}}%</td>
                                    <td id="amount_{{$item->no}}"></td>
                                    <td id="tex_{{$item->no}}"></td>
                                    <td id="total_amount_{{$item->no}}"></td>
                                </tr>
                            @endforeach
                        
                        </tbody>
                    </table>
                    <table {{$data->status == 'unacceptable'? 'hidden' : ''}}>
                        <thead>
                            <tr style="font-size:1.5rem;text-align:center" >
                                <th colspan="5">{{__('customize.performance_price')}}：{{$data->performance_id != null ? number_format($data['performance']->deposit) : '未設定'}}</th>
                            </tr>
                            @if($data->performance_id != null)
                            <tr>
                                <th style="widows: 25%">類型</th>
                                <th style="widows: 25%">日期</th>
                                <th style="widows: 25%">檔案</th>
                                <th style="widows: 25%">備註</th>
                            </tr>
                            @endif
                        </thead>
                        @if($data->performance_id != null)
                        <tbody>
                            <tr>
                                <td rowspan="2">押金日</td>
                                <td rowspan="2">{{$data['performance']->deposit_date}}</td>
                                <td>收據</td>
                                @if($data->performance['invoice_id'] != null)
                                    <td rowspan="2"><a style="text-decoration:none;color:black" target='_blank' href="{{route('invoice.review',$data['performance']->invoice_id)}}">{{$data['performance']->invoice_finished_id}}</a></td>     
                                @endif
                            </tr>
                            <tr>
                                @if($data['performance']->deposit_file!=null)
                                <td><a class="btn btn-blue rounded-pill" href="{{route('invoicedownload', $data['performance']->deposit_file)}}">發票影本下載</a></td>
                                @elseif($data['performance']->deposit_file==null)
                                <td>請款單上未上傳檔案</td>
                                @endif
                            </tr>
                            <tr>
                                <td rowspan="2">回款日</td>
                                <td rowspan="2">{{$data['performance']->PayBack_date}}</td>
                                <td>入款證明</td>
                                <td rowspan="2"></td>
                            </tr>
                            <tr>
                                @if($data['performance']->PayBack_file!=null)
                                <td><a class="btn btn-blue rounded-pill" href="{{route('threedownload', $data['performance']->PayBack_file)}}">入款證明下載</a></td>
                                @elseif($data['performance']->PayBack_file==null)
                                <td>尚未回款</td>
                                @endif
                            </tr>
                        </tbody>
                        @endif
                    </table>
                    <table {{$data->status == 'unacceptable'? 'hidden' : ''}}>
                        
                        <thead>
                            <tr style="font-size:1.5rem;text-align:center" >
                                <th colspan="5" id='total_default'>{{__('customize.default_fine')}}：{{number_format($data->default_fine)}}<i ></i></th>
                            </tr>
                            <tr>
                                <th style="width: 40%">違約工項說明</th>
                                <th style="width: 20%">扣款%數</th>
                                <th style="width: 20%">登記日期</th>
                                <th style="width: 20%">金額</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data->defaults as $item)
                               
                                <tr>
                                    <td>{{$item->content}}</td>
                                    <td>{{$item->persen}}%</td>
                                    <td>{{$item->default_date}}</td>
                                    <td id="default_amount_{{$item->no}}"></td>
                                </tr>
                            @endforeach

                        
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-style">
                        <div class="px-3">
                            <div class="card-header bg-white">
                                <i class='fas fa-dollar-sign' style="font-size:1.5rem;"></i><label class="ml-2 col-form-label">{{__('customize.Invoice')}}</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div style="padding: 10px">
                                <div style="display: flex;justify-content: space-between" >
                                    <label class="ml-2 col-form-label font-weight-bold" style="font-size: 1.2rem; font-weight: 700;">請款帳務</label>
                                    <span class="ml-2 col-form-label font-weight-bold" id="invoice_cost" style="font-size: 1.2rem; font-weight: 700;"></span>

                                </div>
                                <div style="text-align: center">
                                    <button type="button" id="invoice_cost_button" class="btn btn-primary rounded-pill" data-toggle="modal" data-target="#InvoiceModal">查看請款帳務</button>

                                </div>
                            </div>
                            <div style="padding: 10px">
                                <div style="display: flex;justify-content: space-between">
                                    <label class="ml-2 col-form-label font-weight-bold" style="font-size: 1.2rem; font-weight: 700;">健豪帳務</label>
                                    <span class="ml-2 col-form-label font-weight-bold" id="dging_cost" style="font-size: 1.2rem; font-weight: 700;"></span>

                                </div>
                                <div style="text-align: center">
                                    <button type="button" id="dging_cost_button" class="btn btn-primary rounded-pill" data-toggle="modal" data-target="#GdingModal">查看健豪帳務</button>

                                </div>
                                <div style="display: flex;justify-content: center" >
                                    @if($data->jianhao_statement !=null)
                                    <a class="btn btn-blue rounded-pill" href="{{route('threedownload', $data->jianhao_statement)}}">帳務檔案下載</a>
                                    @else
                                    <label class="ml-2 col-form-label font-weight-bold" style="font-size: 1.2rem; font-weight: 700;">未上傳帳務檔案</label>
                                    @endif
                                </div>
                            </div>
                            <div style="padding: 10px">
                                <div style="display: flex;justify-content: space-between" >
                                    <label class="ml-2 col-form-label font-weight-bold" style="font-size: 1.2rem; font-weight: 700;">繳款帳務</label>
                                    <span class="ml-2 col-form-label font-weight-bold" id="bill_payment" style="font-size: 1.2rem; font-weight: 700;"></span>

                                </div>
                                <div style="text-align: center">
                                    <button type="button" id="bill_payment_button" class="btn btn-primary rounded-pill" data-toggle="modal" data-target="#billPaymentModal">查看繳款帳務</button>

                                </div>
                            </div>
                            @if(\Auth::user()->role == 'manager' || \Auth::user()->role == 'proprietor' || \Auth::user()->user_id == $data->user_id)
                            <div style="padding: 10px">
                            @else
                            <div style="padding: 10px" hidden>
                            @endif
                                <div style="display: flex;justify-content:space-between">
                                    <label class="ml-2 col-form-label font-weight-bold" style="font-size: 1.2rem; font-weight: 700;">成本利潤表</label>
                                </div>
                                <div style="display: flex;justify-content: center" >
                                    @if($data->income_statement !=null)
                                    <a class="btn btn-blue rounded-pill" href="{{route('threedownload', $data->income_statement)}}">利潤表下載</a>
                                    @else
                                    <label class="ml-2 col-form-label font-weight-bold" style="font-size: 1.2rem; font-weight: 700;">未上傳利潤表</label>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-style" >
                        <div class="px-3">
                            <div class="card-header bg-white">
                                <i class='fas fa-poll ' style="font-size:1.5rem;"></i><label class="ml-2 col-form-label">數據</label>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach($data->toArray() as $key => $value)
                                @if (strpos($key, '_at'))
                                @continue
                                @elseif (!is_Array($value))
                                {{-- if add operater ($value!=null), would disable the value which haven't writed. --}}
                                    @if($key=='estimated_cost'||$key=='estimated_profit'||$key=='actual_cost'||$key=='actual_profit'||$key=='effective_interest_rate')
                                        @if(\Auth::user()->user_id==$data['user_id']||\Auth::user()->role=='manager' ||\Auth::user()->role=='pm')
                                            @if($key=='effective_interest_rate')
                                            <div {{$data->status != 'close'? 'hidden' : ''}}>
                                                <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.'.$key)}}</label></div>
                                                <div class="d-flex justify-content-center"><label class="content-label-style col-form-label"  id = "{{$key}}">{{$value==null? '-未填寫-': $value.'%'}}</label></div>
                                            </div>
                                            @elseif($key=='estimated_cost'||$key=='estimated_profit'||$key=='actual_profit')
                                            <div {{$data->status == 'unacceptable'? 'hidden' : ''}}>
                                                <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.'.$key)}}</label></div>
                                                <div class="d-flex justify-content-center"><label class="content-label-style col-form-label" id = "{{$key}}">{{$value==null? '-未填寫-': number_format($value)}}</label></div>
                                            </div>
                                            @else
                                            <div>
                                                <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.'.$key)}}</label></div>
                                                <div class="d-flex justify-content-center"><label class="content-label-style col-form-label" id = "{{$key}}">{{$value==null? '-未填寫-': number_format($value)}}</label></div>
                                            </div>
                                            @endif
                                        @else
                                        <div>
                                            <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.'.$key)}}</label></div>
                                            <div class="d-flex justify-content-center"><label class="content-label-style col-form-label"><i class='fas fa-lock'></i></label></div>
                                        </div>
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="InvoiceModal" role="dialog" aria-labelledby="InvoiceModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog " style="max-width: 70%" role="document">
        <div class="modal-content" >
            <div class="modal-header border-0">
                <h5 class="modal-title">請款帳務表單</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group col-lg-6">
                    <select id="year" class="rounded-pill " onchange="totalCalc()">
                        <option value=""></option>
                    </select>
                    <select id="month" class="rounded-pill " onchange="totalCalc()">
                        <option value=""></option>
                    </select>
                    <span>總金額：</span><span id="month_total"></span>
                </div>
                <div class="form-group col-lg-6">
                    <div id="invoice-page" class="d-flex align-items-end">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination mb-0">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true"><i class="fas fa-caret-left" style="width:14.4px"></i></span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true"><i class="fas fa-caret-right" style="width:14.4px"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-12 table-style-invoice ">
                    <table id="search-invoice">

                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="GdingModal" role="dialog" aria-labelledby="GdingModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog " style="max-width: 70%" role="document">
        <div class="modal-content" >
            <div class="modal-header border-0">
                <h5 class="modal-title">健豪帳務表單</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group col-lg-12 d-flex justify-content-between">
                    <div id="GDing-page" class="d-flex align-items-end">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination mb-0">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true"><i class="fas fa-caret-left" style="width:14.4px"></i></span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true"><i class="fas fa-caret-right" style="width:14.4px"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-12 table-style-invoice ">
                    <table id="search-gding">

                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="BillPaymentModal" role="dialog" aria-labelledby="BillPaymentModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog " style="max-width: 70%" role="document">
        <div class="modal-content" >
            <div class="modal-header border-0">
                <h5 class="modal-title">繳款帳務表單</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group col-lg-6">
                    <div id="billPayment-page" class="d-flex align-items-end">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination mb-0">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true"><i class="fas fa-caret-left" style="width:14.4px"></i></span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true"><i class="fas fa-caret-right" style="width:14.4px"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-12 table-style-invoice ">
                    <table id="search-billPayment">

                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>
@stop
<link href="{{ URL::asset('css/pm/project.css') }}" rel="stylesheet">
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>

<script>
    var projectData = []
    var total_default = 0 
    var InvoiceCost = 0
    var GdingCost = 0
    var Payment = 0
    var yearArray = []
    var monthArray = []
    $(document).ready(function() {
        projectData = getProjectData()
        var total = 0
        var invoice = '{{$data->invoices}}'

        invoice = invoice.replace(/[\n\r]/g, "")
        invoice = JSON.parse(invoice.replace(/&quot;/g, '"'));
        preTotalCalc()
        DGing_table = getNewDGing()

        var billPayment = '{{$data->billPayments}}'
        
        billPayment = billPayment.replace(/[\n\r]/g, "")
        billPayment = JSON.parse(billPayment.replace(/&quot;/g, '"'));
        setInvoice()
        setGDing()
        setBillPayment()
        $('#invoice_cost_button').click(function(){
            nowPage = 1
            setInvoiceTable()
    
        });
        $('#dging_cost_button').click(function(){
            nowDgingPage = 1
            setDGingTable()
    
        });
        $('#bill_payment_button').click(function(){
            nowPaymentPage = 1
            setBillPaymentTable()
    
        });
        setTex()
        setdefault()
        $("#total-price").html(commafy(total))
        
        settextArea()
        totalCalc()
        setInterestRate()
    });

    function setTex(){
        var contract_value = projectData.contract_value
        
        for(var i = 0 ; i < projectData.acceptances.length ; i++){
            var persen = projectData.acceptances[i].persen
            var total_amount = Math.round(contract_value * persen / 100)
            var tex = Math.round(total_amount*0.05)
            var amount = Math.round(total_amount-tex)
            $('#amount_' + projectData.acceptances[i].no).html(commafy(amount))
            $('#tex_' + projectData.acceptances[i].no).html(commafy(tex))
            $('#total_amount_' + projectData.acceptances[i].no).html(commafy(total_amount))
        }
    }
    function setdefault(){
        var contract_value = projectData.contract_value
        for(var i = 0 ; i < projectData.defaults.length ; i++){
            var persen = projectData.defaults[i].persen
            var amount = Math.round(contract_value * persen / 100)
            total_default += amount
            $('#default_amount_' + projectData.defaults[i].no).html(commafy(amount))
            
        }
        document.getElementById('total_default').innerHTML = "{{__('customize.default_fine')}}" + "：" + commafy(total_default)
    }

    function settextArea(){
        project_note = document.getElementById('project_note').textContent;
        
        project_note = project_note.replace(/\r?\n/g, '<br/>')
        document.getElementById('project_note').innerHTML = project_note
        
    }

    function getProjectData(){
        var project = '{{$data}}'
        project = project.replace(/[\n\r]/g, "")
        project = JSON.parse(project.replace(/&quot;/g, '"'));
        return project;
    }

    function setInterestRate(){
        var effective_interest_rate = document.getElementById('effective_interest_rate')
        var contract_value = projectData.contract_value * 0.95
        var actual_profit = contract_value-total_default-InvoiceCost-GdingCost+Payment
        document.getElementById('actual_profit').innerHTML = commafy(actual_profit)
        document.getElementById('actual_cost').innerHTML = commafy(total_default+InvoiceCost+parseInt(GdingCost))
        var temp =  (actual_profit/contract_value)*100
        temp = temp.toFixed(2)
        effective_interest_rate.innerHTML = temp + '%'
    }

    function commafy(num) {
        num = num + "";
        var re = /(-?\d+)(\d{3})/
        while (re.test(num)) {
            num = num.replace(re, "$1,$2")
        }
        return num;
    }

    function preTotalCalc() {
        var invoice = '{{$data->invoices}}'

        invoice = invoice.replace(/[\n\r]/g, "")
        invoice = JSON.parse(invoice.replace(/&quot;/g, '"'));

        var invoice_year = ""
        var invoice_month = ""
        var yearDiv = document.getElementById("year")
        var monthDiv = document.getElementById("month")
        for(var i = 0; i < invoice.length; i++){
            if(invoice[i].invoice_date == null) {
                invoice_year = invoice[i].created_at.substr(0, 4)
                invoice_month = invoice[i].created_at.substr(5, 2)
                console.log(invoice_year)
            }
            else {
                invoice_year = invoice[i].invoice_date.substr(0, 4)
                invoice_month = invoice[i].invoice_date.substr(5, 2)
            }
            
            if(monthArray.indexOf(invoice_month) == -1) {
                console.log("monthArray")
                monthArray.push(invoice_month)
            }
            if(yearArray.indexOf(invoice_year) == -1) {
                console.log("yearArray")
                yearArray.push(invoice_year)
            }
        }
        monthArray = monthArray.sort()
        yearArray = yearArray.sort()
        for(var i=0; i<yearArray.length; i++){
            yearDiv.innerHTML += "<option value="+ yearArray[i] +">"+ yearArray[i] +"</option>"
        }
        for(var i=0; i<monthArray.length; i++){
            monthDiv.innerHTML += "<option value="+ monthArray[i] +">"+ monthArray[i] +"</option>"
        }
    }

    function totalCalc() {
        var month = document.getElementById("month").value
        var year = document.getElementById("year").value
        var month_total = document.getElementById("month_total")
        var total = 0
        var invoice_month = '' 
        var invoice_year = ''

        for(var i=0;i < invoice_table.length;i++){
            if(invoice_table[i].invoice_date == null) {
                invoice_month = invoice_table[i].created_at.substr(5, 2)
                invoice_year = invoice_table[i].created_at.substr(0, 4)
            }
            else {
                invoice_month = invoice_table[i].invoice_date.substr(5, 2)
                invoice_year = invoice_table[i].invoice_date.substr(0, 4)
            }
            if(invoice_month == month && invoice_year == year){
                total += invoice_table[i].price
                console.log("Yes, Price:"+total)
            }
        
        }
        console.log("total:"+total)
        console.log("month_total:"+month_total)
        if(total == 0){
            month_total.innerHTML = "無"
        }
        else{
            month_total.innerHTML = total
        }
    }
</script>
<script>
    //Invoice帳務設定類---------------------------------------------------------------------------------------
        var invoice_table = []
        var nowPage = 1
    
        function setInvoice(){
            setInvoiceCost()
            invoice_table = getNewInviceTable()
            setInvoiceTable()
        }
        
        function getNewInviceTable(){
            data="{{$invoice_table}}"
            data = data.replace(/[\n\r]/g, "")
            data = JSON.parse(data.replace(/&quot;/g, '"'));
    
            return data
        }
    
        function setInvoiceCost(){
           
            var invoice = "{{$data->invoices}}"
            invoice = invoice.replace(/[\n\r]/g, "")
            invoice = JSON.parse(invoice.replace(/&quot;/g, '"'));
            for (var i = 0; i < invoice.length; i++) {
                if(invoice[i].status != 'delete' && invoice[i].prepay != 1){
                    
                    InvoiceCost += invoice[i].price
                }
                if(projectData.performance_id != null){
                    if(invoice[i].finished_id == projectData.performance.invoice_finished_id){
                        InvoiceCost -= invoice[i].price
                    }
                }
                
            }
            $('#invoice_cost').text("$" + commafy(InvoiceCost));
        }
    
        function setInvoiceTable(){
            listPage()
            listInvoice()
    
        }
    
        function nextPage() {
            var number = Math.ceil(invoice_table.length / 13)
    
            if (nowPage < number) {
                var temp = document.getElementsByClassName('page-item')
                $(".page-" + String(nowPage)).removeClass('active')
                nowPage++
                $(".page-" + String(nowPage)).addClass('active')
                listPage()
                listInvoice()
            }
    
        }
    
        function previousPage() {
            var number = Math.ceil(invoice_table.length / 13)
    
            if (nowPage > 1) {
                var temp = document.getElementsByClassName('page-item')
                $(".page-" + String(nowPage)).removeClass('active')
                nowPage--
                $(".page-" + String(nowPage)).addClass('active')
                listPage()
                listInvoice()
            }
    
        }
    
        function changePage(index) {
    
            var temp = document.getElementsByClassName('page-item')
    
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage = index
            $(".page-" + String(nowPage)).addClass('active')
    
            listPage()
            listInvoice()
    
        }
    
        function listPage() {
            $("#invoice-page").empty();
            var parent = document.getElementById('invoice-page');
            var table = document.createElement("div");
            table.style.width = "100%";
            var number = Math.ceil(invoice_table.length / 13)
            var data = ''
            if (nowPage < 4) {
                for (var i = 0; i < number; i++) {
                    if (i < 5) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    } else {
                        data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                        data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + number + ')">' + number + '</a></li>'
                        break
                    }
                }
            } else if (nowPage >= 4 && nowPage - 3 <= 2) {
                for (var i = 0; i < number; i++) {
                    if (i < nowPage + 2) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    } else {
                        data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                        data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + number + ')">' + number + '</a></li>'
                        break
                    }
                }
            } else if (nowPage >= 4 && nowPage - 3 > 2 && number - nowPage > 5) {
                for (var i = 0; i < number; i++) {
                    if (i == 0) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                        data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    } else if (i >= nowPage - 3 && i <= nowPage + 1) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
    
                    } else if (i > nowPage + 1) {
                        data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                        data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + number + ')">' + number + '</a></li>'
                        break
                    }
    
    
                }
            } else if (number - nowPage <= 5 && number - nowPage >= 4) {
                for (var i = 0; i < number; i++) {
                    if (i == 0) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                        data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    } else if (i >= nowPage - 3) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    }
                }
            } else if (number - nowPage < 4) {
                for (var i = 0; i < number; i++) {
                    if (i == 0) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                        data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    } else if (i >= number - 5) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    }
                }
            }
            var previous = "previous"
            var next = "next"
            table.innerHTML = '<nav aria-label="Page navigation example">' +
                '<ul class="pagination mb-0">' +
                '<li class="page-item">' +
                '<a class="page-link" href="javascript:void(0)" onclick="previousPage()" aria-label="Previous">' +
                '<span aria-hidden="true"><i class="fas fa-caret-left" style="width:14.4px"></i></span>' +
                '</a>' +
                '</li>' +
                data +
                '<li class="page-item">' +
                '<a class="page-link" href="javascript:void(0)" onclick="nextPage()" aria-label="Next">' +
                '<span aria-hidden="true"><i class="fas fa-caret-right" style="width:14.4px"></i></span>' +
                '</a>' +
                '</li>' +
                '</ul>' +
                '</nav>'
    
            parent.appendChild(table);
    
            $(".page-" + String(nowPage)).addClass('active')
        }
    
        function listInvoice() {
            $("#search-invoice").empty();
            var parent = document.getElementById('search-invoice');
            var table = document.createElement("tbody");
    
            table.innerHTML = '<tr class="text-white">' +
                '<th>請款單號</th>' +
                '<th>請款對象</th>' +
                '<th>請款項目</th>' +
                '<th>請款費用</th>' +
                '<th>請款日期</th>' +
                '<th>狀態</th>' +
                '<th>查看資料</th>' +
                '</tr>'
            var tr, span, name, a
    
    
            for (var i = 0; i < invoice_table.length; i++) {
                if (i >= (nowPage - 1) * 13 && i < nowPage * 13) {
                    table.innerHTML = table.innerHTML + setData(i)
                } else if (i >= nowPage * 13) {
                    break
                }
            }
            parent.appendChild(table);
        }
    
        function setData(i) {
            
            if (invoice_table[i].status == 'waiting') {
                span = "<div class='progress' data-toggle='tooltip' data-placement='top' title='第一階段審核中'>" +
                    "<div class='progress-bar bg-danger' role='progressbar' style='width: 0%' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'>" +
                    "</div>" +
                    "</div>";
    
            } else if (invoice_table[i].status == 'waiting-fix') {
    
                span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='請款被撤回，請修改'>" +
                    "<div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>" +
                    "</div>"
    
            } else if (invoice_table[i].status == 'check') {
    
                span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='第二階段審核中'>" +
                    "<div class='progress-bar bg-danger' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>" +
                    "</div>"
    
            } else if (invoice_table[i].status == 'check-fix') {
    
                span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='請款被撤回，請修改'>" +
                    "<div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>" +
                    "</div>"
    
            } else if (invoice_table[i].status == 'managed') {
    
                span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='請款中'>" +
                    "<div class='progress-bar bg-warning' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>" +
                    "</div>"
    
            } else if (invoice_table[i].status == 'matched') {
    
                span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='匯款中'>" +
                    "<div class='progress-bar bg-success' role='progressbar' style='width: 75%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>" +
                    "</div>"
    
            } else if (invoice_table[i].status == 'complete') {
    
                span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='匯款完成'>" +
                    "<div class='progress-bar bg-info' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>" +
                    "</div>"
            } else if(invoice_table[i].status == 'delete') {
                span = " <div title='已註銷'>" +
                    "<img src='{{ URL::asset('gif/cancelled.png') }}' alt='' style='width:100%'/>" +
                    "</div>"
            }
    
            a = "/invoice/" + invoice_table[i]['invoice_id'] + "/review"
            if(invoice_table[i].status == 'delete'){
                check_icon = ""
            }else{
                check_icon = "<a href='" + a + "' target='_blank'><i class='fas fa-search-dollar' >"
            }
            if(projectData.performance_id != null){
                if(invoice_table[i].finished_id == projectData.performance.invoice_finished_id){
                    var sgin = "<i class=\"fas fa-star\"></i>"
                }
                else{
                    var sgin = ""
                }
            }
            else{
                var sgin = ""
            }
            
            var invoice_dates = ''
            if(invoice_table[i].invoice_date == null) {
                invoice_dates = invoice_table[i].created_at.substr(0, 10)
            }
            else {
                invoice_dates = invoice_table[i].invoice_date
            }   
            tr = "<tr>" +
                "<td width='15%'><div class=\"d-flex justify-content-center\">" + sgin + invoice_table[i].finished_id + "</div></td>" +
                "<td width='20%'>" + invoice_table[i].company + "</td>" +
                "<td width='30%'>" + invoice_table[i].title + "</a></td>" +
                "<td width='10%'>" + commafy(invoice_table[i].price) + "</td>" +
                "<td width='15%'>" + invoice_dates + "</td>" +
                "<td width='5%'>" + span + "</td>" +
                "<td width='5%'>" + check_icon + "</i>"
                "</tr>"
    
    
            return tr
        }
    
    
</script>
<script>
    //DGing帳務設定類---------------------------------------------------------------------------------------
        var DGing_table = []
        var nowDgingPage = 1
        function setGDing(){
            setDGingCost()
            DGing_table = getNewDGing()
            setDGingTable()
        }
        function getNewDGing(){
            data="{{$gding_table}}"
            data = data.replace(/[\n\r]/g, "")
            data = JSON.parse(data.replace(/&quot;/g, '"'));
            return data
        }
        function setDGingCost(){
            
            var Gding = "{{$gding_table}}"
            Gding = Gding.replace(/[\n\r]/g, "")
            Gding = JSON.parse(Gding.replace(/&quot;/g, '"'));
            for (var i = 0; i < Gding.length; i++) {
                GdingCost += Gding[i].price*1.05
            }
            GdingCost = GdingCost.toFixed()
            $('#dging_cost').text("$" + commafy(GdingCost));
        }
        function setDGingTable(){
            listDGingPage()
            listDGing()
        }
    
        function nextDGingPage() {
            var number = Math.ceil(DGing_table.length / 13)
    
            if (nowDgingPage < number) {
                var temp = document.getElementsByClassName('page-item')
                $(".page-" + String(nowDgingPage)).removeClass('active')
                nowDgingPage++
                $(".page-" + String(nowDgingPage)).addClass('active')
                listDGingPage()
                listDGing()
            }
    
        }
    
        function previousDGingPage() {
            var number = Math.ceil(DGing_table.length / 13)
    
            if (nowDgingPage > 1) {
                var temp = document.getElementsByClassName('page-item')
                $(".page-" + String(nowDgingPage)).removeClass('active')
                nowDgingPage--
                $(".page-" + String(nowDgingPage)).addClass('active')
                listDGingPage()
                listDGing()
            }
    
        }
    
        function changeDGingPage(index) {
    
            var temp = document.getElementsByClassName('page-item')
    
            $(".page-" + String(nowDgingPage)).removeClass('active')
            nowDgingPage = index
            $(".page-" + String(nowDgingPage)).addClass('active')
    
            listDGingPage()
            listDGing()
    
        }
    
        function listDGingPage() {
            $("#GDing-page").empty();
           
            var parent = document.getElementById('GDing-page');
            var table = document.createElement("div");
            var number = Math.ceil(DGing_table.length / 13)
            var data = ''
            if (nowDgingPage < 4) {
                for (var i = 0; i < number; i++) {
                    if (i < 5) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeGDingPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    } else {
                        data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                        data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changeGDingPage(' + number + ')">' + number + '</a></li>'
                        break
                    }
                }
            } else if (nowDgingPage >= 4 && nowDgingPage - 3 <= 2) {
                for (var i = 0; i < number; i++) {
                    if (i < nowDgingPage + 2) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeGDingPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    } else {
                        data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                        data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changeGDingPage(' + number + ')">' + number + '</a></li>'
                        break
                    }
                }
            } else if (nowDgingPage >= 4 && nowDgingPage - 3 > 2 && number - nowDgingPage > 5) {
                for (var i = 0; i < number; i++) {
                    if (i == 0) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeGDingPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                        data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    } else if (i >= nowDgingPage - 3 && i <= nowDgingPage + 1) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeGDingPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
    
                    } else if (i > nowDgingPage + 1) {
                        data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                        data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changeGDingPage(' + number + ')">' + number + '</a></li>'
                        break
                    }
    
    
                }
            } else if (number - nowDgingPage <= 5 && number - nowDgingPage >= 4) {
                for (var i = 0; i < number; i++) {
                    if (i == 0) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeGDingPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                        data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    } else if (i >= nowDgingPage - 3) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeGDingPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    }
                }
            } else if (number - nowDgingPage < 4) {
                for (var i = 0; i < number; i++) {
                    if (i == 0) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeGDingPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                        data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    } else if (i >= number - 5) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeGDingPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    }
                }
            }
            var previous = "previous"
            var next = "next"
            table.innerHTML = '<nav aria-label="Page navigation example">' +
                '<ul class="pagination mb-0">' +
                '<li class="page-item">' +
                '<a class="page-link" href="javascript:void(0)" onclick="previousDGingPage()" aria-label="Previous">' +
                '<span aria-hidden="true"><i class="fas fa-caret-left" style="width:14.4px"></i></span>' +
                '</a>' +
                '</li>' +
                data +
                '<li class="page-item">' +
                '<a class="page-link" href="javascript:void(0)" onclick="nextDGingPage()" aria-label="Next">' +
                '<span aria-hidden="true"><i class="fas fa-caret-right" style="width:14.4px"></i></span>' +
                '</a>' +
                '</li>' +
                '</ul>' +
                '</nav>'
            table.style.width = "100%";
            parent.appendChild(table);
    
            $(".page-" + String(nowDgingPage)).addClass('active')
        }
    
        function listDGing() {
            $("#search-gding").empty();
            var parent = document.getElementById('search-gding');
            var table = document.createElement("tbody");
            table.innerHTML = '<tr class="text-white">' +
                '<th>No.</th>' +
                '<th>健豪項目</th>' +
                '<th>細項</th>' +
                '<th>單項金額</th>' +
                '</tr>'
            var tr, span, name, a
    
    
            for (var i = 0; i < DGing_table.length; i++) {
                if (i >= (nowDgingPage - 1) * 13 && i < nowDgingPage * 13) {
                    table.innerHTML = table.innerHTML + setDgingData(i)
                } else if (i >= nowDgingPage * 13) {
                    break
                }
            }
            parent.appendChild(table);
        }
    
        function setDgingData(i) {
            tr = "<tr>" +
                "<td width='10%'>" + DGing_table[i].num + "</td>" +
                "<td width='40%'>" + DGing_table[i].title + "</td>" +
                "<td width='40%'>" + DGing_table[i].note + "</a></td>" +
                "<td width='10%'>" + commafy((DGing_table[i].price*1.05).toFixed()) + "</td>" +
                "</tr>";
            
            setDGingModal(DGing_table[i].num)
    
            return tr
        }
    
        function setDGingModal(val){
            $(document).on("click","#deleteDgingModal_"+val,function(){    //編寫檔案簡介的Icon點擊後的的動作
                var number = $(this).data('id');                    //查詢到button 的 data-id的值
                $("#DeleteDgingModal_form").attr("action",number +"/delete");
                $("#deleteDgingModal").show()                              //顯示Modal
            });
    
            $(document).on("click","#EditDgingModal_"+val,function(){    //編寫檔案簡介的Icon點擊後的的動作
                var number = $(this).data('id');                    //查詢到button 的 data-id的值
                $("#EditDgingModal_form").attr("action",number +"/update");
                for(var i = 0; i < DGing_table.length ; i++){
                    if(DGing_table[i].id == number){
                        $("#EditDging_title").val(DGing_table[i].title)
                        $("#EditDging_note").val(DGing_table[i].note)
                        $("#EditDging_price").val(DGing_table[i].price)
                    }
                }
                
    
                $("#EditDgingModal").show()                              //顯示Modal
            });
            
            
        }
</script>
<script>
    //BillPayment帳務設定類---------------------------------------------------------------------------------------
        var billPayment_table = []
        var nowPaymentPage = 1
    
        function setBillPayment(){
            setPayment()
            billPayment_table = getNewBillPaymentTable()
            setBillPaymentTable()
        }
        
        function getNewBillPaymentTable(){
            data="{{$billPayment_table}}"
            data = data.replace(/[\n\r]/g, "")
            data = JSON.parse(data.replace(/&quot;/g, '"'));
    
            return data
        }
    
        function setPayment(){
           
            var billPayment = "{{$data->billPayments}}"
            billPayment = billPayment.replace(/[\n\r]/g, "")
            billPayment = JSON.parse(billPayment.replace(/&quot;/g, '"'));
            for (var i = 0; i < billPayment.length; i++) {
                if(billPayment[i].status != 'delete'){
                    
                    Payment += billPayment[i].price
                }
                if(projectData.performance_id != null){
                    if(billPayment[i].finished_id == projectData.performance.payment_finished_id){
                        Payment -= billPayment[i].price
                    }
                }
                
            }
            $('#bill_payment').text("$" + commafy(Payment));
        }
    
        function setBillPaymentTable(){
            listPage()
            listBillPayment()
    
        }
    
        function nextPage() {
            var number = Math.ceil(billPayment_table.length / 13)
    
            if (nowPaymentPage < number) {
                var temp = document.getElementsByClassName('page-item')
                $(".page-" + String(nowPaymentPage)).removeClass('active')
                nowPaymentPage++
                $(".page-" + String(nowPaymentPage)).addClass('active')
                listPage()
                listBillPayment()
            }
    
        }
    
        function previousPage() {
            var number = Math.ceil(billPayment_table.length / 13)
    
            if (nowPaymentPage > 1) {
                var temp = document.getElementsByClassName('page-item')
                $(".page-" + String(nowPaymentPage)).removeClass('active')
                nowPaymentPage--
                $(".page-" + String(nowPaymentPage)).addClass('active')
                listPage()
                listBillPayment()
            }
    
        }
    
        function changePage(index) {
    
            var temp = document.getElementsByClassName('page-item')
    
            $(".page-" + String(nowPaymentPage)).removeClass('active')
            nowPaymentPage = index
            $(".page-" + String(nowPaymentPage)).addClass('active')
    
            listPage()
            listBillPayment()
    
        }
    
        function listPage() {
            $("#billPayment-page").empty();
            var parent = document.getElementById('billPayment-page');
            var table = document.createElement("div");
            table.style.width = "100%";
            var number = Math.ceil(billPayment_table.length / 13)
            var data = ''
            if (nowPaymentPage < 4) {
                for (var i = 0; i < number; i++) {
                    if (i < 5) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    } else {
                        data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                        data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + number + ')">' + number + '</a></li>'
                        break
                    }
                }
            } else if (nowPaymentPage >= 4 && nowPaymentPage - 3 <= 2) {
                for (var i = 0; i < number; i++) {
                    if (i < nowPaymentPage + 2) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    } else {
                        data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                        data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + number + ')">' + number + '</a></li>'
                        break
                    }
                }
            } else if (nowPaymentPage >= 4 && nowPaymentPage - 3 > 2 && number - nowPaymentPage > 5) {
                for (var i = 0; i < number; i++) {
                    if (i == 0) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                        data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    } else if (i >= nowPaymentPage - 3 && i <= nowPaymentPage + 1) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
    
                    } else if (i > nowPaymentPage + 1) {
                        data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                        data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + number + ')">' + number + '</a></li>'
                        break
                    }
    
    
                }
            } else if (number - nowPaymentPage <= 5 && number - nowPaymentPage >= 4) {
                for (var i = 0; i < number; i++) {
                    if (i == 0) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                        data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    } else if (i >= nowPaymentPage - 3) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    }
                }
            } else if (number - nowPaymentPage < 4) {
                for (var i = 0; i < number; i++) {
                    if (i == 0) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                        data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    } else if (i >= number - 5) {
                        data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    }
                }
            }
            var previous = "previous"
            var next = "next"
            table.innerHTML = '<nav aria-label="Page navigation example">' +
                '<ul class="pagination mb-0">' +
                '<li class="page-item">' +
                '<a class="page-link" href="javascript:void(0)" onclick="previousPage()" aria-label="Previous">' +
                '<span aria-hidden="true"><i class="fas fa-caret-left" style="width:14.4px"></i></span>' +
                '</a>' +
                '</li>' +
                data +
                '<li class="page-item">' +
                '<a class="page-link" href="javascript:void(0)" onclick="nextPage()" aria-label="Next">' +
                '<span aria-hidden="true"><i class="fas fa-caret-right" style="width:14.4px"></i></span>' +
                '</a>' +
                '</li>' +
                '</ul>' +
                '</nav>'
    
            parent.appendChild(table);
    
            $(".page-" + String(nowPaymentPage)).addClass('active')
        }
    
        function listBillPayment() {
            $("#search-billPayment").empty();
            var parent = document.getElementById('search-billPayment');
            var table = document.createElement("tbody");
    
            table.innerHTML = '<tr class="text-white">' +
                '<th>繳款單號</th>' +
                '<th>繳款者</th>' +
                '<th>繳款項目</th>' +
                '<th>繳款費用</th>' +
                '<th>繳款日期</th>' +
                '<th>狀態</th>' +
                '<th>查看資料</th>' +
                '</tr>'
            var tr, span, name, a
    
    
            for (var i = 0; i < billPayment_table.length; i++) {
                if (i >= (nowPaymentPage - 1) * 13 && i < nowPaymentPage * 13) {
                    table.innerHTML = table.innerHTML + setBillPaymentData(i)
                } else if (i >= nowPaymentPage * 13) {
                    break
                }
            }
            parent.appendChild(table);
        }
    
        function setBillPaymentData(i) {
            
            if (billPayment_table[i].status == 'waiting') {
                span = "<div class='progress' data-toggle='tooltip' data-placement='top' title='待審核'>" +
                    "<div class='progress-bar bg-danger' role='progressbar' style='width: 0%' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'>" +
                    "</div>" +
                    "</div>";
    
            } else if (billPayment_table[i].status == 'waiting-fix') {
    
                span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='繳款被撤回，請修改'>" +
                    "<div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>" +
                    "</div>"
    
            } else if (billPayment_table[i].status == 'managed') {
    
                span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='審核通過'>" +
                    "<div class='progress-bar bg-success' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>" +
                    "</div>"
    
            } else if(billPayment_table[i].status == 'delete') {
                span = " <div title='已註銷'>" +
                    "<img src='{{ URL::asset('gif/cancelled.png') }}' alt='' style='width:100%'/>" +
                    "</div>"
            }
    
            a = "/billPayment/" + billPayment_table[i]['payment_id'] + "/review"
            if(billPayment_table[i].status == 'delete'){
                check_icon = ""
            }else{
                check_icon = "<a href='" + a + "' target='_blank'><i class='fas fa-search-dollar' >"
            }
            if(projectData.performance_id != null){
                if(billPayment_table[i].finished_id == projectData.performance.payment_finished_id){
                    var sgin = "<i class=\"fas fa-star\"></i>"
                }
                else{
                    var sgin = ""
                }
            }
            else{
                var sgin = ""
            }
            
            tr = "<tr>" +
                "<td width='15%'><div class=\"d-flex justify-content-center\">" + sgin + billPayment_table[i].finished_id + "</div></td>" +
                "<td width='20%'>" + billPayment_table[i].remittancer + "</td>" +
                "<td width='30%'>" + billPayment_table[i].title + "</a></td>" +
                "<td width='10%'>" + commafy(billPayment_table[i].price) + "</td>" +
                "<td width='15%'>" + billPayment_table[i].receipt_date + "</td>" +
                "<td width='5%'>" + span + "</td>" +
                "<td width='5%'>" + check_icon + "</i>"
                "</tr>"
    
    
            return tr
        }
    
    
</script>
@stop

