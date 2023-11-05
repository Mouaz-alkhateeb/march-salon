<?php

namespace App\Services\Admin;

use App\Filter\Expert\ExpertFilter;
use App\Filter\Reservation\ReservationHistoryFilter;
use App\Filter\Service\ServiceFilter;
use App\Filter\Transfer\TransferFilter;
use App\Filter\User\ClientFilter;
use App\Filter\User\UserFilter;
use App\Interfaces\Admin\AdminServiceInterface;
use App\Models\ReservationHistory;
use App\Models\Transfer;
use App\Query\Admin\MostReservationQuery;
use App\Repository\Admin\AdminRepository;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PDF;

class AdminService implements AdminServiceInterface
{
    public function __construct(private AdminRepository $adminRepository, private MostReservationQuery  $adminData)
    {
    }
    public function create_admin($data)
    {
        return $this->adminRepository->create_admin($data);
    }

    public function create_receiption($data)
    {
        return $this->adminRepository->create_receiption($data);
    }

    public function create_transfer($data)
    {
        return $this->adminRepository->create_transfer($data);
    }
    public function show_transfer(int $id)
    {
        return $this->adminRepository->getById($id)->load(['user', 'client']);
    }
    public function update_transfer($data)
    {
        return $this->adminRepository->update_transfer($data);
    }

    public function delete_transfer(int $id)
    {
        return $this->adminRepository->delete_transfer($id);
    }
    public function update_receiption($data)
    {
        return $this->adminRepository->update_receiption($data);
    }


    public function list_of_transfers(TransferFilter $transferFilter = null)
    {
        if ($transferFilter != null)
            return $this->adminRepository->getFilterItems($transferFilter);
        else
            return $this->adminRepository->get();
    }

    public function create_service($data)
    {
        return $this->adminRepository->create_service($data);
    }
    public function create_expert($data)
    {
        return $this->adminRepository->create_expert($data);
    }
    public function delete_receiption(int $id)
    {
        return $this->adminRepository->delete_receiption($id);
    }
    public function list_of_experts(ExpertFilter $expertFilter = null)
    {
        if ($expertFilter != null)
            return $this->adminRepository->list_of_experts($expertFilter);
        else
            return $this->adminRepository->get();
    }

    public function list_of_receiptions(UserFilter $userFilter = null)
    {
        if ($userFilter != null)
            return $this->adminRepository->list_of_receiptions($userFilter);
        else
            return $this->adminRepository->get();
    }
    public function create_holiday($data)
    {
        return $this->adminRepository->create_holiday($data);
    }
    public function chang_permission($data)
    {
        return $this->adminRepository->chang_permission($data);
    }
    public function most_active_client()
    {
        return $this->adminData->most_active_client();
    }

    public function number_daily_clients(ClientFilter $clientFilter = null)
    {
        if ($clientFilter != null)
            return $this->adminRepository->number_daily_clients($clientFilter);
        else
            return $this->adminRepository->get();
    }
    public function reservations_history(ReservationHistoryFilter $reservationHistoryFilter = null)
    {
        if ($reservationHistoryFilter != null)
            return $this->adminRepository->reservations_history($reservationHistoryFilter);
        else
            return $this->adminRepository->get();
    }

    public function update_expert($data)
    {
        return $this->adminRepository->update_expert($data);
    }
    public function confirm_reservation($data)
    {
        return $this->adminRepository->confirm_reservation($data);
    }

    public static function isConfirmed($id)
    {
        $isConfirmed = ReservationHistory::where('reservation_id', $id)->value('is_confirmed');
        if ($isConfirmed) {
            return $isConfirmed;
        } else {
            return 0;
        }
    }
    public function export($filter)
    {
        $records = Transfer::query();
        $table_attributes = DB::getSchemaBuilder()->getColumnListing('transfers');

        if ($filter instanceof TransferFilter) {

            $records->when(isset($filter->starting_date), function ($query) use ($filter) {
                $query->where('date', $filter->getStartingDate());
            });
            $records->when(isset($filter->end_date), function ($query) use ($filter) {
                $query->where('date', $filter->getEndingDate());
            });

            $records->when((isset($filter->starting_date) && isset($filter->end_date)), function ($records) use ($filter) {
                $records->whereBetween('date', [$filter->getStartingDate(), $filter->getEndingDate()])
                    ->orWhereBetween('date', [$filter->getStartingDate(), $filter->getEndingDate()]);
            });
        }

        $transfers = $records->with(['user', 'client'])->get();
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        $i = 'A';
        foreach ($table_attributes as $value) {
            if ($value == 'attachment') {
                continue;
            }
            if ($value == 'created_at') {
                continue;
            }
            if ($value == 'updated_at') {
                continue;
            }
            if ($value == 'user_id') {
                $value = 'user';
            }
            if ($value == 'client_id') {
                $value = 'client';
            }
            $activeWorksheet->setCellValue($i . '1', $value);
            $activeWorksheet->getStyle($i . '1')->getAlignment()->setHorizontal('center');
            $activeWorksheet->getColumnDimension($i)->setWidth(30);
            $activeWorksheet->getStyle($i . '1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('FFA0A0A0');
            $header_columns[] = [$i => $value];
            $i++;
        }

        $i = 'A';
        $key_index = 2;
        foreach ($header_columns as $key => $value) {
            foreach ($transfers as $userKey => $userValue) {
                $name = $value[$i];

                if ($name == 'user') {
                    $name = 'user.name';
                }
                if ($name == 'client') {
                    $name = 'client.name';
                }

                $theKey = key($value);
                $activeWorksheet->setCellValue($theKey . $key_index, data_get($userValue, $name));
                $activeWorksheet->getStyle($theKey . $key_index)->getAlignment()->setHorizontal('center');

                $activeWorksheet->getStyle($theKey . $key_index)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THICK);
                $key_index++;
            }
            $i++;
            $key_index = 2;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('transfers.xlsx');
        $file_name = Date('Y-m-d') . '-transfers.xlsx';

        return response()->download(public_path('transfers.xlsx'), $file_name, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'inline; filename="' . $file_name . '"',
        ]);
    }
    public function export_pdf($filter)
    {
        $records = Transfer::query();
        $tableAttributes = DB::getSchemaBuilder()->getColumnListing('transfers');

        if ($filter instanceof TransferFilter) {

            $records->when(isset($filter->starting_date), function ($query) use ($filter) {
                $query->where('date', $filter->getStartingDate());
            });
            $records->when(isset($filter->end_date), function ($query) use ($filter) {
                $query->where('date', $filter->getEndingDate());
            });

            $records->when((isset($filter->starting_date) && isset($filter->end_date)), function ($records) use ($filter) {
                $records->whereBetween('date', [$filter->getStartingDate(), $filter->getEndingDate()])
                    ->orWhereBetween('date', [$filter->getStartingDate(), $filter->getEndingDate()]);
            });

            $transfers = $records->with(['client', 'user'])->get();
            $data = [
                'tableAttributes' => $tableAttributes,
                'transfers' => $transfers,
            ];
        }

        $allTransfers = $records->with(['client', 'user'])->get();

        $data = [
            'tableAttributes' => $tableAttributes,
            'transfers' => $allTransfers,
        ];

        $pdf = PDF::loadView('pdf.transfers', $data);

        $pdf->save(public_path('transfers.pdf'));

        $file_name = date('Y-m-d') . '-transfers.pdf';
        return response()->download(public_path('transfers.pdf'), $file_name, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $file_name . '"',
        ]);
    }
}
