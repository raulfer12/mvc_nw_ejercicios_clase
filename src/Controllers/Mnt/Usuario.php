<?php
    namespace Controllers;

    use Controllers\PublicController;
    use Views\Renderer;

    class Usuario extends PublicController{
        private $redirectTo:"index.php?page=Mnt-Usuarios1";
        private $viewData = array(
            "mode"=> "DSP",
            "modedsc"=>"",
            "usercod" =>0,
            "useremail" =>"",
            "username"=>"",
            "userpswd"=>"",
            "userfching"=>"",
            "userpswdest"=>"ACT",
            "userpswdest_ACT"=>"selected",
            "userpswdest_INA"=>"",
            "userpswdexp"=>"",
            "userest"=>"ACT",
            "userest_ACT"=>"selected",
            "userest_INA"=>"",
            "useractcod"=>"",
            "userpswdchg"=>"",
            "usertipo"=>"NOR",
            "usertipo_NOR"=>"selected",
            "usertipo_CON"=>"",
            "usertipo_CLI"=>"",
            "username_error"=>"",
            "useremail_error"=>"",
            "userpswd_error"=>"",
            "useractcod_error"=>"",
            "general_errors"=>array(),
            "has_errors"=>false,
            "show_action"=>true,
            "readonly"=>false,
            "xssToken"=>"",
        );
        private $modes = array(
            "DSP"=>"Detalle de %s (%s)",
            "INS"=>"Nuevo Usuario",
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
                    unset($_SESSION["xssToken_Mnt_Usuario"]);
                    error_log(sprintf("Controllers/Mnt/Usuario ERROR: %s", $error->getMessage));
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
                if(isset($_GET('usercod'))){
                    $this->viewData["usercod"] = intval($_Get["usercod"]);
                }
            }
        }
        private function validatePostData()
        {
            if(isset($_POST["xssToken"])){
                if(isset($_SESSION["xssToken_Mnt_Usuario"])){
                    if($_POST["xssToken"]!==$_SESSION["xssToken_Mnt_Usuario"]){
                        throw new Exception("Invalid Xss Token no match");
                    }
                } else {
                    throw new Exception("Invalid Xss Token on Session");
                }
            }else{
                throw new Exception("Invalid Xss Token");
            }
            if(isset($_POST["useremail"])){
                if(\Utilities\Validators::IsEmpty($_POST["useremail"])){
                    $this->viewData["has_errors"]= true;
                    $this->viewData["useremail_error"]= "El correo del usuario no puede ir vacio";
                }
            } else{
                throw new Exception{"UserEmail not presented in form"};
            }
            if(isset($_POST["username"])){
                if(\Utilities\Validators::IsEmpty($_POST["username"])){
                    $this->viewData["has_errors"]= true;
                    $this->viewData["username_error"]= "El nombre del usuario no puede ir vacio";
                }
            } else{
                throw new Exception{"UserName not presented in form"};
            }
            if(isset($_POST["userpswd"])){
                if(\Utilities\Validators::IsEmpty($_POST["userpswd"])){
                    $this->viewData["has_errors"]= true;
                    $this->viewData["userpswd_error"]= "La contraseña del usuario no puede ir vacio";
                }
            } else{
                throw new Exception{"UserPswd not presented in form"};
            }
            if(isset($_POST["userpswdest"])){
                if(!in_array($_POST["userpswdest"],array("ACT","INA"))){
                    throw new Exception{"UserPswdEst Inncorrect Value"};    
                }  
            }else{
                throw new Exception{"UserPswdEst not presented in form"};
                if($this->viewData["mode"]!=="DEL") {
                    throw new Exception("UserPswdEst not present in form");
                }
            }
            if(isset($_POST["userest"])){
                if(!in_array($_POST["userest"],array("ACT","INA"))){
                    throw new Exception{"UserEst Inncorrect Value"};    
                }  
            }else{
                throw new Exception{"UserEst not presented in form"};
                if($this->viewData["mode"]!=="DEL") {
                    throw new Exception("UserEst not present in form");
                }
            }
            if(isset($_POST["useractcod"])){
                if(\Utilities\Validators::IsEmpty($_POST["useractcod"])){
                    $this->viewData["has_errors"]= true;
                    $this->viewData["useractcod_error"]= "El codigo del usuario no puede ir vacio";
                }
            } else{
                throw new Exception{"UserActCod not presented in form"};
            }
            if(isset($_POST["usertipo"])){
                if(!in_array($_POST["usertipo"],array("NOR","CON","CLI"))){
                    throw new Exception{"UserTipo Inncorrect Value"};    
                }  
            }else{
                throw new Exception{"UserTipo not presented in form"};
                if($this->viewData["mode"]!=="DEL") {
                    throw new Exception("UserTipo not present in form");
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
            if(isset($_POST["usercod"])){
                if(!($this->viewData["usercod"]!=="INS" && intval($_POST["usercod"])>0)){
                    throw new Exception{"UserCod is not valid"};    
                }
                if($this->viewData["usercod"]!==intval($_POST["usercod"])){
                    throw new Exception{"usercod value is diffrent from query"};
                }   
            }else{
                throw new Exception{"UserCod not presented in form"};
            }
            $this->viewData["useremail"]= $_POST["useremail"];
            $this->viewData["username"]= $_POST["username"];
            $this->viewData["userpswd"]= $_POST["userpswd"];
            $this->viewData["userpswdest"]= $_POST["userpswdest"];
            if($this->viewData["mode"]!=="DEL"){
                $this->viewData["userpswdest"]= $_POST["userpswdest"];
            }
            $this->viewData["userest"]= $_POST["userest"];
            if($this->viewData["mode"]!=="DEL"){
                $this->viewData["userest"]= $_POST["userest"];
            }
            $this->viewData["useractcod"]= $_POST["useractcod"];
            $this->viewData["usertipo"]= $_POST["usertipo"];
            if($this->viewData["mode"]!=="DEL"){
                $this->viewData["usertipo"]= $_POST["usertipo"];
            }
        }
        private function executeAction()
        {
            switch($this->viewData["mode"]){
                case "INS":
                    $inserted=\Dao\Mnt\Usuarios::insert(
                        $this->viewData["useremail"],
                        $this->viewData["username"],
                        $this->viewData["userpswd"],
                        $this->viewData["userfching"],
                        $this->viewData["userpswdest"],
                        $this->viewData["userpswdexp"],
                        $this->viewData["userest"],
                        $this->viewData["useractcod"],
                        $this->viewData["usertipo"]
                    );
                    if($inserted>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Usuario Creado Exitosamente"                        
                        );
                    }
                    break;
                case "UPD":
                    $updated=\Dao\Mnt\Usuarios::insert(
                        $this->viewData["useremail"],
                        $this->viewData["username"],
                        $this->viewData["userpswd"],
                        $this->viewData["userfching"],
                        $this->viewData["userpswdest"],
                        $this->viewData["userpswdexp"],
                        $this->viewData["userest"],
                        $this->viewData["useractcod"],
                        $this->viewData["usertipo"],
                        $this->viewData["usercod"]
                    );
                    if($updated>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Usuario Actualizado Exitosamente"                        
                        );
                    }
                    break;
                case "DEL":
                    $deleted=\Dao\Mnt\Usuarios::insert(
                        $this->viewData["usercod"]
                    );
                    if($deleted>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Usuario Eliminado Exitosamente"                        
                        );
                    }
                    break;
            }
        }
        private function render(){
            $xssToken=md5("USUARIO". rand(0,4000)*rand(5000*9999));
            $this->viewData["xssToken"]=$xssToken;
            $_SESSION["xssToken_Mnt_Usuario"]=$xssToken;
            if($this->viewData["mode"] === "INS") {
                $this->viewData["modedsc"] = $this->modes["INS"];
            } else {
                $tmpUsuarios = \Dao\Mnt\Usuarios::findById($this->viewData["usercod"]);
                if(!$tmpUsuarios){
                    throw new Exception("El usuario no existe en DB");
                }
                \Utilities\ArrUtils::mergeFullArrayTo($tmpUsuarios, $this->viewData);
                $this->viewData["userpswdest_ACT"] = $this->viewData["userpswdest"] === "ACT" ? "selected": "";
                $this->viewData["userpswdest_INA"] = $this->viewData["userpswdest"] === "INA" ? "selected": "";
                $this->viewData["userest_ACT"] = $this->viewData["userest"] === "ACT" ? "selected": "";
                $this->viewData["userest_INA"] = $this->viewData["userest"] === "INA" ? "selected": "";
                $this->viewData["usertipo_NOR"] = $this->viewData["usertipo"] === "NOR" ? "selected": "";
                $this->viewData["usertipo_CON"] = $this->viewData["usertipo"] === "CON" ? "selected": "";
                $this->viewData["usertipo_CLI"] = $this->viewData["usertipo"] === "CLI" ? "selected": "";
                $this->viewData["modedsc"] = sprintf(
                    $this->modes[$this->viewData["mode"]],
                    $this->viewData["username"],
                    $this->viewData["useremail"],
                    $this->viewData["userpswd"],
                    $this->viewData["useractcod"],
                    $this->viewData["usercod"]
                );
                if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                    $this->viewData["readonly"] = "readonly";
                }
                if($this->viewData["mode"] === "DSP") {
                    $this->viewData["show_action"] = false;
                }
            }
            Renderer::render("mnt/usuarios", $this->viewData);
        }
    }
?>