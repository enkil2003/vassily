<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vassilymas</title>
<style type="text/css">
/* Client-specific Styles */
#outlook a{padding:0;} /* Force Outlook to provide a "view in browser" button. */
body{width:100% !important;} .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail to display emails at full width */
body{-webkit-text-size-adjust:none; -ms-text-size-adjust:none;} /* Prevent Webkit and Windows Mobile platforms from changing default font sizes. */
/* Reset Styles */
body{margin:0; padding:0;}
img{height:auto; line-height:100%; outline:none; text-decoration:none;}
#backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}
/** 3. Yahoo paragraph fix: removes the proper spacing or the paragraph (p) tag. To correct we set the top/bottom margin to 1em in the head of the document. Simple fix with little effect on other styling. You do not need to move this inline. NOTE: It is also common to use two breaks instead of the paragraph tag but I think this way is cleaner and more semantic. NOTE: This example recommends 1em or 1.12 em. More info on setting web defaults: http://www.w3.org/TR/CSS21/sample.html or http://meiert.com/en/blog/20070922/user-agent-style-sheets/
INLINE: Yes.
**/
p {
margin: 1em 0;
}
/** 4. Hotmail header color reset: Hotmail replaces your header color styles with a green color on H2, H3, H4, H5, and H6 tags. In this example, the color is reset to black for a non-linked header, blue for a linked header, red for an active header (limited support), and purple for a visited header (limited support).  Replace with your choice of color. The !important is really what is overriding Hotmail's styling. Hotmail also sets the H1 and H2 tags to the same size.
INLINE: Yes.
**/
h1, h2, h3, h4, h5, h6 {
color: black !important;
line-height: 100% !important;
}
h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
color: blue !important;
}
h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
color: red !important; /* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
}
h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
color: purple !important; /* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
}
/** Outlook 07, 10 Padding issue: These "newer" versions of Outlook add some padding around table cells potentially throwing off your perfectly pixeled table.  The issue can cause added space and also throw off borders completely.  Use this fix in your header or inline to safely fix your table woes.
78. 
79.More info: http://www.ianhoar.com/2008/04/29/outlook-2007-borders-and-1px-padding-on-table-cells/
80.http://www.campaignmonitor.com/blog/post/3392/1px-borders-padding-on-table-cells-in-outlook-07/
81. 
82.H/T @edmelly
83. 
84.INLINE: No
85.**/
table td {
border-collapse:collapse;
}
/** BONUS: Adaptation of Brian Thies (Campaign Monitor) link color fix to render the Yahoo Short Cuts invisible. Yahoo short cuts are links that Yahoo places over certain text in your email without your knowledge.  In order to use this fix you need to make the text color the same of the actual font color of your email and reset a few elements. IMPORTANT: You then need to use the Responsys/Smith Harmon link color fix (#7) if you want to style your links to the color you want them to be.  If you don't, this fix will change all links to black in Yahoo. 
92. 
93.If you are not worried about Yahoo's shorcuts, just remove this code.  This is not applicable for Yahoo Classic.
94. 
95.INLINE: No.
96.**/
.yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span { color: black; text-decoration: none !important; border-bottom: none !important; background: none !important;} /* Body text color for the New Yahoo.  This example sets the font of Yahoo's Shortcuts to black. */
</style>
<style>
body {
    font-family: "Trebuchet MS", sans-serif !important;
    font-size: 13px;
}
.remark {
    color: #A70B16 !important;
}
</style>
</head>
<body>
<!-- 5. Wrapper/Container Table: Use a wrapper table to control the width and the background color consistently of your email. Use this approach instead of setting attributes on the body tag. -->
<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
  <tr>
    <td>
      <!-- 6. Tables are the most common way to format your email consistently. Set your table widths inside cells and in most cases reset cellpadding, cellspacing, and border to zero. Use nested tables as a way to space effectively in your message. -->
      <table cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td><img src="http://<?php echo $_SERVER['HTTP_HOST']?>/images/emailLogo.png" alt="vassilymas" title="vassilymas" style="display:block;" /></td>
        </tr>
        <tr>
          <td>
            <p>Hola <span class="remark">Bernardo Gatti</span>,</p>
            <p>Has solicitado un cambio de contraseña. Pero para ello requerimos tu confirmación.<br />
              Puedes confirmar el cambio de contraseña haciendo <a target ="_blank" style="color: #A70B16;
                text-decoration:none;" href="<?php echo $this->url?>">click aquí - Confirmar cambio de contraseña</a>
            </p>
            <p>Solo tienes 24 horas para confirmar el cambio de contraseña.</p>
            <p>Muchas Gracias</p>
            <p>Cualquier consulta o pregunta que desees realizar,
              por favor, escribinos a:
              <a href="mailto:info@vassilymas.com.ar" style="color: #A70B16; text-decoration:none;" target ="_blank"
                title="">info@vassilymas.com.ar</a>
            </p>
          </td>
        </tr>
        <tr>
          <td>
            <p><strong>vassily<span class="remark">mas</span>!</strong><br />
              <a href="mailto:info@vassilymas.com.ar" style="color: #000; text-decoration:none;" target ="_blank"
              title="">www.vassilymas.com.ar</a>
            </p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table> 
</body>
</html>