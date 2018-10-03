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
        $idpo= strtolower($data['get'][0]['po_id']);
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
        // Message
    $html ='<html>';
        $html .='<head>';
            $html .='<title>Correo para facturar</title>';
            $html .='<style>';
                $html .='html, body {';
                    $html .='margin: 0 auto !important;';
                    $html .='padding: 0 !important;';
                    $html .='height: 100% !important;';
                    $html .='width: 100% !important;';
                    $html .='background-color: #ffffff;';
                    $html .='transform: scale(1, 1);';
                    $html .='zoom: 1;';
                $html .='}';

                $html .='table {';
                    $html .='width: 100%;';
                $html .='}';

                $html .='table, th, td {';
                    $html .='border: 1px;';
                    $html .='border-collapse: collapse;';
                $html .='}';

                    $html .='table#t03 td {';
                        $html .='text-align: center;';
                        $html .='font-family: Times, Times New Roman, Georgia, serif;';
                        $html .='font-size: 14px;';
                        $html .='padding: 5px;';
                        $html .='border-bottom: 1px solid #D6D6D6;';
                        $html .='font-family: Helvetica,sans-serif;';
                    $html .='}';

                    $html .='table#t03 th {';
                        $html .='background-color: #009AD6;';
                        $html .='color: white;';
                        $html .='text-align: center;';
                        $html .='font-size: 16px;';
                        $html .='padding: 5px;';
                        $html .='border: 0px;';
                        $html .='font-family: Helvetica,sans-serif;';
                    $html .='}';
            $html .='</style>';
        $html .='</head>';
        $html .='<body>';
            $html .='<table class="wrapper" width="800" cellspacing="0" cellpadding="0" border="0" align="center" style="width: 800px;">';
                $html .='<tbody>';
                    $html .='<!--Home Separador-->';
                    $html .='<tr>';
                        $html .='<td style="margin:0;padding:0;" valign="top" align="center">';
                            $html .='<table data-editable="text" class="text-block" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
                                $html .='<tbody>';
                                    $html .='<tr>';
                                        $html .='<td valign="top" align="center" style="padding: 5px 0px 34px; margin: 0px; font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.15;"><span style="font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:11px;font-weight:300;line-height:1.1;"></span></td>';
                                    $html .='</tr>';
                                $html .='</tbody>';
                            $html .='</table>';
                        $html .='</td>';
                    $html .='</tr>';
                    $html .='<!--End Separador-->';

                    $html .='<tr>';
                        $html .='<td style="margin:0;padding:0;" valign="top" align="center">';
                            $html .='<table style="width:100% ">';
                                $html .='<tr>';
                                    $html .='<td> <img src="http://mypsa.com.mx/logo.png" /> </td>';
                                    $html .='<td style="text-align: right; font-family: Times, Times New Roman, Georgia, serif; font-size: 16px; color: #333399;">RFC: MPR990906AF4<br> Privada Tecnológico No. 25<br> Col. Granja Nogales Sonora, C.P. 84065<br> Tel: 631-314-6263, 631-314-6193</td>';
                                $html .='</tr>';
                            $html .='</table>';
                        $html .='</td>';
                    $html .='</tr>';

                    $html .='<!--Home Separador-->';
                    $html .='<tr>';
                        $html .='<td style="margin:0;padding:0;" valign="top" align="center">';
                            $html .='<table data-editable="text" class="text-block" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
                                $html .='<tbody>';
                                    $html .='<tr>';
                                        $html .='<td valign="top" align="center" style="padding: 5px 0px 10px; margin: 0px; font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.15;"><span style="font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:11px;font-weight:300;line-height:1.1;"></span></td>';
                                    $html .='</tr>';
                                $html .='</tbody>';
                            $html .='</table>';
                        $html .='</td>';
                    $html .='</tr>';
                    $html .='<!--End Separador-->';
                    $html .='<tr>';
                        $html .='<td style="padding:13px 20px;margin:0;" valign="top" bgcolor="#009AD6" align="left">';
                            $html .='<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
                                $html .='<tbody>';
                                    $html .='<tr style="text-align: center;">';
                                        $html .='<td style="clear: none; padding: 0px; max-width: 100%; margin: 0px auto !important; min-width: 320px !important;" width="NaN%" valign="top" align="left" class="column" axis="col">';
                                            $html .='<table data-editable="text" class="column-full-width" style="width: 100%;" cellspacing="0" cellpadding="0" border="0" align="center" width="100%">';
                                                $html .='<tbody>';
                                                    $html .='<tr>';
                                                        $html .='<td valign="top" align="left" style="padding: 10px 0px 7px; margin: 0px; background-color:#009AD6; font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.15;">';
                                                            $html .='<span style="font-family:Helvetica,Arial,sans-serif;font-size:18px;font-weight:300;color:#ffffff; line-height:1.1;">Favor de generar la factura con los siguientes datos. Gracias !</span>';
                                                        $html .='</td>';
                                                    $html .='</tr>';
                                                $html .='</tbody>';
                                            $html .='</table>';
                                        $html .='</td>';
                                    $html .='</tr>';
                                $html .='</tbody>';
                            $html .='</table>';
                        $html .='</td>';
                    $html .='</tr>';
                    $html .='<!--Home Separador-->';
                    $html .='<tr>';
                        $html .='<td style="margin:0;padding:0;" valign="top" align="center">';
                            $html .='<table data-editable="text" class="text-block" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
                                $html .='<tbody>';
                                    $html .='<tr>';
                                        $html .='<td valign="top" align="center" style="padding: 5px 0px 10px; margin: 0px; font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.15;"><span style="font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:11px;font-weight:300;line-height:1.1;"></span></td>';
                                    $html .='</tr>';
                                $html .='</tbody>';
                            $html .='</table>';
                        $html .='</td>';
                    $html .='</tr>';
                    $html .='<!--End Separador-->';
                    $html .='<tr>';
                        $html .='<td>';
                            $html .='<table data-editable="text" class="text-block empty-class" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
                                $html .='<tbody>';
                                    $html .='<tr>';
                                        $html .='<td  valign="top" align="left" style="padding: 5px 89px 10px 20px; margin: 0px; background-color: rgb(255, 255, 255); font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.35;">';
                                            $html .='<table data-editable="image" style="margin: 0; padding: 0;" data-mobile-width="0" id="edir9bvr" cellspacing="0" cellpadding="0" border="0" align="left" width="76">';
                                                $html .='<tbody>';
                                                    $html .='<tr>';
                                                        $html .='<td valign="top" align="left" style="padding: 12px 0px 15px 0px;; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;">';
                                                            $html .='<span style="font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:18px;font-weight:300;line-height:1.1;"># PO:</span>';
                                                        $html .='</td>';
                                                        $html .='<td valign="top"  style="padding: 12px 10px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;">';
                                                            $html .='<span style="font-family:Helvetica,sans-serif;font-size:18px;font-weight:400;color:#161414;line-height:1.3;"> HGNAJ12334</span>';
                                                        $html .='</td>';
                                                    $html .='</tr>';
                                                    $html .='<tr>';
                                                        $html .='<td valign="top"align="left"  style="padding: 12px 0px 15px 0px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;">';
                                                            $html .='<span style="font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:18px;font-weight:300;line-height:1.1;">Cliente:</span>';
                                                        $html .='</td>';
                                                        $html .='<td valign="top" style="padding: 12px 10px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;">';
                                                            $html .='<span style="font-family:Helvetica,sans-serif;font-size:18px;font-weight:400;color:#161414;line-height:1.3;"> Metrologia y pruebas S.A de C.V (Nogales)</span>';
                                                        $html .='</td>';
                                                    $html .='</tr>';
                                                    $html .='<tr>';
                                                        $html .='<td valign="top" align="left" style="padding: 12px 0px 15px 0px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;">';
                                                            $html .='<span style="font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:18px;font-weight:300;line-height:1.1;">Comentarios:</span>';
                                                        $html .='</td>';
                                                        $html .='<td valign="top" style="padding: 12px 10px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;">';
                                                            $html .='<span style="font-family:Helvetica,sans-serif;font-size:16px;font-weight:400;color:#161414;line-height:1.3;"> Se va a facturar con este nombre: Metrologia y Pruebas S.A de C.V. El cliente ha cambiado de razón social favor de modificarlo gracias! </span>';
                                                        $html .='</td>';
                                                    $html .='</tr>';

                                                $html .='</tbody>';
                                            $html .='</table>';

                                        $html .='</td>';
                                    $html .='</tr>';
                                $html .='</tbody>';
                            $html .='</table>';
                        $html .='</td>';
                    $html .='</tr>';

                    $html .='<tr>';
                        $html .='<td style="margin:0;padding:0;" valign="top" align="center">';
                            $html .='<table style="width:100% ">';
                                $html .='<tr>';
                                    $html .='<td><p style="text-align: left; font-family: Times, Times New Roman, Georgia, serif; font-size: 20px; color: #333634;">Total :  3</p></td>';
                                $html .='</tr>';
                            $html .='</table>';
                        $html .='</td>';
                    $html .='</tr>';

                    $html .='<tr>';
                        $html .='<td style="margin:0;padding:0;" valign="top" align="center">';
                            $html .='<table id="t03">';
                                $html .='<tr>';
                                    $html .='<th>#</th>';
                                    $html .='<th># Informe</th>';
                                    $html .='<th>Id equipo</th>';
                                    $html .='<th>Equipo</th>';
                                    $html .='<th>Precio</th>';
                                    $html .='<th>Moneda</th>';                          
                                $html .='</tr>';
                                $html .='<tr style="background-color: #ffffff;">';
                                    $html .='<td>1</td>';
                                    $html .='<td>38467</td>';
                                    $html .='<td>00359834</td>';
                                    $html .='<td>Medidor de relación de transformación</td>';
                                    $html .='<td>$200.00</td>';
                                    $html .='<td>MXN</td>';
                                $html .='</tr>';

                                $html .='<tr style="background-color: #eeeeee ;">';
                                    $html .='<td>2</td>';
                                    $html .='<td>38777</td>';
                                    $html .='<td>20000061</td>';
                                    $html .='<td>Máquina de ensayos</td>';
                                    $html .='<td>$100.10</td>';
                                    $html .='<td>DLL</td>';
                                $html .='</tr>';
                                $html .='<tr style="background-color: #ffffff;">';
                                    $html .='<td>3</td>';
                                    $html .='<td>38778</td>';
                                    $html .='<td>20000062</td>';
                                    $html .='<td>Máquina de ensayos</td>';
                                    $html .='<td>$920.50</td>';
                                    $html .='<td>MXN</td>';
                                $html .='</tr>';

                            $html .='</table>';
                        $html .='</td>';
                    $html .='</tr>';
                    $html .='<!--Home Separador-->';
                    $html .='<tr>';
                        $html .='<td style="margin:0;padding:0;" valign="top" align="center">';
                            $html .='<table data-editable="text" class="text-block" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
                                $html .='<tbody>';
                                    $html .='<tr>';
                                        $html .='<td valign="top" align="center" style="padding: 12px 0px 10px; margin: 0px; font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.15;"><span style="font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:11px;font-weight:300;line-height:1.1;"></span></td>';
                                    $html .='</tr>';
                                $html .='</tbody>';
                            $html .='</table>';
                        $html .='</td>';
                    $html .='</tr>';
                    $html .='<!--End Separador-->';
                    $html .='<tr>';
                        $html .='<td style="padding:13px 30px;margin:0;"  valign="top" bgcolor="white" align="left">';
                            $html .='<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
                                $html .='<tbody>';
                                    $html .='<tr style="text-align: center;">';
                                        $html .='<td style="clear: none; padding: 0px; max-width: 100%; margin: 0px auto !important; min-width: 280px !important;" width="NaN%" valign="top" align="left" class="column" axis="col">';
                                            $html .='<table data-editable="text" class="column-full-width" style="width: 100%;" cellspacing="0" cellpadding="0" border="0" align="center" width="100%">';
                                                $html .='<tbody>';
                                                    $html .='<tr>';
                                                        $html .='<td valign="top" align="center" style="padding: 10px 0px 7px; margin: 0px; background-color:white; font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.15;">';
                                                            $html .='<span style="font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:300;color:#8f8f8f; line-height:1.1;">Este correo se envia de manera automatica, si tiene una pregunta, favor de comunicarse con el departamento correspondiente. Estamos para servirle.</span>';
                                                        $html .='</td>';
                                                    $html .='</tr>';
                                                $html .='</tbody>';
                                            $html .='</table>';
                                        $html .='</td>';
                                    $html .='</tr>';
                                $html .='</tbody>';
                            $html .='</table>';
                        $html .='</td>';
                    $html .='</tr>';

                    $html .='<tr><td></td></tr>';
                $html .='</tbody>';
            $html .='</table>';
        $html .='</body>';
    $html .='</html>';
    
    $to = "it@mypsa.mx";
    $subject = "Correo Facturacion";
    $txt .= $html;   
    $headers  = 'From: laboratoriomypsa@gmail.com' . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=utf-8';

    if(mail($to,$subject,$txt,$headers))
      echo json_encode("Mensaje enviado");
    else
      echo json_encode("Mensaje no enviado");   
    
  }

  public function _scriptdata(){

    $this->_sendemail();

  }
}