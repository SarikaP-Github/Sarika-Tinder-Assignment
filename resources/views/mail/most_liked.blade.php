<html>
<body>

<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" align="left" valign="top" style="border-collapse: collapse; border-spacing: 0;margin-top:30px;">
    <tbody>
    <tr>
        <td align="center" valign="top" >
            <table width="600" align="center" cellpadding="20" cellspacing="0" style="border-collapse: collapse; border-spacing: 0; background-color: #F3F4F5; text-align: center;" border="0" valign="top" bgcolor="#F3F4F5">
                <tbody>
                <tr>
                    <td align="center">
                        <img src='{{ asset("images/logo.jpg") }}' alt="{{ config('app.name') }}" width="100" style="border: 0;">
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" height="100%" cellpadding="30" cellspacing="0" border="0" style="background-color:#ffffff;">
                            <tr>
                                <td align="left">
                                    <p style="text-align:left; color: #4F687A; font-family: America, sans-serif; position: relative; text-transform: inherit; text-shadow: none; font-size: 1rem; font-weight: 400; line-height: 1.25;">Hello Admin,</p>
                                    <p style="text-align:left; color: #4F687A; font-family: America, sans-serif; position: relative; text-transform: inherit; text-shadow: none; font-size: 1rem; font-weight: 400; line-height: 1.25;">{{ $user->name }} liked by 50+ people</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table align="center" cellpadding="20" width="100%" cellspacing="0" style="border-collapse: collapse; border-spacing: 0; background-color: #F3F4F5; text-align: center;">
                            <tr>
                                <td>
                                    <p style="color: #4F687A; font-family: America, sans-serif;  font-size: 1rem; font-weight: 400; line-height: 1.5;">
                                        Copyright © {{ date('Y')}} {{ config('app.name') }}
                                    </p>
                                <td>
                            </tr>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
