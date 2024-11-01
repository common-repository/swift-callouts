<?php

/* scbsConstants.php
 * 
 * Plugin constants
 * 
 * PHP version 5
 * 
 * @author      Rane Wallin
 * @copyright   SwiftWP
 * @license     GPLv2
 * @version     0.8.5
 * @link        http://swiftwp.com/swift-callouts-swiftwp-wordpress-callout-plugin/
 * 
 */

// Nonce ids
define("SCBS_UPDATE_NONCE", "ecbs-edit-templates-nonce");
define("SCBS_DELETE_NONCE", "ecbs-delete-templates-nonce");

// Array indexes for various things in the get_style_data() array
define("ECBS_VALUE_TYPE", 0);
define("ECBS_NICE_NAME", 1);
define("TOOL_TIP", 2);
define("ECBS_TEMPLATE_NAME", 0);
define("ECBS_RADIO_OPTIONS", 3);

// Used to indicate that a template being added should not
// overwrite an existing template. This is only used
// when the plugin is activated, in case the user already
// has data in their database for the plugin
define("NO_OVERWRITE", false);

// successes
define("SUCCESS", "success");
define("TEMPLATE_DELETED", "Template deleted!");


// Errors and failures
define("ECBS_PX_FAIL", "%s: Needs to be a number.\n" );
define("ECBS_HEX_FAIL", "%s: Needs to be a hexidecimal value.\n" );
define("ECBS_SHADOW_FAIL", "Shadow needs to be in the format: XXpx YYpx ZZpx #HEXCOL, where ZZpx and #HEXCOL are both optional and ZZpx needs to be positive and #HEXCOL is a color in hexidecimal value.");
define("ECBS_DEFAULT_FAIL", "Something went wrong.");
define("ECBS_ID_FAIL", "The id can only contain letters and numbers, no spaces, dashes, underscores, or special characters.\n");
define("ECBS_NAME_FAIL", "Template name can only contain letters, numbers and spaces. No dashes, underscores, or special characters.\n");
define("BAD_NONCE", "Invalid referrer.");
define("NOT_PERMITTED", "You do not have permission to access this page.");
define("NO_DATA", "No data to display!");
define("NO_TEMPLATES", "No templates available.");
define("NOT_TEMPLATE", "That is not a valid template.");
define("CANNOT_DELETE", "Unable to delete template.");
define("CANNOT_DELETE_DEFAULT", "You cannot delete the default template.");
define("SELECT_TEMPLATE_DELETE", "Please select template to delete.");
define("UNSET_FAILED", "Unset failed.");

// Various strings used in methods
define("ECBS_TEMPLATE_ID", "ecbs-template-id");
define("NICE_NAME", 'ecbs-nice-name');
define("IN_TEXTAREA", "default-content");
define("ECBS_TEMPLATES", "ecbs_callout_templates");
define("DEFAULT_TEMPLATE", "default");
define("ECBS_ADMIN_STYLESHEET", "ecbs-admin-stylesheet");
define("ECBS_PATHS", dirname(__FILE__) . '/../paths.php');

// html
define("TEMPLATE_UPDATED", "<h2 id=\"ecbs-updated\">Template updated!</h2>");

// The stuff at the top of the page in the admin submenu
define("ADMIN_HEAD", <<< HED
<div class="ecbsAdmin">
<br> For more information about using this plugin, visit our site at <a href="http://swiftwp.com/swift-callouts-swiftwp-wordpress-callout-plugin/" target="_blank">SwiftWP.com</a>.
<br>
<h1 class="ecbsAdmin">Swift Callouts Manager</h1>
<br>
<br>
<hr>
<br>
<br> 
HED
        );

// The close of the edit pane div
define("EDIT_AREA_DIV", <<< EDIV
<hr>

<div id="ecbs-edit-area"> 
</div>
<input id="ajax_button" type="submit" value="Update Template"><input type="button" value="Delete Template" id="ecbs-delete-template">
EDIV
        );

// The html used to format the dropbox that displays the template names
define("TEMPLATE_DROP_BEFORE", <<< B4DROP
        <form id="ecbs-show-templates">
        <input type="hidden" name="action" value="delete_template" />
B4DROP
        );
define("TEMPLATE_DROP_AFTER", <<< AFTDROP
<label for="ecbs_styles">Select a Template to Edit:</label>
<select id="ecbs_styles">
<option value="dummy">Select Template</option>
%s
<option value="new">New Template</option>
</select>
</form>
AFTDROP
        );

// This is the head of the edit pane in the admin submenu
define("EDIT_FORM_HEADER", <<< ECBS_FHED
<div id="ecbs-options-form">
<form  method="post" action="admin-post.php" id="ecbs-edit-template">
<input type="hidden" name="action" value="update_template" />
        %s
<table style="table-layout: fixed">
<tr>
<td>
<label for="shortcode-text">Shortcode</label>
</td>
<td>
[callout template="%s"]Your Text Here[/callout]
</td>
</tr>
<tr>
<td>
<label for="template-id">Template ID</lable>
</td>
<td>
<input name ="ecbs-template-id" type="text" value="%s" %s>
</td>
</tr>
ECBS_FHED
        );

// Creates the input text boxes where the user can specify the values for
// the editable stypes. 
define("STYLE_INPUTS", <<< TMP_FORM
<tr> %s
<td>
<input type="text" style="width:90%%" name="%s" value="%s" onLoad="this.value='%s'">
</td>
</tr>   
TMP_FORM
        );

//define("RADIO_STYLE", "%s%s");

// Builds the labels for the editable styles in the admin edit pane. Also
// adds a help icon that displays a tip when the user mouses over it.
define("LABEL_FORMAT", <<< ECBS_TMP
<td>
<i class="icon-question-sign" style="color: grey;"  onMouseover="ddrivetip('%s')";
onMouseout="hideddrivetip()"></i> <lable onMouseover="ddrivetip('%s')"; onMouseout="hideddrivetip()" style="align:left" for="%s">%s</label>
</td>
ECBS_TMP
        );

// Builds the radio input tags. Found in the scbsAdminMenu class
define("RADIO_FORMAT", <<< RDO
<input type="radio" name="%s" value="%s" %s%s
RDO
);

// Builds the textarea. Found in the scbsAdminMenu class
define("EDIT_TEXTAREA", <<< EDITP
</table>

</form>
</div> 
<div id="ecbs-textbox-area">
<p align="center"><label onMouseover="ddrivetip('Use this area to create any static content that appears inside the callout. You can use any HTML formatting you wish.')";
onMouseout="hideddrivetip()" for="default-content">Default Content (Optional)</label></p>
<p align="center"><textarea rows="25" style="width:90%" 
    id="default-content" name="default-content" form="ecbs-edit-template">
EDITP
);
            
// Closes the textarea divs. Used in the scbsAdminMeny class
define("EDIT_TEXTAREA_END",  "</textarea></p></div>");


// The script to create tool tips when the user mouses over the help icon.
// This is added to the foot of the page with the admin-footer filter.
define("TOOL_TIP_SCRIPT", <<< TT_SCRIPT
<div id="dhtmltooltip"></div>

<script type="text/javascript">

/***********************************************
* Cool DHTML tooltip script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

var offsetxpoint=0 //Customize x offset of tooltip
var offsetypoint=0 //Customize y offset of tooltip
var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip(thetext, thecolor, thewidth){
if (ns6||ie){
if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
tipobj.innerHTML=thetext
enabletip=true
return false
}
}

function positiontip(e){
if (enabletip){
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20

var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth)
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : window.pageXOffset+e.clientX-tipobj.offsetWidth+"px"
else if (curX<leftedge)
tipobj.style.left="5px"
else
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetxpoint+"px"

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight)
tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint+"px"
else
tipobj.style.top=curY+offsetypoint+"px"
tipobj.style.visibility="visible"
}
}

function hideddrivetip(){
if (ns6||ie){
enabletip=false
tipobj.style.visibility="hidden"
tipobj.style.left="-1000px"
tipobj.style.backgroundColor=''
tipobj.style.width=''
}
}

document.onmousemove=positiontip

</script>
TT_SCRIPT
	);

        
// style_data strings used in the get_style_data() method in the scbsTemplate class
define("NICE_NAME_TIP", "This is a name used for your own reference. It shows up in the drop down menu above.");
define("FLOAT_TIP", "Float left means text wraps to the right of the callout and float right means text wraps to the left. To prevent wrapping, set float to none.");
define("BG_COLOR_TIP", "This is the background color inside of the callout. It needs to be a hexidecimal value.");
define("BRDR_COLOR_TIP", "This is the color of the border around the callout. It should be a hexidecimal value.");
define("BRDR_STYLE_TIP", "This controls the appearance of the border around the callout. For no border, select none.");
define("BRDR_WDTH_TIP", "This controls the thickness of the border.");
define("BRDR_RAD_TIP", "This allows you to create callouts with rounded corners. Set the border radius to a value in pixels (px) to control how rounded the edges appear.");
define("MARGIN_TIP", "The margin is the area outside of the callout. It controls how close text gets to the outside border. It can be a value in either pixels (px) or percent (%).");
define("PADDING_TIP", "The padding is the area inside the callout. It controls how close text and other elements get to the inside border. It can be a value in either pixels (px) or percent (%).");
define("WDTH_TIP", "Sets the maximum width of the callout. It can be a value in either pixels (px) or percent (%).");
define("HEIGHT_TIP", "This controls the maximum height of the callout. It can be a value in either pixels (px) or percent (%). Leave blank to allow the contents to determine the height.");
define("TXT_COLOR_TIP", "This controls the color of the text inside the callout. It should be a hexidecimal value.");
define("SHADOW_TIP", "This allows you to add a shadow to the callout. It needs to be in the format XXpx YYpx ZZpx #HEXCOLOR, where XXpx is the horizontal shadow, YYpx is the vertical shadow, ZZpx is the shadow blur and #HEXCOLOR is the shadow color in hexidecimal value. Only the first two values are required. The shadow blur and shadow color are both optional.");