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
                        <!--begin::Nav item-->
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="javascript:void(0)">S.S.S</a>
                        </li>

                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" href="{{route('dashboard.setting.file')}}">Dosyalar</a>
                        </li>

                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5 "
                               href="{{route('dashboard.setting.quantities')}}">Adet İçe Aktar</a>
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
                        <h3 class="fw-bold m-0">Sıkça Sorulan Sorular</h3>
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
                                        <th>Sıra</th>
                                        <th>Durum</th>
										<th class="text-center min-w-100px">Başlık</th>
                                        <th class="text-center">Oluşturma Tarihi</th>
                                        <th class="text-center">Güncelleme Tarihi</th>
										<th class="text-center min-w-70px">Eylemler</th>
									</tr>
								</thead>
								<tbody class="fw-semibold text-gray-600">
                                    @forelse($Questions as $question)
                                        <tr>
                                            <td>{{$loop->index + 1}}</td>
                                            <td>{{$question->order}}</td>
                                            <td>
                                                @if($question->status == 1)
                                                    <span class="badge badge-light-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-light-danger">Pasif</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{$question->title}}</td>
                                            <td class="text-center">{{$question->created_at}}</td>
                                            <td class="text-center">{{$question->updated_at}}</td>
                                            <td class="text-center">
                                                <a
                                                    data-id="{{$question->id}}"
                                                    data-status="{{$question->status}}"
                                                    data-order="{{$question->order}}"
                                                    data-title="{{$question->title}}"
                                                    data-text="{{$question->text}}"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 editSSS">
                                                    <span class="svg-icon svg-icon-3">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                </a>
                                                <a href="{{route('dashboard.setting.sssDestroy',['id' => $question->id])}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
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
                    <form id="add_sss_form" class="form" action="{{route('dashboard.setting.sssStore')}}" method="POST">
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
                                        <label class="required fw-semibold fs-6 mb-2">Sıra</label>
                                        <input type="number" name="order" class="form-control form-control-solid mb-3 mb-lg-0"
                                               placeholder="Sıra" value="9999" required/>
                                        <!--end::Input-->
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
                                <label class="required fw-semibold fs-6 mb-2">Metin</label>
                                <div id="kt_docs_quill_basic" name="kt_docs_quill_basic"></div>
                                       <input type="hidden" name="text" id="editorContent" required>

                                <input type="file" id="fileInput" style="display: none;">
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

        var toolbarOptions = [
               [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
               ['bold', 'italic', 'underline', 'strike'],
               [{'list': 'ordered'}, {'list': 'bullet'}],
               [{'indent': '-1'}, {'indent': '+1'}],
               [{'size': ['small', false, 'large', 'huge']}],
               [{'color': []}, {'background': []}],
               [{'font': []}],
               [{'align': []}],
               ['link', 'image', 'video', 'formula'],
               ['clean'],
               ['code-block'],
           ];
       var quill = new Quill('#kt_docs_quill_basic', {
            modules: {
                toolbar: {
                    container: toolbarOptions,
                    handlers: {
                        'image': function() {
                                document.getElementById('fileInput').click();
                        }
                    }
                }
            },
            placeholder: 'Metin Alanı',
            theme: 'snow'
        });

        document.getElementById('fileInput').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                var formData = new FormData();
                formData.append('image', file);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{route('quill.store')}}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.url) {
                        const range = quill.getSelection(true);
                        quill.insertEmbed(range.index, 'image', result.url);
                        quill.setSelection(range.index + 1);
                    }
                })
                .catch(error => {
                    console.error('Dosya yükleme hatası:', error);
                });
            }
        });

        var form = document.querySelector('#add_sss_form');
       form.onsubmit = function() {
           var html = quill.root.innerHTML;
           if(html == '<p><br></p>') {
               return false;
           }
           document.getElementById('editorContent').value = html;
           // Formun gönderilmesine izin ver
           return true;
       };


        var editButtons = document.querySelectorAll('.editSSS');

    editButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var status = this.getAttribute('data-status');
            var order = this.getAttribute('data-order');
            var title = this.getAttribute('data-title');
            var text = this.getAttribute('data-text');

            // Modal form alanlarını doldur
            var modal = document.getElementById('add_sss');
            modal.querySelector('[name="id"]').value = id;
            modal.querySelector('[name="order"]').value = order;
            modal.querySelector('[name="title"]').value = title;
            modal.querySelector('[name="text"]').value = text;
            modal.querySelector('[name="status"]').checked = status === '1';

            // Quill editörüne yeni içeriği yükle
            quill.root.innerHTML = text;

            // Gizli input alanını doldur
            document.getElementById('editorContent').value = text;

            // Modalı göster
            var modalElement = new bootstrap.Modal(modal);
            modalElement.show();
        });
    });
    </script>
    @endsection
