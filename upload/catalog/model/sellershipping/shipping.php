<?php
class ModelSellerShippingShipping extends Model {
	public function getQuote($address,$shipping,$seller_id,$product_id) {
		$this->load->language('sellershipping/shipping');

		$quote_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone WHERE seller_id = '" . (int)$seller_id . "' ORDER BY name");

		if($shipping == 'flat'){

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get($seller_id.':flat_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

			if (!$this->config->get($seller_id.':flat_geo_zone_id')) {
				$status = true;
			} elseif ($query->num_rows) {
				$status = true;
			} else {
				$status = false;
			}

			$method_data = array();

			if ($status) {
				$quote_data = array();

				$quote_data['flat'] = array(
					'code'         => $seller_id.':flat.flat',
					'title'        => $this->config->get($seller_id.':flat_name'),
					'cost'         => $this->config->get($seller_id.':flat_cost'),
					'tax_class_id' => $this->config->get($seller_id.':flat_tax_class_id'),
					'text'         => $this->currency->format($this->tax->calculate($this->config->get($seller_id.':flat_cost'), 0, $this->config->get('config_tax')), $this->session->data['currency'])
				);

				$method_data = array(
					'code'       => $seller_id.':flat',
					'title'      => $this->config->get($seller_id.':flat_name'),
					'quote'      => $quote_data,
					'sort_order' => $this->config->get($seller_id.':flat_sort_order'),
					'error'      => false
				);
			}

			return $method_data;

		}

		if($shipping == 'weight'){

			foreach ($query->rows as $result) {

				if ($this->config->get($seller_id.':weight_' . $result['geo_zone_id'] . '_status')) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$result['geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

					if ($query->num_rows) {
						$status = true;
					} else {
						$status = false;
					}
				} else {
					$status = false;
				}

				if ($status) {
					$cost = '';
					$weight = $this->getWeight($product_id);

					$rates = explode(',', $this->config->get($seller_id.':weight_' . $result['geo_zone_id'] . '_rate'));

					foreach ($rates as $rate) {
						$data = explode(':', $rate);

						if ($data[0] >= $weight) {
							if (isset($data[1])) {
								$cost = $data[1];
							}

							break;
						}
					}

					if ((string)$cost != '') {
						$quote_data['weight_' . $result['geo_zone_id']] = array(
							'code'         => $seller_id.':weight.weight_' . $result['geo_zone_id'],
							'title'        => '  (' . $this->config->get($seller_id.':weight_name') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class_id')) . ')',
							'cost'         => $cost,
							'tax_class_id' => $this->config->get($seller_id.':weight_tax_class_id'),
							'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get($seller_id.':weight_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
						);
					}
				}
			}

			$method_data = array();

			if ($quote_data) {
				$method_data = array(
					'code'       => 'weight',
					'title'      => $this->config->get($seller_id.':weight_name'),
					'quote'      => $quote_data,
					'sort_order' => $this->config->get($seller_id.':weight_sort_order'),
					'error'      => false
				);
			}



			return $method_data;




		}


	}

	function getShippings($seller_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seller_shipping WHERE `seller_id` = '" . (int)$seller_id . "'");

		return $query->rows;
	}
	public function getWeight($product_id) {
		$weight = 0;



					$productresults = $this->model_sellerproduct_product->getProductsByProductId($product_id);

					foreach ($productresults as $productresult) {

					if (isset($productresult['seller_id'])) {
			if ($productresult['shipping']) {
				foreach ($this->cart->getProducts() as $product) {
					if($product['product_id'] == $product_id){

						$weight += $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('config_weight_class_id'));

					}
				}

			}

		}


	}


return $weight;

}
}
