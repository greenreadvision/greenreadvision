@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card" style="margin: 10px 0px;">
                <div class="card-header">
                    <h4>{{__('customize.Edit')}}{{__('customize.Invoice')}}</h4>
                </div>
                <div class="card-body">
                    <form action="update" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <li><label class="col-form-label">{{__('customize.Project')}}</label><select type="text" name="project_id" class="form-control">
                                    @foreach ($data['projects'] as $project)
                                        <option value="{{$project['project_id']}}" {{$project['selected']}}>{{$project['name']}}</option>
                                    @endforeach
                                </select></li>
                            </div>
                            @foreach($data['invoice'] as $key => $value)
                                @if (($key=='status'||$key=='matched'||$key=='managed')||((strpos($key, '_id')||strpos($key, '_at'))&&\Auth::user()->role!='engineer'))
                                    @continue
                                @endif
                                <div class="col-md-6 row" style="margin: auto;">
                                    <li class="col-12" style="padding:unset;"><label class="col-form-label" for="{{$key}}">{{__('customize.'.$key)}}</label></li>
                                    @if ($key == 'test')
                                        @dump($value)
                                    @elseif (strpos($key, "_id"))
                                        <label class="col-form-label">{{$value}}</label>
                                    @elseif (strpos($key, "_at"))
                                        <label class="col-form-label">{{$value}}</label>
                                    @elseif (strpos($key, "_date"))
                                        <input type="date" id="{{$key}}" name="{{$key}}" value="{{$value}}" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" placeholder="2019-01-06">
                                    @elseif (strpos($key, '_file'))
                                        <input type="file" id="{{$key}}" name="{{$key}}" value="{{$value}}" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}">
                                    @elseif ($key == 'content')
                                        <textarea id="{{$key}}" name="{{$key}}" rows="5" style="resize:none;" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}">{{$errors->has($key)? old($key): $value}}</textarea>
                                    @elseif (strpos($key, 'eceipt'))
                                        <label class="col-6 col-form-label" for="receipt_true"><input type="radio" id="receipt_true" name="receipt" value="1" class="{{ $errors->has('receipt') ? 'is-invalid' : '' }}" {{old('receipt')? 'checked': ''}} required>有</label>
                                        <label class="col-6 col-form-label" for="receipt_false"><input type="radio" id="receipt_false" name="receipt" value="0" class="{{ $errors->has('receipt') ? 'is-invalid' : '' }}" {{old('receipt')? '': 'checked'}}>沒有，待補</label>
                                        {{-- <input type="hidden" name="{{$key}}" value="0">
                                        <input type="checkbox" id="{{$key}}" name="{{$key}}" value="1" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}"> --}}
                                    @else
                                        <input type="text" id="{{$key}}" name="{{$key}}" value="{{$errors->has($key)? old($key): $value}}" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}">
                                    @endif
                                    @if ($errors->has($key))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first($key) }}</strong>
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <hr>
                        <div style="float: right;">
                            <button type="submit" class="btn btn-primary">{{__('customize.Save')}}</button>
                        </div>
                    </form>

                    <form action="delete" method="POST">
                        @method('DELETE')
                        @csrf
                        <div style="float: left;">
                            <button type="submit" class="btn btn-primary">{{__('customize.Delete')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@stop