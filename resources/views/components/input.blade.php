<label class="form-label" {{ $attributes->merge(['for' => $name]) }}>{{ __(str_replace('_', ' ', $name)) }}</label>
<input class="form-control @error($name) is-invalid @enderror"
    {{ $attributes->merge(['id' => $name, 'value' => old($name) ? old($name) : $value, 'name' => $name, 'type' => $type]) }}
    {!! $html !!} />
<x-invalid-input error="{{ $name }}" />
