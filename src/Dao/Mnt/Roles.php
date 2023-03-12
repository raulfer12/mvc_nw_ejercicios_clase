<?php
    namespace Dao\Mnt;

    use Dao\Table;

    class Roles extends Table{

        public static function insert(
            string $rolescod, 
            string $rolesdsc,
            string $rolesest="ACT"
            ): int
        { 
            $sqlstr = "INSERT INTO roles (
                rolescod, 
                rolesdsc, 
                rolesest
                ) values(
                    :rolescod, 
                    :rolesdsc, 
                    :rolesdest
                    );";
            $rowsinserted = self::executeNonQuery(
                $sqlstr,
                array(
                    "rolescod"=>$rolescod, 
                    "rolesdsc"=>$rolesdsc, 
                    "rolesest"=>$rolesest
                    )
            );
            return $rowsinserted;
        }
        public static function update(
            string $rolesdsc,
            string $rolesest,
            string $rolescod
        ){
            $sqlstr="UPDATE roles set
             rolesdsc = :rolesdsc, 
             rolesest = :rolesest 
             where rolescod = :rolecod;";
            $rowsUpdated = self::excuteNonQuery(
                $sqlstr,
                array(
                    "rolesdsc" => $rolesdsc,
                    "rolesest" => $rolesest,
                    "rolescod" => $rolescod
                )
            );
            return $rowsUpdated;
        }
        public static function delete(int $rolescod){
            $sqlstr = "DELETE from roles where rolescod = :rolescod;";
            $rowsDeleted = self::executeNonQuery(
                $sqlstr,
                array(
                    "rolescod" => $rolescod
                )
            )
        }
        public static function findAll(){
            $sqlstr = "SELECT * FROM roles;";
            return self::obtenerRegistros($sqlstr, array());
            
        }
        public static function findByFilter(){
            
        }
        public static function findById(){
            $sqlstr = "SELECT * from roles where rolescod = :rolescod;";
            $row = self::obtenerUnRegistro(
                $sqlstr,
                array(
                    "rolescod" => $rolescod
                )
            )
            return $row;     
        }
    }
?>