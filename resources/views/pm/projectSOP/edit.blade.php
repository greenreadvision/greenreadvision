@extends('layouts.app')
@section('content')
<div class="modal fade" id="newTypeModal" role="dialog" aria-labelledby="newTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="width: 100%">
                <h5 class="modal-title" style="white-space:pre-wrap" id="newTypeModalLabel">新種類輸入框</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label class="col-lg-12 col-form-label">請輸入您想要的種類</label>
                <div class="col-lg-12">
                    <input type="text" name="new_input" id="new_input" class="rounded-pill form-control">
                </div>
                <div class="col-lg-12 d-flex justify-content-end" style="padding-top: 10px">
                    <button type="button" class="btn btn-blue rounded-pill" onclick="enterType()" data-dismiss="modal" aria-label="Close"><span class="mx-2">{{__('customize.Save')}}</span></button>
                </div> 
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 800px">
        <div class="modal-content">
            <div class="modal-header">
                <input type="text" id="number_delete" name="number_delete" value="" hidden>
                <h5 class="modal-title" id="deleteModalLabel">確定刪除？</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-footer border-0" style="justify-content: center">
                    <button type="button" class="btn btn-gray" data-dismiss="modal" >否</button>
                    <button type="button" class="btn btn-blue" data-dismiss="modal" onclick="deleteTr()">是</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteSOPModal" tabindex="-1" role="dialog" aria-labelledby="deleteSOPModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center ">
                是否刪除?
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">否</button>
                <form action="delete" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-primary">是</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-10" style="margin: auto">
    <form name="projectSOP_Form" action="update" method="post" enctype="multipart/form-data">
    @csrf
        <div class="row" style="text-align: center">
            <div class="col-lg-12">
                <div class="card border-0 shadow rounded-pill">
                    <div class="card-body">
                        <div class="form-group col-lg-12">
                            <div class="btn-group btn-group-toggle w-50" data-toggle="buttons">
                                <label class="btn btn-secondary w-50 {{ $projectSOP->SOPtype == 'project' ? 'active' : '' }}" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px">
                                    <input type="radio" name="options" onchange="changeSOP(0)" autocomplete="off" {{ $projectSOP->SOPtype == 'project' ? 'checked' : '' }}> 專案
                                </label>
                                <label class="btn btn-secondary w-50 {{ $projectSOP->SOPtype == 'other' ? 'active' : '' }}" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">
                                    <input type="radio" name="options" onchange="changeSOP(1)" autocomplete="off" {{ $projectSOP->SOPtype == 'other' ? 'checked' : ''  }}> 其他
                                </label>
                                <input type="text" name="SOPtype" id="SOPtype" value="project" hidden>
                            </div>
                        </div>
                        <div class="projectSOP" style="{{ $projectSOP->SOPtype == 'project' ? 'display:block' : 'display:none' }}">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="col-lg-12 col-form-label">公司</label>
                                    <div class="col-lg-12">
                                        <select type="text" id="select-company" name="select-company" onchange="changeProject(this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                            <option value=""></option>
                                            <option value="grv_2" {{$projectSOP->company_name=='grv_2'? 'selected' : ''}}>綠雷德</option>
                                            <option value="rv"  {{$projectSOP->company_name=='rv'? 'selected' : ''}}>閱野</option>
                                            <option value="grv">綠雷德(舊)</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="col-lg-12 col-form-label">專案</label>
                                    <div class="col-lg-12">
                                        <select name="select-project" id="select-project" type="text" class="rounded-pill form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>   
                            </div>
                            <label class="col-lg-12 col-form-label">整體簡介</label>
                            <div class="col-lg-12">
                                <textarea type="text" style="resize:none;" name="content" id="content" rows="3" class="rounded-pill form-control" required>{{ $projectSOP->SOPtype == 'project' ? $projectSOP->content : ''  }}</textarea>
                            </div>
                            <div class="row" style="justify-content: space-between;">
                                <div class="float-left" style="padding-top: 10px">
                                    <button type="button" id="createButton" data-target="#deleteSOPModal" data-toggle="modal" class="btn btn-red rounded-pill"><span class="mx-2">刪除</span> </button>
                                </div>
                                <div class="float-right" style="padding-top: 10px">
                                    <button type="submit" id="createButton" class="btn btn-green rounded-pill"><span class="mx-2">修改</span> </button>
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="otherSOP" style = "{{ $projectSOP->SOPtype == 'other' ? 'display:block' : 'display:none' }}">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="col-lg-12 col-form-label">公司</label>
                                    <div class="col-lg-12">
                                        <select type="text" id="select-other-company" name="select-other-company" class="rounded-pill form-control">
                                            <option value=""></option>
                                            <option value="grv_2" {{$projectSOP->company_name=='grv_2'? 'selected' : ''}}>綠雷德</option>
                                            <option value="rv" {{$projectSOP->company_name=='rv'? 'selected' : ''}}>閱野</option>
                                            <option value="grv">綠雷德(舊)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="col-lg-12 col-form-label">種類</label>
                                    
                                    <div style="display: flex">
                                        <div class="col-lg-8">
                                            <select type="text" id="select-other-type" name="select-other-type" class="rounded-pill form-control">
                                                <option value=""></option>
                                                @foreach ($otherProjectSOPs as $item)
                                                    <option value="{{$item->type}}" {{$projectSOP->type ==$item->type?'selected':''}}>{{$item->type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <button type="button" data-toggle="modal" data-target="#newTypeModal" class="rounded-pill form-control btn btn-success">新增新種類</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <label class="col-lg-12 col-form-label">整體簡介</label>
                            <div class="col-lg-12">
                                <textarea type="text" style="resize:none;" name="otherContent" id="otherContent" rows="3" class="rounded-pill form-control">{{ $projectSOP->SOPtype == 'other' ? $projectSOP->content : ''  }}</textarea>
                            </div>
                            <div class="row" style="justify-content: space-between;">
                                <div class="float-left" style="padding-top: 10px">
                                    <button type="button" id="createButton" data-target="#deleteSOPModal" data-toggle="modal" class="btn btn-red rounded-pill"><span class="mx-2">刪除</span> </button>
                                </div>
                                <div class="float-right" style="padding-top: 10px">
                                    <button type="submit" id="createButton" class="btn btn-green rounded-pill"><span class="mx-2">修改</span> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12" style="padding-top: 10px">
                <input type="text" id="fileNum" name="fileNum" value="" hidden>
                    <div class="col-lg-12 table-style-invoice ">
                        <table id="file_table" class="tableSOP" style="table-layout: fixed;border:1px #000 solid;" bgcolor="white"  >
                            
                        </table>
                    </div>
            </div>
            <div style="padding-top: 10px;padding-left: 30px;">
                <div class="AutoWidth fileButton rounded-pill form-control">
                    <input type="file" id="file" name="file" onchange="AddFile()" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf"/>檔案(單個)上傳請按這
                </div>
            </div>
        </div>
    </form>
</div>

@stop

@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.14.0/dist/xlsx.full.min.js"></script>
<script>
    var SOPtype = "project"
    var company = ""
    var fileNum = 0
    var showNum = 0
    var ProjectSOP = []
    var project_list = [];
    var ProjectSOP_items =[]
</script>
<script>
    

    function changeSOP(i){
        if(i==0){
            SOPtype = "project"
            $('#other_file').val('');
            $('#otherContent').val('');
            document.getElementsByClassName('projectSOP')[0].style.display = "block"
            document.getElementsByClassName('otherSOP')[0].style.display = 'none'
            document.getElementById('SOPtype').value = SOPtype
            document.getElementById('otherContent').required = ""
            document.getElementById('content').required = "required"
            
        }else if(i==1){
            SOPtype = "other"
            $('#file').val('');
            $('#content').val('');
            document.getElementsByClassName('projectSOP')[0].style.display = "none"
            document.getElementsByClassName('otherSOP')[0].style.display = 'block'
            document.getElementById('SOPtype').value = SOPtype
            document.getElementById('otherContent').required = "required"
            document.getElementById('content').required = ""
            
        }
        changeProject("");
        resetFileList()
    }

    function enterType(){
        
        var newType = document.getElementById('new_input')
        var select_other_type = document.getElementById('select-other-type');
        $('#select-other-type').append("<option value='" + newType.value + "' selected>" + newType.value + "</option>")
        newType.value = ""
    }
</script>
<script>
    function getNewProject(){
        data = "{{$projects}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }
    function getNewProjectSOP(){
        data = "{{$projectSOP}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }
    function getNewProjectSOP_items(){
        data = "{{$projectSOP_items}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        fileNum = data.length
        showNum = data.length
        document.getElementById('fileNum').value = fileNum
        return data
    }

    function changeProject(val){
        company = val
        listProject()
    }
    function listProject(){
        var select_project = document.getElementById('select-project');
        var group_grv_2 = document.createElement('optgroup');
        var group_rv = document.createElement('optgroup');
        var group_grv = document.createElement('optgroup');
        group_grv_2.label = "綠雷德(新)"
        group_rv.label = "閱野"
        group_grv.label = "綠雷德(舊)"
        group_grv_2.innerText= " ";
        group_rv.innerText= " ";
        group_grv.innerText= " ";
        group_grv_2.id= "group_grv_2";
        group_rv.id= "group_rv";
        group_grv.id= "group_grv";
        $("#select-project").empty()
        $("#select-project").append("<option value=''></option>")
        if(ProjectSOP['project_id'] == null){
            
            $("#select-project").append(group_grv_2)
            $("#select-project").append(group_rv)
            $("#select-project").append(group_grv)
            for(var i = 0 ; i <project_list.length ; i++){
                if(project_list[i].color != '#00ffb8' && project_list[i].finished != 1){ // 三間公司-其他  不列入選擇範圍
                    if(project_list[i].company_name == 'grv_2'){
                        $("#group_grv_2").append("<option value='" + project_list[i]['project_id'] + "'>" + project_list[i]['name'] + "</option>");
                        
                    }
                    else if(project_list[i].company_name == 'rv'){
                        $("#group_rv").append("<option value='" + project_list[i]['project_id'] + "'>" + project_list[i]['name'] + "</option>");
                    }
                    else if(project_list[i].company_name == 'grv'){
                        $("#group_grv").append("<option value='" + project_list[i]['project_id'] + "'>" + project_list[i]['name'] + "</option>");
                    }
                }
                
            }
            
            
        }else if(ProjectSOP['project_id'] != null){
            company_project = document.createElement('optgroup')
            if(company == 'grv_2'){
                company_project.label = "綠雷德(新)"
                
            }
            else if(company == 'rv'){
                company_project.label = "閱野"
                
            }
            else if(company == 'grv'){
                company_project.label = "綠雷德(舊)"
                
            }
            company_project.innerText= " "
            company_project.id='company_project'
            select_project.append(company_project)
            for(var i = 0 ; i <project_list.length ; i++){
                if(project_list[i].company_name == company && project_list[i].color != '#00ffb8' && project_list[i].finished != 1){
                    if(ProjectSOP.project['project_id'] ==  project_list[i]['project_id']){
                        $('#company_project').append("<option value='" + project_list[i]['project_id'] + "' selected>" + project_list[i]['name'] + "</option>");
                    }
                    else{
                        $('#company_project').append("<option value='" + project_list[i]['project_id'] + "'>" + project_list[i]['name'] + "</option>");
                    }
                }
            }
        }
    }
</script>
<script>
    $(document).ready(function() {
        project_list = getNewProject()
        ProjectSOP = getNewProjectSOP()
        ProjectSOP_items = getNewProjectSOP_items()
        if(ProjectSOP.SOPtype == 'project'){
            SOPtype ='project'
            document.getElementById('SOPtype').value = SOPtype
            changeSOP(0)
            
        }
        else if(ProjectSOP.SOPtype == 'other'){
            SOPtype = 'other'
            document.getElementById('SOPtype').value = SOPtype
            changeSOP(1)
        }
        changeProject(ProjectSOP['company_name'])
        resetFileList()
    });

    function resetFileList(){
        $('#file_table').empty()
        var parent = document.getElementById('file_table');
        var tbody = document.createElement('tbody')
        tbody.setAttribute('id','file_tbody')
        tbody.innerHTML = '<tr class="text-white">' +
            '<th style="width:10%">檔案編號</th>' +
            '<th style="width:40%">檔案名稱(可直接點擊名稱更換檔案)</th>' +
            '<th style="width:45%">檔案簡介</th>' +
            '<th style="width:10%">動作</th>' 
        parent.appendChild(tbody);
        console.log(ProjectSOP_items)
        for(var i = 0 ; i < ProjectSOP_items.length ; i++){
            var tr = document.createElement('tr')
            if(ProjectSOP_items[i]['content']  == null){
                content = ''
            }
            else{
                content = ProjectSOP_items[i]['content'] 
            }
            tr.setAttribute('id','tr_'+i)
            tr.innerHTML = "<td ><input type=\"text\" style=\"width: 100%;text-align:center;border-style:none\"  id = \"File_no_"+i+"\" name =\"File_no_"+i+"\" value =\"" + ProjectSOP_items[i]['no'] +"\" readonly/></td>" +
                '<td>'+"<div class=\"fileButtonList rounded-pill form-control\" id=\"button_"+ i +"\">"+
                "<input type=\"file\" id=\"file_"+ i +"\" name=\"file_"+ i+ "\" onchange=\"changeFile("+ i +")\" accept=\".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf\"/>" +"<span id=\"span_"+i+"\">" + ProjectSOP_items[i]['name'] +"</span>" +"<input style=\"width: 100%;text-align:center;border-style:none\" type=\"text\" id=\"inputFile_"+ i +"\" name=\"inputFile_"+ i +"\" value=\""+ ProjectSOP_items[i]['name'] +"\">"+
                "</div></td>" +
                "<td><textarea rows=\"2\"  style=\"width: 100%;text-align:left;\"  type=\"text\" id=\"SOPtiem_content_"+ i +"\" name=\"SOPtiem_content_"+ i +"\">"+  content +"</textarea></td>" +
                "<td><i class=\"fas fa-trash-alt\" id =\"deleteModal-"+i+"\" data-id=\""+ i +"\" data-toggle=\"modal\" data-target=\"#deleteModal\"></i></td>"
            tbody.appendChild(tr);
            ModalFunction(i)
        }
       

       
    }

    function AddFile(){
        var cloneFile = $('#file').clone()
        cloneFile.attr('id','file_' + fileNum)
        cloneFile.attr('name','file_' + fileNum)
        cloneFile.attr('onchange',"changeFile("+ fileNum +")")

        var file_tbody = document.getElementById('file_tbody')
        var tr = document.createElement('tr')
        tr.setAttribute('id','tr_'+fileNum)

        tr.innerHTML = "<td ><input type=\"text\" style=\"width: 100%;text-align:center;border-style:none\"  id = \"File_no_"+fileNum+"\" name =\"File_no_"+fileNum+"\" value =\"" + (showNum+1) +"\" readonly/></td>"+
        '<td>'+"<div class=\"fileButtonList rounded-pill form-control\" id=\"button_"+ fileNum +"\">"+
        "<span id =\"span_"+ fileNum +"\"></span>" + "<input style=\"width: 100%;text-align:center;border-style:none\" type=\"text\" id=\"inputFile_"+fileNum +"\" name=\"inputFile_"+ fileNum +"\" value=\"\"/>" +
        "</div></td>" +
        "<td><textarea rows=\"2\"  style=\"width: 100%;text-align:left;\"  type=\"text\" id=\"SOPtiem_content_"+ fileNum +"\" name=\"SOPtiem_content_"+ fileNum +"\"></textarea></td>" +
        "<td><i class=\"fas fa-trash-alt\" id =\"deleteModal-"+fileNum+"\" data-id=\""+ fileNum +"\" data-toggle=\"modal\" data-target=\"#deleteModal\"></i></td>"
        file_tbody.appendChild(tr);
        
        inputText = document.getElementById("inputFile_"+ fileNum)
        span = document.getElementById("span_"+fileNum)
        cloneFile.insertBefore(span)
        File = document.getElementById('file_' + fileNum)
        inputText.setAttribute('value',File.files[0].name) 
        span.textContent = File.files[0].name
            
        ModalFunction(fileNum)
        fileNum++
        showNum++
        document.getElementById('fileNum').value = fileNum
        
    }

    function changeFile(val){
        
        span = document.getElementById('span_' + val)
        file = document.getElementById('file_'+val)
        if(file.files.length != 0){
            span.innerText = file.files.item(0).name
            Button = document.getElementById('button_'+val)
            Button.classList.remove('fileButtonList')
            Button.classList.add('fileButtonChange')
        }else{
            span.innerText = "NULL"
            Button.classList.remove('fileButtonList')
            Button.classList.add('fileButtonChange')
        }
    }

    function deleteTr(){
        var delete_ListNum = document.getElementById('number_delete').value
        console.log('delete - ' + delete_ListNum)
        for(var i = 0;i < fileNum; i++){
            if(i == delete_ListNum){
                var tr = document.getElementById('tr_' + i)
                tr.hidden = true
                var file_no = document.getElementById('File_no_' + i)
                file_no.value = 'delete'
            }
            else if(i > delete_ListNum){
                var file_no = document.getElementById('File_no_' + i)
                if(file_no.value !='delete'){
                    file_no.value = file_no.value - 1
                }
            }
        }
        showNum--
    }

    function ModalFunction(item){
        console.log(' item= ' +item)

        $(document).on("click","#deleteModal-"+item,function(){    //編寫檔案簡介的Icon點擊後的的動作
            
            var number = $(this).data('id');                    //查詢到button 的 data-id的值
            number = item
            $("#number_delete").val(number)                       //Modal的saveNumInput設定好值，可以回傳function回saveEditContent()
            $("#deleteModal").show()                              //顯示Modal
            console.log('showList' + number)
        });
    }

    
</script>