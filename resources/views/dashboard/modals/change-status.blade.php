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
                    <div class="text-muted fw-semibold fs-5 mb-5">{!! $Application->getStatusBadge()  !!} >
                        <div class="newStatus d-inline-block"></div>
                    </div>

                </div>
                <form action="{{route('dashboard.application.update_status_with_message')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="text-muted fw-semibold fs-5 mb-5 text-center">Başvuru sahibine gösterilecek metin.
                        </div>
                        <textarea class="form-control" data-kt-autosize="true" name="message" required></textarea>
                        <input type="hidden" name="new_status" class="newStatus" required>
                        <input type="hidden" name="claim_number" value="{{$Application->claim_number}}" required>

                    </div>
                    <div class="form-group mt-5">
                        <div class="fv-row">
                            <div class="text-muted fw-semibold fs-5 mb-5 text-center">Müşteriye İletilecek Dökümanlar (Varsa)</div>
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
                    <div class="d-flex justify-content-center pt-15">
                        <button type="submit" class="btn btn-primary me-3">Kaydet</button>
                        <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">İptal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
