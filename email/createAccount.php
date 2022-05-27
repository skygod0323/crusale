<?php
$comment='<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ececec;">
	<tbody><tr>
		<td align="center" bgcolor="#ececec">
        	<table style="margin:0 10px;" border="0" cellpadding="0" cellspacing="0" width="640">
            	<tbody><tr><td height="20" width="640"></td></tr>
				<tr>
                <td class="w640" align="center" bgcolor="#438eb9" width="640">
        <table class="" border="0" cellpadding="0" cellspacing="0" width="640">
        <tbody><tr><td class="w30" width="30"></td><td class="" height="30" width="580"></td><td class="" width="30"></td></tr>
        <tr>
            <td class="" width="30"></td>
            <td class="" width="580">
                <div align="center">
                    <p style="font-size: 30px !important;color: #edf7f7; font-family: HelveticaNeue, sans-serif; font-size: 36px; text-align: left; margin-top:0px; margin-bottom:30px;">
                        <strong><singleline label="Title"><a style="color: #edf7f7; text-decoration: none;" href="http://'.$_SERVER['HTTP_HOST'].'" target="_blank">'.getWebSiteName().'</a></singleline></strong>
                    </p>
                </div>
            </td>
            <td class="w30" width="30"></td>
        </tr>
    </tbody></table>
</td>
           </tr>
                <tr><td class="" bgcolor="#ffffff" height="30" width="640"></td></tr>
                <tr id="simple-content-row"><td class="" bgcolor="#ffffff" width="640">
    <table class="" align="left" border="0" cellpadding="0" cellspacing="0" width="640">
        <tbody><tr>
            <td class="" width="30"></td>
            <td class="" width="580">
                <repeater>
                    
                    <layout label="Text only">
                        <table class="" border="0" cellpadding="0" cellspacing="0" width="580">
                            <tbody><tr>
                                <td class="" width="580">
                                   <p style="font-size: 14px; line-height:24px; margin-top:0px; margin-bottom:18px; font-family: HelveticaNeue, sans-serif;" align="left"><singleline label="Title">'.$lang[820].' '.$lang[37].'</singleline></p>
								   <p style="font-size: 14px; line-height:24px; margin-top:0px; margin-bottom:18px; font-family: HelveticaNeue, sans-serif;" align="left"><singleline label="Title"><a href=http://'.$_SERVER['HTTP_HOST'].'/emailVerify.php?u='.md5($row_latest_user->usr_id).' target=_blank>http://'.$_SERVER['HTTP_HOST'].'/emailVerify.php?u='.md5($row_latest_user->usr_id).'</a></singleline></p>
								   <p></p>
									<p style="font-size: 14px; line-height:24px; margin-top:0px; margin-bottom:18px; font-family: HelveticaNeue, sans-serif;" align="left"><singleline label="Title">'.$lang[821].'</singleline></p>
									<p style="font-size: 14px; line-height:24px; margin-top:0px; margin-bottom:18px; font-family: HelveticaNeue, sans-serif;" align="left"><singleline label="Title">'.getWebSiteName().' '.$lang[822].'</singleline></p>
                                </td>
                            </tr>
                            <tr><td class="w580" height="10" width="580"></td></tr>
                        </tbody></table>
                    </layout>
                    
                </repeater>
            </td>
            <td class="w30" width="30"></td>
        </tr>
    </tbody></table>
</td></tr>
                <tr><td class="w640" bgcolor="#ffffff" height="15" width="640"></td></tr>
                
                <tr><td class="w640" height="60" width="640"></td></tr>
            </tbody></table>
        </td>
	</tr>
</tbody></table>';
?>