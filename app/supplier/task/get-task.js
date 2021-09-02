$(document).on('click', '.get-task-button', function() {

    var value = {
        id_ordine : $(this).attr('data-id'),
        "id_fornitore": localStorage.getItem("id_fornitore")};

    var data = JSON.stringify(value);

    $.ajax({
    url: "http://localhost/prog3/api/orders/getask.php",
    type: "PUT",
    contentType: "application/json",
    data: data,
    success: function(result) {
        showOrdersSup();
    },
    error: function(xhr, resp, text) {
            console.log(xhr, resp, text);
           }
    });
    
});