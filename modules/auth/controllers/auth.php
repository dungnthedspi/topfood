<?php

class Auth extends Blank_Controller {
	private $model_name;
	private $mysqli;

	function __construct() {
		parent::__construct();
		$this->model_name = "model";
		$this->load->model('auth_model', $this->model_name);
	}

	function index() {
		$log_in_data = $this->session->userdata("LogInData");
		if (isset($log_in_data->username)) {
			redirect("admin/member/detail/" . $log_in_data->id);
		}
		$this->output->append_title("Login");
		$this->load->view("auths/index");
	}

	function login() {
		if (
			!$this->input->post() ||
			!isset($this->input->post()['username']) ||
			!isset($this->input->post()['password']) ||
			(trim($this->input->post()['username']) === '') ||
			(trim($this->input->post()['password']) === '')
		) {
			redirect("auth");
		} else {
			$post = $this->input->post();
			$post['password'] = md5($post['password']);
			$params = array(
				'username' => $post['username'],
				'password' => $post['password']
			);

			$do_log_in = $this->model->logIn($params);
//            debug($do_log_in);
			if (is_array($do_log_in) && count($do_log_in)) {
				$member = $do_log_in[0];
				if ($member->status == 1) {
					$logInData = $this->model->getUserInfo($member->id);
					$this->session->set_userdata("LogInData", $logInData);
					if ($member->role > 2) {
						redirect("home");
					}
					redirect("admin");
				} else {
					$this->session->set_flashdata("serror", "Tài khoản của bạn đang bị khóa!");
					redirect("auth");
				}
			} else {
				$this->session->set_flashdata("serror", "Thông tin đăng nhập không hợp lệ, vui lòng nhập lại!");
				redirect("auth");
			}
		}
	}

	function logout() {
		$this->output->append_title("Logout");
		$this->session->sess_destroy();
		redirect("auth");
	}

	function register() {
		$this->load->view("auths/register");
	}

	function signup() {
		$post = $this->input->post();

		if (!isset($post['first_name'])) {
			$this->session->set_flashdata("serror", "Trường \"Tên\" là bắt buộc!");
			redirect("auth/register");
		}
		if (!isset($post['email'])) {
			$this->session->set_flashdata("serror", "Trường \"Email\" là bắt buộc!");
			redirect("auth/register");
		}
		if (!isset($post['username'])) {
			$this->session->set_flashdata("serror", "Trường \"Tên đăng nhập\" là bắt buộc!");
			redirect("auth/register");
		}
		if (!isset($post['password'])) {
			$this->session->set_flashdata("serror", "Trường \"Mật khẩu\" là bắt buộc!");
			redirect("auth/register");
		} else if (trim(($post['password'])) < 6) {
			$this->session->set_flashdata("serror", "Trường \"Mật khẩu\" phải có ít nhất 6 ký tự!");
			redirect("auth/register");
		}
		if (!isset($post['role'])) {
			$this->session->set_flashdata("serror", "Trường \"Loại tài khoản\" là bắt buộc!");
			redirect("auth/register");
		} else if ($post['role'] != 2 && $post['role'] != 3) {
			$this->session->set_flashdata("serror", "Vui lòng chọn đúng \"Loại tài khoản\"!");
			redirect("auth/register");
		}

		$this->load->model('admin/admin_model');
//        begin check in DB
		$existed_user = $this->admin_model->getUserByName($post['username']);
		if (count($existed_user)) {
			$this->session->set_flashdata("serror", "Tên đăng nhập đã tồn tại, vui lòng chọn tên đăng nhập khác.");
			redirect("auth/register");
		}
		$existed_user = $this->admin_model->getUserByEmail($post['email']);
		if (count($existed_user)) {
			$this->session->set_flashdata("serror", "Email đăng ký đã tồn tại, vui lòng chọn email khác.");
			redirect("auth/register");
		}

		$post['status'] = 1;
		$post['password'] = md5($post['password']);
		$do_add_user = $this->admin_model->addUser($post);
		if ($do_add_user) {
			$this->session->sess_destroy();
			$this->session->set_flashdata("smsg", "Đăng ký thành công! Vui lòng đăng nhập.");
			redirect("auth");
		} else {
			$this->session->set_flashdata("serror", "Có lỗi trong quá trình đăng ký, vui long thử lại.");
			redirect("auth/register");
		}
//        OK
	}
}