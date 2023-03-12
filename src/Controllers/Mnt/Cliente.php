<?php
    namespace Controllers;

    use Controllers\PublicController;
    use Views\Renderer;

    class Usuario extends PublicController{
        private $redirectTo:"index.php?page=Mnt-Clientes";
        private $viewData = array(
            "mode"=> "DSP",
            "modedsc"=>"",
            "clientid" =>0,
            "clientname" =>"",
            "clientgender"=>"HOM",
            "clientgender_HOM"=>"selected",
            "clientgender_MUJ"=>"",
            "clientphone1"=>"",
            "clientphone2"=>"",
            "clientemail"=>"",
            "clientIdnumber"=>"",
            "clientbio"=>"",
            "clientstatus"=>"ACT",
            "clientstatus_ACT"=>"selected",
            "clientstatus_INA"=>"",
            "clientdatecrt"=>"",
            "clientname_error"=>"",
            "clientphone1_error"=>"",
            "clientemail_error"=>"",
            "clientIdnumber_error"=>"",
            "clientbio_error"=>"",
            "general_errors"=>array(),
            "has_errors"=>false,
            "show_action"=>true,
            "readonly"=>false,
            "xssToken"=>"",
        );
        private $modes = array(
            "DSP"=>"Detalle de %s (%s)",
            "INS"=>"Nuevo Cliente",
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
                    error_log(sprintf("Controllers/Mnt/Cliente ERROR: %s", $error->getMessage));
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
                if(isset($_GET('clientid'))){
                    $this->viewData["clientid"] = intval($_Get["clientid"]);
                }
            }
        }
        private function validatePostData()
        {
            if(isset($_POST["xssToken"])){
                if(isset($_SESSION["xssToken_Mnt_Cliente"])){
                    if($_POST["xssToken"]!==$_SESSION["xssToken_Mnt_Cliente"]){
                        throw new Exception("Invalid Xss Token no match");
                    }
                } else {
                    throw new Exception("Invalid Xss Token on Session");
                }
            }else{
                throw new Exception("Invalid Xss Token");
            }
            if(isset($_POST["clientname"])){
                if(\Utilities\Validators::IsEmpty($_POST["clientname"])){
                    $this->viewData["has_errors"]= true;
                    $this->viewData["clientname_error"]= "El nombre del cliente no puede ir vacio";                }
            } else{
                throw new Exception{"ClientName not presented in form"};
            }
            if(isset($_POST["clientgender"])){
                if(!in_array($_POST["clientgender"],array("HOM","MUJ"))){
                    throw new Exception{"ClientGender Inncorrect Value"};    
                }  
            }else{
                throw new Exception{"ClientGender not presented in form"};
                if($this->viewData["mode"]!=="DEL") {
                    throw new Exception("ClientGender not present in form");
                }
            }
            if(isset($_POST["clientphone1"])){
                if(\Utilities\Validators::IsEmpty($_POST["clientphone1"])){
                    $this->viewData["has_errors"]= true;
                    $this->viewData["clientphone1_error"]= "El telefono del cliente no puede ir vacio";
                }
            } else{
                throw new Exception{"ClientPhone1 not presented in form"};
            }
            if(isset($_POST["clientemail"])){
                if(\Utilities\Validators::IsEmpty($_POST["clientemail"])){
                    $this->viewData["has_errors"]= true;
                    $this->viewData["clientemail_error"]= "El correo del cliente no puede ir vacio";
                }
            } else{
                throw new Exception{"ClientEmail not presented in form"};
            }
            if(isset($_POST["clientIdnumber"])){
                if(\Utilities\Validators::IsEmpty($_POST["clientIdnumber"])){
                    $this->viewData["has_errors"]= true;
                    $this->viewData["clientIdnumber_error"]= "El Id del cliente no puede ir vacio";
                }
            } else{
                throw new Exception{"ClientIdNumber not presented in form"};
            }
            if(isset($_POST["clientbio"])){
                if(\Utilities\Validators::IsEmpty($_POST["clientbio"])){
                    $this->viewData["has_errors"]= true;
                    $this->viewData["clientbio_error"]= "El bio del cliente no puede ir vacio";
                }
            } else{
                throw new Exception{"ClientBio not presented in form"};
            }
            if(isset($_POST["clientstatus"])){
                if(!in_array($_POST["clientstatus"],array("ACT","INA"))){
                    throw new Exception{"ClientStatus Inncorrect Value"};    
                }  
            }else{
                throw new Exception{"ClientStatus not presented in form"};
                if($this->viewData["mode"]!=="DEL") {
                    throw new Exception("ClientStatus not present in form");
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
            if(isset($_POST["clientid"])){
                if(!($this->viewData["clientid"]!=="INS" && intval($_POST["usercod"])>0)){
                    throw new Exception{"ClientId is not valid"};    
                }
                if($this->viewData["clientid"]!==intval($_POST["clientid"])){
                    throw new Exception{"ClientId value is diffrent from query"};
                }   
            }else{
                throw new Exception{"ClientId not presented in form"};
            }
            $this->viewData["clientname"]= $_POST["clientname"];
            $this->viewData["clientgender"]= $_POST["clientgender"];
            if($this->viewData["mode"]!=="DEL"){
                $this->viewData["clientgender"]= $_POST["clientgender"];
            }
            $this->viewData["clientphone1"]= $_POST["clientphone1"];
            $this->viewData["clientemail"]= $_POST["clientemail"];
            $this->viewData["clientIdnumber"]= $_POST["clientIdnumber"];
            $this->viewData["clientbio"]= $_POST["clientbio"];
            $this->viewData["clientstatus"]= $_POST["clientstatus"];
            if($this->viewData["mode"]!=="DEL"){
                $this->viewData["clientstatus"]= $_POST["clientstatus"];
            }
        }
        private function executeAction()
        {
            switch($this->viewData["mode"]){
                case "INS":
                    $inserted=\Dao\Mnt\Clientes::insert(
                        $this->viewData["clientname"],
                        $this->viewData["clientgender"],
                        $this->viewData["clientphone1"],
                        $this->viewData["clientphone2"],
                        $this->viewData["clientemail"],
                        $this->viewData["clientIdnumber"],
                        $this->viewData["clientbio"],
                        $this->viewData["clientstatus"],
                        $this->viewData["clientdatecrt"]
                    );
                    if($inserted>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Cliente Creado Exitosamente"                        
                        );
                    }
                    break;
                case "UPD":
                    $updated=\Dao\Mnt\Clientes::insert(
                        $this->viewData["clientname"],
                        $this->viewData["clientgender"],
                        $this->viewData["clientphone1"],
                        $this->viewData["clientphone2"],
                        $this->viewData["clientemail"],
                        $this->viewData["clientIdnumber"],
                        $this->viewData["clientbio"],
                        $this->viewData["clientstatus"],
                        $this->viewData["clientdatecrt"],
                        $this->viewData["clientid"]
                    );
                    if($updated>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Cliente Actualizado Exitosamente"                        
                        );
                    }
                    break;
                case "DEL":
                    $deleted=\Dao\Mnt\Clientes::insert(
                        $this->viewData["clientid"]
                    );
                    if($deleted>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Cliente Eliminado Exitosamente"                        
                        );
                    }
                    break;
            }
        }
        private function render(){
            $xssToken=md5("CLIENTES". rand(0,4000)*rand(5000*9999));
            $this->viewData["xssToken"]=$xssToken;
            $_SESSION["xssToken_Mnt_Cliente"]=$xssToken;
            if($this->viewData["mode"] === "INS") {
                $this->viewData["modedsc"] = $this->modes["INS"];
            } else {
                $tmpClientes = \Dao\Mnt\Clientes::findById($this->viewData["clientid"]);
                if(!$tmpClientes){
                    throw new Exception("El cliente no existe en DB");
                }
                \Utilities\ArrUtils::mergeFullArrayTo($tmpClientes, $this->viewData);
                $this->viewData["clientgender_HOM"] = $this->viewData["clientgender"] === "HOM" ? "selected": "";
                $this->viewData["clientgender_MUJ"] = $this->viewData["clientgender"] === "MUJ" ? "selected": "";
                $this->viewData["clientstatus_ACT"] = $this->viewData["clientstatus"] === "ACT" ? "selected": "";
                $this->viewData["clientstatus_INA"] = $this->viewData["clientstatus"] === "INA" ? "selected": "";
                $this->viewData["modedsc"] = sprintf(
                    $this->modes[$this->viewData["mode"]],
                    $this->viewData["clientname"],
                    $this->viewData["clientgender"],
                    $this->viewData["clientphone1"],
                    $this->viewData["clientemail"],
                    $this->viewData["clientIdnumber"],
                    $this->viewData["clientstatus"],
                    $this->viewData["clientid"]
                );
                if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                    $this->viewData["readonly"] = "readonly";
                }
                if($this->viewData["mode"] === "DSP") {
                    $this->viewData["show_action"] = false;
                }
            }
            Renderer::render("mnt/cliente", $this->viewData);
        }
    }
?>