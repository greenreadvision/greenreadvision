@extends('layouts.app')
@section('content')
<div class="col-lg-12">
    <div class="row ">
        <div class="col-lg-3 mb-2">
            <div class="card border-0 shadow rounded-pill">
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">專案負責人</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-project-user" name="select-project-user" onchange="select('user',this.options[this.options.selectedIndex].value)" class="form-control mb-2 rounded-pill">
                                <option value=""></option>
                                @foreach($users as $user)
                                <option value="{{$user['user_id']}}">{{$user['name']}}({{$user['nickname']}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">投標公司</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-project-company" name="select-project-company" onchange="select('company',this.options[this.options.selectedIndex].value)" class="form-control rounded-pill">
                                <option value=''></option>
                                <option value='grv_2'>綠雷德創新</option>
                                <option value='rv'>閱野</option>
                                <option value='grv'>綠雷德(舊)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">年份</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-project-year" name="select-project-year" onchange="select('year',this.options[this.options.selectedIndex].value)" class="form-control rounded-pill">
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
            <div class="card border-0 shadow " style="min-height: calc(100vh - 135px)">
                <div class="card-body ">
                    <div class="form-group col-lg-12 d-flex justify-content-between">
                        <input type="text" name="search-project" id="search-project" class="form-control rounded-pill col-lg-4" placeholder="搜尋" autocomplete="off" onkeyup="searchProject()">
                        <button class="btn btn-green rounded-pill" onclick="location.href='{{route('project.create')}}'"><span class="mx-2">{{__('customize.Add')}}</span> </button>
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

                        <table id="set-project">
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    // 參數
    var user = ""
    var company = ""
    var year = ""
    var temp = ""
    var nowPage = 1
    var projects = []
    // 
    $(document).ready(function() {
        reset()
    });
    //
    function select(type, id) {
        switch (type) {
            case 'user':
                user = id
                if (id == '') {
                    reset()
                } else {
                    nowPage = 1
                    company = ''
                    year = ''
                    setCompany()
                    setProject()
                    setYear()
                }
                break;
            case 'company':
                company = id //傳入選取值
                if (id == '') {
                    reset()
                } else {
                    nowPage = 1
                    year = ''
                    setProject()
                    setYear()
                }
                break;
            case 'year':
                year = id //傳入選取值
                if (id == '') {
                    reset()
                } else {
                    nowPage = 1
                    setProject()
                }
                break;
            default:
        }

        setSearch()
        listProject()
        listPage()
    }

    function searchProject() {
        temp = document.getElementById('search-project').value
        nowPage = 1
        setProject()
        listProject()
        listPage()
    }

    //條件篩選
    function setProject() {
        projects = getNewProject()
        for (var i = 0; i < projects.length; i++) {
            if (projects[i]['name'] == "其他") {
                projects.splice(i, 1)
                i--
                continue
            }
            if (user != '') {
                if (projects[i]['user_id'] != user) {
                    projects.splice(i, 1)
                    i--
                    continue
                }
            }
            if (company != '') {
                if (projects[i]['company_name'] != company) {
                    projects.splice(i, 1)
                    i--
                    continue
                }
            }
            if (year != '') {
                if (projects[i]['open_date'].substr(0, 4) != year) {
                    projects.splice(i, 1)
                    i--
                    continue
                }
            }
            if (temp != '') {
                if (projects[i]['name'].indexOf(temp) == -1) {
                    projects.splice(i, 1)
                    i--
                    continue
                }
            }
        }
    }
    //重取資料
    function getNewProject() {
        data = "{{$projects}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    function listProject() {
        $("#set-project").empty();
        var parent = document.getElementById('set-project');
        var tbody = document.createElement("tbody");

        tbody.innerHTML = '<tr class="text-white">' +
            '<th>專案負責人</th>' +
            '<th>專案代理人</th>' + 
            '<th>專案名稱</th>' +
            '<th>截標日期</th>' +
            '<th>開標日期</th>' +
            '<th>結案日期</th>' +
            '</tr>'
        var tr, span, name, a


        for (var i = 0; i < projects.length; i++) {
            if (i >= (nowPage - 1) * 13 && i < nowPage * 13) {
                tbody.innerHTML = tbody.innerHTML + setData(i)


            } else if (i >= nowPage * 13) {
                break
            }

        }

        parent.appendChild(tbody);
    }

    function setData(i) {
        if(projects[i]['agent_id']!=null){
            Agent =  projects[i].agent['name'] + "(" + projects[i].agent['nickname'] + ")"
        }else{
            Agent = '-未有代理人-'
        }

        a = "/project/" + projects[i]['project_id']
        tr = "<tr >" +
            "<td><a href='" + a + "' >" + projects[i].user['name'] + "(" + projects[i].user['nickname'] + ")" + "</td>" +
            "<td><a href='" + a + "' >" + Agent + "</td>" +
            "<td><a href='" + a + "' >" + projects[i].name + "</td>" +
            "<td><a href='" + a + "' >" + projects[i].deadline_date + "</a></td>" +
            "<td><a href='" + a + "' >" + projects[i].open_date + "</td>" +
            "<td><a href='" + a + "' >" + projects[i].closing_date + "</td>" +
            "</tr>"
        return tr
    }

    function reset() {
        projects = getNewProject()
        nowPage = 1
        setUser()
        setCompany()
        setYear()
        setSearch()
        setProject()
        listProject()
        listPage()
    }

    function setUser() {
        user = ''
        $("#select-project-user").val("");
    }

    function setCompany() {
        company = ''
        $("#select-project-company").val("");
    }

    function setYear() {
        year = ''
        var years = [] //初始化
        $("#select-project-year").val("");
        $("#select-project-year").empty();
        $("#select-project-year").append("<option value=''></option>");

        for (var i = 0; i < projects.length; i++) {
            if (years.indexOf(projects[i]['open_date'].substr(0, 4)) == -1) {
                years.push(projects[i]['open_date'].substr(0, 4))
                $("#select-project-year").append("<option value='" + projects[i]['open_date'].substr(0, 4) + "'>" + projects[i]['open_date'].substr(0, 4) + "</option>");
            }
        }
    }

    function setSearch() {
        temp = ''
        document.getElementById('search-project').value = temp
    }

    function nextPage() {
        var number = Math.ceil(projects.length / 13)

        if (nowPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage++
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listProject()
        }

    }

    function changePage(index) {

        var temp = document.getElementsByClassName('page-item')

        $(".page-" + String(nowPage)).removeClass('active')
        nowPage = index
        $(".page-" + String(nowPage)).addClass('active')

        listPage()
        listProject()

    }

    function previousPage() {
        var number = Math.ceil(projects.length / 13)

        if (nowPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage--
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listProject()
        }

    }

    function listPage() {
        $("#page-navigation").empty();
        var parent = document.getElementById('page-navigation');
        var div = document.createElement("div");
        var number = Math.ceil(projects.length / 13)
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
</script>
<script src="{{ URL::asset('js/grv.js') }}"></script>
@stop