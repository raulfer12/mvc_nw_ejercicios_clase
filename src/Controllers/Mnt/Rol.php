<?php
    namespace Controllers;

    use Controllers\PublicController;
    use Views\Renderer;

    class Rol extends PublicController{
        private $redirectTo:"index.php?page=Mnt-Roles";
        private $viewData = array(
            "mode"=> "DSP",
            "modedsc"=>"",
            "rolescod" =>"",
            "rolesdsc" =>"",
            "rolesest"=>"ACT",
            "rolesest_ACT"=>"selected",
            "rolesest_INA"=>"",
            "rolescod_error"=>"",
            "rolesdsc_error"=>"",
            "general_errors"=>array(),
            "has_errors"=>false,
            "show_action"=>true,
            "readonly"=>false,
            "xssToken"=>""
        );
        private $modes = array(
            "DSP"=>"Detalle de %s (%s)",
            "INS"=>"Nuevo Rol",
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
            } 
                catch(Exception $error) {
                    unset($_SESSION["xssToken_Mnt_Rol"]);
                    error_log(sprintf("Controllers/Mnt/Rol ERROR: %s", $error->getMessage));
                    \Utilities\Sites::redirectToWithMsg(
                        $redirectTo,
                        "Algo Inesperado Sucedió. Intente de Nuevo"
                    )
                }
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
            if(isset($_GET('rolescod'))){
                $this->viewData["rolescod"] = strval($_Get["rolescod"]);
            }
        }
        }
        private function validatePostData(){
            if(isset($_POST["xssToken"])){
                if(isset($_SESSION["xssToken_Mnt_Rol"])){
                    if($_POST["xssToken"]!==$_SESSION["xssToken_Mnt_Rol"]){
                        throw new Exception("Invalid Xss Token no match");
                    }
                } else {
                    throw new Exception("Invalid Xss Token on Session");
                }
            }else{
                throw new Exception("Invalid Xss Token");
            }
            if(isset($_POST["rolesdsc"])){
                if(\Utilities\Validators::IsEmpty($_POST["rolesdsc"])){
                    $this->viewData["has_errors"]= true;
                    $this->viewData["rolesdsc_error"]= "Este campo no puede ir vacio!";
                }

            } else{
                throw new Exception{"RolesDsc not presented in form"};
            }
            if(isset($_POST["rolesest"])){
                if(!in_array($_POST["rolesest"],array("ACT","INA"))){
                    throw new Exception{"RolesEst Inncorrect Value"};    
                }               
            }else{
                throw new Exception{"RolesEst not presented in form"};
                if($this->viewData["mode"]!=="DEL") {
                    throw new Exception("RolesEst not present in form");
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
            if(isset($_POST["rolescod"])){
                if(\Utilities\Validators::IsEmpty($_POST["rolescod"])){
                    $this->viewData["has_errors"]= true;
                    $this->viewData["rolescod_error"]= "El codigo no puede ir vacio!";
                }
            } else{
                throw new Exception{"RolesCod not presented in form"};
            }
            $this->viewData["rolesdsc"]= $_POST["rolesdsc"];
            $this->viewData["rolesest"]= $_POST["rolesest"];
            if($this->viewData["mode"]!=="DEL"){
                $this->viewData["rolesest"] = $_POST["rolesest"];
            }
            $this->viewData["rolescod"]= $_POST["rolescod"];
        }
        private function executeAction(){
            switch($this->viewData["mode"]){
                case "INS":
                    $inserted=\Dao\Mnt\Roles::insert(
                        $this->viewData["rolescod"],
                        $this->viewData["rolesdsc"],
                        $this->viewData["rolesest"]
                    );
                    if($inserted>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Rol Creado Exitosamente"                        
                        );
                    }
                    break;
                case "UPD":
                    $updated=\Dao\Mnt\Roles::insert(
                        $this->viewData["rolescod"],
                        $this->viewData["rolesdsc"],
                        $this->viewData["rolesest"]
                    );
                    if($updated>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Rol Actualizado Exitosamente"                        
                        );
                    }
                    break;
                case "DEL":
                    $deleted=\Dao\Mnt\Roles::insert(
                        $this->viewData["rolescod"]
                    );
                    if($deleted>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Rol Eliminado Exitosamente"                        
                        );
                    }
                    break;
            }
        }
        private function render(){
            $xssToken=md5("ROLES". rand(0,4000)*rand(5000*9999));
            $this->viewData["xssToken"]=$xssToken;
            $_SESSION["xssToken_Mnt_Rol"]=$xssToken;
            if($this->viewData["mode"] === "INS") {
                $this->viewData["modedsc"] = $this->modes["INS"];
            } else {
                $tmpRoles = \Dao\Mnt\Roles::findById($this->viewData["rolescod"]);
                if(!$tmpRoles){
                    throw new Exception("Rol no existe en DB");
                }
                \Utilities\ArrUtils::mergeFullArrayTo($tmpRoles, $this->viewData);
                $this->viewData["rolesest_ACT"] = $this->viewData["rolesest"] === "ACT" ? "selected": "";
                $this->viewData["rolesest_INA"] = $this->viewData["rolesest"] === "INA" ? "selected": "";
                $this->viewData["modedsc"] = sprintf(
                    $this->modes[$this->viewData["mode"]],
                    $this->viewData["rolesdsc"],
                    $this->viewData["rolescod"]
                );
                if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                    $this->viewData["readonly"] = "readonly";
                }
                if($this->viewData["mode"] === "DSP") {
                    $this->viewData["show_action"] = false;
                }
            }
            Renderer::render("mnt/roles", $this->viewData);
    }
}
?>