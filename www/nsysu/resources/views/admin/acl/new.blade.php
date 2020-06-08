@extends('layouts.admin.main')

@section('content')
	<div class="bar">
        <div class="bar-left">
            <h3 class="bar-title">@lang('admin/common.add')權限</h3>
        </div>
        <div class="bar-right"></div>
	</div>
	<div class="page-form">
		<el-form ref="form" :model="form" action="{{ route('acl.create') }}" label-width="100px">
			<el-form-item label="{{ trans('admin/acl.name') }}" prop="name" :rules="rules.name">
				<el-input v-model="form.name"></el-input>
			</el-form-item>
			<el-form-item label="{{ trans('admin/acl.description') }}" prop="description" :rules="rules.description">
				<el-input v-model="form.description"></el-input>
			</el-form-item>

			<el-form-item>
				<el-button type="primary" @click="onSubmit('form')">@lang('admin/common.add')</el-button>
				<el-button @click="onHref('{{ route('acl.index') }}')">@lang('admin/common.cancal')</el-button>
			</el-form-item>
		</el-form>
	</div>
@endsection

@section('script')
<script>
var app = new Vue({
    el: '#app',
    data() {
        return {
	    	form: {
	          	name: '',
	          	description: ''
	        },
	        rules: {
	        	name: [
	        		{ required: true, message: "{{ trans('validation.required', ['attribute' => trans('admin/acl.name')]) }}"}
	        	],
	        	description: [
	        		{ required: true, message: "{{ trans('validation.required', ['attribute' => trans('admin/acl.description')]) }}"}
	        	]
	        }
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
		    		axios.post(siteUrl + '/acl/new', {
					    name: vm.form.name,
					    description: vm.form.description
					})
					.then(function (res) {
						var data = res.data;
					    if (data.code == '00000') {
					    	vm.$notify.success({
		                            title: "{{ trans('admin/common.success') }}",
		                            message: "{{ trans('admin/common.addSuccess') }}"
		                        });

					    	location.href = siteUrl + '/acl';
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
