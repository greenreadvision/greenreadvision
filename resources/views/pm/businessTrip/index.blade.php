@extends('layouts.app')
@section('content')

<section class="business_allPage">
    <div class="business_search">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body show-project-invoice">
                <div class="form-group">
                    <label class="business_search_title">申請人</label>
                    <div class="business_search_select">
                        <select type="text" id="select-user" name="select-user" onchange="select('user',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                            <option value=""></option>
                            @foreach($users as $user)
                            <option value="{{$user['user_id']}}">{{$user['name']}}({{$user['nickname']}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="business_search_title">請款公司/專案</label>
                    <div class="business_search_select">
                        <select type="text" id="select-company" name="select-company" onchange="select('company',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                            <option value=""></option>
                            <option value="grv_2">綠雷德創新</option>
                            <option value="rv">閱野文創</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="business_search_select">
                        <select type="text" id="select-project" name="select-project" onchange="select('project',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                            <option value=""></option>
                                <optgroup id="select-project-grv" label="綠雷德">
                                <optgroup id="select-project-rv" label="閱野">
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="business_search_title">報告表年份</label>
                    <div class="business_search_select">
                        <select type="text" id="select-year" name="select-year" onchange="select('year',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                            <option value=""></option>
                            
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="business_search_title">報告表月份</label>
                    <div class="business_search_select">
                        <select type="text" id="select-month" name="select-month" onchange="select('month',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                            <option value=""></option>
                            
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="business_search_select">
                        <button type="button" onclick="reset()" class="business_search_reset rounded-pill btn">重置</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="businessTrip_list">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body">
                <div class="form-group businessTrip_tool">
                    <!-- 數字選單 -->
                    <div id="business-list-page" class="d-flex align-items-end">
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
                    <div class="businessTrip_button">
                        <button class="btn btn-green rounded-pill" onclick="location.href='{{route('businessTrip.create')}}'"><span class="mx-2">{{__('customize.Add')}}</span> </button>
                    </div>
                </div>
                <div class="businessTrip_list_content table-style">
                    <table id="search-businessTrip">
                            
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@stop
@section('css')
<link href="{{ URL::asset('css/pm/grvBusinessTrip.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/tool/table.css') }}" rel="stylesheet">
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.14.0/dist/xlsx.full.min.js"></script>


<script type="text/javascript">
    var user_id = '{{\Auth::user()->user_id}}'
    var user = ""
    var company = ""
    var project = ""
    var year = ""
    var month = ""
    var Page = 1
    
    var businesses=[];
    var projects=[];
    var years=[];

    $(document).ready(function() {
        reset()
    });

    function select(type, id) {
        switch (type) {
            case 'user':
                user = id
                if(id ==""){
                    reset();
                }else{
                    company = ''
                    project = ''
                    year = ''
                    month = ''
                    nowPage = 1;
                    setBusiness()
                    setCompany()
                    setProject()
                    setYear()
                    setMonth()
                }
                break;
            case 'company':
                company = id
                if(id ==""){
                    reset();
                }else{
                    project = ''
                    year = ''
                    month = ''
                    nowPage = 1;
                    setBusiness()
                    setProject()
                    setYear()
                    setMonth()
                }
                break;
            case "project":
                project = id
                if(id ==""){
                    reset();
                }else{
                    year = ''
                    month = ''
                    nowPage = 1;
                    setBusiness()
                    setYear()
                    setMonth()
                }
                break;
            case "year":
                year = id
                if(id ==""){
                    reset();
                }else{
                    month = ''
                    nowPage = 1;
                    setBusiness()
                    setMonth()
                }
                break;
            case "month":
                month = id
                if(id ==""){
                    reset();
                }else{
                    nowPage = 1;
                    setBusiness()
                }
                break;
            default:
                break;
        }
        if (id != '') {
            //setSearchNum()
            //setSearch()
            listBusiness() //列出符合條件的請款項目
            listPage()
        }
    }

    //Reset Function
    function reset(){
        businesses = getNewBusinessTrip();
        projects = getNewProject();
        setUser()
        setProject()
        setCompany()
        setProject()
        setYear()
        setMonth()
        nowPage = 1
        listBusiness()
        listPage()
        
    }

    //資料取得
    function getNewBusinessTrip() {
        data = "{{$businessTrips}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    
    function getNewProject() {
        data = "{{$projects}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    //Set系列
    function setBusiness(){
        businesses = getNewBusinessTrip();
        for(var i = 0; i<businesses.length;i++){
            if (user != '') {
                if (businesses[i]['user_id'] != user) {
                    businesses.splice(i, 1)
                    i--
                    continue
                }
            }
            if(company != ''){
                if(businesses[i]['invoice_type'] == 'invoice'){
                    if(businesses[i].invoice['company_name'] != company){
                        businesses.splice(i, 1)
                        i--
                        continue
                    }   
                }else if(businesses[i]['invoice_type'] == 'otherinvoice'){
                    if(businesses[i].otherinvoice['company_name'] != company){
                        businesses.splice(i, 1)
                        i--
                        continue
                    }
                }
                
            }
            if(project != ''){
                
                if(businesses[i]['invoice_type'] == 'invoice'){
                    
                    if(businesses[i].invoice['project_id'] != project){
                        businesses.splice(i, 1)
                        i--
                        continue
                    }
                }else if(businesses[i]['invoice_type'] == 'otherinvoice'){
                    console.log(project)
                    if(project != "qs8dXg66gPm" && project != "qs8dXg77gPm" && project != "qs8dXg88gPm"){
                        businesses.splice(i, 1)
                        i--
                        continue
                    }
                   
                }
            }
            if(year != ''){
                if(businesses[i]['created_at'].substr(0, 4) != year){
                    businesses.splice(i, 1)
                    i--
                    continue
                }
            }
            if(month != ''){
                if(businesses[i]['created_at'].substr(5, 2) != month){
                    businesses.splice(i, 1)
                    i--
                    continue
                }
            }
        }
    }

    function setUser(){
        user = ''
        $("#select-user").val("");
    }

    function setCompany() {
        company = ''
        $("#select-company").val("");
    }

    function setProject(){
        project = ''
        
        $("#select-project").val("");
        $("#select-project-grv").empty()
        $("#select-project-rv").empty()
        projects = getNewProject();
        
        
        for(var i = 0;i < projects.length;i++){
            if(company == ''){
                if (projects[i]['company_name'] == "rv") {
                    $("#select-project-rv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                } else if (projects[i]['company_name'] == "grv_2") {
                    $("#select-project-grv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                }
            }
            else if(company == 'rv'){
                if(projects[i]['company_name'] == "rv"){
                    $("#select-project-rv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                }
            }
            else if(company == 'grv_2'){
                if (projects[i]['company_name'] == "grv_2") {
                    $("#select-project-grv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                }
            }
                
        }
    }

    function setYear(){
        year =""
        years=[]
        $("#select-year").val("");
        $("#select-year").empty();
        $("#select-year").append("<option value=''></option>");
        for (var i = 0; i < businesses.length; i++) {
            console.log(businesses[i])
            if (years.indexOf(businesses[i]['created_at'].substr(0, 4)) == -1) {
                years.push(businesses[i]['created_at'].substr(0, 4))
                $("#select-year").append("<option value='" + businesses[i]['created_at'].substr(0, 4) + "'>" + businesses[i]['created_at'].substr(0, 4) + "</option>");
            }
        }
    }

    function setMonth(){
        month = ''
        $("#select-month").empty();
        $("#select-month").append("<option value=''></option>");
        for (var i = 0; i < 12; i++) {
            if (i < 9) {
                $("#select-month").append("<option value='0" + (i + 1) + "'>" + "0" + (i + 1) + "</option>");
            } else {
                $("#sselect-month").append("<option value='" + (i + 1) + "'>" + (i + 1) + "</option>");

            }
        }
    }

    //list
    function listBusiness(){
        $("#search-businessTrip").empty();
        var parent = document.getElementById('search-businessTrip');
        var table = document.createElement("tbody");
        table.innerHTML = '<tr class="text-white">' +
                '<th>報告單單號</th>' +
                '<th>請款對應</th>' +
                '<th>事由</th>' +
                '<th>出差費用總計</th>' +
                '<th>報告單日期</th>' +
                '</tr>'
        var tr, span, name, a

        for (var i = 0; i < businesses.length; i++) {
            if (i >= (nowPage - 1) * 13 && i < nowPage * 13) {
                    table.innerHTML = table.innerHTML + setData(i)
            } else if (i >= nowPage * 13) {
                break
            }
        }

        parent.appendChild(table);
    }

    function setData(i){
        a = "/businessTrip/" + businesses[i]['businessTrip_id'] + "/show"
        if(businesses[i]['invoice_type'] =='invoice'){
            tr = "<tr>" +
                "<td width='10%'><a href='" + a + "' target='_blank'>" + businesses[i].final_id + "</td>" +
                "<td width='10%'><a href='" + a + "' target='_blank'>" + businesses[i].invoice['finished_id'] + "</td>" +
                "<td width='25%'><a href='" + a + "' target='_blank'>" + businesses[i].title + "</td>" +
                "<td width='10%'><a href='" + a + "' target='_blank'>" + commafy(businesses[i].cost_total) + "</td>" +
                "<td width='15%'><a href='" + a + "' target='_blank'>" + businesses[i].created_at.substr(0, 10) + "</td>" +
                "</tr>"
                
        }else if(businesses[i]['invoice_type'] =='otherinvoice'){

            tr = "<tr>" +
                "<td width='10%'><a href='" + a + "' target='_blank'>" + businesses[i].final_id + "</td>" +
                "<td width='10%'><a href='" + a + "' target='_blank'>" + businesses[i].otherinvoice['finished_id'] + "</td>" +
                "<td width='25%'><a href='" + a + "' target='_blank'>" + businesses[i].title + "</td>" +
                "<td width='10%'><a href='" + a + "' target='_blank'>" + commafy(businesses[i].cost_total) + "</td>" +
                "<td width='15%'><a href='" + a + "' target='_blank'>" + businesses[i].created_at.substr(0, 10) + "</td>" +
                "</tr>"
        }
        


        return tr
    }

    function commafy(num) {
        num = num + "";
        var re = /(-?\d+)(\d{3})/
        while (re.test(num)) {
            num = num.replace(re, "$1,$2")
        }
        return num;
    }


    //list系列
    function listPage() {
        $("#business-list-page").empty();
        var parent = document.getElementById('business-list-page');
        var table = document.createElement("div");
        var number = Math.ceil(businesses.length / 10)
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

    function changePage(index) {

        var temp = document.getElementsByClassName('page-item')

        $(".page-" + String(nowPage)).removeClass('active')
        nowPage = index
        $(".page-" + String(nowPage)).addClass('active')

        listPage()
        listInvoice()

    }

    function nextPage() {
        var number = Math.ceil(businesses.length / 10)

        if (nowPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage++
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listInvoice()
        }

    }

    function previousPage() {
        var number = Math.ceil(businesses.length / 10)

        if (nowPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage--
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listInvoice()
        }

    }

</script>