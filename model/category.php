<?php
class category extends model{
    protected static $returnedMysqlOBJ;
    public static $OBJ = null;
    protected static $table = 'category';
    protected static $related = ['product.category' , 'category.id'];
    protected static $subQuery = '';
}