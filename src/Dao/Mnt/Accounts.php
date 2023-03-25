<?php
    namespace Dao\Mnt;

    use Dao\Table;
    /**
     *  account_id INT AUTO_INCREMENT PRIMARY KEY,
    *account_name VARCHAR(255) NOT NULL,
    *account_type ENUM('ASSET', 'LIABILITY', 'EQUITY', 'INCOME', 'EXPENSE') NOT NULL,
    *balance DECIMAL(10,2) NOT NULL,
    *created_at DATETIME DEFAULT CURRENT_TIMESTAMP
     */

    class Accounts extends Table{
        public static function getAll(){
            return self::obtenerRegistros("SELECT * FROM ACCOUNTS;",array());
        }

        public static function getById(int $journal_id){
            return self::obtenerUnRegistro(
                "SELECT * FROM ACCOUNTS WHERE account_id=:account_id;",
                array("account_id"=>$journal_id)
            );
        }

        public static function insert(
            string $account_name,
            string $account_type,
            float $balance,
        ){
            $ins_sql="INSERT INTO `accounts`
            (
            `account_name`,
            `account_type`,
            `balance`,
            `created_at`)
            VALUES
            (
            :account_name,
            :account_type,
            :balance,
            now());";

            return self::executeNonQuery(
                $ins_sql,
                array(
                    ":account_name"=>$account_name,
                    ":account_type"=>$account_type,
                    ":balance"=>$balance
                )
            );
        }

        public static function update(
            string $account_name,
            string $account_type,
            float $balance,
            int $account_id
        ){
            $ins_sql= "UPDATE `accounts`
            SET
            `account_name` = :account_name,
            `account_type` = :account_type,
            `balance` = :balance,
            WHERE `account_id` = :account_id;"
            return self::executeNonQuery(
                $ins_sql,
                array(
                    ":account_name"=>$account_name,
                    ":account_type"=>$account_type,
                    ":balance"=>$balance,
                    ":account_id"=>$account_id
                )
            );
        }

        public static function delete(
            int $account_id
        ){
            $ins_sql = "DELETE from account where account_id=:account_id;";
            return self::executeNonQuery(
                $ins_sql,
                array("account_id"=>$account_id)
            );
        }
    }
?>