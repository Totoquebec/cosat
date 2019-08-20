<?php
/*
 *
 *
 * Avertissement : Cette librairie de fonctions PHP est distribuee avec l'espoir 
 * qu'elle sera utile, mais elle l'est SANS AUCUNE GARANTIE; sans meme la garantie de 
 * COMMERCIALISATION ou d'UTILITE POUR UN BUT QUELCONQUE.
 * Elle est librement redistribuable tant que la presente licence, ainsi que les credits des 
 * auteurs respectifs de chaque fonctions sont laisses ensembles. 
 * En aucun cas, Nexen.net ne pourra etre tenu responsable de quelques consequences que ce soit
 * de l'utilisation ou la mesutilisation de ces fonctions PHP.

*/

/****
 * Titre : Nombre en espagnol 
 * Auteur : Hector Lecuanda 
 * Email : hector.lecuanda@driessenusa.com
 * Url : 
 * Description : Ecrit un nombre en espagnol.
 * Modifier par : Denis Léveillé      01/06/2004
****/

function ChiffEnLet($number){


$milliers  = (int)($number / 1000); 
$number = fmod($number, 1000); 

$hundreds  = (int)($number / 100); 
$number = fmod($number, 100); 

$tens      =  (int)($number / 10);
$number = fmod($number, 10); 

$units     = (int)($number / 1); 
$number = fmod($number, 1);  

/* uncomment for debugging 

print('Milliers  : '.$milliers. '<br>'); 
print('Centaines : '.$hundreds. '<br>'); 
print('Dizaines  : '.$tens.     '<br>'); 
print('unités    : '.$units.    '<br><hr>'); 
*/

// cascade les milliers. Ceci convertira la partie des milliers dans la  
// chaine correspondante en espagnol 
switch ($milliers) { 
    case 1: $string_milliers = "mil ";        break; // Special case 
    case 2: $string_milliers = "dos mil ";    break; 
    case 3: $string_milliers = "tres mil ";   break; 
    case 4: $string_milliers = "cuatro mil "; break; 
    case 5: $string_milliers = "cinco mil ";    break; // Special case 
    case 6: $string_milliers = "seis mil ";   break; 
    case 7: $string_milliers = "siete mil ";   break; // Special case 
    case 8: $string_milliers = "ocho mil ";   break; 
    case 9: $string_milliers = "nueve mil ";   break; // Special case 
    default: $string_milliers = "";   break; // Special case 
} // end switch milliers
 
// cascade trough hundreds. This will convert the hundreds part to 
// their corresponding string in spanish. 
switch ($hundreds) { 
    case 1: $string_hundreds = "ciento ";        break; // Special case 
    case 2: $string_hundreds = "doscientos ";    break; 
    case 3: $string_hundreds = "trescientos ";   break; 
    case 4: $string_hundreds = "cuatrocientos "; break; 
    case 5: $string_hundreds = "quinientos ";    break; // Special case 
    case 6: $string_hundreds = "seiscientos ";   break; 
    case 7: $string_hundreds = "setecientos ";   break; // Special case 
    case 8: $string_hundreds = "ochocientos ";   break; 
    case 9: $string_hundreds = "novecientos ";   break; // Special case 
    default: $string_hundreds = "";   break; // Special case 
} // end switch hundreds 

// casgade trough tens. This will convert the tens part to corresponding 
// strings in spanish. Note, however that the strings between 11 and 19 
// are all special cases. Also 21-29 is a special case in spanish. 
switch ($tens) { 
    case 1: // Special case, depends on units for each conversion 
            switch($units){ 
                case 1: $string_tens = "once";        break; // Special case 
                case 2: $string_tens = "doce";        break; // Special case 
                case 3: $string_tens = "trece";       break; // Special case 
                case 4: $string_tens = "catorce";     break; // Special case 
                case 5: $string_tens = "quince";      break; // Special case 
                case 6: $string_tens = "dieciseis";   break; // Special case 
                case 7: $string_tens = "diecisiete";  break; // Special case 
                case 8: $string_tens = "dieciocho";   break; // Special case 
                case 9: $string_tens = "diecinueve";  break; // Special case 
            } break; // end switch special case tens/units 

    case 2: $string_tens = "veinti";        break; // Special case 
    case 3: $string_tens = "treinta";       break; 
    case 4: $string_tens = "cuarenta";      break; 
    case 5: $string_tens = "cincuenta";     break;  
    case 6: $string_tens = "sesenta";       break; 
    case 7: $string_tens = "setenta";       break;  
    case 8: $string_tens = "ochenta";       break; 
    case 9: $string_tens = "noventa";       break;
	default:  $string_tens = "";			break;
} // end switch tens 


// cascades trough units, This will convert the units part to corresponding 
// strings in spanish. Note however that a check is being made to see wether 
// the special cases 11-19 were used. In that case, the whole conversion of 
// individual units is ignored since it was already made in the tens cascade. 

if( ($tens == 1) || ($units == 0) ){ 
        $string_units="";  // empties the units check, since it has alredy been handled on the tens switch 
} else { 
   switch ($units) { 
       case 1: $string_units = "un";       break;  
       case 2: $string_units = "dos";      break; 
       case 3: $string_units = "tres";     break; 
       case 4: $string_units = "cuatro";   break; 
       case 5: $string_units = "cinco";    break;  
       case 6: $string_units = "seis";     break; 
       case 7: $string_units = "siete";    break;  
       case 8: $string_units = "ocho";     break; 
       case 9: $string_units = "nueve";    break;  
   } // end switch units 
} // end if-then-else 


//final special cases. This conditions will handle the special cases which 
//are not as general as the ones in the cascades. Basically four: 

// when you've got 100, you dont' say 'ciento' you say 'cien' 
// 'ciento' is used only for [101 >= number > 199] 
if ($hundreds == 1 and $tens == 0 and $units == 0) { 
        $string_hundreds = "cien" ; 
}  

// when you've got 10, you don't say any of the 11-19 special 
// cases.. just say 'diez' 
if ($tens == 1 and $units ==0) { 
        $string_tens = "diez" ; 
} 

// when you've got 20, you don't say 'veinti', which is used 
// only for [21 >= number > 29] 
if ($tens == 2 and $units ==0) { 
        $string_tens = "veinte" ; 
} 

// for numbers >= 30, you don't use a single word such as veintiuno 
// (twenty one), you must add 'y' (and), and use two words. v.gr 31 
// 'treinta y uno' (thirty and one) 
if ($tens >=3 and $units >=1) { 
        $string_tens = $string_tens." y "; 
} 

// this line gathers all the hundreds, tens and units into the final string 
// and returns it as the function value. 
$final_string = $string_milliers.$string_hundreds.$string_tens.$string_units; 
return $final_string ; 
 
} // ChiffEnLet


?>