<?php

class Modelbankbank extends Model
{
    public function addbank($data)
    {
        $this->db->query('INSERT INTO '.DB_PREFIX."bank SET value = '0'");

        $bank_id = $this->db->getLastId();

        foreach ($data['bank_description'] as $language_id => $value) {
            $this->db->query('INSERT INTO '.DB_PREFIX."bank_description SET bank_id = '".(int) $bank_id."', language_id = '".(int) $language_id."', title = '".$this->db->escape($value['title'])."'");
        }

        $this->cache->delete('bank');
    }

    public function editbank($bank_id, $data)
    {
        $this->db->query('UPDATE '.DB_PREFIX."bank SET value = '0' WHERE bank_id = '".(int) $bank_id."'");

        $this->db->query('DELETE FROM '.DB_PREFIX."bank_description WHERE bank_id = '".(int) $bank_id."'");

        foreach ($data['bank_description'] as $language_id => $value) {
            $this->db->query('INSERT INTO '.DB_PREFIX."bank_description SET bank_id = '".(int) $bank_id."', language_id = '".(int) $language_id."', title = '".$this->db->escape($value['title'])."'");
        }

        $this->cache->delete('bank');
    }

    public function deletebank($bank_id)
    {
        $this->db->query('DELETE FROM '.DB_PREFIX."bank WHERE bank_id = '".(int) $bank_id."'");
        $this->db->query('DELETE FROM '.DB_PREFIX."bank_description WHERE bank_id = '".(int) $bank_id."'");

        $this->cache->delete('bank');
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

    public function getbank($bank_id)
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX.'bank wc LEFT JOIN '.DB_PREFIX."bank_description wcd ON (wc.bank_id = wcd.bank_id) WHERE wc.bank_id = '".(int) $bank_id."' AND wcd.language_id = '".(int) $this->config->get('config_language_id')."'");

        return $query->row;
    }

    public function getbankDescriptionByUnit($unit)
    {
        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."bank_description WHERE unit = '".$this->db->escape($unit)."' AND language_id = '".(int) $this->config->get('config_language_id')."'");

        return $query->row;
    }

    public function getbankDescriptions($bank_id)
    {
        $bank_data = array();

        $query = $this->db->query('SELECT * FROM '.DB_PREFIX."bank_description WHERE bank_id = '".(int) $bank_id."'");

        foreach ($query->rows as $result) {
            $bank_data[$result['language_id']] = array(
                'title' => $result['title'],

            );
        }

        return $bank_data;
    }

    public function getTotalbankes()
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX.'bank');

        return $query->row['total'];
    }

    public function getTotalcustomersBybankId($bank_id)
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM '.DB_PREFIX."bankaccount WHERE bank_id = '".$this->db->escape($bank_id)."'");

        return $query->row['total'];
    }
}
