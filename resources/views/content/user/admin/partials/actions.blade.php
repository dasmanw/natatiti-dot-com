<div class="btn-group">
    <a class="btn btn-warning" href="{{ route('admin.edit', $admin) }}"><i class='bx bx-edit'></i></a>
    <button class="btn btn-{{ $admin->deleted_at ? 'dark' : 'danger' }}"
        data-bs-target="#{{ $admin->deleted_at ? 'reactivate' : 'deactivate' }}Modal{{ $admin->id }}"
        data-bs-toggle="modal"><i class='bx bx-{{ $admin->deleted_at ? 'undo' : 'power-off' }}'></i></button>
</div>
@if ($admin->deleted_at)
    <x-modals.reactivate id="{{ $admin->id }}" name="{{ $admin->name }}" model="Admin" />
@else
    <x-modals.deactivate id="{{ $admin->id }}" name="{{ $admin->name }}" model="Admin" />
@endif
