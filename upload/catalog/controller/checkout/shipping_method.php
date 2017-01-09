<?php

class ControllerCheckoutShippingMethod extends Controller
{
    public function index()
    {
        $this->load->language('checkout/checkout');

        $this->load->model('sellerproduct/product');
        $this->load->model('seller/seller');

        $sellerresults = $this->model_seller_seller->getSellersOnCart();


        foreach ($sellerresults as $sellerresult) {
            if (isset($this->session->data['shipping_address'])) {
                // Shipping Methods
              $method_data = array();

              $seller_product = array();

                $this->load->model('sellershipping/shipping');

                $results = $this->model_sellershipping_shipping->getShippings($sellerresult['seller_id']);

                foreach ($results as $result) {
                    if ($this->config->get($sellerresult['seller_id'].':'.$result['code'].'_status')) {
                        $this->load->model('sellershipping/shipping');

                        $quote = $this->model_sellershipping_shipping->getQuote($this->session->data['shipping_address'], $result['code'], $sellerresult['seller_id'], '');

                        if ($quote) {
                            $method_data[$result['code']] = array(
                              'title' => $quote['title'],
                              'quote' => $quote['quote'],
                              'sort_order' => $quote['sort_order'],
                              'error' => $quote['error'],
                          );
                        }
                    }
                }

                $sort_order = array();

                foreach ($method_data as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                }

                array_multisort($sort_order, SORT_ASC, $method_data);

                $products = $this->model_sellerproduct_product->getProductsOnCartBySellerId($sellerresult['seller_id']);

                foreach ($products as $product) {


                    $seller_product[] = array(
                      'product_id' => $product['product_id'],
                      'name' => $product['name'],
                      'quantity' => $product['quantity'],
                      'price' => $product['price'],
                      'total' => $product['total'],
                      'shipping_methods' => $method_data,
                      'href' => $this->url->link('product/product', 'product_id='.$product['product_id']),
                    );

                      $this->session->data['seller_shipping_methods_'.$product['product_id']] = $method_data;

                }



                $data['sellers'][] = array(
                  'seller_id' => $sellerresult['seller_id'],
                  'seller_name' => $sellerresult['name'],
                  'shipping_methods' => $method_data,
                  'product_data' => $seller_product,
                  'href' => $this->url->link('seller/seller/info', 'seller_id='.$sellerresult['seller_id']),
                );




            }
          }

            if (isset($this->session->data['shipping_address'])) {
                // Shipping Methods

                $method_data = array();

                $seller_product = array();

                $this->load->model('extension/extension');

                $results = $this->model_extension_extension->getExtensions('extension/shipping');

                foreach ($results as $result) {
                    if ($this->config->get($result['code'].'_status')) {
                        $this->load->model('extension/shipping/'.$result['code']);

                        $quote = $this->{'model_extension_shipping_'.$result['code']}->getQuote($this->session->data['shipping_address']);

                        if ($quote) {
                            $method_data[$result['code']] = array(
                    'title' => $quote['title'],
                    'quote' => $quote['quote'],
                    'sort_order' => $quote['sort_order'],
                    'error' => $quote['error'],
                );
                        }
                    }
                }

                $sort_order = array();

                foreach ($method_data as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                }

                array_multisort($sort_order, SORT_ASC, $method_data);


                $this->session->data['shipping_methods'] = array();


            $products = $this->model_sellerproduct_product->getProductsByNonSeller();

            foreach ($products as $product) {


                $seller_product[] = array(
                  'product_id' => $product['product_id'],
                  'name' => $product['name'],
                  'quantity' => $product['quantity'],
                  'price' => $product['price'],
                  'total' => $product['total'],
                  'href' => $this->url->link('product/product', 'product_id='.$product['product_id']),
                );

                $this->session->data['shipping_methods'] = $method_data;

            }

            $data['store'][] = array(
              'seller_id' => '0',
              'seller_name' => $this->config->get('config_name'),
              'shipping_methods' => $method_data,
              'product_data' => $seller_product,
              'href' => $this->url->link('common/home',''),
            );
          }







        $data['column_name'] = $this->language->get('column_name');
        $data['column_model'] = $this->language->get('column_model');
        $data['column_quantity'] = $this->language->get('column_quantity');
        $data['column_price'] = $this->language->get('column_price');
        $data['column_total'] = $this->language->get('column_total');
        $data['column_seller_shipping'] = $this->language->get('column_seller_shipping');

        $data['text_shipping_method'] = $this->language->get('text_shipping_method');
        $data['text_comments'] = $this->language->get('text_comments');
        $data['text_loading'] = $this->language->get('text_loading');

        $data['button_continue'] = $this->language->get('button_continue');

        if (empty($this->session->data['shipping_methods'])) {
            $data['error_warning'] = '';
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['shipping_methods'])) {
            $data['shipping_methods'] = $this->session->data['shipping_methods'];
        } else {
            $data['shipping_methods'] = array();
        }

        if (isset($this->session->data['shipping_method']['code'])) {
            $data['code'] = $this->session->data['shipping_method']['code'];
        } else {
            $data['code'] = '';
        }

        if (isset($this->session->data['comment'])) {
            $data['comment'] = $this->session->data['comment'];
        } else {
            $data['comment'] = '';
        }

        $this->response->setOutput($this->load->view('checkout/shipping_method', $data));
    }

    public function save()
    {
        $this->load->language('checkout/checkout');

        $json = array();

        // Validate if shipping is required. If not the customer should not have reached this page.
        if (!$this->cart->hasShipping()) {
            $json['redirect'] = $this->url->link('checkout/checkout', '', true);
        }

        // Validate if shipping address has been set.
        if (!isset($this->session->data['shipping_address'])) {
            $json['redirect'] = $this->url->link('checkout/checkout', '', true);
        }

        // Validate cart has products and has stock.
        if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
            $json['redirect'] = $this->url->link('checkout/cart');
        }

        // Validate minimum quantity requirements.
        $products = $this->cart->getProducts();

        foreach ($products as $product) {
            $product_total = 0;

            foreach ($products as $product_2) {
                if ($product_2['product_id'] == $product['product_id']) {
                    $product_total += $product_2['quantity'];
                }
            }

            if ($product['minimum'] > $product_total) {
                $json['redirect'] = $this->url->link('checkout/cart');

                break;
            }
            if (!isset($this->request->post['shipping_method_'.$product['product_id']])) {
                //	$json['error']['warning'] = $this->language->get('error_shipping');
            } else {

                if (($pos = strpos($this->request->post['shipping_method_'.$product['product_id']], ':') !== false)) {
                    $domain = substr($this->request->post['shipping_method_'.$product['product_id']], $pos + 1);

                    $shipping = explode('.', $domain);

                    $this->session->data['shipping_method_'.$product['product_id']] = $this->session->data['seller_shipping_methods_'.$product['product_id']][$shipping[0]]['quote'][$shipping[1]];
                }
            }
        }

        if (!isset($this->request->post['shipping_method'])) {
            //  $json['error']['warning'] = $this->language->get('error_shipping');
        } else {
            $shipping = explode('.', $this->request->post['shipping_method']);

            if (!isset($shipping[0]) || !isset($shipping[1]) || !isset($this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]])) {
                $json['error']['warning'] = $this->language->get('error_shipping');
            }
        }

        if (!$json) {
            if (empty($this->session->data['shipping_methods'])) {
                $this->session->data['shipping_method'] = '';
            } else {
                $this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
            }

            $this->session->data['comment'] = strip_tags($this->request->post['comment']);
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
