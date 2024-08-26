<div class="card-title flex-column">
    <p class="text-muted d-block">{{$Type->title}} süreci için seçmek istediğiniz ürünleri
        faturanızda
        yer alan ürün kodu ile aratabilirsiniz.</p>
</div>

<form class="row productSearchForm" method="POST"
      action="{{route('dashboard.application.search')}}">
    <input type="hidden" value="{{$Type->uuid}}" name="uuid">

    @csrf

    <div class="row">
        @if($Type->quantity_limitor)
            <div class="col-lg-10">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" name="productCode"
                           class="form-control form-control-solid  ps-12"
                           placeholder="Ürün kodu ile ara." value=""/>
                </div>
            </div>
        @else

            <div class="col-lg-10">
            <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <input type="text" name="productCode"
                       class="form-control form-control-solid  ps-12"
                       placeholder="Ürün kodu ile ara." value=""/>
            </div>
        </div>
<input type="hidden" name="productCount" required
                       class="form-control form-control-solid  ps-12"
                       placeholder="Adet." value=""/>

            @endif
        <div class="col-lg-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="ki-duotone ki-filter-search fs-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                </i>
                Ara
            </button>
        </div>
    </div>
</form>

<div class="card min-w-full selectedProducts mt-5 mb-5">
    <div class="card-header">
        <h3 class="card-title">
            Seçilen Ürünler
        </h3>
    </div>
    <div class="card-table">
        <div class="table-responsive">
            <table class="table gs-7 gy-7 gx-7">
                <thead>
                <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                    <th>Ürün Adı</th>
                    <th>Ürün Kodu</th>
                    <th>Adet</th>

                    <th>İşlemler</th>
                </tr>
                </thead>
                <tbody class="filteredProductsTableBody">

                @if(isset($Application))
                    @forelse($Application->products as $product)
                            <tr id="product{{$loop->index}}"
                                data-desc = "{{ $product['desc'] }}"
                                 data-code ="{{ $product['code'] }}"
                                 data-qty = "{{ $product['qty'] }}"
                                 data-invoice = "{{$product['invoice']}}"
                                data-price = {{ number_format($product['price'], 2, '.', '')}}
                            >
                                <td> {{ $product['desc'] }}</td>
                                <td> {{ $product['code'] }}</td>
                                <td> {{ $product['qty'] }}</td>

                                <td><button class="btn btn-danger btnRemove" data-id="product{{$loop->index}}">Kaldır</button></td>
                        </tr>
                        @empty
                        @endforelse
                    @else
                        <tr class="emptyRow">
                            <td colspan="5">Başvuru için ilgili ürünü seçin.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
