<?php

class Post extends Controller {
    public function getTemplateName($type){
        switch($type){
            case 'list':
                return 'user/post/list.tpl';
            case 'add':
                return 'user/post/add.tpl';
            case 'edit':
                return 'user/post/edit.tpl';
            case 'delete':
                return 'user/post/delete.tpl';
        }
    }

    public function getListData(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mup = $util->loadModel('model_user_post', $dispatcher->getDb());
        return $mup->getListData();
    }

    public function beforeAddProcess($param){
        $regist_data = array();
        $regist_data['code'] = $param['code'];
        $regist_data['name'] = $param['name'];

        return $regist_data;
    }

    public function registData($param){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mup = $util->loadModel('model_user_post', $dispatcher->getDb());
        $mup->registData($param);
    }

    public function afterAddProcess($inserted_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $util->redirect('?mode=user::post&action=list');
    }

    public function validationAdd(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $code = $util->getParameter('code');
        $name = $util->getParameter('name');

        if(!$name){
            $this->setErrorFlg(1);
            $this->setErrorArray('部署名を入力して下さい。');
        }

        if(!$code){
            $this->setErrorFlg(1);
            $this->setErrorArray('略称を入力して下さい。');
        }else{
            if(preg_match("/[一-龠]+|[ぁ-ん]+|[ァ-ヴー]+|[ａ-ｚＡ-Ｚ０-９]+/u", $code) === 1){
                $this->setErrorFlg(1);
                $this->setErrorArray('略称は半角英数字で入力して下さい。');
            }
        }

        return $this->getErrorFlg();
    }

    public function beforeEditProcess($param){
        $update_data = array();
        $update_data['name'] = $param['name'];

        return $update_data;
    }

    public function getEditData($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mup = $util->loadModel('model_user_post', $dispatcher->getDb());
        return $mup->getData($unique_id);
    }

    public function updateData($unique_id, $param){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mup = $util->loadModel('model_user_post', $dispatcher->getDb());
        $mup->updateData($unique_id, $param);
    }

    public function afterEditProcess($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $util->redirect('?mode=user::post&action=list');
    }

    public function deleteData($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mup = $util->loadModel('model_user_post', $dispatcher->getDb());
        $mup->deleteData($unique_id);
    }

    public function afterDeleteProcess($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $util->redirect('?mode=user::post&action=list');
    }

    public function getDeleteData($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mup = $util->loadModel('model_user_post', $dispatcher->getDb());
        return $mup->getData($unique_id);
    }
}
