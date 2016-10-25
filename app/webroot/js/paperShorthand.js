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