<?php
    function CalculatTotal($markArray) {
        // total
        $total = 0;
        for($i = 0; $i < count($markArray); $i++){
            if($markArray[$i] != 'A'){
                $total = $total + (int) $markArray[$i];
            }
        }
        return $total;
    }

    function CalculatResult($markArray) {
        // result
        $studentResult;
        for($i = 0; $i < count($markArray); $i++) {
            if(!($markArray[$i] > 34) or $markArray[$i] == 'A') {
                $studentResult = 'FAIL';
                break;
            } else {
                $studentResult = 'PASS';
            }
        }
        return $studentResult;
    }

    function CheckAvalibility($array, $element) {
        $elementExist = false;
        for($i = 0; $i < count($array); $i++) {
            if($array[$i] == $element) {
                $elementExist = true;
            }
        }
        return $elementExist;
    }

    function change_key($arr, $oldkey, $newkey) {
        $array = json_encode($arr);
        $replace = str_replace($oldkey, $newkey, $array);
        return json_decode($replace);
    }

    function assignRank($exam, $class, $datas) {
        // rank
        $existingData = $datas;
        $studentRank = 1;
        $excludeIndex = [];
        $largestNumber = 0;
        $largestNumberIndex = 0;
        $sameRank = false;
        for($i = 0; $i < count($existingData["results"][$exam][$class]); $i++) {
            for($j = 0; $j < count($existingData["results"][$exam][$class]); $j++) {
                if(count($excludeIndex) > 0) {
                    if(CheckAvalibility($excludeIndex, $j) == false and $existingData["results"][$exam][$class][$j]['result'] == 'PASS') {
                        if($largestNumber <= $existingData["results"][$exam][$class][$j]['total']) {
                            if ($largestNumber == $existingData["results"][$exam][$class][$j]['total']) {
                                $sameRank = true;
                            } else {
                                $sameRank = false;
                            }
                            $largestNumber = $existingData["results"][$exam][$class][$j]['total'];
                            $largestNumberIndex = $j;
                        }
                    }
                } elseif($existingData["results"][$exam][$class][$j]['result'] == 'PASS') {
                    if($largestNumber <= $existingData["results"][$exam][$class][$j]['total']) {
                        if ($largestNumber == $existingData["results"][$exam][$class][$j]['total']) {
                            $sameRank = true;
                        } else {
                            $sameRank = false;
                        }
                        $largestNumber = $existingData["results"][$exam][$class][$j]['total'];
                        $largestNumberIndex = $j;
                    }
                }
            }
            if($existingData["results"][$exam][$class][$i]['result'] == 'PASS' and CheckAvalibility($excludeIndex, $largestNumberIndex) == false) {
                array_push($excludeIndex, $largestNumberIndex);
                $existingData["results"][$exam][$class][$largestNumberIndex]['rank'] = $studentRank;
                if($sameRank == false){$studentRank++;}
                $largestNumber = 0;
            } elseif ($existingData["results"][$exam][$class][$i]['result'] == 'FAIL') {
                $existingData["results"][$exam][$class][$i]['rank'] = 'FAIL';
                $largestNumber = 0;
                array_push($excludeIndex, $i);
            }
        }
        return $existingData;
    }
    if(isset($_POST)){
        $postDataString = file_get_contents("php://input");
        $getData = json_decode($postDataString, true);
        if(isset($getData['oldSub']) and isset($getData['newSub'])){
            $postData = array();
            $rawData = file_get_contents("database/datas.json");
            $existingData = json_decode($rawData, true);
            for($i = 0; $i < count($existingData['subjectcombs']); $i++){
                for($j = 0; $j < count($existingData['subjectcombs'][$i]['subjects']); $j++) {
                    if($existingData['subjectcombs'][$i]['subjects'][$j] == $getData['oldSub']) {
                        $existingData['subjectcombs'][$i]['subjects'][$j] = $getData['newSub'];
                    }
                }
            }
            $dataFile = fopen("database/datas.json", 'w+');
            fwrite($dataFile, json_encode($existingData));
            fclose($dataFile);
        } elseif(isset($getData['oldClass']) and isset($getData['newClass']) and isset($getData['array_index']) and isset($getData['column'])) {
            $postData = array();
            $rawData = file_get_contents("database/datas.json");
            $existingData = json_decode($rawData, true);
            if($getData['column'] == 'class') {
                $oldClassName = $getData['oldClass']." - ".$existingData['classes'][$getData['array_index']]['section'];
            } else {
                $oldClassName = $existingData['classes'][$getData['array_index']]['class']." - ".$getData['oldClass'];
            }
            $newClassName = $existingData['classes'][$getData['array_index']]['class']." - ".$existingData['classes'][$getData['array_index']]['section'];
            for($i = 0; $i < count($existingData['students']); $i++){
                if($existingData['students'][$i]['class'] == $oldClassName) {
                    $existingData['students'][$i]['class'] = $newClassName;
                }
            }
            for($i = 0; $i < count($existingData['subjectcombs']); $i++){
                if($existingData['subjectcombs'][$i]['class'] == $oldClassName) {
                    $existingData['subjectcombs'][$i]['class'] = $newClassName;
                }
            }
            for($i = 0; $i < count($existingData['staffclasses']); $i++){
                for($j = 0; $j < count($existingData['staffclasses'][$i]['classes']); $j++) {
                    if($existingData['staffclasses'][$i]['classes'][$j] == $oldClassName) {
                        $existingData['staffclasses'][$i]['classes'][$j] = $newClassName;
                    }
                }
            }
            foreach($existingData['results'] as $key => $value) {
                $existingData['results'][$key] = change_key($existingData['results'][$key], $oldClassName, $newClassName);
            }
            $dataFile = fopen("database/datas.json", 'w+');
            fwrite($dataFile, json_encode($existingData));
            fclose($dataFile);
        } elseif (isset($getData['oldStaffData']) and isset($getData['newStaffData']) and isset($getData['array_index']) and isset($getData['column'])) {
            $postData = array();
            $rawData = file_get_contents("database/datas.json");
            $existingData = json_decode($rawData, true);
            for($i = 0; $i < count($existingData['staffclasses']); $i++){
                if($existingData['staffclasses'][$i]['staffname'] == $getData['oldStaffData']) {
                    $existingData['staffclasses'][$i]['staffname'] = $getData['newStaffData'];
                }
            }
            $dataFile = fopen("database/datas.json", 'w+');
            fwrite($dataFile, json_encode($existingData));
            fclose($dataFile);
        } elseif (isset($getData['resultExam']) and isset($getData['resultClass'])) {
            $rawData = file_get_contents("database/datas.json");
            $existingData = json_decode($rawData, true);
            $studentMarks = $existingData['results'][$getData['resultExam']][$getData['resultClass']][$getData['array_index']][$getData['column']];
            for($i = 0; $i < count($studentMarks); $i++) {
                if($studentMarks[$i] != 'A') {
                    $studentMarks[$i] = (int)$studentMarks[$i];
                }
            }
            $existingData['results'][$getData['resultExam']][$getData['resultClass']][$getData['array_index']][$getData['column']] = $studentMarks;
            $existingData['results'][$getData['resultExam']][$getData['resultClass']][$getData['array_index']]['total'] = CalculatTotal($studentMarks);
            $existingData['results'][$getData['resultExam']][$getData['resultClass']][$getData['array_index']]['result'] = CalculatResult($studentMarks);
            $existingData = assignRank($getData['resultExam'], $getData['resultClass'], $existingData);
            $dataFile = fopen("database/datas.json", 'w+');
            fwrite($dataFile, json_encode($existingData));
            fclose($dataFile);
            echo '{"Status":'.json_encode($existingData).'}';
        } elseif (isset($getData['oldSch'])) {
            $rawData = file_get_contents("database/datas.json");
            $existingData = json_decode($rawData, true);
            for($i = 0; $i < count($existingData['students']); $i++) {
                if($existingData['students'][$i]['school'] == $getData['oldSch']) {
                    $existingData['students'][$i]['school'] = $getData['newSch'];
                }
            }
            for($i = 0; $i < count($existingData['schoolexams']); $i++) {
                if($existingData['schoolexams'][$i]['school'] == $getData['oldSch']) {
                    $existingData['schoolexams'][$i]['school'] = $getData['newSch'];
                }
            }
            for($i = 0; $i < count($existingData['staffs']); $i++) {
                if($existingData['staffs'][$i]['schoolid'] == $getData['oldSch']) {
                    $existingData['staffs'][$i]['schoolid'] = $getData['newSch'];
                }
            }
            $dataFile = fopen("database/datas.json", 'w+');
            fwrite($dataFile, json_encode($existingData));
            fclose($dataFile);
        }
    }
?>