<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Interinos extends CI_Controller {

	public function index(){

		$this->load->library('parser');
		$content = $this->parser->getContent();
		$this->chekUser($content);

	}
	/*compare user in adjudication with selected user
	*and send msh with slack
	*/
	public function chekUser($content){
		$this->load->library('slack');
		$teacher_name= " FRAU FRANCO, BERNARDO";
		$isAdjudicated = false;
		foreach ($content as $adjudication) {

			if($teacher_name  == $adjudication["teacherName"]){
				$message ="Enhorabona, tens plaça als interins: ".$adjudication['teacherName']. " Data inici: "
				.$adjudication['dateStart']. " Data finalització ".$adjudication['dateEnd']." Centre de treball: ".$adjudication['location'];

				$this->slack->send($message);
				$isAdjudicated = true;
				break;
			}
		}

		$isAdjudicated == false ? $this->slack->send("Aquesta setmana no hi ha hagut sort, no et desanimis "):null;
	}
}
