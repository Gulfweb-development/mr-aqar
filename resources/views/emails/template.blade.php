<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
</head>
<body>

<div style="margin:5%;">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td height="100" align="center" style="border-bottom:1px #CCCCCC solid;"><img src="{{asset('images/main/logo.png')}}" style="max-height:100px;" alt="googleme.com"/></td>
    </tr>
    <tr>
      <td style="padding:20px; font-family: arial, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', 'serif'; color: #000; text-align: justify; font-size: 14px; line-height:23px;">
            <p>{!! $dear !!}</p>
		  	<p>{!! $email_body !!}</p>
		</td>
    </tr>
    <tr>
      <td height="50" align="center"  style="font-family: arial, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', 'serif'; color:#000; font-size: 14px;border-top:1px #CCCCCC solid;">&copy;{{date('Y')}},All Rights Reserved, googleme.com</td>
    </tr>
  </tbody>
</table>
</div>
</body>
</html>
