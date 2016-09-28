<?php

class StdTel
{
    const DEFAULT_COUNTRY_CODE = '86';
    public $countryCode;
    public $cityCode;
    public $number;

    public function __toString()
    {
        return $this->countryCode . $this->cityCode . $this->number;
    }

    public function reset()
    {
        $this->countryCode = null;
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

    public function __construct($internationalPrefixNumDict, $countryCodeDict)
    {
        $this->internationalPrefixNumDict = $internationalPrefixNumDict;
        $this->countryCodeDict = $countryCodeDict;
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
        
        $this->setOriginTel($tel);
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
        foreach ($this->internationalPrefixNumDict as $num => $_str) {
            if (strpos($this->numTel, $num, $this->pos) === $this->pos) {
                $this->pos += strlen($num);
            }
        }

        foreach ($this->countryCodeDict as $num => $_str) {
            if (strpos($this->numTel, $num, $this->pos) === $this->pos) {
                $this->stdTel->countryCode = $num;
                $this->pos += strlen($num);
            }
        }

        if (!isset($this->stdTel->countryCode)) {
            $this->stdTel->countryCode = StdTel::DEFAULT_COUNTRY_CODE;
        }

        foreach ($this->countryCodeDict[$this->stdTel->countryCode]['city_code'] as $num => $_str) {
            if (strpos($this->numTel, $num, $this->pos) === $this->pos ||
                strpos($this->numTel, "0{$num}", $this->pos) === $this->pos
            ) {
                $this->stdTel->cityCode = $num;
                $this->pos += strlen($num);
            }
        }
        if (!isset($this->stdTel->cityCode)) {
            throw new LengthException('tel must has city code!');
        }

        $this->stdTel->number = substr($this->numTel, $this->pos);
    }

    public function setOriginTel($tel)
    {
        $this->originTel = $tel;
        $this->originTelLen = strlen($tel);
    }


}