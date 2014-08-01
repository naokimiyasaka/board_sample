<?php
    class Login
    {
        //定数定義
        const  LOGIN_DISP      = 0;
        const  LOGIN_REGISTER  = 1;
        const  LOGIN_USER_INFO = 2;

        private $_db = null;
        private $_login_disp_status = self::LOGIN_DISP;//ログイン画面状態
        private $_login_id = 0;
        private $_login_pw = '';
        private $_login_date = '';

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

        //ログイン状態かどうかを判断する
        public function checkLoginStatus()
        {
            $login_info = Uitl::getSession('login_info');

            // TODO 中身が正しいかチェックする
            if($login_info == false) {
                return false;
            }

            return true;
        }

        //ユーザー登録処理
        public function registUser()
        {
            $err = 0;
            //ユーザー登録処理　エラーの時はページ遷移させる
            if($this->_db->sendSqlLoginUserRegist(&$err) == false) {
                Uitl::redirect("./index.php?class=Login&method=dispPage&status=1&err=".implode($err));
                exit();
            }

            //ユーザー登録後掲示板のメインページに移動
            Uitl::redirect("./index.php");
            exit();
        }

        //ログイン処理
        public function loginAuth()
        {
            //ログインフォームから入力された値を取得

            //値のエラーチェック

            //データベースからselect name, pass from user_logininfo where name=a and pass=b;
            //レコードが返ってくれば認証Ｏｋ
            $err = 0;
            $result = $this->_db->checkSqlLoginAuth(&$err);
            if($result == false) {
                Uitl::redirect("./?class=Err&method=dispPage&message=$err");//エラーページ
                exit();
            }

            //ログイン情報をセッションにセット 自動でcookieに書かれている
            $this->saveLoginInfo($result['id'], $result['pass']);

            $from_class = Uitl::getSession('class');
            if($from_class == false) {
                $from_class = "DispMain";
            }

            //掲示板へ遷移
            Uitl::redirect("./?class=".$from_class."&method=dispPage");
            exit();
        }

        //ログイン情報の保存
        public function saveLoginInfo($id, $pass)
        {
            Uitl::startSession();
            //暗号化+セッションに保存
            $_SESSION["login_info"] = Uitl::encoding("$id,$pass,".date("Y/m/d H:i:s"), LOGIN_SEED);//ログイン情報を結合
        }

        //ログイン情報の取得
        public function getLoginInfo()
        {
            //セッション開始
            Uitl::startSession();

            //セッション情報を取得
            if(!isset($_SESSION["login_info"])) {
                //Uitl::redirect("./?class=Login&method=dispPage&status=0");//エラーページ
                //exit();
                return false;
            }

            //idに紐づくユーザー情報をデータベースから取得
            $login_info = Uitl::decoding($_SESSION["login_info"], LOGIN_SEED);
            $login_info_array = explode(",", $login_info);
            $id = $login_info_array[0];
            $time = $login_info_array[2];

            //ちゃんとした数値が入っているかどうか
            if(is_numeric($id) == false) {
                return false;
                /*$err = "エラー2";
                Uitl::redirect("./?class=Err&method=dispPage&message=$err");//エラーページ
                exit();*/
            }
            $now_time = date("Y/m/d H:i:s");

            if($time > strtotime("+1 hours")) {
                return false;
            }

            //名前とメールアドレスを取得
            return $this->_db->getUserInfo($id);
        }

        //ログアウト処理
        public function logout()
        {
            Uitl::startSession();
            $_SESSION = array();
            Uitl::endSession();

            //掲示板へ遷移
            Uitl::redirect("./index.php?class=DispMain&method=dispPage");
            exit();
        }

        //ログイン画面遷移 各種ページでログイン情報が取得できないときに使用
        public function loginTransition($class_name, $status)
        {
            if( Uitl::getGet('id') != null ) {
                Uitl::saveSession("bbs_id", Uitl::getGet('id'));
            }

            // ログイン情報の取得
            if($this->getLoginInfo() == false) {
                // 現在のクラス情報を保存
                Uitl::saveSession("class", $class_name);
                Uitl::redirect("./index.php?class=Login&method=dispPage&status=".$status);
                exit();
            }

            return false;
        }

        //ログイン情報をセットする関数
        public function setLoginDispStatus($status)
        {
            $this->_login_disp_status = $status;
        }

        //ログイン情報を取得する関数
        public function getLoginDispStatus($status)
        {
            return $this->_login_disp_status;
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
            //$data_array = array();
            //$data_array = $this->_db->receptionSqlDetails();

            //if( $data_array == null ) {
            //    return false;
            //}

            $this->_login_disp_status = Uitl::getGet('status');

            //各画面にステータス情報から指定されている画面に遷移する
            switch($this->_login_disp_status)
            {
                case self::LOGIN_REGISTER: //新規登録画面
                    $this->dispRegister($smarty);
                break;
                case self::LOGIN_DISP: //ログイン画面
                    $this->dispLogin($smarty);
                break;
                case self::LOGIN_USER_INFO: //ユーザー情報表示
                    $this->dispUserInfo($smarty);
                break;
                default:
                //err
                break;
            }

            return true;
        }

        //登録画面
        private function dispRegister($smarty)
        {
            //$smarty->assign('disp_text', $data_array);
            $smarty->assign('disp_err', Uitl::getGet('err'));
            $smarty->display('loginregister.tpl');
        }

        //ログイン画面
        private function dispLogin($smarty)
        {
            //$smarty->assign('disp_text', $data_array);
            $smarty->display('login.tpl');
        }

        //ユーザー情報表示
        private function dispUserInfo($smarty)
        {
            //$smarty->assign('disp_text', $data_array);
            //$smarty->display('details.tpl');
        }
    }
?>