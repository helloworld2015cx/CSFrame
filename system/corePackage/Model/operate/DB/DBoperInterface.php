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


    public function select();
//    public function update();
//    public function insert();
//    public function delete();


//    where | group by | having | order by | limit
    public function where($field , $compare , $value='');
//    public function whereIn();
//    public function whereLike();
    public function orWhere($closure
        //, DBoperate $orWhere
        );
//    public function groupBy();
//    public function having();
//    public function orderBy();
//    public function limit();
//
////    inner join | left join | right join
//    public function innerJoin();
//    public function leftJoin();
//    public function rightJoin();


}