<?php
    $existingData = array();
    $existingData["results"] = array();
    $existingData["results"]["Test1"] = array();
    $existingData["results"]["Test1"]["X - A"] = [];
    array_push($existingData["results"]["Test1"]["X - A"], array('total' => 450, 'result' => "PASS"));
    array_push($existingData["results"]["Test1"]["X - A"], array('total' => 500, 'result' => "FAIL"));
    array_push($existingData["results"]["Test1"]["X - A"], array('total' => 490, 'result' => "PASS"));
    array_push($existingData["results"]["Test1"]["X - A"], array('total' => 491, 'result' => "PASS"));
    $t = "Test1";
    $c = "X - A";
    function CheckAvalibility($array, $element) {
        $elementExist = false;
        for($i = 0; $i < count($array); $i++) {
            if($array[$i] == $element) {
                $elementExist = true;
            }
        }
        return $elementExist;
    }
    function assignRank($exam, $class, $datas) {
        // rank
        $existingData = $datas;
        $studentRank = 1;
        $excludeIndex = [];
        $largestNumber = 0;
        $largestNumberIndex = 0;
        for($i = 0; $i < count($existingData["results"][$exam][$class]); $i++) {
            for($j = 0; $j < count($existingData["results"][$exam][$class]); $j++) {
                if(count($excludeIndex) > 0) {
                    if(CheckAvalibility($excludeIndex, $j) == false) {
                        if($largestNumber <= $existingData["results"][$exam][$class][$j]['total']) {
                            $largestNumber = $existingData["results"][$exam][$class][$j]['total'];
                            $largestNumberIndex = $j;
                        }
                    }
                } else {
                    if($largestNumber <= $existingData["results"][$exam][$class][$j]['total']) {
                        $largestNumber = $existingData["results"][$exam][$class][$j]['total'];
                        $largestNumberIndex = $j;
                    }
                }
            }
            if($existingData["results"][$exam][$class][$largestNumberIndex]['result'] == 'PASS' and CheckAvalibility($excludeIndex, $largestNumberIndex) == false) {
                array_push($excludeIndex, $largestNumberIndex);
                $existingData["results"][$exam][$class][$largestNumberIndex]['rank'] = $studentRank;
                $studentRank++;
                $largestNumber = 0;
            } elseif ($existingData["results"][$exam][$class][$largestNumberIndex]['result'] == 'FAIL') {
                $existingData["results"][$exam][$class][$largestNumberIndex]['rank'] = 'FAIL';
                $largestNumber = 0;
                array_push($excludeIndex, $largestNumberIndex);
            }
        }
        return $existingData;
    }
    echo "<br>";
    echo json_encode(assignRank($t, $c, $existingData));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="table.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Table</title>
</head>
<body>
    <div class="table-container">
        <div class="tab_head_container">
            <div class="page_limit">
                <span contenteditable="true" >Number of Rows:</span>
                <select name="" id="rows_per_tab" onchange="DeclarRowPerTab(parseInt(this.value))">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="250">250</option>
                </select>
            </div>
            <div class="table_row_filter">
                <span>Search:</span>
                <input type="text" name="" id="table_row_filter_key">
            </div>
        </div>
        <table class="table">
            <thead>
                <th colName="no">SNo<span></span></th>
                <th colName="sno">SNo<span></span></th>
                <th colName="name">name<span></span></th>
                <th colName="tamil">tamil<span></span></th>
                <th colName="english">english<span></span></th>
                <th colName="maths">maths<span></span></th>
                <th colName="science">science<span></span></th>
                <th colName="social">social<span></span></th>
            </thead>
            <tbody></tbody>
        </table>
        <div class="table-footer">
            <span></span>
            <div class="pages_container"></div>
        </div>
        
        <table class="table">
            <thead>
                <th colName="no">SNo<span></span></th>
                <th colName="sno">SNo<span></span></th>
                <th colName="name">name<span></span></th>
                <th colName="tamil">tamil<span></span></th>
                <th colName="english">english<span></span></th>
                <th colName="maths">maths<span></span></th>
                <th colName="science">science<span></span></th>
                <th colName="social">social<span></span></th>
            </thead>
            <tbody>
                <tr>
                    <td>
                        1
                    </td>
                    <td>
                        2
                    </td>
                    <td>
                        3
                    </td>
                    <td>
                        4
                    </td>
                    <td>
                        5
                    </td>
                    <td>
                        6
                    </td>
                    <td>
                        7
                    </td>
                    <td style="padding: 0;">
                        <table class="nested-table">
                            <tr>
                                <td style="padding: 0;">
                                    <table class="nested-table">
                                    <tr>
                                        <td >1</td>
                                        <td >1</td>
                                        <td >1</td>
                                        <td >1</td>
                                        <td >1</td>
                                        <td >1</td>
                                        
                                    </tr>
                                    </table>
                                </td>
                                <td >1</td>
                                <td >1</td>
                                <td >1</td>
                                <td >1</td>
                                <td >1</td>
                                
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <table style="height:500px; background:blue;">
            <tr>
                <td style="vertical-align: top">
                    <table style="background:red; height: 100%;">
                        <tr>
                            <td>hello</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <p id="changable"> this is embed text</p>
    <script>
        // console.log(document.getElementById("changable").textContent)
        var ranklist = [
            {'sno':1, 'name':"dinesh", "tamil":101, "english":10, "maths":10, "science":10, "social":10},
            {'sno':2, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':3, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':4, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':5, 'name':"dk", "tamil":10, "english":102, "maths":10, "science":10, "social":10},
            {'sno':6, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':7, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':8, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':9, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':10, 'name':"dk", "tamil":10, "english":10, "maths":103, "science":10, "social":10},
            {'sno':11, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':12, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':13, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':14, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":104, "social":10},
            {'sno':15, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':16, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':17, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':18, 'name':"d", "tamil":10, "english":10, "maths":10, "science":10, "social":105},
            {'sno':19, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':20, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':21, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':22, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':23, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':24, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':25, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':26, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':27, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':28, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':29, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':1, 'name':"dinesh", "tamil":101, "english":10, "maths":10, "science":10, "social":10},
            {'sno':2, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':3, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':4, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':5, 'name':"dk", "tamil":10, "english":102, "maths":10, "science":10, "social":10},
            {'sno':6, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':7, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':8, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':9, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':10, 'name':"dk", "tamil":10, "english":10, "maths":103, "science":10, "social":10},
            {'sno':11, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':12, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':13, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':14, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":104, "social":10},
            {'sno':15, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':16, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':17, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':18, 'name':"d", "tamil":10, "english":10, "maths":10, "science":10, "social":105},
            {'sno':19, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':20, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':21, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':22, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':23, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':24, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':25, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':26, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':27, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':28, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
            {'sno':29, 'name':"dk", "tamil":10, "english":10, "maths":10, "science":10, "social":10},
        ]

        var array = []
        var total_rows = 0;
        var rows_per_page = 10;
        var starting_row = 1;
        var ending_row = 0;
        var current_page = 1;
        var max_pages = 0;
        var sortCol = "";
        var ascOrder = true;

        function preCalculateTableData() {
            filteredRows();
            if(sortCol !== "") {sortTabRows();}
            total_rows = array.length;
            max_pages = Math.floor(total_rows / rows_per_page);
            if((total_rows % rows_per_page) > 0) {
                max_pages++;
            }
        }

        function filteredRows() {
            var filterKey = document.getElementById("table_row_filter_key").value;
            if(filterKey !== "") {
                var temp_array = ranklist.filter(function(object){
                    return object.sno.toString().includes(filterKey)
                    ||    object.name.toUpperCase().includes(filterKey.toUpperCase())
                    ||    object.tamil.toString().includes(filterKey)
                    ||    object.english.toString().includes(filterKey)
                    ||    object.maths.toString().includes(filterKey)
                    ||    object.science.toString().includes(filterKey)
                    ||    object.social.toString().includes(filterKey)
                })
                array = temp_array;
                // console.log(temp_array)
            } else {
                array = ranklist;
            }
        }

        function sortTabRows() {
            array.sort((a,b) => {
                if(ascOrder) {
                    return (a[sortCol] > b[sortCol]) ? 1 : -1;
                } else {
                    return (b[sortCol] > a[sortCol]) ? 1 : -1;
                }
            })
            var pages = document.querySelectorAll(".table th span");
            pages.forEach(page => {
                page.innerHTML = "";
            })
            if(ascOrder) {
                document.querySelector(".table th[colName="+sortCol+"] span").innerHTML = "<i class=\"fa-solid fa-arrow-down-short-wide\"></i>";
            } else {
                document.querySelector(".table th[colName="+sortCol+"] span").innerHTML = "<i class=\"fa-solid fa-arrow-up-wide-short\"></i>";
            }
        }

        function DisplayPageButtons() {
            preCalculateTableData()
            var pageContainer = document.querySelector(".pages_container");
            var pageButtons;
            pageButtons = "<button class=\"page\" onclick=\"Pervious()\"><i class=\"fa-solid fa-backward\"></i></button>";
            for(i=1; i <= max_pages; i++) {
                pageButtons = pageButtons + "<button index=\""+ i +"\" class=\"page\" onclick=\"GoToPage("+ i +")\">"+ i +"</button>";
            }
            pageButtons = pageButtons + "<button class=\"page\" onclick=\"Next()\"><i class=\"fa-solid fa-forward\"></i></button>";
            pageContainer.innerHTML = pageButtons;
            CurrentPage()
        }

        function CurrentPage() {
            starting_row = ((current_page - 1) * rows_per_page) + 1;
            ending_row = (starting_row + rows_per_page) - 1;
            if(ending_row > total_rows) {
                ending_row = total_rows;
            }
            document.querySelector(".table-footer span").innerHTML = "Showing "+starting_row+" to "+ending_row+" of "+total_rows+" entries"
            var pages = document.querySelectorAll(".page");
            pages.forEach(page => {
                page.classList.remove("active")
            })
            pages[current_page].classList.add("active")
            DisplayTableRows()
        }

        function DisplayTableRows(){
            var tab_start = starting_row - 1;
            var tab_end = ending_row;
            var tr = "";
            for(i=tab_start; i<tab_end; i++) {
                var student = array[i];
                tr = tr + '<tr>'+
                             '<td>'+(parseInt(i) + 1)+'</td>'+
                             '<td>'+student['sno']+'</td>'+
                             '<td>'+student['name']+'</td>'+
                             '<td>'+student['tamil']+'</td>'+
                             '<td>'+student['english']+'</td>'+
                             '<td>'+student['maths']+'</td>'+
                             '<td>'+student['science']+'</td>'+
                             '<td>'+student['social']+'</td>'+
                          '</tr>';
            }
            document.querySelector(".table-container tbody").innerHTML = tr;
        }

        DisplayPageButtons()

        document.getElementById("table_row_filter_key").addEventListener("keyup", () => {
            current_page = 1;
            starting_row = 1;
            DisplayPageButtons();
        })

        document.querySelectorAll(".table th").forEach(column => column.addEventListener("click", (header) => {
            var colName = column.getAttribute("colName")
            sortCol = colName
            ascOrder = (sortCol === colName) ? !ascOrder : true;
            current_page = 1;
            starting_row = 1;
            DisplayPageButtons();
        }))

        function Next() {
            if(current_page < max_pages) {
                current_page++;
                CurrentPage()
            }
        }

        function Pervious() {
            if (current_page > 1) {
                current_page--;
                CurrentPage()
            }
        }

        function GoToPage(index) {
            current_page = parseInt(index);
            CurrentPage()
        }

        function DeclarRowPerTab(rows) {
            rows_per_page = rows
            current_page = 1;
            starting_row = 1;
            DisplayPageButtons();
        }

        document.querySelectorAll(".table td").forEach(data => data.addEventListener("dblclick", (e)=>{
            if(data.getAttribute("editing") !== "true") {
                var styles = document.documentElement.style;
                let width = data.getBoundingClientRect().width
                let height = data.getBoundingClientRect().height
                data.style.padding = "0";
                data.setAttribute("editing", "true")
                styles.setProperty('--table-input-height', height+"px")
                let value = data.innerHTML
                data.innerHTML = "<input type=\"text\" value=\""+value+"\">"
                const temp_inputField = data.querySelector("input")
                const end = temp_inputField.value.length;
                temp_inputField.setSelectionRange(end, end)
                temp_inputField.focus()
                temp_inputField.addEventListener("blur", (e)=>{
                    // console.log(temp_inputField.value)
                    data.innerHTML = temp_inputField.value
                    data.removeAttribute("style")
                    data.setAttribute("editing", "false")
                })
            }
        }))

const itemData = {
    'license_number': '25/2022',
    'application': {
        'tracking_number': '535345345',
        'applicant_name': 'Misir Ali Humayun'
    }
};

const placeholder = [
  {
    "find": "%LICENSE%",
    "column": "license_number"
  },
  {
    "find": "%APPLICANT%",
    "column": "application.applicant_name"
  }
];

const content = "A License numbered %LICENSE% from the %APPLICANT% is received";

function replacePlaceholdersWithData(data, content) {
  placeholder.forEach(({find, column})=>content = content.replaceAll(find, lookup(data, column)))
  return content;
}

function isNumber(numberToCheck) {
    let convertedNumber = parseInt(numberToCheck)
    if(convertedNumber.toString() === numberToCheck) {
        return true
    } else {
        return false
    }
}

function lookup(data, path) {
  let [first, ...rest] = path.split('.');
    if(isNumber(first)){
        first = parseInt(first)
    } else {
        first = first
    }
    if(isNumber(path)) {
        path = parseInt(path)
    } else {
        path = path
    }
  return rest.length ? lookup(data[first], rest.join('.')) : data[path] = 10;
}

// console.log(replacePlaceholdersWithData(itemData, content));

var fullarray = {"classes":[{"class":"X","section":"A"},{"class":"X","section":"B"},{"class":"X","section":"C"}],"subjects":[{"subject":"TAMIL","code":"101"},{"subject":"ENGLISH","code":"102"},{"subject":"MATHS","code":"103"},{"subject":"SCIENCE","code":"104"},{"subject":"SOCIAL","code":"105"}],"students":[{"name":"DINESH KUMAR","rollid":"1","gender":"Male","class":"X - A","school":"10"},{"name":"KUMAR","rollid":"2","gender":"Male","class":"X - A","school":"10"}],"subjectcombs":[{"class":"X - A","subjects":["TAMIL","ENGLISH","MATHS","SCIENCE","SOCIAL"]},{"class":"X - C","subjects":["TAMIL"]},{"class":"X - B","subjects":["TAMIL","ENGLISH"]},{"class":"Select Class","subjects":["Select Subject"]}],"schools":[{"schoolid":"103","schoolname":"dineshkumar metric higher secondary school"},{"schoolid":"10","schoolname":"edappadi"},{"schoolid":"103","schoolname":"Shankari metric higher secondary school"},{"schoolid":"123","schoolname":"Dummy METRIC School"}],"schoolexams":[{"school":"103","exams":["Test1","Test3","Test2"]},{"school":"10","exams":["Test1","Test3"]}],"results":{"Test1":{"X - A":[{"name":"DINESH KUMAR","rollid":"1","marks":[35,35,35,35,35],"total":175,"result":"PASS","rank":2},{"name":"KUMAR","rollid":"2","marks":[36,36,36,36,36],"total":180,"result":"PASS","rank":1}]}},"staffs":[{"name":"DINESH KUMAR","username":"dk","password":"123","permission":"superadmin","schoolid":"10"},{"name":"DINESH KUMAR","username":"dns","password":"123","permission":"superadmin","schoolid":"10"},{"name":"Dinesh","username":"dns2","password":"123","permission":"staff","schoolid":"103"}],"staffclasses":[{"staffname":"dk","classes":["X - A","X - C","X - B"]},{"staffname":"dns2","classes":["X - A","X - C","X - B"]},{"staffname":"dns","classes":["X - B","X - A"]}]}
var path = "results.Test1.X - A.0.marks.0"
var arraykey = path.split(".");
let [first, ...rest] = path.split(".");
console.log(fullarray['results']['Test1']['X - A'][0]['marks'][0], "Before")
lookup(fullarray, path)
console.log(fullarray)
// for(i = 0; i < arraykey.length; i++) {
//     fullarray
// }
    </script>
</body>
</html>