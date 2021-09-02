$(document).ready(function() {
    $(document).on('click', '.update-department-button', function() {
        var id_addetto = $(this).attr('data-id');
        $.getJSON("http://localhost/prog3/api/salesman/read_one.php?id_addetto=" + id_addetto, function(data) {
            $.getJSON("http://localhost/prog3/api/department/read.php", function(data) {
                var update_department_html = `
                    <div id='read-department' class='btn btn-primary pull-right m-b-15px read-department-button'>
                        <span class='glyphicon glyphicon-list'></span> Visualizza addetti vendita
                    </div>

                    <!-- costruzione form html 'aggiorna piano' -->
                    <!-- usiamo la proprietà html5 'required' per prevenire campi vuoti -->
                    <form id='update-department-form' action='#' method='post' border='0'>
                        <table class='table table-hover table-responsive table bordered'>
                            
                            <!-- campo dipartimento -->
                            <tr>
                                <td>Reparto</td>
                                <td><select id='id_reparto' name='id_reparto' class='form-control'>`;

                    $.each(data.records, function(key, val) {
                            update_department_html += `<option value='` + val.id_reparto + `'>` + val.nome + `</option>`;
                    });
                            
                    update_department_html += `
                    </select></td></tr>
                    <tr>
                        <!-- nasconde 'id_addetto' per identificare il record da aggiornare -->
                        <td><input value=\"` + id_addetto + `\" name='id_addetto' type='hidden' /></td>

                        <!-- bottone per inviare il form -->
                        <td>
                            <button type='submit' class='btn btn-info'>
                                <span class='glyphicon glyphicon-edit'></span> Aggiorna Reparto
                            </button>
                        </td>

                    </tr>
                    </table>
                    </form>`;

                $("#page-content").html(update_department_html);

                changePageTitle("Aggiorna reparto");
            });

            $(document).on('submit', '#update-department-form', function() {

                var form_data = JSON.stringify($(this).serializeObject());
                $.ajax({
                    url: "http://localhost/prog3/api/salesman/update.php",
                    type: "PUT",
                    contentType: "application/json",
                    data: form_data,
                    success: function(result) {
                        showDepartment();
                    },
                    error: function(xhr, resp, text) {
                        console.log(xhr, resp, text);
                    }
                });
                
                return false;
            })
        
        });
    });
});