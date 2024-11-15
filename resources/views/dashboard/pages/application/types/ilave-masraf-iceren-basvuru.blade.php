@extends('layouts.dashboard')
@section('content')
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">


        <div class="d-flex flex-column flex-lg-row-fluid gap-7 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{$Type->title}}</h2>
                    </div>
                </div>

                <div class="card-body pt-0">

                    <div class="alert alert-light">
                        <h4 class="mb-3">İlave Masraflı Başvuru Prosedürü</h4>
                        <ol>
                            <li class="mb-3">Detaylı sorunu anlatır resimler.(Montaj öncesi ve sonrasında detaylıca
                                hasar alan parçaları ve aracı fotoğraflayın.)</li>

                            <li class="mb-3">Ürünün montaj yapıldığı tarihteki faturası.(Ürünün montaj yapıldığı
                                tarihteki değişen tüm parçaların yer aldığı müşteriye kesilen fatura)</li>

                            <li class="mb-3">Hasarlı parça veya parçalar</li>

                            <li class="mb-3">Yapılacak son onarım ile ilgili masraf talep listesi; Aracın kullanılan
                                ürünümüzden kaynaklı bir sorununun tespit edilmesi halinde onarımı yapan servisin aracın
                                eski haline getirilmesi için istenen parça listesi ve işçiliğin olduğu ön fatura. </li>
                        </ol>

                        <p>Başvurunun <b>onaylanması</b> halinde servise bu masraf talep listesindeki <b>tutar
                                ödenecektir</b>, <b>sonrasında oluşan hiçbir ekstra masraf kabul edilmez.</b></p>

                        <p>Belgeler ve hasarlı parçalar tarafımıza ulaştıktan sonra başvurunuz hazırlanıp hasarlı
                            parçalarla birlikte Genel Merkezimiz Almanya ile paylaşılır. <b>Süreç yaklaşık 20 ile 45 gün
                                sürmektedir.</b></p>


                    </div>


                    @if(isset($Application))
                        @include('dashboard.pages.application.includes.product-search', ['Type' => $Type, 'Application' => $Application])
                    @else
                        @include('dashboard.pages.application.includes.product-search', ['Type' => $Type])
                    @endif
                    
                    @if($Type->has_additional_payment)
                    <div class="has_additional_payment" style="display: none">

                    </div>
                    @endif

                    <form
                        class="form d-flex flex-column flex-lg-row application_form @if(isset($Application)) update @endif"
                        autocomplete="off" @if(isset($Application))
                        action="{{ route('dashboard.application.update', [$Application->claim_number]) }}" @endif
                        method="POST" action="{{route('dashboard.application.store', ['type' => $Type->uuid])}}">
                        @csrf
                        <div class="mb-5 w-100">
                            <input type="hidden" name="uuid" value="{{$Type->uuid}}">

                            @include('dashboard.pages.application.includes.default-form', ['Type' => $Type, 'Complaints' => $Type->complaints])
                            @php
                                $invoices = [];
                                $car_permits = [];
                                $work_orders = [];
                                $expenses = [];
                                $workmanships = [];
                                $videos = [];
                                $galleries = [];
                                $consents = [];

                                if (isset($Application) && !empty($Application->files)) {

                                    if (isset($Application->files['invoice']) && !empty($Application->files['invoice'])) {
                                        $invoices = explode(',', $Application->files['invoice']);
                                    }

                                    if (isset($Application->files['car_permit']) && !empty($Application->files['car_permit'])) {
                                        $car_permits = explode(',', $Application->files['car_permit']);
                                    }

                                    if (isset($Application->files['work_order']) && !empty($Application->files['work_order'])) {
                                        $work_orders = explode(',', $Application->files['work_order']);
                                    }

                                    if (isset($Application->files['expense']) && !empty($Application->files['expense'])) {
                                        $expenses = explode(',', $Application->files['expense']);
                                    }

                                    if (isset($Application->files['workmanship']) && !empty($Application->files['workmanship'])) {
                                        $workmanships = explode(',', $Application->files['workmanship']);
                                    }

                                    if (isset($Application->files['video']) && !empty($Application->files['video'])) {
                                        $videos = explode(',', $Application->files['video']);
                                    }

                                    if (isset($Application->files['gallery']) && !empty($Application->files['gallery'])) {
                                        $galleries = explode(',', $Application->files['gallery']);
                                    }

                                    if (isset($Application->files['consent']) && !empty($Application->files['consent'])) {
                                        $consents = explode(',', $Application->files['consent']);
                                    }





                                }
                            @endphp

                            <div class="flex-column" data-kt-stepper-element="content">
                                <div class="fv-row invoice">
                                    <label class=" form-label"><b>Servisin Müşteriye Kestiği İlk Fatura / İş Emri
                                            (Zorunlu)</b></label>
                                    <div class="dropzone" id="dropZone1">
                                        <div class="dz-message needsclick">
                                            <i class="ki-duotone ki-file-up fs-3x text-primary"><span
                                                    class="path1"></span><span class="path2"></span></i>

                                            <div class="ms-4 d-flex justify-content-center align-items-center">
                                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları
                                                    sürükleyin veya tıklayarak seçim yapın.</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="docs[invoice]" id="dropZone1Input">
                                </div>

                                @if(!empty($invoices))
                                    <div class="fv-row mt-5 invoice">
                                        <label class=" form-label"><b>Yüklü Dosyalar</b></label>
                                        <div class="d-flex " id="dropZone2InputAdditionalFiles">
                                            @forelse($invoices as $invoice)

                                                <div class="d-flex inner-file">
                                                    <a href="{{ Storage::url('application-files/' . $invoice) }}" target="_blank"
                                                        data-file="{{$invoice}}" data-bind="dropZone1Input">
                                                        {{ $invoice }}
                                                    </a>
                                                    <span class="badge badge-danger delete-file d-inline-block ml-3"
                                                        style="margin-left:5px">X</span>
                                                </div>

                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                @endif


                                <div class="fv-row mt-5 car_permit">
                                    <label class=" form-label"><b>Araç Ruhsatı Görseli (Zorunlu)</b></label>
                                    <div class="dropzone" id="dropZone2">
                                        <div class="dz-message needsclick">
                                            <i class="ki-duotone ki-file-up fs-3x text-primary"><span
                                                    class="path1"></span><span class="path2"></span></i>

                                            <div class="ms-4 d-flex justify-content-center align-items-center">
                                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları
                                                    sürükleyin veya tıklayarak seçim yapın.</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="docs[car_permit]" id="dropZone2Input">
                                </div>

                                @if(!empty($car_permits))
                                    <div class="fv-row mt-5 car_permit">
                                        <label class=" form-label"><b>Yüklü Dosyalar</b></label>
                                        <div class="d-flex " id="dropZone2InputAdditionalFiles">
                                            @forelse($car_permits as $invoice)

                                                <div class="d-flex inner-file">
                                                    <a href="{{ Storage::url('application-files/' . $invoice) }}" target="_blank"
                                                        data-file="{{$invoice}}" data-bind="dropZone2Input">
                                                        {{ $invoice }}
                                                    </a>
                                                    <span class="badge badge-danger delete-file d-inline-block ml-3"
                                                        style="margin-left:5px">X</span>
                                                </div>

                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                @endif

                                <div class="fv-row mt-5 expense">
                                    <label class=" form-label"><b>Masraf Proforma Faturası
                                            (Zorunlu)</b></label>
                                    <div class="dropzone" id="dropZone4">
                                        <div class="dz-message needsclick">
                                            <i class="ki-duotone ki-file-up fs-3x text-primary"><span
                                                    class="path1"></span><span class="path2"></span></i>

                                            <div class="ms-4 d-flex justify-content-center align-items-center">
                                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları
                                                    sürükleyin veya tıklayarak seçim yapın.</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="docs[expense]" id="dropZone4Input">
                                </div>

                                @if(!empty($expenses))
                                    <div class="fv-row mt-5 expense">
                                        <label class=" form-label"><b>Yüklü Dosyalar</b></label>
                                        <div class="d-flex " id="dropZone2InputAdditionalFiles">
                                            @forelse($expenses as $invoice)

                                                <div class="d-flex inner-file">
                                                    <a href="{{ Storage::url('application-files/' . $invoice) }}" target="_blank"
                                                        data-file="{{$invoice}}" data-bind="dropZone4Input">
                                                        {{ $invoice }}
                                                    </a>
                                                    <span class="badge badge-danger delete-file d-inline-block ml-3"
                                                        style="margin-left:5px">X</span>
                                                </div>

                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                @endif

                                <div class="fv-row mt-5 workmanship">
                                    <label class=" form-label"><b>Harici İşçilik Faturası</b></label>
                                    <div class="dropzone" id="dropZone5">
                                        <div class="dz-message needsclick">
                                            <i class="ki-duotone ki-file-up fs-3x text-primary"><span
                                                    class="path1"></span><span class="path2"></span></i>

                                            <div class="ms-4 d-flex justify-content-center align-items-center">
                                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları
                                                    sürükleyin veya tıklayarak seçim yapın.</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="docs[workmanship]" id="dropZone5Input">
                                </div>

                                @if(!empty($workmanships))
                                    <div class="fv-row mt-5 workmanship">
                                        <label class=" form-label"><b>Yüklü Dosyalar</b></label>
                                        <div class="d-flex " id="dropZone2InputAdditionalFiles">
                                            @forelse($workmanships as $invoice)

                                                <div class="d-flex inner-file">
                                                    <a href="{{ Storage::url('application-files/' . $invoice) }}" target="_blank"
                                                        data-file="{{$invoice}}" data-bind="dropZone5Input">
                                                        {{ $invoice }}
                                                    </a>
                                                    <span class="badge badge-danger delete-file d-inline-block ml-3"
                                                        style="margin-left:5px">X</span>
                                                </div>

                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                @endif

                                <div class="fv-row mt-5 video">
                                    <label class=" form-label"><b>Sorunu Anlatan Video</b></label>
                                    <div class="dropzone" id="dropZone6">
                                        <div class="dz-message needsclick">
                                            <i class="ki-duotone ki-file-up fs-3x text-primary"><span
                                                    class="path1"></span><span class="path2"></span></i>

                                            <div class="ms-4 d-flex justify-content-center align-items-center">
                                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları
                                                    sürükleyin veya tıklayarak seçim yapın.</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="docs[video]" id="dropZone6Input">
                                </div>

                                @if(!empty($videos))
                                    <div class="fv-row mt-5 video">
                                        <label class=" form-label"><b>Yüklü Dosyalar</b></label>
                                        <div class="d-flex " id="dropZone2InputAdditionalFiles">
                                            @forelse($videos as $invoice)

                                                <div class="d-flex inner-file">
                                                    <a href="{{ Storage::url('application-files/' . $invoice) }}" target="_blank"
                                                        data-file="{{$invoice}}" data-bind="dropZone6Input">
                                                        {{ $invoice }}
                                                    </a>
                                                    <span class="badge badge-danger delete-file d-inline-block ml-3"
                                                        style="margin-left:5px">X</span>
                                                </div>

                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                @endif

                                <div class="fv-row mt-5 gallery">
                                    <label class=" form-label"><b>Sorunu Anlatan Görseller
                                            (Zorunlu)</b></label>
                                    <div class="dropzone" id="dropZone7">
                                        <div class="dz-message needsclick">
                                            <i class="ki-duotone ki-file-up fs-3x text-primary"><span
                                                    class="path1"></span><span class="path2"></span></i>

                                            <div class="ms-4 d-flex justify-content-center align-items-center">
                                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları
                                                    sürükleyin veya tıklayarak seçim yapın.</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="docs[gallery]" id="dropZone7Input">
                                </div>

                                @if(!empty($galleries))
                                    <div class="fv-row mt-5 gallery">
                                        <label class=" form-label"><b>Yüklü Dosyalar</b></label>
                                        <div class="d-flex " id="dropZone2InputAdditionalFiles">
                                            @forelse($galleries as $invoice)

                                                <div class="d-flex inner-file">
                                                    <a href="{{ Storage::url('application-files/' . $invoice) }}" target="_blank"
                                                        data-file="{{$invoice}}" data-bind="dropZone7Input">
                                                        {{ $invoice }}
                                                    </a>
                                                    <span class="badge badge-danger delete-file d-inline-block ml-3"
                                                        style="margin-left:5px">X</span>
                                                </div>

                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                @endif

                                @if(!isset($Application))
                                    <div class="fv-row mt consent d-block mt-10">
                                        <div
                                            class="border border-gray-700 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="consentConfirm"
                                                    name="application[consent][confirm]" required />
                                                <label class="form-check-label text-gray-700" for="consentConfirm">
                                                    Parçanın incelenmesi için gerekli olan tüm testleri onaylıyorum.
                                                </label>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row consent mt-10 consent-secondary" style="display: none">
                                    <div class="col-lg-6">
                                        <div
                                            class="border border-gray-700 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="constentDestroy" name="application[consent][destroy]" />
                                                <label class="form-check-label text-gray-700" for="constentDestroy">
                                                    Ürünün bertaraf şartlarına göre imhasını istiyorum.
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">
                                        <div
                                            class="border border-gray-700 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="consentReturn" name="application[consent][return]" />
                                                <label class="form-check-label text-gray-700" for="consentReturn">
                                                    Tüm ek masraf ve riskleri kabul ederek ürünü geri istiyorum.
                                                </label>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                @endif

                                

                                <button type="submit" class="btn btn-primary mt-5 float-end">
                                    <span class="indicator-label">
                                        Gönder
                                    </span>
                                    <span class="indicator-progress">
                                        Lütfen bekleyin... <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>

                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let preselectedQuantities = {};

    @if(isset($Application))
        preselectedQuantities = @json($Application->quantities);
    @endif
</script>

<script>


    $(document).ready(function () {

        $('input[name="application[car_brand]"], ' +
            'input[name="application[car_model]"], ' +
            'input[name="application[car_year]"], ' +
            'input[name="application[car_number]"], ' +
            'input[name="application[car_repair_date]"], ' +
            'input[name="application[car_repair_milage]"], ' +
            'input[name="application[car_found_date]"], ' +
            'input[name="application[car_found_milage]"], ' +
            'input[name="application[engine_power]"], ' +
            'input[name="application[engine_code]"], ' +
            'textarea[name="application[fault]"], ' +
            'input[name="application[cost_request]"]').prop('required', true);



        /*if ($('#application_form').length > 0) {
            $('#application_form').on('submit', function (e) {
                e.preventDefault();

                const dropZones = [
                    {
                        id: '#dropZone1Input',
                        error: 'Servisin Müşteriye Kestiği İlk Fatura / İş Emri alanına en az bir dosya ekleyin.'
                    },
                    {id: '#dropZone2Input', error: 'Araç Ruhsatı Görseli alanına en az bir dosya ekleyin.'},
                    {id: '#dropZone4Input', error: 'Masraf Proforma Faturası alanına en az bir dosya ekleyin.'},
                    {id: '#dropZone7Input', error: 'Sorunu Anlatan Görseller alanına en az bir dosya ekleyin.'}
                ];


                for (let zone of dropZones) {
                    if (!$(zone.id).val()) {
                        toastr.error(zone.error, 'Hata');
                        return false;
                    }
                }

                this.submit();
            });
        }*/
    });
    let inputs = null;
    @if(isset($inputs))
        @if(!is_null($inputs))
            inputs = @json($inputs);
        @endif
    @endif

    @if(isset($allinputs))
        let allInputs = @json($allinputs);
    @endif

    //application[consent][confirm] checked, show consent-secondary
    $('input[name="application[consent][confirm]"]').on('change', function () {
        if ($(this).is(':checked')) {
            $('.consent-secondary').show();
        } else {
            $('.consent-secondary').hide();
        }
    });

    $('input[name="application[consent][return]"], input[name="application[consent][destroy]"]').on('change', function () {
        if ($(this).is(':checked')) {
            $('input[name="application[consent][return]"], input[name="application[consent][destroy]"]').not(this).prop('checked', false);
        }
    });

    //when application[consent][return] checked, open swal and show some text inside it. and show accept and reject buttons. if accept button clicked, check the checkbox. if reject button clicked, uncheck the checkbox.
    $('input[name="application[consent][return]"]').on('change', function () {
        if ($(this).is(':checked')) {
            Swal.fire({
                text: "Kontrol ve testler için tarafımıza gönderilen ürün gerekli görüldüğü durumlarda ileri kontroller için farklı ülkelere gönderilip dağıtılıp kesilebilmektedir. Ürünün kontrol ve testleri sonrası herhangi bir kusur tespit edilememesi durumunda ürünün tekrar tarafınıza teslim edilmesini istiyorsanız, bu durumun ek ücret gerektirdiğini bildirmek isteriz. Bu durumda hesaplanan ücreti ödeseniz dahi ürünün kontrol esnasında uygulanan kontrol yöntemleri, ürünün nakliyesi sırasında yaşanan hasar ve değişen gümrük mevzuatları gereği ürünün tarafınıza ulaşmama, hasarlı veya eksik ulaşma gibi riskleri barındırdığını bunu ürünü talep ederek şimdiden kabul ettiğinizi belirtmek isteriz. Bu gibi durumlarda ödediğiniz ücretin iadesi yapılamamaktadır",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                customClass: {
                    popup: 'swal-custom-height'
                },
                confirmButtonText: 'Kabul Ediyorum',
                cancelButtonText: 'Reddediyorum'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('input[name="application[consent][return]"]').prop('checked', true);
                } else {
                    $('input[name="application[consent][return]"]').prop('checked', false);
                }
            });
        }
    });


</script>

@endsection