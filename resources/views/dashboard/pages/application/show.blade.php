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
                                        {!!$Status->html!!}
                                        
                                    </div>
                                    <!--end::Status-->
                                    <!--begin::Description-->
                                    <div
                                        class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-500">{{$Application->getType()->title }}</div>
                                        <div
                                        class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-500">{{$Application->getUser->customer->No}} - {{$Application->getUser->customer->SearchName}}</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Details-->
                                <!--begin::Actions-->
                                <div class="d-flex mb-4 actionButtons">
                                    @if(auth()->user()->hasRole('Yönetici'))

                                            <a href="{{route('dashboard.application.update_status',[2,$Application->claim_number])}}"
                                               class="btn btn-sm btn-warning me-3">Ön Onay Bekleniyor</a>

                                               <a href="{{route('dashboard.application.update_status',[7,$Application->claim_number])}}"
                                                class="btn btn-sm btn-danger me-3">Ön Onay & Kargo Bekleniyor</a>
                                               

                                            <a href="#" class="btn btn-sm btn-success me-3 changeStatusButton"
                                               data-bs-toggle="modal" data-bs-target="#change_status"
                                               data-status-id="5">Onayla</a>

                                            <a href="#" class="btn btn-sm btn-info me-3 changeStatusButton"
                                               data-bs-toggle="modal" data-bs-target="#change_status"
                                               data-status-id="4">Düzenleme İste</a>

                                            <a href="#" class="btn btn-sm btn-danger me-3 changeStatusButton"
                                               data-bs-toggle="modal" data-bs-target="#change_status"
                                               data-status-id="6">Reddet</a>

                                        @endif

                                        <a id="downloadPdfButton"  href="javascript:void(0)" class="btn btn-sm btn-dark me-3" data-status-id="5">
                                            <i class="ki-duotone ki-printer">
 <span class="path1"></span>
 <span class="path2"></span>
 <span class="path3"></span>
 <span class="path4"></span>
 <span class="path5"></span>
</i>
                                            PDF Çıktısı Al
                                        </a>


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
                                            <div class="fs-4 fw-bold">{{count($Application->products)}}</div>
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

                                    @if(isset($Application->application['cost_request']))
                                        <!--begin::Stat-->
                                        <div
                                            class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="fs-4 fw-bold">
                                                    {{ number_format($Application->application['cost_request'], 2, ',', '.') }}
                                                    ₺
                                                </div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">Talep Edilen Masraf Tutarı</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                    @endif

                                    @if(isset($Application->application['accepted_cost']))
                                        <!--begin::Stat-->
                                        <div
                                            class="border border-success border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3 ">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="fs-4 fw-bold">
                                                    {{ number_format($Application->application['accepted_cost'], 2, ',', '.') }}
                                                    ₺
                                                </div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">Onaylanan Masraf Tutarı</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                    @endif
                                </div>
                                <!--end::Stats-->

                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Wrapper-->
                    </div>

                    @if($Application->editable && is_null($Application->viewed_by))
                        <div class="alert alert-info d-flex align-items-center p-5">
                            <div class="d-flex flex-column">
                                <p class="text-dark">Başvurunuz henüz bir yönetici tarafından incelenmedi. Başvurunuz incelenene dek düzenleme yapabilirsiniz.</p>
                                    <a href="{{route('dashboard.application.edit', [$Application->claim_number])}}">Başvuruyu
                                        Düzenle</a>

                            </div>
                        </div>
                    @endif

                    @if($Status['hasNotes'] || $Status['showShipment'])
                        <div class="alert alert-{{$Status['color']}} d-flex align-items-center p-5">
                            <!--begin::Icon-->
                            <i class="ki-duotone ki-shield-tick fs-2hx text-{{$Status['color']}} me-4"><span
                                    class="path1"></span><span class="path2"></span></i>
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
                                                    <a href="{{Storage::url('application-files/'.$file)}}"
                                                       target="_blank">{{$file}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endif

                                @if($Status['canEdit'])
                                    <a href="{{route('dashboard.application.edit', [$Application->claim_number])}}">Başvuruyu
                                        Düzenle</a>
                                @endif

                                @if($Status['showShipment'])
                                    <div class="d-flex mt-5 d-block flex-column">
                                        <h5>İade İçin Gönderim Adresi</h5>
                                        <p class="text-black">Başvurunuz için ön onay verilmiştir. Başvuruya konu olan ürünleri aşağıdaki adrese kargolayabilirsiniz.</p>
                                        <p class="text-black">{{$Settings['shipment_address']}}</p>
                                    </div>
                                @endif

                                @if($Status['canInvoice'] && $Application->type == 2)
                                    <div class="d-flex mt-5 d-block flex-column">
                                        <p>Başvurunuza dair <b>Hasar Yansıtma Faturası</b> oluşturabilirsiniz. Örnek
                                            fatura detaylarını görmek için <b>Fatura Oluştur</b> butonuna tıklayın.</p>

                                        <a class="applicationCreateInvoice btn btn-warning me-2 mb-2" style="max-width: 220px;" data-claim-number = "{{$Application->claim_number}}">

                                            Örnek Fatura Oluştur
                                        </a>
                                    </div>
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
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0 closure-table">
                                    <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-175px">Ürün</th>
                                        <th class="min-w-100px text-end">Kod</th>
                                        <th class="min-w-100px text-end">Marka</th>
                                        {{--<th class="min-w-100px text-end">Marka</th>--}}
                                        @if($Application->type == 2)
                                            <th class="min-w-100px text-end">Fatura</th>
                                        @endif
                                        <th class="min-w-70px text-end">Adet</th>
                                        @if($Application->type == 2)
                                            <th class="min-w-100px text-end">Birim Fatura Fiyatı</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">

                                    @forelse($Application->products as $product)

                                        <tr
                                            data-name="{{$product['desc']}}"
                                            data-no="{{$product['code']}}"
                                            data-quantity="{{$product['qty']}}"
                                            data-price="{{ number_format($product['price'], 2, '.', '')}}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-5">
                                                        <p class="fw-bold text-gray-600 text-hover-primary">
                                                            {{$product['desc']}}
                                                        </p>
                                                    </div>

                                                </div>
                                            </td>
                                            <td class="text-end">{{$product['code']}}</td>
                                            <td class="text-end">{{$brands[$product['code']]}}</td>
                                            @if($Application->type == 2)
                                                <td class="text-end">
                                                {{$product['invoice']}}
                                            </td>
                                            @endif
                                            {{--<td class="text-end">{{$product['product']->BrandName}}</td>--}}
                                            <td class="text-end">{{$product['qty']}}</td>
                                            @if($Application->type == 2)
                                                <td class="text-end">
                                                    {{ number_format($product['price'], 2, ',', '.') }}₺
                                            </td>
                                            @endif
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
                <div class="col-lg-4 mt-5 actionLogs">
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
                                        <div
                                            class="timeline-label fw-bold text-gray-800 fs-6">{{$l->getFormattedCreatedAtAttribute()}}
                                            <br>
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
                <div class="col-lg-8 mt-5 applicationContent">
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
                                    @if(is_array($value))
                                        @continue
                                    @endif
                                    <div>
                                        @if($key == 'cost_request' || $key == 'accepted_cost')
                                            <b>{{ __('fields.' . $key) }}:</b>
                                            <p>{{ number_format($value, 2, ',', '.') }} ₺</p>
                                        @else
                                            <b>{{ __('fields.' . $key) }}:</b> <p>{{ $value }}</p>
                                        @endif
                                    </div>
                                @endforeach
                                @if(isset($Application->application['complain']) && !empty($Application->application['complain']))
                                    <b>Müşteri Şikayeti:</b>
                                    <p>@foreach ($Application->application['complain'] as $value)
                                            {{$ProviderComplaints[$value]->title}}
                                            @if(!$loop->last)
                                                ,
                                            @endif

                                        @endforeach</p>
                                @endif

                                 @if(isset($Application->application['consent']) && !empty($Application->application['consent']))
                                    @if(isset($Application->application['consent']['confirm']))
                                        <p>Parçanın incelenmesi için gerekli olan tüm testleri onaylıyorum.</p>
                                        @endif
                                     @if(isset($Application->application['consent']['destroy']))
                                        <p>Ürünün bertaraf şartlarına göre imhasını istiyorum.</p>
                                        @endif
                                     @if(isset($Application->application['consent']['return']))
                                        <p>Tüm ek masraf ve riskleri kabul ederek ürünü geri istiyorum.</p>
                                        @endif
                                @endif


                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-lg-12 mt-5 applicationFiles">
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
                                                    <p><a href="{{Storage::url('application-files/'.$file)}}"
                                                          target="_blank">{{$file}}</a></p>
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
    @include('dashboard.modals.change-status',['Application' => $Application,'FileMatches' => $FileMatches,'Status' => $Status])
    <div class="modal fade" id="invoiceModal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold"></h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close"
                         data-bs-dismiss="modal"
                         data-bs-target="#kt_modal_add_user"
                         id="kt_modal_add_user_close"
                    >
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body px-5 my-7 invoiceBody" id="invoiceBody">

                </div>

                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.plugin.standard_fonts_metrics.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.plugin.split_text_to_size.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.plugin.from_html.js"></script>
    <script>
document.getElementById('downloadPdfButton').addEventListener('click', function () {
    var element = document.getElementById('kt_content');
    var actionButtons = document.querySelector('.actionButtons');
    var actionLogs = document.querySelector('.actionLogs');
    var alertElements = document.querySelectorAll('.alert');
    var applicationContent = document.querySelector('.applicationContent');
    var applicationFiles = document.querySelector('.applicationFiles');

    // Change class and hide elements
    if (applicationContent) applicationContent.classList.replace('col-lg-8', 'col-lg-12');
    if (actionButtons) actionButtons.style.display = 'none';
    if (actionLogs) actionLogs.style.display = 'none';
    if(applicationFiles) applicationFiles.style.display = 'none';
    alertElements.forEach(function(alertElement) {
        alertElement.classList.remove('d-flex');
        alertElement.style.display = 'none';
    });

    html2canvas(element, {
        scale: 2 // Increase the scale to improve quality
    }).then(function (canvas) {
        var imgData = canvas.toDataURL('image/png');
        var doc = new jsPDF('p', 'mm', 'a4');
        var imgWidth = 210; // A4 width in mm
        var pageHeight = 297; // A4 height in mm
        var imgHeight = canvas.height * imgWidth / canvas.width;
        var heightLeft = imgHeight;
        var position = 0;

        // Set font to handle special characters
        doc.setFont('Helvetica', 'normal');

        doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;

        while (heightLeft >= 0) {
            position = heightLeft - imgHeight;
            doc.addPage();
            doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
        }

        doc.save('{{$Application->claim_number}}.pdf');

        // Restore class and show elements
        if (applicationContent) applicationContent.classList.replace('col-lg-12', 'col-lg-8');
        if (actionButtons) actionButtons.style.display = '';
        if (actionLogs) actionLogs.style.display = '';
        if(applicationFiles) applicationFiles.style.display = '';
        alertElements.forEach(function(alertElement) {
            alertElement.classList.add('d-flex');
            alertElement.style.display = '';
        });
    });
});
    </script>
@endsection

@section('after-scripts')

    <script>

        let statuses = @json($ApplicationStatusById);

        @if ($errors->any())
        @foreach ($errors->all() as $error)
        toastr.error("{{ $error }}", "Hata");
        @endforeach
        @endif


    </script>
@endsection
