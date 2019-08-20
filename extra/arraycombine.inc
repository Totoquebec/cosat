<?php
// Emulation de la fonction array_emulation include dans php 5

function array_combine_emulated( $keys, $vals ) {
 $keys = array_values( (array) $keys );
 $vals = array_values( (array) $vals );
 $n = max( count( $keys ), count( $vals ) );
 $r = array();
 for( $i=0; $i<$n; $i++ ) {
  $r[ $keys[ $i ] ] = $vals[ $i ];
 }
 return $r;
}
?> 
