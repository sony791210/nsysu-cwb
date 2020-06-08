@if ($errors->any())
    <div id="error"></div>
    <script>
        var error = new Vue({
            el: '#error',
            beforeMount() {
                    @foreach ($errors->all() as $error)
                        this.$notify.error({
                            title: "{{ trans('admin/employee.failure') }}",
                            message: '{{ $error }}',
                            type: 'error'
                        });
                    @endforeach
            }
        });
    </script>
@endif
