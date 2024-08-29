<label class="form-label" {{ $attributes->merge(['for' => $name]) }}>{{ str_replace('_', ' ', __($name)) }}</label>
<textarea class="form-control @error($name) is-invalid @enderror"
    {{ $attributes->merge(['id' => $name, 'name' => $name]) }} {!! $html !!}>{{ old($name) ? old($name) : $value }}</textarea>
<x-invalid-input error="{{ $name }}" />
