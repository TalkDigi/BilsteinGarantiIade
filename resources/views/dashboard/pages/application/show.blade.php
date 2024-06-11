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
                                           class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">{{$Application->claim_number}}</a>
                                        {!!$Application->getStatusBadge()!!}
                                    </div>
                                    <!--end::Status-->
                                    <!--begin::Description-->
                                    <div
                                        class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-500">{{$Application->getTypeTitle() }}</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Details-->
                                <!--begin::Actions-->
                                <div class="d-flex mb-4">
                                    @if(auth()->user()->hasRole('Yönetici'))

                                         <a href="{{route('dashboard.application.update_status',[2,$Application->claim_number])}}" class="btn btn-sm btn-warning me-3">Ön Onay Bekleniyor</a>

                                         <a href="#" class="btn btn-sm btn-success me-3 changeStatusButton"
                                       data-bs-toggle="modal" data-bs-target="#change_status" data-status-id="3">Onayla</a>

                                       <a href="#" class="btn btn-sm btn-info me-3 changeStatusButton"
                                       data-bs-toggle="modal" data-bs-target="#change_status" data-status-id="4">Düzenleme İste</a>

                                       <a href="#" class="btn btn-sm btn-danger me-3 changeStatusButton"
                                       data-bs-toggle="modal" data-bs-target="#change_status" data-status-id="5">Reddet</a>

                                    @endif

                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Head-->
                            <!--begin::Info-->
                            <div class="d-flex flex-wrap justify-content-start">
                                <!--begin::Stats-->
                                <div class="d-flex flex-wrap">
                                    <!--begin::Stat-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="fs-4 fw-bold">{{$Application->getLocaleCreatedAtAttribute()}}</div>
                                        </div>
                                        <!--end::Number-->
                                        <!--begin::Label-->
                                        <div class="fw-semibold fs-6 text-gray-500">Oluşturma Tarihi</div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->
                                    <!--begin::Stat-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="fs-4 fw-bold">{{$Application->updated_at->diffForHumans()}}</div>
                                        </div>
                                        <!--end::Number-->
                                        <!--begin::Label-->
                                        <div class="fw-semibold fs-6 text-gray-500">Güncelleme Tarihi</div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->
                                    <!--begin::Stat-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <div class="fs-4 fw-bold">{{$Application->productCount()}}</div>
                                        </div>
                                        <!--end::Number-->
                                        <!--begin::Label-->
                                        <div class="fw-semibold fs-6 text-gray-500">Ürün</div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->
                                    <!--begin::Stat-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <div class="fs-4 fw-bold">
                                                @if($Application->editable)
                                                    <span class="badge badge-light-success">Düzenlenebilir</span>
                                                @else
                                                    <span class="badge badge-light-danger">Kapalı</span>
                                                @endif
                                            </div>
                                        </div>
                                        <!--end::Number-->
                                        <!--begin::Label-->
                                        <div class="fw-semibold fs-6 text-gray-500">Düzenleme Durumu</div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->
                                </div>
                                <!--end::Stats-->

                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Wrapper-->
                    </div>

                    @if($StatusDetail['hasNotes'] && !is_null($Message))
                        <div class="alert alert-{{$StatusDetail['color']}} d-flex align-items-center p-5">
                        <!--begin::Icon-->
                        <i class="ki-duotone ki-shield-tick fs-2hx text-{{$StatusDetail['color']}} me-4"><span class="path1"></span><span class="path2"></span></i>
                        <!--end::Icon-->

                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column">
                            <!--begin::Title-->
                            <h4 class="mb-1 text-dark">Durum değişikliğine dair;</h4>
                            <!--end::Title-->

                            <!--begin::Content-->
                            <span class="text-dark">{{$Message}}</span>
                            <!--end::Content-->



                            @if(!is_null($Files) && !empty($Files))
                                @if($Files[0] !== "")
                                    <ul class="pl-0 mt-5">
                                    @foreach($Files as $file)
                                        <li>
                                            <a href="{{Storage::url($file)}}" target="_blank">{{$file}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                    @endif
                                @endif

                            @if($StatusDetail['canEdit'])
                                @if(auth()->user()->hasRole('Kullanıcı'))
                                    <a href="{{route('dashboard.application.edit', [$Application->claim_number])}}">Başvuruyu Düzenle</a>
                                @endif
                            @endif
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Alert---->
                    @endif
                    <!--end::Details-->
                    <div class="separator"></div>
                    <!--begin::Nav-->
                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                        <!--begin::Nav item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary py-5 me-6 active" href="javascript:void()">Genel</a>
                        </li>

                    </ul>
                    <!--end::Nav-->
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
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                    <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-175px">Ürün</th>
                                        <th class="min-w-100px text-end">Kod</th>
                                        <th class="min-w-100px text-end">Marka</th>
                                        <th class="min-w-70px text-end">Adet</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">

                                    @forelse($Application->getProductDetails() as $product)
                                        {{debug($product['product'])}}
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-5">
                                                        <p class="fw-bold text-gray-600 text-hover-primary">
                                                            {{$product['product']->Name}}
                                                        </p>
                                                    </div>
                                                    <!--end::Title-->
                                                </div>
                                            </td>
                                            <td class="text-end">{{$product['product']->No}}</td>
                                            <td class="text-end">{{$product['product']->BrandName}}</td>
                                            <td class="text-end">{{$product['quantity']}}</td>
                                        </tr>

                                    @empty
                                    @endforelse
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-lg-4 mt-5">
                    <div class="card card-xl-stretch">
                        <div class="card-header align-items-center border-0 mt-4">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="fw-bold mb-2 text-gray-900">Hareketler</span>
                            </h3>

                        </div>
                        <div class="card-body pt-5">
                            <div class="timeline-label">

                                @forelse($Logs as $l)
                                    <div class="timeline-item">
                                        <div class="timeline-label fw-bold text-gray-800 fs-6">{{$l->getFormattedCreatedAtAttribute()}} <br>
                                        <span class="text-muted">{{$l->created_at->format('H:i')}}</span>
                                        </div>
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-success fs-1"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <p class="fw-semibold text-gray-800 ps-3">{!! $l->description !!}</p>
                                            {{-- <p   class="fw-mormal text-muted ps-3"></p> --}}
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-lg-8 mt-5">
                    <!--begin::Card-->
                    <div class="card card-flush h-lg-100">
                        <!--begin::Card header-->
                        <div class="card-header mt-6">
                            <!--begin::Card title-->
                            <div class="card-title flex-column">
                                <h3 class="fw-bold mb-1">Başvuru Detayları</h3>
                            </div>

                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body p-9 pt-4">
                            <div class="row">
                                @foreach ($Application->application as $key => $value)
                                    <div>
                                        <b>{{ __('fields.' . $key) }}:</b> <p>{{ $value }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-lg-12 mt-5">
                    <div class="card card-xl-stretch">
                        <div class="card-header align-items-center border-0 mt-4">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="fw-bold mb-2 text-gray-900">Dosyalar</span>
                            </h3>

                        </div>
                        <div class="card-body pt-5">
                            <div class="row">

                                @forelse($FileMatches as $key => $value)
                                    @if(isset($Application->files[$key]))

                                        <div class="col-lg-6">
                                            <h4>{{$value}}</h4>

                                            @if($Application->files[$key] !== "" || !empty($Application->files[$key]))
                                                @forelse($Application->getFiles($key) as $file)
                                                    <p><a href="{{Storage::url('application-files/'.$file)}}" target="_blank">{{$file}}</a></p>
                                                    @empty
                                                @endforelse
                                            @endif
                                        </div>

                                    @endif
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Post-->
    </div>
    @include('dashboard.modals.change-status',['Application' => $Application])
@endsection


@section('after-scripts')

    <script>
        //use Statuses as json
        let statuses = @json($Statuses);

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}","Hata");
            @endforeach
       @endif

            @if(Session::has('success'))
                toastr.success("{{ Session::get('success') }}","Başarılı");
          @endif

    </script>
@endsection
