<?php


namespace App\ApiHelper;


use Illuminate\Support\Facades\Lang;

class LoginResult
{
    public  $isOk = true;
    public $message = 'Task Complete';
    public $result;
    public $statusCode = EnumResult::Success;

    /**
     * Result constructor.
     * @param $result
     * @param string $message
     * @param bool $isOk
     * @param int $statusCode
     */
    public function __construct($result = null, $statusCode = EnumResult::Success, $message = '', $isOk = true)
    {
        $this->isOk = $isOk;
        $this->message = empty($message) ? Lang::get('Messages.TaskCompleteSuccessfully') : $message;
        $this->result = $result;
        $this->statusCode = $statusCode;
    }
}
