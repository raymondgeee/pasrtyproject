function dragMoveListener (event) {
	var target = event.target,
    x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
    y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

    target.style.webkitTransform =
    target.style.transform =
      'translate(' + x + 'px, ' + y + 'px)';

    target.setAttribute('data-x', x);
	target.setAttribute('data-y', y);
}


function dragMoveListener2 (event) {
	var target = event.target,
    x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
    y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

    target.style.webkitTransform =
    target.style.transform =
      'translate(' + x + 'px, ' + y + 'px)';

    target.setAttribute('data-x', x);
	target.setAttribute('data-y', y);
}

function formatNumber(num) {
	return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

window.dragMoveListener = dragMoveListener;
window.dragMoveListener2 = dragMoveListener2;

function runData(id){
	interact(id).draggable({
	    inertia: false,
		 // restriction: "#editorSpace",
		modifiers: [
            interact.modifiers.restrict({
              restriction: document.getElementById('editorSpace'),
              elementRect: { left: 0, right: 1, top: 0, bottom: 1 },
              endOnly: false
            })
        ],	
	    autoScroll: true,
	    onmove: dragMoveListener2,
	    onend: function (event) {
	      var textEl = event.target.querySelector('p');

	      textEl && (textEl.textContent =
	        'moved a distance of '
	        + (Math.sqrt(Math.pow(event.pageX - event.x0, 2) +
	                     Math.pow(event.pageY - event.y0, 2) | 0))
	            .toFixed(2) + 'px');
				
	    }
  	})
  	.resizable({
		preserveAspectRatio : false,
		edges : {
			left 	: false,
			right 	: true,
			bottom 	: true,
			top 	: false
		}	
	})
	.on('resizemove', function(event){
		var target = event.target,
			x = (parseFloat(target.getAttribute('data-x')) || 0),
			y = (parseFloat(target.getAttribute('data-y')) || 0);

			target.style.width = event.rect.width + 'px';
			target.style.height = event.rect.height + 'px';

			x += event.deltaRect.left; 
			y += event.deltaRect.top;

			target.style.webkitTransform = target.style.transform = 'translate(' + x + 'px,' + y + 'px)';

			target.setAttribute('data-x', x); 
			target.setAttribute('data-y', y); 
	});
}

function callInteract(idElement){
	interact("#"+idElement).draggable({
		inertia: false,
	    autoScroll: true,
		modifiers: [
			interact.modifiers.restrict({
				restriction: document.getElementById('editorSpace'),
			  	// elementRect: { left: 0, right: 1, top: 0, bottom: 1 },
				endOnly: false
			})
		],
	    onmove: dragMoveListener,
	    onend: function (event) {	
				var textEl = event.target.querySelector('p');
				if(idElement == 'layers')
				{
					var countF = $(".flavorData").length;  
					$("#imageSaveBtn").attr("disabled", false);
					$.ajax({
						url 	: 'Include Files/Custom JS/getFlavorAJAX.php',
						type 	: 'POST',
						data 	: {
									countF : countF
						},
						success : function(data){
									$("#containerFlavor").append(data);
									$(".priceFlavor").append(
																"<div class='row' id='removePrice"+countF+"'>"+
																	"<div class='col-md-6'>"+
																		"<label class='w3-medium'>FLAVOR "+(countF+1)+"</label>"+
																	"</div>"+
																	"<div class='col-md-6' style='font-weight:bold;'>"+
																		"<span class='w3-medium' id='totalFlavorPrice"+countF+"'>0.00</span> PHP"+
																	"</div>"+
																	"<input type='hidden' id='totalFlavorPriceData"+countF+"' value=0>"+
																"</div>"
															);

									$("#flavorData"+countF).change(function(){
										var designLayerPrice = $("#totalLayerPriceData").val();
										var designPrice = $("#totalDesignPriceData").val();
										var customId = $("#"+idElement+"Data"+countF).attr("custom-id");
										var dataValue = $(this).val();
										var splitData = dataValue.split("~");
										var flavorId = splitData[0];
										var flavorPrice = splitData[1];
										if(dataValue == 0) flavorPrice = 0;

										var totalValuePrice = 0;
										$(".flavorData").each(function(){
											var dataAllValue = $(this).val();
											var splitAllData = dataAllValue.split("~");
											var flavorAllPrice = splitAllData[1];
											if(dataAllValue == 0) flavorAllPrice = 0;

											totalValuePrice += parseFloat(flavorAllPrice);
										});

										$.ajax({
											url 	: 'Include Files/Custom JS/customizedSQLajax.php?type=3',
											type 	: 'POST',
											data 	: {
														customId 			: customId,
														flavorId 			: flavorId,
														flavorPrice 		: flavorPrice
											},
											success : function(data){
														// console.log(data);
														// $("#"+idElement+"Data"+countCloned).attr("custom-id",data);
											}
										});

										var totalData = parseFloat(flavorPrice);
										var totalPriceData = parseFloat(totalValuePrice) + parseFloat(designPrice) + parseFloat(designLayerPrice);
										$("#totalFlavorPriceData"+countF).val(totalData+".00");

										$("#totalFlavorPrice"+countF).html(totalData+".00");
										$("#totalPrice").html(formatNumber(totalPriceData)+".00");
									});
						}
					});
				}

	      		textEl && (textEl.textContent =
				'moved a distance of '
				+ (Math.sqrt(Math.pow(event.pageX - event.x0, 2) +
							Math.pow(event.pageY - event.y0, 2) | 0))
					.toFixed(2) + 'px');
	    	}
	})
	.resizable({
		preserveAspectRatio : false,
		edges : {
			left 	: false,
			right 	: true,
			bottom 	: true,
			top 	: false
		}	
	})
	.on('resizemove', function(event){
		var target = event.target,
			x = (parseFloat(target.getAttribute('data-x')) || 0),
			y = (parseFloat(target.getAttribute('data-y')) || 0);

			target.style.width = event.rect.width + 'px';
			target.style.height = event.rect.height + 'px';

			x += event.deltaRect.left; 
			y += event.deltaRect.top;

			target.style.webkitTransform = target.style.transform = 'translate(' + x + 'px,' + y + 'px)';

			target.setAttribute('data-x', x); 
			target.setAttribute('data-y', y); 
	})
	.on('move', function (event) {
	    var interaction = event.interaction;
	    if (interaction.pointerIsDown && !interaction.interacting() && event.currentTarget.getAttribute('clonable') != 'false') 
	    {
	        var original = event.currentTarget;
	        var clone = event.currentTarget.cloneNode(true);
	        var x = clone.offsetLeft;
	        var y = clone.offsetTop;
		 	var positionLayer = $("#"+original.getAttribute('id')).offset();
		 	var countCloned = $("."+idElement+"Data").length;
		 	var positionLayerLeft = positionLayer.left - 400;
			var positionLayerTop = positionLayer.top - 300;
			 
	        clone.setAttribute('clonable','false');
	        clone.style.left = positionLayerLeft+"px";
	        clone.style.top = positionLayerTop+"px";
	        clone.style.position = "absolute";
	        clone.style.width = "250px";
	        clone.style.height = "100px";
	        clone.className = idElement+'Data';
	        clone.id = idElement+'Data'+countCloned;
	        original.parentElement.appendChild(clone);
	        interaction.start({ name: 'drag' },event.interactable,clone);

			runData("#"+idElement+"Data"+countCloned);
			
			if(idElement != 'layers')
			{
				var layerCount = $(".layersData").length;
				if(layerCount == 0)
				{
					iziToast.info({
						title: 'Warning',
						message: '<b>Make a layer first.</b>',
						close: true,
						overlay: true,
						position: 'topCenter',
						timeout: 1500
					});
					$("#"+idElement+"Data"+countCloned).remove();
					return false;
				}
			}

            var priceMeter = 0;
            var dataPrice = 0;
            var priceLayerMeter = 0;
            var dataLayerPrice = 0;
            if(idElement == "layers")
            {
                priceLayerMeter = $("#totalLayerPriceData").val();
                priceMeter = $("#totalDesignPriceData").val();
                dataLayerPrice = original.getAttribute('data-price');
            }
	        else
            {
                priceLayerMeter = $("#totalLayerPriceData").val();
                priceMeter = $("#totalDesignPriceData").val();
                dataPrice = original.getAttribute('data-price');
            }

	        var flavorPrice = $("#totalFlavorPrice").html();
			var dataId = original.getAttribute('data-id');
			
			var totalValuePrice = 0;
			$(".flavorData").each(function(){
				var dataAllValue = $(this).val();
				var splitAllData = dataAllValue.split("~");
				var flavorAllPrice = splitAllData[1];
				if(dataAllValue == 0) flavorAllPrice = 0;

				totalValuePrice += parseFloat(flavorAllPrice);
			});

			var totalPriceData = $("#totalPriceData").val();
	        var totalPrice = parseFloat(priceMeter) + parseFloat(dataPrice);
	        var totalLayerPrice = parseFloat(priceLayerMeter) + parseFloat(dataLayerPrice);
			var totalDataPrice = parseFloat(totalValuePrice) + parseFloat(totalPrice) + parseFloat(totalLayerPrice);

	        $("#totalLayerPriceData").val((totalLayerPrice)+".00");
	        $("#totalDesignPriceData").val((totalPrice)+".00");
			$("#totalPriceData").val((totalDataPrice)+".00");

	        $("#totalLayerPrice").html(formatNumber(totalLayerPrice)+".00");
	        $("#totalDesignPrice").html(formatNumber(totalPrice)+".00");
			$("#totalPrice").html(formatNumber(totalDataPrice)+".00");
			
			var layerNumber = 0;
			if(idElement == 'layers')
			{
				var layerNumber = countCloned+1;
			}

	        $.ajax({
	        	url 	: 'Include Files/Custom JS/customizedSQLajax.php?type=1',
	        	type 	: 'POST',
	        	data 	: {
	        				dataPrice 	: dataPrice,
	        				layerNumber : layerNumber,
	        				dataId 		: dataId
	        	},
	        	success : function(data){
	        				// console.log(data);
	        				$("#"+idElement+"Data"+countCloned).attr("custom-id",data);
	        	}
	        });
		
			// console.log(clone);
	        $("."+idElement+"Data").appendTo($( "#editorSpace" ));
	        $("#"+idElement+"Data"+countCloned).dblclick(function(e){
				if(idElement == 'layers')
				{
					$(this).attr("data-identifier",(countCloned+1));
					var dataCount = $("."+idElement+"Data").length;

					var dataIdentifier = $(this).attr("data-identifier");
					console.log(dataCount+" "+(dataIdentifier));
					if(dataCount != (dataIdentifier))
					{
						iziToast.info({
							title: 'Warning',
							message: '<b>Please Delete the previous layer.</b>',
							close: true,
							overlay: true,
							position: 'topCenter',
							timeout: 1500
						});

						return false;
					}

					$("#removeSelection"+countCloned).remove();
					$("#removePrice"+countCloned).remove();
				}

				$(this).remove();
				
	        	var priceMeter = 0;
                var dataPrice = 0;
                var priceLayerMeter = 0;
                var dataLayerPrice = 0;
                if(idElement == "layers")
                {
                    priceLayerMeter = $("#totalLayerPriceData").val();
                    priceMeter = $("#totalDesignPriceData").val();
                    dataLayerPrice = original.getAttribute('data-price');
                }
                else
                {
                    priceLayerMeter = $("#totalLayerPriceData").val();
                    priceMeter = $("#totalDesignPriceData").val();
                    dataPrice = original.getAttribute('data-price');
                }

	        	var customId = $(this).attr("custom-id");
				var flavorPrice = $("#totalFlavorPrice").html();
				
				var totalValuePrice = 0;
				$(".flavorData").each(function(){
					var dataAllValue = $(this).val();
					var splitAllData = dataAllValue.split("~");
					var flavorAllPrice = splitAllData[1];
					if(dataAllValue == 0) flavorAllPrice = 0;

					totalValuePrice += parseFloat(flavorAllPrice);
				});

				var totalPriceData = $("#totalPriceData").val();
	        	var minusPrice = parseFloat(priceMeter) - parseFloat(dataPrice);
	        	var minusLayerPrice = parseFloat(priceLayerMeter) - parseFloat(dataLayerPrice);
	        	var totalDataPrice = parseFloat(minusPrice) + parseFloat(totalValuePrice) + parseFloat(minusLayerPrice);

				$("#totalLayerPriceData").val((minusLayerPrice)+".00");
				$("#totalDesignPriceData").val((minusPrice)+".00");
				$("#totalPriceData").val((totalDataPrice)+".00");
				
	        	$("#totalLayerPrice").html(formatNumber(minusLayerPrice)+".00");
	        	$("#totalDesignPrice").html(formatNumber(minusPrice)+".00");
				$("#totalPrice").html(formatNumber(totalDataPrice)+".00");
				
				if(totalDataPrice == 0)
				{
					$("#imageSaveBtn").attr("disabled", true);
				}
	            
	            $.ajax({
		        	url 	: 'Include Files/Custom JS/customizedSQLajax.php?type=2',
		        	type 	: 'POST',
		        	data 	: {
		        				customId 		: customId
		        	},
		        	success : function(data){
		        				console.log(data);
		        	}
		        });

	            e.stopPropagation();
	        });
	    }
	});
}
