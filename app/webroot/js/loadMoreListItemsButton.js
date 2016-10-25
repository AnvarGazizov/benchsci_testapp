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
