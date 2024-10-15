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
                                            Ürün Miktarları</h3>
                                        <p class="text-muted">Ürünler için seçilebilir miktarları bu sayfadan içe
                                            aktarabilirsiniz.</p>
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
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" href="{{route('dashboard.setting.file')}}">Dosyalar</a>
                        </li>

                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5 active"
                               href="javascript:void(0);">Adet İçe Aktar</a>
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
                </div>
                <!--begin::Card header-->
                <!--begin::Content-->
                <div id="kt_account_settings_profile_details" class="collapse show">
                    <div class="card-body">
                        <form action="{{route('dashboard.setting.quantities.upload')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    {{--file input--}}
                                    <div class="form-group">
                                        <label for="kt_modal_upload_file" class="form-label">Dosya Seç</label>
                                        {{--file input, only accept csv and xlsx etc.--}}
                                        <input type="file" id="kt_modal_upload_file" name="file"
                                               accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                               class="form-control"/>
                                    </div>

                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group mt-2">
                                        <button type="submit" class="btn btn-primary">Yükle</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <table class="table align-middle table-row-bordered fs-6 gy-5 mt-5" id="kt_ecommerce_products_table">
                            <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">

                                <th>#</th>
                                <th class="text-center min-w-100px">Başlık</th>
                                <th class="text-center">Durum</th>
                                <th class="text-center">Oluşturma Tarihi</th>

                                <th class="text-center min-w-70px">Eylemler</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">

                            @forelse($files as $key => $file)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td class="text-center">{{$key}}</td>
                                    <td class="text-center">{{$file['status']}}</td>
                                    <td class="text-center">{{$file['created_at']}}</td>

                                    <td class="text-center">
                                        <a class="btn btn-danger importDelete" data-uuid="{{$file['uuid']}}" data-route="{{route('dashboard.setting.quantities.delete',['uuid' => $file['uuid']])}}"> Sil</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Henüz dosya yüklenmemiş.</td>
                                </tr>

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

@endsection
@section('scripts')
    <script>

        $("#kt_datatable_zero_configuration").DataTable({
	"language": {
		"lengthMenu": "Show _MENU_",
	},
            "dom":
                "<'row mb-2'" +
                "<'col-sm-6 d-flex align-items-center justify-conten-start dt-toolbar'l>" +
                "<'col-sm-6 d-flex align-items-center justify-content-end dt-toolbar'f>" +
                ">" +

                "<'table-responsive'tr>" +

                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">"
});

          document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.importDelete').forEach(function (button) {
            button.addEventListener('click', function () {
                const uuid = this.getAttribute('data-uuid');
                Swal.fire({
                    title: 'Emin misiniz?',
                    text: 'Bu dosyayı silmeniz durumunda, bu dosya ile birlikte içeri aktardığınız ürün adetleri de silinecektir. Silmek istediğinize emin misiniz?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Evet',
                    cancelButtonText: 'Hayır'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const route = this.getAttribute('data-route');

                        window.location.href = route;

                    }
                });
            });
        });
    });

    </script>
    @endsection
