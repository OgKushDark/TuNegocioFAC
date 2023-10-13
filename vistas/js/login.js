$("#frmAcceso").on('submit',function(e)
{
    e.preventDefault();
    logina=$("#logina").val();
    clavea=$("#clavea").val();

    $.post("controladores/usuario.php?op=verificar",
        {"logina":logina,"clavea":clavea},
        function(data)
    {
        if (data!="null")
        {         
            $(location).attr("href","vistas/inicio.php");
        }
        else
        {
            swal({
                  title: '¡Error!',
                  type: 'error',
                    text: 'Usuario y/o Password incorrectos.'
            });
        }
    });
})