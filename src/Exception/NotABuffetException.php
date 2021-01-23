<?php
/**
 * Created by PhpStorm.
 * User: aminebetari
 * Date: 03/12/20
 * Time: 12:17
 */

namespace App\Exception;


class NotABuffetException extends \Exception
{
    protected $message = 'Please do not mix the carnivorous and non-carnivorous dinosaurs. It will be a massacre!';
}