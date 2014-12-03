<?php

class Render {
    
    public static function instantiate()
    {
        $obj = new PHPExcel();
    
        $obj->getProperties()
            ->setCreator("Piotr Kubisa")
            ->setLastModifiedBy("Piotr Kubisa")
            ->setTitle("USA - Highscores raport")
            ->setSubject("USA - Highscores raport")
            ->setDescription("Table within scores from point out US State on the map.")
            ->setKeywords("usa game scores tigeb")
            ->setCategory("Project for TIGEB at University of Economics in Katowice.");

        return $obj;
    }
    
    public static function fillData($obj)
    {
        $obj->setActiveSheetIndex(0)->setTitle('Scores - 5');
        $data = Score::getByTargetPoints(5, false);
        $activeSheet = $obj->setActiveSheetIndex(0);
        $activeSheet->setCellValue('A1', 'username');
        $activeSheet->setCellValue('B1', 'guesses');
        $activeSheet->setCellValue('C1', 'time_diff');
        $activeSheet->setCellValue('D1', 'start_date');
        $activeSheet->setCellValue('E1', 'end_date');
        $activeSheet->getStyle("A1:E1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle("A1:E1")->getFont()->setBold(true);
        $activeSheet->getStyle("A1:E1")->getAlignment()->setIndent(1);
        foreach($data as $idx => $val) {
            $activeSheet->setCellValue('A' . ((int)$idx+2), $val['username']);
            $activeSheet->setCellValue('B' . ((int)$idx+2), $val['guesses']);
            $activeSheet->setCellValue('C' . ((int)$idx+2), $val['time_diff']);
            $activeSheet->setCellValue('D' . ((int)$idx+2), $val['start_date']);
            $activeSheet->setCellValue('E' . ((int)$idx+2), $val['end_date']);
        }
        
        $data = Score::getByTargetPoints(10, false);
        $obj->createSheet(1);
        $obj->setActiveSheetIndex(1)->setTitle('Scores - 10');
        $activeSheet = $obj->setActiveSheetIndex(1);
        $activeSheet->setCellValue('A1', 'username');
        $activeSheet->setCellValue('B1', 'guesses');
        $activeSheet->setCellValue('C1', 'time_diff');
        $activeSheet->setCellValue('D1', 'start_date');
        $activeSheet->setCellValue('E1', 'end_date');
        $activeSheet->getStyle("A1:E1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle("A1:E1")->getFont()->setBold(true);
        $activeSheet->getStyle("A1:E1")->getAlignment()->setIndent(1);
        foreach($data as $idx => $val) {
            $activeSheet->setCellValue('A' . ((int)$idx+2), $val['username']);
            $activeSheet->setCellValue('B' . ((int)$idx+2), $val['guesses']);
            $activeSheet->setCellValue('C' . ((int)$idx+2), $val['time_diff']);
            $activeSheet->setCellValue('D' . ((int)$idx+2), $val['start_date']);
            $activeSheet->setCellValue('E' . ((int)$idx+2), $val['end_date']);
        }
        
        $data = Score::getByTargetPoints(50, false);
        $obj->createSheet(2);
        $obj->setActiveSheetIndex(2)->setTitle('Scores - 50');
        $activeSheet = $obj->setActiveSheetIndex(2);
        $activeSheet->setCellValue('A1', 'username');
        $activeSheet->setCellValue('B1', 'guesses');
        $activeSheet->setCellValue('C1', 'time_diff');
        $activeSheet->setCellValue('D1', 'start_date');
        $activeSheet->setCellValue('E1', 'end_date');
        $activeSheet->getStyle("A1:E1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle("A1:E1")->getFont()->setBold(true);
        $activeSheet->getStyle("A1:E1")->getAlignment()->setIndent(1);
        foreach($data as $idx => $val) {
            $activeSheet->setCellValue('A' . ((int)$idx+2), $val['username']);
            $activeSheet->setCellValue('B' . ((int)$idx+2), $val['guesses']);
            $activeSheet->setCellValue('C' . ((int)$idx+2), $val['time_diff']);
            $activeSheet->setCellValue('D' . ((int)$idx+2), $val['start_date']);
            $activeSheet->setCellValue('E' . ((int)$idx+2), $val['end_date']);
        }   
        
        return $obj;
    }
    
    public static function fillDataBreak($obj)
    {
        $obj->setActiveSheetIndex(0)->setTitle('Scores - 5');
        $data = Score::prepare()->get()->take(1000);
        $activeSheet = $obj->setActiveSheetIndex(0);
        $activeSheet->setCellValue('A1', '- Username -');
        $activeSheet->setCellValue('B1', '- Guesses -');
        $activeSheet->setCellValue('C1', '- States to point out -');
        $activeSheet->setCellValue('D1', '- TimeDiff -');
        $activeSheet->setCellValue('E1', '- StartDate -');
        $activeSheet->setCellValue('F1', '- EndDate -');
        $activeSheet->getStyle("A1:F1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle("A1:F1")->getFont()->setBold(true);
        $activeSheet->getStyle("A1:F1")->getAlignment()->setIndent(1);
        $activeSheet->getColumnDimension('A')->setWidth(20);
        $activeSheet->getColumnDimension('B')->setWidth(20);
        $activeSheet->getColumnDimension('C')->setWidth(20);
        $activeSheet->getColumnDimension('D')->setWidth(20);
        $activeSheet->getColumnDimension('E')->setWidth(20);
        $activeSheet->getColumnDimension('F')->setWidth(20);
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $obj->getDefaultStyle()->applyFromArray($styleArray);
        $activeSheet->getStyle('A1:F1')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'EDEDED')
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
        foreach($data as $idx => $val) {
            $activeSheet->setCellValue('A' . ((int)$idx+2), $val['username']);
            $activeSheet->setCellValue('B' . ((int)$idx+2), $val['guesses']);
            $activeSheet->getStyle('B' . ((int)$idx+2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $activeSheet->setCellValue('C' . ((int)$idx+2), $val['points_to_check']);
            $activeSheet->getStyle('C' . ((int)$idx+2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $activeSheet->setCellValue('D' . ((int)$idx+2), $val['time_diff']);
            $activeSheet->setCellValue('E' . ((int)$idx+2), $val['start_date']);
            $activeSheet->setCellValue('F' . ((int)$idx+2), $val['end_date']);
        }
        

        return $obj;
    }
}

    
