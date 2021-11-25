<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>{{$siteSetting->website_title}}</title>
  <style type="text/css">
  p{ margin:0; padding:12px 0 0 0; line-height:22px;}
  </style>
</head>

<body style="background:#efefef; margin:0; padding:0;">
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:14px;">
    <tbody>
      <tr>
        <td align="center" valign="middle" bgcolor="#18579A" style="padding:15px; margin:0; line-height:0; border-top:2px solid #18579A; border-bottom:1px solid #18579A;"><a target="_blank" href="#"><img src="{{asset('images/admin/logo.png')}}" alt="" style="border:0;" width="157" height="94" /></a></td>
      </tr>
      <tr>
        <td align="left" valign="top" bgcolor="#ffffff" style="color:#3c3c3c; margin:0; padding:15px 15px 30px 15px;">
          @yield('content')
        </td>
      </tr>      
      <tr>
        <td align="center" valign="middle" bgcolor="#33363D" style="padding:20px; color:#ffffff; margin:0; line-height:0;">@lang('custom_admin.label_copyright') &copy; {{$siteSetting->website_title}}</td>
      </tr>
    </tbody>
  </table>
</body>
</html>
