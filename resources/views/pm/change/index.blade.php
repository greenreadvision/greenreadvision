@extends('layouts.app')
@section('content')
<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <a  href="/change" class="page_title_a" >系統更動申請表單</a>
        </div>
    </div>
</div>
<div class="col-lg-12 " >
    <div class="row">
        <div id="loading">
            <img src="{{ URL::asset('gif/loadding.gif') }}" alt=""/>
        </div>
        <div class="col-lg-2">
            <div class="card border-0 shadow rounded-pill">
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">類型</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-change_type" name="select-change_type" onchange="select('change_type',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=''></option>
                                <option>專案</option>
                                <option>其他</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">申請階段</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-review" name="select-review" onchange="select('review',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=''></option>
                                <option value='first'>第一階段</option>
                                <option value='first-fix'>第二階段被撤回</option>
                                <option value='second'>第二階段</option>
                                <option value='second-fix'>第二階段被撤回</option>
                                <option value='third'>第三階段</option>
                                <option value='third-fix'>第三階段被撤回</option>
                                <option value='matched'>處理中</option>
                                <option value='complete'>更動處理完成</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">申請人</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-user" name="select-user" onchange="select('user',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=""></option>
                                @foreach($users as $user)
                                <option value="{{$user['user_id']}}">{{$user['name']}}({{$user['nickname']}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
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
        <div class="col-lg-10">
            <div class="card border-0 shadow" style="min-height: calc(100vh - 135px)">
                <div class="card-body">
                    @if(\Auth::user()->role == 'administrator' || \Auth::user()->role == 'supervisor' || \Auth::user()->role == 'proprietor' || \Auth::user()->role == 'manager')
                    <div class="form-group col-lg-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" onchange="reviewCheck('{{\Auth::user()->user_id}}')">
                            <label class="form-check-label" for="defaultCheck1">
                                審核主管
                            </label>
                        </div>
                    </div>
                    @endif
                    <div class="form-group col-lg-12">
                        <div class="row">
                            <div class="col-lg-2">
                                <input type="text" name="search-num" id="search-num" class="form-control  rounded-pill" placeholder="申請單號" autocomplete="off" onkeyup="searchNum()">
                            </div>
                            <div class=" col-lg-4">
                                <input type="text" name="search" id="search" class="form-control  rounded-pill" placeholder="申請事項" autocomplete="off" onkeyup="searchChange()">
                            </div>
                            <div class="col-lg-6 d-flex justify-content-end">
                                <button class="btn btn-green rounded-pill" onclick="location.href='{{route('change.create')}}'"><span class="mx-2">{{__('customize.Add')}}</span> </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 d-flex justify-content-between">
                        <div id="changes-page" class="d-flex align-items-end">
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
                        <table id="search-change">
                            
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


<script  type="text/javascript" charset="UTF-8">
    var url = window.location.href
    url = new URL(url)
    function ShowDiv() {
            $("#loading").show();
        }
    function HiddenDiv() {
            $("#loading").hide();
        }
    
</script>


<script type="text/javascript">
    function reviewCheck() {
        setChange()
        listChange() //列出符合條件的請款項目
        listPage()
    }

    var user_id = '{{\Auth::user()->user_id}}'
    var user_name = '{{\Auth::user()->name}}'
    var user = ""
    var change_type = ""
    var year = ""
    var month = ""
    var temp = ""
    var numTemp = ""
    var nowPage = 1
    var review = ""

    //帳務
    var changes = []
    $(document).ready(function() {
        reset()
        
    });

    function select(type, id) {
        switch (type) {
            case 'change_type':
                change_type = id
                if (id == '') {
                    reset()
                } else {
                    year = ''
                    month = ''
                    nowPage = 1
                    setChange()
                    setYear()
                    setMonth()
                }
                break;
            case 'user':
                user = id
                if (id == '') {
                    reset()
                } else {
                    year = ''
                    month = ''
                    nowPage = 1
                    setChange()
                    setYear()
                    setMonth()
                }
                break;
            case 'year':
                year = id //傳入選取值
                if (id == '') {
                    reset()
                } else {
                    nowPage = 1
                    month = ''
                    setChange()
                    setMonth()
                }
                break;
            case 'month':
                month = id //傳入選取值
                if (id == '') {
                    reset()
                } else {
                    nowPage = 1
                    setChange()
                }
                break;
            default:
            case 'review':
                review = id
                if (id == '') {
                    reset()
                } else {
                    nowPage = 1
                    setChange()
                }
        }
        if (id != '') {
            setSearchNum()
            setSearch()
            listChange() //列出符合條件的請款項目
            listPage()
        }
    }

    function searchChange() {
        temp = document.getElementById('search').value
        nowPage = 1
        setChange()
        listChange()
        listPage()
    }

    function searchNum() {
        numTemp = document.getElementById('search-num').value
        nowPage = 1
        setChange()
        listChange()
        listPage()
    }

    function setChange() {
        changes = getNewChange()
        for (var i = 0; i < changes.length; i++) {
            if (change_type != '') {
                if (changes[i]['change_type'] != change_type) {
                    changes.splice(i, 1)
                    i--
                    continue
                }
            }

            if (user != '') {
                if (changes[i]['user_id'] != user) {
                    changes.splice(i, 1)
                    i--
                    continue
                }
            }

            if (year != '') {
                if (changes[i]['created_at'].substr(0, 4) != year) {
                    changes.splice(i, 1)
                    i--
                    continue
                }
            }

            if (month != '') {
                if (changes[i]['created_at'].substr(5, 2) != month) {
                    changes.splice(i, 1)
                    i--
                    continue
                }
            }

            if (temp != '') {
                if (changes[i]['title'] == null || changes[i]['title'].indexOf(temp) == -1) {
                    changes.splice(i, 1)
                    i--
                    continue
                }
            }

            if (numTemp != '') {
                if (changes[i]['finished_id'] == null || changes[i]['finished_id'].indexOf(numTemp) == -1) {
                    changes.splice(i, 1)
                    i--
                    continue
                }
            }
            if (review != '') {
                if (review != 'fix') {
                    if (changes[i]['status'] != review) {
                        changes.splice(i, 1)
                        i--
                        continue
                    }
                } else {
                    if (changes[i]['status'] != 'check-fix' && changes[i]['status'] != 'waiting-fix') {
                        changes.splice(i, 1)
                        i--
                        continue
                    }
                }
            }
            if ($('#defaultCheck1')[0] != null) {
                if ($('#defaultCheck1')[0].checked == true) {
                    if (changes[i]['managed'] != user_id) {
                        changes.splice(i, 1)
                        i--
                        continue
                    }
                }
            }
        }
    }

    function getNewChange() {
        data = "{{$changes}}"
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
        listChange()

    }

    function nextPage() {
        var number = Math.ceil(changes.length / 10)

        if (nowPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage++
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listChange()
        }

    }

    function previousPage() {
        var number = Math.ceil(changes.length / 10)

        if (nowPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage--
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listChange()
        }

    }

    function listPage() {
        $("#changes-page").empty();
        var parent = document.getElementById('changes-page');
        var table = document.createElement("div");
        var number = Math.ceil(changes.length / 10)
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

    function listChange() {
        $("#search-change").empty();
        var parent = document.getElementById('search-change');
        var table = document.createElement("tbody");

        table.innerHTML = '<tr class="text-white">' +
            '<th>申請單號</th>' +
            '<th>類別</th>' +
            '<th>申請人</th>' +
            '<th>申請項目</th>' +
            '<th>最晚完成期限</th>' +
            '<th>申請日期</th>' +
            '<th>狀態</th>' +
            '</tr>'
        var tr, span, name, a


        for (var i = 0; i < changes.length; i++) {
            if (i >= (nowPage - 1) * 10 && i < nowPage * 10) {
                table.innerHTML = table.innerHTML + setData(i)
            } else if (i >= nowPage * 10) {
                break
            }
        }
        parent.appendChild(table);
    }

    function setData(i) {
        if (changes[i].status == 'first') {
            span = "<div class='progress' data-toggle='tooltip' data-placement='top' title='第一階段審核中'>" +
                "<div class='progress-bar bg-danger' role='progressbar' style='width: 0%' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'>" +
                "</div>" +
                "</div>";

        } else if (changes[i].status == 'first-fix') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='第一階段審核被撤回，請修改'>" +
                "<div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"

        } else if (changes[i].status == 'second') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='第二階段審核中'>" +
                "<div class='progress-bar bg-danger' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"

        } else if (changes[i].status == 'second-fix') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='第二階段審核被撤回，請修改'>" +
                "<div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"

        } else if (changes[i].status == 'third') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='第三階段審核中'>" +
                "<div class='progress-bar bg-danger' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"

        } else if (changes[i].status == 'third-fix') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='第三階段審核被撤回，請修改'>" +
                "<div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 75%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"
            

        } else if (changes[i].status == 'matched') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='更動處理中'>" +
                "<div class='progress-bar bg-success' role='progressbar' style='width: 75%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"

        } else if (changes[i].status == 'complete') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='更動處理完成'>" +
                "<div class='progress-bar bg-info' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"
                
        } else if(changes[i].status == 'delete') {
            span = " <div title='已註銷'>" +
                "<img src='{{ URL::asset('gif/cancelled.png') }}' alt='' style='width:100%'/>" +
                "</div>"
        }

        var UserName = changes[i].user['name'] 

        if((changes[i].user['role']=='intern'||changes[i].user['role'] == 'manager')&&changes[i].intern_name != null){
            UserName = changes[i].intern_name
        }
        a = "/change/" + changes[i]['id'] + "/review"
        tr = "<tr>" +
            "<td width='15%'><a href='" + a + "' target='_blank'>" + changes[i].finished_id + "</td>" +
            "<td width='10%'><a href='" + a + "' target='_blank'>" + changes[i].change_type + "</td>" +
            "<td width='15%'><a href='" + a + "' target='_blank'>" + UserName + "</td>" +
            "<td width='20%'><a href='" + a + "' target='_blank'>" + changes[i].title + "</a></td>" +
            "<td width='20%'><a href='" + a + "' target='_blank'>" + changes[i].urgency + "</td>" +
            "<td width='15%'> <a href='" + a + "' target='_blank'>" + changes[i].created_at.substr(0, 10) + "</td>" +
            "<td width='5%'>" + span + "</td>" +
            "</tr>"
        return tr
    }

    function reset() {
        if ($('#defaultCheck1')[0] != null) {
            $('#defaultCheck1')[0].checked = false
        }
        
        changes = getNewChange()
        setChange_type()
        setUser()
        setYear()
        setMonth()
        setSearch()
        setSearchNum()
        nowPage = 1
        $("#changes-page").empty();
        $("#select-review").val("");

        listChange()
        listPage()
    }

    function setChange_type() {
        change_type = ''
        $("#select-change_type").val("");
    }

    function setUser() {
        user = ''
        $("#select-user").val("");
    }

    function setYear() {
        year = ''
        var years = [] //初始化
        $("#select-year").val("");
        $("#select-year").empty();
        $("#select-year").append("<option value=''></option>");

        for (var i = 0; i < changes.length; i++) {
            if (years.indexOf(changes[i]['created_at'].substr(0, 4)) == -1) {
                years.push(changes[i]['created_at'].substr(0, 4))
                $("#select-year").append("<option value='" + changes[i]['created_at'].substr(0, 4) + "'>" + changes[i]['created_at'].substr(0, 4) + "</option>");
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
        document.getElementById('search').value = temp
    }

    function setSearchNum() {
        numTemp = ''
        document.getElementById('search-num').value = numTemp
    }
</script>

@stop