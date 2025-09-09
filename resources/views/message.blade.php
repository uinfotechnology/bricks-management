{{-- @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="mdi mdi-check-all me-2"></i>
        <strong>{{ $message }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="mdi mdi-check-all me-2"></i>
        <strong>{{ $message }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="mdi mdi-check-all me-2"></i>
        <strong>{{ $message }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif --}}

<script>
    alertify.set('notifier', 'position', 'top-right');
</script>
@if ($message = Session::get('success'))
    <script>
        var notification = alertify.notify( '{{$message}}' ,'success', 5, function() {});
    </script>
@endif
@if ($message = Session::get('warning'))
    <script>
        var notification = alertify.notify( '{{$message}}' ,'warning', 5, function() {});
    </script>
@endif
@if ($message = Session::get('error'))
    <script>
        var notification = alertify.notify( '{{$message}}' ,'danger', 5, function() {});
    </script>
@endif



{{-- 
<script>
    $(document).ready(function() {
        setTimeout(() => {
            $('.alert').remove();
        }, 3000);
    });
</script> --}}
