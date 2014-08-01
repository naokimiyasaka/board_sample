<?php

require_once('PHPMailer/class.phpmailer.php');

class post_commit_sendmail_release extends Script {
    private $_storage;
    private $_contents;
    private $_company;
    private $_type;
    private $_name;

    public function __construct($argv, $dispatcher){
        parent::__construct($argv, $dispatcher);

        // 言語設定、内部エンコーディングを指定する
        mb_language('japanese');
        mb_internal_encoding('UTF-8');

        $this->_init();
    }

    private function _init(){
        // リポジトリのパスから情報を取得
        $matches = array();
        preg_match('/^\/var\/svn\/release\/(.+)\/(.+)\/(.+)\/(.+)\/(.+)$/', $this->getArgv(2), $matches);

        $this->_storage  = $matches[1];
        $this->_contents = $matches[2];
        $this->_company  = $matches[3];
        $this->_type     = $matches[4];
        $this->_name     = $matches[5];
    }

    private function _getSvnAuthor(){
        $output = array();
        exec(sprintf("svnlook author %s -r %s", $this->getArgv(2), $this->getArgv(3)), $output);
        return implode("<br>\n", $output);
    }

    private function _getSvnDate(){
        $output = array();
        exec(sprintf("svnlook date %s -r %s", $this->getArgv(2), $this->getArgv(3)), $output);
        return implode("<br>\n", $output);
    }

    private function _getSvnChanged(){
        $output = array();
        exec(sprintf("LANG=ja_JP.UTF-8 svnlook changed %s -r %s", $this->getArgv(2), $this->getArgv(3)), $output);

        // changedにDIFFのリンクを付ける
        foreach($output as $num => $line){
            $matches = array();
            preg_match('/(\w+)\s+(.+)/', $line, $matches);
            if($matches[1] == 'U'){
                $output[$num] = sprintf('%s <a href="http://pss-rcs.gamania.co.jp/websvn/%s/diff.php?repname=%s-%s-%s.%s&path=%s&rev=%s">DIFF</a>', $line, $this->_storage, $this->_contents, $this->_company, $this->_type, $this->_name, urlencode('/'.$matches[2]), $this->getArgv(3));
            }else{
                $output[$num] = $line;
            }
        }

        return implode("<br>\n", $output);
    }

    private function _getSvnLog(){
        $output = array();
        exec(sprintf("LANG=ja_JP.UTF-8 svnlook log %s -r %s", $this->getArgv(2), $this->getArgv(3)), $output);
        return implode("<br>\n", $output);
    }

    private function _getStorageId(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrs = $util->loadModel('model_repository_storage', $dispatcher->getDb());

        $storage_data = $mrs->getArrayData();
        $storage_data = array_flip($storage_data);

        if(array_key_exists($this->_storage, $storage_data)){
            return $storage_data[$this->_storage];
        }

        return 0;
    }

    private function _getContentsId(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrcn = $util->loadModel('model_repository_contents', $dispatcher->getDb());

        $contents_data = $mrcn->getArrayData();
        $contents_data = array_flip($contents_data);

        if(array_key_exists($this->_contents, $contents_data)){
            return $contents_data[$this->_contents];
        }

        return 0;
    }

    private function _getCompanyId(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrcm = $util->loadModel('model_repository_company', $dispatcher->getDb());

        $company_data = $mrcm->getArrayData();
        $company_data = array_flip($company_data);

        if(array_key_exists($this->_company, $company_data)){
            return $company_data[$this->_company];
        }

        return 0;
    }

    private function _getTypeId(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        $mrt = $util->loadModel('model_repository_type', $dispatcher->getDb());

        $type_data = $mrt->getArrayData();
        $type_data = array_flip($type_data);

        if(array_key_exists($this->_type, $type_data)){
            return $type_data[$this->_type];
        }

        return 0;
    }

    public function execute(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        // 件名作成
        $mail_subject = sprintf("【SVN】【%s】【%s】Rev up to %d", $this->_storage, $this->_contents, $this->getArgv(3));

        // 本文作成
        $mail_body = '<div style="font-family: \'ＭＳ ゴシック\', \'MS Gothic\', \'Osaka－等幅\', Osaka-mono, monospace;">' .
        implode("<br>\n", array(
            sprintf("リポジトリ : %s", $this->getArgv(2)),
            sprintf("リビジョン : %s", $this->getArgv(3)),
            sprintf("更新者&nbsp;&nbsp;&nbsp;&nbsp; : %s", $this->_getSvnAuthor()),
            sprintf("更新日時&nbsp;&nbsp; : %s", $this->_getSvnDate()),
            "",
            "--------------------------------------------------------",
            "- コミットログ",
            "--------------------------------------------------------",
            sprintf("%s", $this->_getSvnLog()),
            "",
            "--------------------------------------------------------",
            "- 変更ファイル&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[U:更新 A:追加 D:削除]",
            "--------------------------------------------------------",
            sprintf("%s", $this->_getSvnChanged()),
        )) . '</div>';

        // メール設定
        $mail = new PHPMailer();
        $mail->IsHTML(true);
        $mail->CharSet = "iso-2022-jp";
        $mail->Encoding = "7bit";


        $mu = $util->loadModel('model_user', $dispatcher->getDb());
        $send_user_ary = $mu->getPermitSendUserFromRepository($this->_getStorageId(), $this->_getContentsId(), $this->_getCompanyId(), $this->_getTypeId(), $this->_name);

        if($send_user_ary){
            foreach($send_user_ary as $user_ary){
                $mail->AddAddress($user_ary['email']);
            }


            // 各種メール情報を設定
            $mail->From     = sprintf('%s-%s-%s-%s-%s-svn-commit@gamania.com', $this->_storage, $this->_contents, $this->_company, $this->_type, strtolower($this->_name));
            $mail->FromName = mb_encode_mimeheader(mb_convert_encoding('SVN-commit', "JIS", "UTF-8"));
            $mail->Subject  = mb_encode_mimeheader(mb_convert_encoding($mail_subject, "JIS", "UTF-8"));
            $mail->Body     = $mail_body;

            // メール送信
            $mail_res = $mail->Send();
            if(!$mail_res){
                echo sprintf("メールが送信できませんでした。エラー : %s", $mail->ErrorInfo);
            }
        }
    }
}