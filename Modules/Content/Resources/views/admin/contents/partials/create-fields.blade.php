<div class="box-body">
  <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', trans('URL Address')) !!}
                {!! Form::text('crawl_url', old('crawl_url'), ['class' => 'form-control','data-slug' => 'source', 'placeholder' => trans('URL to fetch content')]) !!}
                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
        <label></label><br>
        <input  type="button" class="btn btn-primary btn-flat" value="Crawl Content" onclick="crawl()" />
        </div>
    </div>

      <div class="row">
         <div class="col-sm-12">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', trans('Title')) !!}
                {!! Form::text('title', old('title'), ['class' => 'form-control','id' =>'title',  'placeholder' => trans('Story title')]) !!}
                {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('sub_title') ? ' has-error' : '' }}">
                {!! Form::label('sub_title', trans('Subtitle')) !!}
                {!! Form::text('sub_title', old('sub_title'), ['class' => 'form-control','id' =>'sub_title', 'placeholder' => trans('subtitle')]) !!}
                {!! $errors->first('sub_title', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
          <div class="col-sm-6">
              <div class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">
                  {!! Form::label('category_id', trans('Category')) !!}
                  <select class="form-control" name="category_id">
                      <?php foreach ($categories as $category): ?>
                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                      <?php endforeach; ?>
                  </select>
              </div>
          </div>
    
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                {!! Form::label('content', trans('Story content')) !!}
                {!! Form::textarea('content', old('content'), ['class' => 'form-control','id' =>'content','placeholder' => trans('Story content')]) !!}
                {!! $errors->first('content', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
       </div>
      <div class="row">
     	<div class="form-group box-body">
	        <input  type="button" class="btn btn-primary btn-flat" value="Add Image" onclick="addRow('dataTable')" />
	        <input type="button" class="btn btn-danger btn-flat" value="Delete Image" onclick="deleteRow('dataTable')" />
	        <table id="dataTable" width="350px" border="1" class="imgtable" style="width: 100%;border: 4px solid #ecf0f5;">
                <thead>

                <tr>
	                <th></th>
	                <th>SL.no</th>
	                <th>Upload</th>
	                <th>Preview</th>
	                {{--<th>Image Description</th>--}}
	            </tr>
                </thead>
                <tbody id="syndata">
                </tbody>
	            {{--<tr>--}}
	                {{--<td><input  type="checkbox" name="chk"/></td>--}}
	                {{--<td> 1 </td>--}}
	                {{--<td class="filechoose"><input type='file' name="filebox['imgae'][]" onchange="readURL(this);" value=""></td>--}}
	                {{--<td><img id="blah" src="#" alt="Image preview" width="60" /></td>--}}
	                {{--<td><textarea name="filebox['description'][]"></textarea></td>--}}
	            {{--</tr>--}}
	        </table>
	    </div>
       </div>
    </div>
