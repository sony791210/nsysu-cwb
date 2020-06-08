@extends('layouts.admin.main')

@section('content')
    <div class="account-manage margin-bottom-20">
        <div class="bar">
            <div class="bar-left">
                <h3 class="bar-title">@lang('admin/nav.contact')</h3>
            </div>
        </div>

        <table-list :fields="fields" :table-data="list"
                    :show-edit="false" @on-edit="edit"
                    :show-operate="false">
        </table-list>
    </div>
@endsection

@section('script')
    <script>

        var fields = {!! $fields !!};
        var list = {!! $list !!};
        var app = new Vue({
            el: '#app',
            data: {
                fields: fields,
                list: list,
                form: {
                    name: '',
                    displayName: '',
                    email: ''
                }
            },
            methods: {
                onHref(url) {
                    location.href = url;
                },
                edit(row) {
                    location.href = row.editUrl;
                },
                resetForm() {
                    this.form = {
                        name: '',
                        displayName: '',
                        email: ''
                    };
                },
            }
        });
    </script>
@endsection
