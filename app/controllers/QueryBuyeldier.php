<?php

namespace App\controllers;
use Aura\SqlQuery\QueryFactory;
use PDO;
class QueryBuyeldier
{
    private $db;
    private $queryFactory;
    public function __construct(PDO $pdo, QueryFactory $queryFactory)
    {
        $this->db = $pdo;
        $this->queryFactory = $queryFactory;
    }

    public function select($table){
        $select = $this->queryFactory->newSelect();
        $select
            ->cols(['*'])
            ->from($table);

        $sth = $this->db->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        $result = $sth->fetchALL(PDO::FETCH_ASSOC);
        return $result;
    }
    public function insert($table, $data){
        $insert = $this->queryFactory->newInsert();

        $insert
            ->into($table)             // insert into this table
            ->cols($data);
        $sth = $this->db->prepare($insert->getStatement());

        $sth->execute($insert->getBindValues());
    }
    public function update($table, $data, $id){
        $update = $this->queryFactory->newUpdate();

        $update
            ->table($table)                  // update this table
            ->cols($data)
            ->where('id =:id')
            ->bindValue('id',$id);
        $sth = $this->db->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }
    public function delete($table, $id){
        $delete = $this->queryFactory->newDelete();
        $delete
            ->from($table)                   // FROM this table
            ->where('id =:id')           // AND WHERE these conditions
            ->bindValue('id',$id); // bind one value to a placeholder
        $sth = $this->db->prepare($delete->getStatement());

        // execute with bound values
        $sth->execute($delete->getBindValues());
    }
}