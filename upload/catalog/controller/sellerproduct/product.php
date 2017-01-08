<?php

class ControllersellerproductProduct extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->model('sellerproduct/seller');

        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('sellerproduct/product', '', 'SSL');

            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        }

        if ($this->customer->isSeller()) {
            $this->load->language('sellerproduct/product');

            $this->document->setTitle($this->language->get('heading_title'));

            $this->load->model('sellerproduct/product');

            $this->getList();
        } else {
            $this->response->redirect($this->url->link('sellerprofile/sellerprofile', '', 'SSL'));
        }
    }
    public function add()
    {
        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
        $this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

        if (!$this->customer->isSeller()) {
            $this->index();
        }
        if (!$this->ProductLimit()) {
            $this->response->redirect($this->url->link('sellerproduct/product', '', 'SSL'));
        //$this->getList();
        }
        $this->load->language('sellerproduct/product');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sellerproduct/product');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_sellerproduct_product->addProduct($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name='.urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_model'])) {
                $url .= '&filter_model='.urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_price'])) {
                $url .= '&filter_price='.$this->request->get['filter_price'];
            }

            if (isset($this->request->get['filter_quantity'])) {
                $url .= '&filter_quantity='.$this->request->get['filter_quantity'];
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status='.$this->request->get['filter_status'];
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

            // Add to activity log
            $this->load->model('account/activity');

            $activity_data = array(
                'customer_id' => $this->customer->getId(),
                'name' => $this->customer->getFirstName().' '.$this->customer->getLastName(),
            );

            $this->model_account_activity->addActivity('product_add', $activity_data);

            $this->response->redirect($this->url->link('sellerproduct/product', ''.$url, 'SSL'));
        }

        $this->getForm();
    }

    public function edit()
    {
        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
        $this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

        $this->load->language('sellerproduct/product');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sellerproduct/product');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_sellerproduct_product->editProduct($this->request->get['product_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name='.urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_model'])) {
                $url .= '&filter_model='.urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_price'])) {
                $url .= '&filter_price='.$this->request->get['filter_price'];
            }

            if (isset($this->request->get['filter_quantity'])) {
                $url .= '&filter_quantity='.$this->request->get['filter_quantity'];
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status='.$this->request->get['filter_status'];
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

            // Add to activity log
            $this->load->model('account/activity');

            $activity_data = array(
                'customer_id' => $this->customer->getId(),
                'name' => $this->customer->getFirstName().' '.$this->customer->getLastName(),
            );

            $this->model_account_activity->addActivity('product_edit', $activity_data);

            $this->response->redirect($this->url->link('sellerproduct/product', ''.$url, 'SSL'));
        }

        $this->getForm();
    }

    public function delete()
    {
        $this->load->language('sellerproduct/product');

        if (!$this->customer->isSeller()) {
            $this->index();
        }

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sellerproduct/product');

        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $product_id) {
                $this->model_sellerproduct_product->deleteProduct($product_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name='.urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_model'])) {
                $url .= '&filter_model='.urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_price'])) {
                $url .= '&filter_price='.$this->request->get['filter_price'];
            }

            if (isset($this->request->get['filter_quantity'])) {
                $url .= '&filter_quantity='.$this->request->get['filter_quantity'];
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status='.$this->request->get['filter_status'];
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

            // Add to activity log
            $this->load->model('account/activity');

            $activity_data = array(
                'customer_id' => $this->customer->getId(),
                'name' => $this->customer->getFirstName().' '.$this->customer->getLastName(),
            );

            $this->model_account_activity->addActivity('product_delete', $activity_data);

            $this->response->redirect($this->url->link('sellerproduct/product', ''.$url, 'SSL'));
        }

        $this->getList();
    }

    public function copy()
    {
        $this->load->language('sellerproduct/product');

        if (!$this->customer->isSeller()) {
            $this->index();
        }

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sellerproduct/product');

        if (isset($this->request->post['selected']) && $this->copyProductLimit($this->request->post['selected'], $this->request->get['product_total'])) {
            foreach ($this->request->post['selected'] as $product_id) {
                $this->model_sellerproduct_product->copyProduct($product_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name='.urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_model'])) {
                $url .= '&filter_model='.urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_price'])) {
                $url .= '&filter_price='.$this->request->get['filter_price'];
            }

            if (isset($this->request->get['filter_quantity'])) {
                $url .= '&filter_quantity='.$this->request->get['filter_quantity'];
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status='.$this->request->get['filter_status'];
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

            // Add to activity log
            $this->load->model('account/activity');

            $activity_data = array(
                'customer_id' => $this->customer->getId(),
                'name' => $this->customer->getFirstName().' '.$this->customer->getLastName(),
            );

            $this->model_account_activity->addActivity('product_copy', $activity_data);

            $this->response->redirect($this->url->link('sellerproduct/product', ''.$url, 'SSL'));
        }

        $this->getList();
    }

    public function copyByIsbn()
    {
        $this->load->language('sellerproduct/product');

        if (!$this->customer->isSeller()) {
            $this->index();
        }
        $json = array();
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sellerproduct/product');

        if (isset($this->request->get['product_id'])) {
            $this->model_sellerproduct_product->copyProductByIsbn($this->request->get['product_id']);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name='.urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_model'])) {
                $url .= '&filter_model='.urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_price'])) {
                $url .= '&filter_price='.$this->request->get['filter_price'];
            }

            if (isset($this->request->get['filter_quantity'])) {
                $url .= '&filter_quantity='.$this->request->get['filter_quantity'];
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status='.$this->request->get['filter_status'];
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

            // Add to activity log
            $this->load->model('account/activity');

            $activity_data = array(
                'customer_id' => $this->customer->getId(),
                'name' => $this->customer->getFirstName().' '.$this->customer->getLastName(),
            );

            $this->model_account_activity->addActivity('product_copy', $activity_data);
        }
        $json['success'] = sprintf($this->language->get('text_success'), '');
        $json['redirect'] = str_replace('&amp;', '&', $this->url->link('sellerproduct/product', 'filter_name='.$this->request->get['filter_name']));
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    protected function getList()
    {
        $this->load->model('sellerproduct/seller');

        $data['seller_product_total'] = $this->model_sellerproduct_product->getTotalProducts();
        $data['product_limit'] = $this->model_sellerproduct_seller->getSellerGroupIdBysellerId();

        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = null;
        }

        if (isset($this->request->get['filter_model'])) {
            $filter_model = $this->request->get['filter_model'];
        } else {
            $filter_model = null;
        }

        if (isset($this->request->get['filter_price'])) {
            $filter_price = $this->request->get['filter_price'];
        } else {
            $filter_price = null;
        }

        if (isset($this->request->get['filter_quantity'])) {
            $filter_quantity = $this->request->get['filter_quantity'];
        } else {
            $filter_quantity = null;
        }

        if (isset($this->request->get['filter_status'])) {
            $filter_status = $this->request->get['filter_status'];
        } else {
            $filter_status = null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'pd.name';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name='.urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_model'])) {
            $url .= '&filter_model='.urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_price'])) {
            $url .= '&filter_price='.$this->request->get['filter_price'];
        }

        if (isset($this->request->get['filter_quantity'])) {
            $url .= '&filter_quantity='.$this->request->get['filter_quantity'];
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status='.$this->request->get['filter_status'];
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
            'href' => $this->url->link('sellerproduct/product', ''.$url, 'SSL'),
        );

        $data['insert'] = $this->url->link('sellerproduct/product/add', ''.$url, 'SSL');
        $data['delete'] = $this->url->link('sellerproduct/product/delete', ''.$url, 'SSL');

        $data['products'] = array();

        $filter_data = array(
            'filter_name' => $filter_name,
            'filter_model' => $filter_model,
            'filter_price' => $filter_price,
            'filter_quantity' => $filter_quantity,
            'filter_status' => $filter_status,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin'),
        );

        $this->load->model('tool/image');

        $product_total = $this->model_sellerproduct_product->getTotalProducts($filter_data);

        $data['product_total'] = $product_total;

        $data['copy'] = $this->url->link('sellerproduct/product/copy',  ''.'&product_total='.$product_total.$url, 'SSL');

        $results = $this->model_sellerproduct_product->getProducts($filter_data);

        foreach ($results as $result) {
            if (is_file(DIR_IMAGE.$result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('no_image.png', 40, 40);
            }

            $special = false;

            $product_specials = $this->model_sellerproduct_product->getProductSpecials($result['product_id']);

            foreach ($product_specials  as $product_special) {
                if (($product_special['date_start'] == '0000-00-00' || $product_special['date_start'] < date('Y-m-d')) && ($product_special['date_end'] == '0000-00-00' || $product_special['date_end'] > date('Y-m-d'))) {
                    $special = $product_special['price'];

                    break;
                }
            }

            $data['products'][] = array(
                'product_id' => $result['product_id'],
                'image' => $image,
                'name' => $result['name'],
                'model' => $result['model'],
                'price' => $result['price'],
                'special' => $special,
                'quantity' => $result['quantity'],
                'product_approval' => $result['status'],
                'status' => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
                'edit' => $this->url->link('sellerproduct/product/edit', ''.'&product_id='.$result['product_id'].$url, 'SSL'),
            );
        }

        if($this->customer->getSellerGroupProductStatus()){
          $data['product_status'] = true;
        }elseif($this->customer->getSellerProductStatus()){
          $data['product_status'] = true;
        }else{
            $data['product_status'] = '0';
        }




        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');
        $data['button_request_approval'] = $this->language->get('button_request_approval');
        $data['text_loading'] = $this->language->get('text_loading');
        $data['text_pending'] = $this->language->get('text_pending');

        $data['column_image'] = $this->language->get('column_image');
        $data['column_name'] = $this->language->get('column_name');
        $data['column_model'] = $this->language->get('column_model');
        $data['column_price'] = $this->language->get('column_price');
        $data['column_quantity'] = $this->language->get('column_quantity');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_action'] = $this->language->get('column_action');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_model'] = $this->language->get('entry_model');
        $data['entry_price'] = $this->language->get('entry_price');
        $data['entry_quantity'] = $this->language->get('entry_quantity');
        $data['entry_status'] = $this->language->get('entry_status');

        $data['button_copy'] = $this->language->get('button_copy');
        $data['button_add'] = $this->language->get('button_add');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_filter'] = $this->language->get('button_filter');

        $this->load->model('sellerproduct/seller');
        $this->load->model('sellerproduct/product');

        $product_limit = $this->model_sellerproduct_seller->getSellerGroupIdBysellerId();
        $product_total = $this->model_sellerproduct_product->getTotalProducts();

        if ($product_total >= $product_limit['product_limit'] && $product_limit['product_limit'] != '0') {
            $this->error['warning'] = $this->language->get('text_product_limit');
        }

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

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name='.urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_model'])) {
            $url .= '&filter_model='.urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_price'])) {
            $url .= '&filter_price='.$this->request->get['filter_price'];
        }

        if (isset($this->request->get['filter_quantity'])) {
            $url .= '&filter_quantity='.$this->request->get['filter_quantity'];
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status='.$this->request->get['filter_status'];
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page='.$this->request->get['page'];
        }

        $data['sort_name'] = $this->url->link('sellerproduct/product', ''.'&sort=pd.name'.$url, 'SSL');
        $data['sort_model'] = $this->url->link('sellerproduct/product', ''.'&sort=p.model'.$url, 'SSL');
        $data['sort_price'] = $this->url->link('sellerproduct/product', ''.'&sort=p.price'.$url, 'SSL');
        $data['sort_quantity'] = $this->url->link('sellerproduct/product', ''.'&sort=p.quantity'.$url, 'SSL');
        $data['sort_status'] = $this->url->link('sellerproduct/product', ''.'&sort=p.status'.$url, 'SSL');
        $data['sort_order'] = $this->url->link('sellerproduct/product', ''.'&sort=p.sort_order'.$url, 'SSL');

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name='.urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_model'])) {
            $url .= '&filter_model='.urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_price'])) {
            $url .= '&filter_price='.$this->request->get['filter_price'];
        }

        if (isset($this->request->get['filter_quantity'])) {
            $url .= '&filter_quantity='.$this->request->get['filter_quantity'];
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status='.$this->request->get['filter_status'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort='.$this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order='.$this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $product_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('sellerproduct/product', ''.$url.'&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));

        $data['filter_name'] = $filter_name;
        $data['filter_model'] = $filter_model;
        $data['filter_price'] = $filter_price;
        $data['filter_quantity'] = $filter_quantity;
        $data['filter_status'] = $filter_status;

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');


            $this->response->setOutput($this->load->view('sellerproduct/product_list', $data));

    }

    protected function getForm()
    {
        $this->load->model('sellerproduct/seller');

        $data['product_limit'] = $this->model_sellerproduct_seller->getSellerGroupIdBysellerId();

        if (isset($this->request->get['product_id'])) {
            $product_id = $this->request->get['product_id'];
        } else {
            $product_id = 0;
        }

        $isproductseller = $this->model_sellerproduct_product->isSellerProduct($product_id);
        if (!$isproductseller) {
            $this->index();
        } else {
            $data['heading_title'] = $this->language->get('heading_title');
            $data['text_confirm'] = $this->language->get('text_confirm');

            $data['text_form'] = !isset($this->request->get['product_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
            $data['text_enabled'] = $this->language->get('text_enabled');
            $data['text_disabled'] = $this->language->get('text_disabled');
            $data['text_none'] = $this->language->get('text_none');
            $data['text_yes'] = $this->language->get('text_yes');
            $data['text_no'] = $this->language->get('text_no');
            $data['text_plus'] = $this->language->get('text_plus');
            $data['text_minus'] = $this->language->get('text_minus');
            $data['text_default'] = $this->language->get('text_default');
            $data['text_option'] = $this->language->get('text_option');
            $data['text_option_value'] = $this->language->get('text_option_value');
            $data['text_select'] = $this->language->get('text_select');
            $data['text_percent'] = $this->language->get('text_percent');
            $data['text_amount'] = $this->language->get('text_amount');
            $data['text_price_notice'] = sprintf($this->language->get('text_price_notice'), $this->config->get('config_currency'));

            $data['entry_name'] = $this->language->get('entry_name');
            $data['entry_description'] = $this->language->get('entry_description');
            $data['entry_meta_title'] = $this->language->get('entry_meta_title');
            $data['entry_meta_why'] = $this->language->get('entry_meta_why');
            $data['entry_product_tag'] = $this->language->get('entry_product_tag');
            $data['entry_meta_description'] = $this->language->get('entry_meta_description');
            $data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
            $data['entry_keyword'] = $this->language->get('entry_keyword');
            $data['entry_model'] = $this->language->get('entry_model');
            $data['entry_sku'] = $this->language->get('entry_sku');
            $data['entry_upc'] = $this->language->get('entry_upc');
            $data['entry_ean'] = $this->language->get('entry_ean');
            $data['entry_jan'] = $this->language->get('entry_jan');
            $data['entry_isbn'] = $this->language->get('entry_isbn');
            $data['entry_mpn'] = $this->language->get('entry_mpn');
            $data['entry_location'] = $this->language->get('entry_location');
            $data['entry_minimum'] = $this->language->get('entry_minimum');
            $data['entry_shipping'] = $this->language->get('entry_shipping');
            $data['entry_date_available'] = $this->language->get('entry_date_available');
            $data['entry_quantity'] = $this->language->get('entry_quantity');
            $data['entry_stock_status'] = $this->language->get('entry_stock_status');
            $data['entry_price'] = $this->language->get('entry_price');
            $data['entry_tax_class'] = $this->language->get('entry_tax_class');
            $data['entry_points'] = $this->language->get('entry_points');
            $data['entry_option_points'] = $this->language->get('entry_option_points');
            $data['entry_subtract'] = $this->language->get('entry_subtract');
            $data['entry_weight_class'] = $this->language->get('entry_weight_class');
            $data['entry_weight'] = $this->language->get('entry_weight');
            $data['entry_dimension'] = $this->language->get('entry_dimension');
            $data['entry_length_class'] = $this->language->get('entry_length_class');
            $data['entry_length'] = $this->language->get('entry_length');
            $data['entry_width'] = $this->language->get('entry_width');
            $data['entry_height'] = $this->language->get('entry_height');
            $data['entry_image'] = $this->language->get('entry_image');
            $data['entry_image_more'] = $this->language->get('entry_image_more');
            $data['entry_store'] = $this->language->get('entry_store');
            $data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
            $data['entry_download'] = $this->language->get('entry_download');
            $data['entry_category'] = $this->language->get('entry_category');
            $data['entry_filter'] = $this->language->get('entry_filter');
            $data['entry_related'] = $this->language->get('entry_related');
            $data['entry_attribute'] = $this->language->get('entry_attribute');
            $data['entry_text'] = $this->language->get('entry_text');
            $data['entry_option'] = $this->language->get('entry_option');
            $data['entry_option_value'] = $this->language->get('entry_option_value');
            $data['entry_required'] = $this->language->get('entry_required');
            $data['entry_sort_order'] = $this->language->get('entry_sort_order');
            $data['entry_status'] = $this->language->get('entry_status');
            $data['entry_date_start'] = $this->language->get('entry_date_start');
            $data['entry_date_end'] = $this->language->get('entry_date_end');
            $data['entry_priority'] = $this->language->get('entry_priority');
            $data['entry_tag'] = $this->language->get('entry_tag');
            $data['entry_customer_group'] = $this->language->get('entry_customer_group');
            $data['entry_reward'] = $this->language->get('entry_reward');
            $data['entry_layout'] = $this->language->get('entry_layout');
            $data['entry_recurring'] = $this->language->get('entry_recurring');

            $data['help_keyword'] = $this->language->get('help_keyword');
            $data['help_sku'] = $this->language->get('help_sku');
            $data['help_upc'] = $this->language->get('help_upc');
            $data['help_ean'] = $this->language->get('help_ean');
            $data['help_jan'] = $this->language->get('help_jan');
            $data['help_isbn'] = $this->language->get('help_isbn');
            $data['help_mpn'] = $this->language->get('help_mpn');
            $data['help_minimum'] = $this->language->get('help_minimum');
            $data['help_manufacturer'] = $this->language->get('help_manufacturer');
            $data['help_stock_status'] = $this->language->get('help_stock_status');
            $data['help_points'] = $this->language->get('help_points');
            $data['help_category'] = $this->language->get('help_category');
            $data['help_filter'] = $this->language->get('help_filter');
            $data['help_download'] = $this->language->get('help_download');
            $data['help_related'] = $this->language->get('help_related');
            $data['help_tag'] = $this->language->get('help_tag');

            $data['button_save'] = $this->language->get('button_save');
            $data['button_cancel'] = $this->language->get('button_cancel');
            $data['button_add'] = $this->language->get('button_add');

            $data['tab_general'] = $this->language->get('tab_general');
            $data['tab_data'] = $this->language->get('tab_data');
            $data['tab_attribute'] = $this->language->get('tab_attribute');
            $data['tab_option'] = $this->language->get('tab_option');
            $data['tab_recurring'] = $this->language->get('tab_recurring');
            $data['tab_discount'] = $this->language->get('tab_discount');
            $data['tab_special'] = $this->language->get('tab_special');
            $data['tab_image'] = $this->language->get('tab_image');
            $data['tab_links'] = $this->language->get('tab_links');
            $data['tab_reward'] = $this->language->get('tab_reward');
            $data['tab_design'] = $this->language->get('tab_design');
            $data['tab_openbay'] = $this->language->get('tab_openbay');

            if (isset($this->error['warning'])) {
                $data['error_warning'] = $this->error['warning'];
            } else {
                $data['error_warning'] = '';
            }

            if (isset($this->error['name'])) {
                $data['error_name'] = $this->error['name'];
            } else {
                $data['error_name'] = array();
            }

            if (isset($this->error['meta_title'])) {
                $data['error_meta_title'] = $this->error['meta_title'];
            } else {
                $data['error_meta_title'] = array();
            }

            if (isset($this->error['model'])) {
                $data['error_model'] = $this->error['model'];
            } else {
                $data['error_model'] = '';
            }

            if (isset($this->error['date_available'])) {
                $data['error_date_available'] = $this->error['date_available'];
            } else {
                $data['error_date_available'] = '';
            }

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name='.urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_model'])) {
                $url .= '&filter_model='.urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_price'])) {
                $url .= '&filter_price='.$this->request->get['filter_price'];
            }

            if (isset($this->request->get['filter_quantity'])) {
                $url .= '&filter_quantity='.$this->request->get['filter_quantity'];
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status='.$this->request->get['filter_status'];
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
            'href' => $this->url->link('sellerproduct/product', ''.$url, 'SSL'),
        );

            if (!isset($this->request->get['product_id'])) {
                $data['action'] = $this->url->link('sellerproduct/product/add', ''.$url, 'SSL');
            } else {
                $data['action'] = $this->url->link('sellerproduct/product/edit', ''.'&product_id='.$this->request->get['product_id'].$url, 'SSL');
            }

            $data['cancel'] = $this->url->link('sellerproduct/product', ''.$url, 'SSL');

            if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
                $product_info = $this->model_sellerproduct_product->getProduct($this->request->get['product_id']);
            }

            $data['config_multiseller_tab_data'] = $this->config->get('config_multiseller_tab_data');
            $data['config_multiseller_tab_links'] = $this->config->get('config_multiseller_tab_links');
            $data['config_multiseller_tab_attribute'] = $this->config->get('config_multiseller_tab_attribute');
            $data['config_multiseller_tab_options'] = $this->config->get('config_multiseller_tab_options');
            $data['config_multiseller_tab_recurring'] = $this->config->get('config_multiseller_tab_recurring');
            $data['config_multiseller_tab_discount'] = $this->config->get('config_multiseller_tab_discount');
            $data['config_multiseller_tab_special'] = $this->config->get('config_multiseller_tab_special');
            $data['config_multiseller_tab_image'] = $this->config->get('config_multiseller_tab_image');
            $data['config_multiseller_tab_reward_points'] = $this->config->get('config_multiseller_tab_reward_points');
            $data['config_multiseller_tab_design'] = $this->config->get('config_multiseller_tab_design');
            $data['config_multiseller_out_of_stock_status'] = $this->config->get('config_multiseller_out_of_stock_status');
            $data['config_multiseller_date_available'] = $this->config->get('config_multiseller_date_available');
            $data['config_multiseller_dimensions'] = $this->config->get('config_multiseller_dimensions');
            $data['config_multiseller_subtract_stok'] = $this->config->get('config_multiseller_subtract_stok');
            $data['config_multiseller_seo_url'] = $this->config->get('config_multiseller_seo_url');
            $data['config_multiseller_length_class'] = $this->config->get('config_multiseller_length_class');
            $data['config_multiseller_weight'] = $this->config->get('config_multiseller_weight');
            $data['config_multiseller_weight_class'] = $this->config->get('config_multiseller_weight_class');
            $data['config_multiseller_status'] = $this->config->get('config_multiseller_status');
            $data['config_multiseller_sort_order'] = $this->config->get('config_multiseller_sort_order');
            $data['config_multiseller_sku'] = $this->config->get('config_multiseller_sku');
            $data['config_multiseller_upc'] = $this->config->get('config_multiseller_upc');
            $data['config_multiseller_ean'] = $this->config->get('config_multiseller_ean');
            $data['config_multiseller_jan'] = $this->config->get('config_multiseller_jan');
            $data['config_multiseller_isbn'] = $this->config->get('config_multiseller_isbn');
            $data['config_multiseller_out_of_stock_status'] = $this->config->get('config_multiseller_out_of_stock_status');
            $data['config_multiseller_location'] = $this->config->get('config_multiseller_location');
            $data['config_multiseller_price'] = $this->config->get('config_multiseller_price');
            $data['config_multiseller_quantity'] = $this->config->get('config_multiseller_quantity');
            $data['config_multiseller_minimum_quantity'] = $this->config->get('config_multiseller_minimum_quantity');
            $data['config_multiseller_mpn'] = $this->config->get('config_multiseller_mpn');
            $data['config_multiseller_tax_class'] = $this->config->get('config_multiseller_tax_class');
            $data['config_multiseller_requires_shipping'] = $this->config->get('config_multiseller_requires_shipping');
            $data['config_multiseller_image'] = $this->config->get('config_multiseller_image');
            $data['config_multiseller_model'] = $this->config->get('config_multiseller_model');
            $data['config_multiseller_related_products'] = $this->config->get('config_multiseller_related_products');
            $data['config_multiseller_stors'] = $this->config->get('config_multiseller_stors');
            $data['config_multiseller_filters'] = $this->config->get('config_multiseller_filters');
            $data['config_multiseller_categories'] = $this->config->get('config_multiseller_categories');
            $data['config_multiseller_manufacturer'] = $this->config->get('config_multiseller_manufacturer');
            $data['config_multiseller_dimension'] = $this->config->get('config_multiseller_dimension');
            $data['config_multiseller_downloads'] = $this->config->get('config_multiseller_downloads');

            $this->load->model('sellerproduct/language');

            $data['languages'] = $this->model_sellerproduct_language->getLanguages();

            if (isset($this->request->post['product_description'])) {
                $data['product_description'] = $this->request->post['product_description'];
            } elseif (isset($this->request->get['product_id'])) {
                $data['product_description'] = $this->model_sellerproduct_product->getProductDescriptions($this->request->get['product_id']);
            } else {
                $data['product_description'] = array();
            }

            if (isset($this->request->post['image'])) {
                $data['image'] = $this->request->post['image'];
            } elseif (!empty($product_info)) {
                $data['image'] = $product_info['image'];
            } else {
                $data['image'] = '';
            }

            $this->load->model('tool/image');

            if (isset($this->request->post['image']) && is_file(DIR_IMAGE.$this->request->post['image'])) {
                $data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
            } elseif (!empty($product_info) && is_file(DIR_IMAGE.$product_info['image'])) {
                $data['thumb'] = $this->model_tool_image->resize($product_info['image'], 100, 100);
            } else {
                $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
            }

            $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

            if (isset($this->request->post['model'])) {
                $data['model'] = $this->request->post['model'];
            } elseif (!empty($product_info)) {
                $data['model'] = $product_info['model'];
            } else {
                $data['model'] = '';
            }

            if (isset($this->request->post['sku'])) {
                $data['sku'] = $this->request->post['sku'];
            } elseif (!empty($product_info)) {
                $data['sku'] = $product_info['sku'];
            } else {
                $data['sku'] = '';
            }

            if (isset($this->request->post['upc'])) {
                $data['upc'] = $this->request->post['upc'];
            } elseif (!empty($product_info)) {
                $data['upc'] = $product_info['upc'];
            } else {
                $data['upc'] = '';
            }

            if (isset($this->request->post['ean'])) {
                $data['ean'] = $this->request->post['ean'];
            } elseif (!empty($product_info)) {
                $data['ean'] = $product_info['ean'];
            } else {
                $data['ean'] = '';
            }

            if (isset($this->request->post['jan'])) {
                $data['jan'] = $this->request->post['jan'];
            } elseif (!empty($product_info)) {
                $data['jan'] = $product_info['jan'];
            } else {
                $data['jan'] = '';
            }

            if (isset($this->request->post['isbn'])) {
                $data['isbn'] = $this->request->post['isbn'];
            } elseif (!empty($product_info)) {
                $data['isbn'] = $product_info['isbn'];
            } else {
                $data['isbn'] = '';
            }

            if (isset($this->request->post['mpn'])) {
                $data['mpn'] = $this->request->post['mpn'];
            } elseif (!empty($product_info)) {
                $data['mpn'] = $product_info['mpn'];
            } else {
                $data['mpn'] = '';
            }

            if (isset($this->request->post['location'])) {
                $data['location'] = $this->request->post['location'];
            } elseif (!empty($product_info)) {
                $data['location'] = $product_info['location'];
            } else {
                $data['location'] = '';
            }

            $this->load->model('setting/store');

            $data['stores'] = $this->model_setting_store->getStores();

            if (isset($this->request->post['product_store'])) {
                $data['product_store'] = $this->request->post['product_store'];
            } elseif (isset($this->request->get['product_id'])) {
                $data['product_store'] = $this->model_sellerproduct_product->getProductStores($this->request->get['product_id']);
            } else {
                $data['product_store'] = array(0);
            }

            if (isset($this->request->post['keyword'])) {
                $data['keyword'] = $this->request->post['keyword'];
            } elseif (!empty($product_info)) {
                $data['keyword'] = $product_info['keyword'];
            } else {
                $data['keyword'] = '';
            }

            if (isset($this->request->post['shipping'])) {
                $data['shipping'] = $this->request->post['shipping'];
            } elseif (!empty($product_info)) {
                $data['shipping'] = $product_info['shipping'];
            } else {
                $data['shipping'] = 1;
            }

            if (isset($this->request->post['price'])) {
                $data['price'] = $this->request->post['price'];
            } elseif (!empty($product_info)) {
                $data['price'] = $product_info['price'];
            } else {
                $data['price'] = '';
            }

            $this->load->model('sellerproduct/recurring');

            $data['recurrings'] = $this->model_sellerproduct_recurring->getRecurrings();

            if (isset($this->request->post['product_recurrings'])) {
                $data['product_recurrings'] = $this->request->post['product_recurrings'];
            } elseif (!empty($product_info)) {
                $data['product_recurrings'] = $this->model_sellerproduct_product->getRecurrings($product_info['product_id']);
            } else {
                $data['product_recurrings'] = array();
            }

            $this->load->model('sellerproduct/tax_class');

            $data['tax_classes'] = $this->model_sellerproduct_tax_class->getTaxClasses();

            if (isset($this->request->post['tax_class_id'])) {
                $data['tax_class_id'] = $this->request->post['tax_class_id'];
            } elseif (!empty($product_info)) {
                $data['tax_class_id'] = $product_info['tax_class_id'];
            } else {
                $data['tax_class_id'] = 0;
            }

            if (isset($this->request->post['date_available'])) {
                $data['date_available'] = $this->request->post['date_available'];
            } elseif (!empty($product_info)) {
                $data['date_available'] = ($product_info['date_available'] != '0000-00-00') ? $product_info['date_available'] : '';
            } else {
                $data['date_available'] = date('Y-m-d');
            }

            if (isset($this->request->post['quantity'])) {
                $data['quantity'] = $this->request->post['quantity'];
            } elseif (!empty($product_info)) {
                $data['quantity'] = $product_info['quantity'];
            } else {
                $data['quantity'] = 1;
            }

            if (isset($this->request->post['minimum'])) {
                $data['minimum'] = $this->request->post['minimum'];
            } elseif (!empty($product_info)) {
                $data['minimum'] = $product_info['minimum'];
            } else {
                $data['minimum'] = 1;
            }

            if (isset($this->request->post['subtract'])) {
                $data['subtract'] = $this->request->post['subtract'];
            } elseif (!empty($product_info)) {
                $data['subtract'] = $product_info['subtract'];
            } else {
                $data['subtract'] = 1;
            }

            if (isset($this->request->post['sort_order'])) {
                $data['sort_order'] = $this->request->post['sort_order'];
            } elseif (!empty($product_info)) {
                $data['sort_order'] = $product_info['sort_order'];
            } else {
                $data['sort_order'] = 1;
            }

            $this->load->model('sellerproduct/stock_status');

            $data['stock_statuses'] = $this->model_sellerproduct_stock_status->getStockStatuses();

            if (isset($this->request->post['stock_status_id'])) {
                $data['stock_status_id'] = $this->request->post['stock_status_id'];
            } elseif (!empty($product_info)) {
                $data['stock_status_id'] = $product_info['stock_status_id'];
            } else {
                $data['stock_status_id'] = 0;
            }

            if (isset($this->request->post['status'])) {
                $data['status'] = $this->request->post['status'];
            } elseif (!empty($product_info)) {
                $data['status'] = $product_info['status'];
            } else {
                $data['status'] = 0;
            }

            if (isset($this->request->post['weight'])) {
                $data['weight'] = $this->request->post['weight'];
            } elseif (!empty($product_info)) {
                $data['weight'] = $product_info['weight'];
            } else {
                $data['weight'] = '';
            }

            $this->load->model('sellerproduct/weight_class');

            $data['weight_classes'] = $this->model_sellerproduct_weight_class->getWeightClasses();

            if (isset($this->request->post['weight_class_id'])) {
                $data['weight_class_id'] = $this->request->post['weight_class_id'];
            } elseif (!empty($product_info)) {
                $data['weight_class_id'] = $product_info['weight_class_id'];
            } else {
                $data['weight_class_id'] = $this->config->get('config_weight_class_id');
            }

            if (isset($this->request->post['length'])) {
                $data['length'] = $this->request->post['length'];
            } elseif (!empty($product_info)) {
                $data['length'] = $product_info['length'];
            } else {
                $data['length'] = '';
            }

            if (isset($this->request->post['width'])) {
                $data['width'] = $this->request->post['width'];
            } elseif (!empty($product_info)) {
                $data['width'] = $product_info['width'];
            } else {
                $data['width'] = '';
            }

            if (isset($this->request->post['height'])) {
                $data['height'] = $this->request->post['height'];
            } elseif (!empty($product_info)) {
                $data['height'] = $product_info['height'];
            } else {
                $data['height'] = '';
            }

            $this->load->model('sellerproduct/length_class');

            $data['length_classes'] = $this->model_sellerproduct_length_class->getLengthClasses();

            if (isset($this->request->post['length_class_id'])) {
                $data['length_class_id'] = $this->request->post['length_class_id'];
            } elseif (!empty($product_info)) {
                $data['length_class_id'] = $product_info['length_class_id'];
            } else {
                $data['length_class_id'] = $this->config->get('config_length_class_id');
            }

            $this->load->model('sellerproduct/manufacturer');

            if (isset($this->request->post['manufacturer_id'])) {
                $data['manufacturer_id'] = $this->request->post['manufacturer_id'];
            } elseif (!empty($product_info)) {
                $data['manufacturer_id'] = $product_info['manufacturer_id'];
            } else {
                $data['manufacturer_id'] = 0;
            }

            if (isset($this->request->post['manufacturer'])) {
                $data['manufacturer'] = $this->request->post['manufacturer'];
            } elseif (!empty($product_info)) {
                $manufacturer_info = $this->model_sellerproduct_manufacturer->getManufacturer($product_info['manufacturer_id']);

                if ($manufacturer_info) {
                    $data['manufacturer'] = $manufacturer_info['name'];
                } else {
                    $data['manufacturer'] = '';
                }
            } else {
                $data['manufacturer'] = '';
            }

        // Categories
        $this->load->model('sellerproduct/category');

            if (isset($this->request->post['product_category'])) {
                $categories = $this->request->post['product_category'];
            } elseif (isset($this->request->get['product_id'])) {
                $categories = $this->model_sellerproduct_product->getProductCategories($this->request->get['product_id']);
            } else {
                $categories = array();
            }

            $data['product_categories'] = array();

            foreach ($categories as $category_id) {
                $category_info = $this->model_sellerproduct_category->getCategory($category_id);

                if ($category_info) {
                    $data['product_categories'][] = array(
                    'category_id' => $category_info['category_id'],
                    'name' => ($category_info['path']) ? $category_info['path'].' &gt; '.$category_info['name'] : $category_info['name'],
                );
                }
            }

        // Filters
        $this->load->model('sellerproduct/filter');

            if (isset($this->request->post['product_filter'])) {
                $filters = $this->request->post['product_filter'];
            } elseif (isset($this->request->get['product_id'])) {
                $filters = $this->model_sellerproduct_product->getProductFilters($this->request->get['product_id']);
            } else {
                $filters = array();
            }

            $data['product_filters'] = array();

            foreach ($filters as $filter_id) {
                $filter_info = $this->model_sellerproduct_filter->getFilter($filter_id);

                if ($filter_info) {
                    $data['product_filters'][] = array(
                    'filter_id' => $filter_info['filter_id'],
                    'name' => $filter_info['group'].' &gt; '.$filter_info['name'],
                );
                }
            }

        // Attributes
        $this->load->model('sellerproduct/attribute');

            if (isset($this->request->post['product_attribute'])) {
                $product_attributes = $this->request->post['product_attribute'];
            } elseif (isset($this->request->get['product_id'])) {
                $product_attributes = $this->model_sellerproduct_product->getProductAttributes($this->request->get['product_id']);
            } else {
                $product_attributes = array();
            }

            $data['product_attributes'] = array();

            foreach ($product_attributes as $product_attribute) {
                $attribute_info = $this->model_sellerproduct_attribute->getAttribute($product_attribute['attribute_id']);

                if ($attribute_info) {
                    $data['product_attributes'][] = array(
                    'attribute_id' => $product_attribute['attribute_id'],
                    'name' => $attribute_info['name'],
                    'product_attribute_description' => $product_attribute['product_attribute_description'],
                );
                }
            }

        // Options
        $this->load->model('sellerproduct/option');

            if (isset($this->request->post['product_option'])) {
                $product_options = $this->request->post['product_option'];
            } elseif (isset($this->request->get['product_id'])) {
                $product_options = $this->model_sellerproduct_product->getProductOptions($this->request->get['product_id']);
            } else {
                $product_options = array();
            }

            $data['product_options'] = array();

            foreach ($product_options as $product_option) {
                $product_option_value_data = array();

                if (isset($product_option['product_option_value'])) {
                    foreach ($product_option['product_option_value'] as $product_option_value) {
                        $product_option_value_data[] = array(
                        'product_option_value_id' => $product_option_value['product_option_value_id'],
                        'option_value_id' => $product_option_value['option_value_id'],
                        'quantity' => $product_option_value['quantity'],
                        'subtract' => $product_option_value['subtract'],
                        'price' => $product_option_value['price'],
                        'price_prefix' => $product_option_value['price_prefix'],
                        'points' => $product_option_value['points'],
                        'points_prefix' => $product_option_value['points_prefix'],
                        'weight' => $product_option_value['weight'],
                        'weight_prefix' => $product_option_value['weight_prefix'],
                    );
                    }
                }

                $data['product_options'][] = array(
                'product_option_id' => $product_option['product_option_id'],
                'product_option_value' => $product_option_value_data,
                'option_id' => $product_option['option_id'],
                'name' => $product_option['name'],
                'type' => $product_option['type'],
                'value' => isset($product_option['value']) ? $product_option['value'] : '',
                'required' => $product_option['required'],
            );
            }

            $data['option_values'] = array();

            foreach ($data['product_options'] as $product_option) {
                if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                    if (!isset($data['option_values'][$product_option['option_id']])) {
                        $data['option_values'][$product_option['option_id']] = $this->model_sellerproduct_option->getOptionValues($product_option['option_id']);
                    }
                }
            }

            $this->load->model('account/customer_group');

            $data['customer_groups'] = $this->model_account_customer_group->getCustomerGroups();

            if (isset($this->request->post['product_discount'])) {
                $product_discounts = $this->request->post['product_discount'];
            } elseif (isset($this->request->get['product_id'])) {
                $product_discounts = $this->model_sellerproduct_product->getProductDiscounts($this->request->get['product_id']);
            } else {
                $product_discounts = array();
            }

            $data['product_discounts'] = array();

            foreach ($product_discounts as $product_discount) {
                $data['product_discounts'][] = array(
                'customer_group_id' => $product_discount['customer_group_id'],
                'quantity' => $product_discount['quantity'],
                'priority' => $product_discount['priority'],
                'price' => $product_discount['price'],
                'date_start' => ($product_discount['date_start'] != '0000-00-00') ? $product_discount['date_start'] : '',
                'date_end' => ($product_discount['date_end'] != '0000-00-00') ? $product_discount['date_end'] : '',
            );
            }

            if (isset($this->request->post['product_special'])) {
                $product_specials = $this->request->post['product_special'];
            } elseif (isset($this->request->get['product_id'])) {
                $product_specials = $this->model_sellerproduct_product->getProductSpecials($this->request->get['product_id']);
            } else {
                $product_specials = array();
            }

            $data['product_specials'] = array();

            foreach ($product_specials as $product_special) {
                $data['product_specials'][] = array(
                'customer_group_id' => $product_special['customer_group_id'],
                'priority' => $product_special['priority'],
                'price' => $product_special['price'],
                'date_start' => ($product_special['date_start'] != '0000-00-00') ? $product_special['date_start'] : '',
                'date_end' => ($product_special['date_end'] != '0000-00-00') ? $product_special['date_end'] :  '',
            );
            }

        // Images
        if (isset($this->request->post['product_image'])) {
            $product_images = $this->request->post['product_image'];
        } elseif (isset($this->request->get['product_id'])) {
            $product_images = $this->model_sellerproduct_product->getProductImages($this->request->get['product_id']);
        } else {
            $product_images = array();
        }

            $data['product_images'] = array();

            foreach ($product_images as $product_image) {
                if (is_file(DIR_IMAGE.$product_image['image'])) {
                    $image = $product_image['image'];
                    $thumb = $product_image['image'];
                } else {
                    $image = '';
                    $thumb = 'no_image.png';
                }

                $data['product_images'][] = array(
                'image' => $image,
                'thumb' => $this->model_tool_image->resize($thumb, 100, 100),
                'sort_order' => $product_image['sort_order'],
            );
            }

        // Downloads
        $this->load->model('sellerproduct/download');

            if (isset($this->request->post['product_download'])) {
                $product_downloads = $this->request->post['product_download'];
            } elseif (isset($this->request->get['product_id'])) {
                $product_downloads = $this->model_sellerproduct_product->getProductDownloads($this->request->get['product_id']);
            } else {
                $product_downloads = array();
            }

            $data['product_downloads'] = array();

            foreach ($product_downloads as $download_id) {
                $download_info = $this->model_sellerproduct_download->getDownload($download_id);

                if ($download_info) {
                    $data['product_downloads'][] = array(
                    'download_id' => $download_info['download_id'],
                    'name' => $download_info['name'],
                );
                }
            }

            if (isset($this->request->post['product_related'])) {
                $products = $this->request->post['product_related'];
            } elseif (isset($this->request->get['product_id'])) {
                $products = $this->model_sellerproduct_product->getProductRelated($this->request->get['product_id']);
            } else {
                $products = array();
            }

            $data['product_relateds'] = array();

            foreach ($products as $product_id) {
                $related_info = $this->model_sellerproduct_product->getProduct($product_id);

                if ($related_info) {
                    $data['product_relateds'][] = array(
                    'product_id' => $related_info['product_id'],
                    'name' => $related_info['name'],
                );
                }
            }

            if (isset($this->request->post['points'])) {
                $data['points'] = $this->request->post['points'];
            } elseif (!empty($product_info)) {
                $data['points'] = $product_info['points'];
            } else {
                $data['points'] = '';
            }

            if (isset($this->request->post['product_reward'])) {
                $data['product_reward'] = $this->request->post['product_reward'];
            } elseif (isset($this->request->get['product_id'])) {
                $data['product_reward'] = $this->model_sellerproduct_product->getProductRewards($this->request->get['product_id']);
            } else {
                $data['product_reward'] = array();
            }

            if (isset($this->request->post['product_layout'])) {
                $data['product_layout'] = $this->request->post['product_layout'];
            } elseif (isset($this->request->get['product_id'])) {
                $data['product_layout'] = $this->model_sellerproduct_product->getProductLayouts($this->request->get['product_id']);
            } else {
                $data['product_layout'] = array();
            }

            $this->load->model('sellerproduct/layout');

            $data['layouts'] = $this->model_sellerproduct_layout->getLayouts();

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');


                $this->response->setOutput($this->load->view('sellerproduct/product_form', $data));

        }
    }

    protected function validateForm()
    {
        //if (!$this->user->hasPermission('modify', 'sellerproduct/product')) {
        //	$this->error['warning'] = $this->language->get('error_permission');
        //}

        foreach ($this->request->post['product_description'] as $language_id => $value) {
            if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
                $this->error['name'][$language_id] = $this->language->get('error_name');
            }

            if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
                $this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
            }
        }

    //	if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
    //		$this->error['model'] = $this->language->get('error_model');
    //	}

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }

    protected function copyProductLimit($selectCount, $product_total)
    {
        $this->load->model('sellerproduct/seller');

        $product_limit = $this->model_sellerproduct_seller->getSellerGroupIdBysellerId();

        if (count($selectCount) > ($product_limit['product_limit'] - $product_total) && $product_limit['product_limit'] != '0') {
            $this->error['warning'] = sprintf($this->language->get('text_copy_product_limit'), $product_limit['product_limit'] - $product_total);
        }

        return !$this->error;
    }

    protected function ProductLimit()
    {
        $this->load->model('sellerproduct/seller');
        $this->load->model('sellerproduct/product');

        $product_limit = $this->model_sellerproduct_seller->getSellerGroupIdBysellerId();
        $product_total = $this->model_sellerproduct_product->getTotalProducts();

        if ($product_total >= $product_limit['product_limit'] && $product_limit['product_limit'] != '0') {
            $this->error['warning'] = sprintf($this->language->get('text_product_limit'), $product_limit['product_limit']);
        }

        return !$this->error;
    }

    public function autocomplete()
    {
        $json = array();

        if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
            $this->load->model('sellerproduct/product');
            $this->load->model('sellerproduct/option');

            if (isset($this->request->get['filter_name'])) {
                $filter_name = $this->request->get['filter_name'];
            } else {
                $filter_name = '';
            }

            if (isset($this->request->get['filter_model'])) {
                $filter_model = $this->request->get['filter_model'];
            } else {
                $filter_model = '';
            }

            if (isset($this->request->get['limit'])) {
                $limit = $this->request->get['limit'];
            } else {
                $limit = 5;
            }

            $filter_data = array(
                'filter_name' => $filter_name,
                'filter_model' => $filter_model,
                'start' => 0,
                'limit' => $limit,
            );

            $results = $this->model_sellerproduct_product->getProducts($filter_data);

            foreach ($results as $result) {
                $option_data = array();

                $product_options = $this->model_sellerproduct_product->getProductOptions($result['product_id']);

                foreach ($product_options as $product_option) {
                    $option_info = $this->model_sellerproduct_option->getOption($product_option['option_id']);

                    if ($option_info) {
                        $product_option_value_data = array();

                        foreach ($product_option['product_option_value'] as $product_option_value) {
                            $option_value_info = $this->model_sellerproduct_option->getOptionValue($product_option_value['option_value_id']);

                            if ($option_value_info) {
                                $product_option_value_data[] = array(
                                    'product_option_value_id' => $product_option_value['product_option_value_id'],
                                    'option_value_id' => $product_option_value['option_value_id'],
                                    'name' => $option_value_info['name'],
                                    'price' => (float) $product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
                                    'price_prefix' => $product_option_value['price_prefix'],
                                );
                            }
                        }

                        $option_data[] = array(
                            'product_option_id' => $product_option['product_option_id'],
                            'product_option_value' => $product_option_value_data,
                            'option_id' => $product_option['option_id'],
                            'name' => $option_info['name'],
                            'type' => $option_info['type'],
                            'value' => $product_option['value'],
                            'required' => $product_option['required'],
                        );
                    }
                }

                $json[] = array(
                    'product_id' => $result['product_id'],
                    'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
                    'model' => $result['model'],
                    'option' => $option_data,
                    'price' => $result['price'],
                );
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function option_autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->language('sellerproduct/option');

			$this->load->model('sellerproduct/option');

			$this->load->model('tool/image');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 5
			);

			$options = $this->model_sellerproduct_option->getOptions($filter_data);

			foreach ($options as $option) {
				$option_value_data = array();

				if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
					$option_values = $this->model_sellerproduct_option->getOptionValues($option['option_id']);

					foreach ($option_values as $option_value) {
						if (is_file(DIR_IMAGE . $option_value['image'])) {
							$image = $this->model_tool_image->resize($option_value['image'], 50, 50);
						} else {
							$image = $this->model_tool_image->resize('no_image.png', 50, 50);
						}

						$option_value_data[] = array(
							'option_value_id' => $option_value['option_value_id'],
							'name'            => strip_tags(html_entity_decode($option_value['name'], ENT_QUOTES, 'UTF-8')),
							'image'           => $image
						);
					}

					$sort_order = array();

					foreach ($option_value_data as $key => $value) {
						$sort_order[$key] = $value['name'];
					}

					array_multisort($sort_order, SORT_ASC, $option_value_data);
				}

				$type = '';

				if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
					$type = $this->language->get('text_choose');
				}

				if ($option['type'] == 'text' || $option['type'] == 'textarea') {
					$type = $this->language->get('text_input');
				}

				if ($option['type'] == 'file') {
					$type = $this->language->get('text_file');
				}

				if ($option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
					$type = $this->language->get('text_date');
				}

				$json[] = array(
					'option_id'    => $option['option_id'],
					'name'         => strip_tags(html_entity_decode($option['name'], ENT_QUOTES, 'UTF-8')),
					'category'     => $type,
					'type'         => $option['type'],
					'option_value' => $option_value_data
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
    public function manufacturer_autocomplete()
    {
        $json = array();

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('sellerproduct/manufacturer');

            $filter_data = array(
                'filter_name' => $this->request->get['filter_name'],
                'start' => 0,
                'limit' => 5,
            );

            $results = $this->model_sellerproduct_manufacturer->getManufacturers($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'manufacturer_id' => $result['manufacturer_id'],
                    'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
                );
            }
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function isbn_autocomplete()
    {
        $json = array();

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('catalog/product');

            $filter_data = array(
                'filter_name' => $this->request->get['filter_name'],
                'start' => 0,
                'limit' => 5,
            );

            /// Get From store

            $results = $this->model_catalog_product->getProducts($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'product_id' => $result['product_id'],
                    'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
                );
            }

            // Get From Google Books
            if (empty($json)) {
                $results = $this->getInfoGoogleBooks($filter_data['filter_name']);

                if (!empty($results)) {
                    $str = preg_replace('/\s+/', '', $results['title']);

                    if (preg_match('/[أ-ي]/ui', $str) || !preg_match('/[^A-Za-z0-9]/', $str)) {
                        $json[] = array(

                    'name' => strip_tags(html_entity_decode($results['title'], ENT_QUOTES, 'UTF-8')),
                    'author' => strip_tags(html_entity_decode($results['authors'], ENT_QUOTES, 'UTF-8')),
                    'pagecount' => strip_tags(html_entity_decode($results['pagecount'], ENT_QUOTES, 'UTF-8')),
                    'publisheddate' => strip_tags(html_entity_decode($results['publisheddate'], ENT_QUOTES, 'UTF-8')),
                );
                    } else {
                        $json = array();
                    }
                }
            }

            // Get From bookdepository
            if (empty($json)) {
                $results = $this->getInfobookdepository($filter_data['filter_name']);

                if (!empty($results)) {
                    $str = preg_replace('/\s+/', '', $results['title']);

                    if (preg_match('/[أ-ي]/ui', $str) || !preg_match('/[^A-Za-z0-9]/', $str)) {
                        $json[] = array(

                    'name' => strip_tags(html_entity_decode($results['title'], ENT_QUOTES, 'UTF-8')),

                    'publisheddate' => strip_tags(html_entity_decode($results['publisheddate'], ENT_QUOTES, 'UTF-8')),
                );
                    } else {
                        $json = array();
                    }
                }
            }
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function category_autocomplete()
    {
        $json = array();

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('sellerproduct/category');
            $this->load->model('sellerproduct/product');

            $filter_data = array(
                'filter_name' => $this->request->get['filter_name'],
                'start' => 0,
                'limit' => 5,
            );

            $categories = $this->model_sellerproduct_product->getSellerGroupCategories($this->customer->getSellerGroupId());

            $sellerCategories = $this->model_sellerproduct_product->getSellerCategories($this->customer->getId(), 1);

            if ($sellerCategories) {
                $results = $this->model_sellerproduct_category->getSellerCategories($filter_data , 1 );
            } else {
                $sellergroupCategories = $this->model_sellerproduct_product->getSellerGroupCategories($this->customer->getSellerGroupId());

                if ($sellergroupCategories) {
                    $results = $this->model_sellerproduct_category->getSellerGroupCategories($filter_data);
                } else {
                    $results = $this->model_sellerproduct_category->getCategories($filter_data);
                }
            }

            foreach ($results as $result) {
                $json[] = array(
                    'category_id' => $result['category_id'],
                    'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
                );
            }
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function attribute_autocomplete()
    {
        $json = array();

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('sellerproduct/product');

            $filter_data = array(
                'filter_name' => $this->request->get['filter_name'],
                'start' => 0,
                'limit' => 5,
            );

            $results = $this->model_sellerproduct_product->getAttributes($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'attribute_id' => $result['attribute_id'],
                    'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
                    'attribute_group' => $result['attribute_group'],
                );
            }
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    protected function getInfoGoogleBooks($isbn)
    {
        $page = file_get_contents('https://www.googleapis.com/books/v1/volumes?q=isbn:'.$isbn);
        $data = json_decode($page, true);
        if (isset($data['items'])) {
            $googlebook = array(
                    'title' => $data['items'][0]['volumeInfo']['title'],
                    'authors' => strip_tags(html_entity_decode(@implode(',', $data['items'][0]['volumeInfo']['authors']), ENT_QUOTES, 'UTF-8')),
                    'pagecount' => $data['items'][0]['volumeInfo']['pageCount'],
                    'publisheddate' => $data['items'][0]['volumeInfo']['publishedDate'].'-01-01',
                );

            return $googlebook;
        } else {
            return '';
        }
    }

    public function download_autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('sellerproduct/download');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_sellerproduct_download->getDownloads($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'download_id' => $result['download_id'],
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

    protected function getInfobookdepository($isbn)
    {
        require_once DIR_SYSTEM.'simple_html_dom.php';

        $html = new simple_html_dom();
        $html = @file_get_html('http://www.bookdepository.com/search?searchTerm='.$isbn);

        if ($html) {
            // Find Book title
foreach ($html->find('div.itemHeading') as $element) {
    if ($element) {
        //   echo $element->children(0)->innertext ;
       $book_title = $element->children(0)->innertext;
    }
}

// Find Book year published
foreach ($html->find('ul.biblio li span[property="dc:available"]') as $element) {
    if ($element) {
        $noTags = strip_tags($element->innertext);
        $published = preg_replace('/\s+/', ' ', $noTags);

        $book_pub = substr($published, 10).'-01-01';
    }
}

            if (isset($book_title)) {
                $bookdepository = array(
                    'title' => $book_title,
                    'publisheddate' => $book_pub,
                );

                return $bookdepository;
            } else {
                return '';
            }
        }
    }
    public function request_approval()
    {


        $json = array();



        $this->load->language('sellerproduct/product');

        $this->load->model('sellerproduct/product');

        if (isset($this->request->get['product_id'])) {
            $product_id = $this->request->get['product_id'];
        } else {
            $product_id = 0;
        }

        $this->model_sellerproduct_product->RequestApproval($product_id);


            $json['success'] = $this->language->get('text_success');



        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
