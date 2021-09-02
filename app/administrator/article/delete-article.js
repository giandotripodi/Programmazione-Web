$(document).ready(function() {
    //sarà eseguito se viene cliccato il tasto "elimina"
    $(document).on('click', '.delete-product-button', function() {
        //prende l'id del dipartimento
        var articolo_id = $(this).attr('data-id');

        //bootbox pop-up di conferma
        bootbox.confirm({
            message: "<h4>Sei sicuro di voler eliminare questo articolo?</h4>",
            buttons: {
                confirm: {
                    label: '<span class="glyphicon glyphicon-ok"></span> Si',
                    className: 'btn-danger'
                },
                cancel: {
                    label: '<span class="glyphicon glyphion-remove"></span> No',
                    className: 'btn-primary'
                }
            },
            callback: function(result) {
                if(result == true) {
                    //invia la richiesta delete al server/api
                    $.ajax({
                        url: "http://localhost/prog3/api/article/delete.php",
                        type: "DELETE",
                        contentType: 'json',
                        data: JSON.stringify({ id_articolo: articolo_id}),
                        success: function(result) {
                            showProducts();
                        },
                        error: function(xhr, resp, text) {
                            console.log(xhr, resp, text);
                        }
                    });
                }
            }
        });
    });
});