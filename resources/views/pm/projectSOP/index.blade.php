@extends('layouts.app')
@section('content')

<div class="col-lg-12 ">
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                    <label class="btn btn-secondary active w-50" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px">
                        <input type="radio" name="options" onchange="changeSOP(0)" autocomplete="off" checked> 專案
                    </label>
                    <label class="btn btn-secondary w-50" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">
                        <input type="radio" name="options" onchange="changeSOP(1)" autocomplete="off"> 其他
                    </label>
                </div>
            </div>
            <div class="card border-0 shadow rounded-pill">
                <div class="card-body show-project-SOP">
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">內容查詢</label>
                        <div class="col-lg-12">
                            <input type="text" name="searchContent" id="searchContent" class="form-control  rounded-pill" placeholder="請輸入所要查詢內容" autocomplete="off" onkeyup="searchContent()">
                        </div>
                    </div>                
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">公司</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-company" name="select-company" onchange="select('company',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=""></option>
                                <option value="grv_2">綠雷德</option>
                                <option value="rv">閱野</option>
                                <option value="grv">綠雷德(舊)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">專案</label>
                        <div class="col-lg-12 mb-2">
                            <select type="text" id="select-project-year" name="select-project-year" onchange="selectProjectYears(this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=''></option>
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <select type="text" id="select-project" name="select-project" onchange="select('project',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=''></option>
                                <optgroup id="select-project-grv_2" label="綠雷德">
                                <optgroup id="select-project-grv" label="綠雷德(舊)">
                                <optgroup id="select-project-rv" label="閱野">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">建立年份</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-year" name="select-year" onchange="select('year',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=''></option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <button class="w-100 btn btn-green rounded-pill" onclick="reset()"><span>重置</span> </button>
                    </div>
                </div>

                <div class="card-body show-other-SOP">
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">內容查詢</label>
                        <div class="col-lg-12">
                            <input type="text" name="searchotherContent" id="searchotherContent" class="form-control  rounded-pill" placeholder="請輸入所要查詢內容" autocomplete="off" onkeyup="searchOtherContent()">
                        </div>
                    </div>
                    <div class="form-group" >
                        <label class="col-lg-12 col-form-label">公司</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-other-company" name="select-other-company" onchange="OtherSelect('company',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=""></option>
                                <option value="grv_2">綠雷德</option>
                                <option value="rv">閱野</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">類別</label>
                
                        <div class="col-lg-12">
                            <select type="text" id="select-other-type" name="select-other-type" onchange="OtherSelect('type',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=''></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">建立年份</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-other-year" name="select-other-year" onchange="OtherSelect('year',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=''></option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <button class="w-100 btn btn-green rounded-pill" onclick="otherReset()"><span>重置</span> </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card border-0 shadow" style="min-height: calc(100vh - 135px)">
                <div class="card-body show-project-SOP">
                    <div class="form-group col-lg-12 d-flex justify-content-between">
                        <div id="SOP-page" class="d-flex align-items-end">
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
                        <div style="text-align: right">
                            <button class="btn btn-green rounded-pill" onclick="location.href='{{route('projectSOP.create')}}'"><span class="mx-2">{{__('customize.Add')}}</span> </button>
                        </div>
                        

                    </div>
                    <div class="col-lg-12 table-style-invoice ">
                        <table id="search-SOP" style="table-layout: fixed">
                            
                        </table>
                    </div>

                </div>
                <div class="card-body show-other-SOP">
                    <div class="form-group col-lg-12 d-flex justify-content-between">
                        <div id="SOP-other-page" class="d-flex align-items-end">
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
                        <div style="text-align: right">
                            <button class="btn btn-green rounded-pill" onclick="location.href='{{route('projectSOP.create')}}'"><span class="mx-2">{{__('customize.Add')}}</span> </button>
                        </div>
                    </div>

                    <div class="col-lg-12 table-style-invoice ">
                        <table id="search-other-SOP">

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

<script> //function
    function changeSOP(val){
        if(val ==0){
            document.getElementsByClassName('show-project-SOP')[0].style.display = "inline";
            document.getElementsByClassName('show-project-SOP')[1].style.display = "inline";
            document.getElementsByClassName('show-other-SOP')[0].style.display = "none";
            document.getElementsByClassName('show-other-SOP')[1].style.display = "none";
        }
        else if(val ==1){
            document.getElementsByClassName('show-project-SOP')[0].style.display = "none";
            document.getElementsByClassName('show-project-SOP')[1].style.display = "none";
            document.getElementsByClassName('show-other-SOP')[0].style.display = "inline";
            document.getElementsByClassName('show-other-SOP')[1].style.display = "inline";
        }
    }
</script>

<script>  //資料設定
    var user_id = '{{\Auth::user()->user_id}}'
    //專案資料設定
    var user =""
    var company =""
    var project =""
    var content =""
    var projectYear =""
    var year =""
    var month =""
    var temp =""
    var nowPage = 1
    var projectSOPs = []
    var projects = []

    $(document).ready(function() {
        reset()
        resetOther()
        document.getElementsByClassName('show-other-SOP')[0].style.display = "none";
        document.getElementsByClassName('show-other-SOP')[1].style.display = "none";
        
    });

    
</script>
<script>  //專案function
    function getNewSOP(){
        
        data = "{{$projectSOPs}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }
    function getNewProject() {
        data = "{{$project}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }
    function changePage(index) {

        var temp = document.getElementsByClassName('page-item')

        $(".page-" + String(nowPage)).removeClass('active')
        nowPage = index
        $(".page-" + String(nowPage)).addClass('active')

        listPage()
        listProjectSOP()

    }

    function nextPage() {
        var number = Math.ceil(projectSOPs.length / 10)

        if (nowPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage++
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listProjectSOP()
        }

    }

    function previousPage() {
        var number = Math.ceil(projectSOPs.length / 10)

        if (nowPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage--
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listProjectSOP()
        }

    }
    function selectProjectYears(val) {
        projectYear = val
        project = ''
        $("#select-project-grv_2").empty();
        $("#select-project-grv").empty();
        $("#select-project-rv").empty();

        if (projectYear == '') {
            reset()
        } else {
            setProjectSOP()
            projects = getNewProject()
            for (var i = 0; i < projects.length; i++) {
                if (projects[i]['name'] != "其他" && projects[i]['open_date'].substr(0, 4) == projectYear) {
                    if (projects[i]['company_name'] == "grv") {
                        $("#select-project-grv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                    } else if (projects[i]['company_name'] == "rv") {
                        $("#select-project-rv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                    } else if (projects[i]['company_name'] == "grv_2") {
                        $("#select-project-grv_2").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                    }
                }
            }
            setYear()
        }
        setSearch()
        listProjectSOP() //列出符合條件的請款項目
    }

    function listPage() {
        $("#SOP-page").empty();
        var parent = document.getElementById('SOP-page');
        var table = document.createElement("div");
        var number = Math.ceil(projectSOPs.length / 10)
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

    function select(type, val){
        switch(type){
            case 'user':
                user = val
                if(val ==''){
                    reset()
                }
                else{
                    projectYear = ''
                    company = ''
                    project = ''
                    year = ''
                    month = ''
                    nowPage = 1
                    setProjectSOP()
                    setCompany()
                    setProject()
                    setYear()
                    setMonth()
                }
                break;
            case 'company':
                company = val
                if(val ==''){
                    reset()
                }else{
                    projectYear = ''
                    project = ''
                    year = ''
                    month = ''
                    nowPage = 1
                    setProjectSOP()
                    setProject()
                    setYear()
                    setMonth()
                }
                break;
            case 'project':
            project = val
                if(val ==''){
                    reset()
                }else{
                    year = ''
                    month = ''
                    nowPage = 1
                    setProjectSOP()
                    setYear()
                    setMonth()
                }
                break;
            case 'year':
            year = val
                if(val ==''){
                    reset()
                }else{
                    month = ''
                    nowPage = 1
                    setProjectSOP()
                    setMonth()
                }
                break;
            case 'month':
            month = val
                if(val ==''){
                    reset()
                }else{
                    nowPage = 1
                    setProjectSOP()
                }
                break;
            default:
                break;
        }
        if(val != ""){
            listProjectSOP() //列出符合條件的請款項目
            listPage()
        }
    }

    function setProjectSOP(){
        projectSOPs = getNewSOP();
        for(var i = 0 ; i< projectSOPs.length ; i++){
            if(user != ''){
                if(projectSOPs[i]['user_id'] != user){
                    projectSOPs.splice(i,1)
                    i--
                    continue;
                }
            }
            if(company !=''){
                if(projectSOPs[i].project['company_name'] !=company){
                    projectSOPs.splice(i,1)
                    i--
                    continue;
                }
            }
            if(project !=''){
                if(projectSOPs[i]['project_id'] != project){
                    projectSOPs.splice(i,1)
                    i--
                    continue;
                } else {
                    $('#select-project-year').val(projectSOPs[i].project['open_date'].substr(0, 4))
                }
            }
            if(year !=''){
                if(projectSOPs[i]['created_at'].substr(0, 4) != year){
                    projectSOPs.splice(i,1)
                    i--
                    continue;
                }
            }
            if(month !=''){
                if(projectSOPs[i]['created_at'].substr(5, 2) != month){
                    projectSOPs.splice(i,1)
                    i--
                    continue;
                }
            }
            if (temp != '') {
                if (projectSOPs[i]['content'] == null || projectSOPs[i]['content'].indexOf(temp) == -1) {
                    projectSOPs.splice(i, 1)
                    i--
                    continue
                }
            }
        }
    }
    function setUser() {
        user = ''
        $("#select-user").val("");
    }

    function setCompany() {
        company = ''
        $("#select-company").val("");
    }

    function setProject() {
        projects = getNewProject()
        project = ''
        $("#select-project-grv_2").empty();
        $("#select-project-grv").empty();
        $("#select-project-rv").empty();

        var projectYears = [] //初始化

        for (var i = 0; i < projects.length; i++) {
            if (projectYears.indexOf(projects[i]['open_date'].substr(0, 4)) == -1) {
                projectYears.push(projects[i]['open_date'].substr(0, 4))
            }
            if (projects[i]['name'] != "綠雷德-其他") {
                if (projects[i]['company_name'] == "grv") {
                    $("#select-project-grv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                } else if (projects[i]['company_name'] == "rv") {
                    $("#select-project-rv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                } else if (projects[i]['company_name'] == "grv_2") {
                    $("#select-project-grv_2").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                }
            }
        }

        $("#select-project-year").val("");
        $("#select-project-year").empty();
        $("#select-project-year").append("<option value=''></option>");
        projectYears.sort()
        projectYears.reverse()
        for (var i = 0; i < projectYears.length; i++) {
            $("#select-project-year").append("<option value='" + projectYears[i] + "'>" + projectYears[i] + "</option>");
        }
    }

    function setYear() {
        year = ''
        var years = [] //初始化
        $("#select-year").val("");
        $("#select-year").empty();
        $("#select-year").append("<option value=''></option>");

        for (var i = 0; i < projectSOPs.length; i++) {
            if (years.indexOf(projectSOPs[i]['created_at'].substr(0, 4)) == -1) {
                years.push(projectSOPs[i]['created_at'].substr(0, 4))
                $("#select-year").append("<option value='" + projectSOPs[i]['created_at'].substr(0, 4) + "'>" + projectSOPs[i]['created_at'].substr(0, 4) + "</option>");
            }
        }
    }

    function setMonth() {
        month = ""
        $("#select-month").empty();
        $("#select-month").append("<option value=''></option>");
        for (var i = 0; i < 12; i++) {
            if (i < 9) {
                $("#select-month").append("<option value='0" + (i + 1) + "'>" + "0" + (i + 1) + "</option>");
            } else {
                $("#select-month").append("<option value='" + (i + 1) + "'>" + (i + 1) + "</option>");

            }
        }
    }
    function setSearch() {
        temp = ''
        document.getElementById('searchContent').value = temp
    }

    function searchContent(){
        
        temp = document.getElementById('searchContent').value
        nowPage = 1
        setProjectSOP()
        listProjectSOP()
        listPage()
    }



    function listProjectSOP() {
        $("#search-SOP").empty();
        var parent = document.getElementById('search-SOP');
        var table = document.createElement("tbody");
        
        table.innerHTML = '<tr class="text-white">' +
            '<th style="width:10%">隸屬公司</th>' +
            '<th style="width:20%">專案名稱</th>' +
            '<th style="width:40%">內容</th>' +
            '<th style="width:10%">建立時間</th>' +
            '<th style="width:10%">更新時間</th>' +
            '<th style="width:10%">查看</th>' +
            '</tr>'
        var tr, span, name, a


        for (var i = 0; i < projectSOPs.length; i++) {
            if (i >= (nowPage - 1) * 10 && i < nowPage * 10) {
                table.innerHTML = table.innerHTML + setData(i)
            } else if (i >= nowPage * 10) {
                break
            }
        }
        parent.appendChild(table);
    }

    function setData(i) {
        if(projectSOPs[i].project['company_name'] == 'grv_2'){
            CompanyName = '綠雷德創新'
        }else if(projectSOPs[i].project['company_name'] == 'rv'){
            CompanyName = '閱野文創'
        }
        
        a = "/projectSOP/" + projectSOPs[i]['projectSOP_id'] + "/show"
        tr = "<tr>" +
            "<td >" + CompanyName + "</td>" +
            "<td >" + projectSOPs[i].project['name'] + "</td>" +
            "<td  class='text-truncate'>" + projectSOPs[i].content + "</td>" +
            "<td >" + projectSOPs[i].created_at.substr(0, 10) + "</td>" +
            "<td >" + projectSOPs[i].updated_at.substr(0, 10) + "</td>" +
            "<td ><a href='" + a + "' target='_blank'><i class='fas fa-search'></i></a></td>" +
            "</tr>"


        return tr
    }

    function reset() {
        projectSOPs = getNewSOP();
        setUser()
        setCompany()
        projectYear =''
        setProject()
        setYear()
        setMonth()
        setSearch()
        nowPage = 1
        listPage()
        listProjectSOP();
    }
</script>
<script>
    //其他資料設定
    var otherUser =""
    var otherCompany =""
    var otherType =""
    var otherContent =""
    var otherYear =""
    var otherMonth =""
    var otherTemp =""
    var nowOtherPage =1
    var otherProjectSOPs =[]
    var otherTypes = []
</script>

<script>//其他function
    function OtherSelect(type,val){
        switch(type){
            case 'user':
                otherUser = val
                if(val ==''){
                    resetOther()
                }
                else{
                    otherCompany = ''
                    otherType =''
                    otherYear = ''
                    otherMonth = ''
                    nowOtherPage = 1
                    setOtherSOP()
                    setOtherCompany()
                    setOtherType()
                    setOtherYear()
                    setOtherMonth()
                }
                break;
            case 'company':
                otherCompany = val
                if(val ==''){
                    resetOther()
                }else{
                    otherType = ''
                    otherYear = ''
                    otherMonth =''
                    nowOtherPage = 1
                    setOtherSOP()
                    setOtherType()
                    setOtherYear()
                    setOtherMonth()
                }
                break;
            case 'type':
            otherType = val
                if(val ==''){
                    resetOther()
                }else{
                    otherYear = ''
                    otherMonth = ''
                    nowOtherPage = 1
                    setOtherSOP()
                    setOtherYear()
                    setOtherMonth()
                }
                break;
            case 'year':
            otherYear = val
                if(val ==''){
                    resetOther()
                }else{
                    otherMonth = ''
                    nowOtherPage = 1
                    setOtherSOP()
                    setOtherMonth()
                }
                break;
            case 'month':
            otherMonth = val
                if(val ==''){
                    resetOther()
                }else{
                    nowOtherPage = 1
                    setOtherSOP()
                }
                break;
            default:
                break;
        }
        if(val != ""){
            listOtherProjectSOP() //列出符合條件的請款項目
            listOtherPage()
        }
    }

    function setOtherSOP(){
        otherProjectSOPs = getOtherNewSOP();
        for(var i = 0 ; i< otherProjectSOPs.length ; i++){
            if(otherUser != ''){
                if(otherProjectSOPs[i]['user_id'] != otherUser){
                    otherProjectSOPs.splice(i,1)
                    i--
                    continue;
                }
            }
            if(otherCompany !=''){
                if(otherProjectSOPs[i].company_name !=otherCompany){
                    otherProjectSOPs.splice(i,1)
                    i--
                    continue;
                }
            }
            if(otherType !=''){
                if(otherProjectSOPs[i]['type'] != otherType){
                    otherProjectSOPs.splice(i,1)
                    i--
                    continue;
                } 
            }
            if(otherYear !=''){
                if(otherProjectSOPs[i]['created_at'].substr(0, 4) != otherYear){
                    otherProjectSOPs.splice(i,1)
                    i--
                    continue;
                }
            }
            if(otherMonth !=''){
                if(otherProjectSOPs[i]['created_at'].substr(5, 2) != otherMonth){
                    otherProjectSOPs.splice(i,1)
                    i--
                    continue;
                }
            }
            if (otherTemp != '') {
                if (otherProjectSOPs[i]['content'] == null || otherProjectSOPs[i]['content'].indexOf(otherTemp) == -1) {
                    otherProjectSOPs.splice(i, 1)
                    i--
                    continue
                }
            }
        }
    }

    function getOtherNewSOP(){
        
        data = "{{$otherProjectSOPs}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }
    function setOtherUser() {
        otherUser = ''
        $("#select-other-user").val("");
    }
    function setOtherCompany() {
        otherCompany = ''
        $("#select-other-company").val("");
    }
    function setOtherType() {
        otherType = ''
        $("#select-other-type").val("");
        $('#select-other-type').empty();
        $('#select-other-type').append("<option value=''></option>");
        for(var i = 0 ; i < otherProjectSOPs.length; i++){
            if(otherTypes.indexOf(otherProjectSOPs[i].type) == -1 && otherProjectSOPs[i].SOPtype == 'other'){
                otherTypes.push(otherProjectSOPs[i].type)
            }
        }
        for(var i = 0 ; i < otherTypes.length ; i++){
            $("#select-other-type").append("<option value='"+ otherTypes[i] + "'>" + otherTypes[i] + "</option>");
        }
    }

    function setOtherYear() {
        otherYear = ''
        var otherYears = [] //初始化
        $("#select-other-year").val("");
        $("#select-other-year").empty();
        $("#select-other-year").append("<option value=''></option>");

        for (var i = 0; i < otherProjectSOPs.length; i++) {
            if (otherYears.indexOf(otherProjectSOPs[i]['created_at'].substr(0, 4)) == -1) {
                otherYears.push(otherProjectSOPs[i]['created_at'].substr(0, 4))
                $("#select-other-year").append("<option value='" + otherProjectSOPs[i]['created_at'].substr(0, 4) + "'>" + otherProjectSOPs[i]['created_at'].substr(0, 4) + "</option>");
            }
        }
    }
    function setOtherMonth() {
        month = ""
        $("#select-other-month").empty();
        $("#select-other-month").append("<option value=''></option>");
        for (var i = 0; i < 12; i++) {
            if (i < 9) {
                $("#select-other-month").append("<option value='0" + (i + 1) + "'>" + "0" + (i + 1) + "</option>");
            } else {
                $("#select-other-month").append("<option value='" + (i + 1) + "'>" + (i + 1) + "</option>");

            }
        }
    }
    function setOtherSearch() {
        otherTemp = ''
        document.getElementById('searchotherContent').value = otherTemp
    }
    function searchOtherContent(){
        
        otherTemp = document.getElementById('searchotherContent').value
        nowOtherPage = 1
        setOtherSOP()
        listOtherProjectSOP()
        listOtherPage()
    }

    function listOtherProjectSOP(){
        $("#search-other-SOP").empty();
        var parent = document.getElementById('search-other-SOP');
        var table = document.createElement("tbody");
        
        table.innerHTML = '<tr class="text-white">' +
            '<th style="width:10%">隸屬公司</th>' +
            '<th style="width:20%">類別名稱</th>' +
            '<th style="width:40%">內容</th>' +
            '<th style="width:10%">建立時間</th>' +
            '<th style="width:10%">更新時間</th>' +
            '<th style="width:10%">查看</th>' +
            '</tr>'
        var tr, span, name, a 

        for (var i = 0; i < otherProjectSOPs.length; i++) {
            if (i >= (nowPage - 1) * 10 && i < nowPage * 10) {
                
                table.innerHTML = table.innerHTML + setOtherData(i)
                
            } else if (i >= nowPage * 10) {
                break
            }
        }
        parent.appendChild(table);
    }

    function setOtherData(i){
        if(otherProjectSOPs[i].company_name == 'grv_2'){
            otherCompanyName = '綠雷德創新'
        }else if(otherProjectSOPs[i].company_name == 'rv'){
            otherCompanyName = '閱野文創'
        }
        a = "/projectSOP/" + otherProjectSOPs[i]['projectSOP_id'] + "/show"
        tr = "<tr>" +
            "<td >" + otherCompanyName + "</td>" +
            "<td >" + otherProjectSOPs[i].type + "</td>" +
            "<td  class='text-truncate'>" + otherProjectSOPs[i].content + "</td>" +
            "<td >" + otherProjectSOPs[i].created_at.substr(0, 10) + "</td>" +
            "<td >" + otherProjectSOPs[i].updated_at.substr(0, 10) + "</td>" +
            "<td ><a href='" + a + "' target='_blank'><i class='fas fa-search'></i></td>" +
            "</tr>"


        return tr
    }
    function nextOtherPage() {
        var number = Math.ceil(otherProjectSOPs.length / 10)

        if (nowOtherPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowOtherPage)).removeClass('active')
            nowOtherPage++
            $(".page-" + String(nowOtherPage)).addClass('active')
            listOtherPage()
            listOtherProjectSOP()
        }

    }

    function previousOtherPage() {
        var number = Math.ceil(otherProjectSOPs.length / 10)

        if (nowOtherPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowOtherPage)).removeClass('active')
            nowOtherPage--
            $(".page-" + String(nowOtherPage)).addClass('active')
            listOtherPage()
            listOtherProjectSOP()
        }

    }
    
    function listOtherPage(){
        $("#SOP-other-page").empty();
        var parent = document.getElementById('SOP-other-page');
        var table = document.createElement("div");
        var number = Math.ceil(otherProjectSOPs.length / 10)
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

        $(".page-" + String(nowOtherPage)).addClass('active')
    }
    
    function resetOther() {
        otherProjectSOPs = getOtherNewSOP();
        setOtherUser()
        setOtherCompany()
        setOtherType()
        setOtherYear()
        setOtherMonth()
        setOtherSearch()
        nowOtherPage = 1
        listOtherPage()
        listOtherProjectSOP();
    }
</script>
@stop