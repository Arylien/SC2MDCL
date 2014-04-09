$(function() {
    $('#file_upload').uploadify({
        'swf'      			: 'js/uploadify/uploadify.swf',
        'uploader' 			: 'js/uploadify/uploadify.php',
		'folder'    		: '../../banks/',
		'auto'            	: false,              		// Automatically upload files when added to the queue
		'buttonText'      	: 'Add Bank File(s)',	// The text to use for the browse button
		'checkExisting'   	: true,              		// The path to a server-side script that checks for existing files on the server
		'fileObjName'     	: 'Filedata',         		// The name of the file object to use in your server-side script
		'fileSizeLimit'   	: '5MB',		             	// The maximum size of an uploadable file in KB (Accepts units B KB MB GB if string, 0 for no limit)
		'fileTypeDesc'    	: 'SC2Bank',        		// The description for file types in the browse dialog
		'fileTypeExts'    	: '*.SC2Bank',             // Allowed extensions in the browse dialog (server-side validation should also be used)
		'method'          	: 'post',             		// The method to use when sending files to the server-side upload script
		'multi'           	: true,               		// Allow multiple file selection in the browse dialog
		'progressData'    	: 'percentage',       		// ('percentage' or 'speed') Data to show in the queue item during a file upload
		'removeCompleted' 	: true,               		// Remove queue items from the queue when they are done uploading
		'onQueueComplete' 	: function(queueData) {
            location = 'upload.php?upload=complete';
        }
		
    });
});