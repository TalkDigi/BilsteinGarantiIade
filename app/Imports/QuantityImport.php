<?php

namespace App\Imports;

use App\Models\Quantity;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithUpserts;

class QuantityImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithUpserts
{
    protected $filePath;

    public function __construct($filePath)
    {
        $lastDashPos = strrpos($filePath, '-');

        if ($lastDashPos !== false) {
            $uuidWithExtension = substr($filePath, $lastDashPos + 1);
            $uuid = substr($uuidWithExtension, 0, strrpos($uuidWithExtension, '.'));
        }

        $this->filePath = $uuid;

        Log::info('Clean file path' . $this->filePath);
    }

    public function model(array $row)
    {
        $data = [
            'ItemNo' => $row[0],
            'unit' => $row[1],
            'file_id' => $this->filePath,
        ];
    
        Log::info('Processing Quantity: ' . $data['ItemNo']);
    
        return new Quantity($data);
    }

    public function uniqueBy()
    {
        return 'ItemNo';
    }

    public function headingRow(): int
    {
        return 0;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}