<form id="{{ $name }}" action="{{ $action }}" method="POST"
    @if ($multipart) enctype="multipart/form-data" @endif>
    @csrf
    @method($method)
    {{ $slot }}
</form>
