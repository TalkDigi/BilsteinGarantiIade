<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Log;

class InvoiceExport implements FromView, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    protected $lines;
    protected $total;
    protected $tax;
    protected $total_with_tax;
    protected $Application;
    protected $brands;
    protected $type;

    public function __construct($lines, $total, $tax, $total_with_tax, $Application,$brands,$type = null)
    {
        $this->lines = $lines;
        $this->total = $total;
        $this->tax = $tax;
        $this->total_with_tax = $total_with_tax;
        $this->Application = $Application;
        $this->brands = $brands;
        $this->type = $type;

        Log::info('tYPE BURADA');
        Log::info($type);
    }

    public function view(): View
    {
        return view('exports.invoice', [
            'lines' => $this->lines,
            'total' => $this->total,
            'tax' => $this->tax,
            'total_with_tax' => $this->total_with_tax,
            'Application' => $this->Application,
            'brands' => $this->brands,
            'type' => $this->type
        ]);
    }

    public function headings(): array
    {
        return [
            [''], // Empty row for spacing
            [''], // Empty row for spacing
            [''], // Empty row for spacing
            [''], // Empty row for spacing
            [''], // Empty row for spacing
            ['Logo'], // Placeholder for logo
            ['Örnek Fatura2'], // Title
            [''], // Empty row for spacing
        ];
    }

    public function title(): string
    {
        return 'Fatura';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Merge cells for logo and title
            1 => ['font' => ['bold' => true]],
            2 => ['font' => ['bold' => true]],
            3 => ['font' => ['bold' => true]],
            4 => ['font' => ['bold' => true]],
            5 => ['font' => ['bold' => true]],
            6 => ['font' => ['bold' => true]],
            7 => ['font' => ['bold' => true]],
            8 => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 30,
            'C' => 20,
            'D' => 15,
            'E' => 20,
            'F' => 20,
        ];
    }
}
