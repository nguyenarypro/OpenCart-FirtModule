<?php
class ControllerMarketplaceExtension extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('marketplace/extension');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('marketplace/extension', '', true)
		);

		$data['user_token'] = '';

		if (isset($this->request->get['type'])) {
			$data['type'] = $this->request->get['type'];
		} else {
			$data['type'] = '';
		}
		
		$data['categories'] = array();
		
		$files = glob(DIR_APPLICATION . 'controller/extension/extension/*.php', GLOB_BRACE);
		
		foreach ($files as $file) {
			$extension = basename($file, '.php');
			
			// Compatibility code for old extension folders
			$this->load->language('extension/extension/' . $extension, 'extension');
		
			if ($this->user->hasPermission('extension/extension/' . $extension)) {
				$files = glob(DIR_APPLICATION . 'controller/extension/' . $extension . '/*.php', GLOB_BRACE);
		
				$data['categories'][] = array(
					'code' => $extension,
					'text' => $this->language->get('extension')->get('heading_title') . ' (' . count($files) .')',
					'href' => $this->url->link('extension/extension/' . $extension, '', true)
				);
			}			
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('marketplace/extension', $data));
	}
}