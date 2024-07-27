<?php

namespace Models;

use config\DB;

class Model
{
    protected string $table;
    protected DB $db;

    function __construct(string $table)
    {
        $this->table = $table;
        $this->db = new DB();
    }

    /**
     * @param string $table
     * @param array<string> $params
     * @return bool|int
     */
    function create(array $params): bool|int
    {
        $params = join(', ',$params);

        return $this->db->pdo->exec('CREATE TABLE ' . $this->table . '(' . $params  .');');
    }
    
    /**
     * @param array<mixed> $datas
     * @return bool|int
     */
    function insert(array $datas): bool|int
    {
        $values = [];

        $columns = $this->getTable();

        foreach($datas as $data)
        {
            $values[] = '"' .htmlspecialchars($data) . '"';
        }

        $result = 'INSERT INTO ' . 
        $this->table . 
        ' (' . join(', ', $columns) . 
        ') VALUES (' . 
        join(', ', $values) .');';
     
        return $this->db->pdo->exec($result);;
    }

    /**
     * @return array<string, string>
     */
    protected function getTable(): array
    {
        $query = 'SELECT *
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = "' . $this->table .'"';

        $result = $this->db->pdo->query($query);

        while($row = $result->fetch())
        {
            $columns[] = $row['COLUMN_NAME'];
        }

        $columns = array_slice($columns, 1, -3);

        return $columns;
    }
}

