@extends('layouts.app')
@section('content')
<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <span class="page_title_span">款項管理</span>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a  href="/invoice" class="page_title_a" >請款單</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <span class="page_title_span">建立請款單</span>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary active" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px">
                                    <input type="radio" name="invoiceType1" id="invoiceType1" onchange="changeInvoiceType(0)" autocomplete="off" checked> <span class="mx-2">專案</span>
                                </label>
                                <label class="btn btn-secondary" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">
                                    <input type="radio" name="invoiceType2" id="invoiceType2" onchange="changeInvoiceType(1)" autocomplete="off"> <span class="mx-2">其他</span>
                                </label>
                            </div>
                        </div>
                        <!-- <div class="col-lg-6">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary " style="border-top-left-radius: 25px;border-bottom-left-radius: 25px">
                                    <input type="radio" name="companyType1" id="companyType1" onchange="changeCompanyType(0)" autocomplete="off"> <span class="mx-2">廠商</span>
                                </label>
                                <label class="btn btn-secondary active" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">
                                    <input type="radio" name="companyType2" id="companyType2" onchange="changeCompanyType(1)" autocomplete="off" checked> <span class="mx-2">其他</span>
                                </label>
                            </div>
                        </div> -->
                    </div>
                    
                    <form name="invoiceForm" action="create/review" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            @if(\Auth::user()->role =='intern'||\Auth::user()->role =='manager')
                            <div class="col-lg-12 col-form-label" style="padding-left: 0px">
                                <div  class="col-lg-6 form-group" >
                                    <label class="label-style col-form-label" for="intern_name">實習生姓名</label>
                                    <select type="text" id="intern_name" name="intern_name" class="form-control rounded-pill" autofocus>
                                    @foreach ($data['interns'] as $intern)
                                        <option value="{{$intern->name}}">{{$intern->nickname}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            @endif

                            <div class="col-lg-6 form-group">
                                <div id="otherCreateInvoice">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="label-style col-form-label" for="company_name">公司</label>
                                            <select type="text" id="company_name" name="company_name" class="form-control rounded-pill" autofocus>
                                                <option value="grv_2">綠雷德</option>
                                                <option value="rv">閱野</option>
                                                <option value="grv">綠雷德(舊)</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="label-style col-form-label" for="type">類型</label>
                                            <select type="text" id="type" name="type" class="form-control rounded-pill" onchange="checkPrice()">
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
                                <div id="createInvoice">
                                    <label class="label-style col-form-label" for="project_id">{{__('customize.Project')}}</label>
                                    <select type="text" id="project_id" name="project_id" class="form-control rounded-pill">
                                        <optgroup label="綠雷德">
                                            @foreach($data['grv2'] as $grv2)
                                            @if( $grv2['finished']==0)
                                            <option value="{{$grv2['project_id']}}">{{$grv2->name}}</option>
                                            @endif
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="綠雷德(舊)">
                                            @foreach($data['grv'] as $gr)
                                            @if($gr['name']!='其他' && $gr['finished']==0)
                                            <option value="{{$gr['project_id']}}">{{$gr->name}}</option>
                                            @endif

                                            @endforeach
                                        </optgroup>
                                        <optgroup label="閱野">
                                            @foreach($data['rv'] as $r)
                                            @if( $r['finished']==0)
                                            <option value="{{$r['project_id']}}">{{$r->name}}</option>
                                            @endif
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>

                            </div>
                            <div class="col-lg-6   form-group">
                                <label class="label-style col-form-label" for="company">{{__('customize.company')}}</label>

                                <input placeholder="廠商名稱" type="text" list="list-account" id="account" autocomplete="off" name="company" class="rounded-pill form-control" onchange="selectAccount(this.value)">
                                <datalist id="list-account">
                                </datalist>
                                <!-- <div id="company">
                                    <label class="label-style col-form-label" for="company">{{__('customize.company')}}</label>
                                    <select disabled="disabled" type="text" id="theCompany" name="company" class="form-control rounded-pill" onchange="addBankData()">
                                        <option value=""></option>
                                        @foreach ($data['bank'] as $bank)
                                        <option value="{{$bank['name']}}">{{$bank['name']}}</option>
                                        @endforeach
                                    </select>
                                </div> -->
                                <!-- <div id="otherCompany">
                                    <label class="label-style col-form-label" for="company">{{__('customize.company')}}</label>
                                    <input id="theOtherCompany" autocomplete="off" type="text" name="company" class="form-control rounded-pill{{ $errors->has('company') ? ' is-invalid' : '' }}" value="{{ old('company') }}" required> @if ($errors->has('company'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company') }}</strong>
                                    </span> @endif
                                </div> -->
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="title">請款項目</label>
                                <input id="title" autocomplete="off" type="text" name="title" class="form-control rounded-pill{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}" require>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="purchase_id">採購單號</label>
                                <div class="input-group mb-3">
                                    <input readonly style="border-top-left-radius: 25px;border-bottom-left-radius: 25px" id="purchase_id" autocomplete="off" type="text" name="purchase_id" class="form-control {{ $errors->has('purchase_id') ? ' is-invalid' : '' }}" value="{{ old('purchase_id') }}">
                                    <div class="input-group-append">
                                        <button onclick="showPurchase()" class="btn btn-green" type="button" id="button-addon2" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">採購單</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-12 col-form-label" for="prepay">是否為預支款?</label>
                                <label class="label-style col-3 col-form-label" for="prepay_false"><input type="radio" id="prepay_false" name="prepay" value="0" class="{{ $errors->has('prepay') ? 'is-invalid' : '' }}" {{old('receipt')? '': 'checked'}}>否</label>
                                <label class="label-style col-3 col-form-label" for="prepay_true"><input type="radio" id="prepay_true" name="prepay" value="1" class="{{ $errors->has('prepay') ? 'is-invalid' : '' }}" {{old('receipt')? 'checked': ''}}>是</label>
                            </div>

                            <div class="col-lg-12 form-group">
                                <label class="label-style col-form-label" for="content"> 請款事項(100字以內)</label>
                                <textarea id="content" name="content" rows="5" style="resize:none;" class="form-control rounded-pill{{ $errors->has('content') ? ' is-invalid' : '' }}" required>{{ old('content') }}</textarea> @if ($errors->has('content'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>超出100個字</strong>
                                </span> @endif
                            </div>
                            <div class="col-lg-12">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px">
                                        <input type="radio" name="options" id="option1" onchange="changeBankData(0)" autocomplete="off"> <span class="mx-2">個人帳戶</span>
                                    </label>
                                    <label class="btn btn-secondary active" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">
                                        <input type="radio" name="options" id="option2" onchange="changeBankData(1)" autocomplete="off" checked> <span class="mx-2">其他</span>
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
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label">{{__('customize.receipt')}}</label>
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
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="receipt_date">{{__('customize.receipt_date')}}</label>
                                <input type="date" id="receipt_date" name="receipt_date" class="form-control rounded-pill{{ $errors->has('receipt_date') ? ' is-invalid' : '' }}" value="{{ old('receipt_date') }}" required> @if ($errors->has('receipt_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('receipt_date') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-4 form-group">
                                <label class="label-style col-form-label" for="remuneration">{{__('customize.remuneration')}}(張數)</label>
                                <input oninput="value=value.replace(/[^\d]/g,'')" autocomplete="off" type="text" id="remuneration" name="remuneration" class="form-control rounded-pill{{ $errors->has('remuneration') ? ' is-invalid' : '' }}" value="{{ old('remuneration') }}" required> @if ($errors->has('remuneration'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>請輸入數字，不包含字元、標點符號</strong>
                                </span> @endif
                            </div>
                            <div class="col-lg-4 form-group">
                                <label class="label-style col-form-label" for="price">{{__('customize.price')}}</label>
                                <input oninput="value=value.replace(/[^\d]/g,'')" onkeyup="checkPrice()" autocomplete="off" type="text" id="price" name="price" class="form-control rounded-pill{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ old('price') }}" required> @if ($errors->has('price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>請輸入數字，不包含字元、標點符號</strong>
                                </span> @endif
                            </div>
                            <div class="col-lg-4 form-group">
                                <label class="label-style col-form-label" for="reviewer">審核主管</label>
                                <select type="text" id="reviewer" name="reviewer" class="form-control rounded-pill" required>
                                    <option value=""></option>
                                    <optgroup id="optgroup-1" label="3000元以下">
                                        <option value="GRV00002">蔡貴瑄</option>
                                    </optgroup>
                                    <optgroup id="optgroup-2" label="3000~10000元">
                                        @foreach($data['reviewers'] as $reviewer)
                                        @if($reviewer['status'] != 'resign')
                                        <option value="{{$reviewer['user_id']}}">{{$reviewer->name}}</option>
                                        @endif
                                        @endforeach-->
                                        <option value="">任何主管</option>
                                    </optgroup>
                                    <optgroup id="optgroup-3" label="10000元以上">
                                        <option value="GRV00001">吳奇靜</option>
                                    </optgroup>
                                    <optgroup id="optgroup-4" label="會計自我審核">
                                        <option value="GRV00002">蔡貴瑄</option>
                                    </optgroup>

                                </select>
                            </div>
                            <div class="col-lg-4 form-group">
                                <label class="label-style col-form-label" for="receipt_file">{{__('customize.receipt_file')}}</label>
                                <input type="file" id="receipt_file" name="receipt_file" class="form-control rounded-pill{{ $errors->has('receipt_file') ? ' is-invalid' : '' }}"> @if ($errors->has('receipt_file'))
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
                            <div class="col-lg-4 form-group">
                                <label class="label-style col-form-label" for="pay_day">付款天數</label>
                                <select id="pay_day" name="pay_day" class="form-control rounded-pill{{ $errors->has('pay_day') ? ' is-invalid' : '' }}">
                                    <option value="30">30</option>
                                    <option value="60">60</option>
                                </select>
                                     @if ($errors->has('pay_day'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('pay_day') }}</strong>
                                </span> @endif
                            </div>
                        </div>
                        <div class="float-right">
                            <button type="submit" class="btn btn-green rounded-pill"><span class="mx-2">新增</span> </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




    </div>
</div>
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
                        <div class="col-lg-12 table-style-invoice ">
                            <table id="show-purchase">
                            </table>
                        </div>
                    </div>
                </div>
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
        setAccount()
        $('#optgroup-1').hide()
        $('#optgroup-2').hide()
        $('#optgroup-3').hide()
        $('#optgroup-4').hide()
    });

    function checkPrice() {
        var p = $('#price').val()
        $('#reviewer').val('')
        if ($('#otherCreateInvoice')[0].style.display == 'block') {
            if ($('#type').val() == 'other') {
                if (p < 3000) {
                    $('#optgroup-1').show()
                    $('#optgroup-2').hide()
                    $('#optgroup-3').hide()
                    $('#optgroup-4').hide()
                } else if (p >= 3000 && p < 10000) {
                    $('#optgroup-1').hide()
                    $('#optgroup-2').show()
                    $('#optgroup-3').hide()
                    $('#optgroup-4').hide()
                } else {
                    $('#optgroup-1').hide()
                    $('#optgroup-2').hide()
                    $('#optgroup-3').show()
                    $('#optgroup-4').hide()
                }
            }
            else{
                $('#optgroup-1').hide()
                $('#optgroup-2').hide()
                $('#optgroup-3').hide()
                $('#optgroup-4').show()
            }
        } else {
            if (p < 3000) {
                $('#optgroup-1').show()
                $('#optgroup-2').hide()
                $('#optgroup-3').hide()
                $('#optgroup-4').hide()
            } else if (p >= 3000 && p < 10000) {
                $('#optgroup-1').hide()
                $('#optgroup-2').show()
                $('#optgroup-3').hide()
                $('#optgroup-4').hide()
            } else {
                $('#optgroup-1').hide()
                $('#optgroup-2').hide()
                $('#optgroup-3').show()
                $('#optgroup-4').hide()
            }
        }

    }

    function selectAccount(value) {
        $('input[name="bank"]').val(accounts[accountNames.indexOf(value)]['bank']);
        $('input[name="bank_branch"]').val(accounts[accountNames.indexOf(value)]['bank_branch']);
        $('input[name="bank_account_number"]').val(accounts[accountNames.indexOf(value)]['bank_account_number']);
        $('input[name="bank_account_name"]').val(accounts[accountNames.indexOf(value)]['bank_account_name']);
    }

    function setAccount() {
        data = "{{$data['bank']}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));

        accounts = [] //初始化
        accountNames = []
        for (var i = 0; i < data.length; i++) {
            accounts.push(data[i])
            accountNames.push(data[i].name)
        }
        accountNames.sort(function(a, b) {
            return a.length - b.length;
        });

        accounts.sort(function(a, b) {
            return a.name.length - b.name.length;
        });

        for (var i = 0; i < accounts.length; i++) {
            $("#list-account").append("<option value='" + accounts[i].name + "'>" + accounts[i].name + "</option>");
        }
    }

    function showPurchase() {
        $('#purchaseModal').modal('show')
    }

    function changeBankData(i) {
        if (i == 0) {
            $('input[name="bank"]').val('{{\Auth::user()->bank}}');
            document.getElementById("bank").readOnly = true;
            $('input[name="bank_branch"]').val('{{\Auth::user()->bank_branch}}');
            document.getElementById("bank_branch").readOnly = true;
            $('input[name="bank_account_number"]').val('{{\Auth::user()->bank_account_number}}');
            document.getElementById("bank_account_number").readOnly = true;
            $('input[name="bank_account_name"]').val('{{\Auth::user()->bank_account_name}}');
            document.getElementById("bank_account_name").readOnly = true;
        } else {
            $('input[name="bank"]').val('');
            document.getElementById("bank").readOnly = false;
            $('input[name="bank_branch"]').val('');
            document.getElementById("bank_branch").readOnly = false;
            $('input[name="bank_account_number"]').val('');
            document.getElementById("bank_account_number").readOnly = false;
            $('input[name="bank_account_name"]').val('');
            document.getElementById("bank_account_name").readOnly = false;
        }
    }

    function addBankData() {
        var data = '{{$data["bank"]}}';
        var bank = JSON.parse(data.replace(/&quot;/g, '"'));
        for (i in bank) {
            if (bank[i].name == document.getElementById('theCompany').value) {
                $('input[name="bank"]').val(bank[i].bank);
                $('input[name="bank_branch"]').val(bank[i].bank_branch);
                $('input[name="bank_account_number"]').val(bank[i].bank_account_number);
                $('input[name="bank_account_name"]').val(bank[i].bank_account_name);
            }
        }
    }

    function changeInvoiceType(i) {
        checkPrice()
        if (i == 0) {
            document.getElementById('otherCreateInvoice').style.display = "none"
            document.getElementById('createInvoice').style.display = "block"
            document.invoiceForm.action = "create/review";
        } else {
            document.getElementById('createInvoice').style.display = "none"
            document.getElementById('otherCreateInvoice').style.display = "block"
            document.invoiceForm.action = "create/review/other";
        }
    }

    // function changeCompanyType(i) {
    //     if (i == 0) {
    //         $('#theCompany').attr('disabled', false);
    //         $('#theOtherCompany').attr('disabled', true);
    //         document.getElementById('otherCompany').style.display = "none"
    //         document.getElementById('company').style.display = "block"

    //     } else {
    //         $('#theCompany').attr('disabled', true);
    //         $('#theOtherCompany').attr('disabled', false);
    //         document.getElementById('company').style.display = "none"
    //         document.getElementById('otherCompany').style.display = "block"
    //     }

    // }
</script>
<script>
    var user = ""
    var project = ""
    var projectYear = ""
    var year = ""
    var month = ""
    var temp = ""
    var numTemp = ""
    var nowPage = 1
    //帳務
    var purchases = []
    var projects = []
    $(document).ready(function() {
        reset()
    });

    function selectProjectYears(val) {
        projectYear = val
        project = ''
        $("#select-purchase-project-grv").empty();
        $("#select-purchase-project-rv").empty();

        if (projectYear == '') {
            reset()
        } else {
            setPurchase()
            projects = getNewProject()
            for (var i = 0; i < projects.length; i++) {
                if (projects[i]['open_date'].substr(0, 4) == projectYear) {
                    if (projects[i]['company_name'] == "grv") {
                        $("#select-purchase-project-grv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                    } else if (projects[i]['company_name'] == "rv") {
                        $("#select-purchase-project-rv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                    }
                }
            }
            setYear()
        }
        setSearch()
        listPurchase() //列出符合條件的請款項目
    }

    function select(type, id) {
        switch (type) {
            case 'user':
                user = id
                if (id == '') {
                    reset()
                } else {
                    projectYear = ''
                    project = ''
                    year = ''
                    month = ''
                    setPurchase()
                    setProject() //設置此人所屬專案
                    setYear()
                    setMonth()
                }
                break;
            case 'project':
                project = id //傳入選取值
                if (id == '') {
                    reset()
                } else {
                    year = ''
                    month = ''
                    setPurchase()
                    setYear()
                    setMonth()
                }
                break;
            case 'year':
                year = id //傳入選取值
                if (id == '') {
                    reset()
                } else {
                    month = ''
                    setPurchase()
                    setMonth()
                }
                break;
            case 'month':
                month = id //傳入選取值
                if (id == '') {
                    reset()
                } else {
                    setPurchase()
                }
                break;
            default:

        }
        setSearchNum()
        setSearch()
        listPurchase() //列出符合條件的請款項目
        listPage()
    }

    function searchPurchase() {
        temp = document.getElementById('search-purchase').value
        nowPage = 1
        setPurchase()
        listPurchase()
        listPage()
    }

    function searchNum() {
        numTemp = document.getElementById('search-num').value
        nowPage = 1
        setPurchase()
        listPurchase()
        listPage()
    }

    function setPurchase() {
        purchases = getNewPurchase()
        for (var i = 0; i < purchases.length; i++) {
            if (user != '') {
                if (purchases[i]['user_id'] != user) {
                    purchases.splice(i, 1)
                    i--
                    continue
                }
            }
            if (project != '') {
                if (purchases[i]['project_id'] != project) {
                    purchases.splice(i, 1)
                    i--
                    continue
                } else {
                    $('#select-purchase-project-year').val(purchases[i].project['open_date'].substr(0, 4))
                }
            }
            if (year != '') {
                if (purchases[i]['created_at'].substr(0, 4) != year) {
                    purchases.splice(i, 1)
                    i--
                    continue
                }
            }
            if (month != '') {
                if (purchases[i]['created_at'].substr(5, 2) != month) {
                    purchases.splice(i, 1)
                    i--
                    continue
                }
            }
            if (temp != '') {
                if (purchases[i]['title'] == null || purchases[i]['title'].indexOf(temp) == -1) {
                    purchases.splice(i, 1)
                    i--
                    continue
                }
            }
            if (numTemp != '') {
                if (purchases[i]['id'] == null || purchases[i]['id'].indexOf(numTemp) == -1) {
                    purchases.splice(i, 1)
                    i--
                    continue
                }
            }
        }
    }


    function getNewPurchase() {
        data = "{{$data['purchases']}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    function getNewProject() {
        var temp = []
        var projectTemp = []
        for (var i = 0; i < purchases.length; i++) {
            if (temp.indexOf(purchases[i].project['name']) == -1) {
                temp.push(purchases[i].project['name'])
                projectTemp.push(purchases[i].project)
            }
        }
        return projectTemp
    }

    function listPurchase() {
        $("#show-purchase").empty();
        var parent = document.getElementById('show-purchase');
        var table = document.createElement("tbody");
        table.innerHTML = '<tr class="text-white">' +
            '<th>採購單號</th>' +
            '<th>採購人</th>' +
            '<th>專案</th>' +
            '<th>採購項目</th>' +
            '<th>採購費用</th>' +
            '<th>採購日期</th>' +
            '</tr>'
        var tr, span, name, a


        for (var i = 0; i < purchases.length; i++) {
            if (i >= (nowPage - 1) * 13 && i < nowPage * 13) {
                table.innerHTML = table.innerHTML + setData(i)
            } else if (i >= nowPage * 13) {
                break
            }
        }

        parent.appendChild(table);
    }

    function inputPurchase(i) {
        $('#purchase_id').val(purchases[i].id)
        $('#purchaseModal').modal('hide')
    }

    function setData(i) {

        a = "/purchase/" + purchases[i]['purchase_id'] + "/review"
        tr = "<tr style='cursor: pointer;' class='modal-style' onclick='inputPurchase(" + i + ")'>" +
            "<td>" + purchases[i].id + "</td>" +
            "<td>" + purchases[i].user['name'] + "(" + purchases[i].user['nickname'] + ")" + "</td>" +
            "<td>" + purchases[i].project['name'] + "</td>" +
            "<td>" + purchases[i].title + "</a></td>" +
            "<td>" + commafy(purchases[i].total_amount) + "</td>" +
            "<td>" + purchases[i].purchase_date.substr(0, 10) + "</td>" +
            "</tr>"


        return tr
    }

    function commafy(num) {
        num = num + "";
        var re = /(-?\d+)(\d{3})/
        while (re.test(num)) {
            num = num.replace(re, "$1,$2")
        }
        return num;
    }

    function reset() {
        purchases = getNewPurchase()
        nowPage = 1
        setUser()
        projectYear = ''
        setProject()
        setYear()
        setMonth()
        setSearch()
        setSearchNum()
        listPurchase()
        listPage()
    }

    function setUser() {
        user = ''
        $("#select-purchase-user").val("");
    }

    function setProject() {
        projects = getNewProject()
        project = ''
        $("#select-purchase-project-grv").empty();
        $("#select-purchase-project-rv").empty();

        var projectYears = [] //初始化

        for (var i = 0; i < projects.length; i++) {
            if (projectYears.indexOf(projects[i]['open_date'].substr(0, 4)) == -1) {
                projectYears.push(projects[i]['open_date'].substr(0, 4))
            }
            if (projects[i]['company_name'] == "grv") {
                $("#select-purchase-project-grv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
            } else if (projects[i]['company_name'] == "rv") {
                $("#select-purchase-project-rv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
            }
        }

        $("#select-purchase-project-year").val("");
        $("#select-purchase-project-year").empty();
        $("#select-purchase-project-year").append("<option value=''></option>");
        projectYears.sort()
        projectYears.reverse()
        for (var i = 0; i < projectYears.length; i++) {
            $("#select-purchase-project-year").append("<option value='" + projectYears[i] + "'>" + projectYears[i] + "</option>");
        }
    }

    function setYear() {
        year = ''
        var years = [] //初始化
        $("#select-purchase-year").val("");
        $("#select-purchase-year").empty();
        $("#select-purchase-year").append("<option value=''></option>");

        for (var i = 0; i < purchases.length; i++) {
            if (years.indexOf(purchases[i]['purchase_date'].substr(0, 4)) == -1) {
                years.push(purchases[i]['purchase_date'].substr(0, 4))
                $("#select-purchase-year").append("<option value='" + purchases[i]['purchase_date'].substr(0, 4) + "'>" + purchases[i]['purchase_date'].substr(0, 4) + "</option>");
            }
        }
    }

    function setMonth() {
        month = ''
        $("#select-purchase-month").empty();
        $("#select-purchase-month").append("<option value=''></option>");
        for (var i = 0; i < 12; i++) {
            if (i < 9) {
                $("#select-purchase-month").append("<option value='0" + (i + 1) + "'>" + "0" + (i + 1) + "</option>");
            } else {
                $("#select-purchase-month").append("<option value='" + (i + 1) + "'>" + (i + 1) + "</option>");

            }
        }
    }

    function setSearch() {
        temp = ''
        document.getElementById('search-purchase').value = temp
    }

    function setSearchNum() {
        numTemp = ''
        document.getElementById('search-num').value = numTemp
    }

    function nextPage() {
        var number = Math.ceil(purchases.length / 13)

        if (nowPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage++
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listPurchase()
        }

    }

    function changePage(index) {

        var temp = document.getElementsByClassName('page-item')

        $(".page-" + String(nowPage)).removeClass('active')
        nowPage = index
        $(".page-" + String(nowPage)).addClass('active')

        listPage()
        listPurchase()

    }

    function previousPage() {
        var number = Math.ceil(purchases.length / 13)

        if (nowPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage--
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listPurchase()
        }

    }

    function listPage() {
        $("#page-navigation").empty();
        var parent = document.getElementById('page-navigation');
        var div = document.createElement("div");
        var number = Math.ceil(purchases.length / 13)
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
        div.innerHTML = '<nav aria-label="Page navigation example">' +
            '<ul class="pagination">' +
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

        parent.appendChild(div);

        $(".page-" + String(nowPage)).addClass('active')
    }
</script>
@stop