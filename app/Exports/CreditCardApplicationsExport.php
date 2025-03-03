<?php

namespace App\Exports;

use App\Models\CreditCardApplication;
use Maatwebsite\Excel\Concerns\FromCollection;

class CreditCardApplicationsExport implements FromCollection
{
    /**
     * Retrieve all credit card applications.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return CreditCardApplication::all();
    }
}
