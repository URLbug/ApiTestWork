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
     * @param array<string> $columns
     * @return array<mixed>
     */
    function select(array $columns): array
    {
        $result = [];

        $query = 'SELECT ' . join(', ', $columns) . 
        ' FROM ' . $this->table . ';';

        $datas = $this->db->pdo->query($query);

        while($data = $datas->fetch())
        {
            $result[] = $data;
        }

        return $result; 
    }

    function where(array $columns, string $oper): array
    {
        $result = [];

        $query = 'SELECT ' . join(', ', $columns) . 
        ' FROM ' . $this->table . ' WHERE ' . $oper . ' ;';

        $datas = $this->db->pdo->query($query);

        while($data = $datas->fetch())
        {
            $result[] = $data;
        }

        return $result;
    }

    /**
     * @param string $opt
     * @return bool|int
     */
    function delete(string $opt): bool|int
    {
        $result = 'DELETE FROM ' . $this->table . 
        ' WHERE ' . $opt . ';';
        
        return $this->db->pdo->exec($result);
    }

    function update(array $rows, array $datas, string $opt): bool|int
    {
        $newDatas = [];

        for($i=0; $i < count($rows); $i++)
        {
            $newDatas[] = $rows[$i] . ' = "' . htmlspecialchars($datas[$i]) . '"';
        }

        $result = 'UPDATE ' . $this->table . 
        ' SET ' . join(', ', $newDatas) . ' WHERE ' . $opt . ';';
        
        return $this->db->pdo->exec($result);
    }

    /**
     * @return array<string>
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
