
<div class="flex-column" data-kt-stepper-element="content">
    <div class="d-flex flex-column gap-5 gap-md-7">
        <div class="d-flex flex-column flex-md-row gap-5">
            <div class="fv-row flex-row-fluid">
                <label class=" form-label">Aracın Markası</label>
                <input class="form-control" name="application[car_brand]"
                       @if(isset($Application->application['car_brand']))
                        value="{{ $Application->application['car_brand'] }}"
                       @endif
                />
            </div>
            <div class="flex-row-fluid">
                <label class="form-label">Model Adı</label>
                <input class="form-control" name="application[car_model]"
                @if(isset($Application->application['car_model']))
                        value="{{ $Application->application['car_model'] }}"
                       @endif
                />
            </div>

        </div>
        <div class="d-flex flex-column flex-md-row gap-5">
            <div class="flex-row-fluid">
                <label class="form-label">Model Yılı</label>
                <input class="form-control" name="application[car_year]"
                    @if(isset($Application->application['car_year']))
                        value="{{ $Application->application['car_year'] }}"
                       @endif
                />
            </div>
            <div class="flex-row-fluid">
                <label class="form-label">Şasi Numarası</label>
                <input class="form-control" name="application[car_number]"
                    @if(isset($Application->application['car_number']))
                        value="{{ $Application->application['car_number'] }}"
                       @endif
                />
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row gap-5">
            <div class="flex-row-fluid">
                <label class="form-label">Onarımın (Montajın) Yapıldığı Tarih</label>
                <input class="form-control" id="datePicker1" type="text" name="application[car_repair_date]"
                    @if(isset($Application->application['car_repair_date']))
                        value="{{ $Application->application['car_repair_date'] }}"
                    @endif
                />
            </div>
        </div>
        <div class="flex-row-fluid">
            <div class="fv-row flex-row-fluid">
                <label class=" form-label">Onarımın (Montajın) Yapıldığı Tarihte Aracın
                    Kilometresi</label>
                <input class="form-control" name="application[car_repair_milage]" type="number"
                    @if(isset($Application->application['car_repair_milage']))
                        value="{{ $Application->application['car_repair_milage'] }}"
                    @endif
                />
            </div>
        </div>
        <div class="flex-row-fluid">
            <div class="fv-row flex-row-fluid">
                <label class="form-label">Sorunun Veya Arızanın Tespit Edildiği
                    Tarih</label>
                <input class="form-control" id="datePicker2" name="application[car_found_date]" type="text"
                    @if(isset($Application->application['car_found_date']))
                        value="{{ $Application->application['car_found_date'] }}"
                    @endif
                />
            </div>
        </div>
        <div class="flex-row-fluid">
            <div class="fv-row flex-row-fluid">
                <label class=" form-label">Sorunun Veya Arızanın Tespit Edildiği Tarihte
                    Aracın Kilometresi</label>
                <input class="form-control" name="application[car_found_milage]" placeholder=""
                       @if(isset($Application->application['car_found_milage']))
                            value="{{ $Application->application['car_found_milage'] }}"
                       @endif
                />
            </div>
        </div>

        <div class="d-flex flex-column flex-md-row gap-5">
            <div class="fv-row flex-row-fluid">
                <label class=" form-label">Bayi Adı</label>
                <input class="form-control" name="application[branch_name]"
                    @if(isset($Application->application['branch_name']))
                        value="{{ $Application->application['branch_name'] }}"
                    @endif
                />
            </div>
            <div class="flex-row-fluid">
                <label class="form-label">Telefon Numarası</label>
                <input class="form-control" name="application[branch_number]"
                    @if(isset($Application->application['branch_number']))
                        value="{{ $Application->application['branch_number'] }}"
                    @endif
                />
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row gap-5">
            <div class="fv-row flex-row-fluid">
                <label class=" form-label">Onarımı Yapan Servis</label>
                <input class="form-control" name="application[service_name]"
                    @if(isset($Application->application['service_name']))
                        value="{{ $Application->application['service_name'] }}"
                    @endif
                />
            </div>
            <div class="flex-row-fluid">
                <label class="form-label">Telefon Numarası</label>
                <input class="form-control" name="application[service_number]"
                    @if(isset($Application->application['service_number']))
                        value="{{ $Application->application['service_number'] }}"
                       @endif
                />
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row gap-5">
            <div class="fv-row flex-row-fluid">
                <label class=" form-label">Müşterinin Adı</label>
                <input class="form-control" name="application[customer_name]"
                    @if(isset($Application->application['customer_name']))
                        value="{{ $Application->application['customer_name'] }}"
                       @endif
                />
            </div>
            <div class="flex-row-fluid">
                <label class="form-label">Telefon Numarası</label>
                <input class="form-control" name="application[customer_phone]"
                    @if(isset($Application->application['customer_phone']))
                        value="{{ $Application->application['customer_phone'] }}"
                       @endif
                />
            </div>
        </div>

        <div id="productDetails">

        </div>

        <div class="d-flex flex-column flex-md-row gap-5">
            <div class="fv-row flex-row-fluid">
                <label class=" form-label">Müşteri Şikayeti</label>
                <textarea name="application[customer_complain]" class="form-control" cols="30" rows="10">@if(isset($Application->application['customer_complain'])){{ $Application->application['customer_complain'] }}@endif</textarea>
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row gap-5">
            <div class="fv-row flex-row-fluid">
                <label class=" form-label">Sorunla, Arızayla Veya Ürünle İlgili Detaylı
                    Görüşleriniz. </label>
                <textarea name="application[fault]" class="form-control" cols="30" rows="10">@if(isset($Application->application['fault'])){{ $Application->application['fault'] }}@endif</textarea>
            </div>
        </div>
    </div>
</div>
