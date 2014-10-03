<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class ImagePicker
{
    const THUMBNAILS_DIR = "/tmp/thumbnails";

    public static function delete_thumbnails()
    {
        $d = new Dir(self::THUMBNAILS_DIR);
        $d->delete(true);
        $d->touch();
    }
    /*
     * Ritorna un'immagine ridimensionata per larghezza
     * */
    public static function get_image_by_width($path,$width="original")
    {
        if ($path instanceof File)
            $image_file = $path;
        else
            $image_file = new File($path);

        $image_dir = $image_file->getDirectory();

        $full_cache_dir = new Dir(self::THUMBNAILS_DIR.$image_dir->getPath());

        $full_cache_dir->touch();

        $data = ImageUtils::get_image_data($image_file);

        if ($width == "original")
            $thumb_folder = "original";
        else
        {
            if ($data["width"]>$width)
                $thumb_folder = $width."x__";
            else
                $thumb_folder = "original";
        }

        if ($thumb_folder=="original")
            return $image_file->getPath();

        $final_image_folder = new Dir(self::THUMBNAILS_DIR.$image_dir->getPath().$thumb_folder); //copio l'immagine nella cache
        $final_image_folder->touch();

        $thumbnail_image_file = $final_image_folder->newFile($image_file->getFilename());


        if (!$thumbnail_image_file->exists())
            ImageUtils::resize_by_width($image_file,$thumbnail_image_file,$width);

        return $thumbnail_image_file->getPath();
    }

    /*
     * Ritorna un'immagine ridimensionata per altezza
     * */
    public static function get_image_by_height($path,$height="original")
    {
        if ($path instanceof File)
            $image_file = $path;
        else
            $image_file = new File($path);

        $image_dir = $image_file->getDirectory();

        $full_cache_dir = new Dir(self::THUMBNAILS_DIR.$image_dir->getPath());

        $full_cache_dir->touch();

        $data = ImageUtils::get_image_data($image_file);

        if ($height == "original")
            $thumb_folder = "original";
        else
        {
            if ($data["height"]>$height)
                $thumb_folder = "__x".$height;
            else
                $thumb_folder = "original";
        }

        if ($thumb_folder=="original")
            return $image_file->getPath();

        $final_image_folder = new Dir(self::THUMBNAILS_DIR.$image_dir->getPath().$thumb_folder); //copio l'immagine nella cache
        $final_image_folder->touch();

        $thumbnail_image_file = $final_image_folder->newFile($image_file->getFilename());


        if (!$thumbnail_image_file->exists())
            ImageUtils::resize_by_height($image_file,$thumbnail_image_file,$height);

        return $thumbnail_image_file->getPath();
    }

    static function delete_image_thumbnails($path)
    {
        if ($path instanceof File)
            $image_file = $path;
        else
            $image_file = new File($path);

        $image_dir = $image_file->getDirectory();

        $full_cache_dir = new Dir(self::THUMBNAILS_DIR.$image_dir->getPath());

        $folders = $full_cache_dir->listFolders();

        foreach ($folders as $f)
        {
            $image_thumb = $f->newFile($image_file->getFilename());
            if ($image_thumb->exists()) $image_thumb->delete();

            if ($f->isEmpty())
                $f->delete();
        }

        if ($full_cache_dir->isEmpty())
            $full_cache_dir->delete();
    }
}

?>