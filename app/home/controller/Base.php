<?php

declare(strict_types=1);

namespace app\home\controller;

use alocms\cms\CommonApi;

class Base extends CommonApi
{
    protected function initialize()
    {
        header("Access-Control-Allow-Origin:*");
        parent::initialize();
    }
}
