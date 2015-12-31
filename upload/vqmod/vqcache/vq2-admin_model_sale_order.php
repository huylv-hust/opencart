<?php
class ModelSaleOrder extends Model {
	public function getOrder($order_id) {
		$order_query = $this->db->query("SELECT *, (SELECT CONCAT(c.firstname, ' ', c.lastname) FROM " . DB_PREFIX . "customer c WHERE c.customer_id = o.customer_id) AS customer FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");

		if ($order_query->num_rows) {
			$reward = 0;

			$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

			foreach ($order_product_query->rows as $product) {
				$reward += $product['reward'];
			}

			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");

			if ($country_query->num_rows) {
				$payment_iso_code_2 = $country_query->row['iso_code_2'];
				$payment_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$payment_zone_code = $zone_query->row['code'];
			} else {
				$payment_zone_code = '';
			}

			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");

			if ($country_query->num_rows) {
				$shipping_iso_code_2 = $country_query->row['iso_code_2'];
				$shipping_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$shipping_zone_code = $zone_query->row['code'];
			} else {
				$shipping_zone_code = '';
			}

			if ($order_query->row['affiliate_id']) {
				$affiliate_id = $order_query->row['affiliate_id'];
			} else {
				$affiliate_id = 0;
			}

			$this->load->model('marketing/affiliate');

			$affiliate_info = $this->model_marketing_affiliate->getAffiliate($affiliate_id);

			if ($affiliate_info) {
				$affiliate_firstname = $affiliate_info['firstname'];
				$affiliate_lastname = $affiliate_info['lastname'];
			} else {
				$affiliate_firstname = '';
				$affiliate_lastname = '';
			}

			$this->load->model('localisation/language');

			$language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);

			if ($language_info) {
				$language_code = $language_info['code'];
				$language_directory = $language_info['directory'];
			} else {
				$language_code = '';
				$language_directory = '';
			}

			return array(
				'order_id'                => $order_query->row['order_id'],
				'invoice_no'              => $order_query->row['invoice_no'],
				'invoice_prefix'          => $order_query->row['invoice_prefix'],
				'store_id'                => $order_query->row['store_id'],
				'store_name'              => $order_query->row['store_name'],
				'store_url'               => $order_query->row['store_url'],
				'customer_id'             => $order_query->row['customer_id'],
				'customer'                => $order_query->row['customer'],
				'customer_group_id'       => $order_query->row['customer_group_id'],
				'firstname'               => $order_query->row['firstname'],
				'lastname'                => $order_query->row['lastname'],
				'email'                   => $order_query->row['email'],
				'telephone'               => $order_query->row['telephone'],
				'fax'                     => $order_query->row['fax'],
				'custom_field'            => json_decode($order_query->row['custom_field'], true),
				'payment_firstname'       => $order_query->row['payment_firstname'],
				'payment_lastname'        => $order_query->row['payment_lastname'],
				'payment_company'         => $order_query->row['payment_company'],
				'payment_address_1'       => $order_query->row['payment_address_1'],
				'payment_address_2'       => $order_query->row['payment_address_2'],
				'payment_postcode'        => $order_query->row['payment_postcode'],
				'payment_city'            => $order_query->row['payment_city'],
				'payment_zone_id'         => $order_query->row['payment_zone_id'],
				'payment_zone'            => $order_query->row['payment_zone'],
				'payment_zone_code'       => $payment_zone_code,
				'payment_country_id'      => $order_query->row['payment_country_id'],
				'payment_country'         => $order_query->row['payment_country'],
				'payment_iso_code_2'      => $payment_iso_code_2,
				'payment_iso_code_3'      => $payment_iso_code_3,
				'payment_address_format'  => $order_query->row['payment_address_format'],
				'payment_custom_field'    => json_decode($order_query->row['payment_custom_field'], true),
				'payment_method'          => $order_query->row['payment_method'],
				'payment_code'            => $order_query->row['payment_code'],
				'shipping_firstname'      => $order_query->row['shipping_firstname'],
				'shipping_lastname'       => $order_query->row['shipping_lastname'],
				'shipping_company'        => $order_query->row['shipping_company'],
				'shipping_address_1'      => $order_query->row['shipping_address_1'],
				'shipping_address_2'      => $order_query->row['shipping_address_2'],
				'shipping_postcode'       => $order_query->row['shipping_postcode'],
				'shipping_city'           => $order_query->row['shipping_city'],
				'shipping_zone_id'        => $order_query->row['shipping_zone_id'],
				'shipping_zone'           => $order_query->row['shipping_zone'],
				'shipping_zone_code'      => $shipping_zone_code,
				'shipping_country_id'     => $order_query->row['shipping_country_id'],
				'shipping_country'        => $order_query->row['shipping_country'],
				'shipping_iso_code_2'     => $shipping_iso_code_2,
				'shipping_iso_code_3'     => $shipping_iso_code_3,
				'shipping_address_format' => $order_query->row['shipping_address_format'],
				'shipping_custom_field'   => json_decode($order_query->row['shipping_custom_field'], true),
				'shipping_method'         => $order_query->row['shipping_method'],
				'shipping_code'           => $order_query->row['shipping_code'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
				'reward'                  => $reward,
				'order_status_id'         => $order_query->row['order_status_id'],
				'affiliate_id'            => $order_query->row['affiliate_id'],
				'affiliate_firstname'     => $affiliate_firstname,
				'affiliate_lastname'      => $affiliate_lastname,
				'commission'              => $order_query->row['commission'],
				'language_id'             => $order_query->row['language_id'],
				'language_code'           => $language_code,
				'language_directory'      => $language_directory,
				'currency_id'             => $order_query->row['currency_id'],
				'currency_code'           => $order_query->row['currency_code'],
				'currency_value'          => $order_query->row['currency_value'],
				'ip'                      => $order_query->row['ip'],
				'forwarded_ip'            => $order_query->row['forwarded_ip'],
				'user_agent'              => $order_query->row['user_agent'],
				'accept_language'         => $order_query->row['accept_language'],
				'date_added'              => $order_query->row['date_added'],
				'date_modified'           => $order_query->row['date_modified']
			);
		} else {
			return;
		}
	}

public function getOrdersexport($data = array()) {
        
                $wh = ' WHERE 1 = 1';
                if(isset($_GET['filter_order_id']))
                    $wh .= ' AND oc_order.order_id ='.$_GET['filter_order_id'];
                
                if(isset($_GET['filter_date_modified']))
                    $wh .= ' AND oc_order.date_modified > "'.$_GET['filter_date_modified'].' 00:00:00" AND oc_order.date_modified  < "'.$_GET['filter_date_modified'].' 23:59:59"';
                if(isset($_GET['filter_date_added']))
                    $wh .= ' AND oc_order.date_added > "'.$_GET['filter_date_added'].' 00:00:00" AND oc_order.date_added  < "'.$_GET['filter_date_added'].' 23:59:59"';
                
                if(isset($_GET['filter_order_status']))
                    $wh .= ' AND oc_order.order_status_id ='.$_GET['filter_order_status'];
                else
                    $wh .= ' AND oc_order.order_status_id > 0';   
                
                if(isset($_GET['filter_total']))
                    $wh .= ' AND oc_order.total = "'.$_GET['filter_total'].'"';
                $sql = "SELECT oc_order.*, oc_order_product.product_id, oc_order_product.order_product_id, oc_order_product.model, oc_order_product.quantity, oc_order_product.price, oc_order_product.total, oc_product.jan, oc_product_description.name FROM oc_order LEFT JOIN oc_order_product ON oc_order.order_id = oc_order_product.order_id LEFT JOIN oc_product ON oc_order_product.product_id = oc_product.product_id LEFT JOIN oc_product_description ON oc_order_product.product_id = oc_product_description.product_id {$wh} ORDER BY oc_order.date_added DESC ";
                $query = $this->db->query($sql)->rows;

        //oc_product_attribute.text -> 商品分類名...
        $arr_order = array();
        $product = array();
        $arr_custom_field_json = array();
                $arr_shipping_custom_field_json = array();
        if(count($query) == 0) return array();
                foreach ($query as $key => $data)
        {
                    $arr_order[$data['order_id']] = $data;
                    $arr_custom_field_json[$data['order_id']] = array();
                    if($data['custom_field'])
                        $arr_custom_field_json[$data['order_id']] = json_decode($data['custom_field'],true);
                    
                    $arr_shipping_custom_field_json[$data['order_id']] = array();
                    if($data['shipping_custom_field'])
                        $arr_shipping_custom_field_json[$data['order_id']] = json_decode($data['shipping_custom_field'],true);   
        }
                
                foreach ($query as $key => $data)
        {
                    $arr_order[$data['order_id']] = $data;
                    $arr_custom_field_json[$data['order_id']] = array();
                    if($data['custom_field'])
                        $arr_custom_field_json[$data['order_id']] = json_decode($data['custom_field'],true);
                    
                    $arr_shipping_custom_field_json[$data['order_id']] = array();
                    
                    if($data['shipping_custom_field'])
                        $arr_shipping_custom_field_json[$data['order_id']] = json_decode($data['shipping_custom_field'],true);  
                    
                    $product_id = $data['product_id'];
                    $sql1 = "SELECT * FROM oc_product_attribute WHERE product_id = " . $product_id;
                    $query1 = $this->db->query($sql1)->rows;
                    foreach ($query1 as $key =>$v)
                    {
                            $product[$v['product_id']][] = $v['attribute_id'];
                            $tmp_text[$v['product_id']][] = $v['text'];
                    }     
        }
                //product
        foreach($product as $pk => $pv)
        {
                    $text[$pk]['商品分類名'] = '';
                    $text[$pk]['商品コード'] = '';
                    $text[$pk]['荷姿コード'] = '';
                    $text[$pk]['宇佐美仕入価格'] = '';
                    foreach($pv as $pvk => $pvv)
                    {
                        $attribute_id = $pvv;
                        $sql2 = "SELECT name FROM oc_attribute_description WHERE attribute_id = " . $attribute_id;
                        $query2 = $this->db->query($sql2)->rows;

                        if ($query2[0]['name'] ==  '商品分類名')
                        {
                                $text[$pk]['商品分類名'] = $tmp_text[$pk][$pvk];
                        }

                        if ($query2[0]['name'] ==  '商品コード')
                        {
                                $text[$pk]['商品コード'] = $tmp_text[$pk][$pvk];
                        }

                        if ($query2[0]['name'] ==  '荷姿コード')
                        {
                                $text[$pk]['荷姿コード'] = $tmp_text[$pk][$pvk];
                        }
                        if ($query2[0]['name'] ==  '宇佐美仕入価格')
                        {
                                $text[$pk]['宇佐美仕入価格'] = $tmp_text[$pk][$pvk];
                        }
                    }
        }
                
                // oc_customer.custom_field -> 宇佐美カード上6桁...
        $array_name_customer = array();
        foreach ($arr_custom_field_json as $order_id => $row_cus)
        {
                    $array_name_customer[$order_id]['宇佐美カード上6桁'] ='';
                    $array_name_customer[$order_id]['宇佐美カード下5桁'] ='';
                    $array_name_customer[$order_id]['宇佐美支店コード'] ='';

                    if(count($row_cus))
                    {
                        foreach($row_cus as $field_id => $name)
                        {
                            $sql2 = "SELECT name FROM oc_custom_field_description WHERE custom_field_id = " . $field_id;
                            $query2 = $this->db->query($sql2)->rows;
                            if(count($query2))
                            {
                                $row = current($query2);

                                if ($row['name'] ==  '宇佐美カード上6桁')
                                {
                                    $array_name_customer[$order_id]['宇佐美カード上6桁'] = $name;
                                }
                                if ($row['name'] ==  '宇佐美カード下5桁')
                                {
                                    $array_name_customer[$order_id]['宇佐美カード下5桁'] = $name;
                                }
                                if ($row['name'] ==  '宇佐美支店コード')
                                {
                                    $sql7 = "SELECT name FROM oc_custom_field_value_description WHERE custom_field_value_id = " . $name;
                                    $query7 = $this->db->query($sql7)->rows;
                                    $array_name_customer[$order_id]['宇佐美支店コード'] = $query7[0]['name'];
                                }
                            }
                        }
                    }
        }

            // Shipping                
            $shipping = array();
            foreach ($arr_shipping_custom_field_json as $order_id => $row_cus)
            {
                $shipping[$order_id]['部署名'] = '';
                if(count($row_cus))
                {
                    foreach($row_cus as $field_id => $name)
                    {
                        $sql3 = "SELECT name FROM oc_custom_field_description WHERE custom_field_id = " . $field_id;
                        $query3 = $this->db->query($sql3)->rows;

                        if(count($query3))
                        {
                            $row = current($query3);

                            if ($row['name'] ==  '部署名 1')
                            {
                                $shipping[$order_id]['部署名'] = $name;
                            } 
                        } 
                    }
                }

             }
            //oc_address.custom_field -> 部署 (複数ある場合はdefault addressのもの)
            $address_field_id = array();
            foreach($arr_order as $order_id => $data)
            {
                $customer_id = $data['customer_id'];
                $sql4 = "SELECT * FROM oc_address WHERE customer_id = " . $customer_id;
                $query4 = $this->db->query($sql4)->rows;
                foreach ($query4 as $k =>$v)
                {
                    $custom_field = array();
                    if($v['custom_field'])
                    $custom_field = json_decode($v['custom_field'], true);

                    if(count($custom_field))
                    {


                        foreach ($custom_field as $k1 => $v1)
                        {
                            $address_field_id[$order_id][$k1] = $v1;
                        }
                    }
                    else
                    {
                            $address_field_id[$order_id]['0'] = '0';
                    }
                }                   
            }
            $department = array();
            foreach ($address_field_id as $order_id => $row_add)
            {
                $department[$order_id]['部署名'] = '';
                foreach($row_add as $key => $val)
                {
                    if($val)
                    {

                        $sql6 = "SELECT name FROM oc_custom_field_description WHERE custom_field_id = " . $key;
                        $query6 = $this->db->query($sql6)->rows;                 

                        if(count($query6))
                        if ($query6[0]['name'] ==  '部署名 1')
                        {
                            $department[$order_id]['部署名'] = $address_field_id[$order_id][$key];
                        }
                        else
                        {
                                $department[$order_id]['部署名'] = '';
                        }
                    }
                }
            }
            
            foreach($query as $k => $data)
            {
                $query[$k]['商品分類名'] = isset($text[$data['product_id']]['商品分類名']) ? $text[$data['product_id']]['商品分類名'] : '' ;
                $query[$k]['商品コード'] = isset($text[$data['product_id']]['商品コード']) ? $text[$data['product_id']]['商品コード'] : '' ;
                $query[$k]['荷姿コード'] = isset($text[$data['product_id']]['荷姿コード']) ? $text[$data['product_id']]['荷姿コード'] : '';
                $query[$k]['宇佐美仕入価格'] = isset($text[$data['product_id']]['宇佐美仕入価格']) ? $text[$data['product_id']]['宇佐美仕入価格'] : '';
                $query[$k]['宇佐美カード上6桁'] = $array_name_customer[$data['order_id']]['宇佐美カード上6桁'];
                $query[$k]['宇佐美カード下5桁'] = $array_name_customer[$data['order_id']]['宇佐美カード下5桁'];
                $query[$k]['宇佐美支店コード'] = $array_name_customer[$data['order_id']]['宇佐美支店コード'];
                $query[$k]['部署名'] = isset($department[$data['order_id']]['部署名']) ? $department[$data['order_id']]['部署名'] : '';
                $query[$k]['部署'] = isset($shipping[$data['order_id']]['部署名']) ? $shipping[$data['order_id']]['部署名'] : '';

            }

        //var_dump($custom_field_id);
        //var_dump($arr_order);
        //die;
        
        return $query;

            }
	public function getOrders($data = array()) {
		$sql = "SELECT o.order_id, CONCAT(o.firstname, ' ', o.lastname) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status, o.shipping_code, o.total, o.currency_code, o.currency_value, o.date_added, o.date_modified FROM `" . DB_PREFIX . "order` o";

		if (isset($data['filter_order_status'])) {
			$implode = array();

			$order_statuses = explode(',', $data['filter_order_status']);

			foreach ($order_statuses as $order_status_id) {
				$implode[] = "o.order_status_id = '" . (int)$order_status_id . "'";
			}

			if ($implode) {
				$sql .= " WHERE (" . implode(" OR ", $implode) . ")";
			}
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
		}

		$sort_data = array(
			'o.order_id',
			'customer',
			'status',
			'o.date_added',
			'o.date_modified',
			'o.total'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY o.order_id";
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

	public function getOrderProducts($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderOptions($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");

		return $query->rows;
	}

	public function getOrderVouchers($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderVoucherByVoucherId($voucher_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_voucher` WHERE voucher_id = '" . (int)$voucher_id . "'");

		return $query->row;
	}

	public function getOrderTotals($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order");

		return $query->rows;
	}

	public function getTotalOrders($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order`";

		if (isset($data['filter_order_status'])) {
			$implode = array();

			$order_statuses = explode(',', $data['filter_order_status']);

			foreach ($order_statuses as $order_status_id) {
				$implode[] = "order_status_id = '" . (int)$order_status_id . "'";
			}

			if ($implode) {
				$sql .= " WHERE (" . implode(" OR ", $implode) . ")";
			}
		} else {
			$sql .= " WHERE order_status_id > '0'";
		}

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND total = '" . (float)$data['filter_total'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalOrdersByStoreId($store_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE store_id = '" . (int)$store_id . "'");

		return $query->row['total'];
	}

	public function getTotalOrdersByOrderStatusId($order_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int)$order_status_id . "' AND order_status_id > '0'");

		return $query->row['total'];
	}

	public function getTotalOrdersByProcessingStatus() {
		$implode = array();

		$order_statuses = $this->config->get('config_processing_status');

		foreach ($order_statuses as $order_status_id) {
			$implode[] = "order_status_id = '" . (int)$order_status_id . "'";
		}

		if ($implode) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE " . implode(" OR ", $implode));

			return $query->row['total'];
		} else {
			return 0;
		}
	}

	public function getTotalOrdersByCompleteStatus() {
		$implode = array();

		$order_statuses = $this->config->get('config_complete_status');

		foreach ($order_statuses as $order_status_id) {
			$implode[] = "order_status_id = '" . (int)$order_status_id . "'";
		}

		if ($implode) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE " . implode(" OR ", $implode) . "");

			return $query->row['total'];
		} else {
			return 0;
		}
	}

	public function getTotalOrdersByLanguageId($language_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE language_id = '" . (int)$language_id . "' AND order_status_id > '0'");

		return $query->row['total'];
	}

	public function getTotalOrdersByCurrencyId($currency_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE currency_id = '" . (int)$currency_id . "' AND order_status_id > '0'");

		return $query->row['total'];
	}

	public function createInvoiceNo($order_id) {
		$order_info = $this->getOrder($order_id);

		if ($order_info && !$order_info['invoice_no']) {
			$query = $this->db->query("SELECT MAX(invoice_no) AS invoice_no FROM `" . DB_PREFIX . "order` WHERE invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "'");

			if ($query->row['invoice_no']) {
				$invoice_no = $query->row['invoice_no'] + 1;
			} else {
				$invoice_no = 1;
			}

			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET invoice_no = '" . (int)$invoice_no . "', invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "' WHERE order_id = '" . (int)$order_id . "'");

			return $order_info['invoice_prefix'] . $invoice_no;
		}
	}

	public function getOrderHistories($order_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT oh.date_added, os.name AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$order_id . "' AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY oh.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalOrderHistories($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int)$order_id . "'");

		return $query->row['total'];
	}

	public function getTotalOrderHistoriesByOrderStatusId($order_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_status_id = '" . (int)$order_status_id . "'");

		return $query->row['total'];
	}

	public function getEmailsByProductsOrdered($products, $start, $end) {
		$implode = array();

		foreach ($products as $product_id) {
			$implode[] = "op.product_id = '" . (int)$product_id . "'";
		}

		$query = $this->db->query("SELECT DISTINCT email FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0' LIMIT " . (int)$start . "," . (int)$end);

		return $query->rows;
	}

	public function getTotalEmailsByProductsOrdered($products) {
		$implode = array();

		foreach ($products as $product_id) {
			$implode[] = "op.product_id = '" . (int)$product_id . "'";
		}

		$query = $this->db->query("SELECT DISTINCT email FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0'");

		return $query->row['total'];
	}
}
