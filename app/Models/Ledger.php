<?php

class Ledger extends Model
{
    protected $table = 'gle';

    public function insert($data)
    {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO gle ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);

        try {
            return $stmt->execute($data);
        } catch (PDOException $e) {
            file_put_contents(
                __DIR__ . '/db_errors.log',
                $e->getMessage() . PHP_EOL,
                FILE_APPEND
            );

            return false;
        }
    }

    public function existsByReference($reference)
    {
        if (!$reference) return false;

        try {
            $stmt = $this->db->prepare(
                "SELECT COUNT(*) FROM gle WHERE reference = ?"
            );
            $stmt->execute([$reference]);

            return (int)$stmt->fetchColumn() > 0;

        } catch (Exception $e) {
            file_put_contents(
                __DIR__.'/db_errors.log',
                $e->getMessage(),
                FILE_APPEND
            );

            return false;
        }
    }
}