import $ from 'jquery';

$(document).ready(function() {
    let supplyCounter = 0;
    let selectedSupply = null;
    const deviceContainer = $('#device-container');
    const deviceId = deviceContainer.data('device-id');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    window.toggleMobileMenu = function() {
        const mobileMenu = $('#mobile-menu');
        const menuOpenIcon = $('#menu-open-icon');
        const menuCloseIcon = $('#menu-close-icon');
        mobileMenu.toggleClass('hidden');

        menuOpenIcon.toggleClass('hidden');
        menuCloseIcon.toggleClass('hidden');
    };

    $('#supply-search').on('input', function() {
        const query = $.trim($(this).val());
        if (query.length >= 2) {
            $.getJSON(`/supplies/search?q=${query}`, function(data) {
                const suppliesList = $('#supplies-list');
                suppliesList.empty();
                $.each(data, function(index, supply) {
                    const li = $('<li>')
                        .text(`${supply.name} (Available: ${supply.quantity})`)
                        .addClass('cursor-pointer p-2 hover:bg-gray-200 dark:hover:bg-gray-600')
                        .on('click', function() {
                            $('#supply-search').val(supply.name);
                            selectedSupply = supply;
                            suppliesList.empty();
                        });
                    suppliesList.append(li);
                });
            }).fail(function() {
                console.error('Error fetching supplies');
            });
        } else {
            $('#supplies-list').empty();
        }
    });

    // Handle adding supplies
    $('#supply-quantity').on('input', function() {
        if (selectedSupply && $(this).val() > selectedSupply.quantity) {
            $(this).val(selectedSupply.quantity);
            alert(`The quantity exceeds the available supply. Maximum available: ${selectedSupply.quantity}`);
        }
    });

    $('#add-supply').on('click', function() {
        let supplyQuantity = parseInt($('#supply-quantity').val(), 10);
        supplyCounter++;
        if (selectedSupply && supplyQuantity) {
            const listItem = $(`
                <li>
                    ${selectedSupply.name} - Cantidad: ${supplyQuantity}
                    <input type="hidden" name="supplies[${supplyCounter}][id]" value="${selectedSupply.id}">
                    <input type="hidden" name="supplies[${supplyCounter}][quantity]" value="${supplyQuantity}">
                </li>
            `);

            $('#supplies-selected-list').append(listItem);
            $('#supply-search').val('');
            $('#supply-quantity').val('');
            selectedSupply = null;
        } else {
            alert('Please select a supply and enter a quantity.');
        }
    });

    $('#save-device').on('click', function() {
        let formData = new FormData();

        formData.append('device_id', deviceId);
        $('#supplies-selected-list input').each(function() {
            formData.append($(this).attr('name'), $(this).val());
        });

        $.ajax({
            url: '/devices/store-supplies',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            success: function(data) {
                if (data.success) {
                    alert('Dispositivo guardado exitosamente.');
                    window.location.reload();
                } else {
                    alert('Error al guardar el dispositivo.');
                }
            },
            error: function() {
                alert('An error occurred while processing the request.');
            }
        });
    });

    $('.remove-supply').on('click', function() {
        const deviceId = $(this).data('device-id');
        const supplyId = $(this).data('supply-id');

        $.ajax({
            url: `/devices/${deviceId}/supplies/${supplyId}`,
            method: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                if (response.success) {
                    alert('Insumo eliminado con éxito');
                    window.location.reload();
                } else {
                    alert('Error al eliminar el insumo.');
                }
            },
            error: function() {
                alert('Error al procesar la solicitud.');
            }
        });
    });

    $('.update-supply').on('click', async function() {
        const deviceId = $(this).data('device-id');
        const supplyId = $(this).data('supply-id');
        const quantityInput = $(`#quantity-${supplyId}`);
        let currentQuantity = parseInt(quantityInput.val(), 10);

        try {
            const currentSupplyResponse = await $.ajax({
                url: `/devices/${deviceId}/supplies/${supplyId}`,
                method: 'GET',
            });

            let currentSupplyQuantity = currentSupplyResponse.quantity;

            const availableSupplyResponse = await $.ajax({
                url: `/supplies/supply/${supplyId}`,
                method: 'GET',
            });

            let availableQuantity = availableSupplyResponse.quantity;
            let totalQuantityToAdd = currentQuantity - currentSupplyQuantity;

            if (availableQuantity - totalQuantityToAdd < 0) {
                alert(`La cantidad excede el insumo disponible. Máximo disponible: ${availableQuantity}`);
                return;
            }

            const updateResponse = await $.ajax({
                url: `/devices/${deviceId}/supplies/${supplyId}`,
                method: 'PUT',
                data: {
                    quantity: currentQuantity,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
            });

            if (updateResponse.success) {
                quantityInput.val(currentQuantity);
                window.location.reload();
            } else {
                alert('Error al actualizar la cantidad.');
            }
        } catch (error) {
            alert('Error al procesar la solicitud.');
            console.error(error);
        }
    });
});
