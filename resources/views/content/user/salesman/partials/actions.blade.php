<div class="btn-group">
    <a class="btn btn-warning" href="{{ route('salesman.edit', $salesman) }}"><i class='bx bx-edit'></i></a>
    <button class="btn btn-{{ $salesman->deleted_at ? 'dark' : 'danger' }}"
        data-bs-target="#{{ $salesman->deleted_at ? 'reactivate' : 'deactivate' }}Modal{{ $salesman->id }}"
        data-bs-toggle="modal"><i class='bx bx-{{ $salesman->deleted_at ? 'undo' : 'power-off' }}'></i></button>
</div>
@if ($salesman->deleted_at)
    <x-modals.reactivate id="{{ $salesman->id }}" name="{{ $salesman->name }}" model="Salesman" />
@else
    <x-modals.deactivate id="{{ $salesman->id }}" name="{{ $salesman->name }}" model="Salesman" />
@endif
