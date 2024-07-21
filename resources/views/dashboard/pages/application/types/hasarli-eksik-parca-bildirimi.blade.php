@extends('layouts.dashboard')
@section('content')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <form class="form d-flex flex-column flex-lg-row application_form" novalidate="novalidate"
                   @if(isset($Application))
                      action="{{ route('dashboard.application.update',[$Application->claim_number]) }}"
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

                                @forelse($Application->products as $product)
                                        <div class="d-flex align-items-center border border-dashed rounded p-3 bg-body">

                                            <div class="ms-5">
                                                <span
                                                    class="text-gray-800 text-hover-primary fs-5 fw-bold">{{$product['desc']}}</span>

                                                <div class="text-muted fs-7 mt-2">Adet:
                                                    {{$product['qty']}}
                                                </div>

                                                <div class="fw-semibold fs-7 mt-2">Ürün Kodu: {{$product['code']}}
                                                </div>

                                                <div class="text-muted fs-7 mt-2">Fatura No:
                                                    {{$product['invoice']}}
                                                </div>
                                                <div class="text-muted fs-7 mt-2">Birim Fiyat:
                                                    {{number_format($product['price'], 2, '.', '')}}
                                                </div>

                                            </div>
                                        </div>
                                @empty
                                @endforelse


                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column flex-lg-row-fluid gap-7 gap-lg-10">
                    <div class="card card-flush py-4">

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
												<span class="stepper-number">2</span>
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

											@include('dashboard.pages.application.includes.default-form', ['Complaints' => $Complaints])

											<div class="flex-column" data-kt-stepper-element="content">
												<div class="fv-row">
													<label class=" form-label"><b>Müşteriye Kesilen Onarım Faturası (Opsiyonel)</b></label>
													<div class="dropzone" id="dropZone1">
														<div class="dz-message needsclick">
															<i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

															<div class="ms-4 d-flex justify-content-center align-items-center">
																<h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları sürükleyin veya tıklayarak seçim yapın.</h3>
															</div>
														</div>
													</div>
                                                    <input type="hidden" name="docs[invoice]" id="dropZone1Input" value="@if(isset($Application->files['invoice']) && !empty($Application->files['invoice'])){{$Application->files['invoice']}}@endif">
												</div>

                                                @php
                                                $invoices = null;
                                                $faults = null;
                                                    if(isset($Application) && !empty($Application->files)){

                                                        if(isset($Application->files['invoice']) && !empty($Application->files['invoice'])) {
                                                            $invoices = explode(',',$Application->files['invoice']);
                                                        }

                                                        if(isset($Application->files['fault']) && !empty($Application->files['fault'])) {
                                                            $faults = explode(',',$Application->files['fault']);
                                                        }

                                                    }
                                                @endphp

                                                @if(!empty($invoices))
                                                    <div class="fv-row mt-5">
                                                        <label class=" form-label"><b>Yüklü Dosyalar</b></label>
                                                        <div class="d-flex " id="dropZone1InputAdditionalFiles">
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
													<label class=" form-label"><b>Parçaya Dair Arıza / Hata Görseli (Opsiyonel)</b></label>
													<div class="dropzone" id="dropZone2">
														<div class="dz-message needsclick">
															<i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

															<div class="ms-4 d-flex justify-content-center align-items-center">
																<h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları sürükleyin veya tıklayarak seçim yapın.</h3>
															</div>
														</div>
													</div>
                                                    <input type="hidden" name="docs[fault]" id="dropZone2Input" value="@if(isset($Application->files['fault']) && !empty($Application->files['fault'])){{$Application->files['fault']}}@endif">
												</div>

                                                 @if(!empty($faults))
                                                    <div class="fv-row mt-5">
                                                        <label class=" form-label"><b>Yüklü Dosyalar</b></label>
                                                        <div class="d-flex " id="dropZone2InputAdditionalFiles">
                                                            @forelse($faults as $invoice)

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
        let inputs = null;
        @if(isset($inputs))
            @if(!is_null($inputs))
            inputs = @json($inputs);
        @endif
        @endif

        @if(isset($allinputs))
            let allInputs = @json($allinputs);
        @endif
    </script>


@endsection
