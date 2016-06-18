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

    public function select();
//    public function update();
//    public function insert();
//    public function delete();

//    where | group by | having | order by | limit
    public function where($field , $compare , $value='',$connector = ' and ');
    public function orWhere($closure , $compare = '=' , $value = '');
    public function groupBy($field);
//    public function having();
    public function orderBy($field);
    public function limit($start , $num='');

////    inner join | left join | right join
//    public function innerJoin();
//    public function leftJoin();
//    public function rightJoin();


}