<div class="btn-group">
    <a class="btn btn-warning" href="{{ route('vendor.edit', $vendor) }}"><i class='bx bx-edit'></i></a>
    <button class="btn btn-{{ $vendor->deleted_at ? 'dark' : 'danger' }}"
        data-bs-target="#{{ $vendor->deleted_at ? 'reactivate' : 'deactivate' }}Modal{{ $vendor->id }}"
        data-bs-toggle="modal"><i class='bx bx-{{ $vendor->deleted_at ? 'undo' : 'power-off' }}'></i></button>
</div>
@if ($vendor->deleted_at)
    <x-modals.reactivate id="{{ $vendor->id }}" name="{{ $vendor->name }}" model="Vendor" />
@else
    <x-modals.deactivate id="{{ $vendor->id }}" name="{{ $vendor->name }}" model="Vendor" />
@endif
