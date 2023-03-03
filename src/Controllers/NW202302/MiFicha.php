<?php
    namespace Controllers\NW202302;

    use Controllers\PublicController;
    use Views\Renderer;

    class MiFicha extends PublicController{
        public function run() :void
        {
            $viewData = array(
                "nombre"=> "Raul Banegas",
                "email"=>"raulferbanegas@gmail.com",
                "title"=>"Software Engineer"
            );

            Renderer::render("nw202302/MiFicha", $viewData);
        }
    }
?>