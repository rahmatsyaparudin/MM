<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Numbertoword {
    public function number_to_word($num = '')
    {
        $num = (string)((int)$num);
        if((int)($num) && ctype_digit($num))
        {
            $words = array();           
            $num = str_replace( array( ',' , ' ' ) , '' , trim( $num ) );
            $list1 = array('','One','Two','Three','Four','Five','Six','Seven',
                'Eight','Nine','Ten','Eleven','Twelve','Thirteen','Fourteen',
                'Fifteen','Sixteen','Seventeen','Eighteen','Nineteen');
            $list2  = array('','Ten','Twenty','Thirty','Forty','Fifty','Sixty',
                'Seventy','Eighty','Ninety','Hundred');
            $list3  = array('','Thousand','Million','Billion','Trillion',
                'Quadrillion','Quintillion','Sextillion','Septillion',
                'Octillion','Nonillion','Decillion','Undecillion',
                'Duodecillion','Tredecillion','Quattuordecillion',
                'Quindecillion','Sexdecillion','Septendecillion',
                'Octodecillion','Novemdecillion','Vigintillion');
           
            $num_length = strlen($num);
            $levels = (int)(($num_length+2)/3);
            $max_length = $levels * 3;
            $num = substr('00'.$num , -$max_length);
            $num_levels = str_split($num, 3);
           
            foreach($num_levels as $num_part)
            {
                $levels--;
                $hundreds = (int)($num_part/100);
                $hundreds = ($hundreds ? ' ' . $list1[$hundreds].' Hundred'.($hundreds == 1 ? '' : 's' ).' ':'');
                $tens = (int) ($num_part % 100);
                $singles = '';
               
                if($tens < 20)
                {
                    $tens = ($tens ? ' '. $list1[$tens].' ' : '');
                }
                else
                {
                    $tens   = (int)($tens / 10);
                    $tens   = ' '.$list2[$tens].' ';
                    $singles    = (int)($num_part % 10);
                    $singles    = ' '.$list1[$singles].' ';
                }
                $words[] = $hundreds.$tens.$singles.(($levels && (int) ($num_part)) ? ' '.$list3[$levels].' ':'');
            }
           
            $commas = count($words);
           
            if($commas > 1)
            {
                $commas = $commas - 1;
            }
           
            $words  = implode(', ',$words);
           
            //Some Finishing Touch
            //Replacing multiples of spaces with one space
            //$words  = trim( str_replace( ' ,' , ',' , trim_all( ucwords( $words ) ) ) , ', ' );
            if($commas)
            {
                $words = str_replace(',', ' and', $words);
            }
           
            return $words;
        }
        else if(!((int)$num))
        {
            return 'Zero';
        }
        return '';
    }

    function numToOrdinalWord($num)
    {
        $first_word = array('eth','First','Second','Third','Fourth','Fifth','Sixth','Seventh','Eighth','Ninth','Tenth','Elevents','Twelfth','Thirteenth','Fourteenth','Fifteenth','Sixteenth','Seventeenth','Eighteenth','Nineteenth','Twentieth');
        $second_word =array('','','Twenty','Thirty','Forty','Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety');

        if($num <= 20)
            return $first_word[$num];

        $first_num = substr($num,-1,1);
        $second_num = substr($num,-2,1);

        return $string = str_replace('y-eth','ieth',$second_word[$second_num].'-'.$first_word[$first_num]);
    }

    function getOrdinal($number)
    {
        // get first digit
        $digit = abs($number) % 10;
        $ext = 'th';
        $ext = ((abs($number) %100 < 21 && abs($number) %100 > 4) ? 'th' : (($digit < 4) ? ($digit < 3) ? ($digit < 2) ? ($digit < 1) ? 'th' : 'st' : 'nd' : 'rd' : 'th'));
        return $number.$ext;
    }
}
?>