<?

class VetrineController extends AbstractController
{

    public function get_vetrina()
    {
        $peer = new VetrinaPeer();

        if (Params::is_set("id_vetrina"))
            $do = $peer->find_by_id(Params::get("id_vetrina"));
        else
        {
            $peer->nome_vetrina__EQUAL(Params::get("nome_vetrina"));
            $do_list = $peer->find();
            $do = $do_list[0];
        }
        return ActiveRecordUtils::toArray($do);
    }
    /*
     * Ritorna l'elenco delle vetrine
     * */
    public function index()
    {
        $peer = new VetrinaPeer();
        ActiveRecordUtils::updateFilters($peer);
        return ActiveRecordUtils::toArray($peer->find());
    }

    /*
     * Crea una nuova vetrina
     * */
    function crea_vetrina()
    {
        $peer = new VetrinaPeer();

        $do = $peer->new_do();
        $peer->setupByParams($do);
        $peer->save($do);

        if (is_html())
            return Redirect::success();
        else
            return Result::ok();
    }

    /*
    * Modifica una nuova vetrina
    * */
    function modifica_vetrina()
    {
        $peer = new VetrinaPeer();

        $do = $peer->updateByParams();
        $peer->save($do);

        if (is_html())
            return Redirect::success();
        else
            return Result::ok();
    }

    /*
     * Elimina una vetrina e tutti i prodotti al suo interno
     * */
    function elimina_vetrina()
    {
        $peer = new VetrinaPeer();
        $do = $peer->find_by_id(Params::get("id_vetrina"));
        $peer->delete($do);

        $peer2 = new ProdottoServizioVetrinaPeer();
        $peer2->id_vetrina__EQUAL(Params::get("id_vetrina"));
        $elenco_prodotti_servizi = $peer2->find();
        foreach ($elenco_prodotti_servizi as $ps)
            $peer2->delete($ps);

        if (is_html())
            return Redirect::success();
        else
            return Result::ok();
    }

    function get_prodotto_servizio_vetrina()
    {
        $peer = new ProdottoServizioVetrinaPeer();

        $do = $peer->find_by_id(Params::get("id_prodotto_servizio_vetrina"));

        return ActiveRecordUtils::toArray($do);
    }

    function elenco_prodotti_servizi_vetrina()
    {
        $peer = new ProdottoServizioVetrinaPeer();
        $peer->id_vetrina__EQUAL(Params::get("id_vetrina"));

        $elenco_prodotti_servizi = $peer->find();

        return ActiveRecordUtils::toArray($elenco_prodotti_servizi);
    }

    function aggiungi_prodotto_servizio_vetrina()
    {
        $peer = new ProdottoServizioVetrinaPeer();

        $do = $peer->new_do();
        $peer->setupByParams($do);
        $peer->save($do);

        if (is_html())
            return Redirect::success();
        else
            return Result::ok();
    }

    function modifica_prodotto_servizio_vetrina()
    {
        $peer = new ProdottoServizioVetrinaPeer();
        $do = $peer->updateByParams();
        $peer->save($do);

        if (is_html())
            return Redirect::success();
        else
            return Result::ok();
    }

    function elimina_prodotto_servizio_vetrina()
    {
        $peer = new ProdottoServizioVetrinaPeer();
        $do = $peer->find_by_id(Params::get("id_prodotto_servizio_vetrina"));
        $peer->delete($do);

        if (is_html())
            return Redirect::success();
        else
            return Result::ok();
    }
}

?>