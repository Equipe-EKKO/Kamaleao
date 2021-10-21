var notiFired = false;
var perfFired = false;
var menuFired = false;

function mostra(id, className){
    document.getElementById(id).classList.replace(className, "mostrar");
    if (id == "noti") {
        window.notiFired = true;
    } else if (id == "perf") {
        window.perfFired = true;
        
    } else if (id == "menu") {
        window.menuFired = true;
    }
}

function esconde(id, className){
    document.getElementById(id).classList.replace("mostrar", className);
    if (id == "noti") {
        window.notiFired = false;
        
    } else if (id == "perf") {
        window.perfFired = false;
        
    } else if (id == "menu") {
        window.menuFired = false;
        
    }
}

/* MOSTRA OS DROPDOWN */

function mostraNoti() {
    if (window.notiFired == false) {
        mostra("noti", "noti");
        if (window.perfFired == true && mwindow.enuFired == true) {
            esconde("perf", "peril");
            esconde("menu", "menu");
        } else if (window.perfFired == true && window.menuFired == false) {
            esconde("perf", "perfil");
        } else if (window.perfFired == false && window.menuFired == true) {
            esconde("menu", "menu");
        }
    }
}
function mostraPerf() {
    if (window.perfFired == false) {
        mostra("perf", "perfil");
        if (window.notiFired == true && window.menuFired == true) {
            esconde("noti", "noti");
            esconde("menu", "menu");
        } else if (window.notiFired == true && window.menuFired == false) {
            esconde("noti", "noti");
        } else if (window.notiFired == false && window.menuFired == true) {
            esconde("menu", "menu");
        }
    }
}
function mostraMenu() {
    if (window.menuFired == false) {
        mostra("menu", "menu");
        if (window.notiFired == true && window.perfFired == true) {
            esconde("noti", "noti");
            esconde("perf", "perfil");
        } else if (window.notiFired == true && window.perfFired == false) {
            esconde("noti", "noti");
        } else if (window.notiFired == false && window.perfFired == true) {
            esconde("perf", "perfil");
        }
    }
}
/* ESCONDE OS DROPDOWN */
function escondeNoti() {
    if (window.notiFired == true) {
        esconde("noti", "noti");
    }
}
function escondePerf() {
    if (window.perfFired == true) {
        esconde("perf", "perfil");
    }
}
function escondeMenu() {
    if (window.menuFired == true) {
        esconde("menu", "menu");
    }
}
