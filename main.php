<?php
    //1
    function line($a,$b) {
        if(is_numeric($a) && is_numeric($b)) {
            return[$b / $a];
        }
        return[];
    }
    //kvadratnoe yr-e:  a*x^2 + b*x + d = 0;
    function square($a, $b, $c) {
        if(is_numeric($a) && is_numeric($b) && is_numeric($c)){
            if($c == 0) {
                return [line($a, $b)];
            }
            $discr = $b*$b - 4 * $a * $c;
            if($discr >= 0) {
                $x1 = (-$b + sqrt($discr)) / (2 * $a);
                $x2 = (-$b - sqrt($discr)) / (2 * $a);
                return[$x1, $x2];
            }
        }
        return[];
    }

    function gmp_sign($what) {
        return $what >= 0 ? true : false;
    }

    //kybi4eskoe yr-e:  a*x^3 + b*x^2 + c*x + d = 0;
    function cube($a, $b, $c, $d) {
        if(is_numeric($a) && is_numeric($b) && is_numeric($c) && is_numeric($d)) {
            if($d == 0) {
                return[square($a, $b, $c)];
            }
            if($d == 0 && $c == 0) {
                return[line($a, $b)];
            }
            $Q = ($a * $a - 3 * $b) / 9;
            $R = (2 * pow($a, 3) - 9 * $a * $b + 27 * $c) / 54;   
            $S = pow($Q, 3) - pow($R, 2);        
            if($S > 0) {
                $t = 1/3 * acos($R / (pow($Q, 3/2))); 
                $x1 = -2 * sqrt($Q) * cos($t) - ($a / 3);
                $x2 = -2 * sqrt($Q) * cos($t + (2 * pi() / 3)) - ($a / 3);
                $x3 = -2 * sqrt($Q) * cos($t - (2 * pi() / 3)) - ($a / 3);
                return[$x1, $x2, $x3];
            }
            if($S < 0) {
                if($Q > 0) {
                    $t = 1/3 * acosh(abs($R) / pow($Q, 3/2));
                    $x1 = -2 * gmp_sign($R) * sqrt($Q) * cosh($t) - $a / 3;
                    $x2 = gmp_sign($R) * sqrt($Q) * cosh($t) - $a / 3 + sqrt(3) * sqrt($Q) * sinh($t);
                    $x3 = gmp_sign($R) * sqrt($Q) * cosh($t) - $a / 3 - sqrt(3) * sqrt($Q) * sinh($t);
                    return[$x1, $x2, $x3];
                }
                if($Q < 0) {
                    $t = 1/3 * acosh(abs($R) / pow(abs($Q), 3/2));
                    $x1 = -2 * gmp_sign($R) * sqrt(abs($Q)) * sinh($t) - $a / 3;
                    $x2 = gmp_sign($R) * sqrt(abs($Q)) * sinh($t) - $a / 3 + sqrt(3) * sqrt($Q) * sinh($t);
                    $x3 = gmp_sign($R) * sqrt(abs($Q)) * sinh($t) - $a / 3 - sqrt(3) * sqrt($Q) * sinh($t);
                    return[$x1, $x2, $x3];
                }
                if($Q == 0) {
                    $x1 = -pow(($c - pow($a, 3) / 27), 1/3) - $a / 3;
                    $x2 = - (($a + $x1) / 2) + 1 / 2 * pow(abs(($a - 3 * $x1) * ($a + $x1) - 4 * $b), 1/2);
                    $x3 = - (($a + $x1) / 2) - 1 / 2 * pow(abs(($a - 3 * $x1) * ($a + $x1) - 4 * $b), 1/2);
                    return[$x1, $x2, $x3];
                }
                
            }
            if($S = 0) {
                $x1 = -2 * gmp_sign($R) * sqrt($Q) - $a / 3;
                $x2 = gmp_sign($R) * sqrt($Q) - $a / 3;
                return[$x1, $x2];
            }
        }
        return[];
    }

?>