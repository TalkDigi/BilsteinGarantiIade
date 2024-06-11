"use strict";
let quantities = {};
// Class definition

document.addEventListener('DOMContentLoaded', function () {
    const keys = Object.keys(preselectedQuantities);
    console.log('Keys are'+keys)
    const formCheckInputs = document.querySelectorAll('#kt_ecommerce_edit_order_product_table .form-check-input');

    formCheckInputs.forEach((input) => {
        if (keys.includes(input.getAttribute('data-item-no'))) {
            input.checked = true;

            quantities[input.value] = {
                quantity: preselectedQuantities[input.getAttribute('data-item-no')],
                uom: "Adet",
                id: input.getAttribute('data-item-no')
            }


        const parent = input.closest('tr');

        const product = parent.querySelector('[data-kt-ecommerce-edit-order-filter="product"]').cloneNode(true);

        const productId = product.getAttribute('data-kt-ecommerce-edit-order-id');

        let productIdNumber = productId.split('_')[1];

        let qty;

        let uom;

        let id;

        let selectedQty = [];

        qty = document.getElementById('qty_' + productIdNumber).getAttribute('data-qty');
        uom = document.getElementById('qty_' + productIdNumber).getAttribute('data-uom');
        id = document.getElementById('qty_' + productIdNumber).getAttribute('data-id');

        qty = document.getElementById('qty_' + productIdNumber).getAttribute('data-qty');
        uom = document.getElementById('qty_' + productIdNumber).getAttribute('data-uom');
        id = document.getElementById('qty_' + productIdNumber).getAttribute('data-id');
        let target = document.getElementById('kt_ecommerce_edit_order_selected_products');

        const innerWrapper = document.createElement('div');

        const innerContent = product.innerHTML;

        const wrapperClassesAdd = ['col', 'my-2'];
        const wrapperClassesRemove = ['d-flex', 'align-items-center'];

        const additionalClasses = ['border', 'border-dashed', 'rounded', 'p-3', 'bg-body'];

        product.classList.remove(...wrapperClassesRemove);
        product.classList.add(...wrapperClassesAdd);

        product.innerHTML = '';

        innerWrapper.classList.add(...wrapperClassesRemove);
        innerWrapper.classList.add(...additionalClasses);

        innerWrapper.innerHTML = innerContent;

        product.appendChild(innerWrapper);

        target.appendChild(product);


        }


    });

    addQtySpan();
    addQuantityInputs();

});

var KTAppEcommerceSalesSaveOrder = function () {
    // Shared variables
    var table;
    var datatable;

    // Private functions
    const initSaveOrder = () => {
        // Init flatpickr
        $('#kt_ecommerce_edit_order_date').flatpickr({
            altInput: true,
            altFormat: "d F, Y",
            dateFormat: "Y-m-d",
        });

        // Init select2 country options
        // Format options
        const optionFormat = (item) => {
            if (!item.id) {
                return item.text;
            }

            var span = document.createElement('span');
            var template = '';

            template += '<img src="' + item.element.getAttribute('data-kt-select2-country') + '" class="rounded-circle h-20px me-2" alt="image"/>';
            template += item.text;

            span.innerHTML = template;

            return $(span);
        }

        // Init Select2 --- more info: https://select2.org/
        $('#kt_ecommerce_edit_order_billing_country').select2({
            placeholder: "Select a country",
            minimumResultsForSearch: Infinity,
            templateSelection: optionFormat,
            templateResult: optionFormat
        });

        $('#kt_ecommerce_edit_order_shipping_country').select2({
            placeholder: "Select a country",
            minimumResultsForSearch: Infinity,
            templateSelection: optionFormat,
            templateResult: optionFormat
        });

        // Init datatable --- more info on datatables: https://datatables.net/manual/
        table = document.querySelector('#kt_ecommerce_edit_order_product_table');
        datatable = $(table).DataTable({
            'order': [],
            "scrollY": "400px",
            "scrollCollapse": true,
            "paging": false,
            "info": false,
            'columnDefs': [
                {orderable: false, targets: 0}, // Disable ordering on column 0 (checkbox)
            ]
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-ecommerce-edit-order-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    const handleProductSelect = () => {
        // Define variables
        const checkboxes = table.querySelectorAll('[type="checkbox"]');
        const target = document.getElementById('kt_ecommerce_edit_order_selected_products');
        const totalPrice = document.getElementById('kt_ecommerce_edit_order_total_price');

        // Loop through all checked products
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', e => {

                const parent = checkbox.closest('tr');

                const product = parent.querySelector('[data-kt-ecommerce-edit-order-filter="product"]').cloneNode(true);

                const productId = product.getAttribute('data-kt-ecommerce-edit-order-id');

                let productIdNumber = productId.split('_')[1];

                let qty;

                let uom;

                let id;

                let selectedQty = [];

                qty = document.getElementById('qty_' + productIdNumber).getAttribute('data-qty');
                uom = document.getElementById('qty_' + productIdNumber).getAttribute('data-uom');
                id = document.getElementById('qty_' + productIdNumber).getAttribute('data-id');

                if (e.target.checked) {
                    Swal.fire({
                        title: 'Miktar girin.',
                        input: 'number',
                        inputAttributes: {
                            autocapitalize: 'off',
                            min: 1,
                            max: qty
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Onayla',
                        cancelButtonText: 'İptal',
                        backdrop: true,
                        showLoaderOnConfirm: true,
                        preConfirm: (quantity) => {

                            if (parseInt(quantity) > parseInt(qty)) {
                                Swal.showValidationMessage(
                                    "Faturadaki ürün adedinden yüksek bir sayı girdiniz. Lütfen tekrar deneyin."
                                )
                            }

                            quantities[productIdNumber] = {quantity: quantity, uom: uom, id: id};


                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {

                            const innerWrapper = document.createElement('div');

                            const innerContent = product.innerHTML;

                            const wrapperClassesAdd = ['col', 'my-2'];
                            const wrapperClassesRemove = ['d-flex', 'align-items-center'];

                            const additionalClasses = ['border', 'border-dashed', 'rounded', 'p-3', 'bg-body'];

                            product.classList.remove(...wrapperClassesRemove);
                            product.classList.add(...wrapperClassesAdd);

                            product.innerHTML = '';

                            innerWrapper.classList.add(...wrapperClassesRemove);
                            innerWrapper.classList.add(...additionalClasses);

                            innerWrapper.innerHTML = innerContent;

                            product.appendChild(innerWrapper);

                            if (e.target.checked) {
                                target.appendChild(product);
                            } else {
                                const selectedProduct = target.querySelector('[data-kt-ecommerce-edit-order-id="' + productId + '"]');
                                if (selectedProduct) {
                                    target.removeChild(selectedProduct);
                                }
                            }

                            addQtySpan();

                            detectEmpty();

                            addQuantityInputs();

                        } else {

                            checkbox.checked = false;

                        }
                    })
                } else {
                    const selectedProduct = target.querySelector('[data-kt-ecommerce-edit-order-id="' + productId + '"]');
                    if (selectedProduct) {
                        delete quantities[productIdNumber];
                        target.removeChild(selectedProduct);
                        addQuantityInputs();
                    }
                }


            });
        });

        // Handle empty list message
        const detectEmpty = () => {
            // Select elements
            const message = target.querySelector('span');
            const products = target.querySelectorAll('[data-kt-ecommerce-edit-order-filter="product"]');

            // Detect if element is empty
            if (products.length < 1) {
                // Show message
                message.classList.remove('d-none');

                // Reset price
                totalPrice.innerText = '0.00';
            } else {
                // Hide message
                message.classList.add('d-none');

                // Calculate price
                calculateTotal(products);
            }
        }

        // Calculate total cost
        const calculateTotal = (products) => {
            /*let countPrice = 0;

            products.forEach(product => {
                const price = parseFloat(product.querySelector('[data-kt-ecommerce-edit-order-filter="price"]').innerText);

                countPrice = parseFloat(countPrice + price);
            });

            totalPrice.innerText = countPrice.toFixed(2);*/
        }
    }

    // Submit form handler


    // Public methods
    return {
        init: function () {

            initSaveOrder();

            // handleShippingForm();
            handleProductSelect();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAppEcommerceSalesSaveOrder.init();
});

function addQtySpan() {

    const container = document.querySelector('#kt_ecommerce_edit_order_selected_products');

    const elements = container.querySelectorAll('.ms-5');

    elements.forEach(element => {

        const qtySpan = element.querySelector('span');
        const id = qtySpan.id;
        const productIdNumber = id.split('_')[1];

        // quantities nesnesinden ilgili ürünün miktarını ve birimini al
        if (quantities[productIdNumber]) {
            const quantityInfo = quantities[productIdNumber];
            const quantityText = `${quantityInfo.quantity} ${quantityInfo.uom}`;

            // Kontrol et, eğer miktar span'i zaten varsa yeni bir tane ekleme
            const existingQtySpan = element.querySelector('.added-qty-span');
            if (!existingQtySpan) {
                // Yeni span elementi oluştur
                const newSpan = document.createElement('span');
                newSpan.textContent = quantityText; // "2 ADET"
                newSpan.className = 'added-qty-span'; // Bu span'a bir sınıf adı ekleyerek tekrar eklenmesini önle
                newSpan.classList.add('badge', 'badge-light-warning', 'd-block');

                // Yeni span'i qtySpan elementinin bulunduğu div'in sonuna ekle
                qtySpan.parentNode.appendChild(newSpan);
            }
        }
    });

}

function addQuantityInputs() {
    const quantitiesContainer = document.querySelector('#quantitiesInputs');

    //empty the quantitiesContainer
    quantitiesContainer.innerHTML = '';

    //for every quantity in quantities, create an input
    for (let quantity in quantities) {
        console.log(quantities[quantity].quantity);
        const quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = 'quantities[' + quantities[quantity].id + ']';
        quantityInput.value = quantities[quantity].quantity;
        quantitiesContainer.appendChild(quantityInput);
    }
}

