@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body">
                <div class="col-lg-12">
                    <form name="invoiceForm" action="create/review" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                                
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <input type="text" id="customer_id" name="customer_id" class="rounded-pill form-control{{ $errors->has('customer_id') ? ' is-invalid' : '' }}" value="{{ old('customer_id') }}" hidden>
                                    <div class="col-lg-12 form-group">
                                        <label class="label-style col-form-label" for="estimate_id">報價單號</label>
                                        <input autocomplete="off" type="text" id="estimate_id" name="estimate_id" class="rounded-pill form-control{{ $errors->has('estimate_id') ? ' is-invalid' : '' }}" value="{{$id}}" required readOnly>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="company_name">承辦公司</label>
                                        <select class="rounded-pill form-control" name="company_name" id="company_name" onchange="select(this.options[this.options.selectedIndex].value)">
                                            <option value=""></option>
                                            <option value="grv_2">綠雷德創新股份有限公司</option>
                                            <option value="rv">閱野文創股份有限公司</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="applicant">業務承辦人員</label>
                                        <select name="user" id="user" class="rounded-pill form-control">
                                            <option value=""></option>
                                            @foreach ($users as $user)
                                                <option value="{{$user->user_id}}" {{$user->user_id == \Auth::user()->user_id ? 'selected' :''}}>{{$user->name}}({{$user->nickname}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="customer_name">廠商名稱</label>
                                        <input type="text" id="customer_name" name="customer_name" onkeydown="checkCustomer()" class="rounded-pill form-control{{ $errors->has('customer_name') ? ' is-invalid' : '' }}" value="{{ old('customer_name') }}" required>
                                        @if ($errors->has('customer_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('customer_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="customer_principal">廠商負責人</label>
                                        <input autocomplete="off" type="text" id="customer_principal" name="customer_principal" onkeydown="checkCustomer()" class="rounded-pill form-control{{ $errors->has('customer_principal') ? ' is-invalid' : '' }}" value="{{ old('customer_principal') }}" required>
                                        @if ($errors->has('customer_principal'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('customer_principal') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="customer_phone">聯絡電話</label>
                                        <input type="text" id="customer_phone" name="customer_phone" oninput="checkRequired('telephone')" class="rounded-pill form-control{{ $errors->has('customer_phone') ? ' is-invalid' : '' }}" value="{{ old('customer_phone') }}" required>
                                        @if ($errors->has('customer_phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('customer_phone') }}</strong>
                                        </span>
                                        @endif
                                    </div>
        
                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="customer_mail">Email</label>
                                        <input autocomplete="off" type="text" id="customer_mail" name="customer_mail" oninput="checkRequired('Email')" class="rounded-pill form-control{{ $errors->has('customer_mail') ? ' is-invalid' : '' }}" value="{{ old('customer_mail') }}" required>
                                        @if ($errors->has('customer_mail'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('customer_mail') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-lg-6" id="project_select">
                                        <label class="label-style col-form-label" for="project_id">{{__('customize.Project')}}</label>
                                        <select type="text" id="project_id" name="project_id" class="rounded-pill form-control"  onchange="changeProject(this.options[this.options.selectedIndex].value)" required>
                                            <option value="newProject">新專案</option>
                                            <optgroup id="optgroup_grv" label="綠雷德創新">
                                                @foreach ($projects as $item)
                                                    @if($item['company_name'] =='grv_2' && $item['name']!='綠雷德-其他')
                                                        <option value="{{$item['project_id']}}">{{$item['name']}}</option>
                                                    @endif
                                                @endforeach
                                            </optgroup>
                                            <optgroup id="optgroup_rv" label="閱野">
                                                @foreach ($projects as $item)
                                                    @if($item['company_name'] =='rv' && $item['name']!='閱野-其他')
                                                        <option value="{{$item['project_id']}}">{{$item['name']}}</option>
                                                    @endif
                                                @endforeach
                                            </optgroup>
        
                                            
                                        </select>
                                    </div>
                                    <div class="col-lg-6  form-group" id='newProject_input'>
                                        <label class="label-style col-form-label" for="project_id">新專案名稱</label>
                                        <input autocomplete="off" type="text" id="newProject" name="newProject" class="rounded-pill form-control{{ $errors->has('newProject') ? ' is-invalid' : '' }}" value="{{ old('newProject') }}">
                                        @if ($errors->has('newProject'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('newProject') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label class="label-style col-form-label" for="active_title">報價大綱</label>
                                        <input autocomplete="off" type="text" id="active_title" name="active_title" class="rounded-pill form-control{{ $errors->has('active_title') ? ' is-invalid' : '' }}" value="{{ old('active_title') }}" required>
                                        @if ($errors->has('active_title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('active_title') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div> 
                            </div>
                            <div class="col-lg-6 form-group">
                                <div class="col-lg-12">
                                    <div id="Page-customer" class="d-flex align-items-end">
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
                                <div class="col-lg-12 ">
                                    <table id="customer_table" class="choice_table"  width="100%">
                                        
                                        
                                    </table>
                                </div>
                            </div>
                            
                            <div class="col-lg-12 form-group">
                                <table id="Itemtable" width="100%">
                                    <thead>
                                        <tr class="bg-dark text-white" style="text-align:center">
                                            <th class="px-2" width="5%">
                                            <th class="px-2" width="25%"><label class="label-style col-form-label" for="content">品名</label></th>
                                            <th class="px-2" width="10%"><label class="label-style col-form-label" for="quantity">數量</label></th>
                                            <th class="px-2" width="10%"><label class="label-style col-form-label" for="unit">單位</label></th>
                                            <th class="px-2" width="10%"><label class="label-style col-form-label" for="price">單價</label></th>
                                            <th class="px-2" width="10%"><label class="label-style col-form-label" for="amount">單項總價</label></th>
                                            <th class="px-2" width="25%"><label class="label-style col-form-label" for="note">備註</label></th>
                                        </tr>
                                    </thead>
                                    
                                </table>

                            </div>
                            <div class="col-lg-3 form-group d-flex justify-content-center align-items-center">
                                <div class="form-check" id="check">
                                    <label class="label-style col-form-label" for="amount">稅率選擇</label>
                                    <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                        <label class="btn btn-secondary w-100 rounded-pill action">
                                            <input type="radio" name="options" autocomplete="off"> 未含稅
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
                                <input autocomplete="off" type="text" id="item_total_num" name="item_total_num" class="rounded-pill form-control{{ $errors->has('item_total_num') ? ' is-invalid' : '' }}" value=9 readonly hidden>
                            </div>

                        </div>
                        <div class="md-5" style="float: right;" >
                            <button type="submit" class="btn btn-green rounded-pill"><span class="mx-2">{{__('customize.Add')}}</span></button>
                        </div>


                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@stop
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    var projects=[];
    function getNewProject(){
        data = "{{$projects}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    function select(val){
        if(val =='grv_2'){
            document.getElementById('optgroup_rv').hidden = true
            document.getElementById('optgroup_grv').hidden = false
        }
        else if(val =='rv'){
            document.getElementById('optgroup_grv').hidden = true
            document.getElementById('optgroup_rv').hidden = false

        }else if(val == ''){
            document.getElementById('optgroup_grv').hidden = false
            document.getElementById('optgroup_rv').hidden = false
        }
    }

    function changeProject(val){
        project_select = document.getElementById('project_select')
        newProject_input = document.getElementById('newProject_input')
        if(val == 'newProject'){
            newProject_input.hidden = false
            project_select.classList.remove("col-lg-12")
            project_select.classList.add("col-lg-6")
        }else{
            for(var i =0 ; i < projects.length ; i++){
                if(projects[i].project_id == val){
                    document.getElementById('company_name').value = projects[i].company_name
                    select( projects[i].company_name)
                    break;
                }
            }
            newProject_input.hidden = true
            project_select.classList.remove("col-lg-6")
            project_select.classList.add("col-lg-12")
        }
    }
    function checkRequired(val){
        if(val == 'telephone'){
            if(document.getElementById('customer_phone')!=''){
                document.getElementById('customer_mail').required = false;
            }
            else if(document.getElementById('customer_phone')==''){
                document.getElementById('customer_mail').required = true;
            }
        }else if(val == 'Email'){
            if(document.getElementById('customer_mail')!=''){
                document.getElementById('customer_phone').required = false;
            }
            else if(document.getElementById('customer_mail')==''){
                document.getElementById('customer_phone').required = true;
            }
        }
    }

    function checkCustomer(){
        $('#customer_id').val('');
        console.log(document.getElementById('customer_id').value)
    }
</script>
<script>
    var item_num = 9;
    var texType = 'untexed'
    $(document).ready(function() {
        projects = getNewProject()
        var amount = document.getElementById('amount')
        var tex = document.getElementById('tex')
        var total_amount = document.getElementById('total_amount')
        listPage()
        list_table()
        calculation()

    });

   

    function list_table(){
        var parent = document.getElementById('Itemtable');
        var body = document.createElement("tbody");
        body.setAttribute("id","Itembody");
        for(var i = 0;i<10;i++ ){
            if(i != 9){
                body.innerHTML = body.innerHTML + '<tr style="vertical-align: top;">' +
                    '<th class="p-2">' +
                    '<th class="p-2"><input autocomplete="off" type="text" id="content-' + i + '" name="content-'+ i + '" class="rounded-pill form-control{{ $errors->has("content-'+ i +'") ? " is-invalid" : "" }}" value="{{ old("content-'+ i +'") }}"></th>' +
                    "<th class=\"p-2\"><input oninput=\"value=value.replace(/[^\\d]/g,'')\" onkeyup=\"calculation()\" autocomplete=\"off\" type=\"text\" id=\"quantity-"+ i + "\" name=\"quantity-"+ i +"\" class=\"rounded-pill form-control{{ $errors->has('quantity-"+ i +"') ?  'is-invalid' : '' }}\" value=\"{{ old('quantity-"+ i +"') }}\"></th>" +
                    '<th class="p-2"><input autocomplete="off" type="text" id="unit-'+ i +'" name="unit-'+ i +'" class="rounded-pill form-control{{ $errors->has("unit-'+ i +'") ? " is-invalid" : "" }}" value="{{ old("unit-'+ i +'") }}"></th>' +
                    "<th class=\"p-2\"><input oninput=\"value=value.replace(/[^\\d]/g,'')\" onkeyup=\"calculation()\" autocomplete=\"off\" type=\"text\" id=\"price-"+ i +"\" name=\"price-"+ i +"\" class=\"rounded-pill form-control{{ $errors->has('price-"+ i +"') ? 'is-invalid' : '' }}\" value=\"{{ old('price-"+ i +"') }}\"></th>" +
                    '<th class="p-2"><input autocomplete="off" type="text" id="amount-'+ i +'" name="amount-'+ i +'" class="rounded-pill form-control{{ $errors->has("amount-'+ i +'") ? " is-invalid" : "" }}" value="{{ old("amount-'+ i +'") }}" readonly></th>' +
                    '<th class="p-2"><textarea autocomplete="off" onkeyup="textchange()" id="note-'+ i +'" name="note-'+ i +'" class="rounded-pill form-control{{ $errors->has("note-'+ i +'") ? " is-invalid" : "" }}" >{{ old("note-'+ i +'") }}</textarea></th>' +
                    '</tr>'
            }
            else{
                body.innerHTML = body.innerHTML + '<tr style="vertical-align: top;">' + 
                    '<th class="p-2"><button id="addItemButton" type="button" onclick="additem()" class="w-100 btn btn-green rounded-pill">+</button>' +
                    '<th class="p-2"><input autocomplete="off" type="text" id="content-' + i + '" name="content-'+ i + '" class="rounded-pill form-control{{ $errors->has("content-'+ i +'") ? " is-invalid" : "" }}" value="{{ old("content-'+ i +'") }}"></th>' +
                    "<th class=\"p-2\"><input oninput=\"value=value.replace(/[^\\d]/g,'')\" onkeyup=\"calculation()\" autocomplete=\"off\" type=\"text\" id=\"quantity-"+ i + "\" name=\"quantity-"+ i +"\" class=\"rounded-pill form-control{{ $errors->has('quantity-"+ i +"') ?  'is-invalid' : '' }}\" value=\"{{ old('quantity-"+ i +"') }}\"></th>" +
                    '<th class="p-2"><input autocomplete="off" type="text" id="unit-'+ i +'" name="unit-'+ i +'" class="rounded-pill form-control{{ $errors->has("unit-'+ i +'") ? " is-invalid" : "" }}" value="{{ old("unit-'+ i +'") }}"></th>' +
                    "<th class=\"p-2\"><input oninput=\"value=value.replace(/[^\\d]/g,'')\" onkeyup=\"calculation()\" autocomplete=\"off\" type=\"text\" id=\"price-"+ i +"\" name=\"price-"+ i +"\" class=\"rounded-pill form-control{{ $errors->has('price-"+ i +"') ? 'is-invalid' : '' }}\" value=\"{{ old('price-"+ i +"') }}\"></th>" +
                    '<th class="p-2"><input autocomplete="off" type="text" id="amount-'+ i +'" name="amount-'+ i +'" class="rounded-pill form-control{{ $errors->has("amount-'+ i +'") ? " is-invalid" : "" }}" value="{{ old("amount-'+ i +'") }}" readonly></th>' +
                    '<th class="p-2"><textarea autocomplete="off" onkeyup="textchange()" id="note-'+ i +'" name="note-'+ i +'" class="rounded-pill form-control{{ $errors->has("note-'+ i +'") ? " is-invalid" : "" }}">{{ old("note-'+ i +'") }}</textarea></th>' +
                    '</tr>'
            }
            
        }
        parent.appendChild(body);
    }

    function additem(){
        var parent = document.getElementById('Itembody');
        var tr = document.createElement('tr');
        tr.style.verticalAlign = "top"
        $("#addItemButton").remove();
        item_num = item_num + 1;
        document.getElementById("item_total_num").value = item_num;
        console.log('item_total_num = '+ item_num)
        tr.innerHTML = 
            '<th class="p-2"><button id="addItemButton" type="button" onclick="additem()" class="w-100 btn btn-green rounded-pill">+</button>' +
            '<th class="p-2"><input autocomplete="off" type="text" id="content-' + item_num + '" name="content-'+ item_num + '" class="rounded-pill form-control{{ $errors->has("content-'+ item_num +'") ? " is-invalid" : "" }}" value="{{ old("content-'+ item_num +'") }}"></th>' +
            "<th class=\"p-2\"><input oninput=\"value=value.replace(/[^\\d]/g,'')\" onkeyup=\"calculation()\" autocomplete=\"off\" type=\"text\" id=\"quantity-"+ item_num + "\" name=\"quantity-"+ item_num +"\" class=\"rounded-pill form-control{{ $errors->has('quantity-"+ item_num +"') ?  'is-invalid' : '' }}\" value=\"{{ old('quantity-"+ item_num +"') }}\"></th>" +
            '<th class="p-2"><input autocomplete="off" type="text" id="unit-'+ item_num +'" name="unit-'+ item_num +'" class="rounded-pill form-control{{ $errors->has("unit-'+ item_num +'") ? " is-invalid" : "" }}" value="{{ old("unit-'+ item_num +'") }}"></th>' +
            "<th class=\"p-2\"><input oninput=\"value=value.replace(/[^\\d]/g,'')\" onkeyup=\"calculation()\" autocomplete=\"off\" type=\"text\" id=\"price-"+ item_num +"\" name=\"price-"+ item_num +"\" class=\"rounded-pill form-control{{ $errors->has('price-"+ item_num +"') ? 'is-invalid' : '' }}\" value=\"{{ old('price-"+ item_num +"') }}\"></th>" +
            '<th class="p-2"><input autocomplete="off" type="text" id="amount-'+ item_num +'" name="amount-'+ item_num +'" class="rounded-pill form-control{{ $errors->has("amount-'+ item_num +'") ? " is-invalid" : "" }}" value="{{ old("amount-'+ item_num +'") }}" readonly></th>' +
            '<th class="p-2"><textarea autocomplete="off" onkeyup="textchange()" id="note-'+ item_num +'" name="note-'+ item_num +'" class="rounded-pill form-control{{ $errors->has("note-'+ item_num +'") ? " is-invalid" : "" }}">{{ old("note-'+ item_num +'") }}</textarea></th>'
        parent.appendChild(tr);
        calculation()
    }

    function sum() {
        var quantity, price, sum = 0
        for (var i = 0; i < item_num+1; i++) {
            quantity = document.getElementById('quantity-' + i).value
            price = document.getElementById('price-' + i).value
            amount_one = document.getElementById('amount-' + i)
            
            amount_one.value = Math.round(quantity * price)
            sum = sum + quantity * price
        }
        return sum
    }

    function calculation() {
        amount.value = sum()
        total_amount.value = Math.round(amount.value * 1.05)
        tex.value = Math.round(total_amount.value * 0.05)
    }

    function textchange(){
        for (var i = 0; i < item_num+1; i++) {
            note = document.getElementById('note-' + i).value;
            note = note.replace(/\r/ig, '').replace(/\n/ig, '<br/>');
        }
    }
</script>
<script>
    var nowPage = 1;
    var customers = [];
    var customer_click = null
    function listPage(){
        customers = getNewCustomer()
        listCustomerdata()
        listCustomerPage()
    }

    function getNewCustomer(){
        data ="{{$customer}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }
    function listCustomerdata(){
        $("#customer_table").empty();
        var parent = document.getElementById('customer_table');
        var thead = document.createElement("thead");
        thead.innerHTML = '<tr class="bg-dark text-white"  style="text-align:center">' +
            '<th class="px-2" width="60%"><label class="label-style col-form-label" for="customer_name">客戶名稱</label></th>' +
            '<th class="px-2" width="40%"><label class="label-style col-form-label" for="customer_principal">負責人</label></th>' +
            '</tr>'
        parent.appendChild(thead);
        var tr, span, name, a
        var tbody = document.createElement("tbody");

        for (var i = 0; i < customers.length; i++) {
            if (i >= (nowPage - 1) *6 && i < nowPage * 6) {
                tbody.innerHTML = tbody.innerHTML + setCustomerData(i)
            } else if (i >= nowPage * 6) {
                break
            }
        }

        parent.appendChild(tbody);
    }
    function setCustomerData(i) {

        tr = "<tr style='cursor: pointer;' class='customer-bank-edit-hover' id='" + customers[i].id + "_tr' onclick='setEditCustomerData("+ i +")' >" +
            "<td class='text-left' >" + customers[i].name + "</td>" +
            "<td class='text-left' style='justify-content: center;display: flex;' >" + customers[i].principal + "</td>" +
            "</tr>"
        
        return tr
    }

    function setEditCustomerData(val){
        
        
        if(customer_click != null){
            var click_old = document.getElementById(customers[customer_click].id + '_tr')
            
            click_old.classList.remove('customer-bank-edit-select')
        }
        var customer_tr = document.getElementById(customers[val].id + '_tr')
        customer_tr.classList.add('customer-bank-edit-select')
        customer_click = val
        
        $('#customer_name').val(customers[val].name)
        $('#customer_principal').val(customers[val].principal)
        $('#customer_phone').val(customers[val].phone)
        $('#customer_mail').val(customers[val].email)
        $('#customer_id').val(customers[val].id)
        document.getElementById('customer_mail').required = false;
        document.getElementById('customer_phone').required = false;

    }

    function listCustomerPage(){
        $("#Page-customer").empty();
        var parent = document.getElementById("Page-customer");
        var div = document.createElement("div");
        div.setAttribute('style','width:100%')
        var number = Math.ceil(customers.length /8)
        var data = ''
        if (nowPage < 4) {
            for (var i = 0; i < number; i++) {
                if (i < 5) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changenowPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                } else {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changenowPage(' + number + ')">' + number + '</a></li>'
                    break
                }
            }
        } else if (nowPage >= 4 && nowPage - 3 <= 2) {
            for (var i = 0; i < number; i++) {
                if (i < nowPage + 2) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changenowPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                } else {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changenowPage(' + number + ')">' + number + '</a></li>'
                    break
                }
            }
        }else if (nowPage >= 4 && nowPage - 3 > 2 && number - nowPage >= 4) {
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changenowPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= nowPage - 3 && i <= nowPage + 1) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changenowPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'

                } else if (i > nowPage + 1) {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changenowPage(' + number + ')">' + number + '</a></li>'
                    break
                }


            }
        } else if (number - nowPage <= 5 && number - nowPage >= 4) { //
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changenowPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= nowPage - 1) {
                    data = data + '<li class="page-item page-' + (i+ 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changenowPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                }
            }
        } else if (number - nowPage < 4) {//尾巴
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changenowPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= number - 5) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changenowPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                }
            }
        }
        var previous = "previous"
        var next = "next"
        div.innerHTML = '<nav aria-label="Page navigation example">' +
            '<ul class="pagination" style="justify-content: space-between;">' +
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
    function changenowPage(index) {
        bankList_id = null
        var temp = document.getElementsByClassName('page-item')

        $(".page-" + String(nowPage)).removeClass('active')
        nowPage = index
        $(".page-" + String(nowPage)).addClass('active')

        listCustomerdata()
    }

    function nextnowPage() {
        var number = Math.ceil(customers.length /8)
        bankList_id = null
        if (nowPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage++
            $(".page-" + String(nowPage)).addClass('active')
        }
        listCustomerdata()
    }
    function previousnowPage() {
        var number = Math.ceil(customers.length /8)
        bankList_id = null
        if (nowPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage--
            $(".page-" + String(nowPage)).addClass('active')

        }
        listCustomerdata()
    }
</script>
<script src="{{ URL::asset('js/grv.js') }}"></script>
@stop