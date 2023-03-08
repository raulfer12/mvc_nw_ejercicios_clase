<?php
    namespace Controllers;

    use Controllers\PublicController;
    use Views\Renderer;

    class Categoria extends PublicController{
        private $redirectTo:"index.php?page=Mnt-categorias";
        private $viewData = array(
            "mode"=> "DSP",
            "modedsc"=>"",
            "catid" =>0,
            "catnom" =>"",
            "catest"=>"ACT",
            "catest_ACT"=>"selected",
            "catest_INA"=>"",
            "catnom_error"=>"",
            "general_errors"=>array(),
            "has_errors"=>false,
            "show_action"=>true,
            "readonly"=>false,
        );
        private $modes = array(
            "DSP"=>"Detalle de %s (%s)",
            "INS"=>"Nueva Categoria",
            "UPD"=>"Editar %s (%s)",
            "DEL"=>"Borrar %s (%s)",
        );
        public function run() :void
        {
            try{
            $this->page_loaded();
            if($this->isPostBack()){
                $this->validatePostData();
                if($this->viewData["has_errors"]){
                    $this->executeAction();
                }
            }
            $this->render();
            } catch(Exception $error) {
                error_log(sprintf("Controllers/Mnt/Categoria ERROR: %s", $error->getMessage));
                \Utilities\Sites::redirectToWithMsg(
                    $redirectTo,
                    "Algo Inesperado Sucedió. Intente de Nuevo"
                )
            }
            /**
             * 1) Captura de Valores Iniciales QueryParams-> Parametros de Query ? 
             * https://ax.ex.com/index.php?page=abc&mode=UPD&id=1029
             * 2) Determinamos el metodo POST GET
             * 3)Procesar la Entrada
             * 3.1) Si es un POST
             * 3.2) Capturar y Validar datos del formulario
             * 3.3) Segun el modo realizar la accion solicitada
             * 3.4) Notificar Error si hay
             * 3.5) Redirigir a la lista
             * 4.1) Si es un GET
             * 4.2) Obtener valores de la DB sin no es INS
             * 4.3) Mostrar Valores
             * 4) Renderizar
             */

        }
        private function page_loaded()
        {
            if(isset($_GET['mode'])){
                if(isset($this->modes[$_GET['mode']])){
                    $this->viewData["mode"] = $_Get['mode'];
                } else{
                    throw "Mode Not available";
                }
            } else{
                throw "Mode Not Defined on Query Params"
            }
            if($this->viewData["mode"] !== "INS"){
            if(isset($_GET('catid'))){
                $this->viewData["catid"] = intval($_Get["catid"]);
            }
        }
        }
        private function validatePostData(){
            if(isset($_POST["cadnom"])){
                if(\Utilities\Validators::IsEmpty($_POST["catnom"])){
                    $this->viewData["has_errors"]= true;
                    $this->viewData["catnom_error"]= "El nombre no puede ir vacio!";
                }

            } else{
                throw new Exception{"CatNom not presented in form"};
            }
            if(isset($_POST["cadest"])){
                if(!in_array($_POST["catest"],array("ACT","INA"))){
                    throw new Exception{"CatEst Inncorrect Value"};    
                }
                
            }else{
                throw new Exception{"CatEst not presented in form"};
                if($this->viewData["mode"]!=="DEL") {
                    throw new Exception("CatEst not present in form");
                }
            }
            if(isset($_POST["mode"])){
                if(!key_exists($_POST["mode"], $this->modes)){
                    throw new Exception{"Mode has a bad value"};
                }
                if($this->viewData["mode"]!==$_POST["mode"]){
                    throw new Exception{"Mode value is diffrent from query"};
                }                
            }else{
                throw new Exception{"Mode not presented in form"};
            }
            if(isset($_POST["catid"])){
                if(!($this->viewData["catid"]!=="INS" && intval($_POST["catid"])>0)){
                    throw new Exception{"CatId is not valid"};    
                }
                if($this->viewData["catid"]!==intval($_POST["catid"])){
                    throw new Exception{"catid value is diffrent from query"};
                }   
            }else{
                throw new Exception{"CatId not presented in form"};
            }
            $this->viewData["catnom"]= $_POST["catnom"];
            $this->viewData["catest"]= $_POST["catest"];
            if($this->viewData["mode"]!=="DEL"){
                $this->viewData["catest"] = $_POST["catest"];
            }
        }
        private function executeAction(){
            switch($this->viewData["mode"]){
                case "INS":
                    $inserted=\Dao\Mnt\Categorias::insert(
                        $this->viewData["catnom"],
                        $this->viewData["catest"]
                    );
                    if($inserted>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Categoría Creada Exitosamente"                        
                        );
                    }
                    break;
                case "UPD":
                    $updated=\Dao\Mnt\Categorias::insert(
                        $this->viewData["catnom"],
                        $this->viewData["catest"],
                        $this->viewData["catid"]
                    );
                    if($updated>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Categoría Actualizada Exitosamente"                        
                        );
                    }
                    break;
                case "DEL":
                    $deleted=\Dao\Mnt\Categorias::insert(
                        $this->viewData["catid"]
                    );
                    if($deleted>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Categoría Eliminada Exitosamente"                        
                        );
                    }
                    break;
            }
        }
        private function render(){
            if($this->viewData["mode"] === "INS") {
                $this->viewData["modedsc"] = $this->modes["INS"];
            } else {
                $tmpCategorias = \Dao\Mnt\Categorias::findById($this->viewData["catid"]);
                if(!$tmpCategorias){
                    throw new Exception("Categoria no existe en DB");
                }
                //$this->viewData["catnom"] = $tmpCategorias["catnom"];
                //$this->viewData["catest"] = $tmpCategorias["catest"];
                \Utilities\ArrUtils::mergeFullArrayTo($tmpCategorias, $this->viewData);
                $this->viewData["catest_ACT"] = $this->viewData["catest"] === "ACT" ? "selected": "";
                $this->viewData["catest_INA"] = $this->viewData["catest"] === "INA" ? "selected": "";
                $this->viewData["modedsc"] = sprintf(
                    $this->modes[$this->viewData["mode"]],
                    $this->viewData["catnom"],
                    $this->viewData["catid"]
                );
                if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                    $this->viewData["readonly"] = "readonly";
                }
                if($this->viewData["mode"] === "DSP") {
                    $this->viewData["show_action"] = false;
                }
            }
            Renderer::render("mnt/categoria", $this->viewData);
    }
?>