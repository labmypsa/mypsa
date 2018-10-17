<?php

Session::logged();

/**
* 
*/
class InformesController
{
	
	public function __construct()
	{
		$this->name="informes";
		$this->title="Historial";
		$this->subtitle="Bitácora";		
		$this->model = [
            'informe' => new Informes(),
        	'sucursal' => new Sucursal(),
  		];
       $this->ext=$this->model['sucursal']->extension();
       $this->sucursal= strtoupper(Session::get('sucursal'));     
	}

	public function index(){
		$usuario =Session::get('id');		
		$rol =substr(Session::get('roles_id'),-2); // solo se abstrae el ultimo numero del rol todos empiesan con 100-00
		include view($this->name.'.read');
	}
	public function proceso(){
		$usuario =Session::get('id');		
		$rol =substr(Session::get('roles_id'),-2); // solo se abstrae el ultimo numero del rol todos empiesan con 100-00
		include view($this->name.'.proceso');
	}
	public function calibrar(){		
		Session::logged([
			//'roles_id' => '10003|10000',
		]);
		 $usuario =Session::get('id');		 
		 $rol =Session::get('roles_id');
		include view($this->name.'.calibrar');
	}

	public function verinforme(){
		$usuario =Session::get('id');		 
		$rol =Session::get('roles_id');		 
		if (isset($_GET['p']) && ($rol !='10001' || $rol !='10004')) {
		 	$numinforme=$_GET['p'];	
		  	$temp = json_encode($data['informe'] = $this->model['informe']->get_comparar_cliente($numinforme),true);		
		  	$cliente= json_decode($temp, true);
		  	$plantaid=Session::get('plantas_id');		  	
		 	$file='storage/informes'.$this->ext.'/'.$numinforme.'.pdf';		 		 		 	 			
			if (file_exists($file)) {		 		
					if($plantaid == $cliente[0]["plantas_id"] && $rol =='10005') // Nos ayudara para saber si el cliente que quiere ver su informe le corresponde ese número
				 	{
						include view($this->name.'.verinforme');
				 	}	
				 	else if($rol !='10005'){ // A los demas usuarios que son del equipo interno si los dejara ver
						include view($this->name.'.verinforme');
				 	}
				 	else{
				 		redirect('?c=error&a=error_404');
				 	}
			 } else {
		   		redirect('?c=error&a=error_412');
		  	}		 					
		}
		else{
			redirect('?c=error&a=error_412');
		}
	}
	
	public function get_a_calibrar(){
        echo $data = json_encode($data['informe'] = $this->model['informe']->equipos_calibrar_notification());
	}
}