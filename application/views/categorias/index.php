<script>
    <?php echo $grilla; ?>
</script>
  <div class="container single_product_container">
    <div class="row head">
      <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <h5>CATEGORÍAS DE PRODUCTO</h5>
      </div>
      <div class="btn-group col-lg-4 col-md-4 col-sm-12 col-xs-12" role="group">
        <button type="button" name="button" id="btn_delete" class="btn btn-sm btn-danger btn-margin">ELIMINAR</button>
        <button type="button" name="button" id="btn_share" class="btn btn-sm btn-info btn-margin">COMPARTIR</button>
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
                    <table id="tablaCategorias" class="table table-striped">

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<div class="modal fade" id="categoriaModal" role="dialog">
<form id="formularioDatos" method="POST">
    <div class="modal-dialog modal-large">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Datos de categoría</h5>
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
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            <div class="nk-int-st">
                                              <input type="hidden" id="id" name="id">
                                              <input type="text" id="descripcion" name="descripcion" class="form-control input-sm" placeholder="Nombre de la categoría">                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <div class="nk-int-st">
                                                <input type="number" id="orden" name="orden" class="form-control input-sm" placeholder="Orden">
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
