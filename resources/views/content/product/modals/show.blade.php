<div class="modal fade" id="showModal{{ $product->id }}" aria-labelledby="showModal{{ $product->id }}Label"
    aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="showModal{{ $product->id }}Label">{{ $product->name }} Details</h3>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">
                <div class="row">
                    <div class="text-center">
                        <img src="{{ $product->getMedia('images')->first()?->getUrl() ?? $product->image_link }}" alt="Image not found"
                            style="max-height: 250px; max-width: 100%" loading="lazy">
                    </div>
                    <table class="table table-sm table-striped">
                        <tbody>
                            <tr>
                                <th>Code</th>
                                <td>{{ $product->code }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th>Warehouse</th>
                                <td>{{ $product->warehouse?->name }}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>{{ $product->category?->name }}</td>
                            </tr>
                            <tr>
                                <th>Length</th>
                                <td>{{ $product->length }}</td>
                            </tr>
                            <tr>
                                <th>Height</th>
                                <td>{{ $product->height }}</td>
                            </tr>
                            <tr>
                                <th>Width</th>
                                <td>{{ $product->width }}</td>
                            </tr>
                            @php
                                $priceTypes = json_decode($product->prices);
                            @endphp
                            @foreach (App\Models\Product::$priceTypes as $title)
                                @php
                                    $field = strtolower(str_replace(' ', '_', $title));
                                @endphp
                                <tr>
                                    <th>{{ $title }} Price</th>
                                    <td>{{ $priceTypes->$field }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
