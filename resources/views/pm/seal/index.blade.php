@extends('layouts.app')
@section('content')

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-3 mb-2">
            <div class="card border-0 shadow rounded-pill">
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">申請人</label>
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
                        <label class="col-lg-12 col-form-label">公司</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-company" name="select-company" onchange="select('company',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control mb-2">
                                <option value=""></option>
                                @foreach($company as $item)
                                <option value="{{$item}}">{{__('customize.' . $item)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">用印章別</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-seal-type" name="select-seal-type" onchange="select('sealType',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control mb-2">
                                <option value=""></option>
                                <option value="牛角大小章">牛角大小章</option>
                                <option value="連續大小章">連續大小章</option>
                                <option value="銀行大章">銀行大章</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">文件類別</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-file-type" name="select-file-type" onchange="select('fileType',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control mb-2">
                                <option value=""></option>
                                <option value="合約/契約">合約/契約</option>
                                <option value="標案文件">標案文件</option>
                                <option value="銀行文件">銀行文件</option>
                                <option value="政府文件">政府文件</option>
                                <option value="其他">其他</option>
                            </select>
                        </div>
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
                                <input type="text" name="search-seal-num" id="search-seal-num" class="form-control  rounded-pill" placeholder="用印單號" autocomplete="off" onkeyup="searchSealNum()">
                            </div>
                            <div class=" col-lg-4">
                                <input type="text" name="search-seal" id="search-seal" class="rounded-pill form-control" placeholder="申請事項" autocomplete="off" onkeyup="searchSeal()">
                            </div>
                            <div class="col-lg-6 d-flex justify-content-end">
                                <button class="btn btn-green rounded-pill" onclick="location.href='{{route('seal.create')}}'"><span class="mx-2">{{__('customize.Add')}}</span> </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 d-flex justify-content-between">
                        <div id="invoice-seal-page" class="d-flex align-items-end">
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
                           <button class="btn btn-blue rounded-pill" onclick='tableToExcel()'><span class="mx-2">匯出 Excel</span></button>
                        </div>
                    </div>
                    <div class="col-lg-12 table-style-invoice ">
                        <table id="search-seal-table">

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
    function tableToExcel() {
        var isReceipt = ''
        var isComplete = ''
        var status = {
            'waiting': '第一階段審核中',
            'waiting-fix': '審核被撤回',
            'managed': '審核完成',
            'complete': '用印完成並歸還'
        }
        var cp;
        
        

        var excel = [
            ['用印單號','申請日期', '申請人','歸還日期', '用印人', '公司-專案', '用印類型', '檔案類型', '申請內容', '狀態']
        ];
        for (var i = 0; i < seals.length; i++) {
            var project_name =''
            
            if(seals[i]['project_id'] =='other-grv_2'){
                project_name = '綠雷德-其他';
            }else if(seals[i]['project_id'] == 'other-rv' ){
                project_name = '閱野-其他';
            }else if(seals[i]['project_id'] =='other-grv'){
                project_name = '綠雷德(舊)-其他';
            }else{
                project_name =  seals[i].project['name'];
            }
            excel.push([seals[i]['final_id'],seals[i]['create_day'],seals[i].user['name'],seals[i]['complete_day'],seals[i].seal_user['name'],seals[i]['company'] + project_name,seals[i]['seal_type'],seals[i]['file_type'],seals[i]['content'],seals[i]['status']])
        }
        var filename = "用印表.xlsx";

        var ws_name = "工作表1";
        var wb = XLSX.utils.book_new(),
            ws = XLSX.utils.aoa_to_sheet(excel);
        XLSX.utils.book_append_sheet(wb, ws, ws_name);
        XLSX.writeFile(wb, filename);


    }
</script>
<script>
    var user =""
    var company = ""
    var seal_type = ""
    var file_type = ""
    var contentTemp =""
    var numTemp =""
    var nowPage = 1

    var seals = []

    $(document).ready(function() {
        reset();
    });

    function listSeal(){
        $('#search-seal-table').empty();
        var parent = document.getElementById('search-seal-table')
        var table = document.createElement("tbody");

        table.innerHTML = '<tr class="text-white">' +
            "<th width='10%'>用印單號</th>" + 
            "<th width='10%'>申請人</th>" +
            "<th width='10%'>用印人</th>" +
            "<th width='20%'>公司-專案</th>" +
            "<th width='10%'>用印類型</th>" +
            "<th width='10%'>檔案類型</th>" +
            "<th width='25%'>申請內容</th>" +
            "<th width='5%'>狀態</th>" +
            "<tr>"
        var tr, span, a, tp , cp
       
        for(var i=0;i< seals.length;i++){
            if(i >=(nowPage - 1)*10 && i <nowPage*10){
                table.innerHTML = table.innerHTML + setSealData(i)
            }
            else if(i >= nowPage*10){
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
        listSeal()
    }
    function nextPage() {
        var number = Math.ceil(seals.length / 10)

        if (nowPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage++
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listSeal()
        }

    }

    function previousPage() {
        var number = Math.ceil(seals.length / 10)

        if (nowPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage--
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listSeal()
        }
    }

    function listPage(){
        $("#invoice-seal-page").empty()
        var parent = document.getElementById('invoice-seal-page');
        var table = document.createElement("div");
        var number = Math.ceil(seals.length / 10)
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

    function setSealData(i){
        
        if (seals[i].status == 'waiting') {
            span = "<div class='progress' data-toggle='tooltip' data-placement='top' title='尚未審核'>" +
                "<div class='progress-bar bg-danger' role='progressbar' style='width: 0%' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'>" +
                "</div>" +
                "</div>";
        }
        else if (seals[i].status == 'waiting-fix') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='修改中'>" +
                "<div class='progress-bar bg-danger' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"

        }
        else if (seals[i].status == 'managed') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='申請完成'>" +
                "<div class='progress-bar bg-warning' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"

        }
        else if (seals[i].status == 'complete') {
            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='已用印完成並歸還'>" +
                "<div class='progress-bar bg-info' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"
        }

        if(seals[i].company == 'grv_2'){
            tp = '綠雷德'
        }
        else if(seals[i].company == 'rv'){
            tp = '閱野'
        }

        if(seals[i]['project_id'] == 'other-grv_2' || seals[i]['project_id'] == 'other-rv' || seals[i]['project_id'] == 'other-grv'){
            cp = '其他'
        }else{
            cp = seals[i].project['name']
        }
        a = "/seal/" + seals[i].seal_id + "/show" 
        tr = "<tr>" + 
            "<td width='10%'><a href='" + a + "' target='_blank'>" + seals[i].final_id + "</td>" +
            "<td width='10%'><a href='" + a + "' target='_blank'>" + seals[i].user['name'] + "</td>" +
            "<td width='10%'><a href='" + a + "' target='_blank'>" + seals[i].seal_user['name'] + "</td>" +
            "<td width='20%'><a href='" + a + "' target='_blank'>" + tp +"-"+ cp + "</td>" +
            "<td width='10%'><a href='" + a + "' target='_blank'>" + seals[i].seal_type +"</td>" +
            "<td width='10%'><a href='" + a + "' target='_blank'>" + seals[i].file_type + "</td>" +
            "<td width='25%'><a href='" + a + "' target='_blank'>" + seals[i].content + "</td>" +
            "<td width='5%'><a href='" + a + "' target='_blank'>" + span + "</td>" +
            "</tr>"
        return tr;
    }

    function getNewSeal() {
        data = "{{$seals}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    function select(type,id){
        switch(type){
            case 'user':
                user = id;
                if(id == ""){
                    reset()
                }else{
                    company = "";
                    seal_type = "";
                    file_type = "";
                    nowPage = 1;
                    setSeal()
                    setCompany()
                    setSealType()
                    setFileType()
                }
                break;
            case 'company':
                company = id;
                if(id == ""){
                    reset()
                }else{
                    seal_type = "";
                    file_type = "";
                    nowPage = 1;
                    setSeal()
                    setSealType()
                    setFileType()
                }
                break;
            case 'sealType':
                seal_type = id;
                if(id == ""){
                    reset()
                }else{
                    file_type = "";
                    nowPage = 1;
                    setSeal()
                    setFileType()
                }
                break;
            case 'fileType':
                file_type = id;
                if(id == ""){
                    reset()
                }else{
                    nowPage = 1;
                    setSeal()
                }
                break;
            default:
            break;
        }
        if(id !=''){
            setSearchNum()
            setSearch()
            listSeal();
            listPage();
        }
    }

    function reset(){
        setSeal()
        setUser()
        setCompany()
        setSealType()
        setFileType()
        setSearchNum()
        setSearch()
        listSeal()
        listPage()
    }

    function searchSeal() {
        contentTemp = document.getElementById('search-seal').value
        nowPage = 1
        setSeal()
        listSeal()
        listPage()
    }

    function searchSealNum() {
        numTemp = document.getElementById('search-seal-num').value
        nowPage = 1
        setSeal()
        listSeal()
        listPage()
    }

    function setSeal(){
        seals = getNewSeal();
        for(var i = 0 ; i < seals.length ; i++){
            if(user != ''){
                if(seals[i]['user_id'] != user){
                    seals.splice(i,1)
                    i--
                    continue
                }
            }
            if(company !=''){
                if(seals[i]['company'] != company){
                    seals.splice(i,1)
                    i--
                    continue
                }
            }
            if(seal_type !=''){
                if(seals[i]['seal_type'] != seal_type){
                    seals.splice(i,1)
                    i--
                    continue
                }
            }
            if(file_type != ''){
                if(seals[i]['file_type'] != file_type){
                    seals.splice(i,1)
                    i--
                    continue
                }
            }
            if(contentTemp != ''){
                if (seals[i]['content'] == null || seals[i]['content'].indexOf(contentTemp) == -1) {
                    seals.splice(i, 1)
                    i--
                    continue
                }
            }
            if (numTemp != '') {
                if (seals[i]['final_id'] == null || seals[i]['final_id'].indexOf(numTemp) == -1) {
                    seals.splice(i, 1)
                    i--
                    continue
                }
            }
        }
    }
    function setUser(){
        user = ''
        $("#select-user").val("")
    }

    function setCompany(){
        company = ''
        companies = []
        $('#select-company').val("")
        $('#select-company').empty()
        $('#select-company').append("<option value=''></option>")

        for(var i = 0 ; i < seals.length; i++){
            if(companies.indexOf(seals[i]['company']) == -1){
                companies.push(seals[i]['company'])
            }
        }
        companies.sort();
        for(var j = 0 ; j<companies.length;j++){
            $('#select-company').append("<option value='"+ companies[j] + "'> " + companies[j] + "</option>")
        }
    }

    function setSealType(){
        seal_type = ''
        seal_types = []
        $('#select-seal-type').val("")
        $('#select-seal-type').empty()
        $('#select-seal-type').append("<option value=''></option>")

        for(var i = 0 ; i < seals.length; i++){
            if(seal_types.indexOf(seals[i]['seal_type']) == -1){
                seal_types.push(seals[i]['seal_type'])
            }
        }
        seal_types.sort();
        for(var j = 0 ; j<seal_types.length;j++){
            $('#select-seal-type').append("<option value='"+ seal_types[j] + "'>" + seal_types[j] + "</option>")
        }
    }

    function setFileType(){
        file_type = ''
        file_types = []
        $('#select-file-type').val("")
        $('#select-file-type').empty()
        $('#select-file-type').append("<option value=''></option>")

        for(var i = 0 ; i < seals.length; i++){
            if(file_types.indexOf(seals[i]['file_type']) == -1){
                file_types.push(seals[i]['file_type'])
            }
        }
        file_types.sort();
        for(var j = 0 ; j<file_types.length;j++){
            $('#select-file-type').append("<option value='"+ file_types[j] + "'>" + file_types[j] + "</option>")
        }
    }

    function setSearch() {
        contentTemp = ''
        document.getElementById('search-seal').value = contentTemp
    }

    function setSearchNum() {
        numTemp = ''
        document.getElementById('search-seal-num').value = numTemp
    }

</script>