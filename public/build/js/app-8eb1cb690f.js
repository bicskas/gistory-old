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


	/*

	 var $kereses_mezo = $('#nev1');
	 if ($kereses_mezo.length) {
	 var kepviselok = new Bloodhound({
	 datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nev'),
	 queryTokenizer: Bloodhound.tokenizers.whitespace,
	 remote: {
	 url: '/kereses/'+ $kereses_mezo.data('projectid')+'/%nev',
	 wildcard: '%nev'
	 },
	 limit: 20
	 });

	 kepviselok.initialize();

	 $('#typeahead .typeahead').typeahead(null, {
	 name: 'kepviselo-nev',
	 displayKey: 'nev',
	 source: kepviselok.ttAdapter(),
	 hint: true,
	 highlight: true,
	 minLength: 2,
	 limit: 10
	 });
	 }
	 */

	//----------------------------ábrák megjelenítése---------------

	if($('#svg').length > 0){
		circular();
	}

	if($('#force').length > 0){
		force();
	}

});
/**
 * Created by Video on 2016.11.04..
 */

function circular() {



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

	var svg = d3.select("#svg").append("svg")
		.attr("width", diameter)
		.attr("height", diameter)
		.append("g")
		.attr("transform", "translate(" + radius + "," + radius + ")");

	var link = svg.append("g").selectAll(".link"),
		node = svg.append("g").selectAll(".node");

	// d3.json("/json/readme-flare-imports2.json", function (error, classes) {
	d3.json($('#svg').data('json'), function (error, classes) {
		if (error) throw error;

		var nodes = cluster.nodes(packageHierarchy(classes)),
			links = packageImports(nodes);

		link = link
			.data(bundle(links))
			.enter().append("path")
			.each(function (d) {
				d.source = d[0], d.target = d[d.length - 1];
			})
			.attr("class", "link")
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


function force(){

	var svg = d3.select("svg"),
		width = +svg.attr("width"),
		height = +svg.attr("height");

	var color = d3.scaleOrdinal(d3.schemeCategory20);
	/*var color = function (valami) {
		return '#fff';
	};*/

	var simulation = d3.forceSimulation()
		.force("link", d3.forceLink().id(function(d) { return d.id; }))
		.force("charge", d3.forceManyBody())
		.force("center", d3.forceCenter(width / 2, height / 2));

	d3.json("/json/miserables.json", function(error, graph) {
		if (error) throw error;

		var link = svg.append("g")
			.attr("class", "links")
			.selectAll("line")
			.data(graph.links)
			.enter().append("line")
			.attr("stroke-width", function(d) { return Math.sqrt(d.value); });

		var node = svg.append("g")
			.attr("class", "nodes")
			.selectAll("circle")
			.data(graph.nodes)
			.enter().append("circle")
			.attr("r", 6)
			.attr("fill", function(d) { return color(d.group); })
			.call(d3.drag()
				.on("start", dragstarted)
				.on("drag", dragged)
				.on("end", dragended));

		node.append("title")
			.text(function(d) { return d.id; });

		simulation
			.nodes(graph.nodes)
			.on("tick", ticked);

		simulation.force("link")
			.links(graph.links);

		function ticked() {
			link
				.attr("x1", function(d) { return d.source.x; })
				.attr("y1", function(d) { return d.source.y; })
				.attr("x2", function(d) { return d.target.x; })
				.attr("y2", function(d) { return d.target.y; });

			node
				.attr("cx", function(d) { return d.x; })
				.attr("cy", function(d) { return d.y; });
		}
	});

	function dragstarted(d) {
		if (!d3.event.active) simulation.alphaTarget(0.1).restart();
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
//# sourceMappingURL=app.js.map
