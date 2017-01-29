<div class="box-body">

    <div class='form-group{{ $errors->has('question') ? ' has-error' : '' }}'>
	    {!! Form::label('question', trans('questions::questions.form.question')) !!}
	    {!! Form::text('question', old('question'), ['class' => 'form-control', 'placeholder' => trans('questions::questions.form.question')]) !!}
	    {!! $errors->first('question', '<span class="help-block">:message</span>') !!}
	</div>

	<div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
        {!! Form::label("category_id", trans('properties::propertystatuses.title.propertystatuses')) !!}
        {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}
        {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
    </div>

	<div class='form-group{{ $errors->has('answer_1') ? ' has-error' : '' }}'>
	    {!! Form::label('answer_1', trans('questions::questions.form.answer_1')) !!}
	    {!! Form::text('answer_1', old('answer_1'), ['class' => 'form-control', 'placeholder' => trans('questions::questions.form.answer_1')]) !!}
	    {!! $errors->first('answer_1', '<span class="help-block">:message</span>') !!}
	</div>

	<div class='form-group{{ $errors->has('answer_2') ? ' has-error' : '' }}'>
	    {!! Form::label('answer_2', trans('questions::questions.form.answer_2')) !!}
	    {!! Form::text('answer_2', old('answer_2'), ['class' => 'form-control', 'placeholder' => trans('questions::questions.form.answer_2')]) !!}
	    {!! $errors->first('answer_2', '<span class="help-block">:message</span>') !!}
	</div>

	<div class='form-group{{ $errors->has('answer_3') ? ' has-error' : '' }}'>
	    {!! Form::label('answer_3', trans('questions::questions.form.answer_3')) !!}
	    {!! Form::text('answer_3', old('answer_3'), ['class' => 'form-control', 'placeholder' => trans('questions::questions.form.answer_3')]) !!}
	    {!! $errors->first('answer_3', '<span class="help-block">:message</span>') !!}
	</div>

	<div class='form-group{{ $errors->has('answer_4') ? ' has-error' : '' }}'>
	    {!! Form::label('answer_4', trans('questions::questions.form.answer_4')) !!}
	    {!! Form::text('answer_4', old('answer_4'), ['class' => 'form-control', 'placeholder' => trans('questions::questions.form.answer_4')]) !!}
	    {!! $errors->first('answer_4', '<span class="help-block">:message</span>') !!}
	</div>

	<div class='form-group{{ $errors->has('answer_5') ? ' has-error' : '' }}'>
	    {!! Form::label('answer_5', trans('questions::questions.form.answer_5')) !!}
	    {!! Form::text('answer_5', old('answer_5', 'None of the above'), ['class' => 'form-control', 'placeholder' => trans('questions::questions.form.answer_5'), 'readonly' => '']) !!}
	    {!! $errors->first('answer_5', '<span class="help-block">:message</span>') !!}
	</div>

</div>
