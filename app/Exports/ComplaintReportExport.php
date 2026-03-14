<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ComplaintReportExport implements FromCollection, WithHeadings
{
    protected $from_date;
    protected $to_date;

    public function __construct($from_date = null, $to_date = null)
    {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function collection()
    {
        $query = DB::table('complains')
            ->join('categories', 'categories.id', '=', 'complains.category_id')
            ->join('users','complains.user_id','=','users.id')
            ->select(
                'complains.id as complain_id',
                'complains.title',
                'complains.description',
                'complains.latitude',
                'complains.longitude',
                'categories.name as category_name',
                'users.name as created_user',
                DB::raw("CASE
                    WHEN complains.status = 1 THEN 'Pending'
                    WHEN complains.status = 2 THEN 'Progress'
                    WHEN complains.status = 3 THEN 'Completed'
                    WHEN complains.status = 4 THEN 'Rejected'
                END as status"),
                DB::raw("CASE
                    WHEN complains.priority = 1 THEN 'High'
                    WHEN complains.priority = 2 THEN 'Medium'
                    WHEN complains.priority = 3 THEN 'Low'
                END as priority"),
                DB::raw("DATE_FORMAT(complains.created_at, '%d-%m-%Y') as created_at")
            );

        if ($this->from_date && $this->to_date) {
            $query->whereBetween('complains.created_at', [
                $this->from_date.' 00:00:00',
                $this->to_date.' 23:59:59'
            ]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Complain ID',
            'Title',
            'Description',
            'Latitude',
            'Longitude',
            'Category Name',
            'Created User',
            'Status',
            'Priority',
            'Created Date'
        ];
    }
}
