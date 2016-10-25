<?php echo $this->Html->css('cropper'); ?>
<?php echo $this->Html->script('cropper.js'); ?>


<style>

	.croppBox {
	    position: relative;
	    left: 0;
	    height: 100%;
	    max-height: 400px;
	}
	
	
	#errorMessage{
		color:#a94442;
	}

	#userImageCrop {
	    height: 100%;
	    width: 100%;
	}

	footer{
		display:none;
	}

	.users{
		margin-top:200px;
	}

	.loaderGif{
		height: 45px;
	}


	.submit input{
		margin-top:10px;
		width:100%;
		color:white;
		background: black;
		border:0;
		font-weight: 100;
	}
	.navbar-custom .nav li a {
	    color: black;

	}

	#signUpButton{
		width: 100%;
		color: black;
		margin-top:10px;
		border:1px solid black;
		background: white;
		font-weight: 100;
	}

	.modal-body input{
		width:70%;
		border-left:0;
		border-right:0;
		border-top:0;
		text-align:center;
	}

	.modal-body{
		text-align: center;
	}

	.modal-content{
		border-radius: 0;
	}

	.loginInput{
		width: 100%;
		margin-top: 5px;
	}

	#submitUser{
		width: 200px;
		color: black;
		border:1px solid black;
		background: white;
		font-weight: 100;
		margin-bottom: 50px;
	}

	#logInButton{
		width: 100%;
		color:white;
		margin-top:10px;
		border:1px solid black;
		background: black;
		font-weight: 100;
	}


	.errorMessage{
	    color: #a94442;
	}    

</style>

<div class="users form form-group col-xs-offset-2 col-xs-8 col-sm-4 col-sm-offset-4" ng-controller = "loginCtrl">
	
	    
	<div ng-model = "loginErrorMessage" ng-show="showError" class = "errorMessage">{{loginErrorMessage}}</div>
  	<input ng-model='username' type = "text" name="data[User][username]" class = "loginInput"/>
  	<input ng-model='password' type = "password"  name="data[User][password]" class = "loginInput"/>
    <button id = "logInButton" ng-click = "logInClicked()">Log In</button>
		    
	<button id = "signUpButton" ng-click = "signUpClicked()">Sign Up</button>
</div>

<!-- Sign Up Dialog -->
<div class="modal fade" id="signUpModal" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Sign Up</h4>
      </div>
      	<form  ng-controller = "signUpCtrl" id = "signUpForm" action= <?php echo $this->webroot."users/signup"?> class = "text-center" method="post">
	      <div class="modal-body">
	      		<p id = "errorMessage" ng-show="showError" ng-model="errorMessage"></p>
	      		<input type="email" name="data[email]" ng-model='username' class="" placeholder="Email" id="email" required>
	      		<input type="password" name="data[password]" ng-model='password' class="password" placeholder="Password" id="passwordOne" autocapitalize="none" required>
	      		<input type="password" name="data[password]" ng-model='passwordConfirm' class=" password" placeholder="ConfirmPassword" id="passwordTwo" autocapitalize="none" required>
	      </div>
	      <div class="row text-center">
	        <button type="submit" id = "submitUser" ng-click = "signUpButtonClicked()"class="">Sign Up</button>
	      </div>
  		</form>
    </div>
  </div>
</div>

 <!-- Modal -->
  <div class="modal fade" id="signUpSuccessfullModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Sign Up Successfull</h4>
        </div>
        <div class="modal-body">
          <p>Sign up successfull<br>You can now log in</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


<script>


	$(function(){
		

	






		$('#signUpForm').on('submit', function(e) {
		    e.preventDefault(); // prevent native submit
		    if(checkSignUpForm()){
		    	var data = {email:$("#email").val(),password:$("#passwordOne").val()}

		    	$.ajax({
		    	  type: "POST",
		    	  url: $('#signUpForm').attr('action'),
		    	  data: data,
		    	  success: function(text){
		    	  	if(text == "SUCCESS"){
		    	  		$("#errorMessage").addClass('hidden');
		    	  		$("#signUpSuccessfullModal").modal();
		    	  		$("#signUpModal").modal('hide');
		    	  		
		    	  	}else if(text == "USER_EXISTS"){
		    	  		$("#errorMessage").removeClass('hidden');
		    	  		$("#errorMessage").html('A user with this email already exists.');
		    	  	}else{
		    	  		$("#errorMessage").removeClass('hidden');
		    	  		$("#errorMessage").html('An Error Has Occurred');
		    	  	}
		    	  },
		    	  error: function(XMLHttpRequest, textStatus, errorThrown){
		    	  	console.log(XMLHttpRequest.responseText);
		    	  }
		    	});
		    }
		 });




								  

	});



	function showCroppingModal(){
		$("#picUploadModal").modal();
		var croppingCoOrdinates = {};
		setTimeout(function(){

			//Create the pictureEditor dialog
			var oldCropBox = document.getElementsByClassName("croppBox")[0];
			var	newCropBox = document.createElement('div');
			newCropBox.className = "croppBox";
			var newImage = document.createElement("img");
			newImage.id = "userImageCrop";
			newImage.src =  'img/tempUserPicture'+ SMART.user.getCurrentId()+'.jpg?'+ new Date().getTime() / 1000;
			$(oldCropBox).remove();
			newCropBox.appendChild(newImage);
			$('.bootbox-body').prepend(newCropBox);

			 $('#userImageCrop').cropper({
											aspectRatio: 1/ 1,
											autoCropArea: 4/5,
											strict: true,
											guides: true,
											highlight: true,
											dragCrop: false,
											movable: false,
											resizable: true,
											crop: function(data) {
											// Output the result data for cropping image.
											/*	croppingCoOrdinates.height = data.height;
												croppingCoOrdinates.width = data.width;
												croppingCoOrdinates.x = data.x;
												croppingCoOrdinates.y = data.y;*/
											}
										});
		},150);
	}

	

	function checkSignUpForm(){
		$("#errorMessage").addClass('hidden');
		if(!validateEmail($("#email").val())){
			$("#errorMessage").removeClass('hidden');
			$("#errorMessage").html('Please enter a valid e-mail address');
			return false;
		}else if($("#passwordOne").val().length < 6){
			$("#errorMessage").removeClass('hidden');
			$("#errorMessage").html('Password must be at least six characters long');
			return false;
		}else if($("#passwordOne").val() != $("#passwordTwo").val()){
			$("#errorMessage").removeClass('hidden');
			$("#errorMessage").html('Passwords do not match');
			return false;
		}
		return true;
	}

	function validateEmail(email) {
	  var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	  return re.test(email);
	}
</script>
