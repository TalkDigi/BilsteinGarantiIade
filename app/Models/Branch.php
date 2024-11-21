<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'BranchID',
        'BranchName',
        'CustNo',
    ];

    protected $connection = 'mysql';

    public function migrate_branches()
    {
        $invoices = \App\Models\Invoice::where('CustNo', '120.1042')
            ->get()
            ->groupBy('BranchID');

        foreach ($invoices as $branchID => $invoices) {
            $branch = Branch::where('BranchID', $branchID)->first();
            if (!$branch) {
                Branch::create(['BranchID' => $branchID, 'BranchName' => $invoices[0]->Branch, 'CustNo' => '120.1042']);
            }
        }
    }
}
