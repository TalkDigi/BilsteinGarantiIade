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

                        @if(isset($Application))
                            @include('dashboard.pages.application.includes.product-search', ['Type' => $Type, 'Application' => $Application])
                        @else
                            @include('dashboard.pages.application.includes.product-search', ['Type' => $Type])
                        @endif

                        <form class="form d-flex flex-column flex-lg-row application_form @if(isset($Application)) update @endif"
                              @if(isset($Application))
                                  action="{{ route('dashboard.application.update',[$Application->claim_number]) }}"
                              @endif

                              method="POST"
                                action="{{route('dashboard.application.store',['type' => $Type->uuid ])}}">
                            @csrf
                            <div class="mt-5 w-100">

                                <input type="hidden" name="uuid" value="{{$Type->uuid}}">

                                @include('dashboard.pages.application.includes.default-form', ['Type'=> $Type, 'Complaints' => $Type->complaints])

                                <div class="flex-column mt-5">
                                    <div class="fv-row invoice">
                                        <label class=" form-label"><b>Müşteriye Kesilen Fatura
                                                (Opsiyonel)</b></label>
                                        <div class="dropzone" id="dropZone1">
                                            <div class="dz-message needsclick">
                                                <i class="ki-duotone ki-file-up fs-3x text-primary"><span
                                                        class="path1"></span><span class="path2"></span></i>

                                                <div class="ms-4 d-flex justify-content-center align-items-center">
                                                    <h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları sürükleyin
                                                        veya tıklayarak seçim yapın.</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="docs[invoice]" id="dropZone1Input"
                                               value="@if(isset($Application->files['invoice']) && !empty($Application->files['invoice'])){{$Application->files['invoice']}}@endif">
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
                                                        <a href="{{ Storage::url('application-files/'.$invoice) }}"
                                                           target="_blank" data-file="{{$invoice}}"
                                                           data-bind="dropZone1Input">
                                                            {{ $invoice }}
                                                        </a>
                                                        <span
                                                            class="badge badge-danger delete-file d-inline-block ml-3"
                                                            style="margin-left:5px">X</span>
                                                    </div>

                                                @empty
                                                @endforelse
                                            </div>
                                        </div>
                                    @endif


                                    <div class="fv-row mt-5 fault">
                                        <label class=" form-label"><b>Parçaya Dair Arıza / Hata Görseli / Videosu
                                                (Opsiyonel)</b></label>
                                        <div class="dropzone" id="dropZone2">
                                            <div class="dz-message needsclick">
                                                <i class="ki-duotone ki-file-up fs-3x text-primary"><span
                                                        class="path1"></span><span class="path2"></span></i>

                                                <div class="ms-4 d-flex justify-content-center align-items-center">
                                                    <h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları sürükleyin
                                                        veya tıklayarak seçim yapın.</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="docs[fault]" id="dropZone2Input"
                                               value="@if(isset($Application->files['fault']) && !empty($Application->files['fault'])){{$Application->files['fault']}}@endif">
                                    </div>

                                    @if(!empty($faults))
                                        <div class="fv-row mt-5">
                                            <label class=" form-label"><b>Yüklü Dosyalar</b></label>
                                            <div class="d-flex " id="dropZone2InputAdditionalFiles">
                                                @forelse($faults as $invoice)

                                                    <div class="d-flex inner-file">
                                                        <a href="{{ Storage::url('application-files/'.$invoice) }}"
                                                           target="_blank" data-file="{{$invoice}}"
                                                           data-bind="dropZone2Input">
                                                            {{ $invoice }}
                                                        </a>
                                                        <span
                                                            class="badge badge-danger delete-file d-inline-block ml-3"
                                                            style="margin-left:5px">X</span>
                                                    </div>

                                                @empty
                                                @endforelse
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

        let inputs = null;
        @if(isset($inputs))
            @if(!is_null($inputs))
            inputs = @json($inputs);
        @endif
        @endif

        @if(isset($allinputs))
        let allInputs = @json($allinputs);
        @endif

        console.log(allInputs);
    </script>

@endsection
