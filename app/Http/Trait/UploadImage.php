<?php

namespace App\Http\Trait;

use App\Models\Transfer;
use Illuminate\Support\Str;

trait UploadImage
{
    public function uploadTransferAttachment($file)
    {
        $filename = date('Y-m-d') . '-Transfer-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('trasfers'), $filename);
        $path = 'trasfers/' . $filename;
        return $path;
    }

    public function deleteAndUploadTransferAttachment($file, $transfer_id, $field)
    {
        $transfer = Transfer::find($transfer_id);
        $oldFilePath = public_path($this->getSAttachPath($transfer_id, $field));

        if (file_exists($oldFilePath) && is_file($oldFilePath)) {
            unlink($oldFilePath);
        }
        $filename = date('Y-m-d') . '-Transfer-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('trasfers'), $filename);
        $path = 'trasfers/' . $filename;
        $transfer->$field = $path;
        $transfer->save();
        return $path;
    }

    public function getSAttachPath($transfer_id, $field)
    {
        $transfer = Transfer::find($transfer_id);
        return $transfer->$field;
    }

    public function uploadReservationAttachment($file)
    {
        $filename = date('Y-m-d') . '-Reservation-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('reservations'), $filename);
        $path = 'reservations/' . $filename;
        return $path;
    }

    public function uploadExpertImage($file)
    {
        $filename = date('Y-m-d') . '-Expert-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);
        $path = 'images/' . $filename;
        return $path;
    }
}
