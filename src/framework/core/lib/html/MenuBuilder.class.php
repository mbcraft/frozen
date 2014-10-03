<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class MenuBuilder
{
    const MENU_LAYOUT_FOLDER = "/include/menu/";
            
    /*
     * Ritorna l'albero delle pagine registrate.
     */
    static function get_menu_entries($content_dir_name)
    {
        $content_dir = new Dir($content_dir_name);
        $root_childs = self::loadSortedMenuData($content_dir);
        
        $final_root = array();
        
        $final_root["folder"] = $content_dir->getPath();
        $final_root["childs"] = $root_childs;
        
        return $final_root;      
    }
    
    /*
     * Renderizza il menu utilizzando il template specificato in menu_name
     */
    static function build($menu_name,$content_dir_name)
    {
        $final_root = self::get_menu_entries($content_dir_name);
        
        $final_root["key"] = $menu_name;
        
        $menu_layout_dir = new Dir(self::MENU_LAYOUT_FOLDER.$menu_name."/");
        
        $root_item = new MenuItem($menu_layout_dir,$final_root,0);
        $root_item->render(); 
    }
            
    /*
     * Carica i dati del menù secondo una struttura ad albero
     */
    private static function loadSortedMenuData($folder)
    {
        $menu_files = $folder->findFilesEndingWith("menu.ini");
        
        if (count($menu_files)==0) return null;
        $file = new File($folder->getPath().$menu_files[0]->getFilename());
        
        $all_data = PropertiesUtils::readFromFile($file, true);
        
        $final_sorted_data = array();
        foreach ($all_data as $section => $data)
        {
            $data["key"] = $section;
            
            if (isset($data["folder"]))
            {
                $childs = MenuBuilder::loadSortedMenuData(new Dir($data["folder"]));
                
                if ($childs!==null)                                    
                    $data["childs"] = $childs;
            }
            
            $final_sorted_data[(int)($data["position"])] = $data;
            
        }
 
        ArrayUtils::reorder_from_zero($final_sorted_data);
        
        return $final_sorted_data;
    }

}

?>