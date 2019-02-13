<?php

class RegistroController {

    public function __construct() {
       $this->model = [
            'usuario' => new Usuario(),           
        ];            
    }

    public function index() {    
        include view('registro.index');
    }
    public function correcto(){
    	include view('registro.success');
    }
    public function recuperar(){
        include view('registro.recuperar');
    }

    public function store(){

        $data = validate($_POST, [
            'password' => 'required',            
            'email' => 'required|trimlower|email',
            'nombre' => 'required|trimlower',
            'apellido' => 'required|trimlower',
            'empresa' => 'required|trimlower',
            'sucursal' => 'required|trimlower',
        ]);

        /*|***************************************|*/
        /*|     Enviar correos electronicos       |*/
        /*|      Enviar a cliente y admins        |*/
        /*|***************************************|*/

        $data['body']=EnvioCorreo::_bodynewuser($data);

        //NO OLVIDAR, COMENTAR LAS LINEAS DE ABAJO, ESTO SIRVE PARA HACER PRUEBAS
        // $data['cco'] = array(
        //                 'email' => array('sistemas@mypsa.com.mx'), 
        //                 'alias' => array('Soporte'),
        //             );
        
        $data['cco'] = array(
                        'email' => array('sistemas@mypsa.com.mx','mvega@mypsa.mx'), 
                        'alias' => array('Soporte','Manuel V.'),
                    );

        $data['asunto']="Registro de nuevo usuario";
                
        $retorno=EnvioCorreo::_enviocorreo($data);                
        if ($retorno) {
            unset($data['empresa']);
            unset($data['sucursal']);
            unset($data['body']);
            unset($data['cco']);
            unset($data['asunto']);

            $data["password"] = Crypt::encrypt($data["password"]);
            $data['roles_id'] = '10005';

            //var_dump($data);
            //exit;

            if ($this->model['usuario']->store($data)) {
                redirect('?c=registro&a=correcto');
            } else {
                Flash::error(setError('002'));
            }
        }
        else{
            Flash::error(setError('009'));
        }    
    }  

    public function resetpass(){

        if(validate($_POST, ['email'=>'required|trimlower|exists:usuarios'])){
            $datatemp['email']=$_POST['email'];
            $datatemp['password']=$this->generarPass();
        
            /*|***************************************|*/
            /*|     Enviar correos electronicos       |*/
            /*|      Enviar a cliente y admins        |*/
            /*|***************************************|*/

            $dataemail['body']=EnvioCorreo::_bodyresetpass($datatemp); 

            //COMENTAR LAS LINEAS DE ABAJO, ESTO SIRVE PARA HACER PRUEBAS
            // $data['cco'] = array(
            //                 'email' => array('sistemas@mypsa.com.mx'), 
            //                 'alias' => array('Soporte'),
            //             );
            
            $data['cco'] = array(
                            'email' => array('sistemas@mypsa.com.mx','mvega@mypsa.mx'), 
                            'alias' => array('Soporte','Manuel V.'),
                        );

            $dataemail['asunto']="Actualizacion de contraseña MyPSA";
            $dataemail['email']=$datatemp['email'];
            
            $retorno=EnvioCorreo::_enviocorreo($dataemail);               
            if ($retorno) {
                $data['password'] = Crypt::encrypt($datatemp['password']);
                $usuario= $this->model['usuario']->find_by(['email'=>$datatemp['email']]);
                $data['id']=$usuario[0]['id'];

                if ($this->model['usuario']->update($data)){            
                    redirect('index.php');
                }else {
                    Flash::error(setError('002'));
                }
            }
            else{
                Flash::error(setError('009'));
            }  
        }
        else {
            Flash::error(setError('003'));
        }
    }

    private function generarPass(){
        $cadena="ABCDEFGHIJKLMNOPQRSTUVWXYZz1234567890abcdefghijklmnopqrstuvwxy./-_@*(){}[]";
        $lengthcadena= strlen($cadena);
        $pass="";
        $lengthpass=10;
        for ($i=0; $i < $lengthpass; $i++) { 
            # code...
            $pos=rand(0,$lengthcadena-1);
            $pass.=substr($cadena, $pos,1);
        }
        return $pass;
    }

}

