<?PHP
    print_r($_POST);
/*class Registration{
        private $_link = 0;

        //�R���X�g���N�^
        public function __construct()
        {
            $this->_link = self::connect();//�f�[�^�x�[�X�ɃA�N�Z�X
        }

        //�f�X�g���N�^�@�t�@�C�����N���[�Y����
        public function __destruct()
        {
            self::disconnect($this->_link);//�f�[�^�x�[�X�ؒf
        }

        function connect()
        {
            //DB�ڑ� ����
            $db_host = "localhost";//�T�[�o�[�̏ꏊ
            $db_user = "root";      //���[�U�[
            $db_pass = "0okm9ijn!!";//�p�X���[�h

            $link = mysql_connect($db_host, $db_user, $db_pass);

            if( !$link ) print "�T�[�o�[�ڑ����s";

            //�f�[�^�x�[�X�̑I��
            $db_name = "naokimiyasaka";

            $sdb = mysql_select_db($db_name, $link);

            if( !$sdb ) print "�f�[�^�x�[�X�I�����s";

            return $link;
        }

        function disconnect($link) 
        {
            //�T�[�o�[�ؒf
            if( !mysql_close($link) ) print "�f�[�^�x�[�X�폜���s";
        }
    }

    //�N���X�̎��s����
    $spl_ob_counter = new SqlCounter();//�R���X�g���N�^�[���ĂԂ��ƂŃA�N�Z�X�J�E���^��������
*/
?>