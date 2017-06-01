<?php
if (!function_exists("debug")) {
	function debug($v = '', $stop = true) {
		echo "<pre>";
		print_r($v);
		echo "</pre>";
		if ($stop) {
			die("End_debug");
		}
		echo "End_debug";
	}
}

if (!function_exists("image")) {
	function image($src, $params = array()) {
		$src = (strlen(trim($src)) > 0) ? $src : DEFAULT_AVATAR;
		$img = '<img src="' . site_url($src) . '" ';
		if (is_array($params)) {
			foreach ($params as $k => $v) {
				$img .= $k . '="' . $v . '" ';
			}
		}
		$img .= '/>';
		return $img;
	}
}

if (!function_exists("product_image")) {
	function product_image($src, $params = array()) {
		$src = (strlen(trim($src)) > 0) ? $src : DEFAULT_PRODUCT;
		$img = '<img src="' . site_url($src) . '" ';
		if (is_array($params)) {
			foreach ($params as $k => $v) {
				$img .= $k . '="' . $v . '" ';
			}
		}
		$img .= '/>';
		return $img;
	}
}

if (!function_exists("show_status")) {
	function show_status($status) {
		$class_status = (($status == 1) ? "check-circle-o" : (($status == -1) ? "ban" : ""));
		$html = '<i class="fa fa-status fa-' . $class_status . ' fa-2x" aria-hidden="true"></i>';
		return $html;
	}
}

if (!function_exists("show_role")) {
	function show_role($role) {
		if (!$role) return '';
		$content = null;
		$class = 'role ';
		switch ($role) {
			case 1:
				$content = 'Quản trị viên';
				$class .= "role-admin";
				break;
			case 2:
				$content = 'Nhà hàng';
				$class .= "role-account";
				break;
			default:
				$content = 'Thành viên';
				$class .= "role-member";
		}
		$html = '<span class="' . $class . '">' . $content . "</span>";
		return $html;
	}
}

if (!function_exists("show_bill_status")) {
	function show_bill_status($bill_id, $status, $role = '') {
		$active_status1 = '';
		$active_status2 = '';
		$active_status3 = '';
		$active_status4 = '';
		switch ($status) {
			case 1:
				$active_status1 = "active";
				break;
			case 2:
				$active_status2 = "active";
				break;
			case 3:
				$active_status3 = "active";
				break;
			case 4:
				$active_status4 = "active";
				break;
		}
		if ($role == 1 || $role == 2) {
			$html = '<span style="display: none">' . $status . '</span>
        <a class="bill-status ' . $active_status1 . '" href="' . site_url("admin/bill/update/" . $bill_id . "/1") . '" title="Mới tạo">Mới</a>
        <a class="bill-status ' . $active_status2 . '" href="' . site_url("admin/bill/update/" . $bill_id . "/2") . '" title="Đang xử lí">Xử lí</a>
        <a class="bill-status ' . $active_status3 . '" href="' . site_url("admin/bill/update/" . $bill_id . "/3") . '" title="Đang gửi hàng">Gửi</a>
        <a class="bill-status ' . $active_status4 . '" href="' . site_url("admin/bill/update/" . $bill_id . "/4") . '" title="Đã thanh toán">Xong</a>
        ';
		} else {
			$html = '<span style="display: none">' . $status . '</span>
        <a class="bill-status ' . $active_status1 . '" title="Mới tạo">Mới</a>
        <a class="bill-status ' . $active_status2 . '" title="Đang xử lí">Xử lí</a>
        <a class="bill-status ' . $active_status3 . '" title="Đang gửi hàng">Gửi</a>
        <a class="bill-status ' . $active_status4 . '" title="Đã thanh toán">Xong</a>
        ';
		}

		return $html;
	}
}

if (!function_exists("show_currency")) {
	function show_currency($number) {
		return number_format($number, 3);
	}
}
if (!function_exists("show_voted_star")) {
	function show_voted_star($number) {
		$html = '';
		if ($number >= 0) {
			for ($i = 0; $i < 5; $i++) {
				if ($i < $number) {
					$html .= '<span class="glyphicon glyphicon-star"></span>';
				} else {
					$html .= '<span class="glyphicon glyphicon-star-empty"></span>';
				}
			}
		}

		return $html;
	}
}
if (!function_exists("do_multi_upload")) {
	function do_multi_upload($field_name) {
		$response = array('ok' => true, 'serror' => '', 'new_file' => '');
		$serror = '';
		$target_dir = UPLOAD_ARTICLE_DIR;
		$num_of_file= count($_FILES[$field_name]['name']);
		$uploadOk = 1;
		if($num_of_file){
			for ($i=0; $i<$num_of_file; $i++){
				$target_file = $target_dir . basename($_FILES[$field_name]["name"][$i]);

				if (($_FILES[$field_name]["name"][$i] != '')) {
					$new_file = '';
					$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
					if (isset($post["submit"])) {
						$check = getimagesize($_FILES[$field_name]["tmp_name"][$i]);
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
					if ($_FILES[$field_name]["size"][$i] > MAX_UPLOAD_FILE_SIZE) {
						$serror .= "Kích thước file phải nhỏ hơn ".(MAX_UPLOAD_FILE_SIZE/1024/1024)."MB";
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
						$new_file = $target_dir . md5(basename($_FILES[$field_name]["name"][$i] . microtime())) .".".$imageFileType;
						if (move_uploaded_file($_FILES[$field_name]["tmp_name"][$i], $new_file)) {
//                        $serror .=  "The file ". basename( $_FILES[$field_name]["name"][$i]). " has been uploaded.";
							$uploadOk = 1;
						} else {
							$uploadOk = 0;
							$serror .= "Có lỗi khi đang tải file lên.";
						}
					}
					if ($new_file) {
						$response['new_file'][] = $new_file;
					}
				}
			}
		}

		$response['ok'] = $uploadOk;
		$response['serror'] = $serror;
		return $response;
	}
}