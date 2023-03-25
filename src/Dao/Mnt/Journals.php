<?php
    namespace Dao\Mnt;

    use Dao\Table;

    class Journals extends Table{
        public static function getAll(){
            return self::obtenerRegistros("SELECT * FROM JOURNALS;",array());
        }

        public static function getById(int $journal_id){
            return self::obtenerUnRegistro(
                "SELECT * FROM JOURNALS WHERE journal_id=:journal_id;",
                array("journal_id"=>$journal_id)
            );
        }

        public static function insert(
            string $journal_description,
            string $journal_type,
            string $journal_date,
            float $journal_amount,
        ){
            $ins_sql="INSERT INTO `journals`
            (
            `journal_date`,
            `journal_type`,
            `journal_description`,
            `journal_amount`,
            `created_at`)
            VALUES
            (
            :journal_date,
            :journal_type,
            :journal_description,
            :journal_amount,
            now());";

            return self::executeNonQuery(
                $ins_sql,
                array(
                    ":journal_date"=>$journal_date,
                    ":journal_type"=>$journal_type,
                    ":journal_description"=>$journal_description,
                    ":journal_amount"=>$journal_amount
                )
            );
        }

        public static function update(
            string $journal_description,
            string $journal_type,
            string $journal_date,
            float $journal_amount,
            int $journal_id
        ){
            $ins_sql= "UPDATE `journals`
            SET
            `journal_date` = :journal_date,
            `journal_type` = :journal_type,
            `journal_description` = :journal_description,
            `journal_amount` = :journal_amount,
            WHERE `journal_id` = :journal_id;"
            return self::executeNonQuery(
                $ins_sql,
                array(
                    ":journal_date"=>$journal_date,
                    ":journal_type"=>$journal_type,
                    ":journal_description"=>$journal_description,
                    ":journal_amount"=>$journal_amount,
                    ":journal_id"=>$journal_id
                )
            );
        }

        public static function delete(
            int $journal_id
        ){
            $ins_sql = "DELETE from journal where journal_id=:journal_id;";
            return self::executeNonQuery(
                $ins_sql,
                array("journal_id"=>$journal_id)
            );
        }
    }
?>