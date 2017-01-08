<?php

class Modelbankaccountbankaccount extends Model
{
    public function addbankaccount($data)
    {
        

        $this->db->query('INSERT INTO '.DB_PREFIX."bankaccount SET customer_id = '".(int) $this->customer->getId()."', firstname = '".$this->db->escape($data['firstname'])."', lastname = '".$this->db->escape($data['lastname'])."', company_id = '".$this->db->escape($data['company_id'])."', branch_id = '".$this->db->escape($data['branch_id'])."', bankaccount_1 = '".$this->db->escape($data['bankaccount_1'])."', bankaccount_2 = '".$this->db->escape($data['bankaccount_2'])."', bank_id = '".(int) $data['bank_id']."'");

        $bankaccount_id = $this->db->getLastId();

        if (!empty($data['default'])) {
            $this->db->query('UPDATE '.DB_PREFIX."customer SET bankaccount_id = '".(int) $bankaccount_id."' WHERE customer_id = '".(int) $this->customer->getId()."'");
        }

        
        return $bankaccount_id;
    }

    public function editbankaccount($bankaccount_id, $data)
    {
        

        $this->db->query('UPDATE '.DB_PREFIX."bankaccount SET firstname = '".$this->db->escape($data['firstname'])."', lastname = '".$this->db->escape($data['lastname'])."', company_id = '".$this->db->escape(isset($data['company_id']) ? $data['company_id'] : '')."', branch_id = '".$this->db->escape(isset($data['branch_id']) ? $data['branch_id'] : '')."', bankaccount_1 = '".$this->db->escape($data['bankaccount_1'])."', bankaccount_2 = '".$this->db->escape($data['bankaccount_2'])."' , bank_id = '".(int) $data['bank_id']."' WHERE bankaccount_id  = '".(int) $bankaccount_id."' AND customer_id = '".(int) $this->customer->getId()."'");

        if (!empty($data['default'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET bankaccount_id = '" . (int)$bankaccount_id . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		}

        
    }

    public function deletebankaccount($bankaccount_id)
    {
        

        $this->db->query('DELETE FROM '.DB_PREFIX."bankaccount WHERE bankaccount_id = '".(int) $bankaccount_id."' AND customer_id = '".(int) $this->customer->getId()."'");

        
    }

    public function getbankaccount($bankaccount_id)
    {
        $bankaccount_query = $this->db->query('SELECT DISTINCT * FROM '.DB_PREFIX."bankaccount WHERE bankaccount_id = '".(int) $bankaccount_id."' AND customer_id = '".(int) $this->customer->getId()."'");

        if ($bankaccount_query->num_rows) {
            $bank_query = $this->db->query('SELECT * FROM '.DB_PREFIX.'bank wc LEFT JOIN '.DB_PREFIX."bank_description wcd ON (wc.bank_id = wcd.bank_id) WHERE wc.bank_id = '".(int) $bankaccount_query->row['bank_id']."' AND wcd.language_id = '".(int) $this->config->get('config_language_id')."'");

            if ($bank_query->num_rows) {
                $bank = $bank_query->row['title'];
            } else {
                $bank = '';
            }

            $bankaccount_data = array(
                'firstname' => $bankaccount_query->row['firstname'],
                'lastname' => $bankaccount_query->row['lastname'],
                'company' => $bankaccount_query->row['company'],
                'company_id' => $bankaccount_query->row['company_id'],
                'branch_id' => $bankaccount_query->row['branch_id'],
                'bankaccount_1' => $bankaccount_query->row['bankaccount_1'],
                'bankaccount_2' => $bankaccount_query->row['bankaccount_2'],
                'bank_id' => $bankaccount_query->row['bank_id'],
                'bank' => $bank,

            );

            return $bankaccount_data;
        } else {
            return false;
        }
    }

    public function getbankaccounts()
    {
        $bankaccount_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."bankaccount WHERE customer_id = '".(int) $this->customer->getId()."'");

        foreach ($query->rows as $result) {
            $country_query = $this->db->query('SELECT * FROM '.DB_PREFIX.'bank wc LEFT JOIN '.DB_PREFIX."bank_description wcd ON (wc.bank_id = wcd.bank_id) WHERE wc.bank_id = '".(int) $result['bank_id']."' AND wcd.language_id = '".(int) $this->config->get('config_language_id')."'");

            if ($country_query->num_rows) {
                $country = $country_query->row['title'];
            } else {
                $country = '';
            }

            $bankaccount_data[$result['bankaccount_id']] = array(
                'bankaccount_id' => $result['bankaccount_id'],
                'firstname' => $result['firstname'],
                'lastname' => $result['lastname'],
                'company' => $result['company'],
                'company_id' => $result['company_id'],
                'branch_id' => $result['branch_id'],
                'bankaccount_1' => $result['bankaccount_1'],
                'bankaccount_2' => $result['bankaccount_2'],

                'country' => $country,

            );
        }

        return $bankaccount_data;
    }

    public function getTotalbankaccounts()
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."bankaccount WHERE customer_id = '".(int) $this->customer->getId()."'");

        return $query->row['total'];
    }

    public function getbanks($data = array())
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
}
