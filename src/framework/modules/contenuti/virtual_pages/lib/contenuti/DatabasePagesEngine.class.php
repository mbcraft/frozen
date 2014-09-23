<?

class DatabasePagesEngine implements IEngine
{
    /*
     * Funzione chiamata per sapere se una richiesta viene soddisfatta dall'engine.
     * path + nome danno il percorso completo della pagina SENZA ESTENSIONE, quindi nome NON DEVE CONTENERE
     * l'estensione.
     * */
    function acceptRequest()
    {
        $my_path = Request::getRequestPath();
        $my_name = Request::getRequestName();

        $peer = new PaginePeer();
        $peer->path__EQUAL($my_path);
        $peer->nome__EQUAL($my_name);
        $all_pages = $peer->find();

        return count($all_pages)==1;

    }

    function executeRequest()
    {
        $my_path = Request::getRequestPath();
        $my_name = Request::getRequestName();

        $peer = new PaginePeer();
        $peer->path__EQUAL($my_path);
        $peer->nome__EQUAL($my_name);
        $all_pages = $peer->find();

        $my_page = $all_pages[0];

        $peer_ep = new ElementiPaginaPeer();
        $peer_ep->id_pagina__EQUAL($my_page->id);
        $all_elementi_pagina = $peer_ep->find();

        /*
         * Carico tutti gli elementi pagina
         * Nel nome di un settore eventualmente ci posso mettere una descrizione
         * */
        foreach ($all_elementi_pagina as $elem)
        {
            $categoria = $elem->categoria;
            $sotto_categoria = $elem->sotto_categoria;
            $specifica = $elem->specifica;

            $categoria_instance = __create_instance(StringUtils::underscored_to_camel_case($categoria)."SectorRenderer");
            $result = $categoria_instance->{$sotto_categoria}($specifica);

            set_sector($elem->path_settore,$result);
        }
        /*
         * Questi rendering popolano i vari settori a modo loro
         * */

        //render pagina
        render(PageData::instance()->get("/")); //trova il layout e renderizza il tutto.

    }
}

?>