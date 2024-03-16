<?php

namespace Utils\Abstract;

abstract class Db extends Model
{
    abstract protected function getTable(): string;

    final public function select(...$params): array | null
    {
        return $this->db->select($this->getTable(), ...$params);
    }

    final public function insert(...$params): string
    {
        $this->db->insert($this->getTable(), ...$params);

        return $this->db->id();
    }

    final public function delete(...$params)
    {
        $this->db->delete($this->getTable(), ...$params);
    }

    final public function update(...$params)
    {
        $this->db->update($this->getTable(), ...$params);
    }

    final public function count(...$params)
    {
        return $this->db->count($this->getTable(), ...$params);
    }

    final public function action($func) {
        try {
            $this->db->pdo->beginTransaction();

            $func();

            $this->db->pdo->commit();
        } catch (\Exception $e) {
            if ($this->db->pdo->inTransaction()) 
                $this->db->pdo->rollBack();
            throw $e;
        }
    }
}
