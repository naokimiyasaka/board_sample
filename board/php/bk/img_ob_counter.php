<?php
    class ImgCounter{
        const FP_LENGTH = 24;
        const NUM_TYPE_MAX = 9;
        private $_counter = 0;
        private $_fp;
        private $_format;
        private $_new_counter;

        //コンストラクタ
        //ファイルオープンとカウンタ処理と書き込み処理
        public function __construct() {
            if( file_exists("img_access_count_ob.txt") ) {
                if(is_readable("img_access_count_ob.txt") && is_writable("img_access_count_ob.txt")) {
                    $this->_fp = fopen("img_access_count_ob.txt", "r+");//ファイルを開く
                }
            }
            else {
                if( is_writable("./") ) {
                    $this->_fp= fopen("img_access_count_ob.txt", "w+");//ファイルを作成
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
        }

        //デストラクタ　ファイルをクローズする
        public function __destruct() {
            fclose($this->_fp);
        }

        //画像描画
        public function Dispcounter() {
            $this->_format = '%0'.self::FP_LENGTH.'d';
            $this->_new_counter = sprintf($this->_format, $this->_counter);

            for( $i = 0; $i <= self::NUM_TYPE_MAX; $i++ ) {
                $num = $i;
                $tag = "<div><img class=\"img$i\"".' src="all.gif"></div>';
                $this->_new_counter = str_replace($num, $tag, $this->_new_counter);
            }
            
            print "<div class=\"clear\">"."アクセスカウンタ"."</div>";

            print "$this->_new_counter";
        }
    }

    $img_counter = new ImgCounter();//コンストラクターを呼ぶことでアクセスカウンタが増える
    $img_counter->Dispcounter();
?>
