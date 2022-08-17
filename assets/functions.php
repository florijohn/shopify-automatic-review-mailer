<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require '../vendor/autoload.php';

    function sendTelegramMessage($email, $telegramMsg) {
        require '../config/config.php';
        $data = [
            'appkey' => $appkey,
            'chatid' => $chatid,
            'other' => urlencode($telegramMsg)
        ];
        file_get_contents($webhookURL . http_build_query($data) );
    }

    function getURLParameter () {
        $street = $_GET['street'];
        $zip = $_GET['zip'];
        $city = $_GET['city'];
        $email = $_GET['email'];
        $addressData = array($street, $zip, $city, $email);

        return $addressData;
    }
    function getUserAgent() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($userAgent, 'iPod') !== false) {
            $os = 'ios';
        } elseif (strpos($userAgent, 'iPhone') !== false) {
            $os = 'ios';
        } elseif (strpos($userAgent, 'iPad') !== false) {
            $os = 'ios';
        } elseif (strpos($userAgent, 'Android') !== false) {
            $os = 'android';
        } else {
            $os = 'android';
        }
        return $os;
    }
    function clientToMap() {
        $os = getUserAgent();
        $addressData = getURLParameter();
        $street = $addressData[0];
        $zip = $addressData[1];
        $city = $addressData[2];

        // $baseurlGoogleMaps = "https://www.google.de/maps/place/";
        // $baseurlAppleMaps = "https://maps.apple.com/?address=1,";
        $googleMapsURL = "https://www.google.de/maps/place/$street+$zip+$city";
        $appleMapsURL = "https://maps.apple.com/?address=1,$street+$zip+$city";
        $googleURL = "https://google.com";

        if( $os == 'ios' ){
            header('Location: '.$appleMapsURL);
            die();
        }else if($os == 'android'){
            header('Location: '.$googleMapsURL);
            die();
        } else {
            header('Location: '.$googleURL);
            die();
        }
    }
    function updateDB($email) {
        require '../config/config.php';
      $conn = new mysqli($servername, $username, $password, $dbname);
      $now = date_create()->format('Y-m-d H:i:s');
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $sql = "UPDATE customers SET lastMailSent = \"$now\" WHERE mail = \"$email\" ";

      if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }

      $conn->close();
    }
    function sendEmail($recipient) {
        require '../config/config.php';
        $mail = new PHPMailer(true);
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $mailHost;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $senderMail;                     //SMTP username
        $mail->Password   = $senderMailpw;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 25;
        $mail->SMTPAutoTLS = false;  
        $mail->SMTPSecure = false;   
        $mail->isHTML(true);
        $mail->CharSet   = 'UTF-8';

        $mail->setFrom($senderMail, "Als Pizza und Pasta");

        // custom options
        $mail->addAddress($recipient, "Deine Meinung zählt!");     // Add a recipient");
        
        $mail->Subject = "Deine Meinung zählt!";
        $msg = '<!DOCTYPE html>
        <html lang="de">
          <head>
            <title>Al´s Pizza - Deine Meinung zählt!</title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta name="viewport" content="width=device-width" />
            <link
              rel="stylesheet"
              type="text/css"
              href="/assets/notifications/styles.css"
            />
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
            <style>
              body {
                margin: 0;
              }
        
              .body {
                height: 100% !important;
                width: 100% !important;
              }
        
              .row {
                width: 100%;
              }
        
              .container {
                width: 560px;
                text-align: left;
                margin: 0 auto;
              }
        
              @media (max-width: 600px) {
                .container {
                  width: 94% !important;
                }
              }
        
              table {
                border-spacing: 0;
                border-collapse: collapse;
              }
        
              td {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto",
                  "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans",
                  "Helvetica Neue", sans-serif;
              }
        
              h1,
              h2,
              h3,
              h4,
              h5,
              h6 {
                font-weight: normal;
                margin: 0;
              }
        
              h1,
              h1 a,
              h1 a:hover,
              h1 a:active,
              h1 a:visited {
                font-size: 30px;
                color: #333;
              }
        
              h2 {
                font-size: 24px;
                margin-bottom: 10px;
              }
        
              h3 {
                font-size: 20px;
                margin-bottom: 25px;
              }
        
              h4 {
                font-size: 16px;
                font-weight: 500;
                color: #555;
                margin-bottom: 5px;
              }
        
              p {
                margin: 0;
                color: #777;
                line-height: 150%;
              }
        
              p + p {
                margin-top: 15px;
              }
        
              span,
              strong,
              del,
              a,
              p {
                font-size: 16px;
              }
        
              strong {
                color: #555;
              }
        
              small {
                font-size: 14px;
                color: #999;
              }
        
              a,
              a:hover,
              a:active,
              a:visited {
                text-decoration: none;
              }
        
              .actions {
                margin-top: 20px;
              }
        
              .main-action-cell {
                float: left;
                margin-right: 15px;
              }
        
              @media (max-width: 600px) {
                .main-action-cell {
                  float: none !important;
                  margin-right: 0 !important;
                }
              }
        
              .secondary-action-cell {
                margin-top: 19px;
              }
        
              @media (max-width: 600px) {
                .secondary-action-cell {
                  text-align: center;
                  width: 100%;
                }
              }
        
              .section {
                border-top: 1px solid #e5e5e5;
              }
        
              .section__cell {
                padding: 40px 0;
              }
        
              .content__cell {
                padding-bottom: 40px;
              }
        
              .text-icon-row td {
                padding-bottom: 5px;
              }
        
              .text-icon {
                padding-right: 8px;
              }
        
              .text-icon__image {
                width: 18px;
                height: 18px;
                display: inline-block;
                vertical-align: middle;
              }
        
              .header {
                margin: 40px 0 20px;
              }
        
              @media (max-width: 600px) {
                .header {
                  margin-top: 20px !important;
                  margin-bottom: 2px !important;
                }
              }
        
              @media (max-width: 600px) {
                .shop-name__cell {
                  display: block;
                }
              }
        
              .order-number__cell {
                text-transform: uppercase;
                font-size: 14px;
                text-align: right;
                color: #999;
              }
        
              @media (max-width: 600px) {
                .order-number__cell {
                  display: block;
                  text-align: left !important;
                  margin-top: 20px;
                }
              }
        
              @media (max-width: 600px) {
                .button {
                  width: 100%;
                }
              }
        
              .button__cell {
                text-align: center;
                padding: 20px 25px;
                border-radius: 4px;
              }
        
              .button__text,
              .button__text:hover,
              .button__text:active,
              .button__text:visited {
                color: #fff;
                text-decoration: none;
              }
        
              .or {
                color: #999;
                display: inline-block;
                margin-right: 10px;
              }
        
              @media (max-width: 600px) {
                .or {
                  margin-right: 0 !important;
                }
              }
        
              .apple-wallet-button {
                display: block;
                margin-top: 15px;
              }
        
              @media (max-width: 600px) {
                .apple-wallet-button {
                  text-align: center;
                }
              }
        
              .customer-info__item {
                padding-bottom: 40px;
                width: 50%;
              }
        
              @media (max-width: 600px) {
                .customer-info__item {
                  display: block;
                  width: 100% !important;
                }
              }
        
              .customer-info__item--last {
                padding-bottom: 0;
              }
        
              .customer-info__item-credit {
                height: 24px;
                display: inline-block;
                margin-right: 10px;
                margin-top: 5px;
                margin-bottom: -6px;
              }
        
              .footer {
                border-top: 1px solid #e5e5e5;
              }
        
              .footer__cell {
                padding: 35px 0;
              }
        
              .disclaimer__subtext {
                font-size: 14px;
                color: #999;
              }
        
              .disclaimer__subtext a {
                font-size: 14px;
              }
        
              .spacer {
                min-width: 600px;
                height: 0;
              }
        
              @media (max-width: 600px) {
                .spacer {
                  display: none;
                }
              }
        
              .order-list__item {
                width: 100%;
                border-bottom: 1px solid #e5e5e5;
              }
        
              .order-list__item--single,
              .order-list__item--last {
                border-bottom: none !important;
              }
        
              .order-list__item__cell {
                padding: 15px 0;
              }
        
              .order-list__item--single .order-list__item__cell,
              .order-list__item--first .order-list__item__cell {
                padding-top: 0 !important;
              }
        
              .order-list__item--single .order-list__item__cell,
              .order-list__item--last .order-list__item__cell {
                padding-bottom: 0 !important;
              }
        
              .order-list__product-image {
                margin-right: 15px;
                border: 1px solid #e5e5e5;
                border-radius: 8px;
              }
        
              .order-list__product-description-cell {
                width: 100%;
              }
        
              .order-list__item-title {
                font-weight: 600;
                line-height: 1.4;
                color: #555;
              }
        
              .order-list__item-variant {
                color: #999;
                font-size: 14px;
              }
        
              .order-list__item-original-price {
                display: block;
                text-align: right;
                color: #999;
                font-size: 14px;
              }
        
              .order-list__item-price {
                font-weight: 600;
                text-align: right;
                margin-left: 15px;
                color: #555;
              }
        
              .order-list__price-cell {
                white-space: nowrap;
              }
        
              .subtotal-lines {
                margin-top: 15px;
                border-top: 1px solid #e5e5e5;
              }
        
              .subtotal-table {
                margin-top: 20px;
              }
        
              .subtotal-line td {
                padding: 5px 0;
              }
        
              .subtotal-line__value {
                text-align: right;
              }
        
              .subtotal-line__title p {
                line-height: 1.2em;
              }
        
              .subtotal-table--total {
                border-top: 2px solid #e5e5e5;
              }
        
              .subtotal-table--total td {
                padding: 20px 0 0;
              }
        
              .subtotal-table--total .subtotal-line__value strong {
                font-size: 24px;
              }
        
              .subtotal-table--payment-methods {
                border-top: 1px solid #e5e5e5;
              }
        
              .subtotal-table--payment-methods p,
              .subtotal-table--payment-methods strong {
                color: #999;
                font-size: 14px;
              }
        
              .subtotal-table__small-space {
                height: 10px;
              }
        
              .subtotal-table__line {
                border-bottom: 1px solid #e5e5e5;
                height: 1px;
                padding: 0;
              }
        
              .subtotal-spacer {
                width: 40%;
              }
        
              .emoji {
                padding: 10px;
                font-size: xxx-large;
              }
              .bad {
                color: #ff0000;
              }
              .good {
                color:green;
              }
              .ok {
                color:orange;
              }
              @media (max-width: 600px) {
                .subtotal-spacer {
                  display: none;
                }
              }
            </style>
          </head>
          <body>
            <table class="body">
              <tr>
                <td>
                  <table class="header row">
                    <tr>
                      <td class="header__cell">
                        <center>
                          <table class="container">
                            <tr>
                              <td>
                                <table class="row">
                                  <tr>
                                    <td class="shop-name__cell">
                                      <h1 class="shop-name__text">
                                        <a href="https://als-pizza.de" style="font-weight: 600;">Al´s Pizza und Pasta</a>
                                      </h1>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </center>
                      </td>
                    </tr>
                  </table>
                  <table class="row content">
                    <tr>
                      <td class="content__cell">
                        <center>
                          <table class="container">
                            <tr>
                              <td>
                                <h2>Deine Bewertung</h2>
                                <p>Da wir unseren Dienst stetig verbessern wollen würden wir uns sehr über deine Meinung freuen!</p>
                                <p>Klicke auf ein passendes Emoji um uns deine Meinung mitzuteilen!</p>
                                <br>
                              </td>
                            </tr>
                          </table>
                                <a class="emoji bad" href="https://review.als-pizza.de/ishappy.php?happy=0&email=%email%"><img src="https://review.als-pizza.de/img/frown-solid.png"></a>
                                <a class="emoji bad" href="https://review.als-pizza.de/ishappy.php?happy=0&email=%email%"><img src="https://review.als-pizza.de/img/meh-solid.png"></a>     
                                <a class="emoji ok" href="https://review.als-pizza.de/ishappy.php?happy=1&email=%email%"><img src="https://review.als-pizza.de/img/grin-solid.png"></a>   
                                <a class="emoji good" href="https://review.als-pizza.de/ishappy.php?happy=1&email=%email%"><img src="https://review.als-pizza.de/img/grin-stars-solid.png"></a>
                        </center>
                      </td>
                    </tr>
                  </table>
                  <table class="row footer">
                    <tr>
                      <td class="footer__cell">
                        <center>
                          <table class="container">
                            <tr>
                              <td>
                                <p class="disclaimer__subtext">
                                  Falls du Fragen hast, antworte auf diese E-Mail oder
                                  kontaktiere uns unter
                                  <a href="mailto: info@als-pizza.de">info@als-pizza.de</a
                                  >.
                                </p>
                              </td>
                            </tr>
                          </table>
                        </center>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </body>
        </html>';
        $bodymail = str_replace('%email%', $recipient, $msg);
        $mail->Body = $bodymail;
        $mail->send();
    }
?>