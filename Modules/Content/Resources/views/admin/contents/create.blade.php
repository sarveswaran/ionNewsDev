@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('content::contents.title.create content') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.content.content.index') }}">{{ trans('content::contents.title.contents') }}</a></li>
        <li class="active">{{ trans('content::contents.title.create content') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')
    {!! Form::open(['route' => ['admin.content.content.store'], 'method' => 'post','enctype' => 'multipart/form-data', 'onsubmit'=>'return formValidator()', 'id' => 'userListing']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('content::admin.contents.partials.create-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat"  >{{ trans('core::core.button.create') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.content.content.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
           var all_users_info="";
          $(".user-types").hide();
          $(".img-info").hide();
          $(".custom_img").hide();
          dateRangePickerFunctions();

            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.content.content.index') ?>" }
                ]
            });

        });
    </script>
    <script language="javascript">
      checkedArray = [];
      var roles_data=[];
      var crawlUrl = '{{ env('APP_URL') }}/contents/ajaxcall';
      var userUrl = '{{ env('APP_URL') }}/users';
      var results=''; 
      var select_flag=0 
      var category_check=[];
      
      $("#select_all_page").on('click',function(){

        var check=roles_data.indexOf("-1");  

        dt.destroy();        
        $("#user_info").empty();
        var table = "";
        checkedArray=[];
        // console.log(all_users_info);
        if(select_flag==0)
        {   select_flag=1; 
          $( "#select_all" ).prop( "disabled", true );
         if(check==-1 && roles_data.length){

           $.each(roles_data, function (key, values) {          
          keys=all_users_roles[values]['type'].toLowerCase();
          // console.log(keys);
           
          if (typeof(all_users_info[keys]) != 'undefined') { 
          var data =all_users_info[keys]; 
          // console.log("hahhaha  "+data); 

          $.each(data ,function(key,new_users){  
          table+='<tr id="'+new_users.id+'"><td> <input class="checkbox" type="checkbox" onchange="changed(this);" name="check[]" value="'+new_users.id+'" checked></td>'+
                              '<td>'+new_users.name+'</td>'+
                  '<td>'+new_users.company+'</td><td>'+new_users.role+'</td></tr>'; 
                   checkedArray.push(new_users.id+"");
              // console.log(checkedArray);       
            });
            }
            });
         }else{
          
          $.each(all_users_info, function (key, values) {
          $.each(values, function(key,value){                     
              table+='<tr id="'+value.id+'"><td> <input class="checkbox" type="checkbox" onchange="changed(this);" name="check[]" value="'+value.id+'" checked></td>'+
              '<td>'+value.name+'</td>'+
              '<td>'+value.company+'</td><td>'+value.role+'</td></tr>';
              checkedArray.push(value.id+"");
              // console.log(checkedArray);   
            });
        });
      }
        }
        else { select_flag=0;
          $( "#select_all" ).prop( "disabled", false );
              checkedArray=[];
              // console.log(checkedArray);
              if(check==-1 && roles_data.length){

           $.each(roles_data, function (key, values) {          
          keys=all_users_roles[values]['type'].toLowerCase();
          // console.log(keys);
           
          if (typeof(all_users_info[keys]) != 'undefined') { 
          var data =all_users_info[keys]; 
          // console.log("hahhaha  "+data); 

          $.each(data ,function(key,new_users){  
          table+='<tr id="'+new_users.id+'"><td> <input class="checkbox" type="checkbox" onchange="changed(this);" name="check[]" value="'+new_users.id+'"></td>'+
                              '<td>'+new_users.name+'</td>'+
                  '<td>'+new_users.company+'</td><td>'+new_users.role+'</td></tr>'; 
                          
            });
            }
            });
         }
              else{
              $.each(all_users_info, function (key, values) {
              $.each(values, function(key,value){                    
                  table+='<tr id="'+value.id+'"><td> <input class="checkbox" type="checkbox" onchange="changed(this);" name="check[]" value="'+value.id+'"></td>'+
                  '<td>'+value.name+'</td>'+
                  '<td>'+value.company+'</td><td>'+value.role+'</td></tr>';
                });
            });
            }
            }
        $("#user_info").html(table);
        dataTableAssign(); 
      })

      $("#select_all").change(function(){ 
        var status = this.checked; 
        if(status){
        $('.checkbox').each(function(){ 
            this.checked = status; 
            checkedArray.push(this.value);  
            //console.log(checkedArray);    
          });
        }else { 
            $('.checkbox').each(function(){ 
            this.checked = status; 
            var a = checkedArray.indexOf(this.value);
            checkedArray.splice(a, 1);
            // console.log(checkedArray);
          });
          }
        });
    </script>
   
    <script type="text/javascript">
     user_roles='<?php echo json_encode($user_roles);?>';
     var all_users_roles=jQuery.parseJSON(user_roles);
    
      $( "select.user_group" ).change( changeorder );
          changeorder();


      function selectCategory(event)
      {   
          category_check=$("select").val();        
      }
    
     
</script>

  
@stop
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ Module::asset('content:js/content_create.js') }}?rv={{ env('RV') }}"></script>
<script type="text/javascript" src="{{ Module::asset('content:js/datepicker.js') }}?rv={{ env('RV') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $(".content-wrapper").css({"min-height":"100%"});
  })
</script>
