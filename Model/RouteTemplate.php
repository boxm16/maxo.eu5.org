
<center>
    <div>
        <form action='breaks.php' method='POST' target="_blank">
            <table>
                <tr>

                <input name="routeVersionNumber" type='hidden' value='<?php echo $routeVersionNumber ?>' readonly="true">

                <td>
                    <input id="breakTimeMinutes" name="breakTimeMinutes" class="input" type="number" value="30" >შეს/ბის ხანგრძლივობა

                </td>
                <td>
                    <input type='time' name="firstBreakStartTime" value ="11:00:00"> პირვლე შესვენების დაწყ. დრო
                </td>
                <td>
                    <input type='time' name="lastBreakEndTime" value ="17:00:00" > ბოლო შესვენების დამთ. დრო
                </td>
                <td>
                    <select name="breakStayPoint" >
                        <option value="A" >A წერტილში დასვენება</option>
                        <option value="B">B წერტილში დასვენება</option>
                        <option value="AandB">ორივე წერტილში დასვენება</option>
                    </select>
                </td>


                <td>
                    <input type='submit' value='შესვენებების ვარიანთების გამოსახვა' style='background-color: yellow'>
                </td>
                </tr>
            </table>
        </form>
    </div>
</center>
<br>

<?php
include 'RouteGraphical.php';
