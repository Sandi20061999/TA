<?php
class Workschedule_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get workschedule by WSCode
     */
    function get_workschedule($WSCode)
    {
        return $this->db->get_where('tblworkschedule',array('WSCode'=>$WSCode))->row_array();
    }
        
    /*
     * Get all workschedule
     */
    function get_all_workschedule()
    {
        $this->db->order_by('WSCode', 'desc');
        return $this->db->get('tblworkschedule')->result_array();
    }
        
    /*
     * function to add new workschedule
     */
    function add_workschedule($params)
    {
        return $this->db->insert('tblworkschedule',$params);
    }
    
    /*
     * function to update workschedule
     */
    function update_workschedule($WSCode,$params)
    {
        $this->db->where('WSCode',$WSCode);
        return $this->db->update('tblworkschedule',$params);
    }
    
    /*
     * function to delete workschedule
     */
    function delete_workschedule($WSCode)
    {
        $this->db->delete('tblempworkschedule',array('WSCode'=>$WSCode));
        return $this->db->delete('tblworkschedule',array('WSCode'=>$WSCode));
    }
}