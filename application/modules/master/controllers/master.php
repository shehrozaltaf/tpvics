<?php
class Master extends MX_Controller 

{

  function __construct() {
	parent::__construct();
	
	$this->load->model('master_model');
  }

  
  function get($table){
	  $query = $this->master_model->get($table);
	  return $query;
  }
  
  function get_with_limit($table, $limit, $offset, $order_by) {
	  if ((!is_numeric($limit)) || (!is_numeric($offset))) {
		  die('Non-numeric variable!');
	  }
  
	  $query = $this->master_model->get_with_limit($table, $limit, $offset, $order_by);
	  return $query;
  }
  
  function get_where($table, $id){
	  if (!is_numeric($id)) {
		  die('Non-numeric variable!');
	  }
  
	  $query = $this->master_model->get_where($table, $id);
	  return $query;
  }
  
  function get_where_custom($table, $col, $value){
	  $query = $this->master_model->get_where_custom($table, $col, $value);
	  return $query;
  }
  
  function _insert($table, $data){
	  $this->master_model->_insert($table, $data);
  }
  
  function _update($table, $id, $data){
	  if (!is_numeric($id)) {
		  die('Non-numeric variable!');
	  }
  
	  $this->master_model->_update($table, $id, $data);
  }
  
  function _update_where_custom($table, $col, $value, $data){
	  
	  $this->master_model->_update_where_custom($table, $col, $value, $data);
  }
  
  function _delete($table, $id){
	  if (!is_numeric($id)) {
		  die('Non-numeric variable!');
	  }
  
	  $this->master_model->_delete($table, $id);
  }
  
  function delete_where_custom($table, $column, $value){
  
	  $this->master_model->delete_where_custom($table, $column, $value);
  }
  
  function count_where($table, $column, $value){
	  $count = $this->master_model->count_where($table, $column, $value);
	  return $count;
  }
  
  function get_max($table){
	  $max_id = $this->master_model->get_max($table);
	  return $max_id;
  }
  
  function _custom_query($mysql_query){
  
	  $query = $this->master_model->_custom_query($mysql_query);
	  return $query;
  }
  
  
  function _get_OA($table, $column, $study_id){
  
	  $query = $this->master_model->_get_OA($table, $column, $study_id);
	  return $query;
  }
  
  public function _get_district_name($district_code){
		
	$data = $this->master->_custom_query("select district_name from districts where district_code = $district_code")->row();
	return $data->district_name;
  }
  
  public function _get_tehsil_name($tehsil_code){
		
	$data = $this->master->_custom_query("select tehsil_name from tehsils where tehsil_code = $tehsil_code")->row();
	return $data->tehsil_name;
  }

}