$(document).ready(function() {
    var ruolo = sessionStorage.getItem("ruolo");
    if(ruolo != null) {
        if(!(ruolo == "direttore" && window.location == "http://localhost/prog3/administrator.html#")) {
            alert("Area riservata.");
            window.location.href = "http://localhost/prog3/login.html";
            setCookie("jwt", "", 1);
            sessionStorage.clear();
            return false;
        }

        if(!(ruolo == "addetto vendita") && window.location == "http://localhost/prog3/salesman.html") {
            alert("Area riservata.");
            window.location.href = "http://localhost/prog3/login.html";
            setCookie("jwt", "", 1);
            sessionStorage.clear();
            return false;
        }

        if(!(ruolo == "fornitore") && window.location == "http://localhost/prog3/supplier.html") {
            alert("Area riservata.");
            window.location.href = "http://localhost/prog3/login.html";
            setCookie("jwt", "", 1);
            sessionStorage.clear();
            return false;
        }

        if(!(ruolo == "magazziniere") && window.location == "http://localhost/prog3/warehouse.html") {
            alert("Area riservata.");
            window.location.href = "http://localhost/prog3/login.html";
            setCookie("jwt", "", 1);
            sessionStorage.clear();
            return false;
        }
    }
});