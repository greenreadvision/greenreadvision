@extends('layouts.app')
@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-3  col-12">
            <div class="card border-0 shadow rounded-pill">
                <div class="card-body">
                    <div class="col-12 form-group">
                        <label class="col-lg-12 col-12  col-form-label" style="padding: calc(.375rem + 1px) 0;">承辦人</label>
                        <div class="row">
                            <div class="col-lg-12 col-6">
                                <select type="text" id="select-estimate-user" name="select-estimate-user" onchange="select('user',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control mb-2">
                                    <option value=""></option>
                                    @foreach($users as $user)
                                    <option value="{{$user['user_id']}}">{{$user['name']}}({{$user['nickname']}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 form-group">
                        <label class="col-lg-12 col-12 col-form-label" style="padding: calc(.375rem + 1px) 0;">專案</label>
                        <div class="row">
                            <div class="col-lg-12 col-6">
                                <select type="text" id="select-estimate-project" name="select-estimate-project" onchange="select('project',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                    <option value=''></option>
                                    <optgroup id="select-estimate-project-grv_2" label="綠雷德創新">
                                        @foreach ($projects as $item)
                                            @if($item->company_name == 'grv_2')
                                                <option value="{{$item->project_id}}">{{$item->name}}</option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                    <optgroup id="select-estimate-project-rv" label="閱野">
                                        @foreach ($projects as $item)
                                            @if($item->company_name == 'rv')
                                                <option value="{{$item->project_id}}">{{$item->name}}</option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-6 form-group ">
                            <label class="col-lg-12 col-12 col-form-label">年份</label>
                            <div class="col-lg-12 col-12">
                                <select type="text" id="select-estimate-year" name="select-estimate-year" onchange="select('year',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                    <option value=''></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-6 form-group">
                            <label class="col-lg-12 col-12 col-form-label">月份</label>
                            <div class="col-lg-12 col-12">
                                <select type="text" id="select-estimate-month" name="select-estimate-month" onchange="select('month',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                    <option value=''></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button class="w-100 btn btn-green rounded-pill" onclick="reset()"><span>重置</span> </button>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-9 col-12">
            <div class="card border-0 shadow" style="min-height: calc(100vh - 135px)">
                <div class="card-body">
                    <div class="form-group col-lg-12">
                        <div class="row">
                            <div class="col-lg-2 col-6">
                                <input type="text" name="search-num" id="search-num" class="form-control  rounded-pill" placeholder="報價單號" autocomplete="off" onkeyup="searchNum()">
                            </div>
                            <div class=" col-lg-4 col-6">
                                <input type="text" name="search-estimate" id="search-estimate" class="form-control rounded-pill " placeholder="搜尋" autocomplete="off" onkeyup="searchEstimate()">
                            </div>
                            <div class="col-lg-6 col-12 d-flex justify-content-end">
                                <button class="btn btn-green rounded-pill" onclick="location.href='{{route('estimate.create')}}'"><span class="mx-2">{{__('customize.Add')}}</span> </button>
                            </div>
                        </div>
                    </div>
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
                        <table id="show-estimate">
                            
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

<script type="text/javascript">

    var user = '';
    var project = '';
    var year = '';
    var month = '';
    var temp = '';
    var numtemp = '';
    var nowPage = 1;

    var project=[];
    var estimate=[];
    $(document).ready(function() {
        reset()
    });

    function reset() {
        estimate = getNewEstimate();
        console.log(estimate)
        nowPage = 1;
        setUser();
        setProject();
        setYear();
        setMonth();
        setSearch();
        setSearchNum();
        listEstimate();
        listEstimatePage()
    }

//reset All the patch------------------------------------

    function getNewEstimate(){
        data = "{{$estimate}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    function setUser(){
        console.log('resetUser')
        $('#select-estimate-user').val('');
        user = '';
    }

    function setProject(){
        console.log('resetProject');
        $('#select-estimate-project').val('')
        project = '';
    }

    function setYear(){
        console.log('resetYear');
        year = '';
        years = [];
        $('#select-estimate-year').val('')
        $('#select-estimate-year').empty();
        $("#select-estimate-year").append("<option value=''></option>");
        for (var i = 0; i < estimate.length; i++) {
            if (years.indexOf(estimate[i]['created_at'].substr(0, 4)) == -1) {
                years.push(estimate[i]['created_at'].substr(0, 4))
                $("#select-estimate-year").append("<option value='" + estimate[i]['created_at'].substr(0, 4) + "'>" + estimate[i]['created_at'].substr(0, 4) + "</option>");
            }
        }
        
    }

    function setMonth(){
        console.log('resetMonth');
        month = ''
        $('#select-estimate-month').val('')
        $("#select-estimate-month").empty();
        $("#select-estimate-month").append("<option value=''></option>");
        for (var i = 0; i < 12; i++) {
            if (i < 9) {
                $("#select-estimate-month").append("<option value='0" + (i + 1) + "'>" + "0" + (i + 1) + "</option>");
            } else {
                $("#select-estimate-month").append("<option value='" + (i + 1) + "'>" + (i + 1) + "</option>");

            }
        }
    }

    function setSearchNum(){
        numTemp = ''
        document.getElementById('search-num').value = numTemp
    }

    function setSearch(){
        temp = ''
        document.getElementById('search-estimate').value = temp
    }

    function searchNum(){
        numTemp = document.getElementById('search-num').value
        nowPage = 1
        setEstimate()
        listEstimate()
        listEstimatePage()
    }

    function searchEstimate(){
        temp = document.getElementById('search-estimate').value
        nowPage = 1
        setEstimate()
        listEstimate()
        listEstimatePage()
    }

//----------------------------------------------------------
    
//list------------------------------------------------------
    function listEstimate(){
        $("#show-estimate").empty();
        var parent = document.getElementById('show-estimate');
        var table = document.createElement("tbody");
        table.innerHTML = '<tr class="text-white">' +
            '<th>報價單號</th>' +
            '<th>承辦人員</th>' +
            '<th>負責專案</th>' +
            '<th>報價大綱</th>' +
            '<th>報價費用</th>' +
            '<th>報價日期</th>' +
            '</tr>'

        for (var i = 0; i < estimate.length; i++) {
            if (i >= (nowPage - 1) * 13 && i < nowPage * 13) {
                table.innerHTML = table.innerHTML + setData(i)
            } else if (i >= nowPage * 13) {
                break
            }
        }

        parent.appendChild(table);
    }

    function setData(i){
        a = "/estimate/" + estimate[i]['estimate_id'] + "/show"
        tr = "<tr>" +
            "<td width='10%'><a href='" + a + "'  target='_blank'>" + estimate[i].final_id + "</td>" +
            "<td width='15%'><a href='" + a + "'  target='_blank'>" + estimate[i].user['name'] + "(" + estimate[i].user['nickname'] + ")" + "</td>" +
            "<td width='30%'><a href='" + a + "' target='_blank'>" + estimate[i].active_name + "</td>" +
            "<td width='25%'><a href='" + a + "' target='_blank'>" + estimate[i].active_title + "</a></td>" +
            "<td width='10%'><a href='" + a + "' target='_blank'>" + commafy(estimate[i].total_price) + "</td>" +
            "<td width='10%'><a href='" + a + "' target='_blank'>" + estimate[i].created_at.substr(0, 10) + "</td>" +
            "</tr>"


        return tr
    }

    
//----------------------------------------

//Tool------------------------------------
    function commafy(num) {
        num = num + "";
        var re = /(-?\d+)(\d{3})/
        while (re.test(num)) {
            num = num.replace(re, "$1,$2")
        }
        return num;
    }
//----------------------------------------

//PAGE---------------------------------------
    function nextPage() {
        var number = Math.ceil(estimate.length / 13)

        if (nowPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage++
            $(".page-" + String(nowPage)).addClass('active')
            listEstimatePage()
            listEstimate()
        }

    }

    function changePage(index) {

        var temp = document.getElementsByClassName('page-item')

        $(".page-" + String(nowPage)).removeClass('active')
        nowPage = index
        $(".page-" + String(nowPage)).addClass('active')

        listEstimatePage()
        listEstimate()

    }

    function previousPage() {
        var number = Math.ceil(estimate.length / 13)

        if (nowPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage--
            $(".page-" + String(nowPage)).addClass('active')
            listEstimatePage()
            listEstimate()
        }

    }

    function listEstimatePage() {
        $("#page-navigation").empty();
        var parent = document.getElementById('page-navigation');
        var div = document.createElement("div");
        var number = Math.ceil(estimate.length / 13)
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
//------------------------------------------
</script>

<script>
    function select(type,value){
        switch(type){
            case 'user':
                user = value
                if(value ==''){
                    reset()
                }else{
                    project =''
                    year=''
                    month=''
                    setEstimate()
                    setProject()
                    setYear()
                    setMonth()
                }
                break;
            case 'project':
                project = value
                if(value ==''){
                    reset()
                }else{
                    year=''
                    month=''
                    setEstimate()
                    setYear()
                    setMonth()
                }
                break;
            case 'year':
                year = value
                if(value ==''){
                    reset()
                }else{
                    month=''
                    setEstimate()
                    setMonth()
                }
                break;
            case 'month':
                month = value
                if(value ==''){
                    reset()
                }else{
                    setEstimate()
                }
                break;
            default: 

        }
        if (value != '') {
            setSearchNum()
            setSearch()
            listEstimatePage()
            listEstimate()
        }
    }

    function setEstimate(){
        estimate = getNewEstimate();
        for(var i = 0 ; i < estimate.length ; i++){
            if(user != ''){
                if(estimate[i]['user_id'] != user){
                    estimate.splice(i, 1)
                    i--
                    continue
                }
            }
            if(project != ''){
                if(estimate[i]['project_id'] != project){
                    estimate.splice(i, 1)
                    i--
                    continue
                }
            }
            if(year != ''){
                if(estimate[i]['created_at'].substr(0, 4) != year){
                    estimate.splice(i, 1)
                    i--
                    continue
                }
            }
            if(month != ''){
                console.log(month)
                if(estimate[i]['created_at'].substr(5, 2) != month){
                    estimate.splice(i, 1)
                    i--
                    continue
                }
            }
            if (temp != '') {
                if (estimate[i]['active_title'] == null || estimate[i]['active_title'].indexOf(temp) == -1) {
                    estimate.splice(i, 1)
                    i--
                    continue
                }
            }

            if (numTemp != '') {
                if (estimate[i]['final_id'] == null || estimate[i]['final_id'].indexOf(numTemp) == -1) {
                    estimate.splice(i, 1)
                    i--
                    continue
                }
            }
        }
    }
</script>

@stop