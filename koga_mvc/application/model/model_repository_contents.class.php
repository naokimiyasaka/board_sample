<?php

class model_repository_contents extends Model {
    public function getTableName(){
        return 'repository_contents';
    }

    function getArrayData(){
        $sql = sprintf('select * from repository_contents order by id');
        $repository_contents_res = mysql_query($sql, $this->getDb());

        $data = array();
        while($repository_contents_ary = mysql_fetch_array($repository_contents_res)){
            $data[$repository_contents_ary['id']] = $repository_contents_ary['code'];
        }

        return $data;
    }

    public function getListDataOrderBy(){
        return 'order by id';
    }
}
