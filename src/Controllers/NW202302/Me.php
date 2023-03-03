<?php

    namespace Controllers\NW202302;

    use Controllers\PublicController;
    use Views\Renderer;
    use Dao\Clases\Demo;

    class Me extends PublicController{
        /*index.php?page=NW202302-Me */
        public function run() :void
        {
            $viewData = array();
            $responseDao = Demo::getAResponse()["Response"];
            $viewData["response"] = $responseDao;
            Renderer::render('nw202302/Me', $viewData);
        }
    }

?>