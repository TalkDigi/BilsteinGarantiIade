@extends('layouts.dashboard')
@section('content')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Inbox App - Messages -->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Sidebar-->
                <div class="d-none d-lg-flex flex-column flex-lg-row-auto w-100 w-lg-275px" data-kt-drawer="true"
                    data-kt-drawer-name="inbox-aside" data-kt-drawer-activate="{default: true, lg: false}"
                    data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start"
                    data-kt-drawer-toggle="#kt_inbox_aside_toggle">
                    <!--begin::Sticky aside-->
                    <div class="card card-flush mb-0" data-kt-sticky="false" data-kt-sticky-name="inbox-aside-sticky"
                        data-kt-sticky-offset="{default: false, xl: '100px'}" data-kt-sticky-width="{lg: '275px'}"
                        data-kt-sticky-left="auto" data-kt-sticky-top="100px" data-kt-sticky-animation="false"
                        data-kt-sticky-zindex="95">
                        <!--begin::Aside content-->
                        <div class="card-body application-card-body">
                            <!--begin::Button-->
                            <a data-bs-toggle="modal" data-bs-target="#kt_modal_two_factor_authentication" class="btn btn-primary fw-bold w-100 mb-8">
								Yeni Başvuru +
							</a>

                             <!--begin::Menu item-->
                                <a class="menu-item mb-3" href="{{route('dashboard.application.list')}}">
                                    <!--begin::Inbox-->
                                    <span class="menu-link active">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-abstract-12">
											<span class="path1"></span>
											<span class="path2"></span>
											</i>
                                        </span>
                                        <span class="menu-title fw-bold">Tümü</span>
                                        {{--<span class="badge badge-light-grey">{{count($Applications)}}</span>--}}
                                    </span>
                                    <!--end::Inbox-->
                                </a>
                                <!--end::Menu item-->

                            @foreach ($Types as $key => $type)
									<a class="menu-item mb-3 " href="{{route('dashboard.application.listFilter',['type'=>$key,'tip'=>'tumu'])}}">
										<span class="menu-link">
											<span class="menu-icon">
												<span class="svg-icon"><svg class=" . h-20px w-20px .  " width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M2 21V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V21C22 21.6 21.6 22 21 22H3C2.4 22 2 21.6 2 21Z" fill="currentColor"></path>
                                                <path d="M2 10V3C2 2.4 2.4 2 3 2H21C21.6 2 22 2.4 22 3V10C22 10.6 21.6 11 21 11H3C2.4 11 2 10.6 2 10Z" fill="currentColor"></path>
                                                </svg>
                                                </span>
											</span>
											<span class="menu-title fw-bold text-gray-700">{{$type['title']}}</span>
											{{--<span class="badge badge-light-{{$status['color']}}">{{$statusCounts[$key]}}</span>--}}

										</span>
									</a>
                                @endforeach
                            <!--end::Button-->
                            <div class="separator mb-5 mt-5"></div>
                            <!--begin::Menu-->
                            <div
                                class="menu menu-column menu-rounded menu-state-bg menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary mb-10">

								@php
									$allStatus = App\Models\Application::getStatusArray();
								@endphp

                                @foreach ($allStatus as $key => $status)
									<a class="menu-item mb-3 " href="{{route('dashboard.application.listFilter',['type'=>$basvuru_turu,'tip'=>$status['slug']])}}">

										<span class="menu-link @if(isset($tip) && $tip === $status['slug']) active @endif">
											<span class="menu-icon">
												<i class="ki-duotone ki-abstract-8 fs-5 text-{{$status['color']}} me-3 lh-0">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
											</span>
											<span class="menu-title fw-bold text-gray-700">{{$status['name']}}</span>
											<span class="badge badge-light-{{$status['color']}}">{{$statusCounts[$key]}}</span>

										</span>
									</a>
                                @endforeach


                            </div>

                        </div>
                        <!--end::Aside content-->
                    </div>
                    <!--end::Sticky aside-->
                </div>
                <!--end::Sidebar-->
                <!--begin::Content-->
                <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
                    <!--begin::Card-->
                    <div class="card">
                        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                            <!--begin::Actions-->
                            <div class="d-flex flex-wrap gap-2">

                                <span>

                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3"
                                                data-kt-inbox-listing-filter="filter_newest">Newest</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3"
                                                data-kt-inbox-listing-filter="filter_oldest">Oldest</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3"
                                                data-kt-inbox-listing-filter="filter_unread">Unread</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </span>
                                <!--end::Sort-->
                            </div>
                            <!--end::Actions-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative">
                                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="text" data-kt-inbox-listing-filter="search"
                                        class="form-control form-control-sm form-control-solid mw-100 min-w-125px min-w-lg-150px min-w-xxl-200px ps-11"
                                        placeholder="Ürün veya Fatura No İle Ara" />
                                </div>

                            </div>
                            <!--end::Actions-->
                        </div>
                        <div class="card-body">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered fs-6 gy-5" id="kt_ecommerce_products_table">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">

										<th class="min-w-100px">#</th>
										<th class="text-center min-w-100px">Fatura No</th>
										<th class="text-center min-w-70px">Ürün Adedi</th>
										<th class="text-center min-w-100px">Ürün Miktarı</th>
										<th class="text-center min-w-70px">Durum</th>
                                        <th class="text-center">Oluşturma Tarihi</th>
                                        <th class="text-center">Güncelleme Tarihi</th>
										<th class="text-center min-w-70px">Eylemler</th>
									</tr>
								</thead>
								<tbody class="fw-semibold text-gray-600">
									@forelse($Applications as $a)
										<tr>
											<td>
												<span class="fw-bold">{{$a->claim_number}}</span>
											</td>
											<td class="text-center pe-0">
												<span class="fw-bold">{{$a->invoice}}</span>
											</td>
											<td class="text-center pe-0">
												<span class="fw-bold ms-3">{{$a->productCount()}}</span>
											</td>
											<td class="text-center pe-0">{{$a->productQuantities()}}</td>

											<td class="text-center pe-0" data-order="Inactive">
												{!!$a->getStatusBadge()!!}
											</td>

                                            <td class="text-center">
                                                <span class="fw-bold">{{$a->created_at->format('d/m/Y H:i')}}</span>
                                            </td>

                                            <td class="text-center">
                                                <span class="fw-bold">{{$a->updated_at->diffForHumans()}}</span>
                                            </td>

											@if(auth()->user()->hasRole('Yönetici'))
                                                <td class="text-center">
                                                    <a href="{{route('dashboard.application.show',['claim' => $a->claim_number])}}" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary">İncele</a>
                                                </td>
                                            @endif
                                            @if(auth()->user()->hasRole('Kullanıcı'))
                                                @if($a->editable)
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Eylemler
                                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                        <!--begin::Menu-->
                                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item px-3">
                                                                <a href="{{route('dashboard.application.show',['claim' => $a->claim_number])}}" class="menu-link px-3">İncele</a>
                                                            </div>
                                                            <!--end::Menu item-->
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item px-3">
                                                                <a href="{{route('dashboard.application.edit',['claim' => $a->claim_number])}}" class="menu-link px-3" >Düzenle</a>
                                                            </div>
                                                            <!--end::Menu item-->
                                                        </div>
                                                        <!--end::Menu-->
                                                    </td>
                                                @else
                                                    <td class="text-center">
                                                        <a href="{{route('dashboard.application.show',['claim' => $a->claim_number])}}" class="menu-link px-3">İncele</a>

                                                    </td>

                                                @endif
                                            @endif
										</tr>
										@empty
									@endforelse

								</tbody>
							</table>
                            <!--end::Table-->
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Inbox App - Messages -->
        </div>
        <!--end::Post-->
    </div>
@endsection
@section('modals')
    @include('dashboard.modals.new-application')
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/products.js') }}"></script>
@endsection
