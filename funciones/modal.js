function ModalOpen() {
	$("#myModal").show();
}


function CloseModal(callback) {
	let confirmacion = false;
	if (typeof callback == "function") {
		
		let mensaje = "NO SE PUEDE CERRAR";
		let resp = callback();
		if (typeof resp == "object") {
			confirmacion = resp["confirmacion"];
			mensaje = (typeof resp["error"] != "undefined") ? ((resp["error"] != "") ? (resp["error"]) : (mensaje)) : (mensaje);
		}
		if (typeof resp == "boolean") {
			confirmacion = resp;
		}
		if (confirmacion) {
			$("#myModal").hide();
		} else {
			toastr.alert(mensaje)
		}
	}else{
		if(typeof callback == "boolean"){
			let mensaje = "NO SE PUEDE CERRAR";
			confirmacion = callback;
			if (confirmacion) {
				$("#myModal").hide();
			} else {
				toastr.error(mensaje)
			}
		}else{
			$("#myModal").hide();
		}
	}
	

	

}
