<?php
class model extends facade{
    private $textQuery =            null;
    private $base =                 null;
    private $where =                null;
    private $from =                 null;
    private $join =                 null;
    // ifs ----------------------------------------
    private $case =                 null;
    private $valueInELSEInCase =    null;
    private $if =                   null;    
    private $ifNull =               null;
    private $coalesce =             null;
    private $coalesceAlies =        null;
    private $location =             null;
    // --------------------------------------------
    private $limit =                null;
    private $on =                   null;
    private $sort =                 null;
    private $type =                 null;
    private $subQuery =             null;
    private $groupBy =              null;    
    private $having =               null;    
    private $withAlies =            null;



    protected function getReturnedOBJ(){
        return $this -> returnedMysqlOBJ;
    }
    // protected function makeOBJ(){
    //     return factory::factory(static::class);
    // }

    
    protected function select(array $colomnInQuestion){//$fields=['*']
        if ($colomnInQuestion == []) {$colomnInQuestion = [['*']];}
        $this -> base = 'SELECT ' . implode(',' , $colomnInQuestion[0]);
        return $this;
    }
    protected function find(array $colomnInQuestion){//$id
        // $this;
        return $this -> connection -> query('SELECT * FROM ' . static::class . ' WHERE id = ' . $colomnInQuestion[0]);
    }
    protected function delete(array $colomnInQuestion){
        $this -> base = "DELETE ";
        return $this;
    }
    protected function update(array $colomnInQuestion){//array $data
        $this -> type = 'update';
        $TableValues = '';
        foreach ($colomnInQuestion[0] as $key => $value) {
            if ($TableValues != '') { $TableValues .= ' , ';}
            $TableValues .= $key . " = '" . $value . "' ";
        }
        $this -> base = 'UPDATE '. $this -> table . ' SET ' . $TableValues;
        return $this;
    }
    protected function create(array $colomnInQuestion){//data
        $this -> type = 'update';
        $columnName = '';
        $columnValues = '';
        foreach ($colomnInQuestion[0] as $key => $value) {
            if (!$columnName     == '') { $columnName    .= ' , ';}
            if (!$columnValues   == '') { $columnValues  .= ' , ';}
            $columnName .= $key;
            $columnValues .= " '" . $value . "' ";
        }
        $this -> base = 'INSERT INTO '. $this -> table . ' ( ' . $columnName . ' ) VALUES (' . $columnValues . ' ) ';
        return $this;
    }
    protected function createOrUpdate(array $colomnInQuestion){//data
        if (!$this -> all([]) -> num_rows == 1){
            return $this -> update($colomnInQuestion[0]);
        } else {
            return $this -> create($colomnInQuestion[0]);
        }
    }
    protected function all(array $colomnInQuestion){//fields=['*']
        if ($colomnInQuestion == []) {$colomnInQuestion = [['*']];}
        return $this -> select([$colomnInQuestion[0]]) -> from([]) -> getSQL() -> get([]);
    }
    protected function count(array $colomnInQuestion){
        return $this -> connection -> query("SELECT count(*) FROM " . static::class) -> fetch_assoc()['count(*)'];
        // return $this ->  getSQL() -> get(['count(*)']) -> fetch_assoc()['count(*)'];
    }
    protected function frist(array $colomnInQuestion){
        return $this -> connection -> query("SELECT * FROM " . static::class . " LIMIT 1") -> fetch_assoc();
        // return $this -> select() -> limit([1]) -> getSQL() -> get();
    }

    protected function sort(array $colomnInQuestion){//$data = []
        $this -> sort = ' ORDER BY ' . $colomnInQuestion[0]['columnInQuestion'] . ' ' . $colomnInQuestion[0]['sortingType'];
        return $this;
    }

    protected function from(array $colomnInQuestion){//array $tables = []
        if ($colomnInQuestion == []) {
            $this -> from = ' FROM ' . $this -> table;
        }else {
            $this -> from = ' FROM ' . implode(',' , $colomnInQuestion[0]);
        }
        return $this;
    }
    
    
    protected function belongsTo(array $colomnInQuestion){//string $typeJoin , string $tableName
        $this -> join = $colomnInQuestion[0] . ' JOIN ' . $colomnInQuestion[1];
        $this -> where([]);
        return $this;
    }
    
    
    protected function with(array $colomnInQuestion){//string $tableName , array $fields , array $whereRequest 
        // مسئولیت این متد ایجاد ساب کوئری با سینتگز عمومی است
        $this -> withAlies = 'categoryProductCount';
        // این پراپرتی رو برای متد هَوینگ نوشتم
        $this -> $subQuery = ($this ->$colomnInQuestion[0])
        ->  select([$colomnInQuestion[1]])
            // چرا سلکت رو اینجا کال کردم چون هر ساب کوئری ای دستورش باید یک فیلدز را برگرداند نه بیشتر از یکی رو
        ->  where([$colomnInQuestion[2]])
            // چرا اینجا من وئر رو کال کردم چون همواره ساب کوئری یک مقدار میتواند برگرداند نه چند مقدار
        ->  getSQLWith('categoryProductCount');
            // چرا من گئت اسکیواِل رو کال کردم چون در اونجا پراپرتی های این آبجکت رو به هم کانکت میکنه و برمیگردونه
        return $this;
    }
    
    protected function withProductCount(array $colomnInQuestion){//string $tableName
        $this -> withAlies = 'categoryProductCount';
        $this -> subQuery = (new product) 
        ->  select([['count(*) ']]) 
        ->  where([]) 
        ->  getSQLWith(['categoryProductCount']);
        // return $this -> get();
        return $this;
    }
    
    protected function getSQLWith(array $colomnInQuestion){//string $alies
        if (!$this -> base) { $this -> select([['count(*) count']]); }
        if (!$this -> from) { $this -> from([]); } 
        if (!$this -> join) { $this -> on = null; } else { 
            $this -> where = null;
            if ($this -> on) { $this -> where([]); }
        }
        
        $base =     $this -> base;
        $from =     $this -> from;
        $where =    $this -> where;
        $limit =    $this -> limit;
        
        $this -> base =      '';
        $this -> from =      '';
        $this -> where =     '';
        $this -> limit =     '';

        // $this -> having = $colomnInQuestion[0];

        return ' , ( ' . $base . $from . $where . $limit . ' ) ' . $colomnInQuestion[0];
    }


    protected function case(array $colomnInQuestion){//string $colomnInQuestion , string $ifType , string $valueInQuestion , string $printValue
        if (!$this -> if) {
            $this -> case = ' CASE WHEN ' . $colomnInQuestion[0] . ' ' . $ifType[1] . ' ' . $colomnInQuestion[2] . ' THEN ' . " '" . $colomnInQuestion[3] . "' ";
        } else {
            $this -> case .= ' WHEN ' . $colomnInQuestion[0] . ' ' . $ifType[1] . ' ' . $colomnInQuestion[2] . ' THEN ' . " '" . $colomnInQuestion[3] . "' ";

        }
        return $this;
    }
    protected function caseELSEAndENDAndAlies(array $colomnInQuestion){//string $valueInELSE , string $alies
        $this -> valueInELSEInCase = 'ELSE ' . $colomnInQuestion[0] . ' END ' . $colomnInQuestion[1];
        return $this;
    }
    // ----------------------------------------
    protected function if(array $colomnInQuestion){//string $colomnInQuestion , string $ifType , string $valueInQuestion , string $printValue , string $valueIsIfNull = '' , string $alies
        $this -> if = 'IF ( ' . $colomnInQuestion[0] . ' ' . $colomnInQuestion[1] . ' ' . $colomnInQuestion[2] . ' , ' . " '" . $colomnInQuestion[3] . "' , " . $colomnInQuestion[4] . " ) " . $colomnInQuestion[5];
        return $this;
    }
    // ----------------------------------------
    protected function ifNull(array $colomnInQuestion){//string $colomnInQuestion , string $ifType , string $valueInQuestion , string $printValue , string $alies
        $this -> ifNull = 'IFNULL ( ' . $colomnInQuestion[0] . ' ' . $colomnInQuestion[1] . ' ' . $colomnInQuestion[2] . ' , ' . " '" . $colomnInQuestion[3] . "' ) " . $colomnInQuestion[4];
        return $this;
    }
    // ----------------------------------------
    protected function coalesce(array $colomnInQuestion){//string $colomnInQuestion
        if (!$this -> coalesce) {
            $this -> coalesce = 'COALESCE ( ' . $colomnInQuestion[0];
        } else {
            $this -> coalesce .= ' , ' . $colomnInQuestion[0];
        }
        return $this;
    }
    protected function coalesceAlies(array $colomnInQuestion){//string $alies
        $this -> coalesceAlies = ' ) ' . $colomnInQuestion[0];
        return $this;
    }
    // ----------------------------------------
    protected function location(array $colomnInQuestion){//string $location
        $this -> location = $colomnInQuestion[0];
        return $this;
    }


    protected function groupBy(array $colomnInQuestion){//string $colomnInQuestion
        $this -> groupBy = ' GROUP BY ' . $colomnInQuestion[0] ;

        return $this;
    }


    protected function where(array $colomnInQuestion){//array $requiredValues = []
        if (!isset($colomnInQuestion[0])) {
            $columnName = $this -> related[0];
            $columnValue = $this -> related[1];
        } else {
            if ($colomnInQuestion[0][0] == '') {
                $columnName = $this -> table . '_id';
            }else {
                $columnName = $colomnInQuestion[0][0];
            }
            $columnValue = $colomnInQuestion[0][1];
        }

        
        if ($columnName == $this -> having || $columnValue == $this -> having) { $this -> having($colomnInQuestion); }
        if ($this -> join){ $this -> on($colomnInQuestion); } else {
            if (!$this -> where) {
                $this -> where = ' WHERE '. $columnName . ' = ' . $columnValue;
            }else {
                $this -> where .= ' AND '. $columnName . ' = ' . $columnValue;
            }
        }
        return $this;
    }
    public function on(array $colomnInQuestion){


        if (!isset($colomnInQuestion[0])) {
            $columnName = $this -> related[0];
            $columnValue = $this -> related[1];
        } else {
            if ($colomnInQuestion[0][0] == '') {
                $columnName = $this -> table . '_id';
            }else {
                $columnName = $colomnInQuestion[0][0];
            }
            $columnValue = $colomnInQuestion[0][1];
        }


        if (!$this -> on) {
            $this -> on = ' ON '. $columnName . ' = ' . $columnValue;
        }else {
            $this -> on .= ' AND '. $columnName . ' = ' . $columnValue;
        }
    }
    public function having(array $colomnInQuestion){


        if (!isset($colomnInQuestion[0])) {
            $columnName = $this -> related[0];
            $columnValue = $this -> related[1];
        } else {
            if ($colomnInQuestion[0][0] == '') {
                $columnName = $this -> table . '_id';
            }else {
                $columnName = $colomnInQuestion[0][0];
            }
            $columnValue = $colomnInQuestion[0][1];
        }


        if (!$this -> where){
            $this -> having = ' HAVING '. $columnName . ' = ' . $columnValue;
        } else {
            $this -> having .= ' AND '. $columnName . ' = ' . $columnValue;
        }
    }
    protected function formHaving(array $colomnInQuestion){//string $textQuestion
        if ($colomnInQuestion[0] == 'having') {
            $this -> having = ' HAVING ' . $this -> withAlies . ' > ' . '0';
        } elseif ($colomnInQuestion[0] == 'notHaving') {
            $this -> having = ' HAVING ' . $this -> withAlies . ' = ' . '0';
        }
        return $this;
    }


    protected function limit(array $colomnInQuestion){//array $data
        if (count($colomnInQuestion[0]) == 1) { 
            $limit = $colomnInQuestion[0][0];
            $ofset = 10;
        }else {
            if ($colomnInQuestion[0][0] < $colomnInQuestion[0][1]) {
                $limit = $colomnInQuestion[0][0];
                $ofset = $colomnInQuestion[0][1] - $colomnInQuestion[0][0];

            }else{
                $limit = $colomnInQuestion[0][1];
                $ofset = $colomnInQuestion[0][0] - $colomnInQuestion[0][1];

            }
        }
        $this -> limit = ' LIMIT ' . $limit . ' , ' . $ofset;
        return $this;
    }










    protected function queryCommandCompletion(array $colomnInQuestion){
        if (!$this -> base) { 
             $this -> select([$colomnInQuestion[0]]); 
        }
        // ---------------------------------------------------
        if (!$this -> type) {
            if (!$this -> from) { $this -> from([]); } 
            if (!$this -> join) { 
                $this -> on = null; 
            } else { 
                $this -> where = null;
                if (!$this -> on) { $this -> where([]); }
            }
        }
        // ---------------------------------------------------
        if($this -> case){
            if ($this -> location == 'base') {
                $this -> base   .= ',' . $this -> case . ' ' . $this -> valueInELSEInCase ; 
            } elseif (!$this -> location == 'where') {
                $this -> where  .= ',' . $this -> case . ' ' . $this -> valueInELSEInCase ; 
            }
        } elseif ($this -> if) {
            if ($this -> location == 'base') {
                $this -> base   .= ',' . $this -> if; 
            } elseif (!$this -> location == 'where') {
                $this -> where  .= ',' . $this -> if; 
            }
        } elseif ($this -> ifNull) {
            if ($this -> location == 'base') {
                $this -> base   .= ',' . $this -> ifNull; 
            } elseif (!$this -> location == 'where') {
                $this -> where  .= ',' . $this -> ifNull; 
            }
        } elseif ($this -> coalesce) {
            if ($this -> location == 'base') {
                $this -> base   .= ',' . $this -> coalesce . $this -> coalesceAlies; 
            } elseif (!$this -> location == 'where') {
                $this -> where  .= ',' . $this -> coalesce . $this -> coalesceAlies; 
            }
        }
    }

    protected function getSQL(array $colomnInQuestion = [['*']]){//array $fields = ['*']
        $this ->queryCommandCompletion($colomnInQuestion);
        $this -> textQuery = 
            $this -> base 
        .   $this -> subQuery 
        .   $this -> from 
        .   $this -> join 
        .   $this -> on 
        .   $this -> where 
        .   $this -> having 
        .   $this -> limit 
        .   $this -> sort 
        .   $this -> groupBy;
        
        return $this;
    }

    protected function get(array $colomnInQuestion){
        $this -> getSQL();
        // $this -> returnedMysqlOBJ = $this -> sendQuery($this -> textQuery);
        return $this -> fetchAssoc($this -> sendQuery($this -> textQuery));

    }
    protected function fetchAssoc(mysqli_result $obj):array {
        $num = 0;
        foreach ($obj as $value) { $rowsArray[$num] = $value; $num += 1; }
        return $rowsArray;
    }
}