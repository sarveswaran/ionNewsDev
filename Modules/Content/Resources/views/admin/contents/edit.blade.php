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
    {!! Form::open(['route' => ['admin.content.content.update', $content->id], 'method' => 'put', 'onsubmit'=>'return formValidator()']) !!}
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
    $('.checkbox').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
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
                url: '{{ env('APP_URL') }}/content/users?id=<?php echo $content->id;?>',
                success: function(result) {
                    var checked_result=result.check;

                    var uncheck_result=result.uncheck;
                    
                    console.log(checked_result);
                    $("#user_info").empty();
                    var table = "";
                    var i = 1;
                   $.each(checked_result, function (key, value) {
                                                      
             table+='<tr id="'+value.id+'"><td> <input class="checkbox" type="checkbox" name="check[]" value="'+value.id+'" checked></td>'+
                              '<td>'+value.name+'</td>'+
                  '<td>'+value.id+'</td>';
                            i++;

                        });
                    $.each(uncheck_result, function (key, value) {
                                                      
             table+='<tr id="'+value.id+'"><td> <input class="checkbox" type="checkbox" name="check[]" value="'+value.id+'"></td>'+
                              '<td>'+value.name+'</td>'+
                  '<td>'+value.id+'</td>';
                            i++;

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







        function addRow(tableID) {

            var table = document.getElementById(tableID);

            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);

            var cell1 = row.insertCell(0);
            var element1 = document.createElement("input");
            element1.type = "checkbox";
            element1.name="chkbox[]";
            cell1.appendChild(element1);

            var cell2 = row.insertCell(1);
            cell2.innerHTML = rowCount + 1;

            var cell3 = row.insertCell(2);
            var element2 = document.createElement("input");
            element2.type = "file";
            element2.onchange = "readURL(this)"
            element2.id = "blah2";
            element2.name = "filebox[]";
            cell3.appendChild(element2);

            var cell4 = row.insertCell(3);
            var element3 = document.createElement("img");
            element3.src = "#";
            element3.alt = "Image preview";
            element3.name = "imges[]";
            cell4.appendChild(element3);

            var cell4 = row.insertCell(4);
            var element4 = document.createElement("textarea");
            element4.name = "textarea";
            cell4.appendChild(element4);


        }

        function deleteRow(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;

            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }

            }
            }catch(e) {
                alert(e);
            }
        }
   </script>
  
@stop
