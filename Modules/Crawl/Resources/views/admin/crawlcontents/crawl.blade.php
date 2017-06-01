@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('Crawl Content') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.crawl.crawlcontent.index') }}">{{ trans('crawl::crawlcontents.title.crawlcontents') }}</a></li>
        <li class="active">{{ trans('crawl::crawlcontents.title.create crawlcontent') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')
    <div class="col-xs-12">
            <div class="row">
                 <div class="btn-group pull-left" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.content.content.index') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-arrow-left"></i> {{ trans('Back') }}
                    </a>
                </div>
        </div>
    </div>
    {!! Form::open(['route' => ['admin.crawl.crawlcontent.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                          <div class="box-body">
                        
                                <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    {!! Form::label('name', trans('URL Address')) !!}
                                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('URL to fetch content')]) !!}
                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                
                        </div>
                        
                        </div>
                        </div>
                    @endforeach

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('Crawl Content') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.crawl.crawlcontent.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
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
                    { key: 'b', route: "<?= route('admin.crawl.crawlcontent.index') ?>" }
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
@stop
