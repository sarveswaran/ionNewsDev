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
    {!! Form::open(['route' => ['admin.content.content.store'], 'method' => 'post','enctype' => 'multipart/form-data']) !!}
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
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
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
             $.ajax({
                type: 'GET',
                data: {url: urls},
                url: '/backend/content/contents/ajaxcall',
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
                            if (counter == 5)
                                return false;
                            if (value.desc != null) {
                                counter++;
                                $('#content').append(value.desc + '   <br>');
                            }
                            table+='<tr><td style="text-align: center;"><input  type="radio" name="chk"/></td>'+
                                    '<td><img id="blah" src="'+value.img_url+'" alt="'+value.img_name+'" width="60" /></td></tr>';
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
    
        }

    </script>
@stop
