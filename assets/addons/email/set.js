// ----------------------------------------------------------------------------
// markItUp!
// ----------------------------------------------------------------------------
// Copyright (C) 2008 Jay Salvat
// http://markitup.jaysalvat.com/
// ----------------------------------------------------------------------------
mySettings = {	
	markupSet:  [	
	{	name:'Email selection', 
		className:'email', 
		beforeInsert:function(h) {
				var email = "";
				if (h.altKey) {
					email = prompt("Email:");
					if (email == null) {
						return false;
					}
				}
				var subject = prompt("Subject:", "From markItUp! editor")
				if (subject == null) {
					return false;
				}
				document.location="mailto:"+email+"?subject="+escape(subject)+"&body="+escape(h.selection); 
			} 
		}
	]
}