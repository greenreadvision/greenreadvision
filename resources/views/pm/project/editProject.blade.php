@extends('layouts.app')
@section('content')
<form action="update" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="col-lg-12">
        <div class="row" style="justify-content: flex-end;">
            <div class="mb-3" style="padding: 10px;">
                <div style="float: right;">
                    <button type="button" class="btn btn-green rounded-pill" data-toggle="modal" data-target="#changeStatus">轉換專案狀態</button>
                </div>
            </div>
            @if($data['project']->receiver == "")
            <div class="mb-3" style="padding: 10px;">
                <div style="float: right;">
                    <button type="button" class="btn btn-primary rounded-pill" data-toggle="modal" data-target="#transfer">轉讓專案</button>
                </div>
            </div>
            @else
            <div class="mb-3" style="padding: 10px;">
                <div style="float: right;">
                    <button type="button" class="btn btn-danger rounded-pill">轉讓中</button>
                </div>
            </div>
            @endif
            @if($data['project']->invoices=='[]'&&$data['project']->todos=='[]')
            <div style="float: right;padding: 10px;" class="mb-3" >
                <button type="button" class="btn btn-danger rounded-pill" data-toggle="modal" data-target="#deleteModal">
                    <i class='fas fa-trash-alt'></i><span class="ml-3">{{__('customize.Delete')}}</span>
                </button>
            </div>
            @endif
            
        </div>
    </div>

    <div class="col-lg-12">
        <div class="row" >
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card card-style">
                            <div class="px-3">
                                <div class="card-header bg-white">
                                    <i class='fas fa-user-circle' style="font-size:1.5rem;"></i><label class="ml-2 col-form-label ">{{__('customize.User')}}</label>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-center"><label class="content-label-style col-form-label" style="text-align: center">{{$data['project']->user->name}}</label></div>
                            </div>
                        </div>
                        <div class="card card-style">
                            <div class="px-3">
                                <div class="card-header bg-white row" style="justify-content: space-between">
                                    <div>
                                        <i class='fas fa-check-circle' style="font-size:1.5rem;"></i><label class="ml-2 col-form-label">{{__('customize.project_about')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div>
                                    <label class="ml-2 col-form-label font-weight-bold">{{__('customize.project_status')}}</label>
                                    <div class="d-flex justify-content-center">
                                        <label class="col-form-label" style="font-size: 1.5rem;font-weight: 700;{{$data['project']->status == 'close'? 'color:red':''}}{{$data['project']->status == 'running'? 'color:#000':''}}">{{__('customize.project_'.$data['project']->status)}}</label>
                                    </div>
                                </div>
                                
                                <div {{$data['project']->status == 'unacceptable'? 'hidden' : ''}}>
                                    <label class="ml-2 col-form-label font-weight-bold">{{__('customize.case_num')}}</label>
                                    <div class="d-flex justify-content-center">
                                        <label class="content-label-style col-form-label">
                                            <input autocomplete="off" type="text" id="case_num" name="case_num" value="{{$errors->has('case_num')? old('case_num'): $data['project']->case_num}}" class="form-control{{ $errors->has('case_num') ? ' is-invalid' : '' }}" placeholder="尚未填寫">
                                            @if ($errors->has('case_num'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{__('customize.case_num')}}已重複</strong>
                                            </span>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label class="ml-2 col-form-label font-weight-bold">{{__('customize.project_color')}}</label>
                                    <div class="d-flex justify-content-center">
                                        <label class="content-label-style col-form-label">
                                        <input type="color" id="color" name="color" value="{{$data['project']->color}}" class="form-control" style="height:37px;" required>    
                                            @if ($errors->has('color'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{__('customize.project_color')}}已重複</strong>
                                            </span>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label class="ml-2 col-form-label font-weight-bold">{{__('customize.company')}}</label>
                                    <div class="d-flex justify-content-center">
                                        <label class="content-label-style col-form-label">
                                        <select type="text" id="company_name" name="company_name" class="form-control" autofocus>
                                            @foreach ($data['company_name'] as $key)
                                            @if($data['project']->company_name==$key)
                                            <option value="{{$key}}" selected>{{__('customize.'.$key)}}</option>
                                            @else
                                            <option value="{{$key}}">{{__('customize.'.$key)}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label class="ml-2 col-form-label font-weight-bold">{{__('customize.Project_name')}}</label>
                                    <div class="d-flex justify-content-center">
                                        <label class="content-label-style col-form-label">
                                            <input autocomplete="off" type="text" name="name" value="{{$data['project']->name}}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="尚未填寫">
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{__('customize.Project_name')}}已重複</strong>
                                            </span>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                                <div {{$data['project']->status == 'unacceptable'? 'hidden' : ''}}>
                                    <label class="ml-2 col-form-label font-weight-bold">{{__('customize.Acceptance_times')}}</label>
                                    <div class="d-flex justify-content-center">
                                        <label class="content-label-style col-form-label">
                                            @if($data['project']->acceptance_times != null)
                                            <input autocomplete="off" type="text" name="Acceptance_times" id='Acceptance_times' onkeyup="acceptanceChange(this.id)" value="{{$data['project']->acceptance_times}}" class="form-control{{ $errors->has('Acceptance_times') ? ' is-invalid' : '' }}" placeholder="尚未填寫" required>
                                            @else
                                            <input autocomplete="off" type="text" name="Acceptance_times" id='Acceptance_times' onkeyup="acceptanceChange(this.id)" value="0" class="form-control{{ $errors->has('Acceptance_times') ? ' is-invalid' : '' }}" placeholder="尚未填寫" required>
                                            @endif
                                            @if ($errors->has('Acceptance_times'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{__('customize.Acceptance_times')}}未填寫</strong>
                                            </span>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="col-lg-6">
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
                                                <input type="date" id="deadline_date" name="deadline_date" value="{{$data['project']->deadline_date}}" class="my-1 form-control" placeholder="">
                                                <input type="time" id="deadline_time" name="deadline_time" value="{{$data['project']->deadline_time}}" class="my-1 form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="time-line">
                                        <i class="time-i" style="background-color:#39afd1;"><i style="background-color:#9ae8ff;"></i></i>
                                        <div class="ml-4">
                                            <div class="ml-1">
                                                <span style="background-color:#39afd1;">開標日期</span>
                                                <input type="date" id="open_date" name="open_date" value="{{$data['project']->open_date}}" class="my-1 form-control" placeholder="">
                                                <input type="time" id="open_time" name="open_time" value="{{$data['project']->open_time}}" class="my-1 form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="time-line" {{$data['project']->status == 'unacceptable'? 'hidden' : ''}}>
                                        <i class="time-i" style="background-color:#ffbc00;"><i style="background-color:#fbdd87;"></i></i>
                                        <div class="ml-4">
                                            <div class="ml-1">
                                                <span style="background-color:#ffbc00;">履約日期</span>
                                                <input type="date" id="beginning_date" name="beginning_date" value="{{$data['project']->beginning_date}}" class="my-1 form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="acceptance" {{$data['project']->status == 'unacceptable'? 'hidden' : ''}}> 
                                    @if(count($data['project']->acceptances) != 0)
                                        @foreach ($data['project']->acceptances as $item)
                                        
                                        <div class="time-line">
                                            <i class="time-i" style="background-color:#7338ff;"><i style="background-color:#b19df8;"></i></i> 
                                            <div class="ml-4"> 
                                                <div class="ml-1"> 
                                                    @if($loop->last)
                                                    <span style="background-color:#7338ff;">期末結案驗收</span> 
                                                    @else
                                                    <span style="background-color:#7338ff;">第{{$item->no}}次期中驗收</span> 
                                                    @endif
                                                    <input type="date" id="acceptance_date_{{$item->no}}"  name="acceptance_date_{{$item->no}}" value="{{$item->acceptance_date}}" class="my-1 form-control" placeholder="">
                                                    <div style="display: flex">
                                                        <input type="text" id="acceptance_persen_{{$item->no}}" onkeyup="value=value.replace(/^\D*(\d*(?:\.\d{0,1})?).*$/g, '$1')" name="acceptance_persen_{{$item->no}}"  value="{{$item->persen}}" style="display: inline;width:auto" class="my-1 form-control" placeholder="標金 % 數"> 
                                                        <p style="display: inline"> % </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        @endforeach
                                    @else
                                        @for($i = 1 ; $i <=$data['project']->acceptance_times  ; $i++)
                                        <div class="time-line">
                                            <i class="time-i" style="background-color:#7338ff;"><i style="background-color:#b19df8;"></i></i> 
                                            <div class="ml-4"> 
                                                <div class="ml-1"> 
                                                    @if($i == $data['project']->acceptance_times )
                                                    <span style="background-color:#7338ff;">期末結案驗收</span> 
                                                    @else
                                                    <span style="background-color:#7338ff;">第{{$i}}次期中驗收</span> 
                                                    @endif
                                                    <input type="date" id="acceptance_date_{{$i}}"  name="acceptance_date_{{$i}}" value="" class="my-1 form-control" placeholder="">
                                                    <div style="display: flex">
                                                        <input type="text" id="acceptance_persen_{{$i}}" onkeyup="value=value.replace(/^\D*(\d*(?:\.\d{0,1})?).*$/g, '$1')" name="acceptance_persen_{{$i}}"  value="" style="display: inline;width:auto" class="my-1 form-control" placeholder="驗收標金 % 數"> 
                                                        <p style="display: inline"> % </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endfor
                                    @endif
                                    </div>
                                    <div class="time-line" {{$data['project']->status == 'unacceptable'? 'hidden' : ''}}>
                                        <i class="time-i" style="background-color:#fa5c7c;"><i style="background-color:#ff99ad;"></i></i>
                                        <div class="ml-4">
                                            <div class="ml-1">
                                                <span style="background-color:#fa5c7c;">結案日期</span>
                                                <input type="date" id="closing_date" name="closing_date" value="{{$data['project']->closing_date}}" class="my-1 form-control" placeholder="">
        
                                            </div>
                                        </div>
                                    </div>
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
                        <textarea name="project_note" id="project_note" rows="6" class="my-1 form-control" placeholder="尚未編輯" oninput="setTextArea()">{{$data['project']->project_note==null? '': $data['project']->project_note}}</textarea>
                    </div>
                </div>
                <div class="card card-style col-lg-12" {{$data['project']->status == 'unacceptable'? 'hidden' : ''}}>
                    <div class="px-3">
                        <div class="card-header bg-white">
                            <i class='fas fa-user-circle' style="font-size:1.5rem;"></i><label class="ml-2 col-form-label ">{{__('customize.project_sop')}}</label>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach ($data['project']->projectSOP as $item)
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
                                    @foreach ($data['project_sop_item'] as $sop_item)
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
            <div class="col-lg-6">
                <div class="card card-style col-lg-12">
                    <div class="px-3">
                        <div class="card-header bg-white">
                            <i class='fas fa-dollar-sign' style="font-size:1.5rem;"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.contract_value')}}</label></div>
                            <div class="d-flex justify-content-center">
                                <label class="content-label-style col-form-label">
                                    @if($data['project']->contract_value != null)
                                    <input autocomplete="off" type="text" id="contract_value" name="contract_value" value="{{$errors->has('contract_value')? old('contract_value'): $data['project']->contract_value}}" onkeyup="update()" class="form-control{{ $errors->has('contract_value') ? ' is-invalid' : '' }}" placeholder="尚未填寫" required>
                                    @else
                                    <input autocomplete="off" type="text" id="contract_value" name="contract_value" value="{{$errors->has('contract_value')? old('contract_value'): '0'}}" onkeyup="update()" class="form-control{{ $errors->has('contract_value') ? ' is-invalid' : '' }}" placeholder="尚未填寫" required>
                                    @endif
                                </label>
                            </div>
                        </div>
                        <div {{$data['project']->status == 'unacceptable'? 'hidden' : ''}}>
                            <table id="bound_table">     
                            </table>
                        </div>
                        <div {{$data['project']->status == 'unacceptable'? 'hidden' : ''}}>
                            <div class="d-flex" style="justify-content: space-between;">
                                <label class="ml-2 col-form-label font-weight-bold">{{__('customize.performance_price')}}</label>
                                @if($data['project']->performance_id==null)
                                <button class="btn btn-red rounded-pill" type="button" data-toggle="modal" data-target="#createPerformanceModal"><span>新增履約保證金資料</span></button>
                                @else
                                <button class="btn btn-red rounded-pill" type="button" data-toggle="modal" data-target="#editPerformanceModal"><span>更新履約保證金資料</span></button>
                                @endif
                            </div>
                            <div class="d-flex justify-content-center">
                                <label class="content-label-style col-form-label" style="display: flex">
                                    <input autocomplete="off" type="text" id="performance_price" name="performance_price" value="{{$data['project']->performance_id==null ? '': $data['project']->performance['deposit']}}" class="form-control" placeholder="尚未填寫" readonly>
                                </label>
                            </div>
                            @if($data['project']->performance_id != null)
                            <div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th style="widows: 25%">類型</th>
                                            <th style="widows: 25%">日期</th>
                                            <th style="widows: 25%">檔案</th>
                                            <th style="widows: 25%">備註</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="2">押金日</td>
                                            <td rowspan="2">{{$data['project']->performance['deposit_date']}}</td>
                                            <td>收據</td>
                                            <td rowspan="2">
                                                @if($data['project']->performance['invoice_id'] != null)
                                                <a style="text-decoration:none;color:black" target='_blank' href="{{route('invoice.review',$data['project']->performance['invoice_id'])}}">{{$data['project']->performance['invoice_finished_id']}}</a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            @if($data['project']->performance['deposit_file']!=null)
                                            <td><a class="btn btn-blue rounded-pill" href="{{route('invoicedownload', $data['project']->performance['deposit_file'])}}">發票影本下載</a></td>
                                            @elseif($data['project']->performance['deposit_file']==null)
                                            <td>請款單上未上傳檔案</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td rowspan="2">回款日</td>
                                            <td rowspan="2">{{$data['project']->performance['PayBack_date']}}</td>
                                            <td>入款證明</td>
                                            <td rowspan="2"></td>
                                        </tr>
                                        <tr>
                                            @if($data['project']->performance['PayBack_file']!=null)
                                            <td><a class="btn btn-blue rounded-pill" href="{{route('threedownload', $data['project']->performance['PayBack_file'])}}">入款證明下載</a></td>
                                            @elseif($data['project']->performance['PayBack_file']==null)
                                            <td>尚未回款</td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                        <div {{$data['project']->status == 'unacceptable'? 'hidden' : ''}}>
                            <div class="d-flex" style="justify-content: space-between;">
                                <label class="ml-2 col-form-label font-weight-bold">{{__('customize.default_fine')}}</label>
                                <button class="btn btn-red rounded-pill" type="button" onclick="openDefaultModal()"><span>新增違規工項</span> </button>
                            </div>
                            <div class="d-flex justify-content-center">
                                <label class="content-label-style col-form-label" style="display: flex">
                                    <input autocomplete="off" type="text" id="default_fine" name="default_fine" value="{{$errors->has('default_fine')? old('default_fine'): $data['project']->default_fine}}" class="form-control{{ $errors->has('default_fine') ? ' is-invalid' : '' }}" placeholder="尚未填寫" readonly>
                                </label>
                            </div>
                        </div>
                        <div {{$data['project']->status == 'unacceptable'? 'hidden' : ''}}>
                            <table id = "default_table">
                            @foreach($data['project']->defaults as $item)
                                
                            @endforeach
                            </table>
                            <div id = "default_talbe_input">
                            </div>
                        </div>
                        <input type="text" id="default_num" name="default_num" value="" hidden>
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
                                </div>
                                @if((\Auth::user()->role == 'manager' || \Auth::user()->role == 'proprietor' || \Auth::user()->user_id == $data['project']->user_id) && $data['project']->status !='unacceptable')
                                <div style="padding: 10px">
                                @else
                                <div style="padding: 10px" hidden>
                                @endif
                                    <div style="display: flex;justify-content:space-between">
                                        <label class="ml-2 col-form-label font-weight-bold" style="font-size: 1.2rem; font-weight: 700;">成本利潤表</label>
                                        <span class="ml-2 col-form-label font-weight-bold" id='Statement_show' style="font-size: 1.2rem; font-weight: 700;">{{$data['project']->income_statement == null ? '無資料' : '有資料'}}</span>
                                    </div>
                                    <div style="display: flex;justify-content: center" >
                                        <div class="fileButton rounded-pill form-control" style="width: auto">
                                            <input type="file"  id="income_statement" name="income_statement" onchange="UpLoadStatement()" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf"  multiple/>檔案上傳請按這
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" >
                        <div class="card card-style">
                            <div class="px-3">
                                <div class="card-header bg-white">
                                    <i class='fas fa-poll ' style="font-size:1.5rem;"></i><label class="ml-2 col-form-label">數據</label>
                                </div>
                            </div>
                            <div class="card-body">
                                @foreach($data['project']->toArray() as $key => $value)
                                    @if (strpos($key, '_at'))
                                    @continue
                                    @elseif (!is_Array($value))
                                    <!-- if add operater ($value!=null), would disable the value which have not writed. -->
                                        @if($key=='estimated_cost'||$key=='estimated_profit'||$key=='actual_cost'||$key=='actual_profit'||$key=='effective_interest_rate')
                                            @if(\Auth::user()->user_id==$data['project']['user_id']||\Auth::user()->role=='manager')
        
                                                @if($key=='effective_interest_rate' )
                                                <div {{$data['project']['status'] == 'close'?'hidden':''}}>
                                                    <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.'.$key)}}(結案後會自動顯現)</label></div>
                                                    <div class="d-flex justify-content-center">
                                                        <label class="content-label-style col-form-label">
                                                            <input autocomplete="off" type="text" id="{{$key}}" name="{{$key}}" value="{{$errors->has($key)? old($key): $value}}" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" placeholder="尚未填寫" readonly>
                                                        </label>
                                                        @if ($errors->has('effective_interest_rate'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>專案名稱已重複</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @elseif($key =='actual_cost')
                                                <div>
                                                    <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.'.$key)}}</label></div>
                                                    <div class="d-flex justify-content-center">
                                                        <label class="content-label-style col-form-label">
                                                            <input autocomplete="off" type="text" id="{{$key}}" name="{{$key}}" value="{{$errors->has($key)? old($key): $value}}" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" placeholder="尚未填寫" readonly>
                                                        </label>
                                                    </div>
                                                </div>
                                                @elseif($key == 'actual_profit')
                                                <div {{$data['project']->status != 'unacceptable'?'':'hidden'}}>
                                                    <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.'.$key)}}</label></div>
                                                    <div class="d-flex justify-content-center">
                                                        <label class="content-label-style col-form-label">
                                                            <input autocomplete="off" type="text" id="{{$key}}" name="{{$key}}" value="{{$errors->has($key)? old($key): $value}}" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" placeholder="尚未填寫" readonly>
                                                        </label>
                                                    </div>
                                                </div>
                                                @elseif(($key =='estimated_cost' || $key == 'estimated_profit')&& $data['project']->status != 'unacceptable')
                                                <div>
                                                    <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.'.$key)}}</label></div>
                                                    <div class="d-flex justify-content-center">
                                                        <label class="content-label-style col-form-label">
                                                            <input autocomplete="off" type="text" id="{{$key}}" name="{{$key}}" value="{{$errors->has($key)? old($key): $value}}" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" placeholder="尚未填寫">
                                                        </label>
                                                    </div>
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
    <div class="col-lg-12">
        <div style="float: right;">
            @method('PUT')
            @csrf
            <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Save')}}</button>
        </div>
    </div>
</form>

<div class="modal fade" id="changeStatus" role="dialog" aria-labelledby="changeStatusLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <span style="text-align: center">更改專案狀態</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">   
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center ">
                <form action="update/status" method="POST">
                    <div style="text-align: center;padding: 10px">
                        <select name="status" id="status" class="form-control" onchange="ChangeStatusOption()">
                            <option value="unacceptable" {{$data['project']->status == 'unacceptable'? 'selected':''}} >未得標</option>
                            <option value="running" {{$data['project']->status == 'running'? 'selected':''}}>執行中</option>
                            <option value="close" {{$data['project']->status == 'close'? 'selected':''}}>已結案</option>
    
                        </select>
                    </div>
                    <input autocomplete="off" type="text" id="effective_interest_rate_change" name="effective_interest_rate_change" value="{{$errors->has('effective_interest_rate_change')? old('effective_interest_rate_change'): ''}}" class="form-control{{ $errors->has('effective_interest_rate_change') ? ' is-invalid' : '' }}" placeholder="尚未填寫" hidden>
 
                    <div>
                        @method('PUT')
                        @csrf
                        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">關閉</button>
                        <button type="submit" class="btn btn-primary rounded-pill">儲存</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5>是否刪除?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times;</span>
                </button>
            </div>
            <div class="modal-body text-center row" style="justify-content: center">
                <div style="padding: 10px">
                    <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">否</button>
                </div>
                <div style="padding: 10px">
                    <form action="delete" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-primary rounded-pill" >是</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="transfer" role="dialog" aria-labelledby="transfer" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center ">
                <form action="transfer" method="POST" class="mb-3">
                    @method('PUT')
                    @csrf
                    
                    <select name="user" class="form-control">
                        <option value=""></option>
                        @foreach($data['alluser'] as $user)
                        @if($user->user_id != \Auth::user()->user_id && $user->status != "resignation" && $user->role != "manager")
                        <option value="{{$user['user_id']}}">{{$user->nickname}}</option>

                        @endif
                        @endforeach
                    </select>
                    <div class="modal-footer justify-content-center border-0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-primary">確認</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="defaultModal" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document" style="max-width: 50%">
        <div class="modal-content" >
            <div class="modal-header border-0">
                <h5 class="modal-title" id="signerModalLabel">新增違規工項</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="defaultItem/create/review" method="POST" class="mb-3">
                    @method('POST')
                    @csrf
                    
                    <div class="row">
                        <div class="col-lg-4 form-group">
                            <div>
                                <label class="ml-2 col-form-label font-weight-bold">
                                    扣款%數
                                </label>
                            </div>
                            <div class="d-flex justify-content-center" >
                                <label class="content-label-style col-form-label">
                                    <input type="text" id="default_persen" onkeyup="value=value.replace(/^\D*(\d*(?:\.\d{0,1})?).*$/g, '$1')" name="default_persen" class="form-control {{ $errors->has('default_persen') ? ' is-invalid' : '' }}" oninput="changedefaultAmount('add')" required>
                                    
                                </label>
                                @if ($errors->has('default_persen'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('default_persen') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4 form-group">
                            <div>
                                <label class="ml-2 col-form-label font-weight-bold">
                                    扣款金額
                                </label>
                            </div>
                            <div class="d-flex justify-content-center" >
                                <label class="content-label-style col-form-label">
                                    <input type="text" id="default_amount" name="default_amount" class="form-control{{ $errors->has('default_amount') ? ' is-invalid' : '' }}" readonly>
                                </label>
                                
                            </div>
                        </div>
                        <div class="col-lg-4 form-group">
                            <div>
                                <label class="ml-2 col-form-label font-weight-bold">
                                    登記日期(預設今日)
                                </label>
                            </div>
                            <div class="d-flex justify-content-center" >
                                <label class="content-label-style col-form-label">
                                    <input type="date" id="default_date" name="default_date" class="form-control{{ $errors->has('default_date') ? ' is-invalid' : '' }}" required>
                                </label>
                                @if ($errors->has('default_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('default_date') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <div>
                                <label class="ml-2 col-form-label font-weight-bold">
                                工項內容
                                </label>
                            </div>
                            <div class="d-flex justify-content-center">
                                <label class="content-label-style col-form-label">
                                    <textarea autocomplete="off" type="text" id="default_content" rows="3" name="default_content"  value="" class="form-control{{ $errors->has('default_content') ? ' is-invalid' : '' }}" placeholder="尚未填寫" required></textarea>
                                </label>
                                @if ($errors->has('default_content'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('default_content') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0" style="justify-content: space-between">
                        <button type="button" class="btn btn-danger" onclick="cleandefault('add')">清空輸入</button>
                        <button type="submit" class="btn btn-primary">新增</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="editDefaultModal" role="dialog" aria-labelledby="editDefaultModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document" style="max-width: 50%">
        <div class="modal-content" >
            <div class="modal-header border-0">
                <h5 class="modal-title" id="signerModalLabel">修改工項內容</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editDefaultForm" method="POST" class="mb-3">
                    @method('POST')
                    @csrf
                    <div class="row">
                        <input id="edit_default_remenber" value="" type="text" hidden>
                        <div class="col-lg-4 form-group">
                            <div>
                                <label class="ml-2 col-form-label font-weight-bold">
                                    扣款%數
                                </label>
                            </div>
                            <div class="d-flex justify-content-center" >
                                <label class="content-label-style col-form-label">
                                    <input type="text" id="edit_default_persen" onkeyup="value=value.replace(/^\D*(\d*(?:\.\d{0,1})?).*$/g, '$1')" name="edit_default_persen" class="form-control" oninput="changedefaultAmount('edit')" required>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4 form-group">
                            <div>
                                <label class="ml-2 col-form-label font-weight-bold">
                                    扣款金額
                                </label>
                            </div>
                            <div class="d-flex justify-content-center" >
                                <label class="content-label-style col-form-label">
                                    <input type="text" id="edit_default_amount" name="edit_default_amount" class="form-control" readonly>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4 form-group">
                            <div>
                                <label class="ml-2 col-form-label font-weight-bold">
                                    登記日期
                                </label>
                            </div>
                            <div class="d-flex justify-content-center" >
                                <label class="content-label-style col-form-label">
                                    <input type="date" id="edit_default_date" name="edit_default_date" class="form-control" required>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <div>
                                <label class="ml-2 col-form-label font-weight-bold">
                                工項內容
                                </label>
                            </div>
                            <div class="d-flex justify-content-center">
                                <label class="content-label-style col-form-label">
                                    <textarea autocomplete="off" type="text" id="edit_default_content" rows="3" name="edit_default_content"  value="" class="form-control{{ $errors->has('default_content') ? ' is-invalid' : '' }}" placeholder="尚未填寫" required></textarea>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0" style="justify-content: space-between">
                        <button type="button" class="btn btn-danger" onclick="cleandefault('edit')">清空輸入</button>
                        <button type="submit" class="btn btn-primary" >修正</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="deleteDefaultModal" role="dialog" aria-labelledby="deleteDefaultModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content" >
            <div class="modal-header border-0">
                <h5 class="modal-title" id="signerModalLabel">確定刪除違規工項？</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>工項如下：</h5>
                <span id="deleteContent" style="text-align: center"></span>
                <input type="text" id="deleteContent_id" hidden>
                <div class="modal-footer border-0" style="justify-content: center">
                    <form id='deleteDefaultForm'method="POST" class="mb-3">
                        @method('DELETE')
                        @csrf
                        <button type="button" class="btn btn-gray" data-dismiss="modal" >否</button>
                        <button type="submit" class="btn btn-blue">是</button>
                    </form>
                    
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
                <div class="form-group col-lg-12 d-flex justify-content-between">
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
                    <button type="button" id="gding_button" class="btn btn-primary rounded-pill" data-toggle="modal" data-target="#CreateDgingModal" data-dismiss="modal">新增</button>
                </div>
                <div class="col-lg-12 table-style-invoice ">
                    <table id="search-gding">

                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="CreateDgingModal" role="dialog" aria-labelledby="CreateDgingModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog " style="max-width: 70%" role="document">
        <div class="modal-content" >
            <div class="modal-header border-0">
                <h5 class="modal-title">建立新的健豪工項</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-target="#GdingModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group col-lg-12 d-flex justify-content-center">
                    <form id="CreateDgingModal_form" action="gding/create/review" method="POST">
                        @method('POST')
                        @csrf

                        <input autocomplete="off" type="text" id="item_total_num" name="item_total_num" class="rounded-pill form-control{{ $errors->has('item_total_num') ? ' is-invalid' : '' }}" value=9 readonly hidden>
                        <table id="Itemtable" width="100%">
                            
                            
                        </table>
                        <div class="col-lg-12" style="display: flex;justify-content: flex-end">
                            <button type="submit" class="btn btn-primary rounded-pill">新增</button>
                        </div>

                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="EditDgingModal" role="dialog" aria-labelledby="EditDgingModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog " style="max-width: 70%" role="document">
        <div class="modal-content" >
            <div class="modal-header border-0">
                <h5 class="modal-title">更改健豪項目</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-target="#GdingModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <form id="EditDgingModal_form" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <label class="ml-2 col-form-label font-weight-bold">健豪項目</label>
                                <input autocomplete="off" type="text" id="EditDging_title" name="EditDging_title" class="rounded-pill form-control "  required/>
                            </div>
                            <div class="col-lg-4">
                                <label class="ml-2 col-form-label font-weight-bold">細項</label>
                                <textarea rows="3" autocomplete="off" type="text" id="EditDging_note" name="EditDging_note" class="rounded-pill form-control "  ></textarea>
                            </div>
                            <div class="col-lg-4">
                                <label class="ml-2 col-form-label font-weight-bold">單項金額</label>
                                <input autocomplete="off" type="number" id="EditDging_price" name="EditDging_price" class="rounded-pill form-control" required/>
                            </div>
                            
                        </div>
                        <div style="display: flex;justify-content: end">
                            <div class="mb-3" style="padding: 10px;">
                                <div style="float: right;">
                                    <button type="submit" class="btn btn-green rounded-pill">儲存</button>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="deleteDgingModal" role="dialog" aria-labelledby="deleteDgingModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog " role="document">
        <div class="modal-content" >
            <div class="modal-header border-0">
                <h5 class="modal-title">確定要刪除？</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-target="#GdingModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group col-lg-12 d-flex justify-content-center">
                    <form id="DeleteDgingModal_form" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-target="#GdingModal">否</button>
                        <button type="submit" class="btn btn-primary">是</button>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="InvoiceCheckModal" tabindex="-1" role="dialog" aria-labelledby="InvoiceCheck" aria-hidden="true">
    <div class="modal-dialog" style="max-width:90vw" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>選取請款單</h5>
                <button type="button" id="InvoiceCheck_button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card border-0 shadow" style="min-height: calc(100vh - 135px)">
                            <div class="card-body show-project-invoice">
                                <!--<div class="form-group col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <input type="text" name="search-num" id="search-num" class="form-control  rounded-pill" placeholder="請款單號" autocomplete="off" onkeyup="searchNum()">
                                        </div>
                                        <div class=" col-lg-4">
                                            <input type="text" name="search" id="search" class="form-control  rounded-pill" placeholder="請款事項" autocomplete="off" onkeyup="searchInvoice()">
                                        </div>
                                    </div>
                                </div>-->
                                <div class="form-group col-lg-12 d-flex justify-content-between">
                                    <div id="invoice-page-performance" class="d-flex align-items-end">
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
                                    <table id="search-invoice-performance">
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="createPerformanceModal" role="dialog" aria-labelledby="createPerformanceModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog " style="max-width: 70%" role="document">
        <div class="modal-content" >
            <div class="modal-header border-0">
                <h5 class="modal-title">新增履約保證金資料</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group col-lg-12 d-flex justify-content-center">
                    <form action='performance/create/review' method="POST" style="width:100%" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group row justify-content-center" >
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="label-style col-form-label" for="deposit">履保金金額</label>
                                <input autocomplete="off" type="number" id="deposit" name="deposit" class="form-control rounded-pill{{ $errors->has('deposit') ? ' is-invalid' : '' }}" value="{{ old('deposit') }}" required>
                                @if ($errors->has('deposit'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('deposit') }}</strong>
                                </span> @endif
                            </div>
                            <div class="col-lg-3 col-md-4 form-group">
                                <label class="label-style col-form-label" for="invoice_finished_id">請款單號</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="invoice_id" name="invoice_id" hidden>
                                    <input readonly style="border-top-left-radius: 25px;border-bottom-left-radius: 25px" id="invoice_finished_id" autocomplete="off" type="text" name="invoice_finished_id" class="form-control {{ $errors->has('invoice_finished_id') ? ' is-invalid' : '' }}" value="{{ old('invoice_finished_id') }}">
                                    <div class="input-group-append">
                                        <button onclick="showInvoiceChoice('create')" aria-label="Close" data-dismiss="modal" class="btn btn-green" type="button" id="button-addon2" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">請款單</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="label-style col-form-label" for="deposit_date">履保金繳交時間</label>
                                <input autocomplete="off" type="date" id="deposit_date" name="deposit_date" class="form-control rounded-pill{{ $errors->has('deposit_date') ? ' is-invalid' : '' }}" value="{{ old('deposit_date') }}" >
                                @if ($errors->has('deposit_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('deposit_date') }}</strong>
                                </span> @endif
                            </div>
                        </div>
                        @if(\Auth::user()->role == 'manager' || \Auth::user()->role == 'administrator')
                        <div class="form-group row justify-content-center" >
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="label-style col-form-label" for="PayBack_date">履保金回繳時間</label>
                                <input autocomplete="off" type="date" id="PayBack_date" name="PayBack_date" class="form-control rounded-pill{{ $errors->has('PayBack_date') ? ' is-invalid' : '' }}" value="{{ old('PayBack_date') }}" >
                                @if ($errors->has('PayBack_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('PayBack_date') }}</strong>
                                </span> @endif
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="label-style col-form-label" for="PayBack_file">履保金回繳證明</label>
                                <input autocomplete="off" type="file" id="PayBack_file" name="PayBack_file" class="form-control rounded-pill{{ $errors->has('PayBack_file') ? ' is-invalid' : '' }}" value="{{ old('PayBack_file') }}" >
                                @if ($errors->has('PayBack_file'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('PayBack_file') }}</strong>
                                </span> @endif
                            </div>
                        </div>
                        @endif
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-green rounded-pill">儲存</button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="editPerformanceModal" role="dialog" aria-labelledby="editPerformanceModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog " style="max-width: 70%" role="document">
        <div class="modal-content" >
            <div class="modal-header border-0">
                <h5 class="modal-title">更新履約保證金資料</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group col-lg-12 d-flex justify-content-center">
                    <form action="performance/{{$data['project']->performance_id}}/update" method="POST" style="width:100%" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group row justify-content-center" >
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="label-style col-form-label" for="deposit_update">履保金金額</label>
                                <input autocomplete="off" type="number" id="deposit_update" name="deposit_update" class="form-control rounded-pill{{ $errors->has('deposit_update') ? ' is-invalid' : '' }}" value="{{$data['project']->performance['deposit']}}" required>
                                @if ($errors->has('deposit_update'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('deposit_update') }}</strong>
                                </span> @endif
                            </div>
                            <div class="col-lg-3 col-md-4 form-group">
                                <label class="label-style col-form-label" for="invoice_finished_id_update">請款單號</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="invoice_id_update" name="invoice_id_update" value="{{$data['project']->performance['invoice_id']}}" hidden>
                                    <input readonly style="border-top-left-radius: 25px;border-bottom-left-radius: 25px" id="invoice_finished_id_update" autocomplete="off" type="text" name="invoice_finished_id_update" class="form-control {{ $errors->has('invoice_finished_id_update') ? ' is-invalid' : '' }}" value="{{$data['project']->performance['invoice_finished_id']}}">
                                    <div class="input-group-append">
                                        <button onclick="showInvoiceChoice('update')" aria-label="Close" data-dismiss="modal" class="btn btn-green" type="button" id="button-addon2" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">請款單</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="label-style col-form-label" for="deposit_date_update">履保金繳交時間</label>
                                <input autocomplete="off" type="date" id="deposit_date_update" name="deposit_date_update" class="form-control rounded-pill{{ $errors->has('deposit_date_update') ? ' is-invalid' : '' }}" value="{{$data['project']->performance['deposit_date']}}" >
                                @if ($errors->has('deposit_date_update'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('deposit_date_update') }}</strong>
                                </span> @endif
                            </div>
                        </div>
                        @if(\Auth::user()->role == 'manager' || \Auth::user()->role == 'administrator')
                        <div class="form-group row justify-content-center" >
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="label-style col-form-label" for="PayBack_date_update">履保金回繳時間</label>
                                <input autocomplete="off" type="date" id="PayBack_date_update" name="PayBack_date_update" class="form-control rounded-pill{{ $errors->has('PayBack_date_update') ? ' is-invalid' : '' }}" value="{{$data['project']->performance['PayBack_date']}}" >
                                @if ($errors->has('PayBack_date_update'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('PayBack_date_update') }}</strong>
                                </span> @endif
                            </div>
                            <div class="form-group col-lg-3 col-md-4">
                                <label class="label-style col-form-label" for="payBack_file_update">履保金回繳證明</label>
                                <input type="file" id="payBack_file_update" name="payBack_file_update" class="form-control rounded-pill{{ $errors->has('payBack_file_update') ? ' is-invalid' : '' }}">
                               
                                @if ($errors->has('payBack_file_update'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('payBack_file_update') }}</strong>
                                </span> @endif
                            </div>
                        </div>
                        @endif
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-green rounded-pill">儲存</button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

@stop
<link href="{{ URL::asset('css/pm/project.css') }}" rel="stylesheet">
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.14.0/dist/xlsx.full.min.js"></script>

    
<script type="text/javascript">
//共用設定值-----------------------------------------------------------------------------------
    var projectData = []
    var persens = []
    var defaults = []
    var parent = document.getElementById('default_table')
    var div = document.createElement('div')
    var default_num = 0
    var totalActualCost = 0
    var total_default = 0
    var FinalAmount = 0
    var GdingCost = 0
    var Today = new Date()
</script>

<script>
//初始類---------------------------------------------------------------------------------------
    $(document).ready(function() {  //初始FUNCTION
        
        projectData = getProjectData()
        default_num = projectData.defaults.length
        document.getElementById('default_num').value = default_num
        
        setBoundTable()
        setDefaultTable()
        setActualCost()
        setInvoice()
        setGDing()
        setInvoiceCheck()
        ChangeStatusOption()
        $('#invoice_cost_button').click(function(){
            nowPage = 1
            setInvoiceTable()
    
        });
        $('#dging_cost_button').click(function(){
            nowDgingPage = 1
            setDGingTable()
    
        });
    });
    
    function update(){
        setBoundTable()
        setdefault()
        setActualCost()
        ChangeStatusOption()
    }
    

    function setDefaultTable(){     //初始設定資料庫原有資料上TABLE
        
        var contract_value = document.getElementById('contract_value').value
        default_num =projectData.defaults.length
        $('#default_table').empty()
        var parent = document.getElementById('default_table')
        var thead = document.createElement('thead')
        thead.innerHTML = '<tr>' +
                '<th style="width: 40%">違約工項說明</th>' +
                '<th style="width: 10%">%數</th>' +
                '<th style="width: 20%">日期</th>' +
                '<th style="width: 15%">金額</th>' +
                '<th style="width: 15%">按鈕</th>' +
            '</tr>'
        parent.appendChild(thead)
        var tbody = document.createElement('tbody')
        for(var i = 0;i<projectData.defaults.length;i++){
            
            tbody.innerHTML = tbody.innerHTML + "<tr id=\"default_tr_" + (i+1) + "\">" +
                "<td ><span style=\"width: 100%;text-align:center;border-style:none\"  id = \"default_content_"+ (i+1) +"\" name =\"default_content_"+ (i+1) +"\" readonly>" + projectData.defaults[i].content +"</span></td>" + 
                "<td ><span style=\"width: 100%;text-align:center;border-style:none\"  id = \"default_persen_"+ (i+1) +"\" name =\"default_persen_"+ (i+1) +"\">"+ projectData.defaults[i].persen +"</span></td>" +
                "<td ><span style=\"width: 100%;text-align:center;border-style:none\"  id = \"default_date_"+ (i+1) +"\" name =\"default_date_"+ (i+1) +"\">"+projectData.defaults[i].default_date+"</span></td>" + 
                "<td ><span style=\"width: 100%;text-align:center;border-style:none\"  id = \"default_amount_"+ (i+1) +"\" name =\"default_amount_"+ (i+1) +"\"></span></td>" + 
                "<td ><div style=\"display:flex;justify-content: space-around;\" class=\"mx-2 icon-red\" ><i class=\"fas fa-edit\" onclick=\"editDefault("+ i +")\"></i><i class=\"fas fa-trash-alt\" onclick=\"deleteDefaultModal("+ i +")\"></i></div></td>"
                '</tr>'
        }
        parent.appendChild(tbody);
        
        var default_input = document.getElementById('default_talbe_input')
        var div = document.createElement('div')
        update()//金額處理
    }
</script>
 
<script>
//設定類---------------------------------------------------------------------------------------
    function setdefault(){      //若有新增或是刪除Default，更新扣款金額
        var contract_value = document.getElementById('contract_value').value
        var default_fine = document.getElementById('default_fine')

        total_default = 0

        for(var i = 0 ; i < default_num ; i++){
            var persen =  document.getElementById('default_persen_'+ (i+1)).textContent

            var amount = Math.round(contract_value * persen / 100)
            $('#default_amount_' + (i+1)).text(commafy(amount))
            console.log('default_amount_' +  (i+1) + "  " + commafy(amount))
            total_default = total_default + amount
        }
        default_fine.value = total_default
    }

    function setTex(){
        var contract_value = document.getElementById('contract_value').value
        var times = document.getElementById('Acceptance_times').value
        
        for(var i = 0 ; i < times ; i++){
            
            var total_amount = Math.round(contract_value * persens[i] / 100)
            var tex = Math.round(total_amount*0.05)
            var amount = Math.round(total_amount-tex)
            $('#amount_' + (i+1)).html(commafy(amount))
            $('#tex_' + (i+1)).html(commafy(tex))
            $('#total_amount_' + (i+1) ).html(commafy(total_amount))
        }
    }

    function setActualCost(){
        totalActualCost = 0
        var actual_cost = document.getElementById('actual_cost')
        var invoice = "{{$data['project']->invoices}}"
        invoice = invoice.replace(/[\n\r]/g, "")
        invoice = JSON.parse(invoice.replace(/&quot;/g, '"'));
        
        
        for (var i = 0; i < invoice.length; i++) {
            
            if(invoice[i].status != 'delete' ){
                totalActualCost += invoice[i].price
            }
            if(projectData.performance_id != null){
                if(invoice[i].finished_id == projectData.performance.invoice_finished_id){
                    totalActualCost -= invoice[i].price
                }
            }
            
        }
        var GdingCost = 0
        var Gding = "{{$data['gding_table']}}"
        Gding = Gding.replace(/[\n\r]/g, "")
        Gding = JSON.parse(Gding.replace(/&quot;/g, '"'));
        for (var i = 0; i < Gding.length; i++) {
            GdingCost += Gding[i].price*1.05
        }
        totalActualCost += parseInt(GdingCost.toFixed())
        totalActualCost += total_default
        actual_cost.value = totalActualCost
        setActualProfit()
    }
    
    function setActualProfit(){
        actualProfit = 0
        FinalAmount = document.getElementById('contract_value').value
        var actual_profit = document.getElementById('actual_profit')
        var actualProfit = FinalAmount * 0.95 - totalActualCost
        actual_profit.value = actualProfit
    }
</script>
   
<script>
//編輯驗收類---------------------------------------------------------------------------------------
    function setBoundTable(){   //設定驗收TABLE
        var name = ''
        var times = document.getElementById('Acceptance_times').value
        var contract_value = document.getElementById('contract_value').value
        $('#bound_table').empty()
        var parent = document.getElementById('bound_table')

        var thead = document.createElement('thead')
        thead.innerHTML = "<tr>" + 
            "<th style=\"width: 20%\">驗收期數</th>"+
            "<th style=\"width: 20%\">本期%數</th>" +
            "<th style=\"width: 20%\">應稅價</th>" +
            "<th style=\"width: 20%\">5%稅</th>" +
            "<th style=\"width: 20%\">總計</th>" +
        "</tr>"
        parent.appendChild(thead);

        var tbody = document.createElement('tbody')
        persens = []
        
        for(var i = 1;i<=times;i++){
            var persen_num = document.getElementById('acceptance_persen_' + i).value;
            persens.push(persen_num)
            if(i == times){name = '期末結案驗收'}
            else{name = '第' + i +'次期中驗收'}
            tbody.innerHTML = tbody.innerHTML + '<tr>' +
                                '<td>' + name + '</td>'+
                                '<td>' + persen_num + '</td>'+
                                "<td id=\"amount_"+ i +"\"></td>"+
                                "<td id=\"tex_"+ i +"\"></td>"+
                                "<td id=\"total_amount_"+ i +"\"></td>" +
                                "</tr>"
        }
        parent.appendChild(tbody);

        setTex()
    }

    function acceptanceChange(id){      //合約驗收次數更新
        
        var acceptance_times = document.getElementById(id).value
        $('#acceptance').empty()
        var parent = document.getElementById('acceptance')
        var div = document.createElement("div");
        var data = ''
        
        for(var i = 0 ; i < acceptance_times ; i++){
            
            if( i+1 == acceptance_times){
                data = '期末結案驗收';
            }
            else{
                data = '第'+ (i+1) + '次期中驗收'
            }
            div.innerHTML = div.innerHTML + '<div class="time-line">'+
                            '<i class="time-i" style="background-color:#7338ff;"><i style="background-color:#b19df8;"></i></i>' +
                            '<div class="ml-4">' +
                            '<div class="ml-1">' +
                            '<span style="background-color:#7338ff;">'+ data +'</span>' + 
                            '<input type="date" id="acceptance_date_'+ (i+1) +'" name="acceptance_date_'+(i+1)+'" value="" class="my-1 form-control" placeholder="" required>' +
                            '<div class="persenLine">'+
                            '<input type="text" id="acceptance_persen_'+(i+1)+'" name="acceptance_persen_'+(i+1)+'" value="" onkeyup="setBoundTable()" style="display: inline;width:auto" class="my-1 form-control" placeholder="驗收標金 % 數" required>' +
                            '<p style="display: inline"> % </p>' +
                            '</div>'+ 
                            '</div>'+
                            '</div>'+
                            '</div>';
                            
        }
        parent.appendChild(div);
        setBoundTable()
    }

    
</script>
    
<script>
//編輯Default類---------------------------------------------------------------------------------------
    function editDefault(val){  //BUTTON(EDIT) MODAL SHOW
        document.getElementById('edit_default_persen').value = document.getElementById('default_persen_'+(val+1)).textContent
        document.getElementById('edit_default_content').value = document.getElementById('default_content_'+(val+1)).textContent
        document.getElementById('edit_default_date').value = document.getElementById('default_date_'+(val+1)).textContent
        document.getElementById('edit_default_remenber').value = val+1
        $("#editDefaultForm").attr("action","defaultItem/" + projectData.defaults[val].id +"/update");
        changedefaultAmount('edit')
        $("#editDefaultModal").modal('show')
    }

    function changedefaultAmount(val){
        if(val == 'add'){
            var defaultAmount = document.getElementById('default_amount');
            var defaultpersen = document.getElementById('default_persen').value;
            var contract_value = document.getElementById('contract_value').value
            defaultAmount.value = defaultpersen * contract_value / 100;
        }
        else if(val == 'edit'){
            var defaultAmount = document.getElementById('edit_default_amount');
            var defaultpersen = document.getElementById('edit_default_persen').value;
            var contract_value = document.getElementById('contract_value').value
            defaultAmount.value = defaultpersen * contract_value / 100;
        }
    }

    
</script>
    
<script>
//新增/刪除Default類---------------------------------------------------------------------------------------
    function deleteDefaultModal(val){
        document.getElementById('deleteContent').innerHTML  = document.getElementById('default_content_' + (val+1)).innerHTML
        document.getElementById('deleteContent_id').value = val+1
        
        $("#deleteDefaultForm").attr("action","defaultItem/" + projectData.defaults[val].id +"/delete");
        $('#deleteDefaultModal').modal('show')
        
    }

</script>

<script>
//功能類---------------------------------------------------------------------------------------
    function getProjectData(){  //取得Project所有資料
        var data = "{{$data['project']}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        console.log(data)
        return data;
    }
    
    function commafy(num) {     //更新金額顯示方式
        num = num + "";
        var re = /(-?\d+)(\d{3})/
        while (re.test(num)) {
            num = num.replace(re, "$1,$2")
        }
        return num;
    }

    function openDefaultModal(){    //打開DEFAULT MODAL
        $('#default_persen').val('')
        $('#default_amount').val('')
        $('#default_date').val(Today.getFullYear() + '-' + (Today.getMonth()+1) +'-'+Today.getDate() )
        $('#default_content').val('')
        $('#defaultModal').modal('show')
    }

    function cleandefault(val){ //清理Default的Modal框
        if(val =='edit'){
            document.getElementById('edit_default_amount').value = ""
            document.getElementById('edit_default_persen').value = ""
            document.getElementById('edit_default_date').value = ""
            document.getElementById('edit_default_content').value = ""
        }
        else if(val == 'add'){
            document.getElementById('default_amount').value = ""
            document.getElementById('default_persen').value = ""
            document.getElementById('default_date').value = ""
            document.getElementById('default_content').value = ""
        }
       
    }

    function setTextArea(){
        var textarea = document.getElementById('project_note').value
        textarea = textarea.replace(/\r/ig, '').replace(/\n/ig, '<br/>')
    }
    function setGdingTextArea(val){
        var textarea = document.getElementById('note-'+val).value
        textarea = textarea.replace(/\r/ig, '').replace(/\n/ig, '<br/>')
    }
    
    function setGdingTextArea_show(val){ 
        console.log(val)
        val = val.replace(/\r?\n/g, '<br/>')
        return val;
        
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
        data="{{$data['invoice_table']}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));

        return data
    }

    function setInvoiceCost(){
        var InvoiceCost = 0
        var invoice = "{{$data['project']->invoices}}"
        invoice = invoice.replace(/[\n\r]/g, "")
        invoice = JSON.parse(invoice.replace(/&quot;/g, '"'));
        console.log(invoice)
        for (var i = 0; i < invoice.length; i++) {
            if(invoice[i].status != 'delete' ){
                
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
        
        
        tr = "<tr>" +
            "<td width='15%'><div class=\"d-flex justify-content-center\">" + sgin + invoice_table[i].finished_id + "</div></td>" +
            "<td width='20%'>" + invoice_table[i].company + "</td>" +
            "<td width='30%'>" + invoice_table[i].title + "</a></td>" +
            "<td width='10%'>" + commafy(invoice_table[i].price) + "</td>" +
            "<td width='15%'>" + invoice_table[i].created_at.substr(0, 10) + "</td>" +
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
        data="{{$data['gding_table']}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }
    function setDGingCost(){
        
        var Gding = "{{$data['gding_table']}}"
        Gding = Gding.replace(/[\n\r]/g, "")
        Gding = JSON.parse(Gding.replace(/&quot;/g, '"'));
        for (var i = 0; i < Gding.length; i++) {
            GdingCost += (Gding[i].price * 1.05)
        }
        GdingCost = GdingCost.toFixed()
        $('#dging_cost').text("$" + commafy(GdingCost));
    }
    function setDGingTable(){
        listDGingPage()
        listDGing()
        list_table()
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
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeDGingPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                } else {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changeDGingPage(' + number + ')">' + number + '</a></li>'
                    break
                }
            }
        } else if (nowDgingPage >= 4 && nowDgingPage - 3 <= 2) {
            for (var i = 0; i < number; i++) {
                if (i < nowDgingPage + 2) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeDGingPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                } else {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changeDGingPage(' + number + ')">' + number + '</a></li>'
                    break
                }
            }
        } else if (nowDgingPage >= 4 && nowDgingPage - 3 > 2 && number - nowDgingPage > 5) {
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeDGingPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= nowDgingPage - 3 && i <= nowDgingPage + 1) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeDGingPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'

                } else if (i > nowDgingPage + 1) {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changeDGingPage(' + number + ')">' + number + '</a></li>'
                    break
                }


            }
        } else if (number - nowDgingPage <= 5 && number - nowDgingPage >= 4) {
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeDGingPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= nowDgingPage - 3) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeDGingPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                }
            }
        } else if (number - nowDgingPage < 4) {
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeDGingPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= number - 5) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeDGingPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
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
            '<th>單項金額(含稅)</th>' +
            '<th>修改</th>' +
            '<th>刪除</th>' +
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
        if(DGing_table[i].note == null){
            var DGing_note = ''
        }else{
            var DGing_note = DGing_table[i].note
        }
        DGing_note = setGdingTextArea_show(DGing_note)
        tr = "<tr>" +
            "<td width='10%'>" + DGing_table[i].num + "</td>" +
            "<td width='30%'>" + DGing_table[i].title + "</td>" +
            "<td width='40%'>" + DGing_note + "</td>" +
            "<td width='10%'>" + commafy((DGing_table[i].price*1.05).toFixed()) + "</td>" +
            "<td width='5%'><i class='fas fa-search-dollar' id=\"EditDgingModal_" + DGing_table[i].num + "\" data-id = \""+ DGing_table[i].id +"\" data-toggle=\"modal\" data-dismiss=\"modal\" data-target=\"#EditDgingModal\"></td>"+
            "<td width='5%'><i class='fas fa-trash-alt' id=\"deleteDgingModal_" + DGing_table[i].num + "\" data-id = \""+ DGing_table[i].id +"\"  data-toggle=\"modal\" data-dismiss=\"modal\" data-target=\"#deleteDgingModal\"></td>"+
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

    var item_num = 5;

    function list_table(){
        $('#Itemtable').empty();
        var parent = document.getElementById('Itemtable');
        var head = document.createElement('thead')
        head.innerHTML = '<tr class="bg-dark text-white" style="text-align:center">' +
            '<th class="px-2" width="5%">' +
            '<th class="px-2" width="25%"><label class="label-style col-form-label" for="content">項目</label></th>' +
            '<th class="px-2" width="30%"><label class="label-style col-form-label" for="amount">細項</label></th>' +
            '<th class="px-2" width="20%"><label class="label-style col-form-label" for="price">價錢</label></th>' +
            '<th class="px-2" width="20%"><label class="label-style col-form-label" for="price_tax">價錢(含稅價)</label></th>' +
            '</tr>'
        parent.appendChild(head);
        var body = document.createElement("tbody");
        body.setAttribute("id","Itembody");
        for(var i = 0;i<item_num;i++ ){
            if(i != 5){
                body.innerHTML = body.innerHTML + '<tr style="vertical-align: top;">' +
                    '<th class="p-2">' + (i+1) + '</th>' +
                    '<th class="p-2"><input autocomplete="off" type="text" id="title-' + i + '" name="title-'+ i + '" class="rounded-pill form-control{{ $errors->has("title-'+ i +'") ? " is-invalid" : "" }}" onkeyup="setRequired('+ i +')" value="{{ old("title-'+ i +'") }}"></th>' +
                    '<th class="p-2"><textarea autocomplete="off" rows="3" type="text" id="note-'+ i +'" name="note-'+ i +'" oninput="setGdingTextArea('+ i + ')" class="rounded-pill form-control{{ $errors->has("note-'+ i +'") ? " is-invalid" : "" }}">{{ old("note-'+ i +'") }}</textarea></th>' +
                    '<th class="p-2"><input autocomplete="off" type="number" id="price-'+ i +'" name="price-'+ i +'" class="rounded-pill form-control{{ $errors->has("price-'+ i +'") ? " is-invalid" : "" }}" onkeyup="setRequired('+ i +')" value="{{ old("price-'+ i +'") }}"></th>' +
                    '<th class="p-2"><input autocomplete="off" type="number" id="price-tax-'+ i +'" name="price-tax-'+ i +'" class="rounded-pill form-control{{ $errors->has("price-tax-'+ i +'") ? " is-invalid" : "" }}" value="{{ old("price-tax-'+ i +'") }}" readonly></th>' +
                    '</tr>'
            }
        }
        parent.appendChild(body);
    }

    function setRequired(val){
        title = document.getElementById('title-'+val)
        price = document.getElementById('price-'+val)
        price_tax = document.getElementById('price-tax-'+ val)
        if(title.value != ''){
            title.required = true;
            price.required = true;

        }else{
            title.required = false;
            price.required = false;
        }
        if(price.value != ''){
            price_tax.value = (price.value*1.05).toFixed()
        }
    }
</script>
<script>
//Invoice列表設定類---------------------------------------------------------------------------------------
    var invoice_check = []
    var invoice_check_page = 1;
    var check_type = ''
    function showInvoiceChoice(val){
        if(val == 'create'){
            check_type = 'create'
            listInvoiceCheck()
            $('#editPerformanceModal').modal('hide')
            $('#InvoiceCheck_button').attr('data-target',"#createPerformanceModal")
            
        }else if(val == 'update'){
            check_type = 'update'
            listInvoiceCheck()
            $('#InvoiceCheck_button').attr('data-target',"#editPerformanceModal")
            $('#createPerformanceModal').modal('hide')
           
        }
        $('#InvoiceCheckModal').modal('show')
        
    }

    function InvoiceChoice(val){
        $('#invoice_id').val(invoice_check[val].invoice_id)
        $('#invoice_finished_id').val(invoice_check[val].finished_id)
        $('#deposit').val(invoice_check[val].price)
        $('#InvoiceCheckModal').modal('hide')
        $('#createPerformanceModal').modal('show')
    }

    function InvoiceUpdate(val){
        $('#invoice_id_update').val(invoice_check[val].invoice_id)
        $('#invoice_finished_id_update').val(invoice_check[val].finished_id)
        $('#deposit_update').val(invoice_check[val].price)
        $('#InvoiceCheckModal').modal('hide')
        $('#editPerformanceModal').modal('show')
    }

    function setInvoiceCheck(){
        invoice_check = getNewInviceTable()
        setInvoiceCheckTable()

    }
    
    function getNewInviceTable(){
        data="{{$data['invoice_table']}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));

        return data
    }

    function setInvoiceCheckTable(){
        listInvoiceCheckPage()
        listInvoiceCheck()

    }

    function nextInvoiceCheckPage() {
        var number = Math.ceil(invoice_check.length / 13)

        if (invoice_check_page < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(invoice_check_page)).removeClass('active')
            invoice_check_page++
            $(".page-" + String(invoice_check_page)).addClass('active')
            listPage()
            listInvoice()
        }

    }

    function previousInvoiceCheckPage() {
        var number = Math.ceil(invoice_check.length / 13)

        if (invoice_check_page > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(invoice_check_page)).removeClass('active')
            invoice_check_page--
            $(".page-" + String(invoice_check_page)).addClass('active')
            listPage()
            listInvoice()
        }

    }

    function changeInvoiceCheckPage(index) {

        var temp = document.getElementsByClassName('page-item')

        $(".page-" + String(invoice_check_page)).removeClass('active')
        invoice_check_page = index
        $(".page-" + String(invoice_check_page)).addClass('active')

        listPage()
        listInvoice()

    }

    function listInvoiceCheckPage() {
        $("#invoice-page-performance").empty();
        var parent = document.getElementById('invoice-page-performance');
        var table = document.createElement("div");
        var number = Math.ceil(invoice_check.length / 13)
        var data = ''
        if (invoice_check_page < 4) {
            for (var i = 0; i < number; i++) {
                if (i < 5) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeInvoiceCheckPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                } else {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changeInvoiceCheckPage(' + number + ')">' + number + '</a></li>'
                    break
                }
            }
        } else if (invoice_check_page >= 4 && invoice_check_page - 3 <= 2) {
            for (var i = 0; i < number; i++) {
                if (i < invoice_check_page + 2) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeInvoiceCheckPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                } else {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changeInvoiceCheckPage(' + number + ')">' + number + '</a></li>'
                    break
                }
            }
        } else if (invoice_check_page >= 4 && invoice_check_page - 3 > 2 && number - invoice_check_page > 5) {
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeInvoiceCheckPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= invoice_check_page - 3 && i <= invoice_check_page + 1) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeInvoiceCheckPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'

                } else if (i > invoice_check_page + 1) {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changeInvoiceCheckPage(' + number + ')">' + number + '</a></li>'
                    break
                }


            }
        } else if (number - invoice_check_page <= 5 && number - invoice_check_page >= 4) {
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeInvoiceCheckPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= invoice_check_page - 3) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeInvoiceCheckPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                }
            }
        } else if (number - invoice_check_page < 4) {
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeInvoiceCheckPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= number - 5) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeInvoiceCheckPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                }
            }
        }
        var previous = "previous"
        var next = "next"
        table.innerHTML = '<nav aria-label="Page navigation example">' +
            '<ul class="pagination mb-0">' +
            '<li class="page-item">' +
            '<a class="page-link" href="javascript:void(0)" onclick="previousInvoiceCheckPage()" aria-label="Previous">' +
            '<span aria-hidden="true"><i class="fas fa-caret-left" style="width:14.4px"></i></span>' +
            '</a>' +
            '</li>' +
            data +
            '<li class="page-item">' +
            '<a class="page-link" href="javascript:void(0)" onclick="nextInvoiceCheckPage()" aria-label="Next">' +
            '<span aria-hidden="true"><i class="fas fa-caret-right" style="width:14.4px"></i></span>' +
            '</a>' +
            '</li>' +
            '</ul>' +
            '</nav>'

        parent.appendChild(table);

        $(".page-" + String(invoice_check_page)).addClass('active')
    }

    function listInvoiceCheck() {
        $("#search-invoice-performance").empty();
        var parent = document.getElementById('search-invoice-performance');
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


        for (var i = 0; i < invoice_check.length; i++) {
            if (i >= (invoice_check_page - 1) * 13 && i < invoice_check_page * 13) {
                table.innerHTML = table.innerHTML + setDataInvoiceCheck(i)
            } else if (i >= invoice_check_page * 13) {
                break
            }
        }
        parent.appendChild(table);
    }

    function setDataInvoiceCheck(i) {
        
        if (invoice_check[i].status == 'waiting') {
            span = "<div class='progress' data-toggle='tooltip' data-placement='top' title='第一階段審核中'>" +
                "<div class='progress-bar bg-danger' role='progressbar' style='width: 0%' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'>" +
                "</div>" +
                "</div>";

        } else if (invoice_check[i].status == 'waiting-fix') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='請款被撤回，請修改'>" +
                "<div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"

        } else if (invoice_check[i].status == 'check') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='第二階段審核中'>" +
                "<div class='progress-bar bg-danger' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"

        } else if (invoice_check[i].status == 'check-fix') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='請款被撤回，請修改'>" +
                "<div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"

        } else if (invoice_check[i].status == 'managed') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='請款中'>" +
                "<div class='progress-bar bg-warning' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"

        } else if (invoice_check[i].status == 'matched') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='匯款中'>" +
                "<div class='progress-bar bg-success' role='progressbar' style='width: 75%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"

        } else if (invoice_check[i].status == 'complete') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='匯款完成'>" +
                "<div class='progress-bar bg-info' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"
        } else if(invoice_check[i].status == 'delete') {
            span = " <div title='已註銷'>" +
                "<img src='{{ URL::asset('gif/cancelled.png') }}' alt='' style='width:100%'/>" +
                "</div>"
        }
        
        if(invoice_check[i].status != 'delete') {
            
            if(check_type == 'create'){
                
                check_icon = "<a onclick=\"InvoiceChoice('" + i + "')\"><i class=\"fas fa-hand-pointer\"></i>"
            }
            else if(check_type == 'update'){
                console.log(check_icon)
                check_icon = "<a onclick=\"InvoiceUpdate('" + i + "')\"><i class=\"fas fa-hand-pointer\"></i>"
            }
        }
        else{
            
            check_icon =""
        }
    
        tr = "<tr>" +
            "<td width='15%'>" + invoice_check[i].finished_id + "</td>" +
            "<td width='20%'>" + invoice_check[i].company + "</td>" +
            "<td width='30%'>" + invoice_check[i].title + "</a></td>" +
            "<td width='10%'>" + commafy(invoice_check[i].price) + "</td>" +
            "<td width='15%'>" + invoice_check[i].created_at.substr(0, 10) + "</td>" +
            "<td width='5%'>" + span + "</td>" +
            "<td width='5%'>" + check_icon + "</td>" + 
            "</tr>"


        return tr
    }






</script>
<script>
//成本利潤表設定類---------------------------------------------------------------------------------------
    function UpLoadStatement(){
        var Statement_file = document.getElementById('income_statement')
        var Statement_show = document.getElementById('Statement_show')

        Statement_show.innerText = '已上傳新資料'
    }

    function ChangeStatusOption(){
        effective_interest_rate_change = document.getElementById('effective_interest_rate_change')
        actual_profit = document.getElementById('actual_profit').value
        contract_value = document.getElementById('contract_value').value
        contract_value = contract_value*0.95
        temp  =  (actual_profit/contract_value)*100
        effective_interest_rate_change.value = temp.toFixed(2)
        document.getElementById('effective_interest_rate').value = temp.toFixed(2)
        console.log(document.getElementById('effective_interest_rate_change').value)
    }
</script>
@stop