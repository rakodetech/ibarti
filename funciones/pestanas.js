function iniciar_tab(pag){
 $(".tablinks").eq(pag).addClass("active")
 $(".tabcontent").hide();
 $(".tabcontent").eq(pag).show();
}

function openTap(index) {
 $(".tablinks" ).removeClass( "active" );
 $(".tablinks").eq(index).addClass("active")
 $(".tabcontent").hide();
 $(".tabcontent").eq(index).show();
}
