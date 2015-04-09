<?

class ProdottoServizioController extends AbstractController
{

    function crea()
    {
        $prodotto_servizio_peer = new ProdottoServizioPeer();

        $p = new ProdottoServizioDO();

        $prodotto_servizio_peer->setupByParams($p);

        $prodotto_servizio_peer->save($p);

        $image_count = Params::get("image_count");
        $i = 0;

        while ($i<$image_count)
        {
            if (Upload::isUpload("file_".$i) && Upload::isUploadSuccessful("file_".$i))
            {
                call("prodotto_servizio","aggiungi_immagine",array("file_field_name" => "file_".$i,"id_prodotto_servizio" => $p->id_prodotto_servizio));
            }

            $i++;
        }

        return Redirect::success();
    }

    function get()
    {
        $id_prodotto_servizio = Params::get("id_prodotto_servizio");
        $peer = new ProdottoServizioPeer();

        return ActiveRecordUtils::toArray($peer->find_by_id($id_prodotto_servizio));
    }

    function elimina()
    {
        $id_prodotto_servizio = Params::get("id_prodotto_servizio");

        $peer = new ProdottoServizioPeer();
        $peer->delete_by_id($id_prodotto_servizio);

        $peer = new ImmagineProdottoServizioPeer();
        $peer->id_prodotto_servizio__EQUALS(Params::get("id_prodotto_servizio"));
        $elenco_immagini_prodotto_servizio = $peer->find();
        foreach ($elenco_immagini_prodotto_servizio as $imm)
        {
            call("prodotto_servizio","elimina_immagine",array("id_prodotto_servizio" => $id_prodotto_servizio,"image_name" => $imm->nome_immagine));
        }

        return Redirect::success();
    }

    function modifica()
    {
        $prodotto_servizio_peer = new ProdottoServizioPeer();

        $p = $prodotto_servizio_peer->updateByParams();

        $prodotto_servizio_peer->save($p);

        $image_count = Params::get("image_count");
        $i = 0;

        while ($i<$image_count)
        {
            if (Upload::isUpload("file_".$i) && Upload::isUploadSuccessful("file_".$i))
            {
                call("prodotto_servizio","aggiungi_immagine",array("file_field_name" => "file_".$i,"id_prodotto_servizio" => $p->id_prodotto_servizio));
            }

            $i++;
        }

        return Redirect::success();
    }

    function index()
    {
        $prodotto_servizio_peer = new ProdottoServizioPeer();

        ActiveRecordUtils::updateFilters($prodotto_servizio_peer);

        return ActiveRecordUtils::toArray($prodotto_servizio_peer->find());
    }

    const PRODUCT_IMAGE_DIR = "/immagini/user/prodotti_servizi";

    function index_immagini()
    {
        $peer = new ImmagineProdottoServizioPeer();

        ActiveRecordUtils::updateFilters($peer);

        $elenco_immagini_prodotti_servizi = $peer->find();

        $data = ActiveRecordUtils::toArray($elenco_immagini_prodotti_servizi);

        if (is_html())
        {
            $data[Block::MARKER_KEY] = "vetrine/prodotti_servizi/select_immagine_prodotto_servizio";
        }

        return $data;
    }

    function aggiungi_immagine()
    {
        $id_prodotto_servizio = Params::get("id_prodotto_servizio");

        if (Params::is_set("file_field_name"))
            $file_field_name = Params::get("file_field_name");
        else
            $file_field_name = "file";

        if (Upload::isUploadSuccessful($file_field_name))
        {
            $product_dir = new Dir(self::PRODUCT_IMAGE_DIR."/".$id_prodotto_servizio);
            $product_dir->touch();

            $uploaded_img = Upload::saveTo($file_field_name,$product_dir);

            if (isset(Config::instance()->PRODUCT_IMAGE_RESIZE_BY_WIDTH))
            {
                image_w($uploaded_img->getPath(),Config::instance()->PRODUCT_IMAGE_RESIZE_BY_WIDTH);
            }
            else if (isset(Config::instance()->PRODUCT_IMAGE_RESIZE_BY_HEIGHT))
            {
                image_h($uploaded_img->getPath(),Config::instance()->PRODUCT_IMAGE_RESIZE_BY_HEIGHT);
            }

            //creo una riga associata all'immagine
            $immagine_prodotto_servizio_peer = new ImmagineProdottoServizioPeer();
            $do = $immagine_prodotto_servizio_peer->new_do();
            $do->id_prodotto_servizio = Params::get("id_prodotto_servizio");
            $do->nome_immagine = $uploaded_img->getFilename();
            $immagine_prodotto_servizio_peer->save($do);

            return Redirect::success();
        }
        else
        {
            Flash::error(Upload::getUploadError($file_field_name));
            return Redirect::failure();
        }
    }

    /*
     * Elimina un'immagine dalla gallery
     * */
    function elimina_immagine()
    {
        $image_name = Params::get("image_name");
        $id_prodotto_servizio = Params::get("id_prodotto_servizio");

        $product_image_dir = new Dir(self::PRODUCT_IMAGE_DIR."/".$id_prodotto_servizio);
        $product_image_file = $product_image_dir->newFile($image_name);

        ImagePicker::delete_image_thumbnails($product_image_file);

        //elimino la riga associata all'immagine
        $peer = new ImmagineProdottoServizioPeer();
        $peer->id_prodotto_servizio__EQUALS($id_prodotto_servizio);
        $peer->nome_immagine__EQUALS($image_name);
        $elenco_immagini_prodotto_servizio = $peer->find();
        foreach ($elenco_immagini_prodotto_servizio as $img)
            $peer->delete($img);

        $product_image_file->delete();

        if ($product_image_dir->isEmpty())
            $product_image_dir->delete();

        return Redirect::success();
    }

}

?>