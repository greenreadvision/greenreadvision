@extends('layouts.app')

@section('content')
  <div class="row justify-content-center">
    <div class="col-md-12 col-lg-10 col-xl-8">
      <div class="card" style="margin: 10px 0px;">
        <div class="card-header">
          <h4>{{__('customize.Edit')}}{{__('customize.User')}}</h4>
        </div>
        <div class="card-body">
          <form action="setRole" method="POST">
            @method('PUT')
            @csrf
            <div class="row justify-content-between">
              @foreach($data as $key => $user)
                <div class="col-lg-6">
                  <div class="form-control m-1">
                    <h5>{{$user['nickname']}}</h5>
                    <ul>
                        @foreach ($user as $key => $value)
                            @if($key=='role')
                              <li><span>@lang('customize.'.$key) : </span>
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
                              <li class="col-form-label">@lang('customize.'.$key) : {{$value}}</li>
                            @endif
                        @endforeach
                    </ul>
                    @if ($errors->has('role'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('role') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
              @endforeach
            </div>
            <hr>
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary">{{__('customize.Save')}}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
    
@stop