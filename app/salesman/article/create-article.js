$(document).ready(function() {
    $(document).on('click', '.create-article-button', function() {
        $.getJSON("http://localhost/prog3/api/tipology/read.php", function(data) {
            var create_article_html = `
            <div id='read-products' class='btn btn-primary pull-right m-b-15px read-products-button'>
                <span class='glyphicon glyphicon-list'></span> Visualizza Articoli
            </div>
            
            <!-- Inserisci articolo form html -->
            <form id='create-article-form' action='#' method='post' border='0'>
                <table class='table table-hover table-responsive table-bordered'>
                

                <!-- campo nome -->
                <tr>
                    <td>Nome articolo</td>
                    <td><input type='text' name='nome_articolo' class='form-control' required /</td>
                </tr>
            
                <!-- campo prezzo -->
                <tr>
                    <td>Prezzo</td>
                    <td><input type='number' min='1' name='prezzo' class='form-control' required /</td>
                </tr>
            
            
                <!-- campo taglia -->
                <tr>
                    <td>Taglia</td>
                    <td><input type='text' name='taglia' class='form-control' required /</td>
                </tr>
                

                <!-- menu quantita -->
                <tr>
                    <td>Quantità</td>
                    <td><input type ='number' min='1' name='quantita' class='form-control' required /</td>
                </tr>
                
                <!-- campo categoria -->
                <tr>
                    <td>Categoria</td>
                    <td><select id='id_categoria' name='id_categoria' class='form-control'>
                        <option value='1'>Maglia</option>
                        <option value='2'>Pantalone</option>`;

            $.each(data.records, function(key, val) {
                create_article_html += `<option value='` + val.id_categoria + `'>` + val.categoria + `</option>`;
            });
            
            create_article_html += `</select></td></tr>

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


            
            <!-- button di invio del form -->
            <tr>
                <td></td>
                <td>
                    <button type='submit' class='btn btn-primary'>
                        <span class='glyphicon glyphicon-plus'></span> Inserisci articolo
                    </button>
                </td>
            </tr>
            
            </table>
            </form>`;

            $('#page-content').html(create_article_html);
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

    $(document).on('submit', '#create-article-form', function(e) {
        var form_data = JSON.stringify($(this).serializeObject());

        $.ajax({
            url: "http://localhost/prog3/api/article/create.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function(result) {
                showProducts();
                
            },
            error: function(xhr, resp, text) {
                console.log(xhr, resp, text);
            }
        });
        e.preventDefault();
    });
});