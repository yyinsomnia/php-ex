<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2/6/16
 * Time: 15:58
 */
namespace DimLight\Structure;


class BitSet
{
    /**
     * @var int
     */
    protected $bitNumPerInt;
    /**
     * @var int
     */
    protected $bitNum;

    /**
     * @var store the set
     */
    protected $intArray;

    protected $intArrayCount;

    /**
     * @param int $bitNum
     */
    public function __construct($bitNum)
    {
        $this->bitNum = (int) $bitNum;
        $this->bitNumPerInt = 8 * PHP_INT_SIZE; //8 is hard code, need to improve
        $this->intArrayCount = intval(ceil($this->bitNum / $this->bitNumPerInt));
        $this->intArray = new \SplFixedArray($this->intArrayCount);
        for ($i = 0; $i < $this->intArrayCount; $i++) {
            $this->intArray[$i] = 0;
        }
    }

    public function setTrue($bit)
    {
        if ($bit > $this->bitNum) {
            throw new \RuntimeException();
        } else {
            $index = $this->findIndex($bit);
            $this->intArray[$index[0]] |= (1 << $index[1]);      
        }
    }
    
    public function setFalse($bit)
    {
        if ($bit > $this->bitNum) {
            throw new \RuntimeException();
        } else {
            $index = $this->findIndex($bit);
            $this->intArray[$index[0]] &= ~(1 << $index[1]);      
        }
    }
    
    /**
     * @param int $bit
     * @return array [0 => array_index, 1 => int_index] 
     * @exception 
     */
    protected function findIndex($bit)
    {
        if ($bit > $this->bitNum) {
            throw new \RuntimeException('bit is out of the set size');
        }
        $array_index = intval($bit / $this->bitNumPerInt);
        $int_index = $bit % $this->bitNumPerInt;
        return [$array_index, $int_index];
    }
    
    public function __toString()
    {
        return $this->toString();
    }
    
    public function toString()
    {
        $str = '';
        foreach ($this->intArray as $int) {
            for ($i = 0; $i < $this->bitNumPerInt; $i++) {
                $str .= $int >> $i & 1;
            }
        }
        return substr($str, 0, $this->bitNum);
    }

}

$a = new BitSet(24 * 60);
$a->setTrue(25);
$s = $a->toString();
echo $a;