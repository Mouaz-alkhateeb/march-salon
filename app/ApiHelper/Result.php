<?php


namespace App\ApiHelper;

use Illuminate\Support\Facades\Lang;

class Result
{
    public $isOk = true;
    public $validationMessage;
    public $message = 'Task Complete';
    public $result;
    public $paginate;

    /**
     * Result constructor.
     * @param null $result
     * @param null $validationMessage
     * @param null $paginate
     * @param string $message
     * @param bool $isOk
     */
    public function __construct($result = null, $paginate = null, string $message = '', bool $isOk = true)
    {
        $this->isOk = $isOk;
        $this->message = empty($message) ? Lang::get('Messages.TaskCompleteSuccessfully') : $message;
        $this->result = $result;
        $this->paginate = $paginate;
    }
}