$(document).ready(function(){

    $(document).on('click', '.read-orders-button', function(){
        showOrders();
    });
    $(document).on('click', '#orders-btn-group', function(){
        showOrders();
    });
 
});

function showOrders(){
    $.getJSON("http://localhost/prog3/api/orders/read.php", function(data){
        readOrdersTemplate(data, "");
        changePageTitle("Visualizza ordini");
 
    });
}