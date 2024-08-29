<div class="modal fade" id="deactivateModal{{ $id }}" aria-labelledby="deactivateModal{{ $id }}Label"
    aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="deactivateModal{{ $id }}Label">{{ ucfirst($model) }}
                    Deactivation
                    Confirmation</h3>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">
                Are you sure you want to deactivate <span class="fw-bold text-warning">{{ $name }}</span>?
            </div>
            @php
                $model = lcfirst($model);
                $route = "$model.destroy";
            @endphp
            <form action="{{ route($route, [$model => $id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                    <button class="btn btn-danger" type="submit">Deactivate</button>
                </div>
            </form>
        </div>
    </div>
</div>
