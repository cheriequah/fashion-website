<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body>
    <tr>
        <td>Dear {{ $name }}</td>
    </tr>
    <tr>
        <td>Please click on the below link to activate your account</td>
    </tr>
    <tr>
        <td><a href="{{ url('confirm/'.$code) }}">Confirm Account</a></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>Regards,</td>
    </tr>
    <tr>
        <td>Pearl Wonder Website</td>
    </tr>
</body>
</html>