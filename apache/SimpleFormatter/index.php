<html>
<head>
	<title>Domplate Test</title>
	
	<script type="text/javascript">	
		// This is just so domplate works
		
		function FBL() {};
		function FBTrace() {};
		
		if (!top.console || !top.console.firebug)
		{
		    top.console = {
		        log: function() {},
		        time: function() {},
		        timeEnd: function() {}
		    }
		}
		
		function ddd()
		{
			console.log.apply(console, arguments);
		}
		
		function dir()
		{
			console.dir.apply(console, arguments);
		}
		
		function $(id)
		{
		    return document.getElementById(id);
		}	
	</script>
	<!-- include domplate -->
	<script src="/libraries/domplate/domplate-debug.js" type="text/javascript"></script>	
	<script type="text/javascript">	
	
		with (FBL) {
	
		function Formatter() {};
		
		Formatter.prototype = domplate({
			
			dump:
				TAG('$value|format',{value:'$value|parseParts'}),
					
			arrayTable:
				TABLE({border:1},
					TR(
						TH({colspan:2},'array')
					),				
					FOR('x','$value',
						TR(
							TD('$x.name'),
							TD(
								TAG('$x.val|format',{value:'$x.val|parseParts'})
							)							
						)
					)						
				),
						
			structTable:
				TABLE({border:1},
					TR(
						TH({colspan:2},'struct')
					),				
					FOR('x','$value',
						TR(
							TD('$x.name'),
							TD(
								TAG('$x.val|format',{value:'$x.val|parseParts'})
							)							
						)
					)						
				),
				
			simpleDiv:
				DIV('$value'),
				
			unknownDiv:
				DIV('$value|formatString'),
				
			formatString: function(value){
				return "unknown object type:" + value.toString();
			},
						
			format: function(value){						
				
				switch (this.dumpType(value)) {				
					case "array":				
						return this.arrayTable;
					case "simpleValue":
						return this.simpleDiv;	
					case "struct":
						return this.structTable;
					default:
						return this.unknownDiv;
				}					
									
			},
						
			parseParts: function(value) {
				
				var parts = [];
				var part;
						
				switch (this.dumpType(value)) {
					
					case "array":					
						for (var i=0; i < value.length; i++) {
							part = {name: i+1, val: value[i] };
							parts.push(part);
						}
						return parts;				
						
					case "simpleValue":
						return value;
						
					case "struct":
						for (var i in value) {
							if (i != "__cftype__") {
								part = {name: i, val: value[i] };
								parts.push(part);						
							}					
						}
						return parts;	
					
					default:
						return value;		
					
				}
			},
			
			dumpType: function(value) {				
				if (value instanceof Array) {				
					return "array";					
				} else if (typeof(value) == "object" && value.hasOwnProperty("__cftype__")) {
					return value.__cftype__;	
				} else if (typeof(value) == "string" || typeof(value) == "number" || typeof(value) == "boolean") {
					return "simpleValue";					
				} else {					
					return "unknown";					
				}			
			},
		
		});
		
		formatter = new Formatter();
		
		};
					
		function runTest(){
			
			with (FBL){		
				var testVar = [{"__cftype__":"struct","keyOne":"valueOne","keyTwo":"valueTwo"},"item two","item three"];			
				formatter.dump.append({value:testVar}, $("test"));			
			}
		
		};
					
		window.addEventListener("load", runTest, false);				

	</script>	
	
</head>
<body>

<div id="test"></div>

</body>
</html>