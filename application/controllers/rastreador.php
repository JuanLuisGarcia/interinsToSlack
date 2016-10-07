<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class rastreador extends CI_Controller {
	public function index()
	{
		$this->load->helper('form');
		$this->load->view('rastreator_view');
	}
	public function pokevision()
	{
		//if(isset($this->input->post('latitud') and isset($this->input->post('longitud')and isset($this->input->post('channel')and isset($this->input->post('url_hooks') )){
		//poner validacion de form
			$latitud = $this->input->post('latitud');
        	$longitud = $this->input->post('longitud');
        	$channel = $this->input->post('channel');
        	$url_hooks = $this->input->post('url_hooks');
    	/*}else{
    		$this->load->model('user_info_model');
    	}	*/


		$url = "https://pokevision.com/map/data/".$latitud."/".$longitud;
		$content = file_get_contents($url);
		
		$result = explode ( '{' , $content );
		unset($result[0]);
		unset($result[1]); //despues dejar para validacion de servicio

		$this->load->library('pokedex');
		$pokedex = $this->pokedex->get_pokedex();
		$resultado = array();
		//preparamos la informacion que nos llega de pokevision
		$pokemon_array = array();
		foreach ($result as $pokemon) {
			$pokemon_info  = explode ( ',' , $pokemon );
			$pokemon_info2 = explode ( ':' , $pokemon_info[2] );
			$pokemon_info3 = explode ( ':' , $pokemon_info[3] );
			$pokemon_info4 = explode ( ':' , $pokemon_info[4] );
			$pokemon_info5 = explode ( ':' , $pokemon_info[5] );
			$pokemon_info6 = explode ( ':' , $pokemon_info[6] );
			$pokemon_info7 = explode ( ':' , $pokemon_info[7] );

			/*
			 'expiration_time' 	=> $pokemon_info2[1],
			 'pokemonId'	   	=> $pokemon_info3[1] ,
			 'latitude'			=> $pokemon_info4[1] ,
			 'longitude'		=> $pokemon_info5[1] ,
			 'uid'				=> $pokemon_info6[1] ,
			 'is_alive'			=> $pokemon_info7[1] 
			*/

			$resultado[] = $pokedex[$pokemon_info3[1]]. " Despawn in". " ". date("H:i:s", $pokemon_info2[1]) ;
		}

		

		//antes de enviar a slack pasarlo a string
		$this->load->library('slack');
		foreach ($resultado as $message){
			$this->slack->send($message, $channel , $url_hooks );
		}
		
	}
	
}
