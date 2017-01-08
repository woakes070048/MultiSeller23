<?php
class ModelExtensionSellerExtension extends Model {
	public function getInstalled($type) {
		$extension_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = '" . $this->db->escape($type) . "' ORDER BY code");

		foreach ($query->rows as $result) {
			$extension_data[] = $result['code'];
		}

		return $extension_data;
	}

	public function install($type, $code) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "extension SET `type` = '" . $this->db->escape($type) . "', `code` = '" . $this->db->escape($code) . "'");
	}

	public function editSetting($seller_id,$code, $data, $store_id = 0) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $this->db->escape($seller_id.':'.$code) . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "seller_shipping` WHERE seller_id = '" . (int)$seller_id . "' AND `code` = '" . $this->db->escape($code) . "'");

		foreach ($data as $key => $value) {
			if (substr($key, 0, strlen($code)) == $code) {
				if (!is_array($value)) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($seller_id.':'.$code) . "', `key` = '" . $this->db->escape($seller_id.':'.$key) . "', `value` = '" . $this->db->escape($value) . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($seller_id.':'.$code) . "', `key` = '" . $this->db->escape($seller_id.':'.$key) . "', `value` = '" . $this->db->escape(json_encode($value, true)) . "', serialized = '1'");
				}
			}
		}
		$this->db->query("INSERT INTO " . DB_PREFIX . "seller_shipping SET seller_id = '" . (int)$seller_id . "', `code` = '" . $this->db->escape($code) . "'");
	}

	public function getGeoZones() {


				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone WHERE seller_id = '" . (int)$this->customer->getId() . "'");

				$geo_zone_data = $query->rows;


			return $geo_zone_data;
		}


}
