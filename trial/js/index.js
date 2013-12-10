$(document).ready(function() {

	change_to_search_view();

	/* check favorite list to see if it's already in list */

    $("#top_search_form").on('submit', function(e) {
    	e.preventDefault();
    });

    $(".page-header").on('click', 'button', null, function(e) {
    	e.preventDefault();

    	addToFavorite($(this).data('symbol'), $(this).data('long_name'));
    });

    $("#side_bar").on('click', 'div', null, function(e) {
    	e.preventDefault();
    	var text = $(this).find('p').text();
      	var symbol = trimToSymbol(text);
    	change_to_stock_view();
    	call_YQL(symbol);
    });

    $("#favorite_list").on('click', 'ul>li', null, function(e) {
    	e.preventDefault();
    	change_to_stock_view();
    	call_YQL(trimToSymbol($(this).text()));
    });

    /* day_control listener! */
    $('#day_control').on('click', 'button' , null, function(e) {
    	change_fig_time($(this).data('symbol'), $(this).data('time'));
    });
});

var base_url = "http://wwwp.cs.unc.edu/Courses/comp426-f13/cchunhao/final/trial/";

var yahoo_base_url = "http://query.yahooapis.com/v1/public/yql?";

var YQL_stock = "select * from yahoo.finance.stocks where symbol='yhoo'";

//	two_days_ago.setDate(two_days_ago.getDate() - 2);

var change_fig_time = function (symbol, time) {
	var img_src_url = 'http://chart.finance.yahoo.com/z?s='+ symbol + "&t=" + time + 
	'&q=2&l=off&z=1"';
	var new_img = $('<img src="' + img_src_url + '" alt="" width="90%" class="featuredImg">');
	$('.stock_fig img').replaceWith(new_img);
}

var trimToSymbol = function(string) {
    var tempArray = string.split('(');
    var symbol = (tempArray[1].split(')'))[0];
    return symbol;
}

var updateFavoriteList = function(list_json) {
	var symbol = list_json.stock_name;
	var long_name = list_json.stock_long_name;
	var list = $('<li><a href="">' + long_name + "(" + symbol + ")" + '</a></li>');

	var div_list = $('<div class="list-group"></div>');
	var a_list = $('<a href="#" class="list-group-item"></a>');
	var p_list = $('<p class="list-group-item-text"></p>');

	p_list.append(long_name + "(" + symbol + ")");
	a_list.append(p_list).appendTo(div_list);
								
	$('#favorite_list>ul').append(list);
	$('#side_bar').append(div_list);
}

var addToFavorite = function(symbol, long_name) {
	var query_url = base_url + "list_content.php";
	var settings = {
		type: "POST",
		dataType: "json",
		data: 'stock_name=' + symbol + '&stock_long_name=' + long_name,
		success: function(list_json, status, jqXHR) {
			//alert(jqXHR.responseText);
			updateFavoriteList(list_json);
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

	var query_url = yahoo_base_url + para;
	var settings = {
		type: "GET",
		success: function(stock_json, status, jqXHR) {
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
	var long_name = stock_results.Name;
	var stock_change = $("<p id='change_stock'></p>").append("(" + 
		stock_results['Change_PercentChange'] + ")");

	var header = $("<h3></h3>").append(long_name).append($("<small></small>")
		.append(stock_results.symbol)).append(stock_change);


	stock_change.appendTo(header);

	var favorite_button = $('<button class="btn btn-primary">Favorite</button>');
	favorite_button.data('symbol', symbol);
	favorite_button.data('long_name', long_name);

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

	var button_1d = $('<button class="btn btn-primary pull-right">1d</button>').data('symbol', symbol);
	var button_5d = $('<button class="btn btn-primary pull-right">5d</button>').data('symbol', symbol);
	var button_1m = $('<button class="btn btn-primary pull-right">1m</button>').data('symbol', symbol);
	var button_3m = $('<button class="btn btn-primary pull-right">3m</button>').data('symbol', symbol);
	var button_6m = $('<button class="btn btn-primary pull-right">6m</button>').data('symbol', symbol);
	var button_1y = $('<button class="btn btn-primary pull-right">1y</button>').data('symbol', symbol);
	var button_2y = $('<button class="btn btn-primary pull-right">2y</button>').data('symbol', symbol);

	button_1d.data('time', '1d');
	button_5d.data('time', '5d');
	button_1m.data('time', '1m');
	button_3m.data('time', '3m');
	button_6m.data('time', '6m');
	button_1y.data('time', '1y');
	button_2y.data('time', '2y');

	$('#day_control').empty();
	$('#day_control').append(button_2y).append(button_1y).append(button_6m).append(button_3m)
	.append(button_1m).append(button_5d).append(button_1d);
	//$("#Tags").append(img);
	$("#Tags").empty();
	$('#Tags').append(list);

}

