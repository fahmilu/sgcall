<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" name="viewport" />
<title>Responsive HTML Email Framework</title>


<style type="text/css">
<!--
body {
   background-color: #343739;
   margin: 0;
   padding: 0;
}
a {
    color:#1724A9;
    text-decoration:none;
}
a:hover {
    color:#1724A9;
    text-decoration:underline;
}
ul li {
    font-family: Helvetica, Arial, sans-serif; 
    font-size: 14px; 
    color: #42484D; 
    line-height: 24px; 
    font-weight: 200; 
    text-align:left; 
    vertical-align:top;
}
img {
    border: none;
    display: block;
    }
.imageScale1        {margin-right: 15px; margin-bottom: 0px; }
.imageScale1_last   {
    margin-right: 0px;
    margin-bottom: 0px;
    text-align: right;
}

.imageScale2        {margin-right: 0px; margin-bottom: 0px; }
.imageScale2_last   {margin-right: 0px; margin-bottom: 0px; }
.noBlock img        {display: inline-block; }
-->

@media only screen and (min-width: 768px) 
            {
        .emailWrapper {width:100%!important; }
        .mobileCenter {width: 100%!important; }
        .contentWrapper {width:100%!important; }
            }


@media only screen and (max-width: 640px) 
           {
         body                           {width:100%!important;}
         table table                    {width:500px!important; }
        .emailWrapper                   {width:500px!important; }
        .contentWrapper                 {width:480px!important; }
        .fullWidth                      {width:480px!important; }
        .messageWrapper                 {width:480px!important; }
        .headerScale                    {width:480px!important; }
        .splashScale                    {width: 480px!important; height: 267px!important; margin-left: 0px !important; }
        .mobileCenter                   {width: 480px!important; }
        .mobileCenter2                  {text-align: center!important;}
        .socialCenter                   {width: 170px !important; text-align: center !important; margin-left: auto!important; margin-right: auto!important; }
        .logo                           {width: 393px!important; height: 77px!important; margin-right: 0px!important; margin-left: 0px !important; }
        .imagePackages                  {width: 628px!important; height: 487px!important; margin-right: 0px!important; margin-bottom: 20px!important; margin-left: 0px !important; }
        .imageScale1                    {width: 480px!important; height: 274px!important; margin-right: 0px!important; margin-bottom: 20px!important; margin-left: 0px !important; }
        .imageScale1_last               {width: 480px!important; height: 274px!important; margin-right: 0px!important; margin-bottom: 20px!important; margin-left: 0px !important; }
        .imageScale2                    {width: 480px!important; height: 274px!important; margin-right: 0px!important; margin-bottom: 20px!important; margin-left: 10px !important; }
        .imageScale2_last               {width: 480px!important; height: 274px!important; margin-left: 10px!important; margin-bottom: 20px!important; margin-right: 10px !important; }
        .heading1                       {font-size: 24px !important; font-weight: 200!important; padding: 0px 0 0px 10px !important; }
        .heading2                       {font-size: 20px !important; font-weight: 200!important; }
        .mobileRemove                   {width: 0px !important; display: none !important; height: 0px !important; }
        .hr                             {display: none !important; }
        .button                         {padding: 0 0 10px 10px !important; }
        .textIndent                     {font-size: 16px !important; line-height: 24px !important; font-weight: 200!important; padding: 0px 10px 20px 10px !important; }
        .textIndent2                        {font-size: 18px !important; text-align: center !important; line-height: 20px !important; font-weight: 400!important; padding: 0px 10px 20px 10px !important; }
        body {-webkit-text-size-adjust: none;}
        }
        
        
@media only screen and (max-width: 320px) 
           {
         body                           {width:100%!important;}
         table table                    {width:280px!important; }
        .emailWrapper                   {width: 280px!important; }
        .contentWrapper                 {width: 260px!important; }
        .fullWidth                      {width: 260px!important; }
        .messageWrapper                 {width: 260px!important; }
        .splashScale                    {width: 260px!important; height: 153px!important; }
        .headerScale                    {width: 260px!important; }
        .mobileCenter                   {width: 260px!important; }
        .logo                           {width: 260px!important; height: 50px!important; margin-right: 0px!important; margin-left: 0px !important; }
        .imagePackages                  {width: 260px!important; height: 202px!important; margin-right: 0px!important; margin-left: 10px !important; margin-bottom: 20px!important; }
        .imageScale1                    {width: 260px!important; height: 153px!important;  margin-right: 0px!important; margin-bottom: 20px!important; }
        .imageScale1_last               {width: 260px!important; height: 153px!important; margin-bottom: 20px!important; margin-right: 0px !important; }
        .imageScale2                    {width: 260px!important; height: 153px!important;  margin-right: 0px!important; margin-bottom: 20px!important; margin-left: 10px !important; }
        .imageScale2_last               {width: 260px!important; height: 153px!important; margin-bottom: 20px!important; margin-right: 10px !important; }
        .mobileRemove                   {width: 0px !important; display: none !important;}
        .heading1                       {font-size: 20px !important; font-weight: 200!important; padding: 0px 0 0px 10px !important; }
        .textIndent                     {font-size: 14px !important; line-height: 20px !important; font-weight: 200!important; padding: 0px 10px 20px 10px !important; }
        .textIndent2                        {font-size: 13px !important; text-align: center !important; line-height: 20px !important; font-weight: 400!important; padding: 0px 10px 20px 10px !important; }
        body {-webkit-text-size-adjust: none;}
        .personal-info                  {padding-left: 10px !important;}
        .personal-info tr td            {padding-left: 10px !important;}
           }
           
</style>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<!-- START OF PAGE WRAPPER -->
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#343739">
  <tr>
    <td valign="top">
    
       
      <!-- START OF EMAIL WRAPPER -->
      <table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="emailWrapper" bgcolor="#F9F9F9">
        <tr>
          <td bgcolor="#F9F9F9" >
          
            <!-- START OF CONTENT WRAPPER -->
            <table width="630" border="0" align="center" cellpadding="0" cellspacing="0" class="contentWrapper" bgcolor="#F9F9F9">
                <tr>
                    <td bgcolor="#F9F9F9" >

                        <!-- START OF PERSONAL DATA CONFIRMATION -->
                        <table width="630" border="0" cellspacing="0" align="center" cellpadding="0" bgcolor="#F9F9F9">
                            <tr>
                                <td height="15" bgcolor="#F9F9F9"></td>
                            </tr>
                            <tr>
                                <td style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0; padding: 0px;text-align: left;border:0;border-collapse: collapse;" bgcolor="#F9F9F9">
                                     <!-- CONTENT -->
                                    <table style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0; padding: 0px;text-align: left;border:0;border-collapse: collapse;">
                                      <tr style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
                                        <th style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 10px;border:0;vertical-align:top;">fullname</th>
                                        <td style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 10px;border:0;vertical-align:top;">:</td>
                                        <td style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 10px;border:0;vertical-align:top;"><?= $first_name ?> <?= $last_name ?></td>
                                      </tr>
                                      <tr style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
                                        <th style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 10px;border:0;vertical-align:top;">Email</th>
                                        <td style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 10px;border:0;vertical-align:top;">:</td>
                                        <td style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 10px;border:0;vertical-align:top;"><?= $email ?></td>
                                      </tr>
                                      <tr style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
                                        <th style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 10px;border:0;vertical-align:top;">company</th>
                                        <td style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 10px;border:0;vertical-align:top;">:</td>
                                        <td style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 10px;border:0;vertical-align:top;"><?= $company ?></td>
                                      </tr>
                                      <tr style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
                                        <th style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 10px;border:0;vertical-align:top;">Phone</th>
                                        <td style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 10px;border:0;vertical-align:top;">:</td>
                                        <td style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 10px;border:0;vertical-align:top;"><?= $phone ?></td>
                                      </tr>
                                      <tr style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
                                        <th style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 10px;border:0;vertical-align:top;">Subject</th>
                                        <td style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 10px;border:0;vertical-align:top;">:</td>
                                        <td style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 10px;border:0;vertical-align:top;"><?= $subject ?></td>
                                      </tr>
                                      <tr style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
                                        <th style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 10px;border:0;vertical-align:top;">Message</th>
                                        <td style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 10px;border:0;vertical-align:top;">:</td>
                                        <td style="font-family: Helvetica Neue,  Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 10px;border:0;vertical-align:top;"><?= $message ?></td>
                                      </tr>
                                    </table>
                                    <!-- CONTENT -->
                        
                                </td>
                            </tr>
                            <tr>
                                <td height="15" bgcolor="#F9F9F9" colspan="2" class="mobileRemove" ></td>
                            </tr>
                        </table>            
                        <!-- END OF 3 COLUMN -->  
                        
                        
                        
                         

                                      
            
            
                        <!-- START SPACER -->
                        <table width="630" border="0" cellpadding="0" cellspacing="0" class="hr" align="center"  bgcolor="#F9F9F9" >
                          <tr>
                            <td height="40" align="left" valign="middle"></td>
                          </tr>
                         </table>
                         <!-- END SPACER -->
                         
                         
                         
                         
                        
                                
                            </td>
                          </tr>
                        </table>
                        <!-- END OF FOOTER WRAPPER -->
            

                        <!-- START OF COPYRIGHT WRAPPER -->  
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"  bgcolor="#42484D">
                          <tr>
                            <td valign="top" align="center" bgcolor="#42484D" >
                            
                            <!-- START OF COPYRIGHT -->
                            <table width="630" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#42484D" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;">
                                    <tr>
                                        <td valign="top" align="center" bgcolor="#42484D" style="font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #868A8D; padding: 20px 0 20px 0; line-height: 20px; font-weight: 200; text-align:center; vertical-align:top;" >
                                      &copy; <?= date('Y') ?> - All rights reserved</td>
                                </tr>
                                </table>
                                <!-- END OF COPYRIGHT -->
                          </tr>
                          <tr>
                        </table>
                        <!-- END OF COPYRIGHT WRAPPER -->

            
                    </td>
                </tr>
              </table><!-- END OF EMAIL WRAPPER -->
            
          </td>
        </tr>
      </table><!-- END OF CONTENT WRAPPER -->

    </td>
  </tr>
</table><!-- END OF PAGE WRAPPER -->

</body>
</html>