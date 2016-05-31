<?php

namespace Artesaos\Restinga\Http\Format\Send;

trait SendUrlEncoded
{
    public function encode()
    {
        return $this->buildFormString($this->attributes);
    }

    public function getContentTypeHeader()
    {
        return 'application/x-www-form-urlencoded';
    }

    protected function buildFormString($array, $prefix = null)
    {
        if (!is_array($array)) {
            return $array;
        }
        $params = array();
        foreach ($array as $k => $v) {
            if (is_null($v)) {
                continue;
            }
            if ($prefix && $k && !is_int($k)) {
                $k = $prefix.'['.$k.']';
            } elseif ($prefix) {
                $k = $prefix.'[]';
            }
            if (is_array($v)) {
                $params[] = $this->buildFormString($v, $k);
            } else {
                $params[] = $k.'='.urlencode($v);
            }
        }

        return implode('&', $params);
    }
}
