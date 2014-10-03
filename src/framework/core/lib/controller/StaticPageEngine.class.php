<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class StaticPageEngine implements IEngine
{
    public function acceptRequest() 
    {
        $request_part = Request::getRequestPart();
        
        $dot_pos = strpos($request_part,".");
        
        $page_name = substr($request_part,1,$dot_pos-1);

        return PageFactory::can_create($page_name);
    }
    
    public function renderResult() 
    {
        $request_part = Request::getRequestPart();
        
        $dot_pos = strpos($request_part,".");
        
        $page_name = substr($request_part,1,$dot_pos-1);
        $page = PageFactory::create($page_name, new DataHolder());

        Params::push();
        Params::importFromPost(false);
        Params::importFromGet(true);

        ob_start();
        $page->render();
        $page_result = ob_get_contents();
        ob_end_clean();

        Params::pop();
        
        PageData::instance()->set(Html::get_default_content_save_path(),$page_result);
        render(PageData::instance()->get("/")); //trova il layout e renderizza il tutto.
        
    }
    
    private function initializeDatabase()
    {
        DB::openDefaultConnection();
    }

    private function disposeDatabase()
    {
        DB::closeConnection();
    }

    public function executeRequest()
    {

        
        $this->initializeDatabase();
        
        Session::init();
        Flash::__load_from_session();
        BrowserInfo::fetch();

        RouteMap::init(); //sanitize environment
        
        $this->renderResult();

        Flash::__save_to_session();
        Session::save();

        $this->disposeDatabase();
    }
}
?>