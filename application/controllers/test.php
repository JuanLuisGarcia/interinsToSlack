<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class test extends CI_Controller {
	
	public function __construct() { 
        parent::__construct();
        $this->load->library('unit_test');
        $this->load->library('parser');
    	$this->load->library('slack');
    }
    public function testSlackSend(){
    	$test_name	=	"Slack Test";
    	$esperado	=	"ok";
    	$message 	=	"testing slack library";
    	$slack = $this->slack->send($message);
    	echo $this->unit->run($slack, $esperado, $test_name);
	}
}