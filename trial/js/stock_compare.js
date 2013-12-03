$(document).ready(function() {
    alert("Your initialization code goes here!");

});


var yahoo_base_url = "http://query.yahooapis.com/v1/public/yql?";



var call_YQL = function(symbol) {

	var para = 'q=select * from yahoo.finance.historicaldata where symbol = "'
	+ symbol + '" and startDate = "2009-09-11" and endDate = "2010-03-10" &format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=';

	var query_url = yahoo_base_url + para;
	var settings = {
		type: "GET",
		success: function(todo_json, status, jqXHR) {
			alert("success");
			alert(jqXHR.responseText);
			
		},
		error: function(jqXHR, status, error) {
			alert(jqXHR.responseText);
		},
		cache: false
	}

	$.ajax(query_url, settings);
}



