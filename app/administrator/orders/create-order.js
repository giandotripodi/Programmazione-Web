$(document).ready(function() {
    $(document).on('click', '.create-order-button', function() {

        var create_order_html = `
            <div id='read-orders' class='btn btn-primary pull-right m-b-15px read-orders-button'>
                <span class='glyphicon glyphicon-list'></span> Elenco ordini
            </div>

            <!-- 'Crea ordine' form html -->
            <form id='create-order-form' action='#' method='post' border='0'>
                <table class='table table-hover table-responsive table-bordered'>
                <!-- Campo del oggetto -->
                <tr>
                    <td>Nome articolo</td>
                    <td><input type='text' name='articolo' class='form-control' required /</td>
                </tr>
                <tr>
                    <td>Taglia</td>
                    <td><input type='text' name='taglia' class='form-control' required /</td>
                </tr>
                <!-- Quantità -->
                <tr>
                    <td>Quantità</td>
                    <td><input type ='number' min='1' name='quantita' class='form-control' required /</td>
                <!-- bottone di invio form -->
                <tr>
                    <td></td>
                    <td>
                        <button type='submit' class='btn btn-primary'>
                            <span class='glyphicon glyphicon-plus'></span> Crea ordine
                        </button>
                    </td>
                </tr>
                </table>
            </form>`;

        //inserisce l'html nella "page-content"
        $("#page-content").html(create_order_html);

        changePageTitle("Nuovo ordine");
    });

    

    //se il form viene inviato verrà eseguita questa parte di codice
    $(document).on('submit', '#create-order-form', function(e) {
        //get form data
        var form_data = JSON.stringify($(this).serializeObject());

        console.log(form_data);

        $.ajax({
            url: "http://localhost/prog3/api/orders/create.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function(result) {
                showOrders();
            },
            error: function(xhr, resp, text) {
                console.log(xhr, resp, text);
            }
        });

        e.preventDefault();

    });

    return false;
});