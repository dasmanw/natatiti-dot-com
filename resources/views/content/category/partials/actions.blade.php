<div class="btn-group">
    <a class="btn btn-warning" href="{{ route('category.edit', $category) }}"><i class='bx bx-edit'></i></a>
    <button class="btn btn-{{ $category->deleted_at ? 'dark' : 'danger' }}"
        data-bs-target="#{{ $category->deleted_at ? 'reactivate' : 'deactivate' }}Modal{{ $category->id }}"
        data-bs-toggle="modal"><i class='bx bx-{{ $category->deleted_at ? 'undo' : 'power-off' }}'></i></button>
</div>
@if ($category->deleted_at)
    <x-modals.reactivate id="{{ $category->id }}" name="{{ $category->name }}" model="Category" />
@else
    <x-modals.deactivate id="{{ $category->id }}" name="{{ $category->name }}" model="Category" />
@endif
