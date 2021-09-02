$(document).ready(function(){
    $(document).on('click', '.read-department-button', function(){
        showDepartment();
    });

    $(document).on('click', '#department-btn-group', function(){
        showDepartment();
    });
 
});

function showDepartment(){
    $.getJSON("http://localhost/prog3/api/salesman/read.php", function(data){
        
        readDepartmentTemplate(data, "");
        changePageTitle("Visualizza reparti");
 
    });
}