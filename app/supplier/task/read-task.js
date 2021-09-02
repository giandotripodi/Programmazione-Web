$(document).ready(function(){

    showOrdersSup();
    $(document).on('click', '#get-task-btn-group', function(){
        showOrdersSup();
    });
 
});

function showOrdersSup(){
    $.getJSON("http://localhost/prog3/api/orders/read_task.php", function(data){
        
        readTaskTemplate(data, "");
        changePageTitle("Ordini da prendere in carico");
 
    });
}