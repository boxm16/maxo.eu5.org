<!DOCTYPE html>
<html lang="en">
    <head>
        <title>მახო</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <style>
            input[type="number"] {
                width:60px;
            }
            table {
                border-collapse: collapse;
            }   

            table,  td , th{
                border: 1px solid black;
            }

        </style>

    </head>
    <body>

        <div class="container">
            <a href="index.php">საწყისი გვერდი</a> &nbsp; <a href="calculator.php">მანძილი/სიჩქარე/დრო</a> &nbsp;<a href="percentsCalculator.php" >პროცენტები</a>
            <div class="row">

                <div class="col-sm-5">
                    <table id='bigTable'>
                        <tbody>
                            <tr id='tr:1'>
                                <td>
                                    <table class="table"  >
                                        <thead>
                                            <tr>
                                                <th colspan="2">
                                        <center> დროის ორ მომენტს შორის ხანგრძლივობის გამოთვლა</center>   
                                        </th>
                            </tr>
                            </thead>
                        <tbody>
                            <tr>
                                <td>
                                    დაწყების დრო
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td >
                                                <input id="startHour:1" class="input" type="number" min="-1" value="00" oninput="adjastTimeInputs('start:1')" onkeyup="incoming('1')" onfocus="this.select()">
                                            </td>
                                            <td >
                                                <input id="startMinute:1" class="input" type="number" value="00" oninput="adjastTimeInputs('start:1')" onkeyup="incoming('1')" onfocus="this.select()">
                                            </td>
                                            <td>
                                                <input id="startSecond:1" class="input" type="number" value="00" oninput="adjastTimeInputs('start:1')" onkeyup="incoming('1')" onfocus="this.select()">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    დამთავრების დრო
                                </td>
                                <td colspan="2">
                                    <table>
                                        <tr id="roundTr">
                                            <td >
                                                <input id="endHour:1" class="input" type="number" min="-1" value="00" oninput="adjastTimeInputs('end:1')" onkeyup="incoming('1')" onfocus="this.select()">
                                            </td>
                                            <td >
                                                <input id="endMinute:1" class="input" type="number" value="00" oninput="adjastTimeInputs('end:1')" onkeyup="incoming('1')" onfocus="this.select()">
                                            </td>
                                            <td>
                                                <input id="endSecond:1" class="input" type="number" value="00" oninput="adjastTimeInputs('end:1')" onkeyup="incoming('1')" onfocus="this.select()">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:0px">
                                    <table style="width:100%" class="table">
                                        <tr>

                                            <td style="widht:60%">
                                                <button type="button" class="btn  btn-primary" style="width:100%;" onclick="checkAndCalculatePeriod('1')"><b>გამოთვლა</b></button>
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    შედეგი 

                                </td>
                                <td>
                                    <table width='100%'>
                                        <tr>
                                            <td>
                                                <label id="periodCalculationResult:1" style="widht:40px;font-size: 24px">00:00:00</label> 
                                            </td>
                                            <td>
                                                <button id="periodCalculationResultCopy:1" style='width:100%; background-color:skyblue' onclick="copyResult('periodCalculationResult:1')">Copy</button>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button class='btn btn-danger' style='width:100%' onclick="deleteCalculationArea('1')">
                                        გამოთვლების ველის წაშლა
                                    </button> 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </td>
                    </tr>
                    <tr>
                        <td>
                            <button class="btn btn-warning" style='width:100%' onclick="addCalculationArea()">   
                                გამოთვლების  ველის დამატება
                            </button>
                        </td>
                    </tr>
                    </tbody>
                    </table>
                    <!------- --------------------------------------------------------- --->
                    <hr>
                    <table id='bigTable_2' style="background-color:lime">
                        <tbody>
                            <tr >
                                <td>
                                    <table class="table"  >
                                        <thead>
                                            <tr>
                                                <th colspan="2">
                                        <center>დროის მონაკვეთების გამოთვლები</center>   
                                        </th>
                            </tr>
                            </thead>
                        <tbody>
                            <tr >
                                <td>
                                    პირველი მონაკვეთი
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                <button style='background-color: skyblue' onclick="pasteCopyBuffer('1')">
                                                    Paste
                                                </button> 
                                            </td>
                                            <td >
                                                <input id="firstTimeHour:1" class="input" type="number" min="-1" value="00" oninput="adjastTimeInputs('firstTime:1')" onkeyup="incoming('1')" onfocus="this.select()">
                                            </td>
                                            <td >
                                                <input id="firstTimeMinute:1" class="input" type="number" value="00" oninput="adjastTimeInputs('firstTime:1')" onkeyup="incoming('1')" onfocus="this.select()">
                                            </td>
                                            <td>
                                                <input id="firstTimeSecond:1" class="input" type="number" value="00" oninput="adjastTimeInputs('firstTime:1')" onkeyup="incoming('1')" onfocus="this.select()">
                                            </td>

                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>ქმედება</td>
                                <td>
                                    <table>
                                        <tr>
                                            <td><input id='minus' type="radio" name="action" checked >&nbsp;<label>გამოკლება&nbsp;&nbsp; </label></td>
                                            <td><input id='plus' type="radio" name="action" >&nbsp;<label>დამატება&nbsp;&nbsp;</label></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    მეორე მონაკვეთი
                                </td>
                                <td colspan="2">
                                    <table>
                                        <tr>
                                            <td>
                                                <button style='background-color: skyblue' onclick="pasteCopyBuffer('2')">
                                                    Paste
                                                </button> 
                                            </td>
                                            <td >
                                                <input id="secondTimeHour:1" class="input" type="number" min="-1" value="00" oninput="adjastTimeInputs('secondTime:1')" onkeyup="incoming('1')" onfocus="this.select()">
                                            </td>
                                            <td >
                                                <input id="secondTimeMinute:1" class="input" type="number" value="00" oninput="adjastTimeInputs('secondTime:1')" onkeyup="incoming('1')" onfocus="this.select()">
                                            </td>
                                            <td>
                                                <input id="secondTimeSecond:1" class="input" type="number" value="00" oninput="adjastTimeInputs('secondTime:1')" onkeyup="incoming('1')" onfocus="this.select()">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:0px">
                                    <table style="width:100%" class="table">
                                        <tr>

                                            <td style="widht:60%">
                                                <button type="button" class="btn  btn-primary" style="width:100%;" onclick="calculateTime()"><b>გამოთვლა</b></button>
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    შედეგი
                                </td>
                                <td>
                                    <label id="timeResult" style="widht:40px;font-size: 24px">00:00:00</label> 
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    </td>
                    </tr>

                    </tbody>
                    </table>
                    <hr><hr> <hr><hr>
                </div>
            </div>
        </div>
        <script>

            var calculationAreaCount = 1;
            var copyBuffer = "";
            function checkAndCalculatePeriod(id) {

                let startHour = document.getElementById('startHour:' + id).value;
                let startMinute = document.getElementById('startMinute:' + id).value;
                let startSecond = document.getElementById('startSecond:' + id).value;
                let endHour = document.getElementById('endHour:' + id).value;
                let endMinute = document.getElementById('endMinute:' + id).value;
                let endSecond = document.getElementById('endSecond:' + id).value;
                let startTimeInSeconds = (startHour * 60 * 60) + (startMinute * 60) + (startSecond * 1);
                let endTimeInSeconds = (endHour * 60 * 60) + (endMinute * 60) + (endSecond * 1);
                let timeDifferenceInSeconds = endTimeInSeconds - startTimeInSeconds;

                let hours = Math.floor(timeDifferenceInSeconds / 3600); // get hours
                let minutes = Math.floor((timeDifferenceInSeconds - (hours * 3600)) / 60); // get minutes
                let seconds = timeDifferenceInSeconds - (hours * 3600) - (minutes * 60); //  get seconds
                let result;
                if (timeDifferenceInSeconds < 0) {
                    result = "დაწყების დრო უფრო გვიან არის ვიდრე დამთავრების დრო";
                } else
                {
                    if (hours < 10) {
                        hours = "0" + hours;
                    }
                    if (minutes < 10) {
                        minutes = "0" + minutes;
                    }
                    if (seconds < 10) {
                        seconds = "0" + seconds;
                    }
                    result = hours + ':' + minutes + ':' + seconds;
                }

                let resultDisplay = document.getElementById('periodCalculationResult:' + id);

                resultDisplay.innerHTML = result;
            }

            function incoming(id) {
                if (event.keyCode === 13) {
                    checkAndCalculatePeriod(id);
                }
            }

            function adjastTimeInputs(triggerElement) {
                //   notes.innerHTML = "";
                var code = triggerElement.split(":");
                var targetType = code[0];
                var targetId = code[1];

                let hourInput = document.getElementById(targetType + "Hour:" + targetId);
                let minuteInput = document.getElementById(targetType + "Minute:" + targetId);
                let secondInput = document.getElementById(targetType + "Second:" + targetId);

                if (secondInput.value == 60) {
                    secondInput.value = 0;
                    minuteInput.value = parseInt(minuteInput.value) + 1;

                }
                if (secondInput.value == -1) {
                    minuteInput.value = parseInt(minuteInput.value) - 1;
                    if (hourInput.value == 0 && minuteInput.value == -1) {
                        secondInput.value = 0;
                    } else {
                        secondInput.value = 59;
                    }
                }
                if (minuteInput.value == 60) {
                    minuteInput.value = 0;
                    timeInputHourPlusPlus(targetType, targetId);
                }
                if (minuteInput.value == -1) {
                    minuteInput.value = 59;
                    timeInputHourMinusMinus(targetType, targetId);
                }
                if (hourInput.value == -1) {
                    hourInput.value = 0;
                    //  notes.style.color = "red";
                    // notes.innerHTML = "საათების 0 ზე ქვემოთ ჩამოსვლა დაუშვებელია";
                    //  redNotes.innerHTML = "საათების 0 ზე ქვემოთ ჩამოსვლა დაუშვებელია";

                }
            }

            function   timeInputHourPlusPlus(targetType, targetId) {
                let hourInput = document.getElementById(targetType + "Hour:" + targetId);
                var x = parseInt(hourInput.value) + 1
                if (x < 10) {
                    hourInput.value = "0" + x;
                } else {
                    hourInput.value = x;
                }
            }

            function   timeInputHourMinusMinus(targetType, targetId) {
                let hourInput = document.getElementById(targetType + "Hour:" + targetId);
                let minuteInput = document.getElementById(targetType + "Minute:" + targetId);


                var x = parseInt(hourInput.value) - 1
                if (x < 0) {
                    x = 0;
                    hourInput.value = 0;
                    minuteInput.value = 0;
                    //notes.style.color = "red";
                    // notes.innerHTML = "საათების 0 ზე ქვემოთ ჩამოსვლა დაუშვებელია";
                    //  redNotes.innerHTML = "საათების 0 ზე ქვემოთ ჩამოსვლა დაუშვებელია";
                }
                if (x < 10) {
                    hourInput.value = "0" + x;
                } else {
                    hourInput.value = x;
                }

            }
            function addCalculationArea() {
                calculationAreaCount++;
                var myHtmlContent = "<tr>" +
                        "<td>" +
                        " <table class=\"table\"  >" +
                        "<thead>" +
                        "<tr>" +
                        "<th colspan=\"2\">" +
                        "<center> დროის ორ მომენტს შორის ხანგრძლივობის გამოთვლა</center>" +
                        "</th>" +
                        "</tr>" +
                        "</thead>" +
                        " <tbody>" +
                        " <tr>" +
                        "<td>" +
                        " დაწყების დრო" +
                        "</td>" +
                        "<td>" +
                        "<table>" +
                        "<tr>" +
                        " <td >" +
                        "<input id=\"startHour:" + calculationAreaCount + "\" class=\"input\" type=\"number\" min=\"-1\" value=\"00\" oninput=\"adjastTimeInputs('start:" + calculationAreaCount + "')\" onkeyup=\"incoming('" + calculationAreaCount + "')\" onfocus=\"this.select()\">" +
                        " </td>" +
                        "<td >" +
                        " <input id=\"startMinute:" + calculationAreaCount + "\" class=\"input\" type=\"number\" value=\"00\" oninput=\"adjastTimeInputs('start:" + calculationAreaCount + "')\" onkeyup=\"incoming('" + calculationAreaCount + "')\" onfocus=\"this.select()\">" +
                        "</td>" +
                        "<td>" +
                        "<input id=\"startSecond:" + calculationAreaCount + "\" class=\"input\" type=\"number\" value=\"00\" oninput=\"adjastTimeInputs('start:" + calculationAreaCount + "')\" onkeyup=\"incoming('" + calculationAreaCount + "')\" onfocus=\"this.select()\">" +
                        "</td>" +
                        "</tr>" +
                        "</table>" +
                        " </td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>" +
                        "დამთავრების დრო" +
                        "</td>" +
                        "<td colspan=\"2\">" +
                        "<table>" +
                        "   <tr id=\"roundTr\">" +
                        "<td >" +
                        "   <input id=\"endHour:" + calculationAreaCount + "\" class=\"input\" type=\"number\" min=\"-1\" value=\"00\" oninput=\"adjastTimeInputs('end:" + calculationAreaCount + "')\" onkeyup=\"incoming('" + calculationAreaCount + "')\" onfocus=\"this.select()\">" +
                        "</td>" +
                        "  <td >" +
                        "     <input id=\"endMinute:" + calculationAreaCount + "\" class=\"input\" type=\"number\" value=\"00\" oninput=\"adjastTimeInputs('end:" + calculationAreaCount + "')\" onkeyup=\"incoming('" + calculationAreaCount + "')\" onfocus=\"this.select()\">" +
                        " </td>" +
                        " <td>" +
                        "    <input id=\"endSecond:" + calculationAreaCount + "\" class=\"input\" type=\"number\" value=\"00\" oninput=\"adjastTimeInputs('end:" + calculationAreaCount + "')\" onkeyup = \"incoming('" + calculationAreaCount + "')\" onfocus=\"this.select()\">" +
                        "</td>" +
                        "  </tr>" +
                        "</table>" +
                        "  </td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td colspan=\"2\" style=\"padding:0px\">" +
                        "<table style=\"width:100 % \" class=\"table\">" +
                        "   <tr>" +
                        "<td style=\"widht:60%\">" +
                        "<button type=\"button\" class=\"btn  btn-primary\" style=\"width:100%;\" onclick=\"checkAndCalculatePeriod('" + calculationAreaCount + "')\"><b>გამოთვლა</b></button>" +
                        "</td>" +
                        "</tr>" +
                        "</table>" +
                        "</td>" +
                        " </tr>" +
                        "<tr>" +
                        "<td>" +
                        "   შედეგი" +
                        "</td>" +
                        " <td>" +
                        "      <table width='100%'>" +
                        "<tr>" +
                        "<td>" +
                        "<label id=\"periodCalculationResult:" + calculationAreaCount + "\" style=\"widht:40px;font-size: 24px\">00:00:00</label> " +
                        "</td>" +
                        " <td>" +
                        " <button id=\"periodCalculationResultCopy:" + calculationAreaCount + "\" style='width:100%; background-color:skyblue' onclick=\"copyResult('periodCalculationResult:" + calculationAreaCount + "')\">Copy</button>" +
                        "</td>" +
                        "</tr>" +
                        " </table>" +
                        "</td>" +
                        " </tr>" +
                        "<tr>" +
                        "<td colspan=\"2\">" +
                        "<button class='btn btn-danger' style='width:100%' onclick=\"deleteCalculationArea('" + calculationAreaCount + "')\">" +
                        " გამოთვლების ველის წაშლა" +
                        "</button> " +
                        "</td>" +
                        "</tr>" +
                        "</tbody>" +
                        "</table>" +
                        "</td>" +
                        "</tr>";
                var tableRef = document.getElementById('bigTable').getElementsByTagName('tbody')[0];

                var newRow = tableRef.insertRow(tableRef.rows.length - 1);
                newRow.innerHTML = myHtmlContent;

                newRow.setAttribute("id", "tr:" + calculationAreaCount, 0);
            }

            function deleteCalculationArea(id) {
                document.getElementById("tr:" + id).innerHTML = "";
            }
            //---------------------------
            function calculateTime() {
                let firstTimeInSeconds = (document.getElementById('firstTimeHour:1').value * 60 * 60) + (document.getElementById('firstTimeMinute:1').value * 60) + (document.getElementById('firstTimeSecond:1').value * 1);
                let secondTimeInSeconds = (document.getElementById('secondTimeHour:1').value * 60 * 60) + (document.getElementById('secondTimeMinute:1').value * 60) + (document.getElementById('secondTimeSecond:1').value * 1);
                let resultInSeconds;
                if (minus.checked) {
                    resultInSeconds = firstTimeInSeconds - secondTimeInSeconds;
                }
                if (plus.checked) {
                    resultInSeconds = firstTimeInSeconds + secondTimeInSeconds;
                }
                let result;

                if (resultInSeconds < 0) {

                    result = "პირველი მონაკვეთი უფრო მოკლეა ვიდრე მეორე (გამოკლებული) ";
                } else
                {


                    let hours = Math.floor(resultInSeconds / 3600); // get hours
                    let minutes = Math.floor((resultInSeconds - (hours * 3600)) / 60); // get minutes
                    let seconds = resultInSeconds - (hours * 3600) - (minutes * 60); //  get seconds



                    if (hours < 10) {
                        hours = "0" + hours;
                    }
                    if (minutes < 10) {
                        minutes = "0" + minutes;
                    }
                    if (seconds < 10) {
                        seconds = "0" + seconds;
                    }
                    result = hours + ':' + minutes + ':' + seconds;
                }
                let resultDisplay = document.getElementById('timeResult');

                resultDisplay.innerHTML = result;
            }
            function copyResult(id) {
                let a = document.getElementById(id);
                copyBuffer = a.innerHTML;
            }
            function pasteCopyBuffer(id) {
                let time = copyBuffer.split(":");
                if (id == '1') {
                    document.getElementById('firstTimeHour:1').value = time[0];
                    document.getElementById('firstTimeMinute:1').value = time[1];
                    document.getElementById('firstTimeSecond:1').value = time[2];
                }
                if (id == '2') {
                    document.getElementById('secondTimeHour:1').value = time[0];
                    document.getElementById('secondTimeMinute:1').value = time[1];
                    document.getElementById('secondTimeSecond:1').value = time[2];
                }
                console.log(copyBuffer);
            }
        </script>
    </body>
</html>
