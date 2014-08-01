<?php

require_once('PHPMailer/class.phpmailer.php');

class post_commit_sendmail_develop extends Script {
    private $_category;
    private $_repository;

    private $_send_users = array('gjp-pd-dss-pg@gamania.com');

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
        preg_match('/^\/var\/svn\/develop\/(.+)\/(.+)$/', $this->getArgv(2), $matches);

        $this->_category   = $matches[1];
        $this->_repository = $matches[2];
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
                $output[$num] = sprintf('%s <a href="http://pss-rcs.gamania.co.jp/websvn/develop/diff.php?repname=%s.%s&path=%s&rev=%s">DIFF</a>', $line, $this->_category, $this->_repository, urlencode('/'.$matches[2]), $this->getArgv(3));
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

    public function execute(){
        $dispatcher = $this->getDispatcher();
        $util       = $dispatcher->getUtil();

        // 件名作成
        $mail_subject = sprintf("【SVN】【develop】【%s】Rev up to %d", $this->_category, $this->getArgv(3));

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


        foreach($this->_send_users as $email){
            $mail->AddAddress($email);
        }


        // 各種メール情報を設定
        $mail->From     = sprintf('develop-%s-%s-svn-commit@gamania.com', strtolower($this->_category), strtolower($this->_repository));
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
