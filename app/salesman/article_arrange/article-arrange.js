function readArtArrangeTemplate(data, keywords){
 
    var read_article_arrange_html=`
        <div class="btn-group margin-bottom-1em" role="group" aria-label="...">
            <button id="article-btn-group" type="button" class="btn btn-default">Articoli</button>
            <button id="shifts-btn-group" type="button" class="btn btn-default">Orario lavorativo</button>
            <button id="orders-btn-group" type="button" class="btn btn-default">Ordini</button>
            <button id="arrange-btn-group" type="button" class="btn btn-default">Sistema articolo</button>
        </div>
 
        <!-- start table -->
        <table class='table table-bordered table-hover'>
 
            <!-- creating our table heading -->
            <tr>
                <th class='w-25-pct'>Nome</th>
                <th class='w-15-pct'>Taglia</th>
                <th class='w-30-pct text-align-center'>Azione</th>
            </tr>`;
 
    $.each(data.records, function(key, val) {

        read_article_arrange_html+=`<tr>
 
            <td>` + val.nome_articolo + `</td>
            <td>` + val.taglia + `</td>
 
            <!-- 'action' buttons -->
            <td>
                <!-- edit button -->
                <button class='btn btn-info m-r-10px arrange-product-button' data-id='` + val.id_articolo + `'>
                    <span class='glyphicon glyphicon-edit'></span> Sistema articolo
                </button>
            </td>
        </tr>`;
    });

    read_article_arrange_html+=`</table>`;
    $("#page-content").html(read_article_arrange_html);

}