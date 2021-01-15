<?php 
//Filtrando as variaveis
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

//Verificando se as variaveis estão corretas
if ($name && $email && $message) {

    // Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
    require_once("./phpmailer/class.phpmailer.php");
    require_once './phpmailer/class.smtp.php';
    // Inicia a classe PHPMailer
    $mail = new PHPMailer();

    // Define os dados do servidor e tipo de conexão
    $mail->IsSMTP(); // Define que a mensagem será SMTP
    $mail->Host = "smtp.gmail.com"; // Endereço do servidor SMTP
	$mail->Port = 587; // set the SMTP port for the GMAIL server
	$mail->SMTPSecure = "tls"; // sets the prefix to the servier
    $mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
    $mail->Username = 'nti@leiaja.com.br'; // Usuário do servidor SMTP
    $mail->Password = '1q2w3e4r2014'; // Senha do servidor SMTP
    
	// Define o remetente
    $mail->From = "{$email}"; // Seu e-mail
    $mail->FromName = "{$name}"; // Seu nome
    // Define os destinatário(s)
    $mail->AddAddress('redacao@leiaja.com.br', 'Redação Leiajá');
    $mail->AddCC('jenner.portela@sereducacional.com', 'Jenner');    
    //$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta
    // Define os dados técnicos da Mensagem
    $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
    $mail->CharSet = 'UTF-8'; // Charset da mensagem (opcional)
    // Define a mensagem (Texto e Assunto)
    $mail->Subject = "Midiakit 2015 - Portal Leiajá"; // Assunto da mensagem
    $mail->Body = "{$message}";
    $mail->AltBody = "{$message}";

    // Define os anexos (opcional)
    //$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo
    // Envia o e-mail
    $enviado = $mail->Send();

    // Limpa os destinatários e os anexos
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();

    // Exibe uma mensagem de resultado
    if ($enviado) {
        header('location: http://www.leiaja.com/mediakit?s=1');
    } else {
        //echo $mail->ErrorInfo;
        header('location: http://www.leiaja.com/mediakit?s=0');
    }
}else{
    header('location: http://www.leiaja.com/mediakit?s=0');
}

