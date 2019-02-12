<?php

require 'Phpmailer.php';
require 'Smtp.php';

class EnvioCorreo{

	public static function _enviocorreo($data){
        $para=$data['email'];
		$alias= (isset($data['nombre'])) ? $data['nombre'] : '' ;		
		$asunto=$data['asunto'];		
        $body=$data['body'];

		/* ..................................... */
		//$para="test@mypsa.com.mx";
		//$alias="test";		
		//$asunto="Mensaje de prueba";
		//$body="<h1>Test 1 of PHPMailer html</h1><p>This is a test</p>";
		
		/* ..................................... */
        /*     Server SMTP                       */
        /* ..................................... */

		$mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = APP_SMTPAUTH;
        $mail->Port = APP_SMTPPORT;         
        $mail->Host = APP_SMTPHOST; 
        $mail->Username = APP_SMTPUSER; 
        $mail->Password = APP_SMTPPASS;
        $mail->CharSet = "utf-8";    
        $mail->WordWrap = 80;        

		/* ..................................... */
        /*     Correo De:                        */
        /* ..................................... */        
        $mail->From = APP_SMTPUSER; 
        $mail->FromName ="Mypsa ";

        /* ..................................... */
        /*     Correo Para:                      */
        /* ..................................... */
        $mail->AddAddress($para,$alias);        
        /* ..................................... */
        /*      Correo CC:                       */
        /* ..................................... */       

    	foreach ($data['cc']['email'] as $key => $value) {
     			$mail->AddCC($value,$data['cc']['alias'][$key]);            
     	   }         
        /* ..................................... */
        /*      Correo CCO                       */
        /* ..................................... */
		foreach ($data['cco']['email'] as $key => $value) {
  		   		$mail->AddBCC($value,$data['cc']['alias'][$key]);            
  		      }         
        /* ..................................... */
        /*     Correo Anexo < Attachments >      */
        /* ..................................... */
        foreach ($data['files'] as $key => $value) {
            $mail->AddAttachment($data['files'][$key]["tmp_name"], $data['files'][$key]["name"]);
        }
        /* ..................................... */
        /*      Correo Body                      */
        /* ..................................... */
        $mail->IsHTML(true);         
        $mail->Subject = $asunto;
        $mail->Body = $body;

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

		if(!$mail->Send())
		{
		   //return "Error de envio: " . $mail->ErrorInfo;
			return false;
		}
		else
		{
		   return true;
		}      
	}

	public static function _bodynewuser($data){
		
		$nombre=strtoupper($data['nombre'].' '. $data['apellido']);
        $email=$data['email'];
        $password=$data['password'];
        $empresa=$data['empresa'];
        $sucursal=$data['sucursal'];

        $html ="<!DOCTYPE html>
        <html>
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
                </div>
            </body>
        </html>";
        return $html;
	}

	public static function _bodyusernotificacion($data){
        $email=$data['email'];        
        $nombre=strtoupper($data['nombre'].' '. $data['apellido']);        

        $html="<!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <meta http-equiv='X-UA-Compatible' content='IE=edge' />
                <meta name='viewport' content='width=device-width, initial-scale=1' />
                <meta name='x-apple-disable-message-reformatting' />
                <title></title>
            </head>
            <body data-getresponse='true' style='margin: 0; padding: 0;'>
                <div class='wrap' style='width: 100%; min-width: 320px; table-layout: fixed; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;'>
                <table data-mobile='true' dir='ltr' data-width='600' width='100%' cellspacing='0' cellpadding='0' border='0' align='center' style='font-size: 16px; background-color: rgb(255,255,255);'>
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
                                                        <p  style='font-family:Helvetica,sans-serif;font-size:18px;font-weight:400;color:#373737;line-height:1.3;'>Tu cuenta se dio de alta correctamente.</p>
                                                        <p style='font-family:Helvetica,sans-serif;font-size:18px;font-weight:400;color:#373737;line-height:1.3; ¿'>A partir de este momento podrás ingresar al sistema.</p>
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
                                                <tr>
                                                    <td class='lh-4' valign='top' align='left' style='padding: 0px 50px 34px; margin: 0px; background-color: rgb(255, 255, 255); font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.45;'><div><a href='https://mypsa.com.mx/portal/index.php?c=registro&a=recuperar' class='text-center' style='text-align: center;display: block; font-weight:400;color:#00afec;text-decoration:underline; font-family:Helvetica,sans-serif;font-size:18px;line-height:1.3;'>Restablecer Contraseña</a> </span></div> 

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
                                                    <span style='font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:300;color:#262626; line-height:1.3;'>Este correo se envia de manera automatica, si tiene alguna duda, &nbsp;</span><div><span style='font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:300;color:#262626; line-height:1.3;'> favor de entrar a nuestra pagina <a href='http://mypsa.com.mx/'> http://mypsa.com.mx/ </a> y comunicarse a nuestros numeros telefonicos. Gracias! </span>                                   
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
                </div>
            </body>
        </html>";

        return $html;
	}
	
	public static function _bodyinvoice($data){
        
        $po=$data['po'];
        $cliente=$data['cliente'];
        $contacto=$data['contacto'];
        $comentarios=$data['comentarios'];
        
        $tabla=$data['tabla'];
        $count=count($tabla);
        
        $html ="<!DOCTYPE html>
        <html>
            <head>
                <title>Solicitud de factura</title>
                <style>
                    html, body {
                        margin: 0 auto !important;
                        padding: 0 !important;
                        height: 100% !important;
                        width: 100% !important;
                        background-color: #f3f3f3;
                        transform: scale(1, 1);
                        zoom: 1;
                    }
                    table {
                        width: 100%;
                    }
                    table, th, td {
                        border: 1px;
                        border-collapse: collapse;
                    }            
                        table#t03 td {
                            text-align: center;
                            font-family: Times, Times New Roman, Georgia, serif;
                            font-size: 14px;
                            padding: 5px;
                            border-bottom: 1px solid #D6D6D6;
                            font-family: Helvetica,sans-serif;
                        }
                        table#t03 th {
                            background-color: #009AD6;
                            color: white;
                            text-align: center;
                            font-size: 16px;
                            padding: 5px;
                            border: 0px;
                            font-family: Helvetica,sans-serif;
                        }
                </style>
            </head>
            <body>
                <table class='wrapper' width='800' cellspacing='0' cellpadding='0' border='0' align='center' style='width: 800px;'>
                    <tbody>
                        <!--Home Separador-->
                        <tr>
                            <td style='margin:0;padding:0;' valign='top' align='center'>
                                <table data-editable='text' class='text-block' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
                                    <tbody>
                                        <tr>
                                            <td valign='top' align='center' style='padding: 5px 0px 34px; margin: 0px; font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.15;'><span style='font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:11px;font-weight:300;line-height:1.1;'></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <!--End Separador-->
                        <tr>
                            <td style='margin:0;padding:0;' valign='top' align='center'>
                                <table style='width:100% '>
                                    <tr>
                                        <td> <img src='http://mypsa.com.mx/logo.png' /> </td>
                                        <td style='text-align: right; font-family: Times, Times New Roman, Georgia, serif; font-size: 16px; color: #333399;'>RFC: MPR990906AF4<br> Privada Tecnológico No. 25<br> Col. Granja Nogales Sonora, C.P. 84065<br> Tel: 631-314-6263, 631-314-6193</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!--Home Separador-->
                        <tr>
                            <td style='margin:0;padding:0;' valign='top' align='center'>
                                <table data-editable='text' class='text-block' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
                                    <tbody>
                                        <tr>
                                            <td valign='top' align='center' style='padding: 5px 0px 10px; margin: 0px; font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.15;'><span style='font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:11px;font-weight:300;line-height:1.1;'></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <!--End Separador-->
                        <tr>
                            <td style='padding:13px 20px;margin:0;' valign='top' bgcolor='#009AD6' align='left'>
                                <table width='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
                                    <tbody>
                                        <tr style='text-align: center;'>
                                            <td style='clear: none; padding: 0px; max-width: 100%; margin: 0px auto !important; min-width: 320px !important;' width='NaN%' valign='top' align='left' class='column' axis='col'>
                                                <table data-editable='text' class='column-full-width' style='width: 100%;' cellspacing='0' cellpadding='0' border='0' align='center' width='100%'>
                                                    <tbody>
                                                        <tr>
                                                            <td valign='top' align='left' style='padding: 10px 0px 7px; margin: 0px; background-color:#009AD6; font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.15;'>
                                                                <span style='font-family:Helvetica,Arial,sans-serif;font-size:18px;font-weight:300;color:#ffffff; line-height:1.1;'>Favor de generar la factura con los siguientes datos. Gracias !</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <!--Home Separador-->
                        <tr>
                            <td style='margin:0;padding:0;' valign='top' align='center'>
                                <table data-editable='text' class='text-block' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
                                    <tbody>
                                        <tr>
                                            <td valign='top' align='center' style='padding: 5px 0px 10px; margin: 0px; font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.15;'><span style='font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:11px;font-weight:300;line-height:1.1;'></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <!--End Separador-->
                        <tr>
                            <td>
                                <table data-editable='text' class='text-block empty-class' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
                                    <tbody>
                                        <tr>
                                            <td  valign='top' align='left' style='padding: 5px 89px 10px 20px; margin: 0px; background-color: rgb(255, 255, 255); font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.35;'>
                                                <table data-editable='image' style='margin: 0; padding: 0;' data-mobile-width='0' id='edir9bvr' cellspacing='0' cellpadding='0' border='0' align='left' width='76'>
                                                    <tbody>
                                                        <tr>
                                                            <td valign='top' align='left' style='padding: 12px 0px 15px 0px;; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;'>
                                                                <span style='font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:18px;font-weight:300;line-height:1.1;'># PO:</span>
                                                            </td>
                                                            <td valign='top'  style='padding: 12px 10px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;'>
                                                                <span style='font-family:Helvetica,sans-serif;font-size:18px;font-weight:400;color:#161414;line-height:1.3;'>{$po}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign='top'align='left'  style='padding: 12px 0px 15px 0px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;'>
                                                                <span style='font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:18px;font-weight:300;line-height:1.1;'>Cliente:</span>
                                                            </td>
                                                            <td valign='top' style='padding: 12px 10px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;'>
                                                                <span style='font-family:Helvetica,sans-serif;font-size:18px;font-weight:400;color:#161414;line-height:1.3;'>{$cliente}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign='top'align='left'  style='padding: 12px 0px 15px 0px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;'>
                                                                <span style='font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:18px;font-weight:300;line-height:1.1;'>Contacto:</span>
                                                            </td>
                                                            <td valign='top' style='padding: 12px 10px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;'>
                                                                <span style='font-family:Helvetica,sans-serif;font-size:18px;font-weight:400;color:#161414;line-height:1.3;'>{$contacto}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign='top' align='left' style='padding: 12px 0px 15px 0px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;'>
                                                                <span style='font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:18px;font-weight:300;line-height:1.1;'>Comentarios:</span>
                                                            </td>
                                                            <td valign='top' style='padding: 12px 10px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;'>
                                                                <span style='font-family:Helvetica,sans-serif;font-size:16px;font-weight:400;color:#161414;line-height:1.3;'>{$comentarios}</span>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style='margin:0;padding:0;' valign='top' align='center'>
                                <table style='width:100% '>
                                    <tr>
                                        <td><p style='text-align: left; font-family: Times, Times New Roman, Georgia, serif; font-size: 20px; color: #333634;'>Total :  {$count}</p></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style='margin:0;padding:0;' valign='top' align='center'>
                                <table id='t03'>
                                    <tr>
                                        <th>#</th>
                                        <th># Informe</th>
                                        <th>Id equipo</th>
                                        <th>Equipo</th>
                                        <th>Precio</th>
                                        <th>Moneda</th>                            
                                    </tr>";
                                    // vaciado de los datos 
                                for ($i=0; $i < $count; $i++) { 
                                    if(($i%2) == 0){
                                        $html.="<tr style='background-color: #ffffff;'>";
                                    }
                                    else{
                                        $html.="<tr style='background-color: #eeeeee;'>";
                                    }
                                    $id= $i+1;
                                    $html.="<td>".$id."</td>";

                                    for ($j=0; $j < 1; $j++) {                                 
                                        $html.="<td>".$tabla[$i]['id']."</td>";
                                        $html.="<td>".$tabla[$i]['idequipo']."</td>";
                                        $html.="<td>".$tabla[$i]['descripcion']."</td>";
                                        $suma= intval($tabla[$i]['precio']) + intval($tabla[$i]['precio_extra']);
                                        $html.="<td>". $suma ."</td>";
                                        $html.="<td>".$tabla[$i]['moneda']."</td>";                                       
                                    }
                                    $html.="</tr>";
                                } 

                        $html.="</table>
                            </td>
                        </tr>
                        <!--Home Separador-->
                        <tr>
                            <td style='margin:0;padding:0;' valign='top' align='center'>
                                <table data-editable='text' class='text-block' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
                                    <tbody>
                                        <tr>
                                            <td valign='top' align='center' style='padding: 12px 0px 10px; margin: 0px; font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.15;'><span style='font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:11px;font-weight:300;line-height:1.1;'></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <!--End Separador-->
                        <tr>
                            <td style='padding:13px 30px;margin:0;'  valign='top' bgcolor='white' align='left'>
                                <table width='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
                                    <tbody>
                                        <tr style='text-align: center;'>
                                            <td style='clear: none; padding: 0px; max-width: 100%; margin: 0px auto !important; min-width: 280px !important;' width='NaN%' valign='top' align='left' class='column' axis='col'>
                                                <table data-editable='text' class='column-full-width' style='width: 100%;' cellspacing='0' cellpadding='0' border='0' align='center' width='100%'>
                                                    <tbody>
                                                        <tr>
                                                            <td valign='top' align='center' style='padding: 10px 0px 7px; margin: 0px; background-color:white; font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.15;'>
                                                                <span style='font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:300;color:#8f8f8f; line-height:1.1;'>Este correo se envia de manera automatica, si tiene una pregunta, favor de comunicarse con el departamento correspondiente. Estamos para servirle.</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr><td></td></tr>
                    </tbody>
                </table>
            </body>
        </html>";

        return $html;
	}

    public static function _bodyresetpass($data){
        $email=$data['email'];        
        $password=$data['password'];        

        $html="<!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
            <meta http-equiv='X-UA-Compatible' content='IE=edge' />
            <meta name='viewport' content='width=device-width, initial-scale=1' />
            <meta name='x-apple-disable-message-reformatting' />
            <title></title>
        </head>
        <body data-getresponse='true' style='margin: 0; padding: 0;'>
            <div class='wrap' style='width: 100%; min-width: 320px; table-layout: fixed; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;'>
            <table data-mobile='true' dir='ltr' data-width='600' width='100%' cellspacing='0' cellpadding='0' border='0' align='center' style='font-size: 16px; background-color: rgb(255,255,255);'>
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
                            </tr>
                            <tr>
                                <td style='padding:0;margin:0;' valign='top' align='left'>
                                    <table data-editable='text' class='text-block' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
                                        <tbody>
                                            <tr>
                                                <td class='lh-4' valign='top' align='left' style='padding: 0px 50px 34px; margin: 0px; background-color: rgb(255, 255, 255); font-size: 16px; font-family: Times New Roman, Times, serif; line-height: 1.45;'>
                                                    <p  style='font-family:Helvetica,sans-serif;font-size:18px;font-weight:400;color:#373737;line-height:1.3;'>Recuperar contraseña</p>
                                                    <p style='font-family:Helvetica,sans-serif;font-size:18px;font-weight:400;color:#373737;line-height:1.3; ¿'>Se ha generado una nueva contraseña. Ahora puedes ingresar a tu cuenta.</p>
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
                                                <td  align='left' style='padding: 12px 0px 15px 0px;; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;'>
                                                    <span style='font-family:Helvetica, Arial,sans-serif;color:#8f8f8f;font-size:18px;font-weight:300;line-height:1.1;'>Contraseña:</span>
                                                </td>
                                                <td  style='padding: 12px 10px; margin: 0px; font-size: 18px; font-family: Times New Roman, Times, serif; line-height: 1.3;'>
                                                    <span style='font-family:Helvetica,sans-serif;font-size:18px;font-weight:400;color:#161414;line-height:1.3;'> {$password}</span>
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
                                                <span style='font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:300;color:#262626; line-height:1.3;'>Este correo se envia de manera automatica, si tiene alguna duda, &nbsp;</span><div><span style='font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:300;color:#262626; line-height:1.3;'> favor de entrar a nuestra pagina <a href='http://mypsa.com.mx/'> http://mypsa.com.mx/ </a> y comunicarse a nuestros numeros telefonicos. Gracias! </span>                                   
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
            </div>
        </body>
        </html>";

        return $html;
    }

}

?>