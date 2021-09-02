$(document).ready(function() {
    var jwt = getCookie('jwt');
    if(jwt != "") {
        $.post("http://localhost/prog3/api/auth/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {
            if(result.messagge == 'Accesso garantito.') {
                if(result.data.ruolo == 'fornitore') {
                    localStorage.setItem("id_fornitore", result.data.id_fornitore);
                    sessionStorage.setItem("nome", result.data.nome);
                    sessionStorage.setItem("ruolo", result.data.ruolo);
                    changePannelloTitle("Pannello " + result.data.ruolo + " ");
                } else if (result.data.ruolo == 'addetto vendita') {
                    localStorage.setItem("id_addetto", result.data.id_addetto);
                    sessionStorage.setItem("nome", result.data.nome);
                    sessionStorage.setItem("ruolo", result.data.ruolo);
                    changePannelloTitle("Pannello " + result.data.ruolo + " ");
                }else if (result.data.ruolo == 'direttore'){
                    localStorage.setItem("id_direttore", result.data.id_direttore);
                    sessionStorage.setItem("nome", result.data.nome);
                    sessionStorage.setItem("ruolo", result.data.ruolo);
                    changePannelloTitle("Pannello " + result.data.ruolo + " ");
                }else if (result.data.ruolo == 'magazziniere'){
                    localStorage.setItem("id_magazziniere", result.data.id_magazziniere);
                    sessionStorage.setItem("nome", result.data.nome);
                    sessionStorage.setItem("ruolo", result.data.ruolo);
                    changePannelloTitle("Pannello " + result.data.ruolo + " ");
                }
            }
        });
    } else {
        alert("Area riservata, accesso negato.");
        window.location.replace("http://localhost/prog3/login.html");
        return false;
    }
});

//getCookie()
function getCookie(cname){
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' '){
            c = c.substring(1);
        }

        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function changePannelloTitle(pannello) {
    $('#pannello-title').text(pannello);
}