@extends('layouts.app')
@section('content')
<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <span class="page_title_span">款項管理</span>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a  href="/billPayment" class="page_title_a" >繳款單</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <span class="page_title_span">建立繳款單</span>
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
                            <div class="btn-group btn-group-toggle" data-toggle="buttons" hidden>
                                <label class="btn btn-secondary active" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px">
                                    <input type="radio" name="billPaymentType1" id="billPaymentType1" onchange="changeBillPaymentType(0)" autocomplete="off" checked> <span class="mx-2">專案</span>
                                </label>
                                <label class="btn btn-secondary" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">
                                    <input type="radio" name="billPaymentType2" id="billPaymentType2" onchange="changeBillPaymentType(1)" autocomplete="off"> <span class="mx-2">其他</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <form name="billPaymentForm" action="create/review" method="post" enctype="multipart/form-data">
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
                                <div id="otherCreateBillPayment">
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


                                <div id="createBillPayment">
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
                                <label class="label-style col-form-label" for="remittancer">繳款人</label>

                                <input type="text" id="remittancer" autocomplete="off" name="remittancer" class="rounded-pill form-control">
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="label-style col-form-label" for="title">繳款項目</label>
                                <input id="title" autocomplete="off" type="text" name="title" class="form-control rounded-pill{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}" require>
                            </div>

                            <div class="col-lg-12 form-group">
                                <label class="label-style col-form-label" for="content"> 繳款事項(100字以內)</label>
                                <textarea id="content" name="content" rows="5" style="resize:none;" class="form-control rounded-pill{{ $errors->has('content') ? ' is-invalid' : '' }}" required>{{ old('content') }}</textarea> @if ($errors->has('content'))
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
                                        <input type="radio" name="options" id="option2" onchange="changeBankData(1)" autocomplete="off"> <span class="mx-2">閱野(第一)</span>
                                    </label>
                                    <label class="btn btn-secondary" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">
                                        <input type="radio" name="options" id="option2" onchange="changeBankData(2)" autocomplete="off" checked> <span class="mx-2">閱野(玉山)</span>
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
                                <input type="date" id="receipt_date" name="receipt_date" class="form-control rounded-pill{{ $errors->has('receipt_date') ? ' is-invalid' : '' }}" value="{{ old('receipt_date') }}"> @if ($errors->has('receipt_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('receipt_date') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-4 form-group">
                                <label class="label-style col-form-label" for="receipt_number">數量(匯款證明)</label>
                                <input oninput="value=value.replace(/[^\d]/g,'')" autocomplete="off" type="text" id="receipt_number" name="receipt_number" class="form-control rounded-pill{{ $errors->has('receipt_number') ? ' is-invalid' : '' }}" value="{{ old('receipt_number') }}" required> @if ($errors->has('receipt_number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>請輸入數字，不包含字元、標點符號</strong>
                                </span> @endif
                            </div>
                            <div class="col-lg-4 form-group">
                                <label class="label-style col-form-label" for="price">繳款金額</label>
                                <input oninput="value=value.replace(/[^\d]/g,'')" autocomplete="off" type="text" id="price" name="price" class="form-control rounded-pill{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ old('price') }}" required> @if ($errors->has('price'))
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
                            </div>
                            <div class="col-lg-4 form-group">
                                <label class="label-style col-form-label" for="reviewer">審核主管</label>
                                <input style="color:black;" type="text" id="reviewer" name="reviewer" class="form-control rounded-pill" value="蔡貴瑄" readonly>
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

@stop

@section('script')
<script ctype="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    var accountNames = []

    var accounts = []
    $(document).ready(function() {
        changeBankData(0)
        changeBillPaymentType(0)
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

    function changeBillPaymentType(i) {
        if (i == 0) {
            document.getElementById('otherCreateBillPayment').style.display = "none"
            document.getElementById('createBillPayment').style.display = "block"
            document.billPaymentForm.action = "create/review";
        } else {
            document.getElementById('createBillPayment').style.display = "none"
            document.getElementById('otherCreateBillPayment').style.display = "block"
            document.billPaymentForm.action = "create/review/other";
        }
    }

</script>
@stop