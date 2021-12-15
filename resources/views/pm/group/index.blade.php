@extends('layouts.app')
@section('content')
<div class="col-lg-12 ">
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <div class="card border-0 shadow rounded-pill">
                    <div class="card-body show-project-invoice">
                        <div class="form-group">
                            <label class="col-lg-12 col-form-label">團體名稱</label>
                            <div class="col-lg-12">
                                <input placeholder="搜尋" type="text" list="list-groupName" id="search-group" autocomplete="off" name="search-group" class="rounded-pill form-control" onchange="selectGroupName(this.value)">
                                <datalist id="list-groupName">
                                </datalist>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-lg-12 col-form-label">類別</label>
                            <div class="col-lg-12">
                                <select type="text" id="type" name="type" class="form-control rounded-pill" onchange="select('type',this.options[this.options.selectedIndex].value)">
                                    <option value=""></option>
                                    @foreach ($types as $data)
                                        <option value="{{$data->type}}">{{$data->type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="item_type" class="col-lg-12 col-form-label">細項</label>
                            <div class="col-lg-12">
                                <select type="text" id="item_type" name="item_type" class="form-control rounded-pill" onchange="select('item_type',this.options[this.options.selectedIndex].value)">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-lg-12 col-form-label">地區</label>
                            <div class="col-lg-12">
                                <select type="text" id="address" name="address" class="form-control rounded-pill" onchange="select('address',this.options[this.options.selectedIndex].value)">
                                    <option value="" ></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card border-0 shadow" style="min-height: calc(100vh - 135px)">
                <div class="card-body">
                    <div class="form-group col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 d-flex justify-content-end">
                                <button class="btn btn-green rounded-pill" onclick="location.href='{{route('group.create')}}'"><span class="mx-2">{{__('customize.Add')}}</span> </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12 table-style-invoice">
                            <table id="list-group">
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>

<script>
    
    var groupName=''
    var groupNames =[]

    var group =''
    var groups=[]

    var type = ''
    var types = []

    var item_type = ''
    var items_type =[]

    var address = ''
    var addreses = []
    
    $(document).ready(function(){
        setAccount()
        setItemType()
        setAddress()
        setGroup()
    });

    function reset(){
        groups =getNewGroup()

        groupName=''
        groupNames =[]

        item_type = ''
        items_type =[]

        type = ''
        types = [] 
        
        address = ''
        addreses = []
        $('#search-group').val("")
        setType()
        setAccount()
        setItemType()
        setAddress()
        setGroup()
    }

    function select(data,val){
        switch(data){
            case 'type':
                type = val
                if(val == ''){
                    reset()
                }else{
                    item_type = ''
                    address = ''
                    setGroup()
                    setItemType()
                    setAddress()
                }
                break;
            case 'item_type':
                item_type = val
                if(val == ''){
                    reset()
                }else{
                    address = ''
                    setGroup()
                    setAddress()
                }
                break;
            case 'address':
                address = val
                if(val == ''){
                    reset()
                }else{
                    setGroup()
                }
                break;
            default:
        }
    }

    function selectGroupName(val){
        groupName = val
        if(val ==''){
            reset()
        }
        else{
            setGroup()
        }
    }

    function setGroup(){
        groups = getNewGroup()
        for(var i = 0 ; i < groups.length ; i++){
            if(type != ''){
                if(groups[i]['type'] != type){
                    groups.splice(i, 1)
                    i--
                    continue
                }
            }
            if(item_type != ''){
                if(groups[i]['item_type'] != item_type){
                    groups.splice(i, 1)
                    i--
                    continue
                }
            }
            if(address != ''){
                if(groups[i]['address'] != address){
                    groups.splice(i, 1)
                    i--
                    continue
                }
            }
            if(groupName != ''){
                if(groups[i]['name'] != groupName){
                    groups.splice(i, 1)
                    i--
                    continue
                }
            }
        }
        listGroup()
    }

    function setType(){
        types = getNewType()
        type = ''
        $('#type').empty()
        $('#type').append("<option value=''></option>")
        for(var i = 0 ; i < types.length ; i++){
            $('#type').append("<option value='"+types[i]+"'>"+types[i]+"</option>");
        }
    }

    function setItemType(){
        items_type = getNewItemType()
        item_type = ''

        $('#item_type').empty()
        $('#item_type').append("<option value=''></option>");
        for(var i = 0 ; i < items_type.length ; i++){
            $('#item_type').append("<option value='"+items_type[i]+"'>"+items_type[i]+"</option>");
        }
    }

    function setAddress(){
        addresses = getNewAddress()
        address = ''
        
        $('#address').empty()
        $('#address').append("<option value=''></option>")
        for(var i = 0 ; i < addresses.length ; i++){
            $('#address').append("<option value='"+addresses[i]+"'>"+addresses[i]+"</option>");
        }
    }

    function setAccount() {
        groups = getNewGroup()

        groupName = ''
        groupNames = [] //初始化

        for (var i = 0; i < groups.length; i++) {
            if (groupNames.indexOf(groups[i]['name']) == -1) {
                groupNames.push(groups[i]['name'])
            }
        }
        groupNames.sort(function(a, b) {
            return a.length - b.length;
        });

        for (var i = 0; i < groupNames.length; i++) {
            $("#list-groupName").append("<option value='" + groupNames[i] + "'>" + groupNames[i] + "</option>");
        }
    }

    function getNewGroup() {
        data = "{{$group}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    function getNewType(){
        var temp = []
        var TypeTemp = []
        for(var i = 0;i<groups.length;i++){
            if(temp.indexOf(groups[i]['type']) == -1){
                temp.push(groups[i]['type'])
                TypeTemp.push(groups[i]['type'])
            }
        }
        return TypeTemp
    }

    function getNewItemType(){
        var temp = []
        var itemTemp = []
        for(var i = 0;i<groups.length;i++){
            if(temp.indexOf(groups[i]['item_type']) == -1){
                temp.push(groups[i]['item_type'])
                itemTemp.push(groups[i]['item_type'])
            }
        }
        return itemTemp
    }

    function getNewAddress(){
        var temp = []
        var addressTemp = []
        for(var i = 0;i<groups.length;i++){
            if(temp.indexOf(groups[i]['address']) == -1){
                temp.push(groups[i]['address'])
                addressTemp.push(groups[i]['address'])
            }
        }
        return addressTemp
    }

    function listGroup(){
        $('#list-group').empty()
        var parent = document.getElementById('list-group')
        var table = document.createElement("tbody");
        table.innerHTML = '<tr class="text-white">' +
            '<th>團體名稱</th>' +
            '<th>團體類別</th>' +
            '<th>所在地區</th>' +
            '<th>聯絡方式</th>' +
            '<th>簡易介紹</th>' +
            '</tr>'
        
        var to , list , cele , content

        for (var i = 0; i < groups.length; i++) {
            table.innerHTML = table.innerHTML + setData(i)
        }
        parent.appendChild(table);
        
    }

    function setData(i){
        cele = ''
        content = ''
        to = "/group/" + groups[i]['group_id'] + "/review"

        if(groups[i].phone != null){
            cele = cele + "室話： "+groups[i].phone + "<br>"
        }
        if(groups[i].telephone != null){
            cele = cele + "手機： "+groups[i].telephone+"<br>"
        }
        if(groups[i].fax != null){
            cele = cele + "傳真： "+groups[i].fax
        }
        
        list = "<tr >" +
            "<td width='20%' ><a href='" + to + "' target='_blank' style='font-size: 12pt'>" + groups[i].name + "</td>" +
            "<td width='15%' ><a href='" + to + "' target='_blank' style='font-size: 12pt'>" + groups[i].type + "</td>" +
            "<td width='10%' ><a href='" + to + "' target='_blank' style='font-size: 12pt'>" + groups[i].address + "</td>" +
            "<td width='20%' ><a href='" + to + "' target='_blank' style='font-size: 12pt'>" + cele +"</td>" +
            "<td width='35%' ><a href='" + to + "' target='_blank' style='font-size: 12pt'>" + groups[i].simpleContent + "</td>" +
            "</tr>"

        return list
    }

</script>