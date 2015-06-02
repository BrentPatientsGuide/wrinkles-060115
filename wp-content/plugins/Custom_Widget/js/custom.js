jQuery(document).ready(function ($) {
    $("#hover").click(function () {
        $(this).fadeOut();
        $("#popup").fadeOut();
    });

    //chiusura al click sul pulsante
    $("#close").click(function () {
        $("#hover").fadeOut();
        $("#popup").fadeOut();
    });
    if($("#popup").length){
        $("#hover").fadeIn();
        $("#popup").fadeIn();
    }
});
