function usuariosV(){
var apellidos = new Spry.Widget.ValidationTextField("last_names", "none", {minChars:5, maxChars:50,validateOn:["blur", "change"]});
var nombres   = new Spry.Widget.ValidationTextField("names", "none", {minChars:5, maxChars:50, validateOn:["blur", "change"]});
var emails    = new Spry.Widget.ValidationTextField("emails", "email", {validateOn:["blur"]});
var cedula    = new Spry.Widget.ValidationTextField("cedulas", "integer", {minChars:5, maxChars:8, validateOn:["blur","change"], 	useCharacterMasking:false});
}