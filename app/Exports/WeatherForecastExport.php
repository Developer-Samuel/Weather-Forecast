<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class WeatherForecastExport implements FromCollection, WithHeadings, WithEvents
{
    protected $city;
    protected $country;
    protected $data;

    public function __construct($city, $country, $data)
    {
        $this->city = $city;
        $this->country = $country;
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return ['Date', 'Time', 'Temperature', 'Description'];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $event->sheet->insertNewRowBefore(1, 2);

                $event->sheet->setCellValue('A1', 'City: ' . $this->city);
                $event->sheet->setCellValue('B1', 'Country: ' . $this->country);

                $columns = ['A', 'B', 'C', 'D'];
                foreach ($columns as $column) {
                    $event->sheet->getColumnDimension($column)->setWidth(20);
                }
            },
        ];
    }
}
