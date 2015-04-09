<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class Html implements InitializeAfterLoad
{
    static function __classLoaded($className)
    {
        self::set_title(null);
        self::set_description(null);
        self::set_keywords(null);
        
        PageData::instance()->set("/page/headers/indexing_tags",array(Block::MARKER_KEY => "head/indexing_tags"));
        PageData::instance()->set("/page/headers/content_type",array(Block::MARKER_KEY => "head/content_type"));
        
        PageData::instance()->set("/page/headers/meta_tags",array(Block::MARKER_KEY => "head/meta_tags_list"));
        PageData::instance()->set("/page/headers/meta_tags/list",array());

        PageData::instance()->set("/page/headers/page_author",array(Block::MARKER_KEY => "head/author"));
                
        PageData::instance()->set("/page/headers/comment_tags",array(Block::MARKER_KEY => "head/comment_list"));
        PageData::instance()->set("/page/headers/comment_tags/list",array());

        $year = date("Y");
        $copyright_string = "Copyright ".$year." (c) MBCRAFT";
        PageData::instance()->set("/page/headers/page_copyright",array(Block::MARKER_KEY => "head/copyright","copyright_string" => $copyright_string,"year" => $year));

        self::set_layout("ajax");

        CSS::clean();      
        JS::clean();
    }
    
    static $default_content_save_path = "/page/result";
    
    static function set_title($title)
    {
        if ($title!=null)
            $param = array(Block::MARKER_KEY => "head/title", "title" => $title);
        else
            $param = array();
        PageData::instance()->set("/page/headers/page_title",$param);
        
    }

    static function add_comment($comment)
    {
        PageData::instance()->set("/page/headers/comment_tags/list/".$comment);
    }

    static function add_meta($name,$content)
    {
        PageData::instance()->set("/page/headers/meta_tags/list/".$name,$content);
    }

    static function get_title()
    {
        return PageData::instance()->get("/page/headers/page_title");
    }
    
    static function set_description($description)
    {
        if ($description!=null)
            $param = array(Block::MARKER_KEY => "head/description", "description" => $description);
        else
            $param = array();
        
        PageData::instance()->set("/page/headers/page_description",$param);
    }
    
    static function get_description()
    {
        return PageData::instance()->get("/page/headers/page_description");
    }
    
    static function set_keywords($keywords)
    {
        if ($keywords!=null)
        {
            if (!is_array($keywords))
                $keywords = explode(",",$keywords);
            
            $param = array(Block::MARKER_KEY => "head/keywords","keywords" => $keywords);
        }
        else
            $param = array();
        
        PageData::instance()->set("/page/headers/page_keywords",$param);
    }
    
    static function set_icon($icon_path)
    {
        PageData::instance()->set("/page/headers/page_icon",array(Block::MARKER_KEY => "head/icon","icon_path" => $icon_path));
    }
    
    static function get_icon()
    {
        return PageData::instance()->get("/page/headers/page_icon");
    }
    
    static function get_keywords()
    {
        return PageData::instance()->get("/page/headers/page_keywords");
    }
    
    static function set_default_content_save_path($save_path)
    {
        self::$default_content_save_path = $save_path;
    }
    
    static function get_default_content_save_path()
    {
        return self::$default_content_save_path;
    }

    static function set_copyright($copyright)
    {
        PageData::instance()->set("/page/headers/page_copyright/copyright_string",$copyright);
    }

    static function set_layout($layout)
    {
        PageData::instance()->set(Layout::MARKER_KEY,$layout);
    }
    
    static function get_layout()
    {
        return PageData::instance()->get(Layout::MARKER_KEY);
    }
    
    static function escape_special_characters($string)
    {
        return htmlentities($string, ENT_COMPAT, 'UTF-8');
    }
}
?>