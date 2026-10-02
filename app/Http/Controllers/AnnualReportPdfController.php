<?php

namespace App\Http\Controllers;

use App\Models\AnnualReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AnnualReportPdfController extends Controller
{
    public function download($id)
    {
        $report = AnnualReport::with('lessee')->findOrFail($id);

        $decodeJson = function ($value) {
            if (empty($value))
                return [];
            return is_string($value) ? json_decode($value, true) : (array) $value;
        };

        $items = $decodeJson($report->items);

        // Section JSON sources (raw values before decoding to prevent variable overwrites)
        $pondBreakdownRaw = $report->financial ?? $items['pond_breakdown'] ?? [];
        $financialRaw = $report->financial ?? $items['financial'] ?? [];
        $workersRaw = $report->workers ?? $items['workers'] ?? [];
        $improvementsRaw = $report->improvements ?? $items['improvements'] ?? [];
        $stockingRaw = $report->stocking ?? $items['stocking'] ?? [];
        $harvestingRaw = $report->harvesting ?? $items['harvesting'] ?? [];
        $marketingRaw = $report->marketing ?? $items['marketing'] ?? [];

        $pondBreakdown = $decodeJson($pondBreakdownRaw);
        $financial = $decodeJson($financialRaw);
        $workers = $decodeJson($workersRaw);
        $improvements = $decodeJson($improvementsRaw);

        // --- 1. STOCKING SECTION ---
        $stockData = $decodeJson($stockingRaw);
        $standardStockSpecies = ['Bangus', 'Fry', 'Fingerlings', 'Sugpo', 'Shrimp', 'Others (Specify)'];

        $stocking = [];
        $totalStockCost = 0;

        foreach ($standardStockSpecies as $spec) {
            $item = $stockData[$spec] ?? $stockData[strtolower($spec)] ?? [];
            $cost = isset($item['cost']) && $item['cost'] !== '' ? (float) $item['cost'] : 0;
            $totalStockCost += $cost;

            $stocking[$spec] = [
                'date' => $item['date'] ?? '',
                'source' => $item['source'] ?? '',
                'area' => $item['area'] ?? '',
                'quantity' => $item['quantity'] ?? '',
                'cost' => $cost,
            ];
        }

        $customRows = $stockData['custom_rows'] ?? [];
        foreach ($customRows as $custom) {
            $cost = isset($custom['cost']) && $custom['cost'] !== '' ? (float) $custom['cost'] : 0;
            $totalStockCost += $cost;
        }

        // --- 2. HARVESTING SECTION ---
        $harvestDataRaw = $decodeJson($harvestingRaw);
        $standardHarvestSpecies = ['Bangus', 'Sugpo', 'Shrimp', 'Others (Specify)'];

        $harvestData = [];
        $totalHarvestValue = 0;

        foreach ($standardHarvestSpecies as $spec) {
            $item = $harvestDataRaw[$spec] ?? $harvestDataRaw[strtolower($spec)] ?? [];

            $totalVal = isset($item['total_value']) && $item['total_value'] !== '' ? (float) $item['total_value'] : 0;
            $totalHarvestValue += $totalVal;

            $price = isset($item['price_per_kilo']) && $item['price_per_kilo'] !== ''
                ? (float) $item['price_per_kilo']
                : null;

            $harvestData[$spec] = [
                'date' => $item['date'] ?? '',
                'area_harvested' => $item['area'] ?? '',
                'kilos' => $item['qty_kilos'] ?? '',
                'pcs_per_kg' => $item['pcs_per_kg'] ?? '',
                'price_per_kilo' => $price,
                'total_value' => $totalVal,
            ];
        }

        $customHarvestRows = $harvestDataRaw['custom_rows'] ?? [];
        foreach ($customHarvestRows as $custom) {
            $val = isset($custom['total_value']) && $custom['total_value'] !== '' ? (float) $custom['total_value'] : 0;
            $totalHarvestValue += $val;
        }

        // --- 3. MARKETING SECTION ---
        $marketingDataRaw = $decodeJson($marketingRaw);
        $standardMarketSpecies = ['Bangus', 'Sugpo', 'Shrimp', 'Others'];

        $marketingData = [];

        foreach ($standardMarketSpecies as $spec) {
            $item = $marketingDataRaw[$spec] ?? $marketingDataRaw[strtolower($spec)] ?? [];

            $localVal = isset($item['local_val']) && $item['local_val'] !== '' ? (float) $item['local_val'] : null;
            $exportVal = isset($item['export_val']) && $item['export_val'] !== '' ? (float) $item['export_val'] : null;

            $marketingData[$spec] = [
                'local_kilos' => $item['local_qty'] ?? '',
                'local_value' => $localVal,
                'export_kilos' => $item['export_qty'] ?? '',
                'export_value' => $exportVal,
            ];
        }

        $customMarketingRows = $marketingDataRaw['custom_rows'] ?? [];

        // --- GENERATE PDF ---
        $pdf = Pdf::loadView('pdf.annual-report', compact(
            'report',
            'pondBreakdown',
            'improvements',
            'financial',
            'workers',
            'items',
            'stocking',
            'customRows',            
            'totalStockCost',
            'harvestData',
            'customHarvestRows',      
            'totalHarvestValue',
            'marketingData',
            'customMarketingRows'     
        ))->setPaper([0, 0, 576, 936], 'portrait');

        return $pdf->stream("Annual_Report_{$report->fla_no}.pdf");
    }
}