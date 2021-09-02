$(document).ready(function(){

    $(document).on('click', '.read-shifts-button', function(){
        showShifts();
    });

    $(document).on('click', '#shifts-btn-group', function(){
        showShifts();
    });
 
});

function showShifts(){
    var id_addetto = localStorage.getItem("id_addetto");
    $.getJSON("http://localhost/prog3/api/shifts/reads.php?id_addetto=" + id_addetto, function(data){
        
        readShiftsTemplate(data, "");
        changePageTitle("Visualizza turni lavorativi");
 
    });
}