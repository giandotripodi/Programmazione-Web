$(document).ready(function() {

    setCookie("jwt", "", 1);

    var create_login_html = `
    <div class="login-page">
    <div class="form">
        <h3>Login alla piattaforma</h3><br>
      <form class="login-form" action="#" id="login" method="post">
        <input type="email" name="email" placeholder="Email"/>
        <input type="password" name="password" placeholder="Password"/>
        
        <input type="submit" name="login">
      </form>
    </div>
  </div>`;
    
    $('#app').html(create_login_html);

    $(document).on('submit', '#login', function(e) {
        var form_data = JSON.stringify($(this).serializeObject());

        $.ajax({
            url: "http://localhost/prog3/api/auth/login.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function(result) {
                setCookie("jwt", result.jwt, 1);
                redirect(result.token.data.ruolo);
            },
            error: function(xhr, resp, text) {
                alert("Accesso non riuscito, i dati inseriti non sono corretti."); 
                console.log(xhr);
            }
        });

        e.preventDefault();
    });
});

function redirect(ruolo) {

    switch(ruolo) {
        case 'direttore':
            window.location.href = "http://localhost/prog3/administrator.html";
            break;
        case 'addetto vendita':
            window.location.href = "http://localhost/prog3/salesman.html";
            break;
        case 'magazziniere':
            window.location.href = "http://localhost/prog3/warehouse.html";
            break;
        case 'fornitore':
            window.location.href = "http://localhost/prog3/supplier.html";
            break;
    }
}

// function to set cookie
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};