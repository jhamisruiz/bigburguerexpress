<script>
    <?php echo $grilla; ?>
</script>
  <div class="container single_product_container">
    <div class="row head">
      <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <h5>LISTA DE USUARIOS</h5>
      </div>
      <div class="btn-group col-lg-4 col-md-4 col-sm-12 col-xs-12" role="group">
        <button type="button" name="button" id="btn_delete" class="btn btn-sm btn-danger btn-margin">ELIMINAR</button>
        <button type="button" name="button" id="btn_edit" class="btn btn-sm btn-warning btn-margin">EDITAR</button>
        <button type="button" name="button" id="btn_add" class="btn btn-sm btn-success btn-margin">AGREGAR</button>
      </div>
    </div>
  </div>

<br><br>

<div class="data-table-area">
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <table id="tablaUsuarios" class="table table-striped">

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<div class="modal fade" id="usuarioModal" role="dialog">
<form id="formularioDatos" method="POST">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Datos de usuario</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <hr>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-example-wrap mg-t-30">
                          <div class="form-example-int form-horizental">
                              <div class="form-group">
                                  <div class="row">
                                      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                          <div class="nk-int-st">
                                              <input type="hidden" id="id" name="id">
                                              <input type="text" id="nombre" name="nombre" class="form-control input-sm" placeholder="Nombre Completo">
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <br>
                            <div class="form-example-int form-horizental">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                            <div class="nk-int-st">
                                                <input type="text" id="usuario" name="usuario" class="form-control input-sm" placeholder="Usuario">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <div class="nk-int-st">
                                                <input type="number" id="telefono" name="telefono" class="form-control input-sm" placeholder="Teléfono">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-example-int form-horizental">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="nk-int-st">
                                                <input type="text" id="email" name="email" class="form-control input-sm" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="nk-int-st">
                                                <input type="password" id="password" name="password" class="form-control input-sm" placeholder="Contraseña">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                <button type="submit" class="btn btn-success">GUARDAR</button>
            </div>
        </div>
    </div>
</form>
</div>
