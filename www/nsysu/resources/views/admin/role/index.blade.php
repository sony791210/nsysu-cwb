@extends('layouts.admin.main')

@section('content')
    <h3>@lang('admin/nav.roleManage')</h3>
	<div class="card">
	  	<div class="card-header" style="background-color: #fff;">
			<i class="fa fa-table"> @lang('admin/common.list')</i>
			<div class="pull-right">
				<el-button type="success" size="small" plain @click="onHref('{{ route('role.view.new') }}')">@lang('admin/common.add')</el-button>
			</div>
	  	</div>
	  	<div class="card-body">
	    	<my-table :fields="fields" :list="list" :show-delete="false" :show-view="false" @edit="edit"></my-table>
	  	</div>
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
