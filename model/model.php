<?php
class model extends mainDB{
    private $textQuery = '';

    private $base = '';
    private $where = '';
    private $limit = '';
    private $from = '';
    private $join = '';
    private $on = '';
    private $sort = '';
    private $type = '';

    
    private $if = '';
    private $valueInELSEInCase = '';
    private $location = '';

    private $groupBy = '';
    
    private $having = '';
    
    private $withAlies = '';



    private static function getReturnedOBJ(){
        return static::$returnedMysqlOBJ;
    }
    protected static function makeOBJ(){
        return factory::factory(static::class);
    }

    
    public static function select(array $fields=['*']){
        static::makeOBJ() -> base = 'SELECT ' . implode(',' , $fields);
        return static::makeOBJ();
    }
    public static function find($id){
        static::makeOBJ();
        return static::$connection -> query('SELECT * FROM ' . static::class . ' WHERE id = ' . $id);
    }
    public function delete(){
        static::makeOBJ() -> base = "DELETE ";
        return static::makeOBJ();
    }
    public static function update(array $data){
        static::makeOBJ() -> type = 'update';
        $TableValues = '';
        foreach ($data as $key => $value) {
            if ($TableValues != '') { $TableValues .= ' , ';}
            $TableValues .= $key . " = '" . $value . "' ";
        }
        static::makeOBJ() -> base = 'UPDATE '. static::$table . ' SET ' . $TableValues;
        return static::makeOBJ();
    }
    public static function create(array $data){
        static::makeOBJ() -> type = 'update';
        $columnName = '';
        $columnValues = '';
        foreach ($data as $key => $value) {
            if (!$columnName     == '') { $columnName    .= ' , ';}
            if (!$columnValues   == '') { $columnValues  .= ' , ';}
            $columnName .= $key;
            $columnValues .= " '" . $value . "' ";
        }
        static::makeOBJ() -> base = 'INSERT INTO '. static::$table . ' ( ' . $columnName . ' ) VALUES (' . $columnValues . ' ) ';
        return static::makeOBJ();
    }
    public static function createOrUpdate(array $data){
        if (static::all() -> num_rows == 1){
            return static::update($data);
        } else {
            return static::create($data);
        }
    }
    



    public static function all(array $fields=['*']){
        return static::select($fields) -> from() -> getSQL() -> get();
    }
    public static function count(){
        return static::makeOBJ() ->  getSQL() -> get(['count(*)']) -> fetch_assoc()['count(*)'];
    }
    public static function frist(){
        return static::makeOBJ() -> select() -> limit([1]) -> getSQL() -> get();
    }

    public static function sort(array $data = []){
        static::makeOBJ() -> sort = ' ORDER BY ' . $data['columnInQuestion'] . ' ' . $data['sortingType'];
        return static::makeOBJ();
    }


    
    
    

    
    
    public static function from(array $tables = []){
        if ($tables == []) {
            static::makeOBJ() -> from = ' FROM ' . static::$table;
        }else {
            static::makeOBJ() -> from = ' FROM ' . implode(',' , $tables);
        }
        return static::makeOBJ();
    }
    
    
    public function belongsTo(string $typeJoin , string $tableName){
        $this -> join = $typeJoin . ' JOIN ' . $tableName;
        $this -> where();
        return static::makeOBJ();
    }
    protected function connectInBase(array $fields){
        
        $this -> base .= ',' . implode(',' , $fields);
        return static::makeOBJ();
    }
    
    
    
    
    
    
    
    
    
    public static function with(string $tableName , array $fields , array $whereRequest){ // مسئولیت این متد ایجاد ساب کوئری با سینتگز عمومی است
        (static::makeOBJ()) -> withAlies = 'categoryProductCount';
        // این پراپرتی رو برای متد هَوینگ نوشتم
        static::$subQuery = $tableName::
            select($fields)
            // چرا سلکت رو اینجا کال کردم چون هر ساب کوئری ای دستورش باید یک فیلدز را برگرداند نه بیشتر از یکی رو
        ->  where($whereRequest)
            // چرا اینجا من وئر رو کال کردم چون همواره ساب کوئری یک مقدار میتواند برگرداند نه چند مقدار
        ->  getSQLWith('categoryProductCount');
            // چرا من گئت اسکیواِل رو کال کردم چون در اونجا پراپرتی های این آبجکت رو به هم کانکت میکنه و برمیگردونه
        return static::makeOBJ();
    }
    
    
    
    public static function withProductCount(string $tableName){
        (static::makeOBJ()) -> withAlies = 'categoryProductCount';
        static::$subQuery = $tableName::
            select(['count(*) ']) 
        ->  where(static::$related) 
        ->  getSQLWith('categoryProductCount');
        // return static::makeOBJ() -> get();
        return static::makeOBJ();
    }
    
    protected function getSQLWith(string $alies){
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

        $this -> having = $alies;

        return ' , ( ' . $base . $from . $where . $limit . ' ) ' . $alies;
    }





    
    
    
    public static function case(string $colomnInQuestion , string $ifType , string $valueInQuestion , string $printValue){
        // echo static::class;
        // var_dump(static::makeOBJ());
        // die();   
        if (static::makeOBJ() -> if == '') {
            static::makeOBJ() -> if .= ' CASE WHEN ' . $colomnInQuestion . ' ' . $ifType . ' ' . $valueInQuestion . ' THEN ' . " '" . $printValue . "' ";
        } else {
            static::makeOBJ() -> if .= ' WHEN ' . $colomnInQuestion . ' ' . $ifType . ' ' . $valueInQuestion . ' THEN ' . " '" . $printValue . "' ";

        }
        return static::makeOBJ();
    }
    public function caseELSEAndENDAndAlies(string $valueInELSE , string $alies){
        static::makeOBJ() -> valueInELSEInCase = 'ELSE ' . $valueInELSE . ' END ' . $alies;
        return static::makeOBJ();
    }
    // ----------------------------------------
    public static function if(string $colomnInQuestion , string $ifType , string $valueInQuestion , string $printValue , string $valueIsIfNull = '' , string $alies){
        static::makeOBJ() -> if .= 'IF ( ' . $colomnInQuestion . ' ' . $ifType . ' ' . $valueInQuestion . ' , ' . " '" . $printValue . "' , " . $valueIsIfNull . " ) " . $alies;
        return static::makeOBJ();
    }
    // ----------------------------------------
    public static function ifNull(string $colomnInQuestion , string $ifType , string $valueInQuestion , string $printValue , string $alies){
        static::makeOBJ() -> if .= 'IFNULL ( ' . $colomnInQuestion . ' ' . $ifType . ' ' . $valueInQuestion . ' , ' . " '" . $printValue . "' ) " . $alies;
        return static::makeOBJ();
    }
    // ----------------------------------------
    public static function coalesce(string $colomnInQuestion){
        if (static::makeOBJ() -> if == '') {
            static::makeOBJ() -> if .= 'COALESCE ( ' . $colomnInQuestion;
        } else {
            static::makeOBJ() -> if .= ' , ' . $colomnInQuestion;
        }
        return static::makeOBJ();
    }
    public function coalesceAlies(string $alies){
        static::makeOBJ() -> valueInELSEInCase = ' ) ' . $alies;
        return static::makeOBJ();
    }
    // ----------------------------------------

    

    public function location(string $location){
        $this -> location = $location;
        return static::makeOBJ();
    }








    public static function groupBy(string $colomnInQuestion){
        static::makeOBJ() -> groupBy = ' GROUP BY ' . $colomnInQuestion ;

        return static::makeOBJ();
    }

    public static function having(string $textQuestion){
        var_dump(static::makeOBJ() -> withAlies);
        if ($textQuestion == 'having') {
            static::makeOBJ() -> having = ' HAVING ' . static::makeOBJ() -> withAlies . ' > ' . '0';
        } elseif ($textQuestion == 'notHaving') {
            static::makeOBJ() -> having = ' HAVING ' . static::makeOBJ() -> withAlies . ' = ' . '0';
        }
        return static::makeOBJ();
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

        
        if ($columnName == static::makeOBJ() -> having || $columnValue == static::makeOBJ() -> having) {
            if (static::makeOBJ() -> where == ''){
                static::makeOBJ() -> where = ' HAVING '. $columnName . ' = ' . $columnValue;
            } else {
                static::makeOBJ() -> where .= ' AND '. $columnName . ' = ' . $columnValue;
            }
        }
        if (static::makeOBJ() -> join == ''){
            if (static::makeOBJ() -> where == '') {
                static::makeOBJ() -> where = ' WHERE '. $columnName . ' = ' . $columnValue;
            }else {
                static::makeOBJ() -> where .= ' AND '. $columnName . ' = ' . $columnValue;
            }
        }else {
            if (static::makeOBJ() -> on == '') {
                static::makeOBJ() -> on = ' ON '. $columnName . ' = ' . $columnValue;
            }else {
                static::makeOBJ() -> on .= ' AND '. $columnName . ' = ' . $columnValue;
            }
        }
        return static::makeOBJ();
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
        static::makeOBJ() -> limit = ' LIMIT ' . $limit . ' , ' . $ofset;
        return static::makeOBJ();
    }












    public function getSQL(array $fields = ['*']){
        if ($this -> base == '') { $this -> select($fields); }
        if ($this -> type == '') {
            if ($this -> from == '') { $this -> from(); } 
            if ($this -> join == '') { $this -> on = ''; } else { 
                $this -> where = '';
                if ($this -> on == '') { $this -> where(); }
            }
        }
        if($this -> if != ''){
            if ($this -> location == 'base') {
                $this -> base .= ',' . $this -> if . ' ' . $this -> valueInELSEInCase ; 
            } elseif ($this -> location == 'where') {
                $this -> where .= ',' . $this -> if . ' ' . $this -> valueInELSEInCase ; 
            }
        }
        $base =     $this -> base;
        $from =     $this -> from;
        $join =     $this -> join;
        $on =       $this -> on;
        $where =    $this -> where;
        $limit =    $this -> limit;
        $sort =     $this -> sort;
        $groupBy =  $this -> groupBy;
        $having =   $this -> having;
        $subQuery = static::$subQuery;
        
        $this -> textQuery = $base . $subQuery . $from . $join . $sort . $on . $where . $having . $limit . $groupBy;
        
        return static::makeOBJ();
    }

    public function get(){
        return static::$returnedMysqlOBJ = $this -> sendQuery($this -> textQuery);
    }   
}