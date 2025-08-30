<?php
class product extends model{
    protected $returnedMysqlOBJ;
    // protected $OBJ = null;
    protected $table = ' product ';
    protected $related = ['product_category' , 'category_id'];
    protected $requestQuery = '';

    protected function category(){
        
        return $this -> belongsTo([ ' INNER ' , ' category ']);

        // return (static::makeOBJ()) -> belongsTo( ' INNER ' , ' category ');
    }
}