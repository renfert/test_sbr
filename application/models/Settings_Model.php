<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}


	public function getSettingsInformation()
	{
		$this->db->select("*");
		$this->db->from("settings");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function editCurrency($currency)
	{
		$data = array(
			'currency' => $currency
		);

		if ($this->db->update("settings", $data)) {
			return true;
		} else {
			return false;
		}
	}


	public function edit($params)
	{
		finishStep(4);
		if ($this->db->update("settings", $params)) {
			return true;
		} else {
			return false;
		}
	}


	public function editPrimaryColor($params)
	{
		if ($this->db->update("settings", $params)) {
			return true;
		} else {
			return false;
		}
	}
}
