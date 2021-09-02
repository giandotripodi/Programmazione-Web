function readOrdersTemplate(data, keywords){

    var read_orders_html=`
    <div class="btn-group margin-bottom-1em" role="group" aria-label="...">
        <button id="article-btn-group" type="button" class="btn btn-default">Articoli</button>
        <button id="orders-btn-group" type="button" class="btn btn-default">Ordini</button>
        <button id="shifts-btn-group" type="button" class="btn btn-default">Turni lavorativi</button>
        <button id="department-btn-group" type="button" class="btn btn-default">Imposta reparto</button>
        <button id="store-btn-group" type="button" class="btn btn-default">Aggiorna informazioni</button>
    </div>

    <!-- form di ricerca ordine -->
    <form id='search-orders-form' action='#' method='post'>
    <div id='create-order' class='btn btn-primary pull-right m-b-15px create-order-button'>
        <span class='glyphicon glyphicon-plus'></span> Crea ordine
    </div>

    </form>

    <!-- inzio tabella -->
    <table class='table table-bordered table-hover'>

        <!-- creazione dei titoli della tabella -->
        <tr class='background-grey'>
            <th class='w-15-pct'>N.Ordine</th>
            <th class='w-15-pct'>Articolo</th>
            <th class='w-15-pct'>Taglia</th>
            <th class='w-10-pct'>Stato</th>
            <th class='w-10-pct'>Azione</th>
        </tr>
    `;

    $.each(data.records, function(key, val) {
        //aggiunge un riga alla tabella per ogni riga
        read_orders_html += `
            <tr>
                <td>` + val.id_ordine + `</td>
                <td>` + val.articolo + `</td>
                <td>` + val.taglia + `</td>`;

                if(val.stato == '1') {
                    read_orders_html += `<td>Da prendere in carico</td>`;
                } else if(val.stato == '2') {
                    read_orders_html += `<td>Preso in carico</td>`;
                } else if(val.stato == '3'){
                    read_orders_html += `<td>In consegna</td>`
                }
        read_orders_html += `

                <td>
                <button class='btn btn-primary m-r-10px read-one-order-button' data-id='` + val.id_ordine + `'> 
                    <span class='glyphicon glyphicon-eye-open'></span> Dettagli ordine
                </button>
                </td>
        
            </tr>`;
    });

    //fine tabella
    read_orders_html += `</table>`;

    $("#page-content").html(read_orders_html);
}
