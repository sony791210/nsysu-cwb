@extends('layouts.admin.main')

@section('content')
	<div class="card">
	  	<div class="card-header" style="background-color: #fff;">
			<i class="fa fa-cog"> @lang('admin/common.add')</i>
	  	</div>
	  	<div class="card-body">
			<el-form ref="form" :model="form" label-width="100px">
			    <el-form-item label="{{ trans('admin/role.name') }}" prop="name" :rules="rules.name">
			        <el-input v-model="form.name"></el-input>
			    </el-form-item>
			    <el-form-item label="{{ trans('admin/role.description') }}" prop="description" :rules="rules.description">
			        <el-input v-model="form.description"></el-input>
			    </el-form-item>
			    <el-form-item label="{{ trans('admin/role.setting') }}">
					<el-transfer v-model="form.own_acl" :data="acl" :titles="['{{ trans('admin/role.aclList') }}', '{{ trans('admin/role.addAclList') }}']"></el-transfer>
			    </el-form-item>

			    <el-form-item>
			        <el-button type="primary" @click="onSubmit('form')">@lang('admin/common.add')</el-button>
			        <el-button @click="onHref('{{ route('role.index') }}')">@lang('admin/common.cancal')</el-button>
			    </el-form-item>
			</el-form>
	  	</div>
	</div>
@endsection

@section('script')
<script>
var acl = {!! $acl !!};

var app = new Vue({
    el: '#app',
    data() {
        return {
	    	form: {
	          	name: '',
	          	description: '',
	          	own_acl: []
	        },
	        rules: {
	        	name: [
	        		{ required: true, message: "{{ trans('validation.required', ['attribute' => trans('admin/role.name')]) }}"}
	        	],
	        	description: [
	        		{ required: true, message: "{{ trans('validation.required', ['attribute' => trans('admin/role.description')]) }}"}
	        	]
	        },
	        acl: acl
	    }
    },
    methods: {
    	onHref(url) {
    		location.href = url;
    	},
    	onSubmit(formName) {
    		var vm = this;

    		this.$refs[formName].validate((valid) => {
		        if (valid) {
		    		axios.post(siteUrl + '/role/new', {
					    name: vm.form.name,
					    description: vm.form.description,
					    own_acl: vm.form.own_acl
					})
					.then(function (res) {
						var data = res.data;
					    if (data.code == '00000') {
					    	vm.$notify.success({
		                            title: "{{ trans('admin/common.success') }}",
		                            message: "{{ trans('admin/common.addSuccess') }}"
		                        });

					    	location.href = siteUrl + '/role';
					    }
					    else {
					    	vm.$notify.error({
		                            title: "{{ trans('admin/common.failure') }}",
		                            message: data.message
		                        });
					    }
					})
					.catch(function (e) {
						vm.$notify.error({
		                            title: "{{ trans('admin/common.failure') }}",
		                            message: "{{ trans('admin/common.addFailure') }}"
		                        });
					});
				} else {
		            return false;
		       	}
		    });
    	}
    }
});
</script>
@endsection
