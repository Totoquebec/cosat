<?php
require('mem_image.php');
//include('lib/config.php');

class PDF_HTML extends MEM_IMAGE
{
    var $B=0;
    var $I=0;
    var $U=0;
    var $HREF='';
    var $ALIGN='';
    
	function Footer()
	{
		if( $this->PageNo() > 1 ) {
		    //Positionnement à 1,5 cm du bas
		    $this->SetY(-15);
		    //Police Arial italique 8
		    $this->SetFont('Arial','I',8);
		    //Numéro et nombre de pages
		    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}
	function Header()
	{
	    //Police Arial gras 15
	   /* $this->SetFont('Arial','B',5);
	
	    $this->Cell(0,0,'CATALOGUE COSAT');
	    //Saut de ligne
	    $this->Ln(10);*/
	//        $this->Image("images/fond_pdf.jpg",0,0,200,300, 'JPEG');
		if( $this->PageNo() > 1 ) 
	        $this->Image("images/fond_pdf.jpg",100,20,100,260, 'JPEG');
	}


    function WriteHTML($html)
    {
        //Parseur HTML
        $html=str_replace("\n",' ',$html);
        $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                //Texte
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                elseif($this->ALIGN == 'center')
                    $this->Cell(0,5,$e,0,1,'C');
                else
                    $this->Write(5,$e);
                    
                    
                    
            }
            else
            {
                //Balise
                if($e{0}=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    //Extraction des attributs
                    $a2=split(' ',$e);
                    $tag=strtoupper(array_shift($a2));
                    $prop=array();
                    foreach($a2 as $v)
                        if(ereg('^([^=]*)=["\']?([^"\']*)["\']?$',$v,$a3))
                            $prop[strtoupper($a3[1])]=$a3[2];
                    $this->OpenTag($tag,$prop);
                }
            }
        }
    }

    function OpenTag($tag,$prop)
    {
        //Balise ouvrante
        if($tag=='B' or $tag=='I' or $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF=$prop['HREF'];
        if($tag=='BR')
            $this->Ln(5);
        if($tag=='P')
            $this->ALIGN=$prop['ALIGN'];
        if($tag=='HR')
        {
            if( !empty($prop['WIDTH']) )
                $Width = $prop['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $this->Ln(2);
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.4);
            $this->Line($x,$y,$x+$Width,$y);
            $this->SetLineWidth(0.2);
            $this->Ln(2);
        }
    }

    function CloseTag($tag)
    {
        //Balise fermante
        if($tag=='B' or $tag=='I' or $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF='';
        if($tag=='P')
            $this->ALIGN='';
            
    }

    function SetStyle($tag,$enable)
    {
        //Modifie le style et sélectionne la police correspondante
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B','I','U') as $s)
            if($this->$s>0)
                $style.=$s;
        $this->SetFont('',$style);
    }

    function PutLink($URL,$txt)
    {
		global $handle, $mysql_base,$logo;
   //echo "$txt<br>"; 
		if ($txt == "")
    		$this->Image("images/nondisp.jpg",50,50,100); 
		else {
			$sql = " SELECT * FROM $mysql_base.photo WHERE NoInvent=".$txt." AND NoPhoto='1'";
			$result = mysql_query( $sql, $handle );
	
			mysql_num_rows($result);
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
	
			$logo= $row['Photo'];
	//Affichage (nécessite PHP>=4.3.2 et FPDF>=1.52)
			$this->Image('var://logo', 120, 28, 0, 0, 'JPEG');
	    	}
    }
}
?>