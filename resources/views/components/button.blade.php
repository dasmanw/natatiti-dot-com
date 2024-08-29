<button {{ $attributes->merge(['class' => 'btn btn-' . $class, 'type' => $type]) }}>
    {{ $slot }}
</button>
