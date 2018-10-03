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
    $this->sucursal= strtoupper(Session::get('sucursal'));
	}

	public function index(){
      if (isset($_GET['p'])) {
            $id=$_GET['p'];
            $view_informes="view_informes". $this->ext; 
            $_query="";            
            $data['equipo'] = $this->model['informes']->datos_equipo($id);

            $data['get']=$this->model['informes']->get_factura($id, $view_informes); //  

            if($data['get'][0]['po_id'] === "pendiente"){
             redirect('?c=recepcion&a=index&p='. $data['get'][0]['id']);
            }
            else{
                $proceso = $data['get'][0]['proceso'];
               //cuando no hay factura por defaul 
                if(is_null($data['get'][0]['factura']) === true and $proceso < 4){
                  //buscar por PO si hay asignada una factura y si hay dos facturas mostrara la más actual, llenado previo como sugerencia.
                  if ($data['get'][0]['po_id'] != "n/a") {
                      $_query="SELECT factura FROM ".$view_informes." WHERE po_id='". $data['get'][0]['po_id']."' order by factura desc limit 1;";                     
                      $data['reget']= $this->model['informes']->get_prefactura($_query);
                      $data['get'][0]['factura']=$data['reget'][0]['factura'];                      
                  }                  
                }

                if (is_null($data['get'][0]['precio']) === true and $proceso < 4) {
                      $_query="SELECT precio,precio_extra,monedas_id FROM ".$view_informes." WHERE po_id='". $data['get'][0]['po_id']."' and descripcion='". $data['get'][0]['descripcion']."' order by factura desc limit 1;";

                      $data['reget']= $this->model['informes']->get_prefactura($_query);
                      $data['get'][0]['precio']= $data['reget'][0]['precio'];
                      $data['get'][0]['precio_extra']= $data['reget'][0]['precio_extra'];
                      $data['get'][0]['monedas_id']= $data['reget'][0]['monedas_id'];
                }
                include view($this->name.'.read');               
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
    'factura' => 'trimlower',
    'monedas_id' => 'required|toInt',
    'comentarios' => 'ucname',    
    ]);

    $proceso_temp = $data['proceso'];
    if ($data['proceso'] == 3) {
        $data['proceso'] = intval('4');
      }
    //$data['usuarios_captura3_id'] = intval(Session::get('id'));
    $data['fecha_finalizacion']=$hoy;

     if ($this->model['informes']->find_by(['id' => $data['id']])){

          if ($this->model['informes']->update($data))  {
              // direccionarlo al siguiente proceso
            $roles_id= substr(Session::get('roles_id'),-1,1); 
            if ($proceso_temp == 3) {
                Logs::this("Captura en factura", "Se capturo los datos de facturación, factura: ".$data['factura'].". Informe: ".$data['id']);   
              $this->model['informes']->_redirec($roles_id, $data['proceso'],$data['id']);
              }
                                                   
              if ($proceso_temp == 4) {
              Logs::this("Actualización en factura", "Actualización en factura, ya se encontraba el informe terminado. Informe:".$data['id']);                               
                 $this->model['informes']->_redirec($roles_id, $proceso_temp,$data['id']);
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