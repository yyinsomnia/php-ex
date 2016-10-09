<?php
/**
 *
 */

class StdTel
{
    const DEFAULT_COUNTRY_CODE = '86';
    public $countryCode;
    public $agencyCode;
    public $spCode;
    public $cityCode;
    public $number;

    
    public function __toString()
    {
        if (isset($this->agencyCode)) {
            return $this->toString4Agency();
        } elseif (isset($this->spCode)) {
            return $this->toString4Sp();
        } elseif (isset($this->countryCode)) {
            return $this->toString4Country();
        } elseif (isset($this->number)) {
            return $this->number;
        }
    }

    private function toString4Country()
    {
        return $this->countryCode . '-' . $this->cityCode . '-' . $this->number;
    }

    private function toString4Agency()
    {
        return $this->agencyCode . '-' . $this->number;
    }

     private function toString4Sp()
    {
        return $this->spCode . '-' . $this->number;
    }

    public function reset()
    {
        $this->countryCode = null;
        $this->agencyCode = null;
        $this->spCode = null;
        $this->cityCode = null;
        $this->number = null;
    }

}

class StrHelper
{
    public static function getNum($str)
    {
        $ret = '';
        $len = strlen($str);
        for ($i = 0; $i < $len; $i++){
            if(is_numeric($str[$i])){
                $ret .= $str[$i];
            }
        }
        return $ret;
    }

}


class Lexer
{

    /**
     * 初始化状态
     */
    const STATE_INIT = 0;

    /**
     * 匹配了国际字冠
     */
    const STATE_PREFIX_MATCHED = 1;

    /**
     * 匹配了国家
     */
    const STATE_COUNTRY_MATCHED = 2;

    /**
     * 匹配了城市
     */
    const STATE_CITY_MATCHED = 4;

    private $state;

    private $pos = 0;

    /**
     * @var array
     */
    private $internationalPrefixNumDict;

    /**
     * @var array
     */
    private $countryCodeDict;

    /**
     * @var array
     */
    private $agencyCodeDict;

    /**
     * @var array
     */
    private $spCodeDict;

    /**
     * 只有数字的电话号码
     * @var string
     */
    private $numTel;

    /**
     * 只有数字的电话号码长度
     * @var int
     */
    private $numTelLen;

    /**
     * @var string
     */
    private $originTel;

    /**
     * @var int
     */
    private $originTelLen;

    /**
     * @var StdTel
     */
    private $stdTel;

    public function __construct($internationalPrefixNumDict, $countryCodeDict, $agencyCodeDict, $spCodeDict)
    {
        $this->internationalPrefixNumDict = $internationalPrefixNumDict;
        $this->countryCodeDict = $countryCodeDict;
        $this->agencyCodeDict = $agencyCodeDict;
        $this->spCodeDict = $spCodeDict;

        $this->stdTel = new StdTel();

        $this->init();
    }

    private function init()
    {
        $this->reset();
    }

    private function reset()
    {
        $this->state = self::STATE_INIT;
        $this->pos = 0;
        $this->stdTel->reset();
    }

    public function handle($tel)
    {
        $this->reset();
        $this->setOriginTel($tel);
        $this->achieveNum();
        return $this->match();
    }

    /**
     * 只要数字
     * @return  void
     */
    public function achieveNum()
    {
        $this->numTel = StrHelper::getNum($this->originTel);
        $this->numTelLen = strlen($this->numTel);
    }

    public function match()
    {
        $matched = false;

        foreach ($this->internationalPrefixNumDict as $num => $_str) {
            if (strpos($this->numTel, "{$num}", $this->pos) === $this->pos) {
                $this->pos += strlen($num);
            }
        }

        foreach ($this->countryCodeDict as $num => $_str) {
            if (strpos($this->numTel, "{$num}", $this->pos) === $this->pos) {
                $this->stdTel->countryCode = $num;
                $this->pos += strlen($num);
                break;
            }
        }

        foreach ($this->agencyCodeDict as $num => $_str) {
            if (strpos($this->numTel, "{$num}", $this->pos) === $this->pos) {
                $this->stdTel->agencyCode = $num;
                $this->pos += strlen($num);
                $matched = true; //匹配代理电话
                break;
            }
        }

        // 匹配了代理号码的后面直接跟电话号码
        if (isset($this->stdTel->agencyCode)) {
            ;
        } else {
            if (!isset($this->stdTel->countryCode)) {
                $this->stdTel->countryCode = StdTel::DEFAULT_COUNTRY_CODE;
            }

            foreach ($this->countryCodeDict[$this->stdTel->countryCode]['city_code'] as $num => $_str) {
                if (strpos($this->numTel, "0{$num}", $this->pos) === $this->pos) {
                    $this->stdTel->cityCode = $num;
                    $this->pos += strlen($num) + 1;
                    $this->stdTel->number = substr($this->numTel, $this->pos);
                    break;
                }
                if (strpos($this->numTel, "{$num}", $this->pos) === $this->pos) {
                    $this->stdTel->cityCode = $num;
                    $this->pos += strlen($num);
                    $this->stdTel->number = substr($this->numTel, $this->pos);
                    break;
                }
            }
            $this->stdTel->number = substr($this->numTel, $this->pos);

            if (!self::validatePhone($this->stdTel)) {
                $this->reset();
                foreach ($this->spCodeDict as $numRange => $val) {
                    if (strpos($numRange, '-') !== false) {
                        list($numStart, $numEnd) = explode('-', $numRange);
                        $numList = range($numStart, $numEnd);
                    } else {
                        $numList = array($numRange);
                    }
                    foreach ($numList as $num) {
                        if (strpos($this->numTel, "{$num}", $this->pos) === $this->pos) {
                            $this->stdTel->spCode = $num;
                            $this->pos += strlen($num);
                            $matched = true; //匹配sp号码
                            break;
                        }
                    }
                }
                $this->stdTel->number = substr($this->numTel, $this->pos);
            } else {
                $matched = true; //匹配固话or移动号码
            }
            
            return $matched;
            
        }
    }

    public static function validatePhone(StdTel $tel)
    {

        if ($tel->countryCode == StdTel::DEFAULT_COUNTRY_CODE) {
            $cityCodeLen = strlen($tel->cityCode);
            $numberLen = strlen($tel->number);
            $isLegal = true;
            switch ($cityCodeLen) {
                case 0:
                    $isLegal = $numberLen === 11; //手机号
                    break;
                case 2:
                case 3:
                    $isLegal = in_array($numberLen , array(5, 6, 7, 8), true);
                    break;
                default:
                    $isLegal = false;
            }
            if (!$isLegal) {
                ;
            }
            return $isLegal;
        }
        return true;

    }

    public function setOriginTel($tel)
    {
        $this->originTel = $tel;
        $this->originTelLen = strlen($tel);
    }

    public function getStdTel()
    {
        return $this->stdTel;
    }
}
