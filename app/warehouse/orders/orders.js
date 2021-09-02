function readCheckOrdersTemplate(data, keywords){

    var check_orders_html=`
    <div class="btn-group margin-bottom-1em" role="group" aria-label="...">
        <button id="check-orders-btn-group" type="button" class="btn btn-default">Ricezione ordini</button>
        <button id="wshifts-btn-group" type="button" class="btn btn-default">Turni lavorativi</button>
    </div>


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
        check_orders_html += `
            <tr>
                <td>` + val.id_ordine + `</td>
                <td>` + val.articolo + `</td>
                <td>` + val.taglia + `</td>`;

                if(val.stato == '3') {
                    check_orders_html += `<td>In consegna</td>`;
                }
        check_orders_html += `

                <td>
                <button class='btn btn-primary m-r-10px check-order-button' data-id='` + val.id_ordine + `'> 
                    <span class='glyphicon glyphicon-eye-open'></span> Conferma ricezione
                </button>
                </td>
        
            </tr>`;
    });

    //fine tabella
    check_orders_html += `</table>`;

    $("#page-content").html(check_orders_html);
}
