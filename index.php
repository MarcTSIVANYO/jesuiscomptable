<?php
    include('class_utilitaires.php');
     // destinataire est votre adresse mail. Pour envoyer à plusieurs à la fois, séparez-les par une virgule
    $destinataire =  "contact@jesuiscomptable.com" ;
    $notification=" ";
    // copie ? (envoie une copie au visiteur)
    $copie = 'oui';
        // Messages de confirmation du mail
    $message_envoye = "Votre message nous est bien parvenu !";
    $message_non_envoye = "L'envoi du mail a &eacute;chou&eacute;, veuillez r&eacute;essayer SVP!";
    $email_error='Email Invalide';
    // formulaire envoyé, on récupère tous les champs.
    $nomprenoms     = (isset($_POST['nomprenoms']))     ? $classutilitaire->Rec($_POST['nomprenoms'])     : '';
    $telephone   = (isset($_POST['telephone']))   ? $classutilitaire->Rec($_POST['telephone'])   : '';
    $email   = (isset($_POST['email']))   ? $classutilitaire->Rec($_POST['email'])   : '';
    $objet   = (isset($_POST['objet']))   ? $classutilitaire->Rec($_POST['objet'])   : '';
    $message = (isset($_POST['message'])) ? $classutilitaire->Rec($_POST['message']) : ''; 
 
    if($_POST){   
        if($classutilitaire->IsEmail($email)){ 
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From:'.$nomprenoms.' <'.$email.'>' . "\r\n" .
            'Reply-To:'.$email. "\r\n" .
            'Content-Type: text/html; charset="utf-8"; DelSp="Yes"; format=flowed '."\r\n" .
            'Content-Disposition: inline'. "\r\n" .
            'Content-Transfer-Encoding: 7bit'." \r\n" .
            'X-Mailer:PHP/'.phpversion(); 
        // envoyer une copie au visiteur ?
        $message ="<!doctype html><html><head><title></title></head><body><h2> <br/> T&eacute;l&eacute;phone :".$telephone." <br/></h2> ".$message.'</body></html>';
         
        if ($copie == 'oui')
        {
            $cible = $destinataire.';'.$email;
        }
        else
        {
            $cible = $destinataire;
        };

        // Remplacement de certains caractères spéciaux
        $objet = str_replace("&#039;","'",$objet);
        $objet = str_replace("&#8217;","'",$objet);
        $objet = str_replace("&quot;",'"',$objet);
        $objet = str_replace('<br>','',$objet);
        $objet = str_replace('<br />','',$objet);
        $objet = str_replace("&lt;","<",$objet);
        $objet = str_replace("&gt;",">",$objet);
        $objet = str_replace("&amp;","&",$objet);
                
        $message = str_replace("&#039;","'",$message);
        $message = str_replace("&#8217;","'",$message);
        $message = str_replace("&quot;",'"',$message);
        $message = str_replace('<br>','',$message);
        $message = str_replace('<br />','',$message);
        $message = str_replace("&lt;","<",$message);
        $message = str_replace("&gt;",">",$message);
        $message = str_replace("&amp;","&",$message); 
        // Envoi du mail
        $num_emails = 0;
        $tmp = explode(';', $cible);
        
        foreach($tmp as $email_destinataire)
        {
            if (mail($email_destinataire, $objet, $message, $headers))
                $num_emails++;
        }

        if((($copie == 'oui') && ($num_emails == 2)) || (($copie == 'non') && ($num_emails == 1)))
        { 
            $notification="<font color='#E32C83;'>  ".$message_envoye."</font>";
        }
        else
        {
            $notification="<font color='red'>  ".$message_non_envoye."</font>";
        };
        }else{
            $notification="<font color='red'>  ".$email_error."</font>";
        }
    }   
?> 



<!DOCTYPE html>
<html lang="fr">
<head>
	<!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="UNIKO Personal and Portfolio template">
    <meta name="keywords" content="blog, bootstrap, company produits, cv template, experience, html template, one page, personal, produits, team members">
	<meta name="author" content="Agun Mondol">
    
    <!-- Title --> 
    <title>Comptabilité en Ligne</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/favicon/favicon.jpg">
    <!-- Links of css files -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/color.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <link href="css/owl.css" rel="stylesheet">
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top"> 
	<!-- Header Section -->
    <header id="header" class="navbar-main navbar-fixed-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="header_area">
                        <nav class="navbar navbar-default">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand call-section" href="#page-top"><img src="img/logo/logo.jpg" alt="logo"></a>
                            </div>
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav navbar-right">
                                    <li class="active"><a class="call-section" href="#page-top">Accueil</a></li> 
                                    <li><a class="call-section" href="#service">Services</a></li> 
                                    <li><a class="call-section" href="#contact">Contact</a></li>
                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Start Slider -->  
    <section id="slider">
        <div class="container-fluid">
            <div class="row">
                <div class="slider_area">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        
                    <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <img src="img/slider/1.jpg" alt="">
                                <div class="carousel-caption">
                                    <div class="slider-title">
                                        <h2 style="color: white;">DEVIS COMPTABILITE EN LIGNE </h2>
                                    </div>
                                    <!-- <h5 class="slider-sub-title">Creative UI / UX Designer and Developer</h5> -->
                                    <div class="btn-hire"><a class="btn-default" href="#contact"><i class="fa fa-paper-plane plane" aria-hidden="true" ></i>Demandez un Devis</a></div>
                                    <a class="arrow_btn call-section" href="#service"><i class="fa fa-angle-down down" aria-hidden="true"></i></a>
                                </div>
                            </div>
                            <div class="item">
                                <img src="img/slider/2.jpg" alt="">
                                <div class="carousel-caption">
                                    <div class="slider-title">
                                        <h2 style="color: white;">BUSINESS PLAN EN LIGNE </h2>
                                    </div> 
                                    <div class="btn-hire"><a class="btn-default" href="#contact"><i class="fa fa-paper-plane plane" aria-hidden="true"></i>Demandez un devis</a></div>
                                </div>
                            </div>
                            <div class="item">
                                <img src="img/slider/3.jpg" alt="">
                                <div class="carousel-caption"> 
                                    <div class="slider-title">
                                        <h2 style="color: white;">FORMATION EN LIGNE </h2>
                                    </div>  
                                    <div class="btn-hire"><a class="btn-default" href="#contact"><i class="fa fa-paper-plane plane" aria-hidden="true"></i>Demandez un devis</a></div> 
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Skill building view -->  
 
    <!-- Service Thumbnails --> 
    <section id="service" style="margin-top: 50px; margin-bottom:  50px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="service_area">
                        <h3 class="title white animate bottom">Nos Services</h3>
                        <!-- <div class="sub-title white animate bottom">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sequi tempora veritatis nemo aut ea iusto eos est expedita, quas ab adipisci consectetur tempora jet.</div> -->
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="service-item animate bottom">
                                    <div class="srv-box">
                                        <i class="fa fa-truck"></i>
                                        <h5 class="srv-title">COMPTABILITE</h5>
                                        <p>description description description.....</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="service-item animate bottom">
                                    <div class="srv-box">
                                        <i class="fa fa-exchange service_font" "></i>
                                        <h5 class="srv-title">BUSINESS PLAN</h5>
                                        <p>description description description.....</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="service-item animate bottom">
                                    <div class="srv-box">
                                        <i class="fa fa-cubes service_font"></i>
                                        <h5 class="srv-title">FORMATION</h5>
                                        <p>description description description.....</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>   
    <!-- Footer Contact Section -->        
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="contact_area">
                        <h2 class="title white animate bottom">Nous contacter</h2>
                        <div class="sub-title white animate bottom">Les champs (*) sont obligatoires.</div>
                        <div>  <h3><?php echo  $notification ?></h3></div>
                        <form class="form" action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="nomprenoms" placeholder="Nom & Prénoms (*)" required="">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" placeholder="Email (*)" required="">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="objet" placeholder="Votre Objet (*)" required="">
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="telephone" placeholder="Téléphone (*)" required="">
                                </div>
                                <div class="col-md-12">
                                    <textarea cols="20" rows="6" name="message" placeholder="Votre Message (*)" required=""></textarea>
                                </div>
                                <div class="col-md-12">
                                    <div class="form_button">
                                        <button type="submit" name="submit" class="btn-submit">Envoyer</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="contact-info">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="adress">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        <span>Lomé - TOGO; Cotonou - Bénin</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="adress">
                                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                        <span>contact@jesuiscomptable.com</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="adress">
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                        <span>(+229) 95 02 29 44 <br/> (+228) 92 33 97 43 / 92 44 66 90</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="adress">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        <span>Lun-Sam: 07h30 - 18h (GMT) <br></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Copy Right Text -->
    <footer id="coppyright">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="coppyright_area">
                         <a href="http://www.jesuiscomptable.com/webmail" target="_blank" style="padding-right: 60px;">WebMail</a> 
                        <span>@2019. All Rights Reserved.  Powered by <a href="http://www.mastersolut.com" target="_blank">MasterSolut</a></span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- All Javascript Plugin File here -->
	<script src="js/jquery/1.12.4/jquery.min.js"></script> <!-- jQuery 1.x snippet -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.fancybox.pack.js"></script>
    <script src="js/mixitup.js"></script>
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/jquery.countTo.js"></script>
    <script src="js/owl.js"></script>
    <script src="js/custom.js"></script> <!-- Custom Jquery -->    
</body>
</html>