$(document).ready(function(){
 
    // show html form when 'update product' button was clicked
    $(document).on('click', '.update-store-button', function(){
        // get product id
        var id_negozio = $(this).attr('data-id');
        // read one record based on given product id
        $.getJSON("http://localhost/prog3/api/store/read_one.php?id_negozio=" + id_negozio, function(data){

        var nome = data.nome;
        var via = data.via;
        var cap = data.cap;
        var citta = data.citta;
        // load list of categories
  
        var update_store_html=`
        <div id='read-store' class='btn btn-primary pull-right m-b-15px read-store-button'>
            <span class='glyphicon glyphicon-list'></span> Visualizza neegozi
            </div>
            <!-- build 'update product' html form -->
            <!-- we used the 'required' html5 property to prevent empty fields -->
        <form id='update-store-form' action='#' method='post' border='0'>
        <table class='table table-hover table-responsive table-bordered'>
 
        <!-- name field -->
        <tr>
            <td>Nome</td>
            <td><input value=\"` + nome + `\" type='text' name='nome' class='form-control' required /></td>
        </tr>

        <tr>
            <td>Via</td>
            <td><input value=\"` + via + `\" type='text' name='via' class='form-control' required /></td>
        </tr>

        <!-- price field -->
        <tr>
            <td>Cap</td>
            <td><input value=\"` + cap + `\" type='text' name='cap' class='form-control' required /></td>
        </tr>

        <tr>
        <td>Città</td>
        <td><input value=\"` + citta + `\" type='text' name='citta' class='form-control' required /></td>
        </tr>
        
 
        <tr>
 
            <!-- hidden 'product id' to identify which record to delete -->
            <td><input value=\"` + id_negozio + `\" name='id_negozio' type='hidden' /></td>
 
            <!-- button to submit form -->
            <td>
                <button type='submit' class='btn btn-info'>
                    <span class='glyphicon glyphicon-edit'></span> Aggiorna info
                </button>
            </td>
 
        </tr>
 
    </table>
</form>`;
// inject to 'page-content' of our app
$("#page-content").html(update_store_html);
 
// chage page title
changePageTitle("Aggiorna articolo");
        });
    });
     
    // will run if 'create product' form was submitted
$(document).on('submit', '#update-store-form', function(){
     
    // get form data
var form_data=JSON.stringify($(this).serializeObject());
// submit form data to api
$.ajax({
    url: "http://localhost/prog3/api/store/update.php",
    type : "PUT",
    contentType : 'application/json',
    data : form_data,
    success : function(result) {
        // product was created, go back to products list
        showStores();
    },
    error: function(xhr, resp, text) {
        // show error to console
        console.log(xhr, resp, text);
    }
});
     
    return false;
});
});