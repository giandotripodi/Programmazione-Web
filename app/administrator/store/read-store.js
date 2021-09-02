$(document).ready(function(){
    $(document).on('click', '.read-store-button', function(){
        showStores();
    });

    $(document).on('click', '#store-btn-group', function(){
        showStores();
    });
 
});

function showStores(){
    $.getJSON("http://localhost/prog3/api/store/read.php", function(data){
        
        readStoreTeemplate(data, "");
        changePageTitle("Visualizza negozi");
 
    });
}