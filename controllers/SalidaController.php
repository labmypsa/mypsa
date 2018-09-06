<?php

Session::logged();

class SalidaController {

	public function __construct() {
		$this->name= "salida";
		$this->title="Salida";
		$this->subtitle="Bitácora";		
		$this->model = [
		'usuario'=> new Usuario(),
		'informes'=> new Informes(),
    'sucursal' => new Sucursal(),
    'po' => new PO(),
    'salida' => new Salida(),
    ];
    $this->ext=$this->model['sucursal']->extension();
    $this->sucursal= strtoupper(Session::get('sucursal'));
	}

	public function index(){
     //&a=index&p=2 
      if (isset($_GET['p'])) {
        $id=$_GET['p'];
        $view_informes="view_informes". $this->ext; 
        $data['equipo'] = $this->model['informes']->datos_equipo($id); 
        $data['cliente'] = $this->model['informes']->datos_cliente($id);      
        $data['get']=$this->model['informes']->get_salida($id, $view_informes);
        $idpo= $data['get'][0]['po_id'];
        if($idpo == "pendiente" || $idpo == "n/a" || $idpo == "no existe" || $idpo == "sin orden")
        { 
        $totalfact=0;
        $countfact=0;
        $cantidadpo=0;
        $countpototal=0;
        $countpolisto=0;
        }
        else{       
          $cantidadpo= $data['get'][0]['cantidad'];
          $temp_POt=$this->model['po']->get_countPO($idpo, $view_informes);
          $countpototal= $temp_POt[0]['total'];
          //po_total_listo
          $temp_POtl=$this->model['po']->get_countPOlisto($idpo, $view_informes);
          $countpolisto= $temp_POtl[0]['total'];

          $countfact=$this->model['informes']->get_countfactura($idpo, $view_informes);
          $totalfact= $countfact[0]['total'];
        }
        
        if ($data['get'][0]['proceso']> 1) {
              //se hara la modificación para hermosillo y para guaymas que todos los tecnicos puedan estar en hoja de salida
              if($sucursal != 'nogales'){
                $data['registradopor']= $this->model['usuario']->find_by(['activo'=>'1','plantas_id'=>Session::get('plantas_id')]);
              }
              else{
                $data['registradopor']= $this->model['usuario']->find_by(['activo'=>'1','roles_id'=>'10006','plantas_id'=>Session::get('plantas_id')]);
              }           
            include view($this->name.'.read');
        }
        else{ redirect('?c=informes&a=proceso');}
        }           
        else{   
          redirect('?c=informes&a=proceso');
        }
  } 


  public function store(){
    $hoy = date("Y-m-d");        
    $fecha_entrega= isset($_POST['fecha_entrega']) ? $hoy : NULL;               
    $data = validate($_POST, [ 
          'id' => 'toInt',
          'proceso' => 'toInt',
          'hojas_salida_id' => 'trimlower|required',
          'usuario_hoja_salida' => 'required|toInt',            
          'fecha' => 'required', 
          'comentarios' => 'trimlower',
        ]);
    if($fecha_entrega != null) {unset($data['fecha_entrega']);}                      
      //$data['usuarios_captura2_id'] = intval(Session::get('id'));
    $proceso_temp = $data['proceso'];                    
    if ($data['proceso'] == 2) {$data['proceso'] = intval('3');}

    if ($this->model['informes']->find_by(['id' => $data['id']])){
      $usuarios_id = $data['usuario_hoja_salida']; unset($data['usuario_hoja_salida']);
      $numero = $data['hojas_salida_id']; unset($data['hojas_salida_id']);
      $fecha = $data['fecha']; unset($data['fecha']);                 
      //existe hoja de salida       
        if ($this->model['salida']->find_by(['numero' => $numero])) {
         //si existe - update                 
          $id =$this->model['salida']->find_by(['numero' => $numero]);                
          // se compara para que al hacer el update no marque error al capturar vacio la fecha de entrega            
                if($this->model['salida']->update(['id'=> $id[0]['id'] ,'numero'=>$numero,'usuarios_id'=>$usuarios_id,'fecha'=>$fecha,'fecha_entrega'=>$fecha_entrega])) {                
                $data['hojas_salida_id']=intval($id[0]['id']);
                Logs::this("Actualización hoja de salida", "Se Actualizo el número de hoja de salida: ".$data['hojas_salida_id']);
                } else {                   
                 Flash::error(setError('002'));
                }                  
        }         
       //si no ; insert y asignar id de hoja de salida
        else {
          if($fecha_entrega == null){
            if ($this->model['salida']->store(['numero'=>$numero,'usuarios_id'=>$usuarios_id,'fecha'=>$fecha])) {
              $id =$this->model['salida']->find_by(['numero' => $numero]);                   
               $data['hojas_salida_id']=intval($id[0]['id']);
               Logs::this("Captura hoja de salida", "Se capturo la hoja de salida: ".$data['hojas_salida_id']); 
              } else {                              
                Flash::error(setError('002'));
              }
          }
          else{
            if ($this->model['salida']->store(['numero'=>$numero,'usuarios_id'=>$usuarios_id,'fecha'=>$fecha,'fecha_entrega'=>$fecha_entrega])) {
            $id =$this->model['salida']->find_by(['numero' => $numero]);                         
                $data['hojas_salida_id']=intval($id[0]['id']); 
              } else {                            
                Flash::error(setError('002'));
              }
            }
          }           
        if (is_null($data['hojas_salida_id']) === false) {

            if ($this->model['informes']->update($data)) {
               // direccionarlo al siguiente proceso     
              $roles_id= substr(Session::get('roles_id'),-1,1);            
              $po= $numero=$this->model['po']->po_pendiente($data['id']);
              if ($proceso_temp === 2 && $po !="pendiente") {
                Logs::this("Captura en salida", "Se capturo los datos de salida. Informe: ".$data['id']);
                  redirect('?c=factura&a=index&p='.$data['id']);
                  $this->model['informes']->_redirec($roles_id, $data['proceso'] ,$data['id']);              
                }
              else if ($proceso_temp === 3 && $po !="pendiente") {
                Logs::this("Captura en salida", "Actualización datos de salida. Informe: ".$data['id']);
                  $this->model['informes']->_redirec($roles_id, $data['proceso'] ,$data['id']);               
                }
              else if ($proceso_temp === 4) {
              Logs::this("Actualización en salida", "Actualización en salida, ya se encontraba el informe terminado. Informe: ".$data['id']); 
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
        else{           
          Flash::error(setError('002'));
        }
    }
  }

  public function ajax_load_hoja_salida() {
      $num_hojasalida = $_POST['hojas_salida_id'];
      $data = json_encode($data['salida'] = $this->model['salida']->find_by(['numero' => $num_hojasalida]));
      echo $data;
  }

  public function ajax_load_ultimo_hojasalida() {                                                
      echo json_encode($numero=$this->model['salida']->numero_hojasalida());
  }

  public function ajax_load_listequiPO(){
    $po = $_POST['po'];    
    $view="view_informes". $this->ext;
    $query="SELECT id,id as pivote,alias,descripcion,marca,modelo,serie FROM ".$view." WHERE po_id='". $po ."' and proceso>1 and proceso<4;";                
    $data= $this->model['informes']->get_query_informe($query);      
    echo json_encode($data);
  }

  public function _sendemail(){
    // Multiple recipients
    $to = 'sistemas@mypsa.com.mx'; // note the comma

    // Subject
    $subject = 'Birthday Reminders for August';

    // Message
    $message = '
    <html>
    <head>
      <title>Birthday Reminders for August</title>
    </head>
    <body>
      <p>Here are the birthdays upcoming in August!</p>
      <table>
        <tr>
          <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
        </tr>
        <tr>
          <td>Johny</td><td>10th</td><td>August</td><td>1970</td>
        </tr>
        <tr>
          <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
        </tr>
      </table>
    </body>
    </html>
    ';

    // To send HTML mail, the Content-type header must be set
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

    // Additional headers
    $headers[] = 'To: sistemas@mypsa.com.mx';
    $headers[] = 'From: it@mypsa.mx';
    $headers[] = 'Cc: test@mypsa.com.mx';
    //$headers[] = 'Bcc: ';

    // Mail it
    mail($to, $subject, $message, implode("\r\n", $headers));
  }

  public function _scriptdata(){
    $data = explode(",",$_POST['data']);
    
    echo json_encode($data);
  }
}