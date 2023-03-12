<?php
    namespace Dao\Mnt;

    use Dao\Table;

    class Clientes extends Table{

        public static function insert(
            string $clientname,
            string $clientgender="HOM",
            string $clientphone1,
            string $clientphone2,
            string $clientemail,
            string $clientIdnumber,
            string $clientbio,
            string $clientstatus="ACT",
            string $clientdatecrt
            ): int
        { 
            $sqlstr = "INSERT INTO clientes (
                clientname,
                clientgender,
                clientphone1,
                clientphone2,
                clientemail,
                clientIdnumber,
                clientbio,
                clientstatus,
                clientdatecrt
            ) values(
                :clientname,
                :clientgender,
                :clientphone1,
                :clientphone2,
                :clientemail,
                :clientIdnumber,
                :clientbio,
                :clientstatus,
                :clientdatecrt
            );";
            $rowsinserted = self::executeNonQuery(
                $sqlstr,
                array(
                    "clientname"=>$clientname,
                    "clientgender"=>$clientgender,
                    "clientphone1"=>$clientphone1,
                    "clientphone2"=>$clientphone2,
                    "clientemail"=>$clientemail,
                    "clientIdnumber"=>$clientIdnumber,
                    "clientbio"=>$clientbio,
                    "clientstatus"=>$clientstatus,
                    "clientdatecrt"=>$clientdatecrt
                    )
            );
            return $rowsinserted;
        }
        public static function update(
            string $clientname,
            string $clientgender,
            string $clientphone1,
            string $clientphone2,
            string $clientemail,
            string $clientIdnumber,
            string $clientbio,
            string $clientstatus,
            string $clientdatecrt,
            int $clientid
        ){
            $sqlstr="UPDATE clientes set 
            clientname = :clientname, 
            clientgender= :clientegender,
            clientphone1 = :clientphone1,
            clientphone2 = :clientphone2,
            clientemail = :clientemail,
            clientIdnumber = :clientIdnumber,
            clientbio = :clientbio,
            clientstatus = :clientstatus,
            clientdatecrt = : clientdatecrt,
            where clientid = :clientid;";
            $rowsUpdated = self::excuteNonQuery(
                $sqlstr,
                array(
                    "clientname"=>$clientname,
                    "clientgender"=>$clientgender,
                    "clientphone1"=>$clientphone1,
                    "clientphone2"=>$clientphone2,
                    "clientemail"=>$clientemail,
                    "clientIdnumber"=>$clientIdnumber,
                    "clientbio"=>$clientbio,
                    "clientstatus"=>$clientstatus,
                    "clientdatecrt"=>$clientdatecrt,
                    "clientid"=>$clientid
                )
            );
            return $rowsUpdated;
        }
        public static function delete(int $clientid){
            $sqlstr = "DELETE from clientes where clientid = :clientid;";
            $rowsDeleted = self::executeNonQuery(
                $sqlstr,
                array(
                    "clientid" => $clientid
                )
            )
        }
        public static function findAll(){
            $sqlstr = "SELECT * FROM clientes;";
            return self::obtenerRegistros($sqlstr, array());
            
        }
        public static function findByFilter(){
            
        }
        public static function findById(){
            $sqlstr = "SELECT * from clientes where clientid = :clientid;";
            $row = self::obtenerUnRegistro(
                $sqlstr,
                array(
                    "clientid" => $clientid
                )
            )
            return $row;
        }
    }
?>