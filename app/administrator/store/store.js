function readStoreTeemplate(data, keywords){

    var read_store_html=`
    <div class="btn-group margin-bottom-1em" role="group" aria-label="...">
        <button id="article-btn-group" type="button" class="btn btn-default">Articoli</button>
        <button id="orders-btn-group" type="button" class="btn btn-default">Ordini</button>
        <button id="shifts-btn-group" type="button" class="btn btn-default">Turni lavorativi</button>
        <button id="department-btn-group" type="button" class="btn btn-default">Imposta reparto</button>
        <button id="store-btn-group" type="button" class="btn btn-default">Aggiorna informazioni</button>
    </div>

    <!-- inzio tabella -->
    <table class='table table-bordered table-hover'>

        <!-- creazione dei titoli della tabella -->
        <tr class='background-grey'>
            <th class='w-10-pct'>Nome</th>
            <th class='w-10-pct'>Via</th>
            <th class='w-10-pct'>Cap</th>
            <th class='w-10-pct'>Citta</th>
            <th class='w-10-pct text-align-center'>Azione</th>
        </tr>`;

    $.each(data.records, function(key, val) {
        //aggiunge un riga alla tabella per ogni riga
        read_store_html += `
            <tr>
                <td>` + val.nome + `</td>
                <td>` + val.via + `</td>
                <td>` + val.cap + `</td>
                <td>` + val.citta + `</td>
                <td>
                <button class='btn btn-info m-r-10px update-store-button' data-id='` + val.id_negozio + `'>
                    <span class='glyphicon glyphicon-edit'></span> Aggiorna info
                </button>
                </td>
            </tr>`;
    });

    //fine tabella
    read_store_html += `</table>`;

    $("#page-content").html(read_store_html);
}
