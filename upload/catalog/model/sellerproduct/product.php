<?php

class ModelsellerproductProduct extends Model
{
    public function addProduct($data)
    {

      if($this->customer->getSellerGroupProductStatus()){
        $product_status = $data['status'];
      }elseif($this->customer->getSellerProductStatus()){
        $product_status = $data['status'];
      }else{
        $product_status = '0';
      }


        $this->db->query('INSERT INTO '.DB_PREFIX."product SET model = '".$this->db->escape($data['model'])."', sku = '".$this->db->escape($data['sku'])."', upc = '".$this->db->escape($data['upc'])."', ean = '".$this->db->escape($data['ean'])."', jan = '".$this->db->escape($data['jan'])."', isbn = '".$this->db->escape($data['isbn'])."', mpn = '".$this->db->escape($data['mpn'])."', location = '".$this->db->escape($data['location'])."', quantity = '".(int) $data['quantity']."', minimum = '".(int) $data['minimum']."', subtract = '".(int) $data['subtract']."', stock_status_id = '".(int) $data['stock_status_id']."', date_available = '".$this->db->escape($data['date_available'])."', manufacturer_id = '".(int) $data['manufacturer_id']."', shipping = '".(int) $data['shipping']."', price = '".(float) $data['price']."', points = '".(int) $data['points']."', weight = '".(float) $data['weight']."', weight_class_id = '".(int) $data['weight_class_id']."', length = '".(float) $data['length']."', width = '".(float) $data['width']."', height = '".(float) $data['height']."', length_class_id = '".(int) $data['length_class_id']."', status = '".(int) $product_status."', tax_class_id = '".$this->db->escape($data['tax_class_id'])."', sort_order = '".(int) $data['sort_order']."', date_added = NOW()");

        $product_id = $this->db->getLastId();

        $this->db->query('INSERT INTO '.DB_PREFIX."product_to_seller SET product_id = '".$product_id."' ,seller_id = '".$this->customer->getID()."'");

        if (isset($data['image'])) {
            $this->db->query('UPDATE '.DB_PREFIX."product SET image = '".$this->db->escape($data['image'])."' WHERE product_id = '".(int) $product_id."'");
        }

        foreach ($data['product_description'] as $language_id => $value) {
            $this->db->query('INSERT INTO '.DB_PREFIX."product_description SET product_id = '".(int) $product_id."', language_id = '".(int) $language_id."', name = '".$this->db->escape($value['name'])."', description = '".$this->db->escape($value['description'])."', tag = '".$this->db->escape($value['tag'])."', meta_title = '".$this->db->escape($value['meta_title'])."', meta_description = '".$this->db->escape($value['meta_description'])."', meta_keyword = '".$this->db->escape($value['meta_keyword'])."'");
        }

        if (isset($data['product_store'])) {
            foreach ($data['product_store'] as $store_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_to_store SET product_id = '".(int) $product_id."', store_id = '".(int) $store_id."'");
            }
        }

        if (isset($data['product_attribute'])) {
            foreach ($data['product_attribute'] as $product_attribute) {
                if ($product_attribute['attribute_id']) {
                    $this->db->query('DELETE FROM '.DB_PREFIX."product_attribute WHERE product_id = '".(int) $product_id."' AND attribute_id = '".(int) $product_attribute['attribute_id']."'");

                    foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
                        $this->db->query('INSERT INTO '.DB_PREFIX."product_attribute SET product_id = '".(int) $product_id."', attribute_id = '".(int) $product_attribute['attribute_id']."', language_id = '".(int) $language_id."', text = '".$this->db->escape($product_attribute_description['text'])."'");
                    }
                }
            }
        }

        if (isset($data['product_option'])) {
            foreach ($data['product_option'] as $product_option) {
                if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                    if (isset($product_option['product_option_value'])) {
                        $this->db->query('INSERT INTO '.DB_PREFIX."product_option SET product_id = '".(int) $product_id."', option_id = '".(int) $product_option['option_id']."', required = '".(int) $product_option['required']."'");

                        $product_option_id = $this->db->getLastId();

                        foreach ($product_option['product_option_value'] as $product_option_value) {
                            $this->db->query('INSERT INTO '.DB_PREFIX."product_option_value SET product_option_id = '".(int) $product_option_id."', product_id = '".(int) $product_id."', option_id = '".(int) $product_option['option_id']."', option_value_id = '".(int) $product_option_value['option_value_id']."', quantity = '".(int) $product_option_value['quantity']."', subtract = '".(int) $product_option_value['subtract']."', price = '".(float) $product_option_value['price']."', price_prefix = '".$this->db->escape($product_option_value['price_prefix'])."', points = '".(int) $product_option_value['points']."', points_prefix = '".$this->db->escape($product_option_value['points_prefix'])."', weight = '".(float) $product_option_value['weight']."', weight_prefix = '".$this->db->escape($product_option_value['weight_prefix'])."'");
                        }
                    }
                } else {
                    $this->db->query('INSERT INTO '.DB_PREFIX."product_option SET product_id = '".(int) $product_id."', option_id = '".(int) $product_option['option_id']."', value = '".$this->db->escape($product_option['value'])."', required = '".(int) $product_option['required']."'");
                }
            }
        }

        if (isset($data['product_discount'])) {
            foreach ($data['product_discount'] as $product_discount) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_discount SET product_id = '".(int) $product_id."', customer_group_id = '".(int) $product_discount['customer_group_id']."', quantity = '".(int) $product_discount['quantity']."', priority = '".(int) $product_discount['priority']."', price = '".(float) $product_discount['price']."', date_start = '".$this->db->escape($product_discount['date_start'])."', date_end = '".$this->db->escape($product_discount['date_end'])."'");
            }
        }

        if (isset($data['product_special'])) {
            foreach ($data['product_special'] as $product_special) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_special SET product_id = '".(int) $product_id."', customer_group_id = '".(int) $product_special['customer_group_id']."', priority = '".(int) $product_special['priority']."', price = '".(float) $product_special['price']."', date_start = '".$this->db->escape($product_special['date_start'])."', date_end = '".$this->db->escape($product_special['date_end'])."'");
            }
        }

        if (isset($data['product_image'])) {
            foreach ($data['product_image'] as $product_image) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_image SET product_id = '".(int) $product_id."', image = '".$this->db->escape($product_image['image'])."', sort_order = '".(int) $product_image['sort_order']."'");
            }
        }

        if (isset($data['product_download'])) {
            foreach ($data['product_download'] as $download_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_to_download SET product_id = '".(int) $product_id."', download_id = '".(int) $download_id."'");
            }
        }

        if (isset($data['product_category'])) {
            foreach ($data['product_category'] as $category_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_to_category SET product_id = '".(int) $product_id."', category_id = '".(int) $category_id."'");
            }
        }

        if (isset($data['product_filter'])) {
            foreach ($data['product_filter'] as $filter_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_filter SET product_id = '".(int) $product_id."', filter_id = '".(int) $filter_id."'");
            }
        }

        if (isset($data['product_related'])) {
            foreach ($data['product_related'] as $related_id) {
                $this->db->query('DELETE FROM '.DB_PREFIX."product_related WHERE product_id = '".(int) $product_id."' AND related_id = '".(int) $related_id."'");
                $this->db->query('INSERT INTO '.DB_PREFIX."product_related SET product_id = '".(int) $product_id."', related_id = '".(int) $related_id."'");
                $this->db->query('DELETE FROM '.DB_PREFIX."product_related WHERE product_id = '".(int) $related_id."' AND related_id = '".(int) $product_id."'");
                $this->db->query('INSERT INTO '.DB_PREFIX."product_related SET product_id = '".(int) $related_id."', related_id = '".(int) $product_id."'");
            }
        }

        if (isset($data['product_reward'])) {
            foreach ($data['product_reward'] as $customer_group_id => $product_reward) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_reward SET product_id = '".(int) $product_id."', customer_group_id = '".(int) $customer_group_id."', points = '".(int) $product_reward['points']."'");
            }
        }

        if (isset($data['product_layout'])) {
            foreach ($data['product_layout'] as $store_id => $layout_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_to_layout SET product_id = '".(int) $product_id."', store_id = '".(int) $store_id."', layout_id = '".(int) $layout_id."'");
            }
        }

        if (isset($data['keyword'])) {
            $this->db->query('INSERT INTO '.DB_PREFIX."url_alias SET query = 'product_id=".(int) $product_id."', keyword = '".$this->db->escape($data['keyword'])."'");
        }

        if (isset($data['product_recurrings'])) {
            foreach ($data['product_recurrings'] as $recurring) {
                $this->db->query('INSERT INTO `'.DB_PREFIX.'product_recurring` SET `product_id` = '.(int) $product_id.', customer_group_id = '.(int) $recurring['customer_group_id'].', `recurring_id` = '.(int) $recurring['recurring_id']);
            }
        }

        $this->cache->delete('product');



if($this->config->get('config_seller_add_product_alert')){
        // Sent to admin email
        $message = $this->language->get('text_firstname').' '.$this->customer->getFirstName()."\n";
        $message .= $this->language->get('text_lastname').' '.$this->customer->getLastName()."\n";
        $message .= $this->language->get('text_email').' '.$this->customer->getEmail()."\n";
        $message .= $this->language->get('text_telephone').' '.$this->customer->getTelephone()."\n";



        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
        $mail->smtp_username = $this->config->get('config_mail_smtp_username');
        $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
        $mail->smtp_port = $this->config->get('config_mail_smtp_port');
        $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
        $mail->setTo($this->config->get('config_email'));
        $mail->setFrom($this->customer->getEmail());
        $mail->setSender($this->customer->getFirstName().' '.$this->customer->getLastName());
        $mail->setSubject(html_entity_decode(sprintf($this->language->get('text_seller_add_product'), ''), ENT_QUOTES, 'UTF-8'));
        $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
        $mail->send();
      }
        return $product_id;
    }

    public function editProduct($product_id, $data)
    {
      if($this->customer->getSellerGroupProductStatus()){
        $product_status = $data['status'];
      }elseif($this->customer->getSellerProductStatus()){
        $product_status = $data['status'];
      }else{
        $product_status = '0';
      }



        $this->db->query('UPDATE '.DB_PREFIX."product SET model = '".$this->db->escape($data['model'])."', sku = '".$this->db->escape($data['sku'])."', upc = '".$this->db->escape($data['upc'])."', ean = '".$this->db->escape($data['ean'])."', jan = '".$this->db->escape($data['jan'])."', isbn = '".$this->db->escape($data['isbn'])."', mpn = '".$this->db->escape($data['mpn'])."', location = '".$this->db->escape($data['location'])."', quantity = '".(int) $data['quantity']."', minimum = '".(int) $data['minimum']."', subtract = '".(int) $data['subtract']."', stock_status_id = '".(int) $data['stock_status_id']."', date_available = '".$this->db->escape($data['date_available'])."', manufacturer_id = '".(int) $data['manufacturer_id']."', shipping = '".(int) $data['shipping']."', price = '".(float) $data['price']."', points = '".(int) $data['points']."', weight = '".(float) $data['weight']."', weight_class_id = '".(int) $data['weight_class_id']."', length = '".(float) $data['length']."', width = '".(float) $data['width']."', height = '".(float) $data['height']."', length_class_id = '".(int) $data['length_class_id']."', status = '".(int) $product_status."', tax_class_id = '".$this->db->escape($data['tax_class_id'])."', sort_order = '".(int) $data['sort_order']."', date_modified = NOW() WHERE product_id = '".(int) $product_id."'");

        if (isset($data['image'])) {
            $this->db->query('UPDATE '.DB_PREFIX."product SET image = '".$this->db->escape($data['image'])."' WHERE product_id = '".(int) $product_id."'");
        }

        $this->db->query('DELETE FROM '.DB_PREFIX."product_description WHERE product_id = '".(int) $product_id."'");

        foreach ($data['product_description'] as $language_id => $value) {
            $this->db->query('INSERT INTO '.DB_PREFIX."product_description SET product_id = '".(int) $product_id."', language_id = '".(int) $language_id."', name = '".$this->db->escape($value['name'])."', description = '".$this->db->escape($value['description'])."', tag = '".$this->db->escape($value['tag'])."', meta_title = '".$this->db->escape($value['meta_title'])."', meta_description = '".$this->db->escape($value['meta_description'])."', meta_keyword = '".$this->db->escape($value['meta_keyword'])."'");
        }

        $this->db->query('DELETE FROM '.DB_PREFIX."product_to_store WHERE product_id = '".(int) $product_id."'");

        if (isset($data['product_store'])) {
            foreach ($data['product_store'] as $store_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_to_store SET product_id = '".(int) $product_id."', store_id = '".(int) $store_id."'");
            }
        }

        $this->db->query('DELETE FROM '.DB_PREFIX."product_attribute WHERE product_id = '".(int) $product_id."'");

        if (!empty($data['product_attribute'])) {
            foreach ($data['product_attribute'] as $product_attribute) {
                if ($product_attribute['attribute_id']) {
                    $this->db->query('DELETE FROM '.DB_PREFIX."product_attribute WHERE product_id = '".(int) $product_id."' AND attribute_id = '".(int) $product_attribute['attribute_id']."'");

                    foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
                        $this->db->query('INSERT INTO '.DB_PREFIX."product_attribute SET product_id = '".(int) $product_id."', attribute_id = '".(int) $product_attribute['attribute_id']."', language_id = '".(int) $language_id."', text = '".$this->db->escape($product_attribute_description['text'])."'");
                    }
                }
            }
        }

        $this->db->query('DELETE FROM '.DB_PREFIX."product_option WHERE product_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."product_option_value WHERE product_id = '".(int) $product_id."'");

        if (isset($data['product_option'])) {
            foreach ($data['product_option'] as $product_option) {
                if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                    if (isset($product_option['product_option_value'])) {
                        $this->db->query('INSERT INTO '.DB_PREFIX."product_option SET product_option_id = '".(int) $product_option['product_option_id']."', product_id = '".(int) $product_id."', option_id = '".(int) $product_option['option_id']."', required = '".(int) $product_option['required']."'");

                        $product_option_id = $this->db->getLastId();

                        foreach ($product_option['product_option_value'] as $product_option_value) {
                            $this->db->query('INSERT INTO '.DB_PREFIX."product_option_value SET product_option_value_id = '".(int) $product_option_value['product_option_value_id']."', product_option_id = '".(int) $product_option_id."', product_id = '".(int) $product_id."', option_id = '".(int) $product_option['option_id']."', option_value_id = '".(int) $product_option_value['option_value_id']."', quantity = '".(int) $product_option_value['quantity']."', subtract = '".(int) $product_option_value['subtract']."', price = '".(float) $product_option_value['price']."', price_prefix = '".$this->db->escape($product_option_value['price_prefix'])."', points = '".(int) $product_option_value['points']."', points_prefix = '".$this->db->escape($product_option_value['points_prefix'])."', weight = '".(float) $product_option_value['weight']."', weight_prefix = '".$this->db->escape($product_option_value['weight_prefix'])."'");
                        }
                    }
                } else {
                    $this->db->query('INSERT INTO '.DB_PREFIX."product_option SET product_option_id = '".(int) $product_option['product_option_id']."', product_id = '".(int) $product_id."', option_id = '".(int) $product_option['option_id']."', value = '".$this->db->escape($product_option['value'])."', required = '".(int) $product_option['required']."'");
                }
            }
        }

        $this->db->query('DELETE FROM '.DB_PREFIX."product_discount WHERE product_id = '".(int) $product_id."'");

        if (isset($data['product_discount'])) {
            foreach ($data['product_discount'] as $product_discount) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_discount SET product_id = '".(int) $product_id."', customer_group_id = '".(int) $product_discount['customer_group_id']."', quantity = '".(int) $product_discount['quantity']."', priority = '".(int) $product_discount['priority']."', price = '".(float) $product_discount['price']."', date_start = '".$this->db->escape($product_discount['date_start'])."', date_end = '".$this->db->escape($product_discount['date_end'])."'");
            }
        }

        $this->db->query('DELETE FROM '.DB_PREFIX."product_special WHERE product_id = '".(int) $product_id."'");

        if (isset($data['product_special'])) {
            foreach ($data['product_special'] as $product_special) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_special SET product_id = '".(int) $product_id."', customer_group_id = '".(int) $product_special['customer_group_id']."', priority = '".(int) $product_special['priority']."', price = '".(float) $product_special['price']."', date_start = '".$this->db->escape($product_special['date_start'])."', date_end = '".$this->db->escape($product_special['date_end'])."'");
            }
        }

        $this->db->query('DELETE FROM '.DB_PREFIX."product_image WHERE product_id = '".(int) $product_id."'");

        if (isset($data['product_image'])) {
            foreach ($data['product_image'] as $product_image) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_image SET product_id = '".(int) $product_id."', image = '".$this->db->escape($product_image['image'])."', sort_order = '".(int) $product_image['sort_order']."'");
            }
        }

        $this->db->query('DELETE FROM '.DB_PREFIX."product_to_download WHERE product_id = '".(int) $product_id."'");

        if (isset($data['product_download'])) {
            foreach ($data['product_download'] as $download_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_to_download SET product_id = '".(int) $product_id."', download_id = '".(int) $download_id."'");
            }
        }

        $this->db->query('DELETE FROM '.DB_PREFIX."product_to_category WHERE product_id = '".(int) $product_id."'");

        if (isset($data['product_category'])) {
            foreach ($data['product_category'] as $category_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_to_category SET product_id = '".(int) $product_id."', category_id = '".(int) $category_id."'");
            }
        }

        $this->db->query('DELETE FROM '.DB_PREFIX."product_filter WHERE product_id = '".(int) $product_id."'");

        if (isset($data['product_filter'])) {
            foreach ($data['product_filter'] as $filter_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_filter SET product_id = '".(int) $product_id."', filter_id = '".(int) $filter_id."'");
            }
        }

        $this->db->query('DELETE FROM '.DB_PREFIX."product_related WHERE product_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."product_related WHERE related_id = '".(int) $product_id."'");

        if (isset($data['product_related'])) {
            foreach ($data['product_related'] as $related_id) {
                $this->db->query('DELETE FROM '.DB_PREFIX."product_related WHERE product_id = '".(int) $product_id."' AND related_id = '".(int) $related_id."'");
                $this->db->query('INSERT INTO '.DB_PREFIX."product_related SET product_id = '".(int) $product_id."', related_id = '".(int) $related_id."'");
                $this->db->query('DELETE FROM '.DB_PREFIX."product_related WHERE product_id = '".(int) $related_id."' AND related_id = '".(int) $product_id."'");
                $this->db->query('INSERT INTO '.DB_PREFIX."product_related SET product_id = '".(int) $related_id."', related_id = '".(int) $product_id."'");
            }
        }

        $this->db->query('DELETE FROM '.DB_PREFIX."product_reward WHERE product_id = '".(int) $product_id."'");

        if (isset($data['product_reward'])) {
            foreach ($data['product_reward'] as $customer_group_id => $value) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_reward SET product_id = '".(int) $product_id."', customer_group_id = '".(int) $customer_group_id."', points = '".(int) $value['points']."'");
            }
        }

        $this->db->query('DELETE FROM '.DB_PREFIX."product_to_layout WHERE product_id = '".(int) $product_id."'");

        if (isset($data['product_layout'])) {
            foreach ($data['product_layout'] as $store_id => $layout_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_to_layout SET product_id = '".(int) $product_id."', store_id = '".(int) $store_id."', layout_id = '".(int) $layout_id."'");
            }
        }

        $this->db->query('DELETE FROM '.DB_PREFIX."url_alias WHERE query = 'product_id=".(int) $product_id."'");

        if ($data['keyword']) {
            $this->db->query('INSERT INTO '.DB_PREFIX."url_alias SET query = 'product_id=".(int) $product_id."', keyword = '".$this->db->escape($data['keyword'])."'");
        }

        $this->db->query('DELETE FROM `'.DB_PREFIX.'product_recurring` WHERE product_id = '.(int) $product_id);

        if (isset($data['product_recurrings'])) {
            foreach ($data['product_recurrings'] as $recurring) {
                $this->db->query('INSERT INTO `'.DB_PREFIX.'product_recurring` SET `product_id` = '.(int) $product_id.', customer_group_id = '.(int) $recurring['customer_group_id'].', `recurring_id` = '.(int) $recurring['recurring_id']);
            }
        }

        $this->cache->delete('product');


    }

    public function copyProduct($product_id)
    {
        $query = $this->db->query('SELECT DISTINCT * FROM '.DB_PREFIX.'product p LEFT JOIN '.DB_PREFIX."product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '".(int) $product_id."' AND pd.language_id = '".(int) $this->config->get('config_language_id')."'");

        if ($query->num_rows) {
            $data = array();

            $data = $query->row;

            $data['sku'] = '';
            $data['upc'] = '';
            $data['viewed'] = '0';
            $data['keyword'] = '';
            $data['status'] = '0';

            $data = array_merge($data, array('product_attribute' => $this->getProductAttributes($product_id)));
            $data = array_merge($data, array('product_description' => $this->getProductDescriptions($product_id)));
            $data = array_merge($data, array('product_discount' => $this->getProductDiscounts($product_id)));
            $data = array_merge($data, array('product_filter' => $this->getProductFilters($product_id)));
            $data = array_merge($data, array('product_image' => $this->getProductImages($product_id)));
            $data = array_merge($data, array('product_option' => $this->getProductOptions($product_id)));
            $data = array_merge($data, array('product_related' => $this->getProductRelated($product_id)));
            $data = array_merge($data, array('product_reward' => $this->getProductRewards($product_id)));
            $data = array_merge($data, array('product_special' => $this->getProductSpecials($product_id)));
            $data = array_merge($data, array('product_category' => $this->getProductCategories($product_id)));
            $data = array_merge($data, array('product_download' => $this->getProductDownloads($product_id)));
            $data = array_merge($data, array('product_layout' => $this->getProductLayouts($product_id)));
            $data = array_merge($data, array('product_store' => $this->getProductStores($product_id)));
            $data = array_merge($data, array('product_recurrings' => $this->getRecurrings($product_id)));

            $this->addProductCopy($data);
        }
    }

    public function copyProductByIsbn($product_id)
    {
        $query = $this->db->query('SELECT DISTINCT * FROM '.DB_PREFIX.'product p LEFT JOIN '.DB_PREFIX."product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '".(int) $product_id."' AND pd.language_id = '".(int) $this->config->get('config_language_id')."'");

        if ($query->num_rows) {
            $data = array();

            $data = $query->row;

            $data['sku'] = '';
            $data['upc'] = '';
            $data['viewed'] = '0';
            $data['keyword'] = '';
            $data['status'] = '0';

            $data['book_language_id'] = $this->getProductBooklanguage($product_id);
            $data['book_isbn13'] = $this->getProductBookisbn13($product_id);
            $data = array_merge($data, array('product_author' => $this->getProductAuthors($product_id)));
            $data = array_merge($data, array('product_translator' => $this->getProducttranslators($product_id)));
            $data = array_merge($data, array('product_publisher' => $this->getProductpublishers($product_id)));
            $data = array_merge($data, array('product_description' => $this->getProductDescriptions($product_id)));

            $data = array_merge($data, array('product_category' => $this->getProductCategories($product_id)));

            $data = array_merge($data, array('product_layout' => $this->getProductLayouts($product_id)));
            $data = array_merge($data, array('product_store' => $this->getProductStores($product_id)));

            $this->addProductCopy($data);
        }
    }

    public function deleteProduct($product_id)
    {


        $this->db->query('DELETE FROM '.DB_PREFIX."product WHERE product_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."product_attribute WHERE product_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."product_description WHERE product_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."product_discount WHERE product_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."product_filter WHERE product_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."product_image WHERE product_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."product_option WHERE product_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."product_option_value WHERE product_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."product_related WHERE product_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."product_related WHERE related_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."product_reward WHERE product_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."product_special WHERE product_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."product_to_category WHERE product_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."product_to_download WHERE product_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."product_to_layout WHERE product_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."product_to_store WHERE product_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."review WHERE product_id = '".(int) $product_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX.'product_recurring WHERE product_id = '.(int) $product_id);
        $this->db->query('DELETE FROM '.DB_PREFIX."url_alias WHERE query = 'product_id=".(int) $product_id."'");

        $this->cache->delete('product');


    }

    public function getProduct($product_id)
    {
        $query = $this->db->query('SELECT DISTINCT *, (SELECT keyword FROM '.DB_PREFIX."url_alias WHERE query = 'product_id=".(int) $product_id."') AS keyword FROM ".DB_PREFIX.'product p LEFT JOIN '.DB_PREFIX."product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '".(int) $product_id."' AND pd.language_id = '".(int) $this->config->get('config_language_id')."'");

        return $query->row;
    }

    public function getProducts($data = array())
    {
        $sql = 'SELECT *
		FROM '.DB_PREFIX.'product p
		LEFT JOIN '.DB_PREFIX.'product_description pd ON (p.product_id = pd.product_id)
		LEFT JOIN '.DB_PREFIX."product_to_seller pts ON (p.product_id = pts.product_id)
		WHERE pd.language_id = '".(int) $this->config->get('config_language_id')."'
		AND pts.seller_id = '".(int) $this->customer->getID()."'
		";

        if (!empty($data['filter_name'])) {
            $sql .= " AND pd.name LIKE '%".$this->db->escape($data['filter_name'])."%'";
        }

        if (!empty($data['filter_model'])) {
            $sql .= " AND p.model LIKE '%".$this->db->escape($data['filter_model'])."%'";
        }

        if (!empty($data['filter_price'])) {
            $sql .= " AND p.price LIKE '%".$this->db->escape($data['filter_price'])."%'";
        }

        if (isset($data['filter_quantity']) && $data['filter_quantity'] !== null) {
            $sql .= " AND p.quantity = '".(int) $data['filter_quantity']."'";
        }

        if (isset($data['filter_status']) && $data['filter_status'] !== null) {
            $sql .= " AND p.status = '".(int) $data['filter_status']."'";
        }

        $sql .= ' GROUP BY p.product_id';

        $sort_data = array(
            'pd.name',
            'p.model',
            'p.price',
            'p.quantity',
            'p.status',
            'p.sort_order',
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= ' ORDER BY '.$data['sort'];
        } else {
            $sql .= ' ORDER BY pd.name';
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= ' DESC';
        } else {
            $sql .= ' ASC';
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= ' LIMIT '.(int) $data['start'].','.(int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getProductsByProductId($product_id)
    {
        $sql = 'SELECT *,p.shipping,p.product_id,pd.name,pts.seller_id,CONCAT(c.firstname, " ", c.lastname) AS seller_name
		FROM '.DB_PREFIX.'product p
		LEFT JOIN '.DB_PREFIX.'product_description pd ON (p.product_id = pd.product_id)
		LEFT JOIN '.DB_PREFIX.'product_to_seller pts ON (p.product_id = pts.product_id)
    LEFT JOIN '.DB_PREFIX."customer c ON (pts.seller_id = c.customer_id)
		WHERE pd.language_id = '".(int) $this->config->get('config_language_id')."'
		AND p.product_id = '".(int) $product_id."'
		";



        $sql .= ' GROUP BY pts.seller_id';




        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getProductsOnCartBySellerId($seller_id) {
  		$product_data = array();

  		$cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart c LEFT JOIN ".DB_PREFIX."product_to_seller pts ON (c.product_id = pts.product_id) WHERE c.customer_id = '" . (int)$this->customer->getId() . "' AND c.session_id = '" . $this->db->escape($this->session->getId()) . "' AND pts.seller_id = '" . $seller_id . "'");

  		foreach ($cart_query->rows as $cart) {
  			$stock = true;

  			$product_query = $this->db->query("SELECT *,pts.seller_id FROM " . DB_PREFIX . "product_to_store p2s LEFT JOIN " . DB_PREFIX . "product p ON (p2s.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN ".DB_PREFIX."product_to_seller pts ON (p.product_id = pts.product_id) WHERE p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p2s.product_id = '" . (int)$cart['product_id'] . "' AND pts.seller_id = '" . (int)$cart['seller_id'] . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1' GROUP BY p.product_id ORDER BY pts.seller_id");

  			if ($product_query->num_rows && ($cart['quantity'] > 0)) {
  				$option_price = 0;
  				$option_points = 0;
  				$option_weight = 0;

  				$option_data = array();

  				foreach (json_decode($cart['option']) as $product_option_id => $value) {
  					$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$cart['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

  					if ($option_query->num_rows) {
  						if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
  							$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

  							if ($option_value_query->num_rows) {
  								if ($option_value_query->row['price_prefix'] == '+') {
  									$option_price += $option_value_query->row['price'];
  								} elseif ($option_value_query->row['price_prefix'] == '-') {
  									$option_price -= $option_value_query->row['price'];
  								}

  								if ($option_value_query->row['points_prefix'] == '+') {
  									$option_points += $option_value_query->row['points'];
  								} elseif ($option_value_query->row['points_prefix'] == '-') {
  									$option_points -= $option_value_query->row['points'];
  								}

  								if ($option_value_query->row['weight_prefix'] == '+') {
  									$option_weight += $option_value_query->row['weight'];
  								} elseif ($option_value_query->row['weight_prefix'] == '-') {
  									$option_weight -= $option_value_query->row['weight'];
  								}

  								if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $cart['quantity']))) {
  									$stock = false;
  								}

  								$option_data[] = array(
  									'product_option_id'       => $product_option_id,
  									'product_option_value_id' => $value,
  									'option_id'               => $option_query->row['option_id'],
  									'option_value_id'         => $option_value_query->row['option_value_id'],
  									'name'                    => $option_query->row['name'],
  									'value'                   => $option_value_query->row['name'],
  									'type'                    => $option_query->row['type'],
  									'quantity'                => $option_value_query->row['quantity'],
  									'subtract'                => $option_value_query->row['subtract'],
  									'price'                   => $option_value_query->row['price'],
  									'price_prefix'            => $option_value_query->row['price_prefix'],
  									'points'                  => $option_value_query->row['points'],
  									'points_prefix'           => $option_value_query->row['points_prefix'],
  									'weight'                  => $option_value_query->row['weight'],
  									'weight_prefix'           => $option_value_query->row['weight_prefix']
  								);
  							}
  						} elseif ($option_query->row['type'] == 'checkbox' && is_array($value)) {
  							foreach ($value as $product_option_value_id) {
  								$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

  								if ($option_value_query->num_rows) {
  									if ($option_value_query->row['price_prefix'] == '+') {
  										$option_price += $option_value_query->row['price'];
  									} elseif ($option_value_query->row['price_prefix'] == '-') {
  										$option_price -= $option_value_query->row['price'];
  									}

  									if ($option_value_query->row['points_prefix'] == '+') {
  										$option_points += $option_value_query->row['points'];
  									} elseif ($option_value_query->row['points_prefix'] == '-') {
  										$option_points -= $option_value_query->row['points'];
  									}

  									if ($option_value_query->row['weight_prefix'] == '+') {
  										$option_weight += $option_value_query->row['weight'];
  									} elseif ($option_value_query->row['weight_prefix'] == '-') {
  										$option_weight -= $option_value_query->row['weight'];
  									}

  									if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $cart['quantity']))) {
  										$stock = false;
  									}

  									$option_data[] = array(
  										'product_option_id'       => $product_option_id,
  										'product_option_value_id' => $product_option_value_id,
  										'option_id'               => $option_query->row['option_id'],
  										'option_value_id'         => $option_value_query->row['option_value_id'],
  										'name'                    => $option_query->row['name'],
  										'value'                   => $option_value_query->row['name'],
  										'type'                    => $option_query->row['type'],
  										'quantity'                => $option_value_query->row['quantity'],
  										'subtract'                => $option_value_query->row['subtract'],
  										'price'                   => $option_value_query->row['price'],
  										'price_prefix'            => $option_value_query->row['price_prefix'],
  										'points'                  => $option_value_query->row['points'],
  										'points_prefix'           => $option_value_query->row['points_prefix'],
  										'weight'                  => $option_value_query->row['weight'],
  										'weight_prefix'           => $option_value_query->row['weight_prefix']
  									);
  								}
  							}
  						} elseif ($option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time') {
  							$option_data[] = array(
  								'product_option_id'       => $product_option_id,
  								'product_option_value_id' => '',
  								'option_id'               => $option_query->row['option_id'],
  								'option_value_id'         => '',
  								'name'                    => $option_query->row['name'],
  								'value'                   => $value,
  								'type'                    => $option_query->row['type'],
  								'quantity'                => '',
  								'subtract'                => '',
  								'price'                   => '',
  								'price_prefix'            => '',
  								'points'                  => '',
  								'points_prefix'           => '',
  								'weight'                  => '',
  								'weight_prefix'           => ''
  							);
  						}
  					}
  				}

  				$price = $product_query->row['price'];

  				// Product Discounts
  				$discount_quantity = 0;

  				foreach ($cart_query->rows as $cart_2) {
  					if ($cart_2['product_id'] == $cart['product_id']) {
  						$discount_quantity += $cart_2['quantity'];
  					}
  				}

  				$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

  				if ($product_discount_query->num_rows) {
  					$price = $product_discount_query->row['price'];
  				}

  				// Product Specials
  				$product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

  				if ($product_special_query->num_rows) {
  					$price = $product_special_query->row['price'];
  				}

  				// Reward Points
  				$product_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

  				if ($product_reward_query->num_rows) {
  					$reward = $product_reward_query->row['points'];
  				} else {
  					$reward = 0;
  				}

  				// Downloads
  				$download_data = array();

  				$download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.product_id = '" . (int)$cart['product_id'] . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

  				foreach ($download_query->rows as $download) {
  					$download_data[] = array(
  						'download_id' => $download['download_id'],
  						'name'        => $download['name'],
  						'filename'    => $download['filename'],
  						'mask'        => $download['mask']
  					);
  				}

  				// Stock
  				if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $cart['quantity'])) {
  					$stock = false;
  				}

  				$recurring_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "recurring r LEFT JOIN " . DB_PREFIX . "product_recurring pr ON (r.recurring_id = pr.recurring_id) LEFT JOIN " . DB_PREFIX . "recurring_description rd ON (r.recurring_id = rd.recurring_id) WHERE r.recurring_id = '" . (int)$cart['recurring_id'] . "' AND pr.product_id = '" . (int)$cart['product_id'] . "' AND rd.language_id = " . (int)$this->config->get('config_language_id') . " AND r.status = 1 AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

  				if ($recurring_query->num_rows) {
  					$recurring = array(
  						'recurring_id'    => $cart['recurring_id'],
  						'name'            => $recurring_query->row['name'],
  						'frequency'       => $recurring_query->row['frequency'],
  						'price'           => $recurring_query->row['price'],
  						'cycle'           => $recurring_query->row['cycle'],
  						'duration'        => $recurring_query->row['duration'],
  						'trial'           => $recurring_query->row['trial_status'],
  						'trial_frequency' => $recurring_query->row['trial_frequency'],
  						'trial_price'     => $recurring_query->row['trial_price'],
  						'trial_cycle'     => $recurring_query->row['trial_cycle'],
  						'trial_duration'  => $recurring_query->row['trial_duration']
  					);
  				} else {
  					$recurring = false;
  				}

  				$product_data[] = array(
  					'cart_id'         => $cart['cart_id'],
  					'product_id'      => $product_query->row['product_id'],
            'seller_id'      => $product_query->row['seller_id'],
  					'name'            => $product_query->row['name'],
  					'model'           => $product_query->row['model'],
  					'shipping'        => $product_query->row['shipping'],
  					'image'           => $product_query->row['image'],
  					'option'          => $option_data,
  					'download'        => $download_data,
  					'quantity'        => $cart['quantity'],
  					'minimum'         => $product_query->row['minimum'],
  					'subtract'        => $product_query->row['subtract'],
  					'stock'           => $stock,
  					'price'           => ($price + $option_price),
  					'total'           => ($price + $option_price) * $cart['quantity'],
  					'reward'          => $reward * $cart['quantity'],
  					'points'          => ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $cart['quantity'] : 0),
  					'tax_class_id'    => $product_query->row['tax_class_id'],
  					'weight'          => ($product_query->row['weight'] + $option_weight) * $cart['quantity'],
  					'weight_class_id' => $product_query->row['weight_class_id'],
  					'length'          => $product_query->row['length'],
  					'width'           => $product_query->row['width'],
  					'height'          => $product_query->row['height'],
  					'length_class_id' => $product_query->row['length_class_id'],
  					'recurring'       => $recurring
  				);
  			}
  		}

  		return $product_data;
  	}

    public function getProductsByNonSeller() {
  		$product_data = array();

  		$cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart c  WHERE c.customer_id = '" . (int)$this->customer->getId() . "' AND c.session_id = '" . $this->db->escape($this->session->getId()) . "' AND c.product_id NOT IN (SELECT pts.product_id FROM ".DB_PREFIX."product_to_seller pts)");

  		foreach ($cart_query->rows as $cart) {
  			$stock = true;

  			$product_query = $this->db->query("SELECT p.*,pd.*,pts.seller_id FROM " . DB_PREFIX . "product_to_store p2s LEFT JOIN " . DB_PREFIX . "product p ON (p2s.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN ".DB_PREFIX."product_to_seller pts ON (p.product_id = pts.product_id) WHERE p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p2s.product_id = '" . (int)$cart['product_id'] . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");

  			if ($product_query->num_rows && ($cart['quantity'] > 0)) {
  				$option_price = 0;
  				$option_points = 0;
  				$option_weight = 0;

  				$option_data = array();

  				foreach (json_decode($cart['option']) as $product_option_id => $value) {
  					$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$cart['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

  					if ($option_query->num_rows) {
  						if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
  							$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

  							if ($option_value_query->num_rows) {
  								if ($option_value_query->row['price_prefix'] == '+') {
  									$option_price += $option_value_query->row['price'];
  								} elseif ($option_value_query->row['price_prefix'] == '-') {
  									$option_price -= $option_value_query->row['price'];
  								}

  								if ($option_value_query->row['points_prefix'] == '+') {
  									$option_points += $option_value_query->row['points'];
  								} elseif ($option_value_query->row['points_prefix'] == '-') {
  									$option_points -= $option_value_query->row['points'];
  								}

  								if ($option_value_query->row['weight_prefix'] == '+') {
  									$option_weight += $option_value_query->row['weight'];
  								} elseif ($option_value_query->row['weight_prefix'] == '-') {
  									$option_weight -= $option_value_query->row['weight'];
  								}

  								if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $cart['quantity']))) {
  									$stock = false;
  								}

  								$option_data[] = array(
  									'product_option_id'       => $product_option_id,
  									'product_option_value_id' => $value,
  									'option_id'               => $option_query->row['option_id'],
  									'option_value_id'         => $option_value_query->row['option_value_id'],
  									'name'                    => $option_query->row['name'],
  									'value'                   => $option_value_query->row['name'],
  									'type'                    => $option_query->row['type'],
  									'quantity'                => $option_value_query->row['quantity'],
  									'subtract'                => $option_value_query->row['subtract'],
  									'price'                   => $option_value_query->row['price'],
  									'price_prefix'            => $option_value_query->row['price_prefix'],
  									'points'                  => $option_value_query->row['points'],
  									'points_prefix'           => $option_value_query->row['points_prefix'],
  									'weight'                  => $option_value_query->row['weight'],
  									'weight_prefix'           => $option_value_query->row['weight_prefix']
  								);
  							}
  						} elseif ($option_query->row['type'] == 'checkbox' && is_array($value)) {
  							foreach ($value as $product_option_value_id) {
  								$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

  								if ($option_value_query->num_rows) {
  									if ($option_value_query->row['price_prefix'] == '+') {
  										$option_price += $option_value_query->row['price'];
  									} elseif ($option_value_query->row['price_prefix'] == '-') {
  										$option_price -= $option_value_query->row['price'];
  									}

  									if ($option_value_query->row['points_prefix'] == '+') {
  										$option_points += $option_value_query->row['points'];
  									} elseif ($option_value_query->row['points_prefix'] == '-') {
  										$option_points -= $option_value_query->row['points'];
  									}

  									if ($option_value_query->row['weight_prefix'] == '+') {
  										$option_weight += $option_value_query->row['weight'];
  									} elseif ($option_value_query->row['weight_prefix'] == '-') {
  										$option_weight -= $option_value_query->row['weight'];
  									}

  									if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $cart['quantity']))) {
  										$stock = false;
  									}

  									$option_data[] = array(
  										'product_option_id'       => $product_option_id,
  										'product_option_value_id' => $product_option_value_id,
  										'option_id'               => $option_query->row['option_id'],
  										'option_value_id'         => $option_value_query->row['option_value_id'],
  										'name'                    => $option_query->row['name'],
  										'value'                   => $option_value_query->row['name'],
  										'type'                    => $option_query->row['type'],
  										'quantity'                => $option_value_query->row['quantity'],
  										'subtract'                => $option_value_query->row['subtract'],
  										'price'                   => $option_value_query->row['price'],
  										'price_prefix'            => $option_value_query->row['price_prefix'],
  										'points'                  => $option_value_query->row['points'],
  										'points_prefix'           => $option_value_query->row['points_prefix'],
  										'weight'                  => $option_value_query->row['weight'],
  										'weight_prefix'           => $option_value_query->row['weight_prefix']
  									);
  								}
  							}
  						} elseif ($option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time') {
  							$option_data[] = array(
  								'product_option_id'       => $product_option_id,
  								'product_option_value_id' => '',
  								'option_id'               => $option_query->row['option_id'],
  								'option_value_id'         => '',
  								'name'                    => $option_query->row['name'],
  								'value'                   => $value,
  								'type'                    => $option_query->row['type'],
  								'quantity'                => '',
  								'subtract'                => '',
  								'price'                   => '',
  								'price_prefix'            => '',
  								'points'                  => '',
  								'points_prefix'           => '',
  								'weight'                  => '',
  								'weight_prefix'           => ''
  							);
  						}
  					}
  				}

  				$price = $product_query->row['price'];

  				// Product Discounts
  				$discount_quantity = 0;

  				foreach ($cart_query->rows as $cart_2) {
  					if ($cart_2['product_id'] == $cart['product_id']) {
  						$discount_quantity += $cart_2['quantity'];
  					}
  				}

  				$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

  				if ($product_discount_query->num_rows) {
  					$price = $product_discount_query->row['price'];
  				}

  				// Product Specials
  				$product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

  				if ($product_special_query->num_rows) {
  					$price = $product_special_query->row['price'];
  				}

  				// Reward Points
  				$product_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

  				if ($product_reward_query->num_rows) {
  					$reward = $product_reward_query->row['points'];
  				} else {
  					$reward = 0;
  				}

  				// Downloads
  				$download_data = array();

  				$download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.product_id = '" . (int)$cart['product_id'] . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

  				foreach ($download_query->rows as $download) {
  					$download_data[] = array(
  						'download_id' => $download['download_id'],
  						'name'        => $download['name'],
  						'filename'    => $download['filename'],
  						'mask'        => $download['mask']
  					);
  				}

  				// Stock
  				if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $cart['quantity'])) {
  					$stock = false;
  				}

  				$recurring_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "recurring r LEFT JOIN " . DB_PREFIX . "product_recurring pr ON (r.recurring_id = pr.recurring_id) LEFT JOIN " . DB_PREFIX . "recurring_description rd ON (r.recurring_id = rd.recurring_id) WHERE r.recurring_id = '" . (int)$cart['recurring_id'] . "' AND pr.product_id = '" . (int)$cart['product_id'] . "' AND rd.language_id = " . (int)$this->config->get('config_language_id') . " AND r.status = 1 AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

  				if ($recurring_query->num_rows) {
  					$recurring = array(
  						'recurring_id'    => $cart['recurring_id'],
  						'name'            => $recurring_query->row['name'],
  						'frequency'       => $recurring_query->row['frequency'],
  						'price'           => $recurring_query->row['price'],
  						'cycle'           => $recurring_query->row['cycle'],
  						'duration'        => $recurring_query->row['duration'],
  						'trial'           => $recurring_query->row['trial_status'],
  						'trial_frequency' => $recurring_query->row['trial_frequency'],
  						'trial_price'     => $recurring_query->row['trial_price'],
  						'trial_cycle'     => $recurring_query->row['trial_cycle'],
  						'trial_duration'  => $recurring_query->row['trial_duration']
  					);
  				} else {
  					$recurring = false;
  				}

  				$product_data[] = array(
  					'cart_id'         => $cart['cart_id'],
  					'product_id'      => $product_query->row['product_id'],
            'seller_id'      => $product_query->row['seller_id'],
  					'name'            => $product_query->row['name'],
  					'model'           => $product_query->row['model'],
  					'shipping'        => $product_query->row['shipping'],
  					'image'           => $product_query->row['image'],
  					'option'          => $option_data,
  					'download'        => $download_data,
  					'quantity'        => $cart['quantity'],
  					'minimum'         => $product_query->row['minimum'],
  					'subtract'        => $product_query->row['subtract'],
  					'stock'           => $stock,
  					'price'           => ($price + $option_price),
  					'total'           => ($price + $option_price) * $cart['quantity'],
  					'reward'          => $reward * $cart['quantity'],
  					'points'          => ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $cart['quantity'] : 0),
  					'tax_class_id'    => $product_query->row['tax_class_id'],
  					'weight'          => ($product_query->row['weight'] + $option_weight) * $cart['quantity'],
  					'weight_class_id' => $product_query->row['weight_class_id'],
  					'length'          => $product_query->row['length'],
  					'width'           => $product_query->row['width'],
  					'height'          => $product_query->row['height'],
  					'length_class_id' => $product_query->row['length_class_id'],
  					'recurring'       => $recurring
  				);
  			} else {
  				$this->cart->remove($cart['cart_id']);
  			}
  		}

  		return $product_data;
  	}

    public function getProductsByCategoryId($category_id)
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX.'product p LEFT JOIN '.DB_PREFIX.'product_description pd ON (p.product_id = pd.product_id) LEFT JOIN '.DB_PREFIX."product_to_category p2c ON (p.product_id = p2c.product_id) WHERE pd.language_id = '".(int) $this->config->get('config_language_id')."' AND p2c.category_id = '".(int) $category_id."' ORDER BY pd.name ASC");

        return $query->rows;
    }

    public function getProductDescriptions($product_id)
    {
        $product_description_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."product_description WHERE product_id = '".(int) $product_id."'");

        foreach ($query->rows as $result) {
            $product_description_data[$result['language_id']] = array(
                'name' => $result['name'],
                'description' => $result['description'],
                'meta_title' => $result['meta_title'],
                'meta_description' => $result['meta_description'],
                'meta_keyword' => $result['meta_keyword'],
                'tag' => $result['tag'],
            );
        }

        return $product_description_data;
    }

    public function getProductCategories($product_id)
    {
        $product_category_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."product_to_category WHERE product_id = '".(int) $product_id."'");

        foreach ($query->rows as $result) {
            $product_category_data[] = $result['category_id'];
        }

        return $product_category_data;
    }

    public function getProductFilters($product_id)
    {
        $product_filter_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."product_filter WHERE product_id = '".(int) $product_id."'");

        foreach ($query->rows as $result) {
            $product_filter_data[] = $result['filter_id'];
        }

        return $product_filter_data;
    }

    public function getProductAttributes($product_id)
    {
        $product_attribute_data = array();

        $product_attribute_query = $this->db->query('SELECT attribute_id FROM '.DB_PREFIX."product_attribute WHERE product_id = '".(int) $product_id."' GROUP BY attribute_id");

        foreach ($product_attribute_query->rows as $product_attribute) {
            $product_attribute_description_data = array();

            $product_attribute_description_query = $this->db->query('SELECT * FROM '.DB_PREFIX."product_attribute WHERE product_id = '".(int) $product_id."' AND attribute_id = '".(int) $product_attribute['attribute_id']."'");

            foreach ($product_attribute_description_query->rows as $product_attribute_description) {
                $product_attribute_description_data[$product_attribute_description['language_id']] = array('text' => $product_attribute_description['text']);
            }

            $product_attribute_data[] = array(
                'attribute_id' => $product_attribute['attribute_id'],
                'product_attribute_description' => $product_attribute_description_data,
            );
        }

        return $product_attribute_data;
    }

    public function getProductOptions($product_id)
    {
        $product_option_data = array();

        $product_option_query = $this->db->query('SELECT * FROM `'.DB_PREFIX.'product_option` po LEFT JOIN `'.DB_PREFIX.'option` o ON (po.option_id = o.option_id) LEFT JOIN `'.DB_PREFIX."option_description` od ON (o.option_id = od.option_id) WHERE po.product_id = '".(int) $product_id."' AND od.language_id = '".(int) $this->config->get('config_language_id')."'");

        foreach ($product_option_query->rows as $product_option) {
            $product_option_value_data = array();

            $product_option_value_query = $this->db->query('SELECT * FROM '.DB_PREFIX."product_option_value WHERE product_option_id = '".(int) $product_option['product_option_id']."'");

            foreach ($product_option_value_query->rows as $product_option_value) {
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

            $product_option_data[] = array(
                'product_option_id' => $product_option['product_option_id'],
                'product_option_value' => $product_option_value_data,
                'option_id' => $product_option['option_id'],
                'name' => $product_option['name'],
                'type' => $product_option['type'],
                'value' => $product_option['value'],
                'required' => $product_option['required'],
            );
        }

        return $product_option_data;
    }

    public function getProductImages($product_id)
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."product_image WHERE product_id = '".(int) $product_id."' ORDER BY sort_order ASC");

        return $query->rows;
    }

    public function getProductDiscounts($product_id)
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."product_discount WHERE product_id = '".(int) $product_id."' ORDER BY quantity, priority, price");

        return $query->rows;
    }

    public function getProductSpecials($product_id)
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."product_special WHERE product_id = '".(int) $product_id."' ORDER BY priority, price");

        return $query->rows;
    }

    public function getProductRewards($product_id)
    {
        $product_reward_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."product_reward WHERE product_id = '".(int) $product_id."'");

        foreach ($query->rows as $result) {
            $product_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
        }

        return $product_reward_data;
    }

    public function getProductDownloads($product_id)
    {
        $product_download_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."product_to_download WHERE product_id = '".(int) $product_id."'");

        foreach ($query->rows as $result) {
            $product_download_data[] = $result['download_id'];
        }

        return $product_download_data;
    }

    public function getProductStores($product_id)
    {
        $product_store_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."product_to_store WHERE product_id = '".(int) $product_id."'");

        foreach ($query->rows as $result) {
            $product_store_data[] = $result['store_id'];
        }

        return $product_store_data;
    }

    public function getProductLayouts($product_id)
    {
        $product_layout_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."product_to_layout WHERE product_id = '".(int) $product_id."'");

        foreach ($query->rows as $result) {
            $product_layout_data[$result['store_id']] = $result['layout_id'];
        }

        return $product_layout_data;
    }

    public function getProductRelated($product_id)
    {
        $product_related_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."product_related WHERE product_id = '".(int) $product_id."'");

        foreach ($query->rows as $result) {
            $product_related_data[] = $result['related_id'];
        }

        return $product_related_data;
    }

    public function getRecurrings($product_id)
    {
        $query = $this->db->query('SELECT * FROM `'.DB_PREFIX."product_recurring` WHERE product_id = '".(int) $product_id."'");

        return $query->rows;
    }

    public function getTotalProducts($data = array())
    {
        $sql = 'SELECT
		COUNT(DISTINCT p.product_id) AS total
		FROM '.DB_PREFIX.'product p
		LEFT JOIN '.DB_PREFIX.'product_description pd ON (p.product_id = pd.product_id)
		LEFT JOIN '.DB_PREFIX.'product_to_seller pts ON (p.product_id = pts.product_id)
		';

        $sql .= " WHERE pd.language_id = '".(int) $this->config->get('config_language_id')."'";

        if (!empty($data['filter_name'])) {
            $sql .= " AND pd.name LIKE '%".$this->db->escape($data['filter_name'])."%'";
        }

        if (!empty($data['filter_model'])) {
            $sql .= " AND p.model LIKE '%".$this->db->escape($data['filter_model'])."%'";
        }

        if (!empty($data['filter_price'])) {
            $sql .= " AND p.price LIKE '%".$this->db->escape($data['filter_price'])."%'";
        }

        if (isset($data['filter_quantity']) && $data['filter_quantity'] !== null) {
            $sql .= " AND p.quantity = '".(int) $data['filter_quantity']."'";
        }

        if (isset($data['filter_status']) && $data['filter_status'] !== null) {
            $sql .= " AND p.status = '".(int) $data['filter_status']."'";
        }

        $sql .= " AND pts.seller_id = '".(int) $this->customer->getID()."'";

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getTotalProductsByTaxClassId($tax_class_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."product WHERE tax_class_id = '".(int) $tax_class_id."'");

        return $query->row['total'];
    }

    public function getTotalProductsByStockStatusId($stock_status_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."product WHERE stock_status_id = '".(int) $stock_status_id."'");

        return $query->row['total'];
    }

    public function getTotalProductsByWeightClassId($weight_class_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."product WHERE weight_class_id = '".(int) $weight_class_id."'");

        return $query->row['total'];
    }

    public function getTotalProductsByLengthClassId($length_class_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."product WHERE length_class_id = '".(int) $length_class_id."'");

        return $query->row['total'];
    }

    public function getTotalProductsByDownloadId($download_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."product_to_download WHERE download_id = '".(int) $download_id."'");

        return $query->row['total'];
    }

    public function getTotalProductsByManufacturerId($manufacturer_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."product WHERE manufacturer_id = '".(int) $manufacturer_id."'");

        return $query->row['total'];
    }

    public function getTotalProductsByAttributeId($attribute_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."product_attribute WHERE attribute_id = '".(int) $attribute_id."'");

        return $query->row['total'];
    }

    public function getTotalProductsByOptionId($option_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."product_option WHERE option_id = '".(int) $option_id."'");

        return $query->row['total'];
    }

    public function getTotalProductsByProfileId($recurring_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."product_recurring WHERE recurring_id = '".(int) $recurring_id."'");

        return $query->row['total'];
    }

    public function getTotalProductsByLayoutId($layout_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."product_to_layout WHERE layout_id = '".(int) $layout_id."'");

        return $query->row['total'];
    }

    public function isSellerProduct($product_id)
    {
        if ($product_id == 0) {
            return true;
        } else {
            $seller_query = $this->db->query('SELECT * FROM '.DB_PREFIX."product_to_seller WHERE seller_id = '".(int) $this->customer->getId()."' AND product_id = '".(int) $product_id."'");

            return $seller_query->rows;
        }
    }

    public function addProductCopy($data)
    {


        $this->db->query('INSERT INTO '.DB_PREFIX."product SET model = '".$this->db->escape($data['model'])."', sku = '".$this->db->escape($data['sku'])."', upc = '".$this->db->escape($data['upc'])."', ean = '".$this->db->escape($data['ean'])."', jan = '".$this->db->escape($data['jan'])."', isbn = '".$this->db->escape($data['isbn'])."', mpn = '".$this->db->escape($data['mpn'])."', location = '".$this->db->escape($data['location'])."', quantity = '".(int) $data['quantity']."', minimum = '".(int) $data['minimum']."', subtract = '".(int) $data['subtract']."', stock_status_id = '".(int) $data['stock_status_id']."', date_available = '".$this->db->escape($data['date_available'])."', manufacturer_id = '".(int) $data['manufacturer_id']."', shipping = '".(int) $data['shipping']."', price = '".(float) $data['price']."', points = '".(int) $data['points']."', weight = '".(float) $data['weight']."', weight_class_id = '".(int) $data['weight_class_id']."', length = '".(float) $data['length']."', width = '".(float) $data['width']."', height = '".(float) $data['height']."', length_class_id = '".(int) $data['length_class_id']."', status = '".(int) $data['status']."', tax_class_id = '".$this->db->escape($data['tax_class_id'])."', sort_order = '".(int) $data['sort_order']."', date_added = NOW()");

        $product_id = $this->db->getLastId();

        $this->db->query('INSERT INTO '.DB_PREFIX."product_to_seller SET seller_id = '".$this->customer->getID()."', product_id = '".$product_id."'");

        if (isset($data['image'])) {
            $this->db->query('UPDATE '.DB_PREFIX."product SET image = '".$this->db->escape($data['image'])."' WHERE product_id = '".(int) $product_id."'");
        }

        foreach ($data['product_description'] as $language_id => $value) {
            $this->db->query('INSERT INTO '.DB_PREFIX."product_description SET product_id = '".(int) $product_id."', language_id = '".(int) $language_id."', name = '".$this->db->escape($value['name'])."', description = '".$this->db->escape($value['description'])."', tag = '".$this->db->escape($value['tag'])."', meta_title = '".$this->db->escape($value['meta_title'])."', meta_description = '".$this->db->escape($value['meta_description'])."', meta_keyword = '".$this->db->escape($value['meta_keyword'])."'");
        }

        if (isset($data['product_store'])) {
            foreach ($data['product_store'] as $store_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_to_store SET product_id = '".(int) $product_id."', store_id = '".(int) $store_id."'");
            }
        }

        if (isset($data['product_attribute'])) {
            foreach ($data['product_attribute'] as $product_attribute) {
                if ($product_attribute['attribute_id']) {
                    $this->db->query('DELETE FROM '.DB_PREFIX."product_attribute WHERE product_id = '".(int) $product_id."' AND attribute_id = '".(int) $product_attribute['attribute_id']."'");

                    foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
                        $this->db->query('INSERT INTO '.DB_PREFIX."product_attribute SET product_id = '".(int) $product_id."', attribute_id = '".(int) $product_attribute['attribute_id']."', language_id = '".(int) $language_id."', text = '".$this->db->escape($product_attribute_description['text'])."'");
                    }
                }
            }
        }

        if (isset($data['product_option'])) {
            foreach ($data['product_option'] as $product_option) {
                if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                    if (isset($product_option['product_option_value'])) {
                        $this->db->query('INSERT INTO '.DB_PREFIX."product_option SET product_id = '".(int) $product_id."', option_id = '".(int) $product_option['option_id']."', required = '".(int) $product_option['required']."'");

                        $product_option_id = $this->db->getLastId();

                        foreach ($product_option['product_option_value'] as $product_option_value) {
                            $this->db->query('INSERT INTO '.DB_PREFIX."product_option_value SET product_option_id = '".(int) $product_option_id."', product_id = '".(int) $product_id."', option_id = '".(int) $product_option['option_id']."', option_value_id = '".(int) $product_option_value['option_value_id']."', quantity = '".(int) $product_option_value['quantity']."', subtract = '".(int) $product_option_value['subtract']."', price = '".(float) $product_option_value['price']."', price_prefix = '".$this->db->escape($product_option_value['price_prefix'])."', points = '".(int) $product_option_value['points']."', points_prefix = '".$this->db->escape($product_option_value['points_prefix'])."', weight = '".(float) $product_option_value['weight']."', weight_prefix = '".$this->db->escape($product_option_value['weight_prefix'])."'");
                        }
                    }
                } else {
                    $this->db->query('INSERT INTO '.DB_PREFIX."product_option SET product_id = '".(int) $product_id."', option_id = '".(int) $product_option['option_id']."', value = '".$this->db->escape($product_option['value'])."', required = '".(int) $product_option['required']."'");
                }
            }
        }

        if (isset($data['product_discount'])) {
            foreach ($data['product_discount'] as $product_discount) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_discount SET product_id = '".(int) $product_id."', customer_group_id = '".(int) $product_discount['customer_group_id']."', quantity = '".(int) $product_discount['quantity']."', priority = '".(int) $product_discount['priority']."', price = '".(float) $product_discount['price']."', date_start = '".$this->db->escape($product_discount['date_start'])."', date_end = '".$this->db->escape($product_discount['date_end'])."'");
            }
        }

        if (isset($data['product_special'])) {
            foreach ($data['product_special'] as $product_special) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_special SET product_id = '".(int) $product_id."', customer_group_id = '".(int) $product_special['customer_group_id']."', priority = '".(int) $product_special['priority']."', price = '".(float) $product_special['price']."', date_start = '".$this->db->escape($product_special['date_start'])."', date_end = '".$this->db->escape($product_special['date_end'])."'");
            }
        }

        if (isset($data['product_image'])) {
            foreach ($data['product_image'] as $product_image) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_image SET product_id = '".(int) $product_id."', image = '".$this->db->escape($product_image['image'])."', sort_order = '".(int) $product_image['sort_order']."'");
            }
        }

        if (isset($data['product_download'])) {
            foreach ($data['product_download'] as $download_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_to_download SET product_id = '".(int) $product_id."', download_id = '".(int) $download_id."'");
            }
        }

        if (isset($data['product_category'])) {
            foreach ($data['product_category'] as $category_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_to_category SET product_id = '".(int) $product_id."', category_id = '".(int) $category_id."'");
            }
        }

        if (isset($data['product_filter'])) {
            foreach ($data['product_filter'] as $filter_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_filter SET product_id = '".(int) $product_id."', filter_id = '".(int) $filter_id."'");
            }
        }

        if (isset($data['product_related'])) {
            foreach ($data['product_related'] as $related_id) {
                $this->db->query('DELETE FROM '.DB_PREFIX."product_related WHERE product_id = '".(int) $product_id."' AND related_id = '".(int) $related_id."'");
                $this->db->query('INSERT INTO '.DB_PREFIX."product_related SET product_id = '".(int) $product_id."', related_id = '".(int) $related_id."'");
                $this->db->query('DELETE FROM '.DB_PREFIX."product_related WHERE product_id = '".(int) $related_id."' AND related_id = '".(int) $product_id."'");
                $this->db->query('INSERT INTO '.DB_PREFIX."product_related SET product_id = '".(int) $related_id."', related_id = '".(int) $product_id."'");
            }
        }

        if (isset($data['product_reward'])) {
            foreach ($data['product_reward'] as $customer_group_id => $product_reward) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_reward SET product_id = '".(int) $product_id."', customer_group_id = '".(int) $customer_group_id."', points = '".(int) $product_reward['points']."'");
            }
        }

        if (isset($data['product_layout'])) {
            foreach ($data['product_layout'] as $store_id => $layout_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."product_to_layout SET product_id = '".(int) $product_id."', store_id = '".(int) $store_id."', layout_id = '".(int) $layout_id."'");
            }
        }

        if (isset($data['keyword'])) {
            $this->db->query('INSERT INTO '.DB_PREFIX."url_alias SET query = 'product_id=".(int) $product_id."', keyword = '".$this->db->escape($data['keyword'])."'");
        }

        if (isset($data['product_recurrings'])) {
            foreach ($data['product_recurrings'] as $recurring) {
                $this->db->query('INSERT INTO `'.DB_PREFIX.'product_recurring` SET `product_id` = '.(int) $product_id.', customer_group_id = '.(int) $recurring['customer_group_id'].', `recurring_id` = '.(int) $recurring['recurring_id']);
            }
        }

        $this->cache->delete('product');



        return $product_id;
    }

    public function getAttributes($data = array())
    {
        $sql = 'SELECT *, (SELECT agd.name FROM '.DB_PREFIX."attribute_group_description agd WHERE agd.attribute_group_id = a.attribute_group_id AND agd.language_id = '".(int) $this->config->get('config_language_id')."') AS attribute_group FROM ".DB_PREFIX.'attribute a LEFT JOIN '.DB_PREFIX."attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE ad.language_id = '".(int) $this->config->get('config_language_id')."'";

        if (!empty($data['filter_name'])) {
            $sql .= " AND ad.name LIKE '%".$this->db->escape($data['filter_name'])."%'";
        }

        if (!empty($data['filter_attribute_group_id'])) {
            $sql .= " AND a.attribute_group_id = '".$this->db->escape($data['filter_attribute_group_id'])."'";
        }

        $sort_data = array(
            'ad.name',
            'attribute_group',
            'a.sort_order',
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= ' ORDER BY '.$data['sort'];
        } else {
            $sql .= ' ORDER BY attribute_group, ad.name';
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= ' DESC';
        } else {
            $sql .= ' ASC';
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= ' LIMIT '.(int) $data['start'].','.(int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getSellerGroupCategories($seller_group_id)
    {
        $product_category_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."category_to_seller_group WHERE seller_group_id = '".(int) $seller_group_id."'");

        foreach ($query->rows as $result) {
            $product_category_data[] = $result['category_id'];
        }

        return $product_category_data;
    }

    public function getSellerCategories($seller_id , $status = 1)
    {
        $product_category_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."category_to_seller WHERE seller_id = '".(int) $seller_id."' AND status = '".(int) $status."'");

        foreach ($query->rows as $result) {
            $product_category_data[] = $result['category_id'];
        }

        return $product_category_data;
    }

    public function RequestApproval($product_id)
    {
      $this->db->query('UPDATE '.DB_PREFIX."product SET status = '2' WHERE product_id = '".(int) $product_id."'");


    }

}
