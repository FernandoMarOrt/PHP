<?php

function dni_bien_escrito($texto){

    return strlen($texto)==9 && is_numeric(substr($texto,0,8)) && substr($texto,-1)>="A" && substr($texto,-1)<="Z";

}


?>