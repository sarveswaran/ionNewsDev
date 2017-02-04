<div class="box-body">

    <div class='form-group{{ $errors->has('name') ? ' has-error' : '' }}'>
	    {!! Form::label('name', trans('category name')) !!}
	    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('category name')]) !!}
	    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
	</div>

	<div class='form-group{{ $errors->has('slug') ? ' has-error' : '' }}'>
	    {!! Form::label('slug', trans('reference')) !!}
	    {!! Form::text('slug', old('slug'), ['class' => 'form-control', 'placeholder' => trans('reference')]) !!}
	    {!! $errors->first('slug', '<span class="help-block">:message</span>') !!}
	</div>
	<div class="row">
         <div class="col-sm-10">
            <div class="form-group{{ $errors->has('Address') ? ' has-error' : '' }}">
                {!! Form::label('status', trans('Status')) !!}
                 &nbsp;&nbsp;
                &nbsp;&nbsp;
                {!! Form::label('status', trans('Enable')) !!}
                {!! Form::radio('status', 1, ['class' => '']) !!}
                {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
                &nbsp;&nbsp;
                {!! Form::label('status', trans('disable')) !!}
                {!! Form::radio('status', 0, ['class' => '']) !!}
                {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

</div>
