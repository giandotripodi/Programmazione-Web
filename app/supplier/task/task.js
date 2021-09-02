function readTaskTemplate(data){

    var task_html=`
    <div class="btn-group margin-bottom-1em" role="group" aria-label="...">
    <button id="get-task-btn-group" type="button" class="btn btn-default">Prendi incarichi</button>
    <button id="complete-task-btn-group" type="button" class="btn btn-default">Completa incarichi</button>
    </div>

    <!-- inzio tabella -->
    <table class='table table-bordered table-hover'>

        <!-- creazione dei titoli della tabella -->
        <tr class='bkground-grey'>
            <th class='w-15-pct'>N.Ordine</th>
            <th class='w-15-pct'>Articolo</th>
            <th class='w-15-pct'>Taglia</th>
            <th class='w-10-pct'>Stato</th>
            <th class='w-10-pct'>Azione</th>
        </tr>
    `;

    $.each(data.records, function(key, val) {
        //aggiunge un riga alla tabella per ogni riga
        task_html += `
            <tr>
                <td>` + val.id_ordine + `</td>
                <td>` + val.articolo + `</td>
                <td>` + val.taglia + `</td>`;
                if(val.stato == '1') {
                    task_html += `<td>Da prendere in carico</td>`;
                }
                task_html += `
                <td>
                <button class='btn btn-primary m-r-10px get-task-button' data-id='` + val.id_ordine + `'> 
                    <span class='glyphicon glyphicon-eye-open'></span> Prendi incarico
                </button>
                </td>
            </tr>`;
    });

    //fine tabella
    task_html += `</table>`;

    $("#page-content").html(task_html);
}
