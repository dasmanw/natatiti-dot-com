<div {{ $attributes->merge(['class' => $class . ' mb-3']) }}>
    <x-select name="{{ $name }}" html="{{ $html }}">
        {{ $slot }}
    </x-select>
</div>
