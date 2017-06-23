<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php importView('_static.header'); ?>
            <?php importView('_static.sidebar'); ?>
            <div class="content-wrapper">
                <section class="content-header">
                  <h1>Mensajes<small>13 mensajes sin leer</small></h1>
                </section>
                <section class="content">
                    <div class="row">
                <div class="col-md-3">
                  <a href="compose.html" class="btn btn-primary btn-block margin-bottom btn-flat">Nuevo Mensaje</a>
                  <div class="box box-solid">
                    <div class="box-header with-border">
                      <h3 class="box-title">Carpetas</h3>

                      <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="box-body no-padding">
                      <ul class="nav nav-pills nav-stacked">
                        <li class="active"><a href="?c=mensajes"><i class="fa fa-inbox"></i> Bandeja de entrada
                          <?php
                            if($count_unread_menssages > 0){
                              echo '<span class="label label-primary pull-right">'.$count_unread_menssages.'</span></a></li>';
                            }


                          ?>
                        <li><a href="#"><i class="fa fa-envelope-o"></i> Enviados</a></li>
                        <li><a href="#"><i class="fa fa-file-text-o"></i> Borradores</a></li>
                        <li><a href="#"><i class="fa fa-trash-o"></i> Eliminados</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Bandeja de entrada</h3>
                      <div class="box-tools pull-right">
                        <div class="has-feedback">
                          <input type="text" class="form-control input-sm" placeholder="Search Mail">
                          <span class="glyphicon glyphicon-search form-control-feedback"></span>
                        </div>
                      </div>
                    </div>
                    <div class="box-body no-padding">
                      <div class="mailbox-controls">
                        <button type="button" class="btn btn-default btn-sm btn-flat checkbox-toggle"><i class="fa fa-square-o"></i>
                        </button>
                        <div class="btn-group">
                          <button type="button" class="btn btn-default btn-sm btn-flat" id="btnTrash"><i class="fa fa-trash-o"></i></button>
                          <button type="button" class="btn btn-default btn-sm btn-flat"><i class="fa fa-reply"></i></button>
                          <button type="button" class="btn btn-default btn-sm btn-flat"><i class="fa fa-share"></i></button>
                        </div>
                        <div class="pull-right">
                          1-50/200
                          <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm btn-flat"><i class="fa fa-chevron-left"></i></button>
                            <button type="button" class="btn btn-default btn-sm btn-flat"><i class="fa fa-chevron-right"></i></button>
                          </div>
                        </div>
                      </div>
                      <div class="table-responsive mailbox-messages">
                        <table class="table table-hover" id="inbox">
                          <tbody>
                          <?php
                          if(count($data['mensaje'])==0){
                            echo '<tr><td>No hay mensajes</td></tr>';
                          } else{


                          foreach ($data['mensaje'] as $mensaje) {
                            $leido = ($mensaje['leido']==0) ? 'class="active"' : '';
                            $txtMensaje = ($mensaje['leido']==0) ? '<b>'.$mensaje['asunto'].'</b> - '.substr($mensaje['mensaje'], 0,150) : $mensaje['asunto'].' - '.substr($mensaje['mensaje'], 0,150).'';
                            $favorito = ($mensaje['favorito']==0) ? 'fa-star-o' : 'fa-star';

                          echo '<tr id="'.$mensaje['id'].'" '.$leido.'>
                            <td><input type="checkbox"></td>
                            <td class="mailbox-star"><a href="#"><i class="fa '.$favorito.' text-yellow"></i></a></td>
                            <td class="mailbox-name"><a href="read-mail.html">'.$mensaje['usuario_envio'].'</a></td>
                            <td class="mailbox-subject">'.$txtMensaje.'</td>
                            <td class="mailbox-attachment"></td>
                            <td class="mailbox-date">'.$mensaje['fecha'].'</td>
                          </tr>';
                          }
                        }

                          ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="box-footer no-padding">
                      <div class="mailbox-controls">
                        <button type="button" class="btn btn-default btn-sm btn-flat checkbox-toggle"><i class="fa fa-square-o"></i>
                        </button>
                        <div class="btn-group">
                          <button type="button" class="btn btn-default btn-sm btn-flat"><i class="fa fa-trash-o"></i></button>
                          <button type="button" class="btn btn-default btn-sm btn-flat"><i class="fa fa-reply"></i></button>
                          <button type="button" class="btn btn-default btn-sm btn-flat"><i class="fa fa-share"></i></button>
                        </div>
                        <div class="pull-right">
                          1-50/<?php echo $count_mensajes; ?>
                          <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm btn-flat"><i class="fa fa-chevron-left"></i></button>
                            <button type="button" class="btn btn-default btn-sm btn-flat" id="next"><i class="fa fa-chevron-right"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                </section>
            </div>
            <?php importView('_static.footer'); ?>
        </div>
        <?php importView('_static.scripts'); ?>
        <script src="assets/js/mail.js"></script>
        <script>

  $(function () {
    //Enable iCheck plugin for checkboxes
    //iCheck for checkbox and radio inputs
    $('.mailbox-messages input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });

    //Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
      var clicks = $(this).data('clicks');
      if (clicks) {
        //Uncheck all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
        $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
      } else {
        //Check all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("check");
        $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
      }
      $(this).data("clicks", !clicks);
    });
    $('#btnTrash').click(function(event) {
      var elements = $(".mailbox-messages").find("[aria-checked='true']");
      elements.each(function(index, el) {
        row = el.parentNode.parentNode;
        id =  row.id
        row.remove();
        console.log(id);
        // Peticion ajax
        $.ajax({
            url: "?c=mensajes&a=delete",
            dataType: "json",
            method: "GET",
            data: "id=" +  id
        }).done(function(data) {

        }).fail(function(data) {

        }).always(function(data) {
        });
      });
      refreshIndbox();
    });
    $('#next').click(function(event) {
      refreshIndbox();
    });
    //Handle starring for glyphicon and font awesome
    $(".mailbox-star").click(function (e) {
      e.preventDefault();
      //detect type
      var $this = $(this).find("a > i");
      var glyph = $this.hasClass("glyphicon");
      var fa = $this.hasClass("fa");

      // Peticion ajax
      $.ajax({
          url: "?c=mensajes&a=toogle_fav",
          dataType: "json",
          method: "GET",
          data: "id=" +  $(this)[0].parentNode.id
      }).done(function(data) {
          //Switch states
          if (glyph) {
            $this.toggleClass("glyphicon-star");
            $this.toggleClass("glyphicon-star-empty");
          }

          if (fa) {
            $this.toggleClass("fa-star");
            $this.toggleClass("fa-star-o");
          }
      }).fail(function(data) {

      }).always(function(data) {
        
      });
    });
  });
  function refreshIndbox(){
      // Peticion ajax
      $.ajax({
          url: "?c=mensajes&a=getPage",
          dataType: "json",
          method: "GET",
          data: "page=2"
      }).done(function(data) {
        $('#inbox').empty();
        for (var i=0; i < data.length; i++) {
           //var leido = (el.leido==1) ? 'class="active"': '';
          //$('#inbox').append('<tr id="'+el.id+'" '+el.leido+'><td><input type="checkbox"></td>');
        }

      }).fail(function(data) {

      }).always(function(data) {
        console.log(data);
      });
  }
        </script>
    </body>
</html>