$(document).ready(function(){
    $(document).on('click', '.read-arrange-button', function(){
        showArtArrange();
    });
    
    $(document).on('click', '#arrange-btn-group', function() {
        showArtArrange();
    });
 
});

function showArtArrange(){
    
    $.getJSON("http://localhost/prog3/api/article/read_arrange.php", function(data){
 
        readArtArrangeTemplate(data, "");
         changePageTitle("Visualizza articoli da sistemare");
 
    });
}