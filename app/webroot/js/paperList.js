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