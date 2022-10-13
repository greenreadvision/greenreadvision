@extends('layouts.app')
@section('content')
<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <span class="page_title_span">公司文案</span>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a  href="/resource" class="page_title_a" >共用資源</a>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-3 mb-2">
            <div class="card border-0 shadow rounded-pill">
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">類別</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-board-type" name="select-board-type" onchange="select('type',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control mb-2">
                                @foreach($types as $type)
                                <option id="{{$type}}" value="{{$type}}">{{__('customize.'.$type)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button class="w-100 btn btn-green rounded-pill" onclick="reset()"><span>重置</span> </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 mb-2">
            <div class="card border-0 shadow" style="min-height: calc(100vh - 135px)">
                <div class="card-body">
                    <div class="form-group col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 d-flex justify-content-end">
                                <button class="btn btn-green rounded-pill" onclick="location.href='{{route('resource.create')}}'"><span class="mx-2">{{__('customize.Add')}}</span> </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 d-flex justify-content-between">
                        <div id="resource-page" class="d-flex align-items-end">
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
                        <table id="search-board">
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

@stop

@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.14.0/dist/xlsx.full.min.js"></script>
<script>
    var newTypes= ""
    var nowPage = 1
    var resource =[]


    $(document).ready(function() {
        reset();
    });

    function listResource(){
        $('#search-board').empty();
        var parent = document.getElementById('search-board')
        var table = document.createElement("tbody");

        table.innerHTML = '<tr class="text-white">' +
            "<th width='20%'>類別</th>" + 
            "<th width='20%'>廠商名稱</th>" +
            "<th width='20%'>電話</th>" +
            "<th width='20%'>電子郵件</th>" +
            "<th width='20%'>簡介</th>" +
            "<tr>"
        var tr, span, a, tp

        for(var i=0;i< resource.length;i++){
            if(i >=(nowPage - 1)*13 && i <nowPage*13){
                table.innerHTML = table.innerHTML + setResourceData(i)
            }
            else if(i >= nowPage*13){
                break;
            }
            
        }

        parent.appendChild(table);
    }
    
    function changePage(index){
        var temp = document.getElementsByClassName('page-item')

        $(".page-" + String(nowPage)).removeClass('active')
        nowPage = index
        $(".page-" + String(nowPage)).addClass('active')

        listPage()
        listResource()
    }

    function nextPage() {
        var number = Math.ceil(resource.length / 13)

        if (nowPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage++
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listResource()
        }

    }

    function previousPage() {
        var number = Math.ceil(resource.length / 13)

        if (nowPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage--
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listResource()
        }
    }

    function listPage(){
        $("#resource-page").empty()
        var parent = document.getElementById('resource-page');
        var table = document.createElement("div");
        var number = Math.ceil(resource.length / 13)
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


    function setResourceData(i){
        if(resource[i]['type'] == 'host'){
            tp = '主持人'
        }
        else if(resource[i]['type'] == 'performance'){
            tp = '表演團隊'
        }
        else if(resource[i]['type'] == 'stall_food'){
            tp = '攤商(食)'
        }
        else if(resource[i]['type'] == 'stall_ngo'){
            tp = '攤商(NGO)'
        }
        else if(resource[i]['type'] == 'tour'){
            tp = '導覽老師'
        }
        else if(resource[i]['type'] == 'manufacturer'){
            tp = '商品廠商'
        }

        if(resource[i]['phone']==null){
            phone ='';
        }else{
            phone = resource[i]['phone']
        }

        if(resource[i]['email']==null){
            email ='';
        }else{
            email = resource[i]['email']
        }

        if(resource[i]['intro']==null){
            intro ='';
        }else{
            intro = resource[i]['intro']
        }
        a = "/resource/" + resource[i]['id'] + "/review" 
        tr = "<tr>" + 
            "<td width='20%'><a href='" + a + "' target='_blank'>" + tp + "</td>" +   
            "<td width='20%'><a href='" + a + "' target='_blank'>" + resource[i]['name'] + "</td>" +
            "<td width='20%'><a href='" + a + "' target='_blank'>" + phone + "</td>" +
            "<td width='20%'><a href='" + a + "' target='_blank'>" + email + "</td>" +
            "<td width='20%'><a href='" + a + "' target='_blank'>" + intro + "</td>" +
            "</tr>"

        return tr;
    }

    function select(type, id){
        switch(type){
            case 'type':
                newTypes = id;
                if(id == '')
                {
                    reset()
                }
                else
                {
                    nowPage= 1
                    setResource()
                }
                break;
            default:
        }
        if(id != ''){
            listResource()
        }
    }

    function reset(){
        resource = getNewResource()
        nowPage = 1
        setResource();
        setType();
        listResource();
        listPage();
    }

    function getNewResource(){
        data = "{{$datas}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    function setType(){
        newTypes = ''
        $('#select-board-type').val('')

    }

    function setResource(){
        resource = getNewResource()
        for(var i = 0 ;i < resource.length ; i++){
            if(newTypes != ''){
                if(resource[i]['type'] != newTypes){
                    resource.splice(i,1)
                    i--
                    continue
                }
            }
        }
    }

    {{--  function ckeditor_add(){
        for(var i = 0 ;i < resource.length ; i++){
            resource[i]['note']
            var ck = document.getElementById('ckeditor_'+ i)
            ck.innerHTML = resource[i]['note']
        }
    }  --}}
</script>
@stop