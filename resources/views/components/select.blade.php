<label class="form-label" {{ $attributes->merge(['for' => $name]) }}>{{ str_replace('_', ' ', __($name)) }}</label>
<select class="form-select @error($name)
    invalid
@enderror" id="{{ $name }}" name="{{ $name }}"
    {!! $html !!}>
    {{ $slot }}
</select>
<x-invalid-input error="{{ $name }}" />
