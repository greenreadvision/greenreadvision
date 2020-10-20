@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
	<div class="col-md-12 col-lg-10 col-xl-8">
		<div class="card" style="margin: 10px 0px;">
			<div class="card-header">
				<h4>{{__('customize.Add')}}{{__('customize.OffDay')}}</h4>
			</div>
			<div class="card-body">
				@empty($length)
				<form action="create/content" method="post">
					@endempty
					@isset($length)
					<form action="review" method="post">
						@endisset
						@csrf
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-row">
							<div class="col-md-12 mb-2" {{isset($length)? 'hidden':''}}>
								<div class="input-group">
									<div class="input-group-prepend">
										<label class="input-group-text{{ $errors->has('length') ? ' is-invalid' : '' }}" for="length">@lang('customize.time')@lang('customize.length')</label>
									</div>
									<select name="length" class="custom-select">
										<option hidden></option>
										@foreach ($selected as $key => $select)
										<option value="{{$key}}" {{$select}}>@lang('customize.'.$key)</option>
										@endforeach
									</select>
								</div>
							</div>
							@isset($length)
							@foreach ($names as $key => $name)
							<div class="col-md mb-2" {{$hidden[$key]}}>
								<div class="input-group">
									<div class="input-group-prepend">
										<div for="{{$name}}" class="input-group-text{{$errors->has($name) ? ' is-invalid' : ''}}">
											@lang('customize.'.(strstr($name, '_', 2)))@lang("customize.".$types[$key])
										</div>
									</div>
									<input type="{{$types[$key]}}" name="{{$name}}" class="form-control">
								</div>
							</div>
							@endforeach
							<div class="col-md-12 mb-2">
								<div class="input-group">
									<div class="input-group-prepend">
										<div for="content" class="input-group-text">
											@lang('customize.content')</div>
									</div>
									<input type="text" name="content" class="form-control">
								</div>
							</div>
							@endisset
						</div>
						<div class="d-flex">
							@isset($length)
							<div>
								<button type="button" onclick="location.href='{{url()->previous()}}'" class="btn btn-primary">{{__('customize.prev')}}</button>
							</div>
							@endisset
							<div class="ml-auto">
								<button type="submit" class="btn btn-primary ">{{__('customize.next')}}</button>
							</div>
						</div>
					</form>
					@if($errors->any())
					@foreach ($errors->toArray() as $errorName => $errorMessage)
					<span>@lang($errorName)有誤，請重新更正。</span>
					@endforeach
					@endif
			</div>
		</div>
	</div>
</div>
@stop