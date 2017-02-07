<div class="box-body">

    <div class='form-group{{ $errors->has('question') ? ' has-error' : '' }}'>
	    {!! Form::label('question', trans('Question')) !!}
	    {!! Form::text('question', old('question', $questions->question), ['class' => 'form-control', 'placeholder' => trans('questions::questions.form.question')]) !!}
	    {!! $errors->first('question', '<span class="help-block">:message</span>') !!}
	</div>

 <div class="row">
        <div class="col-md-6">
	<div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
        {!! Form::label("category_id", trans('category')) !!}
        {!! Form::select('category_id', $categories, $questions->category_id, ['class' => 'form-control']) !!}
        {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
    </div>
	</div>
</div>

 <div class="row">
         <div class="col-sm-10">
            <div class="form-group{{ $errors->has('Address') ? ' has-error' : '' }}">
                {!! Form::label('trend', trans('Is It trending')) !!}
                 &nbsp;&nbsp;
                &nbsp;&nbsp;
                {!! Form::label('trend', trans('Yes')) !!}
                {!! Form::radio('trend', 1,$questions->trend, ['class' => '']) !!}
                {!! $errors->first('trend', '<span class="help-block">:message</span>') !!}
                &nbsp;&nbsp;
                {!! Form::label('trend', trans('No')) !!}
                {!! Form::radio('trend', 0,!$questions->trend, ['class' => '']) !!}
                {!! $errors->first('trend', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
 <div class="row">
        <div class="col-md-6">
	<div class='form-group{{ $errors->has('answer_1') ? ' has-error' : '' }}'>
	    {!! Form::label('answer_1', trans('answer_1')) !!}
	    {!! Form::text('answer_1', old('answer_1', $questions->answer_1), ['class' => 'form-control', 'placeholder' => trans('questions::questions.form.answer_1')]) !!}
	    {!! $errors->first('answer_1', '<span class="help-block">:message</span>') !!}
	</div>
	</div>
	<div class="col-md-6">
		<label>total vote answer_1</label><p>1</p>
	</div>
	</div>
 <div class="row">
        <div class="col-md-6">
	<div class='form-group{{ $errors->has('answer_2') ? ' has-error' : '' }}'>
	    {!! Form::label('answer_2', trans('answer_2')) !!}
	    {!! Form::text('answer_2', old('answer_2', $questions->answer_2), ['class' => 'form-control', 'placeholder' => trans('questions::questions.form.answer_2')]) !!}
	    {!! $errors->first('answer_2', '<span class="help-block">:message</span>') !!}
	</div>
	</div>
	<div class="col-md-6">
	<label>total vote answer_2</label><p>2</p>
	</div>
	</div>
 <div class="row">
        <div class="col-md-6">
	<div class='form-group{{ $errors->has('answer_3') ? ' has-error' : '' }}'>
	    {!! Form::label('answer_3', trans('answer_3')) !!}
	    {!! Form::text('answer_3', old('answer_3', $questions->answer_3), ['class' => 'form-control', 'placeholder' => trans('questions::questions.form.answer_3')]) !!}
	    {!! $errors->first('answer_3', '<span class="help-block">:message</span>') !!}
	</div>
	</div>
	<div class="col-md-6">

		<label>total vote answer_3</label><p>3</p>
	</div>
	</div>
 <div class="row">
        <div class="col-md-6">
	<div class='form-group{{ $errors->has('answer_4') ? ' has-error' : '' }}'>
	    {!! Form::label('answer_4', trans('answer_4')) !!}
	    {!! Form::text('answer_4', old('answer_4', $questions->answer_4), ['class' => 'form-control', 'placeholder' => trans('questions::questions.form.answer_4')]) !!}
	    {!! $errors->first('answer_4', '<span class="help-block">:message</span>') !!}
	</div>
</div>
<div class="col-md-6">
<label>total vote answer_4</label><p>4</p>

</div>
</div>
 <div class="row">
        <div class="col-md-6">
	<div class='form-group{{ $errors->has('answer_5') ? ' has-error' : '' }}'>
	    {!! Form::label('answer_5', trans('answer_5')) !!}
	    {!! Form::text('answer_5', old('answer_5', 'None of the above'), ['class' => 'form-control', 'placeholder' => trans('questions::questions.form.answer_5'), 'readonly' => '']) !!}
	    {!! $errors->first('answer_5', '<span class="help-block">:message</span>') !!}
	</div>
	</div>
	<div class="col-md-6">
	<label>total vote answer_5</label><p>2</p>
	</div>
	</div>
	 <div class="row">
         <div class="col-sm-10">
            <div class="form-group{{ $errors->has('Address') ? ' has-error' : '' }}">
                {!! Form::label('status', trans('Status')) !!}
                 &nbsp;&nbsp;
                &nbsp;&nbsp;
                {!! Form::label('status', trans('Enable')) !!}
                {!! Form::radio('status', 1, $questions->status, ['class' => '']) !!}
                {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
                &nbsp;&nbsp;
                {!! Form::label('status', trans('disable')) !!}
                {!! Form::radio('status', 0,!$questions->status, ['class' => '']) !!}
                {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

</div>
