<?php

class model_repository_company extends Model {
    public function getTableName(){
        return 'repository_company';
    }

    function getArrayData(){
        $sql = sprintf('select * from repository_company order by id');
        $repository_company_res = mysql_query($sql, $this->getDb());

        $data = array();
        while($repository_company_ary = mysql_fetch_array($repository_company_res)){
            $data[$repository_company_ary['id']] = $repository_company_ary['code'];
        }

        return $data;
    }

    public function getListDataOrderBy(){
        return 'order by id';
    }
}
