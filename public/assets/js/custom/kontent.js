

if ($('.changeStatusButton').length > 0) {

    $('.changeStatusButton').on('click', function () {

        let status_id = $(this).data('status-id');

        let status = statuses[status_id];

        $('.newStatus').html(status.html);
        $('.newStatus').val(status_id);

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

        if (Object.keys(quantities).length === 0) {

            alert("İleri gitmek için en az bir miktar girmeniz gerekmektedir.");

            stepper.stop();

        } else {

            stepper.goNext();

        }

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

    if(document.getElementById(inputId + 'AdditionalFiles')){
        let additionalFiles = document.getElementById(inputId + 'AdditionalFiles').querySelectorAll('a');
        additionalFiles.forEach(function (file) {
            console.log('Yeni dosyalar '+file.getAttribute('data-file'));
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
            console.log('Status burada'+response.success);

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


/*closure-table
<tr data-name = "{{$item->Name}}" data-no = "{{$item->No}}" data-quantity = "{{$product['quantities'][$item->No]}}" data-price="{{ number_format($prices[$item->No], 2, '.', '')}}">
closure-button*/

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
