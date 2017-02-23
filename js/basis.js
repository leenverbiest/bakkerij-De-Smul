/**
 * Created by cyber10 on 14/02/2017.
 */

window.onload = function() {
    // document dom elementen
    eWinkelmandje = document.getElementById('winkelmandje');

    eWinkelmandje.addEventListener('click', function (e) {
        // e.preventDefault();
    });
    //we passen de datepicker widget toe op de ganse set

    $('#afhaaldatum').datepicker({
        dateFormat: "yy-mm-dd",
        minDate: "1",    //geen selectie de dag zelf
        maxDate: "+3d", //max 3 dagen vooruit best kan de bestelling opgehaald worden
        changeMonth: false,
        changeYear: false

    });


}
