$(document).ready(function() {
    alert("Your initialization code goes here!");

    $('#info_boxes').hide();

    $("#top_search_form").on('submit', function(e) {
    	e.preventDefault();
    });

    $(".page-header").on('click', 'button', null, function(e) {
    	e.preventDefault();

    	addToFavorite($(this).data('symbol'));
    });

    $("#side_bar").on('click', 'div', null, function(e) {
    	var symbol = $(this).find('p').text();
    	e.preventDefault();
    	change_to_stock_view();
    	call_YQL(symbol);
    });

    $("#favorite_list").on('click', 'ul>li', null, function(e) {
    	e.preventDefault();
    	change_to_stock_view();
    	call_YQL($(this).text());
    });

});

var base_url = "http://wwwp.cs.unc.edu/Courses/comp426-f13/cchunhao/final/trial/";

var yahoo_base_url = "http://query.yahooapis.com/v1/public/yql?";

var YQL_stock = "select * from yahoo.finance.stocks where symbol='yhoo'";

//	two_days_ago.setDate(two_days_ago.getDate() - 2);

var addToFavorite = function(symbol) {
	alert(symbol);
	var query_url = base_url + "list_content.php";
	var settings = {
		type: "POST",
		dataType: "json",
		data: 'stock_name=' + symbol,
		success: function(list_json, status, jqXHR) {
			alert("success haha");
			alert(jqXHR.responseText);
			var list = $('<li><a href="">' + symbol + '</a></li>');
				$('#favorite_list>ul').append(list);
		},
		error: function(jqXHR, status, error) {
			alert("You've already added!");			
		},
		cache: false
	}

	$.ajax(query_url, settings);

}

var change_to_stock_view = function() {
	$('#bodypart').hide();
	$('#info_boxes').show();
}
var change_to_search_view = function() {
	$('#info_boxes').hide();
	$('#bodypart').show();	
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
}

var create_content = function (stock_json) {

	var stock_results = stock_json.query.results.quote;
	var symbol = stock_results.Symbol;
	var stock_change = $("<p id='change_stock'></p>").append("(" + 
		stock_results['Change_PercentChange'] + ")");

	var header = $("<h3></h3>").append(stock_results.Name).append($("<small></small>")
		.append(stock_results.symbol)).append(stock_change);


	stock_change.appendTo(header);

	var favorite_button = $('<button class="btn btn-primary">Favorite</button>');
	favorite_button.data('symbol', symbol);

	var button_wrap = $('<span id="button_wrap"></span>').append(favorite_button);
	//button_wrap.data('symbol', symbol);
	button_wrap.appendTo(header);
	//favorite_button.css("float", "right");


	var img_src = "http://chart.finance.yahoo.com/z?s="+ symbol + "&t=1d&q=2&l=off&z=1";
	var img = $('<img src="' + img_src + '" alt="" width="90%" class="featuredImg">');

	var list = $("<ul></ul>");


	list.append($("<li></li>").append('Prev. Close' + ": " + 
		stock_results['PreviousClose']));
	list.append($("<li></li>").append("Day's range" + ": " + 
		stock_results['DaysRange']));
	list.append($("<li></li>").append('Open' + ": " + 
		stock_results['Open']));
	list.append($("<li></li>").append('Market Cap' + ": " + 
		stock_results['MarketCapitalization']));
	list.append($("<li></li>").append('Bid' + ": " + 
		stock_results['Bid']));
	
	list.append($("<li></li>").append("Vol" + ": " + 
		stock_results['Volume']));
	list.append($("<li></li>").append('Ask' + ": " + 
		stock_results['Ask']));
	list.append($("<li></li>").append('Avg. Vol' + ": " + 
		stock_results['AverageDailyVolume']));
	list.append($("<li></li>").append("Year's Range" + ": " + 
		stock_results['YearRange']));	
	list.append($("<li></li>").append('Stock Ex.' + ": " + 
		stock_results['StockExchange']));
	/*
	$.each(stock_results, function(name, value){
		list.append($("<li></li>").append(name + ": " + value));
	});
*/

	$(".page-header").empty();
	$(".page-header").append(header);
	//$(".page-header").append(favorite_button);
	$(".stock_fig").empty();
	$(".stock_fig").append(img);

	//$("#Tags").append(img);
	$("#Tags").empty();
	$('#Tags').append(list);

}

