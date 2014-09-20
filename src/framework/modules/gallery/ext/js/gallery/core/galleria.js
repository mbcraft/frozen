    function load_gallery(my_gallery_name)
    {
        $('#gallery_view').load('/actions/gallery/get_gallery.php',{gallery_name:my_gallery_name});
        $("#gallery_"+my_gallery_name+" a").lightBox({fixedNavigation:true});
    }
    function reload_gallery(gallery_name)
    {
        $("#gallery_"+gallery_name+" a").lightBox({fixedNavigation:true});
    }