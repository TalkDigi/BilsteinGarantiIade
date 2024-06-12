@extends('layouts.dashboard')
@section('content')
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
						<!--begin::Post-->
						<div class="content flex-row-fluid" id="kt_content">
							<!--begin::FAQ card-->
							<div class="card">
								<!--begin::Body-->
								<div class="card-body p-lg-15">
									<!--begin::Classic content-->
									<div class="mb-13">
										<!--begin::Intro-->
										<div class="mb-15">
											<!--begin::Title-->
											<h4 class="fs-2x text-gray-800 w-bolder mb-6">Sıkça Sorulan Sorular</h4>
											<!--end::Title-->
											<!--begin::Text-->
											<p class="fw-semibold fs-4 text-gray-600 mb-2">Garanti ve iade süreçlerine dair sık sorulan soruları bu sayfadan görüntüleyebilirsiniz.</p>
											<!--end::Text-->
										</div>
										<!--end::Intro-->
										<!--begin::Row-->
										<div class="row mb-12">
											<!--begin::Col-->
											<div class="col-md-12 pe-md-10 mb-10 mb-md-0">
												@forelse($Questions as $q)
                                                    <div class="m-0">
                                                        <!--begin::Heading-->
                                                        <div class="d-flex align-items-center collapsible py-3 toggle mb-0" data-bs-toggle="collapse" data-bs-target="#q{{$q->id}}">
                                                            <!--begin::Icon-->
                                                            <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                                                <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                                <i class="ki-duotone ki-plus-square toggle-off fs-1">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                </i>
                                                            </div>
                                                            <!--end::Icon-->
                                                            <!--begin::Title-->
                                                            <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">{{$q->title}}</h4>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Heading-->
                                                        <!--begin::Body-->
                                                        <div id="q{{$q->id}}" class="collapse show fs-6 ms-1">
                                                            <!--begin::Text-->
                                                            <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10 question-body">
                                                                {!! $q->text !!}
                                                            </div>
                                                            <!--end::Text-->
                                                        </div>
                                                        <!--end::Content-->
                                                        <!--begin::Separator-->
                                                        <div class="separator separator-dashed"></div>
                                                        <!--end::Separator-->
                                                    </div>
                                                    @empty
                                                @endforelse


											</div>

										</div>

									</div>

								</div>
								<!--end::Body-->
							</div>
							<!--end::FAQ card-->
						</div>
						<!--end::Post-->
					</div>
@endsection
