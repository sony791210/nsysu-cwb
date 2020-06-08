@extends('layouts.admin.main')

@section('content')
    <div class="account-manage margin-bottom-20">
        <div class="bar">
            <div class="bar-left">
                <h3 class="bar-title">@lang('admin/nav.accountManage')</h3>
            </div>
            <div class="bar-right">
                <el-button @click="onHref('{{ route('employee.new') }}')">@lang('admin/common.add')帳號</el-button>
            </div>
        </div>

        <table-list :fields="fields" :table-data="list"
                    :show-edit="true" @on-edit="edit"
                    :show-operate="true">
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
                onSearch() {
                    var self = this;
                    self.list = [];

                    if (this.form.name || this.form.displayName || this.form.email) {
                        axios.post(siteUrl + '/ajax/employee/search', self.form)
                            .then((res) => {
                                var content = res.data;

                                if (content.code === '00000') {
                                    self.list = content.data.list;
                                }
                            });
                    } else {
                        self.list = list;
                    }

                    return false;
                }
            }
        });
    </script>
@endsection
