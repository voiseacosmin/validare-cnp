<?php

$cnp = $_GET['cnp'];

validare($cnp);

function validare($cnp)
{
    echo "Result: </br>";

    if(sex($cnp)==false)
        echo "Indicator sex din CNP este invalid!</br>";
    if(nastere($cnp)==false)
        echo "Indicator data nastere din CNP este invalida!</br>";
    if(judet($cnp)==false)
        echo "Indicator judet din CNP este invalid!</br>";
    if(nr($cnp)==false)
        echo "Indicator nr NNN din CNP este invalid!</br>";
    if(crc($cnp)==false)
        echo "Indicator de control din CNP este invalid!</br>";
    else
        echo "CNP valid!</br>";
}

function sex($cnp)
{
    $result = false;

    //if lenght is valid
    if (strlen($cnp) == 13)
    {
        $sex = $cnp[0];
        if($sex>0 && $sex < 10)
            $result = true;
    }
    return $result;
}

function nastere($cnp)
{
    $result = false;

    //if lenght is valid
    if (strlen($cnp) == 13)
    {
        $bd = substr($cnp, 1, 6);
        
        $yc = date('Y');
        
        //rezident
        $bry  = 20;
        $y_br = $bry.$bd[0].$bd[1];
        
        if ($sex == 1 || $sex == 2) {
            $sy = 19; 
        }
        elseif ($sex == 3 || $sex == 4) { 
            $sy = 18;
        }
        elseif ($sex == 5 || $sex == 6) { 
            $sy = 20; 
        }
        elseif ($sex == 7 || $sex == 8) { 
            if($y_br < $yc){ 
                $sy = 20;
            }else{
                $sy = 19;
            } 
        }

        $year = $sy.$bd[0].$bd[1];
        $month = $bd[2].$bd[3];
        $day = $bd[4].$bd[5];

        $birthday = $year."-".$month."-".$day;

        if(checkdate($month, $day, $year))
            $result = true;
    }
    return $result;
}

function judet($cnp)
{
    $result = false;

    $judet = $cnp[7].$cnp[8];

    if($judet > 1 && $judet < 53)
        $result = true;

    return $result;
}

function nr($cnp)
{
    $result = false;

    $nr = $cnp[9].$cnp[10].$cnp[11];

    if($nr > 1 && $nr < 1000)
        $result = true;

    return $result;
}

function crc($cnp)
{
    $result = false;

    $crc = "279146358279";

    $sum = $cnp[0]*$crc[0]+$cnp[1]*$crc[1]+$cnp[2]*$crc[2]+$cnp[3]*$crc[3]+$cnp[4]*$crc[4]+$cnp[5]*$crc[5]+$cnp[6]*$crc[6]+$cnp[7]*$crc[7]+$cnp[8]*$crc[8]+$cnp[9]*$crc[9]+$cnp[10]*$crc[10]+$cnp[11]*$crc[11];

    $rest = $sum % 11;
    $r = substr($rest,0,1);

    if($cnp[12] == $r)
        $result = true;

    return $result;
}

?>