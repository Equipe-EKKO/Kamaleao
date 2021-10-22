$(document).ready(function () {
    /* AJAX PRA MANDAR OS RESULTADOS.... SÓ DEUS NA CAUSA */






    function iniciaModal(modalID) {
        var modal = document.getElementById(modalID);
        modal.classList.add('show');
        modal.addEventListener('click', (e) => {
            if(e.target.id == modalID || e.target.className == 'close') {
                modal.classList.remove('show');
            }
        });
    }
    var modalbtn = document.getElementById('modal-btn');
    modalbtn.addEventListener('click', () => iniciaModal('modal1'));
});

