$(document).ready(function() {

    $(document).on('click', '.update-shift-button', function() {

        var id_orario_lav = $(this).attr('data-id');

        $.getJSON("http://localhost/prog3/api/shifts/read_one.php?id_orario_lav=" + id_orario_lav, function(data) {
            var giorno = data.giorno;
            var id_giorno = data.id_giorno;
            var orario = data.orario;
            var id_orario = data.id_orario;
            
            $.getJSON("http://localhost/prog3/api/wdays/read.php", function(data) {

                var update_shift_html = `
                    <div id='read-shift' class='btn btn-primary pull-right m-b-15px read-shifts-button'>
                        <span class='glyphicon glyphicon-list'></span> Visualizza turni
                    </div>

                    <!-- costruzione form html 'aggiorna piano' -->
                    <!-- usiamo la proprietà html5 'required' per prevenire campi vuoti -->
                    <form id='update-shift-form' action='#' method='post' border='0'>
                        <table class='table table-hover table-responsive table bordered'>
                            
                            <!-- campo dipartimento -->
                            <tr>
                                <td>Giorno</td>
                                <td><select id='id_giorno' name='id_giorno' class='form-control'>
                                    <option value='` + id_giorno + `'>` + giorno + `</option>`;

                    $.each(data.records, function(key, val) {
                            update_shift_html += `<option value='` + val.id_giorno + `'>` + val.giorno + `</option>`;
                    });
                            
                    update_shift_html += `
                    </select></td></tr>

                    <!-- menu edificio -->
                    <tr>
                        <td>Orario</td>
                        <td><select id="lookup-orario" name='id_orario' class='form-control' required />
                            <option value='` + id_orario + `'>` + orario + `</option>
                        </select></td>
                    </tr>
                    <tr>
                        <!-- nasconde 'id_orario_lav' per identificare il record da aggiornare -->
                        <td><input value=\"` + id_orario_lav + `\" name='id_orario_lav' type='hidden' /></td>

                        <!-- bottone per inviare il form -->
                        <td>
                            <button type='submit' class='btn btn-info'>
                                <span class='glyphicon glyphicon-edit'></span> Aggiorna Turno
                            </button>
                        </td>

                    </tr>
                    </table>
                    </form>`;

                $("#page-content").html(update_shift_html);

                changePageTitle("Aggiorna orario");
            });

            $(document).on('click', '#id_giorno', function() {
                var success = false;
                $.getJSON("http://localhost/prog3/api/wtime/read.php", function(data) {
                    $('#lookup-orario').empty();
        
                    success = true;
        
                    $.each(data.records, function(key, val) {
                        $('#lookup-orario').append(`<option value='` + val.id_orario + `'>` + val.orario + `</option>`);
                    });
                });
        
                if(success == false) {
                    $('#lookup-orario').empty();
                }
            });

            $(document).on('submit', '#update-shift-form', function() {

                var form_data = JSON.stringify($(this).serializeObject());
                $.ajax({
                    url: "http://localhost/prog3/api/shifts/update.php",
                    type: "PUT",
                    contentType: "application/json",
                    data: form_data,
                    success: function(result) {
                        showShifts();
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