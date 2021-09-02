$(document).ready(function(){
    
    showCheckOrders();
    $(document).on('click', '#check-orders-btn-group', function(){
        showCheckOrders();
    });
 
});

function showCheckOrders(){
    $.getJSON("http://localhost/prog3/api/orders/check.php", function(data){
        
        readCheckOrdersTemplate(data, "");
        changePageTitle("Ricezione ordini");
 
    });
}