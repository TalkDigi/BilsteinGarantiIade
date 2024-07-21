@extends('layouts.dashboard')
@section('content')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Navbar-->
            <div class="card mb-6 mb-xl-9">
                <div class="card-body pt-9 pb-0">
                    <!--begin::Details-->
                    <div class="d-flex flex-wrap flex-sm-nowrap mb-6">

                        <!--begin::Wrapper-->
                        <div class="flex-grow-1">
                            <!--begin::Head-->
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <!--begin::Details-->
                                <div class="d-flex flex-column">
                                    <!--begin::Status-->
                                    <div class="d-flex align-items-center mb-1">

                                        <a href="javascript:void(0)"
                                           class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">Ay Kapama</a>
                                    </div>
                                    <!--end::Status-->
                                    <!--begin::Description-->
                                    <div
                                            class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-500">

                                        Onaylanan ilave masrafsız başvuruların ürün listesine bu sayfadan
                                        ulaşabilirsiniz. Örnek fatura oluşturmak istediğiniz ayı seçerek
                                        başlayabilirsiniz.
                                    </div>
                                    <!--end::Description-->
                                </div>

                            </div>
                            <!--end::Head-->
                            <!--begin::Info-->
                            <form class="d-flex flex-wrap justify-content-start"
                                  action="{{route('dashboard.application.closure-filter')}}" method="POST">
                                @csrf
                                <div class="col-lg-6 p-3">
                                    <label for="month">Ay:</label>
                                    @php
                                        setlocale(LC_TIME, 'tr_TR', 'Turkish');
                                    @endphp
                                    <select name="month" id="month"
                                            class="form-control form-control-solid mb-3 mb-lg-0">
                                        <option selected disabled> Ay Seçin</option>
                                        <option value="1">Ocak</option>
                                        <option value="2">Şubat</option>
                                        <option value="3">Mart</option>
                                        <option value="4">Nisan</option>
                                        <option value="5">Mayıs</option>
                                        <option value="6">Haziran</option>
                                        <option value="7">Temmuz</option>
                                        <option value="8">Ağustos</option>
                                        <option value="9">Eylül</option>
                                        <option value="10">Ekim</option>
                                        <option value="11">Kasım</option>
                                        <option value="12">Aralık</option>
                                        
                                    </select>
                                </div>
                                <div class="col-lg-6 p-3">
                                    <label for="month">Yıl:</label>
                                    <select name="year" id="year" class="form-control form-control-solid mb-3 mb-lg-0">
                                        <option selected disabled> Yıl Seçin</option>
                                        @for ($i = 2021; $i <= date('Y'); $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>

                                        @endfor
                                    </select>
                                </div>
                                <div class="col-lg-12 p-3">
                                    <button type="submit" class="d-block w-100 btn btn-primary">Ara</button>

                                </div>
                            </form>
                            <!--end::Info-->
                        </div>
                        <!--end::Wrapper-->
                    </div>

                    <!--end::Details-->
                    <div class="separator"></div>

                </div>
            </div>
            <!--end::Navbar-->
            <!--begin::Row-->
            @if(isset($items) && count($items) > 0)
                <div class="row gx-6 gx-xl-9">
                    <!--begin::Col-->
                    <div class="col-lg-12">
                        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Ürün Bilgileri</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed table-bordered fs-6 gy-5 mb-0 closure-table">
                                        <thead>
                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-175px">Başvuru No</th>
                                            <th class="min-w-175px">Fatura</th>
                                            <th class="min-w-100px text-start">Ürün</th>
                                            <th class="min-w-100px text-start">Adet</th>
                                            <th class="min-w-70px text-start">Birim Fiyat</th>
                                        </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">

                                        @forelse($items as $key => $product)
                                            <tr data-name="{{$product['desc']}}" data-no="{{$product['code']}}"
                                                data-quantity="{{$product['qty']}}"
                                                data-price="{{ number_format($product['price'], 2, '.', '')}}">

                                                <td>{{$product['claim_number']}}</td>
                                                <td class="text-start">{{$product['invoice']}}</td>
                                                <td class="text-start">
                                                    {{$product['desc']}}
                                                    <br>
                                                    <span class="text-muted">{{$product['code']}}</span>
                                                </td>
                                                <td class="text-start">{{$product['qty']}}</td>
                                                <td class="text-start">
                                                    {{number_format($product['price'], 2, '.', '')}}
                                                </td>

                                            </tr>

                                        @empty
                                        @endforelse
                                        </tbody>
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <button class=" d-block text-center btn btn-success closure-button w-100 mt-5">Kapat ve
                                    Örnek Fatura Oluştur
                                </button>

                            </div>
                            <!--end::Card body-->
                        </div>
                    </div>

                </div>
            @else
                <div class="alert alert-warning">
                    <div class="alert-text text-center">
                        <p class="text-black mb-0">Belirtilen tarihte onaylanmış başvurunuz bulunamadı.</p>
                    </div>
                </div>
            @endif
            <!--end::Row-->
        </div>
        <!--end::Post-->
    </div>


    <div class="modal fade" id="invoiceModal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold"></h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close"
                            data-bs-dismiss="modal"
                            data-bs-target="#kt_modal_add_user"
                            id="kt_modal_add_user_close"
                    >
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body px-5 my-7 invoiceBody" id="invoiceBody">

                </div>
                <div class="modal-footer">
                    <button onclick="downloadPDF()">PDF İndir</button>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
@endsection
@section('scripts')
    <script>
        $('#month').select2({
            placeholder: "Ay Seçin",

        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <script>
        function downloadPDF() {
            var element = document.getElementById('invoiceBody');
            html2canvas(element, {
                onrendered: function (canvas) {
                    var imgData = canvas.toDataURL('image/png');
                    var doc = new jsPDF('p', 'mm');
                    doc.addImage(imgData, 'PNG', 10, 10);
                    doc.save('content.pdf');
                }
            });
        }
    </script>
@endsection
