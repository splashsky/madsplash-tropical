/*********************************************************************
  #### Twitter Post Fetcher! ####
  Coded by Jason Mayes 2013.
  www.jasonmayes.com
  Please keep this disclaimer with my code if you use it. Thanks. :-)
  Got feedback or questions, ask here: http://goo.gl/JinwJ
********************************************************************/
	var twitterFetcher=function(){var d=null;return{fetch:function(a,b){d=b;var c=document.createElement("script");c.type="text/javascript";c.src="http://cdn.syndication.twimg.com/widgets/timelines/"+a+"?&lang=en&callback=twitterFetcher.callback&suppress_response_codes=true&rnd="+Math.random();document.getElementsByTagName("head")[0].appendChild(c)},callback:function(a){var b=document.createElement("div");b.innerHTML=a.body;a=b.getElementsByClassName("e-entry-title");d(a)}}}();

	twitterFetcher.fetch('370874942104940544', function(tweets){
	
	// Do what you want with your tweets here! For example:
	var x = tweets.length;
	var n = 0;
	var element = document.getElementById('tweet');
	
	html = "";
	
	if (tweets[n].innerHTML) {
		html += tweets[n].innerHTML;
	} else {
		html += tweets[n].textContent;
	}
	
	n++;
  
	element.innerHTML = html;
});