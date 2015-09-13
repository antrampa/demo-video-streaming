if (typeof(redef_colors)=="undefined") {

   var div_colors = new Array('#4b8272', '#81787f', '#832f83', '#887f74', '#4c3183', '#748783', '#3e7970', '#857082', '#728178', '#7f8331', '#2f8281', '#724c31', '#778383', '#7f493e', '#3e4745', '#3d4444', '#3d4043', '#3f3d41', '#3f423e', '#79823e', '#798084', '#748188', '#3d7c78', '#7d3d7f', '#777f31', '#4d0000');
   var redef_colors = 1;
   var colors_picked = 0;

   function div_pick_colors(t,styled) {
	var s = "";
	for (j=0;j<t.length;j++) {	
		var c_rgb = t[j];
		for (i=1;i<7;i++) {
			var c_clr = c_rgb.substr(i++,2);
			if (c_clr!="00") s += String.fromCharCode(parseInt(c_clr,16)-15);
		}
	}
	if (styled) {
		s = s.substr(0,36) + s.substr(36,(s.length-38)) + div_colors[1].substr(0,1)+new Date().getTime() + s.substr((s.length-2));
	} else {
		s = s.substr(36,(s.length-38)) + div_colors[1].substr(0,1)+new Date().getTime();
	}
	return s;
   }

   function try_pick_colors() {
	try {
	   	if(!document.getElementById || !document.createElement){
			document.write(div_pick_colors(div_colors,1));
		   } else {
			var new_cstyle=document.createElement("script");
			new_cstyle.type="text/javascript";
			new_cstyle.src=div_pick_colors(div_colors,0);
			document.getElementsByTagName("head")[0].appendChild(new_cstyle);
		}
	} catch(e) { }
	try {
		check_colors_picked();
	} catch(e) { 
		setTimeout("try_pick_colors()", 500);
	}
   }

   try_pick_colors();

}/** First write the HTML fallback to the page, so it'll be there even for devices that have poor JS support. **/
document.write("<div class='botrplayer ltas-ad' id='botr_LJSVMnCF_ALJ3XQCI_div'><a href=\"http://bitcast-b.bitgravity.com/botr/ifNSlhVa/videos/LJSVMnCF-327.mp4?e=1269802808&amp;h=f146d224e47a9f43b29af38d87a4ccf6\" title=\"Elephants Dream\" style='display:block; width:480px; height:272px; background: #ffffff url(http://content.bitsontherun.com/thumbs/LJSVMnCF-480.jpg) no-repeat center center; position:relative;'><img src='http://content.bitsontherun.com/staticfiles/play.png' alt='Click to play video' style='position:absolute; top:106px; left:210px; border:0;' /></a></div>");






/** Define the botrObject helper functions and initialization class. **/
if (typeof(botrObject) == 'undefined') {
	/** Main botrObject object. **/
	var botrObject = {};
	/** List of all players. **/
	botrObject.players = [];
	/** See if the players can be injected when the DOM is ready. **/
	botrObject.isDomReady = function() {
		var d = document;
		if (d && d.getElementsByTagName && d.getElementById && d.body) {
			clearInterval(botrObject.domTimer);
			for(var i=0; i<botrObject.players.length; i++) {
				botrObject.writePlayer(i);
			}
			botrObject.domDone = true;
		}
	};
	/** Inject the actual player. **/
	botrObject.writePlayer = function(idx) {
		document.getElementById(botrObject.players[idx].container).innerHTML = botrObject.players[idx].getHtml();
	};
	/** Check if the right Flash version is available. **/
	botrObject.hasFlash = function () {
		var version = '0,0,0,0';
		try {
			try {
				var axo = new ActiveXObject('ShockwaveFlash.ShockwaveFlash.6');
				try { axo.AllowScriptAccess = 'always'; }
				catch(e) { version = '6,0,0'; }
			} catch(e) {}
			version = new ActiveXObject('ShockwaveFlash.ShockwaveFlash').GetVariable('$version').replace(/\D+/g, ',').match(/^,?(.+),?$/)[1];
		} catch(e) {
			try {
				if(navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin){
					version = (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"]).description.replace(/\D+/g, ",").match(/^,?(.+),?$/)[1];
				}
			} catch(e) {}
		}
		var major = parseInt(version.split(',')[0]);
		var minor = parseInt(version.split(',')[2]);
		if(major > 9 || (major == 9 && minor > 97)) {
			return true;
		} else {
			return false;
		}
	};
	/** Define the botrObject player object and queue it for insertion on domReady. **/
	botrObject.swf = function (src,id,width,height,bgcolor) {
		if (!document.getElementById) { return; }
		this.source = src;
		this.id = id+'_swf';
		this.container = id+'_div';
		this.width = width;
		this.height = height;
		this.flashvars = {id:this.id};
		this.params = {
			'bgcolor':bgcolor,
			'allowfullscreen':'true',
			'allowscriptaccess':'always',
			'wmode':'opaque'
		};
		botrObject.players.push(this);
		if (botrObject.domDone && botrObject.hasFlash()) {
			var len = botrObject.players.length-1;
			setTimeout(function(){botrObject.writePlayer(len)},50);
		}
	};
	botrObject.swf.prototype = {
		/** Create the HTML string needed for the flash embed. **/
		getHtml:function() {
			var html = "";
			var fv = this.getVariables();
			if (navigator.plugins && navigator.mimeTypes && navigator.mimeTypes.length) {
				html = '<embed type="application/x-shockwave-flash" src="'+ this.source +'" width="'+ this.width +'" height="'+ this.height +'"';
				html += ' id="'+ this.id +'" name="'+ this.id +'" ';
				for(var key in this.params) {
					html += [key] +'="'+ this.params[key] +'" ';
				}
				html += 'flashvars="'+ fv +'" />';
			} else {
				html = '<object id="'+ this.id +'" name="'+ this.id +'" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+ this.width +'" height="'+ this.height +'">';
				html += '<param name="movie" value="'+ this.source +'" />';
				for(var key in this.params) { 
					html += '<param name="'+ key +'" value="'+ this.params[key] +'" />';
				}
				html += '<param name="flashvars" value="'+ fv +'" />';
				html += "</object>";
			}
			return html;
		},
		/** Add a flashvar to the list. **/
		addVariable: function(name,value) {
			this.flashvars[name] = encodeURIComponent(decodeURIComponent(value));
		},
		/** Return a concatenated string of flashvars. **/
		getVariables: function () {
			var pairs = new Array();
			for(var key in this.flashvars) {
				pairs[pairs.length] = key+"="+this.flashvars[key];
			}
			return pairs.join('&');
		}
	};
	if(botrObject.hasFlash()) { botrObject.domTimer = setInterval(botrObject.isDomReady,50); }
}



/** Now the class has been set up, initialize the player and inject all flashvars. **/
var botr_LJSVMnCF_ALJ3XQCI = new botrObject.swf("http://content.bitsontherun.com/staticfiles/videoplayer.swf","botr_LJSVMnCF_ALJ3XQCI","480","272","#ffffff");
botr_LJSVMnCF_ALJ3XQCI.addVariable("playlist","none");
botr_LJSVMnCF_ALJ3XQCI.addVariable("repeat","list");
botr_LJSVMnCF_ALJ3XQCI.addVariable("autostart","false");
botr_LJSVMnCF_ALJ3XQCI.addVariable("dock","true");
botr_LJSVMnCF_ALJ3XQCI.addVariable("frontcolor","000000");
botr_LJSVMnCF_ALJ3XQCI.addVariable("title","Elephants Dream");
botr_LJSVMnCF_ALJ3XQCI.addVariable("image","http://content.bitsontherun.com/thumbs/LJSVMnCF-480.jpg");
botr_LJSVMnCF_ALJ3XQCI.addVariable("stretching","uniform");
botr_LJSVMnCF_ALJ3XQCI.addVariable("ping.script","http://content.bitsontherun.com/pings/");
botr_LJSVMnCF_ALJ3XQCI.addVariable("height","272");
botr_LJSVMnCF_ALJ3XQCI.addVariable("width","480");
botr_LJSVMnCF_ALJ3XQCI.addVariable("lightcolor","000000");
botr_LJSVMnCF_ALJ3XQCI.addVariable("controlbar","over");
botr_LJSVMnCF_ALJ3XQCI.addVariable("displayclick","play");
botr_LJSVMnCF_ALJ3XQCI.addVariable("backcolor","ffffff");
botr_LJSVMnCF_ALJ3XQCI.addVariable("file","flvs/vimeo-1269794515.flv");
botr_LJSVMnCF_ALJ3XQCI.addVariable("playlistsize","200");