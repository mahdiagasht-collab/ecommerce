<?php
class model extends facade{
    private $textQuery = '';

    private $base = '';
    private $where = '';
    private $limit = '';
    private $from = '';
    private $join = '';
    private $on = '';
    private $sort = '';
    private $type = '';
    private $subQuery = '';

    
    private $if = '';
    private $valueInELSEInCase = '';
    private $location = '';

    private $groupBy = '';
    
    private $having = '';
    
    private $withAlies = '';



    // protected function getReturnedOBJ(){
    //     return static::$returnedMysqlOBJ;
    // }
    // protected function makeOBJ(){
    //     return factory::factory(static::class);
    // }

    
    protected function select(array $colomnInQuestion){//$fields=['*']
        // var_dump($colomnInQuestion[0]);
        echo '🤨';
        // echo '<br>';
        // echo $colomnInQuestion[0][0];
        // echo '<br>';
        // var_dump(implode(',' , $colomnInQuestion[0]));
        echo '<br>';
        // die();
        if ($colomnInQuestion == []) {$colomnInQuestion = [['*']];}
        echo $this -> base = 'SELECT ' . implode(',' , $colomnInQuestion[0]);
        return $this;
    }
    protected function find(array $colomnInQuestion){//$id
        // $this;
        return static::$connection -> query('SELECT * FROM ' . static::class . ' WHERE id = ' . $colomnInQuestion[0]);
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
        $this -> base = 'UPDATE '. static::$table . ' SET ' . $TableValues;
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
        $this -> base = 'INSERT INTO '. static::$table . ' ( ' . $columnName . ' ) VALUES (' . $columnValues . ' ) ';
        return $this;
    }
    protected function createOrUpdate(array $colomnInQuestion){//data
        if ($this -> all([]) -> num_rows == 1){
            return $this -> update($colomnInQuestion[0]);
        } else {
            return $this -> create($colomnInQuestion[0]);
        }
    }
    



    protected function all(array $colomnInQuestion){//fields=['*']
        if ($colomnInQuestion == []) {$colomnInQuestion = [['*']];}
        return $this -> select([$colomnInQuestion[0]]) -> from([]) -> getSQL([]) -> get([]);
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
            $this -> from = ' FROM ' . static::$table;
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
    protected function connectInBase(array $colomnInQuestion){//fields
        $this -> base .= ',' . implode(',' , $colomnInQuestion[0]);
        return $this;
    }
    
    
    
    
    
    
    
    
    
    protected function with(array $colomnInQuestion){//string $tableName , array $fields , array $whereRequest 
        // مسئولیت این متد ایجاد ساب کوئری با سینتگز عمومی است
        $this -> withAlies = 'categoryProductCount';
        // این پراپرتی رو برای متد هَوینگ نوشتم
        $this -> $subQuery = $colomnInQuestion[0]::
            select([$colomnInQuestion[1]])
            // چرا سلکت رو اینجا کال کردم چون هر ساب کوئری ای دستورش باید یک فیلدز را برگرداند نه بیشتر از یکی رو
        ->  where([$colomnInQuestion[2]])
            // چرا اینجا من وئر رو کال کردم چون همواره ساب کوئری یک مقدار میتواند برگرداند نه چند مقدار
        ->  getSQLWith('categoryProductCount');
            // چرا من گئت اسکیواِل رو کال کردم چون در اونجا پراپرتی های این آبجکت رو به هم کانکت میکنه و برمیگردونه
        return $this;
    }
    
    
    
    protected function withProductCount(array $colomnInQuestion){//string $tableName
        $this -> withAlies = 'categoryProductCount';
          echo '😢';
        $this -> subQuery = (new product) 
        ->  select([['count(*) ']]) 
        ->  where([static::$related]) 
        ->  getSQLWith(['categoryProductCount']);
        // return $this -> get();
        return $this;
    }
    
    protected function getSQLWith(array $colomnInQuestion){//string $alies
        if ($this -> base == '') { $this -> select([['count(*) count']]); }
        if ($this -> from == '') { $this -> from([]); } 
        if ($this -> join == '') { $this -> on = ''; } else { 
            $this -> where = '';
            if ($this -> on == '') { $this -> where([]); }
        }
        
        $base =     $this -> base;
        $from =     $this -> from;
        $where =    $this -> where;
        $limit =    $this -> limit;
        
        $this -> base =      '';
        $this -> from =      '';
        $this -> where =     '';
        $this -> limit =     '';

        $this -> having = $colomnInQuestion[0];

        return ' , ( ' . $base . $from . $where . $limit . ' ) ' . $colomnInQuestion[0];
    }





    
    
    
    protected function case(array $colomnInQuestion){//string $colomnInQuestion , string $ifType , string $valueInQuestion , string $printValue
        // echo static::class;
        // var_dump($this);
        // die();   
        if ($this -> if == '') {
            $this -> if .= ' CASE WHEN ' . $colomnInQuestion[0] . ' ' . $ifType[1] . ' ' . $colomnInQuestion[2] . ' THEN ' . " '" . $colomnInQuestion[3] . "' ";
        } else {
            $this -> if .= ' WHEN ' . $colomnInQuestion[0] . ' ' . $ifType[1] . ' ' . $colomnInQuestion[2] . ' THEN ' . " '" . $colomnInQuestion[3] . "' ";

        }
        return $this;
    }
    protected function caseELSEAndENDAndAlies(array $colomnInQuestion){//string $valueInELSE , string $alies
        $this -> valueInELSEInCase = 'ELSE ' . $colomnInQuestion[0] . ' END ' . $colomnInQuestion[1];
        return $this;
    }
    // ----------------------------------------
    protected function if(array $colomnInQuestion){//string $colomnInQuestion , string $ifType , string $valueInQuestion , string $printValue , string $valueIsIfNull = '' , string $alies
        $this -> if .= 'IF ( ' . $colomnInQuestion[0] . ' ' . $colomnInQuestion[1] . ' ' . $colomnInQuestion[2] . ' , ' . " '" . $colomnInQuestion[3] . "' , " . $colomnInQuestion[4] . " ) " . $colomnInQuestion[5];
        return $this;
    }
    // ----------------------------------------
    protected function ifNull(array $colomnInQuestion){//string $colomnInQuestion , string $ifType , string $valueInQuestion , string $printValue , string $alies
        $this -> if .= 'IFNULL ( ' . $colomnInQuestion[0] . ' ' . $colomnInQuestion[1] . ' ' . $colomnInQuestion[2] . ' , ' . " '" . $colomnInQuestion[3] . "' ) " . $colomnInQuestion[4];
        return $this;
    }
    // ----------------------------------------
    protected function coalesce(array $colomnInQuestion){//string $colomnInQuestion
        if ($this -> if == '') {
            $this -> if .= 'COALESCE ( ' . $colomnInQuestion[0];
        } else {
            $this -> if .= ' , ' . $colomnInQuestion[0];
        }
        return $this;
    }
    protected function coalesceAlies(array $colomnInQuestion){//string $alies
        $this -> valueInELSEInCase = ' ) ' . $colomnInQuestion[0];
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

    protected function having(array $colomnInQuestion){//string $textQuestion
        var_dump($this -> withAlies);
        if ($colomnInQuestion[0] == 'having') {
            $this -> having = ' HAVING ' . $this -> withAlies . ' > ' . '0';
        } elseif ($colomnInQuestion[0] == 'notHaving') {
            $this -> having = ' HAVING ' . $this -> withAlies . ' = ' . '0';
        }
        return $this;
    }




    protected function where(array $colomnInQuestion){//array $requiredValues = []
        // if ($colomnInQuestion == []) { $colomnInQuestion = []}
        
        if ($colomnInQuestion[0] == []) {
            $columnName = static::$related[0];
            $columnValue = static::$related[1];
        } else {
            if ($colomnInQuestion[0][0] == '') {
                $columnName = static::$table . '_id';
            }else {
                $columnName = $colomnInQuestion[0][0];
            }
            $columnValue = $colomnInQuestion[0][1];
        }

        
        if ($columnName == $this -> having || $columnValue == $this -> having) {
            if ($this -> where == ''){
                $this -> where = ' HAVING '. $columnName . ' = ' . $columnValue;
            } else {
                $this -> where .= ' AND '. $columnName . ' = ' . $columnValue;
            }
        }
        if ($this -> join == ''){
            if ($this -> where == '') {
                $this -> where = ' WHERE '. $columnName . ' = ' . $columnValue;
            }else {
                $this -> where .= ' AND '. $columnName . ' = ' . $columnValue;
            }
        }else {
            if ($this -> on == '') {
                $this -> on = ' ON '. $columnName . ' = ' . $columnValue;
            }else {
                $this -> on .= ' AND '. $columnName . ' = ' . $columnValue;
            }
        }
        return $this;
    }
    protected function limit(array $colomnInQuestion){//array $data
        // var_dump($data);
        if (count($colomnInQuestion[0]) == 1) { 
            $limit = $colomnInQuestion[0][0];
            $ofset = 10;
        }else {
            if ($colomnInQuestion[0][0] < $colomnInQuestion[0][1]) {
                $limit = $colomnInQuestion[0][0];
                // echo '😤';
                $ofset = $colomnInQuestion[0][1] - $colomnInQuestion[0][0];

            }else{
                $limit = $colomnInQuestion[0][1];
                $ofset = $colomnInQuestion[0][0] - $colomnInQuestion[0][1];

            }
        }
        $this -> limit = ' LIMIT ' . $limit . ' , ' . $ofset;
        return $this;
    }












    protected function getSQL(array $colomnInQuestion){//array $fields = ['*']
        if ($colomnInQuestion == []) {$colomnInQuestion = [['*']];}
        if ($this -> base == '') { echo '😢'; $this -> select([$colomnInQuestion[0]]); }
        if ($this -> type == '') {
            if ($this -> from == '') { $this -> from([]); } 
            if ($this -> join == '') { $this -> on = ''; } else { 
                $this -> where = '';
                if ($this -> on == '') { $this -> where([]); }
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
        $subQuery = $this -> subQuery;
        
        $this -> textQuery = $base . $subQuery . $from . $join . $sort . $on . $where . $having . $limit . $groupBy;
        
        return $this;
    }

    protected function get(array $colomnInQuestion){
        return static::$returnedMysqlOBJ = $this -> sendQuery($this -> textQuery);
    }   
}