@if (Session::has('flash_notification.message'))
    <script>
        $(function () {
            showMessage('{{ Session::get('flash_notification.message') }}', '{{ Session::get('flash_notification.level') }}');
        });
    </script>
@endif


