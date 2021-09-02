function readShiftsTemplate(data){

    var read_shifts_html=`
    <div class="btn-group margin-bottom-1em" role="group" aria-label="...">
    <button id="article-btn-group" type="button" class="btn btn-default">Articoli</button>
    <button id="shifts-btn-group" type="button" class="btn btn-default">Orario lavorativo</button>
    <button id="orders-btn-group" type="button" class="btn btn-default">Ordini</button>
    <button id="arrange-btn-group" type="button" class="btn btn-default">Sistema articolo</button>
    </div>

    </form>

    <!-- inzio tabella -->
    <table class='table table-bordered table-hover'>

        <!-- creazione dei titoli della tabella -->
        <tr class='background-grey'>
            <th class='w-10-pct'>Giorno</th>
            <th class='w-10-pct'>Orario</th>
        </tr>`;

    $.each(data.records, function(key, val) {
        //aggiunge un riga alla tabella per ogni riga
        read_shifts_html += `
            <tr>
                <td>` + val.giorno + `</td>
                <td>` + val.orario + `</td>
            </tr>`;
    });

    //fine tabella
    read_shifts_html += `</table>`;

    $("#page-content").html(read_shifts_html);
}
