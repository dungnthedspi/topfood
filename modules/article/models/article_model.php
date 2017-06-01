<?php

/**
 * Created by PhpStorm.
 * User: Dinh_Quyet
 * Date: 5/17/2017
 * Time: 02:41
 */
class Article_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function insertPost($params) {
		$ok = false;
		$postData = array(
			'title' => $params['title'],
			'description' => $params['description'],
			'status' => $params['status'],
			'date_created' => $params['date_created'],
		);
		$photos = null;
		if (isset($params['photos'])) {
			$photos = $params['photos'];
			unset($params['photos']);
		}
		unset($params['title'], $params['description'], $params['status'], $params['date_created']);

		$this->db->trans_start();
		$this->db->insert("article", $postData);
		$post_id = $this->db->insert_id();
		if ($post_id) {
			$params['article_id'] = $post_id;
			$ok = $this->db->insert("account_article_author", $params);
			if (is_array($photos)) {
				$num_photo = count($photos);
				$photo_data = array();
				for ($i = 0; $i < $num_photo; $i++) {
					$photo_data[$i]['path'] = $photos[$i];
					$photo_data[$i]['date_created'] = $postData['date_created'];
				}
				$ok = $this->db->insert_batch("photo", $photo_data);
				$first_inserted_id = $this->db->insert_id();
				$article_photo_data = array();
				for ($photo_id = $first_inserted_id; $photo_id < ($num_photo + $first_inserted_id); $photo_id++) {
					$article_photo_data[]=array(
						'article_id'=>$post_id,
						'photo_id'=>$photo_id
					);

				}
				$ok = $this->db->insert_batch("article_photo", $article_photo_data);

			}
		}
		$this->db->trans_complete();
		return $ok;
	}
}