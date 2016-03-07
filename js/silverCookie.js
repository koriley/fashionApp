/* 
 * This is a set cookie function 'class'.
 * This is created for silver pop, but is generic enough that we can set others cookies too
 * Check cookie is an example of how it works.
 */

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires +";path=/";
    
}
//setting a value in local storage
function setLocal(key, value){
    localStorage.setItem(key, value);
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

function getLocal(key){
    localStorage.getItem(key);
}

function checkCookie() {
    var user = getCookie("username");
    if (user != "") {
        alert("Welcome again " + user);
    } else {
        user = prompt("Please enter your name:", "");
        if (user != "" && user != null) {
            setCookie("username", user, 365);
        }
    }
}

function silverPop1() {
    var user = getCookie("magUser");
    if (user != "") {
       //setCookie("magUser", user, 365);
       koPopUp('silverPop1'); //remove this after testing
    } else {
        koPopUp('silverPop1');
    }
}

function checkFashionUser(){
    var user = getCookie("fashionUser");
    var pass = getCookie("fashionPass");
    var lev = getCookie("fashionLev");
    if(user !==''){
        jQuery('#loginBlock').fadeOut();
        jQuery('#mother').load('view/view_mainView.php?level='+lev+'&userID='+user).fadeIn();
    }else{
        jQuery('#mother').load('user/view/view_logIn.php');
    }
}

