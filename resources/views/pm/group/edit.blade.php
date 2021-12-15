@extends('layouts.app')
@section('content')

@foreach ($group_active as $item)
<div class="modal fade" id="deleteActive{{$item['id']}}" tabindex="-1" role="dialog" aria-labelledby="deleteActive{{$item['id']}}" aria-hidden="true">
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
                <button type="button" class="btn btn-blue rounded-pill" onclick="RemoveActive({{$item['id']}})" data-dismiss="modal">是</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<div class="d-flex justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body">
                <div class="col-lg-12">
                    <form id="formType" action="update" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="col">
                            <span style="font-size: 15pt"><b style="color: red">*</b>為必填，<b style="color:green">*</b>為兩者需至少填寫一個</span>
                            <div class="form-row">
                                <div class="col-lg-6" >
                                    <label for="type" class=" col-form-label"><b style="color: red">*</b>類別</label>
                                    <select type="text" id="type" name="type" class="form-control rounded-pill" onchange="changeType(this.options[this.options.selectedIndex].value)">
                                        <option value=""></option>
                                        @foreach ($types as $data)
                                            <option value="{{$data->type}}" {{$data->type == $group->type ? 'selected' : ''}}>{{$data->type}}</option>
                                        @endforeach
                                        <option value="other">其他</option>
                                    </select>
                                </div>
                                <div class="col-lg-3" id="new_type" hidden>
                                    <label for="new_type" class=" col-form-label" ><b style="color: red">*</b>新類別</label>
                                    <input autocomplete="off" type="text" id="new_type_input" name="new_type" class="form-control rounded-pill" value="{{ old('new_type') }}">
                                </div>
                                <div class="col-lg-3" id="new_item_type" hidden>
                                    <label for="new_item_type" class=" col-form-label"><b style="color: red">*</b>新細項</label>
                                    <input autocomplete="off" type="text" id="new_item_type_input" name="new_item_type" class="form-control rounded-pill" value="{{ old('new_item_type') }}">
                                </div>
                            </div>
                            <div class="form-row" id="item_all">
                                <div class="col-lg-6">
                                    <label for="item_type" class=" col-form-label"><b style="color: red">*</b>細項類別</label>
                                    <select type="text" id="item_type" name="item_type" class="form-control rounded-pill" onchange="changeItem(this.options[this.options.selectedIndex].value)">
                                        <option value=""></option>
                                        
                                        
                                       
                                    </select>
                                </div>
                                <div class="col-lg-3" id="item_type_new" hidden>
                                    <label for="item_type_new" class=" col-form-label"><b style="color: red">*</b>新細項</label>
                                    <input autocomplete="off" type="text" id="item_type_new_input" name="item_type_new" class="form-control rounded-pill"  value="{{ old('item_type_new') }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-6">
                                    <label for="name" class="col-form-label" ><b style="color: red">*</b>名稱</label>
                                    <input autocomplete="off" type="text" id="name" name="name" class="form-control rounded-pill"  value="{{$group->name}}" required/>
                                </div>
                                <div class="col-lg-6">
                                    <label for="webAddress" class="col-form-label" >網站</label>
                                    <input autocomplete="off" type="text" id="webAddress" name="webAddress" class="form-control rounded-pill"  value="{{ $group->webAddress}}" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-4">
                                    <label for="phone" class="col-form-label"><b style="color:green">*</b>室話</label>
                                    <input autocomplete="off" maxlength="15" type="text" id="phone" name="phone" class="form-control rounded-pill" onchange="checkPhone()" value="{{ $group->phone}}" required/>
                                </div>
                                <div class="col-lg-4">
                                    <label for="telephone" class="col-form-label"><b style="color:green">*</b>手機</label>
                                    <input autocomplete="off" maxlength="10" type="text" id="telephone" pattern="[0-9]{10}"  name="telephone" onchange="checkPhone()" class="form-control rounded-pill" value="{{ $group->telephone }}"/>
                                </div>
                                <div class="col-lg-4">
                                    <label for="fax" class="col-form-label">傳真(選填)</label>
                                    <input autocomplete="off" maxlength="15" type="text" id="fax" name="fax" class="form-control rounded-pill" value="{{ $group->fax }}"/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-6" id="twzipcode">
                                    <label for="address" class="col-form-label"><b style="color: red">*</b>縣市</label>
                                    <select type="text" id="address" name="address" class="form-control rounded-pill">
                                        <option value="台北" {{$group->address=='台北'? 'selected': ''}}>台北</option>
                                        <option value="新北" {{$group->address=='新北'? 'selected': ''}}>新北</option>
                                        <option value="基隆" {{$group->address=='基隆'? 'selected': ''}}>基隆</option>
                                        <option value="桃園" {{$group->address=='桃園'? 'selected': ''}}>桃園</option>
                                        <option value="新竹" {{$group->address=='新竹'? 'selected': ''}}>新竹</option>
                                        <option value="苗栗" {{$group->address=='苗栗'? 'selected': ''}}>苗栗</option>
                                        <option value="台中" {{$group->address=='台中'? 'selected': ''}}>台中</option>
                                        <option value="彰化" {{$group->address=='彰化'? 'selected': ''}}>彰化</option>
                                        <option value="南投" {{$group->address=='南投'? 'selected': ''}}>南投</option>
                                        <option value="雲林" {{$group->address=='雲林'? 'selected': ''}}>雲林</option>
                                        <option value="嘉義" {{$group->address=='嘉義'? 'selected': ''}}>嘉義</option>
                                        <option value="台南" {{$group->address=='台南'? 'selected': ''}}>台南</option>
                                        <option value="高雄" {{$group->address=='高雄'? 'selected': ''}}>高雄</option>
                                        <option value="屏東" {{$group->address=='屏東'? 'selected': ''}}>屏東</option>
                                        <option value="宜蘭" {{$group->address=='宜蘭'? 'selected': ''}}>宜蘭</option>
                                        <option value="花蓮" {{$group->address=='花蓮'? 'selected': ''}}>花蓮</option>
                                        <option value="台東" {{$group->address=='台東'? 'selected': ''}}>台東</option>
                                        <option value="澎湖" {{$group->address=='澎湖'? 'selected': ''}}>澎湖</option>
                                        <option value="金門" {{$group->address=='金門'? 'selected': ''}}>金門</option>
                                        <option value="馬祖" {{$group->address=='馬祖'? 'selected': ''}}>馬祖</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class = "col-lg-12">
                                    <label class="label-style col-form-label" for="Group_active"> 過往是否有協助過本公司的活動</label>
                                    <div class="form-group">
                                        <div class="btn-group btn-group-toggle w-50" data-toggle="buttons">
                                            @if(count($group_active) == 0)
                                            <label class="btn btn-secondary active w-25" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px">
                                                <input type="radio" name="options" onchange="changeActive(0)" autocomplete="off" checked> 無
                                            </label>
                                            <label class="btn btn-secondary w-25" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">
                                                <input type="radio" name="options" onchange="changeActive(1)" autocomplete="off"> 有
                                            </label>
                                            @else
                                            <label class="btn btn-secondary w-25" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px">
                                                <input type="radio" name="options" onchange="changeActive(0)" autocomplete="off"> 無
                                            </label>
                                            <label class="btn btn-secondary active w-25" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">
                                                <input type="radio" name="options" onchange="changeActive(1)" autocomplete="off" 9checked> 有
                                            </label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="createNewActive">
                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <label class="label-style col-form-label" for="project_name"> 參與標案名稱</label>
                                        <select type="text" id="project_name" name="project_name" class="form-control rounded-pill">
                                            <option value=""></option>
                                            @foreach ($projects as $data)
                                                <option value="{{$data->name}}">{{$data->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="label-style col-form-label" for="active_name"> 活動名稱</label>
                                        <input type="text" id="active_name" name="active_name" class="form-control rounded-pill"/>
                                        <p id="demo" style="color: red"></p>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-lg-10 table-style-invoice">
                                        <label class="label-style col-form-label" ></label>
                                        <table id="list-active">
                                            
                                        </table>
                                    </div>
                                    <div class="col-lg-2" style="text-align: end">
                                        <label class="label-style col-form-label" ></label>
                                        <div>
                                            <button type="button" class="btn btn-green rounded-pill" onclick="createActive()"><span class="mx-2">活動新增</span> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-12">
                                    <label class="label-style col-form-label" for="content"><b style="color: red">*</b> 簡易介紹(請別超過50字)</label>
                                    <input type="text" id="simple_content" name="simple_content" class="form-control rounded-pill" value="{{$group->simpleContent}}" required/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-12">
                                    <label class="label-style col-form-label" for="content"> 詳細介紹</label>
                                    <textarea id="content" name="content" rows="5" style="resize:none;" class="form-control rounded-pill" >{{$group->content}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div >
                            <hr size="8px" align="center" width="100%">
                        </div>
                        <div class="d-flex justify-content-end">
                            @method('PUT')
                            @csrf
                            <button type="submit" class="btn btn-green rounded-pill"><span class="mx-2">更新</span> </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.14.0/dist/xlsx.full.min.js"></script>
<script>
    

    var type =""
    
    var group = []
    var item_type_select=[]

    var activeName=[]
    var projectName=[]
    var activeId=[]
    var activeDelete = []

    var group_active =[]

    $(document).ready(function(){
        group = getNewGroup()
        var new_type = document.getElementById('new_type');//新類別輸入框
        var new_item_type = document.getElementById('new_item_type');//type為other時，新細項輸入框
        
        var item_all = document.getElementById('item_all');//細項全部
        var item_type_new = document.getElementById('item_type_new');//新細項輸入框

        var type = document.getElementById('type');//類別選單
        var item_type = document.getElementById('item_type');//細項選單

        group_active =getGroupActive()
        for(var i =0 ; i<group_active.length;i++){
            projectName.push(group_active[i]['projectName'])
            activeName.push(group_active[i]['activeName'])
            activeId.push(group_active[i]['id'])
        }
        listActive()
       

        type = "{{$group->type}}"
        changeType(type)
        
        
    });

    function listActive(){
        $('#list-active').empty()
        var parent = document.getElementById('list-active')
        var table = document.createElement("tbody");
        table.innerHTML = '<tr class="text-white">' +
            '<th>標案名稱</th>' +
            '<th>活動名稱</th>' +
            '<th></th>'
            '</tr>'
        
        var list
        for(var i = 0;i<activeName.length;i++){
            table.innerHTML = table.innerHTML + setData(i)
        }

        parent.appendChild(table);
    }

    

    function setData(i){
        var error = 0
        for(var j=0;j<activeDelete;j++){
            if(activeDelete[j]==activeId[i]){
                error=1
            }
        }
        if(error==0){
            if(activeId[i]!=null){
            list = "<tr id='list-"+activeId[i]+"'>" +
                "<td width='45%' style='margin-bottom: 0'><input type='text' name='projectName-"+activeId[i]+"' value = '"+projectName[i]+"' class='form-control rounded-pill' readonly></td>" +
                "<td width='45%  style='margin-bottom: 0'><input type='text' name='activeName-"+activeId[i]+"' value = '"+activeName[i]+"' class='form-control rounded-pill'></td>" +
                "<td width='10%'><div class='mx-2 icon-red' data-toggle='modal' data-target='#deleteActive"+activeId[i]+"'><i class='far fa-trash-alt'></i></div></td>"
                "</tr>"
            }
            else{
                list = "<tr>" +
                    "<td width='45%' style='margin-bottom: 0'><input type='text' name='projectName-"+i+"' value = '"+projectName[i]+"' class='form-control rounded-pill' readonly></td>" +
                    "<td width='45%  style='margin-bottom: 0'><input type='text' name='activeName-"+i+"' value = '"+activeName[i]+"' class='form-control rounded-pill'></td>" +
                    "<td width='10%'></td>"
                    "</tr>"
            }
        }
        

        return list
            
    }

    function createActive(){
        var project_name = document.getElementById('project_name')
        var active_name = document.getElementById('active_name')
        var error = 0

        if(project_name.value !='' && active_name.value != ''){
            for(var i = 0 ; i < project_name.length ; i++){
                if(projectName[i] == project_name.value && activeName[i] == active_name.value){
                    error = 1
                    active_name.setCustomValidity('標案&活動名稱不能重複喔!')
                    document.getElementById("demo").innerHTML = active_name.validationMessage;
                }
            }
            if(error != 1 ){
                projectName.push(project_name.value)
                activeName.push(active_name.value)
                document.getElementById("demo").innerHTML = "";
            }
        }
        listActive()
    }

    function changeActive(i){
        var project_name = document.getElementById('project_name')
        var active_name = document.getElementById('active_name')
        if(i == '1'){
            document.getElementById('createNewActive').style.display = "inline"
            listActive()
        }else if(i == '0'){
            document.getElementById('createNewActive').style.display = "none"
            
            active_name.value = ""
        }
    }

    function checkPhone(){
        phone = document.getElementById('phone')
        telephone = document.getElementById('telephone')
        if(telephone.value != '' && phone.value == ''){
            $('#phone').removeAttr("required")
        }else if(telephone.value == '' && phone.value == ''){
            $('#phone').attr("required","required")
        }
    }

    function getNewGroup() {
        data = "{{$groups}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    function getGroupActive(){
        data = "{{$group_active}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    function RemoveActive(val){
        var deleteID = 'list-'+val
        var deleteActive = document.getElementById(deleteID)
        deleteActive.style.display = 'none'
        activeDelete.push(val)
    }


    function reset(){
        item_type_select=[]
        $("#item_type").val("");
        $("#item_type").empty();
        $("#item_type").append("<option value=''></option>");
    }

    function changeType(val){
        type=val
        reset()
        if(val == 'other'){
            item_all.hidden = true;
            new_type.hidden = false;
            new_item_type.hidden = false;
            $('#new_type_input').attr("required","required")
            $('#new_item_type_input').attr("required","required")
            item_type_new.hidden = true;
            item_type.options.selectedIndex = 0;
        }
        else if(val != ''){
            item_all.hidden = false;
            new_type.hidden = true;
            new_item_type.hidden = true;
            $('#new_type_input').removeAttr("required")
            $('#new_item_type_input').removeAttr("required")        
            $('#item_type').removeAttr('disabled');
        }
        else if(val == ''){
            item_all.hidden = false;
            new_type.hidden = true;
            new_item_type.hidden = true;
            item_type_new.hidden = true;
            item_type.options.selectedIndex = 0;
            $('#new_type_input').removeAttr("required")
            $('#new_item_type_input').removeAttr("required")        
            $('#item_type').attr("disabled",'disabled');
        }
        setItemType();
    }

    

    function changeItem(val){
        if(val =="other"){
            item_type_new.hidden = false;
            $("#item_type_new_input").attr("required","required")
        }
        else{
            item_type_new.hidden = true;
            $('#item_type_new_input').removeAttr("required");
        }
    }

    function setItemType(){
        var error = 0
        for(var i = 0; i< group.length ; i++){
            if(item_type_select.length == 0 && group[i]['type']!=type){
                error = 1
            }
            for(var j = 0; j < item_type_select.length ; j++){
                if(group[i]['type']==type){
                    if(item_type_select[j] == group[i]['item_type']){
                        error = 1
                    }
                }
                else{
                    error = 1
                }
            }
            if(error != 1){
                item_type_select.push(group[i]['item_type'])
            }
            error = 0
        }

        for(i = 0; i<item_type_select.length;i++){
            if(item_type_select[i] == "{{$group->item_type}}"){
                $('#item_type').append(" <option value='"+item_type_select[i] +"' selected>"+item_type_select[i]+"</option>");
            }else{
                $('#item_type').append(" <option value='"+item_type_select[i] +"'>"+item_type_select[i]+"</option>");
            }
            
        }
        $('#item_type').append(" <option value='other'>其他</option>");
    }
</script>