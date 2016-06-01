<?php

namespace Artesaos\Restinga\Http\Format\Receive;

use Artesaos\Restinga\Http\ErrorBag;

/**
 * Trait ReceiveJsonErrors.
 */
trait ReceiveJsonErrors
{
    /**
     * @param int    $code
     * @param string $data
     *
     * @return \Artesaos\Restinga\Contracts\Http\ErrorBag
     */
    public function factoryErrors($code, $data)
    {
        $errors = json_decode($data, true);
        if (isset($this->errors_root) && $this->errors_root) {
            $errors = $errors[$this->errors_root];
            foreach($errors as $k => $v) {
                if (is_array($v)) {
                    $errors[$k] = implode(' - ', $v);
                }
            }
        }

        return new ErrorBag($code, $errors, $data);
    }
}
