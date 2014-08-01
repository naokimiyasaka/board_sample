<?php
    class Counter{
        const FP_LENGTH = 20;//constに出来ず
        private $_counter = 0;
        private $_fp;

        //コンストラクタ
        //ファイルオープンとカウンタ処理と書き込み処理
        public function __construct() {
            if( file_exists("access_count_ob.txt") ) {
                if(is_readable("access_count_ob.txt") && is_writable("access_count_ob.txt")) {
                    $this->_fp = fopen("access_count_ob.txt", "r+");//ファイルを開く
                }
            }
            else {
                if( is_writable("./") ) {
                    $this->_fp= fopen("access_count_ob.txt", "w+");//ファイルを作成
                }
            }

            if( $this->_fp ) {
                if(flock($this->_fp, LOCK_EX)){
                    $this->_counter = fgets($this->_fp, self::FP_LENGTH);
                }

                if( $this->_counter === false ) {//念のためカウンタをクリア
                    $this->_counter = 0;
                }
            }

            $this->_counter++;

            rewind($this->_fp);
            fputs($this->_fp, $this->_counter);
            flock($this->_fp, LOCK_UN);

            print "クラスを使用した アクセスカウンタ:$this->_counter\n";
        }

        //デストラクタ　ファイルをクローズする
        public function __destruct() {
            fclose($this->_fp);
        }
    }

    $test_counter = new Counter();//コンストラクターを呼ぶことでアクセスカウンタが増える
?>
