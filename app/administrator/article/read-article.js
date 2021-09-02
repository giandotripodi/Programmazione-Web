$(document).ready(function(){
    showProducts();
    $(document).on('click', '.read-products-button', function(){
        showProducts();
    });
    $(document).on('click', '#article-btn-group', function() {
        showProducts();
    });
 
});

function showProducts(){
    // prendo la lista degli articoli dall'API
    $.getJSON("http://localhost/prog3/api/article/read.php", function(data){

        readProductsTemplate(data, "");
        changePageTitle("Visualizza articoli");
 
    });
}