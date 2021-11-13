<?php

Class Utilitaire{
    
   private $dbh;
    
  
   public function create_tabsmenu_administration($page,$tabsmenu,$catpage){
     $tab=$this->dbh->query("select * from gest_menu  where id_page in (select id_page from gest_page where lib_page='$page' and cat_page='$catpage') and visible='o' order by indice_menu ASC");
     if($tab->rowCount()){
         echo '<ul>';
         foreach($tab as $tabvalues){
            $classcurrent="";
            
            if(($tabsmenu==$tabvalues['id_menu'])){
              $classcurrent='class="current"';  
            }else{
               if($tabvalues['indice_menu']==1 && $tabsmenu==0)$classcurrent='class="current"'; 
            }
            $lientabsmenu='?page='.$page.'-'.$tabvalues['id_menu'];
            $liblientabsmenu=$tabvalues['lib_menu'];
            echo"<li><a href='$lientabsmenu' $classcurrent ><span>$liblientabsmenu</span></a></li>";
         }
         echo '</ul>';
     }
   } 
   
   
   
    public function fichier_displaycontent($page,$id_menu,$catpage){
     $tab=$this->dbh->query("select * from gest_menu  where id_menu='$id_menu'   and visible='o' order by indice_menu ASC");
     $tabfetch=$tab->fetch();
     if($tab->rowCount()){
         return $tabfetch['lien_menu'];
     }else{
       $tabs=$this->dbh->query("select * from gest_menu  where id_page in (select id_page from gest_page where lib_page='$page'and cat_page='$catpage') and visible='o' order by indice_menu ASC"); 
       $tabsfetch=$tabs->fetch();
       return $tabsfetch['lien_menu'];
     }
   } 
   
   
   
   public function mail_attach($to , $sujet , $message , $fichier,$type, $name , $from){
   //$type=mime_content_type($fichier);
   $mail_mime = "MIME-Version: 1.0\n";
   $mail_mime .= "Content-Type: multipart/mixed;\n";
   $mail_mime .= " boundary=\"----=_NextPart\"\n\n";
   $texte = "------=_NextPart\n";
   $texte .= "Content-Type: text/plain; charset=\"utf-8\"\n";
   $texte .= "Content-Transfer-Encoding: 32bit\n\n";
   $texte .= stripslashes($message);
   $texte .= "\n\n";
   $attachement = "------=_NextPart\n";
   $attachement .= "Content-Type:  $type; name=\"$name\"\n";
   $attachement .= "Content-Transfer-Encoding: base64\n";
   $attachement .= "Content-Disposition: attachment; filename=\"$name\"\n\n";
   $fp = fopen($fichier, "rb");
   $buff = fread($fp, filesize($fichier));
   fclose($fp);
   $attachement .= chunk_split(base64_encode($buff));
   $attachement .= "\n\n\n------=_NextPart\n";
   $sujet = stripslashes($sujet);
   $from = stripslashes($from);
   if (file_exists($fichier))
      {
      return @mail($to, $sujet, $texte.$attachement, "From: $from\n".$mail_mime);
      }
      else
      {
      return @mail($to, $sujet, $texte, "From: $from\n".$mail_mime);
      }
  
 }
   
   
   
    public function sans_espace($str){
        $vowels = array(" ");
        return str_replace($vowels, "", $str);
    }
   
public function datesql_to_frenchdate($date)
{
    $date=substr($date,0,10);
    list($year,$month,$day) = explode("-",$date);
    $date = "$day/$month/$year";
	return $date;
}

public function datesql_to_frenchdate_lettre($date)
{
    $date=substr($date,0,10);
    list($year,$month,$day) = explode("-",$date);
    $months = array ("janvier","f&eacute;vrier","mars","avril","mai","juin","juillet","ao&ucirc;t","septembre","octobre","novembre","d&eacute;cembre");
    $month_lettre=$months[$month-1];
    
    $date = "$day $month_lettre $year";
	return $date;
}


public function recuperer_une_chaine_numerique($chaine)
{
    $chaine_propre = eregi_replace("[^0-9]","",$chaine);
	return $chaine_propre;
}
   
   
   
   public function upload_file($dossier,$taille_max=1000000000000,$tab_extension=array('.gif','.jpg','.png','.jpeg','.pdf','.doc','.docx','.xlsx','.xls','.txt'),$name_input_file='',$nouveau_nom){			
		// on contruit notre class
		// 1. on lui donne le chemin vers le répertoire de destination dans notre exemple c'est : '../fichiers/'
		// 2. on lui indique le nom de la balise INPUT FILE qui est 'MON_FICHIER_A_ENVOYER' (voir le formulaire)
        if(!is_dir($dossier)) mkdir($dossier);
		$obj = new upload($dossier, $name_input_file);
		
		// Déclaration des variables de la classe upload
		$obj->cl_taille_maxi = 100000000000; // on attribut la taille maximum du fichier autorisés (1 mo environ dans notre exemple)
		$obj->cl_extensions = array('.gif','.jpg','.png','.jpeg','.pdf','.doc','.docx','.xlsx','.xls','.txt'); // on attribut les extensions autorisées
		
		// on envoi le fichier grace à notre class
		// contrairement au 1er exemple, on met $_POST['perso'] dans uploadFichier, ainsi on aura un nom différent de celui de
		// l'original
		if (!$obj->uploadFichier($nouveau_nom))
		{
			// on récupère l'erreur en cas d'echec grace à notre class
			// et on l'affichera un peu plus bas dans notre code
			$erreur = $obj->affichageErreur();
		}
		else
		{
			// l'envoi c'est bien déroulé, on confirme tout ça et on le laisse continuer
			// je met $erreur=""; pour pas faire vide mais on pourrais enlever le else
			// tout dépend de votre programmation
			$erreur="";
			
			// ici par exemple vous pouvez mettre des données pour votre base sql ou autres...
		}
        $tabupload=array("erreur"=>$erreur,"filefinal"=>$obj->cGetNameFileFinal(true),"size"=>$obj->cGetSizeFile(0,"."),"extension"=>$obj->cGetExtension(),"filetype"=>$obj->cGetTypeFile());
        return $tabupload;
   }
   
   public function notification1($etat='success',$texte=''){
        return "<p class='$etat'>$texte</p>";
   }
   
   public function notification($icone,$etat='alert-danger',$texte=''){
        return "
            <div class='$etat'> 
                <h5> <i class='$icone'></i>$texte</h5>
            </div> ";
   }
   
   public function notification2($etat='alert-danger',$texte=''){
        return "
            <div class='alert alert-block'".$etat."' fade in'>
                <button data-dismiss='alert' class='close' type='button'>
                  ×
                </button>
                <p> <i class='fa fa-times-circle fa-lg'></i>".$texte." </p>
            </div> ";
   }
    
  public function getVideoId($url){
    $type = "";
    $id ="";
    $titre = "no title";
    $description = "no description";
    $code = "no code";
    $img = "no image";
    //Détermination du "type" de vidéo : 
    if(eregi("youtube",$url))            $type="youtube";
    else if(eregi("dailymotion",$url))    $type="dailymotion";
    else if(eregi("google",$url))        $type="google";
    else if(eregi("vimeo",$url))        $type="vimeo";
    else return false;
    
    //Détermination de l'"ID" de la vidéo :
    if($type=="youtube"){
        $debut_id = explode("v=",$url,2);
        $id_et_fin_url = explode("&",$debut_id[1],2);
        $id = $id_et_fin_url[0];
    }
    return $id;
    
}

public function tronque($chaine, $longueur = 120)
{
        $chaine=strip_tags($chaine);
        if (empty ($chaine))
        {
        return "";
        }
        elseif (strlen ($chaine) < $longueur)
        {
            return $chaine;
        }
        elseif (preg_match ("/(.{1,$longueur})\s./ms", $chaine, $match))
        {
            return $match [1] . "...";
        }
        else
        {
            return stripslashes(substr ($chaine, 0, $longueur));
        }
}
   
function coupeTexte($Texte,$NB)   
{   
   $TabMots=explode(" ",strip_tags($Texte));  
   $NvTexte = '';  
   for($i=0;$i<$NB;$i++)   
   {   
      $NvTexte.=' '.$TabMots[$i];   
   } 
   return $NvTexte;   
}
   
    public function ConvertDateTo($type='en',$date)
    {
        if($type=='en'){
            list($d,$m,$y)=explode('/',$date);
            $val=$y.'-'.$m.'-'.$d;
            if(strtotime($val)) $val=date("Y-m-d");
        }
        if($type=='fr'){
            $val=date("d/m/Y");
            if(strtotime($date)) $val=date("d/m/Y",strtotime($date));
        } 
            return $val; 
        }
            
    /*
 * NoSpamQuestion affiche une question pour la validation d'un formulaire ...
 * $mode, mode question ou réponse par défaut tirage au sort de question {string}
 * $answer, lors de la demande d'une réponse à la question numero tant ... {int}
 *
 * @returns array
 *
 * Ajouter une question :
 * copier/coller ces lignes et remplir le contenu entre guillemets doubles :
 *
 * $array_pictures[$j]['num'] = $j; // ne pas changer cette ligne
 * $array_pictures[$j]['question'] = "mettre ici la question (correspondant à l'image si vous utilisez une image)";
 * $array_pictures[$j]['answer'] = "mettre ici la réponse à l'énigme";
 * $j++; // ne pas oublier cette ligne dans la copie :-)
 *
 * C'est tout. Question suivante ? :-)
 *
 */
    function NoSpamQuestion($mode = 'ask', $answer = 0)
    {
    	$array_pictures = array(); $j = 0;
    
    	$array_pictures[$j]['num'] = $j;
    	$array_pictures[$j]['question'] = "Quelle est la cinqui&egrave;me lettre du mot Astux";
    	$array_pictures[$j]['answer'] = "x";
    	$j++;
    
    	$array_pictures[$j]['num'] = $j;
    	$array_pictures[$j]['question'] = "Le soleil est-il chaud ou froid ?";
    	$array_pictures[$j]['answer'] = "chaud";
    	$j++;
    
    	$array_pictures[$j]['num'] = $j;
    	$array_pictures[$j]['question'] = "Ecrire 12 en lettres";
    	$array_pictures[$j]['answer'] = "douze";
    	$j++;
    
    	if ($mode != 'ans')
    	{
    		// on est en mode 'tirer au sort', on tire une image aléatoire
    		$lambda = rand(0, count($array_pictures)-1);
    		return $array_pictures[$lambda];
    	}
    	else
    	{
    		// on demande une vraie réponse
    		foreach($array_pictures as $i => $array)
    		{
    			if ($i == $answer)
    			{
    				return $array;
    				break;
    			};
    		};
    	}; // Fin if ($mode != 'ans')
    }
     
     /*
 * cette fonction sert à nettoyer et enregistrer un texte
 */
    function Rec($text)
    {
    	$text = htmlspecialchars(trim($text), ENT_QUOTES);
    	if (1 === get_magic_quotes_gpc())
    	{
    		$text = stripslashes($text);
    	}
    
    	$text = nl2br($text);
    	return $text;
    }
    
    /*
     * Cette fonction sert à vérifier la syntaxe d'un email
     */
    function IsEmail($email)
    {
    	$value = preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email);
    	return (($value === 0) || ($value === false)) ? false : true;
    }
    
    function format_url($str)
    {
        //$str = mb_strtolower($str);
        $str= strtolower($str);
        $str = utf8_decode($str);
        //$str = strtr($str, utf8_decode('ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ'), 'aAAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
        $str = strtr($str, utf8_decode('àáçèéê'), 'aaceee');
        $str = preg_replace('`[^a-z0-9]+`', '-', $str);
        $str = trim($str, '-');
        return $str;
    }
 
     
 }
$classutilitaire= new Utilitaire();
?>