$(document).ready(function(){

    $(document).on('click', '#wshifts-btn-group', function(){
        showShifts();
    });
 
});

function showShifts(){
    var id_magazziniere = localStorage.getItem("id_magazziniere");
    $.getJSON("http://localhost/prog3/api/shifts/readw.php?id_magazziniere=" + id_magazziniere, function(data){
 
        readShiftsTemplate(data, "");
        changePageTitle("Visualizza turni lavorativi");
 
    });
}