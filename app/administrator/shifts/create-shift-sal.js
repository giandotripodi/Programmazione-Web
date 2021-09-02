$(document).ready(function() {
    $(document).on('click', '.create-shift-sal-button', function() {
        $.getJSON("http://localhost/prog3/api/salesman/read.php", function(data){
            var create_shift_sal_html = `
                <div id='read-shift' class='btn btn-primary pull-right m-b-15px read-shifts-button'>
                    <span class='glyphicon glyphicon-list'></span> Visualizza turni
                </div>

                <!-- 'Crea turno' form html -->
                <form id='create-shiftsal-form' action='#' method='post' border='0'>
                    <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Addetto vendita</td>
                        <td><select id='id_addetto' name='id_addetto' class='form-control'>`;

                        $.each(data.records, function(key, val) {
                            create_shift_sal_html  += `<option value='` + val.id_addetto + `'>` + val.nome +` `+ val.cognome +` - `+ val.reparto + `</option>`;
                        });

                        create_shift_sal_html += `</select></td></tr>
                    </tr>
                    <!-- Giorno -->
                    <tr>
                        <td>Giorno</td>
                        <td><select id="id_giorno" name='id_giorno' class='form-control' />
                        </select></td>
                    </tr>
                    <!-- Orario -->
                    <tr>
                        <td>Orario</td>
                        <td><select id="id_orario" name='id_orario' class='form-control' />
                        </select></td>
                    </tr>
                    <!-- button di invio del form -->
                    <tr>
                        <td></td>
                        <td>
                            <button type='submit' class='btn btn-primary'>
                                <span class='glyphicon glyphicon-plus'></span> Inserisci turno
                            </button>
                        </td>
                    </tr>
                    </table>
                </form>`;

            //inserisce l'html nella "page-content"
            $("#page-content").html(create_shift_sal_html);

            changePageTitle("Inserisci turno");
        });
    });


    $(document).on('click', '#id_addetto', function() {
        var success = false;

        $.getJSON("http://localhost/prog3/api/wdays/read.php", function(data){
            $('#id_giorno').empty();
            success = true;
            $.each(data.records, function(key,val) {
                $('#id_giorno').append(`<option value='` + val.id_giorno + `'> `+ val.giorno + `</option>`);
            });
        });

        if(success == false){
            $('#id_giorno').empty();
        }
    });

    $(document).on('click', '#id_giorno', function() {
        var success = false;

        $.getJSON("http://localhost/prog3/api/wtime/read.php", function(data){
            $('#id_orario').empty();
            success = true;
            $.each(data.records, function(key,val) {
                $('#id_orario').append(`<option value='` + val.id_orario + `'> `+ val.orario + `</option>`);
            });
        });

        if(success == false){
            $('#id_orario').empty();
        }
    });

    //se il form viene inviato verrà eseguita questa parte di codice
    $(document).on('submit', '#create-shiftsal-form', function(e) {
        //get form data
        var form_data = JSON.stringify($(this).serializeObject());

        console.log(form_data);

        $.ajax({
            url: "http://localhost/prog3/api/shifts/creates.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function(result) {
                showShifts();
            },
            error: function(xhr, resp, text) {
                console.log(xhr, resp, text);
            }
        });

        e.preventDefault();

    });

    return false;
});