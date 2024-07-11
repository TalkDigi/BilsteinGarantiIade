@extends('layouts.dashboard')
@section('content')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <form class="form d-flex flex-column flex-lg-row " id="application_form" novalidate="novalidate"

                  @if(isset($Application))
                      action="{{ route('dashboard.application.update',[$Application->claim_number]) }}"
                  @else
                      action="{{ route('dashboard.application.store',[$type['slug'],$Invoice->InvoiceNo]) }}"
                  @endif

                  method="POST">
                @csrf
                <div class="w-100 flex-lg-row-auto w-lg-300px mb-7 me-7 me-lg-10">
                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Fatura Detayları</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="d-flex flex-column gap-10">
                                <div class="fv-row">
                                    <label class="form-label fw-bold">Fatura No</label>
                                    <div class="fs-6">{{ $Invoice->InvoiceNo }}</div>
                                </div>
                                <div class="fv-row">
                                    <label class="form-label fw-bold">Tarih</label>
                                    <div class="fs-6">{{ \Carbon\Carbon::parse($Invoice->PostingDate)->format('d/m/Y') }}
                                    </div>
                                </div>
                                <div class="fv-row">
                                    <label class="form-label fw-bold">Şube</label>
                                    <div class="fs-6">{{ $Invoice->Branch }}</div>
                                </div>

                                <div class="fv-row">
                                    <label class="form-label fw-bold">Tutar</label>
                                    <div class="fs-6">{{ $Invoice->Amt }}</div>
                                </div>
                                <div class="fv-row">
                                    <label class="form-label fw-bold">Tutar (Vergi Dahil)</label>
                                    <div class="fs-6">{{ $Invoice->AmtIncVAT }}</div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column flex-lg-row-fluid gap-7 gap-lg-10">
                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Ürün Seçin</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
							<div class="stepper stepper-pills" id="application_stepper">
								<div class="stepper-nav flex-center flex-wrap mb-10">
									<div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
										<div class="stepper-wrapper d-flex align-items-center">
											<div class="stepper-icon w-40px h-40px">
												<i class="stepper-check fas fa-check"></i>
												<span class="stepper-number">1</span>
											</div>

											<div class="stepper-label">
												<h3 class="stepper-title">
													Ürün Seçimi
												</h3>

											</div>
										</div>

										<div class="stepper-line h-40px"></div>
									</div>

									<div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
										<div class="stepper-wrapper d-flex align-items-center">
											<div class="stepper-icon w-40px h-40px">
												<i class="stepper-check fas fa-check"></i>
												<span class="stepper-number">2</span>
											</div>

											<div class="stepper-label">
												<h3 class="stepper-title">
													Başvuru Formu
												</h3>
											</div>
										</div>

										<div class="stepper-line h-40px"></div>
									</div>

									<div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
										<div class="stepper-wrapper d-flex align-items-center">
											<div class="stepper-icon w-40px h-40px">
												<i class="stepper-check fas fa-check"></i>
												<span class="stepper-number">3</span>
											</div>

											<div class="stepper-label">
												<h3 class="stepper-title">
													Dosyalar
												</h3>
											</div>
										</div>

										<div class="stepper-line h-40px"></div>
									</div>

								</div>
									<div class="">
										<div class="mb-5">
											@include('dashboard.pages.application.includes.select-product',['Invoice' => $Invoice])

											@include('dashboard.pages.application.includes.default-form')
											@php
                                                $invoices = [];
                                                $car_permits = [];
                                                $work_orders = [];
                                                $expenses = [];
                                                $workmanships = [];
                                                $videos = [];
                                                $galleries = [];
                                                $consents = [];

                                                    if(isset($Application) && !empty($Application->files)){

                                                        if(isset($Application->files['invoice']) && !empty($Application->files['invoice'])) {
                                                            $invoices = explode(',',$Application->files['invoice']);
                                                        }

                                                        if(isset($Application->files['car_permit']) && !empty($Application->files['car_permit'])) {
                                                            $car_permits = explode(',',$Application->files['car_permit']);
                                                        }

                                                        if(isset($Application->files['work_order']) && !empty($Application->files['work_order'])) {
                                                            $work_orders = explode(',',$Application->files['work_order']);
                                                        }

                                                        if(isset($Application->files['expense']) && !empty($Application->files['expense'])) {
                                                            $expenses = explode(',',$Application->files['expense']);
                                                        }

                                                        if(isset($Application->files['workmanship']) && !empty($Application->files['workmanship'])) {
                                                            $workmanships = explode(',',$Application->files['workmanship']);
                                                        }

                                                        if(isset($Application->files['video']) && !empty($Application->files['video'])) {
                                                            $videos = explode(',',$Application->files['video']);
                                                        }

                                                        if(isset($Application->files['gallery']) && !empty($Application->files['gallery'])) {
                                                            $galleries = explode(',',$Application->files['gallery']);
                                                        }

                                                        if(isset($Application->files['consent']) && !empty($Application->files['consent'])) {
                                                            $consents = explode(',',$Application->files['consent']);
                                                        }





                                                    }
                                                @endphp

											<div class="flex-column" data-kt-stepper-element="content">
												<div class="fv-row">
													<label class=" form-label"><b>Müşteriye Kesilen Onarım Faturası (Zorunlu)</b></label>
													<div class="dropzone" id="dropZone1">
														<div class="dz-message needsclick">
															<i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

															<div class="ms-4 d-flex justify-content-center align-items-center">
																<h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları sürükleyin veya tıklayarak seçim yapın.</h3>
															</div>
														</div>
													</div>
                                                    <input type="hidden" name="docs[invoice]" id="dropZone1Input">
												</div>

												@if(!empty($invoices))
                                                    <div class="fv-row mt-5">
                                                        <label class=" form-label"><b>Yüklü Dosyalar</b></label>
                                                        <div class="d-flex " id="dropZone2InputAdditionalFiles">
                                                            @forelse($invoices as $invoice)

                                                                    <div class="d-flex inner-file">
                                                                        <a  href="{{ Storage::url('application-files/'.$invoice) }}" target="_blank" data-file="{{$invoice}}" data-bind="dropZone1Input">
                                                                            {{ $invoice }}
                                                                        </a>
                                                                        <span class="badge badge-danger delete-file d-inline-block ml-3" style="margin-left:5px">X</span>
                                                                    </div>

                                                                @empty
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                @endif


                                                <div class="fv-row mt-5">
													<label class=" form-label"><b>Araç Ruhsatı Görseli (Zorunlu)</b></label>
													<div class="dropzone" id="dropZone2">
														<div class="dz-message needsclick">
															<i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

															<div class="ms-4 d-flex justify-content-center align-items-center">
																<h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları sürükleyin veya tıklayarak seçim yapın.</h3>
															</div>
														</div>
													</div>
                                                    <input type="hidden" name="docs[car_permit]" id="dropZone2Input">
												</div>

                                                @if(!empty($car_permits))
                                                    <div class="fv-row mt-5">
                                                        <label class=" form-label"><b>Yüklü Dosyalar</b></label>
                                                        <div class="d-flex " id="dropZone2InputAdditionalFiles">
                                                            @forelse($car_permits as $invoice)

                                                                    <div class="d-flex inner-file">
                                                                        <a  href="{{ Storage::url('application-files/'.$invoice) }}" target="_blank" data-file="{{$invoice}}" data-bind="dropZone2Input">
                                                                            {{ $invoice }}
                                                                        </a>
                                                                        <span class="badge badge-danger delete-file d-inline-block ml-3" style="margin-left:5px">X</span>
                                                                    </div>

                                                                @empty
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="fv-row mt-5">
													<label class=" form-label"><b>İş Emri Görseli (Opsiyonel)</b></label>
													<div class="dropzone" id="dropZone3">
														<div class="dz-message needsclick">
															<i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

															<div class="ms-4 d-flex justify-content-center align-items-center">
																<h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları sürükleyin veya tıklayarak seçim yapın.</h3>
															</div>
														</div>
													</div>
                                                    <input type="hidden" name="docs[work_order]" id="dropZone3Input">
												</div>

                                                @if(!empty($work_orders))
                                                    <div class="fv-row mt-5">
                                                        <label class=" form-label"><b>Yüklü Dosyalar</b></label>
                                                        <div class="d-flex " id="dropZone2InputAdditionalFiles">
                                                            @forelse($work_orders as $invoice)

                                                                    <div class="d-flex inner-file">
                                                                        <a  href="{{ Storage::url('application-files/'.$invoice) }}" target="_blank" data-file="{{$invoice}}" data-bind="dropZone3Input">
                                                                            {{ $invoice }}
                                                                        </a>
                                                                        <span class="badge badge-danger delete-file d-inline-block ml-3" style="margin-left:5px">X</span>
                                                                    </div>

                                                                @empty
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="fv-row mt-5">
													<label class=" form-label"><b>Masraf Proforma Faturası (Zorunlu)</b></label>
													<div class="dropzone" id="dropZone4">
														<div class="dz-message needsclick">
															<i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

															<div class="ms-4 d-flex justify-content-center align-items-center">
																<h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları sürükleyin veya tıklayarak seçim yapın.</h3>
															</div>
														</div>
													</div>
                                                    <input type="hidden" name="docs[expense]" id="dropZone4Input">
												</div>

                                                @if(!empty($expenses))
                                                    <div class="fv-row mt-5">
                                                        <label class=" form-label"><b>Yüklü Dosyalar</b></label>
                                                        <div class="d-flex " id="dropZone2InputAdditionalFiles">
                                                            @forelse($expenses as $invoice)

                                                                    <div class="d-flex inner-file">
                                                                        <a  href="{{ Storage::url('application-files/'.$invoice) }}" target="_blank" data-file="{{$invoice}}" data-bind="dropZone4Input">
                                                                            {{ $invoice }}
                                                                        </a>
                                                                        <span class="badge badge-danger delete-file d-inline-block ml-3" style="margin-left:5px">X</span>
                                                                    </div>

                                                                @empty
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                @endif

                                                 <div class="fv-row mt-5">
													<label class=" form-label"><b>Harici İşçilik Faturası</b></label>
													<div class="dropzone" id="dropZone5">
														<div class="dz-message needsclick">
															<i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

															<div class="ms-4 d-flex justify-content-center align-items-center">
																<h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları sürükleyin veya tıklayarak seçim yapın.</h3>
															</div>
														</div>
													</div>
                                                    <input type="hidden" name="docs[workmanship]" id="dropZone5Input">
												</div>

                                                @if(!empty($workmanships))
                                                    <div class="fv-row mt-5">
                                                        <label class=" form-label"><b>Yüklü Dosyalar</b></label>
                                                        <div class="d-flex " id="dropZone2InputAdditionalFiles">
                                                            @forelse($workmanships as $invoice)

                                                                    <div class="d-flex inner-file">
                                                                        <a  href="{{ Storage::url('application-files/'.$invoice) }}" target="_blank" data-file="{{$invoice}}" data-bind="dropZone5Input">
                                                                            {{ $invoice }}
                                                                        </a>
                                                                        <span class="badge badge-danger delete-file d-inline-block ml-3" style="margin-left:5px">X</span>
                                                                    </div>

                                                                @empty
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="fv-row mt-5">
													<label class=" form-label"><b>Sorunu Anlatan Video</b></label>
													<div class="dropzone" id="dropZone6">
														<div class="dz-message needsclick">
															<i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

															<div class="ms-4 d-flex justify-content-center align-items-center">
																<h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları sürükleyin veya tıklayarak seçim yapın.</h3>
															</div>
														</div>
													</div>
                                                    <input type="hidden" name="docs[video]" id="dropZone6Input">
												</div>

                                                @if(!empty($videos))
                                                    <div class="fv-row mt-5">
                                                        <label class=" form-label"><b>Yüklü Dosyalar</b></label>
                                                        <div class="d-flex " id="dropZone2InputAdditionalFiles">
                                                            @forelse($videos as $invoice)

                                                                    <div class="d-flex inner-file">
                                                                        <a  href="{{ Storage::url('application-files/'.$invoice) }}" target="_blank" data-file="{{$invoice}}" data-bind="dropZone6Input">
                                                                            {{ $invoice }}
                                                                        </a>
                                                                        <span class="badge badge-danger delete-file d-inline-block ml-3" style="margin-left:5px">X</span>
                                                                    </div>

                                                                @empty
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="fv-row mt-5">
													<label class=" form-label"><b>Sorunu Anlatan Görseller (Zorunlu)</b></label>
													<div class="dropzone" id="dropZone7">
														<div class="dz-message needsclick">
															<i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

															<div class="ms-4 d-flex justify-content-center align-items-center">
																<h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları sürükleyin veya tıklayarak seçim yapın.</h3>
															</div>
														</div>
													</div>
                                                    <input type="hidden" name="docs[gallery]" id="dropZone7Input">
												</div>

                                                @if(!empty($galleries))
                                                    <div class="fv-row mt-5">
                                                        <label class=" form-label"><b>Yüklü Dosyalar</b></label>
                                                        <div class="d-flex " id="dropZone2InputAdditionalFiles">
                                                            @forelse($galleries as $invoice)

                                                                    <div class="d-flex inner-file">
                                                                        <a  href="{{ Storage::url('application-files/'.$invoice) }}" target="_blank" data-file="{{$invoice}}" data-bind="dropZone7Input">
                                                                            {{ $invoice }}
                                                                        </a>
                                                                        <span class="badge badge-danger delete-file d-inline-block ml-3" style="margin-left:5px">X</span>
                                                                    </div>

                                                                @empty
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="fv-row mt-5">
													<label class=" form-label"><b>İmzalı Parça Rıza Beyanı (Zorunlu)</b></label>
													<div class="dropzone" id="dropZone8">
														<div class="dz-message needsclick">
															<i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

															<div class="ms-4 d-flex justify-content-center align-items-center">
																<h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları sürükleyin veya tıklayarak seçim yapın.</h3>
															</div>
														</div>
													</div>
                                                    <input type="hidden" name="docs[consent]" id="dropZone8Input">
												</div>

                                                @if(!empty($consents))
                                                    <div class="fv-row mt-5">
                                                        <label class=" form-label"><b>Yüklü Dosyalar</b></label>
                                                        <div class="d-flex " id="dropZone2InputAdditionalFiles">
                                                            @forelse($consents as $invoice)

                                                                    <div class="d-flex inner-file">
                                                                        <a  href="{{ Storage::url('application-files/'.$invoice) }}" target="_blank" data-file="{{$invoice}}" data-bind="dropZone8Input">
                                                                            {{ $invoice }}
                                                                        </a>
                                                                        <span class="badge badge-danger delete-file d-inline-block ml-3" style="margin-left:5px">X</span>
                                                                    </div>

                                                                @empty
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                @endif


											</div>
										</div>

										<div class="d-flex flex-stack">
											<div class="me-2">
												<button type="button" class="btn btn-light btn-active-light-primary" data-kt-stepper-action="previous">
													Geri
												</button>
											</div>

											<div>
												<button type="submit" class="btn btn-primary" >
													<span class="indicator-label">
														Gönder
													</span>
													<span class="indicator-progress">
														Lütfen bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
													</span>
												</button>

												<button type="button" class="btn btn-primary" data-kt-stepper-action="next">
													Devam Et
												</button>
											</div>
										</div>
									</div>
								</div>
                        </div>
                    </div>

                </div>
            </form>
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


	$(document).ready(function() {

    if ($('#application_form').length > 0) {
        $('#application_form').on('submit', function(e) {
            e.preventDefault();

            const dropZones = [
                { id: '#dropZone1Input', error: 'Müşteriye Kesilen Onarım Faturası alanına en az bir dosya ekleyin.' },
                { id: '#dropZone2Input', error: 'Araç Ruhsatı Görseli alanına en az bir dosya ekleyin.' },
                { id: '#dropZone4Input', error: 'Masraf Proforma Faturası alanına en az bir dosya ekleyin.' },
                { id: '#dropZone7Input', error: 'Sorunu Anlatan Görseller alanına en az bir dosya ekleyin.' },
                { id: '#dropZone8Input', error: 'İmzalı Parça Rıza Beyanı alanına en az bir dosya ekle.' }
            ];


            for (let zone of dropZones) {
                if (!$(zone.id).val()) {
                    toastr.error(zone.error, 'Hata');
                    return false;
                }
            }

            this.submit();
        });
    }
});

        </script>

<script src="{{ asset('assets/js/custom/apps/ecommerce/sales/save-order.js') }}"></script>

@endsection

