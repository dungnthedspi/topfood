<?php

class Menu extends Admin_Controller {
	private $model_name;

	function __construct() {
		parent::__construct();
		$this->model_name = "model";
		$this->load->model('admin_model', $this->model_name);
	}

	function index() {

		if ($this->log_in_data->role > 2) {
			show_404();
		}
		$items = $this->model->getListAccountMenu($this->log_in_data->account_id, $this->log_in_data->role);

		$data = array(
			"header_title" => "Danh sách thực đơn",
			"items" => $items
		);
//        debug($this->log_in_data);
		$this->output->append_title("Menu");
		$this->load->view("menus/index", $data);
	}

	function upload() {
		$this->load->view("menus/import");
	}

	function import() {
		$serror = '';
		if (isset($_FILES['file']) && $_FILES['file']['name'] != '') {
			$target_dir = UPLOAD_IMPORT_DIR;

			$target_file = $target_dir . basename($_FILES["file"]["name"]);
			$uploadOk = 1;

			if (($_FILES["file"]["name"] != '')) {
				$new_file = '';
				$fileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if file already exists
				if (file_exists($target_file)) {
					$serror .= "File đã tồn tại.";
					$uploadOk = 0;
				}
// Check file size
				if ($_FILES["file"]["size"] > MAX_UPLOAD_FILE_SIZE) {
					$serror .= "Kích thước file quá lớn.";
					$uploadOk = 0;
				}
// Allow certain file formats
				$fileType = strtolower($fileType);
				if ($fileType != "xlsx") {
					$serror .= "Chỉ cho phép tải lên file có định dạng Excel.";
					$uploadOk = 0;
				}
// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
					$serror .= "File không được tải lên.";
					$this->session->set_flashdata("serror", $serror);
					$this->load->view("menus/import");
// if everything is ok, try to upload file
				} else {
					$new_file = $target_dir . md5(basename($_FILES["file"]["name"] . microtime())) . $fileType;
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $new_file)) {
						$uploadOk = 1;
						//import data
						$header = array();
						$arr_data = array();
//load the excel library
						$this->load->library('excel');
//read file from path
						$objPHPExcel = PHPExcel_IOFactory::load($new_file);
//get only the Cell Collection
						$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
//extract to a PHP readable array format
						foreach ($cell_collection as $cell) {
							$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
							$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
							$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
							//header will/should be in row 1 only. of course this can be modified to suit your need.
							if ($row == 1) {
								$header[$column] = $data_value;
							} else {
								$arr_data[$row][$column] = $data_value;
							}
						}
//send the data in an array format
						$insert_batch_item = array();
						$insert_batch_account_item = array();
						$uploaded_rows = count($arr_data);
						if ($uploaded_rows) {
							foreach ($arr_data as $item) {
								if (isset($item['A']) && $item['A'] != '') {
									$tmp_array = array();
									foreach ($header as $col_name => $field_name) {
										if (isset($item[$col_name])) $tmp_array[$field_name] = $item[$col_name];
									}
									$tmp_array['item_id'] = uniqid($this->log_in_data->id . "_");
									$tmp_array['date_created'] = date("Y-m-d H:i:s");
									$insert_batch_item[] = $tmp_array;
									$insert_batch_account_item[] = array(
										'account_id' => $this->log_in_data->account_id,
										'item_id' => $tmp_array['item_id']
									);
								}

							}
						}

						$imported_rows = count($insert_batch_item);
						if ($imported_rows) {
							$ok = $this->model->insertBatch($insert_batch_item, "item");
							$ok = $this->model->insertBatch($insert_batch_account_item, "account_item");
							if ($ok) {
								$smsg = "Đã nhập " . $imported_rows . " trong tổng số " . $uploaded_rows . " sản phẩm.";
								$this->session->set_flashdata("smsg", $smsg);
								redirect(site_url("admin/menu"));
							} else {
								$serror .= "Có lỗi khi import thực đơn.";
								$this->session->set_flashdata("serror", $serror);
								$this->load->view("menus/import");
							}
						};

					} else {
						$uploadOk = 0;
						$serror .= "Có lỗi khi đang tải file lên.";
						$this->session->set_flashdata("serror", $serror);
						$this->load->view("menus/import");
					}
				}
			}

		} else {
			$serror = "Vui lòng chọn file";
			$this->session->set_flashdata("serror", $serror);
			$this->load->view("menus/import");
		}
	}

	function delete($id) {
		if (intval($id) < 0) {
			show_404();
		}
		$ok = $this->model->deleteItem($id);
		if ($ok) {
			$smsg = "Đã xóa sản phẩm " . $id . ".";
			$this->session->set_flashdata("smsg", $smsg);
		} else {
			$serror = "Đã có lỗi khi xóa sản phẩm " . $id . ".";
			$this->session->set_flashdata("serror", $serror);
		}
		$this->session->set_flashdata("smsg", $smsg);
		redirect(site_url("admin/menu"));
	}

	function edit($id =''){
		if (intval($id) < 0) {
			show_404();
		}
		$item = $this->model->getMenuItemById($id);
		if(count($item)){
			$data=array(
				'header_title' => 'Cập nhật sản phẩm',
				'data' => $item[0]
			);
			$this->load->view('menus/edit', $data);
		}else{
			show_404();
		}
	}

	function update($id){
		if (intval($id) < 0) {
			show_404();
		}
		$post = $this->input->post();
		if ($post) {
			$item = $this->model->getMenuItemById($id);
			if (count($item)){
				$do_upload = $this->do_upload("photo",'menu');
				if ($do_upload['ok']) {
					$post['photo'] = $do_upload['new_file'];
					$this->model->updateMenuItemById($id, $post);
					$this->session->set_flashdata("smsg", "Cập nhật thông tin sản phẩm thành công!");
					redirect("admin/menu");
				} else {
					$this->session->set_flashdata("serror", $do_upload['serror']);
					redirect("admin/menu/edit");
				}
			}else{
				show_404();
			}



		}
	}
}