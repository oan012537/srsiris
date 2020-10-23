@extends('../template')

@section('content')
	
	<!-- Page header -->
	<!--<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Dashboard
				</h4>
			</div>
		</div>
	</div>-->
	<!-- /page header -->
	<style type="text/css">
		.classdashboard{
			background: rgb(199,199,199,0.3);
		}
	</style>

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">
				<div class="row">
					<div class="col-md-12">
						
						<!-- Sortable vertical bar chart -->
						{{-- <div class="panel panel-flat">
							<div class="panel-heading">
								<h5 class="panel-title">แผนภูมิ</h5>
								<div class="heading-elements">
									<ul class="icons-list">
										<li><a data-action="collapse"></a></li>
										<li><a data-action="reload"></a></li>
										<li><a data-action="close"></a></li>
									</ul>
								</div>
							</div>

							<div class="panel-body">
						
								<div class="checkbox content-group">
									<label><input type="checkbox" class="toggle-sort"> เรียงลำดับ</label>
								</div>

								<div class="chart-container">
									<div class="chart" id="d3-bar-sortable-vertical"></div>
								</div>
							</div>
						</div> --}}
						<!-- /sortable vertical bar chart -->
					
						<!-- Vertical form -->
						<div class="panel panel-flat">
							<div class="panel-heading">
								{{-- <h6 class="panel-title">ยอดการขาย</h6> --}}
							</div>
							<div class="panel-body">
								<div class="col-md-12">
									<div class="col-md-2" style="text-align: right;">
										<h6>filter </h6>
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control" name="productname" id="productname" autocomplete="off">
										<input type="hidden" name="productid" id="productid">
									</div>
								{{-- </div> --}}
								{{-- <div class="col-md-6"> --}}
									<div class="form-group">
										<div class="col-md-2">
											<select class="form-control" onchange="getdatachart()" name="typesearch" id="typesearch">
												<option value="1">รายเดือน</option>
												<option value="2">รายปี</option>
											</select>
										</div>
										<div class="col-md-2" style="display: none;">
											<select class="form-control" onchange="getdatachart()" name="typesearchsell" id="typesearchsell">
												<option value="">เซลทั้งหมด</option>
												{{-- @if(!empty($sell))
												@foreach($sell as $item)
												<option value="{{$item->id}}">{{$item->name}}</option>
												@endforeach
												@endif --}}
											</select>
										</div>
										<div class="col-md-2">
											<select class="change-date select-sm form-control" id="select_mount" name="select_mount" onchange="getdatachart()">
												{{-- <optgroup label="<i class='icon-watch pull-right'></i> Time period"> --}}
													<option value="01" @php if(date('m') == '01')echo 'selected'; @endphp >มกราคม</option>
													<option value="02" @php if(date('m') == '02')echo 'selected'; @endphp >กุมภาพันธ์</option>
													<option value="03" @php if(date('m') == '03')echo 'selected'; @endphp >มีนาคม</option>
													<option value="04" @php if(date('m') == '04')echo 'selected'; @endphp >เมษายน</option>
													<option value="05" @php if(date('m') == '05')echo 'selected'; @endphp >พฤษภาคม</option>
													<option value="06" @php if(date('m') == '06')echo 'selected'; @endphp >มิถุนายน</option>
													<option value="07" @php if(date('m') == '07')echo 'selected'; @endphp >กรกฏาคม</option>
													<option value="08" @php if(date('m') == '08')echo 'selected'; @endphp >สิงหาคม</option>
													<option value="09" @php if(date('m') == '09')echo 'selected'; @endphp >กันยายน</option>
													<option value="10" @php if(date('m') == '10')echo 'selected'; @endphp >ตุลาคม</option>
													<option value="11" @php if(date('m') == '11')echo 'selected'; @endphp >พฤษจิกายน</option>
													<option value="12" @php if(date('m') == '12')echo 'selected'; @endphp >ธันวาคม</option>
												{{-- </optgroup> --}}
											</select>
										</div>
										<div class="col-md-2">
											<select class="form-control" id="select_year" name="select_year" onchange="getdatachart()">
												@for($x=$data['min'];$x<=$data['max'];$x++)
												<option value="{{$x}}" @php if(date('Y') == $x)echo 'selected'; @endphp>{{$x}}</option>
												@endfor
											</select>
										</div>
										<div class="col-md-2">
											<a href="{{url('dashboard')}}"><button type="button" class="btn btn-primary">ดูข้อมูลการขาย</button></a>
										</div>
									</div>
								</div>
							</div>
							
							{{-- <div class="container-fluid">
								<div class="row text-center">
									<div class="col-md-4">
										<div class="content-group">
											<h5 class="text-semibold no-margin"><i class="icon-calendar52 position-left text-slate"></i> <span id="totalamount">0.00</span></h5>
											<span class="text-muted text-size-small">รายได้รายเดือน</span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="content-group">
											<h5 class="text-semibold no-margin"><i class="icon-cash3 position-left text-slate"></i> <span id="totalprofit">0.00</span></h5>
											<span class="text-muted text-size-small">กำไร</span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="content-group">
											<h5 class="text-semibold no-margin"><i class="icon-cash3 position-left text-slate"></i> <span id="totalamountavg">0.00</span></h5>
											<span class="text-muted text-size-small">รายได้เฉลี่ย</span>
										</div>
									</div>
								</div>
							</div> --}}
							<div id="showchart"></div>

							
						</div>
						<!-- /vertical form -->
						
						
					</div>
				</div>

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/data.js"></script>
	<script src="https://code.highcharts.com/modules/series-label.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>

	<!-- Additional files for the Highslide popup effect -->
	<script src="https://www.highcharts.com/media/com_demo/js/highslide-full.min.js"></script>
	<script src="https://www.highcharts.com/media/com_demo/js/highslide.config.js" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="https://www.highcharts.com/media/com_demo/css/highslide.css" />
	<script>
		// App sales lines chart
		// ------------------------------

		// appSalesLines('#app_sales', 255); // initialize chart

		// Chart setup
		function appSalesLines(element, height) {


			// Basic setup
			// ------------------------------

			// Define main variables
			var d3Container = d3.select(element),
				margin = {top: 5, right: 30, bottom: 30, left: 50},
				width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
				height = height - margin.top - margin.bottom;

			// Tooltip
			var tooltip = d3.tip()
				.attr('class', 'd3-tip')
				.html(function (d) {
					return "<ul class='list-unstyled mb-5'>" +
						"<li>" + "<div class='text-size-base mt-5 mb-5'><i class='icon-circle-left2 position-left'></i>" + d.name + " app" + "</div>" + "</li>" +
						"<li>" + "Sales: &nbsp;" + "<span class='text-semibold pull-right'>" + (d.value).toFixed(2) + "</span>" + "</li>" +
					"</ul>";
				});

			// Format date
			var parseDate = d3.time.format("%Y/%m/%d").parse,
				formatDate = d3.time.format("%b %d, '%y");

			// Line colors
			var scale = ["#4CAF50", "#FF5722", "#5C6BC0"],
				color = d3.scale.ordinal().range(scale);



			// Create chart
			// ------------------------------

			// Container
			var container = d3Container.append('svg');

			// SVG element
			var svg = container
				.attr('width', width + margin.left + margin.right)
				.attr('height', height + margin.top + margin.bottom)
				.append("g")
					.attr("transform", "translate(" + margin.left + "," + margin.top + ")")
					.call(tooltip);



			// Add date range switcher
			// ------------------------------

			// Menu
			var menu = $("#select_date").multiselect({
				buttonClass: 'btn btn-link text-semibold',
				enableHTML: true,
				dropRight: true,
				onChange: function() { change(), $.uniform.update(); },
				buttonText: function (options, element) {
					var selected = '';
					options.each(function() {
						selected += $(this).html() + ', ';
					});
					return '<span class="status-mark border-warning position-left"></span>' + selected.substr(0, selected.length -2);
				}
			});

			// Radios
			$(".multiselect-container input").uniform({ radioClass: 'choice' });



			// Load data
			// ------------------------------

			d3.csv("assets/demo_data/dashboard/app_sales.csv", function(error, data) {
				formatted = data;
				redraw();
			});



			// Construct layout
			// ------------------------------

			// Add events
			var altKey;
			d3.select(window)
				.on("keydown", function() { altKey = d3.event.altKey; })
				.on("keyup", function() { altKey = false; });
		
			// Set terms of transition on date change   
			function change() {
			  d3.transition()
				  .duration(altKey ? 7500 : 500)
				  .each(redraw);
			}



			// Main chart drawing function
			// ------------------------------

			function redraw() { 

				// Construct chart layout
				// ------------------------------

				// Create data nests
				var nested = d3.nest()
					.key(function(d) { return d.type; })
					.map(formatted)
				
				// Get value from menu selection
				// the option values correspond
				//to the [type] value we used to nest the data  
				var series = menu.val();
				
				// Only retrieve data from the selected series using nest
				var data = nested[series];
				
				// For object constancy we will need to set "keys", one for each type of data (column name) exclude all others.
				color.domain(d3.keys(data[0]).filter(function(key) { return (key !== "date" && key !== "type"); }));

				// Setting up color map
				var linedata = color.domain().map(function(name) {
					return {
								name: name,
								values: data.map(function(d) {
									return {name: name, date: parseDate(d.date), value: parseFloat(d[name], 10)};
								})
							};
						});

				// Draw the line
				var line = d3.svg.line()
					.x(function(d) { return x(d.date); })
					.y(function(d) { return y(d.value); })
					.interpolate('cardinal');



				// Construct scales
				// ------------------------------

				// Horizontal
				var x = d3.time.scale()
					.domain([
						d3.min(linedata, function(c) { return d3.min(c.values, function(v) { return v.date; }); }),
						d3.max(linedata, function(c) { return d3.max(c.values, function(v) { return v.date; }); })
					])
					.range([0, width]);

				// Vertical
				var y = d3.scale.linear()
					.domain([
						d3.min(linedata, function(c) { return d3.min(c.values, function(v) { return v.value; }); }),
						d3.max(linedata, function(c) { return d3.max(c.values, function(v) { return v.value; }); })
					])
					.range([height, 0]);



				// Create axes
				// ------------------------------

				// Horizontal
				var xAxis = d3.svg.axis()
					.scale(x)
					.orient("bottom")
					.tickPadding(8)
					.ticks(d3.time.days)
					.innerTickSize(4)
					.tickFormat(d3.time.format("%a")); // Display hours and minutes in 24h format

				// Vertical
				var yAxis = d3.svg.axis()
					.scale(y)
					.orient("left")
					.ticks(6)
					.tickSize(0 -width)
					.tickPadding(8);
				


				//
				// Append chart elements
				//

				// Append axes
				// ------------------------------

				// Horizontal
				svg.append("g")
					.attr("class", "d3-axis d3-axis-horizontal d3-axis-solid")
					.attr("transform", "translate(0," + height + ")");

				// Vertical
				svg.append("g")
					.attr("class", "d3-axis d3-axis-vertical d3-axis-transparent");



				// Append lines
				// ------------------------------

				// Bind the data
				var lines = svg.selectAll(".lines")
					.data(linedata)
			 
				// Append a group tag for each line
				var lineGroup = lines
					.enter()
					.append("g")
						.attr("class", "lines")
						.attr('id', function(d){ return d.name + "-line"; });

				// Append the line to the graph
				lineGroup.append("path")
					.attr("class", "d3-line d3-line-medium")
					.style("stroke", function(d) { return color(d.name); })
					.style('opacity', 0)
					.attr("d", function(d) { return line(d.values[0]); })
					.transition()
						.duration(500)
						.delay(function(d, i) { return i * 200; })
						.style('opacity', 1);
			  


				// Append circles
				// ------------------------------

				var circles = lines.selectAll("circle")
					.data(function(d) { return d.values; })
					.enter()
					.append("circle")
						.attr("class", "d3-line-circle d3-line-circle-medium")
						.attr("cx", function(d,i){return x(d.date)})
						.attr("cy",function(d,i){return y(d.value)})
						.attr("r", 3)
						.style('fill', '#fff')
						.style("stroke", function(d) { return color(d.name); });

				// Add transition
				circles
					.style('opacity', 0)
					.transition()
						.duration(500)
						.delay(500)
						.style('opacity', 1);



				// Append tooltip
				// ------------------------------

				// Add tooltip on circle hover
				circles
					.on("mouseover", function (d) {
						tooltip.offset([-15, 0]).show(d);

						// Animate circle radius
						d3.select(this).transition().duration(250).attr('r', 4);
					})
					.on("mouseout", function (d) {
						tooltip.hide(d);

						// Animate circle radius
						d3.select(this).transition().duration(250).attr('r', 3);
					});

				// Change tooltip direction of first point
				// to always keep it inside chart, useful on mobiles
				lines.each(function (d) { 
					d3.select(d3.select(this).selectAll('circle')[0][0])
						.on("mouseover", function (d) {
							tooltip.offset([0, 15]).direction('e').show(d);

							// Animate circle radius
							d3.select(this).transition().duration(250).attr('r', 4);
						})
						.on("mouseout", function (d) {
							tooltip.direction('n').hide(d);

							// Animate circle radius
							d3.select(this).transition().duration(250).attr('r', 3);
						});
				})

				// Change tooltip direction of last point
				// to always keep it inside chart, useful on mobiles
				lines.each(function (d) { 
					d3.select(d3.select(this).selectAll('circle')[0][d3.select(this).selectAll('circle').size() - 1])
						.on("mouseover", function (d) {
							tooltip.offset([0, -15]).direction('w').show(d);

							// Animate circle radius
							d3.select(this).transition().duration(250).attr('r', 4);
						})
						.on("mouseout", function (d) {
							tooltip.direction('n').hide(d);

							// Animate circle radius
							d3.select(this).transition().duration(250).attr('r', 3);
						})
				})



				// Update chart on date change
				// ------------------------------

				// Set variable for updating visualization
				var lineUpdate = d3.transition(lines);
				
				// Update lines
				lineUpdate.select("path")
					.attr("d", function(d, i) { return line(d.values); });

				// Update circles
				lineUpdate.selectAll("circle")
					.attr("cy",function(d,i){return y(d.value)})
					.attr("cx", function(d,i){return x(d.date)});

				// Update vertical axes
				d3.transition(svg)
					.select(".d3-axis-vertical")
					.call(yAxis);   

				// Update horizontal axes
				d3.transition(svg)
					.select(".d3-axis-horizontal")
					.attr("transform", "translate(0," + height + ")")
					.call(xAxis);



				// Resize chart
				// ------------------------------

				// Call function on window resize
				$(window).on('resize', appSalesResize);

				// Call function on sidebar width change
				$(document).on('click', '.sidebar-control', appSalesResize);

				// Resize function
				// 
				// Since D3 doesn't support SVG resize by default,
				// we need to manually specify parts of the graph that need to 
				// be updated on window resize
				function appSalesResize() {

					// Layout
					// -------------------------

					// Define width
					width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;

					// Main svg width
					container.attr("width", width + margin.left + margin.right);

					// Width of appended group
					svg.attr("width", width + margin.left + margin.right);

					// Horizontal range
					x.range([0, width]);

					// Vertical range
					y.range([height, 0]);


					// Chart elements
					// -------------------------

					// Horizontal axis
					svg.select('.d3-axis-horizontal').call(xAxis);

					// Vertical axis
					svg.select('.d3-axis-vertical').call(yAxis.tickSize(0-width));

					// Lines
					svg.selectAll('.d3-line').attr("d", function(d, i) { return line(d.values); });

					// Circles
					svg.selectAll('.d3-line-circle').attr("cx", function(d,i){return x(d.date)})
				}
			}
		}
		
		   // Monthly app sales area chart
		// ------------------------------

		// monthlySalesArea("#monthly-sales-stats", 100, '#4DB6AC'); // initialize chart

		// Chart setup
		function monthlySalesArea(element, height, color) {


			// Basic setup
			// ------------------------------

			// Define main variables
			var d3Container = d3.select(element),
				margin = {top: 20, right: 35, bottom: 40, left: 35},
				width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
				height = height - margin.top - margin.bottom;

			// Date and time format
			var parseDate = d3.time.format( '%Y-%m-%d' ).parse,
				bisectDate = d3.bisector(function(d) { return d.date; }).left,
				formatDate = d3.time.format("%b %d");



			// Create SVG
			// ------------------------------

			// Container
			var container = d3Container.append('svg');

			// SVG element
			var svg = container
				.attr('width', width + margin.left + margin.right)
				.attr('height', height + margin.top + margin.bottom)
				.append("g")
					.attr("transform", "translate(" + margin.left + "," + margin.top + ")")



			// Construct chart layout
			// ------------------------------

			// Area
			var area = d3.svg.area()
				.x(function(d) { return x(d.date); })
				.y0(height)
				.y1(function(d) { return y(d.value); })
				.interpolate('monotone')


			// Construct scales
			// ------------------------------

			// Horizontal
			var x = d3.time.scale().range([0, width ]);

			// Vertical
			var y = d3.scale.linear().range([height, 0]);


			// Create axes
			// ------------------------------

			// Horizontal
			var xAxis = d3.svg.axis()
				.scale(x)
				.orient("bottom")
				.ticks(d3.time.days, 6)
				.innerTickSize(4)
				.tickPadding(8)
				.tickFormat(d3.time.format("%b %d"));


			// Load data
			// ------------------------------

			d3.json("assets/demo_data/dashboard/monthly_sales.json", function (error, data) {
			// d3.json("dashboard/data", function (error, data) {

				// Show what's wrong if error
				if (error) return console.error(error);

				// Pull out values
				data.forEach(function (d) {
					d.date = parseDate(d.date);
					d.value = +d.value;
				});

				// Get the maximum value in the given array
				var maxY = d3.max(data, function(d) { return d.value; });

				// Reset start data for animation
				var startData = data.map(function(datum) {
					return {
						date: datum.date,
						value: 0
					};
				});


				// Set input domains
				// ------------------------------

				// Horizontal
				x.domain(d3.extent(data, function(d, i) { return d.date; }));

				// Vertical
				y.domain([0, d3.max( data, function(d) { return d.value; })]);



				//
				// Append chart elements
				//

				// Append axes
				// -------------------------

				// Horizontal
				var horizontalAxis = svg.append("g")
					.attr("class", "d3-axis d3-axis-horizontal d3-axis-solid")
					.attr("transform", "translate(0," + height + ")")
					.call(xAxis);

				// Add extra subticks for hidden hours
				horizontalAxis.selectAll(".d3-axis-subticks")
					.data(x.ticks(d3.time.days), function(d) { return d; })
					.enter()
						.append("line")
						.attr("class", "d3-axis-subticks")
						.attr("y1", 0)
						.attr("y2", 4)
						.attr("x1", x)
						.attr("x2", x);



				// Append area
				// -------------------------

				// Add area path
				svg.append("path")
					.datum(data)
					.attr("class", "d3-area")
					.attr("d", area)
					.style('fill', color)
					.transition() // begin animation
						.duration(1000)
						.attrTween('d', function() {
							var interpolator = d3.interpolateArray(startData, data);
							return function (t) {
								return area(interpolator (t));
							}
						});



				// Append crosshair and tooltip
				// -------------------------

				//
				// Line
				//

				// Line group
				var focusLine = svg.append("g")
					.attr("class", "d3-crosshair-line")
					.style("display", "none");

				// Line element
				focusLine.append("line")
					.attr("class", "vertical-crosshair")
					.attr("y1", 0)
					.attr("y2", -maxY)
					.style("stroke", "#e5e5e5")
					.style('shape-rendering', 'crispEdges')


				//
				// Pointer
				//

				// Pointer group
				var focusPointer = svg.append("g")
					.attr("class", "d3-crosshair-pointer")
					.style("display", "none");

				// Pointer element
				focusPointer.append("circle")
					.attr("r", 3)
					.style("fill", "#fff")
					.style('stroke', color)
					.style('stroke-width', 1)


				//
				// Text
				//

				// Text group
				var focusText = svg.append("g")
					.attr("class", "d3-crosshair-text")
					.style("display", "none");

				// Text element
				focusText.append("text")
					.attr("dy", -10)
					.style('font-size', 12);


				//
				// Overlay with events
				//

				svg.append("rect")
					.attr("class", "d3-crosshair-overlay")
					.style('fill', 'none')
					.style('pointer-events', 'all')
					.attr("width", width)
					.attr("height", height)
						.on("mouseover", function() {
							focusPointer.style("display", null);        
							focusLine.style("display", null)
							focusText.style("display", null);
						})
						.on("mouseout", function() {
							focusPointer.style("display", "none"); 
							focusLine.style("display", "none");
							focusText.style("display", "none");
						})
						.on("mousemove", mousemove);


				// Display tooltip on mousemove
				function mousemove() {

					// Define main variables
					var mouse = d3.mouse(this),
						mousex = mouse[0],
						mousey = mouse[1],
						x0 = x.invert(mousex),
						i = bisectDate(data, x0),
						d0 = data[i - 1],
						d1 = data[i],
						d = x0 - d0.date > d1.date - x0 ? d1 : d0;

					// Move line
					focusLine.attr("transform", "translate(" + x(d.date) + "," + height + ")");

					// Move pointer
					focusPointer.attr("transform", "translate(" + x(d.date) + "," + y(d.value) + ")");

					// Reverse tooltip at the end point
					if(mousex >= (d3Container.node().getBoundingClientRect().width - focusText.select('text').node().getBoundingClientRect().width - margin.right - margin.left)) {
						focusText.select("text").attr('text-anchor', 'end').attr("x", function () { return (x(d.date) - 15) + "px" }).text(formatDate(d.date) + " - " + d.value + " sales");
					}
					else {
						focusText.select("text").attr('text-anchor', 'start').attr("x", function () { return (x(d.date) + 15) + "px" }).text(formatDate(d.date) + " - " + d.value + " sales");
					}
				}



				// Resize chart
				// ------------------------------

				// Call function on window resize
				$(window).on('resize', monthlySalesAreaResize);

				// Call function on sidebar width change
				$(document).on('click', '.sidebar-control', monthlySalesAreaResize);

				// Resize function
				// 
				// Since D3 doesn't support SVG resize by default,
				// we need to manually specify parts of the graph that need to 
				// be updated on window resize
				function monthlySalesAreaResize() {

					// Layout variables
					width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;


					// Layout
					// -------------------------

					// Main svg width
					container.attr("width", width + margin.left + margin.right);

					// Width of appended group
					svg.attr("width", width + margin.left + margin.right);


					// Axes
					// -------------------------

					// Horizontal range
					x.range([0, width]);

					// Horizontal axis
					svg.selectAll('.d3-axis-horizontal').call(xAxis);

					// Horizontal axis subticks
					svg.selectAll('.d3-axis-subticks').attr("x1", x).attr("x2", x);


					// Chart elements
					// -------------------------

					// Area path
					svg.selectAll('.d3-area').datum( data ).attr("d", area);

					// Crosshair
					svg.selectAll('.d3-crosshair-overlay').attr("width", width);
				}
			});
		}
	</script>

	<script>
		function getSum(total, num) {
			return total + Math.round(num);
		}
		var datasale = [];

		getdatacharts();
		function getdatacharts(){
			datasale = [];
			$.post('stock',{type:$("#typesearch").val(),sellname:$("#typesearchsell").val(),mount:$("#select_mount").val(),year:$("#select_year").val(),productid:$("#productid").val(),'_token': "{{ csrf_token() }}"}, function(data) {
				// datasales.push(data);
				if($("#typesearch").val() == '1'){
					for (var i = 0; i < 31; i++) {
						datasale.push(i);
					}
				}else{
					for (var i = 0; i < 31; i++) {
						datasale.push(i);
					}
				}
				
				// var amount = data.selling.reduce(getSum, 0);
				// var profit = data.profit.reduce(getSum, 0);
				// $("#totalamount").html(amount.toFixed(2));
				// $("#totalamountavg").html((amount/31).toFixed(2));
				// $("#totalprofit").html((profit).toFixed(2));
				Highchart(datasale,data.billingnote);
			});
		}
		// console.log(datasales);
		function Highchart(datasale,billingnote) {
			Highcharts.chart('showchart', {
			    chart: {
			        scrollablePlotArea: {
			            minWidth: 500
			        }
			    },
			    title: {
			    	text: ''
			    },

			    xAxis: {
			    	// tickInterval: 100,
			    	// type: 'logarithmic',
			    	categories:datasale,
			    	crosshair: true
			    },

			    yAxis: {
			    	// type: 'logarithmic',
			    	// minorTickInterval: 100,
			    	accessibility: {
			    		rangeDescription: 'Range: 1 to 31'
			    	}
			    },

			    legend: {
			        align: 'center',
			        verticalAlign: 'top',
			        borderWidth: 0
			    },

			    tooltip: {
			    	headerFormat: '<b>รายงาน</b><br />',
			    	pointFormat: 'วันที่ : {point.x}<br> ยอดขาย : {point.y}'
			    },

			    plotOptions: {
			        line: {
			            pointPadding: 0.5,
			            borderWidth: 1
			        }
			    },

			    // series: [{
			    // 	name: 'All sessions',
			    // 	lineWidth: 4,
			    // 	marker: {
			    // 		radius: 4
			    // 	}
			    // }, {
			    // 	name: 'New users'
			    // }]
			    series: [
			    {
			    	name: 'สินค้าคงเหลือ',
			    	data: billingnote,
			    	pointStart: 1,
			    	lineWidth: 3,
			    	// color:green
			    },
			    // plotOptions: {
			    // 	series: {
			    // 		label: {
			    // 			connectorAllowed: false
			    // 		},
			    // 		pointStart: 1
			    // 	}
			    // },
			    // {
			    // 	data: [0, 2, 4, 8, 16, 32, 64, 128, 256, 512],
			    // 	pointStart: 1
			    // }
			    ],
			    navigation: {
			    	buttonOptions: {
			    		enabled: false
			    	}
			    }
			});
		}

		function getdatachart(){
			getdatacharts();
		}
		$("#productname").autocomplete({
			source: "{{url('searchproductname/autocomplete')}}",
			minLength: 1,
			select: function(event, ui){
				$("#productid").val(ui.item.id);
				getdatachart();
			}
		})
		.autocomplete("instance")._renderItem = function(ul, item) {
			return $("<li>").append("<span class='text-semibold'>" + item.label + '</span>').appendTo(ul);
		};
	</script>
@stop