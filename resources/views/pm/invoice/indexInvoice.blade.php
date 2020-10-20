@extends('layouts.app')
@section('content')

<select type="text" id="selectUser" name="selectUser" onchange="select('user',this.options[this.options.selectedIndex].value)" class="form-control mb-2">
    <option value=""></option>
    @foreach($users as $user)
    <option value="{{$user['user_id']}}">{{$user['nickname']}}{{$user['user_id']}}</option>
    @endforeach
</select>
<div class="collapse" id="collapseProject">
    <select type="text" id="selectProject" name="selectProject" onchange="select('project',this.options[this.options.selectedIndex].value)" class="form-control">
        <option value=""></option>
        
    </select>
</div>
<button onclick="test()">test</button>
<div id="search-invoice" class=" table-style-invoice ">



</div>


@stop
@section('script')


<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>

<script>
    var user = ""
    var project = ""
    var projects = []
    var invoice = "{{$invoices}}"
    invoice = invoice.replace(/[\n\r]/g, "")
    invoice = JSON.parse(invoice.replace(/&quot;/g, '"'));
    var data = invoice

    function select(type, id) {
        switch (type) {
            case 'user':
                user = id;
                setProject()
                $('#collapseProject').collapse({
                    toggle: true
                })
                
            case 'project':
                project = id
            default:

        }
        
        list()
    }

    function setProject() {
        projects=[]
        $("#selectProject ").empty();
        $("#selectProject").append("<option value=''></option>");
        for (var i = 0; i < data.length; i++) {
            if (data[i].user['user_id'] == user) {
                if(projects.indexOf(data[i].project['name'])==-1){
                    projects.push(data[i].project['name'])
                    $("#selectProject").append("<option value='" + data[i].project['project_id'] +"'>"+ data[i].project['name']+ "</option>");
                }  
            }
        }
    }

    function test() {
        console.log(invoice[0].user['user_id'])

    }

    function list() {
        $("#search-invoice").empty();
        var parent = document.getElementById('search-invoice');
        var table = document.createElement("table");

        table.innerHTML = '<tr>' +

            '<th>請款人</th>' +

            '<th>請款項目</th>' +

            '<th>請款費用</th>' +

            '<th>請款日期</th>' +

            '<th></th>' +

            '</tr>'

        var tr, span, name, a

        //設定 div 屬性，如 id

        for (var i = 0; i < data.length; i++) {

            if (data[i].user['user_id'] == user) {


                if (data[i].status == 'waiting') {

                    span = "<span class='badge badge-pill badge-danger mr-2' style='background:#dc3545'>等待中</span>";

                } else if (data[i].status == 'waiting-fix' || data[i].status == 'check-fix') {

                    span = "<span class='badge badge-pill badge-danger mr-2' style='background:#ff7a87'>修改中</span>"

                } else if (data[i].status == 'check') {

                    span = "<span class='badge badge-pill badge-warning mr-2' style='background:#ffb13c'>審核中</span>"

                } else if (data[i].status == 'managed') {

                    span = "<span class='badge badge-pill badge-warning mr-2' >已審核</span>"

                } else if (data[i].status == 'matched') {

                    span = "<span class='badge badge-pill badge-success mr-2' >已請款</span>"

                } else if (data[i].status == 'complete') {

                    span = "<span class='badge badge-pill badge-light mr-2' >已匯款</span>"

                }

                a = "test(" + i + ")"

                tr = "<tr>" +

                    "<td>" + data[i].user['nickname'] + "</td>" +

                    "<td><a href='javascript:void(0)' onclick='" + a + "'>" + data[i].title + "</a></td>" +

                    "<td>" + commafy(data[i].price) + "</td>" +

                    "<td>" + data[i].created_at.substr(0, 10) + "</td>" +

                    "<td>" + span + "</td>" +



                    "</tr>"



                table.innerHTML = table.innerHTML + tr





            }

        }



        // tr.innerHTML = '123'

        parent.appendChild(table);



        // console.log(temp)


    }

    function commafy(num) {

        num = num + "";

        var re = /(-?\d+)(\d{3})/

        while (re.test(num)) {

            num = num.replace(re, "$1,$2")

        }

        return num;

    }
</script>

<script src="{{ URL::asset('js/grv.js') }}"></script>


@stop