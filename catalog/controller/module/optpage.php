<?php
class ControllerModuleOptpage extends Controller {
	public function index() { 		
		$this->load->model('module/optpage');
		$this->load->model('catalog/product');
	
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home')	
		);

		$data['thisurl'] =  $this->config->get('config_url') .  $this->request->server['REQUEST_URI'];

					
		if (isset($this->request->get['opt_id'])) {
			// Проверяем есть ли такая страница в базе
			$pageData = $this->model_module_optpage->getPageData($this->request->get['opt_id']);
			// Если страница существует - выводим ее
			if(!empty($pageData)) {

				$category_id = '';
				$manufacturer_id = '';
				$category_name = '';
				$manufacturer_name = '';

				if($pageData['manufacturer_id'] != 0)	{ 
					$manufacturer_id = $pageData['manufacturer_id'];
					$manufacturer_name = $this->model_module_optpage->getManufacturerName($manufacturer_id) . ' ';
				}

				if($pageData['category_id'] != 0)	{ 
					$category_id = $pageData['category_id'];
					$category_name = $this->model_module_optpage->getCategoryName($category_id) . ' ';
				}

				$data['products'] = array();

				$filter_data = array(
					'filter_category_id' => $category_id,
					'filter_manufacturer_id' => $manufacturer_id,
					'filter_filter'      => '',
					'sort'               => '',
					'order'              => 'DESC',
					'start'              => 0,
					'limit'              => 8
				);

				$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

				$results = $this->model_catalog_product->getProducts($filter_data);
				$this->load->model('tool/image');
				foreach ($results as $result) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
					}

					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = false;
					}

					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = (int)$result['rating'];
					} else {
						$rating = false;
					}

					$data['products'][] = array(
						'product_id'  => $result['product_id'],
						'thumb'       => $image,
						'name'        => $result['name'],
						'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'tax'         => $tax,
						'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
						'rating'      => $result['rating'],
						'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
					);
				}
				// Метадата по умолчанию

				// Meta-tags
				
				// Set title
				if($pageData['meta_title'])	$meta_title = $pageData['meta_title'];
				else $meta_title = 'Оптовая продажа ' . $category_name . $manufacturer_name . 'дропшипинг в Москве';
				$this->document->setTitle($meta_title);
				
				// Set meta description
				if($pageData['meta_description'])  $meta_description = $pageData['meta_description'];
				else $meta_description = 'Низкие цены на ' . $category_name . $manufacturer_name . 'оптом у официального поставщика ' . $manufacturer_name . '. Подробные условия по оптовым продажам ' . $category_name . 'и дропшипингу ' . $manufacturer_name . 'внутри.';
				$this->document->setDescription($meta_description);
				
				// Set meta keywords
				if($pageData['meta_keywords'])	$meta_keywords = $pageData['meta_keywords'];
				else $meta_keywords = $manufacturer_name . ' опт, ' . $category_name . 'дропшипинг, ' . $manufacturer_name . 'дропшипинг, ' . $category_name . 'опт'; 
				$this->document->setKeywords($meta_keywords);

				// Set h1
				if($pageData['h1']) $data['h1'] = $pageData['h1'];
				else $data['h1'] = $category_name . $manufacturer_name .'Оптом и в дропшипинг';

				// Set page description
				if($pageData['description']) $data['description'] = html_entity_decode($pageData['description'], ENT_QUOTES, 'UTF-8');
				else $data['description'] = '<p>Наш магазин предлагает отличные условия сотрудничества по схеме дропшипинг!</p><p>Компания занимается оптовой и розничной продажей <strong>' . $category_name . $manufacturer_name .'</strong>. Качество продукции высокое, вся техника проходит предпродажную проверку. Можно приехать в наш выставочный зал, и ознакомиться со всей техникой поближе.</p>';

				// Set breadcrumbs
				$data['breadcrumbs'][] = array(
					'text'      => 'Опт и дропшипинг',
					'href'      => $this->url->link('module/optpage'),			
					'separator' => $this->language->get('text_separator')
				);

				$data['breadcrumbs'][] = array(
					'text'      => $data['h1'],
					'href'      => '#',			
					'separator' => $this->language->get('text_separator')
				);
				

				$this->load->language('product/category');
				$data['button_cart'] = $this->language->get('button_cart');
				$data['button_wishlist'] = $this->language->get('button_wishlist');
				$data['text_refine'] = $this->language->get('text_refine');
				$data['text_empty'] = $this->language->get('text_empty');
				$data['text_quantity'] = $this->language->get('text_quantity');
				$data['text_manufacturer'] = $this->language->get('text_manufacturer');
				$data['text_model'] = $this->language->get('text_model');
				$data['text_price'] = $this->language->get('text_price');
				$data['text_tax'] = $this->language->get('text_tax');
				$data['text_points'] = $this->language->get('text_points');
				$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
				$data['text_sort'] = $this->language->get('text_sort');
				$data['text_limit'] = $this->language->get('text_limit');

				$data['column_left'] = $this->load->controller('common/column_left');
				$data['column_right'] = $this->load->controller('common/column_right');
				$data['content_top'] = $this->load->controller('common/content_top');
				$data['content_bottom'] = $this->load->controller('common/content_bottom');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');
				$data['title'] = $this->document->setTitle($meta_title);

				// Выводи шаблон
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/opt.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/module/opt.tpl', $data));
				} else {
					$this->response->setOutput($this->load->view('default/template/module/opt.tpl', $data));
				}

			} else {

				// Устанавливаем meta-теги
				$title = 'Ошибка 404 - Страница не найдена';
				$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
				$this->document->setDescription('Страницы не существует или была перемещена по другому адресу');

				$data['title'] = $this->document->setTitle($title);
				$data['column_left'] = $this->load->controller('common/column_left');
				$data['column_right'] = $this->load->controller('common/column_right');
				$data['content_top'] = $this->load->controller('common/content_top');
				$data['content_bottom'] = $this->load->controller('common/content_bottom');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');

				$data['breadcrumbs'][] = array(
					'text' => 'Страница не найден',
					'href' => '#'
				);
				
				$data['heading_title'] = 'Страница не найдена';
				$data['text_error'] = 'Добро пожаловать на страницу 404! Вы находитесь здесь, потому что ввели адрес страницы, которая уже не существует или была перемещена по другому адресу';
				$data['button_continue'] = $this->language->get('button_continue');
				$data['continue'] = $this->url->link('common/home');
					
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
				} else {
					$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
				}
			}

		} else {

			$results = $this->model_module_optpage->getAllOptPage();
			
			foreach ($results as $result) {
				$category_id = '';
				$manufacturer_id = ' ';
				$category_name = '';
				$manufacturer_name = '';

				if($result['manufacturer_id'] != 0)	{ 
					// $manufacturer_id = $result['manufacturer_id'];
					$manufacturer_name = $this->model_module_optpage->getManufacturerName($result['manufacturer_id']) . ' ';
				}
				if($result['category_id'] != 0)	{ 
					// $category_id = $result['category_id'];
					$category_name = $this->model_module_optpage->getCategoryName($result['category_id']) . ' ';
				}

				if($result['h1']) {
					$h1 = $result['h1'];
				} else {
					$h1 = $category_name . $manufacturer_name . 'опт и дропшипинг';
				}

				$links[$result['type']][] = array(
					'id' => $result['id'],
					'title'	=> $h1,
					'href'	=> $this->url->link('module/optpage', 'opt_id=' . $result['id'])
				);
			}

			// var_dump($links);

			// выводим главную страницу с отзывами
			$title = 'Ошибка 404 - Страница не найдена';
			// $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
			$this->document->setDescription('Страницы не существует или была перемещена по другому адресу');
			$data['h1'] = 'Продажа оптом и в дропшипинг';
			$data['description'] = 'Продажа оптом и в дропшипинг';
			$data['products'] = '';
			$data['optlinks'] = $links;

			$data['title'] = $this->document->setTitle('Продажа товаров оптом и по дропшипингу');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$data['breadcrumbs'][] = array(
				'text' => 'Опт и дропшипинг',
				'href' => '#'
			);
			
			$data['heading_title'] = 'Страница не найдена';
			$data['text_error'] = 'Добро пожаловать на страницу 404! Вы находитесь здесь, потому что ввели адрес страницы, которая уже не существует или была перемещена по другому адресу';
			$data['button_continue'] = $this->language->get('button_continue');
			$data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/opt.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/module/opt.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/module/opt.tpl', $data));
			}
		}	
	}

	public function send() {
		$json = array();

		if(isset($this->request->post['phone']) | !empty($this->request->post['phone'])) {
			$phone = $this->request->post['phone'];
		}

		if(isset($this->request->post['name']) | !empty($this->request->post['name'])) {
			$name = $this->request->post['name'];
		}

		if(!empty($phone) && !empty($name)) {
			$subject = 'Новый запрос на ОПТ / Дропшипинг';
			$mailto = $this->config->get('config_email');

			$data = array(
				'phone'		=> $phone,
				'name'		=> $name,
				'ip'		=> $this->request->server['REMOTE_ADDR'],
				'url'		=> $this->request->post['url'],
				'title'		=> $this->request->post['title'],
				'logo' =>  $this->config->get('config_url') . 'image/' . $this->config->get('config_logo'),
				'store_url' => $this->config->get('config_url'),
				'store_name' => $this->config->get('config_name')
			);

			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($this->config->get('config_email'));
			$mail->setFrom($mailto);
			$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
			$mail->setHtml($this->load->view('default/template/mail/optorder.tpl', $data));
			// $mail->setHtml($message);
			$mail->send();

			$json['success'] = 'Спасибо, ваша заявка принята! Мы свяжемся с вами в ближайшее время';
		} else {
			if(!isset($phone) | empty($phone)) {
				$json['error']['phone'] = 'Введите номер телефона';
			}
			if (!isset($name) | empty($name)) {
				$json['error']['name'] = 'Введите ваше имя';
			} 
		}

		$this->response->setOutput(json_encode($json));	
	}
}