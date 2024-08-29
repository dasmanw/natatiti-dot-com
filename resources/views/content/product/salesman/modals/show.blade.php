<div class="modal fade" id="showModal{{ $product->id }}" aria-labelledby="showModalLabel{{ $product->id }}"
    aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="showModalLabel{{ $product->id }}">Product Details</h1>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="text-center">
                            <img class="img-fluid" src="{{ $product->getMedia('images')->first()?->getUrl() ?? $product->image_link }}"
                                alt="Image not found" loading="lazy">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <table class="table table-sm table-striped">
                            <tbody>
                                <tr>
                                    <th>Status</th>
                                    <td><span
                                            class="badge rounded-pill bg-label-{{ $product->available_from ? 'danger' : 'success' }}">{{ $product->available_from ? 'Unavailable' : 'Available' }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $product->name }}</td>
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
                        @if (!$product->available_from)
                            <form id="{{ $product->id }}" action="javascript:void(0)" method="POST">
                                @csrf
                                <div class="row mt-3">
                                    <label class="col-sm-3 col-form-label mb-3" for="type{{ $product->id }}">Select
                                        Pricing Type</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" id="type{{ $product->id }}" name="price_type"
                                            oninput="calculateTotalPrice(this.closest('form'))">
                                            <option value="" selected disabled>Select Type</option>
                                            @foreach (App\Models\Product::$priceTypes as $type)
                                                @if ($type != 'Per Day')
                                                    <option value="{{ $type }}"
                                                        {{ old('type') == $type ? 'selected' : '' }}>
                                                        {{ $type }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <textarea class="d-none" name="prices" disabled>{{ $product->prices }}</textarea>
                                    {{-- <label class="col-sm-3 col-form-label mb-3"
                                        for="discount{{ $product->id }}">Discount</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" id="discount{{ $product->id }}" name="discount"
                                            type="number" value="0" min="0" required
                                            oninput="calculateTotalPrice(this.closest('form'))">
                                    </div> --}}
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="total{{ $product->id }}">Total</label>
                                        <input class="form-control" id="total{{ $product->id }}" name="total"
                                            value="0" disabled onkeydown = "return event.keyCode !== 69" />
                                    </div>
                                    {{-- <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="net_total{{ $product->id }}">Net Total</label>
                                        <input class="form-control" id="net_total{{ $product->id }}" name="net_total"
                                            value="0" disabled onkeydown = "return event.keyCode !== 69" />
                                    </div> --}}
                                    <div class="col-12 mb-3">
                                        <button class="btn btn-primary" data-id="{{ $product->id }}"
                                            onclick="addToCart(this)"><i class="bx bx-cart-add"></i></button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
