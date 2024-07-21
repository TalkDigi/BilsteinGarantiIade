if ($('.changeStatusButton').length > 0) {

    $('.changeStatusButton').on('click', function () {

        let status_id = $(this).data('status-id');

        let status = statuses[status_id];

        $('.newStatus').html(status.html);
        $('.newStatus').val(status_id);

        if (status_id == 4) {
            $('.formChangeInputs').show();
        } else {
            $('.formChangeInputs').hide();
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

$('.closure-button').on('click', function () {
    //get all tr data values inside closure-table and store them in an array
    let trs = document.querySelectorAll('.closure-table tbody tr');
    let data = [];
    trs.forEach(function (tr) {
        data.push({
            name: tr.getAttribute('data-name'),
            no: tr.getAttribute('data-no'),
            quantity: tr.getAttribute('data-quantity'),
            price: tr.getAttribute('data-price')
        });
    });

    //send data to the server
    $.ajax({
        type: 'POST',
        url: closure,
        data: {
            data: data,
            _token: document.head.querySelector('meta[name="csrf-token"]').content
        },
        success: function (response) {
            console.log(response);
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
                            //display none
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


    $('.productSearchForm').submit(function (e) {
        e.preventDefault();
        let data = $(this).serialize();

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

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: data,
            success: function (response) {
                $('.productSearchList').html(response.html);
            },
            complete: function () {
                // Hide page loading
                KTApp.hidePageLoading();
                loadingEl.remove();
                $('input[name=productCode]').val('');
                $('input[name=productName]').val('');
            }
        });
    });

    //we have two input productCode and productName. we should reset other input when one of them is filled
    $('input[name=productCode]').on('input', function () {
        $('input[name=productName]').val('');
    });

    $('input[name=productName]').on('input', function () {
        $('input[name=productCode]').val('');
    });

    let products = [];

    $(document).on('click', '.addProduct', function () {

        let desc = $(this).data('desc');
        let code = $(this).data('code');
        let invoice = $(this).data('invoice');
        let price = $(this).data('price');
        let max = $(this).data('max');
        let qty = $(this).closest('.d-flex').find('.quantity').val();


        if (qty == '' || qty == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Hata',
                text: 'Lütfen adet girin.',
            });
            return false;
        }

        if (qty > max) {
            Swal.fire({
                icon: 'error',
                title: 'Hata',
                text: 'Maksimum adet sayısını aştınız.',
            });
            return false;
        }

        let isAdded = false;
        let index = 0;
        for (let i = 0; i < products.length; i++) {
            if (products[i].code == code && products[i].invoice == invoice) {
                isAdded = true;
                index = i;
                break;
            }
        }

        if (isAdded) {

            products[index].qty = parseInt(products[index].qty) + parseInt(qty);

            let newQty = parseInt(qty);

            products[index].qty = newQty;

            let row = $('.selectedProducts').find('tr[data-code="' + code + '"][data-invoice="' + invoice + '"]');

            row.find('.qty').text(newQty);

        } else {

            products.push({
                code: code,
                invoice: invoice,
                qty: qty,
                price: price,
                desc: desc
            });

            let row = '<tr data-code="' + code + '" data-invoice="' + invoice + '">';
            row += '<td>' + desc + '</td>';
            row += '<td>' + code + '</td>';
            row += '<td class="qty">' + qty + '</td>';
            row += '<td>' + price + '</td>';
            row += '<td><button class="btn btn-danger removeProduct">Sil</button></td>';
            row += '</tr>';

            $('.selectedProducts table tbody').find('.emptyRow').remove();

            $('.selectedProducts table tbody').append(row);

        }

        checkApplicationContinueButton(products);
    })

    $(document).on('click', '.removeProduct', function () {
        //get product code and invoice
        let code = $(this).closest('tr').data('code');
        let invoice = $(this).closest('tr').data('invoice');
        //remove product from products array
        for (let i = 0; i < products.length; i++) {
            if (products[i].code == code && products[i].invoice == invoice) {
                products.splice(i, 1);
                break;
            }
        }
        //remove row from table
        $(this).closest('tr').remove();
        checkApplicationContinueButton(products);

    })

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

    $('#bl_new_application_type_modal form').on('submit', function (e) {

        e.preventDefault();

        if (products.length == 0) {
            //show warning
            Swal.fire({
                icon: 'warning',
                title: 'Uyarı',
                text: 'Lütfen en az bir ürün ekleyin.',
            });
            return false;
        }

        //check if any application_type radio is checked

        let application_type = $('input[name=application_type]:checked').val();
        if (!application_type) {
            //show warning
            Swal.fire({
                icon: 'warning',
                title: 'Uyarı',
                text: 'Lütfen bir başvuru türü seçin.',
            });
            return false;
        }

        $('#jsonData').val(JSON.stringify(products));

        //submit form

        this.submit();

    });

});




