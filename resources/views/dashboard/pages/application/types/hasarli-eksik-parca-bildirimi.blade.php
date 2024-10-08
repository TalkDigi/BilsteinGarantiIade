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

                        <form
                            class="form d-flex flex-column flex-lg-row application_form @if(isset($Application)) update @endif"
                            autocomplete="off"
                            @if(isset($Application))
                                action="{{ route('dashboard.application.update',[$Application->claim_number]) }}"
                            @endif

                            method="POST"
                            action="{{route('dashboard.application.store',['type' => $Type->uuid ])}}">
                            @csrf
                            <input type="hidden" name="uuid" value="{{$Type->uuid}}">
                            <div class="mb-5 w-100">

                                @include('dashboard.pages.application.includes.default-form', ['Type'=> $Type, 'Complaints' => $Type->complaints])

                                <div class="flex-column" data-kt-stepper-element="content">

                                    <div class="fv-row mt-5 fault">
                                        <label class=" form-label"><b>Parçaya / Kutuya Dair Hata Görseli</b></label>
                                        <div class="dropzone" id="dropZone11">
                                            <div class="dz-message needsclick">
                                                <i class="ki-duotone ki-file-up fs-3x text-primary"><span
                                                        class="path1"></span><span class="path2"></span></i>

                                                <div class="ms-4 d-flex justify-content-center align-items-center">
                                                    <h3 class="fs-5 fw-bold text-gray-900 mb-1">Dosyaları sürükleyin
                                                        veya tıklayarak seçim yapın.</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="docs[fault]" id="dropZone11Input"
                                               value="@if(isset($Application->files['fault']) && !empty($Application->files['fault'])){{$Application->files['fault']}}@endif">
                                    </div>

                                    @if(!empty($faults))
                                        <div class="fv-row mt-5">
                                            <label class=" form-label"><b>Yüklü Dosyalar</b></label>
                                            <div class="d-flex " id="dropZone11InputAdditionalFiles">
                                                @forelse($faults as $invoice)

                                                    <div class="d-flex inner-file">
                                                        <a href="{{ Storage::url('application-files/'.$invoice) }}"
                                                           target="_blank" data-file="{{$invoice}}"
                                                           data-bind="dropZone11Input">
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

        //if is there any input with name productCount
        //when .productSearchForm form is submit preventDefault.
        //send an ajax requext and open a swal, with number input
        //when user submit swal, set the input value to swal input value
        //submit the productSearchForm form
    </script>

@endsection
