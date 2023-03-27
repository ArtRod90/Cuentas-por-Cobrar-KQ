<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    protected $email;
    protected $nombre;

    public function __construct($email, $nombre)
    {
        $this->email = $email;
        $this->nombre = $nombre;
    }

    public function enviarEmail($tipo)
    {
       
        $mail = new PHPMailer();
      //Server settings
      // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = 'smtp.gmail.com  ';                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = 'wfacele@gmail.com';                     //SMTP username
      $mail->Password   = 'fcaozjvdiryoouos';                           //SMTP password
      $mail->SMTPSecure = "tls";                             //Enable implicit TLS encryption               
      $mail->Port= 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
  
      //Recipients
      $mail->setFrom("wfacele@gmail.com", "CuentasFM.com");
      $mail->addAddress($this->email, $this->nombre);     //Add a recipient                
                   
      // debuguear($this->email);
      //Attachments
      /* $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
      $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
   */
      //Content
      $mail->isHTML(true);    
      $mail->CharSet = "UTF-8";                              //Set email format to HTML
    

      if ($tipo === "crear") {
        $mail->Subject = 'Confirma tu Cuenta';
        $contenido = "<html>";
        $contenido .= "<p><b>" . $this->nombre . "</b> Has Creado tu cuenta en WifiBus, porfavor confirmarla
       en el siguiente enlace</p>";
       $contenido .= "<p>Preciona aqui: <a href = 'https://wifibus.mx/confirmar?token=" 
      . $this->token ."'>Confirmar Cuenta</a></p>";

      }elseif ($tipo === "cambiar") {
        $mail->Subject = 'Resstablece tu Password';
        $contenido = "<html>";
        $contenido .= "<p><b>" . $this->nombre . "</b> Has olvidado tu Password sigue las instrucciones
        para cambiar tu password de tu cuenta WifiBus, porfavor sigue el siguiente enlace</p>";
        $contenido .= "<p>Preciona aqui: <a href = 'https://wifibus.mx'>Reestablecer Cuenta</a></p>";
      }
      
      
      $contenido .= "<p>Si tu no creaste esta cuenta, puedes ignorar este mensaje</p>";
      $contenido .= "</html>";
     
      $mail->Body = $contenido;
      
      $mail->send();
      
    }
}