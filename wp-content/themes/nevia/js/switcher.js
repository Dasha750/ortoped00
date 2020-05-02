/*-----------------------------------------------------------------------------------
/* Styles Switcher
-----------------------------------------------------------------------------------*/


(function($){
	$(document).ready(function(){

		// Color Changer
		$(".green" ).click(function(){
			$("#colors" ).attr("href", "http://nevia.purethemes.wpengine.com/wp-content/themes/nevia/css/colors/green.css" );
			return false;
		});

		$(".blue" ).click(function(){
			$("#colors" ).attr("href", "http://nevia.purethemes.wpengine.com/wp-content/themes/nevia/css/colors/blue.css" );
			return false;
		});

		$(".orange" ).click(function(){
			$("#colors" ).attr("href", "http://nevia.purethemes.wpengine.com/wp-content/themes/nevia/css/colors/orange.css" );
			return false;
		});

		$(".navy" ).click(function(){
			$("#colors" ).attr("href", "http://nevia.purethemes.wpengine.com/wp-content/themes/nevia/css/colors/navy.css" );
			return false;
		});

		$(".yellow" ).click(function(){
			$("#colors" ).attr("href", "http://nevia.purethemes.wpengine.com/wp-content/themes/nevia/css/colors/yellow.css" );
			return false;
		});

		$(".peach" ).click(function(){
			$("#colors" ).attr("href", "http://nevia.purethemes.wpengine.com/wp-content/themes/nevia/css/colors/peach.css" );
			return false;
		});

		$(".beige" ).click(function(){
			$("#colors" ).attr("href", "http://nevia.purethemes.wpengine.com/wp-content/themes/nevia/css/colors/beige.css" );
			return false;
		});

		$(".purple" ).click(function(){
			$("#colors" ).attr("href", "http://nevia.purethemes.wpengine.com/wp-content/themes/nevia/css/colors/purple.css" );
			return false;
		});

		$(".red" ).click(function(){
			$("#colors" ).attr("href", "http://nevia.purethemes.wpengine.com/wp-content/themes/nevia/css/colors/red.css" );
			return false;
		});

		$(".pink" ).click(function(){
			$("#colors" ).attr("href", "http://nevia.purethemes.wpengine.com/wp-content/themes/nevia/css/colors/pink.css" );
			return false;
		});

		$(".celadon" ).click(function(){
			$("#colors" ).attr("href", "http://nevia.purethemes.wpengine.com/wp-content/themes/nevia/css/colors/celadon.css" );
			return false;
		});

		$(".brown" ).click(function(){
			$("#colors" ).attr("href", "http://nevia.purethemes.wpengine.com/wp-content/themes/nevia/css/colors/brown.css" );
			return false;
		});

		$(".cherry" ).click(function(){
			$("#colors" ).attr("href", "http://nevia.purethemes.wpengine.com/wp-content/themes/nevia/css/colors/cherry.css" );
			return false;
		});

		$(".gray" ).click(function(){
			$("#colors" ).attr("href", "http://nevia.purethemes.wpengine.com/wp-content/themes/nevia/css/colors/gray.css" );
			return false;
		});

		$(".dark" ).click(function(){
			$("#colors" ).attr("href", "http://nevia.purethemes.wpengine.com/wp-content/themes/nevia/css/colors/dark.css" );
			return false;
		});

		$(".cyan" ).click(function(){
			$("#colors" ).attr("href", "http://nevia.purethemes.wpengine.com/wp-content/themes/nevia/css/colors/cyan.css" );
			return false;
		});

		$(".olive" ).click(function(){
			$("#colors" ).attr("href", "http://nevia.purethemes.wpengine.com/wp-content/themes/nevia/css/colors/olive.css" );
			return false;
		});

		$(".dirty-green" ).click(function(){
			$("#colors" ).attr("href", "http://nevia.purethemes.wpengine.com/wp-content/themes/nevia/css/colors/dirty-green.css" );
			return false;
		});

		$("#style-switcher h2 a").click(function(e){
			e.preventDefault();
			var div = $("#style-switcher");
			console.log(div.css("left"));
			if (div.css("left") === "-195px") {
				$("#style-switcher").animate({
					left: "0px"
				});
			} else {
				$("#style-switcher").animate({
					left: "-195px"
				});
			}
		})

		// Menu Style Switcher
	   $("#menu-style").change(function(e){
			if( $(this).val() == 1){
				$("#navigation").removeClass("style-2");
			} else{
				$("#navigation").addClass("style-2");
			}
		})

		$(".colors li a").click(function(e){
			e.preventDefault();
			$(this).parent().parent().find("a").removeClass("active");
			$(this).addClass("active");
		})

		$(".bg li a").click(function(e){
			e.preventDefault();
			$(this).parent().parent().find("a").removeClass("active");
			$(this).addClass("active");
			var bg = $(this).css("backgroundImage");
			$("body").css("backgroundImage",bg)
		})

		$("#reset a").click(function(e){
			var bg = $(this).css("backgroundImage");
			$("body").css("backgroundImage","url(./images/bg/noise.png)");
			$("#navigation" ).removeClass("style-2")
		})


});

})(this.jQuery);
