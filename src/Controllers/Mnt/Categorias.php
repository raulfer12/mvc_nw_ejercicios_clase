<?php
/**
 * Archivo Controlador de categorias el listado
 */
    namespace Controllers\Mnt;

    use Controllers\PublicController;
    use Views\Renderer;

    /**
     * Categorias
     */

    class Categorias extends PublicController{
        
        public function run() :void
        {
            $viewData = array();
            $viewData = array(
                "edit_enabled"=>true,
                "delete_enabled"=>true,
                "new_enabled"=>true
            );
            $viewData["categorias"] =\Dao\Mnt\Categorias::findAll();
            Renderer::render('mnt/categorias',$viewData);
        }
    }
?>