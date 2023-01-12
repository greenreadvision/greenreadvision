@extends('layouts.app')

@section('content')
<div class="modal fade" id="purchaseModal" tabindex="-1" role="dialog" aria-labelledby="purchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:90vw" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>選取採購單</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <input type="text" name="search-num" id="search-num" class="form-control  rounded-pill" placeholder="採購單號" autocomplete="off" onkeyup="searchNum()">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <input type="text" name="search-purchase" id="search-purchase" class="form-control rounded-pill " placeholder="搜尋" autocomplete="off" onkeyup="searchPurchase()">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">採購人</label>
                                <div class="col-lg-12">
                                    <select type="text" id="select-purchase-user" name="select-purchase-user" onchange="select('user',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control mb-2">
                                        <option value=""></option>
                                        @foreach($data['users'] as $user)
                                        <option value="{{$user['user_id']}}">{{$user['name']}}({{$user['nickname']}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">專案</label>
                                <div class="col-lg-12 mb-2">
                                    <select type="text" id="select-purchase-project-year" name="select-purchase-project-year" onchange="selectProjectYears(this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                        <option value=''></option>
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <select type="text" id="select-purchase-project" name="select-purchase-project" onchange="select('project',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                        <option value=''></option>
                                        <optgroup id="select-purchase-project-grv" label="綠雷德">
                                        <optgroup id="select-purchase-project-rv" label="閱野">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="col-lg-12 col-form-label">年份</label>
                                <div class="col-lg-12">
                                    <select type="text" id="select-purchase-year" name="select-purchase-year" onchange="select('year',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                        <option value=''></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">月份</label>
                                <div class="col-lg-12">
                                    <select type="text" id="select-purchase-month" name="select-purchase-month" onchange="select('month',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                        <option value=''></option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <button class="w-100 btn btn-green rounded-pill" onclick="reset()"><span>重置</span> </button>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div id="page-navigation" class="col-lg-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
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
                        <div class="col-lg-12 table-style-billPayment ">
                            <table id="show-purchase">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <span class="page_title_span">款項管理</span>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a  href="/billPayment" class="page_title_a" >繳款單</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            @if(strpos(URL::full(),'other'))
            <a href="/billPayment/{{$data['billPayment']['other_payment_id']}}/review/other" class="page_title_a" >{{$data['billPayment']['finished_id']}}</a>
            @else
            <a href="/billPayment/{{$data['billPayment']['payment_id']}}/review" class="page_title_a" >{{$data['billPayment']['finished_id']}}</a>
            @endif
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <span class="page_title_span">編輯資料</span>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center" >
    <div class="col-lg-10">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body">
                <div class="col-lg-12">
                    @if($data['billPayment']['status']=="waiting-fix" || $data['billPayment']['status']=="check-fix")
                    @if(strpos(URL::full(),'other'))
                    <form action="../fix/other" method="POST" enctype="multipart/form-data">
                        @else
                        <form action="fix" method="POST" enctype="multipart/form-data">
                            @endif
                            @method('PUT')
                            @csrf
                            <div class="form-group row">
                                @if(\Auth::user()->role =='intern'||\Auth::user()->role =='manager')
                                <div class="col-lg-12 col-form-label" style="padding-left: 0px">
                                    <div  class="col-lg-6 form-group" >
                                        <label class="label-style col-form-label" for="intern_name">實習生姓名</label>
                                        <select type="text" id="intern_name" name="intern_name" class="form-control rounded-pill" autofocus>
                                        @foreach ($data['interns'] as $intern)
                                        console.log($intern->name)
                                        @if($data['billPayment']['intern_name'] == $intern->name)
                                            <option value="{{$intern->name}}" selected>{{$intern->nickname}}</option>
                                        @else
                                            <option value="{{$intern->name}}">{{$intern->nickname}}</option>
                                        @endif
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                @endif
                                <div class="col-lg-6 form-group">
                                    {{--
                                    <div id="otherEditBillPayment">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label class="label-style col-form-label" for="company_name">{{__('customize.company')}}</label>
                                                <select type="text" id="company_name" name="company_name" class="form-control rounded-pill" autofocus>
                                                    <option value="grv">綠雷德</option>
                                                    <option value="rv1">閱野(第一)</option>
                                                    <option value="rv2">閱野(玉山)</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="label-style col-form-label" for="type">類型</label>
                                                <select type="text" id="type" name="type" class="form-control rounded-pill">
                                                    <option value="salary">薪資-工讀生/農博駐場</option>
                                                    <option value="rent">房租-北科</option>
                                                    <option value="insurance">勞健保/勞退</option>
                                                    <option value="accounting">會計師記帳費</option>
                                                    <option value="cash">每月零用金</option>
                                                    <option value="tax">公司營業稅</option>
                                                    <option value="other">其他</option>
                                                </select>
                                            </div>
                                        </div>
    
    
                                    </div>
                                    --}}
                                    <div id="editBillPayment">
                                        <label class="label-style col-form-label" for="project_id">{{__('customize.Project')}}</label>
                                        <select type="text" id="project_id" name="project_id" class="form-control rounded-pill" autofocus>
                                            
                                            <optgroup label="綠雷德">
                                                @foreach($data['grv2'] as $gr2)
                                                @if($gr2['name']!='其他' )
                                                @if($data['billPayment']['project_id'] == $gr2['project_id'])
                                                <option value="{{$gr2['project_id']}}" selected>{{$gr2->name}}</option>
                                                @else
                                                <option value="{{$gr2['project_id']}}">{{$gr2->name}}</option>
                                                @endif
                                                @endif

                                                @endforeach
                                            </optgroup>
                                            <optgroup label="綠雷德(舊))">
                                                @foreach($data['grv'] as $gr)
                                                @if($gr['name']!='其他' )
                                                @if($data['billPayment']['project_id'] == $gr['project_id'])
                                                <option value="{{$gr['project_id']}}" selected>{{$gr->name}}</option>
                                                @else
                                                <option value="{{$gr['project_id']}}">{{$gr->name}}</option>
                                                @endif
                                                @endif

                                                @endforeach
                                            </optgroup>
                                            <optgroup label="閱野">
                                                @foreach($data['rv'] as $r)

                                                @if($data['billPayment']['project_id'] == $r['project_id'])
                                                <option value="{{$r['project_id']}}" selected>{{$r->name}}</option>

                                                @else
                                                <option value="{{$r['project_id']}}">{{$r->name}}</option>
                                                @endif

                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6   form-group">
                                    <label class="label-style col-form-label" for="remittancer">繳款人</label>
    
                                    <input type="text" id="remittancer" autocomplete="off" name="remittancer" class="rounded-pill form-control{{ $errors->has('remittancer') ? ' is-invalid' : '' }}" value="{{$errors->has('remittancer')? old('remittancer'): $data['billPayment']['remittancer']}}" required>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label class="label-style col-form-label" for="title">繳款項目</label>
                                    <input id="title" autocomplete="off" type="text" name="title" class="form-control rounded-pill{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{$errors->has('title')? old('title'): $data['billPayment']['title']}}" required>
                                </div>
    
                                <div class="col-lg-12 form-group">
                                    <label class="label-style col-form-label" for="content"> 繳款事項(100字以內)</label>
                                    <textarea id="content" name="content" rows="5" style="resize:none;" class="form-control rounded-pill{{ $errors->has('content') ? ' is-invalid' : '' }}" required>{{$errors->has('content')? old('content'): $data['billPayment']['content']}}</textarea> @if ($errors->has('content'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>超出100個字</strong>
                                    </span> @endif
                                </div>
                                <div class="col-lg-12">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary active" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px">
                                            <input type="radio" name="options" id="option1" onchange="changeBankData(0)" autocomplete="off"> <span class="mx-2">綠雷德</span>
                                        </label>
                                        <label class="btn btn-secondary">
                                            <input type="radio" name="options" id="option2" onchange="changeBankData(1)" autocomplete="off" > <span class="mx-2">閱野(第一)</span>
                                        </label>
                                        <label class="btn btn-secondary" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">
                                            <input type="radio" name="options" id="option2" onchange="changeBankData(2)" autocomplete="off" > <span class="mx-2">閱野(玉山)</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="label-style col-form-label" for="bank">{{__('customize.bank')}}</label>
                                    <input autocomplete="off" type="text" id="bank" name="bank" class="form-control rounded-pill{{ $errors->has('bank') ? ' is-invalid' : '' }}" value="{{ old('bank') }}" required>
                                    @if ($errors->has('bank'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank') }}</strong>
                                    </span> @endif
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="label-style col-form-label" for="bank_branch">{{__('customize.bank_branch')}}</label>
                                    <input autocomplete="off" type="text" id="bank_branch" name="bank_branch" class="form-control rounded-pill{{ $errors->has('bank_branch') ? ' is-invalid' : '' }}" value="{{ old('bank_branch') }}" required>
                                    @if ($errors->has('bank_branch'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank_branch') }}</strong>
                                    </span> @endif
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="label-style col-form-label" for="bank_account_number">{{__('customize.bank_account_number')}}</label>
                                    <input autocomplete="off" type="text" id="bank_account_number" name="bank_account_number" class="form-control rounded-pill{{ $errors->has('bank_account_number') ? ' is-invalid' : '' }}" value="{{ old('bank_account_number') }}" required>
                                    @if ($errors->has('bank_account_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank_account_number') }}</strong>
                                    </span> @endif
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="label-style col-form-label" for="bank_account_name">{{__('customize.bank_account_name')}}</label>
                                    <input autocomplete="off" type="text" id="bank_account_name" name="bank_account_name" class="form-control rounded-pill{{ $errors->has('bank_account_name') ? ' is-invalid' : '' }}" value="{{ old('bank_account_name') }}" required>
                                    @if ($errors->has('bank_account_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank_account_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label class="label-style col-form-label">相關匯款證明</label>
                                    <div class="d-flex justify-content-around" style="padding: .375rem .75rem">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="receipt_true" name="receipt" value="1" class="{{ $errors->has('receipt') ? 'is-invalid' : '' }}" {{old('receipt')? 'checked': ''}} required>
                                            <label class="form-check-label ml-1" for="receipt_true">有</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="receipt_false" name="receipt" value="0" class="{{ $errors->has('receipt') ? 'is-invalid' : '' }}" {{old('receipt')? '': 'checked'}}>
                                            <label class="form-check-label ml-1" for="receipt_false">沒有，待補</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label class="label-style col-form-label" for="receipt_date">繳款日期</label>
                                    <input type="date" id="receipt_date" name="receipt_date" class="form-control rounded-pill{{ $errors->has('receipt_date') ? ' is-invalid' : '' }}" value="{{$errors->has('receipt_date')? old('receipt_date'): $data['billPayment']['receipt_date']}}"> @if ($errors->has('receipt_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('receipt_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label class="label-style col-form-label" for="receipt_number">數量(匯款證明)</label>
                                    <input oninput="value=value.replace(/[^\d]/g,'')" autocomplete="off" type="text" id="receipt_number" name="receipt_number" class="form-control rounded-pill{{ $errors->has('receipt_number') ? ' is-invalid' : '' }}" value="{{$errors->has('receipt_number')? old('receipt_number'): $data['billPayment']['receipt_number']}}" required> @if ($errors->has('receipt_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>請輸入數字，不包含字元、標點符號</strong>
                                    </span> @endif
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label class="label-style col-form-label" for="price">繳款金額</label>
                                    <input oninput="value=value.replace(/[^\d]/g,'')" autocomplete="off" type="text" id="price" name="price" class="form-control rounded-pill{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{$errors->has('price')? old('price'): $data['billPayment']['price']}}" required> @if ($errors->has('price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>請輸入數字，不包含字元、標點符號</strong>
                                    </span> @endif
                                </div>
                                <div class="col-lg-4 form-group" onchange="receiptAdjust()">
                                    <label class="label-style col-form-label" for="receipt_file" onchange="receiptAdjust()">匯款證明影本(PDF)</label>
                                    <input type="file" id="receipt_file" name="receipt_file" class="form-control rounded-pill{{ $errors->has('receipt_file') ? ' is-invalid' : '' }}" onchange="receiptAdjust()"> @if ($errors->has('receipt_file'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('receipt_file') }}</strong>
                                    </span> @endif
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label class="label-style col-form-label" for="detail_file">{{__('customize.detail_file')}}</label>
                                    <input type="file" id="detail_file" name="detail_file" class="form-control rounded-pill{{ $errors->has('detail_file') ? ' is-invalid' : '' }}"> @if ($errors->has('detail_file'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('detail_file') }}</strong>
                                    </span> @endif
                                </div>
                                <div class="col-lg-8 form-group">
                                    @if(\Auth::user()->role =='administrator')
                                        <label class="label-style col-form-label" for="review_date">審核日期</label>
                                        <input type="date" id="review_date" name="review_date" class="form-control rounded-pill" value="{{$errors->has('review_date')? old('review_date'): $data['billPayment']['review_date']}}">
                                    @endif
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label class="label-style col-form-label" for="reviewer">審核主管</label>
                                    <input style="color:black;" type="text" id="reviewer" name="reviewer" class="form-control rounded-pill" value="蔡貴瑄" readonly>
                                </div>
                            </div>
                            <div style="float: left;">
                                <button type="button" class="btn btn-red rounded-pill" data-toggle="modal" data-target="#deleteModal">
                                    <i class='ml-2 fas fa-trash-alt'></i><span class="ml-3 mr-2">{{__('customize.Delete')}}</span>
                                </button>
                            </div>
                            <div style="float: right;">
                                <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                            </div>
                        </form>
                        @else
                        @if(strpos(URL::full(),'other'))
                        <form action="../update/other" method="POST" enctype="multipart/form-data">
                            @else
                            <form action="update" method="POST" enctype="multipart/form-data">
                                @endif
                                @method('PUT')
                                @csrf
                                <div class="form-group row">
                                    @if(\Auth::user()->role =='intern'||\Auth::user()->role =='manager')
                                    <div class="col-lg-12 col-form-label" style="padding-left: 0px">
                                        <div  class="col-lg-6 form-group" >
                                            <label class="label-style col-form-label" for="intern_name">實習生姓名</label>
                                            <select type="text" id="intern_name" name="intern_name" class="form-control rounded-pill" autofocus>
                                            @foreach ($data['interns'] as $intern)
                                            console.log($intern->name)
                                            @if($data['billPayment']['intern_name'] == $intern->name)
                                                <option value="{{$intern->name}}" selected>{{$intern->nickname}}</option>
                                            @else
                                                <option value="{{$intern->name}}">{{$intern->nickname}}</option>
                                            @endif
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    @endif
                                    <div class="col-lg-6 form-group">
                                        {{--
                                        <div id="otherEditBillPayment">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label class="label-style col-form-label" for="company_name">{{__('customize.company')}}</label>
                                                    <select type="text" id="company_name" name="company_name" class="form-control rounded-pill" autofocus>
                                                        <option value="grv">綠雷德</option>
                                                        <option value="rv1">閱野(第一)</option>
                                                        <option value="rv2">閱野(玉山)</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="label-style col-form-label" for="type">類型</label>
                                                    <select type="text" id="type" name="type" class="form-control rounded-pill">
                                                        <option value="salary">薪資-工讀生/農博駐場</option>
                                                        <option value="rent">房租-北科</option>
                                                        <option value="insurance">勞健保/勞退</option>
                                                        <option value="accounting">會計師記帳費</option>
                                                        <option value="cash">每月零用金</option>
                                                        <option value="tax">公司營業稅</option>
                                                        <option value="other">其他</option>
                                                    </select>
                                                </div>
                                            </div>
        
        
                                        </div>
                                        --}}
                                        <div id="editBillPayment">
                                            <label class="label-style col-form-label" for="project_id">{{__('customize.Project')}}</label>
                                            <select type="text" id="project_id" name="project_id" class="form-control rounded-pill" autofocus>
                                                
                                                <optgroup label="綠雷德">
                                                    @foreach($data['grv2'] as $gr2)
                                                    @if($gr2['name']!='其他' )
                                                    @if($data['billPayment']['project_id'] == $gr2['project_id'])
                                                    <option value="{{$gr2['project_id']}}" selected>{{$gr2->name}}</option>
                                                    @else
                                                    <option value="{{$gr2['project_id']}}">{{$gr2->name}}</option>
                                                    @endif
                                                    @endif
    
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="綠雷德(舊))">
                                                    @foreach($data['grv'] as $gr)
                                                    @if($gr['name']!='其他' )
                                                    @if($data['billPayment']['project_id'] == $gr['project_id'])
                                                    <option value="{{$gr['project_id']}}" selected>{{$gr->name}}</option>
                                                    @else
                                                    <option value="{{$gr['project_id']}}">{{$gr->name}}</option>
                                                    @endif
                                                    @endif
    
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="閱野">
                                                    @foreach($data['rv'] as $r)
    
                                                    @if($data['billPayment']['project_id'] == $r['project_id'])
                                                    <option value="{{$r['project_id']}}" selected>{{$r->name}}</option>
    
                                                    @else
                                                    <option value="{{$r['project_id']}}">{{$r->name}}</option>
                                                    @endif
    
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6   form-group">
                                        <label class="label-style col-form-label" for="remittancer">繳款人</label>
        
                                        <input type="text" id="remittancer" autocomplete="off" name="remittancer" class="rounded-pill form-control{{ $errors->has('remittancer') ? ' is-invalid' : '' }}" value="{{$errors->has('remittancer')? old('remittancer'): $data['billPayment']['remittancer']}}" required>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label class="label-style col-form-label" for="title">繳款項目</label>
                                        <input id="title" autocomplete="off" type="text" name="title" class="form-control rounded-pill{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{$errors->has('title')? old('title'): $data['billPayment']['title']}}" required>
                                    </div>
        
                                    <div class="col-lg-12 form-group">
                                        <label class="label-style col-form-label" for="content"> 繳款事項(100字以內)</label>
                                        <textarea id="content" name="content" rows="5" style="resize:none;" class="form-control rounded-pill{{ $errors->has('content') ? ' is-invalid' : '' }}" required>{{$errors->has('content')? old('content'): $data['billPayment']['content']}}</textarea> @if ($errors->has('content'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>超出100個字</strong>
                                        </span> @endif
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-secondary active" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px">
                                                <input type="radio" name="options" id="option1" onchange="changeBankData(0)" autocomplete="off"> <span class="mx-2">綠雷德</span>
                                            </label>
                                            <label class="btn btn-secondary">
                                                <input type="radio" name="options" id="option2" onchange="changeBankData(1)" autocomplete="off" > <span class="mx-2">閱野(第一)</span>
                                            </label>
                                            <label class="btn btn-secondary" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">
                                                <input type="radio" name="options" id="option2" onchange="changeBankData(2)" autocomplete="off" > <span class="mx-2">閱野(玉山)</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="bank">{{__('customize.bank')}}</label>
                                        <input autocomplete="off" type="text" id="bank" name="bank" class="form-control rounded-pill{{ $errors->has('bank') ? ' is-invalid' : '' }}" value="{{ old('bank') }}" required>
                                        @if ($errors->has('bank'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bank') }}</strong>
                                        </span> @endif
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="bank_branch">{{__('customize.bank_branch')}}</label>
                                        <input autocomplete="off" type="text" id="bank_branch" name="bank_branch" class="form-control rounded-pill{{ $errors->has('bank_branch') ? ' is-invalid' : '' }}" value="{{ old('bank_branch') }}" required>
                                        @if ($errors->has('bank_branch'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bank_branch') }}</strong>
                                        </span> @endif
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="bank_account_number">{{__('customize.bank_account_number')}}</label>
                                        <input autocomplete="off" type="text" id="bank_account_number" name="bank_account_number" class="form-control rounded-pill{{ $errors->has('bank_account_number') ? ' is-invalid' : '' }}" value="{{ old('bank_account_number') }}" required>
                                        @if ($errors->has('bank_account_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bank_account_number') }}</strong>
                                        </span> @endif
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="bank_account_name">{{__('customize.bank_account_name')}}</label>
                                        <input autocomplete="off" type="text" id="bank_account_name" name="bank_account_name" class="form-control rounded-pill{{ $errors->has('bank_account_name') ? ' is-invalid' : '' }}" value="{{ old('bank_account_name') }}" required>
                                        @if ($errors->has('bank_account_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bank_account_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="label-style col-form-label">相關匯款證明</label>
                                        <div class="d-flex justify-content-around" style="padding: .375rem .75rem">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="receipt_true" name="receipt" value="1" class="{{ $errors->has('receipt') ? 'is-invalid' : '' }}" {{old('receipt')? 'checked': ''}} required>
                                                <label class="form-check-label ml-1" for="receipt_true">有</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="receipt_false" name="receipt" value="0" class="{{ $errors->has('receipt') ? 'is-invalid' : '' }}" {{old('receipt')? '': 'checked'}}>
                                                <label class="form-check-label ml-1" for="receipt_false">沒有，待補</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="label-style col-form-label" for="receipt_date">發票日期</label>
                                        <input type="date" id="receipt_date" name="receipt_date" class="form-control rounded-pill{{ $errors->has('receipt_date') ? ' is-invalid' : '' }}" value="{{$errors->has('receipt_date')? old('receipt_date'): $data['billPayment']['receipt_date']}}"> @if ($errors->has('receipt_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('receipt_date') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="label-style col-form-label" for="receipt_number">數量(匯款證明)</label>
                                        <input oninput="value=value.replace(/[^\d]/g,'')" autocomplete="off" type="text" id="receipt_number" name="receipt_number" class="form-control rounded-pill{{ $errors->has('receipt_number') ? ' is-invalid' : '' }}" value="{{$errors->has('receipt_number')? old('receipt_number'): $data['billPayment']['receipt_number']}}" required> @if ($errors->has('receipt_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>請輸入數字，不包含字元、標點符號</strong>
                                        </span> @endif
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="label-style col-form-label" for="price">繳款金額</label>
                                        <input oninput="value=value.replace(/[^\d]/g,'')" autocomplete="off" type="text" id="price" name="price" class="form-control rounded-pill{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{$errors->has('price')? old('price'): $data['billPayment']['price']}}" required> @if ($errors->has('price'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>請輸入數字，不包含字元、標點符號</strong>
                                        </span> @endif
                                    </div>
                                    <div class="col-lg-4 form-group" onchange="receiptAdjust()">
                                        <label class="label-style col-form-label" for="receipt_file" onchange="receiptAdjust()">匯款證明影本(PDF)</label>
                                        <input type="file" id="receipt_file" name="receipt_file" class="form-control rounded-pill{{ $errors->has('receipt_file') ? ' is-invalid' : '' }}" onchange="receiptAdjust()"> @if ($errors->has('receipt_file'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('receipt_file') }}</strong>
                                        </span> @endif
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="label-style col-form-label" for="detail_file">{{__('customize.detail_file')}}</label>
                                        <input type="file" id="detail_file" name="detail_file" class="form-control rounded-pill{{ $errors->has('detail_file') ? ' is-invalid' : '' }}"> @if ($errors->has('detail_file'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('detail_file') }}</strong>
                                        </span> @endif
                                    </div>
                                    <div class="col-lg-8 form-group">
                                        @if(\Auth::user()->role =='administrator')
                                            <label class="label-style col-form-label" for="review_date">審核日期</label>
                                            <input type="date" id="review_date" name="review_date" class="form-control rounded-pill" value="{{$errors->has('review_date')? old('review_date'): $data['billPayment']['review_date']}}">
                                        @endif
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="label-style col-form-label" for="reviewer">審核主管</label>
                                        <input style="color:black;" type="text" id="reviewer" name="reviewer" class="form-control rounded-pill" value="蔡貴瑄" readonly>
                                    </div>
                                </div>
                                <div style="float: left;">
                                    <button type="button" class="btn btn-red rounded-pill" data-toggle="modal" data-target="#deleteModal">
                                        <i class='ml-2 fas fa-trash-alt'></i><span class="ml-3 mr-2">{{__('customize.Delete')}}</span>
                                    </button>
                                </div>
                                <div style="float: right;">
                                    <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                                </div>
                            </form>
                            @endif
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center ">
                是否刪除?

            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-red rounded-pill" data-dismiss="modal">否</button>
                @if(strpos(URL::full(),'other'))
                <form action="../delete/other" method="POST">
                    @else
                    <form action="delete" method="POST">
                        @endif
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-blue rounded-pill">是</button>
                    </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script ctype="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    var accountNames = []

    var accounts = []
    $(document).ready(function() {
        changeBankData(0)
    });


    function changeBankData(i) {
        if (i == 0) {
            $('input[name="bank"]').val('華南銀行');
            document.getElementById("bank").readOnly = true;
            $('input[name="bank_branch"]').val('板橋分行');
            document.getElementById("bank_branch").readOnly = true;
            $('input[name="bank_account_number"]').val('160-10-008-665-8');
            document.getElementById("bank_account_number").readOnly = true;
            $('input[name="bank_account_name"]').val('綠雷德創新股份有限公司');
            document.getElementById("bank_account_name").readOnly = true;
        } else if(i == 1) {
            $('input[name="bank"]').val('第一銀行');
            document.getElementById("bank").readOnly = true;
            $('input[name="bank_branch"]').val('雙和分行');
            document.getElementById("bank_branch").readOnly = true;
            $('input[name="bank_account_number"]').val('23510036020');
            document.getElementById("bank_account_number").readOnly = true;
            $('input[name="bank_account_name"]').val('閱野文創股份有限公司');
            document.getElementById("bank_account_name").readOnly = true;
        } else {
            $('input[name="bank"]').val('玉山銀行');
            document.getElementById("bank").readOnly = true;
            $('input[name="bank_branch"]').val('中和分行');
            document.getElementById("bank_branch").readOnly = true;
            $('input[name="bank_account_number"]').val('0439-9400-03803');
            document.getElementById("bank_account_number").readOnly = true;
            $('input[name="bank_account_name"]').val('閱野文創股份有限公司');
            document.getElementById("bank_account_name").readOnly = true;
        }
    }
</script>
@stop