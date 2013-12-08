$(document).ready(function() {
    alert("Your initialization code goes here!");
    alert(two_days_ago.toISOString().slice(0,10));
    $('#top_search_form').on('submit', function(e) {
    	e.preventDefault();
    });
});


var yahoo_base_url = "http://query.yahooapis.com/v1/public/yql?";

var YQL_stock = "select * from yahoo.finance.stocks where symbol='yhoo'";

var today = new Date();

var two_days_ago = new Date();
	two_days_ago.setDate(two_days_ago.getDate() - 2);

var call_YQL = function(symbol_json) {

	var symbol = symbol_json.symbol;

	var para = 'q=select * from yahoo.finance.historicaldata where symbol = "'
	+ symbol + '" and startDate = "' + two_days_ago.toISOString().slice(0,10) + '" and endDate = "' 
	+ two_days_ago.toISOString().slice(0,10) + 
	'"&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=';

	alert(para);
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

var create_content = function (stock_json, symbol_json) {
	var header = $("<h2></h2>").append(symbol_json.name);
	var symbol = symbol_json.symbol;
	
	var img = $('<img src="' + img_src + '" alt="">');
	var img_src = "http://chart.finance.yahoo.com/z?s="+ symbol + "&t=3d&q=2&l=off&z=1";
	var list = $("<ul></ul>");

	for()

	$("#Tags").append(header);
	$("#Tags").append(img);
	$('#Tags').append()

}

