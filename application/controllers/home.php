<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Home CI_Controller Class
 * 
 * @access public
 * @author Rahmat Syaparudin
 * @return void
 * @url http://yoursite.com/home/
 */
class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('session', 'form_validation', 'aes128', 'pagination', 'numbertoword'));
		$this->load->model(array('home_db'));
	}

	public function index()
	{
		$view['message'] = $this->session->flashdata('message');
		$this->timeline();
	}

	/** Login Controller **/
	public function signin()
	{	
		if($this->session->userdata("isLogin")==TRUE) : redirect('home/signout'); endif;
		$message = '';		
		$message = $this->session->flashdata('message');

		$username = trim($this->input->post('username'));
		$password = trim($this->input->post('password'));
		$isSignIn = trim($this->input->post('signin'));	
		$verify_password = $this->aes128->aesEncrypt($password);

		if ($this->input->post('signin'))
		{
			if (empty($username) && empty($password)) 
				$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Failed!", text: "Username & Password must be fill.", icon: "error", button: "I Will Try!", timer: 5000,});});</script>';
			else
			{
				if (empty($username))
					$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Sorry!", text: "Username must be fill.", icon: "warning", button: "I Forgot!", timer: 5000,});});</script>';
				else if (empty($password))
					$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Sorry!", text: "Password must be fill.", icon: "warning", button: "Never Mind!", timer: 5000,});});</script>';
				else if (!empty($username) && !empty($password))
				{
					$getUser = '';
					$getPassword = '';
					$getName = '';
					$getStatus = 0;
					$getDeleted = 0;
					$isAdmin = 0;

					$data = $this->home_db->user_login($username);
					$cekRow = $this->home_db->user_login_check_row($username);
					foreach ($data as $row)
					{
						$getUser = $row->username;
						$getPassword = $row->password;
						$getName = $row->name;
						$getStatus = $row->status;
						$getDeleted = ($row->isDeleted == NULL) ? 0 : 1;
						$getAdmin = $row->isAdmin;
						$getAdmin  = empty($getAdmin) ? 0 : $getAdmin;
					}

					if ($username != $getUser)
						$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Failed!", text: "Username '.$username.' doesnt exist.", icon: "error", button: "I\'m Kidding!", timer: 5000,});});</script>';
					else if ($verify_password != $getPassword)
						$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Sorry!", text: "Your password doesnt match.", icon: "warning", button: "Wait a Minute!", timer: 5000,});});</script>';
					else if ($username == $getUser && $verify_password == $getPassword)
					{
						if ($getDeleted == 1)
						{
							$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Bad News!", text: "'.$username.' already deleted from database.", icon: "error", button: "Oh No!", timer: 5000,});});</script>';
						}
						else
						{
							if ($getStatus == 0)								
								$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "We Need To Talk!", text: "Your account has been disabled. Please contact your Administrator.",  icon: "error", button: "Okay Baby!", timer: 5000,});});</script>';
							else
							{
								$userSession = array(
									'getName' => $getName, 
									'getUsername' => $getUser,
									'isAdmin' => $getAdmin,
									'isLogin' => TRUE
								);
								$this->session->set_userdata($userSession);
								
  							
								$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Yeay!", text: "You have successfully signed in.",  icon: "success", button: false, closeOnClickOutside: false, closeOnEsc: false, timer: 5000,});});</script>'; #"Aww yiss!"
								echo '<meta http-equiv="refresh" content="2;url='.base_url().'index.php/home/upload">';
							}
						}												
					}
					else $message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Security Alert!", text: "Wrong Details.",  icon: "error", button: "Sorry!", timer: 5000,});});</script>'; 
				}
				else $message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Security Alert!", text: "You have no authorize.",  icon: "error", button: "Sorry!", timer: 5000,});});</script>';  
			}
		}

		$dir = 'home/';
		$view['dir'] = $dir;
		$view['js'] = $dir.'signin_js';
		$view['content'] = $dir.'signin_main';
		$view['message'] = $message;
		$view['username'] = $username;
		$view['password'] = $password;
		$this->load->view('template', $view);
	}

	public function signout() 
	{
		$message = '';		
		$message = $this->session->flashdata('message');
		$userSession = array(
			'getName' => '', 
			'getUsername' => '',
			'isAdmin' => '',
			'isLogin' => FALSE
		);
		$this->session->unset_userdata($userSession);
		$this->session->sess_destroy();
		$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Bye Bye!", text: "You successfully signed out.",  icon: "success", button: false, closeOnClickOutside: false, closeOnEsc: false, timer: 5000,});});</script>'; #"See You Later!"
		$this->session->set_flashdata('message', $message);
		echo '<meta http-equiv="refresh" content="1;url='.base_url().'index.php/home/signin">';
		$dir = 'home/';
		$view['dir'] = $dir;
		$view['js'] = $dir.'signin_js';
		$view['content'] = $dir.'signin_main';
		$view['message'] = $message;
		$view['username'] = '';
		$view['password'] = '';
		$this->load->view('template', $view); 
	}

	/** Timeline Controller **/
	public function timeline()
	{
		$total_row = $this->home_db->timeline_total_rows();
		$page_num = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
		
		$config = array();
		$config['base_url'] = base_url().'index.php/home/timeline/page';
		$config['total_rows'] = $total_row;
		$config['per_page'] = 6;	
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['first_url'] = '1';
		$config['full_tag_open'] = "<ul class='pagination pagination-sm pagination-centered'>";
      	$config['full_tag_close'] ="</ul>";
	    $config['num_tag_open'] = '<li>';
	    $config['num_tag_close'] = '</li>';
	    $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
	    $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
	    $config['next_link'] = 'Next';
	    $config['next_tag_open'] = "<li>";
	    $config['next_tagl_close'] = "</li>";
	    $config['prev_link'] = 'Previous';
	    $config['prev_tag_open'] = "<li>";
	    $config['prev_tagl_close'] = "</li>";
	    $config['first_tag_open'] = "<li>";
	    $config['first_tagl_close'] = "</li>";
	    $config['last_tag_open'] = "<li>";
	    $config['last_tagl_close'] = "</li>";
	    $config['first_link'] = 'First';
    	$config['last_link'] = 'Last';
    	$offset = ($config['per_page'] * $page_num) - $config['per_page'];
		$this->pagination->initialize($config);
		
		$dir = 'home/';
		$view['dir'] = $dir;
		$view['js'] = '';
		$view['content'] = $dir.'timeline_main';
		$view['results'] = $this->home_db->timeline_data($config["per_page"], $offset);
		$view['pages'] = $this->pagination->create_links();
		$view['page_num'] = $page_num;
		$this->load->view('template', $view);
	}

	public function viewFullscreen($id)
	{	
		$data = $this->home_db->timeline_fullscreen($this->aes128->aesDecrypt($id));

		$dir = 'home/';
		$view['dir'] = $dir;
		$view['js'] = '';
		$view['data'] = $data;
		$view['content'] = $dir.'viewFullscreen_main';
		$this->load->view('template', $view);
	}

	/** Upload Controller **/
	public function upload($command = '', $id='')
	{
		if($this->session->userdata("isLogin")!=TRUE):redirect('home/signin');endif;

		$message = '';		
		$message = $this->session->flashdata('message');

		$command = ($this->uri->segment(3)) ? $this->uri->segment(3) : "";
		$id = ($this->uri->segment(4)) ? $this->aes128->aesDecrypt($this->uri->segment(4)) : "";

		if ($command == "")
		{
			$view['file_id'] = "";
			$view['file_tittle'] = "";
			$view['file_desc'] = "";
			$view['file_name'] = "";
			$view['statusName'] = "Insert Data";
			$view['btnValue'] = "Add";
			$view['btnName'] = "uploadFile";
			$view['btnView'] = "Save";
			$view['btnIcon'] = "fa-save";
			$view['viewColor'] = "success";

			if($this->input->post('uploadFile') != '')
			{
				$file = $_FILES['fileToUpload']['name'];
				$filename = preg_replace('/[^a-z0-9](?![^.]*$)/i', '_', $file);
		    	
		    	$data = $this->home_db->setting_select_all();
		    	foreach ($data as $row) 
				{
					$uploadPath = $row->path_to_upload.'/';
					$uploadPathToServer = './'.$row->path_to_upload.'/';
					$fileformat = ''.$row->file_format.'|'; 
				}
				
				$config['allowed_types'] = $fileformat;
				$config['upload_path'] = $uploadPathToServer;
				$config['file_name'] = $filename;
				$config['overwrite'] = FALSE;
				
				$this->load->library('upload', $config);

				if (empty($filename))
					$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Oops!", text: "You have not selected a file yet.", icon: "error", button: "You are that guy!", timer: 5000,});});</script>';
				else
				{
					if (file_exists($uploadPath.$filename))
						$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Failed!", text: "'.$filename.' is already exist.", icon: "error", button: "You are that guy!", timer: 5000,});});</script>';
					else
					{
						if ($this->upload->do_upload('fileToUpload'))
				        {
				        	$file_tittle = $this->input->post('file_tittle');
				        	$file_desc = $this->input->post('file_desc');
				        	$fileToUpload = $this->input->post('fileToUpload');
				        	$location = $uploadPath.$filename;
				        	$getUser = $this->session->userdata('getUsername'); 
				        	$description  = empty($file_desc) ? NULL : $file_desc;
				        	$status = 1;

				        	$data = array(
				        		'file_tittle' =>  $file_tittle,
				        		'file_name' =>  $filename, 
				        		'file_desc' =>  $description, 
				        		'location' =>  $location, 
				        		'status' =>  $status, 
				        		'username' =>  $getUser,
				        	);

				        	$this->home_db->upload_insert($data);
				        	$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Good Job!", text: "'.$file_tittle.' successfully uploaded.", icon: "success", button: "You are a hero!", timer: 5000,});});</script>';
				        	$this->session->set_flashdata('message', $message);
					        redirect('home/upload');
				        }
				        else
				        {
				            $view['file_tittle'] = trim($this->input->post('file_tittle'));
							$view['file_desc'] = trim($this->input->post('file_desc'));
							$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Oh No!", text: "The file you uploaded is not supported.", icon: "error", button: "My Bad!", timer: 5000,});});</script>';
						}
					}	
				}							
			}
		}
		else if ($command != "")
		{
			switch ($command) {
				case 'edit':
					$row = $this->home_db->upload_edit($id)->row();
					$data = array(
						'file_id'=> $id,
						'file_tittle'=> $row->file_tittle,
						'file_name'=> $row->file_name,
						'file_desc'=> $row->file_desc,
						'location'=> $row->location,
						'status'=> $row->status,
						'username'=> $row->username,
						'timestamp'=> $row->timestamp
					);
					$this->session->set_userdata($data);

					$view['file_id'] = trim($this->session->userdata("file_id"));
					$view['file_tittle'] = trim($this->session->userdata("file_tittle"));
					$view['file_desc'] = trim($this->session->userdata("file_desc"));
					$view['file_name'] = trim($this->session->userdata("file_name"));
					$view['statusName'] = "Edit Data";
					$view['btnValue'] = "Edit";
					$view['btnName'] = "editFile";
					$view['btnView'] = "Edit";
					$view['btnIcon'] = "fa-edit";
					$view['viewColor'] = "warning";

					if($this->input->post('editFile') != ''):
						if ($this->input->post('file_tittle') != '')
						{
							$file_tittle = $this->input->post('file_tittle');
					        $file_desc = $this->input->post('file_desc');
					        $getUser = $this->session->userdata('getUsername'); 
					        $description  = empty($file_desc) ? NULL : $file_desc;
					        
					        $data = array(
					        	'file_tittle' =>  $file_tittle,
					        	'file_desc' =>  $description, 
					        	'username' =>  $getUser,
					        );	

					        $this->home_db->upload_update($id, $data);
					        $message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Good Job!", text: "File ID '.$id.' successfully updated.", icon: "success", button: "Thank You!", timer: 5000,});});</script>';
					        $this->session->set_flashdata('message', $message);
					        redirect('home/upload');
					        swal();
						}
						else
						{
							$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Sorry!", text: "File Title must be fill.", icon: "warning", button: "Take it easy!", timer: 5000,});});</script>';
						}						
					endif;
				break;
			}
		}		
				
		$dir = 'home/';
		$view['dir'] = $dir;
		$view['js'] = $dir.'upload_js';
		$view['content'] = $dir.'upload_main';
		$view['message'] = $message;
		$this->load->view('template', $view);
	}

	public function jsonUpload()
	{
		$data = $this->home_db->upload_select_all();
		$number = 1;
		$aaData = array();
		if (!empty($data))
		{
			foreach ($data as $row) 
			{
				$date = date('d F Y', strtotime($row->time));

				$aaData[] = array(
					$number++,
					$row->file_id,
					$row->fname,
					$row->uname,
					$date, 
					'<a class="btn btn-xs btn-info"  data-toggle="modal" data-target="#modalViewDetail" data-whatever="'.$row->file_id.'" data-placement="top" title="View"><i class="fa fa-eye"></i></a>
					<a href="'.base_url().'index.php/home/upload/edit/'.$this->aes128->aesEncrypt($row->file_id).'" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Edit">
						<i class="fa fa-edit"></i></a>
				    <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return fileDelete('.$row->file_id.');"><i class="fa fa-trash"></i></a>'
				);
			}
		}
		$result['aaData'] = $aaData;
		echo json_encode($result);
		return;
	}

	public function jsonUploadDelete($id='')
	{
		$id = $this->input->post('id');
		$edit = $this->input->post('edit');

		$localDir = $this->home_db->upload_get_location($id);
		$data = $this->home_db->upload_delete($id);
		
		if (file_exists($localDir))
		{
			unlink($localDir);
		}

		$response_array['status'] = 'success';
		header('Content-type: application/json');
		echo json_encode($response_array);
		return;
	}
	
	public function jsonUploadView($id='')
	{
		$data = $this->home_db->upload_get_byId($id);		
		echo json_encode($data);
		return;
	}

	/** User Controller **/
	public function user($command = '')
	{
		if($this->session->userdata("isLogin")!=TRUE):redirect('home/signin');endif;

		$message = '';
		$message = $this->session->flashdata('message');

		if ($this->input->post('addUser') == 'Add'):
			$username = trim($this->input->post('username'));
			$password = trim($this->aes128->aesEncrypt($this->input->post('password')));
			$name = trim($this->input->post('name'));
			$email = trim($this->input->post('email'));
			$level = trim($this->input->post('levelAdd'));
			$status = trim($this->input->post('statusAdd'));

			if (empty($username)) 
				$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Sorry!", text: "Username must be fill.", icon: "warning", button: "Take it easy!", timer: 5000,});});</script>';
			else if (empty($password)) 
				$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Sorry!", text: "Password must be fill.", icon: "warning", button: "Take it easy!", timer: 5000,});});</script>';
			else if (empty($name)) 
				$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Sorry!", text: "Name must be fill.", icon: "warning", button: "Take it easy!", timer: 5000,});});</script>';
			else if (empty($email)) 
				$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Sorry!", text: "Email must be fill.", icon: "warning", button: "Take it easy!", timer: 5000,});});</script>';
			else if (empty($level)) 
				$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Sorry!", text: "Level must be fill.", icon: "warning", button: "Take it easy!", timer: 5000,});});</script>';
			else if (empty($status)) 
				$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Sorry!", text: "Status must be fill.", icon: "warning", button: "Take it easy!", timer: 5000,});});</script>';
			else
			{
				if ($username == "admin") 
					$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Oops!", text: "Username '.$username.' already exist in database.", icon: "error", button: "Give me a Time!", timer: 5000,});});</script>';
				else
				{
					$isAdmin  = ($level == 'user') ? NULL : 1;
					$isStatus  = ($status == 'enable') ? 1 : 0;
					$data = array(
				        'username' =>  $username,
				        'password' =>  $password, 
				        'name' =>  $name, 
				        'email' =>  $email, 
				        'isAdmin' =>  $isAdmin, 
				        'status' =>  $isStatus,
				    );
				    $this->home_db->user_insert($data);
					$message = '<script type="text/javascript">$(document).ready(function(){swal ({title: "Good Job!", text: "User '.$username.' successfully inserted", icon: "success", button: "To Infinity and Beyond!", timer: 5000,});});</script>';
					$this->session->set_flashdata('message', $message);
					redirect('home/user');
				}
			}
		endif; #end addUser

		$dir = 'home/';
		$view['dir'] = $dir;
		$view['js'] = $dir.'user_js';
		$view['content'] = $dir.'user_main';
		$view['message'] = $message;
		$this->load->view('template', $view);
	}

	public function jsonUser()
	{
		$data = $this->home_db->user_select_all();
		$number = 1;
		$aaData = array();
		if (!empty($data))
		{
			foreach ($data as $row) 
			{
				if ($row->status == 1) $status='<label class="btn btn-xs btn-success"><i class="fa fa-check-square-o"></i> Enable</label>'; 
				else  $status='<label class="btn btn-xs btn-danger"><i class="fa fa-times-circle-o"></i> Disable</label>'; 
				if ($row->isAdmin == 1) $level='<label class="btn btn-xs btn-danger"><i class="fa fa-user-secret"></i> Admin</label>'; 
				else $level='<label class="btn btn-xs btn-success"><i class="fa fa-user"></i> User</label>'; 

				$aaData[] = array(
					$number++,
					$row->username,
					$row->name,
					$row->email,
					$level,
					$status,
					$row->timestamp,
					'<a class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
				    <a class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Delete" onclick=" return userDelete(\''.$row->username.'\'); "><i class="fa fa-trash"></i></a>'
				);
			}
		}
		$result['aaData'] = $aaData;
		echo json_encode($result);
		return;
	}

	public function jsonUserDelete($id='')
	{
		$id = $this->input->post('id');
		if ($this->session->userdata('getUsername') == $id)
		{
			$response_array['status'] = 'isLogin';
		}
		else
		{
			$data = $this->home_db->user_delete($id);
			$response_array['status'] = 'success';
		}	
		
		header('Content-type: application/json');
		echo json_encode($response_array);
		return;
	}
}
?>