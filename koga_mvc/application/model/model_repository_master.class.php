<?php

class model_repository_master extends Model {
    public function getTableName(){
        return 'repository_master';
    }

    function getArrayData(){
        $sql = sprintf('select * from repository_master order by repository_storage_id, repository_contents_id, repository_company_id, repository_type_id, name');
        $repository_master_res = mysql_query($sql, $this->getDb());

        $data = array();
        while($repository_master_ary = mysql_fetch_array($repository_master_res)){
            $data[] = $repository_master_ary;
        }

        return $data;
    }

    public function getListDataOrderBy(){
        return 'order by repository_storage_id, repository_contents_id, repository_company_id, repository_type_id, name';
    }
}
