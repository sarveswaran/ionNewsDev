<div class="box-body">
    <div class="box-body">
      <div class="row">
         <div class="col-sm-12">
            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                {!! Form::label('title', trans('Title')) !!}
                {!! Form::text('title', $content->title, ['class' => 'form-control', 'placeholder' => trans('user::users.form.first-name')]) !!}
                {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
       <!--  <div class="col-sm-12">
            <div class="form-group{{ $errors->has('crawl_url') ? ' has-error' : '' }}">
                {!! Form::label('Crawl url', trans('crawl url')) !!}
                {!! Form::text('crawl_url', $content->crawl_url, ['class' => 'form-control', 'placeholder' => trans('crawl url'),'readonly' => 'true']) !!}
                {!! $errors->first('crawl_url', '<span class="help-block">:message</span>') !!}
            </div>
        </div> -->
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('sub_title') ? ' has-error' : '' }}">
                {!! Form::label('sub_title', trans('Subtitle')) !!}
                {!! Form::text('sub_title', $content->sub_title, ['class' => 'form-control', 'placeholder' => trans('sub_title')]) !!}
                {!! $errors->first('sub_title', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
              <div class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">
                  {!! Form::label('category_id', trans('Service Provider Name')) !!}
                  <select class="form-control" name="category_id">
                      <?php foreach ($categories as $category): ?>
                          <option value="{{ $category->id }}" <?php if($category->id == $content->category_id) echo "selected"; else echo '';?> >{{ $category->name }}</option>
                      <?php endforeach; ?>
                  </select>
              </div>
          </div>

        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                {!! Form::label('email', trans('Story content')) !!}
                {!! Form::textarea('content', $content->content, ['class' => 'form-control', 'placeholder' => trans('user::users.form.email')]) !!}
                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
       </div>
      <div class="row">
        
            <div class="col-sm-4">
                <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                    {!! Form::label('image', trans('Image')) !!}
                    {!! Form::file('img', old('img'), ['class' => 'form-control', 'placeholder' => trans('image')]) !!}
                    {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
                    <img src="{{ $content->image }}" width="120">
                </div>
            </div>
      </div>
          
     <div class="form-group user-types">
           <table class=" data-table table table-bordered table-hover dataTable" id="User_data" role="grid" aria-describedby="DataTables_Table_0_info">
           <thead>
               <tr>
                  <th><input type="checkbox"  id="select_all" value=0 name="che" />Select</th>
                  <th>Name</th>
                  <th>User_id </th>
              </tr>  
              </thead>
              <tbody id = "user_info">  
         
                </tbody>
               </tbody> 
           </table>      
      </div>
	    </div>
    
      

    </div>
</div>
