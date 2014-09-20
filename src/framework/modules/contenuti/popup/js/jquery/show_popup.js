/*
* Funzioni js per la visualizzazione di un popup
*/
function center_on_screen(object) {
    $(object).css("left", ( ( $(window).width() - $(object).width() ) / 2) + $(window).scrollLeft() + "px")
    $(object).css('top' , ( ( $(window).height() - $(object).height()) / 2) + $(window).scrollTop() + "px");
}

function show_popup(url, size)
{
    $("#popup").empty().css("height", size.height).css("width", size.width).load(url);
    center_on_screen($("#popup").show());
}
