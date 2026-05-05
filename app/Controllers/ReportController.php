<?php

require_once __DIR__ . '/../Services/ReportService.php';

class ReportController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new ReportService();
    }

    public function partnerReport()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        if (!is_array($input)) {
            return $this->json([
                'ok' => false,
                'message' => 'Invalid input'
            ]);
        }

        return $this->json(
            $this->service->getPartnerReport($input)
        );
    }

    // 🔥 ADD THIS (for dropdown)
    public function getPartners()
    {
        return $this->json(
            $this->service->getPartnerList()
        );
    }


    public function getGLCodes()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? 0;
        $role = $_SESSION['user']['role_name'] ?? '';

        return $this->json(
            $this->service->getGLCodes($userId, $role)
        );
    }

    public function getMainZones()
    {
        return $this->json(
            $this->service->getMainZones()
        );
    }

    public function getZones()
    {
        $input = $_GET['main_zone'] ?? '';
        return $this->json($this->service->getZones($input));
    }

    public function getRegions()
    {
        $input = $_GET['zone'] ?? '';
        return $this->json($this->service->getRegions($input));
    }

    public function getAreas()
    {
        return $this->json($this->service->getAreas());
    }



    public function getBranches()
    {
        return $this->json(
            $this->service->getBranchList()
        );
    }

    public function getTransactionTypes()
    {
        return $this->json(
            $this->service->getTransactionTypeList()
        );
    }

    public function downloadGLE()
    {
        $input = $_GET;

        $result = $this->service->getPartnerReportForExport($input);

        if (!$result['ok']) {
            echo json_encode($result);
            return;
        }

        $rows = $result['data'] ?? [];
        $type = strtolower($input['type'] ?? 'excel');

        if ($type === 'pdf') {
            $filename = 'GLE_Report_' . date('Ymd_His') . '.pdf';

            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: no-cache, no-store, must-revalidate');
            header('Pragma: no-cache');
            header('Expires: 0');

            echo $this->buildPdfDocument($rows, $input);
            exit;
        }

        $filename = 'GLE_Report_' . date('Ymd_His') . '.xls';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        echo $this->buildHtmlTable($rows, $input);
        exit;
    }

    private function buildHtmlTable($rows, $input = [])
    {
        $headers = [
            'Date Time',
            'GL Code',
            'GL Description',
            'Description',
            'Reference',
            'Entry Number',
            'Currency',
            'Debit',
            'Credit',
            'Transaction Type',
            'Branch ID',
            'Cost Center',
            'Item',
        ];

        $filterLines = $this->buildFilterSummary($input);
        $generatedAt = date('m/d/Y H:i');

        $totalDebit  = 0;
        $totalCredit = 0;
        foreach ($rows as $row) {
            $totalDebit  += floatval($row['debit']  ?? 0);
            $totalCredit += floatval($row['credit'] ?? 0);
        }

        $html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" '
              . 'xmlns:x="urn:schemas-microsoft-com:office:excel" '
              . 'xmlns="http://www.w3.org/TR/REC-html40">';
        $html .= '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
        $html .= '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
        $html .= '<x:Name>GLE Report</x:Name>';
        $html .= '<x:WorksheetOptions>';
        $html .= '<x:Print><x:ValidPrinterInfo/></x:Print>';
        $html .= '</x:WorksheetOptions>';
        $html .= '</x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml>';
        
        $html .= '<style>';
        $html .= 'body { font-family: Arial, sans-serif; }';
        $html .= 'th { background-color:#D50000; color:#FFFFFF; border: 0.5pt solid #000000; font-family: Arial; font-size: 11px; height: 25px; text-align:center; }';
        $html .= 'td { font-family: Arial; font-size: 10px; border: 0.5pt solid #000000; text-align: center; }';
        $html .= '.stat-label { font-size:10px; color:#888; font-weight:bold; }';
        $html .= '.stat-value { font-size:11px; color:#000; font-weight:bold; }';
        $html .= '.stat-value-red { font-size:11px; color:#D50000; font-weight:bold; }';
        $html .= '.filter-label { font-size:11px; color:#666; font-weight:bold; border:none; text-align: left; }';
        $html .= '.filter-value { font-size:11px; color:#D50000; border:none; text-align: left; }';
        $html .= '.title-text { font-size:16px; font-weight:bold; color:#D50000; text-align:center; }';
        $html .= '</style></head><body>';

        $html .= '<table style="border-collapse:collapse;">';

        // ── LINE 1: BLANK ROW (To push everything down) ──
        $html .= '<tr><td colspan="13" style="border:none; height:20px;"></td></tr>';

        // ── LINE 2: TITLE ──
        $html .= '<tr>';
        $html .= '<td colspan="5" style="border:none;"></td>';
        $html .= '<td colspan="2" class="title-text" style="padding:10px 0; border:none;">General Ledger Extraction Report</td>';
        $html .= '<td colspan="6" style="border:none;"></td>';
        $html .= '</tr>';

        // ── LINE 3: STATS BAR ──
        $html .= '<tr>';
        $html .= '<td colspan="4" style="border:none;"></td>'; 
        $html .= '<td style="text-align:center; padding:5px; border:none;"><span class="stat-label">TOTAL RECORDS: </span><span class="stat-value">' . count($rows) . '</span></td>';
        $html .= '<td style="text-align:center; padding:5px; border:none;"><span class="stat-label">TOTAL DEBIT: </span><span class="stat-value">' . number_format($totalDebit, 2) . '</span></td>';
        $html .= '<td style="text-align:center; padding:5px; border:none;"><span class="stat-label">TOTAL CREDIT: </span><span class="stat-value-red">' . number_format($totalCredit, 2) . '</span></td>';
        $html .= '<td style="text-align:center; padding:5px; border:none;"><span class="stat-label">GENERATED: </span><span class="stat-value">' . $generatedAt . '</span></td>';
        $html .= '<td colspan="5" style="border:none;"></td>';
        $html .= '</tr>';

        // ── LINE 4 ONWARDS: VERTICAL FILTERS (Column A and B) ──
        if (!empty($filterLines)) {
            foreach ($filterLines as $label => $value) {
                $html .= '<tr>';
                $html .= '<td class="filter-label" style="border:none;">' . htmlspecialchars($label) . ':</td>';
                $html .= '<td class="filter-value" style="border:none;">' . htmlspecialchars($value) . '</td>';
                $html .= '<td colspan="11" style="border:none;"></td>';
                $html .= '</tr>';
            }
        }

        // Space before table
        $html .= '<tr><td colspan="13" style="border:none; height:10px;"></td></tr>';

        // ── DATA TABLE HEADER ──
        $html .= '<thead><tr>';
        foreach ($headers as $h) {
            $html .= '<th style="background-color:#D50000; color:#FFFFFF; padding:7px 10px; font-weight:bold; white-space:nowrap; text-align:center; border: 0.5pt solid #000000;">' . htmlspecialchars($h) . '</th>';
        }
        $html .= '</tr></thead>';

        // ── DATA ROWS ──
        $html .= '<tbody>';
        if (empty($rows)) {
            $html .= '<tr><td colspan="13" style="padding:20px; text-align:center; color:#ccc;">No records found</td></tr>';
        } else {
            foreach ($rows as $row) {
                $html .= '<tr>';
                $html .= '<td style="padding:5px; border: 0.5pt solid #000000;">' . htmlspecialchars($this->formatDate($row['datetime'] ?? '')) . '</td>';
                $html .= '<td style="padding:5px; border: 0.5pt solid #000000;">' . htmlspecialchars($row['gl_code'] ?? '') . '</td>';
                $html .= '<td style="padding:5px; border: 0.5pt solid #000000;">' . htmlspecialchars($row['gl_desc'] ?? '') . '</td>';
                $html .= '<td style="padding:5px; border: 0.5pt solid #000000;">' . htmlspecialchars($row['desc'] ?? '') . '</td>';
                $html .= '<td style="padding:5px; border: 0.5pt solid #000000;">' . htmlspecialchars($row['reference'] ?? '') . '</td>';
                $html .= '<td style="padding:5px; border: 0.5pt solid #000000;">' . htmlspecialchars($row['entry_number'] ?? '') . '</td>';
                $html .= '<td style="padding:5px; border: 0.5pt solid #000000;">' . htmlspecialchars($row['currency'] ?? '') . '</td>';
                $html .= '<td style="padding:5px; border: 0.5pt solid #000000;">' . htmlspecialchars($this->formatNumber($row['debit'] ?? '')) . '</td>';
                $html .= '<td style="padding:5px; border: 0.5pt solid #000000;">' . htmlspecialchars($this->formatNumber($row['credit'] ?? '')) . '</td>';
                $html .= '<td style="padding:5px; border: 0.5pt solid #000000;">' . htmlspecialchars($row['transaction_type'] ?? '') . '</td>';
                $html .= '<td style="padding:5px; border: 0.5pt solid #000000;">' . htmlspecialchars($row['branch_id'] ?? '') . '</td>';
                $html .= '<td style="padding:5px; border: 0.5pt solid #000000;">' . htmlspecialchars($row['cost_center'] ?? '') . '</td>';
                $html .= '<td style="padding:5px; border: 0.5pt solid #000000;">' . htmlspecialchars($row['item'] ?? '') . '</td>';
                $html .= '</tr>';
            }
        }
        $html .= '</tbody></table></body></html>';

        return $html;
    }

    private function buildPdfDocument($rows, $input = [])
    {
        if (!class_exists('TCPDF')) {
            require_once __DIR__ . '/../../vendor/tecnickcom/tcpdf/tcpdf.php';
        }

        $totalDebit = 0;
        $totalCredit = 0;
        foreach ($rows as $row) {
            $totalDebit += floatval($row['debit'] ?? 0);
            $totalCredit += floatval($row['credit'] ?? 0);
        }

        $filterLines = $this->buildFilterSummary($input);
        $generatedAt = date('m/d/Y H:i');

        $html = '<style>';
        $html .= 'body { font-family: arial,helvetica,sans-serif; font-size: 8pt; }';
        $html .= 'h1 { font-size: 14pt; color: #D50000; margin-bottom: 2px; }';
        $html .= '.stats-container { font-size: 7pt; color: #333; margin-top: 2px; margin-bottom: 10px; }';
        // Added margin-bottom to filters-table to move data table down
        $html .= '.filters-table { margin-bottom: 30px; width: 100%; }';
        $html .= '.filters-table td { padding: 1px 0; font-size: 7pt; }';
        $html .= '.data-table { border-collapse: collapse; width: 100%; }'; 
        $html .= '.data-table th, .data-table td { border: 0.1pt solid #444; padding: 3px; font-size: 6pt; text-align: center; }';
        $html .= '.ref-cell { white-space: nowrap; }';
        $html .= '.no-data { color: #999; text-align: center; padding: 20px; }';
        $html .= '</style>';

        $html .= '<div style="text-align:center;">';
        $html .= '<h1>General Ledger Extraction Report</h1>';
        $html .= '<div class="stats-container">';
        $html .= 'RECORDS: ' . count($rows) . ' &nbsp; | &nbsp; ';
        $html .= 'DEBIT: ' . number_format($totalDebit, 2) . ' &nbsp; | &nbsp; ';
        $html .= 'CREDIT: ' . number_format($totalCredit, 2) . ' &nbsp; | &nbsp; ';
        $html .= 'GENERATED: ' . $generatedAt;
        $html .= '</div>';
        $html .= '</div>';

        if (!empty($filterLines)) {
            $html .= '<table class="filters-table">';
            foreach ($filterLines as $label => $value) {
                $html .= '<tr>';
                $html .= '<td style="width:15%; font-weight:bold;">' . htmlspecialchars($label) . ':</td>'; 
                $html .= '<td style="width:85%;">' . htmlspecialchars($value) . '</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
        }
        
        // Added more breaks for extra downward clearance
        $html .= '<br><br><br>';

        $w = [
            'dt' => '9%', 'gc' => '6%', 'gd' => '10%', 'de' => '10%', 'rf' => '13%', 
            'en' => '10%', 'cu' => '4%', 'db' => '7%', 'cr' => '7%', 'ty' => '8%', 
            'br' => '5%', 'cc' => '6%', 'it' => '5%'
        ];

        $html .= '<table class="data-table" cellpadding="2">';
        $html .= '<thead><tr>';
        $html .= '<th style="width:'.$w['dt'].'; background-color:#D50000; color:#FFFFFF; font-weight:bold;">Date Time</th>';
        $html .= '<th style="width:'.$w['gc'].'; background-color:#D50000; color:#FFFFFF; font-weight:bold;">GL Code</th>';
        $html .= '<th style="width:'.$w['gd'].'; background-color:#D50000; color:#FFFFFF; font-weight:bold;">GL Description</th>';
        $html .= '<th style="width:'.$w['de'].'; background-color:#D50000; color:#FFFFFF; font-weight:bold;">Description</th>';
        $html .= '<th style="width:'.$w['rf'].'; background-color:#D50000; color:#FFFFFF; font-weight:bold;">Reference</th>';
        $html .= '<th style="width:'.$w['en'].'; background-color:#D50000; color:#FFFFFF; font-weight:bold;">Entry Number</th>';
        $html .= '<th style="width:'.$w['cu'].'; background-color:#D50000; color:#FFFFFF; font-weight:bold;">Cur</th>';
        $html .= '<th style="width:'.$w['db'].'; background-color:#D50000; color:#FFFFFF; font-weight:bold;">Debit</th>';
        $html .= '<th style="width:'.$w['cr'].'; background-color:#D50000; color:#FFFFFF; font-weight:bold;">Credit</th>';
        $html .= '<th style="width:'.$w['ty'].'; background-color:#D50000; color:#FFFFFF; font-weight:bold;">Transaction Type</th>';
        $html .= '<th style="width:'.$w['br'].'; background-color:#D50000; color:#FFFFFF; font-weight:bold;">Branch</th>';
        $html .= '<th style="width:'.$w['cc'].'; background-color:#D50000; color:#FFFFFF; font-weight:bold;">Cost Center</th>';
        $html .= '<th style="width:'.$w['it'].'; background-color:#D50000; color:#FFFFFF; font-weight:bold;">Item</th>';
        $html .= '</tr></thead>';

        $html .= '<tbody>';
        if (empty($rows)) {
            $html .= '<tr><td class="no-data" colspan="13">No records found</td></tr>';
        } else {
            foreach ($rows as $row) {
                $html .= '<tr>';
                $html .= '<td style="width:'.$w['dt'].';">' . htmlspecialchars($this->formatDate($row['datetime'] ?? '')) . '</td>';
                $html .= '<td style="width:'.$w['gc'].';">' . htmlspecialchars($row['gl_code'] ?? '') . '</td>';
                $html .= '<td style="width:'.$w['gd'].';">' . htmlspecialchars($row['gl_desc'] ?? '') . '</td>';
                $html .= '<td style="width:'.$w['de'].';">' . htmlspecialchars($row['desc'] ?? '') . '</td>';
                $html .= '<td style="width:'.$w['rf'].';" class="ref-cell">' . htmlspecialchars($row['reference'] ?? '') . '</td>';
                $html .= '<td style="width:'.$w['en'].';">' . htmlspecialchars($row['entry_number'] ?? '') . '</td>';
                $html .= '<td style="width:'.$w['cu'].';">' . htmlspecialchars($row['currency'] ?? '') . '</td>';
                $html .= '<td style="width:'.$w['db'].';">' . htmlspecialchars($this->formatNumber($row['debit'] ?? '')) . '</td>';
                $html .= '<td style="width:'.$w['cr'].';">' . htmlspecialchars($this->formatNumber($row['credit'] ?? '')) . '</td>';
                $html .= '<td style="width:'.$w['ty'].';">' . htmlspecialchars($row['transaction_type'] ?? '') . '</td>';
                $html .= '<td style="width:'.$w['br'].';">' . htmlspecialchars($row['branch_id'] ?? '') . '</td>';
                $html .= '<td style="width:'.$w['cc'].';">' . htmlspecialchars($row['cost_center'] ?? '') . '</td>';
                $html .= '<td style="width:'.$w['it'].';">' . htmlspecialchars($row['item'] ?? '') . '</td>';
                $html .= '</tr>';
            }
        }
        $html .= '</tbody></table>';

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('GLCS');
        $pdf->SetTitle('General Ledger Extraction Report');
        $pdf->SetSubject('General Ledger Extraction Report');
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');

        return $pdf->Output('', 'S');
    }

    private function buildFilterSummary($input)
    {
        $labels = [
            'partner'          => 'Partner',
            'gl_code'          => 'GL Code',
            'date_from'        => 'Date From',
            'date_to'          => 'Date To',
            'main_zone'        => 'Main Zone',
            'zone'             => 'Zone',
            'region'           => 'Region',
            'area'             => 'Area',
            'branch'           => 'Branch',
            'transaction_type' => 'Transaction Type',
            'currency'         => 'Currency',
        ];

        $filters = [];
        foreach ($labels as $key => $label) {
            if (!empty($input[$key])) {
                $val = $input[$key];
                if (($key === 'date_from' || $key === 'date_to') && preg_match('/^\d{4}-\d{2}-\d{2}$/', $val)) {
                    $val = date('M d, Y', strtotime($val));
                }
                $filters[$label] = $val;
            }
        }
        return $filters;
    }

    private function formatDate($datetime)
    {
        if (!$datetime) return '';
        $d = new DateTime($datetime);
        return $d->format('m/d/Y H:i');
    }

    private function formatNumber($value)
    {
        if ($value === '' || $value === null) return '';
        $num = floatval($value);
        return number_format($num, 2, '.', ',');
    }
}