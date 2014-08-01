<?php
    class UpLoad
    {
        const UPLOAD = 0;
        const DOWNLIST = 1;
        const DOWNLIST_B = 2;
        private $_status = self::UPLOAD;
        /**
         * コンストラクタ
         *
         * <pre>
         * データベースに接続
         * </pre>
         *
         * @param Object $db_o データベースクラス
         *
         * @return none
         * @access public
         */
        public function __construct($db_o ,$login_o = '')
        {
            $this->_db = $db_o;
        }

        /**
         * デストラクタ
         *
         * <pre>
         * デストラクタ
         * </pre>
         *
         * @return none
         * @access public
         */
        public function __destruct()
        {
            return true;
        }

        //ファイルのアップロード
        public function upLoad()
        {
            $val = Uitl::getFiles('up_img');

            if(!empty($_FILES)){
                $ip = Uitl::getIp();
                //ローカルサーバーにアップロードさせる
                move_uploaded_file($val['tmp_name'], '/home/naokimiyasaka/public_html/ImageUpMSI/img/'.$val['name']);

                //DBに保存先を書き込む
                $path = $ip.'/~naokimiyasaka/ImageUpMSI/img/'.$val['name'];

                //データベースに保存
                $this->_db->sendSqlPath($path);

                //画面を戻す
                Uitl::redirect("./index.php?class=UpLoad&method=dispPage&status=0");
                exit();
            }

            return false;
        }

        //バイナリのアップロード
        public function upLoadBinary()
        {
            $val = Uitl::getFiles('up_img');

            if(!empty($_FILES)){
                //ローカルサーバーにアップロードさせる
                move_uploaded_file($val['tmp_name'], '/home/naokimiyasaka/public_html/ImageUpMSI/img/'.$val['name']);

                //イメージファイルの読み込み
                $image_data = Uitl::imageLoad('/home/naokimiyasaka/public_html/ImageUpMSI/img/'.$val['name']);

                //データベースにバイナリを保存させる
                $this->_db->sendSqlBinary($image_data, $val['type']);

                //画面を戻す
                Uitl::redirect("./index.php?class=UpLoad&method=dispPage&status=0");
                exit();
            }

            return false;
        }

        /**
         * 表示
         *
         * <pre>
         * 表示
         * </pre>
         *
         * @param Object $smarty スマーティクラス
         *
         * @return none
         * @access public
         */
        public function dispPage($smarty)
        {
            $this->_status = Uitl::getGet('status');
            //アップロード画面
            if( $this->_status == self::UPLOAD ) {
                $smarty->display('uploader.tpl');
            }
            else if($this->_status == self::DOWNLIST) {//リスト画面
                $result = $this->_db->receptionSqlPath();//データベースからパスを持ってくる
                $smarty->assign('listImgLink', $result);
                $smarty->display('list.tpl');
            }
            else if($this->_status == self::DOWNLIST_B) {
                //$id_list = $this->_db->getSqlBinaryId(); //データベースのバイナリデータを紐づいているIDを取得
                //仮　start
                //$result = $this->_db->getSqlBinary(3);
                //$data = base64_encode($result[0]['imgdata']);
                $result = $this->_db->getAllSqlBinary();

                //全部エンコード
                foreach($result as &$val) {
                    $work = base64_encode($val['imgdata']);
                    $val['imgdata'] = $work;
                }

                $smarty->assign('image_data', $result);
                $smarty->display('listbin.tpl');
                //仮　end
            }

            return true;
        }
    }
?>