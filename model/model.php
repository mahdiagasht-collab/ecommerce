<?php
class model extends mainDB{
    private $base = '';
    private $where = '';
    private $limit = '';
    private $from = '';
    private $join = '';
    private $on = '';
    private $sort = '';
    private $type = '';

    
    private $case = '';
    private $valueInELSEInCase = '';
    private $locationCase = '';



    private static function getReturnedOBJ(){
        return static::$returnedMysqlOBJ;
    }
    protected static function makeOBJ(){
        if (static::$OBJ === null) {
            echo '👌';
            return static::$OBJ = new static;
        }
        return static::$OBJ;
    }

    
    public static function select(array $fields=['*']){
        (static::makeOBJ()) -> base = 'SELECT ' . implode(',' , $fields);
        return static::$OBJ;
    }
    public static function find($id){
        static::makeOBJ();
        return static::$connection -> query('SELECT * FROM ' . static::class . ' WHERE id = ' . $id);
    }
    public function delete(){
        (static::makeOBJ()) -> base = "DELETE ";
        return static::$OBJ;
    }
    public static function update(array $data){
        (static::makeOBJ()) -> type = 'update';
        $TableValues = '';
        foreach ($data as $key => $value) {
            if ($TableValues != '') { $TableValues .= ' , ';}
            $TableValues .= $key . " = '" . $value . "' ";
        }
        (static::makeOBJ()) -> base = 'UPDATE '. static::$table . ' SET ' . $TableValues;
        return static::$OBJ;
    }
    public static function create(array $data){
        (static::makeOBJ()) -> type = 'update';
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
    public static function createOrUpdate(array $data){
        if (static::all() -> num_rows == 1){
            return static::update($data);
        } else {
            return static::create($data);
        }
    }
    



    public static function all(array $fields=['*']){
        return self::select($fields) -> from() -> get();
    }
    public static function count(){
        return static::makeOBJ() -> get(['count(*)']) -> fetch_assoc()['count(*)'];
    }
    public static function frist(){
        return static::makeOBJ() -> select() -> limit([1]) -> get();
    }

    public static function sort(array $data = []){
        (static::makeOBJ()) -> sort = ' ORDER BY ' . $data['columnInQuestion'] . ' ' . $data['sortingType'];
        return static::$OBJ;
    }


    
    
    

    
    
    public static function from(array $tables = []){
        if ($tables == []) {
            (static::makeOBJ()) -> from = ' FROM ' . static::$table;
        }else {
            (static::makeOBJ()) -> from = ' FROM ' . implode(',' , $tables);
        }
        return static::$OBJ;
    }
    
    
    public function belongsTo(string $tableName){
        $this -> join = ' INNER JOIN ' . $tableName;
        $this -> where();
        return static::$OBJ;
    }
    protected function connectInBase(array $fields){
        
        $this -> base .= ',' . implode(',' , $fields);
        return static::$OBJ;
    }
    
    
    
    
    
    
    
    
    
    public static function with(){
        (static::makeOBJ());
        if (static::$table == 'category') { $tableName = 'product'; } elseif (static::$table == 'product') { $tableName = 'category'; }
        static::$subQuery = $tableName::makeOBJ() -> getSQL('categoryProductCount');
        return static::$OBJ;
    }
    
    
    
    public static function withProductCount(){
        (static::makeOBJ());
        if (static::$table == 'category') {
            $tableName = 'product';
        } elseif (static::$table == 'product') {
            $tableName = 'category';
        }
        static::$subQuery = $tableName::select(['count(*) ']) -> where(static::$related) -> getSQL('categoryProductCount');
        // return (static::makeOBJ()) -> get();
        return static::$OBJ;
    }
    
    protected function getSQL(string $alies){
        if ($this -> base == '') { $this -> select(['count(*) count']); }
        if ($this -> from == '') { $this -> from(); } 
        if ($this -> join == '') { $this -> on = ''; } else { 
            $this -> where = '';
            if ($this -> on == '') { $this -> where(); }
        }
        
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





    
    
    
    public static function case(string $colomnInQuestion , string $ifType , string $valueInQuestion , string $printValue , string $valueInELSE = ''){
        (static::makeOBJ()) -> case .= ' CASE WHEN ' . $colomnInQuestion . ' ' . $ifType . ' ' . $valueInQuestion . ' THEN ' . " '" . $printValue . "' ";
        if ($valueInELSE != '') {
            static::$OBJ -> caseELSE($valueInELSE);
        }
        return static::$OBJ;
    }
    public function caseELSEAndENDAndAlies(string $valueInELSE , string $alies){
        (static::makeOBJ()) -> valueInELSEInCase = 'ELSE ' . $valueInELSE . ' END ' . $alies;
        return static::$OBJ;
    }
    public function locationCase(string $location){
        $this -> locationCase = $location;
        return static::$OBJ;
    }









    public static function where(array $requiredValues = []){
        
        
        if ($requiredValues == []) {
            $columnName = static::$related[0];
            $columnValue = static::$related[1];
        } else {
            if ($requiredValues[0] == '') {
                $columnName = static::$table . '_id';
            }else {
                $columnName = $requiredValues[0];
            }
            $columnValue = $requiredValues[1];
        }



        if ((static::makeOBJ()) -> join == ''){
            if ((static::makeOBJ()) -> where == '') {
                (static::makeOBJ()) -> where = ' WHERE '. $columnName . ' = ' . $columnValue;
            }else {
                (static::makeOBJ()) -> where .= ' AND '. $columnName . ' = ' . $columnValue;
            }
        }else {
            if ((static::makeOBJ()) -> on == '') {
                (static::makeOBJ()) -> on = ' ON '. $columnName . ' = ' . $columnValue;
            }else {
                (static::makeOBJ()) -> on .= ' AND '. $columnName . ' = ' . $columnValue;
            }
        }
        return static::$OBJ;
    }
    public static function limit(array $data){
        // var_dump($data);
        if (count($data) == 1) { 
            $limit = $data[0];
            $ofset = 10;
        }else {
            if ($data[0] < $data[1]) {
                $limit = $data[0];
                // echo '😤';
                $ofset = $data[1] - $data[0];

            }else{
                $limit = $data[1];
                $ofset = $data[0] - $data[1];

            }
        }
        (static::makeOBJ()) -> limit = ' LIMIT ' . $limit . ' , ' . $ofset;
        return static::$OBJ;
    }














    public function get(array $fields = ['*']){
        if ($this -> base == '') { $this -> select($fields); }
        if ($this -> type == '') {
            if ($this -> from == '') { $this -> from(); } 
            if ($this -> join == '') { $this -> on = ''; } else { 
                $this -> where = '';
                if ($this -> on == '') { $this -> where(); }
            }
        }
        
        if ($this -> locationCase == 'base') {
            $this -> base .= ',' . $this -> case . ' ' . $this -> valueInELSEInCase ; 
        } elseif ($this -> locationCase == 'where') {
            $this -> where .= ',' . $this -> case . ' ' . $this -> valueInELSEInCase ; 
        }
        
        $base =     $this -> base;
        $from =     $this -> from;
        $join =     $this -> join;
        $on =       $this -> on;
        $where =    $this -> where;
        $limit =    $this -> limit;
        $sort =     $this -> sort;
        $subQuery = static::$subQuery;
        
        $this -> base = '';
        $this -> from = '';
        $this -> join = '';
        $this -> on = '';
        $this -> where = '';
        $this -> limit = '';
        $this -> sort = '';
        static::$subQuery = '';

        return static::$returnedMysqlOBJ = $this -> sendQuery($base . $subQuery . $from . $join . $sort . $on . $where . $limit);
    }   
}