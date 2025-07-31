<?php

namespace App\Filament\Resources\PartResource\Pages;

use App\Filament\Resources\PartResource;
use App\Imports\PartImport;
use App\Models\Store;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Alignment;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class ListParts extends ListRecords
{
    protected static string $resource = PartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('upload_part')
                ->label('Upload Part')
                ->icon('heroicon-o-plus-circle')
                ->requiresConfirmation()
                ->modalHeading('Upload Part')
                ->modalAlignment(Alignment::Center)
                ->closeModalByClickingAway(false)
                ->form([
                    Section::make()
                        ->schema([
                            Select::make('store_id')
                                ->label('Store')
                                ->options(Store::all()->pluck('store_name', 'id'))
                                ->required(),

                            FileUpload::make('file')
                                ->label('Excel File')
                                // ->disk('upload_part')
                                ->directory('imports')
                                ->visibility('public')
                                ->required()
                                ->live()
                            // ->afterStateUpdated(function (callable $set, TemporaryUploadedFile $state) {
                            //     dd($state->getRealPath());
                            //     // // $impExcel = new ForecastExcelSheets;
                            //     // Excel::import($impExcel, $state->getRealPath());
                            //     // $set('forecasts', $impExcel->data);
                            //     // return $impExcel;
                            // }),
                        ])
                ])
                ->action(function (array $data) {
                    // $data = $this->form->getState();
                    // dd($data);
                    $storeId = $data['store_id'];
                    $filePath = storage_path('app/public/' . $data['file']); // แปลง path ให้ Laravel Excel ใช้ได้

                    Excel::import(new PartImport($storeId), $filePath);

                    Notification::make()
                        ->title('Data imported successfully')
                        ->success()
                        ->send();
                }),
        ];
    }
}
