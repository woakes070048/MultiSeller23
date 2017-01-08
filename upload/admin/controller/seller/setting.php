<?php
class ControllerSellerSetting extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('seller/setting');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('seller/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_seller_setting->editSetting('config', $this->request->post);

			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('seller/setting', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		
        $data['tab_multiseller_setting'] = $this->language->get('tab_multiseller_setting');
$data['tab_multisellergeneral'] = $this->language->get('tab_multisellergeneral');
$data['tab_multisellerproductsetting'] = $this->language->get('tab_multisellerproductsetting');
$data['tab_multisellerordersetting'] = $this->language->get('tab_multisellerordersetting');
$data['tab_multisellerdownloadsetting'] = $this->language->get('tab_multisellerdownloadsetting');
$data['text_sellerdownloadstatus'] = $this->language->get('text_sellerdownloadstatus');

$this->load->model('catalog/information');

		$data['informations'] = $this->model_catalog_information->getInformations();

if (isset($this->request->post['config_sellerdownloadstatus'])) {
						$data['config_sellerdownloadstatus'] = $this->request->post['config_sellerdownloadstatus'];
					} else {
						$data['config_sellerdownloadstatus'] = $this->config->get('config_sellerdownloadstatus');
					}

$data['text_seller_agree'] = $this->language->get('text_seller_agree');

if (isset($this->request->post['config_seller_agree'])) {
  $data['config_seller_agree'] = $this->request->post['config_seller_agree'];
} else {
  $data['config_seller_agree'] = $this->config->get('config_seller_agree');
}

if (isset($this->request->post['config_seller_agree_id'])) {
			$data['config_seller_agree_id'] = $this->request->post['config_seller_agree_id'];
		} else {
			$data['config_seller_agree_id'] = $this->config->get('config_seller_agree_id');
		}

$data['text_sellerreview'] = $this->language->get('text_sellerreview');

if (isset($this->request->post['config_sellerreview'])) {
						$data['config_sellerreview'] = $this->request->post['config_sellerreview'];
					} else {
						$data['config_sellerreview'] = $this->config->get('config_sellerreview');
					}

$data['text_sellerreviewguest'] = $this->language->get('text_sellerreviewguest');

					if (isset($this->request->post['config_sellerreview_guest'])) {
						$data['config_sellerreview_guest'] = $this->request->post['config_sellerreview_guest'];
					} else {
						$data['config_sellerreview_guest'] = $this->config->get('config_sellerreview_guest');
					}

$data['text_sellerimageupload'] = $this->language->get('text_sellerimageupload');
$data['text_sellerprofileimage'] = $this->language->get('text_sellerprofileimage');
$data['text_sellerproductname'] = $this->language->get('text_sellerproductname');
$data['text_sellerproductimage'] = $this->language->get('text_sellerproductimage');
$data['text_sellerproductdateofcreat'] = $this->language->get('text_sellerproductdateofcreat');
$data['text_sellerproductbadge'] = $this->language->get('text_sellerproductbadge');
$data['text_seller_add_product_alert'] = $this->language->get('text_seller_add_product_alert');
$data['text_sellerproductcount'] = $this->language->get('text_sellerproductcount');
$data['text_sellerproductrating'] = $this->language->get('text_sellerproductrating');
$data['text_sellerwebsite'] = $this->language->get('text_sellerwebsite');
$data['text_sellerfacebook'] = $this->language->get('text_sellerfacebook');
$data['text_sellertwitter'] = $this->language->get('text_sellertwitter');
$data['text_sellergoogleplus'] = $this->language->get('text_sellergoogleplus');
$data['text_sellerinstagram'] = $this->language->get('text_sellerinstagram');

if (isset($this->request->post['config_sellerimageupload'])) {
						$data['config_sellerimageupload'] = $this->request->post['config_sellerimageupload'];
					} else {
						$data['config_sellerimageupload'] = $this->config->get('config_sellerimageupload');
					}

if (isset($this->request->post['config_sellerprofileimage'])) {
						$data['config_sellerprofileimage'] = $this->request->post['config_sellerprofileimage'];
					} else {
						$data['config_sellerprofileimage'] = $this->config->get('config_sellerprofileimage');
					}

if (isset($this->request->post['config_sellerproductname'])) {
						$data['config_sellerproductname'] = $this->request->post['config_sellerproductname'];
					} else {
						$data['config_sellerproductname'] = $this->config->get('config_sellerproductname');
					}
if (isset($this->request->post['config_sellerproductrating'])) {
						$data['config_sellerproductrating'] = $this->request->post['config_sellerproductrating'];
					} else {
						$data['config_sellerproductrating'] = $this->config->get('config_sellerproductrating');
					}
if (isset($this->request->post['config_sellerproductimage'])) {
						$data['config_sellerproductimage'] = $this->request->post['config_sellerproductimage'];
					} else {
						$data['config_sellerproductimage'] = $this->config->get('config_sellerproductimage');
					}

if (isset($this->request->post['config_sellerproductdateofcreat'])) {
						$data['config_sellerproductdateofcreat'] = $this->request->post['config_sellerproductdateofcreat'];
					} else {
						$data['config_sellerproductdateofcreat'] = $this->config->get('config_sellerproductdateofcreat');
					}

if (isset($this->request->post['config_sellerproductbadge'])) {
						$data['config_sellerproductbadge'] = $this->request->post['config_sellerproductbadge'];
					} else {
						$data['config_sellerproductbadge'] = $this->config->get('config_sellerproductbadge');
					}
          if (isset($this->request->post['config_seller_add_product_alert'])) {
						$data['config_seller_add_product_alert'] = $this->request->post['config_seller_add_product_alert'];
					} else {
						$data['config_seller_add_product_alert'] = $this->config->get('config_seller_add_product_alert');
					}

if (isset($this->request->post['config_sellerproductcount'])) {
						$data['config_sellerproductcount'] = $this->request->post['config_sellerproductcount'];
					} else {
						$data['config_sellerproductcount'] = $this->config->get('config_sellerproductcount');
					}

					if (isset($this->request->post['config_sellerwebsite'])) {
						$data['config_sellerwebsite'] = $this->request->post['config_sellerwebsite'];
					} else {
						$data['config_sellerwebsite'] = $this->config->get('config_sellerwebsite');
					}

if (isset($this->request->post['config_sellerfacebook'])) {
						$data['config_sellerfacebook'] = $this->request->post['config_sellerfacebook'];
					} else {
						$data['config_sellerfacebook'] = $this->config->get('config_sellerfacebook');
					}

if (isset($this->request->post['config_sellertwitter'])) {
						$data['config_sellertwitter'] = $this->request->post['config_sellertwitter'];
					} else {
						$data['config_sellertwitter'] = $this->config->get('config_sellertwitter');
					}
if (isset($this->request->post['config_sellergoogleplus'])) {
						$data['config_sellergoogleplus'] = $this->request->post['config_sellergoogleplus'];
					} else {
						$data['config_sellergoogleplus'] = $this->config->get('config_sellergoogleplus');
					}
if (isset($this->request->post['config_sellerinstagram'])) {
						$data['config_sellerinstagram'] = $this->request->post['config_sellerinstagram'];
					} else {
						$data['config_sellerinstagram'] = $this->config->get('config_sellerinstagram');
					}

$data['text_sellerordersettlement'] = $this->language->get('text_sellerordersettlement');

if (isset($this->request->post['config_sellerordersettlement'])) {
						$data['config_sellerordersettlement'] = $this->request->post['config_sellerordersettlement'];
					} else {
						$data['config_sellerordersettlement'] = $this->config->get('config_sellerordersettlement');
					}

					$data['text_sellerorderstatus'] = $this->language->get('text_sellerorderstatus');

if (isset($this->request->post['config_sellerorderstatus'])) {
						$data['config_sellerorderstatus'] = $this->request->post['config_sellerorderstatus'];
					} else {
						$data['config_sellerorderstatus'] = $this->config->get('config_sellerorderstatus');
					}

					$data['text_sellerordernotifyhistory'] = $this->language->get('text_sellerordernotifyhistory');

					if (isset($this->request->post['config_sellerordernotifyhistory'])) {
											$data['config_sellerordernotifyhistory'] = $this->request->post['config_sellerordernotifyhistory'];
										} else {
											$data['config_sellerordernotifyhistory'] = $this->config->get('config_sellerordernotifyhistory');
										}
///////////////////////
if (isset($this->request->post['config_multiseller_out_of_stock_status'])) {
						$data['config_multiseller_out_of_stock_status'] = $this->request->post['config_multiseller_out_of_stock_status'];
					} else {
						$data['config_multiseller_out_of_stock_status'] = $this->config->get('config_multiseller_out_of_stock_status');
					}
if (isset($this->request->post['config_multiseller_date_available'])) {
						$data['config_multiseller_date_available'] = $this->request->post['config_multiseller_date_available'];
					} else {
						$data['config_multiseller_date_available'] = $this->config->get('config_multiseller_date_available');
					}
if (isset($this->request->post['config_multiseller_subtract_stok'])) {
						$data['config_multiseller_subtract_stok'] = $this->request->post['config_multiseller_subtract_stok'];
					} else {
						$data['config_multiseller_subtract_stok'] = $this->config->get('config_multiseller_subtract_stok');
					}
if (isset($this->request->post['config_multiseller_seo_url'])) {
						$data['config_multiseller_seo_url'] = $this->request->post['config_multiseller_seo_url'];
					} else {
						$data['config_multiseller_seo_url'] = $this->config->get('config_multiseller_seo_url');
					}
if (isset($this->request->post['config_multiseller_dimensions'])) {
						$data['config_multiseller_dimensions'] = $this->request->post['config_multiseller_dimensions'];
					} else {
						$data['config_multiseller_dimensions'] = $this->config->get('config_multiseller_dimensions');
					}
if (isset($this->request->post['config_multiseller_length_class'])) {
						$data['config_multiseller_length_class'] = $this->request->post['config_multiseller_length_class'];
					} else {
						$data['config_multiseller_length_class'] = $this->config->get('config_multiseller_length_class');
					}
if (isset($this->request->post['config_multiseller_weight'])) {
						$data['config_multiseller_weight'] = $this->request->post['config_multiseller_weight'];
					} else {
						$data['config_multiseller_weight'] = $this->config->get('config_multiseller_weight');
					}
if (isset($this->request->post['config_multiseller_weight_class'])) {
						$data['config_multiseller_weight_class'] = $this->request->post['config_multiseller_weight_class'];
					} else {
						$data['config_multiseller_weight_class'] = $this->config->get('config_multiseller_weight_class');
					}
if (isset($this->request->post['config_multiseller_status'])) {
						$data['config_multiseller_status'] = $this->request->post['config_multiseller_status'];
					} else {
						$data['config_multiseller_status'] = $this->config->get('config_multiseller_status');
					}
if (isset($this->request->post['config_multiseller_sort_order'])) {
						$data['config_multiseller_sort_order'] = $this->request->post['config_multiseller_sort_order'];
					} else {
						$data['config_multiseller_sort_order'] = $this->config->get('config_multiseller_sort_order');
					}
					if (isset($this->request->post['config_multiseller_sku'])) {
						$data['config_multiseller_sku'] = $this->request->post['config_multiseller_sku'];
					} else {
						$data['config_multiseller_sku'] = $this->config->get('config_multiseller_sku');
					}
					if (isset($this->request->post['config_multiseller_upc'])) {
						$data['config_multiseller_upc'] = $this->request->post['config_multiseller_upc'];
					} else {
						$data['config_multiseller_upc'] = $this->config->get('config_multiseller_upc');
					}
					if (isset($this->request->post['config_multiseller_ean'])) {
						$data['config_multiseller_ean'] = $this->request->post['config_multiseller_ean'];
					} else {
						$data['config_multiseller_ean'] = $this->config->get('config_multiseller_ean');
					}
					if (isset($this->request->post['config_multiseller_jan'])) {
						$data['config_multiseller_jan'] = $this->request->post['config_multiseller_jan'];
					} else {
						$data['config_multiseller_jan'] = $this->config->get('config_multiseller_jan');
					}
					if (isset($this->request->post['config_multiseller_isbn'])) {
						$data['config_multiseller_isbn'] = $this->request->post['config_multiseller_isbn'];
					} else {
						$data['config_multiseller_isbn'] = $this->config->get('config_multiseller_isbn');
					}
					if (isset($this->request->post['config_multiseller_out_of_stock_status'])) {
						$data['config_multiseller_out_of_stock_status'] = $this->request->post['config_multiseller_out_of_stock_status'];
					} else {
						$data['config_multiseller_out_of_stock_status'] = $this->config->get('config_multiseller_out_of_stock_status');
					}
					if (isset($this->request->post['config_multiseller_location'])) {
						$data['config_multiseller_location'] = $this->request->post['config_multiseller_location'];
					} else {
						$data['config_multiseller_location'] = $this->config->get('config_multiseller_location');
					}
					if (isset($this->request->post['config_multiseller_price'])) {
						$data['config_multiseller_price'] = $this->request->post['config_multiseller_price'];
					} else {
						$data['config_multiseller_price'] = $this->config->get('config_multiseller_price');
					}
					if (isset($this->request->post['config_multiseller_tax_class'])) {
						$data['config_multiseller_tax_class'] = $this->request->post['config_multiseller_tax_class'];
					} else {
						$data['config_multiseller_tax_class'] = $this->config->get('config_multiseller_tax_class');
					}
					if (isset($this->request->post['config_multiseller_quantity'])) {
						$data['config_multiseller_quantity'] = $this->request->post['config_multiseller_quantity'];
					} else {
						$data['config_multiseller_quantity'] = $this->config->get('config_multiseller_quantity');
					}
					if (isset($this->request->post['config_multiseller_minimum_quantity'])) {
						$data['config_multiseller_minimum_quantity'] = $this->request->post['config_multiseller_minimum_quantity'];
					} else {
						$data['config_multiseller_minimum_quantity'] = $this->config->get('config_multiseller_minimum_quantity');
					}
					if (isset($this->request->post['config_multiseller_mpn'])) {
						$data['config_multiseller_mpn'] = $this->request->post['config_multiseller_mpn'];
					} else {
						$data['config_multiseller_mpn'] = $this->config->get('config_multiseller_mpn');
					}

					if (isset($this->request->post['config_multiseller_tax_class'])) {
						$data['config_multiseller_tax_class'] = $this->request->post['config_multiseller_tax_class'];
					} else {
						$data['config_multiseller_tax_class'] = $this->config->get('config_multiseller_tax_class');
					}
					if (isset($this->request->post['config_multiseller_requires_shipping'])) {
						$data['config_multiseller_requires_shipping'] = $this->request->post['config_multiseller_requires_shipping'];
					} else {
						$data['config_multiseller_requires_shipping'] = $this->config->get('config_multiseller_requires_shipping');
					}
if (isset($this->request->post['config_multiseller_image'])) {
						$data['config_multiseller_image'] = $this->request->post['config_multiseller_image'];
					} else {
						$data['config_multiseller_image'] = $this->config->get('config_multiseller_image');
					}
		if (isset($this->request->post['config_multiseller_model'])) {
						$data['config_multiseller_model'] = $this->request->post['config_multiseller_model'];
					} else {
						$data['config_multiseller_model'] = $this->config->get('config_multiseller_model');
					}
if (isset($this->request->post['config_multiseller_related_products'])) {
						$data['config_multiseller_related_products'] = $this->request->post['config_multiseller_related_products'];
					} else {
						$data['config_multiseller_related_products'] = $this->config->get('config_multiseller_related_products');
					}
					if (isset($this->request->post['config_multiseller_downloads'])) {
						$data['config_multiseller_downloads'] = $this->request->post['config_multiseller_downloads'];
					} else {
						$data['config_multiseller_downloads'] = $this->config->get('config_multiseller_downloads');
					}
					if (isset($this->request->post['config_multiseller_stors'])) {
						$data['config_multiseller_stors'] = $this->request->post['config_multiseller_stors'];
					} else {
						$data['config_multiseller_stors'] = $this->config->get('config_multiseller_stors');
					}
					if (isset($this->request->post['config_multiseller_filters'])) {
						$data['config_multiseller_filters'] = $this->request->post['config_multiseller_filters'];
					} else {
						$data['config_multiseller_filters'] = $this->config->get('config_multiseller_filters');
					}
					if (isset($this->request->post['config_multiseller_categories'])) {
						$data['config_multiseller_categories'] = $this->request->post['config_multiseller_categories'];
					} else {
						$data['config_multiseller_categories'] = $this->config->get('config_multiseller_categories');
					}
					if (isset($this->request->post['config_multiseller_manufacturer'])) {
						$data['config_multiseller_manufacturer'] = $this->request->post['config_multiseller_manufacturer'];
					} else {
						$data['config_multiseller_manufacturer'] = $this->config->get('config_multiseller_manufacturer');
					}
								if (isset($this->request->post['config_multiseller_tab_data'])) {
						$data['config_multiseller_tab_data'] = $this->request->post['config_multiseller_tab_data'];
					} else {
						$data['config_multiseller_tab_data'] = $this->config->get('config_multiseller_tab_data');
					}
					if (isset($this->request->post['config_multiseller_tab_links'])) {
						$data['config_multiseller_tab_links'] = $this->request->post['config_multiseller_tab_links'];
					} else {
						$data['config_multiseller_tab_links'] = $this->config->get('config_multiseller_tab_links');
					}
					if (isset($this->request->post['config_multiseller_tab_attribute'])) {
						$data['config_multiseller_tab_attribute'] = $this->request->post['config_multiseller_tab_attribute'];
					} else {
						$data['config_multiseller_tab_attribute'] = $this->config->get('config_multiseller_tab_attribute');
					}
					if (isset($this->request->post['config_multiseller_tab_options'])) {
						$data['config_multiseller_tab_options'] = $this->request->post['config_multiseller_tab_options'];
					} else {
						$data['config_multiseller_tab_options'] = $this->config->get('config_multiseller_tab_options');
					}
					if (isset($this->request->post['config_multiseller_tab_recurring'])) {
						$data['config_multiseller_tab_recurring'] = $this->request->post['config_multiseller_tab_recurring'];
					} else {
						$data['config_multiseller_tab_recurring'] = $this->config->get('config_multiseller_tab_recurring');
					}
					if (isset($this->request->post['config_multiseller_tab_discount'])) {
						$data['config_multiseller_tab_discount'] = $this->request->post['config_multiseller_tab_discount'];
					} else {
						$data['config_multiseller_tab_discount'] = $this->config->get('config_multiseller_tab_discount');
					}
					if (isset($this->request->post['config_multiseller_tab_special'])) {
						$data['config_multiseller_tab_special'] = $this->request->post['config_multiseller_tab_special'];
					} else {
						$data['config_multiseller_tab_special'] = $this->config->get('config_multiseller_tab_special');
					}
					if (isset($this->request->post['config_multiseller_tab_image'])) {
						$data['config_multiseller_tab_image'] = $this->request->post['config_multiseller_tab_image'];
					} else {
						$data['config_multiseller_tab_image'] = $this->config->get('config_multiseller_tab_image');
					}
					if (isset($this->request->post['config_multiseller_tab_reward_points'])) {
						$data['config_multiseller_tab_reward_points'] = $this->request->post['config_multiseller_tab_reward_points'];
					} else {
						$data['config_multiseller_tab_reward_points'] = $this->config->get('config_multiseller_tab_reward_points');
					}
					if (isset($this->request->post['config_multiseller_tab_design'])) {
						$data['config_multiseller_tab_design'] = $this->request->post['config_multiseller_tab_design'];
					} else {
						$data['config_multiseller_tab_design'] = $this->config->get('config_multiseller_tab_design');
					}
					
					if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
      

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('seller/setting', 'token=' . $this->session->data['token'], true)
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['action'] = $this->url->link('seller/setting', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('seller/setting', 'token=' . $this->session->data['token'], true);

		$data['token'] = $this->session->data['token'];

		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('seller/setting', $data));
	}

	protected function validate() {
		
		if (!$this->user->hasPermission('modify', 'seller/setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		
		return !$this->error;
	}
		
}
