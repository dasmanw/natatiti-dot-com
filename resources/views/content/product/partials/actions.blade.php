<div class="btn-group">
    <a class="btn btn-warning" href="{{ route('product.edit', $product) }}"><i class='bx bx-edit'></i></a>
    <button class="btn btn-info" data-bs-target="#showModal{{ $product->id }}" data-bs-toggle="modal"><i
            class='bx bx-show-alt'></i></button>
    <button class="btn btn-{{ $product->deleted_at ? 'dark' : 'danger' }}"
        data-bs-target="#{{ $product->deleted_at ? 'reactivate' : 'deactivate' }}Modal{{ $product->id }}"
        data-bs-toggle="modal"><i class='bx bx-{{ $product->deleted_at ? 'undo' : 'power-off' }}'></i></button>
</div>
@include('content.product.modals.show')
@if ($product->deleted_at)
    <x-modals.reactivate id="{{ $product->id }}" name="{{ $product->name }}" model="Product" />
@else
    <x-modals.deactivate id="{{ $product->id }}" name="{{ $product->name }}" model="Product" />
@endif
