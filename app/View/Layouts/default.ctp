<?php echo $this->Html->css(array('bootstrap','main')); ?>
<?php echo $this->Html->script(array('react','react-dom','browser.min','jquery','bootstrap')); ?>
<script src="https://d3js.org/d3.v4.min.js"></script>
<script src="https://npmcdn.com/react-router@2.4.0/umd/ReactRouter.min.js"></script>

<div id = "content" class="container">
</div>


<script type="text/babel">


		//Associative array count helper
		Object.size = function(obj) {
		    var size = 0, key;
		    for (key in obj) {
		        if (obj.hasOwnProperty(key)) size++;
		    }
		    return size;
		};
		

		var BarGraph = React.createClass({
			renderGraph:function(){
				var data = [];
				var dataText = [];
				for (var k in this.props.data){
				    if (this.props.data.hasOwnProperty(k)) {
				    	 data.push(this.props.data[k]);
				    	 dataText.push(k);
				    }
				}


				var width = 200,
				    barHeight = 100/data.length;

				if(data.length < 3) 
					barHeight = 30;   

				var x = d3.scaleLinear()
				    .domain([0, d3.max(data)])
				    .range([0, width]);

				var chart = d3.select(".chart");
					chart.selectAll("g").remove();
				 

				var bar = chart.selectAll("g")
				    .data(data)
				  .enter().append("g")
				    .attr("transform", function(d, i) { return "translate(0," + i * barHeight + ")"; });

				bar.append("rect")
				    .attr("width", x)
				    .attr("height", barHeight - 1);


				bar.append("text")
				    .attr("x", function(d) { 
				    	if(x(d) - barHeight/2> 0) 
				    		return x(d) - 3;
				    	else
				    		return x(d) + barHeight/2;
				    })
				    .attr("y", barHeight / 1.8)
				    .attr("dy", ".35em")
				    .attr("font-size",barHeight / 2)
				    .text(function(d) { return d; });

				bar.append("text")
					.attr("font-size",barHeight / 4)
				    .attr("x", function(d,i) {
				    	var currentFontSize = $(this).attr('font-size');

				    	if(x(d) - currentFontSize/2*dataText[i].length > 0)
				    		return x(d) - barHeight/10; 
				    	else
				    		return  0 + currentFontSize/1.8*dataText[i].length;
				    })
				    .attr("y",barHeight/6)
				    .attr("dy", ".35em")
				    .text(function(d,i) { return dataText[i]; });

				//bar.selectAll('rect').transition().attr('width',x);      

			},
			render:function(){
				this.renderGraph();
				var classString = "chart";
				var elementCount = Object.size(this.props.data);
	
				return(
					<div className="row text-center">
						<div className="col-xs-12">

							<svg viewBox="0 0 200 100" className={classString}></svg>
						</div>	
					</div>	
				);
			}
		});





		var BookmarkedPapersContainer = React.createClass({
		  render:function(){
		    var classString = "bookmarkedPapersContainer row" + this.props.classHelper;
		    return(
		      
		        <div className={classString}>
		          {this.props.children}
		          <div className="favouritesLabel">Favourites:{this.props.count}</div>
		        </div>
		        
		    );
		  }
		});






		var PaperShorthand = React.createClass({
		  render:
		  function(){
		  	console.log('test render');
		  	var linkToPaper = "paperFull/" 
		  						+ this.props.currentPaper.id; 
		  	return(
		      <div className="paperShorthand col-xs-12 col-md-4 text-center">
		        <p>{this.props.currentPaper.pub_date}</p>
		        <p>{this.props.currentPaper.gene}</p>
		        <h4><Link to={linkToPaper}>{this.props.currentPaper.title}</Link></h4>
		        <BookmarkToggle handleBookmarkToggle={this.props.handleBookmarkToggle} paperId={this.props.currentPaper.id} inFavourites={this.props.inFavourites}/>
		      </div>
		    );
		  } 
		});








		var SearchForm = React.createClass({
		  handleChange:function(event) {
		      this.props.updateSearchItem(event.target.value);
		    },
		  render:function() {
		    return (
		      <div className="form-inline text-center searchForm">
		        <input type="text" className="form-control searchFormInput"
		          value={this.props.value}
		          onChange={this.handleChange} />
		        <button onClick={this.props.handleSearchSubmit} className="btn btn-primary submitSearchButton" disabled={!this.props.newSearch}>Search</button>
		      </div>
		    );
		  }
		});







		var PaperListView = React.createClass({
		  getInitialState:function(){
		    return {searchListPapers:[],
		    		searchValue:'',
		    		bookMarkedPapers:[],
		    		newSearch:true,
		    		moreItemsLeft:true,
		    		graphData:{},
		    		listSearchLoading:false,
		    		initialQueryEmpy:false}
		  },
		  handleBookmarkToggle:function(id,inFavourites){
		    if(inFavourites){
		      this.removeFromBookmarked(id);
		    }else{
		      this.addToBookmarked(id);
		    }
		  },
		  addToBookmarked:function(id){
		    var placeholder = this.state.bookMarkedPapers;
		    var paperToAdd = 0;
		    for(var i = 0 ; i < this.state.searchListPapers.length; i++){
		      if(this.state.searchListPapers[i]['id'] == id)
		        paperToAdd = this.state.searchListPapers[i];
		    }
		    placeholder.push(paperToAdd);
		    this.setState({bookMarkedPapers:placeholder});
		    this.addBookmarkOnServer(id);
		  },
		  deleteBookmarkOnServer:function(id){
		    $.ajax({
		        type: "POST",
		        url:'bookMarkedPapers/deleteBookMark',
		        data: {'id':id},
		        success:function(message){
		        }
		      }).error(function(e){
		        this.getBookMarkedPapers();
		      }.bind(this));
		  },
		  addBookmarkOnServer:function(id){
		    $.ajax({
		        type: "POST",
		        url:'bookMarkedPapers/addBookmark',
		        data: {'paper_id':id},
		        success:function(message){
		        }
		      }).error(function(e){
		        this.getBookMarkedPapers();
		      }.bind(this));
		  },
		  getBookmarkedPaperIndexById:function(id){
		    for(var i = 0 ; i < this.state.bookMarkedPapers.length; i++){
		      if(this.state.bookMarkedPapers[i]['id'] == id)
		        return i;
		    }
		    return -1;
		  },
		  removeFromBookmarked:function(id){
		    var index = this.getBookmarkedPaperIndexById(id);
		    var placeholder = this.state.bookMarkedPapers;
		    placeholder.splice(index, 1);
		    this.setState({bookMarkedPapers:placeholder});
		    this.deleteBookmarkOnServer(id);
		  },
		  getBookMarkedPaperIds:function(){
		    var shorthandPaperIds = this.state.bookMarkedPapers.map(function(paper){
		      return paper['id'];
		    });
		    return  shorthandPaperIds;
		  },
		  updateSearchListData:function(newData){
		    if(!this.state.newSearch){
		      var replacementData = this.state.searchListPapers;
		      replacementData.push.apply(replacementData, newData);
		      this.setState({searchListPapers:replacementData});
		    }else{
		      this.setState({searchListPapers:newData});
		    }
		  },
		  updateSearchItem:function(item){
		    this.setState({searchValue:item,newSearch:true,searchListPapers:[],graphData:[]});

		  },
		  getGraphData:function(){
		  	$.ajax({
		  		  type: "POST",
		  		  url:'ResearchPapers/getPaperCount',
		  		  data: {'geneName':this.state.searchValue,'fieldName':'technique_group'},
		  		  success:function(message){
		  		  	var newData = JSON.parse(message);
		  		  	this.setState({graphData:newData});
		  		  }.bind(this)
		  		}).error(function(e){});
		  },
		  getPapers:function(){
		    var searchOffset = 0;
		    if(!this.state.newSearch){
		      searchOffset = this.state.searchListPapers.length;
		    }
		    this.setState({listSearchLoading:true,nitialQueryEmpy:false});
		    $.ajax({
		      type: "POST",
		      url:'researchPapers/getPapers',
		      data: {"geneName":this.state.searchValue,"offset":searchOffset},
		      success:function(message){
		        var newData = JSON.parse(message);
		        var newState = {moreItemsLeft:false,newSearch:false,searchListPapers:this.state.searchListPapers,listSearchLoading:false,initialQueryEmpy:false}
		       
		        if(this.state.newSearch){
		        	this.getGraphData();
		        	newState.searchListPapers = newData;
		        	if(newData.length == 0){
		        		newState.initialQueryEmpy = true;
		        	}
		        }else{
		        	var replacementData = this.state.searchListPapers;
		      		replacementData.push.apply(replacementData, newData);
		      		newState.searchListPapers = replacementData;
		        }

		        if(newData.length != 0)
		          newState.moreItemsLeft = true;
		        this.setState(newState);
		      }.bind(this)
		    }); 
		  },
		  getBookMarkedPapers:function(){
		    $.ajax({
		        type: "POST",
		        url:'bookMarkedPapers/getBookMarkedPapers',
		        success:function(message){
		          var newData = JSON.parse(message);
		          this.setState({bookMarkedPapers:newData});
		        }.bind(this)
		    });
		  },
		  componentDidMount:function(){
		    this.getBookMarkedPapers();
		  },
		  render:function(){
		    var bookMarkContainerText = '';
		    var bookMarkContainerClassString = '';
		    var moreButtonVisible = true; 
		    var isSearchEmptyString = ''

		    
		    if(this.state.bookMarkedPapers.length == 0){
		      bookMarkContainerText = 'No Favourites Selected';
		      bookMarkContainerClassString = ' empty';  
		    }

		    if(this.state.initialQueryEmpy)
		    	isSearchEmptyString = 'No Results Found';

		    if(this.state.searchListPapers.length == 0)
		      moreButtonVisible = false;
		    return(
		      <div className="paperListView text-center">
		        <BookmarkedPapersContainer classHelper={bookMarkContainerClassString} count={this.state.bookMarkedPapers.length}>
		          {bookMarkContainerText}
		          <PaperList data={this.state.bookMarkedPapers} handleBookmarkToggle={this.handleBookmarkToggle} bookMarkedPaperIds = {this.getBookMarkedPaperIds()} />
		        </BookmarkedPapersContainer>

		        <SearchForm updateSearchItem={this.updateSearchItem} newSearch={this.state.newSearch} handleSearchSubmit={this.getPapers}/>
		        {isSearchEmptyString}
		        <BarGraph data={this.state.graphData} />
		        <div className="row">

		          <PaperList data={this.state.searchListPapers} bookMarkedPaperIds = {this.getBookMarkedPaperIds()} handleBookmarkToggle={this.handleBookmarkToggle}>

		            <LoadMoreListItemsButton getMoreListItems={this.getPapers} moreItemsLeft={this.state.moreItemsLeft} visible={moreButtonVisible} isSearchLoading={this.state.listSearchLoading}/>

		          </PaperList>

		        </div>  
		      </div>
		    );
		  }
		});



		var PaperList = React.createClass({
		  renderShorthandPapers:function(){
		    var shorthandPapers = this.props.data.map(function(paper){
		        var currentPaper = paper;
		        var inFavourites = false;

		        if(this.props.bookMarkedPaperIds.indexOf(paper['id']) > -1){
		          inFavourites = true;
		        }
		          
		        return(
		          <PaperShorthand key={currentPaper.id}  author={currentPaper.author} currentPaper={currentPaper}  handleBookmarkToggle={this.props.handleBookmarkToggle} inFavourites={inFavourites}></PaperShorthand>
		        );
		      }.bind(this));
		      return shorthandPapers;
		  },
		  render:function(){
		    return(
		      <div className="paperList">
		        {this.renderShorthandPapers()}
		        {this.props.children}
		      </div>
		    );
		  }
		});


		var LoadMoreListItemsButton = React.createClass({
		  render:function(){
		    var containerText = '';
		    var classHelper = "col-xs-12 text-center btn-lg btn-primary";
		    var loaderContainerClassHelper = "loaderContainer hidden";

		    if(this.props.isSearchLoading && this.props.visible){
		    	loaderContainerClassHelper = "loaderContainer";
		    }	
		    
		    if(!this.props.moreItemsLeft&& this.props.visible){
		    	containerText = 'End of Results';
		    }


		    if(!this.props.visible||this.props.isSearchLoading||!this.props.moreItemsLeft)
		      	classHelper = "col-xs-12 text-center hidden";

		    return(
		      <div className="col-xs-12 text-center moreListItemsButtonContainer">
		      	<div className = {loaderContainerClassHelper}>
		      		<img src="img/spinner.gif" className="spinner"/>
		      		<br/>
		      		Loading Papers
		      	</div>
		      	{containerText}	
		        <button className={classHelper}  onClick={this.props.getMoreListItems}>More..</button>
		      </div>  
		    );
		  }
		});





		var BookmarkToggle = React.createClass({
		  handleClick:function(){
		    this.props.handleBookmarkToggle(this.props.paperId,this.props.inFavourites);
		  },
		  render:function(){
		    
		    var classHelperString = "glyphicon glyphicon-star bookMarkToggle";
		    if(this.props.inFavourites)
		      classHelperString += " bookMarkToggleOn";
		    return(
		      <span className={classHelperString} aria-hidden="true" onClick={this.handleClick}>
		      </span>
		    );
		  }
		});

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

		var App = React.createClass({
			render:function(){
				return(
					<div>
						{this.props.children}
					</div>
				);
			}
		});


		var destination = document.getElementById('content');

		var { Router,
		      Route,
		      IndexRoute,
		      IndexLink,
		      Link } = ReactRouter;

		ReactDOM.render(
		  <Router>
		      <Route path="/">
		      	<IndexRoute component={PaperListView}/>
		      	<Route path="paperFull/:id" component={PaperFull}/>
		      	<Route path="search" component={PaperListView}/>
		      </Route>	
		  </Router>,
		  destination
		);

</script>
