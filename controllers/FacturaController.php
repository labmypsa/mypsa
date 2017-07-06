<?php

Session::logged();

class FacturaController {

	public function __construct(){
		$this->name="factura";
		$this->title="Factura";
		$this->subtitle="Bitácora";		
		$this->model =[
			'informes'=> new Informes(),
      'sucursal' => new Sucursal(),
      ];
      $this->ext=$this->model['sucursal']->extension();
	}

	public function index(){
      if (isset($_GET['p'])) {
            $id=$_GET['p'];
            $view_informes="view_informes". $this->ext;     
            $data['get']=$this->model['informes']->get_factura($id, $view_informes); //          
              if($data['get'][0]['po_id'] === "pendiente"){
               redirect('?c=recepcion&a=index&p='. $data['get'][0]['id']);
              }
              else{        
                $data['reget']= $this->model['informes']->get_prefactura($data['get'][0]['po_id'],$view_informes);
                $data['get'][0]['factura']= $data['reget'][0]['factura'];
                $data['get'][0]['precio']= $data['reget'][0]['precio'];
                $data['get'][0]['precio_extra']= $data['reget'][0]['precio_extra'];
                $data['get'][0]['monedas_id']= $data['reget'][0]['monedas_id'];         
                /*Se quito la validación de entrar al modulo, para que funcione la opción agregar factura previa, pero solo va 
                a ingresar cuando no haya P.O Pendiente*/

                //if ($data['get'][0]['proceso']> 2) {                
                  $data['get'][0]['precio']='0';
                  $data['get'][0]['precio_extra']= '0';
                  include view($this->name.'.read');                  
                //}
                //else{ redirect('?c=informes&a=proceso');}
              }    
      }
      else{   
          redirect('?c=informes&a=proceso');
      }
  }

  public function store(){
    $hoy = date("Y-m-d H:i:s");
    $data = validate($_POST, [
    'id' => 'toInt',
    'proceso' => 'toInt',
    'precio' => 'required',
    'precio_extra' => 'required',
    'factura' => 'trimlower|required',
    'monedas_id' => 'required|toInt',
    'comentarios' => 'trimlower',    
    ]);
    if ($data['proceso'] == 3) {
        $data['proceso'] = intval('4');
      }
    //$data['usuarios_captura3_id'] = intval(Session::get('id'));
    $data['fecha_finalizacion']=$hoy;

     if ($this->model['informes']->find_by(['id' => $data['id']])){

          if ($this->model['informes']->update($data))  {
              // direccionarlo al siguiente proceso
              Logs::this("Captura en factura", "Se capturo los datos de facturación, factura: ".$data['factura'].". Informe: ".$data['id']);                                       
              if ($data['proceso'] == 4) {                
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