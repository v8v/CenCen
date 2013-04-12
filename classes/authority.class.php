<?php

/*

程序作用：权限控制类

*/



require_once('database.class.php');



class Authority extends Database

{

  /**

   * 判断是否是管理员

   *

   * @var boolen

   */

  var $isAdmin = false;  



  /**

   * 判断是否是注册用户

   *

   * @var boolen

   */

  var $isUser = false;



  /**

   * 判断是否通过审核

   *

   * @var boolen

   */

  var $isPass = false;



  /**

   * 用户ID

   *

   * @var int

   */

  var $userId = 0;



  /**

   * 用户名

   *

   * @var str

   */

  var $username = '';



  /**

   *构造函数，完成数据库连接

   *

   */

  function Authority()

  {

  	$this->init('');

  }



  /**

   *管理员登录

   *

   */

  function _warn($info,$url = "")

  {?>

  	<script language="JavaScript">

  alert("<?=$info;?>");

  if("<?=$url;?>" != ""){

  	window.location.href = "<?=$url;?>";

  }

  else history.back();

  </script>

<?php

  exit();

  }



  /**

   *管理员登录

   *

   */

  function loginAdmin($username, $password)

  {

  	$query = "SELECT user_password FROM admin WHERE user_name = '".$username."'";

  	$result	= $this->fetch_one_array($query);

  	$this->isAdmin = $result[0] == $password ? TRUE : FALSE;

  	if($this->isAdmin) $this->username = $username;

  }



  /**

   *设置管理员session

   *

   */

  function setAdminSession()

  {

  	if($this->isAdmin){

  		$_SESSION['admin'] = $this->username;

  	}

  }



  /**

   *管理员登录结果提示

   *

   */

  function alertAdminLogin()

  {

  	if($this->isAdmin){

  	  // echo "<script>window.open('main.php', '', 'height=' + (screen.height - 70) + ',width=' + (screen.width - 10) + ',screenX=0,screenY=0,left=0,top=0,resizable=yes,scrollbars=yes');</script>";

          // echo "<script> window.opener = null;</script>";  

          // echo "<script>window.open('', 'self');</script>";  

          // echo "<script> window.close();</script>";  

  	echo "<script>top.location.href='main.php';</script>";			

  	}

  	else

  	{

  		echo "<script>alert('用户名或密码错误！');</script>";	

  	}

  }



  /**

   *取得管理员session

   *

   */

  function getAdminSession()

  {

  	if($_SESSION['admin']){

  		$this->username = $_SESSION['admin'];

  		$this->isAdmin = true;

  	}

  }



  /**

   *管理员登录检查

   *

   */

  function checkAdminLogined()

  {

  	if(!$this->isAdmin){

  		echo "<script>location.href='index.php';</script>";	

  	}

  }



  /**

   *普通会员登录

   *

   */

  function loginUser($username, $password)

  {

  	$query = "SELECT id, isPass FROM users WHERE name = '".$username."' AND password = '".$password."'";

  	$result	= $this->fetch_one_array($query);

  	$this->isUser = $result['id'] ? TRUE : FALSE;

  	$this->isPass = $result['isPass'] ? TRUE : FALSE;

  	if($this->isPass){

  		$this->userId = $result['id'];

  		$this->username = $username;

  	}

  }



  /**

   *设置普通会员session

   *

   */

  function setUserSession()

  {

  	if($this->isPass){

  		$_SESSION['userId'] = $this->userId;

  		$_SESSION['username'] = $this->username;

  	}

  }



  /**

   *普通会员登录结果提示

   *

   */

  function alertUserLogin()

  {

  	if(!$this->isUser) $this->_warn('请先登录', 'index.php');

  	elseif(!$this->isPass) $this->_warn('对不起，您尚未通过验证', 'index.php');

  	elseif($this->isPass) $this->_warn('登录成功', 'sell.php');

  }



  /**

   *取得普通会员session

   *

   */

  function getUserSession()

  {

  	if($_SESSION['userId']){

  		$this->userId = $_SESSION['userId'];

  		$this->username = $_SESSION['username'];

  		$this->isPass = true;

  	}

  }



  /**

   *普通会员登录检查

   *

   */

  function checkUserLogined()

  {

  	if(!$this->isPass) $this->_warn('请先登录', 'index.php');

  }



  /**

   *退出

   *

   */

  function logout()

  {



  	unset($_SESSION);

  	session_destroy();

  }



}



?>
