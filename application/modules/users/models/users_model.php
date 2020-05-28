<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model
{

	function __construct() {
		parent::__construct();
	}
	
	function check_status() {
		
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', $this->input->post('password'));
		$query    = $this->db->get('users_dash');
		$num_rows = $query->num_rows();
		$row      = $query->row();
		
		if($num_rows > 0){
			
			if($row->enable == 1){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	function can_login() {
		
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', $this->input->post('password'));
		$query = $this->db->get('users_dash');
		
		if($query->num_rows() == 1){
			
			$row = $query->row();
			if($row->type == 2){
				return false;
			} else {
				return true;
			}
			
		} else {
			return false;
		}
	}
	
	
	function in_group($user_id, $group_id) {
		
		$this->db->where('user_id', $user_id);
		$this->db->where('group_id', $group_id);
		$query = $this->db->get('users_groups');
		
		if($query->num_rows() == 1){
			return true;
		} else {
			return false;
		}
	}
	
}