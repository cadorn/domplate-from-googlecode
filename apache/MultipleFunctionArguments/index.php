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
			
			table:
				TABLE({border:1},
					TBODY(
            TR(
  						TH('Col 1'),
  						TH('Col 2')
  					),				
  					FOR('row','($value,$styles)|getRowData',
  						TR(
      					FOR('row','($row.value,$row.style)|getRowData',
	    						TD({'style':'background-color: $row.style.color'},'$row.value')					
                )
  						)
  					)
          )						
				),

				
			getRowData: function(value,styles){
				
				var parts = [];
				for (var i=0; i < value.length; i++) {
						part = {name: i+1, value: value[i], style: styles[i] };
						parts.push(part);
				}
				return parts;				
        
			}
		
		});
		
		formatter = new Formatter();
		
		};
					
		function runTest(){
			
			with (FBL){		
      
        DomplateDebug.enabled = true;
      
				var rows = [
                    ["row data 1","r1c2"],
                    ["row data 2","r2c2"],
                    ["row data 3","r3c2"]
                   ];			
        var styles = [
                      [{color:"red"},{color:"cyan"}],
                      [{color:"blue"},{color:"gray"}],
                      [{color:"yellow"},{color:"green"}]
                     ];
                       
				formatter.table.append({value:rows, styles:styles}, $("test"));			

//console.log(parseParts('bwyu4f4 $value|getRowData dsfsdf $value2|getRowData2 sdfsdfsdf'));
//console.log(parseParts('bwyu4f4($value,$styles)|getRowData h478373hh ($value2,$styles2)|getRowData2 dsfsdf'));

			}
		
		};
					
		window.addEventListener("load", runTest, false);				

	</script>	
	
</head>
<body>

<div id="test"></div>

</body>
</html>