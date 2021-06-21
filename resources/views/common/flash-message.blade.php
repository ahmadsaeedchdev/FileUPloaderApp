@if(Session::has('message'))
<div class="alert {{ Session::get('class') ?? 'alert-info' }}" role="alert">
    {{ Session::get('message') }}
</div>
@endif
