$(document).on("submit", "#form-logout", function() {
    window.location.replace("http://localhost/prog3/login.html");
    setCookie("jwt", "", 1);
    sessionStorage.clear();
    return false;
});

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}