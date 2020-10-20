@extends('layouts.app')
@section('content')
<div class="d-flex align-items-center mb-3">
    <h2>{{__('customize.Add')}}{{__('customize.Invoice')}}</h2>
</div>

<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="row">
            <div class="col-lg-6">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary active">
                        <input type="radio" name="invoiceType1" id="invoiceType1" onchange="changeInvoiceType(0)" autocomplete="off" checked> 標案
                    </label>
                    <label class="btn btn-secondary ">
                        <input type="radio" name="invoiceType2" id="invoiceType2" onchange="changeInvoiceType(1)" autocomplete="off"> 其他
                    </label>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary ">
                        <input type="radio" name="companyType1" id="companyType1" onchange="changeCompanyType(0)" autocomplete="off"> 廠商
                    </label>
                    <label class="btn btn-secondary active">
                        <input type="radio" name="companyType2" id="companyType2" onchange="changeCompanyType(1)" autocomplete="off" checked> 其他
                    </label>
                </div>
            </div>
        </div>

        <form name="invoiceForm" action="create/review" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">     
                <div class="col-lg-6 form-group">
                    <div id="otherCreateInvoice">
                        <label class="label-style col-form-label" for="company_name">&nbsp;</label>
                        <select type="text" id="company_name" name="company_name" class="form-control" autofocus>
                            <option value="grv">綠雷德</option>
                            <option value="rv">閱野</option>
                        </select>

                        <label class="label-style col-form-label" for="type">類型</label>
                        <select type="text" id="type" name="type" class="form-control">
                            <option value="salary">薪資</option>
                            <option value="insurance">保險</option>
                            <option value="other">其他</option>
                        </select>
                    </div>
                    <div id="createInvoice">
                        <label class="label-style col-form-label" for="project_id">{{__('customize.Project')}}</label>
                        <select type="text" id="project_id" name="project_id" class="form-control">
                            @foreach ($data['projects'] as $project)
                            @if($project['name']!='其他' && $project['finished']==0)
                            <option value="{{$project['project_id']}}">{{$project['name']}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 form-group">
                    <div id="company">
                        <label class="label-style col-form-label" for="company">{{__('customize.company')}}</label>
                        <select disabled="disabled" type="text" id="theCompany" name="company" class="form-control" onchange="addBankData()">
                            <option value=""></option>

                            @foreach ($data['bank'] as $bank)
                            <option value="{{$bank['name']}}">{{$bank['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="otherCompany">
                        <label class="label-style col-form-label" for="company">{{__('customize.company')}}</label>
                        <input id="theOtherCompany" autocomplete="off" type="text" name="company" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" value="{{ old('company') }}" required> @if ($errors->has('company'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('company') }}</strong>
                        </span> @endif
                    </div>
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="title">請款項目</label>
                    <input id="title" autocomplete="off" type="text" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}" > 
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="purchase_id">採購單號</label>
                    <input id="purchase_id" autocomplete="off" type="text" name="purchase_id" class="form-control{{ $errors->has('purchase_id') ? ' is-invalid' : '' }}" value="{{ old('purchase_id') }}" > 
                </div>
                <div class="col-lg-12 form-group">
                    <label class="label-style col-form-label" for="content"> 請款事項(100字以內)</label>
                    <textarea id="content" name="content" rows="5" style="resize:none;" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" required>{{ old('content') }}</textarea> @if ($errors->has('content'))
                    <span class="invalid-feedback" role="alert">
                        <strong>超出100個字</strong>
                    </span> @endif
                </div>
                <div class="col-lg-12">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary">
                            <input type="radio" name="options" id="option1" onchange="changeBankData(0)" autocomplete="off"> 個人帳戶
                        </label>
                        <label class="btn btn-secondary active">
                            <input type="radio" name="options" id="option2" onchange="changeBankData(1)" autocomplete="off" checked> 其他
                        </label>
                    </div>
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="bank">{{__('customize.bank')}}</label>
                    <input autocomplete="off" type="text" id="bank" name="bank" class="form-control{{ $errors->has('bank') ? ' is-invalid' : '' }}" value="{{ old('bank') }}" required>
                    @if ($errors->has('bank'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('bank') }}</strong>
                    </span> @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="bank_branch">{{__('customize.bank_branch')}}</label>
                    <input autocomplete="off" type="text" id="bank_branch" name="bank_branch" class="form-control{{ $errors->has('bank_branch') ? ' is-invalid' : '' }}" value="{{ old('bank_branch') }}" required>
                    @if ($errors->has('bank_branch'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('bank_branch') }}</strong>
                    </span> @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="bank_account_number">{{__('customize.bank_account_number')}}</label>
                    <input autocomplete="off" type="text" id="bank_account_number" name="bank_account_number" class="form-control{{ $errors->has('bank_account_number') ? ' is-invalid' : '' }}" value="{{ old('bank_account_number') }}" required>
                    @if ($errors->has('bank_account_number'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('bank_account_number') }}</strong>
                    </span> @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="bank_account_name">{{__('customize.bank_account_name')}}</label>
                    <input autocomplete="off" type="text" id="bank_account_name" name="bank_account_name" class="form-control{{ $errors->has('bank_account_name') ? ' is-invalid' : '' }}" value="{{ old('bank_account_name') }}" required>
                    @if ($errors->has('bank_account_name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('bank_account_name') }}</strong>
                    </span>
                    @endif
                </div>


                <div class="row col-lg-6 form-group" style="margin:auto;">
                    <label class="label-style col-12">{{__('customize.receipt')}}</label>
                    <label class="label-style col-6 col-form-label" for="receipt_true"><input type="radio" id="receipt_true" name="receipt" value="1" class="{{ $errors->has('receipt') ? 'is-invalid' : '' }}" {{old('receipt')? 'checked': ''}} required>有</label>
                    <label class="label-style col-6 col-form-label" for="receipt_false"><input type="radio" id="receipt_false" name="receipt" value="0" class="{{ $errors->has('receipt') ? 'is-invalid' : '' }}" {{old('receipt')? '': 'checked'}}>沒有，待補</label>
                    @if ($errors->has('receipt'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('receipt') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="receipt_date">{{__('customize.receipt_date')}}</label>
                    <input type="date" id="receipt_date" name="receipt_date" class="form-control{{ $errors->has('receipt_date') ? ' is-invalid' : '' }}" value="{{ old('receipt_date') }}" required> @if ($errors->has('receipt_date'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('receipt_date') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="remuneration">{{__('customize.remuneration')}}(張數)</label>
                    <input autocomplete="off" type="text" id="remuneration" name="remuneration" class="form-control{{ $errors->has('remuneration') ? ' is-invalid' : '' }}" value="{{ old('remuneration') }}" required> @if ($errors->has('remuneration'))
                    <span class="invalid-feedback" role="alert">
                        <strong>請輸入數字，不包含字元、標點符號</strong>
                    </span> @endif
                </div>
                <div class="col-lg-6">
                    <label class="label-style col-form-label" for="price">{{__('customize.price')}}</label>
                    <input autocomplete="off" type="text" id="price" name="price" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ old('price') }}" required> @if ($errors->has('price'))
                    <span class="invalid-feedback" role="alert">
                        <strong>請輸入數字，不包含字元、標點符號</strong>
                    </span> @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="receipt_file">{{__('customize.receipt_file')}}</label>
                    <input type="file" id="receipt_file" name="receipt_file" class="form-control{{ $errors->has('receipt_file') ? ' is-invalid' : '' }}"> @if ($errors->has('receipt_file'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('receipt_file') }}</strong>
                    </span> @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="detail_file">{{__('customize.detail_file')}}</label>
                    <input type="file" id="detail_file" name="detail_file" class="form-control{{ $errors->has('detail_file') ? ' is-invalid' : '' }}"> @if ($errors->has('detail_file'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('detail_file') }}</strong>
                    </span> @endif
                </div>
            </div>
            <div class="md-5" style="float: right;">
                <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Save')}}</button>
            </div>


        </form>

    </div>
</div>


@stop

@section('javascript')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/grv.js') }}"></script>
<script>
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

    function changeCompanyType(i) {
        if (i == 0) {
            $('#theCompany').attr('disabled', false);
            $('#theOtherCompany').attr('disabled', true);
            document.getElementById('otherCompany').style.display = "none"
            document.getElementById('company').style.display = "block"

        } else {
            $('#theCompany').attr('disabled', true);
            $('#theOtherCompany').attr('disabled', false);
            document.getElementById('company').style.display = "none"
            document.getElementById('otherCompany').style.display = "block"
        }

    }
</script>
@stop