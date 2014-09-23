<?

class ContenutiController extends AbstractController
{
    function init_roots()
    {
        $root_testi = call("single_admin","get_root_folder_testi");
        Session::set("/admin/root_folder_testi",$root_testi);

        $root_immagini = call("single_admin","get_root_folder_immagini");
        Session::set("/admin/root_folder_immagini",$root_immagini);

        $root_documenti = call("single_admin","get_root_folder_documenti");
        Session::set("/admin/root_folder_documenti",$root_documenti);
    }
}

?>