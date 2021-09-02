$(document).on('click', '.check-order-button', function() {

    var value = {
        
        id_ordine : $(this).attr('data-id')};

    var data = JSON.stringify(value);

    $.ajax({
    url: "http://localhost/prog3/api/orders/complete.php",
    type: "PUT",
    contentType: "application/json",
    data: data,
    success: function(result) {
        showCheckOrders();
    },
    error: function(xhr, resp, text) {
            console.log(xhr, resp, text);
           }
    });
    
});