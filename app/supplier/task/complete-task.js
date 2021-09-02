$(document).on('click', '.complete-task-button', function() {

    var value = {
        id_ordine : $(this).attr('data-id')};

    var data = JSON.stringify(value);

    $.ajax({
    url: "http://localhost/prog3/api/orders/complete_task.php",
    type: "PUT",
    contentType: "application/json",
    data: data,
    success: function(result) {
        showOrdersToComp();
    },
    error: function(xhr, resp, text) {
            console.log(xhr, resp, text);
           }
    });
    
});