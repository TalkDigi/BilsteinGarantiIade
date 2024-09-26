<div class="content flex-row-fluid" id="kt_content">
    <!--begin::Invoice 2 main-->
    <div class="card">
        <!--begin::Body-->
        <div class="card-body p-lg-20">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-xl-row">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid ">
                    <!--begin::Invoice 2 content-->
                    <div class="mt-n1">
                        <!--begin::Top-->
                        <div class="d-flex flex-stack align-items-center pb-10">
                            <!--begin::Logo-->
                            <a href="javascript:void(0)">
                                <img alt="Logo"
                                     src="https://bilsteingroup.com/typo3conf/templates/main/assets/img/logo.svg"
                                     class="w-100" style="max-height: 50px"/>
                            </a>

                        </div>
                        <!--end::Top-->
                        <!--begin::Wrapper-->
                        <div class="m-0">
                            <!--begin::Label-->
                            <div class="fw-bold fs-3 text-gray-800 mb-8">Örnek Fatura</div>

                            <!--begin::Content-->
                            <div class="flex-grow-1">
                                <!--begin::Table-->
                                <div class="table-responsive border-bottom mb-9">
                                    <table class="table mb-3">
                                        <thead>
                                        <tr class="border-bottom fs-6 fw-bold text-muted">
                                            <th class="pb-2">#</th>
                                            <th class="min-w-70px text-start pb-2">Ürün</th>
                                            <th class="min-w-80px text-end pb-2">Miktar</th>
                                            <th class="min-w-100px text-end pb-2">Birim Fatura Fiyatı</th>
                                            <th class="min-w-100px text-end pb-2">Toplam</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($target != 'cost')
                                            @forelse($lines as $line)
                                                <tr class="fw-bold text-gray-700 fs-5 text-end">
                                                    <td>{{$loop->index +1}}</td>
                                                    <td class="d-flex align-items-start flex-column">
                                                        <p>{{$line['desc']}}</p>
                                                        <span class="text-muted d-block">{{$line['code']}}</span>
                                                    </td>
                                                    <td class="pt-6">{{$line['qty']}} Adet</td>
                                                    <td class="pt-6">
                                                        {{ number_format($line['price'], 2, ',', '.') }}₺

                                                    </td>

                                                    <td class="pt-6">

                                                        {{ number_format($line['price'] * $line['qty'], 2, ',', '.') }}₺


                                                    </td>
                                                </tr>
                                            @empty
                                            @endforelse

                                        @endif

                                        @if($target == 'cost' && isset($Application->application['accepted_cost']))
                                            <tr class="fw-bold text-gray-700 fs-5 text-end">
                                                <td>#</td>
                                                <td class="d-flex align-items-start flex-column">
                                                    <p>İlave Masraf</p>

                                                </td>
                                                <td class="pt-6"></td>
                                                <td class="pt-6">
                                                    {{ number_format($Application->application['accepted_cost'], 2, ',', '.') }}
                                                    ₺
                                                </td>

                                                <td class="pt-6">
                                                    {{ number_format($Application->application['accepted_cost'], 2, ',', '.') }}
                                                    ₺
                                                </td>
                                            </tr>
                                        @endif

                                        </tbody>
                                    </table>
                                </div>
                                <!--end::Table-->
                                <!--begin::Container-->
                                <div class="d-flex justify-content-end">
                                    <!--begin::Section-->
                                    <div class="mw-300px">
                                        <!--begin::Item-->
                                        <div class="d-flex flex-stack mb-3">
                                            <!--begin::Accountname-->
                                            <div class="fw-semibold pe-10 text-gray-600 fs-7">Ara Toplam:</div>
                                            <!--end::Accountname-->
                                            <!--begin::Label-->
                                            <div class="text-end fw-bold fs-6 text-gray-800">
                                                {{ number_format($total, 2, ',', '.') }}₺
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <div class="d-flex flex-stack mb-3">
                                            <!--begin::Accountname-->
                                            <div class="fw-semibold pe-10 text-gray-600 fs-7">KDV 20%</div>
                                            <!--end::Accountname-->
                                            <!--begin::Label-->
                                            <div class="text-end fw-bold fs-6 text-gray-800">
                                                {{ number_format($tax, 2, ',', '.') }}₺
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <div class="d-flex flex-stack mb-3">
                                            <!--begin::Accountnumber-->
                                            <div class="fw-semibold pe-10 text-gray-600 fs-7">Toplam</div>
                                            <!--end::Accountnumber-->
                                            <!--begin::Number-->
                                            <div class="text-end fw-bold fs-6 text-gray-800">
                                                {{ number_format($total_with_tax, 2, ',', '.') }}₺
                                            </div>
                                            <!--end::Number-->
                                        </div>

                                        <a class="btn btn-success w-100"
                                           href="{{route('dashboard.application.export-invoice',['claim' => $Application->claim_number,'type' => $target])}}">Excel
                                            Çıktısı Al</a>

                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Container-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Invoice 2 content-->
                </div>
                <!--end::Content-->
                <!--begin::Sidebar-->
                <!--end::Sidebar-->
            </div>
            <!--end::Layout-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Invoice 2 main-->
</div>
<!--end::Post-->
