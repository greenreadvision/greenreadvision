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
<div class="col-lg-10" style="margin: auto">
    <form name="projectSOP_Form" action="create/store" method="post" enctype="multipart/form-data">
    @csrf
        <div class="row" style="text-align: center">
            <div class="col-lg-12">
                <div class="card border-0 shadow rounded-pill">
                    <div class="card-body">
                        <div class="form-group  col-lg-12">
                            <div class="btn-group btn-group-toggle w-50" data-toggle="buttons">
                                <label class="btn btn-secondary active w-50" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px">
                                    <input type="radio" name="options" onchange="changeSOP(0)" autocomplete="off" checked> 專案
                                </label>
                                <label class="btn btn-secondary w-50" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">
                                    <input type="radio" name="options" onchange="changeSOP(1)" autocomplete="off"> 其他
                                </label>
                                <input type="text" name="SOPtype" id="SOPtype" value="project" hidden>
                            </div>
                        </div>
                        <div class="projectSOP">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="col-lg-12 col-form-label">公司</label>
                                    <div class="col-lg-12">
                                        <select type="text" id="select-company" name="select-company" onchange="changeProject(this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                            <option value=""></option>
                                            <option value="grv_2">綠雷德</option>
                                            <option value="rv">閱野</option>
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
                            <label class="col-lg-12 col-form-label">檔案上傳(可多檔案)</label>
                            <div class="col-lg-11 fileButton rounded-pill form-control">
                                <input type="file" id="file" name="file[]" onchange="AddFile()" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf"  multiple/>檔案上傳請按這
                            </div>
                            <label class="col-lg-12 col-form-label">整體簡介</label>
                            <div class="col-lg-12">
                                <textarea type="text" style="resize:none;" name="content" id="content" rows="3" class="rounded-pill form-control"></textarea>
                            </div>
                            <div class="float-right" style="padding-top: 10px">
                                <button type="submit" id="createButton" class="btn btn-green rounded-pill"><span class="mx-2">新增</span> </button>
                            </div>
                            <input type="text" id="FileListSave" name="FileListSave" value="" hidden>
                            
                        </div>
                        <div class="otherSOP" style="display: none">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="col-lg-12 col-form-label">公司</label>
                                    <div class="col-lg-12">
                                        <select type="text" id="select-other-company" name="select-other-company" class="rounded-pill form-control">
                                            <option value=""></option>
                                            <option value="grv_2">綠雷德</option>
                                            <option value="rv">閱野</option>
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
                                                    <option value="{{$item->type}}">{{$item->type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <button type="button" data-toggle="modal" data-target="#newTypeModal" class="rounded-pill form-control btn btn-success">新增新種類</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <label class="col-lg-12 col-form-label">檔案上傳(可多檔案)</label>
                            <div class="col-lg-11 fileButton rounded-pill form-control">
                                <input type="file" id="other_file" name="other_file[]" onchange="AddFile()" class="rounded-pill form-control" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" multiple/>檔案上傳請按這
                            </div>
                            <label class="col-lg-12 col-form-label">簡介</label>
                            <div class="col-lg-12">
                                <textarea type="text" style="resize:none;" name="otherContent" id="otherContent" rows="3" class="rounded-pill form-control"></textarea>
                            </div>
                            <div class="float-right" style="padding-top: 10px">
                                <button type="submit" id="createButton" class="btn btn-green rounded-pill"><span class="mx-2">新增</span> </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12" style="padding-top: 10px">
                <div class="col-lg-12 table-style-invoice ">
                    <table id="file_table" class="tableSOP" style="table-layout: fixed;border:1px #000 solid;" bgcolor="white"  >
                        
                    </table>
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
    var fileListNum = 0
    var project_list = [];
</script>
<script>
    function changeSOP(i){
        if(i==0){
            SOPtype = "project"
            company = ""
            $('#select-company').val("");
            $('#other_file').val('');
            $('#otherContent').val('');
            document.getElementsByClassName('projectSOP')[0].style.display = "block"
            document.getElementsByClassName('otherSOP')[0].style.display = 'none'
            document.getElementById('SOPtype').value = SOPtype
            
            
        }else if(i==1){
            SOPtype = "other"
            $('#select-other-type').val("")
            $('#file').val('');
            $('#content').val('');
            document.getElementsByClassName('projectSOP')[0].style.display = "none"
            document.getElementsByClassName('otherSOP')[0].style.display = 'block'
            document.getElementById('SOPtype').value = SOPtype
            
        }
        changeProject("");
        resetFileList()
        for(var i = 0 ;i < fileListNum ; i++){
            $('#fileClone_'+i).remove()
        }
        
        fileListNum = 0
        document.getElementById('FileListSave').value = fileListNum
        
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
            if(company == ""){
                
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
                
                
            }else if(company != ""){
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
                        $('#company_project').append("<option value='" + project_list[i]['project_id'] + "'>" + project_list[i]['name'] + "</option>");
                    }
                }
                
            }
    }
</script>
<script>
    $(document).ready(function() {
        document.getElementsByClassName('otherSOP')[0].style.display = "none";
        resetFileList()
        project_list = getNewProject()
        listProject()
    });

    function resetFileList(){
        $('#file_table').empty()
        var parent = document.getElementById('file_table');
        var tbody = document.createElement('tbody')
        tbody.setAttribute('id','file_tbody')
        tbody.innerHTML = '<tr class="text-white">' +
            '<th style="width:10%">檔案刪除</th>' +
            '<th style="width:10%">檔案編號</th>' +
            '<th style="width:50%">檔案名稱</th>' +
            '<th style="width:30%">檔案備註</th>'
        parent.appendChild(tbody);
        for(var i = 0;i < fileListNum;i++){
            $('#fileClone_' + (i+1)).remove()
        }
        fileNum = 0
        fileListNum = 0
        document.getElementById('FileListSave').value = fileListNum
    }

    function CloneFile(){
        var createButton = document.getElementById('createButton');
        fileListNum++
        var cloneFile = $('#file').clone()
        cloneFile.attr('id','fileClone_' + fileListNum)
        cloneFile.attr('name','fileClone_' + fileListNum +'[]')
        cloneFile.insertAfter(createButton)
        cloneFile.hide()
        document.getElementById('FileListSave').value = fileListNum
        
    }

    function CloneOtherFile(){
        var createButton = document.getElementById('createButton');
        fileListNum++
        var cloneFile = $('#other_file').clone()
        cloneFile.attr('id','fileClone_' + fileListNum)
        cloneFile.attr('name','fileClone_' + fileListNum + '[]')
        cloneFile.insertAfter(createButton)
        cloneFile.hide()
        document.getElementById('FileListSave').value = fileListNum
        
    }

    function AddFile(){
        if(SOPtype == 'project'){
            CloneFile()
            showList()
        }else if(SOPtype =='other'){
            CloneOtherFile()
            showList()
        }
        
    }

    function deleteTr(){
        var delete_ListNum = document.getElementById('number_delete').value
        for(var i = 1;i <= fileListNum; i++){
            var fileArray = document.getElementById('fileClone_' + i)
            console.log('delete' + delete_ListNum)
            if(i == delete_ListNum){
                var deleteArray = document.getElementById('fileClone_' + i)
                var deleteArralenght = deleteArray.files.length
                for(var j = 0 ; j < deleteArray.files.length ; j++){
                    tr = document.getElementById('tr-' + i + "-" + j)
                    tr.remove()
                }
                fileNum= fileNum-deleteArralenght
                $('#fileClone_' + i).remove()
            }
            else if(i > delete_ListNum){
                fileArray.setAttribute("id",'fileClone_' + (i-1))
                deleteModal = document.getElementById('deleteModal-' + i)
                deleteModal.setAttribute('id','deleteModal-'+(i-1))
                deleteModal.setAttribute("data-id",(i-1))

                for(var j = 0 ; j < fileArray.files.length ; j++){
                    tr = document.getElementById('tr-' + i + "-" + j)
                    tr.setAttribute("id",'tr-' + (i-1) + "-" + j)

                    fileContent = document.getElementById('file-content-'+i+"-"+j)
                    fileContent.setAttribute('name',"file-content-"+ (i-1)+"-"+ j)
                    fileContent.setAttribute('id',"file-content-"+ (i-1) +"-" + j)

                    File_no = document.getElementById("File_no_"+ i +"_"+ j)
                    File_no.setAttribute('name',"File_no_"+ (i-1) +"_" + j)
                    File_no.value = File_no.value - deleteArralenght
                    File_no.setAttribute('id',"File_no_"+ (i-1) +"_" + j)

                    ModalFunction((i-1),j)
                }
            }
        }
        fileListNum--
        document.getElementById('FileListSave').value = fileListNum
    }

    function showList(){ 
        var tbody = document.getElementById('file_tbody')
            var fileArray = document.getElementById('fileClone_' + fileListNum)
            
            for(var j =0;j< fileArray.files.length ; j++){
                var tr = document.createElement('tr')
                tr.setAttribute('id','tr-' + fileListNum + "-" + j)
                var fname = fileArray.files.item(j).name;
                var fsize = fileArray.files.item(j).size;
    
                if((fsize/1024)<1024){
                    sizeWord = (fsize/1024).toFixed(0) + "KB"
                }else if((fsize/1024)>1024){
                    sizeWord = ((fsize/1024)/1024).toFixed(2) + "MB"
                }
    
                var contentInput = "<textarea rows=\"2\" style=\"width: 100%;text-align:left;\" id=\"file-content-"+ fileListNum +"-" + j + "\" name=\"file-content-"+ fileListNum+"-"+ j + "\">{{old('file-content-"+ fileNum +"')}}</textarea>"
                if(j==0){
                    tr.innerHTML = "<td rowspan=\""+ fileArray.files.length +"\"><i class=\"fas fa-trash-alt\" id =\"deleteModal-"+fileListNum+"\" data-id=\""+ fileListNum +"\" data-toggle=\"modal\" data-target=\"#deleteModal\"></i></td>" +
                    "<td><input type=\"text\" style=\"width: 100%;text-align:center;border-style:none\"  id = \"File_no_"+fileListNum+"_"+ j +"\" name =\"File_no_"+fileListNum+"_"+ j +"\" value =\"" + (fileNum+1) +"\" readonly/></td>" + 
                    "<td>"+ fname +"</td>"+
                    "<td>" + contentInput +"</td>" 
                }else{
                    tr.innerHTML = "<td><input type=\"text\" style=\"width: 100%;text-align:center;border-style:none\"  id = \"File_no_"+fileListNum+"_"+ j +"\" name =\"File_no_"+fileListNum+"_"+ j +"\" value =\"" + (fileNum+1) +"\" readonly/></td>" + 
                    "<td>"+ fname +"</td>"+
                    "<td>" + contentInput +"</td>" 
                }
                
                tbody.appendChild(tr);
                fileNum++
                ModalFunction(fileListNum , j);
            }
    }

    function ModalFunction(list,item){

        $(document).on("click","#deleteModal-"+list,function(){    //編寫檔案簡介的Icon點擊後的的動作
            
            var number = $(this).data('id');                    //查詢到button 的 data-id的值
            number = list
            $("#number_delete").val(number)                       //Modal的saveNumInput設定好值，可以回傳function回saveEditContent()
            $("#deleteModal").show()                              //顯示Modal
            console.log('showList' + number)
        });
    }

    function saveEditContent(){
        var saveNumber = document.getElementById('number_save').value
        var saveListNumber = document.getElementById('numberList_save').value
        var EditContent = document.getElementById('EditInput')
        var fileContent = document.getElementById('file-content-' + saveListNumber +"-"+saveNumber)
        fileContent.value = EditContent.value   //設定檔案的介紹值
        EditContent.value =""
    }

    
</script>