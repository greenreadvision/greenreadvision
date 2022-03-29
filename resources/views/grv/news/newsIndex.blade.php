@extends('layouts.page')

@section('content')

<div id="home-total" class="grvPage-top" >
    <div id="grvPage-top-img">
        {{--  <img src="{{ URL::asset('img/綠雷德LOGO.png') }}" alt="綠雷德文創">  --}}
    </div>
</div>
<div class="col-lg-12">
    <div class="row" >
        <div class="col-lg-3 Side">
            <div class="title">
                <h3>消息分類</h3>
                <button type="button" onclick="select('type', 'news')"><span>最新消息</span></button>
                <button type="button" onclick="select('type', 'service')"><span>服務項目</span></button>
                <button type="button" onclick="select('type', 'question')"><span>常見問題</span></button>
            </div>
            <div class="title">
                <h3>社群連結</h3>
            </div>
        </div>
        <div class="col-lg-9" id="new_title">
            <div class="col-lg-9 mb-2">
                <div class="card border-0 shadow" style="min-height: calc(100vh - 135px)">
                    <div class="card-body">
                        <div class="form-group col-lg-12 d-flex justify-content-between">
                            <div id="board-page" class="d-flex align-items-end">
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
</div>

@stop


@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.14.0/dist/xlsx.full.min.js"></script>
<script>
    var user = ""
    var year = ""
    var month= ""
    var newTypes= ""
    var nowPage = 1

    var years = []
    var months = []
    var boards =[]

    $(document).ready(function() {
        reset();
    });

    function listBoard(){
        $('#search-board').empty();
        var parent = document.getElementById('search-board')
        var table = document.createElement("tbody");

        table.innerHTML = '<tr class="text-white">' +
            "<th width='70%' style='color:#fff'>文章主旨</th>" +
            "<th width='15%' style='color:#fff'>公告類型</th>" +
            "<th width='15%' style='color:#fff'>上架日期</th>" +
            "<tr>"
        var tr, span, a, tp

        for(var i=0;i< boards.length;i++){
            if(i >=(nowPage - 1)*10 && i <nowPage*10){
                table.innerHTML = table.innerHTML + setBoardData(i)
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
        listBoard()
    }

    function nextPage() {
        var number = Math.ceil(boards.length / 10)

        if (nowPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage++
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listBoard()
        }

    }

    function previousPage() {
        var number = Math.ceil(boards.length / 10)

        if (nowPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage--
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listBoard()
        }
    }

    function listPage(){
        $("#board-page").empty()
        var parent = document.getElementById('board-page');
        var table = document.createElement("div");
        var number = Math.ceil(boards.length / 10)
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


    function setBoardData(i){
        if(boards[i]['newTypes'] == 'service'){
            tp = '服務項目'
        }
        else if(boards[i]['newTypes'] == 'news'){
            tp = '最新項目'
        }
        else if(boards[i]['newTypes'] == 'question'){
            tp = '常見問題'
        }
        
        a = "/news/" + boards[i]['board_id'] + "/show" 
        tr = "<tr>" + 
            "<td width='60%'><a href='" + a + "' target='_blank'>" + boards[i]['title']+ "</td>" +
            "<td width='10%'><a href='" + a + "' target='_blank'>" + tp + "</td>" +
            "<td width='10%'><a href='" + a + "' target='_blank'>" + boards[i]['updata_date'] + "</td>" +
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
                    year = ""
                    month = ""
                    type = ""
                    nowPage = 1
                    setBoard()
                    setYear()
                    setMonth()
                }
                break;
            case 'type':
                newTypes = id;
                if(id == '')
                {
                    reset()
                }
                else
                {
                    year = ''
                    month = ''
                    nowPage= 1
                    setBoard()
                    setYear()
                    setMonth()
                }
                break;
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
                    setBoard()
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
                    setBoard()
                }
                break;
            default:
        }
        if(id != ''){
            listBoard()
        }
    }

    function reset(){
        setBoard();
        setUser();
        setYear();
        setMonth();
        listBoard();
        listPage();
    }

    function getNewBoard(){
        data = "{{$board}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    function setUser(){
        user = ''
        $("#select-board-user").val("")
        
    }

    function setYear(){
        year = ''
        years = []
        $('#select-board-year').val('')
        $('#select-board-year').empty()
        $('#select-board-year').append("<option value=''></option>")

        for (var i = 0; i < boards.length; i++) {
            if (years.indexOf(boards[i]['updata_date'].substr(0, 4)) == -1) {
                years.push(boards[i]['updata_date'].substr(0, 4))
                
                $("#select-board-year").append("<option value='" + boards[i]['updata_date'].substr(0, 4) + "'>" + boards[i]['updata_date'].substr(0, 4) + "</option>");
            }
        }

    }

    function setMonth(){
        month = ''
        months = []
        $('#select-board-month').val('')
        $('#select-board-month').empty()
        $('#select-board-month').append("<option value=''></option>")

        for (var i = 0; i < boards.length; i++) {
            if (months.indexOf(boards[i]['updata_date'].substr(5, 2)) == -1) {
                months.push(boards[i]['updata_date'].substr(5, 2))
                
                $("#select-board-month").append("<option value='" + boards[i]['updata_date'].substr(5, 2) + "'>" + boards[i]['updata_date'].substr(5, 2) + "</option>");
            }
        }
    }


    function setBoard(){
        boards = getNewBoard()
        for(var i = 0 ;i < boards.length ; i++){
            
            if(user != ''){
                if(boards[i]['user_id'] != user){
                    boards.splice(i,1)
                    i--
                    continue
                }
            }
            if(newTypes != ''){
                if(boards[i]['newTypes'] != newTypes){
                    boards.splice(i,1)
                    i--
                    continue
                }
            }
            if(year != ''){
                if(boards[i]['updata_date'].substr(0, 4) != year){
                    boards.splice(i,1)
                    i--
                    continue
                }
            }
            if(month != ''){
                if(boards[i]['updata_date'].substr(5, 2) != month){
                    boards.splice(i,1)
                    i--
                    continue
                }
            }
        }
    }

</script>
