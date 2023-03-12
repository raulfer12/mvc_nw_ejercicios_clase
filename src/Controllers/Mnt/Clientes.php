<?php

    namespace Controllers\Mnt;

    use Controllers\PublicController;
    use Views\Renderer;

    class Clientes extends PublicController{
        
        public function run() :void
        {
            $viewData = array();
            $viewData = array(
                "edit_enabled"=>true,
                "delete_enabled"=>true,
                "new_enabled"=>true
            );
            $viewData["categorias"] =\Dao\Mnt\Clientes::findAll();
            Renderer::render('mnt/clientes',$viewData);
        }
    }
?>