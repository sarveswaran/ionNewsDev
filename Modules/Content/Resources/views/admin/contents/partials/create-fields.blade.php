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
                {!! Form::label('sub_titzle', trans('Subtitle')) !!}
                {!! Form::text('sub_title', old('sub_title'), ['class' => 'form-control','id' =>'sub_title', 'placeholder' => trans('subtitle')]) !!}
                {!! $errors->first('sub_title', '<span class="help-block">:message</span>') !!}
            </div>
        </div>


         <div class="tab-pane" id="tab_2-2">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  {!! Form::label('category_id', trans('Category')) !!}
                                    <select multiple="" class="form-control" name="category_id[]">
                                        <?php foreach ($categories as $category): ?>
                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                      <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


    <!-- <div class="col-sm-12"> -->
     <!-- <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}"> -->
      <!-- {!! Form::label('content', trans('Select Expiry Date')) !!} -->
<!--     <label class="pull-left">Select Expiry Date</label>
    <input type="text" name="date" id="returnrange"  style="margin-left:20px;background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc" value="" class="glyphicon glyphicon-calendar fa fa-calendar">
        <span></span><b class="caret"></b>
    </div> -->

       <div class="col-sm-12">
        <label class="pull-left">Select Date</label>
        <div id="returnrange" class="pull-left" style="margin-left:20px;background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
        <input type="hidden" name="expiry_date" id="expiry_date"  value="" >
        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
        <span></span><b class="caret"></b>
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
     	<div class="form-group box-body img-info">
	        <!-- <input  type="hidden" class="btn btn-primary btn-flat" value="Add Image" onclick="addRow('dataTable')" /> -->
	        <!-- <input type="hidden" class="btn btn-danger btn-flat" value="Delete Image" onclick="deleteRow('dataTable')" /> -->
	        <table id="dataTable" width="350px" border="1" class="imgtable" style="width: 100%;border: 4px solid #ecf0f5;">
                <thead>

                <tr>
	                <th>select</th>
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
      <div class="form-group user-types">


           <table class=" data-table table table-bordered table-hover dataTable" id="User_data" role="grid" aria-describedby="DataTables_Table_0_info" >
           <thead>
               <tr>
                  <th><input type="checkbox"  id="select_all"/>Select</th>
                  <th>Name</th>
                  <th>Company Name </th>
                  <th>Designation</th>
              </tr>  
              </thead>
              <tbody id = "user_info">  
         
                </tbody>
               </tbody> 
           </table>      
      </div>
    </div>
    </div>
