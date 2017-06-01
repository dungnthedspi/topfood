<?php

class Admin_Controller extends CI_Controller {
	protected $log_in_data;

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('assets');

		$this->checkLogIn();
		$this->checkPermission();
		$this->_init();
	}

	public function checkLogIn() {
		$log_in_data = $this->session->userdata("LogInData");
		if (!isset($log_in_data)) {
			$this->session->sess_destroy();
			redirect("auth");
		} else {
			$this->log_in_data = $log_in_data;
		}
	}

	public function checkPermission() {

		$class = $this->router->fetch_class();
		$method = $this->router->fetch_method();
		$id = ($this->uri->segment(4));

		if ($class == "member") {
			switch ($method) {
				case "index":
				case "delete":
				case "add":
				case "insert":
				case "admin":
				case "customer":
				case "restaurant":
					if ($this->log_in_data->role > 1) {
						redirect("auth");
					};
					break;

				case "edit":
				case "update":
				case "detail":
					if ($this->log_in_data->role > 1 && $id != $this->log_in_data->id) {
						redirect("auth");
					};
					break;
			}
		}
	}

	protected function getLogInData() {
		return $this->log_in_data;
	}

	private function _init() {
		$this->output->set_title("Topfood | Admin");
		$this->output->set_template('admin');
		$this->load->section('admin_header', "themes/admin/header");
		$this->load->section('admin_sidebar', "themes/admin/sidebar");
		$this->load->section('admin_footer', "themes/admin/footer");
	}

	public function do_upload($field_name, $type='') {
		$response = array('ok' => true, 'serror' => '', 'new_file' => '');
		$serror = '';
		$target_dir = ($type == 'menu')?UPLOAD_PRODUCT_DIR:UPLOAD_AVATAR_DIR;

		$target_file = $target_dir . basename($_FILES[$field_name]["name"]);
		$uploadOk = 1;

		if (($_FILES[$field_name]["name"] != '')) {
			$new_file = '';
			$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
			if (isset($post["submit"])) {
				$check = getimagesize($_FILES[$field_name]["tmp_name"]);
				if ($check !== false) {
					$uploadOk = 1;
				} else {
					$serror .= "File không phải là file ảnh.";
					$uploadOk = 0;
				}
			}
// Check if file already exists
			if (file_exists($target_file)) {
				$serror .= "File đã tồn tại.";
				$uploadOk = 0;
			}
// Check file size
			if ($_FILES[$field_name]["size"] > MAX_UPLOAD_FILE_SIZE) {
				$serror .= "Kích thước file quá lớn.";
				$uploadOk = 0;
			}
// Allow certain file formats
			$imageFileType = strtolower($imageFileType);
			if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif"
			) {
				$serror .= "Chỉ cho phép tải lên file có định dạng JPG, JPEG, PNG & GIF.";
				$uploadOk = 0;
			}
// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				$serror .= "File không được tải lên.";
// if everything is ok, try to upload file
			} else {
				$new_file = $target_dir . md5(basename($_FILES[$field_name]["name"] . microtime())) . "." . $imageFileType;
				if (move_uploaded_file($_FILES[$field_name]["tmp_name"], $new_file)) {
//                        $serror .=  "The file ". basename( $_FILES[$field_name]["name"]). " has been uploaded.";
					$uploadOk = 1;
				} else {
					$uploadOk = 0;
					$serror .= "Có lỗi khi đang tải file lên.";
				}
			}
			if ($new_file) {
				$response['new_file'] = $new_file;
			}
		}
		$response['ok'] = $uploadOk;
		$response['serror'] = $serror;
		return $response;
	}
}