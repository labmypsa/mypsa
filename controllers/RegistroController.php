<?php

require 'config/Phpmailer.php';
require 'config/Smtp.php';

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
    public function store(){

        $data = validate($_POST, [
            'password' => 'required',
            'email' => 'required|trimlower|email|unique:usuarios',
            'nombre' => 'required|trimlower',
            'apellido' => 'required|trimlower',
            'empresa' => 'required|trimlower',
            'sucursal' => 'required|trimlower',
        ]);

        /*|***************************************|*/
        /*|     Enviar correos electronicos       |*/
        /*|      Enviar a cliente y admins        |*/
        /*|***************************************|*/
      		
        $this->_emailsend($data);
        
        unset($data['empresa']);
        unset($data['sucursal']);

        $data["password"] = Crypt::encrypt($data["password"]);
        $data['roles_id'] = '10005';

        if ($this->model['usuario']->store($data)) {
            redirect('?c=registro&a=correcto');
        } else {
            Flash::error(setError('002'));
        }
    }

    public function _emailsend($data){

    $correo_envia=$data['email'];
    $contacto=$data['nombre'];

    // Datos de la cuenta de correo utilizada para enviar vía SMTP
    $smtpHost = "mail.mypsa.com.mx";  // Dominio alternativo brindado en el email de alta 
    $smtpUsuario = "noreply@mypsa.com.mx";  // Mi cuenta de correo
    $smtpClave = "nog-n.r*123"; 
  
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Port = 587; 
    $mail->IsHTML(true); 
    $mail->CharSet = "utf-8";
    $mail->Host = $smtpHost; 
    $mail->Username = $smtpUsuario; 
    $mail->Password = $smtpClave;    
    $mail->WordWrap = 80;

    $mail->From = $smtpUsuario; // Email desde donde envío el correo.
    $mail->FromName ="Mypsa ";
    $mail->AddAddress($correo_envia,$contacto);
    //$mail->AddAddress("facturacion@mypsa.mx","Facturacion"); // Esta es la dirección a donde enviamos los datos del formulario 
    $mail->AddBCC("sistemas@mypsa.com.mx"); 
    //$mail->AddBCC("it@mypsa.mx"); 
    $mail->AddBCC("mvega@mypsa.mx");

    $mail->Subject = "Solicitud de cliente. Bitacora en linea"; // Este es el titulo del email.
    
    $body= $this->_mailhtml($data);
    //$mail->Body = "Hola probando";
    $mail->Body = $body;      

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    return $mail->Send();

    }

    private function _mailhtml($data){
        $nombre=strtoupper($data['nombre'].' '. $data['apellido']);
        $email=$data['email'];
        $password=$data['password'];
        $empresa=$data['empresa'];
        $sucursal=$data['sucursal'];

        $html ="<!DOCTYPE html> <html>
        <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <meta http-equiv='X-UA-Compatible' content='IE=edge' />
        <meta name='viewport' content='width=device-width, initial-scale=1' />
        <meta name='x-apple-disable-message-reformatting' />
        <title>Registro de cuenta mypsa</title>
        </head>
        <body data-getresponse='true' style='margin: 0; padding: 0; background-color:#ffffff'>
        <div class='wrap' style='width: 100%; min-width: 320px; table-layout: fixed; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;'>
        <table data-mobile='true' dir='ltr' data-width='600' width='100%' cellspacing='0' cellpadding='0' border='0' align='center' style='font-size: 16px; background-color: rgb(255, 255, 2255);'>
            <tbody> 
                <tr>
                    <td style='margin:0;padding:0;' valign='top' align='center'>
                    <table class='wrapper' width='600' cellspacing='0' cellpadding='0' border='0' align='center' style='width: 600px;'>
                        <tbody>
                        <tr>
                            <td style='margin:0;padding:0;' valign='top' align='center'>
                                <table data-editable='text' class='text-block' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
                                    <tbody><tr>
                                        <td class='lh-1' valign='top' align='center' style='padding: 12px 0px 34px; margin: 0px; font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.15;'><span style='font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:11px;font-weight:300;line-height:1.1;'></span></td>
                                    </tr>
                                </tbody></table>
                            </td>
                        </tr>
                        <tr>
                            <td style='margin:0;padding:0;' valign='top' align='center'>
                                <table data-editable='image' data-mobile-width='0' cellspacing='0' cellpadding='0' border='0' align='center' width='158'>
                                    <tbody><tr>
                                        <td style='margin: 0px; padding: 0px 0px 15px; display: inline-block;' class='tdBlock' valign='top' align='left'><a href='http://mypsa.com.mx/' target='_blank'><img createnew='true' src='http://mypsa.com.mx/logo.png' alt='mypsa' data-src='http://mypsa.com.mx/logo.png' data-origsrc='http://mypsa.com.mx/logo.png' width='165' height='80' border='0'></a></td>
                                    </tr>
                                </tbody></table>
                            </td>
                        </tr>                        
                        <tr>
                            <td style='padding:0;margin:0;' valign='top' align='left'>
                                <table data-editable='text' class='text-block' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
                                    <tbody><tr>
                                        <td class='lh-1' valign='top' align='left' style='padding: 43px 50px 40px; margin: 0px; background-color: rgb(255, 255, 255); font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.15;'>
                                            <span style='font-family:Helvetica,Arial,sans-serif;font-size:36px;font-weight:300;color:#00afec; line-height:1.1;'>¡Hola, {$nombre}!</span>
                                        </td>
                                    </tr>
                                </tbody></table>
                            </td>
                        </tr>
                        <tr>
                            <td style='padding:0;margin:0;' valign='top' align='left'>
                                <table data-editable='text' class='text-block' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
                                    <tbody>
                                        <tr>
                                            <td class='lh-4' valign='top' align='left' style='padding: 0px 50px 34px; margin: 0px; background-color: rgb(255, 255, 255); font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.45;'>
                                                <p  style='font-family:Helvetica,sans-serif;font-size:18px;font-weight:400;color:#373737;line-height:1.3;'>Tu cuenta ha sido creada correctamente.</p>
                                                <p style='font-family:Helvetica,sans-serif;font-size:18px;font-weight:400;color:#373737;line-height:1.3; ¿'>Es necesario que tu cuenta sea verificada para poder ingresar al sistema.</p>
                                                <p style='font-family:Helvetica,sans-serif;font-size:18px;font-weight:400;color:#373737;line-height:1.3; ¿'> 
                                                    Este proceso puede demorar de 24-48 horas, una vez autorizada la cuenta se enviará un correo electrónico como notificación.</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        <tr>
                        <tr>
                            <td class='lh-4' valign='top' align='left' style='padding: 0px 50px 34px; margin: 0px; background-color: rgb(255, 255, 255); font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.45;' >
                                <table data-editable='image' style='margin: 0; padding: 0;' data-mobile-width='0' id='edir9bvr' cellspacing='0' cellpadding='0' border='0' align='left' width='76'>
                                    <tbody>
                                        <tr>
                                            <td  align='left' style='padding: 12px 0px 15px 0px;; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;'>
                                                <span style='font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:18px;font-weight:300;line-height:1.1;'>Usuario:</span>
                                            </td>
                                            <td  style='padding: 12px 10px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;'>
                                                <span style='font-family:Helvetica,sans-serif;font-size:18px;font-weight:400;color:#161414;line-height:1.3;'> {$email}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign='top' align='left' style='padding: 12px 0px 15px 0px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;'>
                                                <span style='font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:18px;font-weight:300;line-height:1.1;'>Contraseña:</span>
                                            </td>
                                            <td valign='top' style='padding: 12px 10px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;'>
                                                <span style='font-family:Helvetica,sans-serif;font-size:18px;font-weight:400;color:#161414;line-height:1.3;'> {$password}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign='top' align='left' style='padding: 12px 0px 15px 0px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;'>
                                                <span style='font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:18px;font-weight:300;line-height:1.1;'>Empresa:</span>
                                            </td>
                                            <td valign='top' style='padding: 12px 10px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;'>
                                                <span style='font-family:Helvetica,sans-serif;font-size:18px;font-weight:400;color:#161414;line-height:1.3;'> {$empresa}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign='top' align='left' style='padding: 12px 0px 15px 0px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;'>
                                                <span style='font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:18px;font-weight:300;line-height:1.1;'>Sucursal:</span>
                                            </td>
                                            <td valign='top' style='padding: 12px 10px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;'>
                                                <span style='font-family:Helvetica,sans-serif;font-size:18px;font-weight:400;color:#161414;line-height:1.3;'> {$sucursal}</span>
                                            </td>
                                        </tr>                                                           
                                    </tbody>
                                </table>
                            </td>
                        <tr>
                        <tr>
                            <td style='padding:0;margin:0;' align='left'>
                                <table data-editable='text' class='text-block' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
                                    <tbody>
                                        <tr>
                                            <td class='lh-4' valign='top' align='left' style='padding: 0px 50px 34px; margin: 0px; background-color: rgb(255, 255, 255); font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.45;'>                                                                        
                                                <a href='https://mypsa.com.mx/portal/index.php' class='text-center' style='text-align: center;display: block; font-weight:400;color:#00afec;text-decoration:underline; font-family:Helvetica,sans-serif;font-size:18px;line-height:1.3;'>Iniciar Sesion</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        <tr>
                        <tr>
                            <td style='margin:0;padding:0;' valign='top' align='center'>
                                <table data-editable='text' class='text-block' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
                                    <tbody><tr>
                                        <td class='lh-1' valign='top' align='center' style='padding: 5px 0px 5px; margin: 0px; font-size: 5px; font-family: Times New Roman, Times, serif; line-height: 1.15;'><span style='font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:11px;font-weight:100;line-height:1.1;'></span></td>
                                    </tr>
                                </tbody></table>
                            </td>
                        </tr>
                        <tr>
                            <td style='padding:0;margin:0;' valign='top' align='left'>
                                <table data-editable='text' class='text-block' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
                                    <tbody><tr>                            
                                        <td class='lh-3' valign='top' align='center' style='padding: 20px 50px 50px; margin: 0px; font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.35;'>                                
                                            <span style='font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:300;color:#262626; line-height:1.3;'>Este correo se envia de manera automatica, si tiene alguna duda, &nbsp;</span><div><span style='font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:300;color:#262626; line-height:1.3;'> favor de entrar a nuestra pagina <a href='http://mypsa.com.mx/'>http://mypsa.com.mx/</a> y comunicarse a nuestros numeros telefonicos. Gracias! </span>                                   
                                        </div></td>
                                    </tr>
                                </tbody></table>
                            </td>
                        </tr>
                </tr>
            </tbody>
        </table>                                                                                
                        <tr>
                            <td style='padding:0;margin:0;' valign='top' align='left'>                        
        </td></tr><tr><td></td></tr></tbody></table></td></tr></tbody></table>
        </div></body>
        </html>";

return $html;
    }

}

