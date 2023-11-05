<?php


namespace App\ApiHelper;


use Illuminate\Support\Facades\Lang;

class ErrorResult
{

    public function __construct(string $message = '', bool $isOk = false, int $code = 500)
    {
        $this->isOk = $isOk;
        $this->message = empty($message) ? Lang::get('Messages.TaskDoesNotCompleteSuccessfully') : $message;
        $this->code = $code;
    }
}
