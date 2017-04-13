jQuery(document).ready(function ($) {

		$('.alert>.close').on('click', function () {
			$(this).parent.remove();
		});

		$(document).on('click', '.confirm', function () {
			return confirm('Biztos benne?');
		});

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		// törlés gomb
		$(document).on('click', '.torol', function (e) {
			e.preventDefault();
			if (confirm('Biztos benne?')) {
				var $this = $(this);
				$.ajax({
					url: $this.attr('href'),
					method: 'DELETE',
					success: function (resp) {
						$('#item_' + resp.id).remove();
					},
					error: function () {
						alert('Hiba történt');
					}
				});
			}
		});


		var $node1_mezo = $('#nev1');
		if ($node1_mezo.length) {
			var node1 = new Bloodhound({
				datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nev'),
				queryTokenizer: Bloodhound.tokenizers.whitespace,
				remote: {
					url: '/kereses/keres/' + $node1_mezo.data('projectid') + '/%nev',
					wildcard: '%nev'
				},
				limit: 20
			});

			node1.initialize();

			$node1_mezo.typeahead(null, {
				name: 'node-nev',
				displayKey: 'nev',
				source: node1.ttAdapter(),
				hint: true,
				highlight: true,
				minLength: 2,
				limit: 10
			});
		}

		var $node2_mezo = $('#nev2');
		if ($node2_mezo.length) {
			var node2 = new Bloodhound({
				datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nev'),
				queryTokenizer: Bloodhound.tokenizers.whitespace,
				remote: {url: '/kereses/keres/' + $node2_mezo.data('projectid') + '/%nev',
					wildcard: '%nev'
				},
				limit: 20
			});

			node2.initialize();

			$node2_mezo.typeahead(null, {
				name: 'node-nev',
				displayKey: 'nev',
				source: node2.ttAdapter(),
				hint: true,
				highlight: true,
				minLength: 2,
				limit: 10
			});
		}

		abra();

		//---------------------------Küszöbölés ajaxxal-----------------
		$("#fokszam-slider").slider({
			id: 'fokszam-slider-szin'
		});

		$("#fokszam-slider").on('slideStop', function () {
			console.log($("#fokszam-slider").val());


			$this = $('#kuszob-node');
			$.ajax({
				url: $this.attr('action'),
				method: 'POST',
				data: $this.serialize(),
				dataType: 'html',
				success: function (resp) {
					$('#abrak-tab').html(resp);
					abra();
				},
				error: function () {
					alert('Hiba történt');
				}
			});
		});


		//----------------------------ábrák megjelenítése---------------
		function abra() {

			($('#svg').length > 0)
			{
				chord('#svg');
			}

			if ($('#svg_same').length > 0) {
				chord('#svg_same');
			}

			if ($('#svg_diff').length > 0) {
				chord('#svg_diff');
			}

			if ($('#force').length > 0) {
				force('#force');
			}

			if ($('#force_same').length > 0) {
				force('#force_same');
			}

			if ($('#force_diff').length > 0) {
				force('#force_diff');
			}

			if ($('#bar').length > 0) {
				bar();
			}
		}

		$('.bs-select').selectpicker({
			noneSelectedText: '(válasszon)',
			liveSearch: true,
			liveSearchPlaceholder: '(keresés)'
		});

		$('.bs-select-no-search').selectpicker({
			noneSelectedText: '(válasszon)',
		});

	}
);


//-----------------


/**
 * Created by Video on 2016.11.04..
 */

function chord(param) {



	var diameter = 960,
		radius = diameter / 2,
		innerRadius = radius - 120;

	var cluster = d3.layout.cluster()
		.size([360, innerRadius])
		.sort(null)
		.value(function (d) {
			return d.size;
		});

	var bundle = d3.layout.bundle();

	var line = d3.svg.line.radial()
		.interpolate("bundle")
		.tension(.85)
		.radius(function (d) {
			return d.y;
		})
		.angle(function (d) {
			return d.x / 180 * Math.PI;
		});

	var svg = d3.select(param).append("svg")
		.attr("width", diameter)
		.attr("height", diameter)
		.append("g")
		.attr("transform", "translate(" + radius + "," + radius + ")");

	var link = svg.append("g").selectAll(".link"),
		node = svg.append("g").selectAll(".node");

	// d3.json("/json/readme-flare-imports2.json", function (error, classes) {
	d3.json($(param).data('json'), function (error, classes) {
		if (error) throw error;

		var nodes = cluster.nodes(packageHierarchy(classes)),
			links = packageImports(nodes);

		link = link
			.data(bundle(links))
			.enter().append("path")
			.each(function (d) {
				d.source = d[0], d.target = d[d.length - 1];
			})
			.attr("class", function (d) {
				return "link " + d.source.size;
				})
			.attr("d", line);

		node = node
			.data(nodes.filter(function (n) {
				return !n.children;
			}))
			.enter().append("text")
			.attr("class", "node")
			.attr("dy", ".31em")
			.attr("transform", function (d) {
				return "rotate(" + (d.x - 90) + ")translate(" + (d.y + 8) + ",0)" + (d.x < 180 ? "" : "rotate(180)");
			})
			.style("text-anchor", function (d) {
				return d.x < 180 ? "start" : "end";
			})
			.text(function (d) {
				return d.key;
			})
			.on("mouseover", mouseovered)
			.on("mouseout", mouseouted);
	});

	function mouseovered(d) {
		node
			.each(function (n) {
				n.target = n.source = false;
			});

		link
			.classed("link--target", function (l) {
				if (l.target === d) return l.source.source = true;
			})
			.classed("link--source", function (l) {
				if (l.source === d) return l.target.target = true;
			})
			.filter(function (l) {
				return l.target === d || l.source === d;
			})
			.each(function () {
				this.parentNode.appendChild(this);
			});

		node
			.classed("node--target", function (n) {
				return n.target;
			})
			.classed("node--source", function (n) {
				return n.source;
			});
	}

	function mouseouted(d) {
		link
			.classed("link--target", false)
			.classed("link--source", false);

		node
			.classed("node--target", false)
			.classed("node--source", false);
	}

	d3.select(self.frameElement).style("height", diameter + "px");

// Lazily construct the package hierarchy from class names.
	function packageHierarchy(classes) {
		var map = {};

		function find(name, data) {
			var node = map[name], i;
			if (!node) {
				node = map[name] = data || {name: name, children: []};
				if (name.length) {
					node.parent = find(name.substring(0, i = name.lastIndexOf("*")));
					node.parent.children.push(node);
					node.key = name.substring(i + 1);
				}
			}
			return node;
		}

		classes.forEach(function (d) {
			find(d.name, d);
		});

		return map[""];
	}

// Return a list of imports for the given array of nodes.
	function packageImports(nodes) {
		var map = {},
			imports = [];

		// Compute a map from name to node.
		nodes.forEach(function (d) {
			map[d.name] = d;
		});

		// For each import, construct a link from the source to target node.
		nodes.forEach(function (d) {
			if (d.imports) d.imports.forEach(function (i) {
				imports.push({source: map[d.name], target: map[i]});
			});
		});

		return imports;
	}

}
/**
 * Created by Video on 2016.11.05..
 */


function force(param) {
	var svg = d3.select(param + " > svg"),
		width = +svg.attr("width"),
		height = +svg.attr("height");

	var color = d3.scaleOrdinal(d3.schemeCategory20);
	/*var color = function (valami) {
	 return '#fff';
	 };*/

	var simulation = d3.forceSimulation()
		// .force("link", d3.forceLink().id(function (d) {
		// 	return d.id;
		// }))
		.force("link", d3.forceLink().distance(20).strength(0.02).id(function (d) {
				return d.id;
			}))
		.force("charge", d3.forceManyBody())
		.force("center", d3.forceCenter(width / 2, height / 2));

	// d3.json("/json/miserables.json", function(error, graph) {
	d3.json($(param).data('json'), function (error, graph) {
		if (error) throw error;

		var link = svg.append("g")
			.attr("class", "links")
			.selectAll("line")
			.data(graph.links)
			.enter().append("line")
			.attr("stroke-width", function (d) {
				return Math.sqrt(d.value);
			});

		var node = svg.append("g")
			.attr("class", "nodes")
			.selectAll("circle")
			.data(graph.nodes)
			.enter().append("circle")
			.attr("r", 5)
			.attr("fill", function (d) {
				return color(d.group);
			})
			.call(d3.drag()
				.on("start", dragstarted)
				.on("drag", dragged)
				.on("end", dragended));

		node.append("title")
			.text(function (d) {
				return d.id;
			});

		simulation
			.nodes(graph.nodes)
			.on("tick", ticked);

		simulation.force("link")
			.links(graph.links);

		function ticked() {
			link
				.attr("x1", function (d) {
					return d.source.x;
				})
				.attr("y1", function (d) {
					return d.source.y;
				})
				.attr("x2", function (d) {
					return d.target.x;
				})
				.attr("y2", function (d) {
					return d.target.y;
				});

			node
				.attr("cx", function (d) {
					return d.x;
				})
				.attr("cy", function (d) {
					return d.y;
				});
		}
	});

	function dragstarted(d) {
		if (!d3.event.active) simulation.alphaTarget(0.3).restart();
		d.fx = d.x;
		d.fy = d.y;
	}

	function dragged(d) {
		d.fx = d3.event.x;
		d.fy = d3.event.y;
	}

	function dragended(d) {
		if (!d3.event.active) simulation.alphaTarget(0);
		d.fx = null;
		d.fy = null;
	}
}
/**
 * Created by Video on 2016.11.06..
 */


function bar() {

	var elsosor= [''];

	var data = {
		labels:
			elsosor.concat($('#bar').data('nevek'))
		,
		series: [
			{
				label: 'Fokszám',
				values: elsosor.concat($('#bar').data('degree'))
			},
			/*{
				label: '2013',
				values: [12, 43, 22, 11, 73, 25]
			},
			{
				label: '2014',
				values: [31, 28, 14, 8, 15, 21]
			},*/]
	};

	var chartWidth = 300,
		barHeight = 20,
		groupHeight = barHeight * data.series.length,
		gapBetweenGroups = 10,
		spaceForLabels = 150,
		spaceForLegend = 150;

// Zip the series data together (first values, second values, etc.)
	var zippedData = [];
	for (var i = 0; i < data.labels.length; i++) {
		for (var j = 0; j < data.series.length; j++) {
			zippedData.push(data.series[j].values[i]);
		}
	}

// Color scale
	var color = d3.scale.category20();
	var chartHeight = barHeight * zippedData.length + gapBetweenGroups * data.labels.length;

	var x = d3.scale.linear()
		.domain([0, d3.max(zippedData)])
		.range([0, chartWidth]);

	var y = d3.scale.linear()
		.range([chartHeight + gapBetweenGroups, 0]);

	var yAxis = d3.svg.axis()
		.scale(y)
		.tickFormat('')
		.tickSize(0)
		.orient("left");

// Specify the chart area and dimensions
	var chart = d3.select("#bar > .chart")
		.attr("width", spaceForLabels + chartWidth + spaceForLegend)
		.attr("height", chartHeight);

// Create bars
	var bar = chart.selectAll("g")
		.data(zippedData)
		.enter().append("g")
		.attr("transform", function (d, i) {
			return "translate(" + spaceForLabels + "," + (i * barHeight + gapBetweenGroups * (0.5 + Math.floor(i / data.series.length))) + ")";
		});

// Create rectangles of the correct width
	bar.append("rect")
		.attr("fill", function (d, i) {
			return color(i % data.series.length);
		})
		.attr("class", "bar")
		.attr("width", x)
		.attr("height", barHeight - 1);

// Add text label in bar
	bar.append("text")
		.attr("x", function (d) {
			return x(d) - 3;
		})
		.attr("y", barHeight / 2)
		.attr("fill", "red")
		.attr("dy", ".35em")
		.text(function (d) {
			return d;
		});

// Draw labels
	bar.append("text")
		.attr("class", "label")
		.attr("x", function (d) {
			return -10;
		})
		.attr("y", groupHeight / 2)
		.attr("dy", ".35em")
		.text(function (d, i) {
			if (i % data.series.length === 0)
				return data.labels[Math.floor(i / data.series.length)];
			else
				return ""
		});

	chart.append("g")
		.attr("class", "y axis")
		.attr("transform", "translate(" + spaceForLabels + ", " + -gapBetweenGroups / 2 + ")")
		.call(yAxis);

// Draw legend
	var legendRectSize = 18,
		legendSpacing = 4;

	var legend = chart.selectAll('.legend')
		.data(data.series)
		.enter()
		.append('g')
		.attr('transform', function (d, i) {
			var height = legendRectSize + legendSpacing;
			var offset = -gapBetweenGroups / 2;
			var horz = spaceForLabels + chartWidth + 40 - legendRectSize;
			var vert = i * height - offset;
			return 'translate(' + horz + ',' + vert + ')';
		});

	legend.append('rect')
		.attr('width', legendRectSize)
		.attr('height', legendRectSize)
		.style('fill', function (d, i) {
			return color(i);
		})
		.style('stroke', function (d, i) {
			return color(i);
		});

	legend.append('text')
		.attr('class', 'legend')
		.attr('x', legendRectSize + legendSpacing)
		.attr('y', legendRectSize - legendSpacing)
		.text(function (d) {
			return d.label;
		});


}
//# sourceMappingURL=app.js.map


function RadarChart(id, data, options) {
	var cfg = {
		w: 600,				//Width of the circle
		h: 600,				//Height of the circle
		margin: {top: 20, right: 20, bottom: 20, left: 20}, //The margins of the SVG
		levels: 3,				//How many levels or inner circles should there be drawn
		maxValue: 0, 			//What is the value that the biggest circle will represent
		labelFactor: 1.25, 	//How much farther than the radius of the outer circle should the labels be placed
		wrapWidth: 60, 		//The number of pixels after which a label needs to be given a new line
		opacityArea: 0.35, 	//The opacity of the area of the blob
		dotRadius: 4, 			//The size of the colored circles of each blog
		opacityCircles: 0.1, 	//The opacity of the circles of each blob
		strokeWidth: 2, 		//The width of the stroke around each blob
		roundStrokes: false,	//If true the area and stroke will follow a round path (cardinal-closed)
		color: d3.scale.category10()	//Color function
	};

	//Put all of the options into a variable called cfg
	if('undefined' !== typeof options){
		for(var i in options){
			if('undefined' !== typeof options[i]){ cfg[i] = options[i]; }
		}//for i
	}//if

	//If the supplied maxValue is smaller than the actual one, replace by the max in the data
	var maxValue = Math.max(cfg.maxValue, d3.max(data, function(i){return d3.max(i.map(function(o){return o.value;}))}));

	var allAxis = (data[0].map(function(i, j){return i.axis})),	//Names of each axis
		total = allAxis.length,					//The number of different axes
		radius = Math.min(cfg.w/2, cfg.h/2), 	//Radius of the outermost circle
		Format = d3.format('%'),			 	//Percentage formatting
		angleSlice = Math.PI * 2 / total;		//The width in radians of each "slice"

	//Scale for the radius
	var rScale = d3.scale.linear()
		.range([0, radius])
		.domain([0, maxValue]);

	/////////////////////////////////////////////////////////
	//////////// Create the container SVG and g /////////////
	/////////////////////////////////////////////////////////

	//Remove whatever chart with the same id/class was present before
	d3.select(id).select("svg").remove();

	//Initiate the radar chart SVG
	var svg = d3.select(id).append("svg")
		.attr("width",  cfg.w + cfg.margin.left + cfg.margin.right)
		.attr("height", cfg.h + cfg.margin.top + cfg.margin.bottom)
		.attr("class", "radar"+id);
	//Append a g element
	var g = svg.append("g")
		.attr("transform", "translate(" + (cfg.w/2 + cfg.margin.left) + "," + (cfg.h/2 + cfg.margin.top) + ")");

	/////////////////////////////////////////////////////////
	////////// Glow filter for some extra pizzazz ///////////
	/////////////////////////////////////////////////////////

	//Filter for the outside glow
	var filter = g.append('defs').append('filter').attr('id','glow'),
		feGaussianBlur = filter.append('feGaussianBlur').attr('stdDeviation','2.5').attr('result','coloredBlur'),
		feMerge = filter.append('feMerge'),
		feMergeNode_1 = feMerge.append('feMergeNode').attr('in','coloredBlur'),
		feMergeNode_2 = feMerge.append('feMergeNode').attr('in','SourceGraphic');

	/////////////////////////////////////////////////////////
	/////////////// Draw the Circular grid //////////////////
	/////////////////////////////////////////////////////////

	//Wrapper for the grid & axes
	var axisGrid = g.append("g").attr("class", "axisWrapper");

	//Draw the background circles
	axisGrid.selectAll(".levels")
		.data(d3.range(1,(cfg.levels+1)).reverse())
		.enter()
		.append("circle")
		.attr("class", "gridCircle")
		.attr("r", function(d, i){return radius/cfg.levels*d;})
		.style("fill", "#CDCDCD")
		.style("stroke", "#CDCDCD")
		.style("fill-opacity", cfg.opacityCircles)
		.style("filter" , "url(#glow)");

	//Text indicating at what % each level is
	axisGrid.selectAll(".axisLabel")
		.data(d3.range(1,(cfg.levels+1)).reverse())
		.enter().append("text")
		.attr("class", "axisLabel")
		.attr("x", 4)
		.attr("y", function(d){return -d*radius/cfg.levels;})
		.attr("dy", "0.4em")
		.style("font-size", "10px")
		.attr("fill", "#737373")
		.text(function(d,i) { return Format(maxValue * d/cfg.levels); });

	/////////////////////////////////////////////////////////
	//////////////////// Draw the axes //////////////////////
	/////////////////////////////////////////////////////////

	//Create the straight lines radiating outward from the center
	var axis = axisGrid.selectAll(".axis")
		.data(allAxis)
		.enter()
		.append("g")
		.attr("class", "axis");
	//Append the lines
	axis.append("line")
		.attr("x1", 0)
		.attr("y1", 0)
		.attr("x2", function(d, i){ return rScale(maxValue*1.1) * Math.cos(angleSlice*i - Math.PI/2); })
		.attr("y2", function(d, i){ return rScale(maxValue*1.1) * Math.sin(angleSlice*i - Math.PI/2); })
		.attr("class", "line")
		.style("stroke", "white")
		.style("stroke-width", "2px");

	//Append the labels at each axis
	axis.append("text")
		.attr("class", "legend")
		.style("font-size", "11px")
		.attr("text-anchor", "middle")
		.attr("dy", "0.35em")
		.attr("x", function(d, i){ return rScale(maxValue * cfg.labelFactor) * Math.cos(angleSlice*i - Math.PI/2); })
		.attr("y", function(d, i){ return rScale(maxValue * cfg.labelFactor) * Math.sin(angleSlice*i - Math.PI/2); })
		.text(function(d){return d})
		.call(wrap, cfg.wrapWidth);

	/////////////////////////////////////////////////////////
	///////////// Draw the radar chart blobs ////////////////
	/////////////////////////////////////////////////////////

	//The radial line function
	var radarLine = d3.svg.line.radial()
		.interpolate("linear-closed")
		.radius(function(d) { return rScale(d.value); })
		.angle(function(d,i) {	return i*angleSlice; });

	if(cfg.roundStrokes) {
		radarLine.interpolate("cardinal-closed");
	}

	//Create a wrapper for the blobs
	var blobWrapper = g.selectAll(".radarWrapper")
		.data(data)
		.enter().append("g")
		.attr("class", "radarWrapper");

	//Append the backgrounds
	blobWrapper
		.append("path")
		.attr("class", "radarArea")
		.attr("d", function(d,i) { return radarLine(d); })
		.style("fill", function(d,i) { return cfg.color(i); })
		.style("fill-opacity", cfg.opacityArea)
		.on('mouseover', function (d,i){
			//Dim all blobs
			d3.selectAll(".radarArea")
				.transition().duration(200)
				.style("fill-opacity", 0.1);
			//Bring back the hovered over blob
			d3.select(this)
				.transition().duration(200)
				.style("fill-opacity", 0.7);
		})
		.on('mouseout', function(){
			//Bring back all blobs
			d3.selectAll(".radarArea")
				.transition().duration(200)
				.style("fill-opacity", cfg.opacityArea);
		});

	//Create the outlines
	blobWrapper.append("path")
		.attr("class", "radarStroke")
		.attr("d", function(d,i) { return radarLine(d); })
		.style("stroke-width", cfg.strokeWidth + "px")
		.style("stroke", function(d,i) { return cfg.color(i); })
		.style("fill", "none")
		.style("filter" , "url(#glow)");

	//Append the circles
	blobWrapper.selectAll(".radarCircle")
		.data(function(d,i) { return d; })
		.enter().append("circle")
		.attr("class", "radarCircle")
		.attr("r", cfg.dotRadius)
		.attr("cx", function(d,i){ return rScale(d.value) * Math.cos(angleSlice*i - Math.PI/2); })
		.attr("cy", function(d,i){ return rScale(d.value) * Math.sin(angleSlice*i - Math.PI/2); })
		.style("fill", function(d,i,j) { return cfg.color(j); })
		.style("fill-opacity", 0.8);

	/////////////////////////////////////////////////////////
	//////// Append invisible circles for tooltip ///////////
	/////////////////////////////////////////////////////////

	//Wrapper for the invisible circles on top
	var blobCircleWrapper = g.selectAll(".radarCircleWrapper")
		.data(data)
		.enter().append("g")
		.attr("class", "radarCircleWrapper");

	//Append a set of invisible circles on top for the mouseover pop-up
	blobCircleWrapper.selectAll(".radarInvisibleCircle")
		.data(function(d,i) { return d; })
		.enter().append("circle")
		.attr("class", "radarInvisibleCircle")
		.attr("r", cfg.dotRadius*1.5)
		.attr("cx", function(d,i){ return rScale(d.value) * Math.cos(angleSlice*i - Math.PI/2); })
		.attr("cy", function(d,i){ return rScale(d.value) * Math.sin(angleSlice*i - Math.PI/2); })
		.style("fill", "none")
		.style("pointer-events", "all")
		.on("mouseover", function(d,i) {
			newX =  parseFloat(d3.select(this).attr('cx')) - 10;
			newY =  parseFloat(d3.select(this).attr('cy')) - 10;

			tooltip
				.attr('x', newX)
				.attr('y', newY)
				.text(Format(d.value))
				.transition().duration(200)
				.style('opacity', 1);
		})
		.on("mouseout", function(){
			tooltip.transition().duration(200)
				.style("opacity", 0);
		});

	//Set up the small tooltip for when you hover over a circle
	var tooltip = g.append("text")
		.attr("class", "tooltip")
		.style("opacity", 0);

	/////////////////////////////////////////////////////////
	/////////////////// Helper Function /////////////////////
	/////////////////////////////////////////////////////////

	//Taken from http://bl.ocks.org/mbostock/7555321
	//Wraps SVG text
	function wrap(text, width) {
		text.each(function() {
			var text = d3.select(this),
				words = text.text().split(/\s+/).reverse(),
				word,
				line = [],
				lineNumber = 0,
				lineHeight = 1.4, // ems
				y = text.attr("y"),
				x = text.attr("x"),
				dy = parseFloat(text.attr("dy")),
				tspan = text.text(null).append("tspan").attr("x", x).attr("y", y).attr("dy", dy + "em");

			while (word = words.pop()) {
				line.push(word);
				tspan.text(line.join(" "));
				if (tspan.node().getComputedTextLength() > width) {
					line.pop();
					tspan.text(line.join(" "));
					line = [word];
					tspan = text.append("tspan").attr("x", x).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
				}
			}
		});
	}//wrap

}//RadarChart
