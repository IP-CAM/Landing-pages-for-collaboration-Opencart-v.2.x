<?php
class ControllerCatalogOpt extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/review');

		$this->document->setTitle('Страницы под опт');

		$this->load->model('catalog/opt');
		$type = 1;
		$this->getList($type);
	}

	public function add() {
		$this->load->language('catalog/review');

		$this->document->setTitle('Добавить страницу под опт');

		$this->load->model('catalog/opt');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			if(empty($this->request->post['manufacturer_id'])){
				$this->request->post['manufacturer_id'] = '';
			} elseif (empty($this->request->post['category_id'])) {
				$this->request->post['category_id'] = '';
			}
			
			$this->model_catalog_opt->savePage($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/opt', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('catalog/opt');

		$this->document->setTitle('Посадочная страницы под опт');

		$this->load->model('catalog/opt');

		
		
		$this->request->post['manufacturer_id'] = ' ';

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_catalog_opt->savePage($this->request->post);
			// $this->model_catalog_opt->addReviewc($this->request->get['category_id']);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/opt', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->model_catalog_opt->savePage($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('catalog/opt', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/review');

		$this->document->setTitle($this->language->get('heading_title') . ' по категориям');

		$this->load->model('catalog/opt');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {

			foreach ($this->request->post['selected'] as $page_id) {	
				$this->model_catalog_opt->deleteOptPage($page_id);
			}



			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/opt', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		} 

		elseif (isset($this->request->get['page_id']) && $this->validateDelete()) {

			// var_dump($this->request->get['category_id']);
			$this->model_catalog_opt->deleteOptPage($this->request->get['page_id']);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/opt', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}


		$this->getList();
	}

	protected function getList($type) {

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';


		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Оптовые посадочные страницы',
			'href' => $this->url->link('catalog/opt', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('catalog/opt/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('catalog/opt/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// $data['reviews'] = array();

		if (isset($this->request->get['filter_type'])) {
			$filter_type = $this->request->get['filter_type'];
		} else {
			$filter_type = NULL;
		}

		$filter_data = array(
			// 'filter_product'    => $filter_product,
			// 'filter_author'     => $filter_author,
			// 'filter_status'     => $filter_status,
			'filter_type' 			=> $filter_type,
			// 'sort'              => $sort,
			// 'type'             =>  $type,
			'start'             => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'             => $this->config->get('config_limit_admin')
		);

		$data['filter_type'] = $filter_type;

		$page_total = $this->model_catalog_opt->getOptTotal($filter_data);

		// $results = $this->model_catalog_opt->getReviews($filter_data);
		$results = $this->model_catalog_opt->getOptList($filter_data);

		foreach ($results as $result) {
			$data['items'][] = array(
				'cname'			=> $result['cname'],
				'title'			=> $result['title'],
				'h1'			=> $result['h1'],
				'meta_description' => $result['meta_description'],
				'page_id' => $result['id'],
				'edit'       => $this->url->link('catalog/opt/update', 'token=' . $this->session->data['token'] . '&page_id=' . $result['id'] . $url, 'SSL'),
				'delete'       => $this->url->link('catalog/opt/delete', 'token=' . $this->session->data['token'] . '&page_id=' . $result['id'] . $url, 'SSL')
			);

		}

		$data['heading_title'] = 'Оптовые посадочные страницы';

		$data['text_list'] = 'Оптовые посадочные страницы';
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

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
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['filter_type'])) {
	      $url .= '&filter_type=' . $this->request->get['filter_type'];
	    }

		

		$url = '';

		// if (isset($this->request->get['page'])) {
		// 	$url .= '&page=' . $this->request->get['page'];
		// }

		if (isset($this->request->get['filter_type'])) {
	      $url .= '&filter_type=' . $this->request->get['filter_type'];
	    }

		$pagination = new Pagination();
		$pagination->total = $page_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/opt', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = $this->language->get('text_pagination');

		$data['results'] = sprintf($this->language->get('text_pagination'), ($page_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($page_total - $this->config->get('config_limit_admin'))) ? $page_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $page_total, ceil($page_total / $this->config->get('config_limit_admin')));



		// $data['sort'] = $sort;
		// $data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/opt_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = 'Посадочная под опт';

		$data['text_form'] = 'Посадочная под опт';
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_text'] = $this->language->get('entry_text');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Посадочные под опт',
			'href' => $this->url->link('catalog/opt', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);


		if (!isset($this->request->get['page_id'])) {
			$data['action'] = $this->url->link('catalog/opt/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('catalog/opt/update', 'token=' . $this->session->data['token'] . '&page_id=' . $this->request->get['page_id'] . $url, 'SSL');
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} else {
			$data['keyword'] = '';
		}

		$data['cancel'] = $this->url->link('catalog/opt', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['page_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$result = $this->model_catalog_opt->getOptPageData($this->request->get['page_id']);
			$data['page_id'] = $result['id'];
			$data['type'] = $result['type'];
			$data['category_id'] = $result['category_id'];
			$data['manufacturer_id'] = $result['manufacturer_id'];
			$data['title'] = $result['meta_title'];
			$data['h1'] = $result['h1'];
			$data['meta_keywords'] = $result['meta_keywords'];
			$data['meta_description'] = $result['meta_description'];
			$data['description'] = $result['description'];
			$data['keyword'] = $result['keyword'];
		}



		$data['categories'] = $this->model_catalog_opt->getAllCategories();
		$data['manufacturers'] = $this->model_catalog_opt->getAllManufacturers();

		$data['token'] = $this->session->data['token'];


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/opt_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/opt')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (utf8_strlen($this->request->post['keyword']) > 0) {
			$this->load->model('catalog/url_alias');

			$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);

			if ($url_alias_info && isset($this->request->get['page_id']) && $url_alias_info['query'] != 'optpage_id=' . $this->request->get['page_id']) {
				$this->error['keyword'] = 'SEO keyword already in use!';
			}

			if ($url_alias_info && !isset($this->request->get['page_id'])) {
				$this->error['keyword'] = 'SEO keyword already in use!';
			}
		}

		// if (!$this->request->post['page_id']) {
		// 	$this->error['product'] = $this->language->get('error_product');
		// }

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/review')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}