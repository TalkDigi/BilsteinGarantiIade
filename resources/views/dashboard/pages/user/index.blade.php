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
                            <input type="text" data-kt-user-table-filter="search"
                                   class="form-control form-control-solid w-250px ps-13" placeholder="Kullanıcı Ara"/>
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Add user-->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_add_user">
                                <i class="ki-duotone ki-plus fs-2"></i>Kullanıcı Ekle
                            </button>
                            <!--end::Add user-->
                        </div>
                        <!--end::Toolbar-->

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
                                        <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                             data-kt-users-modal-action="close">
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
                                        <form id="kt_modal_add_user_form" class="form" action="{{route('user.store')}}"
                                              method="POST">
                                            @csrf
                                            <!--begin::Scroll-->
                                            <div class="d-flex flex-column scroll-y px-5 px-lg-10"
                                                 id="kt_modal_add_user_scroll" data-kt-scroll="true"
                                                 data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                                                 data-kt-scroll-dependencies="#kt_modal_add_user_header"
                                                 data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
                                                 data-kt-scroll-offset="300px">
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="required fw-semibold fs-6 mb-2">Ad & Soyad</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" name="name"
                                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                                           placeholder="Ad & Soyad" required/>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="required fw-semibold fs-6 mb-2">E-Posta</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="email" name="email"
                                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                                           placeholder="example@domain.com" required/>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="required fw-semibold fs-6 mb-2">Şifre</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="password" name="password"
                                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                                           required/>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <div class="fv-row mb-7 customerSelect">
                                                    <label class="form-label fs-6 fw-semibold">Müşteri:</label>
                                                    <select class="form-select form-select-solid fw-bold customerSelect"
                                                            name="customer" data-kt-select2="true" data-placeholder=" ."
                                                            data-allow-clear="true" data-kt-user-table-filter="two-step"
                                                            data-hide-search="true" 
                                                            >
                                                        <option></option>
                                                        @forelse($Customers as $customer)
                                                            <option
                                                                value="{{$customer->No}}">{{$customer->Name2}}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>

                                                <div class="branchSelectContainer" style="display: none;">
    <label for="branchSelect" class="form-label fs-6 fw-semibold">Şube:</label>
    <select class="form-select form-select-solid fw-bold branchSelect" name="branch">
        <!-- Branch seçenekleri buraya eklenecek -->
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
                                                        <div class="d-flex fv-row role{{$role->id}}">
                                                            <!--begin::Radio-->
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <!--begin::Input-->
                                                                <input class="form-check-input me-3" name="role"
                                                                       type="radio" value="{{$role->id}}"
                                                                       id="kt_modal_update_role_option_{{$role->id}}"/>
                                                                <!--end::Input-->
                                                                <!--begin::Label-->
                                                                <label class="form-check-label"
                                                                       for="kt_modal_update_role_option_{{$role->id}}">
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
                                                <button type="reset" class="btn btn-light me-3"
                                                        data-kt-users-modal-action="cancel">Kapat
                                                </button>
                                                <button type="submit" class="btn btn-primary"
                                                        data-kt-users-modal-action="submit">
                                                    <span class="indicator-label">Gönder</span>
                                                    <span class="indicator-progress">Lütfen bekleyin...
																	<span
                                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
                        <div class="modal fade" id="kt_modal_edit_user" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <!--begin::Modal content-->
                                <div class="modal-content">
                                    <!--begin::Modal header-->
                                    <div class="modal-header" id="kt_modal_edit_user_header">
                                        <!--begin::Modal title-->
                                        <h2 class="fw-bold">Kullanıcı Düzenle</h2>
                                        <!--end::Modal title-->
                                        <!--begin::Close-->
                                        <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                             data-kt-users-modal-action="close">
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
                                        <form id="kt_modal_edit_user_form" class="form" action="{{route('user.update')}}"
                                              method="POST">
                                            @csrf
                                            <input type="hidden" name="uuid" id="uuid">
                                            <!--begin::Scroll-->
                                            <div class="d-flex flex-column scroll-y px-5 px-lg-10"
                                                 id="kt_modal_edit_user_scroll" data-kt-scroll="true"
                                                 data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                                                 data-kt-scroll-dependencies="#kt_modal_edit_user_header"
                                                 data-kt-scroll-wrappers="#kt_modal_edit_user_scroll"
                                                 data-kt-scroll-offset="300px">
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="required fw-semibold fs-6 mb-2">Ad & Soyad</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" name="name"
                                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                                           placeholder="Ad & Soyad" required/>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="required fw-semibold fs-6 mb-2">E-Posta</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="email" name="email"
                                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                                           placeholder="example@domain.com" required/>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="required fw-semibold fs-6 mb-2">Şifre</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="password" name="password"
                                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                                           />
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <div class="fv-row mb-7 customerSelect">
                                                    <label class="form-label fs-6 fw-semibold">Müşteri:</label>
                                                    <select class="form-select form-select-solid fw-bold customerSelect"
                                                            name="customer" data-kt-select2="true" data-placeholder=" ."
                                                            data-allow-clear="true" data-kt-user-table-filter="two-step"
                                                            data-hide-search="true" 
                                                            >
                                                        <option></option>
                                                        @forelse($Customers as $customer)
                                                            <option
                                                                value="{{$customer->No}}">{{$customer->Name2}}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>

                                                <div class="branchSelectContainer" style="display: none;">
    <label for="branchSelect" class="form-label fs-6 fw-semibold">Şube:</label>
    <select class="form-select form-select-solid fw-bold branchSelect" name="branch">
        <!-- Branch seçenekleri buraya eklenecek -->
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
                                                        <div class="d-flex fv-row role{{$role->id}}">
                                                            <!--begin::Radio-->
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <!--begin::Input-->
                                                                <input class="form-check-input me-3" name="role"
                                                                       type="radio" value="{{$role->id}}"
                                                                       id="kt_modal_update_role_option_{{$role->id}}"/>
                                                                <!--end::Input-->
                                                                <!--begin::Label-->
                                                                <label class="form-check-label"
                                                                       for="kt_modal_update_role_option_{{$role->id}}">
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
                                                <button type="reset" class="btn btn-light me-3"
                                                        data-kt-users-modal-action="cancel">Kapat
                                                </button>
                                                <button type="submit" class="btn btn-primary"
                                                        data-kt-users-modal-action="submit">
                                                    <span class="indicator-label">Gönder</span>
                                                    <span class="indicator-progress">Lütfen bekleyin...
																	<span
                                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
							<th class="min-w-125px">Şube</th>
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
                                        <a href="javascript:void(0)"
                                           class="text-gray-800 text-hover-primary mb-1">{{$user->name}}</a>
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
									@if($user->branch)
										<span class="badge badge-light">{{$user->branch->BranchName}}</span>
									@else
										<span class="badge badge-danger">Şube ataması yapılmadı.</span>
									@endif
								</td>
                                <td>
                                    @if($user->roles[0]->name == 'Yönetici')

                                        <span class="badge badge-primary">Yönetici</span>

                                    @else

                                        @forelse($user->roles as $role)
                                            <span class="badge badge-info">{{$role->name}}</span>
                                        @empty
                                            <span class="badge badge-danger">Rol atanmamış</span>
                                        @endforelse 

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
                                    <a data-user-id="{{$user->uuid}}"
                                       class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm edit-user">Düzenle</a>
                                    <a href="{{ route('user.destroy', $user->uuid) }}" class="btn btn-danger btn-active-light-danger btn-flex btn-center btn-sm delete-user ms-2">Sil</a>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-user');
            
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const userId = this.getAttribute('href').split('/').pop();
                    
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Bu kullanıcıyı silmek istediğinizden emin misiniz?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Evet, sil!',
                        cancelButtonText: 'Hayır, vazgeç'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = this.getAttribute('href');
                        }
                    });
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const roleInputs = document.querySelectorAll('input[name="role"]');
            roleInputs.forEach(input => {
                input.addEventListener('change', function () {
                    if (this.value == 1) {
                        Swal.fire({
                            title: 'Uyarı',
                            text: 'Bir yönetici hesabı oluşturmayı seçtiniz. Yönetici hesapları, normal müşterilerden farklı yetkilere sahip. Oluşturduğunuz hesap tüm başvuruları görüntüleyebilecek ve durumlarını değiştirebilecek. Devam etmek istiyor musunuz?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Devam Et',
                            cancelButtonText: 'İptal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.querySelector('.customerSelect').style.display = 'none';
                                document.querySelector('.branchSelectContainer').style.display = 'none';
                            } else {
                                this.checked = false;
                                document.querySelector('.role1').remove();


                            }
                        });
                    } else {
                        const customerSelect = document.querySelector('.customerSelect');
                customerSelect.style.display = 'block';
                customerSelect.querySelector('select').setAttribute('required', 'required');
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            // Tüm 'edit-user' butonlarını seç
            const editButtons = document.querySelectorAll('.edit-user');

            // Her bir 'edit-user' butonuna olay dinleyicisi ekle
            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    console.log('edit-user clicked');
                    const userId = this.getAttribute('data-user-id');
                    console.log(userId);
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(`/kullanicilar/duzenle/${userId}`, {
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);

                            // Modal alanlarını doldur
                            document.getElementById('kt_modal_edit_user_form').querySelector('[name="name"]').value = data.user.name;
                            document.getElementById('kt_modal_edit_user_form').querySelector('[name="email"]').value = data.user.email;
                            document.getElementById('kt_modal_edit_user_form').querySelector('[name="uuid"]').value = data.user.uuid;
                            
                            // Rol seçimini güncelle
                            console.log(data.role);
                            // Önce tüm radio butonları temizle
                            const allRoleRadios = document.querySelectorAll('#kt_modal_edit_user_form [name="role"]');
                            allRoleRadios.forEach(radio => {
                                radio.checked = false;
                            });

                            // Eğer data.role bir dizi ise
                            if (Array.isArray(data.role)) {
                                // Şube yöneticisi rolü var mı kontrol et
                                const hasManagerRole = data.role.some(role => role.id === 3);
                                
                                if (hasManagerRole) {
                                    // Şube yöneticisi rolünü seç
                                    allRoleRadios.forEach(radio => {
                                        if (radio.value == 3) {
                                            radio.checked = true;
                                        }
                                    });
                                } else {
                                    // İlk rolü seç
                                    allRoleRadios.forEach(radio => {
                                        if (radio.value == data.role[0].id) {
                                            radio.checked = true;
                                        }
                                    });
                                }
                            } else {
                                // Tek rol varsa onu seç
                                allRoleRadios.forEach(radio => {
                                    if (radio.value == data.role.id) {
                                        radio.checked = true;
                                    }
                                });
                            }

                            const roleRadios = document.querySelectorAll('#kt_modal_edit_user_form [name="role"]');
                            roleRadios.forEach(radio => {
                                if (radio.value == data.role.id) {
                                    radio.checked = true;
                                }
                            });

                            // Şube seçimini güncelle
                            if (data.branches && data.branches.length > 0) {
                                const branchContainer = document.getElementById('kt_modal_edit_user_form').querySelector('.branchSelectContainer');
                                const branchSelect = document.getElementById('kt_modal_edit_user_form').querySelector('.branchSelect');
                                
                                if (branchContainer && branchSelect) {
                                    // Şube container'ı göster
                                    branchContainer.style.display = 'block';
                                    
                                    // Mevcut seçenekleri temizle
                                    branchSelect.innerHTML = '';
                                    
                                    // Şubeleri select'e ekle
                                    data.branches.forEach(branch => {
                                        const option = document.createElement('option');
                                        option.value = branch.BranchID;
                                        option.textContent = branch.BranchName;
                                        branchSelect.appendChild(option);
                                    });

                                    // Eğer kullanıcının şubesi varsa seç
                                    console.log('User branch no',data.user.BranchNo);

                                    if (data.user.BranchNo) {
                                        $(branchSelect).val(data.user.BranchNo).trigger('change');
                                    }
                                }
                            }

                            // Müşteri seçimini güncelle (eğer varsa)
                            if (data.user.CustNo) {
                                const customerSelect = document.getElementById('kt_modal_edit_user_form').querySelector('[name="customer"]');
                                console.log(customerSelect);
                                if (customerSelect) {
                                    // Select2'yi kullanarak seçeneği güncelle
                                    $(customerSelect).val(data.user.CustNo).trigger('change');
                                }
                            }

                            // Durum seçimini güncelle
                            const statusSwitch = document.getElementById('kt_modal_edit_user_form').querySelector('[name="status"]');
                            if (statusSwitch) {
                                statusSwitch.checked = data.user.status == 1;
                            }

                            // Modal'ı göster
                            const editUserModal = new bootstrap.Modal(document.getElementById('kt_modal_edit_user'));
                            editUserModal.show();
                        })
                        .catch(error => {
                            console.error('Kullanıcı verileri alınırken bir hata oluştu:', error);
                        });
                });
            });
        });
        

        document.addEventListener('DOMContentLoaded', function() {
            // customerSelect class'ına sahip select2 elementlerini seç
            const customerSelects = document.querySelectorAll('select.customerSelect');
            const branchSelectContainers = document.querySelectorAll('.branchSelectContainer');
            const branchSelects = document.querySelectorAll('.branchSelect');

            // jQuery kullanarak select2 olayını dinle
            $(customerSelects).each(function(index, customerSelect) {
                $(customerSelect).on('select2:select', function(e) {
                    const customerId = this.value;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // AJAX isteği
                    fetch('/get-customer-branches', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ customer_id: customerId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // İlgili branchSelect'i temizle
                        const branchSelect = branchSelects[index];
                        branchSelect.innerHTML = '';

                        console.log(data);

                        if (data.branches && data.branches.length > 0) {
                            // Gelen verileri branchSelect'e ekle
                            data.branches.forEach(branch => {
                                const option = document.createElement('option');
                                option.value = branch.BranchID;
                                option.textContent = branch.BranchName;
                                branchSelect.appendChild(option);
                            });

                            // İlgili branchSelectContainer'ı göster
                            branchSelectContainers[index].style.display = 'block';
                        } else {

                            // Eğer veri yoksa ilgili branchSelectContainer'ı gizle
                            branchSelectContainers[index].style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Branch verileri alınırken bir hata oluştu:', error);
                    });

                });
            });
        });
    </script>
@endsection
