function readDepartmentTemplate(data, keywords){

    var read_department_html=`
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
            <th class='w-15-pct'>Nome</th>
            <th class='w-15-pct'>Cognome</th>
            <th class='w-10-pct'>Email</th>
            <th class='w-10-pct'>Reparto</th>
            <th class='w-10-pct'>Azione</th>
        </tr>
    `;

    $.each(data.records, function(key, val) {
        //aggiunge un riga alla tabella per ogni riga
        read_department_html += `
            <tr>
                <td>` + val.nome + `</td>
                <td>` + val.cognome + `</td>
                <td>` + val.email + `</td>
                <td>` + val.reparto + `</td>
                <td>
                <button class='btn btn-primary m-r-10px update-department-button' data-id='` + val.id_addetto + `'> 
                    <span class='glyphicon glyphicon-eye-open'></span> Imposta reparto
                </button>
                </td>
        
            </tr>`;
    });

    //fine tabella
    read_department_html += `</table>`;

    $("#page-content").html(read_department_html);
}
