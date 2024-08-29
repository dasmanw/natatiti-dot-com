<div class="btn-group">
    <a class="btn btn-warning" href="{{ route('reservation.edit', $reservation) }}"><i class='bx bx-edit'></i></a>
    <a class="btn btn-info" href="{{ route('reservation.invoice', $reservation) }}"><i class='bx bx-show-alt'></i></a>
    <button class="btn btn-danger" data-bs-target="#deleteModal{{ $reservation->id }}" data-bs-toggle="modal"><i
            class='bx bx-trash'></i></button>
</div>
<div class="modal fade" id="deleteModal{{ $reservation->id }}" aria-labelledby="deleteModal{{ $reservation->id }}Label"
    aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="deleteModal{{ $reservation->id }}Label">{{ $reservation->code }}
                    Deletion
                    Confirmation</h3>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">
                Are you sure you want to delete <span class="fw-bold text-warning">{{ $reservation->code }}</span>?
            </div>
            <form action="{{ route('reservation.destroy', $reservation) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                    <button class="btn btn-danger" type="submit">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
