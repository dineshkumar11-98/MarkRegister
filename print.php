<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="print.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <table class="table" editable="true" id="data-table">
            <thead>
                <tr><th colname="sno" printerVisible = "false">S.No</th>
                <th colname="name">Name</th>
                <th colname="rollid">Roll No</th>
                <th colname="marks" style="padding:0">Marks
                    <table class="nested-table">
                        <thead id="subjectHeader"><tr><th>TAMIL</th><th>ENGLISH</th><th>MATHS</th><th>SCIENCE</th><th>SOCIAL</th></tr></thead>
                    </table>
                </th>
                <th colname="total">Total</th>
                <th colname="result">Result</th>
                <th colname="rank">Rank</th>
                <th colname="acion" printerVisible = "false">Action</th>
            </tr></thead>
            <tbody>
                <tr array_index="0">
                    <td editable="false" printerVisible = "false">1</td>
                    <td editable="false" colname="name">DINESH KUMAR</td>
                    <td editable="true" colname="rollid">1</td>
                    <td style="padding: 0" colname="marks">
                        <table class="nested-table">
                            <tbody>
                                <tr array_index="0">
                                    <td colname="marks" array_index="0" editable="true">40</td>
                                    <td colname="marks" array_index="1" editable="true">35</td>
                                    <td colname="marks" array_index="2" editable="true">35</td>
                                    <td colname="marks" array_index="3" editable="true">35</td>
                                    <td colname="marks" array_index="4" editable="true">35</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td editable="false" colname="total">180</td>
                    <td editable="false" colname="result">PASS</td>
                    <td editable="false" colname="rank">2</td>
                    <td class="text-center bavel-font" title="Delete" printerVisible = "false">
                        <i class="fa-solid fa-trash-can"></i>
                    </td>
                </tr>
                <tr array_index="1">
                    <td editable="false" printerVisible = "false">2</td>
                    <td editable="false" colname="name">KUMAR</td>
                    <td editable="true" colname="rollid">2</td>
                    <td style="padding: 0" colname="marks">
                        <table class="nested-table">
                            <tbody>
                                <tr array_index="1">
                                    <td colname="marks" array_index="0" editable="true">A</td>
                                    <td colname="marks" array_index="1" editable="true">36</td>
                                    <td colname="marks" array_index="2" editable="true">36</td>
                                    <td colname="marks" array_index="3" editable="true">36</td>
                                    <td colname="marks" array_index="4" editable="true">36</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td editable="false" colname="total">144</td>
                    <td editable="false" colname="result">FAIL</td>
                    <td editable="false" colname="rank">FAIL</td>
                    <td class="text-center bavel-font" title="Delete" printerVisible = "false">
                        <i class="fa-solid fa-trash-can"></i>
                    </td>
                </tr>
                <tr array_index="2">
                    <td editable="false" printerVisible = "false">3</td>
                    <td editable="false" colname="name">Name</td>
                    <td editable="true" colname="rollid">3</td>
                    <td style="padding: 0" colname="marks">
                        <table class="nested-table">
                            <tbody>
                                <tr array_index="2">
                                    <td colname="marks" array_index="0" editable="true">37</td>
                                    <td colname="marks" array_index="1" editable="true">37</td>
                                    <td colname="marks" array_index="2" editable="true">37</td>
                                    <td colname="marks" array_index="3" editable="true">37</td>
                                    <td colname="marks" array_index="4" editable="true">37</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td editable="false" colname="total">185</td>
                    <td editable="false" colname="result">PASS</td>
                    <td editable="false" colname="rank">1</td>
                    <td class="text-center bavel-font" title="Delete" printerVisible = "false">
                        <i class="fa-solid fa-trash-can"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>