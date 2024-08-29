@extends('layouts/contentNavbarLayout')

@section('title', 'Cart Check Out')

@section('content')
    <x-breadcrumb>
        <li class="breadcrumb-item">Cart</li>
        <li class="breadcrumb-item active" aria-current="page">Check Out</li>
    </x-breadcrumb>

    <x-page-heading>Cart Check Out</x-page-heading>

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                @forelse ($carts as $cart)
                    <div class="col-lg-6">
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img class="card-img card-img-left"
                                        src="{{ $cart->product->getMedia('images')->first()?->getUrl() ?? $cart->product->image_link }}"
                                        alt="Card image" />
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $cart->product->name }}
                                        </h5>
                                        <form action="{{ route('cart.destroy', $cart) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-pinned" type="submit"><i
                                                    class="bx bx-trash"></i></button>
                                        </form>
                                        <table class="table table-sm table-striped">
                                            <tr>
                                                <th>Price Type</th>
                                                <td>{{ $cart->price_type }}</td>
                                            </tr>
                                            {{-- <tr>
                                                <th>Discount</th>
                                                <td>{{ $cart->discount }}</td>
                                            </tr> --}}
                                            <tr>
                                                <th>Total</th>
                                                <td>{{ $cart->total }}</td>
                                            </tr>
                                            {{-- <tr>
                                                <th>Net Total</th>
                                                <td>{{ $cart->net_total }}</td>
                                            </tr> --}}
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <div class="card mb-3">
                            <h4 class="mb-0 py-3">No Products Added</h4>
                        </div>
                    </div>
                @endforelse
                @if ($carts->count() > 0)
                    <div class="col-12">
                        <form action="{{ route('cart.checkout') }}" method="POST">
                            <div class="row">
                                <x-input-responsive name="total_discount" type="number"
                                    value="{{ $calculations['discount'] }}"
                                    html="required {{ is_super_admin() || is_admin() ? 'max=' . $calculations['sub_total'] : 'max=5' }}" />
                                <x-input-responsive name="sub_total" value="{{ $calculations['sub_total'] }}"
                                    html="disabled" />
                                <x-input-responsive name="grand_total"
                                    value="{{ $calculations['sub_total'] - $calculations['discount'] }}" html="disabled" />
                                <x-input-responsive name="name" html="required" />
                                <x-input-responsive name="phone_number" type="tel" html="required" />
                                <x-input-responsive name="email" type="email" />
                                <x-input-responsive class="col-md-8" name="address" html="required" />
                                {{-- <x-input-responsive name="payment_method" value="Cash On Delivery"
                                    html="required readonly" /> --}}
                                <x-select-responsive name="payment_method" html="required">
                                    <option value="Cash On Delivery">Cash On Delivery</option>
                                    <option value="KNET">KNET</option>
                                </x-select-responsive>
                                <x-textarea-responsive name="comments" class="col-12"
                                    html="required"></x-textarea-responsive>
                                <div class="col-12">
                                    @csrf
                                    <div class="d-flex justify-content-end">
                                        <div class="form-check me-2">
                                            <input class="form-check-input mt-2" type="checkbox" name="invoice"
                                                value="" id="invoice" checked>
                                            <label class="form-check-label mt-2" for="invoice">
                                                Show Invoice
                                            </label>
                                        </div>
                                        <button class="btn btn-primary" type="submit">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#total_discount').on('input', function() {
            let totalDiscountValue = $(this).val();
            let newGrandTotal = {{ $calculations['sub_total'] }} - totalDiscountValue;
            $('#grand_total').val(newGrandTotal);
        });
    </script>
@endpush
