@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('content::contents.title.edit content') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.content.content.index') }}">{{ trans('content::contents.title.contents') }}</a></li>
        <li class="active">{{ trans('content::contents.title.edit content') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')
    {!! Form::open(['route' => ['admin.content.content.update', $content->id], 'method' => 'put','enctype' => 'multipart/form-data' ,'onsubmit'=>'return formValidator()']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('content::admin.contents.partials.edit-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
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
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.content.content.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
           
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>
        <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
      <script type="text/javascript">
       var checked_result;
       var uncheck_result;
        var a;
        var b;
        var optionSet1 = {
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            minDate: '01/01/2012',
            maxDate: moment(),
            dateLimit: { days: 300},
            showDropdowns: true,
            showWeekNumbers: true,
            autoApply: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            ranges: {
                'Today': [moment(), moment()],
            },
            opens: 'right',
            format: 'MM/DD/YYYY',
            separator: ' to ',
            locale: {
                applyLabel: 'Submit',
                cancelLabel: 'Clear',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        };
  var datetime="<?php echo ($content->expiry_date != "0000-00-00")?$content->expiry_date:date('Y-m-d'); ?>";


          var optionSet2 = {
          singleDatePicker:true,
          startDate:moment.utc(Date.parse(datetime)),
          endDate: moment.utc(Date.parse(datetime))
        }
        var cb = function(start, end, label) {
            $('#returnrange span').html(start.format('MMMM D, YYYY'));
            a=start.format('YYYY-MM-DD');
            b=end.format('YYYY-MM-DD');            
            $('#expiry_date').val(b);
        };
        cb(moment.utc(Date.parse(datetime)), moment.utc(Date.parse(datetime)), "Last Month");
        $('#returnrange').daterangepicker(optionSet2,cb);        
        $('#returnrange').val(daterangepicker);
        $('#expiry_date').val(b);
  </script>
  <script>
   function previewFile(){
    
       var preview = document.querySelector('img'); //selects the query named img
       var file    = document.querySelector('input[type=file]').files[0]; //sames as here
       var reader  = new FileReader();

       reader.onloadend = function () {
           preview.src = reader.result;
       }

       if (file) {
           reader.readAsDataURL(file); //reads the data as a URL
       } else {
           preview.src = "";
       }
  }

  // previewFile();  //calls the function named previewFile()
  </script>
    <script language="javascript">    
    var form_checker=0;

     function formValidator() {
         $('.checkbox').each(function(){ //iterate all listed checkbox items
            if(this.checked)
            {
              form_checker=1;
            }
        
       
    });
            if(form_checker==1)
            return true;
           else{ alert("Please Add Atleast One User");
            return false;
          }
    }

    $("#select_all").change(function(){
    var status = this.checked;    
    if(status){
        $("#select_all").val(1);
    }
     else $("#select_all").val(0);
    $('.checkbox').each(function(){ 
        this.checked = status; 
    });
   
});
$('.checkbox').change(function(){ //".checkbox" change
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){ //if this item is unchecked
        $("#select_all")[0].checked = false; //change "select all" checked status to false
    }
   
    //check "select all" if all checkbox items are checked
    if ($('.checkbox:checked').length == $('.checkbox').length ){
        $("#select_all")[0].checked = true; //change "select all" checked status to true
    }
});
     
            $.ajax({
                type: 'GET',
                url: '{{ env('APP_URL') }}/users?id=<?php echo $content->id;?>',
                success: function(result) {
                    checked_result=result.check;
                    uncheck_result=result.uncheck;   

                    $("#user_info").empty();
                    var table = "";
                    var i = 1;
                   $.each(checked_result, function (key, values) {
                    $.each(values, function(key,value)
                    {
                                                      
             table+='<tr id="'+value.id+'"><td> <input class="checkbox" type="checkbox" name="check[]" value="'+value.id+'" checked></td>'+
                              '<td>'+value.name+'</td>'+
                  '<td>'+value.company+'</td><td>'+value.role+'</td></tr>';
                            i++;

                        });
                });
                    $.each(uncheck_result, function (key, values) {
                    $.each(values, function(key,value){
                                                      
             table+='<tr id="'+value.id+'"><td> <input class="checkbox" type="checkbox" name="check[]" value="'+value.id+'"></td>'+
                              '<td>'+value.name+'</td>'+
                  '<td>'+value.company+'</td><td>'+value.role+'</td></tr>';
                            i++;

                        });
                       });

                        $("#user_info").html(table);

                        $("#User_data").DataTable({
                        "initComplete": function( settings, json ) {
                            $('.dataTables_filter').find('input[typcd e=search]').attr('type','text');
                        },
                        "bPaginate": true,
                        "bautoWidth": true,
                        "pagingType": "full_numbers",
                        "pageLength": 25,
                        "lengthMenu": [10, 25, 50, 100],
                        "dom": 'T<"clear">lfrtip',
                        "initComplete": function( settings, json ) {
                            $('.dataTables_filter').find('input[type=search]').attr('type','text');
                        },
                        tableTools: {
                            "sSwfPath":"http://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf",
                            aButtons: ['csv']
                        }
                    });



              
                },
                error: function(xhr, desc, err) {
                    console.log(xhr);}

                
              });       
   </script>

<script type="text/javascript">
      var user_roles='<?php echo json_encode($user_roles);?>';
      var all_users_roles=jQuery.parseJSON(user_roles);    
      function changeorder()
      { 
       var roles_data=$( this ).val();
       var check=roles_data.indexOf("-1");            
        $("#user_info").empty();
        var table = "";
         if(check==-1){
            $.each(roles_data, function (key, values) {          
            keys=all_users_roles[values]['type'].toLowerCase();           
            if (typeof(checked_result[keys]) != 'undefined') {
            var checked_data =checked_result[keys];               
            $.each(checked_data ,function(key,new_users){  
            table+='<tr id="'+new_users.id+'"><td> <input class="checkbox" type="checkbox" name="check[]" value="'+new_users.id+'" checked></td>'+
                              '<td>'+new_users.name+'</td>'+
                  '<td>'+new_users.company+'</td><td>'+new_users.role+'</td></tr>';   
            });
            }  

          if (typeof(uncheck_result[keys]) != 'undefined') {                 
            var unchecked_data =uncheck_result[keys]; 
            $.each(unchecked_data ,function(key,new_users){  
            table+='<tr id="'+new_users.id+'"><td> <input class="checkbox" type="checkbox" onchange="changed(this);" name="check[]" value="'+new_users.id+'"></td>'+
                              '<td>'+new_users.name+'</td>'+
                  '<td>'+new_users.company+'</td><td>'+new_users.role+'</td></tr>';     
            });
            }           
            });
         }
          else{
            $.each(checked_result, function (key, values) {
            $.each(values, function(key,value){                                     
            table+='<tr id="'+value.id+'"><td> <input class="checkbox" type="checkbox" name="check[]" value="'+value.id+'" checked></td>'+
                              '<td>'+value.name+'</td>'+
                  '<td>'+value.company+'</td><td>'+value.role+'</td></tr>';
            });
            });
            $.each(uncheck_result, function (key, values) {
            $.each(values, function(key,value){
            table+='<tr id="'+value.id+'"><td> <input class="checkbox" type="checkbox" name="check[]" value="'+value.id+'"></td>'+
                              '<td>'+value.name+'</td>'+
                  '<td>'+value.company+'</td><td>'+value.role+'</td></tr>';
            });
            });
            }                      
            $("#user_info").html(table);          
         }
        $( "select.user_group" ).change( changeorder );
         changeorder();
    </script>
@stop
