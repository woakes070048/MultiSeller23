<?php

class ControllerSellersellerGroup extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('seller/seller_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('seller/seller_group');

        $this->getList();
    }

    public function add()
    {
        $this->load->language('seller/seller_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('seller/seller_group');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_seller_seller_group->addsellerGroup($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort='.$this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order='.$this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page='.$this->request->get['page'];
            }

            $this->response->redirect($this->url->link('seller/seller_group', 'token='.$this->session->data['token'].$url, 'SSL'));
        }

        $this->getForm();
    }

    public function edit()
    {
        $this->load->language('seller/seller_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('seller/seller_group');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_seller_seller_group->editsellerGroup($this->request->get['seller_group_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort='.$this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order='.$this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page='.$this->request->get['page'];
            }

            $this->response->redirect($this->url->link('seller/seller_group', 'token='.$this->session->data['token'].$url, 'SSL'));
        }

        $this->getForm();
    }

    public function delete()
    {
        $this->load->language('seller/seller_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('seller/seller_group');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $seller_group_id) {
                $this->model_seller_seller_group->deletesellerGroup($seller_group_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort='.$this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order='.$this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page='.$this->request->get['page'];
            }

            $this->response->redirect($this->url->link('seller/seller_group', 'token='.$this->session->data['token'].$url, 'SSL'));
        }

        $this->getList();
    }

    protected function getList()
    {
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'cgd.name';
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
            'href' => $this->url->link('common/dashboard', 'token='.$this->session->data['token'], 'SSL'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('seller/seller_group', 'token='.$this->session->data['token'].$url, 'SSL'),
        );

        $data['insert'] = $this->url->link('seller/seller_group/add', 'token='.$this->session->data['token'].$url, 'SSL');
        $data['delete'] = $this->url->link('seller/seller_group/delete', 'token='.$this->session->data['token'].$url, 'SSL');

        $data['seller_groups'] = array();

        $filter_data = array(
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin'),
        );

        $seller_group_total = $this->model_seller_seller_group->getTotalsellerGroups();

        $results = $this->model_seller_seller_group->getsellerGroups($filter_data);

        foreach ($results as $result) {
            $data['seller_groups'][] = array(
                'seller_group_id' => $result['seller_group_id'],
                'name' => $result['name'].(($result['seller_group_id'] == $this->config->get('config_seller_group_id')) ? $this->language->get('text_default') : null),
                'sort_order' => $result['sort_order'],
                'subscription_duration' => $result['subscription_duration'],
                'product_limit' => $result['product_limit'],
                'status' => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
                'product_status' => ($result['product_status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
                'subscription_price' => $result['subscription_price'],
                'edit' => $this->url->link('seller/seller_group/edit', 'token='.$this->session->data['token'].'&seller_group_id='.$result['seller_group_id'].$url, 'SSL'),
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');

        $data['column_name'] = $this->language->get('column_name');
        $data['column_sort_order'] = $this->language->get('column_sort_order');
        $data['column_subscription_duration'] = $this->language->get('column_subscription_duration');
        $data['column_product_limit'] = $this->language->get('column_product_limit');
        $data['column_subscription_price'] = $this->language->get('column_subscription_price');
        $data['column_action'] = $this->language->get('column_action');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_product_status'] = $this->language->get('column_product_status');
        $data['button_add'] = $this->language->get('button_add');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');

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

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page='.$this->request->get['page'];
        }

        $data['sort_name'] = $this->url->link('seller/seller_group', 'token='.$this->session->data['token'].'&sort=cgd.name'.$url, 'SSL');
        $data['sort_sort_order'] = $this->url->link('seller/seller_group', 'token='.$this->session->data['token'].'&sort=cg.sort_order'.$url, 'SSL');
        $data['sort_status'] = $this->url->link('seller/seller_group', 'token='.$this->session->data['token'].'&sort=cg.status'.$url, 'SSL');
        $data['sort_product_status'] = $this->url->link('seller/seller_group', 'token='.$this->session->data['token'].'&sort=cg.product_status'.$url, 'SSL');
        $data['sort_subscription_duration'] = $this->url->link('seller/seller_group', 'token='.$this->session->data['token'].'&sort=cg.subscription_duration'.$url, 'SSL');
        $data['sort_product_limit'] = $this->url->link('seller/seller_group', 'token='.$this->session->data['token'].'&sort=cg.product_limit'.$url, 'SSL');
        $data['sort_subscription_price'] = $this->url->link('seller/seller_group', 'token='.$this->session->data['token'].'&sort=cg.subscription_price'.$url, 'SSL');

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort='.$this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order='.$this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $seller_group_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('seller/seller_group', 'token='.$this->session->data['token'].$url.'&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($seller_group_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($seller_group_total - $this->config->get('config_limit_admin'))) ? $seller_group_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $seller_group_total, ceil($seller_group_total / $this->config->get('config_limit_admin')));

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('seller/seller_group_list.tpl', $data));
    }

    protected function getForm()
    {
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = !isset($this->request->get['seller_group_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['help_category'] = $this->language->get('help_category');
        $data['entry_category'] = $this->language->get('entry_category');
        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_description'] = $this->language->get('entry_description');
        $data['text_no_commissions'] = $this->language->get('text_no_commissions');
        $data['entry_commission'] = $this->language->get('entry_commission');
        $data['entry_subscription_duration'] = $this->language->get('entry_subscription_duration');
        $data['entry_product_limit'] = $this->language->get('entry_product_limit');
        $data['entry_subscription_price'] = $this->language->get('entry_subscription_price');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['help_status'] = $this->language->get('help_status');
        $data['entry_product_status'] = $this->language->get('entry_product_status');
        $data['help_product_status'] = $this->language->get('help_product_status');

        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

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

        $url = '';

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
            'href' => $this->url->link('common/dashboard', 'token='.$this->session->data['token'], 'SSL'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('seller/seller_group', 'token='.$this->session->data['token'].$url, 'SSL'),
        );

        if (!isset($this->request->get['seller_group_id'])) {
            $data['action'] = $this->url->link('seller/seller_group/add', 'token='.$this->session->data['token'].$url, 'SSL');
        } else {
            $data['action'] = $this->url->link('seller/seller_group/edit', 'token='.$this->session->data['token'].'&seller_group_id='.$this->request->get['seller_group_id'].$url, 'SSL');
        }

        $data['cancel'] = $this->url->link('seller/seller_group', 'token='.$this->session->data['token'].$url, 'SSL');

        if (isset($this->request->get['seller_group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $seller_group_info = $this->model_seller_seller_group->getsellerGroup($this->request->get['seller_group_id']);
        }

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->request->post['seller_group_description'])) {
            $data['seller_group_description'] = $this->request->post['seller_group_description'];
        } elseif (isset($this->request->get['seller_group_id'])) {
            $data['seller_group_description'] = $this->model_seller_seller_group->getsellerGroupDescriptions($this->request->get['seller_group_id']);
        } else {
            $data['seller_group_description'] = array();
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($seller_group_info)) {
            $data['status'] = $seller_group_info['status'];
        } else {
            $data['status'] = true;
        }

        if (isset($this->request->post['product_status'])) {
          $data['product_status'] = $this->request->post['product_status'];
      } elseif (!empty($seller_group_info)) {
          $data['product_status'] = $seller_group_info['product_status'];
      } else {
          $data['product_status'] = true;
      }

        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($seller_group_info)) {
            $data['sort_order'] = $seller_group_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }

        if (isset($this->request->post['subscription_duration'])) {
            $data['subscription_duration'] = $this->request->post['subscription_duration'];
        } elseif (!empty($seller_group_info)) {
            $data['subscription_duration'] = $seller_group_info['subscription_duration'];
        } else {
            $data['subscription_duration'] = '';
        }

        if (isset($this->request->post['product_limit'])) {
            $data['product_limit'] = $this->request->post['product_limit'];
        } elseif (!empty($seller_group_info)) {
            $data['product_limit'] = $seller_group_info['product_limit'];
        } else {
            $data['product_limit'] = '';
        }

        if (isset($this->request->post['subscription_price'])) {
            $data['subscription_price'] = $this->request->post['subscription_price'];
        } elseif (!empty($seller_group_info)) {
            $data['subscription_price'] = $seller_group_info['subscription_price'];
        } else {
            $data['subscription_price'] = '';
        }

        if (isset($this->request->post['commission'])) {
            $data['commission'] = $this->request->post['commission'];
        } elseif (!empty($seller_group_info)) {
            $data['commission'] = $seller_group_info['commission'];
        } else {
            $data['commission'] = '';
        }

        if (isset($this->request->post['fee'])) {
            $data['fee'] = $this->request->post['fee'];
        } elseif (!empty($seller_group_info)) {
            $data['fee'] = $seller_group_info['fee'];
        } else {
            $data['fee'] = '';
        }



        $data['token'] = $this->session->data['token'];

        // Categories
        $this->load->model('seller/seller_group');
        $this->load->model('catalog/category');

        if (isset($this->request->post['seller_group_category'])) {
            $categories = $this->request->post['seller_group_category'];
        } elseif (isset($this->request->get['seller_group_id'])) {
            $categories = $this->model_seller_seller_group->getsellergroupCategories($this->request->get['seller_group_id']);
        } else {
            $categories = array();
        }

        $data['seller_group_categories'] = array();

        foreach ($categories as $category_id) {
            $category_info = $this->model_catalog_category->getCategory($category_id);

            if ($category_info) {
                $data['seller_group_categories'][] = array(
                    'category_id' => $category_info['category_id'],
                    'name' => ($category_info['path']) ? $category_info['path'].' &gt; '.$category_info['name'] : $category_info['name'],
                );
            }
        }


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('seller/seller_group_form.tpl', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'seller/seller_group')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        foreach ($this->request->post['seller_group_description'] as $language_id => $value) {
            if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 32)) {
                $this->error['name'][$language_id] = $this->language->get('error_name');
            }
        }

        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'seller/seller_group')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $this->load->model('setting/store');
        $this->load->model('seller/seller');

        foreach ($this->request->post['selected'] as $seller_group_id) {
            if ($this->config->get('config_seller_group_id') == $seller_group_id) {
                $this->error['warning'] = $this->language->get('error_default');
            }

            $store_total = $this->model_seller_seller_group->getTotalStoresBysellerGroupId($seller_group_id);

            if ($store_total) {
                $this->error['warning'] = sprintf($this->language->get('error_store'), $store_total);
            }

            $seller_total = $this->model_seller_seller->getTotalsellersBysellerGroupId($seller_group_id);

            if ($seller_total) {
                $this->error['warning'] = sprintf($this->language->get('error_seller'), $seller_total);
            }
        }

        return !$this->error;
    }
}
