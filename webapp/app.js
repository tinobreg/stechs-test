// Returns a function, that, as long as it continues to be invoked, will not
// be triggered. The function will be called after it stops being called for
// N milliseconds. If `immediate` is passed, trigger the function on the
// leading edge, instead of the trailing.
function debounce(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this, args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};

//Adding alert message to webpage
function addAlert(type, message) {
    $('<div class="alert alert-' + type + '" role="alert">' + message + '</alert>')
        .prependTo('.alert-container')
        .delay(4000)
        .queue(function () {
            $(this).remove();
        });
};

// Receives a string and returns the same string replacing the dots with dashes
function formatForCssClass(value) {
    return value.replace(/\./g, '-');
}

// Load table from api
var loadTable = debounce(function(vendor) {
    var vendorValue = (vendor.length > 0 ? vendor : 0);
    $.ajax({
        method: "GET",
        url: encodeURI("http://api.stechs.local/modem/list/vendor/"+vendorValue+"/empty"),
        dataType: 'json',
        beforeSend: function() {
            $('#result-container').html('<h2 class="text-center">Buscando...</h2>');
        },
        success: function (data) {
            if(data.success) {
                var tableHtml = $('#table-container').html();
                $('#result-container').html(tableHtml);

                var rows = '';
                $.each(data.modems, function (i, v) {
                    var row = '<tr class="'+formatForCssClass(v.vsi_model)+' '+formatForCssClass(v.vsi_swver)+'">';
                    row    += '<td>'+v.modem_macaddr+'</td>';
                    row    += '<td>'+v.ipaddr+'</td>';
                    row    += '<td>'+v.vsi_model+'</td>';
                    row    += '<td>'+v.vsi_swver+'</td>';
                    row    += '<td class="button-container">';
                        row    += '<a class="add-modem btn btn-secondary btn-sm" href="javascript:;" data-macaddress="'+v.modem_macaddr+'" data-parent=".'+formatForCssClass(v.vsi_model)+'.'+formatForCssClass(v.vsi_swver)+'">Agregar</a>';
                    row    += '</td>';
                    row    += '</tr>';

                    rows += row;
                });

                $('#result-container #vendor-names').html('Fabricante/s: '+data.vendors);
                $('#result-container #thead').html(rows);
            } else {
                $('#result-container').html('<h2 class="text-center">'+data.error+'</h2>');
            }
        }
    });
}, 350);

// Add modem into api
var addModem = debounce(function(button) {
    $.ajax({
        method: "POST",
        url: encodeURI("http://api.stechs.local/modem/add"),
        data: {'macaddress':button.data('macaddress')},
        dataType: 'json',
        beforeSend: function() {
            button.html('Cargando...');
        },
        success: function (data) {
            if(data.success) {
                addAlert('success', data.message);

                $.each($(button.data('parent')), function (i, v) {
                    $(v).addClass('bg-success');
                    $(v).addClass('text-white');
                    $(v).find('.button-container').html('Agregado')
                });
            } else {
                button.html('Agregar');
                addAlert('danger', data.error);
            }
        }
    })
}, 200);

$('body').on('click', '.add-modem', function( event ) {
    event.preventDefault();
    var button = $(this);
    addModem(button);
});

$("#search-form").submit(function( event ) {
    event.preventDefault();
    loadTable($('#vendor').val());
});