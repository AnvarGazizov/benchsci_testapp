<?php echo $this->Html->css('cropper'); ?>
<?php echo $this->Html->script(array('cropper.js','exif.js')); 
	echo $this->Html->scriptBlock(sprintf('address = "%s";', $address));
?>


<style>

	#addressInput{
		margin-top:20px;
	}

	.croppBox {
	    position: relative;
	    left: 0;
	    height: 100%;
	    max-height: 400px;
	}

	#userImageCrop {
	    height: 100%;
	    width: 100%;
	}

	.whiteButton{
		width: 200px;
		color: black;
		border:1px solid black;
		background: white;
		font-weight: 100;
		margin-bottom: 50px;
		margin-top:15px;
	}


	.blackButton{
		border:0;
		width: 200px;
		color: white;
		background: black;
		font-weight: 100;
		margin-bottom: 50px;
		margin-top:15px;
	}

	.blackButton a{
		color:white;
		text-decoration: none;
	}

	#userImage{
		height: 150px;
		border-radius: 10px;
	}


	input{
		border-left:0;
		border-right:0;
		border-top:0;
		text-align:center;
		border-bottom: 1px solid black;
	}



</style>
<div class = "row text-center" ng-controller="profileViewCtrl" ng-init="<?php echo "address = '".$address."'";?>" >
	
	<br>
	<h2><?php echo $userName; ?></h2>
	<input id = "picInput" class = "hidden" ng-model="picInput" ng-change="pictureInputChange($event)" type = "file" name="upl" class = "input file" fileread="vm.uploadme">
	<img id="userImage" src=<?php echo "../img/".$userImageURL ?> >
	<div id="tempUploadStatus" class = "text-center hidden">
	      		 <img src="../img/spinner.gif" class = "loaderGif"></img>
	      		<div class = "text-center">Uploading</div>
	</div>
	<br>
	<button type="submit" class="whiteButton" id = "changePhoto">Upload New Photo</button>
	<div id="locationField">
		Address:
		<br>
	  <input id="autocomplete" data-userAddress = <?php echo "'".$address."'";?> placeholder="Enter your address"
	         onFocus="geolocate()"  ng-model = "address" ng-change="adressChanged()" type="text" />
	</div>
	<button type="submit" class="whiteButton" ng-click="updateAddress()" ng-show="addressLength" id = "updateAddress">Update Address</button>
	<br>
	<button type="submit" class="blackButton" ng-click="logout()" id = "logout">Log Out</button>

</div>


<div class="modal fade" id="picUploadModal" tabindex="-1" role="dialog" ng-controller="uploadPhotoModalCtrl" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Upload New Picture</h4>
      </div>
	      <div class="modal-body">
	      		<div class="croppBox">
	      			<img id="userImageCrop" data-userid =<?php echo $userId; ?> >
	      		</div>
	      		<div id="pictureUploadStatus" ng-show = "uploadGIFShow" class = "text-center">
	      		 <img src="../img/spinner.gif" class = "loaderGif"></img>
	      		<div class = "text-center">Uploading</div>
	      		</div>
	      </div>
	      <div class="row text-center">
	        <button type="submit" id = "imageCropButton" ng-click = "cropImage()" ng-show="imageCropButtonShow" class="whiteButton">Upload</button>
	      </div>
    </div>
  </div>
</div>
<script>


	


	function openCroppingDialog(dataURI){
			$("#tempUploadStatus").removeClass('hidden');
			$("#userImage").addClass('hidden');
			EXIF.getData(imageFile, function(){
					
				   var formData = new FormData();
				   formData.append("imageFile",dataURI);
				   formData.append('Orientation',this.exifdata['Orientation']);
				  
				   setTimeout(function(){
				   	console.log( typeof formData.get('imageFile'));
				   $.ajax({
					 type: "POST",
					 url: 'saveTempImage',
					 data: formData,
					 success:function(message){
						//If the request was sucessfull alert the user 
						console.log(message);
						if(message.indexOf("SUCCESS") > -1){
								$("#tempUploadStatus").addClass('hidden');
								$("#userImage").removeClass('hidden');
								showCroppingModal();
							  
							
						}	
					 },
					 error: function (xhr, ajaxOptions, thrownError) {
						console.log(xhr.responseText);
					console.log(xhr.status);
					console.log(thrownError);
					 },
					 contentType:false,
					 processData:false
				   });
				},1000);

			});
			
			
			
	}


</script>
<?php echo $this->Html->script(array('addressInputAutoComplete.js')); ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUS3WO3zWidbU25rBJb_HlW-7gtjnpxt0&libraries=places&callback=initAutocomplete"
        async defer></script>	