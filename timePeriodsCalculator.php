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
                    <table id="calculationTable" class="table"  >
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
                                                <input id="roundInputHour" class="input" type="number" min="-1" value="00" oninput="adjastTimeInputs(event)" onkeyup="incoming(event)" onfocus="this.select()">
                                            </td>
                                            <td >
                                                <input id="roundInputMinute" class="input" type="number" value="00" oninput="adjastTimeInputs(event)" onkeyup="incoming(event)" onfocus="this.select()">
                                            </td>
                                            <td>
                                                <input id="roundInputSecond" class="input" type="number" value="00" oninput="adjastTimeInputs(event)" onkeyup="incoming(event)" onfocus="this.select()">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
