@extends('layouts.dashboard')
@section('content')

    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="row g-5 g-xl-8">
                <div class="col-xl-4 mb-xl-10">
                    <!--begin::Lists Widget 19-->
                    <div class="card card-flush h-xl-100">
                        <!--begin::Heading-->
                        <div
                            class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px"
                            style="background-image:url('assets/media/svg/shapes/top-green.png" data-bs-theme="light">
                            <!--begin::Title-->
                            <h3 class="card-title align-items-start flex-column text-white pt-15">
                                @if(auth()->user()->hasRole('Yönetici'))
                                    <span class="fw-bold fs-2x mb-3">Başvurular</span>
                                @else
                                    <span class="fw-bold fs-2x mb-3">Başvurularım</span>
                                @endif
                                <div class="fs-4 text-white">
                                    @php
                                        $count = 0;
                                    @endphp
                                    @forelse($Types as $type)
                                        @php
                                            $count += $type->application_counts();
                                        @endphp
                                    @empty
                                    @endforelse

                                    <span
                                        class="opacity-75">Toplam {{$count}} @if(auth()->user()->hasRole('Yönetici'))
                                            başvuru
                                        @else
                                            başvurunuz
                                        @endif var.</span>
                                </div>
                            </h3>
                        </div>
                        <!--end::Heading-->
                        <!--begin::Body-->
                        <div class="card-body mt-n20">
                            <!--begin::Stats-->
                            <div class="mt-n20 position-relative">
                                <!--begin::Row-->
                                <div class="row g-3 g-lg-6">
                                    <!--begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-30px me-5 mb-8">

                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                <!--begin::Number-->
                                                <a href="basvurular/{{$Types[0]->id}}/tumu"
                                                   class="text-gray-700 fw-bolder  fs-2qx lh-1 ls-n1 mb-1 position-relative">
                                                    {{$Types[0]->application_counts()}}
                                                    @if(auth()->user()->hasRole('Yönetici') && $Types[0]->non_viewed_counts() != 0)
                                                        <span class="notify-span">
                                                            {{$Types[0]->non_viewed_counts()}}
                                                        </span>
                                                    @endif


                                                </a>
                                                <!--end::Number-->
                                                <!--begin::Desc-->
                                                <a href="basvurular/{{$Types[0]->id}}/tumu"
                                                   class="text-gray-500 fw-semibold d-block fs-6">{{$Types[0]->title}}</a>

                                                <!--end::Desc-->
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-30px me-5 mb-8">

                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                <!--begin::Number-->
                                                <a href="basvurular/{{$Types[1]->id}}/tumu"
                                                   class="text-gray-700 fw-bolder  fs-2qx lh-1 ls-n1 mb-1 position-relative">
                                                    {{$Types[1]->application_counts()}}
                                                    @if(auth()->user()->hasRole('Yönetici') && $Types[1]->non_viewed_counts() != 0)
                                                        <span class="notify-span">
                                                            {{$Types[1]->non_viewed_counts()}}
                                                        </span>
                                                    @endif


                                                </a>

                                                <!--end::Number-->
                                                <!--begin::Desc-->
                                                <a href="basvurular/{{$Types[1]->id}}/tumu"
                                                   class="text-gray-500 fw-semibold d-block fs-6">{{$Types[1]->title}}</a>
                                                <!--end::Desc-->
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-12">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-30px me-5 mb-8">

                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                <!--begin::Number-->
                                                <a href="basvurular/{{$Types[2]->id}}/tumu"
                                                   class="text-gray-700 fw-bolder  fs-2qx lh-1 ls-n1 mb-1 position-relative">
                                                    {{$Types[2]->application_counts()}}
                                                    @if(auth()->user()->hasRole('Yönetici') && $Types[2]->non_viewed_counts() != 0)
                                                        <span class="notify-span">
                                                            {{$Types[2]->non_viewed_counts()}}
                                                        </span>
                                                    @endif


                                                </a>
                                                <!--end::Number-->
                                                <!--begin::Desc-->
                                                <a href="basvurular/{{$Types[2]->id}}/tumu"
                                                   class="text-gray-500 fw-semibold d-block fs-6">{{$Types[2]->title}}</a>
                                                <!--end::Desc-->
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>

                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Lists Widget 19-->
                </div>

                <div class="col-xl-8">
                    <div class="row gx-5 gx-xl-8 mb-5 mb-xl-8">
                        <div class="col-xl-3 mb-5 mb-xl-0">
                            <div
                                class="card h-150px bgi-no-repeat bgi-size-cover bgi-position-y-center card-xl-stretch border-0"
                                style="background-color: #F1416C;
background-image: url('assets/media/svg/shapes/wave-bg-red.svg');">
                                <div class="card-body p-6">
                                    <a href="{{route('dashboard.guide.sss')}}"
                                       class="text-white text-hover-primary fw-bold fs-2">Sıkça Sorulan Sorular</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9">
                            <div class="card h-150px card-xl-stretch">
                                @if(auth()->user()->hasRole('Yönetici'))
                                    <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
                                        <div class="me-2">
                                            <h2 class="fw-bold text-gray-800 mb-3">Başvurular</h2>
                                            <div class="text-muted fw-semibold fs-6">
                                                İncelenmemiş {{count($NonViewed)}} başvuru bulunmakta.
                                            </div>
                                        </div>


                                        <a href="{{route('dashboard.application.list')}}"
                                           class="btn btn-primary fw-semibold">+</a>
                                    </div>
                                @else
                                    <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
                                        <div class="me-2">
                                            <h2 class="fw-bold text-gray-800 mb-3">Yeni Başvuru Oluştur</h2>
                                            <div class="text-muted fw-semibold fs-6">
                                                Başvuru formlarını buradan oluşturabilirsiniz.
                                            </div>
                                        </div>
                                        <a href="#" class="btn btn-primary fw-semibold" data-bs-toggle="modal"
                                           data-bs-target="#bl_new_application_type_modal">+</a>

                                        {{-- <a href="{{route('dashboard.application.index')}}" class="btn btn-primary fw-semibold" >+</a>--}}
                                    </div>

                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5 gx-xl-8 mb-5 mb-xl-8">
                        <div class="col-xl-12">
                            <div class="card h-175px bgi-no-repeat bgi-size-contain card-xl-stretch mb-5 mb-xl-8"
                                 style="background-color: #663259; background-position: right; background-image:url('assets/media/svg/misc/taieri.svg')">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h2 class="text-white fw-bold ">Ay Kapama</h2>
                                    @if(auth()->user()->hasRole('Yönetici'))
                                        <span class="text-white mb-5 d-block"> Müşterilere ait ay kapama hesaplamalarını görüntüleyin. </span>
                                    @else
                                        <span class="text-white mb-5 d-block"> İstediğiniz aya ait onaylanmış başvurularınız için örnek fatura oluşturun. </span>
                                    @endif
                                    <div class="m-0">
                                        <a href='{{route('dashboard.application.closure')}}'
                                           class="btn btn-danger fw-semibold px-6 py-3">Oluştur</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row gx-5 gx-xl-8">
                                {{--@forelse($allResults as $key => $r)

                                    <div class="col-sm-4 mb-5 mb-xl-10">
                                        <!--begin::List widget 1-->
                                        <div class="card card-flush h-lg-100">
                                            <!--begin::Header-->
                                            <div class="card-header pt-5">
                                                <!--begin::Title-->
                                                <a href="/basvurular/{{$slugs[$key]}}" class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bold text-gray-900">{{$key}}</span>
                                                </a>

                                            </div>
                                            <div class="card-body pt-5">
                                                @forelse($r as $a => $c)
                                                    @if($a == 'Taslak')
                                                    @else
                                                        <div class="d-flex flex-stack">
                                                            <div
                                                                class="text-gray-700 fw-semibold fs-6 me-2">{{$a}}</div>
                                                            <div class="d-flex align-items-senter">

                                                                <span class="text-gray-900 fw-bolder fs-6">{{$c}}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @empty
                                                @endforelse

                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse--}}

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row gy-5 g-xl-12">

                <div class="col-xl-12">
                    <div class="card card-xl-stretch">
                        <div class="card-header align-items-center border-0 mt-4">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="fw-bold mb-2 text-gray-900">Hareketler</span>
                            </h3>
                            <div class="card-toolbar">
                                <button type="button"
                                        class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="ki-duotone ki-category fs-6">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </button>

                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="timeline-label">
                            @forelse($Activities as $l)
    <div class="timeline-item">
        <div class="timeline-label fw-bold text-gray-800 fs-6">
            {{$l->getFormattedCreatedAtAttribute()}}
            <br>
            <span class="text-muted">{{$l->created_at->format('H:i')}}</span>
        </div>
        <div class="timeline-badge">
            <i class="fa fa-genderless text-success fs-1"></i>
        </div>
        <div class="timeline-content">
            <p class="fw-semibold text-gray-800 ps-3">
                
            @if(auth()->user()->hasRole('Yönetici'))
            
                    {!! $l->description !!}
            @else
            @if($l->causer->hasRole('Yönetici'))
                    @php
                        $description = str_replace($l->causer->name, 'Bilstein Yöneticisi', $l->description);
                    @endphp
                    {!! $description !!}
                @else
                    {!! $l->description !!}
                @endif
            @endif
            </p>
        </div>
    </div>
@empty
@endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    </div>
@endsection
@section('modals')
    @include('dashboard.modals.new-application')
@endsection
