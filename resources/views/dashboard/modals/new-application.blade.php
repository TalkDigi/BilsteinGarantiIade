<div class="modal fade" id="kt_modal_two_factor_authentication" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">

            <div class="modal-body scroll-y pt-10 pb-15 px-lg-17">
                <div class="btn btn-sm btn-icon btn-active-color-primary new-application-close" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <div data-kt-element="options">

                    <p class="text-muted fs-5 fw-semibold mb-10 text-center">
                        Başvuru tipinize uygun seçeneği seçerek sürece devam edebilirsiniz.
                    </p>

                    <form class="pb-10" method="POST" action="{{route('dashboard.application.create.redirect')}}">

                        @csrf



                        <input type="radio" class="btn-check" name="application_type" value="ilave-masraf-iceren-basvuru"
                               id="ilave-masraf-iceren-basvuru"/>
                        <label
                            class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5"
                            for="ilave-masraf-iceren-basvuru">
                            <i class="ki-duotone ki-message-text-2 fs-4x me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <span class="d-block fw-semibold text-start">
                                <span class="text-gray-900 fw-bold d-block fs-3">İlave Masraf İçeren Başvuru</span>
                                {{--<span class="text-muted fw-semibold fs-6">We will send a code via SMS if you need to use your backup login method.</span>--}}
                            </span>
                        </label>

                        <input type="radio" class="btn-check" name="application_type" value="masraf-icermeyen-basvuru"
                               id="masraf-icermeyen-basvuru"/>
                        <label
                            class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5"
                            for="masraf-icermeyen-basvuru">
                            <i class="ki-duotone ki-message-text-2 fs-4x me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <span class="d-block fw-semibold text-start">
                                <span class="text-gray-900 fw-bold d-block fs-3">Masraf İçermeyen Başvuru</span>
                                {{--<span class="text-muted fw-semibold fs-6">We will send a code via SMS if you need to use your backup login method.</span>--}}
                            </span>
                        </label>

                        <input type="radio" class="btn-check" name="application_type" value="hasarli-eksik-parca-bildirimi"
                               id="hasarli-eksik-parca-bildirimi"/>
                        <label
                            class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center"
                            for="hasarli-eksik-parca-bildirimi">
                            <i class="ki-duotone ki-message-text-2 fs-4x me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <span class="d-block fw-semibold text-start">
                                <span class="text-gray-900 fw-bold d-block fs-3">Hasarlı Parça Bildirimi</span>
										{{--<span class="text-muted fw-semibold fs-6">We will send a code via SMS if you need to use your backup login method.</span>--}}
                            </span>
                        </label>
                        <button class="btn btn-primary w-100 mt-5" type="submit">Devam Et</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
