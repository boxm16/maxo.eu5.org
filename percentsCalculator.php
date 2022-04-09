<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>პროცენტები</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
            <a href="index.php">საწყისი გვერდი</a> &nbsp;<a href="calculator.php" >მანძილი/სიჩქარე/დრო</a> &nbsp;<a href="timePeriodsCalculator.php">დროის პერიოდების გამოთვლა</a>
            <div class="row">
                <div class="col-sm-6">
                    <table id="calculationTable" class="table">
                        <thead>
                            <tr>
                                <th colspan="2">
                        <center>ბრუნების პროცენტები</center>   
                        </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>გეგმიური</td>
                                <td>
                                    <input id="scheduled" type="number" min="0" value="00" style="width:80px;" onkeyup="incoming_1(event)" onfocus="this.select()"> 
                                </td>
                            </tr>
                            <tr>
                                <td>ფაქტიური</td>
                                <td>
                                    <input id="actual" type="number"  min="0" value="00" style="width:80px;" onkeyup="incoming_1(event)" onfocus="this.select()">
                                </td>

                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button type="button" class="btn  btn-primary" style="width:100%;" onclick="calculateLostRounds()"><b>გამოთვლა</b></button>
                                </td>
                            </tr>
                            <tr>
                                <td widht="20%">შესრულებულების %</td>
                                <td width="80%">
                                    <label id="result_1" style="font-size: 30px;">00</label>
                                </td>
                            </tr>
                            <tr>
                                <td widht="20%">დაკარგულების %</td>
                                <td width="80%">
                                    <label id="result_2" style="font-size: 30px;">00</label>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div  class="col-sm-1"> </div>

                <div  class="col-sm-5"> 
                    <table id="calculationTable" class="table"  >
                        <thead>
                            <tr>
                                <th colspan="2">
                        <center> დროს პროცენტები</center>   
                        </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    მოცემული დრო   
                                </td>
                                <td>
                                    <table>
                                        <tr id="roundTr">
                                            <td >

                                                <input id="roundInputHour" class="input" type="number" min="-1" value="00" oninput="adjastTimeInputs(event)" onkeyup="incoming(event)" onfocus="this.select()">
                                            </td>
                                            <td >

                                                <input id="roundInputMinute" class="input" type="number" value="00" oninput="adjastTimeInputs(event)" onkeyup="incoming(event)" onfocus="this.select()">
                                            </td>
                                            <td>

                                                <input id="roundInputSecond" class="input" type="number" value="00" oninput="adjastTimeInputs(event)" onkeyup="incoming(event)" onfocus="this.select()">
                                            </td>
                                        </tr>
                                        <tr id="roundMinutesTr">
                                            <td colspan="2" style="padding-top:5px; padding-left:40px">
                                                <input id="roundInputMinutes" class="input" type="number"value="00" style="width:100px;" oninput="adjastTimeInputs(event)" onkeyup="incoming(event)" onfocus="this.select()">
                                            </td>
                                            <td style="padding-top:5px">

                                                <input id="roundInputSeconds" class="input" type="number" value="00" oninput="adjastTimeInputs(event)" onkeyup="incoming(event)" onfocus="this.select()">
                                            </td> 
                                        </tr>
                                    </table>
                                </td>

                            </tr>
                            <tr>

                                <td>
                                    პროცენტი
                                </td>
                                <td colspan="2">
                                    <input id="percents" class="input" type="number"  style="width:135px;" max="200"  value="0" onkeyup="incoming(event)" onfocus="this.select()">
                                </td>


                            </tr>

                            <tr>
                                <td colspan="2" style="padding:0px">
                                    <table style="width:100%" class="table">
                                        <tr>

                                            <td style="widht:60%">
                                                <button type="button" class="btn  btn-primary" style="width:100%;" onclick="checkAndCalculate()"><b>გამოთვლა</b></button>
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
                                    <label id="resultTime" style="widht:40px;font-size: 24px">00:00:00</label> 
                                </td>


                            </tr>

                            <tr>
                                <td colspan="2">
                                    <table>
                                        <tr id="minusPlusBoth">

                                        </tr>
                                    </table>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="width:800px">  <label id="notes"> შენიშვბები</label></td>
                            </tr>



                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <script>
            function incoming(event) {
                if (event.keyCode === 13) {
                    checkAndCalculate();
                }
            }

            function incoming_1(event) {
                if (event.keyCode === 13) {
                    calculateLostRounds();
                }
            }

            function  checkAndCalculate() {
                let minutes = roundInputMinutes.value * 1;
                let seconds = roundInputSeconds.value * 1;
                let totalSeconds = (minutes * 60) + seconds;
                let per = percents.value * 1;//
                let result = (totalSeconds * per) / 100;


                let date = new Date(0);
                date.setSeconds(result);
                let resultString = date.toISOString().substr(11, 8);
                let resultDesplay = document.getElementById("resultTime");
                resultDesplay.innerHTML = resultString;

                let maxResult = totalSeconds + result;
                let minResult = totalSeconds - result;

                date = new Date(0);
                date.setSeconds(maxResult);
                let maxResultString = date.toISOString().substr(11, 8);


                date = new Date(0);
                date.setSeconds(minResult);
                let minResultString = date.toISOString().substr(11, 8);



                let minusPlusBothDispaly = document.getElementById("minusPlusBoth");
                minusPlusBothDispaly.innerHTML = "<td>" + maxResultString + "</td><td>" + minResultString + "</td><td>" + maxResultString + "/" + minResultString + "</td>";


            }

            function adjastTimeInputs(event) {
                notes.innerHTML = "";

                var targetTR = event.target.parentNode.parentNode.id;
                var targetInputs;

                if (targetTR == "roundTr") {
                    targetInputs = "round";
                    adjastTimeInputs_1(targetInputs);
                }
                if (targetTR == "roundMinutesTr") {

                    adjastTimeInputs_2();
                }
            }


            function adjastTimeInputs_1(targetInputs) {

                var second = document.getElementById(targetInputs + "InputSecond");
                var minute = document.getElementById(targetInputs + "InputMinute");
                var hour = document.getElementById(targetInputs + "InputHour");

                if (second.value == 60) {
                    second.value = 0;
                    minute.value = parseInt(minute.value) + 1;
                }
                if (second.value == -1) {
                    minute.value = parseInt(minute.value) - 1;
                    if (hour.value == 0 && minute.value == -1) {
                        second.value = 0;
                    } else {
                        second.value = 59;
                    }
                }


                if (minute.value == 60) {
                    minute.value = 0;
                    timeInputHourPlusPlus(targetInputs);
                }
                if (minute.value == -1) {

                    minute.value = 59;
                    timeInputHourMinusMinus(targetInputs);
                }

                if (hour.value == -1) {
                    hour.value = 0;
                    notes.style.color = "red";
                    notes.innerHTML = "საათების 0 ზე ქვემოთ ჩამოსვლა დაუშვებელია";
                    //  redNotes.innerHTML = "საათების 0 ზე ქვემოთ ჩამოსვლა დაუშვებელია";

                }

                copyHoursToMinutes();
            }

            function copyHoursToMinutes() {
                var hour = roundInputHour.value;
                var minute = roundInputMinute.value;
                var minutes = (hour * 60) + parseInt(minute);
                roundInputMinutes.value = minutes;
                roundInputSeconds.value = roundInputSecond.value;
            }

            function   timeInputHourMinusMinus(targetInputs) {
                var hour = document.getElementById(targetInputs + "InputHour");
                var minute = document.getElementById(targetInputs + "InputMinute");

                var x = parseInt(hour.value) - 1
                if (x < 0) {
                    x = 0;
                    hour.value = 0;
                    minute.value = 0;
                    notes.style.color = "red";
                    notes.innerHTML = "საათების 0 ზე ქვემოთ ჩამოსვლა დაუშვებელია";
                    //  redNotes.innerHTML = "საათების 0 ზე ქვემოთ ჩამოსვლა დაუშვებელია";
                }
                if (x < 10) {
                    hour.value = "0" + x;
                } else {
                    hour.value = x;
                }
            }
            function   timeInputHourPlusPlus(targetInputs) {
                var hour = document.getElementById(targetInputs + "InputHour");
                var x = parseInt(hour.value) + 1
                if (x < 10) {
                    hour.value = "0" + x;
                } else {
                    hour.value = x;
                }
            }


            function adjastTimeInputs_2() {
                var second = document.getElementById("roundInputSeconds");
                var minute = document.getElementById("roundInputMinutes");


                if (second.value == 60) {
                    second.value = 0;
                    minute.value = parseInt(minute.value) + 1;
                }
                if (second.value == -1) {
                    minute.value = parseInt(minute.value) - 1;
                    if (minute.value == -1) {
                        second.value = 0;
                    } else {
                        second.value = 59;
                    }
                }


                if (minute.value == -1) {

                    minute.value = 0;
                    notes.style.color = "red";
                    notes.innerHTML = "წუთების 0 ზე ქვემოთ ჩამოსვლა დაუშვებელია";
                }


                copyMinutesToHours();
            }

            function copyMinutesToHours() {
                var minutes = roundInputMinutes.value;
                var hour = parseInt(minutes / 60);
                var minute = minutes % 60;
                if (hour < 10) {
                    roundInputHour.value = "0" + hour;
                } else {
                    roundInputHour.value = hour;
                }
                if (minute < 10) {
                    roundInputMinute.value = "0" + minute;
                } else {
                    roundInputMinute.value = minute;
                }

                roundInputSecond.value = roundInputSeconds.value;


            }


            function calculateLostRounds() {
                let sched = scheduled.value * 1;
                let actu = actual.value * 1;
                let diff = sched - actu;
                if (sched == 0) {
                    result_2.innerHTML = "?";
                    result_1.innerHTML = "?";
                } else {
                    let res = (diff * 100) / sched;
                    result_2.innerHTML = res;
                    result_1.innerHTML = 100 - res;
                }
            }

        </script>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    </body>

</html>
