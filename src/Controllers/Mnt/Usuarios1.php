<?php
    namespace Controllers\Mnt;

    use Controllers\PublicController;
    use Views\Renderer;

    class Usuario extends PublicController{
        
        public function run() :void
        {
            $viewData = array();
            $viewData = array(
                "edit_enabled"=>true,
                "delete_enabled"=>true,
                "new_enabled"=>true
            );
            $viewData["usuarios"] =\Dao\Mnt\Usuarios::findAll();
            Renderer::render('mnt/usuarios',$viewData);
        }
    }

?>