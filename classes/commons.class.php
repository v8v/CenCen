<?php

/*

程序作用：分类类

*/

//初始化系统变量

require_once('database.class.php');

class Commons extends Database

{  

  

  function Commons($table)

  {

  	$this->init($table);

  }



  /**

   * 

   * @param $id

   */

  function getInfoById($id)

  {

  	$result = $this->fetch_one_array("SELECT * FROM ".$this->table." WHERE id = ".$id);

  	return $result;

  }

  

  /**

   * 分页检索

   * @param $keyword

   * @param $sizeOfPage

   */

  function getSearch($field,$keyword, $sizeOfPage = 20)

  {

  	$clause = " WHERE 1 =1 ";

  	$clause .= empty($keyword) ? "" : "AND ".$field." LIKE '%".$keyword."%'";

  	//echo "<script>alert('$clause');</script>";

  	//查询数据

  	$query = " SELECT COUNT(1) FROM  ".$this->table;

  	$query .= $clause;

  	//echo "<script>alert('$query');</script>";

  	$result = $this->fetch_one_array($query);

  	$count = $result['0'];

  	

  	$p = new show_page;

  	$p->setvar($_GET);

  	$p->set($sizeOfPage, $count, $_GET['p']);

  	

  	$query = " SELECT * FROM  ".$this->table;

  	$query .= $clause." ORDER BY id  LIMIT ".$p->limit();

  	unset($result);

  	$result['content'] = $this->fetch_all_array($query);

  	$result['page']	= $p->output['1'];

  	return $result;

  }

  	

  function getAll()

  {

  	$query = " SELECT * FROM ".$this->table;

  	$result= $this->fetch_all_array($query);

  	return $result;

  }

  

  function getSearchByWhere($where)

  {	$clause = " WHERE 1 =1 ";

  	$clause .= empty($where) ? "" : " AND ".$where." ";

  	$query = " SELECT * FROM ".$this->table;

  	$query = " SELECT * FROM ".$this->table.$clause;		

  	$result= $this->fetch_all_array($query);

  	return $result;

  }

  

  function getSearchBySQL($sql)

  {	

  	$result= $this->fetch_all_array($sql);

  	return $result;

  }

  

  /**

   * 

   * @param $id

   */

  function getInfoBySQL($sql)

  {

  	$result = $this->fetch_one_array($sql);

  	return $result;

  }

  

  

  /**

   * 增加

   * @param $arr

   */

  function add($arr)

  {

  	$this->_insertFromArray($arr);

  }

  

  /**

   * 修改

   * @param $id

   * @param $arr

   */

  function edit($id,$arr)

  {

  	$clause = " WHERE id = ".$id;

  	$this->_updateFromArray($clause,$arr);

  	if($this->affected_rows() <= 0) return false;

  	return true;

  }

  

}

?>
