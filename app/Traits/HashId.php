<?php

/**
 * Created by PhpStorm.
 * User: tujailer
 * Date: 8/1/21
 * Time: 3:56 PM
 */

namespace App\Traits;

use Hashids\Hashids;

trait HashId
{

    public function key()
    {
        return new Hashids('Auditors', 32);
    }

    public function decrypt($id)
    {
        return $this->key()->decode($id)[0];
    }

    public function encrypt($id)
    {
        if (is_numeric($id)) {
            return $this->key()->encode($id);
        }
    }
}
