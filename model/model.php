<?php
class model extends mainDB{
    private $base = '';
    private $where = '';
    private $limit = '';
    private $from = '';
    private $join = '';
    private $on = '';



    // private static function getReturnedOBJ(){
    //     return static::$returnedMysqlOBJ;
    // }
    private static function makeOBJ(){
        if (static::$OBJ === null) {
            echo '👌';
            return static::$OBJ = new static;
        }
        return static::$OBJ;
    }

    
    // public static function select(array $fields=['*']){
    //     (static::makeOBJ()) -> base = 'SELECT ' . implode(',' , $fields);
    //     return static::$OBJ;
    // }
    public static function select(array $fields = ['*']){
        if ($fields == ['*']) {
            var_dump($fields);
            echo '😤';
            (static::makeOBJ()) -> base = 'SELECT ' . implode(',' , static::$fields);
        } else {
            echo '😤😤';
            (static::makeOBJ()) -> base = 'SELECT ' . implode(',' , $fields);
        }
        // if ($fields == ['*']) {
        //     $fields = static::$fields;
        // }
        return static::$OBJ;
    }
    public static function find($id){
        return static::$connection -> query('SELECT * FROM ' . static::class . 'WHERE id = ' . $id);
    }
    public function delete(){
        (static::makeOBJ()) -> base = "DELETE FROM ". static::$table;
        return static::$OBJ;
    }
    public function update(array $data){
        $TableValues = '';
        foreach ($data as $key => $value) {
            if ($TableValues != '') { $TableValues .= ' , ';}
            $TableValues .= $key . " = '" . $value . "' ";
        }
        (static::makeOBJ()) -> base = 'UPDATE '. static::$table . ' SET ' . $TableValues;
        return static::$OBJ;
    }
    public static function create(array $data){
        $columnName = '';
        $columnValues = '';
        foreach ($data as $key => $value) {
            if (!$columnName     == '') { $columnName    .= ' , ';}
            if (!$columnValues   == '') { $columnValues  .= ' , ';}
            $columnName .= $key;
            $columnValues .= " '" . $value . "' ";
        }
        (static::makeOBJ()) -> base = 'INSERT INTO '. static::$table . ' ( ' . $columnName . ' ) VALUES (' . $columnValues . ' ) ';
        return static::$OBJ;
    }
    



    public static function all(array $fields=['*']){
        return self::select($fields) -> get();
    }
    public static function count(){
        return static::makeOBJ() -> get(['count(*)']) -> fetch_assoc()['count(*)'];
    }
    public static function frist(){
        return static::makeOBJ() -> select() -> limit([1]) -> get();
    }

    public static function pageInItPrice(array $data = []){
        $result =  static::$returnedMysqlOBJ;
        $prices[0] = $result -> fetch_assoc();
        var_dump($data);
        if ($data['columnInQuestion'] == '' && $data['sortingType' == '']) {
            $a = [];
            for ($i=1; $i < $result -> num_rows; $i++) { 
                $prices[$i] = $result -> fetch_assoc();
                $b = $i;
                for ($c=1; $c < count($prices); $c++) { 
                    if ($prices[$b - 1]['price'] > $prices[$b]['price']) {
                        $a = $prices[$b];
                        $prices[$b] = $prices[$b - 1];
                        $prices[$b - 1] = $a;
                        $b--;
                    }
                }
            }
        }else {
            $columnInQuestion = $data['columnInQuestion'];
            $sortingType = $data['sortingType'];
            if ($sortingType == 'decs') {
                $a = [];
                for ($i=1; $i < $result -> num_rows; $i++) { 
                    $prices[$i] = $result -> fetch_assoc();
                    $b = $i;
                    for ($c=1; $c < count($prices); $c++) { 
                        if ($prices[$b - 1][$columnInQuestion] < $prices[$b][$columnInQuestion]) {
                            $a = $prices[$b];
                            $prices[$b] = $prices[$b - 1];
                            $prices[$b - 1] = $a;
                            $b--;
                        }
                    }
                }
            }else {
                $a = [];
                for ($i=1; $i < $result -> num_rows; $i++) { 
                    $prices[$i] = $result -> fetch_assoc();
                    $b = $i;
                    for ($c=1; $c < count($prices); $c++) { 
                        if ($prices[$b - 1][$columnInQuestion] > $prices[$b][$columnInQuestion]) {
                            $a = $prices[$b];
                            $prices[$b] = $prices[$b - 1];
                            $prices[$b - 1] = $a;
                            $b--;
                        }
                    }
                }
            }
        }
        return $prices;
    }


    public static function sort($column , $sortingType){
        
        $result =  static::getReturnedOBJ();
        $prices[0] = $result -> fetch_assoc();
        // var_dump($prices);
        $a = [];
        for ($i=1; $i < $result -> num_rows; $i++) { 
            $prices[$i] = $result -> fetch_assoc();
            $b = $i;
            for ($c=1; $c < count($prices); $c++) { 
                if ($sortingType == 'decs') {
                    // $sortingType = '<';
                    if ($prices[$b - 1]['price'] < $prices[$b]['price']) {
                        $a = $prices[$b];
                        $prices[$b] = $prices[$b - 1];
                        $prices[$b - 1] = $a;
                        $b--;
                    }
                }else {
                    // $sortingType = '>';
                    if ($prices[$b - 1]['price'] > $prices[$b]['price']) {
                        $a = $prices[$b];
                        $prices[$b] = $prices[$b - 1];
                        $prices[$b - 1] = $a;
                        $b--;
                    }
                }
            }
        }
        // var_dump($prices);
        return $prices;
    }
    private function selectWithinSelect(array $internalSelectValues){
        // for ($i=0; $i < count($internalSelectValues); $i++) { 
        //     $internalSelectValues[$i];
        // }
        $tableName = $internalSelectValues[0];
        $columns = $internalSelectValues[1];
        $valueForWhere = $internalSelectValues[2];
        $aluse = $internalSelectValues[3];
        
        $newFields = '';
        foreach ($columns as $key => $value) {
            if ($newFields != '') { $newFields .= ' , ';}
            if (is_string($value)) {
                $newFields .= $value;
            }else {
                $newFields .= $this -> selectWithinSelect($value);
            }
        }

        return ' ( ' . 'SELECT' . implode(' , ' , $columns) . 'FROM' . $tableName . $this -> makeWhereInColumn($valueForWhere) . ' ) ' . $aluse;
    }
    private function makeWhereInColumn(array $valueForWhere){
        return ' WHERE '. $valueForWhere[0] . ' = ' . $valueForWhere[1];
    }





    
    public static function from(array $tables = []){
        if ($tables == []) {
            (static::makeOBJ()) -> from = ' FROM ' . static::$table;
        }else {
            (static::makeOBJ()) -> from = ' FROM ' . implode(',' , $tables);
        }
        return static::$OBJ;
    }


    public static function join(array $requestJoin){
        (static::makeOBJ()) -> join = $requestJoin['typeJoin'] . ' JOIN ' . $requestJoin['tableName'];
        return static::$OBJ;
    }
    public static function on(array $requiredValues = []){
        if ($requiredValues == []) {
            $columnName = static::$related[0];
            $columnValue = static::$related[1];
        }else {
            if ($requiredValues[0] == '') { $columnName = 'id'; }else { $columnName = $requiredValues[0]; }
            $columnValue = $requiredValues[1];
        }

        if ((static::makeOBJ()) -> on == '') {
            (static::makeOBJ()) -> on = ' ON '. $columnName . ' = ' . $columnValue;
        }else {
            (static::makeOBJ()) -> on .= ' AND '. $columnName . ' = ' . $columnValue;
        }
        return static::$OBJ;

    }
    









    
    public static function with(array $requiredValuesForSubqueryRequest , $alies){
        foreach ($requiredValuesForSubqueryRequest as $tableName => $fields) {
            static::$subQuery = $tableName::select($fields) -> where(static::$related) -> getSQL($alies);
        }
        return (static::makeOBJ()) -> get();
    }
    private function getSQL(string $alies){
        if ($this -> from == '') { $this -> from(); }
        if ($this -> base == '') { $this -> select('count(*) count'); }
        
        $base =     $this -> base;
        $from =     $this -> from;
        $where =    $this -> where;
        $limit =    $this -> limit;

        $this -> base =      '';
        $this -> from =      '';
        $this -> where =     '';
        $this -> limit =     '';

        return ' , ( ' . $base . $from . $where . $limit . ' ) ' . $alies;
    }






    
    public static function where(array $requiredValues = []){
        // foreach ($requiredValues as $key => $value) {
        //     $columnName = $key;
        //     $columnValue = $value;
        // }
        // var_dump($requiredValues);
        if ($requiredValues[0] == '') {
            $columnName = 'id';
        }else {
            $columnName = $requiredValues[0];
        }
        $columnValue = $requiredValues[1];
        if ((static::makeOBJ()) -> where == '') {
            (static::makeOBJ()) -> where = ' WHERE '. $columnName . ' = ' . $columnValue;
        }else {
            (static::makeOBJ()) -> where .= ' AND '. $columnName . ' = ' . $columnValue;
        }
        return static::$OBJ;
    }
    public static function limit(array $data){
        // var_dump($data);
        if (count($data) == 1) {
            $limit = $data[0];
            $ofset = '';
        }else {
            if ($data[0] < $data[1]) {
                $limit = $data[0];
                // echo '😤';
                $ofset = ' , ' . $data[1] - ($data[0] + 1) + 1;

            }else{
                $limit = $data[1];
                $ofset = ' , ' . $data[0] - ($data[1] + 1) + 1;
            }
        }
        (static::makeOBJ()) -> limit = ' LIMIT ' . $limit . $ofset;
        return static::$OBJ;
    }














    public function get(array $fields = ['*']){
        if ($this -> base == '') { $this -> select($fields); }
        if ($this -> from == '') { $this -> from(); }
        if ($this -> join == '') { $this -> on = ''; } else { 
            $this -> where = '';
            if ($this -> on == '') { $this -> on(); }
        }
        
        $where =    $this -> where;
        $limit =    $this -> limit;
        $base =     $this -> base;
        $from =     $this -> from;
        $join =     $this -> join;
        $on =       $this -> on;
        $subQuery = static::$subQuery;
        
        // echo ($this -> base . $where . $limit);
        $this -> where = '';
        $this -> limit = '';
        $this -> base = '';
        $this -> from = '';
        $this -> join = '';
        $this -> on = '';
        static::$subQuery = '';

        return static::$returnedMysqlOBJ = $this -> sendQuery($base . $subQuery . $from . $join . $on . $where . $limit);
    }
}