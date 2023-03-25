<?php
    namespace Controllers;

    use Controllers\PublicController;
    use Exception;
    use Views\Renderer;

    class Account extends PublicController{
        private $redirectTo:"index.php?page=Mnt-Accounts";
        private $viewData = array(
            "mode"=> "DSP",
            "modedsc"=>"",
            "account_id"=>0,
            "account_name"=>"",
            "account_type"=>"ASSET",
            "account_type_ASSET"=>"selected",
            "account_type_LIABILITY"=>"",
            "account_type_EQUITY"=>"",
            "account_type_INCOME"=>"",
            "account_type_EXPENSE"=>"",
            "balance"=>0,
            "general_errors"=>array(),
            "has_errors"=>false,
            "show_action"=>true,
            "readonly"=>false,
            "xssToken"=>""
        );
        private $modes = array(
            "DSP"=>"Detalle de %s (%s)",
            "INS"=>"Nueva Account",
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
                unset($_SESSION["xssToken_Mnt_Account"]);
                error_log(sprintf("Controllers/Mnt/Account ERROR: %s", $error->getMessage));
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
            if(isset($_GET('account_id'))){
                $this->viewData["account_id"] = intval($_Get["account_id"]);
            }
        }
        }
        private function validatePostData(){
            if(isset($_POST["xssToken"])){
                if(isset($_SESSION["xssToken_Mnt_Account"])){
                    if($_POST["xssToken"]!==$_SESSION["xssToken_Mnt_Account"]){
                        throw new Exception("Invalid Xss Token no match");
                    }
                } else {
                    throw new Exception("Invalid Xss Token on Session");
                }
            }else{
                throw new Exception("Invalid Xss Token");
            }
            if(isset($_POST["account_name"])){
                if(\Utilities\Validators::IsEmpty($_POST["account_name"])){
                    $this->viewData["has_errors"]= true;
                }

            } else{
                throw new Exception{"Account Name not presented in form"};
            }
            if(isset($_POST["account_type"])){
                if(!in_array($_POST["account_type"],array("ASSET","LIABILITY","EQUITY","INCOME","EXPENSE"))){
                    throw new Exception{"Account Type Inncorrect Value"};    
                }
            }else{
                if($this->viewData["mode"]!=="DEL") {
                    throw new Exception("Account Type not present in form");
                }
            }
            if(isset($_POST["balance"])){
                if(floatval($_POST["balance"])<=0){
                    throw new Exception{"Balance Inncorrect Value"};    
                }
            }else{
                throw new Exception("Balance not present in form");
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
            if(isset($_POST["account_id"])){
                if(!($this->viewData["account_id"]!=="INS" && intval($_POST["account_id"])>0)){
                    throw new Exception{"Account Id is not valid"};    
                }
                if($this->viewData["account_id"]!==intval($_POST["account_id"])){
                    throw new Exception{"Account Id value is diffrent from query"};
                }   
            }else{
                throw new Exception{"Account Id not presented in form"};
            }
            $tmpPostData=array(
                "account_name"=>$_POST["account_name"],
                "balance"=>floatval($_POST["balance"])
            );
            \Utilities\ArrUtils::mergeFullArrayTo(
                $tmpPostData,
                $this->viewData
            );
            if($this->viewData["mode"]!=="DEL"){
                $this->viewData["account_type"] = $_POST["account_type"];
            }
        }
        private function executeAction(){
            switch($this->viewData["mode"]){
                case "INS":
                    $inserted=\Dao\Mnt\Accounts::insert(
                        $this->viewData["account_id"],
                        $this->viewData["account_type"],
                        $this->viewData["balance"]
                    );
                    if($inserted>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Account Creada Exitosamente"                        
                        );
                    }
                    break;
                case "UPD":
                    $updated=\Dao\Mnt\Accounts::insert(
                        $this->viewData["account_id"],
                        $this->viewData["account_type"],
                        $this->viewData["balance"],
                        $this->viewData["account_id"]
                    );
                    if($updated>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Account Actualizada Exitosamente"                        
                        );
                    }
                    break;
                case "DEL":
                    $deleted=\Dao\Mnt\Accounts::insert(
                        $this->viewData["account_id"]
                    );
                    if($deleted>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Account Eliminada Exitosamente"                        
                        );
                    }
                    break;
            }
        }
        private function render(){
            $xssToken=md5("ACCOUNT". rand(0,4000)*rand(5000*9999));
            $this->viewData["xssToken"]=$xssToken;
            $_SESSION["xssToken_Mnt_Account"]=$xssToken;
            if($this->viewData["mode"] === "INS") {
                $this->viewData["modedsc"] = $this->modes["INS"];
            } else {
                $tmpAccounts = \Dao\Mnt\Accounts::getById($this->viewData["account_id"]);
                if(!$tmpAccounts){
                    throw new Exception("Account no existe en DB");
                }
                \Utilities\ArrUtils::mergeFullArrayTo($tmpAccounts, $this->viewData);
                $this->viewData["account_type_ASSET"] = $this->viewData["account_type"] === "ASSET" ? "selected": "";
                $this->viewData["account_type_LIABILITY"] = $this->viewData["account_type"] === "LIABILITY" ? "selected": "";
                $this->viewData["account_type_EQUITY"] = $this->viewData["account_type"] === "EQUITY" ? "selected": "";
                $this->viewData["account_type_INCOME"] = $this->viewData["account_type"] === "INCOME" ? "selected": "";
                $this->viewData["account_type_EXPENSE"] = $this->viewData["account_type"] === "EXPENSE" ? "selected": "";
                $this->viewData["modedsc"] = sprintf(
                    $this->modes[$this->viewData["mode"]],
                    $this->viewData["account_name"],
                    $this->viewData["account_id"]
                );
                if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                    $this->viewData["readonly"] = "readonly";
                }
                if($this->viewData["mode"] === "DSP") {
                    $this->viewData["show_action"] = false;
                }
            }
            Renderer::render("mnt/account", $this->viewData);
    }
}
?>