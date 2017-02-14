<div class="box-body">

    <div class='form-group{{ $errors->has('question') ? ' has-error' : '' }}'>
	    {!! Form::label('question', trans('Question')) !!}
	    {!! Form::text('question', old('question'), ['class' => 'form-control', 'placeholder' => trans('question')]) !!}
	    {!! $errors->first('question', '<span class="help-block">:message</span>') !!}
	</div>
	
	@mediaSingle('movieimage')

</div>
