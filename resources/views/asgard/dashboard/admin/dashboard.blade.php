@extends('layouts.master')

@section('content-header')
    <h1 class="pull-left">
        Overview Details
    </h1>
    <div class="btn-group pull-right">
       <!--  <a class="btn btn-default" id="sum" data-mode="0" href="">Total <span>300</span></a>
        <a class="btn btn-default" id=-on" href="">On Duty <span>140</span></a> -->
        <a class="btn btn-default hidden" id="add-widget" data-toggle="modal" data-target="#myModal">{{ trans('dashboard::dashboard.add widget') }}</a>
    </div>
    <div class="clearfix"></div>
@stop

@section('styles')
    <style>
        .grid-stack-item {
            padding-right: 20px !important;
        }
    </style>
@stop

@section('content')
  <!--   <div class="row">
        <div class="col-xs-12">
            
            <div class="box box-primary">
                <div class="box-header">
                </div>
               
                <div class="box-body">
                    <div class="table-responsive">
                       
                        
                    </div>
                </div>
               
            </div>
        </div>
    </div> -->
    <style type="text/css">
        .griddash{
            height: 120px;
            background: #3c8dbc;
            /* padding: 29px; */
            margin: 10px;
        }
       .rowgap{
            margin-top: 40px;
            height: 120px;
       }
       .rowfirst{
            height: 120px;
       }
       .refname{
            text-align: center;
            top: 33px;
            /* margin-top: 11px; */
            margin: 0px;
            color: white;
            padding-top: 25px;
       }
       .refval{
            text-align: center;
            top: 2px;
            /* margin-top: 11px; */
            margin: 0px;
            color: white;
            padding-top: 10px;
       }
    </style>
    <!-- <div class="row rowfirst">
        <div class="col-md-3">
            <div class="grid-stack">
            <div class="griddash">
                <h3 class="refname">Total User</h3>
                <h3 class="refval">360</h3>
            </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="grid-stack">
             <div class="griddash">
                    <h3 class="refname">Total Questions</h3>
                    <h3 class="refval">350</h3>
                    </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="grid-stack">
             <div class="griddash">
              <h3 class="refname">Total Answers</h3>
              <h3 class="refval">10</h3>
              </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="grid-stack">
             <div class="griddash">
              <h3 class="refname">New Questions</h3>
              <h3 class="refval">10</h3>
              </div>
            </div>
        </div>
    </div> -->
   <!--      <div class="row rowgap">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                Recently Registered Customers
                </div>
              
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>{{ trans('Sl.No') }}</th>
                                <th>{{ trans('Name') }}</th>
                                <th data-sortable="false">{{ trans('Phone') }}</th>
                                 <th>{{ trans('Email') }}</th>
                                <th style="width: 35%;">{{ trans('Address') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>bharath</td>
                                <td>9743725012</td>
                                <td>bharath@gmail.com</td>
                                <td>Benanzy Apartments ,Hormavu Bangalore</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>sharath</td>
                                <td>9732725232</td>
                                <td>sharath@gmail.com</td>
                                <td>sanjays Apartments ,Hormavu Bangalore</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>anil</td>
                                <td>9323272501</td>
                                <td>Benanzy@gmail.com</td>
                                <td>sharath Apartments ,Hormavu Bangalore</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>naveen</td>
                                <td>9743725012</td>
                                <td>navee@gmail.com</td>
                                <td>naveen rores Apartments ,Hormavu Bangalore</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>sanjay</td>
                                <td>97443725012</td>
                                <td>sanjay@gmail.com</td>
                                <td>Benanzy Apartments ,Hormavu Bangalore</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>raghu</td>
                                <td>9223725552</td>
                                <td>raghu@gmail.com</td>
                                <td>treener Apartments ,Hormavu Bangalore</td>
                            </tr>
                            <?php if (isset($user_details)): ?>
                            <?php foreach ($user_details as $user_details): ?>
                            <tr>
                                <td>
                                    <a href="{{ route('admin.contact.user_details.edit', [$user_details->id]) }}">
                                        {{ $user_details->created_at }}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.contact.user_details.edit', [$user_details->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.contact.user_details.destroy', [$user_details->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                
                            </tfoot>
                        </table>
                     
                    </div>
                </div>
            
            </div>
        </div>
    </div> -->
     <div class="row rowgap">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                Recently Questions
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>{{ trans('Sl.No') }}</th>
                                <th>{{ trans('Question') }}</th>
                                <th data-sortable="false">{{ trans('Status') }}</th>
                                 <th>{{ trans('Date') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                         <?php if (isset($questions)): ?>
                            <?php foreach ($questions as $question): ?>
                           
                            <tr>
                                <td>{{ $question->id }}</td>
                                <td>{{ $question->question }}</td>
                                <?php if($question->status == 1){?>
                                <td>active</td>
                                <?php }else{?>
                                <td>Inactive</td>
                                <?php }?>
                                <td>{{ $question->created_at }}</td>
                                
                            </tr>
                         
                            
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('dashboard::dashboard.add widget to dashboard') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            var options = {
                vertical_margin: 10,
                float: true,
                animate: true
            };
            $('.grid-stack').gridstack(options);

            /** savey crap */
            new function () {
                this.defaultWidgets = {!! json_encode($widgets) !!};
                this.serialized_data = {!! $customWidgets !== 'null' ? $customWidgets : json_encode($widgets) !!};
                //console.log(this.defaultWidgets.PostsWidget);
                this.grid = jQuery('.grid-stack').data('gridstack');
                this.load_grid = function () {
                    this.grid.remove_all();
                    var items = GridStackUI.Utils.sort(this.serialized_data);
                    _.each(items, function (node) {
                        this.spawn_widget(node);
                        jQuery(jQuery.find('option[value="'+node.id+'"]')[0]).hide();
                    }, this);
                }.bind(this);
                this.save_grid = function () {
                    this.serialized_data = _.map($('.grid-stack > .grid-stack-item:visible'), function (el) {
                        el = jQuery(el);
                        var node = el.data('_gridstack_node');
                        return {
                            id: el.attr('id'),
                            x: node.x,
                            y: node.y,
                            width: node.width,
                            height: node.height
                        };
                    }, this);
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('dashboard.grid.save') }}',
                        data: {
                            _token: '<?= csrf_token() ?>',
                            grid: JSON.stringify(this.serialized_data)
                        },
                        success: function(data) {
                            console.log(data);
                        }
                    });
                }.bind(this);
                this.clear_grid = function () {
                    this.grid.remove_all();
                    jQuery(jQuery.find('option:hidden')).show();
                }.bind(this);
                this.edit_grid = function () {
                    mode = jQuery('#edit-grid').data('mode');
                    if (mode == 0) {
                        // enable all the grid editing
                        _.map(jQuery('.grid-stack > .grid-stack-item:visible'), function (el) {
                            this.grid.movable(el, true);
                            jQuery(el).on('dblclick', function (e) {
                                this.grid.resizable(el, true);
                            }.bind(this));
                        }, this);
                        jQuery('#edit-grid').data('mode', 1).text('{{ trans('dashboard::dashboard.save grid') }}');
                    } else {
                        // disable all the grid editing
                        _.map(jQuery('.grid-stack > .grid-stack-item:visible'), function (el) {
                            this.grid.movable(el, false);
                            this.grid.resizable(el, false);
                            jQuery(el).off('dblclick');
                        }, this);
                        jQuery('#edit-grid').data('mode', 0).text('{{ trans('dashboard::dashboard.edit grid') }}');
                        // run the save mech
                        this.save_grid();
                    }
                }.bind(this);
                this.spawn_widget = function (node) {
                    var html = node.html === undefined ? this.defaultWidgets[node.id].html : node.html,
                        element = jQuery('<div><div class="grid-stack-item-content" />' + html + '<div/>'),
                        x = node.options === undefined ? node.x : node.options.x,
                        y = node.options === undefined ? node.y : node.options.y,
                        width = node.options === undefined ? node.width : node.options.width,
                        height = node.options === undefined ? node.height : node.options.height;

                    this.grid.add_widget(element, x, y, width, height);

                    element.attr({id: node.id});
                    this.grid.resizable(element, false);
                    this.grid.movable(element, false);
                    return element;
                }.bind(this);
                jQuery('#edit-grid').on('click', this.edit_grid);
                jQuery('#myModal').on('hidden.bs.modal', function (e) {
                    value = jQuery('select[name=widget]').val();
                    if (value == 'x') {
                        return;
                    }
                    element = this.spawn_widget({
                        auto_position: true,
                        width: 2,
                        height: 2,
                        id: value
                    });
                    this.grid.resizable(element, true);
                    this.grid.movable(element, true);
                }.bind(this));
                this.load_grid();
            };

        });
    </script>
@stop
