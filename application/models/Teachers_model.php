<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Teachers_model extends CI_Model
	{
	public function __construct()
	{
	$this->load->database();
    }
    
    public function add_record($data)
    {
    //SELECT MAX ID
    $max_id = 1;
	$emp_code = 001;
    $this->db->select_max('id');
	$this->db->select_max('emp_code');
    $query = $this->db->get('tab_teachers');
    $row = $query->row();
    if (isset($row))
    {
    $max_id = $row->id + 1;
	$emp_code = $row->emp_code + 1;
    }
    
    $data['id'] = $max_id;
	$data['emp_code'] = $emp_code;
    return $this->db->insert('tab_teachers', $data);
    }
    
    public function edit_record($id,$data)
    {
    $this->db->where('id', $id);
    $this->db->update('tab_teachers', $data);		
    }
    
    public function delete_record($id)
    {
    $this->db->where('id', $id);
    return $this->db->delete('tab_teachers');
    }
    
    public function view_record($order_by = '')
    {
    $this->db->select('t.*');
    $this->db->from('tab_teachers as t');
    if($order_by != ''){
    $this->db->order_by('t.id',$order_by);
    }
    $query = $this->db->get();		
    return $query->result_array();
    }
    
    public function user_view_record()
    {
    $this->db->select('r.*,se.gender_type,c.country_name,s.state_name,d.district_name,ci.city_name,a.area_name');
    $this->db->from('tab_registration as r');
    
    $this->db->join('tab_country as c','c.id = r.country_id', 'left');
    $this->db->join('tab_state as s','s.id = r.state_id', 'left');
    $this->db->join('tab_district as d','d.id = r.district_id', 'left');
    $this->db->join('tab_city as ci','ci.id = r.city_id', 'left');
    $this->db->join('tab_area as a','a.id = r.area_id', 'left');
    $this->db->join('tab_sex as se','se.id = r.gender_id', 'left');
    
    $query = $this->db->get();		
    return $query->result_array();
    }
    
    public function get_record_by_id($id)
    {
    $this->db->where('id', $id);
    $query = $this->db->get('tab_teachers');
    
    return $query->row_array();
    }
    
    public function get_single_view($id)
    {
    $this->db->select('r.*,se.gender_type,c.country_name');
    $this->db->from('tab_teachers as r');
    $this->db->join('tab_country as c','c.id = r.country_id', 'left');
    $this->db->join('tab_sex as se','se.id = r.gender_id', 'left');
    $this->db->where('r.id', $id);
    $query = $this->db->get();
    
    return $query->row_array();
    }
    
    public function teachers_count()
    {
    
    return $this->db->count_all_results('tab_teachers');
    }
    
    
    }