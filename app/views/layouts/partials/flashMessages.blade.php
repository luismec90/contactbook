@if (Session::has('flash_notification.message'))
    <script>
        $(function () {
            $.notify({
                message: '{{ Session::get('flash_notification.message') }}'
            }, {
                type: '{{ Session::get('flash_notification.level') }}',
                placement: {
                    from: "top",
                    align: "center"
                }
            });
        });
    </script>
@endif


