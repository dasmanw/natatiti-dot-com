<div {{ $attributes->merge(['class' => $class . ' mb-3']) }}>
    <x-textarea name="{{ $name }}" value="{{ $value }}" html="{{ $html }}" />
</div>
