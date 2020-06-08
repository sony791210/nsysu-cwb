@extends('layouts.admin.main')

@section('content')
    <div class="bar">
        <div class="bar-left">
            <h3 class="bar-title">@lang('admin/common.add')帳號</h3>
        </div>
        <div class="bar-right"></div>
    </div>
    <div class="page-form">
        <el-form ref="form" :model="form" label-width="100px">
            <el-form-item label="{{ trans('admin/employee.name') }}" prop="name" :rules="rules.name">
                <el-input v-model="form.name"></el-input>
            </el-form-item>

            <el-form-item label="{{ trans('admin/employee.displayName') }}" prop="displayName"
                          :rules="rules.displayName">
                <el-input v-model="form.displayName"></el-input>
            </el-form-item>

            <el-form-item label="{{ trans('admin/employee.email') }}" prop="email" :rules="rules.email">
                <el-input type="email" v-model="form.email" auto-complete="off"></el-input>
            </el-form-item>

            <el-form-item label="">
                <hr class="my-10">
            </el-form-item>

            <el-form-item label="{{ trans('admin/employee.password') }}" prop="password" :rules="rules.password">
                <el-input type="password" v-model="form.password" auto-complete="off" required></el-input>
            </el-form-item>

            <el-form-item label="{{ trans('admin/employee.checkPassword') }}" prop="checkPassword"
                          :rules="rules.checkPassword">
                <el-input type="password" v-model="form.checkPassword" auto-complete="off" required></el-input>
            </el-form-item>

            <el-form-item label="">
                <hr class="my-10">
            </el-form-item>

            <el-form-item label="{{ trans('admin/employee.role') }}">
                <el-transfer v-model="form.role" :data="role"
                             :titles="['{{ trans('admin/common.list') }}', '{{ trans('admin/common.selectList') }}']"></el-transfer>
            </el-form-item>

            <el-form-item label="">
                <hr class="my-10">
            </el-form-item>

            <el-form-item label="{{ trans('admin/employee.status') }}">
                <el-switch v-model="form.status" active-color="#13ce66" inactive-color="#a2a2a2">
                </el-switch>
            </el-form-item>
        </el-form>
    </div>
    <div class="text-center margin-bottom-20">
        <el-button type="primary" @click="onSubmit('form')">@lang('admin/common.add')</el-button>
        <el-button @click="onHref('{{ route('employee.index') }}')">@lang('admin/common.cancal')</el-button>
    </div>
@endsection

@section('script')
    <script>
        var role = {!! $role !!};

        var app = new Vue({
            el: '#app',
            data() {
                var validatePassword = (rule, value, callback) => {
                    if (value) {
                        if (value !== this.form.checkPassword) {
                            callback(new Error("{{ trans('admin/employee.validator.samePassword') }}"));
                        }
                    }

                    callback();
                };

                var validateCkPassword = (rule, value, callback) => {
                    if (value) {
                        if (value !== this.form.password) {
                            callback(new Error("{{ trans('admin/employee.validator.samePassword') }}"));
                        }
                    }

                    callback();
                };

                return {
                    form: {
                        name: '',
                        displayName: '',
                        email: '',
                        password: '',
                        checkPassword: '',
                        status: false,
                        role: []
                    },
                    rules: {
                        name: [
                            {
                                required: true,
                                message: "{{ trans('validation.required', ['attribute' => trans('admin/employee.name')]) }}"
                            }
                        ],
                        displayName: [
                            {
                                required: true,
                                message: "{{ trans('validation.required', ['attribute' => trans('admin/employee.displayName')]) }}"
                            }
                        ],
                        email: [
                            {
                                required: true,
                                message: "{{ trans('validation.required', ['attribute' => trans('admin/employee.email')]) }}"
                            },
                            {
                                type: 'email',
                                message: "{{ trans('validation.email', ['attribute' => trans('admin/employee.email')]) }}"
                            }
                        ],
                        password: [
                            {
                                required: true,
                                message: "{{ trans('validation.required', ['attribute' => trans('admin/employee.password')]) }}"
                            }
                        ],
                        checkPassword: [
                            {
                                required: true,
                                message: "{{ trans('validation.required', ['attribute' => trans('admin/employee.checkPassword')]) }}"
                            }
                        ]
                    },
                    role: role
                }
            },
            methods: {
                onHref(url) {
                    location.href = url;
                },
                handleCheckAllChange(val) {
                    this.checkedCities = val ? cityOptions : [];
                    this.isIndeterminate = false;
                },
                handleCheckedRoleChange(value) {
                    let checkedCount = value.length;
                    this.checkAll = checkedCount === this.cities.length;
                    this.isIndeterminate = checkedCount > 0 && checkedCount < this.cities.length;
                },
                onSubmit(formName) {
                    var vm = this;

                    if (!this.checkoutPwd()) {
                        vm.$notify.error({
                            title: "{{ trans('admin/common.failure') }}",
                            message: "{{ trans('admin/employee.validator.samePassword') }}"
                        });
                        return false;
                    }

                    this.$refs[formName].validate((valid) => {
                        if (valid) {
                            axios.post("{{ route('employee.create') }}", {
                                name: vm.form.name,
                                displayName: vm.form.displayName,
                                email: vm.form.email,
                                password: vm.form.password,
                                checkPassword: vm.form.checkPassword,
                                status: vm.form.status,
                                role: vm.form.role,
                            })
                                .then(function (res) {
                                    console.log(res);
                                    var data = res.data;
                                    if (data.code == '00000') {
                                        vm.$notify.success({
                                            title: "{{ trans('admin/common.success') }}",
                                            message: "{{ trans('admin/common.addSuccess') }}"
                                        });

                                        location.href = siteUrl + '/admin/employee';
                                    } else {
                                        vm.$notify.error({
                                            title: "{{ trans('admin/common.failure') }}",
                                            message: data.message
                                        });
                                    }
                                })
                                .catch(function (e) {
                                    console.log(e);
                                    vm.$notify.error({
                                        title: "{{ trans('admin/common.failure') }}",
                                        message: "{{ trans('admin/common.addFailure') }}"
                                    });
                                });
                        } else {
                            return false;
                        }
                    });
                },
                checkoutPwd() {
                    return (this.form.password === this.form.checkPassword) ? true : false;
                }
            }
        });
    </script>
@endsection
