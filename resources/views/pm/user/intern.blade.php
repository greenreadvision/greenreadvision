@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center">
  <div class="col-lg-11">
    <div class="card border-0 shadow rounded-pill">
      <div class="card-body">
        <div class="col-lg-12 table-style-invoice ">
          <table>
            <tbody>
              <tr class="text-white">
                <th>員工編號</th>
                <th>姓名</th>
                <th>綽號</th>
                <th>職位</th>
                <th>在職狀態</th>
              </tr>
              @foreach($users as $user)
              <tr class="modal-style" data-toggle="modal" data-target="#{{$user->user_id}}Modal">
                <td>{{$user->user_id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->nickname}}</td>
                <td>{{__('customize.'.$user->role)}}</td>
                <td>{{__('customize.'.$user->status)}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@foreach($users as $user)
<div class="modal fade" id="{{$user->user_id}}Modal" tabindex="-1" role="dialog" aria-labelledby="{{$user->user_id}}ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header ">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="staff/store/{{$user->user_id}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="modal-body">
          <div class="d-flex justify-content-center">
            <div class="col-lg-11">

              <div class="form-group row">
                <div class="form-group col-lg-6">
                  <label for="user_id">員工編號</label>
                  <input autocomplete="off" type="text" class="form-control rounded-pill" id="user_id" name="user_id" value="{{$user->user_id}}">
                </div>
                <div class="form-group col-lg-3">
                  <label for="name">姓名</label>
                  <input type="text" class="form-control rounded-pill" id="name" value="{{$user->name}}" disabled>
                </div>
                <div class="form-group col-lg-3">
                  <label for="nickname">綽號</label>
                  <input type="text" class="form-control rounded-pill" id="nickname" value="{{$user->nickname}}" disabled>
                </div>
                <div class="form-group col-lg-6">
                  <label for="role">職位</label>
                  <select type="text" id="role" name="role" class="form-control rounded-pill">
                    @foreach($roles as $role)
                    @if($user->role == $role)
                    <option value="{{$role}}" selected>{{__('customize.'.$role)}}</option>
                    @else
                    <option value="{{$role}}">{{__('customize.'.$role)}}</option>
                    @endif
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-lg-6">
                  <label for="status">在職狀況</label>
                  <select type="text" id="status" name="status" class="form-control rounded-pill">
                  @foreach($statuses as $status)
                    @if($user->status == $status)
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
@stop