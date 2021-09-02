$(document).ready(function(){
    
    $(document).on('click', '#complete-task-btn-group', function(){
        showOrdersToComp();
    });
 
});

function showOrdersToComp(){

    $.getJSON("http://localhost/prog3/api/orders/read_taskc.php", function(data){
        readTaskToCompleteTemplate(data, "");
        changePageTitle("Ordini presi in carico");
 
    });
}