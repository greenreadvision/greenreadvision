@extends('layouts.app')

@section('content')
<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <span class="page_title_span">款項管理</span>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a  href="/purchase" class="page_title_a" >採購單</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a  href="/purchase/{{$purchase->purchase_id}}/review" class="page_title_a" >{{$purchase->id}}</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <span class="page_title_span">編輯資料</span>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body">
                <div class="col-lg-12">
                    <form action="update" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="id">採購單號</label>
                                <input autocomplete="off" type="text" id="id" name="id" class="rounded-pill form-control{{ $errors->has('id') ? ' is-invalid' : '' }}" value="{{$purchase->id}}" required readOnly>
                            </div>

                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="applicant">採購人</label>
                                <input autocomplete="off" type="text" id="applicant" name="applicant" class="rounded-pill form-control{{ $errors->has('applicant') ? ' is-invalid' : '' }}" value="{{$purchase->applicant}}" required>
                                @if ($errors->has('applicant'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('applicant') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="project_id">{{__('customize.Project')}}</label>
                                <select type="text" id="project_id" name="project_id" class="rounded-pill form-control">
                                    <optgroup label="綠雷德創新">
                                        @foreach($grv_2 as $g2)
                                        @if($g2['name']!='其他')
                                        @if($purchase['project_id'] == $g2['project_id'])
                                        <option value="{{$g2['project_id']}}" selected>{{$g2->name}}</option>
                                        @else
                                        <option value="{{$g2['project_id']}}">{{$g2->name}}</option>
                                        @endif
                                        @endif
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="閱野">
                                        @foreach($rv as $r)
                                        @if($purchase['project_id'] == $r['project_id'])
                                        <option value="{{$r['project_id']}}" selected>{{$r->name}}</option>
                                        @else
                                        <option value="{{$r['project_id']}}">{{$r->name}}</option>
                                        @endif
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="綠雷德(舊)">
                                        @foreach($grv as $gr)
                                        @if($gr['name']!='其他')
                                        @if($purchase['project_id'] == $gr['project_id'])
                                        <option value="{{$gr['project_id']}}" selected>{{$gr->name}}</option>
                                        @else
                                        <option value="{{$gr['project_id']}}">{{$gr->name}}</option>
                                        @endif
                                        @endif
                                        @endforeach
                                    </optgroup>
                                    @foreach($grv as $gr)
                                    @if($gr['name']=='其他')
                                    @if($purchase['project_id'] == $gr['project_id'])
                                    <option value="{{$gr['project_id']}}" selected>{{$gr->name}}</option>
                                    @else
                                    <option value="{{$gr['project_id']}}">{{$gr->name}}</option>
                                    @endif
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="purchase_date">採購日期</label>
                                <input type="date" id="purchase_date" name="purchase_date" class="rounded-pill form-control{{ $errors->has('purchase_date') ? ' is-invalid' : '' }}" value="{{ $purchase->purchase_date }}" required>
                                @if ($errors->has('purchase_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('purchase_date') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="company1">廠商名稱</label>
                                <input autocomplete="off" type="text" id="company1" name="company" class="rounded-pill form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" value="{{ $purchase->company }}" required>
                                @if ($errors->has('company'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('company') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="delivery_date">交貨日期</label>
                                <input type="date" id="delivery_date" name="delivery_date" class="rounded-pill form-control{{ $errors->has('delivery_date') ? ' is-invalid' : '' }}" value="{{ $purchase->delivery_date}}" required>
                                @if ($errors->has('delivery_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('delivery_date') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="contact_person">聯絡人</label>
                                <input autocomplete="off" type="text" id="contact_person" name="contact_person" class="rounded-pill form-control{{ $errors->has('contact_person') ? ' is-invalid' : '' }}" value="{{ $purchase->contact_person }}" required>
                                @if ($errors->has('contact_person'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('contact_person') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="address">送貨地址</label>
                                <input autocomplete="off" type="text" id="address" name="address" class="rounded-pill form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ $purchase->address }}" required>
                                @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-6 form-group">
                                <div class=" form-group">
                                    <label class="label-style col-form-label" for="phone">電話</label>
                                    <input autocomplete="off" type="text" id="phone" name="phone" class="rounded-pill form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ $purchase->phone }}" required>
                                    
                                </div>
                                <div class="form-group">
                                    <label class="label-style col-form-label" for="fax">傳真</label>
                                    <input autocomplete="off" type="text" id="fax" name="fax" class="rounded-pill form-control{{ $errors->has('fax') ? ' is-invalid' : '' }}" value="{{ $purchase->fax }}" >
                                   
                                </div>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="note">備註(50字以內)</label>
                                <textarea id="note" name="note" rows="5" style="resize:none;" class="rounded-pill form-control{{ $errors->has('note') ? ' is-invalid' : '' }}">{{ $purchase->note}}</textarea>
                                @if ($errors->has('note'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>超出50個字</strong>
                                </span>
                                @endif
                            </div>

                            <div class="col-lg-12 form-group">
                                <table width="100%">
                                    <thead>
                                        <tr class="bg-dark text-white" style="text-align:center">
                                            <th class="px-2" width="5%">
                                            <th class="px-2" width="30%"> <label class="label-style col-form-label" for="content">品名</label></th>
                                            <th class="px-2" width="10%"><label class="label-style col-form-label" for="quantity">數量</label></th>
                                            <th class="px-2" width="10%"><label class="label-style col-form-label" for="price">單價</label></th>
                                            <th class="px-2" width="15%"><label class="label-style col-form-label" for="amount">單項總計</label></th>
                                            <th class="px-2" width="25%"><label class="label-style col-form-label" for="note">備註</label></th>
                                        </tr>
                                    </thead>
                                    <tbody id="addItem">
                                        @foreach($purchase_item as $key => $item)
                                            @if($key === count($purchase_item)-1)
                                            <tr>
                                                <th class="p-2">
                                                    <button id="addItemButton" type="button" onclick="additem()" class="w-100 btn btn-green rounded-pill">+</button>
                                                </th>
                                                <th class="p-2">
                                                    <input autocomplete="off" type="text" id="content-{{$item->no}}" name="content-{{$item->no}}" class="item-num rounded-pill form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" value="{{ $item->content }}" required>
                                                </th>
                                                <th class="p-2">
                                                    <input autocomplete="off" oninput="value=value.replace(/[^\d]/g,'')" onkeyup="calculation()" type="text" id="quantity-{{$item->no}}" name="quantity-{{$item->no}}" class="rounded-pill form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" value="{{ $item->quantity }}" required>
                                                </th>
                                                <th class="p-2">
                                                    <input autocomplete="off" oninput="value=value.replace(/[^\d]/g,'')" onkeyup="calculation()" type="text" id="price-{{$item->no}}" name="price-{{$item->no}}" class="rounded-pill form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ $item->price }}" required>
                                                </th>
                                                <th class="p-2">
                                                    <input autocomplete="off" type="text" id="amount-{{$item->no}}" name="amount-{{$item->no}}" class="rounded-pill form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{ $item->amount }}" readonly>
                                                </th>
                                                <th class="p-2">
                                                    <input autocomplete="off" type="text" id="note-{{$item->no}}" name="note-{{$item->no}}" class="rounded-pill form-control{{ $errors->has('note') ? ' is-invalid' : '' }}" value="{{ $item->note }}">
                                                </th>
                                            </tr>
                                            @else
                                            <tr>
                                                <th class="p-2">
                                                </th>
                                                <th class="p-2">
                                                    <input autocomplete="off" type="text" id="content-{{$item->no}}" name="content-{{$item->no}}" class="item-num rounded-pill form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" value="{{ $item->content }}" required>
                                                </th>
                                                <th class="p-2">
                                                    <input autocomplete="off" oninput="value=value.replace(/[^\d]/g,'')" onkeyup="calculation()" type="text" id="quantity-{{$item->no}}" name="quantity-{{$item->no}}" class="rounded-pill form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" value="{{ $item->quantity }}" required>
                                                </th>
                                                <th class="p-2">
                                                    <input autocomplete="off" oninput="value=value.replace(/[^\d]/g,'')" onkeyup="calculation()" type="text" id="price-{{$item->no}}" name="price-{{$item->no}}" class="rounded-pill form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ $item->price }}" required>
                                                </th>
                                                <th class="p-2">
                                                    <input autocomplete="off" type="text" id="amount-{{$item->no}}" name="amount-{{$item->no}}" class="rounded-pill form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{ $item->amount }}" readonly>
                                                </th>
                                                <th class="p-2">
                                                    <input autocomplete="off" type="text" id="note-{{$item->no}}" name="note-{{$item->no}}" class="rounded-pill form-control{{ $errors->has('note') ? ' is-invalid' : '' }}" value="{{ $item->note }}">
                                                </th>
                                            </tr>
                                            @endif
                                        
                                        @endforeach

                                        <!--@for($i=count($purchase_item)+1 ; $i<=(11-count($purchase_item));$i++)
                                        <tr>
                                            <th class="p-2">
                                                <input autocomplete="off" type="text" id="content-{{$i}}" name="content{{$i}}" class="item-num rounded-pill form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" value="" >
                                            </th>
                                            <th class="p-2">
                                                <input autocomplete="off" oninput="value=value.replace(/[^\d]/g,'')" onkeyup="calculation()" type="text" id="quantity-{{$i}}" name="quantity{{$i}}" class="rounded-pill form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" value="" >
                                            </th>
                                            <th class="p-2">
                                                <input autocomplete="off" oninput="value=value.replace(/[^\d]/g,'')" onkeyup="calculation()" type="text" id="price-{{$i}}" name="price{{$i}}" class="rounded-pill form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" value="" >
                                            </th>
                                            <th class="p-2">
                                                <input autocomplete="off" oninput="value=value.replace(/[^\d]/g,'')" type="text" id="amount-{{$i}}" name="amount{{$i}}" class="rounded-pill form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" value="" readonly>
                                            </th>
                                            <th class="p-2">
                                                <input autocomplete="off" type="text" id="note-{{$i}}" name="note{{$i}}" class="rounded-pill form-control{{ $errors->has('note') ? ' is-invalid' : '' }}" value="">
                                            </th>
                                        </tr>
                                        @endfor-->
                                    </tbody>
                                </table>


                            </div>

                            <div class="col-lg-3 form-group d-flex justify-content-center align-items-center">
                                <div class="form-check" id="check">
                                    <label class="label-style col-form-label" for="amount">稅率選擇</label>
                                    <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                        <label class="btn btn-secondary w-33 texRadio" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px">
                                            <input type="radio" name="options"  onchange="texTypeFunction(0)" autocomplete="off" checked> 未含稅
                                        </label>
                                        <label class="btn btn-secondary w-33 texRadio">
                                            <input type="radio" name="options"  onchange="texTypeFunction(1)" autocomplete="off"> 已含稅
                                        </label>
                                        <label class="btn btn-secondary w-33 texRadio" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">
                                            <input type="radio" name="options"  onchange="texTypeFunction(2)" autocomplete="off"> 零%稅
                                        </label>
                                    </div>
                                    <!--<input class="form-check-input" type="checkbox" value="" id="texCheck" onclick="calculation()">
                                    <label class="form-check-label" for="texCheck">
                                        未稅
                                    </label>-->
                                </div>
                            </div>
                            <div class="col-lg-3 form-group">
                                <label class="label-style col-form-label" for="amount">金額</label>
                                <input autocomplete="off" type="text" id="amount" name="amount" class="rounded-pill form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{ old('amount') }}" readonly>

                            </div>
                            <div class="col-lg-3 form-group">
                                <label class="label-style col-form-label" for="tex">稅金</label>
                                <input autocomplete="off" type="text" id="tex" name="tex" class="rounded-pill form-control{{ $errors->has('tex') ? ' is-invalid' : '' }}" value="{{ old('tex') }}" readonly>

                            </div>
                            <div class="col-lg-3 form-group">
                                <label class="label-style col-form-label" for="total_amount">總金額</label>
                                <input autocomplete="off" type="text" id="total_amount" name="total_amount" class="rounded-pill form-control{{ $errors->has('total_amount') ? ' is-invalid' : '' }}" value="{{ old('total_amount') }}" readonly>
                                <input autocomplete="off" type="text" id="item_total_num" name="item_total_num" class="rounded-pill form-control{{ $errors->has('item_total_num') ? ' is-invalid' : '' }}" value="{{count($purchase_item)}}" readonly hidden>
                            </div>

                        </div>
                        <div style="float: left;">
                            <button type="button" class="btn btn-red rounded-pill" data-toggle="modal" data-target="#deleteModal">
                                <i class='ml-2 fas fa-trash-alt'></i><span class="ml-3 mr-2">{{__('customize.Delete')}}</span>
                            </button>
                        </div>
                        <div class="md-5" style="float: right;">
                            <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                        </div>


                    </form>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">否</button>
                <form action="delete" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-primary">是</button>
                </form>
            </div>
        </div>
    </div>
</div>




@stop
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    var i = document.getElementsByClassName('item-num').length + 1
    var texType = ''
    var texRadioLabel = document.getElementsByClassName('texRadio')
    var texRadio = document.getElementsByName('options')
    $(document).ready(function() {
        var purchase = '{{$purchase}}'
        purchase = purchase.replace(/[\n\r]/g, "")
        purchase = JSON.parse(purchase.replace(/&quot;/g, '"'));
        
        var purchase_item = '{{$purchase_item}}'
        purchase_item = purchase_item.replace(/[\n\r]/g, "")
        purchase_item = JSON.parse(purchase_item.replace(/&quot;/g, '"'));
        item_num = purchase_item.length

        var texCheck = document.getElementById('texCheck')
        var amount = document.getElementById('amount')
        var tex = document.getElementById('tex')
        var total_amount = document.getElementById('total_amount')
        if(purchase.tex == 0){
            texRadioLabel[2].classList.add('active')
            texType = 'zerotexed'
        }else if(sum() == purchase.total_amount){
            texRadioLabel[1].classList.add('active')
            texType = 'texed'
        }else if(sum() != purchase.total_amount){
            texRadioLabel[0].classList.add('active')
            texType = 'untexed'
        }
        calculation()
    });

    function addElementDiv(obj) {

        var parent = document.getElementById(obj);
        //新增 div
        var div = document.createElement("tr");
        //設定 div 屬性，如 id

        div.innerHTML = '<th></th>' +
            '<th class="p-2"><input autocomplete="off" type="text" id="content-' + i + '" name="content-' + i + '" class="item-num rounded-pill form-control{{ $errors->has("content") ? " is-invalid" : "" }}" value="{{ old("content") }}"></th>' +
            '<th class="p-2"><input autocomplete="off" oninput="value=value.replace(/[^\d]/g,"")" onkeyup="calculation()" type="text" id="quantity-' + i + '" name="quantity-' + i + '" class="rounded-pill form-control{{ $errors->has("quantity") ? " is-invalid" : "" }}" value="{{ old("quantity") }}"></th>' +
            '<th class="p-2"><input autocomplete="off" oninput="value=value.replace(/[^\d]/g,"")" onkeyup="calculation()" type="text" id="price-' + i + '" name="price-' + i + '" class="rounded-pill form-control{{ $errors->has("price") ? " is-invalid" : "" }}" value="{{ old("price") }}"></th>' +
            '<th class="p-2"><input autocomplete="off" type="text" id="note-' + i + '" name="note-' + i + '" class="rounded-pill form-control{{ $errors->has("note") ? " is-invalid" : "" }}" value="{{ old("note") }}"></th>'
        parent.appendChild(div);
        i++;
    }

    function sum() {
        var quantity, price, sum = 0
        for (var i = 1; i < document.getElementsByClassName('item-num').length+1; i++) {
            quantity = document.getElementById('quantity-' + i).value
            price = document.getElementById('price-' + i).value
            oneAmount = document.getElementById('amount-' + i)
            oneAmount.value = Math.round(quantity * price)
            sum = sum + quantity * price
        }
        
        return sum
    }
    
    function texTypeFunction(val){
        if(val == 0){
            texType = 'untexed'
        }else if(val == 1){
            texType = 'texed'
        }else if(val == 2){
            texType = 'zerotexed'
        }
        calculation()
    }

    function calculation() {
        console.log('sum' +  sum())
        if (texType == 'untexed') {
            
            amount.value = sum()
            tex.value = Math.round(sum() * 0.05)
            total_amount.value = Math.round(sum() * 1.05)
        }
        else if(texType == 'texed'){
            
            total_amount.value = sum()
            amount.value = Math.round(total_amount.value/1.05)
            tex.value = Math.round(amount.value * 0.05)
        }else if(texType == 'zerotexed'){
            total_amount.value = sum()
            amount.value = total_amount.value
            tex.value = 0
        }

    }

    function additem(){
        var parent = document.getElementById('addItem');
        var tr = document.createElement('tr');
        $("#addItemButton").remove();
        item_num = item_num + 1;
        document.getElementById("item_total_num").value = item_num;
        tr.innerHTML = '<tr>' + 
            '<th class="p-2"><button id="addItemButton" type="button" onclick="additem()" class="w-100 btn btn-green rounded-pill">+</button>' +
            '<th class="p-2"><input autocomplete="off" type="text" id="content-' + item_num + '" name="content-'+ item_num + '" class="item-num rounded-pill form-control{{ $errors->has("content-'+ item_num +'") ? " is-invalid" : "" }}" value="{{ old("content-'+ item_num +'") }}"></th>' +
            '<th class="p-2"><input oninput="value=value.replace(/[^\d]/g,"")" onkeyup="calculation()" autocomplete="off" type="text" id="quantity-'+ item_num + '" name="quantity-'+ item_num +'" class="rounded-pill form-control{{ $errors->has("quantity-'+ item_num +'") ? " is-invalid" : "" }}" value="{{ old("quantity-'+ item_num +'") }}"></th>' +
            '<th class="p-2"><input oninput="value=value.replace(/[^\d]/g,"")" onkeyup="calculation()" autocomplete="off" type="text" id="price-'+ item_num +'" name="price-'+ item_num +'" class="rounded-pill form-control{{ $errors->has("price-'+ item_num +'") ? " is-invalid" : "" }}" value="{{ old("price-'+ item_num +'") }}"></th>' +
            '<th class="p-2"><input autocomplete="off" type="text" id="amount-'+ item_num +'" name="amount-'+ item_num +'" class="rounded-pill form-control{{ $errors->has("amount-'+ item_num +'") ? " is-invalid" : "" }}" value="{{ old("amount-'+ item_num +'") }}" readonly></th>' +
            '<th class="p-2"><input autocomplete="off" type="text" id="note-'+ item_num +'" name="note-'+ item_num +'" class="rounded-pill form-control{{ $errors->has("note-'+ item_num +'") ? " is-invalid" : "" }}" value="{{ old("note-'+ item_num +'") }}"></th>' +
            '</tr>'
        parent.appendChild(tr);
        calculation()
    }
</script>
<script src="{{ URL::asset('js/grv.js') }}"></script>
@stop