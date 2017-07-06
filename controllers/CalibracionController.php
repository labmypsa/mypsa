<?php

Session::logged();

class CalibracionController {

	public function __construct() {
  		$this->name= "calibracion";
  		$this->title ="Calibración";
  		$this->subtitle= "Bitácora";
  		$this->model=[
  			'usuario'=> new Usuario(),
        'acreditacion'=> new Acreditacion(),
        'informes'=> new Informes(),
        'sucursal' => new Sucursal(),
  		];
      $this->ext=$this->model['sucursal']->extension();      
  	}

  	public function index (){   
      if (isset($_GET['p'])) {
        $id=$_GET['p'];
        $view_informes="view_informes". $this->ext;       
        $data['get']=$this->model['informes']->get_calibracion($id, $view_informes);             
       if ($data['get'][0]['proceso']> 0) {
        $data['tecnico']= $this->model['usuario']->find_by(['plantas_id'=>Session::get('plantas_id'),'activo'=>'1']);
        $data['acreditacion']=$this->model['acreditacion']->find_by(['activo'=>'1']); 
        include view($this->name.'.read');
        }
        else{ redirect('?c=informes&a=proceso');}
    }
    else{   
       redirect('?c=informes&a=proceso');
  	}
  }


  public function store (){
    $hoy = date("Y-m-d");    
      if (isset($_POST['calibrado']) === true) {          
         $data = validate($_POST, [
          'id' => 'toInt',
          'proceso' => 'toInt',
          'comentarios' => 'trimlower',
          'calibrado' => 'toInt',
          'acreditaciones_id' => 'toInt',
          ]);
          $data['usuarios_calibracion_id'] = $_POST['usuarios_calibracion_id'];
          $data['usuarios_informe_id'] = $_POST['usuarios_calibracion_id'];
          $data['fecha_calibracion'] = $_POST['fecha_calibracion'];
          $data['fecha_vencimiento'] = $_POST['fecha_calibracion'];                        
          $data['periodo_calibracion'] = '0';          
      }
      else{
          $data = validate($_POST, [ 
              'id' => 'toInt',
              'proceso' => 'toInt',
              'usuarios_calibracion_id' => 'required|toInt',
              'usuarios_informe_id' => 'required|toInt',
              'fecha_calibracion' => 'required',
              'acreditaciones_id' => 'required|toInt',             
              'periodo_calibracion' => 'required|toInt',
              'comentarios' => 'trimlower',
            ]);
          $fechacal= $data['fecha_calibracion'];
          $periodo= $data['periodo_calibracion'];
          $data['fecha_vencimiento'] = date('Y-m-d', strtotime($fechacal . "+".$periodo." month"));           
          $data['calibrado']= intval('1');

      }      
      if ($data['proceso'] === 1) {
        $data['proceso'] = intval('2');
        }
        
         if ($this->model['informes']->find_by(['id' => $data['id']])){              
              if ($this->model['informes']->update($data))  {
              // direccionarlo al siguiente proceso                     
               if ($data['proceso'] === 2) {
                Logs::this("Captura en calibración", "Se capturo los datos de calibración el informe".$data['id']);
                $i= substr(Session::get('roles_id'),-1,1); 
                //Esta función sirve para denegar el seguimiento a las personas no autorizadas (Técnicos)
                if($i==3) {redirect('?c=informes&a=calibrar');} // Regreso al técnico a su historial de equipos,
                else{redirect('?c=salida&a=index&p='.$data['id']); }
                }
                else if ($data['proceso'] === 3) {
                  Logs::this("Actualización en calibración", "Actualización de información, se encuentra en proceso de facturación. El informe".$data['id']);
                  redirect('?c=factura&a=index&p='.$data['id']);               
                }
                else if ($data['proceso'] === 4) {
                  Logs::this("Actualización en calibración", "Actualización en información, ya se encontraba el informe terminado.".$data['id']);
                  redirect('?c=recepcion');
                  } 
                else{
                  redirect('?c=informes&a=proceso');
                }               
              }
              else {                 
                 Flash::error(setError('002'));
              }
         }
  }
}