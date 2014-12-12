$(document).ready(function(){
    server = "http://"+window.location.hostname;
    $("#llenar").click(function(){
        var vaIGI = $("#valorIGI").val()
        var vaIVA = $("#valorIVA").val()
        $("input[name^='igi']" ).each(function(index, elemento){
            id = $(elemento).attr("id");
            id = id.slice(4,id.length);
            if ($("#checktipo_"+id).prop("checked")) {
                $(elemento).val(vaIGI);
            }
        });
        $("input[name^='iva_aduanal']" ).each(function(index, elemento){
            id = $(elemento).attr("id");
            id = id.slice(12,id.length);
            if ($("#checktipo_"+id).prop("checked")) {
                $(elemento).val(vaIVA);
            }
        });
    });
    $("#checkAll").click(function(){
        var valor = $("#checkAll").prop("checked");
        $("input[id^='checktipo_']" ).each(function(index, elemento){
            $(elemento).prop("checked",valor);
        });
    });
    $("#guardar").click(function(){
        var id = $("#cotizacion").val();
        var prv = $("#prv").val();
        var dta = $("#dta").val();
        var dta_porcentaje = $("#dta_porcentaje").val();
        var iva_factura = $("#iva_factura").val();
        $.post(server+'/operaciones/actualizarImpuestosGenrales','id=' + id +'&prv=' + prv + '&dta=' + dta + '&dta_porcentaje=' + dta_porcentaje + '&iva_factura=' + iva_factura,function(datos){
            alert(datos);
            $("#alerta-impuestos").fadeOut(300);
        }, 'json');
    });
    $("button[id^='b-actualizar_']").click(function(){
        if(confirm("¿Está seguro de actualizar?")){
            var check = $("input[id^='checktipo_']:checked");
            var id;
             for(var i = 0; i < check.length; i++){
                id = $(check[i]).attr("id");
                id = id.slice(10,id.length);
                igi = $("#igi_"+id).val();
                iva_aduanal = $("#iva_aduanal_"+id).val();
                $.post(server+'/operaciones/actualizarOrdProd','id=' + id + '&igi=' + igi+ '&iva_aduanal=' + iva_aduanal);
            }
        }
    });
});
