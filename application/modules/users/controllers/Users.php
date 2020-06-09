<?php

class Users extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->form_validation->CI =& $this;
        $this->data = null;
        $this->load->module("master");
        $this->db = $this->load->database('default', TRUE);
        $this->load->vars('current_url', $this->uri->uri_to_assoc(1));
    }


    function index()
    {
        if (!$this->logged_in()) {
            redirect('index.php/Users/login');
        }
        if ($this->in_group('admin') || $this->in_group('management')) {
            $this->data['users'] = $this->master->get('users');
        } else {
            $user = $this->get_user();
            $this->data['users'] = $this->master->get_where_custom('users', 'district', $user->district);
        }
        $this->data['heading'] = "Users";
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['main_content'] = 'index';
        $this->load->view('includes/template', $this->data);
    }

    public function login()
    {
        if ($this->logged_in()) {
            redirect('index.php/users/index');
        }
        $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|callback_check_status|callback_can_login');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
        if ($this->form_validation->run() == TRUE) {

            $login_data = array(
                'user' => $this->input->post('username'),
                'logged_in' => 1
            );
            $this->session->set_userdata($login_data);
            redirect('index.php/Tpvics/index');
        }
        $this->data['main_content'] = 'login';
        $this->load->view('includes/template', $this->data);
    }

    public function register()
    {
        if (!$this->logged_in()) {
            redirect('index.php/users/login');
        }
        $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|is_unique[users.username]');
        $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|xss_clean');
        $this->form_validation->set_rules('designation', 'Designation', 'required|trim|xss_clean');
        $this->form_validation->set_rules('dist_id', 'District Id', 'required|trim|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
        $this->form_validation->set_rules('passwordagain', 'Password Confirmation', 'required|trim|xss_clean|matches[password]');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'username' => $this->input->post('username'),
                'full_name' => $this->input->post('full_name'),
                'dist_id' => $this->input->post('dist_id'),
                'designation' => $this->input->post('designation'),
                'password' => $this->input->post('password'),
                'auth_level' => 0,
                'enable' => 1
            );
            $this->master->_insert('users', $data);
            $flash_msg = "User registered successfully";
            $value = '<div class="callout callout-success"><p>' . $flash_msg . '</p></div>';
            $this->session->set_flashdata('message', $value);
            redirect('index.php/users/index');
        }
        $this->data['heading'] = "Create User";
        $this->data['main_content'] = 'register';
        $this->load->view('includes/template', $this->data);
    }


    public function edit_user($id)
    {
        if (!$this->logged_in()) {
            redirect('index.php/users/login');
        }
        $user = $this->get_user();
        if ($user->type === 2) {
            return show_error('An app user cannot use dashboard');
        }
        if ($id != $user->id && !$this->in_group('admin') && (!$this->in_group('district_managers') && $user->district != $this->get_district($id))) {
            return show_error('You must be an authorized user to change these information');
        }
        $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|is_unique[users.username]');
        $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|xss_clean');
        $this->form_validation->set_rules('designation', 'Designation', 'required|trim|xss_clean');
        $this->form_validation->set_rules('dist_id', 'District Id', 'required|trim|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
        $this->form_validation->set_rules('passwordagain', 'Password Confirmation', 'required|trim|xss_clean|matches[password]');
        if ($this->form_validation->run() == TRUE) {
            $user_data = array(
                'username' => $this->input->post('username'),
                'full_name' => $this->input->post('full_name'),
                'dist_id' => $this->input->post('dist_id'),
                'designation' => $this->input->post('designation'),
                'password' => $this->input->post('password')
            );
            $this->master->_update('users', $id, $user_data);
            $flash_msg = "User updated successfully";
            $value = '<div class="callout callout-success"><p>' . $flash_msg . '</p></div>';
            $this->session->set_flashdata('message', $value);
            redirect('index.php/users/index');
        }
        $this->data['user'] = $this->master->get_where_custom('users', 'id', $id)->row();
        $this->data['heading'] = "Edit User";
        $this->data['main_content'] = 'edit_user';
        $this->load->view('includes/template', $this->data);
    }


    public function create_group()
    {
        if (!$this->logged_in()) {
            redirect('index.php/users/login');
        }
        if (!$this->in_group('admin')) {
            return show_error('You must be an administrator to view this page');
        }
        $this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean|is_unique[groups.name]');
        $this->form_validation->set_rules('description', 'Description', 'required|trim|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            );
            $this->master->_insert('groups', $data);
            redirect('index.php/users/index');
        }
        $this->data['heading'] = "Create Group";
        $this->data['main_content'] = 'create_group';
        $this->load->view('includes/template', $this->data);
    }

///////////////////////////////////// Supporting Functions ///////////////////////////////////
    function check_status()
    {
        $this->load->model('users_model');
        if ($this->users_model->check_status()) {
            return true;
        } else {
            $this->form_validation->set_message('check_status', 'No such user or suspended user');
            return false;
        }
    }

    function can_login()
    {
        $this->load->model('users_model');
        if ($this->users_model->can_login()) {
            return true;
        } else {
            $this->form_validation->set_message('can_login', 'Either incorrect username/password or not a dashboard user');
            return false;
        }
    }

    function logged_in()
    {
        if ($this->session->userdata('logged_in')) {
            return true;
        } else {
            return false;
        }
    }

    function in_group($group)
    {
        $this->load->model('users_model');
        $user_id = $this->master->get_where_custom('users_dash', 'username', $this->session->user)->row()->id;
        $group_id = $this->master->get_where_custom('groups', 'name', $group)->row()->id;
        if ($this->users_model->in_group($user_id, $group_id)) {
            return true;
        } else {
            return false;
        }
    }

    function get_user()
    {
        if (!$this->logged_in()) {
            redirect('index.php/users/login');
        }
        $this->load->model('users_model');
        $user = $this->master->get_where_custom('users_dash', 'username', $this->session->user)->row();
        return $user;
    }

    function get_district($id)
    {
        $district = $this->master->get_where_custom('users_dash', 'id', $id)->row()->district;
        return $district;
    }

    function username_check($str)
    {

        $id = $this->uri->segment(3);
        $mysql_query = "SELECT * FROM users where username = '$str' and id != $id";
        $query = $this->master->_custom_query($mysql_query);
        $num_rows = $query->num_rows();
        if ($num_rows > 0) {
            $this->form_validation->set_message('username_check', "This User already exists");
            return false;
        } else {
            return true;
        }
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect('index.php/users/login');
    }


    ////// close db connection ////
    public function __destruct()
    {
        $this->db->close();
    }
}