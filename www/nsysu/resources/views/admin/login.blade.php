<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="高雄阿蓮天聖宮"/>

    <title>@lang('admin/common.system')</title>

    <link href="{{ mix('css/admin/app.css') }}" media="all" rel="stylesheet" type="text/css"/>
</head>
<body class="bg-light">
<div class="container login-page" id="app">
    <div class="card card-login mx-auto" v-cloak>
        <div class="card-header text-center">
            <h4><b>@lang('admin/common.system')</b></h4>
        </div>
        <div class="card-body">
            <form id="login-form" action="{{ route('signIn') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="Account">@lang('admin/login.account')</label>
                    <input class="form-control" id="Account" name="account" v-model='login.account'
                           aria-describedby="emailHelp"
                           placeholder="{{ trans('admin/common.input') . trans('admin/login.account') }}">
                </div>
                <div class="form-group">
                    <label for="Password">@lang('admin/login.password')</label>
                    <input class="form-control" id="Password" type="password" name="password"
                           v-model='login.password'
                           placeholder="{{ trans('admin/common.input') . trans('admin/login.password') }}">
                </div>
                <button type="submit"
                        class="btn btn-primary btn-block login-btn">@lang('admin/common.login')
                </button>
            </form>
        </div>
    </div>
</div>

<script src="{{ mix('js/admin/app.js') }}"></script>

<script>
    var app = new Vue({
        el: '#app',
        beforeMount() {
            @if ($errors->any())
                    @foreach ($errors->all() as $error)
                this.$message.error('{{ $error }}');
            @endforeach
            @endif
        },
        data() {
            return {
                login: {
                    password: '',
                    account: ''
                },
                account: "",
                loading: false
            }
        },
        methods: {}
    });
</script>
</body>
</html>
