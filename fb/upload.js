var fbUserId=Math.floor(Math.random()*1000000);//FIXME

//button click event to choose image
function on_select_image_button_click(e){
	var hidden_area = document.getElementById("hidden_area");
	if(!hidden_area){
		hidden_area=document.createElement("div");
		hidden_area.id="hidden_area";
		hidden_area.style.display="none";
		document.body.appendChild(hidden_area);
	}

	var filetag = document.createElement("input");
	filetag.setAttribute("type", "file");
	hidden_area.appendChild(filetag);
	filetag.onchange=on_file_change;
	filetag.click();
}

//file selected 
function on_file_change(){
	var files = this.files;
	for( var i = 0; i < files.length; i++ )
	{
		var file = files[ i ];
		var imageType = /^image\//;
		if( !file.type.match( imageType ) ){continue;}
		load_image(file);
		break;
	}
}

//load blob image not to use large memory
function load_image(file){
console.log("image loading");
$("#message").text("image loading");
	var image = document.createElement("img");
	document.getElementById("hidden_area").appendChild(image);
	image.onerror = onImageError;
	image.onload = onImageLoad;
	var createObjectURL = (window.webkitURL && window.webkitURL.createObjectURL) || (window.URL && window.URL.createObjectURL);
	image.src = createObjectURL(file);
}

function onImageLoad(e){
console.log("image onload");
$("#message").text("image onload");
	var image=this;
	var revokeObjectURL = (window.webkitURL && window.webkitURL.revokeObjectURL) || (window.URL && window.URL.revokeObjectURL);
	revokeObjectURL(image.src);

	var JPEG_QUALITY = 0.8;
	
	var imageWidth=image.width;
	var imageHeight=image.height;
	var targetWidth,targetHeight;
	if(imageWidth>imageHeight){
		targetWidth=800;
		targetHeight=targetWidth*imageHeight/imageWidth;
	}else{
		targetHeight=800;
		targetWidth=targetHeight*imageWidth/imageHeight;
	}

	var canvas = document.createElement("canvas");
	canvas.width = targetWidth;
	canvas.height = targetHeight;
	var context = canvas.getContext("2d");
	context.drawImage(image, 0, 0, imageWidth, imageHeight, 0, 0, targetWidth, targetHeight);
	var resized_dataurl=canvas.toDataURL("image/jpeg", JPEG_QUALITY);
	
$("#message").append("<br>\nresized width="+ targetWidth +",height="+ targetHeight);
$("#message").append("<br>\nuploading size="+resized_dataurl.length);

	//release memory
	image.onload=null;
	image.onerror=null;
	image.src="";
	
	//release memory
	var hidden_area=document.getElementById("hidden_area");
	while (hidden_area.firstChild) {hidden_area.removeChild(hidden_area.firstChild);}
	document.body.removeChild(hidden_area);
	
	//send resized image data url to server
	$.ajax({
		type:"POST",
		url:"receive_image.php",
		data:{"img64":resized_dataurl,
		"userid":'facebook-' + fbUserId}
	}).done(function(ret){
		console.log("ret="+ret);
$("#message").append("<br>\nuploaded "+ret);
	});
}

//image load error
function onImageError(e) {
	console.log("image onerror");
	console.log(e);
	$("#message").text("image load error");
}

//initialization
$(function() {
	var createObjectURL = (window.webkitURL && window.webkitURL.createObjectURL) || (window.URL && window.URL.createObjectURL);
	if (!createObjectURL) {
		$("#message").text("This browser is not supported for `createObjectURL`");
	}else{
		if(window.touchstart){
			$("#select_image_button").bind("touchstart",on_select_image_button_click);
		}else{
			$("#select_image_button").bind("click",on_select_image_button_click);
		}
	}
});
