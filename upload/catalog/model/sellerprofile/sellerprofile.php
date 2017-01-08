<?php

class Modelsellerprofilesellerprofile extends Model
{

    public function getseller($seller_id)
    {
        $query = $this->db->query('SELECT DISTINCT *,c.description as seller_description FROM '.DB_PREFIX.'customer  c

		LEFT JOIN '.DB_PREFIX.'seller_group_description  sgd ON (c.seller_group_id = sgd.seller_group_id)
		LEFT JOIN '.DB_PREFIX."seller_group sg ON (c.seller_group_id = sg.seller_group_id)
		WHERE customer_id = '".(int) $seller_id."'
		AND sgd.language_id = '".(int) $this->config->get('config_language_id')."'
		");

        return $query->row;
    }

    public function getSellerGroupId()
    {
        $seller_data = array();

        $query = $this->db->query('SELECT seller_group_id FROM '.DB_PREFIX."customer
		WHERE customer_id = '".(int) $this->customer->getID()."'

		");

        foreach ($query->rows as $result) {
            $seller_data[] = $result['seller_group_id'];
        }

        return $seller_data;
    }

    public function getsellerByEmail($email)
    {
        $query = $this->db->query('SELECT DISTINCT * FROM '.DB_PREFIX."customer WHERE LCASE(email) = '".$this->db->escape(utf8_strtolower($email))."'");

        return $query->row;
    }

    public function getsellers($data = array())
    {
        $sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cgd.name AS seller_group FROM ".DB_PREFIX.'customer c LEFT JOIN '.DB_PREFIX."seller_group_description cgd ON (c.seller_group_id = cgd.seller_group_id) WHERE cgd.language_id = '".(int) $this->config->get('config_language_id')."'";

        $implode = array();

        if (!empty($data['filter_name'])) {
            $implode[] = "CONCAT(c.firstname, ' ', c.lastname) LIKE '%".$this->db->escape($data['filter_name'])."%'";
        }

        if (!empty($data['filter_email'])) {
            $implode[] = "c.email LIKE '%".$this->db->escape($data['filter_email'])."%'";
        }

        if (isset($data['filter_newsletter']) && $data['filter_newsletter'] !== null) {
            $implode[] = "c.newsletter = '".(int) $data['filter_newsletter']."'";
        }

        if (!empty($data['filter_seller_group_id'])) {
            $implode[] = "c.seller_group_id = '".(int) $data['filter_seller_group_id']."'";
        }

        if (!empty($data['filter_ip'])) {
            $implode[] = 'c.seller_id IN (SELECT seller_id FROM '.DB_PREFIX."customer_ip WHERE ip = '".$this->db->escape($data['filter_ip'])."')";
        }

        if (isset($data['filter_status']) && $data['filter_status'] !== null) {
            $implode[] = "c.status = '".(int) $data['filter_status']."'";
        }

        if (isset($data['filter_seller_approved']) && $data['filter_seller_approved'] !== null) {
            $implode[] = "c.seller_approved = '".(int) $data['filter_seller_approved']."'";
        }

        if (!empty($data['filter_date_added'])) {
            $implode[] = "DATE(c.seller_date_added) = DATE('".$this->db->escape($data['filter_date_added'])."')";
        }

        if ($implode) {
            $sql .= ' AND '.implode(' AND ', $implode);
        }

        $sort_data = array(
            'name',
            'c.email',
            'seller_group',
            'c.status',
            'c.seller_approved',
            'c.ip',
            'c.seller_date_added',
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= ' ORDER BY '.$data['sort'];
        } else {
            $sql .= ' ORDER BY name';
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

    public function getSellerGroup($seller_group_id)
    {
        $query = $this->db->query('SELECT DISTINCT * FROM '.DB_PREFIX.'seller_group cg LEFT JOIN '.DB_PREFIX."seller_group_description cgd ON (cg.seller_group_id = cgd.seller_group_id) WHERE cg.seller_group_id = '".(int) $seller_group_id."' AND cgd.language_id = '".(int) $this->config->get('config_language_id')."'");

        return $query->rows;
    }

    public function getbankaccount($bankaccount_id)
    {
        $bankaccount_query = $this->db->query('SELECT * FROM '.DB_PREFIX."bankaccount WHERE bankaccount_id = '".(int) $bankaccount_id."'");

        if ($bankaccount_query->num_rows) {
            return array(
                'bankaccount_id' => $bankaccount_query->row['bankaccount_id'],
                'seller_id' => $bankaccount_query->row['customer_id'],
                'firstname' => $bankaccount_query->row['firstname'],
                'lastname' => $bankaccount_query->row['lastname'],
                'company_id' => $bankaccount_query->row['company_id'],
                'branch_id' => $bankaccount_query->row['branch_id'],
                'bankaccount_1' => $bankaccount_query->row['bankaccount_1'],
                'bank_id' => $bankaccount_query->row['bank_id'],
                'bankaccount_2' => $bankaccount_query->row['bankaccount_2'],

            );
        }
    }

    public function getbankaccounts($seller_id)
    {
        $bankaccount_data = array();

        $query = $this->db->query('SELECT bankaccount_id FROM '.DB_PREFIX."bankaccount WHERE customer_id = '".(int) $seller_id."'");

        foreach ($query->rows as $result) {
            $bankaccount_info = $this->getbankaccount($result['bankaccount_id']);

            if ($bankaccount_info) {
                $bankaccount_data[$result['bankaccount_id']] = $bankaccount_info;
            }
        }

        return $bankaccount_data;
    }

    public function addHistory($seller_id, $comment)
    {
        $this->db->query('INSERT INTO '.DB_PREFIX."customer_history SET customer_id = '".(int) $seller_id."', comment = '".$this->db->escape(strip_tags($comment))."', date_added = NOW()");
    }

    public function getHistories($seller_id, $start = 0, $limit = 10)
    {
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 10;
        }

        $query = $this->db->query('SELECT comment, date_added FROM '.DB_PREFIX."customer_history WHERE customer_id = '".(int) $seller_id."' ORDER BY date_added DESC LIMIT ".(int) $start.','.(int) $limit);

        return $query->rows;
    }

    public function getTotalHistories($seller_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."customer_history WHERE customer_id = '".(int) $seller_id."'");

        return $query->row['total'];
    }

    public function getTransactions($seller_id, $start = 0, $limit = 10)
    {
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 10;
        }

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."seller_transaction WHERE customer_id = '".(int) $seller_id."' ORDER BY date_added DESC LIMIT ".(int) $start.','.(int) $limit);

        return $query->rows;
    }

    public function getTotalTransactions($seller_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total  FROM '.DB_PREFIX."seller_transaction WHERE customer_id = '".(int) $seller_id."'");

        return $query->row['total'];
    }

    public function getTransactionTotal($seller_id)
    {
        $query = $this->db->query('SELECT SUM(amount) AS total FROM '.DB_PREFIX."seller_transaction WHERE customer_id = '".(int) $seller_id."'");

        return $query->row['total'];
    }

    public function getTotalTransactionsByOrderId($order_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."seller_transaction WHERE order_id = '".(int) $order_id."'");

        return $query->row['total'];
    }

    public function addrequest_membership($seller_id, $data)
    {
        $seller_info = $this->getseller($this->customer->getId());

        $this->load->language('sellerprofile/sellerprofile');

        $this->load->model('setting/store');
        if (isset($store_info)) {
            $store_info = $this->model_setting_store->getStores($seller_info['store_id']);
            $store_name = $store_info['name'];
            $store_url = $store_info['url'].'admin/index.php?route=common/login';
        } else {
            $store_name = $this->config->get('config_name');
            $store_url = HTTP_SERVER.'admin/index.php?route=common/login';
        }

        $customer_url = HTTP_SERVER.'admin/index.php?route=seller/seller';
        $message = $store_url."\n\n";

        $isseller = $this->customer->isSeller();
        if ($isseller != '0') {
            if ($seller_info['seller_approved'] == '0') {
                $this->db->query('
			UPDATE '.DB_PREFIX."customer
			SET seller_group_id = '".(int) $data['seller_group_id']."'	WHERE customer_id = '".(int) $this->customer->getId()."'
			");

                $this->db->query('DELETE FROM '.DB_PREFIX."category_to_seller WHERE seller_id = '".$this->customer->getId()."'");
                foreach ($data['seller_category'] as $category_id) {
                    $this->db->query('INSERT INTO '.DB_PREFIX."category_to_seller SET seller_id = '".$this->customer->getId()."', category_id = '".(int) $category_id."'");
                }

            // Sent to admin email
            $message = $this->language->get('text_firstname').' '.$seller_info['firstname']."\n";
                $message .= $this->language->get('text_lastname').' '.$seller_info['lastname']."\n";
                $message .= $this->language->get('text_seller_group').' '.$seller_info['name']."\n";
                $message .= $this->language->get('text_email').' '.$seller_info['email']."\n";
                $message .= $this->language->get('text_telephone').' '.$seller_info['telephone']."\n";

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
                $mail->setSubject(html_entity_decode(sprintf($this->language->get('text_add_request_subject'), ''), ENT_QUOTES, 'UTF-8'));
                $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
                $mail->send();
            } else {
                $this->db->query('
			UPDATE '.DB_PREFIX."customer
			SET seller_changegroup = '".(int) $data['seller_group_id']."'	WHERE customer_id = '".(int) $this->customer->getId()."'
			");

                $this->db->query('DELETE FROM '.DB_PREFIX."category_to_seller WHERE seller_id = '".$this->customer->getId()."'");
                  if (isset($data['seller_category'])) {
                foreach ($data['seller_category'] as $category_id) {
                    $this->db->query('INSERT INTO '.DB_PREFIX."category_to_seller SET seller_id = '".$this->customer->getId()."', category_id = '".(int) $category_id."'");
                }
              }
            // Sent to admin email
            $message = $this->language->get('text_firstname').' '.$seller_info['firstname']."\n";
                $message .= $this->language->get('text_lastname').' '.$seller_info['lastname']."\n";
                $message .= $this->language->get('text_seller_group').' '.$this->request->post['seller_group_name']."\n";
                $message .= $this->language->get('text_email').' '.$seller_info['email']."\n";
                $message .= $this->language->get('text_telephone').' '.$seller_info['telephone']."\n";

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
                $mail->setSubject(html_entity_decode(sprintf($this->language->get('text_upgrade_request_subject'), ''), ENT_QUOTES, 'UTF-8'));
                $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
                $mail->send();
            }
        } else {
            $this->db->query('
			UPDATE '.DB_PREFIX."customer
			SET seller_group_id = '".(int) $data['seller_group_id']."'	WHERE customer_id = '".(int) $this->customer->getId()."'
			");

            $this->db->query('DELETE FROM '.DB_PREFIX."category_to_seller WHERE seller_id = '".$this->customer->getId()."'");

            if (isset($data['seller_category'])) {

            foreach ($data['seller_category'] as $category_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."category_to_seller SET seller_id = '".$this->customer->getId()."', category_id = '".(int) $category_id."'");
            }
}
            // Sent to admin email
            $message = $this->language->get('text_firstname').' '.$this->customer->getFirstName()."\n";
            $message .= $this->language->get('text_lastname').' '.$this->customer->getLastName()."\n";
            $message .= $this->language->get('text_seller_group').' '.$this->request->post['seller_group_name']."\n";
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
            $mail->setSubject(html_entity_decode(sprintf($this->language->get('text_add_request_subject'), ''), ENT_QUOTES, 'UTF-8'));
            $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
            $mail->send();
        }

            // Sent to custuer email

            $message = sprintf($this->language->get('text_request_message'), $this->request->post['seller_group_name'])."\n\n";

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
        $mail->setSubject(html_entity_decode(sprintf($this->language->get('text_request_message'), $this->request->post['seller_group_name']), ENT_QUOTES, 'UTF-8'));
        $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
        $mail->send();
    }

    public function deleterequest_membership($order_id)
    {
        $this->db->query('DELETE FROM '.DB_PREFIX."customer_request_membership WHERE order_id = '".(int) $order_id."' AND points > 0");
    }

    public function getsellerreviewbysellerID($seller_id)
    {
        $query = $this->db->query('SELECT AVG(rating) AS total
		FROM '.DB_PREFIX."sellerreview r1
		WHERE r1.seller_id = '".(int) $seller_id."'
		AND r1.status = '1'
		GROUP BY r1.seller_id
		");

        return $query->row;
    }

    public function getsellerbadges()
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX.'badge_description  bd
		 LEFT JOIN '.DB_PREFIX."badge_to_seller bts ON (bts.badge_id = bd.badge_id) WHERE bd.language_id = '".(int) $this->config->get('config_language_id')."'
		 AND bts.seller_id =  '".(int) $this->customer->getid()."'

		");

        return $query->rows;
    }

    public function getsellerbadgesbysellerID($seller_id)
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX.'badge_description  bd
		 LEFT JOIN '.DB_PREFIX."badge_to_seller bts ON (bts.badge_id = bd.badge_id) WHERE bd.language_id = '".(int) $this->config->get('config_language_id')."'
		 AND bts.seller_id =  '".(int) $seller_id."'

		");

        return $query->rows;
    }


    public function getbadgeseller($seller_id)
    {
        $seller_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."badge_to_seller WHERE seller_id = '".(int) $seller_id."'");

        foreach ($query->rows as $result) {
            $seller_data[] = $result['badge_id'];
        }

        return $seller_data;
    }

    public function getProducts($start = 0, $limit = 10)
    {
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 10;
        }
        $sql = 'SELECT * FROM '.DB_PREFIX.'product p
		LEFT JOIN '.DB_PREFIX.'product_description pd ON (p.product_id = pd.product_id)
		LEFT JOIN '.DB_PREFIX."product_to_seller pts ON (p.product_id = pts.product_id)
		WHERE pd.language_id = '".(int) $this->config->get('config_language_id')."'
		AND pts.seller_id = '".(int) $this->customer->getid()."'

		";

        $sql .= ' GROUP BY p.product_id';

        $sql .= ' LIMIT '.(int) $start.','.(int) $limit;
        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotalProductsbysellerID($seller_id)
    {
        $sql = 'SELECT COUNT(DISTINCT p.product_id) AS total FROM '.DB_PREFIX.'product p
    LEFT JOIN '.DB_PREFIX.'product_description pd ON (p.product_id = pd.product_id)
    LEFT JOIN '.DB_PREFIX.'product_to_seller pts ON (p.product_id = pts.product_id)
    ';

        $sql .= " WHERE pts.seller_id = '".(int) $seller_id."'";

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getTotalProducts($data = array())
    {
        $sql = 'SELECT COUNT(DISTINCT p.product_id) AS total FROM '.DB_PREFIX.'product p
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

        $sql .= " AND pts.seller_id = '".(int) $this->customer->getid()."'";

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getsellerproducts($seller_id)
    {
        $seller_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."product_to_seller WHERE seller_id = '".(int) $seller_id."'");

        foreach ($query->rows as $result) {
            $seller_data[] = $result['product_id'];
        }

        return $seller_data;
    }

    public function getSellerGroups($data = array())
    {
        $sql = 'SELECT * FROM '.DB_PREFIX.'seller_group cg LEFT JOIN '.DB_PREFIX."seller_group_description cgd ON (cg.seller_group_id = cgd.seller_group_id) WHERE cgd.language_id = '".(int) $this->config->get('config_language_id')."' AND cg.status='1'";

        $sort_data = array(
            'cgd.name',
            'cg.sort_order',
            'cg.product_limit',
            'cg.subscription_price',
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= ' ORDER BY '.$data['sort'];
        } else {
            $sql .= ' ORDER BY cgd.name';
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

    public function getSellerGroupCommission($seller_group_id)
    {
        $sql = 'SELECT * FROM '.DB_PREFIX.'commission_rate_to_seller_group wc
			LEFT JOIN '.DB_PREFIX."commission_rate wcd ON (wc.commission_rate_id = wcd.commission_rate_id)
			WHERE wc.seller_group_id = '".(int) $seller_group_id."'";

        $query = $this->db->query($sql);
        if (isset($query->row['name'])) {
            return $query->row['name'];
        } else {
            return 0;
        }
    }

    public function getSellerGroupCommissionRate($seller_group_id)
    {
        $sql = 'SELECT * FROM '.DB_PREFIX.'commission_rate_to_seller_group wc
			LEFT JOIN '.DB_PREFIX."commission_rate wcd ON (wc.commission_rate_id = wcd.commission_rate_id)
			WHERE wc.seller_group_id = '".(int) $seller_group_id."'";

        $query = $this->db->query($sql);

        if (isset($query->row['rate'])) {
            return $query->row['rate'];
        } else {
            return 0;
        }
    }

    public function getbankes($data = array())
    {
        if ($data) {
            $sql = 'SELECT * FROM '.DB_PREFIX.'bank wc LEFT JOIN '.DB_PREFIX."bank_description wcd ON (wc.bank_id = wcd.bank_id) WHERE wcd.language_id = '".(int) $this->config->get('config_language_id')."'";

            $sort_data = array(
                'title',

            );

            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                $sql .= ' ORDER BY '.$data['sort'];
            } else {
                $sql .= ' ORDER BY title';
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
        } else {
            $bank_data = $this->cache->get('bank.'.(int) $this->config->get('config_language_id'));

            if (!$bank_data) {
                $query = $this->db->query('SELECT * FROM '.DB_PREFIX.'bank wc LEFT JOIN '.DB_PREFIX."bank_description wcd ON (wc.bank_id = wcd.bank_id) WHERE wcd.language_id = '".(int) $this->config->get('config_language_id')."'");

                $bank_data = $query->rows;

                $this->cache->set('bank.'.(int) $this->config->get('config_language_id'), $bank_data);
            }

            return $bank_data;
        }
    }

    public function getSellerrequest()
    {
        $seller_query = $this->db->query('
			SELECT * FROM '.DB_PREFIX."customer
			WHERE customer_id = '".(int) $this->customer->getId()."'
			");

        return $seller_query->row;
    }

    public function getProductsellers($product_id)
    {
        $query = $this->db->query('
		SELECT * FROM '.DB_PREFIX.'product_to_seller pts
		LEFT JOIN '.DB_PREFIX.'customer c ON (c.customer_id = pts.seller_id)
		LEFT JOIN '.DB_PREFIX.'seller_group_description  sgd ON (c.seller_group_id = sgd.seller_group_id)
		LEFT JOIN '.DB_PREFIX."seller_group sg ON (c.seller_group_id = sg.seller_group_id)
		WHERE product_id = '".(int) $product_id."'
		AND sgd.language_id = '".(int) $this->config->get('config_language_id')."'
		");

        return $query->row;
    }

    public function CancelRequest()
    {
  
        $this->db->query('
			UPDATE '.DB_PREFIX."customer
			SET 	seller_changegroup = '0'	WHERE customer_id = '".(int) $this->customer->getId()."'
			");

        return true;
    }


    public function Sellerdeleteimage()
    {
        $this->db->query('UPDATE '.DB_PREFIX."customer SET image = '' WHERE customer_id='".(int) $this->customer->getId()."'");
    }

    public function Sellerdeletebanner()
    {
        $this->db->query('UPDATE '.DB_PREFIX."customer SET banner = '' WHERE customer_id='".(int) $this->customer->getId()."'");
    }

    public function SellerProfileSave($data)
    {
      if (isset($data['image'])) {
        $this->db->query('UPDATE '.DB_PREFIX."customer SET image = '".$data['image']."' WHERE customer_id='".(int) $this->customer->getId()."'");
      }
      if (isset($data['banner'])) {
        $this->db->query('UPDATE '.DB_PREFIX."customer SET banner = '".$data['banner']."' WHERE customer_id='".(int) $this->customer->getId()."'");
      }
      if (isset($data['seller_description'])) {
        $this->db->query('UPDATE '.DB_PREFIX."customer SET description = '".$data['seller_description']."' WHERE customer_id='".(int) $this->customer->getId()."'");
      }
      if (isset($data['website'])) {
        $this->db->query('UPDATE '.DB_PREFIX."customer SET website = '".$data['website']."' WHERE customer_id='".(int) $this->customer->getId()."'");
      }
      if (isset($data['facebook'])) {
        $this->db->query('UPDATE '.DB_PREFIX."customer SET facebook = '".$data['facebook']."' WHERE customer_id='".(int) $this->customer->getId()."'");
      }
      if (isset($data['twitter'])) {
        $this->db->query('UPDATE '.DB_PREFIX."customer SET twitter = '".$data['twitter']."' WHERE customer_id='".(int) $this->customer->getId()."'");
      }
      if (isset($data['googleplus'])) {
        $this->db->query('UPDATE '.DB_PREFIX."customer SET googleplus = '".$data['googleplus']."' WHERE customer_id='".(int) $this->customer->getId()."'");
      }
      if (isset($data['instagram'])) {
        $this->db->query('UPDATE '.DB_PREFIX."customer SET instagram = '".$data['instagram']."' WHERE customer_id='".(int) $this->customer->getId()."'");
      }
      if (isset($data['nickname'])) {
      $this->db->query('UPDATE '.DB_PREFIX."customer SET nickname = '".$data['nickname']."' WHERE customer_id='".(int) $this->customer->getId()."'");
    }

    }
}
