<?php
/**
 * Model
 *
 * Modelの基礎クラス
 *
 * PHP versions 5
 *
 * @category   Model
 * @package    Model
 * @subpackage Model
 * @author     Seiki Koga <seikikoga@gamania.com>
 * @copyright  2011-2011 Gamania Degital Entertainment Co.,Ltd.
 * @license    http://www.opensource.org/licenses/mit-license.php MIT License
 * @version    SVN: $Rev: 26 $
 * @access     public
 * @link       10.119.10.100:/var/svn/KC/backend
 */

/**
 * Model
 *
 * Modelの基礎クラス
 *
 * @category   Model
 * @package    Model
 * @subpackage Model
 * @author     Seiki Koga <seikikoga@gamania.com>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT License
 * @access     public
 * @link       10.119.10.100:/var/svn/KC/backend
 * @access     public
 */
abstract class Model {
    /**
     * データベース接続リソース
     *
     * Dispatcherで接続されたリソース
     *
     * @var resource データベース接続リソース
     */
    private $_db;

    /**
     * TRUNSACTIONの深度カウンタ
     *
     * TRUNSACTIONを開始する度にカウントしていく。
     * カウントが０の時のみcommit可能。
     *
     * @var integer TRUNSACTIONの深度カウンタ
     */
    static private $_trunsaction_count = 0;

    /**
     * コンストラクタ
     *
     * 渡されたデータベース接続リソースを保持しておく。
     *
     * @param  resource $db データベース接続リソース
     * @return void
     * @access public
     */
    public function __construct($db){
        $this->_db = $db;
    }

    /**
     * テーブル名取得
     *
     * テーブル名を取得する。
     * 各モデルに必ず実装する事。
     *
     * @param  void
     * @return string テーブル名
     * @access abstract public
     */
    abstract public function getTableName();

    /**
     * データベース接続リソース取得
     *
     * 保持しているデータベース接続リソースを返す。
     *
     * @param  void
     * @return resource データベース接続リソース
     * @access public
     */
    public function getDb(){
        return $this->_db;
    }

    /**
     * SQL実行
     *
     * 渡されたSQLを実行する。
     * 失敗した場合は例外を吐く。
     *
     * @param  string $sql SQL文
     * @return void
     * @access public
     */
    public function execute($sql){
        $res = mysql_query($sql);

        if($res){
            return $res;
        }else{
            throw new MysqlException('Database Error : ' . mysql_error($this->_db));
        }
    }

    /**
     * トランザクション開始
     *
     * トランザクションカウンタが０の時に
     * トランザクションを開始する。
     *
     * @param  void
     * @return void
     * @access public
     */
    public function begin(){
        if(self::$_trunsaction_count == 0){
            $sql = sprintf('start trunsaction');
            $this->execute($sql);
        }else{
            self::$_trunsaction_count++;
        }
    }

    /**
     * コミット処理
     *
     * トランザクションカウンタが１の時にコミットをする。
     * ０以下の場合は例外を吐く。
     *
     * @param  void
     * @return void
     * @access public
     */
    public function commit(){
        if(self::$_trunsaction_count > 0){
            self::$_trunsaction_count--;

            if(self::$_trunsaction_count == 0){
                $sql = sprintf('commit');
                $this->execute($sql);

                self::$_trunsaction_count = 0;
            }
        }else{
            throw new MysqlException('Non Started Trunsaction.');
        }
    }

    /**
     * ロールバック処理
     *
     * ロールバックを行う。
     * ロールバックが呼ばれた時に
     * トランザクションカウンタを０にする。
     *
     * @param  void
     * @return void
     * @access public
     */
    public function rollback(){
        $sql = sprintf('rollback');
        $this->execute($sql);

        self::$_trunsaction_count = 0;
    }

    /**
     * データ取得
     *
     * PrimaryKeyからデータを取得する。
     * 取得できなかった場合は例外が発生するかも・・・。
     *
     * @param  integer $unique_id PrimaryKey
     * @return void
     * @access public
     */
    public function getData($unique_id){
        $sql = sprintf('select * from %s where id = %d', $this->getTableName(), $unique_id);
        $res = $this->execute($sql);

        return mysql_fetch_array($res);
    }

    /**
     * 一覧データ取得
     *
     * 一覧用のデータを取得してくる。
     * OrderByを指定する場合はgetListDataOrderByを実装する事。
     *
     * @param  void
     * @return array 一覧データ
     * @access public
     */
    public function getListData(){
        $sql = sprintf('select * from %s %s', $this->getTableName(), $this->getListDataOrderBy());
        $res = $this->execute($sql);

        $data = array();
        while($ary = mysql_fetch_array($res)){
            $data[] = $ary;
        }

        return $data;
    }

    /**
     * 一覧データ取得の並び順
     *
     * OrderByを指定する。
     * 実装していないModel用にこちらでも空文字列で実装。
     *
     * @param  void
     * @return string OrderBy文
     * @access public
     */
    public function getListDataOrderBy(){
        return '';
    }

    /**
     * データの新規登録
     *
     * KeyValの組み合わせで配列を引数にする。
     * その組み合わせでInsert文を作成する。
     * Insertが成功した場合は登録されたIDを返す。
     *
     * @param  array $param 登録するKeyValの配列
     * @return integer 登録されたID
     * @access public
     */
    public function registData($param){
        $key_ary = array();
        $val_ary = array();

        foreach($param as $key => $value){
            $key_ary[] = $key;

            if(gettype($value) == 'string'){
                $value = sprintf("'%s'", mysql_real_escape_string($value));
            }

            $val_ary[] = $value;
        }

        $sql = sprintf('insert into %s (%s) values (%s)', $this->getTableName(), implode(', ', $key_ary), implode(', ', $val_ary));
        $this->execute($sql);

        return mysql_insert_id($this->_db);
    }


    /**
     * データの更新
     *
     * PrimaryKeyとKeyValの組み合わせで配列を引数にする。
     * その組み合わせでUpdate文を作成する。
     *
     * @param  integer $unique_id PrimaryKey
     * @param  array   $param     登録するKeyValの配列
     * @return void
     * @access public
     */
    public function updateData($unique_id, $param){
        $update_ary = array();

        foreach($param as $key => $value){
            if(gettype($value) == 'string'){
                $value = sprintf("'%s'", mysql_real_escape_string($value));
            }

            $update_ary[] = sprintf("%s = %s", $key, $value);
        }

        $sql = sprintf('update %s set %s where id = %d', $this->getTableName(), implode(', ', $update_ary), $unique_id);
        $this->execute($sql);
    }

    /**
     * 指定データ削除
     *
     * 指定したPrimaryKeyのデータを削除する。
     *
     * @param  integer $unique_id PrimaryKey
     * @return string OrderBy文
     * @access public
     */
    public function deleteData($unique_id){
        $sql = sprintf('delete from %s where id = %d', $this->getTableName(), $unique_id);
        $this->execute($sql);
    }
}
