<?php

class BarcodeCreator{


    private static $barObj = '';
    private $numOfCopy = 0;
    private $barSize =14;
    private $barString;



    public static function init()
    {
        if(!self::$barObj){
            self::$barObj = new self;
        }
        return self::$barObj;

    }


    private function __construct()
    {

    }

    public function setNum($num)
    {
        $this->numOfCopy = $num;
        return $this;
    }

    public function setBarSize($size){
        $this->barSize = $size;
        return $this;
    }

    public function setStr($str)
    {
        $this->barString = $str;
        return $this;
    }



    private function font_style_out_put(){
        return <<<DOC
<style>
    .center{text-align:center;}
    @font-face {
        font-family: 'IDAutomationC128S';
        src: url('toxls/IDAutomationC128S.eot'); /* IE9 Compat Modes */
        src: url('toxls/IDAutomationC128S.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
        url('toxls/IDAutomationC128S.woff') format('woff'), /* Modern Browsers */
        url('toxls/IDAutomationC128S.ttf')  format('truetype'), /* Safari, Android, iOS */
        url('toxls/IDAutomationC128S.svg#svgFontName') format('svg'); /* Legacy iOS */
    }
</style>
DOC;
    }

    private function barcode_creator(){
        return <<<DOC
<div class="center"><div style="font-family: IDAutomationC128S;font-size:{$this->barSize}px"> <{}> </div></div>
DOC;

    }

//    private function

    public function outPut(){
       return $this->font_style_out_put().str_replace('<{}>', call_user_func( 'htmlspecialchars' , array_shift($this->str2barcode($this->barString))) , $this->barcode_creator());
    }

    private function str2barcode($readablestring)
    {
        /*
        code128a不支持小写字母编码，code128auto中通常仅适用code128b与code128c进行混合编码。
        如果可读字符长度（设为l）大于等于4且全部为数字型字符，则code128auto以code128c作为起始编码，注意：code128c仅支持对偶数个数字型字符进行编码。
        如果l为偶数，则直接全部code128c编码至结束。
        如果l为奇数，则将前l-1个字符以code128c编码，第l个字符以code128b编码。
        如果长度小于4或字符串中包含非数字型字符，则code128auto以code128b作为起始编码。
        以code128b起始编码时，发现长度（设为l）不少于4的连续的数字型字符时，
        若l为偶数，则切换至code128c进行编码；
        若l为奇数，则首个数字型字符以code128b编码，之后切换为code128c进行编码；
        切换至code128c编码完成后，后续还有字符时（肯定是非数字型），切换回code128b继续编码，直至发现下一个长度不少于4的连续的数字型字符。
        */
//$code128amapping数组用于以可读字符为索引查找条码字体的code128a编码字符。
        $code128amapping = array(' ' => ' ', '!' => '!', '"' => '"', '#' => '#', '$' => '$', '%' => '%', '&' => '&', '\'' => '\'', '(' => '(', ')' => ')', '*' => '*', '+' => '+', ',' => ',', '-' => '-', '.' => '.', '/' => '/', '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', ':' => ':', ';' => ';', '<' => '<', '=' => '=', '>' => '>', '?' => '?', '@' => '@', 'a' => 'a', 'b' => 'b', 'c' => 'c', 'd' => 'd', 'e' => 'e', 'f' => 'f', 'g' => 'g', 'h' => 'h', 'i' => 'i', 'j' => 'j', 'k' => 'k', 'l' => 'l', 'm' => 'm', 'n' => 'n', 'o' => 'o', 'p' => 'p', 'q' => 'q', 'r' => 'r', 's' => 's', 't' => 't', 'u' => 'u', 'v' => 'v', 'w' => 'w', 'x' => 'x', 'y' => 'y', 'z' => 'z', '[' => '[', '\\' => '\\', ']' => ']', '^' => '^', '_' => '_');

//$code128bmapping数组用于以可读字符为索引查找条码字体的code128b编码字符。
        $code128bmapping = array(' ' => ' ', '!' => '!', '"' => '"', '#' => '#', '$' => '$', '%' => '%', '&' => '&', '\'' => '\'', '(' => '(', ')' => ')', '*' => '*', '+' => '+', ',' => ',', '-' => '-', '.' => '.', '/' => '/', '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', ':' => ':', ';' => ';', '<' => '<', '=' => '=', '>' => '>', '?' => '?', '@' => '@', 'a' => 'a', 'b' => 'b', 'c' => 'c', 'd' => 'd', 'e' => 'e', 'f' => 'f', 'g' => 'g', 'h' => 'h', 'i' => 'i', 'j' => 'j', 'k' => 'k', 'l' => 'l', 'm' => 'm', 'n' => 'n', 'o' => 'o', 'p' => 'p', 'q' => 'q', 'r' => 'r', 's' => 's', 't' => 't', 'u' => 'u', 'v' => 'v', 'w' => 'w', 'x' => 'x', 'y' => 'y', 'z' => 'z', '[' => '[', '\\' => '\\', ']' => ']', '^' => '^', '_' => '_', '`' => '`', 'a' => 'a', 'b' => 'b', 'c' => 'c', 'd' => 'd', 'e' => 'e', 'f' => 'f', 'g' => 'g', 'h' => 'h', 'i' => 'i', 'j' => 'j', 'k' => 'k', 'l' => 'l', 'm' => 'm', 'n' => 'n', 'o' => 'o', 'p' => 'p', 'q' => 'q', 'r' => 'r', 's' => 's', 't' => 't', 'u' => 'u', 'v' => 'v', 'w' => 'w', 'x' => 'x', 'y' => 'y', 'z' => 'z', '{' => '{', '|' => '|', '}' => '}', '~' => '~');

//$code128cmapping数组用于以可读字符为索引查找条码字体的code128c编码字符。
        $code128cmapping = array('00' => 'â', '01' => '!', '02' => '"', '03' => '#', '04' => '$', '05' => '%', '06' => '&', '07' => '\'', '08' => '(', '09' => ')', '10' => '*', '11' => '+', '12' => ',', '13' => '-', '14' => '.', '15' => '/', '16' => '0', '17' => '1', '18' => '2', '19' => '3', '20' => '4', '21' => '5', '22' => '6', '23' => '7', '24' => '8', '25' => '9', '26' => ':', '27' => ';', '28' => '<', '29' => '=', '30' => '>', '31' => '?', '32' => '@', '33' => 'a', '34' => 'b', '35' => 'c', '36' => 'd', '37' => 'e', '38' => 'f', '39' => 'g', '40' => 'h', '41' => 'i', '42' => 'j', '43' => 'k', '44' => 'l', '45' => 'm', '46' => 'n', '47' => 'o', '48' => 'p', '49' => 'q', '50' => 'r', '51' => 's', '52' => 't', '53' => 'u', '54' => 'v', '55' => 'w', '56' => 'x', '57' => 'y', '58' => 'z', '59' => '[', '60' => '\\', '61' => ']', '62' => '^', '63' => '_', '64' => '`', '65' => 'a', '66' => 'b', '67' => 'c', '68' => 'd', '69' => 'e', '70' => 'f', '71' => 'g', '72' => 'h', '73' => 'i', '74' => 'j', '75' => 'k', '76' => 'l', '77' => 'm', '78' => 'n', '79' => 'o', '80' => 'p', '81' => 'q', '82' => 'r', '83' => 's', '84' => 't', '85' => 'u', '86' => 'v', '87' => 'w', '88' => 'x', '89' => 'y', '90' => 'z', '91' => '{', '92' => '|', '93' => '}', '94' => '~', '95' => 'ã', '96' => 'ä', '97' => 'å', '98' => 'æ', '99' => 'ç');

//$idtobarfontcharmapping数组用于通过id查找对应的编码字符
        $idtobarfontcharmapping = array('â', '!', '"', '#', '$', '%', '&', '\'', '(', ')', '*', '+', ',', '-', '.', '/', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ':', ';', '<', '=', '>', '?', '@', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '[', '\\', ']', '^', '_', '`', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '{', '|', '}', '~', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í');

//$barfontchartoidmapping数组用于通过编码字符查找其所对应的id，array_flip函数功能是将数组索引与数值进行互换。
        $barfontchartoidmapping = array_flip($idtobarfontcharmapping);

//$controlcharmapping用于查找不同控制命令的编码字符。
        $controlcharmapping = array('code c' => 'ç', 'code b' => 'è', 'code a' => 'é', 'fnc1' => 'ê', 'start a' => 'ë', 'start b' => 'ì', 'start c' => 'í', 'stop' => 'î');

        $startb = false;//记录编码是否由code128b起始
        $startc = false;//记录编码是否由code128c起始

        $readablestringlenth = strlen($readablestring);//获得可读字符串长度

//判断应该以code128b起始，还是以code128c起始--start
        if ($readablestringlenth >= 4) {
            $i = 0;
            while (is_numeric($readablestring[$i]) && $i < $readablestringlenth) {
                $i++;
            }
//echo "i=".$i."<br>";
            if ($i == $readablestringlenth) {
//可读字符长度不小于4且全部都是数字型字符，以code128c起始。
                $startc = true;
            } else {
//可读字符长度不小于4但其中包含非数字型字符，以code128b起始
                $startb = true;
            }
        } else {
////可读字符长度小于4，字符，以code128b起始
            $startb = true;
        }
//判断应该以code128b起始，还是以code128c起始--end

        $barfontstring = "";//存储编码后的字符串，初始设为空字符串。
        $barfontcharidarray = array();//存储编码后字符对应的id，初始设为空数组。
        $barfontchararray = array();//存储编码后字符数组，仅用于说明算法过程实际使用中可注释。
        $readablestringsplited = array(); //该数组用来存储拆分后的可读字符，每个拆分出来的部分对应一个编码字符，仅用于说明算法过程实际使用可注释掉。

        if ($startc) {
            $barfontchar = $controlcharmapping['start c'];//找到code128c编码的起始符
            $barfontstring .= $barfontchararray[] = $barfontchar;//向$barfontstring中添加首个编码字符。
            $barfontcharidarray[] = $barfontchartoidmapping[$barfontchar];//向$barfontcharidarray中添加首个编码字符对应的id。
            $readablestringsplited[] = "code128c起始符";//向$readablestringsplited中添加当前编码字符对应的含义，仅用于辅助算法过程说明，实际使用可注释掉。
            for ($i = 0; $i < $readablestringlenth - 1; $i += 2) {//每两个字符做一次循环，得到一个code128c字符。
                $code128ckey = $readablestring[$i] . $readablestring[$i + 1];//将两位数字型字符连接得到code128c的编码索引。
                $barfontchar = $code128cmapping[$code128ckey];//通过code128c索引获得code128c的编码字符。
                $barfontstring .= $barfontchararray[] = $barfontchar;//将code128c编码字符加入$barfontchararray数组，并连接到$barfontstring右侧。
                $barfontcharidarray[] = $barfontchartoidmapping[$barfontchar];//将code128c的编码字符对应的id存入$barfontcharidarray数组。
                $readablestringsplited[] = $code128ckey;//将拆分的可读字符（即索引）存入$readablestringsplited，仅用于辅助算法过程说明，实际使用可注释掉。
            }
            if ($readablestringlenth % 2) {//纯数字型可读字符串长度为奇数，最后1位需要切换至code128b编码
                $barfontchar = $controlcharmapping['code b'];//切换至code128b编码，注意，编码切换符与起始符是有区别的。
                $barfontstring .= $barfontchararray[] = $barfontchar;
                $barfontcharidarray[] = $barfontchartoidmapping[$barfontchar];
                $readablestringsplited[] = "切换至code128b";
                $barfontchar = $code128bmapping[$readablestring[$readablestringlenth - 1]];
                $barfontstring .= $barfontchararray[] = $barfontchar;
                $barfontcharidarray[] = $barfontchartoidmapping[$barfontchar];
                $readablestringsplited[] = $readablestring[$readablestringlenth - 1];
            }
        }

        if ($startb) {
            $barfontchar = $controlcharmapping['start b'];
            $barfontstring .= $barfontchararray[] = $barfontchar;
            $barfontcharidarray[] = $barfontchartoidmapping[$barfontchar];
            $readablestringsplited[] = "code128b起始符";
//连续数字型字符长度(l)大于等于4时，使用code128c编码，l为奇数时，最左侧的以code128b编码。
            $i = 0;
            while ($i < $readablestringlenth) { //对可读字符开始扫描，用while的原因是循环步长受循环过程控制。
                $j = $i;
                while (is_numeric($readablestring[$j])) {//探测连续数字型字符串长度
                    $j++;
//echo $j."<br>";
                }
                $continuousnumericcharendpos = $j;
                $continuousnumericstringlen = $j - $i;//得到连续数字型字符串长度
                if ($continuousnumericstringlen >= 4) {//当前字符位置向右存在长度不小于4的连续数字型字符
                    if ($continuousnumericstringlen % 2) {//连续数字型字符长度为奇数，则首个数字型字符以code128b编码
                        $barfontchar = $code128bmapping[$readablestring[$i]];
                        $barfontstring .= $barfontchararray[] = $barfontchar;
                        $barfontcharidarray[] = $barfontchartoidmapping[$barfontchar];
                        $readablestringsplited[] = $readablestring[$i];
                        $i++;
                    }
//切换至code128c起始编码
                    $barfontchar = $controlcharmapping['code c'];
                    $barfontstring .= $barfontchararray[] = $barfontchar;
                    $barfontcharidarray[] = $barfontchartoidmapping[$barfontchar];
                    $readablestringsplited[] = "切换至code128c";
//echo "continuousnumericcharendpos=".$continuousnumericcharendpos;

//每2个字符一次循环，得到code128c编码字符，参见本文if($startc)部分。
                    for (; $i < $continuousnumericcharendpos; $i += 2) {
//echo $i."======".$readablestring[$i]."======".$readablestring[$i+1]."<br>";
                        $barfontchar = $code128cmapping[$readablestring[$i] . $readablestring[$i + 1]];
                        $barfontstring .= $barfontchararray[] = $barfontchar;
                        $barfontcharidarray[] = $barfontchartoidmapping[$barfontchar];
                        $readablestringsplited[] = $readablestring[$i] . $readablestring[$i + 1];
                    }
                    if ($i < $readablestringlenth) {//连续数字型字符串编码完毕后后面还有剩余字符，则需要切换回code128b继续编码。
                        $barfontchar = $controlcharmapping['code b'];
                        $barfontstring .= $barfontchararray[] = $barfontchar;
                        $barfontcharidarray[] = $barfontchartoidmapping[$barfontchar];
                        $readablestringsplited[] = "切换回code128b";
//此处仅需要切换回code128c，对后续字符进行编码的工作，在下一次while循环中进行。
                    }
                } else {//当前字符位置向右不存在长度不小于4的连续数字型字符，直接以code128b对当前字符编码。
                    $barfontchar = $code128bmapping[$readablestring[$i]];
                    $barfontstring .= $barfontchararray[] = $barfontchar;
                    $barfontcharidarray[] = $barfontchartoidmapping[$barfontchar];
                    $readablestringsplited[] = $readablestring[$i];
                    $i++;
                }
            }
        }

//计算校验位id
        /*校验位的算法：
        设：	cn=编码后字符串（不计起始符）的第n位字符对应的id值（并设共有n位，不包含起始符，不包含校验位，不包含结束符）
        cl=起始符对应的id值
        cid=校验位id值
        则：cid = ( cl + c1 * 1 + c2 * 2 + c3 * 3 + … + cn * n ) % 103
        */
        $checksum = $barfontcharidarray[0]; //设置起始值为编码后字符串中第1个字符对应的id，即起始符id，即上述公式中的cl
//累加 cn*n (n=1…n)
        for ($i = 1; $i <= count($barfontcharidarray) - 1; $i++) { //count($barfontcharidarray)-1就是n值
            $checksum += $barfontcharidarray[$i] * $i;
        }
        $checknobarfontcharid = $checksum % 103;//取余数后得到校验位的id
        $barfontcharidarray[] = $checknobarfontcharid;//将校验位id存入$barfontcharidarray
        $checknobarfontchar = $idtobarfontcharmapping[$checknobarfontcharid];//通过校验位id得到校验位的编码字符。
        $barfontstring .= $barfontchararray[] = $checknobarfontchar;//将校验位编码字符连接至$barfontstring字符串后端（右侧）。
        $readablestringsplited[] = "校验位";

//添加结束符
        $barfontstring .= $barfontchararray[] = $controlcharmapping['stop'];
        $readablestringsplited[] = "结束符";
        return array($barfontstring, $readablestringsplited, $barfontchararray, $barfontcharidarray);
    }
}

$str = BarcodeCreator::init()->setStr('CHENGXIANG')->setBarSize(21)->outPut();


echo $str;


