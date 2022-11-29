var $ = jQuery;
$('#paypal-activated input[name="paypal-activated"]').on('change', function (event) {
    event.preventDefault();
    var form_data = new FormData();
    var paypal_license = $('#paypal_license input[name="paypal_license"]').val();
    form_data.append('action', 'atbdp_paypal_license_activation');
    form_data.append('paypal_license', paypal_license);
    $.ajax({
        method: 'POST',
        processData: false,
        contentType: false,
        url: atbdp_paypal.ajaxurl,
        data: form_data,
        success: function (response) {
            if (response.status === true) {
                $('#success_msg').remove();
                $('#paypal-activated').after('<p id="success_msg">' + response.msg + '</p>');
                location.reload();
            } else {
                $('#error_msg').remove();
                $('#paypal-activated').after('<p id="error_msg">' + response.msg + '</p>');
            }
        },
        error: function (error) {
            // console.log(error);
        }
    });
});
// deactivate license
$('#paypal-deactivated input[name="paypal-deactivated"]').on('change', function (event) {
    event.preventDefault();
    var form_data = new FormData();
    var paypal_license = $('#paypal_license input[name="paypal_license"]').val();
    form_data.append('action', 'atbdp_paypal_license_deactivation');
    form_data.append('paypal_license', paypal_license);
    $.ajax({
        method: 'POST',
        processData: false,
        contentType: false,
        url: atbdp_paypal.ajaxurl,
        data: form_data,
        success: function (response) {
            if (response.status === true) {
                $('#success_msg').remove();
                $('#paypal-deactivated').after('<p id="success_msg">' + response.msg + '</p>');
                location.reload();
            } else {
                $('#error_msg').remove();
                $('#paypal-deactivated').after('<p id="error_msg">' + response.msg + '</p>');
            }
        },
        error: function (error) {
            // console.log(error);
        }
    });
});
