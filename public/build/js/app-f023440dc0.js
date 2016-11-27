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
				url: '/kereses/keres/1/%nev',
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
			remote: {
				url: '/kereses/keres/1/%nev',
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

		//----------------------------ábrák megjelenítése---------------

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

		$('.bs-select').selectpicker({
			noneSelectedText: '(válasszon)',
			liveSearch: true,
			liveSearchPlaceholder: '(keresés)'
		});

	}
);
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
					node.parent = find(name.substring(0, i = name.lastIndexOf(".")));
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
		.force("link", d3.forceLink().id(function (d) {
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
