<div class="btn-group">
    <a class="btn btn-warning" href="{{ route('warehouse.edit', $warehouse) }}"><i class='bx bx-edit'></i></a>
    <button class="btn btn-{{ $warehouse->deleted_at ? 'dark' : 'danger' }}"
        data-bs-target="#{{ $warehouse->deleted_at ? 'reactivate' : 'deactivate' }}Modal{{ $warehouse->id }}"
        data-bs-toggle="modal"><i class='bx bx-{{ $warehouse->deleted_at ? 'undo' : 'power-off' }}'></i></button>
</div>
@if ($warehouse->deleted_at)
    <x-modals.reactivate id="{{ $warehouse->id }}" name="{{ $warehouse->name }}" model="Warehouse" />
@else
    <x-modals.deactivate id="{{ $warehouse->id }}" name="{{ $warehouse->name }}" model="Warehouse" />
@endif
