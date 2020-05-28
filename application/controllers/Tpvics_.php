<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scans extends MX_Controller
{


    function __construct(){

        parent::__construct();

        $this->scans = $this->load->database('default', TRUE);

        $this->data = null;
        //$this->form_validation->CI =& $this;

        $this->load->vars('current_url', $this->uri->uri_to_assoc(1));
        $this->load->module("master");

        $this->load->module("users");
        if (!$this->users->logged_in()){
            redirect('users/login', 'refresh');
        }
    }


    function dashboard(){

        $this->data['heading'] = "Coverage Evaluation Survey, Pakistan, 2020";

        if($this->users->in_group('admin') || $this->users->in_group('management')){

            $this->data['clusters_by_district'] = $this->scans->query("select dist_id, 
			count(*) clusters_by_district from clusters where dist_id in('2', '3')
			group by dist_id order by dist_id");

            $this->data['randomized_clusters'] = $this->scans->query("select dist_id,
			sum(case when randomized = '1' or randomized = '2' then 1 else 0 end) randomized_c
			from clusters where dist_id in('2', '3') 
			group by dist_id order by dist_id");

            $c_r_clusters = $this->scans->query("select c.dist_id, c.cluster_no,
			(select count(*) from bl_randomised where dist_id = c.dist_id and hh02 = c.cluster_no) as hh_randomized,
			(select count(distinct hhno) from forms where dist_id = c.dist_id and cluster_code = c.cluster_no and cast(istatus as int) > 0 and cast(istatus as int) < 96 and istatus is not null and istatus != '' and istatus != 'null') as hh_collected
			from clusters c
			where c.randomized = '1' or c.randomized = '2'
			group by c.dist_id, c.cluster_no order by c.dist_id");

            $cc_d2 = 0;
            $cc_d3 = 0;

            $rc_d2 = 0;
            $rc_d3 = 0;

            foreach($c_r_clusters->result() as $r){

                if($r->dist_id == '2'){

                    if($r->hh_collected == 20){
                        $rc_d2 = $rc_d2 + 1;
                    } else {
                        $cc_d2 = $cc_d2 + 1;
                    }

                } else if($r->dist_id == '3'){

                    if($r->hh_collected == 20){
                        $rc_d3 = $rc_d3 + 1;
                    } else {
                        $cc_d3 = $cc_d3 + 1;
                    }
                }
            }

            // Completed Clusters
            $this->data['cc_d2'] 	= $cc_d2;
            $this->data['cc_d3'] 	= $cc_d3;
            $this->data['cc_total'] = $cc_d2 + $cc_d3;

            // Remaining Clusters
            $this->data['rc_d2'] 	= $rc_d2;
            $this->data['rc_d3'] 	= $rc_d3;
            $this->data['rc_total'] = $rc_d2 + $rc_d3;

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            if(!empty($this->uri->segment(3))){

                $type = substr($this->uri->segment(3), 0, 2);
                $d    = substr($this->uri->segment(3), 4, 3);

                if($type == 'rc'){

                    $this->data['get_list'] = $this->scans->query("select l.enumcode, l.hh02,
					(select count(*) from(select distinct hh03, tabNo from listings where hh04 in('1','2') and enumcode = l.enumcode and hh02 = l.hh02) as structures) as structures,
					(select count(*) from(select distinct hh03, tabNo from listings where hh04 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as structures) as residential_structures,
					sum(case when hh04 = '1' and hh15 != '1' then 1 else 0 end) as households,
					sum(case when hh04 = '1' and hh15 != '1' and hh10 = '1' then 1 else 0 end) as eligible_households,
					(select count(*) from bl_randomised where dist_id = l.enumcode and hh02 = l.hh02) as randomized_households,
					(select count(distinct rndid) from forms where SUBSTRING(cluster_code, 1, 1) = l.enumcode and cluster_code = l.hh02 and istatus = '1') as collected_households,
					(select sum(cast(hh11 as int)) from listings where hh04 = '1' and hh15 != '1' and hh10 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_eligible_wras,
					(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
					(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = '9' group by deviceid) AS completed_tabs) completed_tabs
					from clusters c
					left join listings l on l.hh02 = c.cluster_no
					where l.enumcode = '$d' and (c.randomized = '1' or c.randomized = '2')
					and l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
					group by l.enumcode, l.hh02
					order by l.enumcode,l.hh02");

                } else if($type == 'cc'){

                    $this->data['get_list'] = $this->scans->query("select l.enumcode, l.hh02,
					(select count(*) from(select distinct hh03, tabNo from listings where hh04 in('1','2') and enumcode = l.enumcode and hh02 = l.hh02) as structures) as structures,
					(select count(*) from(select distinct hh03, tabNo from listings where hh04 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as structures) as residential_structures,
					sum(case when hh04 = '1' and hh15 != '1' then 1 else 0 end) as households,
					sum(case when hh04 = '1' and hh15 != '1' and hh10 = '1' then 1 else 0 end) as eligible_households,
					(select count(*) from bl_randomised where dist_id = l.enumcode and hh02 = l.hh02) as randomized_households,
					(select count(distinct rndid) from forms where SUBSTRING(cluster_code, 1, 1) = l.enumcode and cluster_code = l.hh02 and istatus = '1') as collected_households,
					(select sum(cast(hh11 as int)) from listings where hh04 = '1' and hh15 != '1' and hh10 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_eligible_wras,
					(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
					(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = '9' group by deviceid) AS completed_tabs) completed_tabs
					from clusters c
					left join listings l on l.hh02 = c.cluster_no
					where l.enumcode = '$d' and (c.randomized = '1' or c.randomized = '2')
					and l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
					and (select count(*) from bl_randomised where dist_id = l.enumcode and hh02 = l.hh02) = (select count(distinct rndid) from forms where SUBSTRING(cluster_code, 1, 3) = l.enumcode and cluster_code = l.hh02 and istatus > 0 and istatus < 96 and istatus is not null and istatus != '' and istatus != 'null')
					group by l.enumcode, l.hh02
					order by l.enumcode,l.hh02");

                } else if($type == 'ic'){

                    $this->data['get_list'] = $this->scans->query("select l.enumcode, l.hh02,
					(select count(*) from(select distinct hh03, tabNo from listings where hh04 in('1','2') and enumcode = l.enumcode and hh02 = l.hh02) as structures) as structures,
					(select count(*) from(select distinct hh03, tabNo from listings where hh04 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as structures) as residential_structures,
					sum(case when hh04 = '1' and hh15 != '1' then 1 else 0 end) as households,
					sum(case when hh04 = '1' and hh15 != '1' and hh10 = '1' then 1 else 0 end) as eligible_households,
					(select count(*) from bl_randomised where dist_id = l.enumcode and hh02 = l.hh02) as randomized_households,
					(select count(distinct rndid) from forms where SUBSTRING(cluster_code, 1, 1) = l.enumcode and cluster_code = l.hh02 and istatus = '1') as collected_households,
					(select sum(cast(hh11 as int)) from listings where hh04 = '1' and hh15 != '1' and hh10 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_eligible_wras,
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

                $this->data['get_list'] = $this->scans->query("select l.enumcode, l.hh02,
				(select count(*) from(select distinct hh03, tabNo from listings where hh04 in('1','2') and enumcode = l.enumcode and hh02 = l.hh02) as structures) as structures,
				(select count(*) from(select distinct hh03, tabNo from listings where hh04 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as structures) as residential_structures,
				sum(case when hh04 = '1' and hh15 != '1' then 1 else 0 end) as households,
				sum(case when hh04 = '1' and hh15 != '1' and hh10 = '1' then 1 else 0 end) as eligible_households,
				(select count(*) from bl_randomised where dist_id = l.enumcode and hh02 = l.hh02) as randomized_households,
				(select count(distinct rndid) from forms where SUBSTRING(cluster_code, 1, 1) = l.enumcode and cluster_code = l.hh02 and istatus = '1') as collected_households,
				(select sum(cast(hh11 as int)) from listings where hh04 = '1' and hh15 != '1' and hh10 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_eligible_wras,
				(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
				(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = '9' group by deviceid) AS completed_tabs) completed_tabs
				from clusters c
				left join listings l on l.hh02 = c.cluster_no
				where (c.randomized = '1' or c.randomized = '2')
				and l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
				group by l.enumcode, l.hh02
				order by l.enumcode,l.hh02");
            }


        } else {

            $id 	  = $this->users->get_user()->id;
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

            foreach($c_r_clusters->result() as $r){

                if($r->dist_id == '2'){

                    if($r->hh_collected == 20){
                        $rc_d2 = $rc_d2 + 1;
                    } else {
                        $cc_d2 = $cc_d2 + 1;
                    }

                } else if($r->dist_id == '3'){

                    if($r->hh_collected == 20){
                        $rc_d3 = $rc_d3 + 1;
                    } else {
                        $cc_d3 = $cc_d3 + 1;
                    }
                }
            }

            // Completed Clusters
            $this->data['cc_d2'] 	= $cc_d2;
            $this->data['cc_d3'] 	= $cc_d3;
            $this->data['cc_total'] = $cc_d2 + $cc_d3;

            // Remaining Clusters
            $this->data['rc_d2'] 	= $rc_d2;
            $this->data['rc_d3'] 	= $rc_d3;
            $this->data['rc_total'] = $rc_d2 + $rc_d3;


            $this->data['get_list'] = $this->scans->query("select l.enumcode, l.hh02,
			(select count(*) from(select distinct hh03, tabNo from listings where hh04 in('1','2') and enumcode = l.enumcode and hh02 = l.hh02) as structures) as structures,
			(select count(*) from(select distinct hh03, tabNo from listings where hh04 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as structures) as residential_structures,
			sum(case when hh04 = '1' and hh15 != '1' then 1 else 0 end) as households,
			sum(case when hh04 = '1' and hh15 != '1' and hh10 = '1' then 1 else 0 end) as eligible_households,
			(select count(*) from bl_randomised where dist_id = l.enumcode and hh02 = l.hh02) as randomized_households,
			(select count(distinct rndid) from forms where SUBSTRING(cluster_code, 1, 1) = l.enumcode and cluster_code = l.hh02 and istatus = '1') as collected_households,
			(select sum(cast(hh11 as int)) from listings where hh04 = '1' and hh15 != '1' and hh10 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_eligible_wras,
			(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
			(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = '9' group by deviceid) AS completed_tabs) completed_tabs
			from clusters c
			left join listings l on l.hh02 = c.cluster_no
			where l.enumcode = '$district' and (c.randomized = '1' or c.randomized = '2')
			and l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
			group by l.enumcode, l.hh02
			order by l.enumcode,l.hh02");

        }

        $this->data['message']  	= $this->session->flashdata('message');
        $this->data['main_content'] = 'scans/dashboard';
        $this->load->view('includes/template', $this->data);
    }


    function index(){


        $this->data['heading'] = "Coverage Evaluation Survey, Pakistan, 2020";

        if($this->users->in_group('admin') || $this->users->in_group('management')){
            $this->data['clusters_by_district'] = $this->scans->query("select (case
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
			count(*) clusters_by_district from clusters  
			group by dist_id order by dist_id");

            $cip_clusters = $this->scans->query("select l.enumcode, l.hh02,
			(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
			(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9 group by deviceid) AS completed_tabs) completed_tabs
			from clusters c
			left join listings l on l.hh02 = c.cluster_no
			where l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
			group by l.enumcode, l.hh02
			order by l.enumcode,l.hh02");

            $d2_t = 0;
            $d3_t = 0;

            $d2_c = 0;
            $d3_c = 0;

            $d2_ip = 0;
            $d3_ip = 0;

            foreach($cip_clusters->result() as $row){

                if($row->enumcode == 2){

                    $d2_t = $d2_t + 1;

                    if($row->collecting_tabs == $row->completed_tabs){
                        $d2_c = $d2_c + 1;
                    } else {
                        $d2_ip = $d2_ip + 1;
                    }

                } else if($row->enumcode == 3){

                    $d3_t = $d3_t + 1;

                    if($row->collecting_tabs == $row->completed_tabs){
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

            $all_clusters = $this->scans->query("select dist_id, count(*) clusters_by_district from clusters group by dist_id order by dist_id");

            $this->data['d2_r'] = 0;
            $this->data['d3_r'] = 0;

            foreach($all_clusters->result() as $row2){

                if($row2->dist_id == 2){
                    $this->data['d2_r'] = $row2->clusters_by_district - $d2_t;
                } else if($row2->dist_id == 3){
                    $this->data['d3_r'] = $row2->clusters_by_district - $d3_t;
                }
            }


            $this->data['gt_c']  = $d2_c + $d3_c;
            $this->data['gt_ip'] = $d2_ip + $d3_ip;
            $this->data['gt_r'] = $this->data['d2_r'] + $this->data['d3_r'];

            $district_cluster_type = $this->uri->segment(3);

            if(!empty($district_cluster_type)){

                $district 	  = substr($district_cluster_type, 1, 1);
                $cluster_type = substr($district_cluster_type, 3, 1);

                if($cluster_type == 'c'){

                    $this->data['get_list'] = $this->scans->query("select l.enumcode, l.hh02,
					(select count(*) from(select distinct hh03, tabNo from listings where hh04 in('1','2') and enumcode = l.enumcode and hh02 = l.hh02) as structures) as structures,
					(select count(*) from(select distinct hh03, tabNo from listings where hh04 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as structures) as residential_structures,
					sum(case when hh04 = '1' and hh15 != '1' then 1 else 0 end) as households,
					sum(case when hh04 = '1' and hh15 != '1' and hh10 = '1' then 1 else 0 end) as eligible_households,
					(select sum(cast(hh11 as int)) from listings where hh04 = '1' and hh15 != '1' and hh10 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_eligible_wras,
					(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
					(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9 group by deviceid) AS completed_tabs) completed_tabs
					from clusters c
					left join listings l on l.hh02 = c.cluster_no
					where l.enumcode = '$district' and l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
					and (select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) = (select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9 group by deviceid) AS completed_tabs)
					group by l.enumcode, l.hh02
					order by l.enumcode,l.hh02");

                } else {

                    $this->data['get_list'] = $this->scans->query("select l.enumcode, l.hh02,
					(select count(*) from(select distinct hh03, tabNo from listings where hh04 in('1','2') and enumcode = l.enumcode and hh02 = l.hh02) as structures) as structures,
					(select count(*) from(select distinct hh03, tabNo from listings where hh04 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as structures) as residential_structures,
					sum(case when hh04 = '1' and hh15 != '1' then 1 else 0 end) as households,
					sum(case when hh04 = '1' and hh15 != '1' and hh10 = '1' then 1 else 0 end) as eligible_households,
					(select sum(cast(hh11 as int)) from listings where hh04 = '1' and hh15 != '1' and hh10 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_eligible_wras,
					(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
					(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9 group by deviceid) AS completed_tabs) completed_tabs
					from clusters c
					left join listings l on l.hh02 = c.cluster_no
					where l.enumcode = '$district' and l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
					and (select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) != (select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9 group by deviceid) AS completed_tabs)
					group by l.enumcode, l.hh02
					order by l.enumcode,l.hh02");
                }

            } else {

                $this->data['get_list'] = $this->scans->query("select l.enumcode, l.hh02,
				(select count(*) from(select distinct hh03, tabNo from listings where hh04 in('1','2') and enumcode = l.enumcode and hh02 = l.hh02) as structures) as structures,
				(select count(*) from(select distinct hh03, tabNo from listings where hh04 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as structures) as residential_structures,
				sum(case when hh04 = '1' and hh15 != '1' then 1 else 0 end) as households,
				sum(case when hh04 = '1' and hh15 != '1' and hh10 = '1' then 1 else 0 end) as eligible_households,
				(select sum(cast(hh11 as int)) from listings where hh04 = '1' and hh15 != '1' and hh10 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_eligible_wras,
				(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
				(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9 group by deviceid) AS completed_tabs) completed_tabs
				from clusters c
				left join listings l on l.hh02 = c.cluster_no
				where l.enumcode in(2, 3) and l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
				group by l.enumcode, l.hh02
				order by l.enumcode,l.hh02");
            }

        } else {

            $id 	  = $this->users->get_user()->id;
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

            foreach($cip_clusters->result() as $row){

                if($row->enumcode == 2){

                    $d2_t = $d2_t + 1;

                    if($row->collecting_tabs == $row->completed_tabs){
                        $d2_c = $d2_c + 1;
                    } else {
                        $d2_ip = $d2_ip + 1;
                    }

                } else if($row->enumcode == 3){

                    $d3_t = $d3_t + 1;

                    if($row->collecting_tabs == $row->completed_tabs){
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

            foreach($all_clusters->result() as $row2){

                if($row2->dist_id == 2){
                    $this->data['d2_r'] = $row2->clusters_by_district - $d2_t;
                } else if($row2->dist_id == 3){
                    $this->data['d3_r'] = $row2->clusters_by_district - $d3_t;
                }
            }

            $this->data['gt_c']  = $d2_c + $d3_c;
            $this->data['gt_ip'] = $d2_ip + $d3_ip;
            $this->data['gt_r'] = $this->data['d2_r'] + $this->data['d3_r'];

            $this->data['get_list'] = $this->scans->query("select l.enumcode, l.hh02,
			(select count(*) from(select distinct hh03, tabNo from listings where hh04 in('1','2') and enumcode = l.enumcode and hh02 = l.hh02) as structures) as structures,
			(select count(*) from(select distinct hh03, tabNo from listings where hh04 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as structures) as residential_structures,
			sum(case when hh04 = '1' and hh15 != '1' then 1 else 0 end) as households,
			sum(case when hh04 = '1' and hh15 != '1' and hh10 = '1' then 1 else 0 end) as eligible_households,
			(select sum(cast(hh11 as int)) from listings where hh04 = '1' and hh15 != '1' and hh10 = '1' and enumcode = l.enumcode and hh02 = l.hh02) as no_of_eligible_wras,
			(select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) as collecting_tabs,
			(select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9 group by deviceid) AS completed_tabs) completed_tabs
			from clusters c
			left join listings l on l.hh02 = c.cluster_no
			where l.enumcode = '$district' and l.username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
			and (select count(distinct deviceid) from listings where hh02 = l.hh02 and enumcode = l.enumcode) = (select count(*) completed_tabs from(select deviceid, max(cast(hh03 as int)) ms from listings where enumcode = l.enumcode and hh02 = l.hh02 and hh04 = 9 group by deviceid) AS completed_tabs)
			group by l.enumcode, l.hh02
			order by l.enumcode,l.hh02");
        }


        $this->data['message']  	= $this->session->flashdata('message');
        $this->data['main_content'] = 'scans/index';
        $this->load->view('includes/template', $this->data);
    }


    function systematic_randomizer(){

        $source 	 = 'listings';
        $destination = 'destination';
        $sample 	 = 20;

        $columns = 'col_id, hh02, tabNo, hh03, hh07, hh08, hh09, enumcode, uid';

        $cluster = $this->uri->segment(3);

        $randomization_status = $this->scans->query("select randomized from clusters where cluster_no = '$cluster'")->row()->randomized;
        if($randomization_status == 1 or $randomization_status == 2){

            $flash_msg = "Cluster No ".$cluster." is Already Randomized";
            $value = '<div class="callout callout-warning"><p>'.$flash_msg.'</p></div>';
            $this->session->set_flashdata('message', $value);

            if($this->users->in_group('admin') || $this->users->in_group('management')){
                redirect('scans/index/'.$this->uri->segment(4));
            } else {
                redirect('scans/index');
            }
        }

        $dataset = $this->scans->query("select ".$columns." from ".$source."
		where username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
		and hh04 = '1' and hh10 = '1' and hh15 != '1' and hh02 = '$cluster' order by tabNo, deviceid, cast(hh03 as int), cast(hh07 as int)");

        if($dataset->num_rows() > 0){

            $residential_structures = $this->scans->query("select distinct hh03, tabNo from listings where hh02 = '$cluster' and hh04 = '1'")->num_rows();

            $this->scans->query("update clusters set randomized = '1' where cluster_no = '$cluster'");

            if($dataset->num_rows() > $sample){

                $quotient     = $dataset->num_rows()/$sample;
                $random_start = rand(1, $quotient);
                $random_point = $random_start;
                $index 		  = floor($random_start);
                $result 	  = $dataset->result_array();

                //echo '<p><strong>Dataset = '.$dataset->num_rows().' | Sample = '.$sample.' | Random Start = '.$random_start.' | Quotient = '.$quotient.'</strong></p>';

                for($i = 1; $i <= 20; $i++){

                    $data = array(
                        'randDT'  => date('Y-m-d h:i:s'),
                        'uid' 	  => $result[$index - 1]['uid'],
                        'sno' 	  => $i,
                        'hh02' 	  => $result[$index - 1]['hh02'],
                        'hh03' 	  => $result[$index - 1]['hh03'],
                        'hh07' 	  => $result[$index - 1]['hh07'],
                        'hh08' 	  => $result[$index - 1]['hh08'],
                        'hh09' 	  => $result[$index - 1]['hh09'],
                        'total'   => $residential_structures,
                        'randno'  => $random_start,
                        'quot' 	  => $quotient,
                        'dist_id' => $result[$index - 1]['enumcode'],
                        'compid'  => $result[$index - 1]['hh02']."-".str_pad($result[$index - 1]['hh03'],4,"0",STR_PAD_LEFT)."-".str_pad($result[$index - 1]['hh07'],3,"0",STR_PAD_LEFT),
                        'ssno' 	  => $result[$index - 1]['tabNo'],
                    );

                    $this->scans->insert('bl_randomised', $data);
                    $this->scans->query("update listings set randomized = '1' where col_id = ".$result[$index - 1]['col_id']);

                    $random_point = $random_point + $quotient;
                    $index = floor($random_point);
                }

                $flash_msg = "Cluster No ".$cluster." Randomized successfully";
                $value = '<div class="callout callout-success"><p>'.$flash_msg.'</p></div>';
                $this->session->set_flashdata('message', $value);

                if($this->users->in_group('admin') || $this->users->in_group('management')){
                    redirect('scans/index/'.$this->uri->segment(4));
                } else {
                    redirect('scans/index');
                }

            } else {

                $result 	  = $dataset->result_array();
                $quotient     = $dataset->num_rows()/count($result);
                $random_start = rand(1, $quotient);

                for($i = 0; $i < count($result); $i++){

                    $data = array(
                        'randDT'  => date('Y-m-d h:i:s'),
                        'uid' 	  => $result[$i]['uid'],
                        'sno' 	  => $i + 1,
                        'hh02' 	  => $result[$i]['hh02'],
                        'hh03' 	  => $result[$i]['hh03'],
                        'hh07' 	  => $result[$i]['hh07'],
                        'hh08' 	  => $result[$i]['hh08'],
                        'hh09' 	  => $result[$i]['hh09'],
                        'total'   => $residential_structures,
                        'randno'  => $random_start,
                        'quot' 	  => $quotient,
                        'dist_id' => $result[$i]['enumcode'],
                        'compid'  => $result[$i]['hh02']."-".str_pad($result[$i]['hh03'],4,"0",STR_PAD_LEFT)."-".str_pad($result[$i]['hh07'],3,"0",STR_PAD_LEFT),
                        'ssno' 	  => $result[$i]['tabNo'],
                    );

                    $this->scans->insert('bl_randomised', $data);
                    $this->scans->query("update listings set randomized = '1' where col_id = ".$result[$i]['col_id']);
                }

                $flash_msg = "Cluster No ".$cluster." Randomized successfully";
                $value = '<div class="callout callout-success"><p>'.$flash_msg.'</p></div>';
                $this->session->set_flashdata('message', $value);
                if($this->users->in_group('admin') || $this->users->in_group('management')){
                    redirect('scans/index/'.$this->uri->segment(4));
                } else {
                    redirect('scans/index');
                }
            }

        } else {

            $flash_msg = "Cluster No ".$cluster." Has Zero Households";
            $value = '<div class="callout callout-danger"><p>'.$flash_msg.'</p></div>';
            $this->session->set_flashdata('message', $value);
            if($this->users->in_group('admin') || $this->users->in_group('management')){
                redirect('scans/index/'.$this->uri->segment(4));
            } else {
                redirect('scans/index');
            }
        }
    }


    function add_five(){

        $this->data['get_list'] = $this->scans->query("select * from clusters where randomized = 1");

        $this->data['heading'] = "Add more five cases";

        $this->data['message']  	= $this->session->flashdata('message');
        $this->data['main_content'] = 'scans/add_five';
        $this->load->view('includes/template', $this->data);
    }


    function systematic_randomizer2(){

        $source 	 = 'listings';
        $destination = 'destination';
        $sample 	 = 5;

        $columns = 'col_id, hh02, tabNo, hh03, hh07, hh08, hh09, enumcode, uid';

        $cluster = $this->uri->segment(3);

        $randomization_status = $this->scans->query("select randomized from clusters where cluster_no = '$cluster'")->row()->randomized;
        if($randomization_status == 2){

            $flash_msg = "Cluster No ".$cluster." is Already Randomized";
            $value = '<div class="callout callout-warning"><p>'.$flash_msg.'</p></div>';
            $this->session->set_flashdata('message', $value);

            if($this->users->in_group('admin') || $this->users->in_group('management')){
                redirect('scans/index/'.$this->uri->segment(4));
            } else {
                redirect('scans/index');
            }
        }

        $sno = $this->scans->query("select max(cast(sno as int)) sno from bl_randomised where hh02 = '$cluster'")->row()->sno;

        $dataset = $this->scans->query("select * from listings
		where username not in('afg12345','user0001','user0113','user0123','user0211','user0234','user0252','user0414','user0432', 'user0434')
		and hh04 = '1' and hh10 = '1' and hh15 != '1' and hh02 = '$cluster'  and (randomized is null or randomized = '0') order by tabNo, deviceid, cast(hh03 as int), cast(hh07 as int)");

        if($dataset->num_rows() > 0){

            $residential_structures = $this->scans->query("select distinct hh03, tabNo from listings where hh02 = '$cluster' and hh04 = '1'")->num_rows();

            $this->scans->query("update clusters set randomized = '2' where cluster_no = '$cluster'");

            if($dataset->num_rows() > $sample){

                $quotient     = $dataset->num_rows()/$sample;
                $random_start = rand(1, $quotient);
                $random_point = $random_start;
                $index 		  = floor($random_start);
                $result 	  = $dataset->result_array();

                //echo '<p><strong>Dataset = '.$dataset->num_rows().' | Sample = '.$sample.' | Random Start = '.$random_start.' | Quotient = '.$quotient.'</strong></p>';

                for($i = 1; $i <= 5; $i++){

                    $data = array(
                        'randDT'  => date('Y-m-d h:i:s'),
                        'uid' 	  => $result[$index - 1]['uid'],
                        'sno' 	  => $sno + $i,
                        'hh02' 	  => $result[$index - 1]['hh02'],
                        'hh03' 	  => $result[$index - 1]['hh03'],
                        'hh07' 	  => $result[$index - 1]['hh07'],
                        'hh08' 	  => $result[$index - 1]['hh08'],
                        'hh09' 	  => $result[$index - 1]['hh09'],
                        'total'   => $residential_structures,
                        'randno'  => $random_start,
                        'quot' 	  => $quotient,
                        'dist_id' => $result[$index - 1]['enumcode'],
                        'compid'  => $result[$index - 1]['hh02']."-".str_pad($result[$index - 1]['hh03'],4,"0",STR_PAD_LEFT)."-".str_pad($result[$index - 1]['hh07'],3,"0",STR_PAD_LEFT),
                        'ssno' 	  => $result[$index - 1]['tabNo'],
                    );

                    $this->scans->insert('bl_randomised', $data);
                    $this->scans->query("update listings set randomized = '2' where col_id = ".$result[$index - 1]['col_id']);

                    $random_point = $random_point + $quotient;
                    $index = floor($random_point);
                }

                $flash_msg = "Added five more cases to Cluster: ".$cluster;
                $value = '<div class="callout callout-success"><p>'.$flash_msg.'</p></div>';
                $this->session->set_flashdata('message', $value);

                redirect('scans/add_five');

            } else {

                $result 	  = $dataset->result_array();
                $quotient     = $dataset->num_rows()/count($result);
                $random_start = rand(1, $quotient);

                for($i = 0; $i < count($result); $i++){

                    $data = array(
                        'randDT'  => date('Y-m-d h:i:s'),
                        'uid' 	  => $result[$i]['uid'],
                        'sno' 	  => $sno + $i + 1,
                        'hh02' 	  => $result[$i]['hh02'],
                        'hh03' 	  => $result[$i]['hh03'],
                        'hh07' 	  => $result[$i]['hh07'],
                        'hh08' 	  => $result[$i]['hh08'],
                        'hh09' 	  => $result[$i]['hh09'],
                        'total'   => $residential_structures,
                        'randno'  => $random_start,
                        'quot' 	  => $quotient,
                        'dist_id' => $result[$i]['enumcode'],
                        'compid'  => $result[$i]['hh02']."-".str_pad($result[$i]['hh03'],4,"0",STR_PAD_LEFT)."-".str_pad($result[$i]['hh07'],3,"0",STR_PAD_LEFT),
                        'ssno' 	  => $result[$i]['tabNo'],
                    );

                    $this->scans->insert('bl_randomised', $data);
                    $this->scans->query("update listings set randomized = '2' where col_id = ".$result[$i]['col_id']);
                }

                $flash_msg = "Added more cases to Cluster: ".$cluster;
                $value = '<div class="callout callout-success"><p>'.$flash_msg.'</p></div>';
                $this->session->set_flashdata('message', $value);

                redirect('scans/add_five');
            }

        } else {

            $flash_msg = "Cluster No ".$cluster." Has No More Households";
            $value = '<div class="callout callout-danger"><p>'.$flash_msg.'</p></div>';
            $this->session->set_flashdata('message', $value);

            redirect('scans/add_five');
        }
    }


    function make_pdf(){

        $cluster = $this->uri->segment(3);

        $this->data['cluster'] = $this->uri->segment(3);

        $this->data['cluster_data'] = $this->scans->query("select * from bl_randomised where hh02 = '$cluster'");
        $rd 						= $this->scans->query("select top 1 randDT from bl_randomised where hh02 = '$cluster'")->row()->randDT;

        $this->data['randomization_date'] = substr($rd, 0, 10);

        $get_geoarea = $this->scans->query("select geoarea from clusters where cluster_no = '$cluster'")->row()->geoarea;
        $division = explode("|",$get_geoarea);
        $this->data['division'] = ltrim(rtrim($division[1]));

        $this->load->library('Pdf');


        $this->data['main_content'] = 'scans/make_pdf';
        $this->load->view('includes/template', $this->data);
    }


    function get_excel(){

        $cluster = $this->uri->segment(3);

        $this->data['cluster_data'] = $this->scans->query("select sno, ssno, substring(compid, 6, 8) household, hh08 from bl_randomised where hh02 = '$cluster'");

        $rd = $this->scans->query("select top 1 randDT from bl_randomised where hh02 = '$cluster'")->row()->randDT;
        $this->data['randomization_date'] = substr($rd, 0, 10);

        $get_geoarea = $this->scans->query("select geoarea from clusters where cluster_no = '$cluster'")->row()->geoarea;
        $division = explode("|",$get_geoarea);
        $this->data['division'] = ltrim(rtrim($division[1]));

        //var_dump($this->data['division']);die();


        $this->data['cluster'] = $this->uri->segment(3);
        $this->data['heading'] = "Get Excel";

        $this->data['main_content'] = 'scans/get_excel';
        $this->load->view('includes/template', $this->data);
    }


    function cluster_progress(){

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

        $this->data['heading'] = "Collection Progress for Cluster No: ".$cluster;

        $this->data['main_content'] = 'scans/cluster_progress';
        $this->load->view('includes/template', $this->data);
    }

    function test_data(){

        echo dirname(__FILE__);
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


    ////// close db connection //////
    public function __destruct(){

        $this->db->close();
    }
}