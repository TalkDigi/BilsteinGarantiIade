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
                            <div class="mb-2">
                                <!--begin::Details-->
                                <div class="d-flex flex-column">
                                    <!--begin::Status-->
                                    <div class="d-flex align-items-center mb-1">

                                        <a href="javascript:void(0)"
                                           class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">
                                           {{$months[$Closure->month]}} {{$Closure->year}} Ay Kapama

                                           @if(auth()->user()->hasRole('Yönetici'))
                                           ( {{$Closure->customer->No}} - {{$Closure->customer->SearchName}} )
                                            @endif
                                        </a>
                                    </div>
                                    <!--end::Status-->
                                    <!--begin::Description-->
                                    <div
                                            class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-500 flex-column">

                                        {{-- we have session flash --}}
                                        @if(session()->has('success'))
                                            <div class="alert alert-success">
                                                {{ session()->get('success') }}
                                            </div>
                                        @endif

                                        @if(session()->has('error'))
                                            <div class="alert alert-danger">
                                                {{ session()->get('error') }}
                                            </div>
                                        @endif

                                        @if(session()->has('warning'))
                                            <div class="alert alert-warning">
                                                {{ session()->get('warning') }}
                                            </div>
                                        @endif





                                        {{$months[$Closure->month]}} {{$Closure->year}} dönemine ait onaylanmış başvurularınıza dair kabul edilen faturaların detayları aşağıda listelenmiştir.



                                        <a  href="{{route('dashboard.application.export-invoice-closure',['uuid' => $Closure->uuid])}}" target="_blank" class="btn btn-sm btn-success me-3 mt-10" data-status-id="5">
                                            <i class="ki-duotone ki-printer">
 <span class="path1"></span>
 <span class="path2"></span>
 <span class="path3"></span>
 <span class="path4"></span>
 <span class="path5"></span>
</i>
                                            Örnek Fatura İndir
                                        </a>
                                    </div>
                                    <!--end::Description-->
                                </div>

                            </div>

                        </div>
                        <!--end::Wrapper-->
                    </div>

                    <!--end::Details-->
                    <div class="separator"></div>

                </div>
            </div>
            <!--end::Navbar-->
            <!--begin::Row-->
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
                            @forelse($Closure->data as $no => $application)
                                <h4 class="mb-4 mt-4">{{$no}}</h4>
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table
                                        class="table align-middle table-row-dashed table-bordered fs-6 gy-5 mb-0 closure-table">
                                        <thead>
                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-175px">Fatura</th>
                                            <th class="min-w-100px text-start">Ürün</th>
                                            <th class="min-w-100px text-start">Adet</th>
                                            <th class="min-w-70px text-start">Birim Fatura Fiyatı</th>
                                            <th class="min-w-70px text-start">Toplam Fiyat</th>
                                        </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">

                                        @forelse($application as $product)
                                            <tr data-name="{{$product['desc']}}" data-no="{{$product['code']}}"
                                                data-quantity="{{$product['qty']}}"
                                                data-price="{{ number_format($product['price'] * $product['qty'], 2, '.', '')}}">

                                                <td class="text-start">
                                                    {{$product['invoice']}}

                                                    <span class="text-muted d-block">
                                                        {{Carbon::createFromFormat('Y-m-d', $invoices[$product['invoice']])->locale('tr_TR')->translatedFormat('d F Y')}}
                                                                </span>
                                                </td>
                                                <td class="text-start">

                                                    {{$product['code']}}
                                                    <br>
                                                    <span class="text-muted">{{$product['desc']}}</span>
                                                </td>
                                                <td class="text-start">{{$product['qty']}}</td>
                                                <td class="text-start">
                                                    {{ number_format($product['price'], 2, ',', '.') }}₺
                                                </td>
                                                <td class="text-start">
                                                    {{ number_format($product['price'] * $product['qty'], 2, ',', '.') }}
                                                    ₺
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

        </div>
        <!--end::Post-->
    </div>

@endsection
