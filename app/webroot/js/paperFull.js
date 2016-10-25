var PaperFull = React.createClass({
	getInitialState:function(){
	    return {data:{}};
  	},
	componentDidMount:function(){
		$.ajax({
		    type: "POST",
		    data:{id:this.props.params.id},
		    url:'ResearchPapers/getPaperById',
		    success:function(message){
		      var newData = JSON.parse(message);
		      this.setState({data:newData});
		    }.bind(this)
		});
	},
	render:function(){

		var classHelper1 = "spinnerLarge";
		var classHelper2 = "";
		var classHelper3 = "";
		//If no paper is yet loaded show loading message and hide the paper related text
		if(Object.size(this.state.data) != 0){
			classHelper1+=" hidden";
			classHelper2 = "hidden";
		}else{
			classHelper3="hidden";				
		}	

		return(
			<div className="row text-center paperFull">
				<h2 className={classHelper2}>Loading Paper</h2>
				<img src="img/spinner.gif" className={classHelper1}/>
				<div className={classHelper3}>
					<h2>{this.state.data.title}</h2>
					<p>{this.state.data.author}</p>
					<h4>{this.state.data.pub_date}</h4>
					<h2>Gene: {this.state.data.gene}</h2>
					<h2>Technique: {this.state.data.technique_group}</h2>
					<h2>{this.state.data.figure_number}</h2>
					<h4>Published By: {this.state.data.publisher}</h4>
				</div>	
			</div>
		);
	}
});