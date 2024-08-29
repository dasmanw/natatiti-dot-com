<div class="modal fade" id="reactivateModal{{ $id }}" aria-labelledby="reactivateModal{{ $id }}Label"
    aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="reactivateModal{{ $id }}Label">{{ ucfirst($model) }}
                    Reactivation
                    Confirmation</h3>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">
                Are you sure you want to reactivate <span class="fw-bold text-warning">{{ $name }}</span>?
            </div>
            @php
                $model = lcfirst($model);
                $route = "$model.restore";
            @endphp
            <form action="{{ route($route, [$model => $id]) }}" method="POST">
                @csrf
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                    <button class="btn btn-dark" type="submit">Reactivate</button>
                </div>
            </form>
        </div>
    </div>
</div>
