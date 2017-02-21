/**
 * Created by cyber10 on 14/02/2017.
 */

window.onload = function() {
  // document dom elementen
    eWinkelmandje = document.getElementById('winkelmandje');

    eWinkelmandje.addEventListener('click', function(e){
        // e.preventDefault();
    })
    $( function() {
        $( "#datepicker" ).datepicker();
    } );

};


