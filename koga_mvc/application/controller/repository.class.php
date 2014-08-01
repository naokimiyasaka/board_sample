<?php

class Repository extends Controller {
    public function getTemplateName($type){
        switch($type){
            case 'list':
                return 'repository/list.tpl';
            case 'add':
                return 'repository/add.tpl';
            case 'edit':
                return 'repository/edit.tpl';
            case 'delete':
                return 'repository/delete.tpl';
        }
    }

    public function getListData(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrm = $util->loadModel('model_repository_master', $dispatcher->getDb());
        return $mrm->getListData();
    }

    public function customColumn($data){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrcm = $util->loadModel('model_repository_company', $dispatcher->getDb());
        $mrcn = $util->loadModel('model_repository_contents', $dispatcher->getDb());
        $mrs  = $util->loadModel('model_repository_storage', $dispatcher->getDb());
        $mrt  = $util->loadModel('model_repository_type', $dispatcher->getDb());
        $mrh  = $util->loadModel('model_repository_history', $dispatcher->getDb());

        $company_data_ary  = $mrcm->getArrayData();
        $contents_data_ary = $mrcn->getArrayData();
        $storage_data_ary  = $mrs->getArrayData();
        $type_data_ary     = $mrt->getArrayData();
        $history_data_ary  = $mrh->getCountArray();

        foreach($data as &$row){
            $row['repository_storage_id']  = $storage_data_ary[$row['repository_storage_id']];
            $row['repository_contents_id'] = $contents_data_ary[$row['repository_contents_id']];
            $row['repository_company_id']  = $company_data_ary[$row['repository_company_id']];
            $row['repository_type_id']     = $type_data_ary[$row['repository_type_id']];
            $row['history_count']          = array_key_exists($row['id'], $history_data_ary) ? $history_data_ary[$row['id']] : 0;
        }
    }

    public function beforeAddProcess($param){
        $regist_data = array();
        $regist_data['repository_company_id']  = $param['repository_company_id'];
        $regist_data['repository_contents_id'] = $param['repository_contents_id'];
        $regist_data['repository_storage_id']  = $param['repository_storage_id'];
        $regist_data['repository_type_id']     = $param['repository_type_id'];
        $regist_data['name']                   = $param['name'];
        $regist_data['memo']                   = $param['memo'];

        return $regist_data;
    }

    public function registData($param){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrm = $util->loadModel('model_repository_master', $dispatcher->getDb());
        $mrm->registData($param);
    }

    public function afterAddProcess($inserted_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $repository_full_path = $this->_getRepositoryFullPath();
        $repository_dir_path  = $this->_getRepositoryDirPath();

        exec(sprintf('mkdir -p -m 775 %s', $repository_dir_path));
        exec(sprintf('svnadmin create %s', $repository_full_path));
        exec(sprintf('chmod -R ug+w %s', $repository_full_path));
        exec(sprintf('chgrp -R svn %s', $repository_full_path));
        exec(sprintf("svn mkdir file://%s -m 'trunk'", $repository_full_path . '/trunk'));
        exec(sprintf("svn mkdir file://%s -m 'branches'", $repository_full_path . '/branches'));
        exec(sprintf("svn mkdir file://%s -m 'tags'", $repository_full_path . '/tags'));
        exec(sprintf("cp %s/../../data/svn-hook/post-commit-release %s/hooks/post-commit", dirname(__FILE__), $repository_full_path));
        exec(sprintf("chmod 775 %s/hooks/post-commit", $repository_full_path));
        exec(sprintf("chgrp svn %s/hooks/post-commit", $repository_full_path));

        $util->redirect('?mode=repository&action=list');
    }

    public function getEtcAddAssignData(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrcm = $util->loadModel('model_repository_company', $dispatcher->getDb());
        $mrcn = $util->loadModel('model_repository_contents', $dispatcher->getDb());
        $mrs  = $util->loadModel('model_repository_storage', $dispatcher->getDb());
        $mrt  = $util->loadModel('model_repository_type', $dispatcher->getDb());

        $company_data_ary  = $mrcm->getArrayData();
        $contents_data_ary = $mrcn->getArrayData();
        $storage_data_ary  = $mrs->getArrayData();
        $type_data_ary     = $mrt->getArrayData();

        return array(
            'company_data'  => $company_data_ary,
            'contents_data' => $contents_data_ary,
            'storage_data'  => $storage_data_ary,
            'type_data'     => $type_data_ary
        );
    }

    public function validationAdd(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $repository_name = $util->getParameter('name');
        if(!$repository_name){
            $this->setErrorFlg(1);
            $this->setErrorArray('リポジトリ名を入力して下さい。');
        }else{
            $repository_full_path = $this->_getRepositoryFullPath();
            $repository_dir_path  = $this->_getRepositoryDirPath();

            if(file_exists($repository_dir_path)){
                if(!is_writable($repository_dir_path)){
                    $this->setErrorFlg(1);
                    $this->setErrorArray(sprintf('%s に書き込み権限がありません。', $repository_dir_path));
                }
            }

            if(file_exists($repository_full_path)){
                $this->setErrorFlg(1);
                $this->setErrorArray('既にリポジトリが存在しています。');
            }

            if(preg_match("/[一-龠]+|[ぁ-ん]+|[ァ-ヴー]+|[ａ-ｚＡ-Ｚ０-９]+/u", $repository_name) === 1){
                $this->setErrorFlg(1);
                $this->setErrorArray('リポジトリ名は半角英数字で入力して下さい。');
            }
        }

        return $this->getErrorFlg();
    }

    public function beforeEditProcess($param){
        $update_data = array();
        $update_data['memo'] = $param['memo'];

        return $update_data;
    }

    public function getEditData($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrm = $util->loadModel('model_repository_master', $dispatcher->getDb());
        return $mrm->getData($unique_id);
    }

    public function updateData($unique_id, $param){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrm = $util->loadModel('model_repository_master', $dispatcher->getDb());
        $mrm->updateData($unique_id, $param);
    }

    public function afterEditProcess($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $util->redirect('?mode=repository&action=list');
    }

    public function customEditData($data){
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

        $data['repository_company_id']  = $company_data[$data['repository_company_id']];
        $data['repository_contents_id'] = $contents_data[$data['repository_contents_id']];
        $data['repository_storage_id']  = $storage_data[$data['repository_storage_id']];
        $data['repository_type_id']     = $type_data[$data['repository_type_id']];
    }

    public function deleteData($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrm = $util->loadModel('model_repository_master', $dispatcher->getDb());
        $mrm->deleteData($unique_id);
    }

    public function afterDeleteProcess($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $util->redirect('?mode=repository&action=list');
    }

    public function getDeleteData($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrm = $util->loadModel('model_repository_master', $dispatcher->getDb());
        return $mrm->getData($unique_id);
    }

    public function customDeleteData($data){
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

        $data['repository_company_id']  = $company_data[$data['repository_company_id']];
        $data['repository_contents_id'] = $contents_data[$data['repository_contents_id']];
        $data['repository_storage_id']  = $storage_data[$data['repository_storage_id']];
        $data['repository_type_id']     = $type_data[$data['repository_type_id']];
    }

    private function _getRepositoryFullPath(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        return $this->_generatePath() . '/' . $util->getParameter('name');
    }

    private function _getRepositoryDirPath(){
        return $this->_generatePath();
    }

    private function _generatePath(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $storage_id  = $util->getParameter('repository_storage_id');
        $contents_id = $util->getParameter('repository_contents_id');
        $company_id  = $util->getParameter('repository_company_id');
        $type_id     = $util->getParameter('repository_type_id');

        $mrcm = $util->loadModel('model_repository_company', $dispatcher->getDb());
        $mrcn = $util->loadModel('model_repository_contents', $dispatcher->getDb());
        $mrs  = $util->loadModel('model_repository_storage', $dispatcher->getDb());
        $mrt  = $util->loadModel('model_repository_type', $dispatcher->getDb());

        $company_data  = $mrcm->getArrayData();
        $contents_data = $mrcn->getArrayData();
        $storage_data  = $mrs->getArrayData();
        $type_data     = $mrt->getArrayData();

        return sprintf('/var/svn/release/%s/%s/%s/%s', $storage_data[$storage_id], $contents_data[$contents_id], $company_data[$company_id], $type_data[$type_id]);
    }

    public function executePermission(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $repository_id = $util->getParameter('id');

        $mrm  = $util->loadModel('model_repository_master', $dispatcher->getDb());
        $mrcm = $util->loadModel('model_repository_company', $dispatcher->getDb());
        $mrcn = $util->loadModel('model_repository_contents', $dispatcher->getDb());
        $mrs  = $util->loadModel('model_repository_storage', $dispatcher->getDb());
        $mrt  = $util->loadModel('model_repository_type', $dispatcher->getDb());

        $company_data  = $mrcm->getArrayData();
        $contents_data = $mrcn->getArrayData();
        $storage_data  = $mrs->getArrayData();
        $type_data     = $mrt->getArrayData();

        $repository_data = $mrm->getData($repository_id);
        $company_data    = $mrcm->getArrayData();
        $contents_data   = $mrcn->getArrayData();
        $storage_data    = $mrs->getArrayData();
        $type_data       = $mrt->getArrayData();

        $repository_full_path = sprintf('/var/svn/release/%s/%s/%s/%s/%s', $storage_data[$repository_data['repository_storage_id']], $contents_data[$repository_data['repository_contents_id']], $company_data[$repository_data['repository_company_id']], $type_data[$repository_data['repository_type_id']], $repository_data['name']);

        exec(sprintf('chmod -R ug+w %s', $repository_full_path));

        $util->redirect('?mode=repository&action=list');
    }
}
