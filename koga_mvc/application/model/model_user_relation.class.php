<?php

class model_user_relation extends Model {
    public function getTableName(){
        return 'user_relation';
    }

    public function getListDataOrderBy(){
        return '';
    }

    function getArraySendData($user_id){
        $sql = sprintf('select * from user_relation where user_id = %d', $user_id);
        $user_relation_res = $this->execute($sql);

        $data = array();
        while($user_relation_ary = mysql_fetch_array($user_relation_res)){
            $data[$user_relation_ary['repository_master_id']] = $user_relation_ary['send_flg'];
        }

        return $data;
    }

    function registData($user_id, $regist_data, $repository_data){
        foreach($repository_data as $data){
            $send_flg = 0;
            if(array_key_exists(sprintf('repository%d', $data['id']), $regist_data)){
                $send_flg = 1;
            }else{
                $send_flg = 0;
            }

            $sql = sprintf('insert into user_relation (user_id, repository_master_id, send_flg) values (%d, %d, %d)', $user_id, $data['id'], $send_flg);
            $this->execute($sql);
        }
    }

    function updateData($user_id, $param, $repository_data){
        foreach($repository_data as $data){
            $send_flg = 0;
            if(array_key_exists(sprintf('repository%d', $data['id']), $param)){
                $send_flg = 1;
            }else{
                $send_flg = 0;
            }

            $sql = sprintf('select * from user_relation where user_id = %d and repository_master_id = %d', $user_id, $data['id']);
            $res = $this->execute($sql);
            $user_relation_ary = mysql_fetch_array($res);

            if($user_relation_ary){
                $sql = sprintf('update user_relation set send_flg = %d where user_id = %d and repository_master_id = %d', $send_flg, $user_id, $data['id']);
                $this->execute($sql);
            }else{
                $sql = sprintf('insert into user_relation (user_id, send_flg, repository_master_id) values (%d, %d, %d)', $user_id, $send_flg, $data['id']);
                $this->execute($sql);
            }
        }
    }

    function deleteData($user_id){
        $sql = sprintf('delete from user_relation where user_id = %d', $user_id);
        $this->execute($sql);
    }
}
