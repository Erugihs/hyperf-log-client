<?php


namespace STK\Client\Log\Base;

use STK\Client\Log\Base\Attributes;
use STK\Client\Log\Exception\FieldException;

class LogBase
{
    use Attributes;
    
    public $table;
    public $casts;
    public $defaults = [];
    public $logSvc;

    public function __construct()
    {
        $this->setLogSvc();
    }

    public function setLogSvc()
    {
        $this->logSvc = make(LogServiceProviderInterface::class);
    }


    /**
     * @param mixed $attributes 查询参数
     * @param string $contextKey 递归时传递的上下文键名
     * @return array
     */
    protected function relationsAttribute($attributes, $contextKey = '')
    {
        if (is_array($attributes)) {
            $castAttribute = [];
            foreach($attributes as $aKey => $aValue){
                if (isset($this->casts[$aKey]) || $contextKey) {
                    if ($contextKey) {
                        $type = $this->casts[$contextKey];
                    } else {
                        $type = $this->casts[$aKey];
                    }
                    if (is_array($aValue)) {
                        strpos($aKey,'$')===false && $contextKey = $aKey;
                        foreach($aValue as $k => $v){
                            $castAttribute[$aKey][$k] = $this->relationsAttribute($v,$contextKey);
                        }
                        $contextKey = '';
                    } elseif (is_string($aValue)) {
                        $castAttribute[$aKey] = $this->castAttribute($type, $aValue);
                    } else {
                        $castAttribute[$aKey] = $aValue;
                    }
                } elseif(strpos($aKey,'$')!==false) {
                    foreach($aValue as $k => $v){
                        $castAttribute[$aKey][$k] = $this->relationsAttribute($v);
                    }
                } else {
                    $castAttribute[$aKey] = $aValue;
                }
            }
        } else {
            $type = $this->casts[$contextKey];
            $castAttribute = $this->castAttribute($type, $attributes);
        }
        return $castAttribute;
    }

    protected function castAttribute(string $castType, $value)
    {
        switch ($castType) {
            case 'int':
            case 'integer':
                return $this->fromInt($value);
            case 'string':
                return $this->fromString($value);
            case 'bool':
            case 'boolean':
                return $this->fromBool($value);
            case 'object':
                return $this->fromIdObj($value);
        }
        return $value;
    }

    public function setUnsetValueByDefaults(&$attributes)
    {
        foreach ($this->defaults as $key => $default) {
            if (!isset($attributes[$key])) {
                $attributes[$key] = $default;
            }
        }
        return $attributes;
    }
}
