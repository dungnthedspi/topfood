<?php

class Member extends Admin_Controller {
	private $model_name;

//    public $session;
	function __construct() {
		parent::__construct();
		$this->model_name = "model";
		$this->load->model('admin_model', $this->model_name);
	}

	function index() {
		$members = $this->model->getList();
		$data = array(
			'header_title' => 'Danh sách thành viên',
			'members' => $members
		);
		$this->output->append_title("member");
		$this->load->view("members/index", $data);
	}

	function edit($id) {

		$data = array();
		if (intval($id) >= 0) {
			$data['member'] = $this->model->getUserById($id);
		} else {
			show_404();
		}
		$data['member'] = $data['member'][0];
		$data['header_title'] = 'Cập nhật thông tin thành viên';
//        debug($data);
		$this->output->append_title($data['member']->first_name . " " . $data['member']->last_name);

		$this->load->view("members/edit", $data);
	}

	function update($id) {
		if (intval($id) < 0) {
			show_404();
		}
		$post = $this->input->post();
//        debug($post);
		$serror = '';
		if ($post && intval($id) >= 0) {

			$currentUserData = $this->model->getUserById($id);
			$currentUserData = $currentUserData[0];

			$target_dir = UPLOAD_AVATAR_DIR;

			$target_file = $target_dir . basename($_FILES["avatar"]["name"]);
			$uploadOk = 1;

			if (($_FILES["avatar"]["name"] != '') && $currentUserData->avatar != $target_file) {
				$new_file = '';
				$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
				if (isset($post["submit"])) {
					$check = getimagesize($_FILES["avatar"]["tmp_name"]);
					if ($check !== false) {
						$uploadOk = 1;
					} else {
						$serror .= "File không phải là file ảnh.";
						$uploadOk = 0;
					}
				}
// Check if file already exists
				if (file_exists($target_file)) {
					$serror .= "Sorry, file already exists.";
					$uploadOk = 0;
				}
// Check file size
				if ($_FILES["avatar"]["size"] > MAX_UPLOAD_FILE_SIZE) {
					$serror .= "Sorry, your file is too large.";
					$uploadOk = 0;
				}
// Allow certain file formats
				$imageFileType = strtolower($imageFileType);
				if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
					&& $imageFileType != "gif"
				) {
					$serror .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
					$uploadOk = 0;
				}
// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
					$serror .= "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
				} else {
					$new_file = $target_dir . md5(basename($_FILES["avatar"]["name"] . microtime())) . "." . $imageFileType;
					if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $new_file)) {
						$uploadOk = 1;
					} else {
						$uploadOk = 0;
						$serror .= "Sorry, there was an error uploading your file.";
					}
				}
				$this->session->set_flashdata("serror", $serror);
				if ($new_file) {
					$post['avatar'] = $new_file;
					unlink($currentUserData->avatar);
				}
			}
			if ($uploadOk == 1) {
				unset($post['username']);

				if (isset($post['do_change_password'])) {
					unset($post['do_change_password']);
					$post['password'] = md5($post['password']);
				} else {
					unset($post['password']);
				}
				if (!isset($post['status'])) {
					$post['status'] = -1;
				}

				$do_update_member = $this->model->updateUserById($id, $post);
				if ($do_update_member) {

					$log_in_data = $this->getLogInData();
					if ($log_in_data->id == $id) {
						$currentUserData = $this->model->getUserById($id);
						$this->session->set_userdata("LogInData", $currentUserData[0]);
					}
					$this->session->set_flashdata("smsg", "Cập nhật thông tin thành công.");
					redirect('admin/member');
				} else {
					$this->session->set_flashdata("serror", $serror);
					redirect('admin/member/edit/' . $id);
				}
			} else {
				$this->session->set_flashdata("serror", $serror);
				redirect('admin/member/edit/' . $id);
			}
		}
	}

	function detail($id) {
		if (intval($id) < 0) {
			show_404();
		}
		$data = array();
		if (intval($id) >= 0) {
			$data['member'] = $this->model->getUserById($id);
		}
		$data['member'] = $data['member'][0];
		$data['header_title'] = 'Chi tiết thông tin thành viên';
//        debug($data);
		$this->output->append_title($data['member']->first_name . " " . $data['member']->last_name);

		$this->load->view("members/detail", $data);
	}

	function delete($id) {
		if (intval($id) < 0) {
			show_404();
		}
		if (intval($id) >= 0) {
			if ($this->model->deleteUserById($id)) {
				$this->session->set_flashdata("smsg", "Xóa thành công!");
			} else {
				$this->session->set_flashdata("serror", "Có lỗi trong quá trình xóa tài khoản, vui lòng thử lại!");
			}
		}
		redirect('admin/member');
	}

	public function add() {

		$data['header_title'] = 'Thêm thành viên mới';
		$this->load->view("members/add", $data);
	}

	public function insert() {

		$post = $this->input->post();
		if ($post) {
			$existed_user = $this->model->getUserByName($post['username']);
			if (count($existed_user)) {
				$this->session->set_flashdata("serror", "Tên đăng nhập đã tồn tại, vui lòng chọn tên đăng nhập khác.");
				redirect("admin/member/add");
			}
			$existed_user = $this->model->getUserByEmail($post['email']);
			if (count($existed_user)) {
				$this->session->set_flashdata("serror", "Email đăng ký đã tồn tại, vui lòng chọn email khác.");
				redirect("admin/member/add");
			}

			$do_upload = $this->do_upload("avatar");

			if ($do_upload['ok']) {
				$post['avatar'] = $do_upload['new_file'];
				$post['password'] = md5($post['password']);
				$do_add_user = $this->model->addUser($post);
				if ($do_add_user) {
					$this->session->set_flashdata("smsg", "Thêm mới thành công!");
					redirect("admin/member");
				} else {
					$this->session->set_flashdata("serror", "Có lỗi trong quá trình thêm mới, vui long thử lại.");
					redirect("admin/member/add");
				}
			} else {
				$this->session->set_flashdata("serror", $do_upload['serror']);
				redirect("admin/member/add");
			}

		}
	}

	function admin() {
		$this->getUserByRole(ROLE_ADMIN);
	}

	function restaurant() {
		$this->getUserByRole(ROLE_RESTAURANT);
	}

	function customer() {
		$this->getUserByRole(ROLE_CUSTOMER);
	}

	private function getUserByRole($role) {
		$params = array('role' => $role);
		$members = $this->model->getList($params);
		$object_name = '';
		switch ($role) {
			case 1:
				$object_name = ' quản trị viên';
				break;
			case 2:
				$object_name = ' nhà hàng';
				break;
			case 3:
				$object_name = ' khách hàng';
				break;
		}
		$data = array(
			'header_title' => 'Danh sách' . $object_name,
			'members' => $members
		);
		$this->output->append_title($data['header_title']);
		$this->load->view("members/index", $data);
	}

}