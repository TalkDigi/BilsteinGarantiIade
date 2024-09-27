if ($('.changeStatusButton').length > 0) {

    $('.changeStatusButton').on('click', function (e) {
        let status_id = $(this).data('status-id');

        let status = statuses[status_id];

        let buttonText = $(this).text().trim();

        let cargoHistory = $(this).data('cargo-history');

         // Eğer status_id 5 veya 6 ise ve cargo_history false ise
         if ((status_id == 5 || status_id == 6) && !cargoHistory) {

            let modalTarget = $(this).data('bs-target');
            e.preventDefault(); // Varsayılan tıklama davranışını engelle

            Swal.fire({
                title: 'Dikkat!',
                text: `Bu başvuru henüz "Kargo Bekleniyor" durumuna alınmadı. Durumu "${buttonText}" olarak güncellemek istediğinize emin misiniz?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, eminim',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var modal = new bootstrap.Modal(document.querySelector(modalTarget));
                    modal.show();
                }
            });
        }

        if ((status_id == 5 || status_id == 6) && cargoHistory) {
            let modalTarget = $(this).data('bs-target');
            var modal = new bootstrap.Modal(document.querySelector(modalTarget));
                    modal.show();
        }

        $('.newStatus').html(status.html);
        $('.newStatus').val(status_id);

        if (status_id == 4) {
            $('.formChangeInputs').show();
        } else {
            $('.formChangeInputs').hide();
        }

        if (status_id == 5) {
            $('.accepted_cost').show();
        } else {
            $('.accepted_cost').hide();
        }

    });

}

if (document.getElementById("datePicker1")) {
    new tempusDominus.TempusDominus(document.getElementById("datePicker1"), {
        display: {
            viewMode: "calendar",
            components: {
                decades: true,
                year: true,
                month: true,
                date: true,
                hours: false,
                minutes: false,
                seconds: false
            }
        },
        localization: {
            locale: "tr",
            format: "dd/MM/yyyy"
        }
    });
}

if (document.getElementById("datePicker2")) {
    new tempusDominus.TempusDominus(document.getElementById("datePicker2"), {
        display: {
            viewMode: "calendar",
            components: {
                decades: true,
                year: true,
                month: true,
                date: true,
                hours: false,
                minutes: false,
                seconds: false
            }
        },
        localization: {
            locale: "tr",
            format: "dd/MM/yyyy"
        }
    });
}

if (document.getElementById("application_stepper")) {
    var element = document.querySelector("#application_stepper");

    var stepper = new KTStepper(element);
    stepper.on("kt.stepper.next", function (stepper) {
        stepper.goNext();

        /* if (Object.keys(quantities).length === 0) {

             alert("İleri gitmek için en az bir miktar girmeniz gerekmektedir.");

             stepper.stop();

         } else {

             stepper.goNext();

         }*/

    });

    stepper.on("kt.stepper.previous", function (stepper) {
        stepper.goPrevious(); // go previous step
    });
}

function initializeDropzone(dropzoneId, updatedFileNamesMap) {
    var myDropzone = new Dropzone(dropzoneId, {
        headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
        },
        url: fileStore,
        paramName: "file",
        renameFile: function (file) {
            return file.name;
        },
        maxFiles: maxFilesAllowed,
        maxFilesize: 10, // MB
        addRemoveLinks: true,
        accept: function (file, done) {
            done();
        },
        success: function (file, response) {
            console.log('success');
            if (response.path) {
                var newName = response.path;
                updatedFileNamesMap[file.upload.uuid] = newName;

                var fileNode = file.previewElement.querySelector("[data-dz-name]");
                if (fileNode) {
                    fileNode.innerHTML = newName;
                }
            }
            getAllFileNames(myDropzone, dropzoneId.replace('#', '') + 'Input', updatedFileNamesMap);
        },
        error: function (file, response) {
            var responseText = JSON.stringify(response);
            this.removeFile(file);
            if (responseText.includes("You can not upload any more files.")) {
                toastr.warning("Dosya yükleme limitini aştınız. Lütfen yalnızca " + maxFilesAllowed + " dosya yükleyin.", "Hata");
            } else {
                toastr.warning("Yükleme sırasında bir hata oluştu. Lütfen sistem yöneticinizle iletişime geçin.", "Hata");
            }
        }
    });

    myDropzone.on("removedfile", function (file) {
        var fileName = updatedFileNamesMap[file.upload.uuid] || file.name;
        getAllFileNames(myDropzone, dropzoneId.replace('#', '') + 'Input', updatedFileNamesMap);
    });
}

const maxFilesAllowed = 5;
var updatedFileNames = {};
var updatedFileNamesSecond = {};
var updatedFileNamesThird = {};
var updatedFileNamesFour = {};
var updatedFileNamesFive = {};
var updatedFileNamesSix = {};
var updatedFileNamesSeven = {};
var updatedFileNamesEight = {};
var updatedFileNamesNine = {};
var updatedFileNamesTen = {};
var updatedFileNamesEleven = {};

// Dropzone rneklerini başlat
if (document.getElementById("dropZone1")) {
    initializeDropzone("#dropZone1", updatedFileNames);
}

if (document.getElementById("dropZone2")) {
    initializeDropzone("#dropZone2", updatedFileNamesSecond);
}

if (document.getElementById("dropZone3")) {
    initializeDropzone("#dropZone3", updatedFileNamesThird);
}

if (document.getElementById("dropZone4")) {
    initializeDropzone("#dropZone4", updatedFileNamesFour);
}

if (document.getElementById("dropZone5")) {
    initializeDropzone("#dropZone5", updatedFileNamesFive);
}

if (document.getElementById("dropZone6")) {
    initializeDropzone("#dropZone6", updatedFileNamesSix);
}

if (document.getElementById("dropZone7")) {
    initializeDropzone("#dropZone7", updatedFileNamesSeven);
}

if (document.getElementById("dropZone8")) {
    initializeDropzone("#dropZone8", updatedFileNamesEight);
}

if (document.getElementById("dropZone9")) {
    initializeDropzone("#dropZone9", updatedFileNamesNine);
}

$('#change_status').on('shown.bs.modal', function () {
    initializeDropzone("#dropZone10", updatedFileNames);
});

if (document.getElementById("dropZone11")) {
    initializeDropzone("#dropZone11", updatedFileNamesEleven);
}


function getAllFileNames(dropzoneInstance, inputId, updatedNamesObj) {


    let names = [];

    dropzoneInstance.files.forEach(function (file) {
        console.log('filename ' + file.name);
        console.log(updatedNamesObj)
        // Güncellenmiş isimleri kontrol et ve kullan
        var updatedName = updatedNamesObj[file.upload.uuid] || file.name;

        names.push(updatedName);
    });

    if (document.getElementById(inputId + 'AdditionalFiles')) {
        let additionalFiles = document.getElementById(inputId + 'AdditionalFiles').querySelectorAll('a');
        additionalFiles.forEach(function (file) {
            console.log('Yeni dosyalar ' + file.getAttribute('data-file'));
            names.push(file.getAttribute('data-file'));
        });
    }

    let namesString = names.join(',');
    document.getElementById(inputId).value = namesString;
}

$(document).on('click', '.delete-file', function () {
    let parent = $(this).closest('.inner-file');
    let anchor = $(this).prev('a');
    let file = anchor.data('file');
    let targetInput = anchor.data('bind');
    let inputId = anchor.data('bind')
    let data = {
        file: file,
        _token: document.head.querySelector('meta[name="csrf-token"]').content
    };

    $.ajax({
        type: 'POST',
        url: fileDelete,
        data: data,
        success: function (response) {
            console.log('Status burada' + response.success);

            if (response.success) {
                parent.remove();
                let targetInputValue = document.getElementById(targetInput).value;
                let targetInputValueArray = targetInputValue.split(',');
                let index = targetInputValueArray.indexOf(file);
                if (index > -1) {
                    targetInputValueArray.splice(index, 1);
                }
                let newTargetInputValue = targetInputValueArray.join(',');
                document.getElementById(targetInput).value = newTargetInputValue;
                toastr.success('Dosya başarıyla silindi.');
            } else {
                toastr.error('Dosya silinirken bir hata oluştu.');
            }
        },
        error: function (error) {
            toastr.error('Dosya silinirken bir hata oluştu.');
        }
    });
});

$('.applicationCreateInvoice').on('click', function () {

    let claimNumber = $(this).data('claim-number');
    let target = $(this).data('target');

    $.ajax({
        type: 'POST',
        url: create_invoice,
        data: {
            claim_number: claimNumber,
            target: target,
            _token: document.head.querySelector('meta[name="csrf-token"]').content
        },
        success: function (response) {
            if (response.success) {
                //put response.html niside .invoiceBody
                $('.invoiceBody').html(response.html);
                //show invoiceModal
                $('#invoiceModal').modal('show');

            } else {
                toastr.error('Oluşturulurken bir hata oluştu.');
            }
        },
        error: function (error) {
            toastr.error('Oluşturulurken bir hata oluştu.');
        }
    });

});

function checkApplicationContinueButton(products) {

    //console log products count
    console.log(products.length);
    //check if products array is empty
    if (products.length == 0) {
        //disable continue button
        $('.applicationStatus button').attr('disabled', 'disabled');
    } else {
        //enable continue button
        $('.applicationStatus button').removeAttr('disabled');
    }
}

$(document).ready(function () {

    // Eğer inputs array'i null değilse
    if (typeof inputs !== 'undefined') {
        console.log(inputs);

        if (inputs !== null) {
            // Eğer inputs array'i null değilse ve bir array ise
            if (Array.isArray(inputs) && inputs.length) {
                // allInputs nesnesindeki her bir öğeyi kontrol ediyoruz
                for (var key in allInputs) {
                    if (allInputs.hasOwnProperty(key)) {
                        // Eğer inputs array'inde yoksa
                        if (!inputs.includes(key)) {
                            // Bu stringi class olarak al ve class > input veya class > textarea readonly yap ve arka plan rengini değiştir

                            var elements = $('.' + key);

                            elements.hide();
                            var elementsInputs = $('.' + key + ' > input, .' + key + ' > textarea');
                            elementsInputs.attr('readonly', true);

                        }
                    }
                }
            } else {
                console.error("inputs array değil veya boş.");
            }
        }
    }

    let isHide = false;

    $('.productSearchForm').submit(function (e) {
        e.preventDefault();


        const loadingEl = document.createElement("div");
        document.body.prepend(loadingEl);
        loadingEl.classList.add("page-loader");
        loadingEl.classList.add("flex-column");
        loadingEl.innerHTML = `
                <span class="spinner-border text-primary" role="status"></span>
                <span class="text-muted fs-6 fw-semibold mt-5">Sonuçlar aranıyor...</span>
            `;

        // Show page loading
        KTApp.showPageLoading();

        //first check if is there any input with productCount name
        let productCount = $('input[name=productCount]');
        let productCountVal = productCount.val();


        if (productCount.length > 0 && productCountVal === '') {


            let csrf = $('meta[name="csrf-token"]').attr('content');
            let productCode = $('input[name=productCode]').val();

            $.ajax({
                url: check_quantity,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                data: {
                    productCode: productCode
                },
                success: function (data) {

                    console.log('Response' + JSON.stringify(data));

                    let qty = 1;

                    if (data.success) {
                        qty = data.quantity;

                    }

                    // Hide page loading
                    KTApp.hidePageLoading();
                    loadingEl.remove();

                    Swal.fire({
                        title: 'Ürün Adedi',
                        input: 'number',
                        inputValue: qty,
                        inputAttributes: {},
                        showCancelButton: true,
                        confirmButtonText: 'Tamam',
                        cancelButtonText: 'İptal',
                        showLoaderOnConfirm: true,
                        preConfirm: (value) => {
                            //check if value is step by qty
                            if (value % qty !== 0) {
                                Swal.showValidationMessage(
                                    `Adet sayısı, kutu içeriği olan ${qty} ve katları olmalıdır.`
                                );
                            }

                            //value should be minimun value
                            if (value < qty) {
                                Swal.showValidationMessage(
                                    `Adet sayısı ${qty} den küçük olamaz.`
                                );
                            }

                            return value;
                        }

                    }).then((result) => {
                        const loadingEl = document.createElement("div");
                        document.body.prepend(loadingEl);
                        loadingEl.classList.add("page-loader");
                        loadingEl.classList.add("flex-column");
                        loadingEl.innerHTML = `
                <span class="spinner-border text-primary" role="status"></span>
                <span class="text-muted fs-6 fw-semibold mt-5">Sonuçlar aranıyor...</span>
            `;
                        KTApp.showPageLoading();

                        if (result.isConfirmed) {


                            productCount.val(result.value);

                            let url = $('.productSearchForm').attr('action');

                            let data = $('.productSearchForm').serialize();

                            KTApp.showPageLoading();

                            $.ajax({
                                url: url,
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: data,
                                success: function (response) {
                                    if (response.success) {
                                        console.log(response);
                                        $('.filteredProductsTableBody').html(response.html);

                                        if (response.hide_search) {
                                            isHide = true;
                                            $('.productSearchForm').hide();
                                        }
                                    } else {
                                        isHide = false;
                                        toastr.error(response.message);
                                    }
                                },
                                complete: function () {
                                    // Hide page loading
                                    KTApp.hidePageLoading();
                                    loadingEl.remove();
                                    $('input[name=productCode]').val('');
                                    $('input[name=productName]').val('');
                                    $('input[name=productCount]').val('');

                                }
                            });
                        }


                    });
                }
            });

        } else {

                   const loadingEl = document.createElement("div");
                        document.body.prepend(loadingEl);
                        loadingEl.classList.add("page-loader");
                        loadingEl.classList.add("flex-column");
                        loadingEl.innerHTML = `
                <span class="spinner-border text-primary" role="status"></span>
                <span class="text-muted fs-6 fw-semibold mt-5">Sonuçlar aranıyor...</span>
            `;
                        KTApp.showPageLoading();

            let url = $('.productSearchForm').attr('action');

            let data = $('.productSearchForm').serialize();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: data,
                success: function (response) {
                    if (response.success) {
                        console.log(response);
                        $('.filteredProductsTableBody').html(response.html);

                        if (response.hide_search) {
                            isHide = true;
                            $('.productSearchForm').hide();
                        }
                    } else {
                        isHide = false;
                        toastr.error(response.message);
                    }
                },
                complete: function () {
                    // Hide page loading
                    KTApp.hidePageLoading();
                    loadingEl.remove();
                    $('input[name=productCode]').val('');
                    $('input[name=productName]').val('');
                }
            });
        }


    });

    //on click btnRemove
    $(document).on('click', '.btnRemove', function () {
        //get data-id
        let id = $(this).data('id');
        //remove alltr's with data-product = id
        $('tr[data-code=' + id + ']').remove();

        $(this).closest('tr').remove();

        if (isHide) {
            $('.productSearchForm').show();
        }
    });


    $('.application_form').submit(function (e) {
        e.preventDefault();

        if ($('input[name="application[complain][]"]').length > 0) {
            if ($('input[name="application[complain][]"]:checked').length === 0) {
                e.preventDefault();
                alert('Lütfen en az bir müşteri şikayeti seçin.');
                return;
            }
        }

        if (document.getElementById('dropZone11Input')) {
            if (!$('#dropZone11Input').val()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Uyarı',
                    text: 'Parçaya / Kutuya Dair Hata Görseli alanına en az bir dosya ekleyin.',
                });
                return false;
            }
        }

        //if form has update class, just post it
        if ($(this).hasClass('update')) {
            $(this).off('submit').submit();
            return true;
        }
        let trs = document.querySelectorAll('.filteredProductsTableBody tr');
        console.log(trs);
        products = [];
        document.querySelectorAll('tr.calculate').forEach(function (tr) {
    products.push({
        code: tr.getAttribute('data-code'),
        desc: tr.getAttribute('data-desc'),
        qty: tr.getAttribute('data-qty'),
        invoice: tr.getAttribute('data-invoice'),
        price: tr.getAttribute('data-price')
    });
});

//if productCount is empty, show warning
if (products.length === 0) {
    Swal.fire({
        icon: 'warning',
        title: 'Uyarı',
        text: 'Lütfen en az bir ürün ekleyin.',
    });
    return false;
}

        let data = $(this).serialize();
        data += '&products=' + JSON.stringify(products);
        //post application form
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: data,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    //redirect to applications page
                    window.location.href = response.redirect;
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (error) {
                toastr.error('Başvuru oluşturulurken bir hata oluştu.');
            }
        });


    })

    //we have two input productCode and productName. we should reset other input when one of them is filled
    $('input[name=productCode]').on('input', function () {
        $('input[name=productName]').val('');
    });

    $('input[name=productName]').on('input', function () {
        $('input[name=productCode]').val('');
    });

    $('.applicationStatus button').on('click', function () {
        //check if products array is empty
        if (products.length == 0) {
            //show warning
            Swal.fire({
                icon: 'warning',
                title: 'Uyarı',
                text: 'Lütfen en az bir ürün ekleyin.',
            });
            return false;
        }

        //how #bl_new_application_type_modal modal

        $('#bl_new_application_type_modal').modal('show');

        $('.applicationSummary').text('Toplam ' + products.length + ' ürün eklendi.');

    });

    const checkboxes = $('input[name="application[complain][]"]');
    const requiredInputs = [
        'textarea[name="application[fault]"]',
        'input[name="application[engine_power]"]',
        'input[name="application[engine_code]"]'
    ];

    checkboxes.on('change', function() {
        const selectedValues = checkboxes.filter(':checked').map(function() {
            return parseInt(this.value);
        }).get();

        const isRequired = selectedValues.includes(9) || selectedValues.includes(10);

        requiredInputs.forEach(function(selector) {
            const input = $(selector);
            if (isRequired) {
                input.attr('required', 'required');
            } else {
                input.removeAttr('required');
            }
        });
    });

});




