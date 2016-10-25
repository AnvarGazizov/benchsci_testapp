var BarGraph = React.createClass({
	renderGraph:function(){
		var data = [];
		var dataText = [];
		//Separate data into text and numbers
		for (var k in this.props.data){
		    if (this.props.data.hasOwnProperty(k)) {
		    	 data.push(this.props.data[k]);
		    	 dataText.push(k);
		    }
		}


		var width = 200,
		    barHeight = 100/data.length;
		//Adjust display for low number of bars    
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
		    	//Display number properly in line with bar 
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
		    	//Display text properly in line with bar 
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
		return(
			<div className="row text-center">
				<div className="col-xs-12">

					<svg viewBox="0 0 200 100" className={classString}></svg>
				</div>	
			</div>	
		);
	}
});