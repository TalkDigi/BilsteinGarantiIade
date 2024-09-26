@php
use Carbon\Carbon;
@endphp
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
                                            class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">Tüm Başvurular</a>
                                    </div>
                                    
                                </div>

                            </div>
                            <!--end::Head-->
                            <!--begin::Info-->
                            <form class="d-flex flex-wrap justify-content-start"
                                action="{{ route('dashboard.applications.filter') }}" method="POST">
                                @csrf
                                {{-- if user has role Yönetici --}}
                                @if (auth()->user()->hasRole('Yönetici'))
                                    
                                    <div class="col-lg-6 p-2">
                                        <select class="form-select form-select-solid form-select-lg" data-control="select2"
                                            data-hide-search="true" name="year">
                                            <option value="">Yıl Seçin</option>
                                            @for ($i = date('Y'); $i >= 2021; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-lg-6 p-2">
                                        <select class="form-select form-select-solid form-select-lg" data-control="select2"
                                            data-hide-search="true" name="CustNo">
                                            <option value="">Müşteri Seçin</option>

                                            @forelse($Customers as $customer)
                                                <option value="{{ $customer->No }}">{{ $customer->No }} -
                                                    {{ $customer->SearchName }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                
                                @endif
                                <div class="col-lg-12 p-3">
                                    <button type="submit" class="d-block w-100 btn btn-primary">Ara</button>

                                </div>
                            </form>

                        </div>
                        <!--end::Wrapper-->
                    </div>

                    <!--end::Details-->
                    <div class="separator"></div>

                </div>
            </div>
            <!--end::Navbar-->
            <!--begin::Row-->
                @if (isset($Applications) && count($Applications) > 0)
                    <div class="row gx-6 gx-xl-9 ">
                        <!--begin::Col-->
                        <div class="col-lg-12">
                            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    @forelse($Applications as $month => $application)
                                    
                                        <h4 class="mb-4 mt-5">
                                            {{ $month }} Ayı Başvuruları
                                        </h4>
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table
                                                class="table align-middle table-row-dashed table-bordered fs-6 gy-5 mb-0 closure-table">
                                                <thead>
                                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                        <th class="">Başvuru No</th>
                                                        <th class="min-w-250px text-start">Tip</th>
                                                        <th class="w-200px text-start">Ay Kapama</th>

                                                    </tr>
                                                </thead>
                                                <tbody class="fw-semibold text-gray-600">
      

                                                    @forelse($application as $app)
                                                        <tr >

                                                            <td class="text-start">
                                                                <a href="{{route('dashboard.application.show', $app->claim_number)}}">
                                                                {{$app->claim_number}}
                                                                </a>
                                                            </td>
                                                            <td class="text-start">
                                                                {{$app->getType()->title}}
                                                            </td>
                                                            
                                                            <td class="text-start">
                                                                
                                                                @if(isset($FilteredClosures[$app->claim_number]))
                                                                <a href="{{route('dashboard.application.closure-show', $FilteredClosures[$app->claim_number]['uuid'])}}" class="btn btn-info">
                                                                    {{ $FilteredClosures[$app->claim_number]['month'] }} / {{ $FilteredClosures[$app->claim_number]['year'] }}
                                                                    </a>
                                                                @endif
                                                                
                                                            </td>

                                                        </tr>

                                                    @empty
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                    @empty
                                    @endforelse

                                </div>
                                <!--end::Card body-->
                            </div>
                        </div>

                    </div>
                @else
                    <div class="alert alert-warning">
                        <div class="alert-text text-center">
                            <p class="text-black mb-0">Belirtilen tarihlerde başvuru bulunamadı..</p>
                        </div>
                    </div>
                @endif
        </div>
        <!--end::Post-->
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
                onrendered: function(canvas) {
                    var imgData = canvas.toDataURL('image/png');
                    var doc = new jsPDF('p', 'mm');
                    doc.addImage(imgData, 'PNG', 10, 10);
                    doc.save('content.pdf');
                }
            });
        }

        //if user click changePrice, trigger ajax
        let claimNumber = '';
        let index = '';
        $(document).on('click', '.changePrice', function() {

            claimNumber = $(this).data('claim-number');
            index = $(this).data('index');

            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('dashboard.application.search_other_prices') }}",
                type: 'POST',
                data: {
                    claim_number: claimNumber,
                    _token: token
                },
                success: function(data) {
                    $('#priceChangeBody').html(data.html);
                    $('#priceChange').modal('show');
                }
            });

        });

        $(document).on('click', '.change-price', function() {
            var invoiceId = $(this).data('invoice-id');
            var token = $('meta[name="csrf-token"]').attr('content');
            var qty = $(this).data('qty');
            var maxQty = $(this).data('max-qty');
            if (qty > maxQty) {
                toastr.error('Başvuru miktarı, kalan adetten fazla olamaz.');
                return false;
            }
            $.ajax({
                url: "{{ route('dashboard.application.set_price') }}",
                type: 'POST',
                data: {
                    invoice_id: invoiceId,
                    index: index,
                    claim_number: claimNumber,
                    _token: token
                },
                success: function(data) {
                    if (data.success) {
                        $('#priceChange').modal('hide');
                        $('.' + claimNumber).html(data.html);
                    } else {
                        toastr.error('Fiyat değiştirilemedi.');
                    }
                }
            });
        });
    </script>
@endsection
