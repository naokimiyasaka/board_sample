<?php

class model_user_post extends Model {
    public function getTableName(){
        return 'user_post';
    }

    function getArrayData(){
        $sql = sprintf('select * from user_post order by id');
        $user_post_res = mysql_query($sql, $this->getDb());

        $data = array();
        while($user_post_ary = mysql_fetch_array($user_post_res)){
            $data[$user_post_ary['id']] = $user_post_ary['code'];
        }

        return $data;
    }

    public function getListDataOrderBy(){
        return 'order by id';
    }
}
