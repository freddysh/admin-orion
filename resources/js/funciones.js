

function mostrar_provincias(departamento_id){
    // alert('hola:'+departamento_id);
    console.log('departamento_id:'+departamento_id);
    if(departamento_id>0){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
        type:'POST',
        url:'mostrar-provincias',
        data:{departamento_id:departamento_id},
        success:function(data){
            $("select[name='provincia'").html('');
            $("select[name='provincia'").html(data.options);
        }
        });
    }
}
function mostrar_distritos(provincia_id){
    // alert('hola:'+departamento_id);
    console.log('departamento_id:'+provincia_id);
    if(provincia_id>0){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
        type:'POST',
        url:'mostrar-distritos',
        data:{provincia_id:provincia_id},
        success:function(data){
            $("select[name='distrito'").html('');
            $("select[name='distrito'").html(data.options);
        }
        });
    }
}
function mostrar_comunidades(distrito_id,asociacion_id){
    // alert('hola:'+departamento_id);
    console.log('distrito_id:'+distrito_id);
    if(distrito_id>0){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
        type:'POST',
        url:'mostrar-comunidades',
        data:{distrito_id:distrito_id},
        success:function(data){

            $("#comunidad_"+asociacion_id).html('');
            $("#comunidad_"+asociacion_id).html(data.options);
        }
        });
    }
}

function borrar_foto_cliente(id){
    // alert('hola:'+departamento_id);
    $("#"+id).remove();

}

function borrar_foto_asociacion(id){
    // alert('hola:'+departamento_id);
    $("#"+id).remove();

}

function eliminar_producto_(id){

    Swal.fire({
        title: 'MENSAJE DEL SISTEMA',
        text: "¿Estas seguro de borrar el producto?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar!',
        cancelButtonText:'No, cancelar'
      }).then((result) => {
        if (result.value) {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'get',
                url:'/admin/producto/delete/'+id,
                // data:{id:id},
                success:function(data){
                    if(data==1){
                        Swal.fire(
                            'Borrado!',
                            'El producto ha sido borrado.',
                            'success'
                        );
                        $('#row_lista_productos_'+id).remove();
                    }
                    else if(data==0){
                        Swal.fire(
                            'Error!',
                            'Hubo un error al borrar el producto.',
                            'danger'
                        )
                    }
                }
             });
        }
      })

}
function eliminar_asociacion(id){

    Swal.fire({
        title: 'MENSAJE DEL SISTEMA',
        text: "¿Estas seguro de borrar la asociacion?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar!',
        cancelButtonText:'No, cancelar'
      }).then((result) => {
        if (result.value) {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'get',
                url:'/admin/asociacion/delete/'+id,
                // data:{id:id},
                success:function(data){
                    if(data==1){
                        Swal.fire(
                            'Borrado!',
                            'La asociacion ha sido borrada.',
                            'success'
                        );
                        $('#row_lista_asociaciones_'+id).remove();
                    }
                    else if(data==0){
                        Swal.fire(
                            'Error!',
                            'Hubo un error al borrar la asociacion.',
                            'danger'
                        )
                    }
                }
             });
        }
      })
}

function buscar_asociacion(ruc_rs){
    var valor=$.trim(ruc_rs);
    if(valor.length>0){
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'get',
            url:'/admin/asociacion/buscar/'+valor,
            beforeSend: function(data1) {
                // console.log('data1:'+data1);
                $("#asociacion").html('');
                $("#asociacion").html('<i class="fas fa-stroopwafel fa-spin fa-3x"></i>');
            },
            success:function(data){
                $('#asociacion').html('');
                $('#asociacion').html(data);
            }
         });
    }
}
// var nro_hijos_acti=1;
// var nro_hijos_comi=1;
// var nro_hijos_hosp=1;
// var nro_hijos_tran=1;
// var nro_hijos_serv=1;
function agregar_precio(valor1,valor2){

    var valor=$('#cantidad_precios_'+valor1+'_'+valor2).val();
    valor++
    $('#cantidad_precios_'+valor1+'_'+valor2).val(valor);
    var cadena='<tr id="row_'+valor1+'_precios_'+valor2+'_'+valor+'">'+
    '<td>'+
    '<select class="form-control" name="categoria_n[]" id="categoria">'+
        '<option value="Nacional">Nacional</option>'+
        '<option value="Extranjero">Extranjero</option>';
        if(valor1=='a'){
            cadena+='<option value="Agencia">Agencia</option>';
        }
    cadena+='</select>'+
    '</td>'+
    '<td>'+
        '<input class="form-control" type="number" min="0" name="minimo_'+valor1+'_n_'+valor2+'[]" id="minimo">'+
    '</td>'+
    '<td>'+
        '<input class="form-control" type="number" min="0" name="maximo_'+valor1+'_n_'+valor2+'[]" id="maximo">'+
    '</td>'+
    '<td>'+
        '<input class="form-control" type="number" min="0" name="precio_'+valor1+'_n_'+valor2+'[]" id="precio">'+
    '</td>'+
    '<td>'+
        '<button class="btn btn-danger" type="button" onclick="borrar_precio(\''+valor1+'\',\''+valor2+'\',\''+valor+'\')"><i class="fas fa-trash-alt"></i></button>'+
        '<button class="btn btn-success d-none" type="button" onclick="agregar_precio(\''+valor1+'\')"><i class="fas fa-plus"></i></button>'+
    '</td>'+
'</tr>';
    $('#'+valor1+'_precios_'+valor2).append(cadena);
}
function borrar_precio(valor1,valor2,valor3){
    $('#row_'+valor1+'_precios_'+valor2+'_'+valor3).remove();

}
// function guardar_actividad(){
//     $.ajaxSetup({
//         headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//     $.ajax({
//         type:'post',
//         url: $("#form_actividad").attr('action'),
//         method: $("#form_actividad").attr('method'),
//         data: $("#form_actividad").serialize(),
//         // dataType:'json',
//         // async:false,
//         processData: false,
//         contentType: false,
//         success:function(data){
//             alert('rpta:'+data);
//         }
//         });
// }
function enviar_datos(valor1,valor2){
    // tinymce.triggerSave();
    if($('#'+valor1+'_asociacion_id').val()==''){
        $('#ruc_rs').focus();
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Ingrese un numero de ruc, razon social o nombre',
          })
        return false;
    }
    if(valor1=='a'||valor1=='h'||valor1=='t'||valor1=='s'){
        if($('#titulo_'+valor1+'_'+valor2).val().trim()==''){
            $('#titulo_'+valor1+'_'+valor2).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese el titulo',
            })
            return false;
        }
    }
    if(valor1=='a'){
        if($('#categoria_'+valor1+'_'+valor2).val().trim()==''){
            $('#categoria_'+valor1+'_'+valor2).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese la categoria',
            })
            return false;
        }
        if($('#edad_minima_'+valor1+'_'+valor2).val().trim()==''){
            $('#edad_minima_'+valor1+'_'+valor2).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese la edad minima',
            })
            return false;
        }
        if($('#dificultad_'+valor1+'_'+valor2).val().trim()==''){
            $('#dificultad_'+valor1+'_'+valor2).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese la dificultad',
            })
            return false;
        }
        if($('#tolerancia_'+valor1+'_'+valor2).val().trim()==''){
            $('#tolerancia_'+valor1+'_'+valor2).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese la tolerancia',
            })
            return false;
        }
    }

    if($('#descripcion_'+valor1+'_'+valor2).val().trim()==''){
        $('#descripcion_'+valor1+'_'+valor2).focus();
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Ingrese una descripcion',
          })
        return false;
    }
    if(valor1=='a'){
        if($('#duracion_'+valor1+'_'+valor2).val().trim()==''){
            $('#duracion_'+valor1+'_'+valor2).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese la duracion',
            })
            return false;
        }
        if($('#periodo_'+valor1+'_'+valor2).val().trim()==''){
            $('#periodo_'+valor1+'_'+valor2).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese el periodo',
            })
            return false;
        }
        if($('#incluye_'+valor1+'_'+valor2).val().trim()==''){
            $('#incluye_'+valor1+'_'+valor2).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese lo que incluye',
            })
            return false;
        }
        if($('#no_incluye_'+valor1+'_'+valor2).val().trim()==''){
            $('#no_incluye_'+valor1+'_'+valor2).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese lo que no incluye',
            })
            return false;
        }
        if($('#disponible_'+valor1+'_'+valor2).val().trim()==''){
            $('#disponible_'+valor1+'_'+valor2).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese los idiomas disponbles',
            })
            return false;
        }
        if($('#recomendaciones_'+valor1+'_'+valor2).val().trim()==''){
            $('#recomendaciones_'+valor1+'_'+valor2).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese las recomendaciones',
            })
            return false;
        }
    }
    // $("input[name='foto[]']").each(function(indice, elemento) {
    //     if($(elemento).val()==''){
    //         $(elemento).focus();
    //         Swal.fire(
    //             'Good job!',
    //             'You clicked the button!',
    //             'success'
    //           )
    //         return false;
    //     }
    // });
    var minimo=0;
    $("input[name='minimo_"+valor1+'_'+valor2+"[]']").each(function(indice, elemento) {
        if(!$.isNumeric($(elemento).val())){
            minimo++;
            $(elemento).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese un valor numerico',
            })
            return false;
        }
    });
    var maximo=0;
    $("input[name='maximo_"+valor1+'_'+valor2+"[]']").each(function(indice, elemento) {
        if(!$.isNumeric($(elemento).val())){
            maximo++;
            $(elemento).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese un valor numerico',
            })
            return false;
        }
    });
    var precio=0;
    $("input[name='precio_"+valor1+'_'+valor2+"[]']").each(function(indice, elemento) {
        if(!$.isNumeric($(elemento).val())){
            precio++;
            $(elemento).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese un valor numerico',
            })
            return false;
        }
    });

    //if(!es_correcto_fotos('Para la foto de portada','foto_portada_e_'+valor1+'_'+valor2,'1770','900')){
    //    return false;
    //}
    //if(!es_correcto_fotos('Para la foto de miniatura','foto_miniatura_'+valor1+'_'+valor2,'550','345')){
    //    return false;
    //}
    //if(!es_correcto_fotos_galeria('Para las fotos de la galeria','foto_'+valor1+'_'+valor2,'1280','665')){
    //    return false;
    //}
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: $("#form_"+valor1+'_'+valor2).attr('action'),
        method: $("#form_"+valor1+'_'+valor2).attr('method'),
        data:new FormData($("#form_"+valor1+'_'+valor2)[0]),
        dataType:'json',
        contentType:false,
        cache:false,
        processData: false,
        beforeSend: function() {
            $('#rpt_form_'+valor1+'_'+valor2).html('');
            $('#rpt_form_'+valor1+'_'+valor2).html('<i class="fas fa-stroopwafel fa-spin fa-3x"></i>');
        },
        success:function(data){
            $('#rpt_form_'+valor1+'_'+valor2).html(data.mensaje);
            $('#rpt_form_'+valor1+'_'+valor2).addClass(data.nombre_clase);
            $("#form_"+valor1+'_'+valor2)[0].reset();
        }
        });
}
function buscar_servicios(ruc_rs){
    var valor=$.trim(ruc_rs);
    if(valor.length>0){
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'get',
            url:'/admin/servicios/buscar/'+valor,
            beforeSend: function() {
                $('#servicios').html('');
                $('#servicios').html('<i class="fas fa-stroopwafel fa-spin fa-3x"></i>');
            },
            success:function(data){
                $('#servicios').html('');
                $('#servicios').html(data);
            }
         });
    }
}

function enviar_datos_editar(valor1,valor2){
    // tinymce.triggerSave();
    if($('#'+valor1+'_asociacion_id').val()==''){
        $('#ruc_rs').focus();
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Ingrese un numero de ruc, razon social o nombre',
          })
        return false;
    }
    if($('#titulo_'+valor1+'_'+valor2).val().trim()==''){
        $('#titulo_'+valor1+'_'+valor2).focus();
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Ingrese el titulo',
          })
        return false;
    }
    // if($('#categoria_'+valor1+'_'+valor2).val().trim()==''){
    //     $('#categoria_'+valor1+'_'+valor2).focus();
    //     Swal.fire({
    //         type: 'error',
    //         title: 'Oops...',
    //         text: 'Ingrese la categoria',
    //       })
    //     return false;
    // }
    if($('#descripcion_'+valor1+'_'+valor2).val().trim()==''){
        $('#descripcion_'+valor1+'_'+valor2).focus();
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Ingrese una descripcion',
          })
        return false;
    }
    // $("input[name='foto[]']").each(function(indice, elemento) {
    //     if($(elemento).val()==''){
    //         $(elemento).focus();
    //         Swal.fire(
    //             'Good job!',
    //             'You clicked the button!',
    //             'success'
    //           )
    //         return false;
    //     }
    // });
    var minimo=0;
    $("input[name='minimo_"+valor1+'_'+valor2.replace("e", "n")+"[]']").each(function(indice, elemento) {
        if(!$.isNumeric($(elemento).val())){
            minimo++;
            $(elemento).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese un valor numerico',
            })
            return false;
        }
    });
    var maximo=0;
    $("input[name='maximo_"+valor1+'_'+valor2.replace("e", "n")+"[]']").each(function(indice, elemento) {
        if(!$.isNumeric($(elemento).val())){
            maximo++;
            $(elemento).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese un valor numerico',
            })
            return false;
        }
    });
    var precio=0;
    $("input[name='precio_"+valor1+'_'+valor2.replace("e", "n")+"[]']").each(function(indice, elemento) {
        if(!$.isNumeric($(elemento).val())){
            precio++;
            $(elemento).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese un valor numerico',
            })
            return false;
        }
    });
    var minimo=0;
    $("input[name='minimo_"+valor1+'_'+valor2+"[]']").each(function(indice, elemento) {
        if(!$.isNumeric($(elemento).val())){
            minimo++;
            $(elemento).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese un valor numerico',
            })
            return false;
        }
    });
    var maximo=0;
    $("input[name='maximo_"+valor1+'_'+valor2+"[]']").each(function(indice, elemento) {
        if(!$.isNumeric($(elemento).val())){
            maximo++;
            $(elemento).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese un valor numerico',
            })
            return false;
        }
    });
    var precio=0;
    $("input[name='precio_"+valor1+'_'+valor2+"[]']").each(function(indice, elemento) {
        if(!$.isNumeric($(elemento).val())){
            precio++;
            $(elemento).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese un valor numerico',
            })
            return false;
        }
    });
    //if(!es_correcto_fotos('Para la foto de portada','foto_portada_e_'+valor1+'_'+valor2,'1770','900')){
    //    return false;
    //}
    //if(!es_correcto_fotos('Para la foto de miniatura','foto_miniatura_'+valor1+'_'+valor2,'550','345')){
    //    return false;
    //}
    //if(!es_correcto_fotos_galeria('Para las fotos de la galeria','foto_'+valor1+'_'+valor2,'1280','665')){
    //    return false;
    //}
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: $("#form_"+valor1+'_'+valor2).attr('action'),
        method: $("#form_"+valor1+'_'+valor2).attr('method'),
        data:new FormData($("#form_"+valor1+'_'+valor2)[0]),
        dataType:'json',
        contentType:false,
        cache:false,
        processData: false,
        beforeSend: function() {
            $('#rpt_form_'+valor1+'_'+valor2).html('');
            $('#rpt_form_'+valor1+'_'+valor2).html('<i class="fas fa-stroopwafel fa-spin fa-3x"></i>');
        },
        success:function(data){
            $('#rpt_form_'+valor1+'_'+valor2).html(data.mensaje);
            $('#rpt_form_'+valor1+'_'+valor2).addClass(data.nombre_clase);
            // $("#form_"+valor1+'_'+valor2)[0].reset();
        }
        });
}
function borrar_servicio(id,atributo){

    Swal.fire({
        title: 'MENSAJE DEL SISTEMA',
        text: "¿Estas seguro de borrar el servicio?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar!',
        cancelButtonText:'No, cancelar'
      }).then((result) => {
        if (result.value) {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'get',
                url:'/admin/servicio/delete/'+id+'/'+atributo,
                // data:{id:id},
                success:function(data){
                    if(data==1){
                        Swal.fire(
                            'Borrado!',
                            'El servicio ha sido borrada.',
                            'success'
                        );
                        $('#servicio_'+id).fadeOut();
                    }
                    else if(data==0){
                        Swal.fire(
                            'Error!',
                            'Hubo un error al borrar el servicio.',
                            'danger'
                        )
                    }
                }
             });
        }
      })
}

function filtro_reserva(campo,columna){
    $('#codigo_'+columna).addClass('d-none');
    $('#nombre_'+columna).addClass('d-none');
    $('#fechas_'+columna).addClass('d-none');
    $('#mes_anio_'+columna).addClass('d-none');

    $('#'+campo+'_'+columna).removeClass('d-none');

}

function confirmar(tipo_servicio,grupo_id,estado){
    console.log('tipo_servicio:'+tipo_servicio+',grupo_id:'+grupo_id+',estado:'+estado);
    if(estado==0)
        estado=1;
    else if(estado==1)
        estado=0;

    console.log('tipo_servicio:'+tipo_servicio+',grupo_id:'+grupo_id+',estado:'+estado);
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'get',
        url:'/admin/reserva/grupo/confirmar/'+tipo_servicio+'/'+grupo_id+'/'+estado,
        // data:{id:id},
        success:function(data){
            console.log(data);
            if(data.rpt==1){
                $('#estado_'+tipo_servicio+'_'+grupo_id).val(data.estado);

                $('#estado_span_'+tipo_servicio+'_'+grupo_id).removeClass('badge-dark');
                $('#estado_span_'+tipo_servicio+'_'+grupo_id).removeClass('badge-success');
                $('#confirmar_'+tipo_servicio+'_'+grupo_id).removeClass('btn-primary');
                $('#confirmar_'+tipo_servicio+'_'+grupo_id).removeClass('btn-danger');

                $('#estado_span_'+tipo_servicio+'_'+grupo_id).addClass(data.clase_span);
                $('#estado_span_'+tipo_servicio+'_'+grupo_id).html(data.estado_span);
                $('#confirmar_'+tipo_servicio+'_'+grupo_id).addClass(data.clase_confirmar);
                $('#confirmar_'+tipo_servicio+'_'+grupo_id).html(data.estado_confirmar);
            }
            else if(data.rpt==0){
                Swal.fire(
                    'Upps!',
                    'Hubo un error, vuelva a intentarlo.',
                    'error'
                )
            }
        }
     });
}

function mostrar_provincias_servicios(departamento_id,categoria,categoria_id,producto_id){
    // alert('hola:'+departamento_id);
    console.log('departamento_id:'+departamento_id);
    if(departamento_id>0){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
        type:'POST',
        url:'../mostrar-provincias',
        data:{departamento_id:departamento_id},
        success:function(data){
            $("select[name='provincia'").html('');
            $("select[name='provincia'").html(data.options);

            // $('#provincia_'+categoria_id+'_'+producto_id).html('');
            // $('#provincia_'+categoria_id+'_'+producto_id).html(data.options);
        }
        });

    mostrar_proveedores(departamento_id,categoria,categoria_id,producto_id);
    }
}
function mostrar_distritos_servicios(provincia_id){
    // alert('hola:'+departamento_id);
    console.log('departamento_id:'+provincia_id);
    if(provincia_id>0){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
        type:'POST',
        url:'../mostrar-distritos',
        data:{provincia_id:provincia_id},
        success:function(data){
            $("select[name='distrito'").html('');
            $("select[name='distrito'").html(data.options);
        }
        });
    }
}
function mostrar_comunidades_servicios(distrito_id,asociacion_id){
    // alert('hola:'+departamento_id);
    console.log('distrito_id:'+distrito_id);
    if(distrito_id>0){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
        type:'POST',
        url:'../mostrar-comunidades',
        data:{distrito_id:distrito_id},
        success:function(data){

            $("#comunidad_"+asociacion_id).html('');
            $("#comunidad_"+asociacion_id).html(data.options);
        }
        });
    }
}

function mostrar_proveedores(departamento_id,categoria,categoria_id,producto_id){
    // alert('hola:'+departamento_id);
    console.log('departamento_id:'+departamento_id);
    if(departamento_id>0){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
        type:'POST',
        url:'../mostrar-proveedores',
        data:{departamento_id:departamento_id,categoria:categoria,categoria_id:categoria_id,producto_id:producto_id},
        beforeSend: function() {
            $("#lista_proveedores").html('');
            $("#lista_proveedores").html('<i class="fas fa-stroopwafel fa-spin fa-3x"></i>');
        },
        success:function(data){

            $("#lista_proveedores_"+categoria_id+"_"+producto_id).html('');
            $("#lista_proveedores_"+categoria_id+"_"+producto_id).html(data);
        }
        });

    }
}
var nro_proves=0;
function pasar_datos(clase,categoria_id,producto_id){
   var resultArray = [];
//    $("input[name='proveedor_id[]']").each(function () {
//     resultArray.push($(this).val());
//    });
var proveedor_id='c_proveedor_id_'+categoria_id+'_'+producto_id;
var proveedor='proveedor_'+categoria_id+'_'+producto_id;
   resultArray=$("input[class='"+proveedor_id+"']").map(function(){ return this.value }).get();
console.log('resultArray:'+resultArray);
   $("input[name='"+proveedor+"[]']").each(function (index) {
       console.log('entro el checbox');
        if($(this).is(':checked')){
            var valor=$(this).val();
            valor=valor.split('_');
            console.log('in array:'+jQuery.inArray( valor[0], resultArray ));
            if(resultArray==''){
                var cadena='<div id="lista_proveedores_saved_'+categoria_id+'_'+producto_id+'_'+valor[0]+'" class="row">'+
                '<div class="col-7 ">'+valor[1]+'</div>'+
                '<div class="col-3 px-0 mx-0"><input class="'+proveedor_id+'" type="hidden" name="proveedor_id_a[]" value="'+valor[0]+'"><input type="hidden" name="proveedor_id[]" value="'+valor[0]+'"><input class="form-control" type="number" name="precio_proveedor[]" min="0" step="0.01"></div>'+
                '<div class="col-2 px-0 mx-0"><button type="button" class="btn btn-danger" onclick="borrar_proveedor_save(\''+categoria_id+'\',\''+producto_id+'\',\''+valor[0]+'\')"><i class="fas fa-trash"></i></button></div>'+
            '</div>';
    $('#lista_proveedores_save_'+categoria_id+'_'+producto_id).append(cadena);
            }
            else{
                if (jQuery.inArray( valor[0], resultArray ) == -1 ) {
                    nro_proves++;
                    var cadena='<div id="lista_proveedores_saved_'+categoria_id+'_'+producto_id+'_'+valor[0]+'" class="row">'+
                                '<div class="col-7 ">'+valor[1]+'</div>'+
                                '<div class="col-3 px-0 mx-0"><input class="'+proveedor_id+'" type="hidden" name="proveedor_id_a[]" value="'+valor[0]+'"><input  type="hidden" name="proveedor_id[]" value="'+valor[0]+'"><input class="form-control" type="number" name="precio_proveedor[]" min="0" step="0.01"></div>'+
                                '<div class="col-2 px-0 mx-0"><button type="button" class="btn btn-danger" onclick="borrar_proveedor_save(\''+categoria_id+'\',\''+producto_id+'\',\''+valor[0]+'\')"><i class="fas fa-trash"></i></button></div>'+
                            '</div>';
                    $('#lista_proveedores_save_'+categoria_id+'_'+producto_id).append(cadena);
                }
            }
        }
    });

}
function borrar_proveedor_save(valor1,valor2,valor3){
    $('#lista_proveedores_saved_'+valor1+'_'+valor2+'_'+valor3).remove();
}

function eliminar_producto(id,categoria,categoria_id){

    Swal.fire({
        title: 'MENSAJE DEL SISTEMA',
        text: "¿Estas seguro de borrar el producto?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar!',
        cancelButtonText:'No, cancelar'
      }).then((result) => {
        if (result.value) {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'get',
                url:'/admin/producto/delete/'+id+'/'+categoria,
                // data:{id:id},
                success:function(data){
                    if(data==1){
                        Swal.fire(
                            'Borrado!',
                            'El producto ha sido borrada.',
                            'success'
                        );
                        $('#row_lista_productos_'+id+'_'+categoria_id).remove();
                    }
                    else if(data==0){
                        Swal.fire(
                            'Error!',
                            'Hubo un error al borrar el producto.',
                            'danger'
                        )
                    }
                    else if(data==2){
                        Swal.fire(
                            'Opps!',
                            'El producto esta presente an algunas reservas, no borre este producto.',
                            'warning'
                        )
                    }
                }
             });
        }
      })
}

function mostrar_provincias_productos(departamento_id,categoria,categoria_id,producto_id){
    // alert('hola:'+departamento_id);
    console.log('departamento_id:'+departamento_id);
    if(departamento_id>0){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
        type:'POST',
        url:'/admin/comunidad/mostrar-provincias',
        data:{departamento_id:departamento_id,categoria_id:categoria_id,producto_id:producto_id},
        success:function(data){
            // $("select[id='provincia'").html('');
            // $("select[id='provincia'").html(data.options);
            $('#provincia_'+categoria_id+'_'+producto_id).html('');
            $('#provincia_'+categoria_id+'_'+producto_id).html(data.options);

        }
        });

    mostrar_proveedores_productos(departamento_id,categoria,categoria_id,producto_id);
    }
}
function mostrar_distritos_productos(provincia_id,categoria_id,producto_id){
    // alert('hola:'+departamento_id);
    console.log('departamento_id:'+provincia_id);
    if(provincia_id>0){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
        type:'POST',
        url:'/admin/comunidad/mostrar-distritos',
        data:{provincia_id:provincia_id},
        success:function(data){
            // $("select[name='distrito'").html('');
            // $("select[name='distrito'").html(data.options);

            $('#distrito_'+categoria_id+'_'+producto_id).html('');
            $('#distrito_'+categoria_id+'_'+producto_id).html(data.options);
        }
        });
    }
}
function mostrar_comunidades_productos(distrito_id,asociacion_id,categoria_id,producto_id){
    // alert('hola:'+departamento_id);
    console.log('distrito_id:'+distrito_id);
    if(distrito_id>0){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
        type:'POST',
        url:'/admin/comunidad/mostrar-comunidades',
        data:{distrito_id:distrito_id},
        success:function(data){

            // $("#comunidad_"+asociacion_id).html('');
            // $("#comunidad_"+asociacion_id).html(data.options);

            $('#comunidad_'+categoria_id+'_'+producto_id).html('');
            $('#comunidad_'+categoria_id+'_'+producto_id).html(data.options);
        }
        });
    }
}
function mostrar_proveedores_productos(departamento_id,categoria,categoria_id,producto_id){
    // alert('hola:'+departamento_id);
    console.log('departamento_id:'+departamento_id);
    if(departamento_id>0){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
        type:'POST',
        url:'/admin/producto/mostrar-proveedores',
        data:{departamento_id:departamento_id,categoria:categoria,categoria_id:categoria_id,producto_id:producto_id},
        beforeSend: function() {
            $("#lista_proveedores_"+categoria_id+"_"+producto_id).html('');
            $("#lista_proveedores_"+categoria_id+"_"+producto_id).html('<i class="fas fa-stroopwafel fa-spin fa-3x"></i>');
        },
        success:function(data){
            $("#lista_proveedores_"+categoria_id+"_"+producto_id).html('');
            $("#lista_proveedores_"+categoria_id+"_"+producto_id).html(data);
        }
        });

    }
}


function borrar_proveedor_save_d(valor1,valor2,valor3){
    $('#lista_proveedores_saved_'+valor1+'_'+valor2+'_'+valor3).remove();
}
var proveedor_id_t_g=0;
function proveedor_escojido(valor1){
    proveedor_id_t_g=valor1;
}
function escojer_proveedor(valor1,rol){
    console.log('valor1:'+valor1+',valor2:'+proveedor_id_t_g);
    var proveedor_nombre_pago=$('#proveedor_nombre_'+valor1+'_'+proveedor_id_t_g).val();
    var proveedor_id_pago=$('#proveedor_'+valor1+'_'+proveedor_id_t_g).val();
    var precio_pago=$('#precio_pago_'+valor1+'_'+proveedor_id_t_g).val();
    var fecha_pago=$('#fecha_pago_'+valor1+'_'+proveedor_id_t_g).val();
    console.log('proveedor_nombre_pago:'+proveedor_nombre_pago+',proveedor_id_pago:'+proveedor_id_pago+',precio_pago:'+precio_pago+',fecha_pago:'+fecha_pago);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
    type:'POST',
    url:'/admin/reserva/escojer-proveedor',
    data:{transporte_externo_guia_id:valor1,proveedor_id_pago:proveedor_id_pago,precio_pago:precio_pago,fecha_pago:fecha_pago,rol:rol},
    beforeSend: function(data1) {
        console.log('data1:'+data1);
        $("#rpt_"+valor1).html('');
        $("#rpt_"+valor1).html('<i class="fas fa-stroopwafel fa-spin fa-3x"></i>');
        $('#rpt_proveedor_'+rol+'_'+valor1).html('');
        $('#rpt_precio_pago_'+rol+'_'+valor1).html('');
        $('#rpt_fecha_pago_'+rol+'_'+valor1).html('');
    },
    success:function(data){
        console.log(data.rpt);
        if(data.rpt=='1'){
            $('#rpt_proveedor_'+rol+'_'+valor1).html(proveedor_nombre_pago);
            $('#rpt_precio_pago_'+rol+'_'+valor1).html(precio_pago);
            $('#rpt_fecha_pago_'+rol+'_'+valor1).html(fecha_pago);
            $('#rpt_'+valor1).html('');
            $('#rpt_'+valor1).html('<span class="text-success">Proveedor escojido correctamente!</span>');
        }
        else if(data.rpt=='0'){
            $('#rpt_'+valor1).html('');
            $('#rpt_'+valor1).html('<span class="text-danger">Upps! Vuelva a intentarlo.</span>');
        }
    }
    });
}
function confirmar_t_g(tipo_servicio,grupo_id,estado){
    console.log('tipo_servicio:'+tipo_servicio+',grupo_id:'+grupo_id+',estado:'+estado);
    if(estado==0)
        estado=1;
    else if(estado==1)
        estado=0;

    console.log('tipo_servicio:'+tipo_servicio+',grupo_id:'+grupo_id+',estado:'+estado);
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'get',
        url:'/admin/reserva/grupo/confirmar/'+tipo_servicio+'/'+grupo_id+'/'+estado,
        // data:{id:id},
        success:function(data){
            console.log(data);
            if(data.rpt==1){
                $('#estado_'+tipo_servicio+'_'+grupo_id).val(data.estado);

                $('#estado_span_'+tipo_servicio+'_'+grupo_id).removeClass('badge-dark');
                $('#estado_span_'+tipo_servicio+'_'+grupo_id).removeClass('badge-success');
                $('#estado_span_'+tipo_servicio+'_'+grupo_id).removeClass('badge-primary');
                $('#estado_span_'+tipo_servicio+'_'+grupo_id).removeClass('badge-danger');

                $('#estado_span_'+tipo_servicio+'_'+grupo_id).addClass(data.clase_span);
                $('#estado_span_'+tipo_servicio+'_'+grupo_id).html(data.estado_span);
                $('#confirmar_'+tipo_servicio+'_'+grupo_id).addClass(data.clase_confirmar);
                $('#confirmar_'+tipo_servicio+'_'+grupo_id).html(data.estado_confirmar);
            }
            else if(data.rpt==0){
                Swal.fire(
                    'Upps!',
                    'Hubo un error, vuelva a intentarlo.',
                    'error'
                )
            }
        }
     });
}
function buscar_reserva(valorcito){
console.log(valorcito);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url:'../admin/reserva/get-reserva',
        data:{valor:valorcito},
        beforeSend: function() {
            $("#rpt").html('');
            $('#rpt').html('<i class="fas fa-stroopwafel fa-spin fa-3x"></i>');
        },
        success:function(data){
            $("#rpt").html('');
            $("#rpt").html(data);
        }
    });
}

function guardar_calendario(valor1){
$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    url: $("#form_a_calendario_"+valor1).attr('action'),
    method: $("#form_a_calendario_"+valor1).attr('method'),
    data:$("#form_a_calendario_"+valor1).serialize(),
    beforeSend: function(data1) {
        // console.log('data1:'+data1);
        $("#rpt_calendario_"+valor1).html('');
        $("#rpt_calendario_"+valor1).html('<i class="fas fa-stroopwafel fa-spin fa-3x"></i>');
    },
    success:function(data){
        console.log(data);
        if(data.length==1){
            $('#rpt_form_a_e_'+valor1).removeClass('text-success');
            $('#rpt_form_a_e_'+valor1).addClass('text-danger');
            $('#rpt_form_a_e_'+valor1).html('');
            $('#rpt_form_a_e_'+valor1).html('');
            $('#rpt_form_a_e_'+valor1).html('Vuelva a intentarlo');
        }
        else{
            $('#rpt_form_a_e_'+valor1).removeClass('text-danger');
            $('#rpt_form_a_e_'+valor1).addClass('text-success');
            $('#rpt_form_a_e_'+valor1).html('');
            $('#rpt_form_a_e_'+valor1).html('Fecha guardada correctamente');
            $('#rpt_form_a_e_tabla_'+valor1).html('');
            $('#rpt_form_a_e_tabla_'+valor1).html(data);

            $("#form_a_calendario_"+valor1)[0].reset();
            $("#rpt_calendario_"+valor1).html(data);
        }
    }
    });
}
function guardar_calendario_2(valor1){
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: $("#form_a_d_calendario_"+valor1).attr('action'),
        method: $("#form_a_d_calendario_"+valor1).attr('method'),
        data:$("#form_a_d_calendario_"+valor1).serialize(),
        beforeSend: function(data1) {
            // console.log('data1:'+data1);
            $("#rpt_calendario_"+valor1).html('');
            $("#rpt_calendario_"+valor1).html('<i class="fas fa-stroopwafel fa-spin fa-3x"></i>');
        },
        success:function(data){
            console.log(data);
            if(data.length==1){
                $('#rpt_form_a_e_'+valor1).removeClass('text-success');
                $('#rpt_form_a_e_'+valor1).addClass('text-danger');
                $('#rpt_form_a_e_'+valor1).html('');
                $('#rpt_form_a_e_'+valor1).html('');
                $('#rpt_form_a_e_'+valor1).html('Vuelva a intentarlo');
            }
            else{
                $('#rpt_form_a_e_'+valor1).removeClass('text-danger');
                $('#rpt_form_a_e_'+valor1).addClass('text-success');
                $('#rpt_form_a_e_'+valor1).html('');
                $('#rpt_form_a_e_'+valor1).html('Fecha guardada correctamente');
                $('#rpt_form_a_e_tabla_'+valor1).html('');
                $('#rpt_form_a_e_tabla_'+valor1).html(data);

                $("#form_a_d_calendario_"+valor1)[0].reset();
                $("#rpt_calendario_"+valor1).html(data);
            }
        }
        });
    }
function borrar_fecha_dispo(actividad_id){
var fecha=$('#fecha_texto_'+actividad_id).html();
$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    type:'POST',
    url:'/admin/servicios/calendario/eliminar',
    data:{actividad_id:actividad_id,fecha:fecha},
    success:function(data){
        if(data.length>1){
            $("#rpt_calendario_"+actividad_id).html(data);
        }
    }
});

}


function agregar_hora(valor1){

    var valor=$('#cantidad_horas_'+valor1).val();
    valor++
    $('#cantidad_horas_'+valor1).val(valor);
    var cadena='<div id="hora_'+valor1+'_'+valor+'" class="input-group mb-1">'+
    '<div class="input-group-prepend">'+
        '<button type="button" class="btn btn-secondary">Hora</button>'+
    '</div>'+
    '<select class="form-control" name="hora[]">'+
        '<option value="07:00:00">07:00:00</option>'+
        '<option value="07:30:00">07:30:00</option>'+
        '<option value="08:00:00">08:00:00</option>'+
        '<option value="08:30:00">08:30:00</option>'+
        '<option value="09:00:00">09:00:00</option>'+
        '<option value="09:30:00">09:30:00</option>'+
        '<option value="10:00:00">10:00:00</option>'+
        '<option value="10:30:00">10:30:00</option>'+
        '<option value="11:00:00">11:00:00</option>'+
        '<option value="11:30:00">11:30:00</option>'+
        '<option value="12:00:00">12:00:00</option>'+
        '<option value="12:30:00">12:30:00</option>'+
        '<option value="13:00:00">13:00:00</option>'+
        '<option value="13:30:00">13:30:00</option>'+
        '<option value="14:00:00">14:00:00</option>'+
        '<option value="14:30:00">14:30:00</option>'+
        '<option value="15:00:00">15:00:00</option>'+
        '<option value="15:30:00">15:30:00</option>'+
        '<option value="16:00:00">16:00:00</option>'+
        '<option value="16:30:00">16:30:00</option>'+
        '<option value="17:00:00">17:00:00</option>'+
        '</select>'+
    '<div class="input-group-prepend">'+
        '<button type="button" class="btn btn-danger" onclick="borrar_hora(\''+valor1+'\',\''+valor+'\')"><i class="fas fa-trash-alt"></i> </button>'+
        '</div>'+
'</div>';
    $('#caja_hora_'+valor1).append(cadena);
}

function borrar_hora(valor1,item){
    $('#hora_'+valor1+'_'+item).remove();

}
function eliminar_administrador(id){

    Swal.fire({
        title: 'MENSAJE DEL SISTEMA',
        text: "¿Estas seguro de borrar el administrador?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar!',
        cancelButtonText:'No, cancelar'
      }).then((result) => {
        if (result.value) {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'get',
                url:'/admin/administrador/delete/'+id,
                // data:{id:id},
                success:function(data){
                    if(data==1){
                        Swal.fire(
                            'Borrado!',
                            'El administrador ha sido borrado.',
                            'success'
                        );
                        $('#row_lista_comunidades_'+id).remove();
                    }
                    else if(data==0){
                        Swal.fire(
                            'Error!',
                            'Hubo un error al borrar al administrador.',
                            'danger'
                        )
                    }
                }
             });
        }
      })

}

function confirmar_(tipo_servicio,grupo_id,estado,nuevo_estado){
    console.log('tipo_servicio:'+tipo_servicio+',grupo_id:'+grupo_id+',estado:'+estado);
    // if(estado==0)
    //     estado=1;
    // else if(estado==1)
    //     estado=0;

    console.log('tipo_servicio:'+tipo_servicio+',grupo_id:'+grupo_id+',estado:'+estado);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'get',
        url:'/admin/reserva/grupo/confirmar_reserva/'+tipo_servicio+'/'+grupo_id+'/'+estado+'/'+nuevo_estado,
        // data:{id:id},
        success:function(data){
            console.log(data);
            if(data.rpt==1){
                $('#estado_'+tipo_servicio+'_'+grupo_id).val(data.estado);
                $('#estado_span_'+tipo_servicio+'_'+grupo_id).removeClass('badge-dark');
                $('#estado_span_'+tipo_servicio+'_'+grupo_id).removeClass('badge-success');
                $('#estado_span_'+tipo_servicio+'_'+grupo_id).removeClass('badge-danger');
                // $('#confirmar_'+tipo_servicio+'_'+grupo_id).removeClass('btn-primary');
                // $('#confirmar_'+tipo_servicio+'_'+grupo_id).removeClass('btn-danger');

                $('#estado_span_'+tipo_servicio+'_'+grupo_id).addClass(data.clase_span);
                $('#estado_span_'+tipo_servicio+'_'+grupo_id).html(data.estado_span);
                // $('#confirmar_'+tipo_servicio+'_'+grupo_id).addClass(data.clase_confirmar);
                // $('#confirmar_'+tipo_servicio+'_'+grupo_id).html(data.estado_confirmar);
            }
            else if(data.rpt==0){
                Swal.fire(
                    'Upps!',
                    'Hubo un error, vuelva a intentarlo.',
                    'error'
                )
            }
        }
    });
}

function mostrar_pagina(grupo_id,estado){
    // console.log('tipo_servicio:'+tipo_servicio+',grupo_id:'+grupo_id+',estado:'+estado);
    if(estado==0)
        estado=1;
    else if(estado==1)
        estado=0;

    // console.log('tipo_servicio:'+tipo_servicio+',grupo_id:'+grupo_id+',estado:'+estado);
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'get',
        url:'/admin/producto/mostrar-pagina/'+grupo_id+'/'+estado,
        // data:{id:id},
        success:function(data){
            console.log(data);
            if(data.rpt==1){
                $('#mostrar_en_pagina_'+grupo_id).val(data.estado);

                // $('#estado_span_'+tipo_servicio+'_'+grupo_id).removeClass('badge-dark');
                // $('#estado_span_'+tipo_servicio+'_'+grupo_id).removeClass('badge-success');
                // $('#estado_span_'+tipo_servicio+'_'+grupo_id).removeClass('badge-primary');
                // $('#estado_span_'+tipo_servicio+'_'+grupo_id).removeClass('badge-danger');

                // $('#estado_span_'+tipo_servicio+'_'+grupo_id).addClass(data.clase_span);
                // $('#estado_span_'+tipo_servicio+'_'+grupo_id).html(data.estado_span);
                $('#confirmar_'+grupo_id).removeClass('btn-danger');
                $('#confirmar_'+grupo_id).removeClass('btn-success');
                $('#confirmar_'+grupo_id).addClass(data.clase_confirmar);
                $('#confirmar_'+grupo_id).html(data.estado_confirmar);
            }
            else if(data.rpt==0){
                Swal.fire(
                    'Upps!',
                    'Hubo un error, vuelva a intentarlo.',
                    'error'
                )
            }
        }
     });
}
function es_correcto_fotos(mensa,archivo,ancho,alto){
    console.log("archivo."+archivo+",ancho:"+ancho+",alto:"+alto);
    var o = document.getElementById(archivo);
    var foto = o.files[0];
    var c =0;


    if(o.files.length!=0){
      if (!(/\.(jpeg|jpg|png)$/i).test(foto.name)) {

          c=1;
          Swal.fire(
            'MENSAJE DEL SISTEMA',
            ''+mensa+' ingrese una imagen con alguno de los siguientes formatos: .jpeg/.jpg/.png.',
            'error'
            );
            return false;
        //   alert('Ingrese una imagen con alguno de los siguientes formatos: .jpeg/.jpg/.png.');


      }
      else {
          var img = new Image();
          img.onload = function dimension() {
              if (this.width.toFixed(0) != ancho && this.height.toFixed(0) != alto) {
                c=1;
                Swal.fire(
                    'MENSAJE DEL SISTEMA',
                    ''+mensa+' las medidas deben ser: ('+ancho+'x'+alto+' px). Medida de la foto que desea subir es: ('+this.width.toFixed(0)+'x'+this.height.toFixed(0)+' px)',
                    'error'
                    );
                    return false;
                // alert('Las medidas deben ser: 900 x 400');
                // alert(c);
              }
            else {
                // Swal.fire(
                //     'MENSAJE DEL SISTEMA',
                //     'Imagen correcta :)',
                //     'success'
                //     );
                // return false;
                    // alert('Imagen correcta :)');
              }
          };

           img.src = URL.createObjectURL(foto);

      }
    }
    else{
        return true;
    }
    //   if(c === 1){
    //     return false;
    //   }
    //   else{

    //     return true;

    //   }
  }
function es_correcto_fotos_galeria(mensa,archivo,ancho,alto){
    console.log("archivo."+archivo+",ancho:"+ancho+",alto:"+alto);
    var o = document.getElementById(archivo);
    var foto = o.files;
    var c =0;
console.log(foto.length);
    var total_galeria=foto.length;
    var fotos_erradas=0;
    //manejaremos tipo de errors 1=formato, 2=medida
    var tipo_error=0;
    if(foto.length!=0){
        var imagen_con_error='';
        for(var i=0;i<foto.length;i++){
            console.log('nombre:'+foto[i].name);
            if (!(/\.(jpeg|jpg|png)$/i).test(foto[i].name)) {
                tipo_error=1;
                fotos_erradas++;
                imagen_con_error+=foto[i].name+', ';

            }
        }
        if(fotos_erradas>0){
            if(tipo_error==1){
                Swal.fire(
                  'MENSAJE DEL SISTEMA',
                  ''+mensa+' ingrese las imagenes con alguno de los siguientes formatos: .jpeg/.jpg/.png.'+'.Se subio ('+imagen_con_error+').',
                  'error'
                  );
                  return false;
            }
        }

        imagen_con_error='';
        fotos_erradas=0;
        var _URL = window.URL || window.webkitURL;
        var DOMURL = window.URL || window.webkitURL || window;
        var procesaImg = function(data) {
            var img = new Image();
            var svg = new Blob([data], {type: 'image/svg+xml'});
            var url = DOMURL.createObjectURL(svg);
            img.onload = function() {
            ctx.drawImage(img, Window.posx,Window.posy);
            DOMURL.revokeObjectURL(url);
            imagen_con_error+='('+this.width.toFixed(0)+'x'+this.height.toFixed(0)+'), ';
            }
            img.src=url;
        };
        for(var i=0;i<foto.length;i++){
            procesaImg(foto[i]);
            console.log('nombre x:'+foto[i]);
            // var img = new Image();
            // // img.src = foto[i];
            // img.onload = function() {
            // // imgwidth = this.width;
            // // imgheight = this.height;


            // };

        //    img.src = URL.createObjectURL(foto[i]);
                // var img = (Image)foto[i];
                // var img = new Image();
                // img.onload = function dimension() {
                //     if (this.width.toFixed(0) != ancho && this.height.toFixed(0) != alto) {
                //       tipo_error=2;
                //       fotos_erradas++;
                //       c=1;
                //       imagen_con_error+=this.name+'('+this.width.toFixed(0)+'x'+this.height.toFixed(0)+'), ';

                //     }

                // };

                // img.src = URL.createObjectURL(foto[i]);
        }
        console.log('error:'+imagen_con_error);
        // if(fotos_erradas>0){
        //     if(tipo_error==2){
        //         Swal.fire(
        //             'MENSAJE DEL SISTEMA',
        //             ''+mensa+' las medidas deben ser: ('+ancho+'x'+alto+' px). Medida de las fotos que desea subir es: '+imagen_con_error,
        //             'error'
        //             );
        //             return false;
        //     }
        // }
    }
    else{
        return true;
    }
    //   if(c === 1){
    //     return false;
    //   }
    //   else{

    //     return true;

    //   }
  }

  function eliminar_categoria(id){

    Swal.fire({
        title: 'MENSAJE DEL SISTEMA',
        text: "¿Estas seguro de borrar la categoria?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar!',
        cancelButtonText:'No, cancelar'
      }).then((result) => {
        if (result.value) {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'get',
                url:'/admin/categoria/delete/'+id,
                // data:{id:id},
                success:function(data){
                    if(data==1){
                        Swal.fire(
                            'Borrado!',
                            'La categoria ha sido borrada.',
                            'success'
                        );
                        $('#row_lista_comunidades_'+id).remove();
                    }
                    else if(data==2){
                        Swal.fire(
                            'Avertencia!',
                            'La categoria tiene actividaes relacionadas, modifique o borre las actividaes que tengan esta categoria.',
                            'danger'
                        )
                    }
                    else if(data==0){
                        Swal.fire(
                            'Error!',
                            'Hubo un error al borrar la categoria.',
                            'danger'
                        )
                    }
                }
             });
        }
      })
}
function eliminar_marca(id){

    Swal.fire({
        title: 'MENSAJE DEL SISTEMA',
        text: "¿Estas seguro de borrar la marca?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar!',
        cancelButtonText:'No, cancelar'
      }).then((result) => {
        if (result.value) {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'get',
                url:'/admin/marca/delete/'+id,
                // data:{id:id},
                success:function(data){
                    console.log('data:'+data);
                    if(data==1){
                        Swal.fire(
                            'Borrado!',
                            'La marca ha sido borrada.',
                            'success'
                        );
                        $('#row_lista_marcas_'+id).remove();
                    }
                    else if(data==2){
                        Swal.fire(
                            'Avertencia!',
                            'La marca tiene productos relacionados, modifique o borre los productos que tengan esta marca.',
                            'danger'
                        )
                    }
                    else if(data==0){
                        Swal.fire(
                            'Error!',
                            'Hubo un error al borrar la marca.',
                            'danger'
                        )
                    }
                }
             });
        }
      })
}
function buscar_reserva_encuesta(valorcito){
console.log(valorcito);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url:'../admin/encuesta/get-reserva',
        data:{valor:valorcito},
        beforeSend: function() {
            $("#rpt").html('');
            $('#rpt').html('<i class="fas fa-stroopwafel fa-spin fa-3x"></i>');
        },
        success:function(data){
            $("#rpt").html('');
            $("#rpt").html(data);
        }
    });
}
function eliminar_proveedor(id,tipo){

    var texto='';
    if(tipo=='GUIA'){
        texto='al GUIA';
    }
    else if(tipo=='TRANSPORTE'){
        texto='al TRANSPORTISTA';
    }
    Swal.fire({
        title: 'MENSAJE DEL SISTEMA',
        text: "¿Estas seguro de borrar "+texto+"?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar!',
        cancelButtonText:'No, cancelar'
      }).then((result) => {
        if (result.value) {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'get',
                url:'/admin/proveedor/delete/'+id+'/'+tipo,
                // data:{id:id},
                success:function(data){
                    if(data==1){
                        Swal.fire(
                            'Borrado!',
                            'El proveedor ha sido borrado.',
                            'success'
                        );
                        $('#row_lista_asociaciones_'+id).remove();
                    }
                    else if(data==0){
                        Swal.fire(
                            'Error!',
                            'Hubo un error al borrar al proveedor.',
                            'danger'
                        )
                    }
                    else if(data==2){
                        Swal.fire(
                            'Opps!',
                            'El proveedor tiene productos, por favor borre sus productos e intentelo una vez más.',
                            'warning'
                        )
                    }
                }
             });
        }
      })
}
function search_orden(valorcito){
    console.log(valorcito);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'POST',
            url:'../../order/get-order',
            data:{valor:valorcito},
            beforeSend: function() {
                $("#rpt").html('');
                $('#rpt').html('<i class="fas fa-stroopwafel fa-spin fa-3x"></i>');
            },
            success:function(data){
                $("#rpt").html('');
                $("#rpt").html(data);
            }
        });
    }
