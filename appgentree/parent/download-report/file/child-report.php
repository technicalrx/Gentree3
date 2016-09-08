<?php require('../../../classes.php');
require_once('tcpdf_include.php');
define('K_PATH_MAIN', '../../images/');

$resultid=$_GET['resultid'];

$get_report = $db->get_results("select * from ".TABLE_RESULT." where md5(result_id) = '".$resultid."'");
$childid=md5($get_report[0]->child_id);
$get_child_detail = $db->get_results("select * from ".TABLE_CHILD." where md5(child_id) = '".$childid."'");

// Get list of result of child 
$get_result_student=$db->get_results("select * from ".TABLE_RESULT." where child_id='".$get_report[0]->child_id."' order by  result_id desc");
// Get the index of current result in array
$i=0;
if(count($get_result_student))
{
	foreach ($get_result_student as $grs)
	{
		if($grs->result_id==$get_report[0]->result_id)
		{
			break;
		}
		$i++;
	}
}

if(count($get_result_student))
{
	if(array_key_exists(($i+1), $get_result_student))
	{
		$p_assessment_date=$get_result_student[$i+1]->Period;
	}
	else
	{
		$p_assessment_date='None';
	}
}else
{
	$p_assessment_date='None';
}

	$gr = $get_report[0];
	$gc = $get_child_detail[0];

	$phys = 0;
	$vis = 0;
	$aud = 0;
	$math_logic = 0;
	$sci = 0;
	$verb = 0;
	$selfs = 0;
	$groups = 0;
	$none = 0;
									// physical
								if($gr->Result1A1 == "PK" )
								{
										$phys=1;
								}
								else
									{
										$phys=0;
									}
									// visual 
									if($gr->Result3B2 == "VS")
									{
										$vis=1;
									}
									else {
										$vis=0;
									}
									// auditory
									if($gr->Result2B1 == "AA")
									{
										$aud=1;
									}
									else
									{
										$aud=0;
									}
									// math logic
									if($gr->Result2C1 == "ML" && $gr->Result2C2 == "ML" && $gr->Result2C3 == "ML")
									{
										$math_logic=1;
									}
									else if($gr->Result3A2 == "ML")
									{
										$math_logic=1;
									}
									else {
										$math_logic=0;
									}
									// science
									if($gr->Result3A1 == "NS")
									{
										$sci=1;
									}
									else
									{
										$sci=0;
									}
									// verbal linguistic
									if( $gr->Result2B2 =="VB")
									{
										$verb=1;
									}
									else {
										$verb=0;
									}
									// self group
									if($gr->midpoint=="0" || $gr->midpoint=="2" || $gr->Result4A1=="")
									{
										if( $gr->Result1A2 == "SLF")
										{
											$selfs = 1;
										}
										else if( $gr->Result1A2 == "GRP")
										{
											$groups = 1;
										}
										else {
											$none = 1;
										}
									}
									else{
										if( $gr->Result4A1 == "SLF")
										{
											$selfs = 1;
										}
										else if( $gr->Result4A1 == "GRP")
										{
											$groups = 1;
										}
										else {
											$none = 1;
										}
									}
 	// convert image from png to jpg
  // function convertImage($originalImage, $outputImage, $quality)
		// {
		//     // jpg, png, gif or bmp?
		//     $exploded = explode('.',$originalImage);
		//     $ext = $exploded[count($exploded) - 1]; 

		//     if (preg_match('/jpg|jpeg/i',$ext))
		//         $imageTmp=imagecreatefromjpeg($originalImage);
		//     else if (preg_match('/png/i',$ext))
		//         $imageTmp=imagecreatefrompng($originalImage);
		//     else if (preg_match('/gif/i',$ext))
		//         $imageTmp=imagecreatefromgif($originalImage);
		//     else if (preg_match('/bmp/i',$ext))
		//         $imageTmp=imagecreatefrombmp($originalImage);
		//     else
		//         return 0;

		//     // quality is a value from 0 (worst) to 100 (best)
		//     imagejpeg($imageTmp, $outputImage, $quality);
		//     imagedestroy($imageTmp);

		//     return 1;
		// }
				
		// Child Image
		if($get_child_detail[0]->child_pic!="")
		{
			$inputimage = SITE_URL.'parent/child_image/'.$get_child_detail[0]->child_pic;
		}else if($get_child_detail[0]->sex==1) {
		
			$inputimage = SITE_URL."parent/images/boy-image.png";
	    }else
	    {
	    	$inputimage = SITE_URL."parent/images/girl-image.png";
	    }

	    // Calculate assessement date
	    	$dob= $gc->dob;
			$doa= $gr->Period;
			$dob = strtotime($dob);
			$doa = strtotime($doa);
																	// echo $dob." ";
																	// echo $doa;
			$diff = abs($dob-$doa);
																	// echo " ".$diff." ";
			$month = floor($diff / 2678400);
																	// echo $month;
			if($month>12)
			{
				$year = floor($month/12);
				$num_month = $month%12;
				$assessement_date=$year." year(s) ".$num_month." month(s)";
			}
			else{
					$assessement_date=$month." month(s)";
				}
			
					
		// Learning stype calculate
		                                  if($vis == 1 && $aud == 1 && $phys == 1)
															{
																$lstyle="Visual, Auditory, Physical";
															}
															else if($vis ==1 && $aud == 1)
															{
																$lstyle="Visual, Auditory";
															}
															else if($phys ==1 && $aud == 1)
															{
																$lstyle="Auditory, Physical";
															}
															else if($phys ==1 && $vis == 1)
															{
																$lstyle="Visual, Physical";
															}
															else if($phys ==1)
															{
																$lstyle="Physical";
															}
															else if($aud == 1)
															{
																$lstyle="Auditory";
															}
															else if($vis == 1)
															{
																$lstyle="Visual";
															} 

       //Learning prefrences
															if($sci ==1 && $math_logic == 1 && $verb == 1)
															{
																$lpref="Verbal Linguistic, Math, Science";
															}
															else if($verb ==1 && $math_logic == 1)
															{
																$lpref="Verbal Linguistic, Math";
															}
															else if($sci ==1 && $math_logic == 1)
															{
																$lpref="Math, Science";
															}
															else if($sci ==1 && $verb == 1)
															{
																$lpref="Verbal Linguistic, Science";
															}
															else if($sci ==1)
															{
																$lpref="Science";
															}
															else if($math_logic == 1)
															{
																$lpref="Math";
															}
															else if($verb == 1)
															{
																$lpref="Verbal Linguistic";
															}

	      // Group and self test
															if($selfs == 1)
															{
																$gs_test= "Self Study";
															}
															else if($groups == 1)
															{
																$gs_test="Group Study";
															}
												// Visual Link
															if( $vis == 1)
																	{
																		$visuallink='<a style="color: rgb(255, 255, 255);text-decoration: none;"  class="no-underline color-white" target="_blank" href="http://bit.ly/2c0JKgl"><img src="http://brolance.com/phase2/images/check.png" width="17" height="17"> Learn More</a>';
																	}
																	else 
																	{
																		$visuallink='----';
																	}
											   	// Auditory
														if( $aud == 1)
																	{
																		$auditorylink='<a style="color: rgb(255, 255, 255);text-decoration: none;"  class="no-underline color-white" target="_blank" href="http://bit.ly/2bSzLZZ">
																				<img src="http://brolance.com/phase2/images/check.png" width="17" height="17"> Learn More
																			</a>';
																	}
																	else {
																		$auditorylink='----';
																	}
												// Physical
																	if( $phys == 1)
																	{
																		$physicallink='<a style="color: rgb(255, 255, 255);text-decoration: none;"  class="no-underline color-white" target="_blank" href="http://bit.ly/2bS84C7"><img src="http://brolance.com/phase2/images/check.png" width="17" height="17"> Learn More
																			</a>';
																	}
																	else {
																		$physicallink='----';
																	}
											// Verbal
																	if( $verb == 1)
																	{
																	     $verballink='<a style="color: rgb(255, 255, 255);text-decoration: none;"   class="no-underline color-white" target="_blank" href="http://bit.ly/2crgwcc">	<img src="http://brolance.com/phase2/images/check.png" width="17" height="17"> Learn More
																			</a>';
																	}
																	else {
																		$verballink='----';
																	}
											//Math
													if($math_logic ==1)
																	{
																		$mathlogics='<a style="color: rgb(255, 255, 255);text-decoration: none;" class="no-underline color-white" target="_blank" href="http://bit.ly/2bCJJOt"><img src="http://brolance.com/phase2/images/check.png" width="17" height="17"> Learn More</a>';
																	}else {
																		$mathlogics='----';
																	}
											// Science Logic
													if($sci ==1)
																	{
																	$sciencelogic='<a style="color: rgb(255, 255, 255);text-decoration: none;" class="no-underline color-white" target="_blank" href="http://bit.ly/2bHcAyj"><img src="http://brolance.com/phase2/images/check.png" width="17" height="17"> Learn More</a>';
																	
																	}
																	else
																	{
																		$sciencelogic='----';
																	}
											// selfgrouplogic
																	if($selfs == 1 && $groups == 0)
																	{
																		$selflogic='<a style="color: rgb(51, 122, 183);text-decoration: none;" class="no-underline" target="_blank" href="http://bit.ly/2bCi6SF"><img src="http://brolance.com/phase2/images/check.png" width="17" height="17"> Learn More</a>';
																	}
																	else{
																		$selflogic='----';
																	}
										   // GroupLogic
																	if($selfs == 0 && $groups == 1)
																	{
																	   $grouplogic='<a style="color: rgb(51, 122, 183);text-decoration: none;" class="no-underline" target="_blank" href="http://bit.ly/2bS7HaV"><img src="http://brolance.com/phase2/images/check.png" width="17" height="17"> Learn More</a>';

																	}
																	else{
																		$grouplogic='----';
																	}
										// Auditory Sensisitve
																if($gr->Result2C1!="" && $gr->Result2C2!="" && $gr->Result2C3!="")
																	{
																		if($gr->Result2C1 == "ML" && $gr->Result2C2 == "ML" && $gr->Result2C3 == "ML")
																		{
																			$audi_send_logic="----";
																		}
																		else if(($gr->Result2C1=="nML"||$gr->Result2C1==$to)&&($gr->Result2C2=="nML"||$gr->Result2C2==$to)&&($gr->Result2C3=="nML"||$gr->Result2C3==$to))
																		{
																			$audi_send_logic='<a style="color: rgb(51, 122, 183);text-decoration: none;"  class="no-underline" target="_blank" href="http://www.gentreediscover.com/wp-content/uploads/Auditory-Sensitivity.pdf"><img src="http://brolance.com/phase2/images/check.png" width="17" height="17"> Learn More</a>';
																		}
																		else{
																			$audi_send_logic="----";
																		}
																	}
										// Attension Sensitive

																	if($gr->midpoint=="1" )
																	{
																		$attension_logic='----';
																	}
																	else if ($gr->midpoint=="2")
																	{
																		
																		$attension_logic='<a style="color: rgb(51, 122, 183);text-decoration: none;"  class="no-underline" target="_blank" href="http://www.gentreediscover.com/wp-content/uploads/Attention-Sensitivity.pdf"><img src="http://brolance.com/phase2/images/check.png" width="17" height="17"> Learn More</a>';
																		
																	}

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	

	//Page header
	public function Header() {
		// Logo
		//$image_file = K_PATH_MAIN.'gentree-discover.jpg';
		
			$img = file_get_contents('http://brolance.com/phase2/images/gentree-discover.jpg');
	    
        $this->Image('@' . $img,  10, 5, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		//$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'I', 10);
		// Title
		
		$this->Cell(190, 0, "A revolutionary approach to maximizing your child's learning potential", R, false, 'C', 0, '', 0, false, 'M', 'M');


	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number

		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('gentree-discover');
$pdf->SetTitle($get_child_detail[0]->child_firstname.' '.$get_child_detail[0]->child_lastname.' Report');
$pdf->SetSubject($get_child_detail[0]->child_firstname.' '.$get_child_detail[0]->child_lastname.' Report');
$pdf->SetKeywords('Report,gentree');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();


// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html = '<table  cellspacing="3" cellpadding="4">
	<tr>
		
		
		<th style="text-align:center;width:30%"><img src="'.$inputimage.'" alt="test alt attribute" width="150" height="150" border="1" /></th>
		<th style="text-align:left;width:70%">
			<table cellspacing="1" cellpadding="4" >
			<tr>
			<th>
			<span style="font-size:13">'.ucfirst($gc->child_firstname).' '. ucfirst($gc->child_lastname).'</span>
			</th>
			</tr>

			<tr>
			<th style="background-color: rgb(238, 238, 238);">
			<span style="font-size:11"><b>Age at Assessment Date :</b> '.$assessement_date.'</span>
			
			</th>
			</tr>

			<tr>
			<th>
			<span style="font-size:11"><b>Date of Assessment :</b> '.date('m-d-Y', strtotime($gr->Period)).'</span>
			
			</th>
			</tr>

			<tr>
			<th style="background-color: rgb(238, 238, 238);">
			<span style="font-size:11"><b>Date of Previous Assessment :</b> '.$p_assessment_date.'</span>
			</th>
			<th>


			</th>
			</tr>
			</table>
	   </th>
	</tr>
</table>
<h2>Assessment Results Quick View:</h2>	
<table  cellspacing="3" cellpadding="8">
	<tr style="background-color: rgb(138, 199, 54);color: rgb(255, 255, 255);" >
		<th>
				Learning Style(s): '.$lstyle.'
		</th>
	</tr>	

	<tr style="background-color: rgb(4, 116, 190);color: rgb(255, 255, 255);">
		<th>
			Learning Preference(s): '.$lpref.'
		</th>
	</tr>
	<tr style="background-color: rgb(22, 49, 94);color: rgb(255, 255, 255);">
		<th>
				Social Preference: '.$gs_test.'
		</th>
	</tr>

</table>
<br></br><br></br><br></br>
<table >
	<tr>
	 <th>
		<table  cellspacing="3" cellpadding="8">
			<tr>
				<th style="background-color: rgb(138, 199, 54);color: rgb(255, 255, 255);padding:20">
					<span style="font-size: small;">Learning Style(s):</span>
				</th>
			</tr>
			<tr>	
				<th>
					<table  cellpadding="2">
			          <tr >
			          	<th style="background-color: rgb(238, 238, 238);color: rgb(0, 0, 0);" >
			          	   <span style="font-size: small;">Visual</span>
			          	</th>
			          	<th style="background-color: rgb(138, 199, 54);color: rgb(255, 255, 255);">
			          	  <span style="font-size: small;"> '.$visuallink.'</span>
			          	</th>
			          </tr>
			        </table> 
				</th>
			</tr>
			<tr>	
				<th>
					<table  cellpadding="2">
			          <tr >
			          	<th style="background-color: rgb(238, 238, 238);color: rgb(0, 0, 0);" >
			          	   <span style="font-size: small;">Auditory</span>
			          	</th>
			          	<th style="background-color: rgb(138, 199, 54);color: rgb(255, 255, 255);">
			          	  <span style="font-size: small;"> '.$auditorylink.'</span>
			          	</th>
			          </tr>
			        </table> 
				</th>
			</tr>
			<tr>	
				<th>
					<table  cellpadding="2">
			          <tr >
			          	<th style="background-color: rgb(238, 238, 238);color: rgb(0, 0, 0);" >
			          	   <span style="font-size: small;">Physical</span>
			          	</th>
			          	<th style="background-color: rgb(138, 199, 54);color: rgb(255, 255, 255);">
			          	  <span style="font-size: small;"> '.$physicallink.'</span>
			          	</th>
			          </tr>
			        </table> 
				</th>
			</tr>
		</table>
	</th>


	<th>
		<table  cellspacing="3" cellpadding="8">
			<tr>
				<th style="background-color: rgb(4, 116, 190);color: rgb(255, 255, 255);">
					<span style="font-size: small;">Learning Preference(s):</span>
				</th>
			</tr>
			<tr>	
				<th>
					<table  cellpadding="2">
			          <tr >
			          	<th style="background-color: rgb(238, 238, 238);color: rgb(0, 0, 0);" >
			          	   <span style="font-size: small;">Verbal</span>
			          	</th>
			          	<th style="background-color: rgb(4, 116, 190);color: rgb(255, 255, 255);">
			          	  <span style="font-size: small;"> '.$verballink.'</span>
			          	</th>
			          </tr>
			        </table> 
				</th>
			</tr>
			<tr>	
				<th>
					<table  cellpadding="2">
			          <tr >
			          	<th style="background-color: rgb(238, 238, 238);color: rgb(0, 0, 0);" >
			          	   <span style="font-size: small;">Math</span>
			          	</th>
			          	<th style="background-color: rgb(4, 116, 190);color: rgb(255, 255, 255);">
			          	  <span style="font-size: small;"> '.$mathlogics.'</span>
			          	</th>
			          </tr>
			        </table> 
				</th>
			</tr>
			<tr>	
				<th>
					<table  cellpadding="2">
			          <tr >
			          	<th style="background-color: rgb(238, 238, 238);color: rgb(0, 0, 0);" >
			          	   <span style="font-size: small;">Science</span>
			          	</th>
			          	<th style="background-color: rgb(4, 116, 190);color: rgb(255, 255, 255);">
			          	  <span style="font-size: small;"> '.$sciencelogic.'</span>
			          	</th>
			          </tr>
			        </table> 
				</th>
			</tr>
		</table>
	</th>		
	</tr>


	<tr>
	 <th>
		<table  cellspacing="3" cellpadding="8">
			<tr>
				<th style="background-color: rgb(22, 49, 94);color: rgb(255, 255, 255);">
					<span style="font-size: small;">Social Preference:</span>
				</th>
			</tr>

			<tr>	
				<th>
					<table  cellpadding="2">
			          <tr style="background-color: rgb(238, 238, 238);color: rgb(0, 0, 0);" >
			          	<th  >
			          	   <span style="font-size: small;">Self Study</span>
			          	</th>
			          	<th>
			          	  <span style="font-size: small;"> '.$selflogic.'</span>
			          	</th>
			          </tr>
			        </table> 
				</th>
			</tr>
			<tr>	
				<th>
					<table  cellpadding="2">
			          <tr style="background-color: rgb(238, 238, 238);color: rgb(0, 0, 0);" >
			          	<th  >
			          	   <span style="font-size: small;">Group Study</span>
			          	</th>
			          	<th>
			          	  <span style="font-size: small;"> '.$grouplogic.'</span>
			          	</th>
			          </tr>
			        </table> 
				</th>
			</tr>
		</table>
	</th>		

		
	<th>
		<table  cellspacing="3" cellpadding="8">
			<tr>
				<th style="background-color: rgb(60, 58, 60);color: rgb(255, 255, 255);">
					<span style="font-size: small;">Additional Indicator(s):</span>
				</th>
			</tr>

			<tr>	
				<th>
					<table  cellpadding="2">
			          <tr style="background-color: rgb(238, 238, 238);color: rgb(0, 0, 0);" >
			          	<th  >
			          	   <span style="font-size: small;">Auditory Sensitive&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   '.$audi_send_logic.'</span>
			          	</th>
			          	
			          </tr>
			        </table> 
				</th>
			</tr>
			<tr>	
				<th>
					<table  cellpadding="2">
			          <tr style="background-color: rgb(238, 238, 238);color: rgb(0, 0, 0);" >
			          	<th  >
			          	   <span style="font-size: small;">Attention Sensitive&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    '.$attension_logic.'</span>
			          	</th>
			          	
			          </tr>
			        </table> 
				</th>
			</tr>
		</table>
	</th>		
	</tr>

</table>
';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->AddPage();
// output some RTL HTML content
$html = '<h2>Problem-Solving Skills: Executive Functioning</h2>
<p>
<font size="10">Parents and Teachers should create a healthy, safe environment for children to confidently practice the skills below throughout their early childhood years. Repetition and consistency is key for children to apply these skills as they develop problem-solving techniques for home, school, and peers. These skills also apply to developing solid executive functioning skills (as compared to an air traffic control center helping an airplane to land).</font>
<font size="10"><br>
Working memory is defined as holding, processing, and manipulation of information. It is an important process for reasoning, guidance of decision making, and behavior.</font>
<font size="10">	<ul>
				<li>

Daily, encourage your child to re-tell what they have learned, prompting them with questions to extend their memory recall of the event(s).
</li>
<li>
Together, list out steps for completing a chore or project.
</li>
<li>
Play matching games such as Go Fish or games such as Concentration.
</li>
<li>
Read stories and nursery rhymes or sing songs that allow for echoing or other auditory responses.
</li>
</ul>
</font>
<font size="10">
Cognitive flexibility is the mental ability to switch between thinking about two different concepts, and to think about multiple concepts simultaneously.
</font>
<font size="10">
<ul>
				<li>
Encourage your child to use imaginative play and practice having conversations with adults such as servers, teachers, doctors, etc.
</li>
<li>
Play games with your child that require self-regulation and quick decision making such as Red Light-Green Light, Musical Chairs,or Simon Says.
</li>
<li>
Put together age-appropriate jigsaw puzzles or search for hidden objects in picture books created for that purpose to enhance visual discrimination.
</li>
<li>
Sort and classify objects and pictures of objects using different and/or new guidelines. Have your child explain their thinking as they are practicing this skill.
</li>
</ul>
<b>Reference Link</b>
<p>Wikipedia: 2016</font><br></br><br></br>
<font size="10">
Center on the Developing Child at Harvard University (2014).<i>Enhancing and Practicing Executive Function Skills with Children from Infancy to Adolescence.</i></p>
</font></p>
';
$pdf->writeHTML($html, true, false, true, false, '');



// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output($get_child_detail[0]->child_firstname.' '.$get_child_detail[0]->child_lastname, 'I');

//============================================================+
// END OF FILE
//============================================================+
