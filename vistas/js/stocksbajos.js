//Función que se ejecuta al inicio
function init(){

    StocksBajos();
    CreditosPendientes();
    DocumentosPendientes();
	
}

function StocksBajos(){

	$.post("../controladores/consultas.php?op=totalStocksBajos", function(data,status)
	{

		data=JSON.parse(data);

		var label=document.querySelector('#totalstockbajo');
		if(data.totalstocksbajos == ""){
			label.textContent="0";
		}else{
			label.textContent=data.totalstocksbajos;
		}

		var label=document.querySelector('#totalstockbajo2');
		if(data.totalstocksbajos == ""){
			label.textContent="0";
		}else{
			label.textContent=data.totalstocksbajos;
		}

	});

	$.post("../controladores/consultas.php?op=listarStocksBajos", function(r){

		$("#StocksBajos").html(r);

	});

}

function CreditosPendientes(){

	$.post("../controladores/consultas.php?op=totalCreditoPendientes", function(data,status)
	{

		data=JSON.parse(data);

		var label=document.querySelector('#creditop');
		if(data.totalcreditospendientes == ""){
			label.textContent="0";
		}else{
			label.textContent=data.totalcreditospendientes;
		}

		var label=document.querySelector('#creditosp2');
		if(data.totalcreditospendientes == ""){
			label.textContent="0";
		}else{
			label.textContent=data.totalcreditospendientes;
		}

	});

	$.post("../controladores/consultas.php?op=listarCreditosPendientes", function(r){

		$("#CreditosPendientes").html(r);

	});

}

function DocumentosPendientes(){

	$.post("../controladores/consultas.php?op=totalDocumentosPendientes", function(data,status)
	{

		data=JSON.parse(data);

		var label=document.querySelector('#documentosp');
		if(data.totaldocumentospendientes == ""){
			label.textContent="0";
		}else{
			label.textContent=data.totaldocumentospendientes;
		}

		var label=document.querySelector('#documentosp2');
		if(data.totaldocumentospendientes == ""){
			label.textContent="0";
		}else{
			label.textContent=data.totaldocumentospendientes;
		}

	});

	$.post("../controladores/consultas.php?op=listarDocumentosPendientes", function(r){

		$("#DocumentosPendientes").html(r);	

	});

}

init();