var SearchForm = React.createClass({
      handleChange:function(event) {
          this.props.updateSearchItem(event.target.value);
      },
      handleSubmit:function(event) {
          this.props.handleSearchSubmit();
      },
      render:function() {
        return (
          <div className="form-inline text-center searchForm">
            <input type="text" className="form-control searchFormInput"
              value={this.props.value}
              onChange={this.handleChange} />
            <button onClick={this.handleSubmit} className="btn btn-primary submitSearchButton">Search</button>
          </div>
        );
      }
    });