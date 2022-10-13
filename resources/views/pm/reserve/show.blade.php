@extends('layouts.app')
@section('content')
<div class="container-fluid p-0">    
    <div class="page_level">
        <div class="page_show">
            <div class="page_title" id="page_title">
                <span class="page_title_span">硬體管理</span>
                <i class="fas fa-chevron-right page_title_arrow"></i>
                <a  href="/reserve/index" class="page_title_a" >倉儲查詢</a>
                <i class="fas fa-chevron-right page_title_arrow"></i>
                <span class="page_title_span">{{__('customize.'.$location)}}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-3 mb-2">
                <div class="card border-0 shadow rounded-pill">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="col-lg-12 col-form-label">登記者</label>
                            <div class="col-lg-12">
                                <select type="text" id="select-user" name="select-user" onchange="select('user',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control mb-2">
                                    <option value=""></option>
                                        <optgroup label="正職">
                                        @foreach($users as $user)
                                        @if( $user->role != 'manager' && $user->user_id !='GRV00000' && $user->user_id !='GRV00018')
                                            <option value="{{$user['name']}}">{{$user['name']}}({{$user['nickname']}})</option>
                                        @endif
                                        @endforeach
                                        </optgroup>
                                        <optgroup label="實習生">
                                        @foreach($interns as $intern)
                                            <option value="{{$intern['nickname']}}">{{$intern['name']}}({{$intern['nickname']}})</option>
                                        @endforeach
                                        </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="col-lg-12 col-form-label">年份</label>
                            <div class="col-lg-12">
                                <select type="text" id="select-year" name="select-year" onchange="select('year',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                    <option value=''></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-12 col-form-label">月份</label>
                            <div class="col-lg-12">
                                <select type="text" id="select-month" name="select-month" onchange="select('month',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                    <option value=''></option>
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
                                <div class=" col-lg-4">
                                    <input type="text" name="search" id="search" class="form-control rounded-pill " placeholder="項目" autocomplete="off" onkeyup="search()">
                                </div>
                                <div class="col-lg-8 d-flex justify-content-end">
                                    <button class="btn btn-green rounded-pill" onclick="location.href='{{route('reserve.create')}}'"><span class="mx-2">{{__('customize.Add')}}</span></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-12 d-flex justify-content-between">
    
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
                        <div class="col-lg-12 table-style-invoice">
                            <table id="show-reserve">
    
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
    <script>
        var user = ""
        //var project = ""
        //var projectYear = ""
        var year = ""
        var month = ""
        var temp = ""
        var nowPage = 1
        //帳務
        var projects = []
        $(document).ready(function() {
            reset()
        });
    
        /*function selectProjectYears(val) {
            projectYear = val
            project = ''
            $("#select-project-grv").empty();
            $("#select-project-rv").empty();
    
            if (projectYear == '') {
                reset()
            } else {
                setreserve()
                projects = getNewProject()
                for (var i = 0; i < projects.length; i++) {
                    if (projects[i]['open_date'].substr(0, 4) == projectYear) {
                        if (projects[i]['company_name'] == "grv") {
                            $("#select-project-grv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                        } else if (projects[i]['company_name'] == "rv") {
                            $("#select-project-rv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                        }
                    }
                }
                setYear()
            }
            setSearch()
            listreserve() //列出符合條件的請款項目
        }*/
    
        function select(type, id) {
            switch (type) {
                case 'user':
                    user = id
                    if (id == '') {
                        reset()
                    } else {
                        //projectYear = ''
                        //project = ''
                        year = ''
                        month = ''
                        setreserve()
                        //setProject() //設置此人所屬專案
                        setYear()
                        setMonth()
                    }
                    break;
                /*case 'project':
                    project = id //傳入選取值
                    if (id == '') {
                        reset()
                    } else {
                        year = ''
                        month = ''
                        setreserve()
                        setYear()
                        setMonth()
                    }
                    break;*/
                case 'year':
                    year = id //傳入選取值
                    if (id == '') {
                        reset()
                    } else {
                        month = ''
                        setreserve()
                        setMonth()
                    }
                    break;
                case 'month':
                    month = id //傳入選取值
                    if (id == '') {
                        reset()
                    } else {
                        setreserve()
                    }
                    break;
                default:
    
            }
            setSearch()
            listreserve() //列出符合條件的請款項目
            listPage()
        }
    
        function search() {
            temp = document.getElementById('search').value
            nowPage = 1
            setreserve()
            listreserve()
            listPage()
        }
    
        function setreserve() {
            reserves = getNewreserve()
            for (var i = 0; i < reserves.length; i++) {
                if (user != '') {
                    if (reserves[i]['signer'] != user) {
                        reserves.splice(i, 1)
                        i--
                        continue
                    }
                }
                /*if (project != '') {
                    if (reserves[i].purchases['project_id'] != project) {
                        reserves.splice(i, 1)
                        i--
                        continue
                    } else {
                        $('#select-project-year').val(reserves[i].purchases.project['open_date'].substr(0, 4))
                    }
                }*/
                if (year != '') {
                    if (reserves[i]['created_at'].substr(0, 4) != year) {
                        reserves.splice(i, 1)
                        i--
                        continue
                    }
                }
                if (month != '') {
                    if (reserves[i]['created_at'].substr(5, 2) != month) {
                        reserves.splice(i, 1)
                        i--
                        continue
                    }
                }
                if (temp != '') {
                    if (reserves[i]['name'] == null || reserves[i]['name'].indexOf(temp) == -1) {
                        reserves.splice(i, 1)
                        i--
                        continue
                    }
                }
            }
        }
    
    
        function getNewreserve() {
            data = "{{$reserves}}"
            data = data.replace(/[\n\r]/g, "")
            data = JSON.parse(data.replace(/&quot;/g, '"'));
            for (var i = 0; i < data.length; i++) {
                if (data[i]['location'] != '{{$location}}') {
                    data.splice(i, 1)
                    i--
                }
            } 
            return data
        }
    
        function getNewProject() {
            var temp = []
            var projectTemp = []
            for (var i = 0; i < reserves.length; i++) {
                if(reserves[i].purchases!=null){
                    if (temp.indexOf(reserves[i].purchases.project['name']) == -1) {
                        temp.push(reserves[i].purchases.project['name'])
                        projectTemp.push(reserves[i].purchases.project)
                    }
                }
                
            }
            return projectTemp
        }
    
        function listreserve() {
            $("#show-reserve").empty();
            var parent = document.getElementById('show-reserve');
            var table = document.createElement("tbody");
            table.innerHTML = '<tr class="text-white">' +
                // '<th>採購單號</th>' +
                '<th></th>' +
                '<th style="width:6rem;">登記者</th>' +
                '<th style="width:5rem;">分類</th>' +
                '<th>品名</th>' +
                '<th style="width:5rem;">數量</th>' +
                '<th style="width:5rem;">專案</th>' +
                '<th>登記日期</th>' +
                '<th>測試按鈕</th>' +
                '</tr>'
            var tr, span, name, a
    
    
            for (var i = 0; i < reserves.length; i++) {
                if (i >= (nowPage - 1) * 13 && i < nowPage * 13) {
                    table.innerHTML = table.innerHTML + setData(i)
                } else if (i >= nowPage * 13) {
                    break
                }
            }
    
            parent.appendChild(table);
        }
    
        function setData(i) {
            if(reserves[i].purchases!=null){
                var projectName = reserves[i].purchases.project['name'];
            }
            else{
                var projectName = '-未填寫-'
            }

            form = 
                "<div>"+
                "<form action='" + reserves[i]['reserve_id'] + "/update' method='post' enctype='multipart/form-data' id='form" + reserves[i]['reserve_id'] + "'>" +
                "<input type='hidden' name='_method' value='PUT' form='form"+ reserves[i]['reserve_id'] +"' />" +
                "<input type='hidden' name='_token' value='{{ csrf_token() }}' form='form"+ reserves[i]['reserve_id'] +"' />" +
                "</form>" +
                "</div>"+
                "<div>" +
                "<tr>" + 
                "<td><button type='button' class='btn btn-green rounded-pill' onclick='edit(this,"+ '"' + reserves[i]['reserve_id'] + '"' + ")' form='form" + reserves[i]['reserve_id'] + "'>修改</button>"+
                "<button type='submit' id='"+ reserves[i]['reserve_id'] +"' form='form"+ reserves[i]['reserve_id'] +"' class='btn btn-green rounded-pill' hidden>確定</button></td>"+
                "<td><input readonly='readonly' required id='signer' autocomplete='off' type='text' name='signer' form='form" + reserves[i]['reserve_id'] + "' class='" + reserves[i]['reserve_id'] + " rounded-pill form-control{{ $errors->has('signer') ? ' is-invalid' : '' }}' style='text-align:center; width:6rem;' value='" + reserves[i].signer + "'></td>" +
                // "<td><a href='" + a + "'  target='_blank'>" + reserves[i].purchase_id + "</td>" +
                "<td><input readonly='readonly' required id='category' autocomplete='off' type='text' name='category' form='form" + reserves[i]['reserve_id'] + "' class='" + reserves[i]['reserve_id'] + " rounded-pill form-control{{ $errors->has('category') ? ' is-invalid' : '' }}' style='text-align:center; width:5rem;' value='" + reserves[i].category + "'></td>" +
                "<td><input readonly='readonly' required id='name' autocomplete='off' type='text' name='name' form='form" + reserves[i]['reserve_id'] + "' class='" + reserves[i]['reserve_id'] + " rounded-pill form-control{{ $errors->has('name') ? ' is-invalid' : '' }}' style='text-align:center; justify-content: center;' value='" + reserves[i].name + "'></td>" +
                "<td><input readonly='readonly' required id='stock' autocomplete='off' type='text' name='stock' form='form" + reserves[i]['reserve_id'] + "' class='" + reserves[i]['reserve_id'] + " rounded-pill form-control{{ $errors->has('stock') ? ' is-invalid' : '' }}' style='text-align:center ; width:5rem;' value='" + reserves[i].stock + "'></td>" +
                "<td><input readonly='readonly' required id='project_id' autocomplete='off' type='text' name='project_id' form='form" + reserves[i]['reserve_id'] + "' class='" + reserves[i]['reserve_id'] + " rounded-pill form-control{{ $errors->has('project_id') ? ' is-invalid' : '' }}' style='text-align:center; width:5rem;' value='" + projectName + "'></td>" +
                "<td>" + reserves[i].created_at.substr(0, 11) + "</td>" +
                "<td>"+
                "<div class='modal fade' id='deleteModal' tabindex='-1' role='dialog' aria-labelledby='deleteModalLabel' aria-hidden='true'>"+
                    "<div class='modal-dialog ' role='document'>"+
                        "<div class='modal-content'>"+
                            "<div class='modal-header border-0'>"+
                                "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>"+
                                    "<span aria-hidden='true'>&times;</span>"+
                                "</button>"+
                            "</div>"+
                            "<div class='modal-body text-center '>"+
                                "是否刪除?"+
                            "</div>"+
                            "<div class='modal-footer justify-content-center border-0'>"+
                                "<button type='button' class='btn btn-red rounded-pill' data-dismiss='modal'>否</button>"+
                                "<form action='" + reserves[i]['reserve_id'] + "/delete' method='POST'>"+
                                    '@method("DELETE")'+
                                    '@csrf'+
                                    "<button type='submit' class='btn btn-blue rounded-pill'>是</button>"+
                                "</form>"+
                            "</div>"+
                        "</div>"+
                    "</div>"+
                "</div>"+
                "<button type='button' class='btn btn-red rounded-pill' data-toggle='modal' data-target='#deleteModal'>"+
                    "<span>{{__('customize.Delete')}}</span>"+
                "</button>"+
                "</td>"+
                "</tr>" +
                "</div>";
    
    
            return form
        }
    
        function commafy(num) {
            num = num + "";
            var re = /(-?\d+)(\d{3})/
            while (re.test(num)) {
                num = num.replace(re, "$1,$2")
            }
            return num;
        }
    
        function reset() {
            reserves = getNewreserve()
            nowPage = 1
            setUser()
            projectYear = ''
            //setProject()
            setYear()
            setMonth()
            setSearch()
            listreserve()
            listPage()
        }
    
        function setUser() {
            user = ''
            $("#select-user").val("");
        }
    
        function setProject() {
            projects = getNewProject()
            project = ''
            $("#select-project-grv").empty();
            $("#select-project-rv").empty();
    
            var projectYears = [] //初始化
    
            for (var i = 0; i < projects.length; i++) {
                if (projectYears.indexOf(projects[i]['open_date'].substr(0, 4)) == -1) {
                    projectYears.push(projects[i]['open_date'].substr(0, 4))
                }
                if (projects[i]['company_name'] == "grv") {
                    $("#select-project-grv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                } else if (projects[i]['company_name'] == "rv") {
                    $("#select-project-rv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
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
    
            for (var i = 0; i < reserves.length; i++) {
                if (years.indexOf(reserves[i]['created_at'].substr(0, 4)) == -1) {
                    years.push(reserves[i]['created_at'].substr(0, 4))
                    $("#select-year").append("<option value='" + reserves[i]['created_at'].substr(0, 4) + "'>" + reserves[i]['created_at'].substr(0, 4) + "</option>");
                }
            }
        }
    
        function setMonth() {
            month = ''
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
            document.getElementById('search').value = temp
        }
    
        function nextPage() {
            var number = Math.ceil(reserves.length / 13)
    
            if (nowPage < number) {
                var temp = document.getElementsByClassName('page-item')
                $(".page-" + String(nowPage)).removeClass('active')
                nowPage++
                $(".page-" + String(nowPage)).addClass('active')
                listPage()
                listreserve()
            }
    
        }
    
        function changePage(index) {
    
            var temp = document.getElementsByClassName('page-item')
    
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage = index
            $(".page-" + String(nowPage)).addClass('active')
    
            listPage()
            listreserve()
    
        }
    
        function previousPage() {
            var number = Math.ceil(reserves.length / 13)
    
            if (nowPage > 1) {
                var temp = document.getElementsByClassName('page-item')
                $(".page-" + String(nowPage)).removeClass('active')
                nowPage--
                $(".page-" + String(nowPage)).addClass('active')
                listPage()
                listreserve()
            }
    
        }
    
        function listPage() {
            $("#page-navigation").empty();
            var parent = document.getElementById('page-navigation');
            var div = document.createElement("div");
            var number = Math.ceil(reserves.length / 13)
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

        function edit(btnEdit, className){
            var cN = document.getElementsByClassName(className);
            var btnConfirm = document.getElementById(className);
            for(var i = 0; i < cN.length; i++) {
                cN[i].readOnly = false;
            }
            btnEdit.hidden = true;
            btnConfirm.hidden = false;
            console.log(btnConfirm);

        }
    </script>
    @stop