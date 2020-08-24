@extends('layouts.admin.main')

@section('content')
    <div class="bar">
        <div class="bar-left">
            <h3 class="bar-title">@lang('admin/common.edit')帳號</h3>
        </div>
        <div class="bar-right"></div>
    </div>
    <div class="page-form">
        <el-form ref="form" :model="form" label-width="100px">
            <el-form-item label="{{ trans('admin/employee.name') }}">
                <el-input v-model="form.name" :disabled="true"></el-input>
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
                <small class="form-text text-muted">如不需修改密碼，則不用填寫</small>
            </el-form-item>

            <el-form-item label="{{ trans('admin/employee.password') }}" prop="password" :rules="rules.password">
                <el-input type="password" v-model="form.password" auto-complete="off"></el-input>
            </el-form-item>
            <el-form-item label="{{ trans('admin/employee.checkPassword') }}" prop="checkPassword"
                          :rules="rules.checkPassword">
                <el-input type="password" v-model="form.checkPassword" auto-complete="off"></el-input>
            </el-form-item>

            <el-form-item label="">
                <hr class="my-10">
            </el-form-item>

            <el-form-item label="{{ trans('admin/employee.role') }}">
                <el-transfer v-model="form.role" :data="role"
                             :titles="['{{ trans('admin/common.list') }}',
							 '{{ trans('admin/common.selectList') }}']">
                </el-transfer>
            </el-form-item>

            <el-form-item label="">
                <hr class="my-10">
            </el-form-item>

            <el-form-item label="{{ trans('admin/employee.status') }}">
                <el-switch v-model="form.status" active-color="#13ce66" inactive-color="#a2a2a2">
                </el-switch>
            </el-form-item>

            <el-form-item>
                <el-button type="primary" @click="onSubmit('form')">@lang('admin/common.edit')</el-button>
                <el-button @click="onHref('{{ route('employee.index') }}')">@lang('admin/common.cancal')</el-button>
            </el-form-item>
        </el-form>
    </div>
@endsection

@section('script')
    <script>
        var employee = {!! $employee !!};
        var role = {!! $role !!};
        var hasRole = {!! $hasRole !!};

        var app = new Vue({
            el: '#app',
            data() {
                return {
                    form: {
                        id: employee.employee_id,
                        name: employee.name,
                        displayName: employee.displayName,
                        email: employee.email,
                        password: '',
                        checkPassword: '',
                        status: (employee.status === 1),
                        role: hasRole
                    },
                    rules: {
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
                    },
                    role: role
                }
            },
            methods: {
                onHref(url) {
                    location.href = url;
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
                            axios.post(siteUrl + '/admin/employee/update/' + vm.form.id, {
                                displayName: vm.form.displayName,
                                email: vm.form.email,
                                password: vm.form.password,
                                checkPassword: vm.form.checkPassword,
                                status: vm.form.status,
                                role: vm.form.role,
                            })
                                .then(function (res) {
                                    var data = res.data;
                                    if (data.code == '00000') {
                                        vm.$notify.success({
                                            title: "{{ trans('admin/common.success') }}",
                                            message: "{{ trans('admin/common.editSuccess') }}"
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
                                    vm.$notify.error({
                                        title: "{{ trans('admin/common.failure') }}",
                                        message: "{{ trans('admin/common.editFailure') }}"
                                    });
                                });
                        } else {
                            return false;
                        }
                    });
                },
                checkoutPwd() {
                    if (this.form.password || this.form.checkPassword) {
                        return (this.form.password === this.form.checkPassword) ? true : false;
                    }

                    return true;
                }
            }
        });
    </script>
@endsection
