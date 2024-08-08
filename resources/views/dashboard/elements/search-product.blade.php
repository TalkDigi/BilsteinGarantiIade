{{--
<div
    class="row row-cols-1 row-cols-xl-3 row-cols-md-2 border border-dashed rounded pt-3 pb-1 px-2 mb-5 mh-300px overflow-scroll"
    id="kt_ecommerce_edit_order_selected_products">
    <span class="w-100 text-muted d-none">Başvuru için ilgili ürünü seçin.</span>

    @forelse($products as $product)
        <div class="col-lg-4 my-2">
            <div class="d-flex align-items-center border border-dashed rounded p-3 bg-body">

                <div class="ms-5">
                    <span class="text-gray-800 text-hover-primary fs-5 fw-bold">{{$product['ItemDesc']}}</span>

                    <div class="fw-semibold fs-7 mt-2">Ürün Kodu: {{$product['ItemNo']}}
                    </div>

                    <div class="text-muted fs-7 mt-2">Fatura No:
                        {{$product['Invoice']}}
                    </div>
                    <div class="text-muted fs-7 mt-2">Birim Fiyat:
                        {{number_format($product['Price'], 2, '.', '')}}
                    </div>
                    @if(isset($product['Blocked']))
                        <div class="text-muted fs-7 mt-2">Başvurulmuş Adet
                            : {{$product['Blocked']}}
                    </div>
                        @endif
                    <div class="d-flex flex-col">
                        <input class="form-control mt-2 quantity" type="number" max="{{$product['Qty']}}"
                               placeholder="Adet girin. (Maks. {{$product['Qty']}} Adet)">

                        <button class="btn btn-close-white addProduct btn-sm"
                                data-desc="{{$product['ItemDesc']}}"
                                data-code="{{$product['ItemNo']}}"
                                data-invoice="{{$product['Invoice']}}"
                                data-price=" {{number_format($product['Price'], 2, '.', '')}}"
                                data-max="{{$product['Qty']}}"
                        >
                            Ekle
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div>
            Ürün bulunamadı.
        </div>
    @endforelse


</div>
--}}
@forelse($products as $product)
    <tr id="product{{$loop->index}}"
        data-desc = "{{ $product['line']['ItemDesc'] }}"
         data-code ="{{ $product['line']['ItemNo'] }}"
         data-qty = "{{ $product['usedQty'] }}"
         data-invoice = "{{$product['invoice']}}"
        data-price = {{ number_format($product['line']['Amt'] / $product['line']['Qty'], 2, '.', '')}}
    >
        <td> {{ $product['line']['ItemDesc'] }}</td>
        <td> {{ $product['line']['ItemNo'] }}</td>
        <td> {{ $product['usedQty'] }}</td>
        <td>{{$product['invoice']}}</td>
        <td class="text-center" >
            {{
                number_format($product['line']['Amt'] / $product['line']['Qty'], 2, '.', '')
            }}₺
        </td>
        <td><button class="btn btn-danger btnRemove" data-id="product{{$loop->index}}">Kaldır</button></td>
</tr>
@empty
    <tr>
        <td colspan="5">Başvuru için ilgili ürünü seçin.</td>
    </tr>
@endforelse
