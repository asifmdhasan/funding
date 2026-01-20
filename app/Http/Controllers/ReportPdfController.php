<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Models\Donor;
use App\Models\Crisis;
use App\Models\Donation;
use Illuminate\Http\Request;

class ReportPdfController extends Controller
{
    public function crisisReport(Crisis $crisis)
    {
        $donations = Donation::query()
            ->where('crisis_id', $crisis->id)
            ->selectRaw('donor_id, SUM(amount) as total_amount, MAX(created_at) as last_donation_date')
            ->groupBy('donor_id')
            ->with('donor')
            ->get();

        $totalAmount = $donations->sum('total_amount');

        $html = view('pdf.crisis-report', compact(
            'crisis',
            'donations',
            'totalAmount'
        ))->render();

        $mpdf = new Mpdf(['format' => 'A4']);
        $mpdf->WriteHTML($html);

        return $mpdf->Output(
            'crisis-report-'.$crisis->id.'.pdf',
            'I'
        );
    }

    public function donorReport(Donor $donor)
    {
        $donations = Donation::query()
            ->where('donor_id', $donor->id)
            ->whereNotNull('crisis_id')
            ->selectRaw('crisis_id, SUM(amount) as total_amount, MAX(created_at) as last_donation_date')
            ->groupBy('crisis_id')
            ->with(['crisis.category'])
            ->get();

        $totalAmount = $donations->sum('total_amount');

        $html = view('pdf.donor-report', compact(
            'donor',
            'donations',
            'totalAmount'
        ))->render();

        $mpdf = new Mpdf(['format' => 'A4']);
        $mpdf->WriteHTML($html);

        return $mpdf->Output(
            'donor-report-'.$donor->id.'.pdf',
            'I'
        );
    }
}
