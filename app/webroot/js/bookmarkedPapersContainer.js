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