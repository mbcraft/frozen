/*
 * NOTA DI COPYRIGHT
 Questo framework è esclusiva proprietà di Frostlab gate. Ne è vietato l'utilizzo, la copia, la modifica o la redistribuzione
 sotto qualsiasi forma senza l'esplicito consenso da parte di Frostlab gate. Tutti i diritti riservati.
 *
 * COPYRIGHT NOTICE
 This framework is exclusive property of Frostlab gate. Usage, copy, changes or redistribution in any form are forbidden
 without an explicit agreement with Frostlab gate. All rights reserved.
 */

$(document).ready(function(){
    $('.cssdropdown li.headlink').hover(
        function() { $('ul', this).css('display', 'block'); },
        function() { $('ul', this).css('display', 'none'); });
});