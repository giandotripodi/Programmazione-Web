function readProductsTemplate(data, keywords){
 
    var read_article_html=`
        <div class="btn-group margin-bottom-1em" role="group" aria-label="...">
            <button id="article-btn-group" type="button" class="btn btn-default">Articoli</button>
            <button id="orders-btn-group" type="button" class="btn btn-default">Ordini</button>
            <button id="shifts-btn-group" type="button" class="btn btn-default">Turni lavorativi</button>
            <button id="department-btn-group" type="button" class="btn btn-default">Imposta reparto</button>
            <button id="store-btn-group" type="button" class="btn btn-default">Aggiorna informazioni</button>
        </div>
        <!-- search products form -->
        <form id='search-product-form' action='#' method='post'>
        <div class='input-group pull-left w-30-pct'>
 
            <input type='text' value='` + keywords + `' name='keywords' class='form-control product-search-keywords' placeholder='Cerca articoli...' />
 
            <span class='input-group-btn'>
                <button type='submit' class='btn btn-default' type='button'>
                    <span class='glyphicon glyphicon-search'></span>
                </button>
            </span>
 
        </div>
        </form>
 
        <!-- when clicked, it will load the create product form -->
        <div id='create-article' class='btn btn-primary pull-right m-b-15px create-article-button'>
            <span class='glyphicon glyphicon-plus'></span> Inserisci articolo
        </div>
 
        <!-- start table -->
        <table class='table table-bordered table-hover'>
 
            <!-- creating our table heading -->
            <tr>
                <th class='w-25-pct'>Nome</th>
                <th class='w-10-pct'>Prezzo</th>
                <th class='w-15-pct'>Taglia</th>
                <th class='w-20-pct'>Reparto</th>
                <th class='w-30-pct text-align-center'>Azione</th>
            </tr>`;
 
    $.each(data.records, function(key, val) {

        read_article_html+=`<tr>
 
            <td>` + val.nome_articolo + `</td>
            <td>€` + val.prezzo + `</td>
            <td>` + val.taglia + `</td>
            <td>` + val.reparto + `</td>
 
            <!-- 'action' buttons -->
            <td>
                <!-- read product button -->
                <button class='btn btn-primary m-r-10px read-one-product-button' data-id='` + val.id_articolo + `'>
                    <span class='glyphicon glyphicon-eye-open'></span> Visualizza
                </button>
 
                <!-- edit button -->
                <button class='btn btn-info m-r-10px update-product-button' data-id='` + val.id_articolo + `'>
                    <span class='glyphicon glyphicon-edit'></span> Modifica
                </button>
 
                <!-- delete button -->
                <button class='btn btn-danger delete-product-button' data-id='` + val.id_articolo + `'>
                    <span class='glyphicon glyphicon-remove'></span> Elimina
                </button>
            </td>
        </tr>`;
    });

    read_article_html+=`</table>`;
    
    $("#page-content").html(read_article_html);
}