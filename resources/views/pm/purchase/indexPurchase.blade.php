@extends('layouts.app')
@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-2  col-12">
            <div class="card border-0 shadow rounded-pill">
                <div class="card-body">
                    <div class="col-12 form-group">
                        <label class="col-lg-12 col-12  col-form-label" style="padding: calc(.375rem + 1px) 0;">採購人</label>
                        <div class="row">
                            <div class="col-lg-12 col-6">
                                <select type="text" id="select-purchase-user" name="select-purchase-user" onchange="select('user',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control mb-2">
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
                            <div class="col-lg-12 col-6 mb-2">
                                <select type="text" id="select-purchase-project-year" name="select-purchase-project-year" onchange="selectProjectYears(this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                    <option value=''></option>
                                </select>
                            </div>
                            <div class="col-lg-12 col-6">
                                <select type="text" id="select-purchase-project" name="select-purchase-project" onchange="select('project',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                    <option value=''></option>
                                    <optgroup id="select-purchase-project-grv_2" label="綠雷德創新">
                                    <optgroup id="select-purchase-project-grv" label="綠雷德(舊)">
                                    <optgroup id="select-purchase-project-rv" label="閱野">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-6 form-group ">
                            <label class="col-lg-12 col-12 col-form-label">年份</label>
                            <div class="col-lg-12 col-12">
                                <select type="text" id="select-purchase-year" name="select-purchase-year" onchange="select('year',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                    <option value=''></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-6 form-group">
                            <label class="col-lg-12 col-12 col-form-label">月份</label>
                            <div class="col-lg-12 col-12">
                                <select type="text" id="select-purchase-month" name="select-purchase-month" onchange="select('month',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
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
        <div class="col-lg-10 col-12">
            <div class="card border-0 shadow" style="min-height: calc(100vh - 135px)">
                <div class="card-body">
                    <div class="form-group col-lg-12">
                        <div class="row">
                            <div class="col-lg-2 col-6">
                                <input type="text" name="search-num" id="search-num" class="form-control  rounded-pill" placeholder="採購單號" autocomplete="off" onkeyup="searchNum()">
                            </div>
                            <div class=" col-lg-4 col-6">
                                <input type="text" name="search-purchase" id="search-purchase" class="form-control rounded-pill " placeholder="搜尋" autocomplete="off" onkeyup="searchPurchase()">
                            </div>
                            <div class="col-lg-6 col-12 d-flex justify-content-end">
                                <button class="btn btn-green rounded-pill" onclick="location.href='{{route('purchase.create')}}'"><span class="mx-2">{{__('customize.Add')}}</span> </button>

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
                        <table id="show-purchase">
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
    var user = ""
    var project = ""
    var projectYear = ""
    var year = ""
    var month = ""
    var temp = ""
    var numTemp = ""
    var nowPage = 1
    //帳務
    var purchases = []
    var projects = []
    $(document).ready(function() {
        reset()
    });

    function selectProjectYears(val) {
        projectYear = val
        project = ''
        $("#select-purchase-project-grv").empty();
        $("#select-purchase-project-rv").empty();
        $("#select-purchase-project-grv_2").empty();

        if (projectYear == '') {
            reset()
        } else {
            setPurchase()
            projects = getNewProject()
            for (var i = 0; i < projects.length; i++) {
                if (projects[i]['open_date'].substr(0, 4) == projectYear) {
                    if (projects[i]['company_name'] == "grv") {
                        $("#select-purchase-project-grv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                    } else if (projects[i]['company_name'] == "rv") {
                        $("#select-purchase-project-rv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                    }
                    else if (projects[i]['company_name'] == "grv_2") {
                        $("#select-purchase-project-grv_2").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                    }
                }
            }
            setYear()
        }
        setSearch()
        listPurchase() //列出符合條件的請款項目
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
                    setPurchase()
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
                    setPurchase()
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
                    setPurchase()
                    setMonth()
                }
                break;
            case 'month':
                month = id //傳入選取值
                if (id == '') {
                    reset()
                } else {
                    setPurchase()
                }
                break;
            default:

        }
        setSearchNum()
        setSearch()
        listPurchase() //列出符合條件的請款項目
        listPage()
    }

    function searchPurchase() {
        temp = document.getElementById('search-purchase').value
        nowPage = 1
        setPurchase()
        listPurchase()
        listPage()
    }

    function searchNum() {
        numTemp = document.getElementById('search-num').value
        nowPage = 1
        setPurchase()
        listPurchase()
        listPage()
    }

    function setPurchase() {
        purchases = getNewPurchase()
        for (var i = 0; i < purchases.length; i++) {
            if (user != '') {
                if (purchases[i]['user_id'] != user) {
                    purchases.splice(i, 1)
                    i--
                    continue
                }
            }
            if (project != '') {
                if (purchases[i]['project_id'] != project) {
                    purchases.splice(i, 1)
                    i--
                    continue
                } else {
                    $('#select-purchase-project-year').val(purchases[i].project['open_date'].substr(0, 4))
                }
            }
            if (year != '') {
                if (purchases[i]['created_at'].substr(0, 4) != year) {
                    purchases.splice(i, 1)
                    i--
                    continue
                }
            }
            if (month != '') {
                if (purchases[i]['created_at'].substr(5, 2) != month) {
                    purchases.splice(i, 1)
                    i--
                    continue
                }
            }
            if (temp != '') {
                if (purchases[i]['title'] == null || purchases[i]['title'].indexOf(temp) == -1) {
                    purchases.splice(i, 1)
                    i--
                    continue
                }
            }
            if (numTemp != '') {
                if (purchases[i]['id'] == null || purchases[i]['id'].indexOf(numTemp) == -1) {
                    purchases.splice(i, 1)
                    i--
                    continue
                }
            }
        }
    }


    function getNewPurchase() {
        data = "{{$purchases}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    function getNewProject() {
        var temp = []
        var projectTemp = []
        for (var i = 0; i < purchases.length; i++) {
            if (temp.indexOf(purchases[i].project['name']) == -1) {
                temp.push(purchases[i].project['name'])
                projectTemp.push(purchases[i].project)
            }
        }
        return projectTemp
    }

    function listPurchase() {
        var screen_width = window.screen.width;
        $("#show-purchase").empty();
        var parent = document.getElementById('show-purchase');
        var table = document.createElement("tbody");
        if(screen_width < 768){
            table.innerHTML = '<tr class="text-white">' +
                    '<th>採購人</th>' +
                    '<th>專案</th>' +
                    '<th>採購項目</th>' +
                '</tr>'
        }else{
            table.innerHTML = '<tr class="text-white">' +
                '<th>採購單號</th>' +
                '<th>採購人</th>' +
                '<th>專案</th>' +
                '<th>採購項目</th>' +
                '<th>採購費用</th>' +
                '<th>採購日期</th>' +
                '</tr>'
        }
        
        var tr, span, name, a


        for (var i = 0; i < purchases.length; i++) {
            if (i >= (nowPage - 1) * 13 && i < nowPage * 13) {
                if(screen_width < 768){
                table.innerHTML = table.innerHTML + setMobileData(i)
                }else{
                    table.innerHTML = table.innerHTML + setData(i)
                }
            } else if (i >= nowPage * 13) {
                break
            }
        }

        parent.appendChild(table);
    }

    function setMobileData(i){
        a = "/purchase/" + purchases[i]['purchase_id'] + "/review"
        tr = "<tr>" +
            "<td width='33%'><a href='" + a + "'  target='_blank'>" + purchases[i].user['name'] + "(" + purchases[i].user['nickname'] + ")" + "</td>" +
            "<td width='33%'><a href='" + a + "' target='_blank'>" + purchases[i].project['name'] + "</td>" +
            "<td width='34%'><a href='" + a + "' target='_blank'>" + purchases[i].title + "</a></td>" +
            "</tr>"


        return tr
    }

    function setData(i) {

        a = "/purchase/" + purchases[i]['purchase_id'] + "/review"
        tr = "<tr>" +
            "<td width='10%'><a href='" + a + "'  target='_blank'>" + purchases[i].id + "</td>" +
            "<td width='15%'><a href='" + a + "'  target='_blank'>" + purchases[i].user['name'] + "(" + purchases[i].user['nickname'] + ")" + "</td>" +
            "<td width='30%'><a href='" + a + "' target='_blank'>" + purchases[i].project['name'] + "</td>" +
            "<td width='25%'><a href='" + a + "' target='_blank'>" + purchases[i].title + "</a></td>" +
            "<td width='10%'><a href='" + a + "' target='_blank'>" + commafy(purchases[i].total_amount) + "</td>" +
            "<td width='10%'><a href='" + a + "' target='_blank'>" + purchases[i].purchase_date.substr(0, 10) + "</td>" +
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
        purchases = getNewPurchase()
        nowPage = 1
        setUser()
        projectYear = ''
        setProject()
        setYear()
        setMonth()
        setSearch()
        setSearchNum()
        listPurchase()
        listPage()
    }

    function setUser() {
        user = ''
        $("#select-purchase-user").val("");
    }

    function setProject() {
        projects = getNewProject()
        project = ''
        $("#select-purchase-project-grv").empty();
        $("#select-purchase-project-rv").empty();

        var projectYears = [] //初始化

        for (var i = 0; i < projects.length; i++) {
            if (projectYears.indexOf(projects[i]['open_date'].substr(0, 4)) == -1) {
                projectYears.push(projects[i]['open_date'].substr(0, 4))
            }
            if (projects[i]['company_name'] == "grv") {
                $("#select-purchase-project-grv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
            } else if (projects[i]['company_name'] == "rv") {
                $("#select-purchase-project-rv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
            } else if (projects[i]['company_name'] == "grv_2") {
                $("#select-purchase-project-grv_2").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
            }
            
        }

        $("#select-purchase-project-year").val("");
        $("#select-purchase-project-year").empty();
        $("#select-purchase-project-year").append("<option value=''></option>");
        projectYears.sort()
        projectYears.reverse()
        for (var i = 0; i < projectYears.length; i++) {
            $("#select-purchase-project-year").append("<option value='" + projectYears[i] + "'>" + projectYears[i] + "</option>");
        }
    }

    function setYear() {
        year = ''
        var years = [] //初始化
        $("#select-purchase-year").val("");
        $("#select-purchase-year").empty();
        $("#select-purchase-year").append("<option value=''></option>");

        for (var i = 0; i < purchases.length; i++) {
            if (years.indexOf(purchases[i]['purchase_date'].substr(0, 4)) == -1) {
                years.push(purchases[i]['purchase_date'].substr(0, 4))
                $("#select-purchase-year").append("<option value='" + purchases[i]['purchase_date'].substr(0, 4) + "'>" + purchases[i]['purchase_date'].substr(0, 4) + "</option>");
            }
        }
    }

    function setMonth() {
        month = ''
        $("#select-purchase-month").empty();
        $("#select-purchase-month").append("<option value=''></option>");
        for (var i = 0; i < 12; i++) {
            if (i < 9) {
                $("#select-purchase-month").append("<option value='0" + (i + 1) + "'>" + "0" + (i + 1) + "</option>");
            } else {
                $("#select-purchase-month").append("<option value='" + (i + 1) + "'>" + (i + 1) + "</option>");

            }
        }
    }

    function setSearch() {
        temp = ''
        document.getElementById('search-purchase').value = temp
    }
    function setSearchNum() {
        numTemp = ''
        document.getElementById('search-num').value = numTemp
    }

    function nextPage() {
        var number = Math.ceil(purchases.length / 13)

        if (nowPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage++
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listPurchase()
        }

    }

    function changePage(index) {

        var temp = document.getElementsByClassName('page-item')

        $(".page-" + String(nowPage)).removeClass('active')
        nowPage = index
        $(".page-" + String(nowPage)).addClass('active')

        listPage()
        listPurchase()

    }

    function previousPage() {
        var number = Math.ceil(purchases.length / 13)

        if (nowPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage--
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listPurchase()
        }

    }

    function listPage() {
        $("#page-navigation").empty();
        var parent = document.getElementById('page-navigation');
        var div = document.createElement("div");
        var number = Math.ceil(purchases.length / 13)
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