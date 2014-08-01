<?php

class model_repository_history extends Model {
    public function getTableName(){
        return 'repository_history';
    }

    public function getListData($repository_id){
        $sql = sprintf('select * from %s where repository_master_id = %d %s', $this->getTableName(), $repository_id, $this->getListDataOrderBy());
        $res = $this->execute($sql);

        $data = array();
        while($ary = mysql_fetch_array($res)){
            $data[] = $ary;
        }

        return $data;
    }

    public function getListDataOrderBy(){
        return 'order by id';
    }

    public function updateInvalid($id){
        $sql = sprintf('update %s set invalid_flg = (invalid_flg xor 1) where id = %d', $this->getTableName(), $id);
        $this->execute($sql);
    }

    public function getCountArray(){
        $sql = sprintf('select * from %s', $this->getTableName());
        $res = $this->execute($sql);

        $data = array();
        while($ary = mysql_fetch_array($res)){
            if(array_key_exists($ary['repository_master_id'], $data)){
                $data[$ary['repository_master_id']]++;
            }else{
                $data[$ary['repository_master_id']] = 1;
            }
        }

        return $data;
    }
}
