@foreach($products as $product) 

<tr data-name="{{$product['desc']}}" data-no="{{$product['code']}}"
    data-quantity="{{$product['qty']}}"
    data-price="{{ number_format($product['price'] * $product['qty'], 2, '.', '')}}">

    <td class="text-start">{{$product['invoice']}}</td>
    <td class="text-start">
        {{$product['desc']}}
        <br>
        <span class="text-muted">{{$product['code']}}</span>
    </td>
    <td class="text-start">{{$product['qty']}}</td>
    <td class="text-start">
        {{ number_format($product['price'], 2, ',', '.') }}₺
    </td>
    <td class="text-start">
        {{ number_format($product['price'] * $product['qty'], 2, ',', '.') }}₺
    </td>
    <td>
        <a data-claim-number="{{$Application->claim_number}}" data-index="{{$loop->index}}" class="btn btn-sm btn-bg-light btn-icon-gray-900 btn-text-gray-900 me-2 mb-2 changePrice">
<i class="ki-duotone ki-price-tag fs-1"><span class="path1"></span><span class="path2"></span></i>Farklı Fiyat Seç</a>
    </td>

</tr>

@endforeach