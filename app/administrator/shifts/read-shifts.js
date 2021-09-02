$(document).ready(function(){
    $(document).on('click', '.read-shifts-button', function(){
        showShifts();
    });

    $(document).on('click', '#shifts-btn-group', function(){
        showShifts();
    });
 
});

function showShifts(){
    $.getJSON("http://localhost/prog3/api/shifts/read.php", function(data){
        
        readShiftsTemplate(data, "");
        changePageTitle("Visualizza turni lavorativi");
 
    });
}