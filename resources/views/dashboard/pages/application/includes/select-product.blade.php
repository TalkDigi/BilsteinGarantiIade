<div class="flex-column current" data-kt-stepper-element="content">
    <div class="d-flex flex-column gap-10">
        <div>
            <label class="form-label"></label>
            <div class="row row-cols-1 row-cols-xl-3 row-cols-md-2 border border-dashed rounded pt-3 pb-1 px-2 mb-5 mh-300px overflow-scroll"
                id="kt_ecommerce_edit_order_selected_products">
                <span class="w-100 text-muted">Başvuru için ilgili ürünü seçin.</span>
            </div>
        </div>
        <div class="separator"></div>
        <div class="d-flex align-items-center position-relative mb-n7">
            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
            <input type="text" data-kt-ecommerce-edit-order-filter="search"
                class="form-control form-control-solid w-100 w-lg-50 ps-12"
                placeholder="Ürün arayın." />
        </div>
        <table class="table align-middle table-row-dashed fs-6 gy-5"
            id="kt_ecommerce_edit_order_product_table">
            <thead>
                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                    <th class="w-25px pe-2"></th>
                    <th class="min-w-200px">Ürün</th>
                    <th class="min-w-200px">Birim Fiyat</th>
                    <th class="min-w-100px text-end pe-5">Miktar</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">

                @forelse($Invoice->updateLinesWithBrandNames() as $line)
                    <tr>
                        <td>
                            <div
                                class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" data-item-no="{{$line['ItemNo']}}"
                                    value="{{ $loop->iteration }}" />

                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center"
                                data-kt-ecommerce-edit-order-filter="product"
                                data-kt-ecommerce-edit-order-id="product_{{ $loop->iteration }}">

                                <div class="ms-5">
                                    <span class="text-gray-800 text-hover-primary fs-5 fw-bold"
                                        id="qty_{{ $loop->iteration }}"
                                        data-uom="{{ $line['UOM'] }}"
                                        data-qty="{{ $line['Qty'] }}"
                                          data-brand="{{$line['BrandName']}}"
                                          data-id="{{$line['ItemNo']}}"
                                          data-item-no="{{$line['ItemNo']}}"
                                    >{{ $line['ItemDesc'] }}</span>

                                    <div class="fw-semibold fs-7">Ürün Kodu: {{ $line['ItemNo'] }}
                                    </div>

                                    <div class="text-muted fs-7">Marka:
                                        {{$line['BrandName']}}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span
                                data-kt-ecommerce-edit-order-filter="price">{{ $line['UnitPrice'] }}</span>
                        </td>
                        <td class="text-end pe-5">
                            <span class="badge badge-light-warning">{{ $line['UOM'] }}</span>
                            <span class="fw-bold text-warning ms-3">{{ $line['Qty'] }}</span>
                        </td>
                    </tr>
                @empty
                @endforelse


            </tbody>
        </table>
    </div>
    <div id="quantitiesInputs">

    </div>
</div>
