<?php

namespace App\Exports;

use App\Models\customer_supplier;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class CustomerSupplier implements FromArray, WithHeadings, WithEvents, ShouldAutoSize
{
    use Exportable;

    private $shop_id;
    private $customer_name;
    private $status;
    private $customer_flg;

    public function __construct($shop_id, $customer_name, $status, $customer_flg)
    {
        $this->shop_id = $shop_id;
        $this->customer_name = $customer_name;
        $this->status = $status;
        $this->customer_flg = $customer_flg;
    }

    public function array(): array
    {
        return customer_supplier::exportListCustomer($this->shop_id, $this->customer_name, $this->status,
            $this->customer_flg);
    }

    public function registerEvents(): array
    {
        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];


        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endColor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
        ];



        return [
            AfterSheet::class => function(AfterSheet $event) use ($styleArray, $styleBorder) {
                $event->sheet->getStyle('A1:I1')->applyFromArray($styleArray);
                $event->sheet->getStyle('A1:I1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getStyle('A1:I1000')->applyFromArray($styleBorder);
                $event->sheet->getStyle('A1:I1')->getFill()->setFillType('solid')->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKGREEN);
            }
        ];
    }

    public function headings(): array
    {

        if ($this->customer_flg) {
            return [
                __('messages.stt'),
                __('messages.customer_name'),
                __('messages.customer_group_name'),
                __('messages.customer_tax_code'),
                __('messages.customer_address'),
                __('messages.customer_email'),
                __('messages.customer_tel'),
                __('messages.customer_web'),
                __('messages.customer_note'),
            ];
        } else {
            return [
                __('messages.stt'),
                __('messages.supplier_name'),
                __('messages.supplier_group_name'),
                __('messages.customer_tax_code'),
                __('messages.customer_address'),
                __('messages.customer_email'),
                __('messages.customer_tel'),
                __('messages.customer_web'),
                __('messages.customer_note'),
            ];
        }

    }

}
