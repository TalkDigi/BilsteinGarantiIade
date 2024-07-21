@extends('layouts.dashboard')
@section('content')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Navbar-->
            <div class="card mb-5 mb-xl-10">
                <div class="card-body pt-9 pb-0">
                    <!--begin::Details-->
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <!--end::Pic-->
                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <!--begin::Title-->
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <!--begin::User-->
                                <div class="d-flex flex-column">
                                    <!--begin::Name-->
                                    <div class="d-flex  mb-2 flex-column align-items-start">
                                        <h3 class="text-gray-900 text-hover-primary fs-2 fw-bold me-1 text-left">
                                            Yönetim</h3>
                                        <p class="text-muted">Bilgilendirme sayfalarını ve genel ayarları bu sayfa
                                            altından yönetebilirsiniz. </p>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Details-->
                    <!--begin::Navs-->
                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5 "
                               href="{{route('dashboard.setting.index')}}">Ayarlar</a>
                        </li>
                        <!--end::Nav item-->
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5 "
                               href="{{route('dashboard.setting.sss')}}">S.S.S</a>
                        </li>

                        <!--begin::Nav item-->
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="javascript:void(0)">Dosyalar</a>
                        </li>

                    </ul>
                    <!--begin::Navs-->
                </div>
            </div>
            <!--end::Navbar-->
            <!--begin::Basic info-->
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                     data-bs-target="#kt_account_profile_details" aria-expanded="true"
                     aria-controls="kt_account_profile_details">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Dosyalar</h3>
                    </div>
                    <!--end::Card title-->
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#add_sss">
                            <i class="ki-duotone ki-plus fs-2"></i>İçerik Ekle
                        </button>
                    </div>
                </div>
                <!--begin::Card header-->
                <!--begin::Content-->
                <div id="kt_account_settings_profile_details" class="collapse show">
                   <div class="card-body">
                       <table class="table align-middle table-row-bordered fs-6 gy-5" id="kt_ecommerce_products_table">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">

										<th>#</th>
                                        <th>Durum</th>
                                        <th>Menüde Gözüksün</th>
										<th class="text-center min-w-100px">Başlık</th>
                                        <th class="text-center">Oluşturma Tarihi</th>
                                        <th class="text-center">Güncelleme Tarihi</th>
										<th class="text-center min-w-70px">Eylemler</th>
									</tr>
								</thead>
								<tbody class="fw-semibold text-gray-600">
                                    @forelse($Files as $question)
                                        <tr>
                                            <td>{{$loop->index + 1}}</td>

                                            <td>
                                                @if($question->status == 1)
                                                    <span class="badge badge-light-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-light-danger">Pasif</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($question->show_menu == 1)
                                                    <span class="badge badge-light-success">Evet</span>
                                                @else
                                                    <span class="badge badge-light-danger">Hayır</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{$question->name}}</td>
                                            <td class="text-center">{{$question->created_at}}</td>
                                            <td class="text-center">{{$question->updated_at}}</td>
                                            <td class="text-center">
                                                <a
                                                    data-id="{{$question->id}}"
                                                    data-status="{{$question->status}}"
                                                    data-show_menu="{{$question->show_menu}}"
                                                    data-title="{{$question->name}}"
                                                    data-path="{{Storage::url('files/'.$question->path)}}"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 editSSS">
                                                    <span class="svg-icon svg-icon-3">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                </a>
                                                <a href="{{route('dashboard.setting.fileDestroy',['id' => $question->id])}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                                    <!--begin::Svg Icon | path: icons/duotone/General/Trash.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                   @endforelse
								</tbody>
							</table>
                   </div>
                </div>
                <!--end::Content-->
            </div>

        </div>
        <!--end::Post-->
    </div>

    <!--begin::Modal - Add task-->
    <div class="modal fade" id="add_sss" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">İçerik Ekle</h2>
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
                    <form id="add_file_form" class="form" action="{{route('dashboard.setting.fileStore')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="">
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                             data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                             data-kt-scroll-dependencies="#kt_modal_add_user_header"
                             data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">

                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchDefault" name="status" checked/>
                                        <label class="form-check-label" for="flexSwitchDefault">
                                            Durum
                                        </label>
                                    </div>

                            </div>

                            <div class="fv-row mb-7">

                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchDefault" name="show_menu"/>
                                        <label class="form-check-label" for="flexSwitchDefault">
                                            Menüde Gözüksün
                                        </label>
                                    </div>

                            </div>
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Başlık</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="title" class="form-control form-control-solid mb-3 mb-lg-0"
                                       placeholder="Başlık" required/>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Dosya</label>


                                <input type="file" class="form-control" name="file">
                            </div>
                            <div class="fv-row mb-7">
                                <a href="" target="_blank" class="uploadedFile" style="display: none">Yüklü Dosya</a>
                            </div>

                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-10">
                            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                                Kapat
                            </button>
                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span class="indicator-label">Kaydet</span>

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
@endsection
@section('scripts')
    <style>
        #kt_docs_quill_basic {
               height: 300px;
           }
    </style>
    <script>
        var editButtons = document.querySelectorAll('.editSSS');

    editButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            /*data-id="{{$question->id}}"
                                                    data-status="{{$question->status}}"
                                                    data-show_menu="{{$question->show_menu}}"
                                                    data-title="{{$question->name}}"
                                                    data-path="{{Storage::url('files/'.$question->path)}}"*/
            var id = this.getAttribute('data-id');
            var status = this.getAttribute('data-status');
            var show_menu = this.getAttribute('data-show_menu');
            var title = this.getAttribute('data-title');
            var path = this.getAttribute('data-path');

            // Modal form alanlarını doldur
            var modal = document.getElementById('add_sss');
            modal.querySelector('[name="id"]').value = id;
            modal.querySelector('[name="title"]').value = title;
            modal.querySelector('[name="status"]').checked = status === '1';
            modal.querySelector('[name="show_menu"]').checked = show_menu === '1';
            //select .uploadedFile, change its href attribute
            var uploadedFile = modal.querySelector('.uploadedFile');
            uploadedFile.href = path;
            //show uploadedFile
            uploadedFile.style.display = 'block';

            var modalElement = new bootstrap.Modal(modal);
            modalElement.show();
        });
    });
    </script>
    @endsection
