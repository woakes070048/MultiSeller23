<?php

class Controllersellerprofilesellerprofile extends Controller
{
    private $error = array();

    public function index()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('sellerprofile/sellerprofile', '', 'SSL');

            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->load->model('sellerproduct/seller');

        $this->load->language('sellerprofile/sellerprofile');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sellerprofile/sellerprofile');

        $data['column_seller_group'] = $this->language->get('column_seller_group');
        $data['column_commission'] = $this->language->get('column_commission');
        $data['column_commission_rate'] = $this->language->get('column_commission_rate');
        $data['column_subscription_price'] = $this->language->get('column_subscription_price');
        $data['column_product_limit'] = $this->language->get('column_product_limit');
        $data['column_name'] = $this->language->get('column_name');
        $data['column_subscription_duration'] = $this->language->get('column_subscription_duration');
        $data['column_seller_group_description'] = $this->language->get('column_seller_group_description');
        $data['column_categories'] = $this->language->get('column_categories');
        $data['column_group_categories'] = $this->language->get('column_group_categories');

        $data['column_sort_order'] = $this->language->get('column_sort_order');

        $data['map'] = $this->load->controller('sellerprofile/map');
        $data['chart'] = $this->load->controller('sellerprofile/chart');

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_seller_detail'] = $this->language->get('text_seller_detail');
        $data['text_seller_profile'] = $this->language->get('text_seller_profile');
        $data['entry_seller_avatar'] = $this->language->get('entry_seller_avatar');
        $data['entry_seller_banner'] = $this->language->get('entry_seller_banner');
        $data['entry_all_categories'] = $this->language->get('entry_all_categories');
        $data['text_seller_group_detail'] = $this->language->get('text_seller_group_detail');

        $data['text_form'] = !isset($this->request->get['seller_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_select'] = $this->language->get('text_select');
        $data['text_none'] = $this->language->get('text_none');
        $data['text_loading'] = $this->language->get('text_loading');
        $data['text_add_ban_ip'] = $this->language->get('text_add_ban_ip');
        $data['text_remove_ban_ip'] = $this->language->get('text_remove_ban_ip');
        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_seller_group_commission'] = $this->language->get('entry_seller_group_commission');
        $data['entry_seller_group_commission_rate'] = $this->language->get('entry_seller_group_commission_rate');
        $data['entry_date_created'] = $this->language->get('entry_date_created');
        $data['entry_date_end'] = $this->language->get('entry_date_end');
        $data['entry_seller_group'] = $this->language->get('entry_seller_group');
        $data['entry_firstname'] = $this->language->get('entry_firstname');
        $data['entry_lastname'] = $this->language->get('entry_lastname');
        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_telephone'] = $this->language->get('entry_telephone');
        $data['entry_fax'] = $this->language->get('entry_fax');
        $data['entry_password'] = $this->language->get('entry_password');
        $data['entry_confirm'] = $this->language->get('entry_confirm');
        $data['entry_newsletter'] = $this->language->get('entry_newsletter');
        $data['entry_safe'] = $this->language->get('entry_safe');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_company_id'] = $this->language->get('entry_company_id');
        $data['entry_branch_id'] = $this->language->get('entry_branch_id');
        $data['entry_bank'] = $this->language->get('entry_bank');
        $data['entry_bankaccount_1'] = $this->language->get('entry_bankaccount_1');
        $data['entry_bankaccount_2'] = $this->language->get('entry_bankaccount_2');
        $data['entry_city'] = $this->language->get('entry_city');
        $data['entry_postcode'] = $this->language->get('entry_postcode');
        $data['entry_zone'] = $this->language->get('entry_zone');
        $data['entry_country'] = $this->language->get('entry_country');
        $data['entry_default'] = $this->language->get('entry_default');
        $data['entry_comment'] = $this->language->get('entry_comment');
        $data['entry_description'] = $this->language->get('entry_description');
        $data['entry_amount'] = $this->language->get('entry_amount');
        $data['entry_points'] = $this->language->get('entry_points');
        $data['entry_seller_group_limit'] = $this->language->get('entry_seller_group_limit');
        $data['entry_seller_group_subscription_price'] = $this->language->get('entry_seller_group_subscription_price');
        $data['entry_seller_product_total'] = $this->language->get('entry_seller_product_total');
        $data['entry_seller_product_left'] = $this->language->get('entry_seller_product_left');

        $data['help_safe'] = $this->language->get('help_safe');
        $data['help_points'] = $this->language->get('help_points');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_bankaccount_add'] = $this->language->get('button_bankaccount_add');
        $data['button_history_add'] = $this->language->get('button_history_add');
        $data['button_transaction_add'] = $this->language->get('button_transaction_add');
        $data['button_request_membership_add'] = $this->language->get('button_request_membership_add');
        $data['entry_facebook'] = $this->language->get('entry_facebook');
        $data['entry_website'] = $this->language->get('entry_website');
        $data['entry_twitter'] = $this->language->get('entry_twitter');
        $data['entry_nickname'] = $this->language->get('entry_nickname');
        $data['entry_googleplus'] = $this->language->get('entry_googleplus');
        $data['entry_instagram'] = $this->language->get('entry_instagram');
        $data['button_remove'] = $this->language->get('button_remove');
        $data['button_upload'] = $this->language->get('button_upload');

        $data['tab_dashboard'] = $this->language->get('tab_dashboard');
        $data['tab_bankaccount'] = $this->language->get('tab_bankaccount');
        $data['tab_history'] = $this->language->get('tab_history');
        $data['tab_badge'] = $this->language->get('tab_badge');
        $data['tab_sellerproduct'] = $this->language->get('tab_sellerproduct');
        $data['tab_transaction'] = $this->language->get('tab_transaction');
        $data['tab_request_membership'] = $this->language->get('tab_request_membership');
        $data['tab_more_details'] = $this->language->get('tab_more_details');
        $data['tab_ip'] = $this->language->get('tab_ip');

        if ($this->config->get('config_seller_agree_id')) {
            $this->load->model('catalog/information');

            $information_info = $this->model_catalog_information->getInformation($this->config->get('config_seller_agree_id'));

            if ($information_info) {
                $data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/agree', 'information_id='.$this->config->get('config_seller_agree_id'), 'SSL'), $information_info['title'], $information_info['title']);
            } else {
                $data['text_agree'] = '';
            }
        } else {
            $data['text_agree'] = '';
        }

        if (isset($information_info['title'])) {
            $data['text_seller_agree'] = sprintf($this->language->get('text_seller_agree'), $information_info['title']);
        }

        $this->load->model('sellerprofile/sellerprofile');
        $data['banks'] = $this->model_sellerprofile_sellerprofile->getbankes();

        $data['seller_id'] = $this->customer->getId();

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', '', 'SSL'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sellerprofile/sellerprofile', '', 'SSL'),
        );

        $data['cancel'] = $this->url->link('account/account', '', 'SSL');

        $seller_info = $this->model_sellerprofile_sellerprofile->getseller($this->customer->getId());

        $data['seller_product_total'] = $this->model_sellerprofile_sellerprofile->getTotalProducts();

        $this->load->model('sellerprofile/sellerprofile');

        $data['seller_groups'] = $this->model_sellerprofile_sellerprofile->getSellerGroups();

        if (isset($this->request->post['seller_group_id'])) {
            $data['seller_group_id'] = $this->request->post['seller_group_id'];
        } elseif (!empty($seller_info)) {
            $data['seller_group_id'] = $seller_info['seller_group_id'];
        } else {
            $data['seller_group_id'] = $this->config->get('config_seller_group_id');
        }
        $this->load->model('tool/image');
        if ($this->config->get('config_sellerimageupload')) {
            $data['sellerimageupload'] = '1';
        } else {
            $data['sellerimageupload'] = '0';
        }
        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } elseif (!empty($seller_info)) {
            $data['image'] = $seller_info['image'];
        } else {
            $data['image'] = '';
        }
        if (isset($this->request->post['image']) && is_file(DIR_IMAGE.$this->request->post['image'])) {
            $data['thumb_image'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif (!empty($seller_info) && is_file(DIR_IMAGE.$seller_info['image'])) {
            $data['thumb_image'] = $this->model_tool_image->resize($seller_info['image'], 100, 100);
        } else {
            $data['thumb_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }

        if (isset($this->request->post['banner'])) {
            $data['banner'] = $this->request->post['banner'];
        } elseif (!empty($seller_info)) {
            $data['banner'] = $seller_info['banner'];
        } else {
            $data['banner'] = '';
        }
        if (isset($this->request->post['banner']) && is_file(DIR_IMAGE.$this->request->post['banner'])) {
            $data['thumb_banner'] = $this->model_tool_image->resize($this->request->post['banner'], 100, 100);
        } elseif (!empty($seller_info) && is_file(DIR_IMAGE.$seller_info['banner'])) {
            $data['thumb_banner'] = $this->model_tool_image->resize($seller_info['banner'], 100, 100);
        } else {
            $data['thumb_banner'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }

        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        $data['is_seller'] = $this->customer->isSeller();
        if (isset($this->request->post['seller_group'])) {
            $data['seller_group'] = $this->request->post['seller_group'];
        } elseif (!empty($seller_info)) {


            $this->load->model('sellerproduct/seller');

            $data['is_seller'] = $this->customer->isSeller();

            $data['seller_group'] = $seller_info['name'];
        } else {
            $data['seller_group'] = '';

        }

        if (isset($this->request->post['seller_group_limit'])) {
            $data['seller_group_limit'] = $this->request->post['seller_group_limit'];
        } elseif (!empty($seller_info)) {
            $data['seller_group_limit'] = $seller_info['product_limit'];
        } else {
            $data['seller_group_limit'] = '';
        }
        if (isset($this->request->post['seller_description'])) {
            $data['seller_description'] = $this->request->post['seller_description'];
        } elseif (!empty($seller_info)) {
            $data['seller_description'] = $seller_info['seller_description'];
        } else {
            $data['seller_description'] = '';
        }

        if (isset($this->request->post['facebook'])) {
            $data['facebook'] = $this->request->post['facebook'];
        } elseif (!empty($seller_info)) {
            $data['facebook'] = $seller_info['facebook'];
        } else {
            $data['facebook'] = '';
        }

        if (isset($this->request->post['website'])) {
            $data['website'] = $this->request->post['website'];
        } elseif (!empty($seller_info)) {
            $data['website'] = $seller_info['website'];
        } else {
            $data['website'] = '';
        }

        if (isset($this->request->post['twitter'])) {
            $data['twitter'] = $this->request->post['twitter'];
        } elseif (!empty($seller_info)) {
            $data['twitter'] = $seller_info['twitter'];
        } else {
            $data['twitter'] = '';
        }

        if (isset($this->request->post['nickname'])) {
            $data['nickname'] = $this->request->post['nickname'];
        } elseif (!empty($seller_info)) {
            $data['nickname'] = $seller_info['nickname'];
        } else {
            $data['nickname'] = '';
        }

        if (isset($this->request->post['googleplus'])) {
            $data['googleplus'] = $this->request->post['googleplus'];
        } elseif (!empty($seller_info)) {
            $data['googleplus'] = $seller_info['googleplus'];
        } else {
            $data['googleplus'] = '';
        }

        if (isset($this->request->post['instagram'])) {
            $data['instagram'] = $this->request->post['instagram'];
        } elseif (!empty($seller_info)) {
            $data['instagram'] = $seller_info['instagram'];
        } else {
            $data['instagram'] = '';
        }

        if (isset($this->request->post['seller_group_subscription_price'])) {
            $data['seller_group_subscription_price'] = $this->request->post['seller_group_subscription_price'];
        } elseif (!empty($seller_info)) {
            $data['seller_group_subscription_price'] = $this->currency->format($seller_info['subscription_price'], $this->session->data['currency']);
        } else {
            $data['seller_group_subscription_price'] = '';
        }
        if (isset($this->request->post['commission'])) {
            $data['commission'] = $this->request->post['commission'];
        } elseif (!empty($seller_info)) {
            $data['commission'] = $this->currency->format($seller_info['commission'], $this->session->data['currency']).' + '.$seller_info['fee']."%";
        } else {
            $data['commission'] = '';
        }

        if (isset($this->request->post['firstname'])) {
            $data['firstname'] = $this->request->post['firstname'];
        } elseif (!empty($seller_info)) {
            $data['firstname'] = $seller_info['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if (isset($this->request->post['lastname'])) {
            $data['lastname'] = $this->request->post['lastname'];
        } elseif (!empty($seller_info)) {
            $data['lastname'] = $seller_info['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if (isset($this->request->post['email'])) {
            $data['email'] = $this->request->post['email'];
        } elseif (!empty($seller_info)) {
            $data['email'] = $seller_info['email'];
        } else {
            $data['email'] = '';
        }

        if (isset($this->request->post['telephone'])) {
            $data['telephone'] = $this->request->post['telephone'];
        } elseif (!empty($seller_info)) {
            $data['telephone'] = $seller_info['telephone'];
        } else {
            $data['telephone'] = '';
        }

        if (isset($this->request->post['date'])) {
            $data['date'] = $this->request->post['date'];
        } elseif (!empty($seller_info)) {
            $data['date'] = date($this->language->get('date_format_short'), strtotime($seller_info['seller_date_added']));
        } else {
            $data['date'] = '';
        }

        if (!empty($seller_info) && $seller_info['subscription_duration'] != 0) {
            $data['date_end'] = date($this->language->get('date_format_short'), strtotime('+'.$seller_info['subscription_duration'].'months', strtotime($seller_info['seller_date_added'])));
        } else {
            $data['date_end'] = $this->language->get('text_unlimited');
        }

        $data['text_unlimited'] = $this->language->get('text_unlimited');

        if (isset($this->request->post['bankaccount'])) {
            $data['bankaccounts'] = $this->request->post['bankaccount'];
        } elseif (isset($this->request->get['seller_id'])) {
            $data['bankaccounts'] = $this->model_sellerprofile_sellerprofile->getbankaccounts($this->customer->getId());
        } else {
            $data['bankaccounts'] = array();
        }

        if (isset($this->request->post['bankaccount_id'])) {
            $data['bankaccount_id'] = $this->request->post['bankaccount_id'];
        } elseif (!empty($seller_info)) {
            $data['bankaccount_id'] = $seller_info['bankaccount_id'];
        } else {
            $data['bankaccount_id'] = '';
        }

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        if (isset($this->request->post['seller_group_id'])) {
            $data['seller_group_id'] = $this->request->post['seller_group_id'];
        } else {
            $data['seller_group_id'] = $this->model_sellerprofile_sellerprofile->getSellerGroupId();
        }



        $this->load->model('sellerproduct/seller');

        $data['seller_request'] = $this->model_sellerprofile_sellerprofile->getSellerrequest();
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
            'href' => $this->url->link('common/home', '', 'SSL'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sellerprofile/sellerprofile',  $url, 'SSL'),
        );

        $data['column_commission'] = $this->language->get('column_commission');
        $data['column_commission_rate'] = $this->language->get('column_commission_rate');

        $this->load->model('sellerproduct/category');
        $this->load->model('sellerproduct/product');



        $data['seller_groups'] = array();

        $filter_data = array(
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin'),
        );

        $seller_product_total = $this->model_sellerprofile_sellerprofile->getTotalProducts();

        $results = $this->model_sellerprofile_sellerprofile->getSellerGroups($filter_data);

        foreach ($results as $result) {
            $data['seller_groups'][] = array(
                'seller_group_id' => $result['seller_group_id'],
                'seller_categories' => $this->model_sellerproduct_category->getCategories(''),
                'name' => $result['name'],
                'sort_order' => $result['sort_order'],
                'description' => $result['description'],
                'product_limit' => ($result['product_limit'] != "0") ? $result['product_limit'] :  $this->language->get('text_unlimited') ,
                'text_subscription_duration' => sprintf($this->language->get('text_subscription_duration'), $result['subscription_duration']),
                'subscription_price' => $this->currency->format($result['subscription_price'], $this->session->data['currency']),
                'subscription_duration' => $result['subscription_duration'],
                'commission' => $this->currency->format($result['commission'], $this->session->data['currency']).' + '.$result['fee']."%",
                'categories' => $this->model_sellerproduct_category->getsellergroupCategoriesByGroupId($result['seller_group_id']),



                );
        }
				$data['error_warning_product_limit'] = '';
        if (!empty($seller_info)) {
					if ($seller_info['product_limit'] != 0) {


            if ($seller_product_total >= $seller_info['product_limit']) {
                $data['error_warning_product_limit'] = $this->language->get('warning_product_limit');
            } else {
                $data['error_warning_product_limit'] = '';
            }

						}
        } else {
            $data['error_warning_product_limit'] = '';
        }



        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');

        $data['column_name'] = $this->language->get('column_name');
        $data['column_sort_order'] = $this->language->get('column_sort_order');
        $data['column_product_limit'] = $this->language->get('column_product_limit');
        $data['column_subscription_price'] = $this->language->get('column_subscription_price');
        $data['column_action'] = $this->language->get('column_action');

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

        $data['sort_name'] = $this->url->link('sellerprofile/sellerprofile',  '&sort=cgd.name'.$url, 'SSL');
        $data['sort_sort_order'] = $this->url->link('sellerprofile/sellerprofile',  '&sort=cg.sort_order'.$url, 'SSL');
        $data['sort_product_limit'] = $this->url->link('sellerprofile/sellerprofile',  '&sort=cg.product_limit'.$url, 'SSL');
        $data['sort_subscription_price'] = $this->url->link('sellerprofile/sellerprofile',  '&sort=cg.subscription_price'.$url, 'SSL');

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort='.$this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order='.$this->request->get['order'];
        }

        $data['sort'] = $sort;
        $data['order'] = $order;


            $this->response->setOutput($this->load->view('sellerprofile/sellerprofile_form', $data));

    }

    public function badge()
    {
        $this->load->language('sellerprofile/sellerprofile');

        $this->load->model('sellerprofile/sellerprofile');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['entry_badge'] = $this->language->get('entry_badge');
        $data['text_no_results'] = $this->language->get('text_no_results');

        if (isset($this->request->post['seller_badge'])) {
            $data['seller_badge'] = $this->request->post['seller_badge'];
        } elseif (isset($this->request->get['seller_id'])) {
            $data['seller_badge'] = $this->model_sellerprofile_sellerprofile->getbadgeseller($this->request->get['seller_id']);
        } else {
            $data['seller_badge'] = array($this->config->get('config_badge_id'));
        }

        $data['seller_badge'] = $this->model_sellerprofile_sellerprofile->getbadgeseller($this->customer->getId());

        $data['badges'] = array();

        $results = $this->model_sellerprofile_sellerprofile->getsellerbadges();

        $this->load->model('tool/image');

        foreach ($results as $result) {
            $data['badges'][] = array(
            'badge_id' => $result['badge_id'],
                'title' => $result['title'],
                'image' => (is_file(DIR_IMAGE.$result['image']) ? $this->model_tool_image->resize($result['image'], 40, 40) : $this->model_tool_image->resize('no_image.png', 40, 40)),
            );
        }


            $this->response->setOutput($this->load->view('sellerprofile/sellerprofile_badge', $data));

    }

    public function sellerproduct()
    {
        $this->load->language('sellerproduct/product');
        $this->load->language('sellerprofile/sellerprofile');
        $this->load->model('sellerprofile/sellerprofile');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['entry_sellerproduct'] = $this->language->get('entry_sellerproduct');
        $data['text_no_results'] = $this->language->get('text_no_results');

        $data['button_edit_mode'] = $this->language->get('button_edit_mode');
        $data['column_image'] = $this->language->get('column_image');
        $data['column_name'] = $this->language->get('column_name');
        $data['column_price'] = $this->language->get('column_price');
        $data['column_quantity'] = $this->language->get('column_quantity');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_action'] = $this->language->get('column_action');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->post['sellerprofile_sellerprofileproduct'])) {
            $data['sellerprofile_sellerprofileproduct'] = $this->request->post['sellerprofile_sellerprofileproduct'];
        } elseif (isset($this->request->get['seller_id'])) {
            $data['sellerprofile_sellerprofileproduct'] = $this->model_sellerprofile_sellerprofile->getsellerproducts($this->request->get['seller_id']);
        } else {
            $data['sellerprofile_sellerprofileproduct'] = array($this->config->get('config_sellerproduct_id'));
        }

        $data['edit'] = $this->url->link('sellerproduct/product', '', 'SSL');

        $data['products'] = array();

        $this->load->model('tool/image');
        $this->load->model('sellerproduct/product');


        $results = $this->model_sellerprofile_sellerprofile->getProducts(($page - 1) * 10, 10);

        foreach ($results as $result) {
            if (is_file(DIR_IMAGE.$result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('no_image.png', 40, 40);
            }

            $special = false;

            $product_specials = $this->model_sellerproduct_product->getProductSpecials($result['product_id']);

            foreach ($product_specials  as $product_special) {
                if (($product_special['date_start'] == '0000-00-00' || strtotime($product_special['date_start']) < time()) && ($product_special['date_end'] == '0000-00-00' || strtotime($product_special['date_end']) > time())) {
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
                'status' => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
        );
        }

        $product_total = $this->model_sellerprofile_sellerprofile->getTotalProducts();

        $pagination = new Pagination();
        $pagination->total = $product_total;
        $pagination->page = $page;
        $pagination->limit = 10;
        $pagination->url = $this->url->link('sellerprofile/sellerprofile/sellerproduct', 'seller_id='.$this->request->get['seller_id'].'&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($product_total - 10)) ? $product_total : ((($page - 1) * 10) + 10), $product_total, ceil($product_total / 10));


            $this->response->setOutput($this->load->view('sellerprofile/sellerprofile_sellerproduct', $data));

    }

    public function history()
    {
        $this->load->language('sellerprofile/sellerprofile');

        $this->load->model('sellerprofile/sellerprofile');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['text_no_results'] = $this->language->get('text_no_results');

        $data['column_date_added'] = $this->language->get('column_date_added');
        $data['column_comment'] = $this->language->get('column_comment');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $data['histories'] = array();

        $results = $this->model_sellerprofile_sellerprofile->getHistories($this->request->get['seller_id'], ($page - 1) * 10, 10);

        foreach ($results as $result) {
            $data['histories'][] = array(
                'comment' => $result['comment'],
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
            );
        }

        $history_total = $this->model_sellerprofile_sellerprofile->getTotalHistories($this->request->get['seller_id']);

        $pagination = new Pagination();
        $pagination->total = $history_total;
        $pagination->page = $page;
        $pagination->limit = 10;
        $pagination->url = $this->url->link('sellerprofile/sellerprofile/history', '&seller_id='.$this->request->get['seller_id'].'&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($history_total - 10)) ? $history_total : ((($page - 1) * 10) + 10), $history_total, ceil($history_total / 10));


        $this->response->setOutput($this->load->view('sellerprofile/sellerprofile_history', $data));

    }

    public function transaction()
    {
        $this->load->language('sellerprofile/sellerprofile');

        $this->load->model('sellerprofile/sellerprofile');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->user->hasPermission('modify', 'sellerprofile/sellerprofile')) {
            $this->model_sellerprofile_sellerprofile->addTransaction($this->request->get['seller_id'], $this->request->post['description'], $this->request->post['amount']);

            $data['success'] = $this->language->get('text_success');
        } else {
            $data['success'] = '';
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && !$this->user->hasPermission('modify', 'sellerprofile/sellerprofile')) {
            $data['error_warning'] = $this->language->get('error_permission');
        } else {
            $data['error_warning'] = '';
        }

        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_balance'] = $this->language->get('text_balance');
        $data['text_commission'] = $this->language->get('text_commission');
        $data['text_subscription_price'] = $this->language->get('text_subscription_price');
        $data['text_total'] = $this->language->get('text_total');
        $data['text_amount'] = $this->language->get('text_amount');

        $data['column_date_added'] = $this->language->get('column_date_added');
        $data['column_description'] = $this->language->get('column_description');
        $data['column_amount'] = $this->language->get('column_amount');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $data['transactions'] = array();

        $results = $this->model_sellerprofile_sellerprofile->getTransactions($this->request->get['seller_id'], ($page - 1) * 10, 10);

        foreach ($results as $result) {
            $data['transactions'][] = array(
                'amount' => $this->currency->format($result['amount'], $this->session->data['currency']),
                'description' => $result['description'],
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
            );
        }

        $data['balance'] = $this->currency->format($this->model_sellerprofile_sellerprofile->getTransactionTotal($this->request->get['seller_id']), $this->session->data['currency']);
        $balance = $this->model_sellerprofile_sellerprofile->getTransactionTotal($this->request->get['seller_id']);

        $seller_info = $this->model_sellerprofile_sellerprofile->getseller($this->customer->getId());
        if($seller_info){


        $commission = $seller_info['commission'];
        $fee = $seller_info['fee'];

        $data['commissions'] = $this->currency->format($seller_info['commission'], $this->session->data['currency']).' + '.($balance * $fee / 100)."%";
        $data['commission'] = $this->currency->format($seller_info['commission'], $this->session->data['currency']);
        $data['fee'] = $seller_info['fee'];

        $data['total'] = $this->currency->format($balance - $commission - ($balance * $fee / 100), $this->session->data['currency']);
}
        $transaction_total = $this->model_sellerprofile_sellerprofile->getTotalTransactions($this->request->get['seller_id']);

        $pagination = new Pagination();
        $pagination->total = $transaction_total;
        $pagination->page = $page;
        $pagination->limit = 10;
        $pagination->url = $this->url->link('sellerprofile/sellerprofile/transaction', '&seller_id='.$this->request->get['seller_id'].'&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($transaction_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($transaction_total - 10)) ? $transaction_total : ((($page - 1) * 10) + 10), $transaction_total, ceil($transaction_total / 10));


            $this->response->setOutput($this->load->view('sellerprofile/sellerprofile_transaction', $data));

    }

    public function request_membership()
    {
        $this->load->language('sellerprofile/sellerprofile');

        $this->load->model('sellerprofile/sellerprofile');
        $data['text_request_message'] = $this->language->get('text_request_message');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->model_sellerprofile_sellerprofile->addrequest_membership($this->request->get['seller_id'], $this->request->post);
            $this->model_sellerprofile_sellerprofile->addHistory($this->request->get['seller_id'], sprintf($this->language->get('text_request_message'), $this->request->post['seller_group_name']));

            // Add to activity log
            $this->load->model('account/activity');

            $activity_data = array(
                'customer_id' => $this->customer->getId(),
                'name' => $this->customer->getFirstName().' '.$this->customer->getLastName(),
            );

            $this->model_account_activity->addActivity('request_add', $activity_data);

            $data['success'] = $this->language->get('text_success');
        } else {
            $data['success'] = '';
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $data['error_warning'] = $this->language->get('error_permission');
        } else {
            $data['error_warning'] = '';
        }

        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_balance'] = $this->language->get('text_balance');
        $data['text_not_seller'] = $this->language->get('text_not_seller');
        $data['text_request'] = $this->language->get('text_request');
        $data['text_seller_no_approved'] = $this->language->get('text_seller_no_approved');
        $data['text_seller'] = $this->language->get('text_seller');
        $data['text_seller_change_group'] = $this->language->get('text_seller_change_group');
        $data['seller_request'] = $this->model_sellerprofile_sellerprofile->getSellerrequest();


            $this->response->setOutput($this->load->view('sellerprofile/sellerprofile_request_membership', $data));

    }

    public function cancelrequest()
    {
        $this->load->language('sellerprofile/sellerprofile');
        $this->load->model('sellerprofile/sellerprofile');

        $json = array();

        $customer_info = $this->model_sellerprofile_sellerprofile->CancelRequest();

        if (!$customer_info) {
            $json['error'] = $this->language->get('error_permission');
        }

        if (!$json) {
            $this->model_sellerprofile_sellerprofile->addHistory($this->customer->getID(), $this->language->get('text_cancel_request'));

            $subject = sprintf($this->language->get('text_cancel_request'), $this->config->get('config_name'));

            $message = sprintf($this->language->get('text_cancel_request'), $this->config->get('config_name'))."\n\n";
            $message .= $this->language->get('text_thanks')."\n";
            $message .= $this->config->get('config_name');

            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
            $mail->smtp_username = $this->config->get('config_mail_smtp_username');
            $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
            $mail->smtp_port = $this->config->get('config_mail_smtp_port');
            $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
            $mail->setTo($this->customer->getEmail());
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($this->config->get('config_name'));
            $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
            $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
            $mail->send();

            $json['success'] = $this->language->get('text_resend_success');
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function autocomplete()
    {
        $json = array();

        if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_email'])) {
            if (isset($this->request->get['filter_name'])) {
                $filter_name = $this->request->get['filter_name'];
            } else {
                $filter_name = '';
            }

            if (isset($this->request->get['filter_email'])) {
                $filter_email = $this->request->get['filter_email'];
            } else {
                $filter_email = '';
            }

            $this->load->model('sellerprofile/sellerprofile');

            $filter_data = array(
                'filter_name' => $filter_name,
                'filter_email' => $filter_email,
                'start' => 0,
                'limit' => 5,
            );

            $results = $this->model_sellerprofile_sellerprofile->getsellers($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'seller_id' => $result['seller_id'],
                    'seller_group_id' => $result['seller_group_id'],
                    'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
                    'seller_group' => $result['seller_group'],
                    'firstname' => $result['firstname'],
                    'lastname' => $result['lastname'],
                    'email' => $result['email'],
                    'telephone' => $result['telephone'],
                    'fax' => $result['fax'],
                    'custom_field' => unserialize($result['custom_field']),
                    'bankaccount' => $this->model_sellerprofile_sellerprofile->getbankaccounts($result['seller_id']),
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

    public function bankaccount()
    {
        $json = array();

        if (!empty($this->request->get['bankaccount_id'])) {
            $this->load->model('sellerprofile/sellerprofile');

            $json = $this->model_sellerprofile_sellerprofile->getbankaccount($this->request->get['bankaccount_id']);
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }



    public function seller_delete_image()
    {
        $this->load->language('sellerprofile/sellerprofile');

        $this->load->model('sellerprofile/sellerprofile');
        $data['text_request_message'] = $this->language->get('text_request_message');

        $json = array();

        if ($this->request->get['seller_image']) {
            $this->model_sellerprofile_sellerprofile->Sellerdeleteimage();

                // Add to activity log
            $this->load->model('account/activity');

            $activity_data = array(
                'customer_id' => $this->customer->getId(),
                'name' => $this->customer->getFirstName().' '.$this->customer->getLastName(),
            );

            $this->model_account_activity->addActivity('image_add', $activity_data);

            $json['success'] = $this->language->get('text_delete_image_success');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function seller_delete_banner()
    {
        $this->load->language('sellerprofile/sellerprofile');

        $this->load->model('sellerprofile/sellerprofile');
        $data['text_request_message'] = $this->language->get('text_request_message');

        $json = array();

        if ($this->request->get['seller_banner']) {
            $this->model_sellerprofile_sellerprofile->Sellerdeletebanner();

                // Add to activity log
            $this->load->model('account/activity');

            $activity_data = array(
                'customer_id' => $this->customer->getId(),
                'name' => $this->customer->getFirstName().' '.$this->customer->getLastName(),
            );

            $this->model_account_activity->addActivity('banner_add', $activity_data);

            $json['success'] = $this->language->get('text_delete_banner_success');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function profile()
    {
        $this->load->language('sellerprofile/sellerprofile');

        $this->load->model('sellerprofile/sellerprofile');
        $data['text_request_message'] = $this->language->get('text_request_message');

        $json = array();

        $this->model_sellerprofile_sellerprofile->SellerProfileSave($this->request->get);

                // Add to activity log
      $this->load->model('account/activity');

        $activity_data = array(
                'customer_id' => $this->customer->getId(),
                'name' => $this->customer->getFirstName().' '.$this->customer->getLastName(),
            );

        $this->model_account_activity->addActivity('profile_update', $activity_data);

        $json['success'] = $this->language->get('text_update_profile_success');

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
