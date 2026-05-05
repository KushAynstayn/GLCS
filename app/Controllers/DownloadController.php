<?php

require_once __DIR__ . '/../Core/Controller.php';
// You will need to create a GLModel or similar to fetch the actual data
// require_once __DIR__ . '/../Models/GLModel.php'; 

class DownloadController extends Controller {

    /**
     * Entry point for download requests
     * Example URL: index.php?api=gl-download&type=excel
     */
    public function download() {
        $type = $_GET['type'] ?? 'excel';
        $source = $_GET['source'] ?? 'gl_settings'; // To distinguish between settings or reports

        // 1. Fetch Data (Replace this with a call to your Model)
        $data = $this->fetchData($source);

        if (empty($data)) {
            die("No data available to download.");
        }

        // 2. Route to specific format handler
        if ($type === 'pdf') {
            $this->generatePDF($data, $source);
        } else {
            $this->generateExcel($data, $source);
        }
    }

    private function fetchData($source) {
        // Logic to fetch data from database based on the source
        // For now, returning dummy data to demonstrate the structure
        return [
            ['GL Account' => '1010', 'Title' => 'Cash', 'Status' => 'Active'],
            ['GL Account' => '1020', 'Title' => 'Accounts Receivable', 'Status' => 'Active'],
        ];
    }

    private function generateExcel($data, $filename) {
        // Set headers to force download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '_' . date('Ymd') . '.xls"');
        header('Cache-Control: max-age=0');

        // Simple HTML Table format that Excel understands
        echo "<table border='1'>";
        // Headers
        echo "<tr>";
        foreach (array_keys($data[0]) as $column) {
            echo "<th style='background-color: #D50000; color: white;'>$column</th>";
        }
        echo "</tr>";

        // Body
        foreach ($data as $row) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>$cell</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        exit;
    }

    private function generatePDF($data, $filename) {
        // Note: For real PDF generation, you should use a library like Dompdf or TCPDF.
        // Below is a simple implementation concept.
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="' . $filename . '_' . date('Ymd') . '.pdf"');
        
        echo "PDF Generation logic requires a library (e.g., Dompdf).";
        // Example with Dompdf (if installed via composer):
        // $dompdf = new \Dompdf\Dompdf();
        // $dompdf->loadHtml($html_content);
        // $dompdf->render();
        // $dompdf->stream($filename);
        exit;
    }
}