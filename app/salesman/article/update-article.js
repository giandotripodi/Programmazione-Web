$(document).ready(function(){
 
    $(document).on('click', '.update-product-button', function(){
        var id = $(this).attr('data-id');
        $.getJSON("http://localhost/prog3/api/article/read_one.php?id_articolo=" + id, function(data){

        var nome_articolo = data.nome_articolo;
        var taglia = data.taglia;
        var prezzo = data.prezzo;
  
        var update_product_html=`
        <div id='read-products' class='btn btn-primary pull-right m-b-15px read-products-button'>
            <span class='glyphicon glyphicon-list'></span> Visualizza articoli
            </div>
            <!-- build 'update product' html form -->
            <!-- we used the 'required' html5 property to prevent empty fields -->
        <form id='update-product-form' action='#' method='post' border='0'>
        <table class='table table-hover table-responsive table-bordered'>
 
        <!-- name field -->
        <tr>
            <td>Nome</td>
            <td><input value=\"` + nome_articolo + `\" type='text' name='nome_articolo' class='form-control' required /></td>
        </tr>

        <tr>
            <td>Taglia</td>
            <td><input value=\"` + taglia + `\" type='text' name='taglia' class='form-control' required /></td>
        </tr>

        <!-- price field -->
        <tr>
            <td>Prezzo</td>
            <td><input value=\"` + prezzo + `\" type='number' min='1' name='prezzo' class='form-control' required /></td>
        </tr>
        
 
        <tr>
 
            <!-- hidden 'product id' to identify which record to delete -->
            <td><input value=\"` + id + `\" name='id_articolo' type='hidden' /></td>
 
            <!-- button to submit form -->
            <td>
                <button type='submit' class='btn btn-info'>
                    <span class='glyphicon glyphicon-edit'></span> Aggiorna articolo
                </button>
            </td>
 
        </tr>
 
    </table>
</form>`;

$("#page-content").html(update_product_html);

changePageTitle("Aggiorna articolo");
        });
    });

$(document).on('submit', '#update-product-form', function(){
     
var form_data=JSON.stringify($(this).serializeObject());

$.ajax({
    url: "http://localhost/prog3/api/article/update.php",
    type : "PUT",
    contentType : 'application/json',
    data : form_data,
    success : function(result) {
        showProducts();
    },
    error: function(xhr, resp, text) {
        console.log(xhr, resp, text);
    }
});
     
    return false;
});
});