<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Home_db CI_Model Class
 * 
 * @access public
 * @author Rahmat Syaparudin
 * @return void
 */
class Home_db extends CI_MODEL
{
    /** User Table **/
    public function user_login($username)
    {
        $where = "username = '".$username."' AND status = 1";
        $this->db->select('username, name, password, status, isDeleted, isAdmin');
        $this->db->from('user');
        $this->db->where('username', $username);
        $query = $this->db->get()->result();
        return $query;
    }

    public function user_get_row($username)
    {
        $this->db->select('name, username, password, status, isDeleted, isAdmin');
        $this->db->from('user');
        $this->db->where('username', $username);
        $query = $this->db->get();
        return $query->row();
    }

    public function user_check_row($username)
    {
        $this->db->select('name, username, password, status, isDeleted, isAdmin');
        $this->db->from('user');
        $this->db->where('username', $username);
        $query = $this->db->get();
        return $query->num_rows();
    }  
    
    public function user_select_all()
    {
        $where = "status in (1,0) AND isDeleted IS NULL";
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where($where);
        $this->db->order_by('timestamp', 'DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    public function user_get_byId($id)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('username', $id);
        $query = $this->db->get()->result();
        return $query;
    }

    public function user_insert($data)
    {
        $this->db->trans_start();
        $query = $this->db->insert('user', $data);
        $this->db->trans_complete();
    }

    public function user_update($id, $data)
    {
        $this->db->where('username', $id);
        $this->db->update('user', $data);
    }

    public function user_delete($id)
    {
        $this->db->where('username', $id);
        $this->db->update('user', array('isDeleted' => 1));
        #$this->db->delete('user');
    }

    /** File_list Table **/
    public function timeline_data($limit, $offset)
    {
        $this->db->select('file_id, file_tittle, file_name, file_desc, location, a.timestamp, b.name AS userName'); 
        $this->db->from('file_list a');
        $this->db->join('user b', 'a.username = b.username');        
        $this->db->order_by('a.timestamp', 'DESC');
        $this->db->limit($limit,$offset);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false; 
    }

    public function timeline_total_rows()
    {
        $query = $this->db->get('file_list')->num_rows();
        return $query;
    }

    public function timeline_fullscreen($id)
    {
        $this->db->select('location, file_name, file_tittle');
        $this->db->from('file_list');
        $this->db->where('file_id', $id);
        $query = $this->db->get()->row();
        return $query;
    }    

    public function upload_select_all()
    {
        $this->db->select('file_id, a.file_tittle as fname, b.name as uname, location, file_desc, file_name, a.timestamp as time');
        $this->db->from('file_list a');
        $this->db->join('user b', 'a.username = b.username');  
        $this->db->where('a.status', 1);
        $this->db->order_by('a.timestamp', 'DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    public function upload_get_location($id)
    {
        $this->db->select('location');
        $this->db->from('file_list');
        $this->db->where('file_id', $id);
        $query = $this->db->get();
        return $query->row()->location;
    }

    public function upload_insert($data)
    {
    	$this->db->trans_start();
		$query = $this->db->insert('file_list', $data);
		$this->db->trans_complete();
    }

    public function upload_update($id, $data)
    {
        $this->db->where('file_id', $id);
        $this->db->update('file_list', $data);
    }

    public function upload_edit($id='')
    {
        $this->db->select('*');
        $this->db->from('file_list');
        $this->db->where('file_id', $id);
        $query = $this->db->get();
        return $query;
    }

    public function upload_delete($id)
    {
        $this->db->where('file_id', $id);
        $this->db->delete('file_list');
    }

    public function upload_get_byId($id)
    {
        $this->db->select('file_id, file_tittle, name, file_desc, file_name, a.timestamp as date');
        $this->db->from('file_list a');
        $this->db->join('user b', 'a.username = b.username');  
        $this->db->where('file_id', $id);
        $query = $this->db->get();
        return $query->row();

        $this->db->select('file_id, a.file_tittle as fname, b.name as uname, location, file_desc, file_name, a.timestamp as time');
        $this->db->from('file_list a');
        $this->db->join('user b', 'a.username = b.username');  
        $this->db->where('a.status', 1);
        $this->db->order_by('a.timestamp', 'DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    /** Setting Table **/
    public function setting_select_all()
    {
        $this->db->select('*');
        $this->db->from('setting');
        $this->db->where('status', 1);
        $query = $this->db->get()->result();
        return $query;
    }   

    public function supported_format()
    {
        $this->db->select('file_format');
        $this->db->from('setting');
        $query = $this->db->get();
        return $query->row()->file_format;
    }  
}