<?php

class model_user extends Model {
    public function getTableName(){
        return 'user';
    }

    public function getListDataOrderBy(){
        return 'order by user_post_id, name';
    }

    public function getPermitSendUserFromRepository($s_id, $cn_id, $cm_id, $t_id, $name){
        $sql = sprintf("select * from user where id in (select user_id from user_relation where send_flg = 1 and repository_master_id in (select id from repository_master where repository_storage_id = %d and repository_contents_id = %d and repository_company_id = %d and repository_type_id = %d and name = '%s'))", $s_id, $cn_id, $cm_id, $t_id, $name);
        $res = $this->execute($sql);

        $data = array();
        while($ary = mysql_fetch_array($res)){
            $data[] = $ary;
        }

        return $data;
    }
}
