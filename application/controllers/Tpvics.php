<?php error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Tpvics extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->scans = $this->load->database('default', TRUE);
        $this->data = null;
        //$this->form_validation->CI =& $this;
        $this->load->vars('current_url', $this->uri->uri_to_assoc(1));
        $this->load->module("master");
        $this->load->module("users");
        if (!$this->users->logged_in()) {
            redirect('index.php/users/login', 'refresh');
        }


    }


    function dashboard()
    {

        $this->data['heading'] = "Coverage Evaluation Survey, Pakistan, 2020";

        if ($this->users->in_group('admin') || $this->users->in_group('management')) {
            $total_clusters_by_district = $this->clusters_by_district('');
            $clusters_by_district = array();
            foreach ($total_clusters_by_district->result() as $row) {
                $myTotalArray = array();
                $myTotalArray['clusters_by_district'] = $row->clusters_by_district;
                if ($row->provinceId == 1) {
                    $myTotalArray['district'] = 'KHYBER PAKHTUNKHWA';
                } elseif ($row->provinceId == 2) {
                    $myTotalArray['district'] = 'PUNJAB';
                } elseif ($row->provinceId == 3) {
                    $myTotalArray['district'] = 'SINDH';
                } elseif ($row->provinceId == 4) {
                    $myTotalArray['district'] = 'BALOCHISTAN';
                } elseif ($row->provinceId == 7) {
                    $myTotalArray['district'] = 'GILGIT BALTISTAN';
                } elseif ($row->provinceId == 9) {
                    $myTotalArray['district'] = 'ADJACENT AREAS-FR';
                }
                $clusters_by_district[] = $myTotalArray;
            }
            $this->data['clusters_by_district'] = $clusters_by_district;

            $this->data['randomized_clusters'] = $this->scans->query("select SUBSTRING (clusters.dist_id, 1, 1) as dist_id,
			sum(case when randomized = '1' or randomized = '2' then 1 else 0 end) randomized_c
			from clusters  
			group by SUBSTRING (clusters.dist_id, 1, 1) order by dist_id");

            $c_r_clusters = $this->scans->query("select SUBSTRING (c.dist_id, 1, 1) as dist_id, c.cluster_no,
			(select count(*) from bl_randomised where dist_id = c.dist_id and hh02 = c.cluster_no) as hh_randomized,
			(select count(distinct hhno) from forms where dist_id = c.dist_id and cluster_code = c.cluster_no and cast(istatus as int) > 0 and cast(istatus as int) < 96 and istatus is not null and istatus != '' and istatus != 'null') as hh_collected
			from clusters c   order by c.dist_id");

            $cc_d1 = 0;
            $cc_d2 = 0;
            $cc_d3 = 0;
            $cc_d4 = 0;
            $cc_d7 = 0;
            $cc_d9 = 0;

            $rc_d1 = 0;
            $rc_d2 = 0;
            $rc_d3 = 0;
            $rc_d4 = 0;
            $rc_d7 = 0;
            $rc_d9 = 0;

            foreach ($c_r_clusters->result() as $r) {

                if ($r->dist_id == '1') {
                    if ($r->hh_collected == 20) {
                        $cc_d1 = $cc_d1 + 1;
                    } else {
                        $rc_d1 = $rc_d1 + 1;
                    }
                } else if ($r->dist_id == '2') {
                    if ($r->hh_collected == 20) {
                        $cc_d2 = $cc_d2 + 1;
                    } else {
                        $rc_d2 = $rc_d2 + 1;
                    }
                } else if ($r->dist_id == '3') {
                    if ($r->hh_collected == 20) {
                        $cc_d3 = $cc_d3 + 1;
                    } else {
                        $rc_d3 = $rc_d3 + 1;
                    }
                } else if ($r->dist_id == '4') {
                    if ($r->hh_collected == 20) {
                        $cc_d4 = $cc_d4 + 1;
                    } else {
                        $rc_d4 = $rc_d4 + 1;
                    }
                } else if ($r->dist_id == '7') {
                    if ($r->hh_collected == 20) {
                        $cc_d7 = $cc_d7 + 1;
                    } else {
                        $rc_d7 = $rc_d7 + 1;
                    }
                } else if ($r->dist_id == '9') {
                    if ($r->hh_collected == 20) {
                        $cc_d9 = $cc_d9 + 1;
                    } else {
                        $rc_d9 = $rc_d9 + 1;
                    }
                }
            }
// Completed Clusters
            $this->data['cc_d1'] = $cc_d1;
            $this->data['cc_d2'] = $cc_d2;
            $this->data['cc_d3'] = $cc_d3;
            $this->data['cc_d4'] = $cc_d4;
            $this->data['cc_d7'] = $cc_d7;
            $this->data['cc_d9'] = $cc_d9;
            $this->data['cc_total'] = $cc_d1 + $cc_d2 + $cc_d3 + $cc_d4 + $cc_d7 + $cc_d9;

            // Remaining Clusters
            $this->data['rc_d1'] = $rc_d1;
            $this->data['rc_d2'] = $rc_d2;
            $this->data['rc_d3'] = $rc_d3;
            $this->data['rc_d4'] = $rc_d4;
            $this->data['rc_d7'] = $rc_d7;
            $this->data['rc_d9'] = $rc_d9;
            $this->data['rc_total'] = $rc_d1 + $rc_d2 + $rc_d3 + $rc_d4 + $rc_d7 + $rc_d9;

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            if (!empty($this->uri->segment(3))) {

                $type = substr($this->uri->segment(3), 0, 2);
                $d = substr($this->uri->segment(3), 4, 3);

                if ($type == 'rc') {

                    $this->data['get_list'] = $this->scans->query("select l.enumcode, l.hh02,
					(select MAX(CAST(hh03 as int))  from listings   where enumcode = l.enumcode and hh02 = l.hh02)   as structures, 
					(select count(*) from(select distinct hh03, tabNo from listings where hh08a1 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as residential_structures) as residential_structures,
					sum(case when hh10 = '1'  then 1 else 0 end) as target_children,
					
					(select count(*) from bl_randomised where dist_id = l.enumcode and hh02 = l.hh02) as randomized_households,
					(select count(distinct rndid) from forms where SUBSTRING(cluster_code, 1, 1) = l.enumcode and cluster_code = l.hh02 and istatus = '1') as collected_households,
					(select SUM(CAST(hh13 as int)) from listings where hh10='1' and hh13!='null' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_children,
					(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
					(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = '9' group by deviceid) AS completed_tabs) completed_tabs
					from clusters c
					left join listings l on l.hh02 = c.cluster_no
					where l.enumcode = '$d' and (c.randomized = '1' or c.randomized = '2')
					and l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
					group by l.enumcode, l.hh02
					order by l.enumcode,l.hh02");


                } else if ($type == 'cc') {

                    $this->data['get_list'] = $this->scans->query("select l.enumcode, l.hh02,
					(select MAX(CAST(hh03 as int))  from listings   where enumcode = l.enumcode and hh02 = l.hh02)   as structures, 
					(select count(*) from(select distinct hh03, tabNo from listings where hh08a1 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as residential_structures) as residential_structures,
					sum(case when hh10 = '1'  then 1 else 0 end) as target_children,
					
					(select count(*) from bl_randomised where dist_id = l.enumcode and hh02 = l.hh02) as randomized_households,
					(select count(distinct rndid) from forms where SUBSTRING(cluster_code, 1, 1) = l.enumcode and cluster_code = l.hh02 and istatus = '1') as collected_households,
					(select SUM(CAST(hh13 as int)) from listings where hh10='1' and hh13!='null' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_children,
					(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
					(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = '9' group by deviceid) AS completed_tabs) completed_tabs
					from clusters c
					left join listings l on l.hh02 = c.cluster_no
					where l.enumcode = '$d' and (c.randomized = '1' or c.randomized = '2')
					and l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
					and (select count(*) from bl_randomised where dist_id = l.enumcode and hh02 = l.hh02) = (select count(distinct rndid) from forms where SUBSTRING(cluster_code, 1, 3) = l.enumcode and cluster_code = l.hh02 and istatus > 0 and istatus < 96 and istatus is not null and istatus != '' and istatus != 'null')
					group by l.enumcode, l.hh02
					order by l.enumcode,l.hh02");

                } else if ($type == 'ic') {

                    $this->data['get_list'] = $this->scans->query("select l.enumcode, l.hh02,
					(select MAX(CAST(hh03 as int))  from listings   where enumcode = l.enumcode and hh02 = l.hh02)   as structures, 
					(select count(*) from(select distinct hh03, tabNo from listings where hh08a1 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as residential_structures) as residential_structures,
					sum(case when hh10 = '1'  then 1 else 0 end) as target_children,
					
					(select count(*) from bl_randomised where dist_id = l.enumcode and hh02 = l.hh02) as randomized_households,
					(select count(distinct rndid) from forms where SUBSTRING(cluster_code, 1, 1) = l.enumcode and cluster_code = l.hh02 and istatus = '1') as collected_households,
					(select SUM(CAST(hh13 as int)) from listings where hh10='1' and hh13!='null' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_children,
					(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
					(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = '9' group by deviceid) AS completed_tabs) completed_tabs
					from clusters c
					left join listings l on l.hh02 = c.cluster_no
					where l.enumcode = '$d' and (c.randomized = '1' or c.randomized = '2')
					and l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
					and (select count(*) from bl_randomised where dist_id = l.enumcode and hh02 = l.hh02) > (select count(distinct rndid) from forms where SUBSTRING(cluster_code, 1, 3) = l.enumcode and cluster_code = l.hh02 and istatus > 0 and istatus < 96 and istatus is not null and istatus != '' and istatus != 'null')
					group by l.enumcode, l.hh02
					order by l.enumcode,l.hh02");

                }

            } else {
                $this->data['get_list'] = $this->scans->query("select SUBSTRING (l.enumcode, 1, 1) as enumcode, l.hh02,
				(select MAX(CAST(hh03 as int))  from listings   where enumcode = l.enumcode and hh02 = l.hh02)   as structures, 
				(select count(*) from(select distinct hh03, tabNo from listings where hh08a1 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as residential_structures) as residential_structures,
				sum(case when hh10 = '1'  then 1 else 0 end) as target_children,
				
				(select count(*) from bl_randomised where dist_id = l.enumcode and hh02 = l.hh02) as randomized_households,
				
				(select SUM(CAST(hh13 as int)) from listings where hh10='1' and hh13!='null' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_children,
				(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
				(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = '9' group by deviceid) AS completed_tabs) completed_tabs
				from clusters c
				left join listings l on l.hh02 = c.cluster_no
				where   l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
				group by l.enumcode, l.hh02
				order by l.enumcode,l.hh02");
                /* $this->data['get_list'] = $this->scans->query("select l.enumcode, l.hh02,
                 (select MAX(CAST(hh03 as int))  from listings   where enumcode = l.enumcode and hh02 = l.hh02)   as structures, 
                 (select count(*) from(select distinct hh03, tabNo from listings where hh08a1 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as residential_structures) as residential_structures,
                 sum(case when hh10 = '1'  then 1 else 0 end) as target_children,
                 
                 (select count(*) from bl_randomised where dist_id = l.enumcode and hh02 = l.hh02) as randomized_households,
                 (select count(distinct rndid) from forms where SUBSTRING(cluster_code, 1, 1) = l.enumcode and cluster_code = l.hh02 and istatus = '1') as collected_households,
                 (select SUM(CAST(hh13 as int)) from listings where hh10='1' and hh13!='null' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_children,
                 (select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
                 (select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = '9' group by deviceid) AS completed_tabs) completed_tabs
                 from clusters c
                 left join listings l on l.hh02 = c.cluster_no
                 where (c.randomized = '1' or c.randomized = '2')
                 and l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
                 group by l.enumcode, l.hh02
                 order by l.enumcode,l.hh02");*/
            }


        } else {

            $id = $this->users->get_user()->id;
            $district = $this->users->get_district($id);

            $this->data['clusters_by_district'] = $this->scans->query("select dist_id, 
			count(*) clusters_by_district from clusters where dist_id = '$district'
			group by dist_id order by dist_id");


            $this->data['randomized_clusters'] = $this->scans->query("select dist_id,
			sum(case when randomized = '1' or randomized = '2' then 1 else 0 end) randomized_c
			from clusters where dist_id = '$district' 
			group by dist_id order by dist_id");


            $c_r_clusters = $this->scans->query("select c.dist_id, c.cluster_no,
			(select count(*) from bl_randomised where dist_id = c.dist_id and hh02 = c.cluster_no) as hh_randomized,
			(select count(distinct hhno) from forms where dist_id = c.dist_id and cluster_code = c.cluster_no and cast(istatus as int) > 0 and cast(istatus as int) < 96 and istatus is not null and istatus != '' and istatus != 'null') as hh_collected
			from clusters c
			where (c.randomized = '1' or c.randomized = '2') and c.dist_id = '$district'
			group by c.dist_id, c.cluster_no order by c.dist_id");

            $cc_d2 = 0;
            $cc_d3 = 0;

            $rc_d2 = 0;
            $rc_d3 = 0;

            foreach ($c_r_clusters->result() as $r) {

                if ($r->dist_id == '2') {

                    if ($r->hh_collected == 20) {
                        $rc_d2 = $rc_d2 + 1;
                    } else {
                        $cc_d2 = $cc_d2 + 1;
                    }

                } else if ($r->dist_id == '3') {

                    if ($r->hh_collected == 20) {
                        $rc_d3 = $rc_d3 + 1;
                    } else {
                        $cc_d3 = $cc_d3 + 1;
                    }
                }
            }

            // Completed Clusters
            $this->data['cc_d2'] = $cc_d2;
            $this->data['cc_d3'] = $cc_d3;
            $this->data['cc_total'] = $cc_d2 + $cc_d3;

            // Remaining Clusters
            $this->data['rc_d2'] = $rc_d2;
            $this->data['rc_d3'] = $rc_d3;
            $this->data['rc_total'] = $rc_d2 + $rc_d3;


            $this->data['get_list'] = $this->scans->query("select l.enumcode, l.hh02,
			(select MAX(CAST(hh03 as int))  from listings   where enumcode = l.enumcode and hh02 = l.hh02)   as structures, 
			(select count(*) from(select distinct hh03, tabNo from listings where hh08a1 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as residential_structures) as residential_structures,
			sum(case when hh10 = '1'  then 1 else 0 end) as target_children,
			
			(select count(*) from bl_randomised where dist_id = l.enumcode and hh02 = l.hh02) as randomized_households,
			(select count(distinct rndid) from forms where SUBSTRING(cluster_code, 1, 1) = l.enumcode and cluster_code = l.hh02 and istatus = '1') as collected_households,
			(select SUM(CAST(hh13 as int)) from listings where hh10='1' and hh13!='null' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_children,
			(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
			(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = '9' group by deviceid) AS completed_tabs) completed_tabs
			from clusters c
			left join listings l on l.hh02 = c.cluster_no
			where l.enumcode = '$district' and (c.randomized = '1' or c.randomized = '2')
			and l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
			group by l.enumcode, l.hh02
			order by l.enumcode,l.hh02");

        }

        $this->data['message'] = $this->session->flashdata('message');
        $this->data['main_content'] = 'scans/dashboard';
        $this->load->view('includes/template', $this->data);
    }


    function clusters_by_district($district)
    {
        if (isset($district) && $district != '') {
            $dist_where = "where dist_id = '$district' ";
        } else {
            $dist_where = '';
        }
        /*return $this->scans->query("select (case
			when dist_id like '1%' then 'KHYBER PAKHTUNKHWA'
			when dist_id like '2%' then 'PUNJAB'
			when dist_id like '3%' then 'SINDH'
			when dist_id like '4%' then 'BALOCHISTAN'
			when dist_id like '5%' then 'FATA'
			when dist_id like '6%' then 'FEDERAL CAPITAL '
			when dist_id like '7%' then 'GILGIT BALTISTAN'
			when dist_id like '8%' then 'AZAD JAMMU'
			when dist_id like '9%' then 'ADJACENT AREAS-FR'
			else '' end) as district, 
			count(*) clusters_by_district 
			from clusters  
			$dist_where
			group by dist_id order by dist_id");*/
        return $this->scans->query("SELECT
                                SUBSTRING (dist_id, 1, 1) AS provinceId,
                                COUNT (*) clusters_by_district
                            FROM
                                clusters
                            GROUP BY
                                SUBSTRING (dist_id, 1, 1)");
    }

    function index()
    {
        if (!$this->users->in_group('admin')) {
            redirect('index.php/Tpvics/sync_report');
        }

        $this->data['heading'] = "Coverage Evaluation Survey, Pakistan, 2020";
        if ($this->users->in_group('admin') || $this->users->in_group('management')) {
            $total_clusters_by_district = $this->clusters_by_district('');
            $clusters_by_district = array();
            foreach ($total_clusters_by_district->result() as $row) {
                $myTotalArray = array();
                $myTotalArray['clusters_by_district'] = $row->clusters_by_district;
                if ($row->provinceId == 1) {
                    $myTotalArray['district'] = 'KHYBER PAKHTUNKHWA';
                } elseif ($row->provinceId == 2) {
                    $myTotalArray['district'] = 'PUNJAB';
                } elseif ($row->provinceId == 3) {
                    $myTotalArray['district'] = 'SINDH';
                } elseif ($row->provinceId == 4) {
                    $myTotalArray['district'] = 'BALOCHISTAN';
                } elseif ($row->provinceId == 7) {
                    $myTotalArray['district'] = 'GILGIT BALTISTAN';
                } elseif ($row->provinceId == 9) {
                    $myTotalArray['district'] = 'ADJACENT AREAS-FR';
                }
                $clusters_by_district[] = $myTotalArray;
            }
            $this->data['clusters_by_district'] = $clusters_by_district;

            $cip_clusters = $this->scans->query("select l.enumcode, l.hh02,  SUBSTRING (c.dist_id, 1, 1) AS provinceId,
			(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
			(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9 group by deviceid) AS completed_tabs) completed_tabs
			from clusters c
			left join listings l on l.hh02 = c.cluster_no
			where l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
			group by l.enumcode, l.hh02,c.dist_id
			order by l.enumcode,l.hh02");
            /* echo '<pre>';
             print_r($cip_clusters->result());
             echo '</pre>';
             exit();*/
            $d1_t = 0;
            $d2_t = 0;
            $d3_t = 0;
            $d4_t = 0;
            $d7_t = 0;
            $d9_t = 0;

            $d1_c = 0;
            $d2_c = 0;
            $d3_c = 0;
            $d4_c = 0;
            $d7_c = 0;
            $d9_c = 0;

            $d1_ip = 0;
            $d2_ip = 0;
            $d3_ip = 0;
            $d4_ip = 0;
            $d7_ip = 0;
            $d9_ip = 0;

            foreach ($cip_clusters->result() as $row) {
                if ($row->provinceId == 1) {
                    $d1_t = $d1_t + 1;
                    if ($row->collecting_tabs == $row->completed_tabs) {
                        $d1_c = $d1_c + 1;
                    } else {
                        $d1_ip = $d1_ip + 1;
                    }
                } else if ($row->provinceId == 2) {
                    $d2_t = $d2_t + 1;
                    if ($row->collecting_tabs == $row->completed_tabs) {
                        $d2_c = $d2_c + 1;
                    } else {
                        $d2_ip = $d2_ip + 1;
                    }
                } else if ($row->provinceId == 3) {
                    $d3_t = $d3_t + 1;
                    if ($row->collecting_tabs == $row->completed_tabs) {
                        $d3_c = $d3_c + 1;
                    } else {
                        $d3_ip = $d3_ip + 1;
                    }
                } else if ($row->provinceId == 4) {
                    $d4_t = $d4_t + 1;
                    if ($row->collecting_tabs == $row->completed_tabs) {
                        $d4_c = $d4_c + 1;
                    } else {
                        $d4_ip = $d4_ip + 1;
                    }
                } else if ($row->provinceId == 7) {
                    $d7_t = $d7_t + 1;
                    if ($row->collecting_tabs == $row->completed_tabs) {
                        $d7_c = $d7_c + 1;
                    } else {
                        $d7_ip = $d7_ip + 1;
                    }
                } else if ($row->provinceId == 9) {
                    $d9_t = $d9_t + 1;
                    if ($row->collecting_tabs == $row->completed_tabs) {
                        $d9_c = $d9_c + 1;
                    } else {
                        $d9_ip = $d9_ip + 1;
                    }
                }
            }

            $this->data['d1_t'] = $d1_t;
            $this->data['d2_t'] = $d2_t;
            $this->data['d3_t'] = $d3_t;
            $this->data['d4_t'] = $d4_t;
            $this->data['d7_t'] = $d7_t;
            $this->data['d9_t'] = $d9_t;

            $this->data['d1_c'] = $d1_c;
            $this->data['d2_c'] = $d2_c;
            $this->data['d3_c'] = $d3_c;
            $this->data['d4_c'] = $d4_c;
            $this->data['d7_c'] = $d7_c;
            $this->data['d9_c'] = $d9_c;

            $this->data['d1_ip'] = $d1_ip;
            $this->data['d2_ip'] = $d2_ip;
            $this->data['d3_ip'] = $d3_ip;
            $this->data['d4_ip'] = $d4_ip;
            $this->data['d7_ip'] = $d7_ip;
            $this->data['d9_ip'] = $d9_ip;

//            $all_clusters = $this->scans->query("select dist_id, count(*) clusters_by_district from clusters group by dist_id order by dist_id");
            $all_clusters = $total_clusters_by_district;
            $this->data['d1_r'] = 0;
            $this->data['d2_r'] = 0;
            $this->data['d3_r'] = 0;
            $this->data['d4_r'] = 0;
            $this->data['d7_r'] = 0;
            $this->data['d9_r'] = 0;
            foreach ($all_clusters->result() as $row2) {
                if ($row2->provinceId == 1) {
                    $this->data['d1_r'] = $row2->clusters_by_district - $d1_t;
                } else if ($row2->provinceId == 2) {
                    $this->data['d2_r'] = $row2->clusters_by_district - $d2_t;
                } else if ($row2->provinceId == 3) {
                    $this->data['d3_r'] = $row2->clusters_by_district - $d3_t;
                } else if ($row2->provinceId == 4) {
                    $this->data['d4_r'] = $row2->clusters_by_district - $d4_t;
                } else if ($row2->provinceId == 7) {
                    $this->data['d7_r'] = $row2->clusters_by_district - $d7_t;
                } else if ($row2->provinceId == 9) {
                    $this->data['d9_r'] = $row2->clusters_by_district - $d9_t;
                }
            }
            $this->data['gt_c'] = $d1_c + $d2_c + $d3_c + $d4_c + $d7_c + $d9_c;
            $this->data['gt_ip'] = $d1_ip + $d2_ip + $d3_ip + $d4_ip + $d7_ip + $d9_ip;
            $this->data['gt_r'] = $this->data['d1_r'] + $this->data['d2_r'] + $this->data['d3_r'] + $this->data['d4_r']
                + $this->data['d7_r'] + $this->data['d9_r'];
            $district_cluster_type = $this->uri->segment(3);
            if (!empty($district_cluster_type)) {
                $district = substr($district_cluster_type, 1, 1);
                $cluster_type = substr($district_cluster_type, 3, 1);

                if ($cluster_type == 'c') {
                    $this->data['get_list'] = $this->scans->query("SELECT
	l.enumcode,
	l.hh02, 
(select MAX(CAST(hh03 as int))  from listings   where enumcode = l.enumcode and hh02 = l.hh02)   as structures, 
(select count(*) from(select distinct hh03, tabNo from listings where hh08a1 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as residential_structures) as residential_structures,
sum(case when hh10 = '1'  then 1 else 0 end) as target_children,
(select SUM(CAST(hh13 as int)) from listings where hh10='1' and hh13!='null' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_children,
(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9 group by deviceid) AS completed_tabs) completed_tabs,
(select hh04   from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9  group by hh02,hh04 ) as status 
					from clusters c
					left join listings l on l.hh02 = c.cluster_no
					where SUBSTRING (c.dist_id, 1, 1) = '$district' and l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
					and (select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) = (select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9 group by deviceid) AS completed_tabs)
					group by l.enumcode, l.hh02
					order by l.enumcode,l.hh02");
                } else {

                    $this->data['get_list'] = $this->scans->query("SELECT
	l.enumcode,
	l.hh02, 
(select MAX(CAST(hh03 as int))  from listings   where enumcode = l.enumcode and hh02 = l.hh02)   as structures, 
(select count(*) from(select distinct hh03, tabNo from listings where hh08a1 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as residential_structures) as residential_structures,
sum(case when hh10 = '1'  then 1 else 0 end) as target_children,
(select SUM(CAST(hh13 as int)) from listings where hh10='1' and hh13!='null' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_children,
(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9 group by deviceid) AS completed_tabs) completed_tabs,
(select hh04   from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9  group by hh02,hh04 ) as status 
from clusters c
					left join listings l on l.hh02 = c.cluster_no
					where SUBSTRING (c.dist_id, 1, 1) = '$district' and l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
					and (select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) != (select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9 group by deviceid) AS completed_tabs)
					group by l.enumcode, l.hh02
					order by l.enumcode,l.hh02");
                }
            } else {
                $this->data['get_list'] = $this->scans->query("SELECT
	l.enumcode,
	l.hh02, 
(select MAX(CAST(hh03 as int))  from listings   where enumcode = l.enumcode and hh02 = l.hh02)   as structures, 
(select count(*) from(select distinct hh03, tabNo from listings where hh08a1 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as residential_structures) as residential_structures,
sum(case when hh10 = '1'  then 1 else 0 end) as target_children,
(select SUM(CAST(hh13 as int)) from listings where hh10='1' and hh13!='null' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_children,
(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9 group by deviceid) AS completed_tabs) completed_tabs,
(select hh04   from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9  group by hh02,hh04 ) as status 
                              from clusters c
                            left join listings l on l.hh02 = c.cluster_no
                              where   l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
                                group by l.enumcode, l.hh02
                            order by l.enumcode,l.hh02");


            }
        } else {
            /*else*/
            $id = $this->users->get_user()->id;
            $district = $this->users->get_district($id);
            $this->data['clusters_by_district'] = $this->scans->query("select (case
			when dist_id = '2' then 'Punjab'
			else 'Sindh' end) as district, 
			count(*) clusters_by_district from clusters where dist_id = '$district'
			group by dist_id order by dist_id");
            $cip_clusters = $this->scans->query("select l.enumcode, l.hh02,
			(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
			(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9 group by deviceid) AS completed_tabs) completed_tabs
			from clusters c
			left join listings l on l.hh02 = c.cluster_no
			where l.enumcode = '$district' and l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
			group by l.enumcode, l.hh02
			order by l.enumcode,l.hh02");
            $d2_t = 0;
            $d3_t = 0;
            $d2_c = 0;
            $d3_c = 0;
            $d2_ip = 0;
            $d3_ip = 0;
            foreach ($cip_clusters->result() as $row) {
                if ($row->enumcode == 2) {

                    $d2_t = $d2_t + 1;

                    if ($row->collecting_tabs == $row->completed_tabs) {
                        $d2_c = $d2_c + 1;
                    } else {
                        $d2_ip = $d2_ip + 1;
                    }

                } else if ($row->enumcode == 3) {

                    $d3_t = $d3_t + 1;

                    if ($row->collecting_tabs == $row->completed_tabs) {
                        $d3_c = $d3_c + 1;
                    } else {
                        $d3_ip = $d3_ip + 1;
                    }

                }
            }

            $this->data['d2_t'] = $d2_t;
            $this->data['d3_t'] = $d3_t;

            $this->data['d2_c'] = $d2_c;
            $this->data['d3_c'] = $d3_c;

            $this->data['d2_ip'] = $d2_ip;
            $this->data['d3_ip'] = $d3_ip;

            $all_clusters = $this->scans->query("select dist_id, count(*) clusters_by_district from clusters where dist_id = '$district' group by dist_id order by dist_id");

            $this->data['d2_r'] = 0;
            $this->data['d3_r'] = 0;

            foreach ($all_clusters->result() as $row2) {

                if ($row2->dist_id == 2) {
                    $this->data['d2_r'] = $row2->clusters_by_district - $d2_t;
                } else if ($row2->dist_id == 3) {
                    $this->data['d3_r'] = $row2->clusters_by_district - $d3_t;
                }
            }

            $this->data['gt_c'] = $d2_c + $d3_c;
            $this->data['gt_ip'] = $d2_ip + $d3_ip;
            $this->data['gt_r'] = $this->data['d2_r'] + $this->data['d3_r'];

            $this->data['get_list'] = $this->scans->query("
            SELECT
	l.enumcode,
	l.hh02, 
(select MAX(CAST(hh03 as int))  from listings   where enumcode = l.enumcode and hh02 = l.hh02)   as structures, 
(select count(*) from(select distinct hh03, tabNo from listings where hh08a1 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as residential_structures) as residential_structures,
sum(case when hh10 = '1'  then 1 else 0 end) as target_children,
(select SUM(CAST(hh13 as int)) from listings where hh10='1' and hh13!='null' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_children,
(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9 group by deviceid) AS completed_tabs) completed_tabs,
(select hh04   from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9  group by hh02,hh04 ) as status 
			from clusters c
			left join listings l on l.hh02 = c.cluster_no
			where l.enumcode = '$district' and l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
			and (select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) = (select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9 group by deviceid) AS completed_tabs)
			group by l.enumcode, l.hh02
			order by l.enumcode,l.hh02");
        }

        $myStatusArr = array();

        $randomized = $this->scans->query("SELECT a.hh02, a.hh04 FROM listings a   WHERE a.hh04 = 9 and 
EXISTS ( SELECT b.hh02 FROM bl_randomised b WHERE a.hh02 = b.hh02 )  group by a.hh02, a.hh04;");
        foreach ($randomized->result() as $row) {
            $myStatusArr[$row->hh02] = 'Randomized';
        }
        $ready_to_randomized = $this->scans->query("SELECT a.hh02, a.hh04 FROM listings a   WHERE a.hh04 = 9 and 
not EXISTS ( SELECT b.hh02 FROM bl_randomised b WHERE a.hh02 = b.hh02 ) group by a.hh02, a.hh04;");
        foreach ($ready_to_randomized->result() as $row) {
            if (!isset($myStatusArr[$row->hh02]) || $row->hh02 == '') {
                $myStatusArr[$row->hh02] = 'Ready to Randomize';
            }
        }
        $progress = $this->scans->query("SELECT a.hh02 FROM listings a   WHERE a.hh04 != 9  group by a.hh02 ;");
        foreach ($progress->result() as $row) {
            if (!isset($myStatusArr[$row->hh02]) || $row->hh02 == '') {
                $myStatusArr[$row->hh02] = 'In Progress';
            }
        }
        $this->data['status'] = $myStatusArr;

        $this->data['message'] = $this->session->flashdata('message');
        $this->data['main_content'] = 'scans/index';
        $this->load->view('includes/template', $this->data);
    }



    function systematic_randomizer()
    {
        $source = 'listings';
        $sample = 30;
        $columns = 'col_id, hh02, tabNo, hh03,  hh07, hh08, hh09, enumcode, uid';

        $cluster = $this->uri->segment(3);
        $randomization_status = $this->scans->query("select randomized from clusters where cluster_no = '$cluster'")->row()->randomized;

        if ($randomization_status == 1) {
            $flash_msg = "Cluster No " . $cluster . " is Already Randomized";
            $value = '<div class="callout callout-warning"><p>' . $flash_msg . '</p></div>';
            $this->session->set_flashdata('message', $value);
            if ($this->users->in_group('admin') || $this->users->in_group('management')) {
                redirect('index.php/Tpvics/index/' . $this->uri->segment(4));
            } else {
                redirect('index.php/Tpvics/index');
            }
        }
        $dataset = $this->scans->query("select " . $columns . " from " . $source . "
		where username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
		and hh08a1 = '1' and hh10 = '1'  and hh02 = '$cluster' order by tabNo, deviceid, cast(hh03 as int), cast(hh07 as int)");
        if ($dataset->num_rows() > 0) {
            $residential_structures = $this->scans->query("select distinct hh03, tabNo from listings where hh02 = '$cluster' and hh08a1 = '1'")->num_rows();
            $this->scans->query("update clusters set randomized = '1' where cluster_no = '$cluster'");
            if ($dataset->num_rows() > $sample) {
                $quotient = $dataset->num_rows() / $sample;
                $random_start = rand(1, $quotient);
                $random_point = $random_start;
                $index = floor($random_start);
                $result = $dataset->result_array();
                for ($i = 1; $i <= 30; $i++) {
                    $data = array(
                        'randDT' => date('Y-m-d h:i:s'),
                        'uid' => $result[$index - 1]['uid'],
                        'sno' => $i,
                        'hh02' => $result[$index - 1]['hh02'],
                        'hh03' => $result[$index - 1]['hh03'],
                        'hh07' => $result[$index - 1]['hh07'],
                        'hh08' => $result[$index - 1]['hh08'],
                        'hh09' => $result[$index - 1]['hh09'],
                        'total' => $residential_structures,
                        'randno' => $random_start,
                        'quot' => $quotient,
                        'hhdt' => $result[$index - 1]['hhdt'],
                        'dist_id' => $result[$index - 1]['enumcode'],
                        'compid' => $result[$index - 1]['hh02'] . "-" . str_pad($result[$index - 1]['hh03'], 4, "0", STR_PAD_LEFT) . "-" . str_pad($result[$index - 1]['hh07'], 3, "0", STR_PAD_LEFT),
                        'tabNo' => $result[$index - 1]['tabNo'],
                    );
                    $this->scans->insert('bl_randomised', $data);
                    $random_point = $random_point + $quotient;
                    $index = floor($random_point);
                }

                $flash_msg = "Cluster No " . $cluster . " Randomized successfully";
                $value = '<div class="callout callout-success"><p>' . $flash_msg . '</p></div>';
                $this->session->set_flashdata('message', $value);
                if ($this->users->in_group('admin') || $this->users->in_group('management')) {
                    redirect('index.php/Tpvics/index/' . $this->uri->segment(4));
                } else {
                    redirect('index.php/Tpvics/index');
                }
            } else {
                $result = $dataset->result_array();
                $quotient = $dataset->num_rows() / count($result);
                $random_start = rand(1, $quotient);
                for ($i = 0; $i < count($result); $i++) {
                    $data = array(
                        'randDT' => date('Y-m-d h:i:s'),
                        'uid' => $result[$i]['uid'],
                        'sno' => $i + 1,
                        'hh02' => $result[$i]['hh02'],
                        'hh03' => $result[$i]['hh03'],
                        'hh07' => $result[$i]['hh07'],
                        'hh08' => $result[$i]['hh08'],
                        'hh09' => $result[$i]['hh09'],
                        'total' => $residential_structures,
                        'randno' => $random_start,
                        'quot' => $quotient,
                        'hhdt' => $result[$i]['hhdt'],
                        'dist_id' => $result[$i]['enumcode'],
                        'compid' => $result[$i]['hh02'] . "-" . str_pad($result[$i]['hh03'], 4, "0", STR_PAD_LEFT) . "-" . str_pad($result[$i]['hh07'], 3, "0", STR_PAD_LEFT),
                        'tabNo' => $result[$i]['tabNo'],
                    );
                    $this->scans->insert('bl_randomised', $data);
                }
                $flash_msg = "Cluster No " . $cluster . " Randomized successfully";
                $value = '<div class="callout callout-success"><p>' . $flash_msg . '</p></div>';
                $this->session->set_flashdata('message', $value);
                if ($this->users->in_group('admin') || $this->users->in_group('management')) {
                    redirect('index.php/Tpvics/index/' . $this->uri->segment(4));
                } else {
                    redirect('index.php/Tpvics/index');
                }
            }
        } else {
            $flash_msg = "Cluster No " . $cluster . " Has Zero Households";
            $value = '<div class="callout callout-danger"><p>' . $flash_msg . '</p></div>';
            $this->session->set_flashdata('message', $value);
            if ($this->users->in_group('admin') || $this->users->in_group('management')) {
                redirect('index.php/Tpvics/index/' . $this->uri->segment(4));
            } else {
                redirect('index.php/Tpvics/index');
            }
        }
    }


    function make_pdf()
    {

        $this->load->library('tcpdf');
        $cluster = $this->uri->segment(3);
        $this->data['cluster'] = $this->uri->segment(3);
        $this->data['cluster_data'] = $this->scans->query("select bl_randomised.randDT,
	bl_randomised.sno,
	bl_randomised.hh02,
	bl_randomised.hh03,
	bl_randomised.hh05,
	bl_randomised.hh07,
	bl_randomised.hh08,
	bl_randomised.hh09,
	bl_randomised.hhss,
	bl_randomised.compid,
	bl_randomised.total,
	bl_randomised.randno,
	bl_randomised.quot,
	bl_randomised.ssno,
	bl_randomised.hhdt,
	bl_randomised.dist_id,
	bl_randomised.[tabNo ],
	clusters.geoarea
FROM
	bl_randomised
LEFT JOIN clusters ON bl_randomised.hh02 = clusters.cluster_no where bl_randomised.hh02 = '$cluster'");
        $rd = $this->scans->query("select top 1 randDT from bl_randomised where hh02 = '$cluster'")->row()->randDT;
        $this->data['randomization_date'] = substr($rd, 0, 10);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 048');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $geoarea = explode('|', $this->data['cluster_data']->row()->geoarea);

        $pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, 'TPVICS', 'Cluster No: ' . $cluster . "\n" . 'Province: ' . $geoarea[0]
            . "\n" . 'District: ' . $geoarea[1] . "\n" . 'Tehsil: ' . $geoarea[2] . "\n" . 'Area: ' . $geoarea[3]);
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 15, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->AddPage();
        $pdf->Write(0, 'Randomization Date: ' . $this->data['randomization_date'], '', 0, 'R', true, 0, false, false, 0);
        $pdf->SetFont('helvetica', '', 9);
        $tbl = '<table border="1" cellpadding="2" cellspacing="2" nobr="true">
                 <tr>
                  <th width="10%" style="text-align:center"><b>Serial No</b></th> 
                  <th width="20%" style="text-align:center"><b>Household No</b></th>
                  <th width="20%" style="text-align:center"><b>Head of Household</b></th>
                  <th width="50%" style="text-align:center"><b>Remarks</b></th>
                 </tr>';


        foreach ($this->data['cluster_data']->result('array') as $row) {
            $tbl .= '<tr><td>' . $row['sno'] . '</td> 
<td>' . $row['tabNo '] . '-' . substr($row['compid'], 8, 8) . '</td>
<td>' . ucfirst($row['hh08']) . '</td>
<td></td>
</tr>';
        }
        $tbl .= '</table>';
        $pdf->writeHTML($tbl, true, false, true, false, '');
        ob_clean();
        ob_flush();
        $pdf->Output('example_007.pdf', 'I');
        ob_end_flush();
        ob_end_clean();
    }

    function get_excel()
    {
        $cluster = $this->uri->segment(3);
        $this->data['cluster_data'] = $this->scans->query("select sno, tabNo, substring(compid, 9, 8) household, hh08 from bl_randomised where hh02 = '$cluster'");
        $rd = $this->scans->query("select top 1 randDT from bl_randomised where hh02 = '$cluster'")->row()->randDT;
        $this->data['randomization_date'] = substr($rd, 0, 10);
        $get_geoarea = $this->scans->query("select geoarea from clusters where cluster_no = '$cluster'")->row()->geoarea;
        $division = explode("|", $get_geoarea);
        $this->data['division'] = ltrim(rtrim($division[1]));
        $this->data['cluster'] = $this->uri->segment(3);
        $this->data['heading'] = "Get Excel";
        $this->data['main_content'] = 'scans/get_excel';
        $this->load->view('includes/template', $this->data);
    }


    function cluster_progress()
    {

        $cluster = $this->uri->segment(3);
        $this->data['get_list'] = $this->scans->query("select distinct hhno,
		(select count(*) from forms  where cluster_code = f.cluster_code and hhno = f.hhno and username = f.username and istatus = '1') as forms,
		(select count(*) from hb	 where cluster_no   = f.cluster_code and hhno = f.hhno and username = f.username) as hb,
		(select count(*) from vision where cluster_no   = f.cluster_code and hhno = f.hhno and username = f.username) as vision,
		(select count(*) from anthro where cluster_no   = f.cluster_code and hhno = f.hhno and username = f.username) as anthro
		from forms f
		where f.cluster_code = '$cluster' and f.istatus = '1'
		and f.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
		and f.cluster_code not like '%501' and f.cluster_code not like '%502'
		order by f.hhno");

        //var_dump($this->data['get_list']->result());die();

        $this->data['heading'] = "Collection Progress for Cluster No: " . $cluster;

        $this->data['main_content'] = 'scans/cluster_progress';
        $this->load->view('includes/template', $this->data);
    }

    function test_data()
    {

        echo dirname(__FILE__);
    }

    function randomized_households()
    {

        $cluster = $this->uri->segment(3);
        $this->data['get_list'] = $this->scans->query("select hh02, sno, concat(tabNO, '-', substring(compid, 8, 8)) as hhno from bl_randomised where hh02 = '$cluster' order by cast(sno as int)");

        //var_dump($this->data['get_list']->result());die();

        $this->data['heading'] = "Randomized Households for Cluster No: " . $cluster;

        $this->data['main_content'] = 'scans/randomized_households';
        $this->load->view('includes/template', $this->data);
    }

    function collected_households()
    {

        $cluster = $this->uri->segment(3);
        $this->data['get_list'] = $this->scans->query("select distinct cluster_code, hhno from forms where cluster_code = '$cluster' and istatus in('1', '2', '3', '4', '5', '6', '7', '96')");

        //var_dump($this->data['get_list']->result());die();

        $this->data['heading'] = "Collected Households for Cluster No: " . $cluster;

        $this->data['main_content'] = 'scans/collected_households';
        $this->load->view('includes/template', $this->data);
    }

    /*

    function systematic_randomizer(){

        $random_no = floor(1000/20);

        $random_point = rand(1, $random_no);

        //echo $random_point; die();

        for($i = 1; $i <= 20; $i++){

            echo $i.":".$random_point.'<br>';

            $random_point = floor($random_point + $random_no);
        }
    }


    function insert_data(){

        for($i = 1; $i <= 1000; $i++){

            $form = 'form_'.$i;

            $this->db->query("INSERT INTO source(form_no, cluster) VALUES ('$form', 113001)");
        }
    }

    function progress(){

        $survey = $this->uri->segment(3);

        $this->data['heading'] = $survey;

        $this->data['progress_by_district'] = $this->scans->query("select * from tbl02_progress where survey = $survey");

        $this->data['main_content'] = 'scans/index';
        $this->load->view('includes/template', $this->data);
    }

    */

    function sync_report()
    {
        $this->data['heading'] = "Sync Report";
        $query = "SELECT
	cluster_code as Cluster,
	LEFT (formdate, 8) AS FormDate,
	COUNT (*) AS Synced
FROM
	[dbo].[forms]
WHERE
	username NOT LIKE '%user%'
GROUP BY
	cluster_code,
	LEFT (formdate, 8) 
ORDER BY
	formdate DESC";
        $getData = $this->scans->query($query);
        $this->data['get_list'] = $getData->result();
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['main_content'] = 'scans/sync_report';
        $this->load->view('includes/template', $this->data);
    }

    function getHousehold()
    {
        $cluster = $_POST['cluster'];
        $formDate = $_POST['formDate'];
        $query = "SELECT
	hhno
FROM
	[dbo].[forms]
WHERE
	cluster_code = '" . $cluster . "'
AND formdate LIKE  '" . $formDate . "%' ";
        $getData = $this->scans->query($query);
        echo json_encode($getData->result());
    }


    function skipQuestions()
    {
        $this->data['heading'] = "Coverage Evaluation Survey, Pakistan, 2020";
        $forms_sq_query = "SELECT
	sq.username,
	sq.total,
	(
		hh15 + hh18 + hh20 + ss04 + ss07 + ss09 + ss11 + ss22 + ss24
	) / 9 AS SkipPecentage,
	sq.hh15,
	sq.hh18,
	sq.hh20,
	sq.ss04,
	sq.ss07,
	sq.ss09,
	sq.ss11,
	sq.ss22,
	sq.ss24
FROM
	forms_sq sq";
        $getForms = $this->scans->query($forms_sq_query);

        $child_sq_query = "SELECT
	sq.username,
	sq.total,
	(
		IM01 + IM02 +  IM08 + IM10 + IM14 + IM16 + IM18 + IM21 + IM23
	) / 10 AS SkipPecentage,
	sq.IM01,
	sq.IM02,
	 
	sq.IM08,
	sq.IM10,
	sq.IM14,
	sq.IM16,
	sq.IM18,
	sq.IM21,
	sq.IM23
FROM
	child_table_sq sq";
        $getChilds = $this->scans->query($child_sq_query);

        $this->data['get_list'] = $getForms->result();
        $this->data['get_list_childs'] = $getChilds->result();
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['main_content'] = 'scans/skipQuestions';
        $this->load->view('includes/template', $this->data);
    }


    /*==============Upload Excels===============*/
    function upload_excel_data()
    {
        $this->data['heading'] = "Upload Excel Data";

        $this->data['get_table'] = array('bl_randomised', 'clusters', 'devices', 'users', 'users_dash');
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['main_content'] = 'scans/upload_excel';
        $this->load->view('includes/template', $this->data);
    }


    public function addExcelData2()
    {
        $config['upload_path'] = 'assets/uploads/excelsUpload';
        $config['allowed_types'] = 'xlsx|xlx|csv';
        $this->load->library('upload', $config);
        $data = array();
        if (!$this->upload->do_upload('document_file')) {
            /* $error = array('Error' => $this->upload->display_errors());
             print_r($error);*/
            $data = array('0' => 'Error', '1' => $this->upload->display_errors());
        } else {
            if (!$this->upload->do_upload('userfile')) {
                $error = array('Error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }


            if (isset($_POST['idTable']) && $_POST['idTable'] != '' && $_POST['idTable'] != '0') {
                $table = $_POST['idTable'];
                $data = array('document_file' => $this->upload->data());
                $file = 'assets/uploads/excelsUpload/' . $data['document_file']['file_name'];
                if (file_exists($file)) {
                    $this->load->library('excel');
                    $objPHPExcel = PHPExcel_IOFactory::load($file);
                    $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                    foreach ($cell_collection as $cell) {
                        $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                        $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                        $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                        if ($row == 1) {
                            $header[$row][$column] = $data_value;
                        } else {
                            $arr_data[$row][$column] = $data_value;
                        }
                    }


                    $i = 0;
                    $myarr = array();
                    foreach ($arr_data as $k => $l) {
                        $c = array();
                        foreach ($header[1] as $h => $v) {
                            $c[$v] = $l[$h];
                        }
                        $myarr[] = $c;
                    }


                    echo '<pre>';
                    print_r($myarr);
                    echo '</pre>';
//                    $data['header'] = $header;

                    exit();
                    $data['values'] = $arr_data;
                    $r = range('A', 'Z');
                    $isrtArr = array();
                    foreach ($data['values'] as $key => $val) {
                        if (isset($val[$r[0]])) {
                            $formArray_Detail = array();
                            $formArray_Detail['username'] = (isset($val[$r[0]]) && $val[$r[0]] != '' ? $val[$r[0]] : '');
                            $formArray_Detail['password'] = (isset($val[$r[1]]) && $val[$r[1]] != '' ? $val[$r[1]] : '');
                            $formArray_Detail['dist_id'] = (isset($val[$r[2]]) && $val[$r[2]] != '' ? $val[$r[2]] : '');
                            $formArray_Detail['full_name'] = (isset($val[$r[3]]) && $val[$r[3]] != '' ? $val[$r[3]] : '');
                            $formArray_Detail['auth_level'] = (isset($val[$r[4]]) && $val[$r[4]] != '' ? $val[$r[4]] : '');
                            $formArray_Detail['enabled'] = (isset($val[$r[5]]) && $val[$r[5]] != '' ? $val[$r[5]] : '');
                            $isrtArr[] = $formArray_Detail;
                        }
                    }
                    /* $InsertData = $this->db->insert_batch('users', $isrtArr);
                     if ($InsertData) {
                         $data = array('0' => 'success', '1' => 'Successfully Uploaded');
                     } else {
                         $data = array('0' => 'Error', '1' => 'Error while inserting data');
                     }*/
                } else {
                    $data = array('0' => 'Error', '1' => 'Error while uploading file');
                }
            } else {
                $data = array('0' => 'Error', '1' => 'Please select table');
            }

        }
        echo json_encode($data);
    }

    public function addExcelData()
    {
        $config['upload_path'] = 'assets/uploads/excelsUpload';
        $config['allowed_types'] = 'xlsx|xlx|csv';
        $this->load->library('upload', $config);
        $data = array();
        if (!$this->upload->do_upload('document_file')) {
            /* $error = array('Error' => $this->upload->display_errors());
             print_r($error);*/
            $data = array('0' => 'Error', '1' => $this->upload->display_errors());
        } else {
            if (!$this->upload->do_upload('userfile')) {
                $error = array('Error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }


            if (isset($_POST['idTable']) && $_POST['idTable'] != '' && $_POST['idTable'] != '0') {
                $table = $_POST['idTable'];
                $data = array('document_file' => $this->upload->data());
                $file = 'assets/uploads/excelsUpload/' . $data['document_file']['file_name'];
                if (file_exists($file)) {
                    $this->load->library('excel');
                    $objPHPExcel = PHPExcel_IOFactory::load($file);
                    $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                    foreach ($cell_collection as $cell) {
                        $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                        $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                        $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                        if ($row == 1) {
                            $header[$row][$column] = $data_value;
                        } else {
                            $arr_data[$row][$column] = $data_value;
                        }
                    }

                    $myarr = array();
                    foreach ($arr_data as $k => $l) {
                        $c = array();
                        foreach ($header[1] as $h => $v) {
                            $c[$v] = $l[$h];
                        }
                        $myarr[] = $c;
                    }
                    $InsertData = $this->db->insert_batch($table, $myarr);
                    if ($InsertData) {
                        $data = array('0' => 'Success', '1' => 'Successfully Uploaded');
                    } else {
                        $data = array('0' => 'Error', '1' => $this->db->error());
                    }
                } else {
                    $data = array('0' => 'Error', '1' => 'Error while uploading file');
                }
            } else {
                $data = array('0' => 'Error', '1' => 'Please select table');
            }

        }
        echo json_encode($data);
    }


    ////// close db connection //////
    public function __destruct()
    {

        $this->db->close();
    }
}