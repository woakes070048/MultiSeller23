<?php
class ModelExtensionTotalShipping extends Model {
	public function getTotal($total) {

		$products = $this->cart->getProducts();

		$this->load->model('sellerproduct/product');

		foreach ($products as $product) {
				$productresults = $this->model_sellerproduct_product->getProductsByProductId($product['product_id']);

				foreach ($productresults as $productresult) {
						if ($productresult['seller_id']) {

		if ($this->cart->hasShipping() && isset($this->session->data['shipping_method_'.$product['product_id']])) {
			$total['totals'][] = array(
				'code'       => 'shipping',
				'title'      => $this->session->data['shipping_method_'.$product['product_id']]['title'],
				'value'      => $this->session->data['shipping_method_'.$product['product_id']]['cost'],
				'seller_id'      => $productresult['seller_id'],
				'product_id'      => $productresult['product_id'],
				'sort_order' => $this->config->get('extension/shipping_sort_order')
			);



			$total['total'] += $this->session->data['shipping_method_'.$product['product_id']]['cost'];
		}

	}

	}
}
if ($this->cart->hasShipping() && !empty($this->session->data['shipping_method'])) {
	$total['totals'][] = array(
		'code'       => 'shipping',
		'title'      => $this->session->data['shipping_method']['title'],
		'value'      => $this->session->data['shipping_method']['cost'],
		'sort_order' => $this->config->get('extension/shipping_sort_order')
	);

	if ($this->session->data['shipping_method']['tax_class_id']) {
		$tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);

		foreach ($tax_rates as $tax_rate) {
			if (!isset($total['taxes'][$tax_rate['tax_rate_id']])) {
				$total['taxes'][$tax_rate['tax_rate_id']] = $tax_rate['amount'];
			} else {
				$total['taxes'][$tax_rate['tax_rate_id']] += $tax_rate['amount'];
			}
		}
	}

	$total['total'] += $this->session->data['shipping_method']['cost'];
}
}
}
