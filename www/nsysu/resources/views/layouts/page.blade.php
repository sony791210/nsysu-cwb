<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=5>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="author" content="高雄阿蓮天聖宮"/>

        <title>@lang('admin/common.system')</title>

        <link href="{{ mix('css/admin/app.css') }}" media="all" rel="stylesheet" type="text/css" />

        @yield('css')

        <script>
            var siteUrl = "{{ url('/') }}";
            var csrfToken = "{{ csrf_token() }}";
            var CKEDITOR_BASEPATH = '/js/ckeditor/';
        </script>
    </head>
    <body id="page-top">
        <div id="app">
            @yield('content')
        </div>

        <script src="{{ mix('js/admin/app.js') }}"></script>
        <script src="{{ mix('js/date_helper.js') }}"></script>
        <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>

        @yield('script')

        <!-- Error-->
        @include('layouts.admin._error')
        <!-- END Error-->
    </body>
</html>
