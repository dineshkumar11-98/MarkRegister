var tableDataArray;
var serNoCol = false
var fullArray, arrayKey;
var removableTD, editableTD;
function getTableDataArray(array, colReq, fullData, key, isRemovable, isEditable) {
    tableDataArray = array;
    serNoCol = colReq;
    fullArray = fullData;
    arrayKey = key;
    removableTD = isRemovable;
    editableTD = isEditable;
}

document.addEventListener("DOMContentLoaded", () => {
    var array = [];
    var total_rows = 0;
    var rows_per_page = 10;
    var starting_row = 1;
    var ending_row = 0;
    var current_page = 1;
    var max_pages = 0;

    function preCalculateTableData() {
        filteredRows();
        total_rows = array.length;
        max_pages = Math.floor(total_rows / rows_per_page);
        if((total_rows % rows_per_page) > 0) {
            max_pages++;
        }
    }

    function filteredRows() {
        var filterKey = document.getElementById("table_row_filter_key").value;
        if(filterKey !== "") {
            var temp_array = [];
            for(i=0; i < tableDataArray.length; i++) {
                for(j=0; j < Object.keys(tableDataArray[i]).length; j++){
                    var rawFilter = tableDataArray.filter(function(object){
                        if(typeof object[Object.keys(tableDataArray[i])[j]] === "object") {
                            let subFilter = object[Object.keys(tableDataArray[i])[j]].filter(function(words){
                                if(typeof words == "number") {
                                    return words.toString().includes(filterKey)
                                } else {
                                    return words.toUpperCase().includes(filterKey.toUpperCase())
                                }
                            })
                            if(subFilter.length > 0){
                                return true
                            }
                        } else {
                            if(typeof object[Object.keys(tableDataArray[i])[j]] == "number") {
                                return object[Object.keys(tableDataArray[i])[j]].toString().includes(filterKey)
                            } else {
                                return object[Object.keys(tableDataArray[i])[j]].toUpperCase().includes(filterKey.toUpperCase())
                            }
                        }
                    })
                    if (rawFilter.length > 0 && i === 0){
                        var arrayExist = false;
                        for(k=0; k < rawFilter.length; k++){
                            for(l = 0 ; l < temp_array.length; l++) {
                                if(JSON.stringify(temp_array[l]) === JSON.stringify(rawFilter[k])) {
                                    arrayExist = true;
                                    break;
                                } else {
                                    arrayExist = false;
                                }
                            }
                            if(arrayExist === false) {
                                temp_array.push(rawFilter[k])
                            }
                        }
                    }
                    // break;
                }
            }
            array = temp_array
        } else {
            array = tableDataArray;
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
        if(array[0][0] === undefined) {
            for(i=tab_start; i<tab_end; i++) {
                tr = tr + '<tr array_index = '+i+'>';
                if(serNoCol === true) {
                    tr = tr + '<td editable = \"false\">'+(i + 1)+'</td>';
                }
                const subArray = array[i]
                const arrayKeys = Object.keys(subArray);
                for (j=0; j<arrayKeys.length; j++) {
                    if(typeof subArray[arrayKeys[j]] === "object") {
                        tr = tr + "<td style=\"padding: 0\" colName=\""+arrayKeys[j]+"\">"+NestedTable(arrayKeys[j], subArray[arrayKeys[j]], j, i)+"</td>"
                    } else {
                        tr = tr + '<td editable = \"'+editableTD[j]+'\" colName=\"'+arrayKeys[j]+'\">'+subArray[arrayKeys[j]]+'</td>'
                    }
                }
                if(removableTD === true) {
                    tr = tr + '<td class=\"text-center bavel-font\" title="Delete"><i class="fa-solid fa-trash-can"></i></i></td>'
                }
                tr = tr + '</tr>';
            }
        }
        
        document.querySelector(".table-container tbody").innerHTML = tr;
        EditTable();
    }

    function NestedTable(colName, nestedArray, editable, MainArray_index) {
        let nestedTable = "";
        nestedTable = nestedTable + "<table class=\"nested-table\"><tr array_index=\""+MainArray_index+"\">"
        if(Object.keys(nestedArray).length > 0) {
            for(l=0;l<nestedArray.length;l++){
                if (typeof nestedArray[l] === "object") {
                    nestedTable = nestedTable +  NestedTable(colName, nestedArray[l])
                }
                nestedTable = nestedTable + "<td colname=\""+colName+"\" array_index=\""+l+"\" editable = \""+editableTD[editable]+"\">"+nestedArray[l]+"</td>"
            }
        }
        nestedTable = nestedTable + "</tr></table>"
        return nestedTable
    }
    
    document.getElementById("table_row_filter_key").addEventListener("keyup", () => {
        current_page = 1;
        starting_row = 1;
        DisplayPageButtons();
    })

    window.Next = function() {
        if(current_page < max_pages) {
            current_page++;
            CurrentPage()
        }
    }

    window.Pervious = function() {
        if (current_page > 1) {
            current_page--;
            CurrentPage()
        }
    }

    window.GoToPage = function(index) {
        current_page = parseInt(index);
        CurrentPage()
    }

    window.DeclarRowPerTab = function(rows) {
        rows_per_page = rows
        current_page = 1;
        starting_row = 1;
        DisplayPageButtons();
    }

    window.RefreshTable = function() {
        DisplayPageButtons();
    }

    DisplayPageButtons()

    function isNumber(numberToCheck) {
        let convertedNumber = parseInt(numberToCheck)
        if(convertedNumber.toString() === numberToCheck) {
            return true
        } else {
            return false
        }
    }
    
    function lookup(data, path, newValue) {
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
        return rest.length ? lookup(data[first], rest.join('.'), newValue) : data[path] = newValue;
    }

    function EditTable() {
        var dataTable = document.getElementById("data-table")
        var eventHandler = function(e) {
            if(this.getAttribute("editing") !== "true" && this.getAttribute("editable") === "true" && dataTable.getAttribute("editable") === "true") {
                // creating input field on double click the cell
                var styles = document.documentElement.style;
                let height = this.getBoundingClientRect().height
                this.style.padding = "0";
                this.setAttribute("editing", "true")
                styles.setProperty('--table-input-height', height+"px")
                let value = this.textContent
                this.innerHTML = "<input type=\"text\" value=\""+value+"\">"
                // set cursor and end of the values in input field
                const temp_inputField = this.querySelector("input")
                const pageContainer = document.querySelector(".pages_container")
                const end = temp_inputField.value.length;
                temp_inputField.setSelectionRange(end, end)
                temp_inputField.focus()
                // if table editing activate disable the filter and switch pages
                dataTable.setAttribute("editable", "false")
                document.getElementById("table_row_filter_key").setAttribute("readonly", "readonly")
                pageContainer.style.visibility = "hidden";
                pageContainer.style.PointerEvent = "none";
                // after press enter delete the input field and save the changed content to server
                temp_inputField.addEventListener("keyup", (e)=>{
                    if(e.keyCode === 13) {
                        this.innerHTML = temp_inputField.value
                        document.getElementById("table_row_filter_key").removeAttribute("readonly")
                        pageContainer.removeAttribute("style")
                        this.removeAttribute("style")
                        this.setAttribute("editing", "false")
                        var parent = this.parentElement;
                        var array_index = parent.getAttribute("array_index")
                        var colName = this.getAttribute("colName")
                        var childArray_index = this.getAttribute("array_index")
                        if (arrayKey.split(".").length > 1) {
                            var path = arrayKey + "." + array_index + "." + colName + "." + childArray_index;
                            lookup(fullArray, path, temp_inputField.value)
                        } else {
                            fullArray[arrayKey][array_index][colName] = temp_inputField.value
                        }
                        fetch("saveUpdates.php", {
                            method: 'POST',
                            headers: {
                                'Content-Type' : 'application/json; charset=utf-8'
                            },
                            body: JSON.stringify(fullArray)
                        }).then(
                            res => res.json()
                        ).then(
                            resJson => {
                                if(resJson["Entry"]){
                                    dataTable.setAttribute("editable", "true")
                                    try {
                                        onValueChange(value, temp_inputField.value, array_index, colName, childArray_index, arrayKey)
                                    } catch {
                                        // 
                                    }
                                }
                            }
                        )
                    }
                })
            }
        }
        document.querySelectorAll(".table td").forEach(data => data.addEventListener("dblclick", eventHandler))
    }
});