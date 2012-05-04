<?php

App::import('Vendor', 'PHPExcel', array('file' => 'excel/Classes/PHPExcel.php'));
App::import('Vendor', 'PHPExcelWriter', array('file' => 'excel/Classes/PHPExcel/Writer/Excel2007.php'));

class ExcelHelper extends AppHelper {

    var $xls;
    var $sheet;
    var $data;
    var $blacklist = array();
    var $fila;
    var $col;

    function excelHelper() {
        $this->xls = new PHPExcel();
        $this->sheet = $this->xls->getActiveSheet();
        $this->sheet->getDefaultStyle()->getFont()->setName('Arial');
        $this->sheet->getDefaultStyle()->getFont()->setSize(10);
        $this->sheet->getPageSetup()->setFitToPage(true);
        $this->sheet->getDefaultStyle()->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );
    }

    function generate(&$data, $title = 'Report') {
        $this->data = & $data;
        $this->_title($title);
        $this->_headers();
        $this->_rows();
        $this->_output($title);
        return true;
    }
        
    function _title($title) {
      $this->sheet->setTitle($title);
    } 

    function _headers() {
        $i = 0;
        foreach ($this->data[0] as $field => $value) {
            if (!in_array($field, $this->blacklist)) {
                $columnName = Inflector::humanize($field);
                $this->sheet->setCellValueByColumnAndRow($i++, 4, $columnName);
            }
        }
        $this->sheet->getStyle('A4')->getFont()->setBold(true);
        $this->sheet->getStyle('A4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $this->sheet->getStyle('A4')->getFill()->getStartColor()->setRGB('969696');
        $this->sheet->duplicateStyle($this->sheet->getStyle('A4'), 'B4:' . $this->sheet->getHighestColumn() . '4');
        for ($j = 1; $j < $i; $j++) {
            $this->sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($j))->setAutoSize(true);
        }
    }

    function _rows() {
        $i = 5;
        foreach ($this->data as $row) {
            $j = 0;
            foreach ($row as $field => $value) {
                if (!in_array($field, $this->blacklist)) {
                    $this->sheet->setCellValueByColumnAndRow($j++, $i, $value);
                }
            }
            $i++;
        }
    }

    function _output($title) {
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment;filename="' . $title . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel5($this->xls);
        $objWriter->setTempDir(TMP);
        $objWriter->save('php://output');
    }
    
    function _centrarTexto($celda){
        $this->sheet->getStyle($celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }
    
    function _formatoNumero($celda) {
        $this->sheet->getStyle($celda)->getNumberFormat()->setFormatCode('#,##0.00');
    }
    
    function _logos() {

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setPath('./img/GobiernoBolivariano.jpg');
        $objDrawing->setHeight(30);
        $objDrawing->setWidth(720);

        $objDrawing->setWorksheet($this->xls->getActiveSheet());
    }

    function _AgregarImagen($celda, $ruta, $offset) {
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath($ruta);
        $objDrawing->setWidth(180);
        $objDrawing->setHeight(180);
        $objDrawing->setResizeProportional(true);
        $objDrawing->setCoordinates($celda);
        $objDrawing->setOffsetX($offset);
        $objDrawing->setWorksheet($this->xls->getActiveSheet());
    }

    function _unir($celda) {
        $this->sheet->mergeCells($celda);
    }

    function _color($celda) {
        $this->sheet->getStyle($celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('d4d6fc');
    }    

    function _campo($pos, $title) {
        $this->sheet->setCellValue($pos, $title);
    }    

    function _formatoTexto($texto, $formato) {
        
    }

    function _borde($celda) {
        $this->sheet->getStyle($celda)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $this->sheet->getStyle($celda)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $this->sheet->getStyle($celda)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $this->sheet->getStyle($celda)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    }

    function _addField($valor, $i, $j) {
        $this->sheet->setCellValueByColumnAndRow($j, $i, $valor);
    }

    function _texto($col, $tam, $estilo) {
        $this->sheet->getStyle($col)->getFont()->setName('Arial');
        $this->sheet->getStyle($col)->getFont()->setSize($tam);
        $this->sheet->getStyle($col)->getFont()->setBold(true);
    }

    function _anchoFila($fila, $tam) {
        $this->sheet->getRowDimension($fila)->setRowHeight($tam);
    }

    function _anchoColumna($col, $tam) {
        $this->sheet->getStyle($col)->getAlignment()->setWrapText(true);
        $this->sheet->getColumnDimension($col)->setWidth($tam);
    }

    function _formatoColumna($col, $tipo) {
        if ($tipo == 1)
            $this->sheet->getStyle($col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD);
        if ($tipo == 2)
            $this->sheet->getStyle($col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    }

}

