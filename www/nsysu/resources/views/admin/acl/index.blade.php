@extends('layouts.admin.main')

@section('content')
	<div class="bar">
		<div class="bar-left">
			<h3 class="bar-title">@lang('admin/nav.aclManage')</h3>
		</div>
		<div class="bar-right">
		<el-button @click="onHref('{{ route('acl.view.new') }}')">@lang('admin/common.add')權限</el-button>
		</div>
	</div>
	<table-list :fields="fields" :table-data="list" :show-edit="true" @on-edit="edit"></table-list>
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
    	list: list
    },
    methods: {
    	onHref(url) {
    		location.href = url;
    	},
        edit(row) {
            location.href = row.editUrl;
        }
    }
});
</script>
@endsection
