<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/6/18/
 * Time: 20:23
 */

namespace sys\corePackage\Model\operate\DB;


Interface DBoperInterface
{
    public function table($table);
    public function alias($table_alias);

    public function select();
    public function find($id='');
    public function first();

    public function update(array $data);
    public function insert(array $data);
    public function delete($id='');

//    where | group by | having | order by | limit
    public function where($field , $compare , $value='',$connector = ' and ');
    public function orWhere($closure , $compare = '=' , $value = '');
    public function groupBy($field);
//    public function having();
    public function orderBy($field,$sort='asc');
    public function limit($start , $num='');

    public function get_sql_result($sql);

////    inner join | left join | right join
    public function innerJoin($table , $column1 , $column2 );
    public function leftJoin($table , $column1 , $column2 );
    public function rightJoin($table , $column1 , $column2 );
}