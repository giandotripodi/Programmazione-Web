function readShiftsTemplate(data, keywords){

    var read_shifts_html=`
    <div class="btn-group margin-bottom-1em" role="group" aria-label="...">
        <button id="article-btn-group" type="button" class="btn btn-default">Articoli</button>
        <button id="orders-btn-group" type="button" class="btn btn-default">Ordini</button>
        <button id="shifts-btn-group" type="button" class="btn btn-default">Turni lavorativi</button>
        <button id="department-btn-group" type="button" class="btn btn-default">Imposta reparto</button>
        <button id="store-btn-group" type="button" class="btn btn-default">Aggiorna informazioni</button>
    </div>

    <div id='create-shift-ware' class='btn btn-primary pull-right m-b-15px create-shift-ware-button'>
    <span class='glyphicon glyphicon-plus'></span> Nuovo turno (MAG)
    </div>
    
    <div id='create-shift-sal' class='btn btn-primary pull-right m-b-15px create-shift-sal-button'>
        <span class='glyphicon glyphicon-plus'></span> Nuovo turno (AV)
    </div>

    </form>

    <!-- inzio tabella -->
    <table class='table table-bordered table-hover'>

        <!-- creazione dei titoli della tabella -->
        <tr class='background-grey'>
            <th class='w-10-pct'>Ruolo</th>
            <th class='w-10-pct'>Nome</th>
            <th class='w-10-pct'>Giorno</th>
            <th class='w-10-pct'>Orario</th>
            <th class='w-10-pct text-align-center'>Azione</th>
        </tr>`;

    $.each(data.records, function(key, val) {
        //aggiunge un riga alla tabella per ogni riga
        read_shifts_html += `
            <tr>
                <td>` + val.ruolo + `</td>
                <td>` + val.nome + `</td>
                <td>` + val.giorno + `</td>
                <td>` + val.orario + `</td>
                <td>
                <button class='btn btn-info m-r-10px update-shift-button' data-id='` + val.id_orario_lav + `'>
                    <span class='glyphicon glyphicon-edit'></span> Modifica orario
                </button>
                </td>
            </tr>`;
    });

    //fine tabella
    read_shifts_html += `</table>`;

    $("#page-content").html(read_shifts_html);
}
