@extends('grv.CMS.app')
@section('content')


<div class="col-lg-12" >
    <div class="row">
        
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-10 mb-2">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow rounded-pill">
                    <div class="card-body">
                        <div class='justify-content-center' >
                            <div id="content" name= 'content'>

                            </div>
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

    var board =[]
    $(document).ready(function() {
        getNewBoard()
        setContent();
    });
    

    function getNewBoard(){
        data = "{{$board}}"
        data = data.replace(/[\n\r]/g, "")
        data = data.replace(/&lt;/g, '<')
        data = data.replace(/&gt;/g, '>')
        data = data.replace(/&quot;/g, '"')
        
        data = JSON.parse(data)
        data.content = data.content.replace(/&#039;/g,"'")
        data.content = data.content.replace()
        
        console.log(data)
        return data
    }

    function setContent(){
     
        board=getNewBoard();
        $('#content').empty();
        var parent = document.getElementById('content');
        var content = document.createElement('div');
        var data = board.content;
        console.log(data)
        content.innerHTML = data;

        parent.appendChild(content);
    }

</script>