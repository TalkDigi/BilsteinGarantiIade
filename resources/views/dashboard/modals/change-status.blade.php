<div class="modal fade" id="change_status" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header pb-0 border-0 justify-content-end">
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                <div class="text-center mb-13">
                    <h1 class="mb-3">Durum Değiştir</h1>
                    <div class="text-muted fw-semibold fs-5 mb-5">{!! $Status->html  !!} >
                        <div class="newStatus d-inline-block"></div>
                    </div>


                </div>
                <form action="{{route('dashboard.application.update_status_with_message')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="text-muted fw-semibold fs-5 mb-5 text-center">Başvuru sahibine gösterilecek metin.
                        </div>
                        <textarea class="form-control" data-kt-autosize="true" name="message"></textarea>
                        <input type="hidden" name="new_status" class="newStatus" required>
                        <input type="hidden" name="claim_number" value="{{$Application->claim_number}}" required>

                    </div>

                    @if($Application->getType()->has_additional_payment)
                        <div class="flex-row-fluid mb-5 mt-5 accepted_cost">
                            <div class="fv-row flex-row-fluid cost_request position-relative">
                                <label class="form-label">Onaylanan Masraf Tutarı</label>
                                <input class="form-control" name="accepted_cost" type="text" required
                                       @if (isset($Application->application['cost_request'])) value="{{ $Application->application['cost_request'] }}"
                                       @endif
                                       pattern="\d+(,\d{1,2})?"
                                       oninput="this.value = this.value.replace(/[^0-9,]/g, '').replace(/(,.*?),/g, '$1');"/>
                                <span>₺</span>
                            </div>
                        </div>

                    @endif
                    <div class="form-group mt-5">
                        <div class="fv-row">
                            <div class="text-muted fw-semibold fs-5 mb-5 text-center">Müşteriye İletilecek Dökümanlar
                                (Opsiyonel)
                            </div>
                            <div class="dropzone" id="dropZone10">
                                <div class="dz-message needsclick">
                                    <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span
                                            class="path2"></span></i>

                                    <div class="ms-4 d-flex justify-content-center align-items-center">
                                        <h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları sürükleyin veya tıklayarak
                                            seçim yapın.</h3>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="files[support]" id="dropZone10Input">
                        </div>
                    </div>
                    <div class="form-group mt-5 flex-wrap-reverse formChangeInputs" style="display:none">
                        {{debug($CatInputs)}}

                        @foreach ($FileMatches as $input => $description)
                        @if (!in_array($input, $CatInputs['files']) && !in_array($input, $CatInputs['application']))
                            @continue;
                        @endif
                        <div class="form-check form-check-custom form-check-solid mt-3">

                                <input class="form-check-input" type="checkbox" name="inputs[]" value="{{$input}}"
                                       id="input{{$input}}">
                                <label for="input{{$input}}">
                                    {{$description}}
                                </label>
                            </div>
                            @endforeach
                    </div>
                    <div class="d-flex justify-content-center pt-15">
                        <button type="submit" class="btn btn-primary me-3">Kaydet</button>
                        <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">İptal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
