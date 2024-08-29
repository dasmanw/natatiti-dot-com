<div {{ $attributes->merge(['class' => $class . ' mb-3']) }}>
    <x-input name="{{ $name }}" type="{{ $type }}" value="{{ $value }}" html="{{ $html }}" />
</div>
