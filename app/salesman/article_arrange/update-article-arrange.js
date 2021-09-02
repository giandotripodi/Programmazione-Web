$(document).ready(function(){
 
    $(document).on('click', '.arrange-product-button', function(){
        var id_articolo = $(this).attr('data-id');
        $.getJSON("http://localhost/prog3/api/tipology/read.php", function(data){
  
        var update_article_arrange=`
        <div id='read-products' class='btn btn-primary pull-right m-b-15px read-arrange-button'>
            <span class='glyphicon glyphicon-list'></span> Visualizza articoli da sistemare
        </div>
            <!-- build 'update product' html form -->
            <!-- we used the 'required' html5 property to prevent empty fields -->
        <form id='update-arrange-form' action='#' method='post' border='0'>
        <table class='table table-hover table-responsive table-bordered'>
 
        <!-- campo categoria -->
        <tr>
            <td>Categoria</td>
            <td><select id='id_categoria' name='id_categoria' class='form-control'>
                <option value='1'>Maglia</option>
                <option value='2'>Pantalone</option>`;
        $.each(data.records, function(key, val) {
            update_article_arrange += `<option value='` + val.id_categoria + `'>` + val.categoria + `</option>`;
        });
    
        update_article_arrange += `</select></td></tr>

        <!-- menu sottocategoria -->
        <tr>
            <td>Sottocategoria</td>
            <td><select id="select-id" name='id_sottocategoria' class='form-control' />
            </select></td>
        </tr>

        <!-- menu reparto -->
        <tr>
            <td>Reparto</td>
            <td><select id="id_reparto" name='id_reparto' class='form-control' />
            </select></td>
        </tr>

        <!-- campo prezzo -->
        <tr>
            <td>Prezzo</td>
            <td><input type='number' min='1' name='prezzo' class='form-control' required /</td>
        </tr>
 
        <tr>
 
            <!-- hidden 'product id' to identify which record to delete -->
            <td><input value=\"` + id_articolo + `\" name='id_articolo' type='hidden' /></td>
 
            <!-- button to submit form -->
            <td>
                <button type='submit' class='btn btn-info'>
                    <span class='glyphicon glyphicon-edit'></span> Sistema articolo
                </button>
            </td>
 
        </tr>
 
    </table>
</form>`;
        $("#page-content").html(update_article_arrange);
    });
});

$(document).on('click', '#id_categoria', function() {
    var success = false;
    
    $.getJSON("http://localhost/prog3/api/category/search.php?s=" + this.value, function(data) {
        $('#select-id').empty();
        success = true;

        $.each(data.records, function(key, val) {
            $('#select-id').append(`<option value='` + val.id_sottocategoria + `'>` + val.sottocategoria + `</option>`);
        });
    });


    if(success == false) {
        $('#select-id').empty();
    }
});

$(document ).on('click', '#select-id', function() {
    var success = false;

    $.getJSON("http://localhost/prog3/api/department/read.php", function(data){
        $('#id_reparto').empty();
        success = true;
        $.each(data.records, function(key,val) {
            $('#id_reparto').append(`<option value='` + val.id_reparto + `'> `+ val.nome + `</option>`);
        });
    });

    if(success == false){
        $('#id_reparto').empty();
    }
});


$(document).on('submit', '#update-arrange-form', function(){
     
var form_data=JSON.stringify($(this).serializeObject());

$.ajax({
    url: "http://localhost/prog3/api/article/update_arrange.php",
    type : "PUT",
    contentType : 'application/json',
    data : form_data,
    success : function(result) {
        showArtArrange();
    },
    error: function(xhr, resp, text) {
        console.log(xhr, resp, text);
    }
});
     
    return false;
});
});