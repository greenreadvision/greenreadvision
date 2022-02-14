@extends('layouts.app')

@section('content')

<div class="modal fade" id="create_Modal"  role="dialog" aria-labelledby="CreateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form action="intern/create" method="POST" enctype="multipart/form-data">
          @method('PUT')
          @csrf
          <div class="modal-body">
            <div class="d-flex justify-content-center">
              <div class="col-lg-11">

                <div class="form-group row">
                  <div class="form-group col-lg-6">
                    <label for="intern_id">實習生編號</label>
                    <input autocomplete="on" type="text" class="form-control rounded-pill" id="create_intern_id" name="create_intern_id" value="{{$number}}" disabled>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="name">姓名</label>
                    <input type="text" class="form-control rounded-pill" id="create_name" name="create_name">
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="nickname">綽號</label>
                    <input type="text" class="form-control rounded-pill" id="create_nickname"  name="create_nickname">
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="email">email</label>
                    <input type="text" class="form-control rounded-pill" id="create_email" name="create_email">
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="status">在職狀況</label>
                    <select type="text" id="create_status" name="create_status" class="form-control rounded-pill">
                      <option value="general" selected>{{__('customize.general')}}</option>
                      <option value="train_OK">{{__('customize.train_OK')}}</option>
                    </select>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn btn-red rounded-pill " data-dismiss="modal"><span class="mx-2">關閉</span></button>
            <button type="submit" class="btn btn-green rounded-pill "><span class="mx-2">儲存</span></button>
          </div>
        </form>
    </div>
  </div>
</div>

@foreach($interns as $intern)

<div class="modal fade" id="{{$intern->intern_id}}_Modal"  role="dialog" aria-labelledby="{{$intern->intern_id}}ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header ">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="intern/store/{{$intern->intern_id}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="modal-body">
          <div class="d-flex justify-content-center">
            <div class="col-lg-11">

              <div class="form-group row">
                <div class="form-group col-lg-6">
                  <label for="intern_id">實習生編號</label>
                  <input autocomplete="off" type="text" class="form-control rounded-pill" id="intern_id" name="intern_id" value="{{$intern->intern_id}}">
                </div>
                <div class="form-group col-lg-3">
                  <label for="name">姓名</label>
                  <input type="text" class="form-control rounded-pill" id="name" value="{{$intern->name}}" disabled>
                </div>
                <div class="form-group col-lg-3">
                  <label for="nickname">綽號</label>
                  <input type="text" class="form-control rounded-pill" id="nickname" value="{{$intern->nickname}}" disabled>
                </div>
                <div class="form-group col-lg-6">
                  <label for="nickname">email</label>
                  <input type="text" class="form-control rounded-pill" id="email" value="{{$intern->email}}" disabled>
                </div>
                <div class="form-group col-lg-6">
                  <label for="status">在職狀況</label>
                  <select type="text" id="status" name="status" class="form-control rounded-pill">
                  @foreach($statuses as $status)
                    @if($intern->status == $status)
                    <option value="{{$status}}" selected>{{__('customize.'.$status)}}</option>
                    @else
                    <option value="{{$status}}">{{__('customize.'.$status)}}</option>
                    @endif
                    @endforeach
                  </select>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button type="button" class="btn btn-red rounded-pill " data-dismiss="modal"><span class="mx-2">關閉</span></button>
          <button type="submit" class="btn btn-green rounded-pill "><span class="mx-2">儲存</span></button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach
<div class="d-flex justify-content-center">
  <div class="col-lg-11">
    <div class="card border-0 shadow rounded-pill">
      <div class="card-body">
        <div style ="text-align:right">
          <button type="button" class="btn btn-primary" onclick="showModal('create')">
            {{__('customize.Add')}}
          </button>
        </div>
        <div class="col-lg-12 table-style-invoice ">
          <table>
            <tbody>
              <tr class="text-white">
                <th>實習生編號</th>
                <th>姓名</th>
                <th>綽號</th>
                <th>電子郵件</th>
                <th>在職狀態</th>
              </tr>
              @foreach($interns as $intern)
              <tr class="modal-style" data-toggle="modal" data-target="#{{$intern->intern_id}}_Modal" onclick="showModal({{$intern->intern_id}})">
                <td>{{$intern->intern_id}}</td>
                <td>{{$intern->name}}</td>
                <td>{{$intern->nickname}}</td>
                <td>{{__($intern->email)}}</td>
                <td>{{__('customize.'.$intern->status)}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

<script>
  function showModal(id){
    console.log(id)
    $('#'+id +'_Modal').modal('show')
  }
</script>