@extends('grv.CMS.app')
@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-3 mb-2">
            <div class="card border-0 shadow rounded-pill">
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">開版人員</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-user" name="select-user" onchange="select('user',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control mb-2">
                                <option value=""></option>
                                @foreach($users as $user)
                                <option value="{{$user['user_id']}}">{{$user['name']}}({{$user['nickname']}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">活動類型</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-type" name="select-type" onchange="select('type',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control mb-2">
                                <option value=""></option>
                                @foreach($types as $type)
                                <option value="{{$type['type_id']}}">{{__('customize.' . $type['type_id'])}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">隸屬標案</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-project" name="select-project" onchange="select('project',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control mb-2">
                                <option value=""></option>
                                <optgroup id="select-project-grv_2" label="綠雷德">
                                <optgroup id="select-project-grv" label="綠雷德(舊)">
                                <optgroup id="select-project-rv" label="閱野">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">活動年份</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-year" name="select-year" onchange="select('year',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control mb-2">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">活動月份</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-month" name="select-month" onchange="select('month',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control mb-2">
                                <option value=""></option>
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
                                <button class="btn btn-green rounded-pill" onclick="location.href='{{route('activity.create')}}'"><span class="mx-2">{{__('customize.Add')}}</span> </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 d-flex justify-content-between">
                        <div id="activity-page" class="d-flex align-items-end">
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
                        <table id="search-activity">
                            
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
    var user = ""
    var year = ""
    var project = ""
    var month= ""
    var Types= ""
    var nowPage = 1

    var projects = []
    var years = []
    var months = []
    var activities =[]

    $(document).ready(function() {
        reset();
    });

    function listActivity(){
        $('#search-activity').empty();
        var parent = document.getElementById('search-activity')
        var table = document.createElement("tbody");

        table.innerHTML = '<tr class="text-white">' +
            "<th width='10%'>發佈人員</th>" + 
            "<th width='25%'>專案</th>" +
            "<th width='35%'>活動名稱</th>" +
            "<th width='10%'>活動類型</th>" +
            "<th width='10%'>活動起始日期</th>" +
            "<tr>"
        var tr, span, a, tp

        for(var i=0;i< activities.length;i++){
            if(i >=(nowPage - 1)*10 && i <nowPage*10){
                table.innerHTML = table.innerHTML + setActivityData(i)
            }
            else if(i >= nowPage){
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
        listActivity()
    }

    function nextPage() {
        var number = Math.ceil(activities.length / 10)

        if (nowPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage++
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listActivity()
        }

    }

    function previousPage() {
        var number = Math.ceil(activities.length / 10)

        if (nowPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage--
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listActivity()
        }
    }

    function listPage(){
        $("#activity-page").empty()
        var parent = document.getElementById('activity-page');
        var table = document.createElement("div");
        var number = Math.ceil(activities.length / 10)
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

    function setActivityData(i){
        if(activities[i]['type'] == 'culture'){
            tp = '服務項目'
        }
        else if(activities[i]['type'] == 'reporter'){
            tp = '記者會'
        }
        else if(activities[i]['type'] == 'major-activity'){
            tp = '大型活動'
        }
        else if(activities[i]['type'] == 'Venue'){
            tp = '場館營運'
        }
        
        a = "/activity_CMS/" + activities[i]['activity_id'] + "/show" 
        tr = "<tr>" + 
            "<td width='10%'><a href='" + a + "' target='_blank'>" + activities[i].user['name']+ "</td>" +
            "<td width='35%'><a href='" + a + "' target='_blank'>" + activities[i].project['name']+ "</td>" +
            "<td width='35%'><a href='" + a + "' target='_blank'>" + activities[i]['name']+ "</td>" +
            "<td width='10%'><a href='" + a + "' target='_blank'>" + tp +"</td>" +
            "<td width='10%'><a href='" + a + "' target='_blank'>" + activities[i]['begin_time'] + "</td>" +
            "</tr>"

        return tr;
    }
    function select(type, id){
        switch(type){
            case 'user':
                user = id;
                if(id=='')
                {
                    reset();
                }
                else
                {
                    project = ''
                    year = ""
                    month = ""
                    type = ""
                    nowPage = 1
                    setActivity()
                    setProject()
                    setYear()
                    setMonth()
                }
                break;
            case 'type':
                Types = id;
                if(id == '')
                {
                    reset()
                }
                else
                {
                    project = ''
                    year = ''
                    month = ''
                    nowPage= 1
                    setActivity()
                    setProject()
                    setYear()
                    setMonth()
                }
                break;
            case 'project':
                project = id
                if(id == ''){
                    reset()
                }
                else{
                    year = ''
                    month = ''
                    nowPage= 1
                    setActivity()
                    setYear()
                    setMonth()
                }
            case 'year':
                year = id;
                if(id == '')
                {
                    reset()
                }
                else
                {
                    month = ''
                    nowPage= 1
                    setActivity()
                    setMonth()
                }
                break;
            case 'month':
                month = id;
                if(id == '')
                {
                    reset()
                }
                else
                {
                    nowPage= 1
                    setActivity()
                }
                break;
            default:
        }
        if(id != ''){
            listActivity()
        }
    }

    function reset(){
        setActivity();
        setUser();
        setProject();
        setYear();
        setMonth();
        listActivity();
        listPage();
    }

    function getNewActivity() {
        data = "{{$actitvies}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }
    function getNewProject() {
        var temp = []
        var projectTemp = []
       
        for (var i = 0; i < activities.length; i++) {
            if (temp.indexOf(activities[i].project['name']) == -1) {
                temp.push(activities[i].project['name'])
                projectTemp.push(activities[i].project)
            }
        }
        return projectTemp
    }

    function setUser(){
        user = ''
        $("#select-user").val("")
    }

    function setProject(){
        projects = getNewProject()
        project = ''
        $("#select-project-grv_2").empty();
        $("#select-project-grv").empty();
        $("#select-project-rv").empty();

        for (var i = 0; i < projects.length; i++) {
            if (projects[i]['name'] != "其他") {
                if (projects[i]['company_name'] == "grv") {
                    $("#select-project-grv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                } else if (projects[i]['company_name'] == "rv") {
                    $("#select-project-rv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                } else if (projects[i]['company_name'] == "grv_2") {
                    $("#select-project-grv_2").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                }
            }
        }

    }

    function setYear(){
        year = ''
        years = []
        $('#select-year').val('')
        $('#select-year').empty()
        $('#select-year').append("<option value=''></option>")

        for (var i = 0; i < activities.length; i++) {
            if (years.indexOf(activities[i]['year']) == -1) {
                years.push(activities[i]['year'])
            }
        }
        years.sort();
        for(var j = 0;j < years.length; j++){
            $("#select-year").append("<option value='" + years[j] + "'>" + years[j] + "</option>");
        }

    }

    function setMonth(){
        month = ''
        months = []
        $('#select-month').val('')
        $('#select-month').empty()
        $('#select-month').append("<option value=''></option>")

        for (var i = 0; i < activities.length; i++) {
            if (months.indexOf(activities[i]['month']) == -1) {
                months.push(activities[i]['month'])
            }
        }
        months.sort();
        for(var j = 0;j < months.length; j++){
            $("#select-month").append("<option value='" + months[j] + "'>" + months[j] + "</option>");
        }
    }

    function setActivity(){
        activities = getNewActivity();
        for(var i = 0 ; i < activities.length ; i++){
            if(user != ''){
                if(activities[i]['user_id'] != user && activities[i].project['user_id'] != user){
                    activities.splice(i,1)
                    i--
                    continue
                }
            }
            if(project != ""){
                if(activities[i].project['project_id'] != project){
                    activities.splice(i,1)
                    i--
                    continue
                }
            }
            if(Types != ""){
                if(activities[i]['type'] != Types){
                    activities.splice(i,1)
                    i--
                    continue
                }
            }
            if(year != ""){
                if(activities[i]['year'] != year){
                    activities.splice(i,1)
                    i--
                    continue
                }
            }
            if(month != ""){
                if(activities[i]['month'] != month){
                    activities.splice(i,1)
                    i--
                    continue
                }
            }
        }
    }
</script>
