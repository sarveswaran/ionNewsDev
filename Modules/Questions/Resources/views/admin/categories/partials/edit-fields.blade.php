<div class="box-body">

    <div class='form-group{{ $errors->has('name') ? ' has-error' : '' }}'>
	    {!! Form::label('name', trans('questions::questions.form.name')) !!}
	    {!! Form::text('name', old('name', $category->name), ['class' => 'form-control', 'placeholder' => trans('questions::questions.form.name')]) !!}
	    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
	</div>

	<div class='form-group{{ $errors->has('slug') ? ' has-error' : '' }}'>
	    {!! Form::label('slug', trans('questions::questions.form.slug')) !!}
	    {!! Form::text('slug', old('slug', $category->slug), ['class' => 'form-control', 'placeholder' => trans('questions::questions.form.slug')]) !!}
	    {!! $errors->first('slug', '<span class="help-block">:message</span>') !!}
	</div>

</div>
