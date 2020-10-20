@extends('layouts.app')

@section('content')

<form action="setRole" method="POST">
  @method('PUT')
  @csrf
  <div class="row">
    @foreach($data as $key => $user)
    <div class="col-lg-3 p-0 d-flex">
      <div class="form-control m-2">
        <h5>{{$user['nickname']}}</h5>
        <select type="text" class="form-control mt-2" name="{{$user['user_id']}}" id="{{$user['user_id']}}"required>
          @if($user['status'] == 'hold a post')
          <option value="hold a post" selected>@lang('customize.hold_a_post')</option>
          <option value="resignation">@lang('customize.resignation')</option>

          @else
          <option value="hold a post">@lang('customize.hold_a_post')</option>
          <option value="resignation" selected>@lang('customize.resignation')</option>
          @endif
        </select>
        <!-- <ul>
          @foreach ($user as $key => $value)
          @if($key=='role')
          <li><span class="font-weight-bold">@lang('customize.'.$key) : </span>
            @if (\Auth::user()->user_id==$user['user_id'])
            <span>@lang('customize.'.$value)</span>
            @else
            <select type="text" class="{{ $errors->has('role') ? ' is-invalid' : '' }}" name="{{$user['user_id']}}" required>
              <option value="manager" {{ $value == 'manager'? 'selected':'' }}>@lang('customize.manager')</option>
              <option value="accountant" {{ $value == 'accountant'? 'selected':'' }}>@lang('customize.accountant')</option>
              <option value="staff" {{ $value == 'staff'? 'selected':'' }}>@lang('customize.staff')</option>
            </select>
            @endif
          </li>
          @elseif($key!='nickname')
          <li class="col-form-label"><span class="font-weight-bold">@lang('customize.'.$key) : </span>{{$value}}</li>
          @endif
          @endforeach
        </ul>
        @if ($errors->has('role'))
        <span class="invalid-feedback" role="alert">
          <strong>{{ $errors->first('role') }}</strong>
        </span>
        @endif -->
      </div>
    </div>
    @endforeach
  </div>

  <div class="d-flex justify-content-end">
    <button type="submit" class="btn btn-primary">{{__('customize.Save')}}</button>
  </div>
</form>
@stop