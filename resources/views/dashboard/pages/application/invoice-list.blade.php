@extends('layouts.dashboard')
@section('content')
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
						<!--begin::Post-->
						<div class="content flex-row-fluid" id="kt_content">
							<!--begin::Products-->
							<div class="card card-flush">
								<!--begin::Card header-->
								<div class="card-header align-items-center py-5 gap-2 gap-md-5">

									<div class="card-title">
                                        @if(isset($type))
                                            <h3>{{$type['title']}}</h3>
                                        @else
                                            <h3>Faturalar</h3>
                                        @endif
                                        @if(session()->has('claim_number'))
                            <div class="card-toolbar">
                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary">View Claim {{session('claim_number')}}</a>

                            </div>
                        @endif
									</div>

                                    <div class="card-title">
                                        <!--begin::Search-->
										<div class="d-flex align-items-center position-relative my-1">
                                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                                <span class="path1"></span>
												<span class="path2"></span>
											</i>
											<input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Fatura No Ara" />
										</div>
										<!--end::Search-->
                                    </div>
									<!--end::Card toolbar-->
								</div>
								<!--end::Card header-->
								<!--begin::Card body-->
								<div class="card-body pt-0">
									<!--begin::Table-->
									<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
										<thead>
											<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                <th class="text-start">#</th>
												<th class="text-start min-w-100px">Fatura No</th>
												<th class="text-start min-w-100px">Şube</th>
												<th class="text-start min-w-70px">Tarih</th>
												<th class="text-start min-w-100px">Tutar</th>
                                                <th class="text-start min-w-100px">İşlem</th>
											</tr>
										</thead>
										<tbody class="fw-semibold text-gray-600">
											@forelse($Invoices as $invoice)
                                                <tr>
                                                    <td class="text-start pe-0">
                                                        {{$loop->iteration}}
                                                    </td>
                                                    <td class="text-start pe-0">
                                                        <div class="d-flex align-items-center">
                                                            {{$invoice->InvoiceNo}}
                                                        </div>
                                                    </td>
                                                    <td class="text-start pe-0">
                                                        <span class="fw-bold">{{$invoice->Branch}}</span>
                                                    </td>
                                                    <td class="text-start pe-0" data-order="22">
                                                        <span class="fw-bold ms-3">{{ \Carbon\Carbon::parse($invoice->PostingDate)->format('d/m/Y') }}</span>
                                                    </td>
												    <td class="text-start pe-0">{{$invoice->AmtIncVAT}}</td>
                                                    <td class="text-start">
                                                        <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">İşlemler
                                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                        <!--begin::Menu-->
                                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item px-3">
                                                                <a href="{{route('dashboard.application.index',['type' => $type['slug'], $invoice->InvoiceNo])}}" class="menu-link px-3">Başvuru Oluştur</a>
                                                            </div>
                                                            <!--end::Menu item-->
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item px-3">
                                                                <a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">İçeriği Gör</a>
                                                            </div>
                                                            <!--end::Menu item-->
                                                        </div>
                                                        <!--end::Menu-->
                                                    </td>
                                                </tr>
                                                @empty
                                           @endforelse

										</tbody>
									</table>
									<!--end::Table-->
								</div>
								<!--end::Card body-->
							</div>
							<!--end::Products-->
						</div>
						<!--end::Post-->
					</div>

    @endsection
@section('modals')
    @include('dashboard.modals.new-application')
@endsection

@section('scripts')
    <script src="{{asset('assets/js/custom/apps/ecommerce/catalog/products.js')}}"></script>

@endsection
