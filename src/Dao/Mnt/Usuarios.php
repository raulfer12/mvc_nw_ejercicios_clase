<?php
    namespace Dao\Mnt;

    use Dao\Table;

    class Usuarios extends Table{

        public static function insert(
            string $useremail,
            string $username,
            string $userpswd,
            string $userfching,
            string $userpswdest="ACT",
            string $userpswdexp,
            string $userest="ACT",
            string $useractcod,
            string $userpswdchg,
            string $usertipo="NOR"
            ): int
        { 
            $sqlstr = "INSERT INTO usuario (
                useremail,
                username,
                userpswd,
                userfching,
                userpswdest,
                userpswdexp,
                userest,
                useractcod,
                userpswdchg,
                usertipo
            ) values(
                :useremail,
                :username,
                :userpswd,
                :userfching,
                :userpswdest,
                :userpswdexp,
                :userest,
                :useractcod,
                :userpswdchg,
                :usertipo
            );";
            $rowsinserted = self::executeNonQuery(
                $sqlstr,
                array(
                    "useremail"=>$useremail,
                    "username"=>$username,
                    "userpswd"=>$userpswd,
                    "userfching"=>$userfching,
                    "userpswdest"=>$userpswdest,
                    "userpswdexp"=>$userpswdexp,
                    "userest"=>$userest,
                    "useractcod"=>$useractcod,
                    "userpswdchg"=>$userpswdchg,
                    "usertipo"=>$usertipo
                    )
            );
            return $rowsinserted;
        }
        public static function update(
            string $useremail,
            string $username,
            string $userpswd,
            string $userfching,
            string $userpswdest,
            string $userpswdexp,
            string $userest,
            string $useractcod,
            string $userpswdchg,
            string $usertipo,
            int $usercod
        ){
            $sqlstr="UPDATE usuario set 
            useremail = :useremail, 
            username = :username,
            userpswd = :userpswd,
            userfching = :userfching,
            userpswdest = :userpswdest,
            userpswdexp = :userpswdexp,
            userest = :userest,
            useractcod = :useractcod,
            userpswdchg = : userpswdchg,
            usertipo = :usertipo 
            where usercod = :usercod;";
            $rowsUpdated = self::excuteNonQuery(
                $sqlstr,
                array(
                    "useremail"=>$useremail,
                    "username"=>$username,
                    "userpswd"=>$userpswd,
                    "userfching"=>$userfching,
                    "userpswdest"=>$userpswdest,
                    "userpswdexp"=>$userpswdexp,
                    "userest"=>$userest,
                    "useractcod"=>$useractcod,
                    "userpswdchg"=>$userpswdchg,
                    "usertipo"=>$usertipo,
                    "usercod"=>$usercod
                )
            );
            return $rowsUpdated;
        }
        public static function delete(int $usercod){
            $sqlstr = "DELETE from usuario where usercod = :usercod;";
            $rowsDeleted = self::executeNonQuery(
                $sqlstr,
                array(
                    "usercod" => $usercod
                )
            )
        }
        public static function findAll(){
            $sqlstr = "SELECT * FROM usuario;";
            return self::obtenerRegistros($sqlstr, array());
            
        }
        public static function findByFilter(){
            
        }
        public static function findById(){
            $sqlstr = "SELECT * from usuario where usercod = :usercod;";
            $row = self::obtenerUnRegistro(
                $sqlstr,
                array(
                    "usercod" => $usercod
                )
            )
            return $row;
            
        }
    }
?>