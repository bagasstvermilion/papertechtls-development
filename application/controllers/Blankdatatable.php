<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blankdatatable extends CI_Controller {

	public function index()
	{
		echo '{"draw":0,"recordsTotal":0,"recordsFiltered":0,"data":[]}';
	}	
}