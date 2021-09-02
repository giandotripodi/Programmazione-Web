$(document).ready(function(){
 
    $(document).on('submit', '#search-product-form', function(){
 
        var keywords = $(this).find(":input[name='keywords']").val();
 
        $.getJSON("http://localhost/prog3/api/article/search.php?s=" + keywords, function(data){
 
            readProductsTemplate(data, keywords);
 
            changePageTitle("Cerca articoli: " + keywords);
 
        });

        return false;
    });
 
});