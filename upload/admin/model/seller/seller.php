<?php

class ModelSellerseller extends Model
{
    public function addseller($data)
    {
        $this->db->query('INSERT INTO '.DB_PREFIX."customer SET seller_group_id = '".(int) $data['seller_group_id']."', firstname = '".$this->db->escape($data['firstname'])."', lastname = '".$this->db->escape($data['lastname'])."', email = '".$this->db->escape($data['email'])."', telephone = '".$this->db->escape($data['telephone'])."', fax = '".$this->db->escape($data['fax'])."', newsletter = '".(int) $data['newsletter']."', salt = '".$this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9))."', password = '".$this->db->escape(sha1($salt.sha1($salt.sha1($data['password']))))."', status = '".(int) $data['status']."', product_status = '".(int) $data['product_status']."', safe = '".(int) $data['safe']."', date_added = NOW()");

        $seller_id = $this->db->getLastId();

        if (isset($data['bankaccount'])) {
            foreach ($data['bankaccount'] as $bankaccount) {
                $this->db->query('INSERT INTO '.DB_PREFIX."bankaccount SET customer_id = '".(int) $seller_id."', firstname = '".$this->db->escape($bankaccount['firstname'])."', lastname = '".$this->db->escape($bankaccount['lastname'])."', company_id = '".$this->db->escape($bankaccount['company_id'])."', bankaccount_1 = '".$this->db->escape($bankaccount['bankaccount_1'])."', bankaccount_2 = '".$this->db->escape($bankaccount['bankaccount_2'])."' , branch_id = '".$this->db->escape($bankaccount['branch_id'])."', bank_id = '".(int) $bankaccount['bank_id']."'");

                if (isset($bankaccount['default'])) {
                    $bankaccount_id = $this->db->getLastId();

                    $this->db->query('UPDATE '.DB_PREFIX."customer SET bankaccount_id = '".(int) $bankaccount_id."' WHERE customer_id = '".(int) $seller_id."'");
                }
            }
        }

        if (isset($data['seller_badge'])) {
            foreach ($data['seller_badge'] as $seller_group_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."badge_to_seller SET seller_id = '".(int) $seller_id."', badge_id = '".(int) $seller_group_id."'");
            }
        }


        if (isset($data['seller_category'])) {
            foreach ($data['seller_category'] as $category_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."category_to_seller SET seller_id = '".(int) $seller_id."', category_id = '".(int) $category_id."', status ='1'");
            }
        }

    }

    public function addtoseller($seller_group_id, $seller_id)
    {
        $seller_info = $this->getseller($seller_id);

        if ($seller_info) {
            $this->db->query('UPDATE '.DB_PREFIX."customer SET seller_group_id = '".(int) $seller_group_id."' , seller_date_added = NOW() WHERE customer_id = '".(int) $seller_id."'");
        }
    }

    public function editseller($seller_id, $data)
    {
        $this->db->query('UPDATE '.DB_PREFIX."customer SET seller_group_id = '".(int) $data['seller_group_id']."', firstname = '".$this->db->escape($data['firstname'])."', lastname = '".$this->db->escape($data['lastname'])."', email = '".$this->db->escape($data['email'])."', telephone = '".$this->db->escape($data['telephone'])."', fax = '".$this->db->escape($data['fax'])."', newsletter = '".(int) $data['newsletter']."', status = '".(int) $data['status']."', product_status = '".(int) $data['product_status']."', safe = '".(int) $data['safe']."', image = '". $data['image']."', banner = '". $data['banner']."', description = '". $data['seller_description']."', website = '". $data['website']."', facebook = '". $data['facebook']."', twitter = '". $data['twitter']."',nickname = '". $data['nickname']."', googleplus = '". $data['googleplus']."', instagram = '". $data['instagram']."' WHERE customer_id = '".(int) $seller_id."'");

        if ($data['password']) {
            $this->db->query('UPDATE '.DB_PREFIX."customer SET salt = '".$this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9))."', password = '".$this->db->escape(sha1($salt.sha1($salt.sha1($data['password']))))."' WHERE customer_id = '".(int) $seller_id."'");
        }

        $this->db->query('DELETE FROM '.DB_PREFIX."bankaccount WHERE customer_id = '".(int) $seller_id."'");

        if (isset($data['bankaccount'])) {
            foreach ($data['bankaccount'] as $bankaccount) {
                $this->db->query('INSERT INTO '.DB_PREFIX."bankaccount SET bankaccount_id = '".(int) $bankaccount['bankaccount_id']."', customer_id = '".(int) $seller_id."', firstname = '".$this->db->escape($bankaccount['firstname'])."', lastname = '".$this->db->escape($bankaccount['lastname'])."', company_id = '".$this->db->escape($bankaccount['company_id'])."', bankaccount_1 = '".$this->db->escape($bankaccount['bankaccount_1'])."', bankaccount_2 = '".$this->db->escape($bankaccount['bankaccount_2'])."' , branch_id = '".$this->db->escape($bankaccount['branch_id'])."', bank_id = '".(int) $bankaccount['bank_id']."'");

                if (isset($bankaccount['default'])) {
                    $bankaccount_id = $this->db->getLastId();

                    $this->db->query('UPDATE '.DB_PREFIX."customer SET bankaccount_id = '".(int) $bankaccount_id."' WHERE customer_id = '".(int) $seller_id."'");
                }
            }
        }
        $this->db->query('DELETE FROM '.DB_PREFIX."badge_to_seller WHERE seller_id = '".(int) $seller_id."'");

        if (isset($data['seller_badge'])) {
            foreach ($data['seller_badge'] as $seller_group_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."badge_to_seller SET seller_id = '".(int) $seller_id."', badge_id = '".(int) $seller_group_id."'");
            }
        }

        $this->db->query('DELETE FROM '.DB_PREFIX."category_to_seller WHERE seller_id = '".(int) $seller_id."' AND status ='1'");

        if (isset($data['seller_category'])) {
            foreach ($data['seller_category'] as $category_id) {
                $this->db->query('INSERT INTO '.DB_PREFIX."category_to_seller SET seller_id = '".(int) $seller_id."', category_id = '".(int) $category_id."', status ='1'");
            }
        }

    }

    public function seller_category_approve($seller_id, $category_id)
    {

      $this->db->query('UPDATE '.DB_PREFIX."category_to_seller SET status ='1' WHERE seller_id = '".(int) $seller_id."' AND category_id = '".(int) $category_id."'");

    }

    public function editToken($seller_id, $token)
    {
        $this->db->query('UPDATE '.DB_PREFIX."customer SET token = '".$this->db->escape($token)."' WHERE customer_id = '".(int) $seller_id."'");
    }

    public function deleteseller($seller_id)
    {
        $this->db->query('UPDATE '.DB_PREFIX."customer SET seller_group_id = '0' ,  seller_approved = '0' ,seller_changegroup = '0'WHERE customer_id = '".(int) $seller_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."category_to_seller WHERE seller_id = '".(int) $seller_id."'");
    }

    public function getseller($seller_id)
    {
        $query = $this->db->query('SELECT DISTINCT * FROM '.DB_PREFIX."customer WHERE customer_id = '".(int) $seller_id."'");

        return $query->row;
    }

    public function getsellerByEmail($email)
    {
        $query = $this->db->query('SELECT DISTINCT * FROM '.DB_PREFIX."customer WHERE LCASE(email) = '".$this->db->escape(utf8_strtolower($email))."'");

        return $query->row;
    }

    public function getsellecategory($seller_id)
    {
      $query = $this->db->query('SELECT DISTINCT * FROM '.DB_PREFIX."category_to_seller WHERE seller_id = '".(int) $seller_id."' AND status = 0");

      return $query->row;



    }

    public function getsellers($data = array())
    {
        $sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cgd.name AS seller_group, c.seller_group_id AS seller_group_id
        FROM ".DB_PREFIX.'customer c
        LEFT JOIN '.DB_PREFIX.'seller_group_description cgd
        ON (c.seller_group_id = cgd.seller_group_id)
        LEFT JOIN
        (
        SELECT cgd2.seller_group_id,cgd2.name AS seller_group_upgrade FROM '.DB_PREFIX.'seller_group_description cgd2
        WHERE cgd2.language_id = '.(int) $this->config->get('config_language_id').'
        ) cgd2
        ON (c.seller_changegroup = cgd2.seller_group_id)

        LEFT JOIN
        (
        SELECT *,COUNT(pts.seller_id) AS product_total FROM '.DB_PREFIX."product_to_seller pts
        GROUP BY pts.seller_id
        ) pts
        ON (c.customer_id = pts.seller_id)
        WHERE cgd.language_id = '".(int) $this->config->get('config_language_id')."'";

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
            $implode[] = 'c.customer_id IN (SELECT customer_id FROM '.DB_PREFIX."customer_ip WHERE ip = '".$this->db->escape($data['filter_ip'])."')";
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
            'pts.seller_id',
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

    public function getsellergroup($seller_group_id)
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."seller_group_description WHERE seller_group_id = '".$seller_group_id."' AND language_id = '".(int) $this->config->get('config_language_id')."'");

        return $query->row;
    }

    public function getsellergroupIdBysellerId($seller_id)
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX.'customer c
		LEFT JOIN '.DB_PREFIX.'seller_group sg ON (c.seller_group_id = sg.seller_group_id)
		LEFT JOIN '.DB_PREFIX."seller_group_description sgd ON (c.seller_group_id = sgd.seller_group_id)
		 WHERE c.customer_id =  '".$seller_id."'

		 AND sgd.language_id = '".(int) $this->config->get('config_language_id')."'");

        return $query->row;
    }

    public function getsellergroupIdRequsetBysellerId($seller_id)
    {
        $query = $this->db->query('
		SELECT sgd.name FROM '.DB_PREFIX.'customer c
		LEFT JOIN '.DB_PREFIX.'seller_group sg ON (c.seller_changegroup = sg.seller_group_id)
		LEFT JOIN '.DB_PREFIX."seller_group_description sgd ON (c.seller_changegroup = sgd.seller_group_id)
		WHERE c.customer_id =  '".$seller_id."'
		AND sgd.language_id = '".(int) $this->config->get('config_language_id')."'");

        return $query->row;
    }

    public function approve($seller_id)
    {
        $seller_info = $this->getseller($seller_id);

        if ($seller_info) {
            $this->db->query('UPDATE '.DB_PREFIX."customer SET seller_approved = '1' ,seller_date_added = NOW() WHERE customer_id = '".(int) $seller_id."'");

            $this->db->query('UPDATE '.DB_PREFIX."category_to_seller SET status = '1' WHERE seller_id = '".(int) $seller_id."'");

            $this->load->language('seller/mail_seller');

            $this->load->model('setting/store');

            $store_info = $this->model_setting_store->getStore($seller_info['store_id']);

            if ($store_info) {
                $store_name = $store_info['name'];
                $store_url = $store_info['url'].'index.php?route=account/login';
            } else {
                $store_name = $this->config->get('config_name');
                $store_url = HTTP_CATALOG.'index.php?route=sellerprofile/sellerprofile';
            }

            $message = sprintf($this->language->get('text_approve_welcome'), $store_name)."\n\n";
            $message .= $this->language->get('text_approve_login')."\n";
            $message .= $store_url."\n\n";
            $message .= $this->language->get('text_approve_services')."\n\n";
            $message .= $this->language->get('text_approve_thanks')."\n";
            $message .= $store_name;

            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
            $mail->smtp_username = $this->config->get('config_mail_smtp_username');
            $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
            $mail->smtp_port = $this->config->get('config_mail_smtp_port');
            $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
            $mail->setTo($seller_info['email']);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($store_name);
            $mail->setSubject(sprintf($this->language->get('text_approve_subject'), $store_name));
            $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
            $mail->send();
        }
    }

    public function upgrade_sellergroup($seller_id)
    {
        $seller_info = $this->getseller($seller_id);

        if ($seller_info) {
            $this->db->query('UPDATE '.DB_PREFIX.'customer SET seller_group_id = (
			SELECT seller_changegroup from (SELECT * from '.DB_PREFIX."customer ) as x WHERE customer_id = '".(int) $seller_id."'
			) WHERE customer_id = '".(int) $seller_id."'");

            $this->db->query('UPDATE '.DB_PREFIX."customer SET seller_changegroup = '0' WHERE customer_id = '".(int) $seller_id."'");

            $this->load->language('seller/mail_seller');

            $this->load->model('setting/store');

            $store_info = $this->model_setting_store->getStore($seller_info['store_id']);

            if ($store_info) {
                $store_name = $store_info['name'];
                $store_url = $store_info['url'].'index.php?route=account/login';
            } else {
                $store_name = $this->config->get('config_name');
                $store_url = HTTP_CATALOG.'index.php?route=account/login';
            }

            $message = sprintf($this->language->get('text_upgrade_welcome'), $store_name)."\n\n";
            $message .= $this->language->get('text_upgrade_login')."\n";
            $message .= $store_url."\n\n";
            $message .= $this->language->get('text_upgrade_services')."\n\n";
            $message .= $this->language->get('text_upgrade_thanks')."\n";
            $message .= $store_name;

            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
            $mail->smtp_username = $this->config->get('config_mail_smtp_username');
            $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
            $mail->smtp_port = $this->config->get('config_mail_smtp_port');
            $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
            $mail->setTo($seller_info['email']);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($store_name);
            $mail->setSubject(sprintf($this->language->get('text_upgrade_subject'), $store_name));
            $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
            $mail->send();
        }
    }

    public function disapprove($seller_id)
    {
        $seller_info = $this->getseller($seller_id);

        if ($seller_info) {
            $this->db->query('UPDATE '.DB_PREFIX."customer SET seller_approved = '0' WHERE customer_id = '".(int) $seller_id."'");

            $this->load->language('seller/mail_seller');

            $this->load->model('setting/store');

            $store_info = $this->model_setting_store->getStore($seller_info['store_id']);

            if ($store_info) {
                $store_name = $store_info['name'];
                $store_url = $store_info['url'].'index.php?route=account/login';
            } else {
                $store_name = $this->config->get('config_name');
                $store_url = HTTP_CATALOG.'index.php?route=account/login';
            }

            $message = $this->language->get('text_disapprove_login')."\n";
            $message .= $store_url."\n\n";

            $message .= $this->language->get('text_disapprove_thanks')."\n";
            $message .= $store_name;

            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
            $mail->smtp_username = $this->config->get('config_mail_smtp_username');
            $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
            $mail->smtp_port = $this->config->get('config_mail_smtp_port');
            $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
            $mail->setTo($seller_info['email']);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($store_name);
            $mail->setSubject(sprintf($this->language->get('text_disapprove_subject'), $store_name));
            $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
            $mail->send();
        }
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

    public function getTotalsellers($data = array())
    {
        $sql = 'SELECT COUNT(*) AS total FROM '.DB_PREFIX.'customer';

        $implode = array();

        if (!empty($data['filter_name'])) {
            $implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%".$this->db->escape($data['filter_name'])."%'";
        }

        if (!empty($data['filter_email'])) {
            $implode[] = "email LIKE '%".$this->db->escape($data['filter_email'])."%'";
        }

        if (isset($data['filter_newsletter']) && $data['filter_newsletter'] !== null) {
            $implode[] = "newsletter = '".(int) $data['filter_newsletter']."'";
        }

        if (!empty($data['filter_seller_group_id'])) {
            $implode[] = "seller_group_id = '".(int) $data['filter_seller_group_id']."'";
        }

        if (!empty($data['filter_ip'])) {
            $implode[] = 'customer_id IN (SELECT customer_id FROM '.DB_PREFIX."customer_ip WHERE ip = '".$this->db->escape($data['filter_ip'])."')";
        }

        if (isset($data['filter_status']) && $data['filter_status'] !== null) {
            $implode[] = "status = '".(int) $data['filter_status']."'";
        }

        if (isset($data['filter_seller_approved']) && $data['filter_seller_approved'] !== null) {
            $implode[] = "seller_approved = '".(int) $data['filter_seller_approved']."'";
            $implode[] = "seller_group_id != '0'";
        }

        if (!empty($data['filter_date_added'])) {
            $implode[] = "DATE(date_added) = DATE('".$this->db->escape($data['filter_date_added'])."')";
        }

        $implode[] = "seller_group_id != '0'";

        if ($implode) {
            $sql .= ' WHERE '.implode(' AND ', $implode);
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getTotalsellersAwaitingApproval()
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."customer WHERE status = '0' OR seller_approved = '0'");

        return $query->row['total'];
    }

    public function getTotalbankaccountsBysellerId($seller_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."bankaccount WHERE customer_id = '".(int) $seller_id."'");

        return $query->row['total'];
    }

    public function getTotalbankaccountsByCountryId($country_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."bankaccount WHERE country_id = '".(int) $country_id."'");

        return $query->row['total'];
    }

    public function getTotalbankaccountsByZoneId($zone_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."bankaccount WHERE zone_id = '".(int) $zone_id."'");

        return $query->row['total'];
    }

    public function getTotalsellersBysellerGroupId($seller_group_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."customer WHERE seller_group_id = '".(int) $seller_group_id."'");

        return $query->row['total'];
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

    public function addTransaction($seller_id, $description = '', $amount = '', $order_id = 0)
    {
        $seller_info = $this->getseller($seller_id);

        if ($seller_info) {
            $this->db->query('INSERT INTO '.DB_PREFIX."seller_transaction SET customer_id = '".(int) $seller_id."', order_id = '".(int) $order_id."', description = '".$this->db->escape($description)."', amount = '".(float) $amount."', date_added = NOW()");

            $this->load->language('seller/mail_seller');

            $this->load->model('setting/store');

            $store_info = $this->model_setting_store->getStore($seller_info['store_id']);

            if ($store_info) {
                $store_name = $store_info['name'];
            } else {
                $store_name = $this->config->get('config_name');
            }

            $message = sprintf($this->language->get('text_transaction_received'), $this->currency->format($amount, $this->config->get('config_currency')))."\n\n";
            $message .= sprintf($this->language->get('text_transaction_total'), $this->currency->format($this->getTransactionTotal($seller_id), $this->config->get('config_currency')));

            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
            $mail->smtp_username = $this->config->get('config_mail_smtp_username');
            $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
            $mail->smtp_port = $this->config->get('config_mail_smtp_port');
            $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
            $mail->setTo($seller_info['email']);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($store_name);
            $mail->setSubject(sprintf($this->language->get('text_transaction_subject'), $this->config->get('config_name')));
            $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
            $mail->send();
        }
    }

    public function deleteTransaction($order_id)
    {
        $this->db->query('DELETE FROM '.DB_PREFIX."seller_transaction WHERE order_id = '".(int) $order_id."'");
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

    public function addReward($seller_id, $description = '', $points = '', $order_id = 0)
    {
        $seller_info = $this->getseller($seller_id);

        if ($seller_info) {
            $this->db->query('INSERT INTO '.DB_PREFIX."customer_reward SET customer_id = '".(int) $seller_id."', order_id = '".(int) $order_id."', points = '".(int) $points."', description = '".$this->db->escape($description)."', date_added = NOW()");

            $this->load->language('seller/mail_seller');

            $this->load->model('setting/store');

            $store_info = $this->model_setting_store->getStore($seller_info['store_id']);

            if ($store_info) {
                $store_name = $store_info['name'];
            } else {
                $store_name = $this->config->get('config_name');
            }

            $message = sprintf($this->language->get('text_reward_received'), $points)."\n\n";
            $message .= sprintf($this->language->get('text_reward_total'), $this->getRewardTotal($seller_id));

            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
            $mail->smtp_username = $this->config->get('config_mail_smtp_username');
            $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
            $mail->smtp_port = $this->config->get('config_mail_smtp_port');
            $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
            $mail->setTo($seller_info['email']);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($store_name);
            $mail->setSubject(sprintf($this->language->get('text_reward_subject'), $store_name));
            $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
            $mail->send();
        }
    }

    public function deleteReward($order_id)
    {
        $this->db->query('DELETE FROM '.DB_PREFIX."customer_reward WHERE order_id = '".(int) $order_id."' AND points > 0");
    }

    public function getRewards($seller_id, $start = 0, $limit = 10)
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."customer_reward WHERE customer_id = '".(int) $seller_id."' ORDER BY date_added DESC LIMIT ".(int) $start.','.(int) $limit);

        return $query->rows;
    }

    public function getTotalRewards($seller_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."customer_reward WHERE customer_id = '".(int) $seller_id."'");

        return $query->row['total'];
    }

    public function getRewardTotal($seller_id)
    {
        $query = $this->db->query('SELECT SUM(points) AS total FROM '.DB_PREFIX."customer_reward WHERE customer_id = '".(int) $seller_id."'");

        return $query->row['total'];
    }

    public function getTotalsellerRewardsByOrderId($order_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."customer_reward WHERE order_id = '".(int) $order_id."'");

        return $query->row['total'];
    }

    public function getIps($seller_id)
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."customer_ip WHERE customer_id = '".(int) $seller_id."'");

        return $query->rows;
    }

    public function getTotalIps($seller_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."customer_ip WHERE customer_id = '".(int) $seller_id."'");

        return $query->row['total'];
    }

    public function getTotalsellersByIp($ip)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."customer_ip WHERE ip = '".$this->db->escape($ip)."'");

        return $query->row['total'];
    }

    public function addBanIp($ip)
    {
        $this->db->query('INSERT INTO `'.DB_PREFIX."customer_ban_ip` SET `ip` = '".$this->db->escape($ip)."'");
    }

    public function removeBanIp($ip)
    {
        $this->db->query('DELETE FROM `'.DB_PREFIX."customer_ban_ip` WHERE `ip` = '".$this->db->escape($ip)."'");
    }

    public function getTotalBanIpsByIp($ip)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM `'.DB_PREFIX."customer_ban_ip` WHERE `ip` = '".$this->db->escape($ip)."'");

        return $query->row['total'];
    }

    public function getCustomers($data = array())
    {
        $sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cgd.name AS customer_group
		FROM ".DB_PREFIX."customer c
    LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id)
LEFT JOIN (SELECT sgd.name AS seller_group,sgd.seller_group_id FROM ".DB_PREFIX."seller_group_description sgd
WHERE sgd.language_id = '" . (int)$this->config->get('config_language_id') . "'
) sg on (c.seller_group_id = sg.seller_group_id)

WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'
    ";

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
            $implode[] = "sg.seller_group_id = '".(int) $data['filter_seller_group_id']."'";
        }

        if (!empty($data['filter_customer_group_id'])) {
            $implode[] = "c.customer_group_id = '".(int) $data['filter_customer_group_id']."'";
        }

        if (!empty($data['filter_ip'])) {
            $implode[] = 'c.customer_id IN (SELECT customer_id FROM '.DB_PREFIX."customer_ip WHERE ip = '".$this->db->escape($data['filter_ip'])."')";
        }

        if (isset($data['filter_status']) && $data['filter_status'] !== null) {
            $implode[] = "c.status = '".(int) $data['filter_status']."'";
        }

        if (isset($data['filter_approved']) && $data['filter_approved'] !== null) {
            $implode[] = "c.seller_approved = '".(int) $data['filter_approved']."'";
        }

        if (!empty($data['filter_date_added'])) {
            $implode[] = "DATE(c.date_added) = DATE('".$this->db->escape($data['filter_date_added'])."')";
        }

        if ($implode) {
            $sql .= ' AND '.implode(' AND ', $implode);
        }

        $sort_data = array(
            'name',
            'c.email',
            'customer_group',
            'sg.seller_group',
            'c.status',
            'c.approved',
            'c.ip',
            'c.date_added',
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

    public function getTotalCustomers($data = array())
    {
        $sql = 'SELECT COUNT(*) AS total FROM '.DB_PREFIX."customer  ";

        $implode = array();

        if (!empty($data['filter_name'])) {
            $implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%".$this->db->escape($data['filter_name'])."%'";
        }

        if (!empty($data['filter_email'])) {
            $implode[] = "email LIKE '%".$this->db->escape($data['filter_email'])."%'";
        }

        if (isset($data['filter_newsletter']) && $data['filter_newsletter'] !== null) {
            $implode[] = "newsletter = '".(int) $data['filter_newsletter']."'";
        }

        if (!empty($data['filter_customer_group_id'])) {
            $implode[] = "customer_group_id = '".(int) $data['filter_customer_group_id']."'";
        }

        if (!empty($data['filter_ip'])) {
            $implode[] = 'customer_id IN (SELECT customer_id FROM '.DB_PREFIX."customer_ip WHERE ip = '".$this->db->escape($data['filter_ip'])."')";
        }

        if (isset($data['filter_status']) && $data['filter_status'] !== null) {
            $implode[] = "status = '".(int) $data['filter_status']."'";
        }

        if (isset($data['filter_approved']) && $data['filter_approved'] !== null) {
            $implode[] = "seller_approved = '".(int) $data['filter_approved']."'";
        }

        if (!empty($data['filter_date_added'])) {
            $implode[] = "DATE(date_added) = DATE('".$this->db->escape($data['filter_date_added'])."')";
        }

        if ($implode) {
            $sql .= ' WHERE '.implode(' AND ', $implode);
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getbadges()
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."badge_description  WHERE language_id = '".(int) $this->config->get('config_language_id')."'");

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

    public function getProducts($seller_id, $start = 0, $limit = 10)
    {
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 10;
        }
        $sql = '
		SELECT * FROM '.DB_PREFIX.'product p
		LEFT JOIN '.DB_PREFIX.'product_description pd
		ON (p.product_id = pd.product_id)
		LEFT JOIN '.DB_PREFIX."product_to_seller pts
		ON (p.product_id = pts.product_id)
		WHERE pd.language_id = '".(int) $this->config->get('config_language_id')."'";

        $sql .= " AND pts.seller_id ='".(int) $seller_id."' ";

        $sql .= ' GROUP BY p.product_id';

        $sql .= ' LIMIT '.(int) $start.','.(int) $limit;
        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getProductsSeller($data = array()) {
		$sql = "SELECT *,p.image as image,CONCAT(c.firstname, ' ', c.lastname) AS seller,p.status as status FROM " . DB_PREFIX . "product_to_seller pts LEFT JOIN " . DB_PREFIX . "product_description pd ON (pts.product_id = pd.product_id) LEFT JOIN ".DB_PREFIX."product p
		ON (p.product_id = pts.product_id)
    LEFT JOIN " . DB_PREFIX . "customer c ON (pts.seller_id = c.customer_id)
    WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

    if (!empty($data['filter_seller'])) {
			$sql .= " AND CONCAT(c.firstname, ' ', c.lastname) LIKE '" . $this->db->escape($data['filter_seller']) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (isset($data['filter_price']) && !is_null($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.product_id ,seller";

		$sort_data = array(
			'pd.name',
      'seller',
			'p.model',
			'p.price',
			'p.quantity',
			'p.status',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

    public function getTotalProducts($seller_id,$data = array())
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

        $sql .= " AND pts.seller_id = '".(int) $seller_id."'";

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getTotalProductsSeller($data = array())
    {
        $sql = 'SELECT COUNT(DISTINCT p.product_id) AS total FROM '.DB_PREFIX.'product_to_seller pts
		LEFT JOIN '.DB_PREFIX.'product_description pd ON (pts.product_id = pd.product_id)
		LEFT JOIN '.DB_PREFIX.'product p ON (p.product_id = pts.product_id)

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

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getTotalsellerProducts($data = array())
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

    public function addsellerproduct($seller_id, $product_id)
    {
        $this->db->query('DELETE FROM `'.DB_PREFIX."product_to_seller` WHERE `product_id` = '".$product_id."'");

        $this->db->query('INSERT INTO '.DB_PREFIX."product_to_seller SET seller_id = '".(int) $seller_id."' , product_id = '".(int) $product_id."'");
    }
    public function deletesellerproduct($product_id)
    {
        $this->db->query('DELETE FROM `'.DB_PREFIX."product_to_seller` WHERE `product_id` = '".$product_id."'");
    }
    public function getTotalsellersBybadgeId($badge_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."badge_to_seller WHERE badge_id = '".$this->db->escape($badge_id)."'");

        return $query->row['total'];
    }
    public function getsellerGroups($data = array())
    {
        $sql = 'SELECT * FROM '.DB_PREFIX.'seller_group cg LEFT JOIN '.DB_PREFIX."seller_group_description cgd ON (cg.seller_group_id = cgd.seller_group_id) WHERE cgd.language_id = '".(int) $this->config->get('config_language_id')."'";

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
    public function getSellerSubscription()
    {
        $sql = '
		SELECT *
		FROM '.DB_PREFIX.'customer c
		LEFT JOIN '.DB_PREFIX.'seller_group cd ON (c.seller_group_id = cd.seller_group_id)
		LEFT JOIN '.DB_PREFIX."seller_group_description cgd ON (c.seller_group_id = cgd.seller_group_id)
		WHERE  c.seller_approved = '1'
		";

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getsellerCategories($seller_id)
    {
        $product_category_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."category_to_seller WHERE seller_id = '".(int) $seller_id."' AND status = 1");

        foreach ($query->rows as $result) {
            $product_category_data[] = $result['category_id'];
        }

        return $product_category_data;
    }

    public function getsellerCategoriesAonApproved($seller_id)
    {
        $product_category_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."category_to_seller WHERE seller_id = '".(int) $seller_id."' AND status = 0");

        foreach ($query->rows as $result) {
            $product_category_data[] = $result['category_id'];
        }

        return $product_category_data;
    }

    public function getProductSpecials($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' ORDER BY priority, price");

		return $query->rows;
	}

}
