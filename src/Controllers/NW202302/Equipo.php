<?php
    namespace Controllers\NW202302;

    use Controllers\PublicController;
    use Views\Renderer;

    class Equipo extends PublicController{
        public function run() :void
        {
            $viewData = array(
                "nombre1"=> "Raul Banegas",
                "email1"=>"0501200015374",
                "title1"=>"Software Engineer",

                "nombre2"=> "Michaell Antonio Osorio",
                "email2"=>"0703200004889",
                "title2"=>"Software Engineer",

                "nombre3"=> "Jose Diego Amaya",
                "email3"=>"0801199803269",
                "title3"=>"Software Engineer",

                "nombre4"=> "Alexandra Jireh Murillo",
                "email4"=>"0806200000004",
                "title4"=>"Software Engineer",

                "nombre5"=> "Joela Ordoñez Hernandez ",
                "email5"=>"1501200201932",
                "title5"=>"Software Engineer"
            );

            Renderer::render("nw202302/Equipo", $viewData);
        }
    }
?>