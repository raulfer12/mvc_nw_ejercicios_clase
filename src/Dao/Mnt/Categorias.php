<?php
    namespace Dao\Mnt;

    use Dao\Table;

    class Categorias extends Table{

        /**
         * Crea un nuevo registro de categoria
         * 
         */

        public static function insert(string $catnom,string $catest="ACT"): int
        { 
            $sqlstr = "INSERT INTO categorias (catnom, catest) values(:catnom, :catest);";
            $rowsinserted = self::executeNonQuery(
                $sqlstr,
                array("catnom"=>$catnom,"catest"=>$catest)
            );
            return $rowsinserted;
        }
        public static function update(
            string $catnom,
            string $catest,
            int $catid
        ){
            $sqlstr="UPDATE categorias set catnom = :catnom, catest = :catest where catid = :catid;";
            $rowsUpdated = self::excuteNonQuery(
                $sqlstr,
                array(
                    "catnom" => $catnom,
                    "catest" => $catest,
                    "catid" => $catid
                )
            );
            return $rowsUpdated;
        }
        public static function delete(int $catid){
            $sqlstr = "DELETE from categorias where catid = :catid;";
            $rowsDeleted = self::executeNonQuery(
                $sqlstr,
                array(
                    "catid" => $catid
                )
            )
        }
        public static function findAll(){
            $sqlstr = "SELECT * FROM categorias;";
            return self::obtenerRegistros($sqlstr, array());
            
        }
        public static function findByFilter(){
            
        }
        public static function findById(){
            $sqlstr = "SELECT * from categorias where catid = :catid;";
            $row = self::obtenerUnRegistro(
                $sqlstr,
                array(
                    "catid" => $catid
                )
            )
            return $row;
            
        }
    }
?>