<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        
        <title>NSYSU</title>

        <link href="{{ mix('css/pages/app.css') }}" media="all" rel="stylesheet" type="text/css" />
        @yield('css')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://unpkg.com/vue"></script>
        <script src="//www.amcharts.com/lib/3/amcharts.js"></script>
        <script src="//www.amcharts.com/lib/3/pie.js"></script>
        <script>
            var siteUrl = "{{ url('/') }}";
            var CKEDITOR_BASEPATH = '/js/ckeditor/';
        </script>
    </head>
    <body id="page-top">
        <div id="app"></div>
        <script src="{{ mix('js/pages/app.js') }}"></script>
        <script type="text/javascript" src="https://code.jscharting.com/latest/modules/types.js"></script> 
    </body>
</html>

