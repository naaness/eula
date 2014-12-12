$(document).ready(function(){


	$("#barrita").animate({'width':20+'%'},500,function(){
		$("#barrita").animate({'width':70+'%'},50,function(){
			$("#barrita").hide();
		});
	});
	//alert("Listo");

	$(".close").click(function(){
		$(".alert").fadeOut(200);
	});

	/*$(".nav-p").click(function(){
		$('.submenu').fadeIn(300);
	});*/

    $("button[id^='eliminar_']").click(function() {
        if (confirm("Seguro que desea eliminar"))
        {

        }
        else
        {
            event.preventDefault();
        };
    });


	setTimeout( "jQuery('#mensaje').fadeOut(1000);",5000 );

	if ($('#example').length) {
		$('#example').dataTable({
			//"scrollX": true,
			"pagingType": "full_numbers",
			"language": {
				"url": _root_+"public/dataTables/lang/es_ES.json",
				"decimal": ",",
				"thousands": "."
			},
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
		});

		$('#searchTable').searchTable({fadeIn:600,fadeOut:200});

		$('.tooltip_info').tooltip('hide');
	};
});

$(window).load(function(){
	$("#barrita").animate({'width':100+'%'},function(){
	});
});
