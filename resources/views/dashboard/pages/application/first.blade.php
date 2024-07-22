@extends('layouts.dashboard')
@section('content')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">

                    <div class="card-title flex-column">
                        <h3 d-block>Garanti / İade Başvurusu</h3>
                        <p class="text-muted d-block">Garanti / İade süreci için seçmek istediğiniz ürünleri faturanızda
                            yer alan ürün kodu veya ürün adı ile aratabilirsiniz.</p>
                    </div>

                </div>
                <div class="card-body pt-0 ">
                    <form class="row productSearchForm" method="POST"
                          action="{{route('dashboard.application.search')}}">

                        @csrf

                        <div class="col-lg-6">
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

                        <div class="col-lg-6">
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>

                                <input type="text" name="productName"
                                       class="form-control form-control-solid  ps-12"
                                       placeholder="Ürün adı ile ara."/>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-4 mb-4">
                            <button type="submit"  class="btn btn-primary w-100">
<i class="ki-duotone ki-filter-search fs-1" >
 <span class="path1"></span>
 <span class="path2"></span>
 <span class="path3"></span>
</i>
Ara
</button>
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
                                        <th>Birim Fiyat</th>
                                        <th>İşlemler</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="emptyRow">
                                        <td colspan="5">Başvuru için ilgili ürünü seçin.</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="productSearchList">

                    </div>

                    <div class="applicationStatus">

                        <button class="btn btn-secondary" disabled>Devam Et</button>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('modals')
    @include('dashboard.modals.new-application')
@endsection

@section('scripts')
    <script src="{{asset('assets/js/custom/apps/ecommerce/catalog/products.js')}}"></script>

@endsection
