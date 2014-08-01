<?php

class History extends Controller {
    public function getTemplateName($type){
        switch($type){
            case 'list':
                return 'repository/history/list.tpl';
            case 'add':
                return 'repository/history/add.tpl';
            case 'edit':
                return 'repository/history/edit.tpl';
            case 'delete':
                return 'repository/history/delete.tpl';
        }
    }

    public function getListData(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $repository_id = $util->getParameter('repository_id');

        $mrh = $util->loadModel('model_repository_history', $dispatcher->getDb());
        return $mrh->getListData($repository_id);
    }

    public function customColumn($data){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        foreach($data as &$row){
            if(mb_strlen($row['note']) > 7){
                $row['note_sub'] = mb_substr($row['note'], 0, 7) . '...';
            }else{
                $row['note_sub'] = $row['note'];
            }

            $row['note'] = $util->htmlescape($row['note']);

            if(mb_strlen($row['application_server']) > 7){
                $row['application_server_sub'] = mb_substr($row['application_server'], 0, 7) . '...';
            }else{
                $row['application_server_sub'] = $row['application_server'];
            }

            $row['application_server'] = $util->htmlescape($row['application_server']);
        }
    }

    public function getEtcListAssignData(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $repository_id = $util->getParameter('repository_id');

        $mrm  = $util->loadModel('model_repository_master', $dispatcher->getDb());
        $mrs  = $util->loadModel('model_repository_storage', $dispatcher->getDb());
        $mrcn = $util->loadModel('model_repository_contents', $dispatcher->getDb());
        $mrcm = $util->loadModel('model_repository_company', $dispatcher->getDb());
        $mrt  = $util->loadModel('model_repository_type', $dispatcher->getDb());

        $repository_data = $mrm->getData($repository_id);
        $storage_data    = $mrs->getArrayData();
        $contents_data   = $mrcn->getArrayData();
        $company_data    = $mrcm->getArrayData();
        $type_data       = $mrt->getArrayData();

        return array(
            'repository_id'   => $repository_id,
            'storage_name'    => $storage_data[$repository_data['repository_storage_id']],
            'contents_name'   => $contents_data[$repository_data['repository_contents_id']],
            'company_name'    => $company_data[$repository_data['repository_company_id']],
            'type_name'       => $type_data[$repository_data['repository_type_id']],
            'repository_name' => $repository_data['name']
        );
    }

    public function beforeAddProcess($param){
        $regist_data = array();
        $regist_data['repository_master_id'] = $param['repository_id'];
        $regist_data['release_version']      = $param['release_version'];
        $regist_data['development_version']  = $param['development_version'];
        $regist_data['note']                 = $param['note'];
        $regist_data['preferred_date']       = sprintf('%04d-%02d-%02d', $param['preferred_year'], $param['preferred_month'], $param['preferred_day']);
        $regist_data['delivery_date']        = sprintf('%04d-%02d-%02d', $param['delivery_year'], $param['delivery_month'], $param['delivery_day']);
        $regist_data['test_revision']        = $param['test_revision'];
        $regist_data['release_revision']     = $param['release_revision'];
        $regist_data['application_server']   = $param['application_server'];
        $regist_data['invalid_flg']          = 0;

        return $regist_data;
    }

    public function registData($param){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrh = $util->loadModel('model_repository_history', $dispatcher->getDb());
        $mrh->registData($param);
    }

    public function afterAddProcess($inserted_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $util->redirect(sprintf('?mode=repository::history&action=list&repository_id=%d', $util->getParameter('repository_id')));
    }

    public function getEtcAddAssignData(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $year  = array();
        $month = array();
        $day   = array();

        $now_year = date('Y', time());

        $year[] = $now_year;
        $year[] = $now_year + 1;

        foreach(range(1,12) as $m){
            $month[] = $m;
        }

        foreach(range(1,31) as $d){
            $day[] = $d;
        }

        return array(
            'year'          => $year,
            'month'         => $month,
            'day'           => $day,
            'now_year'      => date('Y', time()),
            'now_month'     => date('m', time()),
            'now_day'       => date('d', time()),
            'repository_id' => $util->getParameter('repository_id')
        );
    }

    public function validationAdd(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $release_version     = $util->getParameter('release_version');
        $development_version = $util->getParameter('development_version');
        $note                = $util->getParameter('note');
        $preferred_year      = $util->getParameter('preferred_year');
        $preferred_month     = $util->getParameter('preferred_month');
        $preferred_day       = $util->getParameter('preferred_day');
        $delivery_year       = $util->getParameter('delivery_year');
        $delivery_month      = $util->getParameter('delivery_month');
        $delivery_day        = $util->getParameter('delivery_day');
        $test_revision       = $util->getParameter('test_revision');
        $release_revision    = $util->getParameter('release_revision');
        $application_server  = $util->getParameter('application_server');

        if(!$release_version){
            $this->setErrorFlg(1);
            $this->setErrorArray('バージョンを入力して下さい。');
        }

        if($test_revision && !is_numeric($test_revision)){
            $this->setErrorFlg(1);
            $this->setErrorArray('テストRevisionは半角数字で入力して下さい。');
        }

        if($release_revision && !is_numeric($release_revision)){
            $this->setErrorFlg(1);
            $this->setErrorArray('本番Revisionは半角数字で入力して下さい。');
        }

        if(!checkdate($preferred_month, $preferred_day, $preferred_year)){
            $this->setErrorFlg(1);
            $this->setErrorArray('希望日で入力された日付は存在しません。');
        }

        if($delivery_year or $delivery_month or $delivery_day){
            if($delivery_year and $delivery_month and $delivery_day){
                if(!checkdate($delivery_month, $delivery_day, $delivery_year)){
                    $this->setErrorFlg(1);
                    $this->setErrorArray('納品日で入力された日付は存在しません。');
                }
            }else{
                $this->setErrorFlg(1);
                $this->setErrorArray('納品日の日付を正しく入力して下さい。');
            }
        }

        if($development_version){
            if(!preg_match('/\d{8}_\d{2}/', $development_version)){
                $this->setErrorFlg(1);
                $this->setErrorArray('開発番号の書式が正しくありません。');
            }
        }

        return $this->getErrorFlg();
    }

    public function getEditData($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrh = $util->loadModel('model_repository_history', $dispatcher->getDb());
        return $mrh->getData($unique_id);
    }

    public function customEditData($data){
        $data['p_year']  = sprintf('%d', date('Y', strtotime($data['preferred_date'])));
        $data['p_month'] = sprintf('%d', date('m', strtotime($data['preferred_date'])));
        $data['p_day']   = sprintf('%d', date('d', strtotime($data['preferred_date'])));

        if($data['delivery_date'] == '0000-00-00'){
            $data['d_year'] = 0;
            $data['d_month'] = 0;
            $data['d_day'] = 0;
        }else{
            $data['d_year']  = sprintf('%d', date('Y', strtotime($data['delivery_date'])));
            $data['d_month'] = sprintf('%d', date('m', strtotime($data['delivery_date'])));
            $data['d_day']   = sprintf('%d', date('d', strtotime($data['delivery_date'])));
        }
    }

    public function getEtcEditAssignData($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $year  = array();
        $month = array();
        $day   = array();

        $now_year = date('Y', time());

        $year[] = $now_year;
        $year[] = $now_year + 1;

        foreach(range(1,12) as $m){
            $month[] = $m;
        }

        foreach(range(1,31) as $d){
            $day[] = $d;
        }

        return array(
            'year'          => $year,
            'month'         => $month,
            'day'           => $day,
            'now_year'      => date('Y', time()),
            'now_month'     => date('m', time()),
            'now_day'       => date('d', time()),
        );
    }

    public function validationEdit(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $release_version     = $util->getParameter('release_version');
        $development_version = $util->getParameter('development_version');
        $note                = $util->getParameter('note');
        $preferred_year      = $util->getParameter('preferred_year');
        $preferred_month     = $util->getParameter('preferred_month');
        $preferred_day       = $util->getParameter('preferred_day');
        $delivery_year       = $util->getParameter('delivery_year');
        $delivery_month      = $util->getParameter('delivery_month');
        $delivery_day        = $util->getParameter('delivery_day');
        $test_revision       = $util->getParameter('test_revision');
        $release_revision    = $util->getParameter('release_revision');
        $application_server  = $util->getParameter('application_server');

        if(!$release_version){
            $this->setErrorFlg(1);
            $this->setErrorArray('バージョンを入力して下さい。');
        }

        if($test_revision && !is_numeric($test_revision)){
            $this->setErrorFlg(1);
            $this->setErrorArray('テストRevisionは半角数字で入力して下さい。');
        }

        if($release_revision && !is_numeric($release_revision)){
            $this->setErrorFlg(1);
            $this->setErrorArray('本番Revisionは半角数字で入力して下さい。');
        }

        if(!checkdate($preferred_month, $preferred_day, $preferred_year)){
            $this->setErrorFlg(1);
            $this->setErrorArray('希望日で入力された日付は存在しません。');
        }

        if($delivery_year or $delivery_month or $delivery_day){
            if($delivery_year and $delivery_month and $delivery_day){
                if(!checkdate($delivery_month, $delivery_day, $delivery_year)){
                    $this->setErrorFlg(1);
                    $this->setErrorArray('納品日で入力された日付は存在しません。');
                }
            }else{
                $this->setErrorFlg(1);
                $this->setErrorArray('納品日の日付を正しく入力して下さい。');
            }
        }

        if($development_version){
            if(!preg_match('/\d{8}_\d{2}/', $development_version)){
                $this->setErrorFlg(1);
                $this->setErrorArray('開発番号の書式が正しくありません。');
            }
        }

        return $this->getErrorFlg();
    }

    public function beforeEditProcess($param){
        $update_data = array();
        $update_data['release_version']      = $param['release_version'];
        $update_data['development_version']  = $param['development_version'];
        $update_data['note']                 = $param['note'];
        $update_data['preferred_date']       = sprintf('%04d-%02d-%02d', $param['preferred_year'], $param['preferred_month'], $param['preferred_day']);
        $update_data['delivery_date']        = sprintf('%04d-%02d-%02d', $param['delivery_year'], $param['delivery_month'], $param['delivery_day']);
        $update_data['test_revision']        = $param['test_revision'];
        $update_data['release_revision']     = $param['release_revision'];
        $update_data['application_server']   = $param['application_server'];

        return $update_data;
    }

    public function updateData($unique_id, $param){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrh = $util->loadModel('model_repository_history', $dispatcher->getDb());
        $mrh->updateData($unique_id, $param);
    }

    public function afterEditProcess($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $repository_id = $util->getParameter('repository_id');

        $util->redirect(sprintf('?mode=repository::history&action=list&repository_id=%d', $repository_id));
    }

    public function deleteData($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrh = $util->loadModel('model_repository_history', $dispatcher->getDb());
        $mrh->deleteData($unique_id);
    }

    public function afterDeleteProcess($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $repository_id = $util->getParameter('repository_id');

        $util->redirect(sprintf('?mode=repository::history&action=list&repository_id=%d', $repository_id));
    }

    public function getDeleteData($unique_id){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrh = $util->loadModel('model_repository_history', $dispatcher->getDb());
        return $mrh->getData($unique_id);
    }

    public function executeInvalid(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrh = $util->loadModel('model_repository_history', $dispatcher->getDb());
        $mrh->updateInvalid($util->getParameter('id'));

        $util->redirect(sprintf('?mode=repository::history&action=list&repository_id=%d', $util->getParameter('repository_id')));
    }
}
