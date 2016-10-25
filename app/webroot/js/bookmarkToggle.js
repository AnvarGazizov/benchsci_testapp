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