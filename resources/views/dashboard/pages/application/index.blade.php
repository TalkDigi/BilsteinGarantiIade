@extends('layouts.dashboard')
@section('content')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl" style="max-width:1600px">
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
                            <a data-bs-toggle="modal" id="bl_new_application_type_modal_button" data-bs-target="#bl_new_application_type_modal"
                               class="btn btn-primary fw-bold w-100 mb-8">
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

                            {{--https://garanti.test/basvurular/1/tumu--}}

                            {{--get id from url--}}

                            @foreach ($Types as $key => $type)
                                <a class="menu-item mb-3 "
                                   href="{{route('dashboard.application.listFilter',['type'=>$type->id,'tip'=>'tumu'])}}">
										<span class="menu-link @if(request()->route('type') == $type->id) activeCat @endif">
											<span class="menu-icon">
												<span class="svg-icon"><svg class=" . h-20px w-20px .  " width="24"
                                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3"
                                                      d="M2 21V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V21C22 21.6 21.6 22 21 22H3C2.4 22 2 21.6 2 21Z"
                                                      fill="currentColor"></path>
                                                <path
                                                    d="M2 10V3C2 2.4 2.4 2 3 2H21C21.6 2 22 2.4 22 3V10C22 10.6 21.6 11 21 11H3C2.4 11 2 10.6 2 10Z"
                                                    fill="currentColor"></path>
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
                                    $allStatus = App\Models\Status::get()->toArray();
                                    //group by id
                                $allStatusById = [];
                                foreach ($allStatus as $key => $status) {
                                    $allStatusById[$status['id']] = $status;
                                }
                                @endphp

                                @foreach ($allStatusById as $key => $status)
                                    <a class="menu-item mb-3 "
                                       href="{{route('dashboard.application.listFilter',['type'=>$basvuru_turu,'tip'=>$status['slug']])}}">

										<span
                                            class="menu-link @if(isset($tip) && $tip === $status['slug']) active @endif">
											<span class="menu-icon">
												<i class="ki-duotone ki-abstract-8 fs-5 text-{{$status['color']}} me-3 lh-0">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
											</span>
											<span class="menu-title fw-bold text-gray-700">{{$status['name']}}</span>
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
                            @if(auth()->user()->hasRole('Yönetici'))
                            <select class="form-select form-select-solid form-select-lg customer-select" id="customer-select" data-control="select2"
                                            data-hide-search="true" name="CustNo">
                                            <option value="">Müşteri Seçin</option>
                                            <option value="all">Tümü</option>

                                            @forelse($Customers as $customer)
                                                <option value="{{ $customer->No }}">{{ $customer->No }} -
                                                    {{ $customer->SearchName }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    @endif

                                    @if(auth()->user()->hasRole('Şube Yöneticisi') && auth()->user()->customer->branches->isNotEmpty())
                            <select class="form-select form-select-solid form-select-lg branch-select" id="branch-select" data-control="select2"
                                            data-hide-search="true" name="branchID">
                                            <option value="">Şube Seçin</option>
                                            <option value="all">Tümü</option>

                                            @forelse(auth()->user()->customer->branches as $branch)
                                                <option value="{{ $branch->BranchName }}">
                                                    {{ $branch->BranchName }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    @endif
                           

                            </div>
                            <!--end::Actions-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <!--begin::Search-->
                                <form class="d-flex align-items-center position-relative" method="POST"
                                      action="{{route('dashboard.application.claim_search')}}">
                                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>

                                    @csrf
                                    <input type="text" data-kt-inbox-listing-filter="search"
                                           class="form-control form-control-sm form-control-solid mw-100 min-w-125px min-w-lg-150px min-w-xxl-200px ps-11"
                                           placeholder="Başvuru No Ara" name="search"/>
                                    <button class="btn btn-primary">Ara</button>

                                </form>

                            </div>
                            <!--end::Actions-->
                        </div>
                        <div class="card-body">
                            @if(isset($Applications) && !$Applications->isEmpty())
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered fs-6 gy-5"
                                       id="kt_ecommerce_products_table">
                                    <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="text-center">#</th>
                                        <th class="text-center">Başvuru No</th>
                                        <th class="text-center">Müşteri</th>
                                        <th class="text-center">Bayi</th>
                                        <th class="text-center">Durum</th>
                                        <th class="text-center">Tip</th>
                                        <th class="text-center">Ay Kapama</th>
                                        <th class="text-center">Oluşturma Tarihi</th>
                                        <th class="text-center">Güncelleme Tarihi</th>
                                        <th class="text-center">Eylemler</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                    @forelse($Applications as $a)
                                        <tr data-customer-no="{{$a->getUser->customer->No}}">
                                            <td>{{$a->id}}</td>
                                            <td>
                                                <span class="fw-bold">{{$a->claim_number}}</span>
                                            </td>

                                            <td>
                                                <span
                                                    class="fw-bold"> {{$a->getUser->customer->No}} - {{$a->getUser->customer->SearchName}}</span>
                                            </td>

                                            <td>
                                                
                                            @if(!empty($a->BranchNo))
                                                <span class="fw-bold">{{$a->branch->BranchName}}</span>
                                            @endif
                                            </td>

                                            <td class="text-center pe-0" data-order="Inactive">
                                                {!!$a->getStatus->html!!}
                                            </td>

                                            <td>
                                                <span style="font-size: 12px">{{$a->getType()->title}}</span>
                                            </td>
                                            <td>
                                                @if(isset($FilteredClosures[$a->claim_number]))
                                                <a href="{{route('dashboard.application.closure-show',['uuid' => $FilteredClosures[$a->claim_number]['uuid']])}}"
                                                   class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary">
                                                    {{$FilteredClosures[$a->claim_number]['month']}} / {{$FilteredClosures[$a->claim_number]['year']}}
                                                </a>
                                                @else
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <span class="fw-bold">{{$a->created_at->format('d/m/Y H:i')}}</span>
                                            </td>

                                            <td class="text-center">
                                                <span class="fw-bold">{{$a->updated_at->diffForHumans()}}</span>
                                            </td>

                                            <td class="text-center">
                                                <a href="{{route('dashboard.application.show',['claim' => $a->claim_number])}}"
                                                   class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary">İncele</a>
                                            </td>


                                        </tr>
                                    @empty

                                    @endforelse

                                    </tbody>
                                </table>
                                <!--end::Table-->
                            @else
                                <div class="alert alert-warning d-flex align-items-center p-5 mb-10">
                                    <i class="ki-duotone ki-shield-tick fs-2hx text-warning me-4"><span
                                            class="path1"></span><span class="path2"></span></i>
                                    <div class="d-flex flex-column">
                                        <span>Başvuru bulunamadı.</span>
                                    </div>
                                </div>
                            @endif
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
    <script>
   $(document).ready(function() {
    // DataTable'ı başlat
    var table = $('#kt_ecommerce_products_table').DataTable();
    
    $('#customer-select').change(function() {
        var selectedCustomer = $(this).val();
        
        if (selectedCustomer === 'all') {
            table.column(2).search('').draw(); // 2. sütun müşteri sütunu
        } else {
            table.column(2).search(selectedCustomer).draw();
        }
    });

    $('#customer-select').change(function() {
        var selectedCustomer = $(this).val();
        
        if (selectedCustomer === 'all') {
            table.column(2).search('').draw(); // 2. sütun müşteri sütunu
        } else {
            table.column(2).search(selectedCustomer).draw();
        }
    });

    $('#branch-select').change(function() {
        var selectedBranch = $(this).val();
        
        if (selectedBranch === 'all') {
            table.column(3).search('').draw(); // 3. sütun şube sütunu
        } else {
            table.column(3).search(selectedBranch).draw();
        }
    });
});
</script>


    </script>
@endsection
