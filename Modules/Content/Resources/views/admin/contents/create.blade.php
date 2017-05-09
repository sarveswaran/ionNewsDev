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
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.content.content.index') ?>" }
                ]
            });

        });
    </script>
<!--          <script type="text/javascript">
    $(function () {
        $('#datetimepicker6').datetimepicker();
        $('#datetimepicker7').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });
    });
</script> -->
    <script>
        $( document ).ready(function() {
          $(".user-types").hide();
          $(".img-info").hide();


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

        var optionSet2 = {
          singleDatePicker:true
        }

        var cb = function(start, end, label) {
            $('#returnrange span').html(start.format('MMMM D, YYYY'));
            a=start.format('YYYY-MM-DD');
            b=end.format('YYYY-MM-DD');
            $('#expiry_date').val(b);
        };

        cb(moment(), moment(), "Last Month");
        $('#returnrange').daterangepicker(optionSet2,cb);
        $('#returnrange').val(daterangepicker);
        $('#expiry_date').val(b);
            var results='';
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
         if(checkedArray.length==0){
          alert("Select atleast one user.");
          return false;
         }
         $("#userListing").append("<input type='hidden' name='checkedDetails[]' value='"+JSON.stringify(checkedArray)+"'/>");
         return true;
    }


      checkedArray = [];

      $("#select_all").change(function(){   
    
       var status = this.checked; 
       if(status){
      $('.checkbox').each(function(){ 

        this.checked = status; 
        checkedArray.push(this.value);  
        //console.log(checkedArray);     
        
       });
    }else { $('.checkbox').each(function(){ 
      this.checked = status; 
      var a = checkedArray.indexOf(this.value);
    checkedArray.splice(a, 1);
     // console.log(checkedArray);
  });

    }

   
      });

  
function changed(event){
  if(event.checked){
    checkedArray.push(event.value);
  }else{
    var a = checkedArray.indexOf(event.value);
    checkedArray.splice(a, 1);
  }
  console.log(checkedArray);
}

          var results='';
        function addRow(tableID) {
               if(results!='') {
                   var table = document.getElementById(tableID);

                   var rowCount = table.rows.length;
                   if (rowCount == results.count-1)
                       alert('All Images are Showing Successfully');
                   else {
                       var row = table.insertRow(rowCount);
                       var cell1 = row.insertCell(0);
                       var element1 = document.createElement("input");
                       element1.type = "checkbox";
                       element1.name = "chkbox[]";
                       cell1.appendChild(element1);

                       // var cell2 = row.insertCell(1);
                       // cell2.innerHTML = rowCount;



                       // var cell3 = row.insertCell(2);
                       // var element2 = document.createElement("input");
                       // element2.type = "file";
                       // element2.onchange = "readURL(this)";
                       // element2.id = "blah2";
                       // element2.name = "filebox['imgae'][]";
                       // cell3.appendChild(element2);

                       var cell3 = row.insertCell(2);
                       var element2 = document.createElement("img");
                       element2.src = results[rowCount-1]['img_url'];
                       element2.alt = results[rowCount-1]['img_name'];
                       element2.name = "imges[]";
                       cell3.appendChild(element2);

//                   var cell4 = row.insertCell(4);
//                   var element4 = document.createElement("textarea");
//                   element4.name ="filebox['imgae'][]";
////                   element4.text(results[rowCount]['desc']);
////                   $(".desc").val(results[rowCount]['desc']);
//                   cell4.appendChild(element4);
                   }
               }else alert('You have not mention Url Address');
//                }});


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
        function crawl() {
             var urls=$(".form-control").val();
             $(".user-types").show();
             $(".img-info").show();


            // var APP_URLs = '{{ env('APP_URL') }}';              
             if(!urls)
             {
              alert ("You have not mention Url Address");
               return false;
             }
                $.ajax({
                type: 'GET',
                data: {url: urls},
                url: '{{ env('APP_URL') }}/contents/ajaxcall',
                success: function(result) {
                    results = result;
                    $('#sub_title').val(result.sub_title);
                    $('#title').val(result.title);

                    $("#syndata").empty();
                    var table = "";
                    var i = 1;
                    var counter = 0;
                    if (result.status == 200)
                    {
                        $.each(result, function (key, value) {
                            if (counter == 5 || i==5)
                                return false;
                            if (value.desc != null) {
                                counter++;
                                $('#content').append(value.desc + '   <br>');
                              }
                            
                            table+='<tr><td style="text-align: center;"><input  type="radio" name="image" value ="'+value.img_url+'"/></td>'+
                                    '<td><img id="blah" name="" src="'+value.img_url+'" alt="'+value.img_name+'" width="100" /><input type="hidden" name="img'+i+'" value="'+value.img_url+'" style="opacity: 0;"/></td></tr>';
                            i++;

                        });
                        $("#syndata").html(table);
                }else {
                      alert("No img are found in this given URL");
                    }
                },
                error: function(xhr, desc, err) {
                    console.log(xhr);
                }
            });

                          

             $.ajax({
                type: 'GET',
                url: '{{ env('APP_URL') }}/users',
                success: function(result) {
                    $("#user_info").empty();
                    var table = "";
                    var i = 1;
                   $.each(result, function (key, value) {
                                                      
             table+='<tr id="'+value.id+'"><td> <input class="checkbox" type="checkbox" onchange="changed(this);" name="check[]" value="'+value.id+'"></td>'+
                              '<td>'+value.name+'</td>'+
                  '<td>'+value.company+'</td><td>'+value.role+'</td></tr>';
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
                        "pageLength": 10,
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

        }


    </script>
@stop
