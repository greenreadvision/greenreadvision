@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card card-style">
            <div class="card-body ">
                <div class="col-lg-12 ">
                </div>
                <div class="col-lg-12 d-flex justify-content-between">
                    <div class=" col-lg-4">
                        <input type="text" name="searchCustomer" id="searchCustomer" class="mb-2 form-control  rounded-pill" placeholder="客戶名稱" autocomplete="off" onkeyup="searchCustomer()">
                    </div>
                    <button id="createModalButton" data-toggle="modal" data-target="#createModal" class="mb-2 btn btn-green rounded-pill"><span class="mx-2">{{__('customize.Add')}}</span> </button>
                </div>
                <div class="col-lg-12">
                    <div id="customer-page" class="d-flex align-items-end">
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
                <div class="col-lg-12 table-style-invoice">
                    <table id="show-customer">

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@foreach($customer as $item)
<div class="modal" id="{{$item->id}}_Modal" tabindex="-1" role="dialog" aria-labelledby="{{$item->id}}_Modal" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="max-width: 90%" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="CloseModal('{{$item->id}}')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/customer/{{$item->id}}/update" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12 d-flex justify-content-center">
                        <div class="col-lg-3">
                            <div class="col-lg-12 form-group">
                                <label class="label-style col-form-label" for="Customer_id">會員編號</label>
                                <input autocomplete="off" type="text" id="Customer_id-{{$item->id}}" name="Customer_id" class="rounded-pill form-control{{ $errors->has('Customer_id') ? ' is-invalid' : '' }}" value="{{$item->customer_id}}" readonly>
                                @if ($errors->has('Customer_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('Customer_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="col-lg-12 form-group">
                                <label class="label-style col-form-label" for="name">客戶名稱</label>
                                <input autocomplete="off" type="text" id="name-{{$item->id}}" name="name" class="rounded-pill form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{$item->name}}" onkeyup="searchEditBank()" required>
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="col-lg-12 form-group">
                                <label class="label-style col-form-label" for="principal">負責人</label>
                                <input autocomplete="off" type="text" id="principal-{{$item->id}}" name="principal" class="rounded-pill form-control{{ $errors->has('principal') ? ' is-invalid' : '' }}" value="{{$item->principal}}"  required>
                                @if ($errors->has('principal'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('principal') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="col-lg-12 form-group">
                                <label class="label-style col-form-label" for="sex">性別</label>
                                <select name="sex" id="sex-{{$item->id}}" class="rounded-pill form-control{{ $errors->has('principal') ? ' is-invalid' : '' }}">
                                    @if($item->sex == 'male')
                                    <option value="male" selected>先生</option>
                                    <option value="female">小姐</option>
                                    @elseif($item->sex == 'female')
                                    <option value="male" >先生</option>
                                    <option value="female" selected>小姐</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4" hidden>
                            <div class="col-lg-12 form-group">
                                <label class="label-style col-form-label" for="bank_id">id</label>
                                <input autocomplete="off" type="text" id="bank_id-{{$item->id}}" name="bank_id" class="rounded-pill form-control{{ $errors->has('bank_id') ? ' is-invalid' : '' }}" value="{{$item->bank_id}}" >
                                @if ($errors->has('bank_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('bank_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="bankName">銀行名稱</label>
                                    @if($item->bank_id == null)
                                    <input autocomplete="off" type="text" id="bank-{{$item->id}}" name="bank" class="rounded-pill form-control{{ $errors->has('bank') ? ' is-invalid' : '' }}" value="" >
                                    @else
                                    <input autocomplete="off" type="text" id="bank-{{$item->id}}" name="bank" class="rounded-pill form-control{{ $errors->has('bank') ? ' is-invalid' : '' }}" value="{{$item->bank['bank']}}" >
                                    @endif
                                    @if ($errors->has('bank'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="bankName">分行名字</label>
                                    @if($item->bank_id == null)
                                    <input autocomplete="off" type="text" id="bank_branch-{{$item->id}}" name="bank_branch" class="rounded-pill form-control{{ $errors->has('bank_branch') ? ' is-invalid' : '' }}" value="" >
                                    @else
                                    <input autocomplete="off" type="text" id="bank_branch-{{$item->id}}" name="bank_branch" class="rounded-pill form-control{{ $errors->has('bank_branch') ? ' is-invalid' : '' }}" value="{{$item->bank['bank_branch']}}" >
                                    @endif
                                    @if ($errors->has('bank_branch'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank_branch') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="bankName">銀行帳戶</label>
                                    @if($item->bank_id == null)
                                    <input autocomplete="off" type="text" id="bank_account_number-{{$item->id}}" name="bank_account_number" class="rounded-pill form-control{{ $errors->has('bank_account_number') ? ' is-invalid' : '' }}" value=""  onkeyup="value=value.replace(/[^\d]/g,'') ">
                                    @else
                                    <input autocomplete="off" type="text" id="bank_account_number-{{$item->id}}" name="bank_account_number" class="rounded-pill form-control{{ $errors->has('bank_account_number') ? ' is-invalid' : '' }}" value="{{$item->bank['bank_account_number']}}"  onkeyup="value=value.replace(/[^\d]/g,'') ">
                                    @endif
                                    @if ($errors->has('bank_account_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank_account_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="bankName">戶頭名字</label>
                                    @if($item->bank_id == null)
                                    <input autocomplete="off" type="text" id="bank_name-{{$item->id}}" name="bank_name" class="rounded-pill form-control{{ $errors->has('bank_name') ? ' is-invalid' : '' }}" value="" >
                                    @else
                                    <input autocomplete="off" type="text" id="bank_name-{{$item->id}}" name="bank_name" class="rounded-pill form-control{{ $errors->has('bank_name') ? ' is-invalid' : '' }}" value="{{$item->bank['name']}}" >
                                    @endif
                                    @if ($errors->has('bank_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="tax_id">統一編號(隨填)</label>
                                    <input autocomplete="off" type="text" id="tax_id-{{$item->id}}" name="tax_id" class="rounded-pill form-control{{ $errors->has('tax_id') ? ' is-invalid' : '' }}" value="{{$item->tax_id}}"  onkeyup="value=value.replace(/[^\d]/g,'') " >
                                    @if ($errors->has('tax_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tax_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="address">地址(隨填)</label>
                                    <input autocomplete="off" type="text" id="address-{{$item->id}}" name="address" class="rounded-pill form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{$item->address}}" 隨填>
                                    @if ($errors->has('address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="phone">電話(必填)</label>
                                    <input autocomplete="off" type="text" id="phone-{{$item->id}}" name="phone" class="rounded-pill form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{$item->phone}}" required>
                                    @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="fax">傳真(隨填)</label>
                                    <input autocomplete="off" type="text" id="fax-{{$item->id}}" name="fax" class="rounded-pill form-control{{ $errors->has('fax') ? ' is-invalid' : '' }}" value="{{$item->fax}}">
                                    @if ($errors->has('fax'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('fax') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="mail">Email(隨填)</label>
                                    <input autocomplete="off" type="email" id="mail-{{$item->id}}" name="email" class="rounded-pill form-control{{ $errors->has('mail') ? ' is-invalid' : '' }}" value="{{$item->email}}" >
                                    @if ($errors->has('mail'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mail') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="col-lg-12">
                                <div id="Bank-page-{{$item->id}}" class="d-flex align-items-end">
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
                            <div class="col-lg-12 table-style-invoice">
                                <table id="show-bank-{{$item->id}}">
                                    
                                </table>
                            </div>
                            
                        </div>
                    </div>
                   

                    
                    <div class="md-5" style="float: right;">
                        <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                    </div>

                </form>
                <div class="md-5" style="float: left">
                    <form action="{{$item->id}}/delete" method="DELETE">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-red rounded-pill">
                            <span class="mx-2">{{__('customize.Delete')}}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach



<div class="modal " id="createModal" role="dialog" aria-labelledby="createModal" aria-hidden="true"  data-backdrop="static">
    <div class="modal-dialog modal-lg" style="max-width: 90%" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="CloseModal('create')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="create/store" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12 d-flex justify-content-center">
                        <div class="col-lg-4">
                            <div class="col-lg-12 form-group">
                                <label class="label-style col-form-label" for="name">客戶名稱(必填)</label>
                                <input autocomplete="off" type="text" id="name-create" name="name" class="rounded-pill form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="" onkeyup="searchEditBank()" required>
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4" hidden>
                            <div class="col-lg-12 form-group">
                                <label class="label-style col-form-label" for="bank_id-create">id</label>
                                <input autocomplete="off" type="text" id="bank_id-create" name="bank_id" class="rounded-pill form-control{{ $errors->has('bank_id') ? ' is-invalid' : '' }}" value="" >
                                @if ($errors->has('bank_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('bank_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-lg-12 form-group">
                                <label class="label-style col-form-label" for="principal">負責人(必填)</label>
                                <input autocomplete="off" type="text" id="principal-create" name="principal" class="rounded-pill form-control{{ $errors->has('principal') ? ' is-invalid' : '' }}" value="" required>
                                @if ($errors->has('principal'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('principal') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-lg-12 form-group">
                                <label class="label-style col-form-label" for="sex">性別</label>
                                <select name="sex" id="sex-create" class="rounded-pill form-control{{ $errors->has('principal') ? ' is-invalid' : '' }}">
                                    <option value="male" selected>先生</option>
                                    <option value="female">小姐</option>
                                </select>
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="bankName">銀行名稱</label>
                                    <input autocomplete="off" type="text" id="bank-create" name="bank" class="rounded-pill form-control{{ $errors->has('bank') ? ' is-invalid' : '' }}" value="" >
                                    @if ($errors->has('bank'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="bankName">分行名字</label>
                                    <input autocomplete="off" type="text" id="bank_branch-create" name="bank_branch" class="rounded-pill form-control{{ $errors->has('bank_branch') ? ' is-invalid' : '' }}" value="" >
                                    @if ($errors->has('bank_branch'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank_branch') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="bankName">銀行帳戶</label>
                                    <input autocomplete="off" type="text" id="bank_account_number-create" name="bank_account_number" class="rounded-pill form-control{{ $errors->has('bank_account_number') ? ' is-invalid' : '' }}" value=""  onkeyup="value=value.replace(/[^\d]/g,'') ">
                                    @if ($errors->has('bank_account_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank_account_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="bankName">戶頭名字</label>
                                    <input autocomplete="off" type="text" id="bank_name-create" name="bank_name" class="rounded-pill form-control{{ $errors->has('bank_name') ? ' is-invalid' : '' }}" value="" >
                                    @if ($errors->has('bank_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="tax_id">統一編號(隨填)</label>
                                    <input autocomplete="off" type="text" id="tax_id-create" name="tax_id" class="rounded-pill form-control{{ $errors->has('tax_id') ? ' is-invalid' : '' }}" value=""  onkeyup="value=value.replace(/[^\d]/g,'') " >
                                    @if ($errors->has('tax_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tax_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="address">地址(隨填)</label>
                                    <input autocomplete="off" type="text" id="address-create" name="address" class="rounded-pill form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" value="" >
                                    @if ($errors->has('address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="phone">電話(必填)</label>
                                    <input autocomplete="off" type="text" id="phone-create" name="phone" class="rounded-pill form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="" required>
                                    @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="fax">傳真(隨填)</label>
                                    <input autocomplete="off" type="text" id="fax-create" name="fax" class="rounded-pill form-control{{ $errors->has('fax') ? ' is-invalid' : '' }}" value="">
                                    @if ($errors->has('fax'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('fax') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="email">Email(隨填)</label>
                                    <input autocomplete="off" type="email" id="mail-create" name="email" class="rounded-pill form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="" >
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="col-lg-12">
                                <div id="Bank-page-create" class="d-flex align-items-end">
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
                            <div class="col-lg-12 table-style-invoice">
                                <table id="show-bank-create">
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                   

                    
                    <div class="md-5" style="float: right;">
                        <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.14.0/dist/xlsx.full.min.js"></script>
<script>
    var customers = []
    var bank = []
    var searchTemp = ''
    var searchBankTemp = ''
    var bankList_id = null
    var nowPage = 1
    var BankPage = 1
    var localPoint = ''
    $(document).ready(function() {
        reset()
    });
    function reset() {
        banks = getNewBank()
        customers = getNewCustomer()
        nowPage = 1
        BankPage = 1
        setCustomer()
        listCustomer()
        listPage()
        for(var i = 0 ; i < customers.length ; i++){
            setModal(i)
        }
        $(document).on("click","#createModalButton",function(){    //編寫檔案簡介的Icon點擊後的的動作
            searchBankTemp = ""
            searchBankID = ""
            localPoint = 'create'
            
            setBank()
            listBank()
            listBankPage()
            $("#createModal").show()                              //顯示Modal
        });
    }
</script>
<script>
    function searchCustomer() {
        searchTemp = document.getElementById('searchCustomer').value
        nowPage = 1
        setCustomer()
        listCustomer()
        listPage()
    }

    function getNewCustomer(){
        data = "{{$customer}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }
    
    function setCustomer() {
        customers = getNewCustomer()
        for (var i = 0; i < customers.length; i++) {
            if (searchTemp != '') {
                if (customers[i]['name'] == null || customers[i]['name'].indexOf(searchTemp) == -1) {
                    customers.splice(i, 1)
                    i--
                    continue
                }
            }
        }
    }

    function listCustomer(){
        $("#show-customer").empty();
        var parent = document.getElementById('show-customer');
        var table = document.createElement("tbody");
        table.innerHTML = '<tr class="text-white">' +
            '<th>客戶編號</th>' +
            '<th>客戶名稱</th>' +
            '<th>客戶銀行</th>' +
            '<th>聯絡方式</th>' +
            '<th>動作</th>' + 
            '</tr>'
        var tr, span, name, a

        for (var i = 0; i < customers.length; i++) {
            if (i >= (nowPage - 1) * 13 && i < nowPage * 13) {
            table.innerHTML = table.innerHTML + setData(i)
            } else if (i >= nowPage * 13) {
                break
            }
        }

        parent.appendChild(table);
    }

    function setData(i) {
        if(customers[i].bank_id == null){
            var hasBank = '無資料'
        }
        else{
            var hasBank = '有資料'
        }

        tr = "<tr class='modal-style'>"+
            "<td class='text-center'>" + customers[i].customer_id + "</td>" +
            "<td class='text-center'>" + customers[i].name + "</td>" +
            "<td class='text-center'>" + hasBank + "</td>" +
            "<td class='text-center'>" + customers[i].phone + "</td>" +
            "<td class='text-center'><i class='fas fa-edit' data-toggle='modal' id=\"" + customers[i].id + "_check\" data-id=\""+ customers[i].id +"\" data-target='#" + customers[i].id + "_Modal'></i></td>" +
            "</tr>"

        return tr
    }

    function listPage(){
        $("#customer-page").empty();
        var parent = document.getElementById('customer-page');
        var div = document.createElement("div");
        var number = Math.ceil(customers.length / 13)
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
    function changePage(index) {
        var temp = document.getElementsByClassName('page-item')

        $(".page-" + String(nowPage)).removeClass('active')
        nowPage = index
        $(".page-" + String(nowPage)).addClass('active')

        listPage()
        listCustomer()

    }

    function nextPage() {
        var number = Math.ceil(customers.length / 13)

        if (nowPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage++
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listCustomer()
        }

    }
    function previousPage() {
        var number = Math.ceil(customers.length / 13)

        if (nowPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage--
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listCustomer()
        }
    }
</script>

<script>
    function setModal(val){
        $(document).on("click","#"+customers[val].id + "_check",function(){    //編寫檔案簡介的Icon點擊後的的動作
            $("#"+customers[val].id + "_Modal").show()                              //顯示Modal
            console.log(customers[val].id)
            searchBankTemp = customers[val].name
            searchBankID = val
            localPoint = customers[val].id
            setBank()
            listBank()
            listBankPage()
            
        });
    }

    function getNewBank(){
        data = "{{$bank}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }
    function searchEditBank() {
        searchBankTemp = document.getElementById('name-'+ localPoint).value
        BankPage = 1
        $('#bank_id-'+localPoint).val("")
        $('#bank-'+localPoint).val("")
        $('#bank_branch-'+localPoint).val("")
        $('#bank_name-'+localPoint).val("")
        $('#bank_account_number-'+localPoint).val("")
        bankList_id = null
        setBank()
        listBank()
        listBankPage()
    }

    function setBank() {
        banks = getNewBank()
        for (var i = 0; i < banks.length; i++) {
            if (searchBankTemp != '') {
                if (banks[i]['name'] == null || banks[i]['name'].indexOf(searchBankTemp) == -1) {
                    banks.splice(i, 1)
                    i--
                    continue
                }
            }
        }

        banks.sort(function(a, b) {
            return a.name.length - b.name.length;
        });
    }
    function listBank(){
        $("#show-bank-"+localPoint).empty();
        var parent = document.getElementById('show-bank-'+localPoint);
        var table = document.createElement("tbody");
        table.innerHTML = '<tr class="text-white">' +
            '<th>客戶名稱表單</th>' +
            '</tr>'
        var tr, span, name, a

        for (var i = 0; i < banks.length; i++) {
            if (i >= (BankPage - 1) *6 && i < BankPage * 6) {
            table.innerHTML = table.innerHTML + setBankData(i)
            } else if (i >= BankPage * 6) {
                break
            }
        }

        parent.appendChild(table);
    }

    function setBankData(i) {

        if(localPoint == 'create'){
            tr = "<tr style='cursor: pointer;' class='modal-style'   " + banks[i].bank_id + "_Modal>" +
                "<td class='text-left customer-bank-edit-hover' id='" + banks[i].bank_id + "_td' onclick='setEditBankDate("+ i +")'>" + banks[i].name + "</td>" +
                "</tr>"
        }
        else if(customers[searchBankID].bank_id == banks[i].bank_id){
            tr = "<tr style='cursor: pointer;' class='modal-style'   " + banks[i].bank_id + "_Modal>" +
                "<td class='text-left customer-bank-edit-hover customer-bank-edit-select' id='" + banks[i].bank_id + "_td' onclick='setEditBankDate("+ i +")'>" + banks[i].name + "</td>" +
                "</tr>"
            bankList_id = i
        }
        else{
            tr = "<tr style='cursor: pointer;' class='modal-style'   " + banks[i].bank_id + "_Modal>" +
                "<td class='text-left customer-bank-edit-hover' id='" + banks[i].bank_id + "_td' onclick='setEditBankDate("+ i +")'>" + banks[i].name + "</td>" +
                "</tr>"
        }
        
        return tr
    }

    function setEditBankDate(val){
        
        
        if(bankList_id != null){
            var bank_td_old = document.getElementById(banks[bankList_id].bank_id + '_td')
            
            bank_td_old.classList.remove('customer-bank-edit-select')
        }
        var bank_td = document.getElementById(banks[val].bank_id + '_td')
        bank_td.classList.add('customer-bank-edit-select')
        bankList_id = val
        
        $('#name-' + localPoint).val(banks[bankList_id].name)
        $('#bank-' + localPoint).val(banks[bankList_id].bank)
        $('#bank_branch-' + localPoint).val(banks[bankList_id].bank_branch)
        $('#bank_account_number-' + localPoint).val(banks[bankList_id].bank_account_number)
        $('#bank_name-' + localPoint).val(banks[bankList_id].name)
        $('#bank_id-' + localPoint).val(banks[bankList_id].bank_id)

    }

    function listBankPage(){
        $("#Bank-page-"+localPoint).empty();
        var parent = document.getElementById("Bank-page-"+localPoint);
        var div = document.createElement("div");
        div.setAttribute('style','width:100%')
        var number = Math.ceil(banks.length / 6)
        var data = ''
        if (BankPage < 4) {
            for (var i = 0; i < number; i++) {
                if (i < 5) {
                    data = data + '<li class="page-item page-bank-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeBankPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                } else {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-bank-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changeBankPage(' + number + ')">' + number + '</a></li>'
                    break
                }
            }
        } else if (BankPage >= 4 && BankPage - 3 <= 2) {
            for (var i = 0; i < number; i++) {
                if (i < BankPage + 2) {
                    data = data + '<li class="page-item page-bank-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeBankPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                } else {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-bank-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changeBankPage(' + number + ')">' + number + '</a></li>'
                    break
                }
            }
        }else if (BankPage >= 4 && BankPage - 3 > 2 && number - BankPage >= 4) {
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-bank-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeBankPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= BankPage - 3 && i <= BankPage + 1) {
                    data = data + '<li class="page-item page-bank-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeBankPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'

                } else if (i > BankPage + 1) {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-bank-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changeBankPage(' + number + ')">' + number + '</a></li>'
                    break
                }


            }
        } else if (number - BankPage <= 5 && number - BankPage >= 4) { //
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-bank-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeBankPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-bank-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= BankPage - 1) {
                    data = data + '<li class="page-item page-bank-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeBankPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                }
            }
        } else if (number - BankPage < 4) {//尾巴
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-bank-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeBankPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= number - 5) {
                    data = data + '<li class="page-item page-bank-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeBankPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                }
            }
        }
        var previous = "previous"
        var next = "next"
        div.innerHTML = '<nav aria-label="Page navigation example">' +
            '<ul class="pagination" style="justify-content: space-between;">' +
            '<li class="page-bank-item">' +
            '<a class="page-link" href="javascript:void(0)" onclick="previousBankPage()" aria-label="Previous">' +
            '<span aria-hidden="true"><i class="fas fa-caret-left" style="width:14.4px"></i></span>' +
            '</a>' +
            '</li>' +
            data +
            '<li class="page-bank-item">' +
            '<a class="page-link" href="javascript:void(0)" onclick="nextBankPage()" aria-label="Next">' +
            '<span aria-hidden="true"><i class="fas fa-caret-right" style="width:14.4px"></i></span>' +
            '</a>' +
            '</li>' +
            '</ul>' +
            '</nav>'

        parent.appendChild(div);

        $(".page-bank-" + String(BankPage)).addClass('active')
    }
    function changeBankPage(index) {
        bankList_id = null
        var temp = document.getElementsByClassName('page-bank-item')

        $(".page-bank-" + String(BankPage)).removeClass('active')
        BankPage = index
        $(".page-bank-" + String(BankPage)).addClass('active')

        listBankPage()
        listBank()

    }

    function nextBankPage() {
        var number = Math.ceil(banks.length /6)
        bankList_id = null
        if (BankPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(BankPage)).removeClass('active')
            BankPage++
            $(".page-" + String(BankPage)).addClass('active')
            listBankPage()
            listBank()
        }

    }
    function previousBankPage() {
        var number = Math.ceil(banks.length / 6)
        bankList_id = null
        if (BankPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(BankPage)).removeClass('active')
            BankPage--
            $(".page-" + String(BankPage)).addClass('active')
            listBankPage()
            listBank()
            
        }
    }

    

</script>

<script>

    function CloseModal(val){
        if(val == 'create'){
            searchBankTemp = ""
            searchBankID = ''
            localPoint = 'create'
            
            setBank()
            listBank()
            listBankPage()

            $('#name-'+val).val("")
            $('#tax_id-'+val).val("")
            $('#address-'+val).val("")
            $('#phone-'+val).val("")
            $('#fax-'+val).val("")
            $('#principal-'+val).val("")
            $('#sex-'+val).val("")
            $('#mail-'+val).val("")
            $('#bank_id-'+val).val("")
            $('#bank-'+val).val("")
            $('#bank_branch-'+val).val("")
            $('#bank_name-'+val).val("")
            $('#bank_account_number-'+val).val("")

        }else{
            for(var i=0 ; i < customers.length; i++ ){
                if(customers[i].id == val){
                    searchBankTemp = customers[i].name
                    searchBankID = i
                    localPoint = customers[i].id
                    setBank()
                    listBank()
                    listBankPage()
                    
                    $('#name-'+val).val(customers[i].name)
                    $('#tax_id-'+val).val(customers[i].tax_id)
                    $('#address-'+val).val(customers[i].address)
                    $('#phone-'+val).val(customers[i].phone)
                    $('#principal-'+val).val(customers[i].principal)
                    $('#sex-'+val).val(customers[i].sex)
                    $('#fax-'+val).val(customers[i].fax)
                    $('#mail-'+val).val(customers[i].mail)
                    if(customers[i].bank_id !=null){
                        $('#bank_id-'+val).val(customers[i].bank['bank_id'])
                        $('#bank-'+val).val(customers[i].bank['bank'])
                        $('#bank_branch-'+val).val(customers[i].bank['bank_branch'])
                        $('#bank_name-'+val).val(customers[i].bank['bank_account_name'])
                        $('#bank_account_number-'+val).val(customers[i].bank['bank_account_number'])
                        
                    }else{
                        $('#bank_id-'+val).val("")
                        $('#bank-'+val).val("")
                        $('#bank_branch-'+val).val("")
                        $('#bank_name-'+val).val("")
                        $('#bank_account_number-'+val).val("")
                    }
                    
                }
            }
            $("#"+val + "_Modal").modal().hide();
        }
    }
</script>
@stop