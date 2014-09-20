// ----------------------------------------------------------------------------
// markItUp!
// ----------------------------------------------------------------------------
// Copyright (C) 2008 Jay Salvat
// http://markitup.jaysalvat.com/
// ----------------------------------------------------------------------------
mySettings = {	
	markupSet: [	
		{	name:'Table generator', 
			className:'tablegenerator', 
			placeholder:"Your text here...",
			replaceWith:function(markItUp) {
				var cols = prompt("How many cols?"),
					rows = prompt("How many rows?"),
					html = "<table>\n";
				if (markItUp.altKey) {
					html += " <tr>\n";
					for (var c = 0; c < cols; c++) {
						html += "! [![TH"+(c+1)+" text:]!]\n";	
					}
					html+= " </tr>\n";
				}
				for (var r = 0; r < rows; r++) {
					html+= " <tr>\n";
					for (var c = 0; c < cols; c++) {
						html += "  <td>"+(markItUp.placeholder||"")+"</td>\n";	
					}
					html+= " </tr>\n";
				}
				html += "<table>\n";
				return html;
			}
		}
	]
}