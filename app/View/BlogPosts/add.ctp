<?php echo $this->Html->script(array('react','react-dom')); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.min.js"></script>

<style>
	.navbar-default{
		display:none;
	}



	.navbar-postAdd{
		color:black;
	}


	.intro-header .site-heading, .intro-header .post-heading, .intro-header .page-heading {
		padding-bottom:20px;
	}

	.videoContainer{
		height:30%;
		min-height: 500px;
	}

	iframe{
		height:100%;
		position:absolute;
		border:0;

	}

	.addButton{
		color:black;
	}


	.post-heading{
		color:black;
	}


	.blogPostImage{
		height:400px;
		background-repeat: no-repeat;
		background-position-x: 50%;
		background-size: contain;
	}



	#headingOne{
		font-size: 55px;
		color:white;
		background:transparent;
		border:0;
	}
</style>
<div id = "addViewContent">
</div>





<!-- youtube video modal -->
<div id="youtubeLinkModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Video</h4>
      </div>
      <div class="modal-body">
        <input type = "text" class="form-control" id = "youtubeLinkText" placeholder="Link to YouTube Video Here">
      </div>
      <div class="modal-footer">
        <button type="button" id = "submitVideoButton"class="btn btn-default" >Submit</button>
      </div>
    </div>

  </div>
</div>



<!-- add image modal -->
<div id="addImageModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Image</h4>
      </div>
      <div class="modal-body">
      		Select Image:
	        <select class="form-control" id = "imageSelect">
	           
	        </select>
      </div>
      <div class="modal-footer">
        <button type="button" id = "submitImageElementButton"class="btn btn-default" >Submit</button>
      </div>
    </div>

  </div>
</div>





<!-- upload image modal -->
<div id="uploadImageModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
    	  <button type="button" class="close" data-dismiss="modal">&times;</button>
    	  <h4 class="modal-title">Upload Image</h4>
    	</div>
    	<div class="modal-body">
    	  <form action="uploadImage" id = "imageUploadForm" method="post" enctype="multipart/form-data">
    	      <input type="file" name="fileToUpload" id="fileToUpload">
    	  </form>
    	</div>
    	<div class="modal-footer">
    	  <button type="button" id = "submitImageButton"class="btn btn-default" >Submit</button>

    	</div>		
      
    </div>

  </div>
</div>




<div className="blogPosts form" style = "display:none;">
<?php echo $this->Form->create('BlogPost'); ?>
	<fieldset>
		<legend><?php echo __('Add Blog Post'); ?></legend>
	<?php
		echo $this->Form->input('date');
		echo $this->Form->input('author');
		echo $this->Form->input('headline');
		echo $this->Form->input('content');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<script type="text/babel">



		var sampleText = 'Lorem ipsum dolor sit amet, et odio facete gloriatur usu. In zril consul abhorreant has, quo ut doming maluisset, ex solet splendide mei. Civibus accusam moderatius ut vel. Sit libris iriure at. Mel id tale nonumes, vel aliquam splendide cu. Commodo maluisset in ius, aliquid percipitur id pro, usu vivendo fabellas ea.';


		$(function(){
			$('#imageUploadForm').on('submit',(function(e) {
			        e.preventDefault();
			        var formData = new FormData(this);

			        $.ajax({
			            type:'POST',
			            url: $(this).attr('action'),
			            data:formData,
			            cache:false,
			            contentType: false,
			            processData: false,
			            success:function(data){
			            	alert(data);
			                console.log("success");
			                console.log(data);

			            },
			            error: function(data){
			                console.log("error");
			                console.log(data);
			            }
			        });
			    }));
			$("#submitImageButton").click(function(){
				$('#imageUploadForm').submit();
			});
		});




		function updateAvailableImages(){
			$.ajax({
			    type:'POST',
			    url: 'getImageNames',
			    success:function(data){
			        console.log("success");
			        var dataArray = $.parseJSON(data);
			        $("#imageSelect").html('');
			        for(var i = 1; i < dataArray.length; i++){
			        	$("#imageSelect").append('<option value="' + dataArray[i] + '">' + dataArray[i] + '</option>');
			        }
			        console.log(dataArray);

			    },
			    error: function(data){
			        console.log("error");
			        console.log(data);
			    }
			});
		}	
		



		



		var AddVideoButton = React.createClass({
			render:function(){
				return (<button className = "btn btn-lg btn-primary" onClick={this.handleClick}  ><span className="glyphicon glyphicon-plus"></span>Video</button>);
			},
	        handleClick: function () {
	        	$("#youtubeLinkModal").modal();
	            var handleClick  = this.props.handleClick;
	        	$("#submitVideoButton").click(function(){
	        		if(validateYouTubeUrl()){
	        			$("#submitVideoButton").off();
	        			
	        			handleClick({type:'video',attributes:{youtubeVideoId:youtube_parser($("#youtubeLinkText").val())},id:0});
	        			$(".close").click();
	        		}
	        		else{
	        			alert("Enter a Valid YouTubeUrl");
	        		}
	        	});
	         	
	        }
		});


		var AddParagraphButton = React.createClass({
			render:function(){
				return (<button onClick={this.handleClick} className = "btn btn-lg btn-primary" ><span className="glyphicon glyphicon-plus"></span>Paragraph</button>);
			},
	        handleClick: function () {

	         	this.props.handleClick();
	        }
		});


		var AddPictureButton = React.createClass({
			render:function(){
				return (<button onClick={this.handleClick} className = "btn btn-lg btn-primary" ><span className="glyphicon glyphicon-plus"></span>Picture</button>);
			},
	        handleClick: function () {
	        	
	         	updateAvailableImages();
	         	$("#addImageModal").modal();
	         	var handleClick = this.props.handleClick;

	         	$("#submitImageElementButton").click(function(){
	        		$("#submitVideoButton").off();
	        		handleClick({type:'image',attributes:{src:$("#imageSelect").val()},id:0});
	        		console.log(this.props);
	        		$(".close").click();
	        	});
	        }
		});






		var AddAudioButton = React.createClass({
			render:function(){
				return (<button className = "btn btn-lg btn-primary" ><span className="glyphicon glyphicon-plus"></span>Audio</button>);
			},
	        handleClick: function () {
	         
	        }
		});






//INPUT ELEMENT COMPONENTS


		var VideoElementInput = React.createClass({
			render:function(){
				return(
					<div className = "row">
						<div className = "col-xs-8 col-xs-offset-2 videoContainer">
							<iframe width="100%" height="100%" id="mainVideoFrame" src={"http://www.youtube.com/embed/" + this.props.youtubeId + "?rel=0&amp"}></iframe>
						</div>	
					</div>
				
				);
			}
		});



		var ParagraphElementInput = React.createClass({
			render:function(){
				return(
					<div className = "row">
						<div className = "col-xs-8 col-xs-offset-2 paragraphContainer">
							<p contentEditable={true} >{this.props.text}</p>
						</div>	
					</div>
				);
			}
		});



		var ImageElementInput = React.createClass({
			render:function(){
				return(
					<div className = "row">
						<div className = "col-xs-8 col-xs-offset-2">
							<div className = "blogPostImage" style={{backgroundImage: "url('../img/user/" + this.props.source + "')"}}></div>
						</div>	
					</div>
				);
			}
		});

		var BlogPostHeaderInput = React.createClass({
		  render: function() {
		  	var today = new Date();
		  	var dd = today.getDate();
		  	var mm = today.getMonth()+1; //January is 0!

		  	var yyyy = today.getFullYear();
		  	if(dd<10){
		  	    dd='0'+dd
		  	} 
		  	if(mm<10){
		  	    mm='0'+mm
		  	} 
		  	var today = dd+'/'+mm+'/'+yyyy;

		    return (
		      <header className="intro-header" style={{backgroundImage: "url('../img/post-bg.jpg')"}}>
		          <div className="container">
		              <div className="row">
		                  <div className="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
		                      <div className="post-heading">
		                          <h1><span contentEditable={true}>Click Here to Type In Headline</span></h1>
		                          <h2 className="subheading" contentEditable={true}>Type In Subheading</h2>
		                          <span className="meta">Posted on {today}</span>
		                      </div>
		                  </div>
		              </div>
		          </div>
		      </header>
		    );
		  }
		});



//CONTAINER COMPONENTS



		var AddPostView = React.createClass({
		  getInitialState: function() {
		      return {data: [],idCounter:0};
		  },	
		  addVideoToBlogPostContent:function(video){
			this.addVideoToData(video);
		  },
		  addParagraphToBlogPostContent:function(){
		  	this.state.data.push({type:"paragraph",attributes:{text:sampleText},id:this.state.idCounter});

		  	this.setState({data:this.state.data , idCounter: this.state.idCounter++});
		  },
		  addVideoToData:function(video){
		  	video.id = this.state.idCounter;
		  	this.state.data.push(video);
		  	this.setState({data:this.state.data , idCounter: this.state.idCounter++});
		  },
		  addImageToBlogPostContent:function(image){
		  	image.id = this.state.idCounter;
		  	this.state.data.push(image);
		  	this.setState({data:this.state.data , idCounter: this.state.idCounter++});
		  },	
		  render: function() {
		    return (
		    <div>	
		      <AddPostViewNavbar videoHandler = {this.addVideoToBlogPostContent} paragraphHandler = {this.addParagraphToBlogPostContent} imageHandler = {this.addImageToBlogPostContent}/>
		      <PostContent data = {this.state.data}/>
		    </div>  
		    );
		  }
		});

		var PostContent =  React.createClass({	 
		  render: function() {
		  	var postElements = this.props.data.map(function(element) {
		  		if(element.type == 'video')
		  	      return (
		  	        	<VideoElementInput youtubeId = {element.attributes.youtubeVideoId} />
		  	      );
		  	  	else if(element.type == 'paragraph')
		  	  		return (
		  	  		  	<ParagraphElementInput text = {element.attributes.text} />
		  	  		);
		  	  	else if(element.type == 'image'){
		  	  		return (
		  	  			<ImageElementInput source = {element.attributes.src } />
		  	  		);	
		  	  	}	

		  	});
		    return (
		      <div  id = "postContent">
		      	<BlogPostHeaderInput />
		      	{postElements}
		      </div>
		    );
		  }
		});


		var AddPostViewNavbar = React.createClass({
		  render: function() {
		    return (
		      <nav className="navbar navbar-postAdd  navbar-fixed-top">
		          <div className="container-fluid">
		              <div className="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		                  <ul className="nav navbar-nav navbar-center">
		                      <li>
		                          <AddParagraphButton handleClick = {this.props.paragraphHandler}/>
		                      </li>
		                      <li>
		                          <AddPictureButton handleClick = {this.props.imageHandler} />
		                      </li>
		                      <li>
		                          <AddAudioButton />
		                      </li>
		                      <li>
		                          <AddVideoButton handleClick = {this.props.videoHandler}/>
		                      </li>
		                      <li>
		                          <button className = "btn btn-lg btn-primary" data-toggle="modal" data-target="#uploadImageModal"><span className="glyphicon glyphicon-plus"></span>Upload Picture</button>
		                      </li>
		                  </ul>
		              </div>
		          </div>
		      </nav>
		    );
		  }
		});



		var VideoEditContainer = React.createClass({
			render:function(){
				return(<div className = "row"></div>)
			}
		});




		
		function validateYouTubeUrl()
		{
		    var url = $("#youtubeLinkText").val()
		        if (url != undefined || url != '') {
		            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
		            var match = url.match(regExp);
		            if (match && match[2].length == 11) {
		                return true;
		            }
		            else {
		                return false;
		            }
		        }
		}




		function youtube_parser(url){
		       var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
		       var match = url.match(regExp);
		       return (match&&match[7].length==11)? match[7] : false;
		}




		ReactDOM.render(
		  <AddPostView />,
		  document.getElementById('addViewContent')
		);
</script>

<!--
<div className="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Blog Posts'), array('action' => 'index')); ?></li>
	</ul>
</div>
-->