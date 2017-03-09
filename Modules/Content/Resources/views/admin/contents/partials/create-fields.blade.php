<div class="box-body">
      <div class="row">
         <div class="col-sm-12">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', trans('Title')) !!}
                {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => trans('Story title')]) !!}
                {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('sub_title') ? ' has-error' : '' }}">
                {!! Form::label('sub_title', trans('Subtitle')) !!}
                {!! Form::text('sub_title', old('sub_title'), ['class' => 'form-control', 'placeholder' => trans('subtitle')]) !!}
                {!! $errors->first('sub_title', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                {!! Form::label('content', trans('Story content')) !!}
                {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'placeholder' => trans('Story content')]) !!}
                {!! $errors->first('content', '<span class="help-block">:message</span>') !!}
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
