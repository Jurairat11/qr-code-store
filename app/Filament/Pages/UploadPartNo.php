<?php

namespace App\Filament\Pages;

use App\Models\Store;
use Filament\Pages\Page;
use App\Imports\PartImport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;

class UploadPartNo extends Page implements HasForms
{
    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';
    protected static string $view = 'filament.pages.upload-part-no';

    protected static ?string $title = 'Upload Excel';
    public $file;
    public $store_id;

    use InteractsWithForms;

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make()
            ->schema([

            Select::make('store_id')
            ->label('Store')
            ->options(Store::all()->pluck('store_name', 'id'))
            ->required(),

            FileUpload::make('file')
                ->label('Excel File')
                ->disk('local')
                ->directory('imports')
                ->required(),
            ])

        ];
    }

    public function submit()
    {
        $data = $this->form->getState();

        $storeId = $data['store_id'];
        $file = $data['file'];

        Excel::import(new PartImport($storeId),$file);

        Notification::make()
            ->title('Data imported successfully')
            ->success()
            ->send();
    }

}
