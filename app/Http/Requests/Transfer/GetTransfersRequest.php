<?php

namespace App\Http\Requests\Transfer;

use App\Filter\Transfer\TransferFilter;
use Illuminate\Foundation\Http\FormRequest;

class GetTransfersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function generateFilter()
    {
        $transferFilter = new TransferFilter();

        if ($this->filled('user_id')) {
            $transferFilter->setUserId($this->input('user_id'));
        }
        if ($this->filled('client_id')) {
            $transferFilter->setClientId($this->input('client_id'));
        }
        if ($this->filled('starting_date')) {
            $transferFilter->setStartingDate($this->input('starting_date'));
        }
        if ($this->filled('end_date')) {
            $transferFilter->setEndingDate($this->input('end_date'));
        }
        if ($this->filled('transfer_amount')) {
            $transferFilter->setTransferAmount($this->input('transfer_amount'));
        }

        if ($this->filled('order_by')) {
            $transferFilter->setOrderBy($this->input('order_by'));
        }

        if ($this->filled('order')) {
            $transferFilter->setOrder($this->input('order'));
        }

        if ($this->filled('per_page')) {
            $transferFilter->setPerPage($this->input('per_page'));
        }
        return $transferFilter;
    }
    public function generateFilesFilter()
    {
        $transferFilter = new TransferFilter();


        if ($this->filled('starting_date')) {
            $transferFilter->setStartingDate($this->input('starting_date'));
        }
        if ($this->filled('end_date')) {
            $transferFilter->setEndingDate($this->input('end_date'));
        }

        return $transferFilter;
    }
}