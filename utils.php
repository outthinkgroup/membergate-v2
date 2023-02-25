<?php

function check_and_return($var)
{
    return isset($var) ? $var : null;
}

function debug($val)
{
    error_log(print_r($val, true));
}
