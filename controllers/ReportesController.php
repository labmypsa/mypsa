<?php

Session::logged();

class ReportesController{		

	public function __construct()
	{
		$this->name="reportes";
		$this->title="Reportes";
		$this->subtitle="";		
		$this->model = [		 
		 'sucursal' => new Sucursal(),
		 'usuario'=> new Usuario(),
		 'tipocalibracion'=> new Tipocalibracion(),
		 'informes'=> new Informes(),
		 'planta' => new Planta(),
        ];
        $this->ext=$this->model['sucursal']->extension();        
	}

	public function index(){

		if(isset($_POST['submit'])){
			$data = validate($_POST, [
	            'daterange' => 'required',
	            'nombre_suc' => 'required|trimlower',
	            'usuarios_calibracion_id' => 'required|toInt',          
	            'calibraciones_id' => 'required|toInt',            
	        ]); 
	        $cadena= explode(' - ', $data['daterange']);				
			unset($data['daterange']);
			$data['fecha_home']=$cadena[0];
			$data['fecha_end']=$cadena[1];
			$ext="";
	    	if ($data['nombre_suc']== 'nogales') {$ext="_n"; }
	        else if($data['nombre_suc']== 'hermosillo') {$ext="_h"; }
	        else if($data['nombre_suc']== 'guaymas') {$ext="_g"; }	        
	        unset($data['nombre_suc']);

	        $data['ext']=$ext;

	 		$table_t=$this->model['informes']->get_reporte_totales($data); 	
	 		$equipos_t = 0;
	 		$pesos_t = 0;
	 		$dolares_t = 0;  		
	 		if(sizeof($table_t) > 0){ 			 	
	 		for ($i=0; $i < sizeof($table_t); $i++) {  					     		
	 			if(sizeof($table_t) > 1){ 				
	 				$z=$i+1;
	 				for ($y=$z; $y <= sizeof($table_t); $y++) { 			 	
	 			 		if ((int)$table_t[$i]['id_tecnico'] == (int)$table_t[$y]['id_tecnico']) {  						 					
		 					$table_t[$i]['total_equipos'] += (int) $table_t[$y]['total_equipos']; //concatena y suma  la fila actual y la siguiente
		 					$table_t[$i]['total_pesos'] += (int) $table_t[$y]['total_pesos'];
		 					$table_t[$i]['total_dolares'] += (int) $table_t[$y]['total_dolares'];
		 					unset($table_t[$y]);
	 					} 		  				
	 				}
	 				$table_t=array_values($table_t);  				
	 			}			  			 			
	 			}  					
	 		} 
	 		//var_dump($table_t);  		 	
	 		for ($i=0; $i < sizeof($table_t) ; $i++) { 
	 			$equipos_t = $equipos_t + (int) $table_t[$i]['total_equipos']; // sumar el total de equipos de todos los tecnicos
	 			$pesos_t = $pesos_t + (int) $table_t[$i]['total_pesos'] ; 
	 			$dolares_t = $dolares_t + (int) $table_t[$i]['total_dolares'] ;
	 		 	$array_Ttec[$i]=$table_t[$i]['tecnico'];
	 		 	$array_Teq[$i]=$table_t[$i]['total_equipos'];
	 		 	$array_Tps[$i]=$table_t[$i]['total_pesos'];
	 		 	$array_Tdl[$i]=$table_t[$i]['total_dolares'];
	 		 }  		
	 	}
	 	
		$data['tecnico']= $this->model['usuario']->find_by(['roles_id'=>'10003', 'plantas_id'=>Session::get('plantas_id')]); 			
		$data['tipocalibracion']=$this->model['tipocalibracion']->all();			
		$data['sucursal']=$this->model['sucursal']->find_by();
 		include view($this->name.'.read');
	}

	public function tecnico(){
		$arreglo = (isset($_GET['p'])) ? json_encode($this->url_get($_GET['p'])) : "";
		include view($this->name.'.tecnico');
	}

	public function ajax_load_tecnicos() {
        $sucursal = $_POST['sucursal'];        
		$data = json_encode($data['tecnico']= $this->model['usuario']->find_by(['roles_id'=>'10003', 'sucursal'=>$sucursal],'view_usuarios')); 
        echo $data;
    }

	public function cliente(){
 		$data['planta']= $this->model['planta']->find_by([],'view_plantas');

		 if (strtolower(Session::get('sucursal'))=="nogales") {
			$data['sucursal']=$this->model['sucursal']->find_by();
		}
		else{
			$data['sucursal']=$this->model['sucursal']->find_by(['nombre'=>Session::get('sucursal')]);	 
		}				

		include view($this->name.'.cliente');
	}

	public function ajax_load_clientes() { 	
		$data = array(
				"daterange" =>$_POST['daterange'],
				"nombre_suc" =>$_POST['nombre_suc'],
				"cliente_id" => (int) $_POST['cliente_id'],
				"tipo_busqueda" =>(int) $_POST['tipo_busqueda']
				);	

        $cadena= explode(' - ', $data['daterange']);				
		unset($data['daterange']);
		$data['fecha_home']=$cadena[0];
		$data['fecha_end']=$cadena[1];
		$ext="";		
		$sucursal= strtolower($data['nombre_suc']);
    	if ($sucursal== 'nogales') {$ext="_n"; }
        else if($sucursal== 'hermosillo') {$ext="_h"; }
        else if($sucursal== 'guaymas') {$ext="_g"; }	        
        unset($data['nombre_suc']);
        $data['ext']=$ext;			
		if ($data['tipo_busqueda']==1) {
			$hoy= date('Y-m-d');
			$_fhome= date('Y-m-d',strtotime($data['fecha_home']));
			$_fend= date('Y-m-d',strtotime($data['fecha_end']));
			if ($_fhome >= $hoy and $_fend > $hoy) {				
				$table_rc=$this->model['informes']->get_reporte_clientes($data);		
			}
			else{
				$table_rc=false;
			}
			}
			else{
			$table_rc=$this->model['informes']->get_reporte_clientes($data);	
			}							

		//$_SESSION['_arraykey']= $table_rc;
		echo json_encode($table_rc);
    }  

	public function get_url($data)
	{	
		$array = array(			
			$data['calibraciones_id'],
			$data['fecha_home'],
			$data['fecha_end'],
			$data['ext']
			);
 		$tmp = serialize($array);
        $tmp = urlencode($tmp);
        return $tmp;
	}

	public function url_get($url_array)
	{	
		$tmp = stripslashes($url_array);
		$tmp = urldecode($tmp);
		$tmp = unserialize($tmp);
		return $tmp;
	}

	public function ajax_puente()
	{	
		$id= $_POST['var1'];
		$url_array= $_POST['var2'];
		$array = $this->url_get($url_array);
		$array[4]= (int)$id;
		$tmp = serialize($array);
        $tmp = urlencode($tmp);		
		echo  $tmp;
	}

	public function test(){
		// $_arraykey= array("a", "b","c","d");
		// $_topcliente= array();
		// $_topequipos= array();
		// var_dump($_SESSION['_arraykey']);		
		// echo json_encode($_arraykey);		
	}
	
		
}
