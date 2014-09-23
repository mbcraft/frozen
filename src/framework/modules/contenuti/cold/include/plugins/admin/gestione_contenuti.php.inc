<?

start_admin_panel("/pannello_sinistra/gestione_contenuti","Gestione contenuti pagine");
admin_link("/admin/contenuti/testi/","Gestione contenuti");
admin_link("/admin/media/immagini/?folder=/contenuti/","Gestione immagini");
admin_link("/admin/media/documenti/?folder=/contenuti/","Gestione documenti");
end_admin_panel();

?>