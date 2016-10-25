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
        //Add bookmark to state
        var placeholder = this.state.bookMarkedPapers;
        var paperToAdd = 0;
        for(var i = 0 ; i < this.state.searchListPapers.length; i++){
          if(this.state.searchListPapers[i]['id'] == id)
            paperToAdd = this.state.searchListPapers[i];
        }
        placeholder.push(paperToAdd);
        this.setState({bookMarkedPapers:placeholder});
        //Update on server
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
            //refresh the bookmarks with appropriate content form the server
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
        //Check if its a brand new search or if more is being added to old search
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
          //Serverside query begins at this offset
          searchOffset = this.state.searchListPapers.length;
        }

        this.setState({listSearchLoading:true,nitialQueryEmpy:false});

        $.ajax({
          type: "POST",
          url:'researchPapers/getPapers',
          data: {"geneName":this.state.searchValue,"offset":searchOffset},
          success:function(message){
            var newData = JSON.parse(message);
            //Hold all variables needed to be updated in state in a temp variable in order to only make one call to setState
            var newState = {moreItemsLeft:false,newSearch:false,searchListPapers:this.state.searchListPapers,listSearchLoading:false,initialQueryEmpy:false}
            
            if(this.state.newSearch){
              //Only get graph data on the first search
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
        var loaderContainerClassHelper = 'hidden';
        
        if(this.state.bookMarkedPapers.length == 0){
          bookMarkContainerText = 'No Favourites Selected';
          bookMarkContainerClassString = ' empty';  
        }

        if(this.state.initialQueryEmpy)
          isSearchEmptyString = 'No Results Found';

        if(this.state.searchListPapers.length == 0)
          moreButtonVisible = false;

        if(this.state.listSearchLoading && this.state.newSearch){
          loaderContainerClassHelper = '';
        }

        return(
          <div className="paperListView text-center">
            <BookmarkedPapersContainer classHelper={bookMarkContainerClassString} count={this.state.bookMarkedPapers.length}>
              
              {bookMarkContainerText}
              
              <PaperList data={this.state.bookMarkedPapers} handleBookmarkToggle={this.handleBookmarkToggle} bookMarkedPaperIds = {this.getBookMarkedPaperIds()} />
            
            </BookmarkedPapersContainer>

            <SearchForm updateSearchItem={this.updateSearchItem} newSearch={this.state.newSearch} handleSearchSubmit={this.getPapers}/>
            
            {isSearchEmptyString}
            <div className = {loaderContainerClassHelper}>
              <img src="img/spinner.gif" className="spinner"/>
              <br/>
              Loading Papers
            </div>
            
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
