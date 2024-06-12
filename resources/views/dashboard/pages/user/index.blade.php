@extends('layouts.dashboard')
@section('content')
    					<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
						<!--begin::Post-->
						<div class="content flex-row-fluid" id="kt_content">
							<!--begin::Card-->
							<div class="card">
								<!--begin::Card header-->
								<div class="card-header border-0 pt-6">
									<!--begin::Card title-->
									<div class="card-title">
										<!--begin::Search-->
										<div class="d-flex align-items-center position-relative my-1">
											<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
												<span class="path1"></span>
												<span class="path2"></span>
											</i>
											<input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Kullanıcı Ara" />
										</div>
										<!--end::Search-->
									</div>
									<!--begin::Card title-->
									<!--begin::Card toolbar-->
									<div class="card-toolbar">
										<!--begin::Toolbar-->
										<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
											{{--<button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
											<i class="ki-duotone ki-filter fs-2">
												<span class="path1"></span>
												<span class="path2"></span>
											</i>Filtrele</button>
											<div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
												<!--begin::Header-->
												<div class="px-7 py-5">
													<div class="fs-5 text-gray-900 fw-bold">Filtre</div>
												</div>
												<!--end::Header-->
												<!--begin::Separator-->
												<div class="separator border-gray-200"></div>
												<!--end::Separator-->
												<!--begin::Content-->
												<div class="px-7 py-5" data-kt-user-table-filter="form">
													<!--begin::Input group-->
													<div class="mb-10">
														<label class="form-label fs-6 fw-semibold">Rol:</label>
														<select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Rol seçin" data-allow-clear="true" data-kt-user-table-filter="role" data-hide-search="true">
															<option></option>
															@forelse($Roles as $role)
                                                                <option value="{{$role->name}}">{{$role->name}}</option>
                                                            @empty
                                                            @endforelse

														</select>
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="mb-10">
														<label class="form-label fs-6 fw-semibold">Müşteri:</label>
														<select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="two-step" data-hide-search="true">
															<option></option>
															@forelse($Customers as $customer)
                                                                <option value="{{$customer->Name2}}">{{$customer->Name2}}</option>
                                                            @empty
                                                            @endforelse
														</select>
													</div>
													<!--end::Input group-->
													<!--begin::Actions-->
													<div class="d-flex justify-content-end">
														<button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">Uygula</button>
													</div>
													<!--end::Actions-->
												</div>
												<!--end::Content-->
											</div>--}}
											<!--end::Filter-->
											<!--begin::Add user-->
											<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
											<i class="ki-duotone ki-plus fs-2"></i>Kullanıcı Ekle</button>
											<!--end::Add user-->
										</div>
										<!--end::Toolbar-->

										<!--begin::Modal - Adjust Balance-->
										<div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
											<!--begin::Modal dialog-->
											<div class="modal-dialog modal-dialog-centered mw-650px">
												<!--begin::Modal content-->
												<div class="modal-content">
													<!--begin::Modal header-->
													<div class="modal-header">
														<!--begin::Modal title-->
														<h2 class="fw-bold">Export Users</h2>
														<!--end::Modal title-->
														<!--begin::Close-->
														<div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
															<i class="ki-duotone ki-cross fs-1">
																<span class="path1"></span>
																<span class="path2"></span>
															</i>
														</div>
														<!--end::Close-->
													</div>
													<!--end::Modal header-->
													<!--begin::Modal body-->
													<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
														<!--begin::Form-->
														<form id="kt_modal_export_users_form" class="form" action="#">
															<!--begin::Input group-->
															<div class="fv-row mb-10">
																<!--begin::Label-->
																<label class="fs-6 fw-semibold form-label mb-2">Select Roles:</label>
																<!--end::Label-->
																<!--begin::Input-->
																<select name="role" data-control="select2" data-placeholder="Select a role" data-hide-search="true" class="form-select form-select-solid fw-bold">
																	<option></option>
																	<option value="Administrator">Administrator</option>
																	<option value="Analyst">Analyst</option>
																	<option value="Developer">Developer</option>
																	<option value="Support">Support</option>
																	<option value="Trial">Trial</option>
																</select>
																<!--end::Input-->
															</div>
															<!--end::Input group-->
															<!--begin::Input group-->
															<div class="fv-row mb-10">
																<!--begin::Label-->
																<label class="required fs-6 fw-semibold form-label mb-2">Select Export Format:</label>
																<!--end::Label-->
																<!--begin::Input-->
																<select name="format" data-control="select2" data-placeholder="Select a format" data-hide-search="true" class="form-select form-select-solid fw-bold">
																	<option></option>
																	<option value="excel">Excel</option>
																	<option value="pdf">PDF</option>
																	<option value="cvs">CVS</option>
																	<option value="zip">ZIP</option>
																</select>
																<!--end::Input-->
															</div>
															<!--end::Input group-->
															<!--begin::Actions-->
															<div class="text-center">
																<button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
																<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
																	<span class="indicator-label">Submit</span>
																	<span class="indicator-progress">Please wait...
																	<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
																</button>
															</div>
															<!--end::Actions-->
														</form>
														<!--end::Form-->
													</div>
													<!--end::Modal body-->
												</div>
												<!--end::Modal content-->
											</div>
											<!--end::Modal dialog-->
										</div>
										<!--end::Modal - New Card-->
										<!--begin::Modal - Add task-->
										<div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
											<!--begin::Modal dialog-->
											<div class="modal-dialog modal-dialog-centered mw-650px">
												<!--begin::Modal content-->
												<div class="modal-content">
													<!--begin::Modal header-->
													<div class="modal-header" id="kt_modal_add_user_header">
														<!--begin::Modal title-->
														<h2 class="fw-bold">Kullanıcı Ekle</h2>
														<!--end::Modal title-->
														<!--begin::Close-->
														<div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
															<i class="ki-duotone ki-cross fs-1">
																<span class="path1"></span>
																<span class="path2"></span>
															</i>
														</div>
														<!--end::Close-->
													</div>
													<!--end::Modal header-->
													<!--begin::Modal body-->
													<div class="modal-body px-5 my-7">
														<!--begin::Form-->
														<form id="kt_modal_add_user_form" class="form" action="{{route('user.store')}}" method="POST">
                                                            @csrf
															<!--begin::Scroll-->
															<div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
																<!--begin::Input group-->
																<div class="fv-row mb-7">
																	<!--begin::Label-->
																	<label class="required fw-semibold fs-6 mb-2">Ad & Soyad</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Ad & Soyad" required />
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row mb-7">
																	<!--begin::Label-->
																	<label class="required fw-semibold fs-6 mb-2">E-Posta</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@domain.com"  required />
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
                                                                <!--begin::Input group-->
																<div class="fv-row mb-7">
																	<!--begin::Label-->
																	<label class="required fw-semibold fs-6 mb-2">Şifre</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="password" name="password" class="form-control form-control-solid mb-3 mb-lg-0"  required />
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
                                                                <div class="fv-row mb-7">
                                                                    	<label class="form-label fs-6 fw-semibold">Müşteri:</label>
                                                                        <select class="form-select form-select-solid fw-bold" name="customer" data-kt-select2="true" data-placeholder="Müşteri seçin." data-allow-clear="true" data-kt-user-table-filter="two-step" data-hide-search="true" required>
                                                                            <option></option>
                                                                            @forelse($Customers as $customer)
                                                                                <option value="{{$customer->No}}">{{$customer->Name2}}</option>
                                                                            @empty
                                                                            @endforelse
                                                                        </select>
                                                                </div>

																<!--begin::Input group-->
																<div class="mb-5">
																	<!--begin::Label-->
																	<label class="required fw-semibold fs-6 mb-5">Rol</label>
																	<!--end::Label-->
																	<!--begin::Roles-->
																	<!--begin::Input row-->
																	@forelse($Roles as $role)
                                                                        <div class="d-flex fv-row">
																		<!--begin::Radio-->
																		<div class="form-check form-check-custom form-check-solid">
																			<!--begin::Input-->
																			<input class="form-check-input me-3" name="role" type="radio" value="{{$role->id}}" id="kt_modal_update_role_option_{{$role->id}}"/>
																			<!--end::Input-->
																			<!--begin::Label-->
																			<label class="form-check-label" for="kt_modal_update_role_option_{{$role->id}}">
																				<div class="fw-bold text-gray-800">
                                                                                    {{$role->name}}</div>
																			</label>
																			<!--end::Label-->
																		</div>
																		<!--end::Radio-->
																	</div>
																	<!--end::Input row-->
																	<div class='separator separator-dashed my-5'></div>
                                                                        @empty
                                                                    @endforelse

																	<!--end::Roles-->
																</div>
																<!--end::Input group-->
															</div>
															<!--end::Scroll-->
															<!--begin::Actions-->
															<div class="text-center pt-10">
																<button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Kapat</button>
																<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
																	<span class="indicator-label">Gönder</span>
																	<span class="indicator-progress">Lütfen bekleyin...
																	<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
																</button>
															</div>
															<!--end::Actions-->
														</form>
														<!--end::Form-->
													</div>
													<!--end::Modal body-->
												</div>
												<!--end::Modal content-->
											</div>
											<!--end::Modal dialog-->
										</div>
										<!--end::Modal - Add task-->
									</div>
									<!--end::Card toolbar-->
								</div>
								<!--end::Card header-->
								<!--begin::Card body-->
								<div class="card-body py-4">
									<!--begin::Table-->
									<table class="table align-middle table-row-dashed fs-6 gy-5 table-responsive" id="kt_table_users">
										<thead>
											<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

												<th class="min-w-125px">Kullanıcı</th>
												<th class="min-w-125px">Müşteri</th>
												<th class="min-w-125px">Rol</th>
                                                <th class="min-w-125px">Durum</th>
												<th class="min-w-125px">Oluşturma Tarihi</th>
												<th class="text-end min-w-100px">Eylemler</th>
											</tr>
										</thead>
										<tbody class="text-gray-600 fw-semibold">
											@forelse($Users as $user)
                                                <tr>

												<td class="d-flex align-items-center">
													<!--begin:: Avatar -->
													<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
															<a href="javascript:void(0)">
																<div class="symbol-label fs-3 bg-light-primary text-primary text-uppercase">
																	{{substr($user->name,0,1)}}
                                                                </div>
															</a>
													</div>
													<!--end::Avatar-->
													<!--begin::User details-->
													<div class="d-flex flex-column">
														<a href="javascript:void(0)" class="text-gray-800 text-hover-primary mb-1">{{$user->name}}</a>
														<span>{{$user->email}}</span>
													</div>
													<!--begin::User details-->
												</td>
												<td>
                                                    @if($user->customer)
                                                        <span class="badge badge-light">{{$user->customer->Name2}}</span>
                                                    @else
                                                        <span class="badge badge-danger">Müşteri ataması yapılmadı.</span>
                                                    @endif
                                                </td>
												<td>
                                                    @if($user->roles[0]->name == 'Yönetici')

                                                        <span class="badge badge-primary">Yönetici</span>

                                                    @else

                                                        <span class="badge badge-info">{{$user->roles[0]->name}}</span>

                                                    @endif

                                                </td>
                                                    <td>
                                                        @if($user->status)
                                                            <span class="badge badge-success">Aktif</span>
                                                        @else
                                                            <span class="badge badge-danger">Pasif</span>
                                                        @endif
                                                    </td>
												<td>
													<div class="badge badge-light fw-bold">
                                                        {{$user->created_at->diffForHumans()}}
                                                    </div>
												</td>
												<td class="text-end">
													<a href="javascript:void(0)" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm">Düzenle</a>
												</td>
											</tr>
                                                @empty
                                            @endforelse

										</tbody>
									</table>
									<!--end::Table-->
								</div>
								<!--end::Card body-->
							</div>
							<!--end::Card-->
						</div>
						<!--end::Post-->
					</div>

@endsection
@section('modals')
    @include('dashboard.modals.new-application')
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
@endsection
