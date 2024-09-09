<?php

namespace App\Imports;

use App\Models\Quantity;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class QuantityImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
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


    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $data = [
            'ItemNo' => $row[0],
            'unit' => $row[1],
            'file_id' => $this->filePath,
        ];


        $quantity = Quantity::where('ItemNo', $row['0'])->first();

        if ($quantity) {

            $quantity->update($data);
            return $quantity;

        } else {

            return new Quantity($data);

        }
    }

    /**
     * Ignore the first row of the file.
     *
     * @return int
     */
    public function headingRow(): int
    {
        return 0; // Ignore the first row
    }

    /**
     * Define the chunk size for processing the file.
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000; // Process 1000 rows at a time
    }

    public function batchSize(): int
    {
        return 1000;
    }

}
