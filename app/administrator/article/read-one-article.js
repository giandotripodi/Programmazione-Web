$(document).ready(function(){
    $(document).on('click', '.read-one-product-button', function(){

        var id = $(this).attr('data-id');
        $.getJSON("http://localhost/prog3/api/article/read_one.php?id_articolo=" + id, function(data){
            var read_one_product_html=`
 
            <!-- when clicked, it will show the product's list -->
            <div id='read-products' class='btn btn-primary pull-right m-b-15px read-products-button'>
                <span class='glyphicon glyphicon-list'></span> Visualizza articoli
            </div>
            <!-- product data will be shown in this table -->
            <table class='table table-bordered table-hover'>
    
            <!-- product name -->
            <tr>
                <td>ID articolo</td>
                <td>` + data.id_articolo + `</td>
            </tr>
            <tr>
                <td class='w-30-pct'>Nome</td>
                <td class='w-70-pct'>` + data.nome_articolo + `</td>
            </tr>
            <tr>
                <td>Taglia</td>
                <td>` + data.taglia + `</td>
            </tr>
            <!-- product price -->
            <tr>
                <td>Prezzo</td>
                <td>€` + data.prezzo + `</td>
            </tr>
        
            <!-- product category name -->
            <tr>
                <td>Categoria</td>
                <td>` + data.categoria + `</td>
            </tr>
            <tr>
                <td>Sottocategoria</td>
                <td>` + data.sottocategoria + `</td>
            </tr>
            <tr>
                <td>Reparto</td>
                <td>` + data.reparto + `</td>
            </tr>
        
        </table>`;
        $("#page-content").html(read_one_product_html);
        changePageTitle("Dettagli articolo");
        });
    });
 
});