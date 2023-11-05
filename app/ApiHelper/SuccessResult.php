<?php


namespace App\ApiHelper;


use Illuminate\Support\Facades\Lang;

class SuccessResult
{

    public function __construct(string $message = '', bool $isOk = true)
    {
        $this->isOk = $isOk;
        $this->message = empty($message) ? Lang::get('Messages.TaskCompleteSuccessfully') : $message;

    }

}