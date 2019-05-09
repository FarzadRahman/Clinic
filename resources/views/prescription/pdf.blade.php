<html>
    <head>

        <title>&nbsp;</title>

    </head>
    <body style="margin: 0px;padding: 0px">
    <table style="width: 100%;">
        <tr>
            <td>
                {{$appointment->doctorName}} <br>
                Mbbs Mh-Phill <br>
                Family Physician <br>
                Mobile : 01646133213415

            </td>
            <td>
                <table   style="width: 100%;border: solid 2px black">
                    <tr>
                        <td>Reg No : {{$appointment->regNo}} </td>
                        <td>SI No : {{$appointment->serialNumber}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Name: {{$appointment->name}} </td>
                    </tr>
                    <tr>
                        <td>Age: {{$appointment->age}}</td>
                        <td> Sex: {{$appointment->sex}} </td>
                    </tr>

                    <tr>
                        <td colspan="2">Visit Date : {{$appointment->appointmentTime}}</td>
                    </tr>
                </table>


            </td>
        </tr>
    </table>


    <table style="width: 100%;border-top: solid 2px black;height: 80%">
        <tr>
            <td style="width: 40%;border-right: solid 2px black"></td>
            <td style="width: 60%;" valign="top">R<sub>x</sub></td>
        </tr>

    </table>


    <script>
        window.print();

    </script>

    </body>
</html>