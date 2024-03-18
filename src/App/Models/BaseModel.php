<?php

namespace phpApi\App\Models;

use mysqli as mySqlObject;

class BaseModel {
    protected string $table;
    protected mySqlObject $conn;

    protected $columns = '*';

    protected $conditions = [];

    protected $operation = 'SELECT ';

    protected $joinsWith = [];

    protected $sorting = [];

    protected $limit = null;

    protected $offset = null;

    protected $data = [];

    public function __construct($table = '')
    {
        try {
            $conn = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            $this->setConnection($conn, $table);

        } catch (\Exception $exception){
            die('connection error');
            /** Do Whatever you wanna do */
        }
    }

    protected function setConnection(\mysqli $conn, $table)
    {
        if ( $conn->connect_errno ) {
            throw new \Exception('db connection failed');
        }

        $this->conn = $conn;
        $this->table = $table;
    }

    protected function shouldLog(): bool
    {
        return SHOULD_LOG;
    }

    protected function getConnection(): mySqlObject
    {
        return $this->conn;
    }

    public function select($columns)
    {
        if(is_array($columns)) {
            $this->columns = rtrim(implode(', ', $columns), ', ');
        } elseif (is_string($columns)) {
            $this->columns = $columns;
        } elseif (is_null($columns)){
            $this->columns = '';
        }

        return $this;
    }

    public function where()
    {
        return $this->returnAfterSettingCondition(
            $this->fetchConditionalOperators( ...array_merge([
                isset($this->conditions[0]) ? 'AND' : 'WHERE'],func_get_args()
            ))
        );
    }

    public function orWhere()
    {
        return $this->returnAfterSettingCondition(
            $this->fetchConditionalOperators( ...array_merge([
                isset($this->conditions[0]) ? 'OR' : 'WHERE'],func_get_args()
            ))
        );
    }

    protected function returnAfterSettingCondition( $conditionalArray )
    {
        $this->conditions[] = $conditionalArray;

        return $this;
    }

    protected function execute($sql = null)
    {
        $query = $sql ?: $this->baseQuery();

        $this->createLogs($query);

        $result = $this->conn->query($query);

        if ($this->operation == 'SELECT ' && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $result->free();
        }

        return $data ?? [];
    }

    protected function fetchConditionalOperators()
    {
        $havingOperator = count($args = func_get_args()) == 4;
        $column = $args[1];
        $operator = $havingOperator ? $args[2] : '=';
        $value = $havingOperator ? $args[3] : $args[2];

        return (['clause'=> $args[0], 'column' => $column, 'operator' => $operator, 'value' => $value ]);
    }

    public function save($data, $update = false)
    {
        $this->data = $data;
        $this->operation = $update ? "UPDATE" : "INSERT";
        $this->execute();

        return $update ? : (new Model($this->table))->orderBy('id')->first();
    }

    protected function baseQuery()
    {
        if ($this->operation == 'INSERT') {
            return $this->getDataInsertionQuery();
        }

        if ($this->operation == 'UPDATE') {
            return ($this->getDataUpdationQuery());
        }

        $query = $this->getBaseQueryForModel();

        $this->appendConditionalJoins($query);

        $this->appendConditionalOperators($query);

        return $this->appendSortingLimitOffset($query);
    }

    private function getDataInsertionQuery()
    {
        foreach ($this->data as $key => $value) {
            $columns[] = $key;
            $values[] = '"'.$value.'"';
        }

        $columns = rtrim(implode(', ', $columns), ', ');
        $values = rtrim(implode(', ', $values), ', ');

        return "INSERT INTO ".$this->table." (".$columns.") VALUES(".$values.");";
    }

    private function getDataUpdationQuery()
    {
        $query = "UPDATE ".$this->table." SET ";

        foreach ($this->data as $key => $value) {
            $query = $query . "`".$key."` = '".$value."', ";
        }

        $query = rtrim($query, ', ');

        $this->appendConditionalOperators($query);

        return $query;
    }

    private function appendConditionalOperators(&$query)
    {
        foreach ($this->conditions as $condition) {
            $value = $condition['operator']== 'IN' ? $condition['value'] : '"'.$condition['value'].'"';
            $query = $query. ' '.$condition['clause']. ' '.$condition['column'].' '.$condition['operator'].' '.$value;
        }
    }

    private function appendConditionalJoins(&$query)
    {
        foreach ($this->joinsWith as $joins) {
            $query = $query.' JOIN '.$joins['table'].' ON '.$joins['condition'];
        }
    }

    private function getBaseQueryForModel(): string
    {
        if ($this->operation === 'DELETE') {
           $this->columns = '';
        }

        return $this->operation.$this->columns.' FROM '.$this->table;
    }

    private function appendSortingLimitOffset($query)
    {
        if (!empty($this->sorting)) {
            $query = $query.' ORDER BY '.$this->table.'.'.$this->sorting['key'].' '.$this->sorting['order'];
        }

        if ($this->limit) {
            $query = $query.' LIMIT '.$this->limit;
        }

        if ($this->offset) {
            $query = $query.' OFFSET '.$this->offset;
        }

        return $query;
    }

    private function createLogs($query) : void
    {
        if($this->shouldLog()){
            $fp = fopen('query.log', 'a+');
            fwrite($fp, '['.date('Y-m-d H:i:s').'] ('.$query.')'.PHP_EOL);
            fclose($fp);
        }
    }
}
