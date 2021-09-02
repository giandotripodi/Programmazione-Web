$(document).ready(function(){
    $(document).on('click', '.read-one-order-button', function(){
        var id = $(this).attr('data-id');
        $.getJSON("http://localhost/prog3/api/orders/read_one.php?id_ordine=" + id, function(data){

            var read_one_order_html=`
 
            <!-- when clicked, it will show the product's list -->
            <div id='read-orders' class='btn btn-primary pull-right m-b-15px read-orders-button'>
                <span class='glyphicon glyphicon-list'></span> Visualizza ordini
            </div>
            <!-- product data will be shown in this table -->
            <table class='table table-bordered table-hover'>
    
            <!-- numero ordine -->
            <tr>
                <td>N.Ordine</td>
                <td>` + data.id_ordine + `</td>
            </tr>
            <!-- nome articolo -->
            <tr>
                <td class='w-30-pct'>Articolo</td>
                <td class='w-70-pct'>` + data.articolo + `</td>
            </tr>
            <!-- nome fornitore -->
            <tr>
                <td>Fornitore</td>
                <td>` + data.fornitore + `</td>
            </tr>
            <!-- stato ordine -->
            <tr>
                <td>Stato</td>`;
                if(data.stato == '1'){
                    read_one_order_html += `<td>Da prendere in carico</td>`;
                } else{
                    read_one_order_html += `<td>Preso in carico</td>`;
                }

        read_one_order_html +=`
            </tr>
        </table>`;
        $("#page-content").html(read_one_order_html);
        changePageTitle("Dettagli ordine");
        });
    });
 
});