<?php

namespace App\Imports;

use App\Models\Part;

use Maatwebsite\Excel\Concerns\ToModel;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PartImport implements ToModel, WithHeadingRow
{
    protected $storeId;

    public function __construct($storeId) {
        $this->storeId = $storeId;

    }

    public function model(array $row)
    {
        $exists = Part::where('store_id', $this->storeId)
            ->where('part_no', $row['part_no'])
            ->where('pac_qty',$row['pac_qty'])
            ->exists();

        if ($exists) {
            Notification::make()
                ->title("Part No. '{$row['part_no']}' already exists in this store.")
                ->danger()
                ->send();

            throw ValidationException::withMessages([
                'part_no' => "Part No. '{$row['part_no']}' already exists in this store.",
            ]);
        }

        return new Part([
            'store_id' => $this->storeId,
            'part_no' => $row['part_no'],
            'pac_qty' => $row['pac_qty']
        ]);
    }


}
