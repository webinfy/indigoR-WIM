<?php

include __DIR__ . '/vendor/autoload.php';

function inputText($value) {
    $value = trim($value);
    $value = addslashes($value);
    $value = mysql_real_escape_string($value);
    $value = str_replace("<", "&lt;", $value);
    $value = str_replace(">", "&gt;", $value);
    return "'" . $value . "'";
}

function getExcelContents($inputFileName) {
    //  $inputFileName = 'files/example_feed_xls.xls';
    //  Read your Excel workbook
    $ext = pathinfo($inputFileName, PATHINFO_EXTENSION);
    if (empty($inputFileName)) {
        return FALSE;
    } else if (!file_exists($inputFileName)) {
        return FALSE;
    } else if (!in_array($ext, array('xls', 'xlsx', 'csv'))) {
        return FALSE;
    } else {
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }
//  Get worksheet dimensions
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

//  Loop through each row of the worksheet in turn
        $dataArr = [];
        $getHeading = $sheet->rangeToArray('A' . 1 . ':' . $highestColumn . 1, NULL, TRUE, FALSE);
        $dataArr['heading'] = $getHeading[0];
        for ($row = 2; $row <= $highestRow; $row++) {
            //  Read a row of data into an array
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
//            foreach ($rowData[0] as $col) {
//                $temp[] = inputText($col);
//            }
//            $dataArr[] = $temp;

            $data[] = $rowData[0];
        }
        $dataArr['data'] = $data;
        return $dataArr;
    }
}

function downloadReport($payments, $fileDetail) {

    $customFields = json_decode($fileDetail->custom_fields);

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);

    $style = [
        'alignment' => [
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ]
    ];

    $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle("A1:J1")->applyFromArray($style);
//    $objPHPExcel->getActiveSheet()->getColumnDimension("A1:J1")->setAutoSize(true);

    foreach (range('A', 'J') as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }



    ///SetHeading//

    $head = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S'];
    $count = 0;
    $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', "Name");
    $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', "Email");
    $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', "Phone");
    foreach ($customFields as $key => $value) {
        $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', $value);
    }
    $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', "Total");
    $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', "Due Date");
    $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', "Status");
    $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', "Payment Date");
    //Set Content
    $rowCount = 2;
    $total = count($payments);
    for ($i = 0; $i < $total; $i++) {
        $count = -1;
        $objPHPExcel->getActiveSheet()->SetCellValue($head[++$count] . $rowCount, $payments[$i]['name']);
        $objPHPExcel->getActiveSheet()->SetCellValue($head[++$count] . $rowCount, $payments[$i]['email']);
        $objPHPExcel->getActiveSheet()->SetCellValue($head[++$count] . $rowCount, " " . $payments[$i]['phone']);
        $customFieldValues = json_decode($payments[$i]['custom_fields']);
        foreach ($customFields as $key => $value) {
            $objPHPExcel->getActiveSheet()->SetCellValue($head[++$count] . $rowCount, $customFieldValues->$key);
        }
        $objPHPExcel->getActiveSheet()->SetCellValue($head[++$count] . $rowCount, $payments[$i]['total_fee']);

        $objPHPExcel->getActiveSheet()->SetCellValue($head[++$count] . $rowCount, $payments[$i]['due_date']);
        $objPHPExcel->getActiveSheet()->getStyle($head[$count] . $rowCount)->applyFromArray($style);

        $objPHPExcel->getActiveSheet()->SetCellValue($head[++$count] . $rowCount, ($payments[$i]['status'] == 1) ? 'Paid' : 'Unpaid');
        $objPHPExcel->getActiveSheet()->getStyle($head[$count] . $rowCount)->applyFromArray($style);

        $objPHPExcel->getActiveSheet()->SetCellValue($head[++$count] . $rowCount, !empty($payments[$i]['payment_date']) ? $payments[$i]['payment_date'] : "");
        $objPHPExcel->getActiveSheet()->getStyle($head[$count] . $rowCount)->applyFromArray($style);

        $rowCount++;
    }
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $filename = "Payemnt-report.xlsx";
    $objWriter->save("temp_excel/$filename");
    return $filename;
}

function downloadCustomerReport($payments, $fileDetail) {

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);

    $style = [
        'alignment' => [
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ]
    ];

    $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle("A1:F1")->applyFromArray($style);
    foreach (range('A', 'F') as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }


    $head = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S'];
    $count = 0;

    ///SetHeading//
    $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', "Name");
    $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', "Email");
    $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', "Phone");
    $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', "Total");
    $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', "Status");
    $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', "Payment Date");
    //Set Content
    $rowCount = 2;
    $total = count($payments);
    for ($i = 0; $i < $total; $i++) {
        $count = -1;
        $objPHPExcel->getActiveSheet()->SetCellValue($head[++$count] . $rowCount, $payments[$i]['name']);
        $objPHPExcel->getActiveSheet()->SetCellValue($head[++$count] . $rowCount, $payments[$i]['email']);
        $objPHPExcel->getActiveSheet()->SetCellValue($head[++$count] . $rowCount, $payments[$i]['phone']);
        $objPHPExcel->getActiveSheet()->SetCellValue($head[++$count] . $rowCount, $payments[$i]['total_fee']);

        $objPHPExcel->getActiveSheet()->SetCellValue($head[++$count] . $rowCount, ($payments[$i]['status'] == 1) ? 'Paid' : 'Unpaid');
        $objPHPExcel->getActiveSheet()->getStyle($head[$count] . $rowCount)->applyFromArray($style);

        $objPHPExcel->getActiveSheet()->SetCellValue($head[++$count] . $rowCount, $payments[$i]['payment_date']);
        $objPHPExcel->getActiveSheet()->getStyle($head[$count] . $rowCount)->applyFromArray($style);

        $rowCount++;
    }
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $filename = "Payemnt-report.xlsx";
    $objWriter->save("temp_excel/$filename");
    return $filename;
}

function importExcel($filePath) {
    $excelData = array();
    if ($filePath) {
        $objPHPExcel = PHPExcel_IOFactory::load($filePath);
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle = $worksheet->getTitle();
            $highestRow = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;
            $data = array();
            for ($row = 1; $row <= $highestRow; ++$row) {
                $values = array();
                for ($col = 0; $col < $highestColumnIndex; ++$col) {
                    $cell = $worksheet->getCellByColumnAndRow($col, $row);
                    $val = $cell->getValue();
                    if (isset($val) && $val)
                        $data[$row][$col] = $val;
                }
            }
            $excelData[$worksheetTitle] = $data;
        }
        return $excelData;
    }
    return FALSE;
}
