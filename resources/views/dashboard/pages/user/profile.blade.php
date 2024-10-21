@extends('layouts.dashboard')
@section('content')
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::FAQ card-->
        <div class="card">
            <!--begin::Body-->
            <div class="card-body p-lg-15">
                <!--begin::Classic content-->
                <div class="mb-13">
                    <!--begin::Intro-->
                    <div class="mb-15">
                        <!--begin::Title-->
                        <h4 class="fs-2x text-gray-800 w-bolder mb-6">Profil</h4>
                        <!--end::Title-->
                        <!--begin::Text-->
                        <p class="fw-semibold fs-4 text-gray-600 mb-2">Profilinize dair bilgileri bu sayfadan
                            görüntüleyebilir, şifrenizi değiştirebilirsiniz.</p>
                        <!--end::Text-->
                    </div>
                    <!--end::Intro-->

                    <!--begin::Alerts-->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                </div>

            </div>
            <!--end::Body-->
        </div>

        <div class="card mb-5 mt-5 6mb-xl-10">
            <!--begin::Content-->
            <div id="kt_account_settings_profile_details" class="collapse show">
                <!--begin::Form-->
                <form id="kt_account_profile_details_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                    novalidate="novalidate" action="{{route('user.profile.update')}}" method="POST">
                    @csrf
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">


                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label  fw-semibold fs-6">Kullanıcı Adı</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                        <input type="text" disabled
                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                            value="{{$user->name}}">
                                        <div
                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                        </div>
                                    </div>

                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label  fw-semibold fs-6">E-Posta</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <input type="text" disabled class="form-control form-control-lg form-control-solid"
                                    value="{{$user->email}}">
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label  fw-semibold fs-6">Müşteri</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <input type="text" disabled class="form-control form-control-lg form-control-solid"
                                    value="{{!is_null($user->customer) ? $user->customer->Name : ''}}">
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <div class="position-relative hrDivider">
                            <style>
                                .hrDivider {
                                    margin: 50px 0px;
                                }

                                .hrDivider span {
                                    position: absolute;
                                    top: -10px;
                                    background: white;
                                    left: 45%;
                                    font-weight: bold;
                                    color: rgba(130, 125, 125, 0.67);
                                    padding: 0px 10px;
                                }
                            </style>
                            <hr>

                            <span class="">Şifre Değiştir</span>
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span class="required">Eski Şifre</span>
                            </label>
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <input type="password" name="old_password" required
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Eski şifrenizi giriniz." value="">
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">

                                </div>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span class="required">Yeni Şifre</span>
                            </label>
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <input type="password" name="new_password" required
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Yeni şifrenizi giriniz." value="">
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">

                                </div>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span class="required">Yeni Şifre (Tekrar)</span>
                            </label>
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <input type="password" name="new_password_confirmation" required
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Yeni şifrenizi giriniz." value="">
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">

                                </div>
                            </div>
                            <!--end::Col-->
                        </div>

                    </div>
                    <!--end::Card body-->

                    <!--begin::Actions-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" class="btn btn-primary"
                            id="kt_account_profile_details_submit">Kaydet</button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::FAQ card-->
    </div>
    <!--end::Post-->
</div>
@endsection