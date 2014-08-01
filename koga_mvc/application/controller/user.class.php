<?php

class User extends Controller {
    public function getTemplateName($type){
        switch($type){
            case 'list':
                return 'user/list.tpl';
            case 'add':
                return 'user/add.tpl';
            case 'edit':
                return 'user/edit.tpl';
            case 'delete':
                return 'user/delete.tpl';
        }
    }

    public function getListData(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mu = $util->loadModel('model_user', $dispatcher->getDb());
        return $mu->getListData();
    }

    public function customColumn($data){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mup = $util->loadModel('model_user_post', $dispatcher->getDb());

        $post_data_ary  = $mup->getArrayData();

        foreach($data as &$row){
            $row['user_post_id'] = $post_data_ary[$row['user_post_id']];
        }
    }

    public function beforeAddProcess($param){
        $regist_data = array();
        $regist_data['name']         = $param['name'];
        $regist_data['email']        = $param['email'];
        $regist_data['user_post_id'] = $param['user_post_id'];

        return $regist_data;
    }

    public function registData($param){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mu = $util->loadModel('model_user', $dispatcher->getDb());
        return $mu->registData($param);
    }

    public function afterAddProcess($inserted_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrm = $util->loadModel('model_repository_master', $dispatcher->getDb());
        $mur = $util->loadModel('model_user_relation', $dispatcher->getDb());

        $repository_data_ary = $mrm->getArrayData();

        $mur->registData($inserted_id, $util->getParameter(), $repository_data_ary);

        $util->redirect('?mode=user&action=list');
    }

    public function getEtcAddAssignData(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrm = $util->loadModel('model_repository_master', $dispatcher->getDb());
        $mup = $util->loadModel('model_user_post', $dispatcher->getDb());

        $repository_data_ary = $this->_getPathArray($mrm->getArrayData());
        $post_data_ary       = $mup->getArrayData();

        return array(
            'post_data'       => $post_data_ary,
            'repository_data' => $repository_data_ary
        );
    }

    public function validationAdd(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $name  = $util->getParameter('name');
        $email = $util->getParameter('email');

        if(!$name){
            $this->setErrorFlg(1);
            $this->setErrorArray('名前を入力して下さい。');
        }

        if(!$email){
            $this->setErrorFlg(1);
            $this->setErrorArray('メールアドレスを入力して下さい。');
        }else{
            if(preg_match("/[一-龠]+|[ぁ-ん]+|[ァ-ヴー]+|[ａ-ｚＡ-Ｚ０-９]+/u", $email) === 1){
                $this->setErrorFlg(1);
                $this->setErrorArray('メールアドレスは半角英数字で入力して下さい。');
            }
        }

        return $this->getErrorFlg();
    }

    public function validationEdit(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $name  = $util->getParameter('name');
        $email = $util->getParameter('email');

        if(!$name){
            $this->setErrorFlg(1);
            $this->setErrorArray('名前を入力して下さい。');
        }

        if(!$email){
            $this->setErrorFlg(1);
            $this->setErrorArray('メールアドレスを入力して下さい。');
        }else{
            if(preg_match("/[一-龠]+|[ぁ-ん]+|[ァ-ヴー]+|[ａ-ｚＡ-Ｚ０-９]+/u", $email) === 1){
                $this->setErrorFlg(1);
                $this->setErrorArray('メールアドレスは半角英数字で入力して下さい。');
            }
        }

        return $this->getErrorFlg();
    }

    public function beforeEditProcess($param){
        $update_data = array();
        $update_data['name']         = $param['name'];
        $update_data['email']        = $param['email'];
        $update_data['user_post_id'] = $param['user_post_id'];

        return $update_data;
    }

    public function getEditData($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mu = $util->loadModel('model_user', $dispatcher->getDb());
        return $mu->getData($unique_id);
    }

    public function updateData($unique_id, $param){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mu = $util->loadModel('model_user', $dispatcher->getDb());
        $mu->updateData($unique_id, $param);
    }

    public function afterEditProcess($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mur = $util->loadModel('model_user_relation', $dispatcher->getDb());
        $mrm = $util->loadModel('model_repository_master', $dispatcher->getDb());

        $repository_data_ary = $mrm->getArrayData();

        $mur->updateData($unique_id, $util->getParameter(), $repository_data_ary);

        $util->redirect('?mode=user&action=list');
    }

    public function getEtcEditAssignData($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrm = $util->loadModel('model_repository_master', $dispatcher->getDb());
        $mup = $util->loadModel('model_user_post', $dispatcher->getDb());
        $mur = $util->loadModel('model_user_relation', $dispatcher->getDb());

        $repository_data_ary = $this->_getPathArray($mrm->getArrayData());
        $post_data_ary       = $mup->getArrayData();
        $relation_data_ary   = $mur->getArraySendData($unique_id);

        foreach($repository_data_ary as &$data){
            if(array_key_exists($data['id'], $relation_data_ary) && $relation_data_ary[$data['id']] == 1){
                $data['send_flg'] = 1;
            }else{
                $data['send_flg'] = 0;
            }
        }

        return array(
            'post_data'       => $post_data_ary,
            'repository_data' => $repository_data_ary
        );
    }

    public function deleteData($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mu = $util->loadModel('model_user', $dispatcher->getDb());
        $mu->deleteData($unique_id);
    }

    public function afterDeleteProcess($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mur = $util->loadModel('model_user_relation', $dispatcher->getDb());

        $mur->deleteData($unique_id);

        $util->redirect('?mode=user&action=list');
    }

    public function getDeleteData($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mu = $util->loadModel('model_user', $dispatcher->getDb());
        return $mu->getData($unique_id);
    }

    public function customDeleteData($data){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mup = $util->loadModel('model_user_post', $dispatcher->getDb());

        $post_data  = $mup->getArrayData();

        $data['user_post_id']  = $post_data[$data['user_post_id']];
    }

    public function getEtcDeleteAssignData($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrm = $util->loadModel('model_repository_master', $dispatcher->getDb());
        $mup = $util->loadModel('model_user_post', $dispatcher->getDb());
        $mur = $util->loadModel('model_user_relation', $dispatcher->getDb());

        $repository_data_ary = $this->_getPathArray($mrm->getArrayData());
        $post_data_ary       = $mup->getArrayData();
        $relation_data_ary   = $mur->getArraySendData($unique_id);

        foreach($repository_data_ary as &$data){
            if(array_key_exists($data['id'], $relation_data_ary) && $relation_data_ary[$data['id']] == 1){
                $data['send_flg'] = 1;
            }else{
                $data['send_flg'] = 0;
            }
        }

        return array(
            'post_data'       => $post_data_ary,
            'repository_data' => $repository_data_ary
        );
    }

    private function _getPathArray($repository_data){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrcm = $util->loadModel('model_repository_company', $dispatcher->getDb());
        $mrcn = $util->loadModel('model_repository_contents', $dispatcher->getDb());
        $mrs  = $util->loadModel('model_repository_storage', $dispatcher->getDb());
        $mrt  = $util->loadModel('model_repository_type', $dispatcher->getDb());

        $company_data  = $mrcm->getArrayData();
        $contents_data = $mrcn->getArrayData();
        $storage_data  = $mrs->getArrayData();
        $type_data     = $mrt->getArrayData();

        foreach($repository_data as &$row){
            $row['path'] = $this->_generatePath($storage_data[$row['repository_storage_id']], $contents_data[$row['repository_contents_id']], $company_data[$row['repository_company_id']], $type_data[$row['repository_type_id']]) . '/' . $row['name'];
        }

        return $repository_data;
    }

    private function _generatePath($s_name, $cn_name, $cm_name, $t_name){
        return sprintf('%s/%s/%s/%s', $s_name, $cn_name, $cm_name, $t_name);
    }
}
