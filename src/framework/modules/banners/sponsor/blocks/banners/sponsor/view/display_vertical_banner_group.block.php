<?
$banner_group = call("sponsor_banner","get_banner_group_by_name",array("name" => $name));
$elenco_banner = call("sponsor_banner","index_banner",array("__filter_id_banner_group__EQUAL" => $banner_group["id_banner_group"]));
?>
<div class="vertical_banner_list">
<?
foreach ($elenco_banner as $banner)
{
    $immagine = call("immagini","get",array("id" => $banner["id_immagine"]));
    $banner["immagine"] = $immagine;
    $banner["max_width"] = $max_width;
    include_block("banners/sponsor/view/display_banner",$banner);
}
?>
</div>