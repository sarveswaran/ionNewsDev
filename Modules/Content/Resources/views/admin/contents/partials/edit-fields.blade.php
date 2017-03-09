<div class="box-body">
    <div class="box-body">
      <div class="row">
         <div class="col-sm-12">
            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                {!! Form::label('first_name', trans('Title')) !!}
                {!! Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => trans('user::users.form.first-name')]) !!}
                {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                {!! Form::label('last_name', trans('Subtitle')) !!}
                {!! Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => trans('user::users.form.last-name')]) !!}
                {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                {!! Form::label('email', trans('Story content')) !!}
                {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'placeholder' => trans('user::users.form.email')]) !!}
                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
       </div>
      <div class="row">
     	<div class="form-group box-body">
	        <input name="" type="button" class="btn btn-primary btn-flat" value="Add Image" onclick="addRow('dataTable')" />
	        <input type="button" class="btn btn-danger btn-flat" value="Delete Image" onclick="deleteRow('dataTable')" />
	        <table id="dataTable" width="350px" border="1" class="imgtable" style="width: 100%;border: 4px solid #ecf0f5;">
	            <tr>
	                <th></th>
	                <th>SL.no</th>
	                <th>Upload</th>
	                <th>Preview</th>
	                <th>Image Description</th>
	            </tr>
	            <tr>
	                <td><input  type="checkbox" name="chk"/></td>
	                <td> 1 </td>
	                <td class="filechoose"><input type='file' name="filebox[]" onchange="readURL(this);"/ value=""></td>
	                <td><img id="blah" src="#" alt="Image preview" /></td>
	                <td><textarea name=""></textarea></td>
	            </tr>
	        </table>
	    </div>
       </div>
    </div>
</div>
