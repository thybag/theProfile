/**
 * Key functions for theProfile Website
 * 
 * @author Carl Saggs (cs305@kent.ac.uk)
 * @version 1.7
 * 	
*/


var myDialog;		// Dialog Reference
var mergeDialog;	// Merge Dialog reference
var dialogexist = 0;	// Dialog set check
var mdialogexist = 0;	// Merge set check

/**
 * Sync Function for attached accounts.
 * Makes an ajax call to the sync function of the provided account, shows a 
 * loading gif so the user can tell its working.
 * 
 * @param myUrl Link to the Sync function of the appliction the user wants to sync
 * @param Object img A reference to the Image DOM object that was clicked to call this function
 */
function app_update(myUrl, img){
	//Store the original icon src
	var orig = img.src;
	//Set the image to display a spinner gif
	img.src = siteRoot +'/img/ajax-loader.gif';
	//Perform ajax get on myUrl
	dojo.xhrGet({
		url: myUrl,
		handleAs: "text",
		load: function(data){
			//On return set the img object back to its original picture
			img.src = orig;
			//Check for any updates as a result of the sync
			checkSync();
		}
	});
}

/**
 * Check sync
 * Uses the check page to determine if any data needs to be syncronised via merge
 * If so, launches the merge dialog
 */
function checkSync(){
	//Perfom ajax get on check url
	dojo.xhrGet({
		url: siteRoot+"/sync/check/",
		handleAs:"text",
		preventCache: true,
		load: function(data){
			//if check url returns 1, then sync is wanted
			if(data == 1){
				//check if the merge dialog exists already
				if(mdialogexist == 0){
					//create a new merge dialog if not.
					mergeDialog = new dijit.Dialog({
						title: "New data found",
						style: "width: 600px",
						href: siteRoot+"/sync/load/",
						preventCache : true,
					});
				} 
				mdialogexist = 1;
				//Display merge dialog
				mergeDialog.show();
			}
		}
	});
}

/**
 * Merge Select
 * Simple bit of code used to highlight/unhighlight selected options during a merge
 * 
 * @param itm DOM reference to itm selected
 */
function mergeSelect(itm){
	//get the id of the item clicked
	var itm_id = dojo.attr(itm, 'id');
	//Pull the range tag to find out how many items are in this row
	var range = dojo.attr(itm, 'range')
	//Get the ID minus the number on the end
	var other = itm_id.substring(0, itm_id.length-1);
	//Set the hidden forms value to the value of the selected block
	dojo.byId(other+0).value = itm.innerHTML;
	//For each block in this line remove the mergeSelected class.
	for(i=1; i <= range; i++ ){
		 dojo.removeClass(other+i, "mergeSelected");
	}  
	//Add the class to the clicked item
	dojo.addClass(itm.id, "mergeSelected");
}

/**
 * showDialog
 * General function for displaying dojo dialogs
 * 
 * @param String name Title of the Dialog
 * @param String url Location of the contents for the dialog
 * @param String zone used to calcuate ID for ajax refresh of content
 */
function showDialog(name, url, zone){
	//if zone isn't specified, set it to empty
	if(!zone){ var zone = '' };
	//if dialog does not already exist
	if(dialogexist == 0){
		//create new dialog.
		myDialog = new dijit.Dialog({
			title: "Bla",
			style: "width: 400px; text-align: left;"
		});
		dialogexist = 1;
	}
	//Set dialog attributes, href is the location of the cotent shown within it.
	myDialog.attr('title', name);
	myDialog.attr('href', url);
	myDialog.attr('zone', zone);
	//display dialog
	myDialog.show();
	//return false so href does not active on link
	return false;
}   
var dbg;

/**
 * dialogSave
 * General function to save forms in dialogs
 * 
 * @param String cform Reference to from dijit
 */
function dialogSave(cform){
	//check form pass's validation (if not return false)
	if(!cform.validate()){return false;}
	
	//Post details to forms sumbit url
	dojo.xhrPost({
		form: cform.attr('id'),
		load: function(data, ioArgs){
			//If data is empty, the form saved ok.
			if(data == ''){
				//hide the dialog and refresh the relevent zone
				myDialog.hide();
				refreshContent();
			}else{
				//if not, cake returned validation errors of its own
				//the html is contained in the responce so just set it in to
				//the current dialog
				myDialog.attr('content', data);
			}
			//Check for any flash messages
			checkFlash();
		},
		error: function(err, ioArgs){
			//error message here?
			alert("oops! Try again, hopefully this was just a server hiccup");
		}
	});
	return false;
}
/**
 * Check flash
 * checks for any new flash messages via ajax and displays them on the page
 * if found.
 */
function checkFlash(){
	//ajax request to getFlash view.
	dojo.xhrGet({
		url: siteRoot+"/users/getFlash",
		handleAs:"text",
		preventCache: true,
		load: function(data){
			//If data is returned, a flash must have been set, display it to the user
			if(data !== ''){
				dojo.byId('flashZilla').innerHTML = data;
			}
		}
	});
}

/**
 * refreshContent
 * Updates the content of a "zone" on a profile via ajax
 */
function refreshContent(){
	//Try to grab the last zone set to the dialog
	var z = myDialog.attr('zone');
	//Return false if zone cannot be found
	if(z=='') return false;
	if(z==null) return false; 
	//Generate ID of zone
	var node = dojo.byId('z_'+z);
	//Fade zone out temporarily
	dojo.fadeOut({ node: node}).play();
	//Request updated content for zone via ajax get call
	dojo.xhrGet({
			url: siteRoot+"/ajax_zone/"+z,
			handleAs: "text",
			preventCache: true,
			load: function(data){
		 		//Write the returned data in to the zone
				dojo.byId(node).innerHTML = data;
				//Fade zone back in so user can see it.
				dojo.fadeIn({ node: node}).play();
	 		}
	});
}

/**
 * toolTipr
 * Dynamically generates tooltips when called.
 * 
 * @param itm DOM reference to clicked object
 */
function toolTipr(item){
	//Set tooltip text useing item Objects alt value
	var text = '<div style="width:180px;">' + item.getAttribute("alt") + '</div>';
	//Create tooltip dojo Object and attach it to the clicked item
	var x = new dijit.Tooltip({label: text, connectId: item, position: 'above'});
	//remove items on mouse over since tooltip is only needed once
	item.onmouseover = '';
	//show tooltip
	x.open(item) ;
}