<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_model extends CI_Model
{

	function __construct() {
		
		parent::__construct();
		//$this->db = $this->load->database('nns_vasa', TRUE);
	}
	
	function get($table){
		$query = $this->db->get($table);
		return $query;
	}
	
	function get_with_limit($table, $limit, $offset, $order_by) {
		$this->db->limit($limit, $offset);
		$this->db->order_by($order_by);
		$query = $this->db->get($table);
		return $query;
	}
	
	function get_where($table, $id){
		$this->db->where('id', $id);
		$query = $this->db->get($table);
		return $query;
	}
	
	function get_where_custom($table, $col, $value) {
		$this->db->where($col, $value);
		$query = $this->db->get($table);
		return $query;
	}
	
	function _insert($table, $data){
		$this->db->insert($table, $data);
	}
	
	function _update($table, $id, $data){
		$this->db->where('id', $id);
		$this->db->update($table, $data);
	}
	
	function _update_where_custom($table, $col, $value, $data){
		$this->db->where($col, $value);
		$this->db->update($table, $data);
	}
	
	function _delete($table, $id){
		$this->db->where('id', $id);
		$this->db->delete($table);
	}
	
	function delete_where_custom($table, $column, $value){
		
		$this->db->where($column, $value);
		$this->db->delete($table);
  	}
	
	function count_where($table, $column, $value) {
		$this->db->where($column, $value);
		$query = $this->db->get($table);
		$num_rows = $query->num_rows();
		return $num_rows;
	}
	
	function count_all($table) {
		$query = $this->db->get($table);
		$num_rows = $query->num_rows();
		return $num_rows;
	}
	
	function get_max($table) {
		$this->db->select_max('id');
		$query = $this->db->get($table);
		$row = $query->row();
		$id = $row->id;
		return $id;
	}
	
	function _custom_query($mysql_query) {
		
		$query = $this->db->query($mysql_query);
		return $query;
	}
	
	public function get_status($cluster, $hhno){

		$data = $this->db->query("select top 1 * from forms where cluster_code = '$cluster' and hhno = '$hhno' and istatus in('1', '2', '3', '4', '5', '6', '7', '96') and username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434') order by col_id desc");

		if($data->num_rows() == 0){
			return 0;
		} else {
			return $data->row()->istatus;
		}
	}
	
	public function get_members($cluster, $hhno){

		$data = $uen_ml->query("select f.cluster_code, f.hhno,
		(select count(distinct serial_no) from familymembers where clusterno = f.cluster_code and hhno = f.hhno) as members,
		(select count(distinct serial_no) from familymembers where clusterno = f.cluster_code and hhno = f.hhno and gender = '2' and age > 14 and age < 50 and marital in('1', '3', '4')) as mwra,
		(select count(distinct serial_no) from familymembers where clusterno = f.cluster_code and hhno = f.hhno and age < 5) as under5_children
		from forms f
		where f.cluster_code = '$cluster' and f.hhno = '$hhno'
		and f.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
		and f.istatus in('1', '2', '3', '4', '5', '6', '7', '96')
		group by f.cluster_code, f.hhno
		order by f.hhno");

		return $data->result_array();
	}

    public function get_user($hh02, $hh03, $hh07, $tabNo)
    {
        $bl = $this->load->database('default', TRUE);
        $data = $bl->query("select username from listings where hh02 = '$hh02' and hh03 = '$hh03' and hh07 = '$hh07' and tabNo = '$tabNo'")->row();
        if (isset($data->username) && $data->username != '') {
            $username = $data->username;
        } else {
            $username = '';
        }
        return $username;
    }

    public function get_status_shehroz($cluster, $hhno)
    {

        /*http://localhost/uen/spc/randomized_households/252060*/
        $uen_ml = $this->load->database('uen_ml', TRUE);
        $sql = "SELECT
	istatus,
	hhno,cluster_code
FROM
	forms
WHERE
	cluster_code = '$cluster' 
AND hhno = '$hhno' 
AND istatus IN (
	'1',
	'2',
	'3',
	'4',
	'5',
	'6',
	'7',
	'96'
)
AND username NOT IN (
	'afg12345',
	'user0001',
	'user0113',
	'user0123',
	'user0211',
	'user0234',
	'user0252',
	'user0414',
	'user0432',
	'user0434'
)
ORDER BY
	col_id ASC";
        $data = $uen_ml->query($sql);
        $result = 0;
        if ($data->num_rows() == 0) {
            $result = 0;
        } else {
            foreach ($data->result_array as $k => $v) {
                if ($v['istatus'] == 1) {
                    $result = 1;
                    break;
                } else {
                    $result = $v['istatus'];
                }
            }
        }
        return $result;
    }
	
	function __destruct() {
		
		$this->db->close();
	}

}