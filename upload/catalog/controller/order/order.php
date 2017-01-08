<?php

class ControllerorderOrder extends Controller
{
    private $error = array();

    public function index()
    {


      if (!$this->customer->isLogged()) {
          $this->session->data['redirect'] = $this->url->link('order/order', '', 'SSL');

          $this->response->redirect($this->url->link('account/login', '', 'SSL'));
      }

        if ($this->customer->isSeller()) {
        $this->load->language('order/order');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('order/order');

        $this->getList();
      } else {
          $this->response->redirect($this->url->link('sellerprofile/sellerprofile', '', 'SSL'));
      }
    }

    public function add()
    {
        $this->load->language('order/order');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('order/order');

        unset($this->session->data['cookie']);

        if ($this->validate()) {
            // API
            $this->load->model('user/api');

            $api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

            if ($api_info) {
                $curl = curl_init();

                // Set SSL if required
                if (substr(HTTPS_CATALOG, 0, 5) == 'https') {
                    curl_setopt($curl, CURLOPT_PORT, 443);
                }

                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLINFO_HEADER_OUT, true);
                curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG.'index.php?route=api/login');
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($api_info));

                $json = curl_exec($curl);

                if (!$json) {
                    $this->error['warning'] = sprintf($this->language->get('error_curl'), curl_error($curl), curl_errno($curl));
                } else {
                    $response = json_decode($json, true);

                    if (isset($response['cookie'])) {
                        $this->session->data['cookie'] = $response['cookie'];
                    }

                    curl_close($curl);
                }
            }
        }

        $this->getForm();
    }

    public function edit()
    {
        $this->load->language('order/order');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('order/order');

        unset($this->session->data['cookie']);

        if ($this->validate()) {
            // API
            $this->load->model('user/api');

            $api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

            if ($api_info) {
                $curl = curl_init();

                // Set SSL if required
                if (substr(HTTPS_CATALOG, 0, 5) == 'https') {
                    curl_setopt($curl, CURLOPT_PORT, 443);
                }

                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLINFO_HEADER_OUT, true);
                curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG.'index.php?route=api/login');
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($api_info));

                $json = curl_exec($curl);

                if (!$json) {
                    $this->error['warning'] = sprintf($this->language->get('error_curl'), curl_error($curl), curl_errno($curl));
                } else {
                    $response = json_decode($json, true);

                    if (isset($response['cookie'])) {
                        $this->session->data['cookie'] = $response['cookie'];
                    }

                    curl_close($curl);
                }
            }
        }

        $this->getForm();
    }

    public function delete()
    {
        $this->load->language('order/order');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('order/order');

        unset($this->session->data['cookie']);

        if (isset($this->request->get['order_id']) && $this->validate()) {
            // API
            $this->load->model('user/api');

            $api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

            if ($api_info) {
                $curl = curl_init();

                // Set SSL if required
                if (substr(HTTPS_CATALOG, 0, 5) == 'https') {
                    curl_setopt($curl, CURLOPT_PORT, 443);
                }

                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLINFO_HEADER_OUT, true);
                curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG.'index.php?route=api/login');
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($api_info));

                $json = curl_exec($curl);

                if (!$json) {
                    $this->error['warning'] = sprintf($this->language->get('error_curl'), curl_error($curl), curl_errno($curl));
                } else {
                    $response = json_decode($json, true);

                    if (isset($response['cookie'])) {
                        $this->session->data['cookie'] = $response['cookie'];
                    }

                    curl_close($curl);
                }
            }
        }

        if (isset($this->session->data['cookie'])) {
            $curl = curl_init();

            // Set SSL if required
            if (substr(HTTPS_CATALOG, 0, 5) == 'https') {
                curl_setopt($curl, CURLOPT_PORT, 443);
            }

            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLINFO_HEADER_OUT, true);
            curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG.'index.php?route=api/order/delete&order_id='.$this->request->get['order_id']);
            curl_setopt($curl, CURLOPT_COOKIE, session_name().'='.$this->session->data['cookie'].';');

            $json = curl_exec($curl);

            if (!$json) {
                $this->error['warning'] = sprintf($this->language->get('error_curl'), curl_error($curl), curl_errno($curl));
            } else {
                $response = json_decode($json, true);

                curl_close($curl);

                if (isset($response['error'])) {
                    $this->error['warning'] = $response['error'];
                }
            }
        }

        if (isset($response['error'])) {
            $this->error['warning'] = $response['error'];
        }

        if (isset($response['success'])) {
            $this->session->data['success'] = $response['success'];

            $url = '';

            if (isset($this->request->get['filter_order_id'])) {
                $url .= '&filter_order_id='.$this->request->get['filter_order_id'];
            }

            if (isset($this->request->get['filter_seller'])) {
                $url .= '&filter_seller='.urlencode(html_entity_decode($this->request->get['filter_seller'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_order_status'])) {
                $url .= '&filter_order_status='.$this->request->get['filter_order_status'];
            }

            if (isset($this->request->get['filter_total'])) {
                $url .= '&filter_total='.$this->request->get['filter_total'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added='.$this->request->get['filter_date_added'];
            }

            if (isset($this->request->get['filter_date_modified'])) {
                $url .= '&filter_date_modified='.$this->request->get['filter_date_modified'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort='.$this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order='.$this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page='.$this->request->get['page'];
            }

            $this->response->redirect($this->url->link('order/order', $url, 'SSL'));
        }

        $this->getList();
    }

    protected function getList()
    {
        if (isset($this->request->get['filter_order_id'])) {
            $filter_order_id = $this->request->get['filter_order_id'];
        } else {
            $filter_order_id = null;
        }

        if (isset($this->request->get['filter_seller'])) {
            $filter_seller = $this->request->get['filter_seller'];
        } else {
            $filter_seller = null;
        }

        if (isset($this->request->get['filter_order_status'])) {
            $filter_order_status = $this->request->get['filter_order_status'];
        } else {
            $filter_order_status = null;
        }

        if (isset($this->request->get['filter_total'])) {
            $filter_total = $this->request->get['filter_total'];
        } else {
            $filter_total = null;
        }

        if (isset($this->request->get['filter_date_added'])) {
            $filter_date_added = $this->request->get['filter_date_added'];
        } else {
            $filter_date_added = null;
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $filter_date_modified = $this->request->get['filter_date_modified'];
        } else {
            $filter_date_modified = null;
        }
        if (isset($this->request->get['filter_order_settlement'])) {
            $filter_order_settlement = $this->request->get['filter_order_settlement'];
        } else {
            $filter_order_settlement = null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'o.order_id';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id='.$this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_seller'])) {
            $url .= '&filter_seller='.urlencode(html_entity_decode($this->request->get['filter_seller'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_order_status'])) {
            $url .= '&filter_order_status='.$this->request->get['filter_order_status'];
        }

        if (isset($this->request->get['filter_total'])) {
            $url .= '&filter_total='.$this->request->get['filter_total'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added='.$this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $url .= '&filter_date_modified='.$this->request->get['filter_date_modified'];
        }
        if (isset($this->request->get['filter_order_settlement'])) {
            $url .= '&filter_order_settlement='.$this->request->get['filter_order_settlement'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort='.$this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order='.$this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page='.$this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', '', 'SSL'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('order/order', $url, 'SSL'),
        );

    	$data['invoice'] = $this->url->link('order/order/invoice', '', 'SSL');
        $data['shipping'] = $this->url->link('order/order/shipping', '', 'SSL');
        $data['insert'] = $this->url->link('sale/order/add', '', 'SSL');

        $data['orders'] = array();

        $filter_data = array(
            'filter_order_id' => $filter_order_id,
            'filter_seller' => $filter_seller,
            'filter_order_status' => $filter_order_status,
            'filter_total' => $filter_total,
            'filter_date_added' => $filter_date_added,
            'filter_date_modified' => $filter_date_modified,
            'filter_order_settlement' => $filter_order_settlement,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin'),
        );

        $order_total = $this->model_order_order->getTotalOrders($filter_data);

        $results = $this->model_order_order->getOrders($filter_data);

        foreach ($results as $result) {
            $data['orders'][] = array(
                'order_id' => $result['order_id'],
                'seller' => $result['seller'],
                'status' => $result['status'],

                'order_settlement' => $this->model_order_order->getSellrOrdersettlement($result['order_id'], $result['customer_id']),
                'invoice' => $this->url->link('order/order/invoice', 'order_id='.$result['order_id'].$url, 'SSL'),
                'total' => $this->currency->format($result['totals'] + $total = $this->model_order_order->getOrderTotalsTotal($result['order_id'], $this->customer->getId()), $result['currency_code'], $result['currency_value']),
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
                'shipping_code' => $result['shipping_code'],
                'view' => $this->url->link('order/order/info', 'order_id='.$result['order_id'].$url, 'SSL'),
                'add_to_transaction' => $this->url->link('order/order/add_to_transaction', 'seller_id='.$result['customer_id'].$url, 'SSL'),
                'edit' => $this->url->link('sale/order/edit', 'order_id='.$result['order_id'].$url, 'SSL'),
                'delete' => $this->url->link('order/order/delete', 'order_id='.$result['order_id'].$url, 'SSL'),
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');
        $data['text_missing'] = $this->language->get('text_missing');

        $data['column_order_id'] = $this->language->get('column_order_id');
        $data['column_seller'] = $this->language->get('column_seller');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_total'] = $this->language->get('column_total');
        $data['column_date_added'] = $this->language->get('column_date_added');
        $data['column_date_modified'] = $this->language->get('column_date_modified');
        $data['column_action'] = $this->language->get('column_action');
        $data['column_order_settlement'] = $this->language->get('column_order_settlement');

        $data['entry_return_id'] = $this->language->get('entry_return_id');
        $data['entry_order_id'] = $this->language->get('entry_order_id');
        $data['entry_seller'] = $this->language->get('entry_seller');
        $data['entry_order_status'] = $this->language->get('entry_order_status');
        $data['entry_total'] = $this->language->get('entry_total');
        $data['entry_date_added'] = $this->language->get('entry_date_added');
        $data['entry_date_modified'] = $this->language->get('entry_date_modified');

        $data['button_invoice_print'] = $this->language->get('button_invoice_print');
        $data['button_shipping_print'] = $this->language->get('button_shipping_print');
        $data['button_add'] = $this->language->get('button_add');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_filter'] = $this->language->get('button_filter');
        $data['button_view'] = $this->language->get('button_view');
        $data['button_add_to_transaction'] = $this->language->get('button_add_to_transaction');



        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array) $this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $url = '';

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id='.$this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_seller'])) {
            $url .= '&filter_seller='.urlencode(html_entity_decode($this->request->get['filter_seller'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_order_status'])) {
            $url .= '&filter_order_status='.$this->request->get['filter_order_status'];
        }

        if (isset($this->request->get['filter_total'])) {
            $url .= '&filter_total='.$this->request->get['filter_total'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added='.$this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $url .= '&filter_date_modified='.$this->request->get['filter_date_modified'];
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page='.$this->request->get['page'];
        }

        $data['sort_order'] = $this->url->link('order/order', 'sort=o.order_id'.$url, 'SSL');
        $data['sort_seller'] = $this->url->link('order/order', 'sort=seller'.$url, 'SSL');
        $data['sort_status'] = $this->url->link('order/order', 'sort=status'.$url, 'SSL');
        $data['sort_total'] = $this->url->link('order/order', 'sort=o.total'.$url, 'SSL');
        $data['sort_date_added'] = $this->url->link('order/order', 'sort=o.date_added'.$url, 'SSL');
        $data['sort_date_modified'] = $this->url->link('order/order', 'sort=o.date_modified'.$url, 'SSL');
        $data['sort_order_settlement'] = $this->url->link('order/order', 'sort=o.order_settlement'.$url, 'SSL');

        $url = '';

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id='.$this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_seller'])) {
            $url .= '&filter_seller='.urlencode(html_entity_decode($this->request->get['filter_seller'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_order_status'])) {
            $url .= '&filter_order_status='.$this->request->get['filter_order_status'];
        }

        if (isset($this->request->get['filter_total'])) {
            $url .= '&filter_total='.$this->request->get['filter_total'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added='.$this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $url .= '&filter_date_modified='.$this->request->get['filter_date_modified'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort='.$this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order='.$this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $order_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('order/order', $url.'&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

        $data['filter_order_id'] = $filter_order_id;
        $data['filter_seller'] = $filter_seller;
        $data['filter_order_status'] = $filter_order_status;
        $data['filter_total'] = $filter_total;
        $data['filter_date_added'] = $filter_date_added;
        $data['filter_date_modified'] = $filter_date_modified;

        $this->load->model('order/order_status');

        $data['order_statuses'] = $this->model_order_order_status->getOrderStatuses();

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['column_left'] = $this->load->controller('common/column_left');
    		$data['column_right'] = $this->load->controller('common/column_right');
    		$data['content_top'] = $this->load->controller('common/content_top');
    		$data['content_bottom'] = $this->load->controller('common/content_bottom');
    		$data['footer'] = $this->load->controller('common/footer');
    		$data['header'] = $this->load->controller('common/header');



                $this->response->setOutput($this->load->view('order/order_list', $data));

    }

    public function getForm()
    {
        $this->load->model('seller/seller');

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = !isset($this->request->get['order_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_default'] = $this->language->get('text_default');
        $data['text_select'] = $this->language->get('text_select');
        $data['text_none'] = $this->language->get('text_none');
        $data['text_loading'] = $this->language->get('text_loading');
        $data['text_product'] = $this->language->get('text_product');
        $data['text_voucher'] = $this->language->get('text_voucher');
        $data['text_order'] = $this->language->get('text_order');

        $data['entry_store'] = $this->language->get('entry_store');
        $data['entry_seller'] = $this->language->get('entry_seller');
        $data['entry_seller_group'] = $this->language->get('entry_seller_group');
        $data['entry_firstname'] = $this->language->get('entry_firstname');
        $data['entry_lastname'] = $this->language->get('entry_lastname');
        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_telephone'] = $this->language->get('entry_telephone');
        $data['entry_fax'] = $this->language->get('entry_fax');
        $data['entry_comment'] = $this->language->get('entry_comment');
        $data['entry_affiliate'] = $this->language->get('entry_affiliate');
        $data['entry_address'] = $this->language->get('entry_address');
        $data['entry_company'] = $this->language->get('entry_company');
        $data['entry_address_1'] = $this->language->get('entry_address_1');
        $data['entry_address_2'] = $this->language->get('entry_address_2');
        $data['entry_city'] = $this->language->get('entry_city');
        $data['entry_postcode'] = $this->language->get('entry_postcode');
        $data['entry_zone'] = $this->language->get('entry_zone');
        $data['entry_zone_code'] = $this->language->get('entry_zone_code');
        $data['entry_country'] = $this->language->get('entry_country');
        $data['entry_product'] = $this->language->get('entry_product');
        $data['entry_option'] = $this->language->get('entry_option');
        $data['entry_quantity'] = $this->language->get('entry_quantity');
        $data['entry_to_name'] = $this->language->get('entry_to_name');
        $data['entry_to_email'] = $this->language->get('entry_to_email');
        $data['entry_from_name'] = $this->language->get('entry_from_name');
        $data['entry_from_email'] = $this->language->get('entry_from_email');
        $data['entry_theme'] = $this->language->get('entry_theme');
        $data['entry_message'] = $this->language->get('entry_message');
        $data['entry_amount'] = $this->language->get('entry_amount');
        $data['entry_shipping_method'] = $this->language->get('entry_shipping_method');
        $data['entry_payment_method'] = $this->language->get('entry_payment_method');
        $data['entry_coupon'] = $this->language->get('entry_coupon');
        $data['entry_voucher'] = $this->language->get('entry_voucher');
        $data['entry_reward'] = $this->language->get('entry_reward');
        $data['entry_order_status'] = $this->language->get('entry_order_status');

        $data['column_product'] = $this->language->get('column_product');
        $data['column_model'] = $this->language->get('column_model');
        $data['column_quantity'] = $this->language->get('column_quantity');
        $data['column_price'] = $this->language->get('column_price');
        $data['column_total'] = $this->language->get('column_total');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_continue'] = $this->language->get('button_continue');
        $data['button_back'] = $this->language->get('button_back');
        $data['button_product_add'] = $this->language->get('button_product_add');
        $data['button_voucher_add'] = $this->language->get('button_voucher_add');

        $data['button_payment'] = $this->language->get('button_payment');
        $data['button_shipping'] = $this->language->get('button_shipping');
        $data['button_coupon'] = $this->language->get('button_coupon');
        $data['button_voucher'] = $this->language->get('button_voucher');
        $data['button_reward'] = $this->language->get('button_reward');
        $data['button_upload'] = $this->language->get('button_upload');
        $data['button_remove'] = $this->language->get('button_remove');

        $data['tab_order'] = $this->language->get('tab_order');
        $data['tab_seller'] = $this->language->get('tab_seller');
        $data['tab_payment'] = $this->language->get('tab_payment');
        $data['tab_shipping'] = $this->language->get('tab_shipping');
        $data['tab_product'] = $this->language->get('tab_product');
        $data['tab_voucher'] = $this->language->get('tab_voucher');
        $data['tab_total'] = $this->language->get('tab_total');



        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $url = '';

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id='.$this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_seller'])) {
            $url .= '&filter_seller='.urlencode(html_entity_decode($this->request->get['filter_seller'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_order_status'])) {
            $url .= '&filter_order_status='.$this->request->get['filter_order_status'];
        }

        if (isset($this->request->get['filter_total'])) {
            $url .= '&filter_total='.$this->request->get['filter_total'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added='.$this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $url .= '&filter_date_modified='.$this->request->get['filter_date_modified'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort='.$this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order='.$this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page='.$this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', '', 'SSL'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('order/order',$url, 'SSL'),
        );

        $data['cancel'] = $this->url->link('order/order', $url, 'SSL');

        if (isset($this->request->get['order_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $order_info = $this->model_order_order->getOrder($this->request->get['order_id'], $this->customer->getId());
        }

        if (!empty($order_info)) {
            $data['order_id'] = $this->request->get['order_id'];
            $data['store_id'] = $order_info['store_id'];

            $data['seller'] = $order_info['seller'];
            $data['customer_id'] = $order_info['customer_id'];
            $data['customer_group_id'] = $order_info['customer_group_id'];
            $data['firstname'] = $order_info['firstname'];
            $data['lastname'] = $order_info['lastname'];
            $data['email'] = $order_info['email'];
            $data['telephone'] = $order_info['telephone'];
            $data['fax'] = $order_info['fax'];
            $data['account_custom_field'] = $order_info['custom_field'];

            $this->load->model('customer/customer');

            $data['addresses'] = $this->model_sale_customer->getAddresses($order_info['customer_id']);

            $data['payment_firstname'] = $order_info['payment_firstname'];
            $data['payment_lastname'] = $order_info['payment_lastname'];
            $data['payment_company'] = $order_info['payment_company'];
            $data['payment_address_1'] = $order_info['payment_address_1'];
            $data['payment_address_2'] = $order_info['payment_address_2'];
            $data['payment_city'] = $order_info['payment_city'];
            $data['payment_postcode'] = $order_info['payment_postcode'];
            $data['payment_country_id'] = $order_info['payment_country_id'];
            $data['payment_zone_id'] = $order_info['payment_zone_id'];
            $data['payment_custom_field'] = $order_info['payment_custom_field'];
            $data['payment_method'] = $order_info['payment_method'];
            $data['payment_code'] = $order_info['payment_code'];

            $data['shipping_firstname'] = $order_info['shipping_firstname'];
            $data['shipping_lastname'] = $order_info['shipping_lastname'];
            $data['shipping_company'] = $order_info['shipping_company'];
            $data['shipping_address_1'] = $order_info['shipping_address_1'];
            $data['shipping_address_2'] = $order_info['shipping_address_2'];
            $data['shipping_city'] = $order_info['shipping_city'];
            $data['shipping_postcode'] = $order_info['shipping_postcode'];
            $data['shipping_country_id'] = $order_info['shipping_country_id'];
            $data['shipping_zone_id'] = $order_info['shipping_zone_id'];
            $data['shipping_custom_field'] = $order_info['shipping_custom_field'];
            $data['shipping_method'] = $order_info['shipping_method'];
            $data['shipping_code'] = $order_info['shipping_code'];

            // Add products to the API
            if (isset($this->session->data['cookie'])) {
                $products = $this->model_order_order->getOrderProducts($this->request->get['order_id'], $this->customer->getId());

                foreach ($products as $product) {
                    $option_data = array();

                    $options = $this->model_order_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

                    foreach ($options as $option) {
                        if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'image') {
                            $option_data[$option['product_option_id']] = $option['product_option_value_id'];
                        }

                        if ($option['type'] == 'checkbox') {
                            $option_data[$option['product_option_id']][] = $option['product_option_value_id'];
                        }

                        if ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
                            $option_data[$option['product_option_id']] = $option['value'];
                        }
                    }

                    $product_data = array(
                        'product_id' => $product['product_id'],
                        'option' => $option_data,
                        'quantity' => $product['quantity'],
                        'override' => true,
                    );

                    $curl = curl_init();

                    // Set SSL if required
                    if (substr(HTTPS_CATALOG, 0, 5) == 'https') {
                        curl_setopt($curl, CURLOPT_PORT, 443);
                    }

                    curl_setopt($curl, CURLOPT_HEADER, false);
                    curl_setopt($curl, CURLINFO_HEADER_OUT, true);
                    curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG.'index.php?route=api/cart/add');
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($product_data));
                    curl_setopt($curl, CURLOPT_COOKIE, session_name().'='.$this->session->data['cookie'].';');

                    $response = curl_exec($curl);

                    if (!$response) {
                        $data['error_warning'] = sprintf($this->language->get('error_curl'), curl_error($curl), curl_errno($curl));
                    }
                }
            }

            // Add vouchers to the API
            if (isset($this->session->data['cookie'])) {
                $vouchers = $this->model_order_order->getOrderVouchers($this->request->get['order_id']);

                foreach ($vouchers as $voucher) {
                    $curl = curl_init();

                    // Set SSL if required
                    if (substr(HTTPS_CATALOG, 0, 5) == 'https') {
                        curl_setopt($curl, CURLOPT_PORT, 443);
                    }

                    curl_setopt($curl, CURLOPT_HEADER, false);
                    curl_setopt($curl, CURLINFO_HEADER_OUT, true);
                    curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG.'index.php?route=api/voucher/add');
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($voucher));
                    curl_setopt($curl, CURLOPT_COOKIE, session_name().'='.$this->session->data['cookie'].';');

                    $response = curl_exec($curl);

                    if (!$response) {
                        $data['error_warning'] = sprintf($this->language->get('error_curl'), curl_error($curl), curl_errno($curl));
                    }
                }
            }

            $data['coupon'] = '';
            $data['voucher'] = '';
            $data['reward'] = '';

            $data['order_totals'] = array();

            $order_totals = $this->model_order_order->getOrderTotals($this->request->get['order_id']);

            foreach ($order_totals as $order_total) {
                // If coupon, voucher or reward points
                $start = strpos($order_total['title'], '(') + 1;
                $end = strrpos($order_total['title'], ')');

                if ($start && $end) {
                    if ($order_total['code'] == 'coupon') {
                        $data['coupon'] = substr($order_total['title'], $start, $end - $start);
                    }

                    if ($order_total['code'] == 'voucher') {
                        $data['voucher'] = substr($order_total['title'], $start, $end - $start);
                    }

                    if ($order_total['code'] == 'reward') {
                        $data['reward'] = substr($order_total['title'], $start, $end - $start);
                    }
                }
            }

            $data['order_status_id'] = $order_info['order_status_id'];
            $data['comment'] = $order_info['comment'];
            $data['affiliate_id'] = $order_info['affiliate_id'];
            $data['affiliate'] = $order_info['affiliate_firstname'].' '.$order_info['affiliate_lastname'];
        } else {
            $data['order_id'] = 0;
            $data['store_id'] = '';
            $data['seller'] = '';
            $data['customer_id'] = '';
            $data['customer_group_id'] = $this->config->get('config_customer_group_id');
            $data['firstname'] = '';
            $data['lastname'] = '';
            $data['email'] = '';
            $data['telephone'] = '';
            $data['fax'] = '';
            $data['seller_custom_field'] = array();

            $data['addresss'] = array();

            $data['payment_firstname'] = '';
            $data['payment_lastname'] = '';
            $data['payment_company'] = '';
            $data['payment_address_1'] = '';
            $data['payment_address_2'] = '';
            $data['payment_city'] = '';
            $data['payment_postcode'] = '';
            $data['payment_country_id'] = '';
            $data['payment_zone_id'] = '';
            $data['payment_custom_field'] = array();
            $data['payment_method'] = '';
            $data['payment_code'] = '';

            $data['shipping_firstname'] = '';
            $data['shipping_lastname'] = '';
            $data['shipping_company'] = '';
            $data['shipping_address_1'] = '';
            $data['shipping_address_2'] = '';
            $data['shipping_city'] = '';
            $data['shipping_postcode'] = '';
            $data['shipping_country_id'] = '';
            $data['shipping_zone_id'] = '';
            $data['shipping_custom_field'] = array();
            $data['shipping_method'] = '';
            $data['shipping_code'] = '';

            $data['order_products'] = array();
            $data['order_vouchers'] = array();
            $data['order_totals'] = array();

            $data['order_status_id'] = $this->config->get('config_order_status_id');

            $data['comment'] = '';
            $data['affiliate_id'] = '';
            $data['affiliate'] = '';

            $data['coupon'] = '';
            $data['voucher'] = '';
            $data['reward'] = '';
        }

        // Stores
        $this->load->model('setting/store');

        $data['stores'] = $this->model_setting_store->getStores();

        // seller Groups


        $data['seller_groups'] = $this->model_order_order->getSellerGroups();

        // Custom Fields
        $this->load->model('sale/custom_field');

        $data['custom_fields'] = array();

        $custom_fields = $this->model_sale_custom_field->getCustomFields();

        foreach ($custom_fields as $custom_field) {
            $data['custom_fields'][] = array(
                'custom_field_id' => $custom_field['custom_field_id'],
                'custom_field_value' => $this->model_sale_custom_field->getCustomFieldValues($custom_field['custom_field_id']),
                'name' => $custom_field['name'],
                'value' => $custom_field['value'],
                'type' => $custom_field['type'],
                'location' => $custom_field['location'],
            );
        }

        $this->load->model('order/order_status');

        $data['order_statuses'] = $this->model_order_order_status->getOrderStatuses();

        $this->load->model('localisation/country');

        $data['countries'] = $this->model_localisation_country->getCountries();

        $data['voucher_min'] = $this->config->get('config_voucher_min');

        $this->load->model('sale/voucher_theme');

        $data['voucher_themes'] = $this->model_sale_voucher_theme->getVoucherThemes();

        $data['column_left'] = $this->load->controller('common/column_left');
    		$data['column_right'] = $this->load->controller('common/column_right');
    		$data['content_top'] = $this->load->controller('common/content_top');
    		$data['content_bottom'] = $this->load->controller('common/content_bottom');
    		$data['footer'] = $this->load->controller('common/footer');
    		$data['header'] = $this->load->controller('common/header');

        $this->response->setOutput($this->load->view('order/order_form', $data));
    }

    public function info()
    {
        $this->load->model('order/order');

        if (isset($this->request->get['order_id'])) {
            $order_id = $this->request->get['order_id'];
        } else {
            $order_id = 0;
        }

        if ($this->customer->getId()) {
            $seller_id = $this->customer->getId();
        } else {
            $seller_id = 0;
        }
        $order_info = $this->model_order_order->getOrder($order_id, $seller_id);
        $isorderseller = $this->model_order_order->isSellerOrder($order_id, $seller_id);


        if ($order_info && !empty($isorderseller)) {
            $this->load->language('order/order');

            $this->document->setTitle($this->language->get('heading_title'));

            $data['heading_title'] = $this->language->get('heading_title');
            $data['text_order_detail'] = $this->language->get('text_order_detail');
            $data['text_customer_detail'] = $this->language->get('text_customer_detail');
            $data['text_option'] = $this->language->get('text_option');
            $data['text_order'] = sprintf($this->language->get('text_order'), $this->request->get['order_id']);

            $data['text_payment_address'] = $this->language->get('text_payment_address');
            $data['text_shipping_address'] = $this->language->get('text_shipping_address');
            $data['text_sellerhistory_add'] = $this->language->get('text_sellerhistory_add');
            $data['tab_additional'] = $this->language->get('tab_additional');
            $data['entry_override'] = $this->language->get('entry_override');
            $data['button_ip_add'] = $this->language->get('button_ip_add');
            $data['text_browser'] = $this->language->get('text_browser');
            $data['text_store'] = $this->language->get('text_store');
            $data['text_customer'] = $this->language->get('text_customer');
            $data['help_override'] = $this->language->get('help_override');

            $data['text_invoice'] = $this->language->get('text_invoice');
            $data['column_status'] = $this->language->get('column_status');


            $data['text_order_id'] = $this->language->get('text_order_id');
            $data['text_invoice_no'] = $this->language->get('text_invoice_no');
            $data['text_invoice_date'] = $this->language->get('text_invoice_date');
            $data['text_store_name'] = $this->language->get('text_store_name');
            $data['text_store_url'] = $this->language->get('text_store_url');
            $data['text_seller'] = $this->language->get('text_seller');
            $data['text_seller_group'] = $this->language->get('text_seller_group');
            $data['text_email'] = $this->language->get('text_email');
            $data['text_telephone'] = $this->language->get('text_telephone');
            $data['text_fax'] = $this->language->get('text_fax');
            $data['text_total'] = $this->language->get('text_total');
            $data['text_reward'] = $this->language->get('text_reward');
            $data['text_order_status'] = $this->language->get('text_order_status');
            $data['text_comment'] = $this->language->get('text_comment');
            $data['text_affiliate'] = $this->language->get('text_affiliate');
            $data['text_commission'] = $this->language->get('text_commission');
            $data['text_ip'] = $this->language->get('text_ip');
            $data['text_forwarded_ip'] = $this->language->get('text_forwarded_ip');
            $data['text_user_agent'] = $this->language->get('text_user_agent');
            $data['text_accept_language'] = $this->language->get('text_accept_language');
            $data['text_date_added'] = $this->language->get('text_date_added');
            $data['text_date_modified'] = $this->language->get('text_date_modified');
            $data['text_firstname'] = $this->language->get('text_firstname');
            $data['text_lastname'] = $this->language->get('text_lastname');
            $data['text_company'] = $this->language->get('text_company');
            $data['text_address_1'] = $this->language->get('text_address_1');
            $data['text_address_2'] = $this->language->get('text_address_2');
            $data['text_city'] = $this->language->get('text_city');
            $data['text_postcode'] = $this->language->get('text_postcode');
            $data['text_zone'] = $this->language->get('text_zone');
            $data['text_zone_code'] = $this->language->get('text_zone_code');
            $data['text_country'] = $this->language->get('text_country');
            $data['text_shipping_method'] = $this->language->get('text_shipping_method');
            $data['text_payment_method'] = $this->language->get('text_payment_method');
            $data['text_sellerhistory'] = $this->language->get('text_sellerhistory');
            $data['text_country_match'] = $this->language->get('text_country_match');
            $data['text_country_code'] = $this->language->get('text_country_code');
            $data['text_high_risk_country'] = $this->language->get('text_high_risk_country');
            $data['text_distance'] = $this->language->get('text_distance');
            $data['text_ip_region'] = $this->language->get('text_ip_region');
            $data['text_ip_city'] = $this->language->get('text_ip_city');
            $data['text_ip_latitude'] = $this->language->get('text_ip_latitude');
            $data['text_ip_longitude'] = $this->language->get('text_ip_longitude');
            $data['text_ip_isp'] = $this->language->get('text_ip_isp');
            $data['text_ip_org'] = $this->language->get('text_ip_org');
            $data['text_ip_asnum'] = $this->language->get('text_ip_asnum');
            $data['text_ip_user_type'] = $this->language->get('text_ip_user_type');
            $data['text_ip_country_confidence'] = $this->language->get('text_ip_country_confidence');
            $data['text_ip_region_confidence'] = $this->language->get('text_ip_region_confidence');
            $data['text_ip_city_confidence'] = $this->language->get('text_ip_city_confidence');
            $data['text_ip_postal_confidence'] = $this->language->get('text_ip_postal_confidence');
            $data['text_ip_postal_code'] = $this->language->get('text_ip_postal_code');
            $data['text_ip_accuracy_radius'] = $this->language->get('text_ip_accuracy_radius');
            $data['text_ip_net_speed_cell'] = $this->language->get('text_ip_net_speed_cell');
            $data['text_ip_metro_code'] = $this->language->get('text_ip_metro_code');
            $data['text_ip_area_code'] = $this->language->get('text_ip_area_code');
            $data['text_ip_time_zone'] = $this->language->get('text_ip_time_zone');
            $data['text_ip_region_name'] = $this->language->get('text_ip_region_name');
            $data['text_ip_domain'] = $this->language->get('text_ip_domain');
            $data['text_ip_country_name'] = $this->language->get('text_ip_country_name');
            $data['text_ip_continent_code'] = $this->language->get('text_ip_continent_code');
            $data['text_ip_corporate_proxy'] = $this->language->get('text_ip_corporate_proxy');
            $data['text_anonymous_proxy'] = $this->language->get('text_anonymous_proxy');
            $data['text_proxy_score'] = $this->language->get('text_proxy_score');
            $data['text_is_trans_proxy'] = $this->language->get('text_is_trans_proxy');
            $data['text_free_mail'] = $this->language->get('text_free_mail');
            $data['text_carder_email'] = $this->language->get('text_carder_email');
            $data['text_high_risk_username'] = $this->language->get('text_high_risk_username');
            $data['text_high_risk_password'] = $this->language->get('text_high_risk_password');
            $data['text_bin_match'] = $this->language->get('text_bin_match');
            $data['text_bin_country'] = $this->language->get('text_bin_country');
            $data['text_bin_name_match'] = $this->language->get('text_bin_name_match');
            $data['text_bin_name'] = $this->language->get('text_bin_name');
            $data['text_bin_phone_match'] = $this->language->get('text_bin_phone_match');
            $data['text_bin_phone'] = $this->language->get('text_bin_phone');
            $data['text_seller_phone_in_billing_location'] = $this->language->get('text_seller_phone_in_billing_location');
            $data['text_ship_forward'] = $this->language->get('text_ship_forward');
            $data['text_city_postal_match'] = $this->language->get('text_city_postal_match');
            $data['text_ship_city_postal_match'] = $this->language->get('text_ship_city_postal_match');
            $data['text_score'] = $this->language->get('text_score');
            $data['text_explanation'] = $this->language->get('text_explanation');
            $data['text_risk_score'] = $this->language->get('text_risk_score');
            $data['text_queries_remaining'] = $this->language->get('text_queries_remaining');
            $data['text_maxmind_id'] = $this->language->get('text_maxmind_id');
            $data['text_error'] = $this->language->get('text_error');
            $data['text_loading'] = $this->language->get('text_loading');

            $data['help_country_match'] = $this->language->get('help_country_match');
            $data['help_country_code'] = $this->language->get('help_country_code');
            $data['help_high_risk_country'] = $this->language->get('help_high_risk_country');
            $data['help_distance'] = $this->language->get('help_distance');
            $data['help_ip_region'] = $this->language->get('help_ip_region');
            $data['help_ip_city'] = $this->language->get('help_ip_city');
            $data['help_ip_latitude'] = $this->language->get('help_ip_latitude');
            $data['help_ip_longitude'] = $this->language->get('help_ip_longitude');
            $data['help_ip_isp'] = $this->language->get('help_ip_isp');
            $data['help_ip_org'] = $this->language->get('help_ip_org');
            $data['help_ip_asnum'] = $this->language->get('help_ip_asnum');
            $data['help_ip_user_type'] = $this->language->get('help_ip_user_type');
            $data['help_ip_country_confidence'] = $this->language->get('help_ip_country_confidence');
            $data['help_ip_region_confidence'] = $this->language->get('help_ip_region_confidence');
            $data['help_ip_city_confidence'] = $this->language->get('help_ip_city_confidence');
            $data['help_ip_postal_confidence'] = $this->language->get('help_ip_postal_confidence');
            $data['help_ip_postal_code'] = $this->language->get('help_ip_postal_code');
            $data['help_ip_accuracy_radius'] = $this->language->get('help_ip_accuracy_radius');
            $data['help_ip_net_speed_cell'] = $this->language->get('help_ip_net_speed_cell');
            $data['help_ip_metro_code'] = $this->language->get('help_ip_metro_code');
            $data['help_ip_area_code'] = $this->language->get('help_ip_area_code');
            $data['help_ip_time_zone'] = $this->language->get('help_ip_time_zone');
            $data['help_ip_region_name'] = $this->language->get('help_ip_region_name');
            $data['help_ip_domain'] = $this->language->get('help_ip_domain');
            $data['help_ip_country_name'] = $this->language->get('help_ip_country_name');
            $data['help_ip_continent_code'] = $this->language->get('help_ip_continent_code');
            $data['help_ip_corporate_proxy'] = $this->language->get('help_ip_corporate_proxy');
            $data['help_anonymous_proxy'] = $this->language->get('help_anonymous_proxy');
            $data['help_proxy_score'] = $this->language->get('help_proxy_score');
            $data['help_is_trans_proxy'] = $this->language->get('help_is_trans_proxy');
            $data['help_free_mail'] = $this->language->get('help_free_mail');
            $data['help_carder_email'] = $this->language->get('help_carder_email');
            $data['help_high_risk_username'] = $this->language->get('help_high_risk_username');
            $data['help_high_risk_password'] = $this->language->get('help_high_risk_password');
            $data['help_bin_match'] = $this->language->get('help_bin_match');
            $data['help_bin_country'] = $this->language->get('help_bin_country');
            $data['help_bin_name_match'] = $this->language->get('help_bin_name_match');
            $data['help_bin_name'] = $this->language->get('help_bin_name');
            $data['help_bin_phone_match'] = $this->language->get('help_bin_phone_match');
            $data['help_bin_phone'] = $this->language->get('help_bin_phone');
            $data['help_seller_phone_in_billing_location'] = $this->language->get('help_seller_phone_in_billing_location');
            $data['help_ship_forward'] = $this->language->get('help_ship_forward');
            $data['help_city_postal_match'] = $this->language->get('help_city_postal_match');
            $data['help_ship_city_postal_match'] = $this->language->get('help_ship_city_postal_match');
            $data['help_score'] = $this->language->get('help_score');
            $data['help_explanation'] = $this->language->get('help_explanation');
            $data['help_risk_score'] = $this->language->get('help_risk_score');
            $data['help_queries_remaining'] = $this->language->get('help_queries_remaining');
            $data['help_maxmind_id'] = $this->language->get('help_maxmind_id');
            $data['help_error'] = $this->language->get('help_error');

            $data['column_product'] = $this->language->get('column_product');
            $data['column_model'] = $this->language->get('column_model');
            $data['column_quantity'] = $this->language->get('column_quantity');
            $data['column_price'] = $this->language->get('column_price');
            $data['column_total'] = $this->language->get('column_total');

            $data['entry_order_status'] = $this->language->get('entry_order_status');
            $data['entry_notify'] = $this->language->get('entry_notify');
            $data['entry_comment'] = $this->language->get('entry_comment');

            $data['button_invoice_print'] = $this->language->get('button_invoice_print');
            $data['button_shipping_print'] = $this->language->get('button_shipping_print');
            $data['button_edit'] = $this->language->get('button_edit');
            $data['button_cancel'] = $this->language->get('button_cancel');
            $data['button_generate'] = $this->language->get('button_generate');
            $data['button_reward_add'] = $this->language->get('button_reward_add');
            $data['button_reward_remove'] = $this->language->get('button_reward_remove');
            $data['button_commission_add'] = $this->language->get('button_commission_add');
            $data['button_commission_remove'] = $this->language->get('button_commission_remove');
            $data['button_sellerhistory_add'] = $this->language->get('button_sellerhistory_add');
            $data['button_sellersettlementhistory_add'] = $this->language->get('button_sellersettlementhistory_add');
            $data['button_sellersettlementhistory_cancel'] = $this->language->get('button_sellersettlementhistory_cancel');

            $data['tab_order'] = $this->language->get('tab_order');
            $data['tab_payment'] = $this->language->get('tab_payment');
            $data['tab_shipping'] = $this->language->get('tab_shipping');
            $data['tab_product'] = $this->language->get('tab_product');
            $data['tab_sellerhistory'] = $this->language->get('tab_sellerhistory');
            $data['tab_fraud'] = $this->language->get('tab_fraud');

            $data['config_sellerordersettlement'] = $this->config->get('config_sellerordersettlement');
            $data['config_sellerorderstatus'] = $this->config->get('config_sellerorderstatus');
            $data['config_sellerordernotifyhistory'] = $this->config->get('config_sellerordernotifyhistory');



            $url = '';

            if (isset($this->request->get['filter_order_id'])) {
                $url .= '&filter_order_id='.$this->request->get['filter_order_id'];
            }

            if (isset($this->request->get['filter_seller'])) {
                $url .= '&filter_seller='.urlencode(html_entity_decode($this->request->get['filter_seller'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_order_status'])) {
                $url .= '&filter_order_status='.$this->request->get['filter_order_status'];
            }

            if (isset($this->request->get['filter_total'])) {
                $url .= '&filter_total='.$this->request->get['filter_total'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added='.$this->request->get['filter_date_added'];
            }

            if (isset($this->request->get['filter_date_modified'])) {
                $url .= '&filter_date_modified='.$this->request->get['filter_date_modified'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort='.$this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order='.$this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page='.$this->request->get['page'];
            }

            $data['breadcrumbs'] = array();

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/home','' , 'SSL'),
            );

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('order/order', $url, 'SSL'),
            );

            $data['shipping'] = $this->url->link('order/order/shipping', 'order_id='.(int) $this->request->get['order_id'], 'SSL');
            $data['invoice'] = $this->url->link('order/order/invoice', 'order_id='.(int) $this->request->get['order_id'], 'SSL');
            $data['edit'] = $this->url->link('sale/order/edit', 'order_id='.(int) $this->request->get['order_id'], 'SSL');
            $data['cancel'] = $this->url->link('order/order', $url, 'SSL');

          $data['seller_order_info'] = $this->model_order_order->getSellrOrdersettlement($this->request->get['order_id'], $this->customer->getId());

            $data['order_id'] = $this->request->get['order_id'];

            $data['seller_id'] = $this->customer->getId();
            if ($order_info['invoice_no']) {
                $data['invoice_no'] = $order_info['invoice_prefix'].$order_info['invoice_no'];
            } else {
                $data['invoice_no'] = '';
            }

            $data['store_name'] = $order_info['store_name'];
            $data['store_url'] = $order_info['store_url'];
            $data['firstname'] = $order_info['firstname'];
            $data['lastname'] = $order_info['lastname'];

            $data['seller_name'] = $order_info['seller'];

            if ($order_info['customer_id']) {
                $data['seller'] = $this->url->link('seller/seller/info','', 'SSL');
            } else {
                $data['seller'] = '';
            }



            $seller_group_info = $this->model_order_order->getSellerGroup($order_info['customer_group_id']);

            if ($seller_group_info) {
                $data['seller_group'] = $seller_group_info['name'];
            } else {
                $data['seller_group'] = '';
            }

            $data['email'] = $order_info['email'];
            $data['telephone'] = $order_info['telephone'];
            $data['fax'] = $order_info['fax'];
            $data['comment'] = nl2br($order_info['comment']);
            $data['shipping_method'] = $order_info['shipping_method'];
            $data['payment_method'] = $order_info['payment_method'];
            $data['total'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']);

            $this->load->model('seller/seller');

            $data['reward'] = $order_info['reward'];

            $data['reward_total'] = $this->model_seller_seller->getTotalsellerRewardsByOrderId($this->request->get['order_id']);

            $data['affiliate_firstname'] = $order_info['affiliate_firstname'];
            $data['affiliate_lastname'] = $order_info['affiliate_lastname'];

            if ($order_info['affiliate_id']) {
                $data['affiliate'] = $this->url->link('marketing/affiliate/edit', 'affiliate_id='.$order_info['affiliate_id'], 'SSL');
            } else {
                $data['affiliate'] = '';
            }

            $data['commission'] = $this->currency->format($order_info['commission'], $order_info['currency_code'], $order_info['currency_value']);

            // $this->load->model('marketing/affiliate');
            //
            // $data['commission_total'] = $this->model_marketing_affiliate->getTotalTransactionsByOrderId($this->request->get['order_id']);

            $this->load->model('order/order_status');

            $order_status_info = $this->model_order_order_status->getOrderStatus($order_info['order_status_id']);

            if ($order_status_info) {
                $data['order_status'] = $order_status_info['name'];
            } else {
                $data['order_status'] = '';
            }




            $data['ip'] = $order_info['ip'];
            $data['forwarded_ip'] = $order_info['forwarded_ip'];
            $data['user_agent'] = $order_info['user_agent'];
            $data['accept_language'] = $order_info['accept_language'];

            $data['ip'] = $order_info['ip'];
            $data['forwarded_ip'] = $order_info['forwarded_ip'];
            $data['user_agent'] = $order_info['user_agent'];
            $data['accept_language'] = $order_info['accept_language'];
            $data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));
            $data['date_modified'] = date($this->language->get('date_format_short'), strtotime($order_info['date_modified']));
            $data['payment_firstname'] = $order_info['payment_firstname'];
            $data['payment_lastname'] = $order_info['payment_lastname'];
            $data['payment_company'] = $order_info['payment_company'];
            $data['payment_address_1'] = $order_info['payment_address_1'];
            $data['payment_address_2'] = $order_info['payment_address_2'];
            $data['payment_city'] = $order_info['payment_city'];
            $data['payment_postcode'] = $order_info['payment_postcode'];
            $data['payment_zone'] = $order_info['payment_zone'];
            $data['payment_zone_code'] = $order_info['payment_zone_code'];
            $data['payment_country'] = $order_info['payment_country'];
            $data['shipping_firstname'] = $order_info['shipping_firstname'];
            $data['shipping_lastname'] = $order_info['shipping_lastname'];
            $data['shipping_company'] = $order_info['shipping_company'];
            $data['shipping_address_1'] = $order_info['shipping_address_1'];
            $data['shipping_address_2'] = $order_info['shipping_address_2'];
            $data['shipping_city'] = $order_info['shipping_city'];
            $data['shipping_postcode'] = $order_info['shipping_postcode'];
            $data['shipping_zone'] = $order_info['shipping_zone'];
            $data['shipping_zone_code'] = $order_info['shipping_zone_code'];
            $data['shipping_country'] = $order_info['shipping_country'];

                        // Payment Address
            if ($order_info['payment_address_format']) {
                $format = $order_info['payment_address_format'];
            } else {
                $format = '{firstname} {lastname}'."\n".'{company}'."\n".'{address_1}'."\n".'{address_2}'."\n".'{city} {postcode}'."\n".'{zone}'."\n".'{country}';
            }

            $find = array(
                '{firstname}',
                '{lastname}',
                '{company}',
                '{address_1}',
                '{address_2}',
                '{city}',
                '{postcode}',
                '{zone}',
                '{zone_code}',
                '{country}',
            );

            $replace = array(
                'firstname' => $order_info['payment_firstname'],
                'lastname' => $order_info['payment_lastname'],
                'company' => $order_info['payment_company'],
                'address_1' => $order_info['payment_address_1'],
                'address_2' => $order_info['payment_address_2'],
                'city' => $order_info['payment_city'],
                'postcode' => $order_info['payment_postcode'],
                'zone' => $order_info['payment_zone'],
                'zone_code' => $order_info['payment_zone_code'],
                'country' => $order_info['payment_country'],
            );

            $data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

            // Shipping Address
            if ($order_info['shipping_address_format']) {
                $format = $order_info['shipping_address_format'];
            } else {
                $format = '{firstname} {lastname}'."\n".'{company}'."\n".'{address_1}'."\n".'{address_2}'."\n".'{city} {postcode}'."\n".'{zone}'."\n".'{country}';
            }

            $find = array(
                '{firstname}',
                '{lastname}',
                '{company}',
                '{address_1}',
                '{address_2}',
                '{city}',
                '{postcode}',
                '{zone}',
                '{zone_code}',
                '{country}',
            );

            $replace = array(
                'firstname' => $order_info['shipping_firstname'],
                'lastname' => $order_info['shipping_lastname'],
                'company' => $order_info['shipping_company'],
                'address_1' => $order_info['shipping_address_1'],
                'address_2' => $order_info['shipping_address_2'],
                'city' => $order_info['shipping_city'],
                'postcode' => $order_info['shipping_postcode'],
                'zone' => $order_info['shipping_zone'],
                'zone_code' => $order_info['shipping_zone_code'],
                'country' => $order_info['shipping_country'],
            );

            $data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

            // Additional Tabs
            $data['tabs'] = array();

            $this->load->model('extension/extension');

            $content = $this->load->controller('extension/payment/'.$order_info['payment_code'].'/order');

            if ($content) {
                $this->load->language('extension/payment/'.$order_info['payment_code']);

                $data['tabs'][] = array(
                    'code' => $order_info['payment_code'],
                    'title' => $this->language->get('heading_title'),
                    'content' => $content,
                );
            }



            $this->load->model('tool/upload');

            $data['products'] = array();

            $products = $this->model_order_order->getOrderProducts($this->request->get['order_id'], $this->customer->getId());
            $seller_total = 0;
            foreach ($products as $product) {
                $option_data = array();

                $options = $this->model_order_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

                foreach ($options as $option) {
                    if ($option['type'] != 'file') {
                        $option_data[] = array(
                            'name' => $option['name'],
                            'value' => $option['value'],
                            'type' => $option['type'],
                        );
                    } else {
                        $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                        if ($upload_info) {
                            $option_data[] = array(
                                'name' => $option['name'],
                                'value' => $upload_info['name'],
                                'type' => $option['type'],
                                'href' => $this->url->link('tool/upload/download', 'code='.$upload_info['code'], 'SSL'),
                            );
                        }
                    }
                }
                $this->load->model('order/order_status');


                $data['products'][] = array(
                    'order_product_id' => $product['order_product_id'],
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'model' => $product['model'],
                    'option' => $option_data,
                    'quantity' => $product['quantity'],
                    'order_product_status' => $product['status_id'],
                    'price' => $this->currency->format($product['price'] + ($this->config->get('config_tax') * 0 ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
                    'total' => $this->currency->format($product['total'] + ($this->config->get('config_tax') * 0 ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
                    'href' => $this->url->link('sellerproduct/product/edit', 'product_id='.$product['product_id'], 'SSL'),
                );

                $seller_total = $seller_total + $product['price'] * $product['quantity'];
            }

            $total = $this->model_order_order->getOrderTotalsTotal($this->request->get['order_id'], $this->customer->getId());

            $data['seller_total'] = $this->currency->format($seller_total +  $total, $order_info['currency_code'], $order_info['currency_value']);

            $data['vouchers'] = array();

            $vouchers = $this->model_order_order->getOrderVouchers($this->request->get['order_id']);

            foreach ($vouchers as $voucher) {
                $data['vouchers'][] = array(
                    'description' => $voucher['description'],
                    'amount' => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
                    'href' => $this->url->link('seller/voucher/edit', 'voucher_id='.$voucher['voucher_id'], 'SSL'),
                );
            }

            $totals = $this->model_order_order->getOrderTotals($this->request->get['order_id'],$this->customer->getId());

            foreach ($totals as $total) {
                $data['totals'][] = array(
                    'title' => $total['title'],
                    'text' => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
                );
            }

            $data['order_statuses'] = $this->model_order_order_status->getOrderStatuses();



            $data['order_status_id'] = $order_info['order_status_id'];

            // Unset any past sessions this page date_added for the api to work.
            unset($this->session->data['cookie']);


            if (isset($response['cookie'])) {
                $this->session->data['cookie'] = $response['cookie'];
            } else {
                $data['error_warning'] = $this->language->get('error_permission');
            }

            $data['payment_action'] = $this->load->controller('extension/payment/'.$order_info['payment_code'].'/orderAction', '');

            $data['column_left'] = $this->load->controller('common/column_left');
        		$data['column_right'] = $this->load->controller('common/column_right');
        		$data['content_top'] = $this->load->controller('common/content_top');
        		$data['content_bottom'] = $this->load->controller('common/content_bottom');
        		$data['footer'] = $this->load->controller('common/footer');
        		$data['header'] = $this->load->controller('common/header');



                  $this->response->setOutput($this->load->view('order/order_info', $data));

        } else {
          $this->index();

        }
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'order/order')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function createInvoiceNo()
    {
        $this->load->language('order/order');

        $json = array();

        if (isset($this->request->get['order_id'])) {
            if (isset($this->request->get['order_id'])) {
                $order_id = $this->request->get['order_id'];
            } else {
                $order_id = 0;
            }

            $this->load->model('order/order');

            $invoice_no = $this->model_order_order->createInvoiceNo($order_id, $this->customer->getId());

            if ($invoice_no) {
                $json['invoice_no'] = $invoice_no;
            } else {
                $json['error'] = $this->language->get('error_action');
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function addReward()
    {
        $this->load->language('order/order');

        $json = array();

        if (!$this->user->hasPermission('modify', 'order/order')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            if (isset($this->request->get['order_id'])) {
                $order_id = $this->request->get['order_id'];
            } else {
                $order_id = 0;
            }

            $this->load->model('order/order');

            $order_info = $this->model_order_order->getOrder($order_id);

            if ($order_info && $order_info['customer_id'] && ($order_info['reward'] > 0)) {
                $this->load->model('seller/seller');

                $reward_total = $this->model_seller_seller->getTotalsellerRewardsByOrderId($order_id);

                if (!$reward_total) {
                    $this->model_seller_seller->addReward($order_info['customer_id'], $this->language->get('text_order_id').' #'.$order_id, $order_info['reward'], $order_id);
                }
            }

            $json['success'] = $this->language->get('text_reward_added');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function removeReward()
    {
        $this->load->language('order/order');

        $json = array();

        if (!$this->user->hasPermission('modify', 'order/order')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            if (isset($this->request->get['order_id'])) {
                $order_id = $this->request->get['order_id'];
            } else {
                $order_id = 0;
            }

            $this->load->model('order/order');

            $order_info = $this->model_order_order->getOrder($order_id);

            if ($order_info) {
                $this->load->model('seller/seller');

                $this->model_seller_seller->deleteReward($order_id);
            }

            $json['success'] = $this->language->get('text_reward_removed');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function addCommission()
    {
        $this->load->language('order/order');

        $json = array();

        if (!$this->user->hasPermission('modify', 'order/order')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            if (isset($this->request->get['order_id'])) {
                $order_id = $this->request->get['order_id'];
            } else {
                $order_id = 0;
            }

            $this->load->model('order/order');

            $order_info = $this->model_order_order->getOrder($order_id);

            if ($order_info) {
                $this->load->model('marketing/affiliate');

                $affiliate_total = $this->model_marketing_affiliate->getTotalTransactionsByOrderId($order_id);

                if (!$affiliate_total) {
                    $this->model_marketing_affiliate->addTransaction($order_info['affiliate_id'], $this->language->get('text_order_id').' #'.$order_id, $order_info['commission'], $order_id);
                }
            }

            $json['success'] = $this->language->get('text_commission_added');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function removeCommission()
    {
        $this->load->language('order/order');

        $json = array();

        if (!$this->user->hasPermission('modify', 'order/order')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            if (isset($this->request->get['order_id'])) {
                $order_id = $this->request->get['order_id'];
            } else {
                $order_id = 0;
            }

            $this->load->model('order/order');

            $order_info = $this->model_order_order->getOrder($order_id);

            if ($order_info) {
                $this->load->model('marketing/affiliate');

                $this->model_marketing_affiliate->deleteTransaction($order_id);
            }

            $json['success'] = $this->language->get('text_commission_removed');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function country()
    {
        $json = array();

        $this->load->model('localisation/country');

        $country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

        if ($country_info) {
            $this->load->model('localisation/zone');

            $json = array(
                'country_id' => $country_info['country_id'],
                'name' => $country_info['name'],
                'iso_code_2' => $country_info['iso_code_2'],
                'iso_code_3' => $country_info['iso_code_3'],
                'address_format' => $country_info['address_format'],
                'postcode_required' => $country_info['postcode_required'],
                'zone' => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
                'status' => $country_info['status'],
            );
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function sellerhistory()
    {
        $this->load->language('order/order');

        $data['text_no_results'] = $this->language->get('text_no_results');

        $data['column_date_added'] = $this->language->get('column_date_added');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_notify'] = $this->language->get('column_notify');
        $data['column_comment'] = $this->language->get('column_comment');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $data['histories'] = array();

        $this->load->model('order/order');
        $this->load->model('seller/seller');

        $results = $this->model_order_order->getOrderHistories($this->request->get['order_id'], $this->customer->getId(), ($page - 1) * 10, 10);

        foreach ($results as $result) {
            $data['histories'][] = array(
                'notify' => $result['notify'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
                'status' => $result['status'],
                'comment' => $result['notify'] ? nl2br($result['comment']) : '',
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
            );
        }

        $sellerhistory_total = $this->model_order_order->getTotalOrderHistories($this->request->get['order_id'], $this->customer->getId());

        $pagination = new Pagination();
        $pagination->total = $sellerhistory_total;
        $pagination->page = $page;
        $pagination->limit = 10;
        $pagination->url = $this->url->link('order/order/sellerhistory', 'order_id='.$this->request->get['order_id'].'&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($sellerhistory_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($sellerhistory_total - 10)) ? $sellerhistory_total : ((($page - 1) * 10) + 10), $sellerhistory_total, ceil($sellerhistory_total / 10));



            $this->response->setOutput($this->load->view('order/order_sellerhistory', $data));

    }

    public function invoice()
    {
        $this->load->language('order/order');

        $data['title'] = $this->language->get('text_invoice');

        if ($this->request->server['HTTPS']) {
            $data['base'] = HTTPS_SERVER;
        } else {
            $data['base'] = HTTP_SERVER;
        }

        $data['direction'] = $this->language->get('direction');
        $data['lang'] = $this->language->get('code');
        $data['text_total'] = $this->language->get('text_total');
        $data['text_seller_name'] = $this->language->get('text_seller_name');
        $data['text_seller_info'] = $this->language->get('text_seller_info');
        $data['text_invoice'] = $this->language->get('text_invoice');
        $data['text_order_detail'] = $this->language->get('text_order_detail');
        $data['text_order_id'] = $this->language->get('text_order_id');
        $data['text_invoice_no'] = $this->language->get('text_invoice_no');
        $data['text_invoice_date'] = $this->language->get('text_invoice_date');
        $data['text_date_added'] = $this->language->get('text_date_added');
        $data['text_telephone'] = $this->language->get('text_telephone');
        $data['text_fax'] = $this->language->get('text_fax');
        $data['text_email'] = $this->language->get('text_email');
        $data['text_website'] = $this->language->get('text_website');
        $data['text_to'] = $this->language->get('text_to');
        $data['text_ship_to'] = $this->language->get('text_ship_to');
        $data['text_payment_method'] = $this->language->get('text_payment_method');
        $data['text_shipping_method'] = $this->language->get('text_shipping_method');

        $data['column_product'] = $this->language->get('column_product');
        $data['column_model'] = $this->language->get('column_model');
        $data['column_quantity'] = $this->language->get('column_quantity');
        $data['column_price'] = $this->language->get('column_price');
        $data['column_total'] = $this->language->get('column_total');
        $data['column_comment'] = $this->language->get('column_comment');

        $this->load->model('order/order');

        $this->load->model('setting/setting');

        $data['orders'] = array();

        $orders = array();

        if (isset($this->request->post['selected'])) {
            $orders = $this->request->post['selected'];
        } elseif (isset($this->request->get['order_id'])) {
            $orders[] = $this->request->get['order_id'];
        }

        foreach ($orders as $order_id) {
            $order_info = $this->model_order_order->getOrder($order_id, $this->customer->getId());

            if ($order_info) {
                $store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

                if ($store_info) {
                    $store_address = $store_info['config_address'];
                    $store_email = $store_info['config_email'];
                    $store_telephone = $store_info['config_telephone'];
                    $store_fax = $store_info['config_fax'];
                } else {
                    $store_address = $this->config->get('config_address');
                    $store_email = $this->config->get('config_email');
                    $store_telephone = $this->config->get('config_telephone');
                    $store_fax = $this->config->get('config_fax');
                }

                if ($order_info['invoice_no']) {
                    $invoice_no = $order_info['invoice_prefix'].$order_info['invoice_no'];
                } else {
                    $invoice_no = '';
                }

                if ($order_info['payment_address_format']) {
                    $format = $order_info['payment_address_format'];
                } else {
                    $format = '{firstname} {lastname}'."\n".'{company}'."\n".'{address_1}'."\n".'{address_2}'."\n".'{city} {postcode}'."\n".'{zone}'."\n".'{country}';
                }

                $find = array(
                    '{firstname}',
                    '{lastname}',
                    '{company}',
                    '{address_1}',
                    '{address_2}',
                    '{city}',
                    '{postcode}',
                    '{zone}',
                    '{zone_code}',
                    '{country}',
                );

                $replace = array(
                    'firstname' => $order_info['payment_firstname'],
                    'lastname' => $order_info['payment_lastname'],
                    'company' => $order_info['payment_company'],
                    'address_1' => $order_info['payment_address_1'],
                    'address_2' => $order_info['payment_address_2'],
                    'city' => $order_info['payment_city'],
                    'postcode' => $order_info['payment_postcode'],
                    'zone' => $order_info['payment_zone'],
                    'zone_code' => $order_info['payment_zone_code'],
                    'country' => $order_info['payment_country'],
                );

                $payment_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

                if ($order_info['shipping_address_format']) {
                    $format = $order_info['shipping_address_format'];
                } else {
                    $format = '{firstname} {lastname}'."\n".'{company}'."\n".'{address_1}'."\n".'{address_2}'."\n".'{city} {postcode}'."\n".'{zone}'."\n".'{country}';
                }

                $find = array(
                    '{firstname}',
                    '{lastname}',
                    '{company}',
                    '{address_1}',
                    '{address_2}',
                    '{city}',
                    '{postcode}',
                    '{zone}',
                    '{zone_code}',
                    '{country}',
                );

                $replace = array(
                    'firstname' => $order_info['shipping_firstname'],
                    'lastname' => $order_info['shipping_lastname'],
                    'company' => $order_info['shipping_company'],
                    'address_1' => $order_info['shipping_address_1'],
                    'address_2' => $order_info['shipping_address_2'],
                    'city' => $order_info['shipping_city'],
                    'postcode' => $order_info['shipping_postcode'],
                    'zone' => $order_info['shipping_zone'],
                    'zone_code' => $order_info['shipping_zone_code'],
                    'country' => $order_info['shipping_country'],
                );

                $shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

                $this->load->model('tool/upload');

                $product_data = array();

                $products = $this->model_order_order->getOrderProducts($order_id, $this->customer->getId());
                $seller_total = 0;
                foreach ($products as $product) {
                    $option_data = array();

                    $options = $this->model_order_order->getOrderOptions($order_id, $product['order_product_id']);

                    foreach ($options as $option) {
                        if ($option['type'] != 'file') {
                            $value = $option['value'];
                        } else {
                            $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                            if ($upload_info) {
                                $value = $upload_info['name'];
                            } else {
                                $value = '';
                            }
                        }

                        $option_data[] = array(
                            'name' => $option['name'],
                            'value' => $value,
                        );
                    }

                    $product_data[] = array(
                        'name' => $product['name'],
                        'model' => $product['model'],
                        'option' => $option_data,
                        'quantity' => $product['quantity'],
                        'price' => $this->currency->format($product['price'] + ($this->config->get('config_tax') * 0 ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
                    'total' => $this->currency->format($product['total'] + ($this->config->get('config_tax') * 0 ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
                    );
                    $seller_total = $seller_total + $product['price'] * $product['quantity'];
                }

                $total = $this->model_order_order->getOrderTotalsTotal($this->request->get['order_id'], $this->customer->getId());

                $data['seller_total'] = $this->currency->format($seller_total + $total, $order_info['currency_code'], $order_info['currency_value']);

                $voucher_data = array();

                $vouchers = $this->model_order_order->getOrderVouchers($order_id);

                foreach ($vouchers as $voucher) {
                    $voucher_data[] = array(
                        'description' => $voucher['description'],
                        'amount' => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
                    );
                }

                $total_data = array();

                $totals = $this->model_order_order->getOrderTotals($order_id,$this->customer->getId());

                foreach ($totals as $total) {
                    $total_data[] = array(
                        'title' => $total['title'],
                        'text' => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
                    );
                }

                $data['orders'][] = array(
                    'order_id' => $order_id,
                    'invoice_no' => $invoice_no,
                    'date_added' => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
                    'store_name' => $order_info['store_name'],
                    'store_url' => rtrim($order_info['store_url'], '/'),
                    'store_address' => nl2br($store_address),
                    'store_email' => $store_email,
                    'store_telephone' => $store_telephone,
                    'store_fax' => $store_fax,
                    'email' => $order_info['email'],
                    'telephone' => $order_info['telephone'],
                      'customer_email' => $order_info['customer_email'],
                    'customer_telephone' => $order_info['customer_telephone'],
                    'shipping_address' => $shipping_address,
                    'shipping_method' => $order_info['shipping_method'],
                    'payment_address' => $payment_address,
                    'payment_method' => $order_info['payment_method'],
                    'product' => $product_data,
                    'voucher' => $voucher_data,
                    'total' => $total_data,
                    'comment' => nl2br($order_info['comment']),
                );
            }
        }

        $this->load->model('seller/seller');

        $data['seller_info'] = $this->model_seller_seller->getseller($this->customer->getId());


            $this->response->setOutput($this->load->view('order/order_invoice', $data));

    }

    public function shipping()
    {
        $this->load->language('order/order');

        $data['title'] = $this->language->get('text_shipping');

        if ($this->request->server['HTTPS']) {
            $data['base'] = HTTPS_SERVER;
        } else {
            $data['base'] = HTTP_SERVER;
        }

        $data['direction'] = $this->language->get('direction');
        $data['lang'] = $this->language->get('code');

        $data['text_shipping'] = $this->language->get('text_shipping');
        $data['text_picklist'] = $this->language->get('text_picklist');
        $data['text_order_detail'] = $this->language->get('text_order_detail');
        $data['text_order_id'] = $this->language->get('text_order_id');
        $data['text_invoice_no'] = $this->language->get('text_invoice_no');
        $data['text_invoice_date'] = $this->language->get('text_invoice_date');
        $data['text_date_added'] = $this->language->get('text_date_added');
        $data['text_telephone'] = $this->language->get('text_telephone');
        $data['text_fax'] = $this->language->get('text_fax');
        $data['text_email'] = $this->language->get('text_email');
        $data['text_website'] = $this->language->get('text_website');
        $data['text_contact'] = $this->language->get('text_contact');
        $data['text_from'] = $this->language->get('text_from');
        $data['text_to'] = $this->language->get('text_to');
        $data['text_shipping_method'] = $this->language->get('text_shipping_method');
        $data['text_sku'] = $this->language->get('text_sku');
        $data['text_upc'] = $this->language->get('text_upc');
        $data['text_ean'] = $this->language->get('text_ean');
        $data['text_jan'] = $this->language->get('text_jan');
        $data['text_isbn'] = $this->language->get('text_isbn');
        $data['text_mpn'] = $this->language->get('text_mpn');

        $data['column_location'] = $this->language->get('column_location');
        $data['column_reference'] = $this->language->get('column_reference');
        $data['column_product'] = $this->language->get('column_product');
        $data['column_weight'] = $this->language->get('column_weight');
        $data['column_model'] = $this->language->get('column_model');
        $data['column_quantity'] = $this->language->get('column_quantity');
        $data['column_comment'] = $this->language->get('column_comment');

        $this->load->model('order/order');

        $this->load->model('catalog/product');

        $this->load->model('setting/setting');

        $data['orders'] = array();

        $orders = array();

        if (isset($this->request->post['selected'])) {
            $orders = $this->request->post['selected'];
        } elseif (isset($this->request->get['order_id'])) {
            $orders[] = $this->request->get['order_id'];
        }

        foreach ($orders as $order_id) {
            $order_info = $this->model_order_order->getOrder($order_id, $this->customer->getId());

            // Make sure there is a shipping method
            if ($order_info && $order_info['shipping_code']) {
                $store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

                if ($store_info) {
                    $store_address = $store_info['config_address'];
                    $store_email = $store_info['config_email'];
                    $store_telephone = $store_info['config_telephone'];
                    $store_fax = $store_info['config_fax'];
                } else {
                    $store_address = $this->config->get('config_address');
                    $store_email = $this->config->get('config_email');
                    $store_telephone = $this->config->get('config_telephone');
                    $store_fax = $this->config->get('config_fax');
                }

                if ($order_info['invoice_no']) {
                    $invoice_no = $order_info['invoice_prefix'].$order_info['invoice_no'];
                } else {
                    $invoice_no = '';
                }

                if ($order_info['shipping_address_format']) {
                    $format = $order_info['shipping_address_format'];
                } else {
                    $format = '{firstname} {lastname}'."\n".'{company}'."\n".'{address_1}'."\n".'{address_2}'."\n".'{city} {postcode}'."\n".'{zone}'."\n".'{country}';
                }

                $find = array(
                    '{firstname}',
                    '{lastname}',
                    '{company}',
                    '{address_1}',
                    '{address_2}',
                    '{city}',
                    '{postcode}',
                    '{zone}',
                    '{zone_code}',
                    '{country}',
                );

                $replace = array(
                    'firstname' => $order_info['shipping_firstname'],
                    'lastname' => $order_info['shipping_lastname'],
                    'company' => $order_info['shipping_company'],
                    'address_1' => $order_info['shipping_address_1'],
                    'address_2' => $order_info['shipping_address_2'],
                    'city' => $order_info['shipping_city'],
                    'postcode' => $order_info['shipping_postcode'],
                    'zone' => $order_info['shipping_zone'],
                    'zone_code' => $order_info['shipping_zone_code'],
                    'country' => $order_info['shipping_country'],
                );

                $shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

                $this->load->model('tool/upload');

                $product_data = array();

                $products = $this->model_order_order->getOrderProducts($order_id, $this->customer->getId());

                foreach ($products as $product) {
                    $product_info = $this->model_catalog_product->getProduct($product['product_id']);

                    $option_data = array();

                    $options = $this->model_order_order->getOrderOptions($order_id, $product['order_product_id']);

                    foreach ($options as $option) {
                        if ($option['type'] != 'file') {
                            $value = $option['value'];
                        } else {
                            $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                            if ($upload_info) {
                                $value = $upload_info['name'];
                            } else {
                                $value = '';
                            }
                        }

                        $option_data[] = array(
                            'name' => $option['name'],
                            'value' => $value,
                        );
                    }

                    $product_data[] = array(
                        'name' => $product_info['name'],
                        'model' => $product_info['model'],
                        'option' => $option_data,
                        'quantity' => $product['quantity'],
                        'location' => $product_info['location'],
                        'sku' => $product_info['sku'],
                        'upc' => $product_info['upc'],
                        'ean' => $product_info['ean'],
                        'jan' => $product_info['jan'],
                        'isbn' => $product_info['isbn'],
                        'mpn' => $product_info['mpn'],
                        'weight' => $this->weight->format($product_info['weight'], $this->config->get('config_weight_class_id'), $this->language->get('decimal_point'), $this->language->get('thousand_point')),
                    );
                }

                $data['orders'][] = array(
                    'order_id' => $order_id,
                    'invoice_no' => $invoice_no,
                    'date_added' => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
                    'store_name' => $order_info['store_name'],
                    'store_url' => rtrim($order_info['store_url'], '/'),
                    'store_address' => nl2br($store_address),
                    'store_email' => $store_email,
                    'store_telephone' => $store_telephone,
                    'store_fax' => $store_fax,
                    'email' => $order_info['email'],
                    'telephone' => $order_info['telephone'],
                    'customer_email' => $order_info['customer_email'],
                  'customer_telephone' => $order_info['customer_telephone'],
                    'shipping_address' => $shipping_address,
                    'shipping_method' => $order_info['shipping_method'],
                    'product' => $product_data,
                    'comment' => nl2br($order_info['comment']),
                );
            }
        }


            $this->response->setOutput($this->load->view('order/order_shipping', $data));

    }

    public function api()
    {
        $json = array();

        // Store
        if (isset($this->request->get['store_id'])) {
            $store_id = $this->request->get['store_id'];
        } else {
            $store_id = 0;
        }

        $this->load->model('setting/store');

        $store_info = $this->model_setting_store->getStore($store_id);

        if ($store_info) {
            $url = $store_info['ssl'];
        } else {
            $url = HTTPS_CATALOG;
        }

        if (isset($this->session->data['cookie']) && isset($this->request->get['api'])) {
            // Include any URL perameters
            $url_data = array();

            foreach ($this->request->get as $key => $value) {
                if ($key != 'route' && $key != 'token' && $key != 'store_id') {
                    $url_data[$key] = $value;
                }
            }

            $curl = curl_init();

            // Set SSL if required
            if (substr($url, 0, 5) == 'https') {
                curl_setopt($curl, CURLOPT_PORT, 443);
            }

            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLINFO_HEADER_OUT, true);
            curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, $url.'index.php?route='.$this->request->get['api'].($url_data ? '&'.http_build_query($url_data) : ''));

            if ($this->request->post) {
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($this->request->post));
            }

            curl_setopt($curl, CURLOPT_COOKIE, session_name().'='.$this->session->data['cookie'].';');

            $json = curl_exec($curl);

            curl_close($curl);
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput($json);
    }

    public function add_to_transaction()
    {
        $this->load->language('order/order');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('seller/seller');

        $this->load->model('order/order');

        $orders = array();

        if (isset($this->request->post['selected'])) {
            $orders = $this->request->post['selected'];
        } elseif (isset($this->request->get['order_id'])) {
            $orders[] = $this->request->get['order_id'];
        }

        if ($orders && $this->validate()) {
            $results = $this->model_order_order->getOrderBySeller($this->customer->getId());

            $add_to_seller_history_transaction_comment = sprintf($this->language->get('add_to_seller_history_transaction_comment'), $results['order_id']);

            $this->model_seller_seller->addHistory($this->customer->getId(), $add_to_seller_history_transaction_comment);

            $add_to_seller_transaction_comment = sprintf($this->language->get('add_to_seller_transaction_comment'), $results['order_id']);

            $this->model_seller_seller->addTransaction($this->customer->getId(), $add_to_seller_transaction_comment, $results['totals']);

            $add_order_seller_history_comment = sprintf($this->language->get('add_order_seller_history_comment'), $this->customer->getId(), $this->currency->format($results['totals']));

            if ($results) {
                $this->model_order_order->addOrderHistory($this->customer->getId(), $results['order_id'], 1, $results['order_status_id'], $add_order_seller_history_comment, 0);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name='.urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_email'])) {
                $url .= '&filter_email='.urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_seller_group_id'])) {
                $url .= '&filter_seller_group_id='.$this->request->get['filter_seller_group_id'];
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status='.$this->request->get['filter_status'];
            }

            if (isset($this->request->get['filter_seller_approved'])) {
                $url .= '&filter_seller_approved='.$this->request->get['filter_seller_approved'];
            }

            if (isset($this->request->get['filter_ip'])) {
                $url .= '&filter_ip='.$this->request->get['filter_ip'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added='.$this->request->get['filter_date_added'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort='.$this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order='.$this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page='.$this->request->get['page'];
            }

            $this->response->redirect($this->url->link('order/order', $url, 'SSL'));
        }

        $this->getList();
    }

    public function selleraddhistory()
    {


        $json = array();


            $keys = array(
                'order_status_id',
                'notify',
                'append',
                'comment',
            );

        foreach ($keys as $key) {
            if (!isset($this->request->post[$key])) {
                $this->request->post[$key] = '';
            }
        }
        $this->load->language('order/order');

        $this->load->model('order/order');

        if (isset($this->request->get['order_id'])) {
            $order_id = $this->request->get['order_id'];
        } else {
            $order_id = 0;
        }

        $order_info = $this->model_order_order->getOrder($order_id, $this->customer->getId());

        if ($order_info) {
            $this->model_order_order->addOrderHistory($order_id, $order_info['order_status_id'],$this->customer->getId(), $this->request->post['comment'], $this->request->post['notify']);
            $json['success'] = $this->language->get('text_success');
        } else {
            $json['error'] = $this->language->get('error_not_found');
        }


        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function sellerproductorderchangestatus()
    {

      $this->load->model('order/order');

        $json = array();



 $this->model_order_order->sellerproductorderchangestatus($this->request->get['order_id'],$this->request->post['product_id'],$this->request->post['status_id']);




            $json['success'] = $this->request->post['status_id'];



        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function sellerproductorderdelete()
    {

      $this->load->model('order/order');

        $json = array();



        $this->model_order_order->sellerproductorderdelete($this->request->get['order_id'],$this->request->post['product_id']);






            $json['success'] = '';



        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    public function sellerordersettlement() {

$this->load->model('order/order');
$json = array();


  // Add keys for missing post vars
  $keys = array(
    'order_status_id',
    'notify',
    'append',
    'comment'
  );

  foreach ($keys as $key) {
    if (!isset($this->request->post[$key])) {
      $this->request->post[$key] = '';
    }
  }



  if (isset($this->request->get['order_id'])) {
    $order_id = $this->request->get['order_id'];
  } else {
    $order_id = 0;
  }

  if (isset($this->request->get['seller_id'])) {
    $seller_id = $this->request->get['seller_id'];
  } else {
    $seller_id = 0;
  }


if (isset($this->request->post['settlement'])){
$this->load->language('order/order');

$this->load->model('seller/seller');

$this->load->model('order/order');

$results = $this->model_order_order->getOrderBySeller($this->request->get['seller_id'],$this->request->get['order_id']);

$add_to_seller_history_transaction_comment = sprintf($this->language->get('add_to_seller_history_transaction_comment'), $results['order_id']);


  $this->model_seller_seller->addHistory($this->request->get['seller_id'], $add_to_seller_history_transaction_comment);

  $add_to_seller_transaction_comment = sprintf($this->language->get('add_to_seller_transaction_comment'), $results['order_id']);

  $this->model_seller_seller->addTransaction($this->request->get['seller_id'], $add_to_seller_transaction_comment , $results['totals'] , $results['order_id']);

$results = $this->model_order_order->AddSellrOrdersettlement($this->request->get['order_id'],$this->request->get['seller_id']);
}

if (isset($this->request->post['cancelsettlement'])){
$this->load->language('order/order');

$this->load->model('seller/seller');

$this->load->model('order/order');

$results = $this->model_order_order->getOrderBySeller($this->request->get['seller_id'],$this->request->get['order_id']);

$add_to_seller_cancel_transaction_comment = sprintf($this->language->get('add_to_seller_cancel_transaction_comment'), $results['order_id']);


  $this->model_seller_seller->addHistory($this->request->get['seller_id'], $add_to_seller_cancel_transaction_comment);

  $add_to_seller_cancel_transaction_comment = sprintf($this->language->get('add_to_seller_cancel_transaction_comment'), $results['order_id']);

  $this->model_seller_seller->addTransaction($this->request->get['seller_id'], $add_to_seller_cancel_transaction_comment ,( $results['totals'] * -1) , $results['order_id']);

$results = $this->model_order_order->CancelSellrOrdersettlement($this->request->get['order_id'],$this->request->get['seller_id']);
}
  $order_info = $this->model_order_order->getOrder($order_id,$this->customer->getId());

  if ($order_info) {
    $this->model_order_order->addOrderSellerHistory($order_id,$seller_id, $this->request->post['order_status_id'], $this->request->post['comment'], $this->request->post['notify']);

    $json['success'] = $this->language->get('text_success');
  } else {
    $json['error'] = $this->language->get('error_not_found');
  }


$this->response->addHeader('Content-Type: application/json');
$this->response->setOutput(json_encode($json));
}
}
