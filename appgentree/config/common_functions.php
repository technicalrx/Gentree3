<?php
function sqlinj( $string ) {	

	$string = mysql_real_escape_string( $string );

	$string = trim( $string );

	$string = strip_tags( $string );

	return $string;

}

function desp_sqlinj($string) {	

	$string = mysql_real_escape_string($string);
	
	$string = preg_replace("/\r\n|\r|\n/",'<br/>',$string);

	return $string;

}

function mailforget($subject,$tomail,$toname,$link)
{

$imgSrc   = 'https://www.google.com/images/srpr/logo11w.png'; // Change image src to your site specific settings 
$imgDesc  = 'https://www.google.com/images/srpr/logo11w.png'; // Change Alt tag/image Description to your site specific settings 
$imgTitle = 'Google Logo'; // Change Alt Title tag/image title to your site specific settings 

/* 
Change your message body in the given $subjectPara variables.  
$subjectPara1 means 'first paragraph in message body', $subjectPara2 means'first paragraph in message body', 
if you don't want more than 1 para, just put NULL in unused $subjectPara variables. 
*/ 
$subjectPara1 = 'Emailing Google+ connections works a bit differently to protect the privacy of email addresses.  
Your email address is not visible to your Google+ connections until you send them an email, and their email addresses are not visible to you until they respond.'; 
$subjectPara2 = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry s standard dummy text ever  
since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,  
but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets  
containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'; 
$subjectPara3 = NULL; 
$subjectPara4 = NULL; 
$subjectPara5 = NULL; 

$message = '<!DOCTYPE HTML>'. 
'<head>'. 
'<meta http-equiv="content-type" content="text/html">'. 
'<title>Email notification</title>'. 
'</head>'. 
'<body>'. 
'<div id="header" style="width: 80%;height: 60px;margin: 0 auto;padding: 10px;color: #fff;text-align: center;background-color: #E0E0E0;font-family: Open Sans,Arial,sans-serif;">'. 
   '<img height="50" width="220" style="border-width:0" src="'.$imgSrc.'" alt="'.$imgDesc.'" title="'.$imgTitle.'">'. 
'</div>'. 

'<div id="outer" style="width: 80%;margin: 0 auto;margin-top: 10px;">'.  
   '<div id="inner" style="width: 78%;margin: 0 auto;background-color: #fff;font-family: Open Sans,Arial,sans-serif;font-size: 13px;font-weight: normal;line-height: 1.4em;color: #444;margin-top: 10px;">'. 
       '<p>'.$subjectPara1.'</p>'. 
       '<p>'.$subjectPara2.'</p>'. 
       '<p>'.$subjectPara3.'</p>'. 
       '<p>'.$subjectPara4.'</p>'. 
       '<p>'.$subjectPara5.'</p>'. 
   '</div>'.   
'</div>'. 

'<div id="footer" style="width: 80%;height: 40px;margin: 0 auto;text-align: center;padding: 10px;font-family: Verdena;background-color: #E2E2E2;">'. 
   'All rights reserved @ mysite.html 2014'. 
'</div>'. 
'</body>'; 

/*EMAIL TEMPLATE ENDS*/ 


$to      = $tomail;             // give to email address 
$subject = $subject;  //change subject of email 
$from    = 'info@catalystimpact';                           // give from email address 

// mandatory headers for email message, change if you need something different in your setting. 
$headers  = "From: " . $from . "\r\n"; 
$headers .= "Reply-To: ". $from . "\r\n";  
$headers .= "MIME-Version: 1.0\r\n"; 
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 

return mail($to, $subject, $message, $headers);

}

function mailformat($subject, $recevername, $message, $tomail, $toname, $fromail, $fromname, $attachment = '') {

	$mail_body = '';

	$mail_body .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

	$mail_body .= '<html xmlns="http://www.w3.org/1999/xhtml">';

	$mail_body .= '<head>';

	$mail_body .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

	$mail_body .= '<title>'.$subject.'</title>';

	$mail_body .= '</head>';

	

	$mail_body .= '
		<body style="margin:0px; padding:0px; contenteditable="#FFF;" font-family:Arial, Helvetica, sans-serif; background: url('.SITE_URL.'images/banner.png) no-repeat;">		
			<div style="width:700px;">
				<div style="padding-bottom:10px; border-bottom:#503b1c solid 1px;"><img src="'.SITE_URL.'images/site-logo.png"/></div>
				<div style="margin:20px 0 25px 0px; font-family:Verdana; font-size:13px; font-weight:bold;">Dear '.$recevername.',</div>
				<div style="font-family:Verdana; font-size:12px; margin-bottom:20px;">'.$message.'</div>
				<div style="margin:20px 0 20px 0px; font-family:Verdana; font-size:13px; font-weight:bold;">Best Wishes,<br />'.SITE_TITLE.'
			</div>
		</body>

	';

	$mail = new PHPMailer(true);

	$mail->From = $fromail;

	$mail->FromName = $fromname;

	$mail->addAddress($tomail, $toname);


	if( $attachment ) {

		$mail->addAttachment($attachment);

	}

	$mail->isHTML( true );

	$mail->Subject = $subject;

	$mail->Body    = $mail_body;


	$r = $mail->send();

	return $r;

}
function site_paging( $SITEURL, $total_record, $url, $pagevar ) {
	$tot1 = $total_record;
	?>
	<div id="paginatio">
	<?php
	$disable = '';
	$prev = $pagevar-1;
	$href = 'href='.$url;
	$href1 = 'href='.$url.'/'.$prev;
	if($pagevar == 0 || $pagevar == "")
	{
		$disable = 'disabled';
		$href = '';
		$href1 = '';
	}
	?>
		<a <?php echo $href?>  class="btn <?php echo $disable?>" style="margin: 4px; text-decoration: none;"> << </i></a>
		<a <?php echo $href1?> class="btn <?php echo $disable?>" style="margin: 4px; text-decoration: none;"> < </a>
		
		
		<?php
		if($pagevar == "")
			$pagevar = 0;
		
		if($pagevar > 2)
		{
			$pagint_start = $pagevar-2;
			$pagint_end = $pagevar+3;
		}
		else
		{
			$pagint_start = 0;
			$pagint_end = 5;
		}
		
		if($pagint_end > $total_record)
		{
			$pagint_start = $total_record-5;
			$pagint_end = $total_record;
		}
		if($total_record <= 5)
		{
			$pagint_start = 0;
			$pagint_end = $total_record;
		}
		
		
		for($i = $pagint_start; $i < $pagint_end; $i++)
		{
			$current = '';
			$href = 'href='.$url.'/'.$i;
			if($pagevar == $i)
			{
				$current = 'btn-primary';
				$href = '';
			}
		?>
			<a <?php echo $href?> class="btn <?php echo $current?>" style="margin: 4px; text-decoration: none;"><?php echo $i+1?></a>
		<?php
		}
		?>
		<?php
		$disable = '';
		$next = $pagevar+1;
		$href = 'href='.$url.'/'.$next;
		
		$tot1--;
		$href1 = 'href='.$url.'/'.$tot1;
		
		if($pagevar >= $tot1)
		{
			$disable = 'disabled';
			$href = '';
			$href1 = '';
		}
		?>
		<a <?php echo $href?> class="btn <?php echo $disable?>" style="margin: 4px; text-decoration: none;"> > </i></a>
		<a <?php echo $href1?> class="btn <?php echo $disable?>" style="margin: 4px; text-decoration: none;"> >> </i></a>
	</div>
<?php
}
function change_slug($change_slugs, $slug_slug, $name_slug, $table_name, $count_slugs = 0) {

	$change_slugs = str_replace("&","",  strtolower( $change_slugs));

	$change_slugs = str_replace("#","",  strtolower( $change_slugs ));

	$change_slugs = str_replace("%","",  strtolower( $change_slugs ));

	$change_slugs = str_replace("!","",  strtolower( $change_slugs ));

	$change_slugs = str_replace("@","",  strtolower( $change_slugs ));

	$change_slugs = str_replace("$","",  strtolower( $change_slugs ));

	$change_slugs = str_replace("^","",  strtolower( $change_slugs ));

	$change_slugs = str_replace("*","",  strtolower( $change_slugs ));

	$change_slugs = str_replace("(","",  strtolower( $change_slugs ));

	$change_slugs = str_replace(")","",  strtolower( $change_slugs ));

	$change_slugs = str_replace("+","",  strtolower( $change_slugs ));

	$change_slugs = str_replace("=","",  strtolower( $change_slugs ));

	$change_slugs = str_replace("/","",  strtolower( $change_slugs ));

	$change_slugs = str_replace(" ","-", strtolower( $change_slugs ));

	$change_slugs = str_replace(".","",  strtolower( $change_slugs ));

	

	$count = mysql_num_rows(mysql_query("select ".$slug_slug." from ".$table_name." where ".$slug_slug." ='".$change_slugs."'"));



	if( $count ) {

		return change_slug($name_slug."-".$count_slugs, $slug_slug, $name_slug, $table_name, ++$count_slugs);

	} else {

		if( $count > 0 ) {

			$change_slugs = $name_slug."-".$count_slugs;

		}

		return $change_slugs;

	}

}

//function to parse arguments from urls

function get_url_params() {

	

    //Get the query string made of slashes

    $slashes=explode("/",trim(htmlentities(array_shift($_GET),ENT_QUOTES),"/"));

	

	//print_r ($slashes);

	

    //Extract the asked page from those parameters

    switch(count($slashes)) {

        case 0:

            $params['page'] = "home";

            break;

        case 1:

            $params['page'] = array_shift($slashes);

            break;

        case ((count($slashes) % 2)==1):

            //odd

            $params['page'] = array_shift($slashes);

            break;

        default:

            //even

            $params['page'] = array_shift($slashes);

            //$params['myparam'] = array_shift($slashes);

            break;

    }

 

    //Process the parameters by pairs

    $cpt = 1;

	$param = "";

    if( !empty( $slashes ) ) {

		foreach($slashes as $get){

		   $params[] = htmlentities($get,ENT_QUOTES);

		}

	}

 

    //Process the $_GET parameters if any

    if( !empty( $_GET ) ) { 

		foreach($_GET as $name=>$get){

			$params[] = htmlentities( $get, ENT_QUOTES );

		}

	}

    return $params;

}

function compress_image($source_url, $destination_url, $quality) {

	$info = getimagesize($source_url);

	if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);

	elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);

	elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);

	imagejpeg($image, $destination_url, $quality);

	return $destination_url;

}


function redirect($url)
{
	redirct($url);
}

function redirct( $url ) {

	$url = preg_replace('|[^a-z0-9-~+_.?#=&;,/:%!]|i', '', $url);

	$url = validate_redirect($url);

	echo '<script type="text/javascript">window.location="'.$url.'"</script>';

	exit();

}

function validate_redirect($location, $default = '') {

	$location = trim( $location );

	// browsers will assume 'http' is your protocol, and will obey a redirect to a URL starting with '//'

	if ( substr($location, 0, 2) == '//' )

		$location = 'http:' . $location;



	// In php 5 parse_url may fail if the URL query part contains http://, bug #38143

	$test = ( $cut = strpos($location, '?') ) ? substr( $location, 0, $cut ) : $location;



	$lp  = parse_url($test);



	// Give up if malformed URL

	if ( false === $lp )

		return $default;



	// Allow only http and https schemes. No data:, etc.

	if ( isset($lp['scheme']) && !('http' == $lp['scheme'] || 'https' == $lp['scheme']) )

		return $default;



	// Reject if scheme is set but host is not. This catches urls like https:host.com for which parse_url does not set the host field.

	if ( isset($lp['scheme'])  && !isset($lp['host']) )

		return $default;

		

	return $location;

}



/**

 * For Uploading File

 */

function upload_file($file_object, $destination_dir, $valiad_mime_types, $id)

{

	

	$img_name = $file_object['name'];

	$fileext = strtolower(substr($file_object['name'],-4));

	if($fileext == "jpeg") {

		$fileext=".jpg";

	}
	if($fileext == "docx") {

		$fileext=".docx";

	}

	$pfilename = $id.$fileext;

	$dir = $destination_dir.$pfilename;

	

	$upload = new Upload();

	$upload->SetFileName($pfilename);

	$upload->SetTempName($file_object['tmp_name']);

	$upload->SetUploadDirectory($destination_dir); //Upload directory, this should be writable

	$upload->SetValidExtensions($valiad_mime_types);

	$upload->UploadFile();

	return $pfilename;

}

function reArrayFiles(&$file_post) {



    $file_ary = array();

    $file_count = count($file_post['name']);

    $file_keys = array_keys($file_post);



    for ($i=0; $i<$file_count; $i++) {

        foreach ($file_keys as $key) {

            $file_ary[$i][$key] = $file_post[$key][$i];

        }

    }



    return $file_ary;

}

/* For Generate Randomg String */
function generateRandomString($length = 8) {
    return substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

function rating_box_color($rating)
{
	$color = '';
	switch($rating)
	{
		case '0' : $color = 'style="background:#ff0000"'; break;
		case '1' : $color = 'style="background:#ff0000"'; break;
		case '2' : $color = 'style="background:#9c3e00"'; break;
		case '3' : $color = 'style="background:#9c3e00"'; break;
		case '4' : $color = 'style=""'; break;
		case '5' : $color = 'style=""'; break;
	}
	
	return $color;
}

function rating_smily($rating)
{
	$color = '';
	switch(ceil($rating))
	{
		case '0' : $color = 'images/sad.png'; break;
		case '1' : $color = 'images/sad.png'; break;
		case '2' : $color = 'images/Angry face.png'; break;
		case '3' : $color = 'images/Angry face.png'; break;
		case '4' : $color = 'images/happy.png'; break;
		case '5' : $color = 'images/happy.png'; break;
	}
	
	return $color;
}

/* For Generate Randomg String */
function generateRandom($length = 8) {
    return substr(str_shuffle("0123456789"), 0, $length);
}

function RandomString($first,$last)
{
	$str;
	if(strlen($first)>2)
	{
		$str=$str.substr($first,0,2);
	}else
	{
		$str=$str.$first;
	}

	if(strlen($last)>2)
	{
		$str=$str.substr($last,0,2);
	}else
	{
		$str=$str.$last;
	}

	if(strlen($str)==4)
	{
		$str=$str.generateRandom(4);
	}else
	{
		$str=$str.generateRandom(8-strlen($str));
	}

	return strtolower($str);
}
?>