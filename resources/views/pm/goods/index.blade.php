@extends('layouts.app')
@section('content')

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-3 mb-2">
            <div class="card border-0 shadow rounded-pill">
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">簽收人</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-user" name="select-user" onchange="select('user',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control mb-2">
                                <option value=""></option>
                                @foreach($users as $user)
                                @if( $user->role != 'manager' && $user->user_id !='GRV00000')

                                <option value="{{$user['user_id']}}">{{$user['name']}}({{$user['nickname']}})</option>
                               @endif
                                @endforeach
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
                                <optgroup id="select-project-grv" label="綠雷德">
                                <optgroup id="select-project-rv" label="閱野">
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
                            <div class="col-lg-2">
                                <input type="text" name="search-num" id="search-num" class="form-control  rounded-pill" placeholder="貨運單號" autocomplete="off" onkeyup="searchNum()">
                            </div>
                            <div class=" col-lg-4">
                                <input type="text" name="search" id="search" class="form-control rounded-pill " placeholder="項目" autocomplete="off" onkeyup="search()">

                            </div>
                            <div class="col-lg-6 d-flex justify-content-end">
                                <button class="btn btn-green rounded-pill" onclick="location.href='{{route('goods.create')}}'"><span class="mx-2">{{__('customize.Add')}}</span> </button>

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
                        <table id="show-good">

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
    var project = ""
    var projectYear = ""
    var year = ""
    var month = ""
    var temp = ""
    var numTemp = ""
    var nowPage = 1
    //帳務
    var projects = []
    $(document).ready(function() {
        reset()
    });

    function selectProjectYears(val) {
        projectYear = val
        project = ''
        $("#select-project-grv").empty();
        $("#select-project-rv").empty();

        if (projectYear == '') {
            reset()
        } else {
            setGood()
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
        listGood() //列出符合條件的請款項目
    }

    function select(type, id) {
        switch (type) {
            case 'user':
                user = id
                if (id == '') {
                    reset()
                } else {
                    projectYear = ''
                    project = ''
                    year = ''
                    month = ''
                    setGood()
                    setProject() //設置此人所屬專案
                    setYear()
                    setMonth()
                }
                break;
            case 'project':
                project = id //傳入選取值
                if (id == '') {
                    reset()
                } else {
                    year = ''
                    month = ''
                    setGood()
                    setYear()
                    setMonth()
                }
                break;
            case 'year':
                year = id //傳入選取值
                if (id == '') {
                    reset()
                } else {
                    month = ''
                    setGood()
                    setMonth()
                }
                break;
            case 'month':
                month = id //傳入選取值
                if (id == '') {
                    reset()
                } else {
                    setGood()
                }
                break;
            default:

        }
        setSearchNum()
        setSearch()
        listGood() //列出符合條件的請款項目
        listPage()
    }

    function search() {
        temp = document.getElementById('search').value
        nowPage = 1
        setGood()
        listGood()
        listPage()
    }

    function searchNum() {
        numTemp = document.getElementById('search-num').value
        nowPage = 1
        setGood()
        listGood()
        listPage()
    }

    function setGood() {
        goods = getNewGood()
        for (var i = 0; i < goods.length; i++) {
            if (user != '') {
                if (goods[i]['user_id'] != user) {
                    goods.splice(i, 1)
                    i--
                    continue
                }
            }
            if (project != '') {
                if (goods[i].purchases['project_id'] != project) {
                    goods.splice(i, 1)
                    i--
                    continue
                } else {
                    $('#select-project-year').val(goods[i].purchases.project['open_date'].substr(0, 4))
                }
            }
            if (year != '') {
                if (goods[i]['created_at'].substr(0, 4) != year) {
                    goods.splice(i, 1)
                    i--
                    continue
                }
            }
            if (month != '') {
                if (goods[i]['created_at'].substr(5, 2) != month) {
                    goods.splice(i, 1)
                    i--
                    continue
                }
            }
            if (temp != '') {
                if (goods[i]['good_name'] == null || goods[i]['good_name'].indexOf(temp) == -1) {
                    goods.splice(i, 1)
                    i--
                    continue
                }
            }
            if (numTemp != '') {
                if (goods[i]['delivery_number'] == null || goods[i]['delivery_number'].indexOf(numTemp) == -1) {
                    goods.splice(i, 1)
                    i--
                    continue
                }
            }
        }
    }


    function getNewGood() {
        data = "{{$goods}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    function getNewProject() {
        var temp = []
        var projectTemp = []
        for (var i = 0; i < goods.length; i++) {
            if(goods[i].purchases!=null){
                if (temp.indexOf(goods[i].purchases.project['name']) == -1) {
                    temp.push(goods[i].purchases.project['name'])
                    projectTemp.push(goods[i].purchases.project)
                }
            }
            
        }
        return projectTemp
    }

    function listGood() {
        $("#show-good").empty();
        var parent = document.getElementById('show-good');
        var table = document.createElement("tbody");
        table.innerHTML = '<tr class="text-white">' +
            '<th>貨運單號</th>' +
            // '<th>採購單號</th>' +
            '<th>簽收人</th>' +
            '<th>簽收日期</th>' +
            '<th>項目</th>' +
            '<th>數量</th>' +
            '<th>專案</th>' +
            '</tr>'
        var tr, span, name, a


        for (var i = 0; i < goods.length; i++) {
            if (i >= (nowPage - 1) * 13 && i < nowPage * 13) {
                table.innerHTML = table.innerHTML + setData(i)
            } else if (i >= nowPage * 13) {
                break
            }
        }

        parent.appendChild(table);
    }

    function setData(i) {
        var quantity = ""
        if(goods[i].quantity != null){
            quantity = goods[i].quantity
        }
        if(goods[i].purchases!=null){
            var projectName = goods[i].purchases.project['name'];
        }
        else{
            var projectName = '-未填寫-'
        }
        a = "/goods/" + goods[i]['goods_id']
        tr = "<tr>" +
            "<td><a href='" + a + "'  target='_blank'>" + goods[i].delivery_number + "</td>" +
            // "<td><a href='" + a + "'  target='_blank'>" + goods[i].purchase_id + "</td>" +
            "<td><a href='" + a + "'  target='_blank'>" + goods[i].user['name'] + "(" + goods[i].user['nickname'] + ")" + "</td>" +
            "<td><a href='" + a + "' target='_blank'>" + goods[i].receipt_date + "</td>" +
            "<td><a href='" + a + "' target='_blank'>" + goods[i].good_name + "</a></td>" +
            "<td><a href='" + a + "' target='_blank'>" + quantity + "</td>" +
            "<td><a href='" + a + "' target='_blank'>" + projectName + "</td>" +
            "</tr>"


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

    function reset() {
        goods = getNewGood()
        nowPage = 1
        setUser()
        projectYear = ''
        setProject()
        setYear()
        setMonth()
        setSearch()
        setSearchNum()
        listGood()
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

        for (var i = 0; i < goods.length; i++) {
            if (years.indexOf(goods[i]['receipt_date'].substr(0, 4)) == -1) {
                years.push(goods[i]['receipt_date'].substr(0, 4))
                $("#select-year").append("<option value='" + goods[i]['receipt_date'].substr(0, 4) + "'>" + goods[i]['receipt_date'].substr(0, 4) + "</option>");
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

    function setSearchNum() {
        numTemp = ''
        document.getElementById('search-num').value = numTemp
    }

    function nextPage() {
        var number = Math.ceil(goods.length / 13)

        if (nowPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage++
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listGood()
        }

    }

    function changePage(index) {

        var temp = document.getElementsByClassName('page-item')

        $(".page-" + String(nowPage)).removeClass('active')
        nowPage = index
        $(".page-" + String(nowPage)).addClass('active')

        listPage()
        listGood()

    }

    function previousPage() {
        var number = Math.ceil(goods.length / 13)

        if (nowPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage--
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listGood()
        }

    }

    function listPage() {
        $("#page-navigation").empty();
        var parent = document.getElementById('page-navigation');
        var div = document.createElement("div");
        var number = Math.ceil(goods.length / 13)
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
@stop