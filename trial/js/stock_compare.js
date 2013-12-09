$(document).ready(function() {
    alert("Your initialization code goes here!");
    call_YQL("YHOO");
    $("#top_search_form").on('submit', function(e) {
    	e.preventDefault();
    });

    $(".page-header").on('click', 'button', null, function(e) {
    	e.preventDefault();
    	alert("test");

    	addToFavorite($(this).data('symbol'));
    });

});

var base_url = "http://wwwp.cs.unc.edu/Courses/comp426-f13/cchunhao/final/trial/";

var yahoo_base_url = "http://query.yahooapis.com/v1/public/yql?";

var YQL_stock = "select * from yahoo.finance.stocks where symbol='yhoo'";

//var today = new Date();

//var two_days_ago = new Date();
//	two_days_ago.setDate(two_days_ago.getDate() - 2);

var addToFavorite = function(symbol) {

	alert(symbol);
	var query_url = base_url + "database.php";
	var settings = {
		type: "POST",
		dataType: "json",
		data: 'stock_name=' + symbol,
		success: function(list_json, status, jqXHR) {
			alert("success haha");
			alert(jqXHR.responseText);
		},
		error: function(jqXHR, status, error) {
			alert(jqXHR.responseText);			
		},
		cache: false
	}

	$.ajax(query_url, settings);

}


var call_YQL = function(symbol) {

	var para = 'q=select * from yahoo.finance.quotes where symbol in ("' + 
		symbol + 
		'") &format=json&env=http://datatables.org/alltables.env&diagnostics=true';

	alert(para);
	var query_url = yahoo_base_url + para;
	var settings = {
		type: "GET",
		success: function(stock_json, status, jqXHR) {
			alert("success");
			//alert(jqXHR.responseText);
			create_content(stock_json);
		},
		error: function(jqXHR, status, error) {
			alert("failure to get data from YQL");
		},
		cache: false
	}

	$.ajax(query_url, settings);
	/*var para = 'q=select * from yahoo.finance.historicaldata where symbol = "'
	+ symbol + '" and startDate = "' + two_days_ago.toISOString().slice(0,10) + '" and endDate = "' 
	+ two_days_ago.toISOString().slice(0,10) + 
	'"&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=';*/
}

var create_content = function (stock_json) {

	var stock_results = stock_json.query.results.quote;
	var symbol = stock_results.Symbol;

	var header = $("<h3></h3>").append(stock_results.Name).append($("<small></small>")
		.append(stock_results.symbol));

	var favorite_button = $('<button class="btn btn-primary">Favorite</button>');
	favorite_button.data('symbol', symbol);

	var button_wrap = $('<span id="button_wrap"></span>').append(favorite_button);
	//button_wrap.data('symbol', symbol);
	button_wrap.appendTo(header);
	//favorite_button.css("float", "right");


	var img_src = "http://chart.finance.yahoo.com/z?s="+ symbol + "&t=1d&q=2&l=off&z=1";
	var img = $('<img src="' + img_src + '" alt="" width="90%" class="featuredImg">');

	var list = $("<ul></ul>");

	$.each(stock_results, function(name, value){
		list.append($("<li></li>").append(name + ": " + value));
	});


	$(".page-header").empty();
	$(".page-header").append(header);
	//$(".page-header").append(favorite_button);
	$(".stock_fig").empty();
	$(".stock_fig").append(img);

	//$("#Tags").append(img);
	$("#Tags").empty();
	$('#Tags').append(list);

}

