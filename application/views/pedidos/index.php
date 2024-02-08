<script>
    <?php echo $grilla; ?>
</script>
  <div class="container single_product_container">
    <div class="row head">
      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <h5>LISTA DE PEDIDOS</h5>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <div class="input-group">
          <input type="text" class="form-control form-control-sm" aria-describedby="button-addon2" name="filtroFecha" id="filtroFecha">
          <div class="input-group-append">
            <button class="btn btn-success btn-sm" type="button" id="button-addon2">Filtrar</button>
          </div>
        </div>
      </div>
      <div class="btn-group col-lg-4 col-md-4 col-sm-11 col-xs-11 offset-1" role="group">
        <button type="button" name="button" id="btn_imprimir" class="btn btn-sm btn-warning">IMPRIMIR</button>
        <button type="button" name="button" id="btn_estado" class="btn btn-sm btn-default">ASIGNAR</button>
        <button type="button" name="button" id="btn_edit" class="btn btn-sm btn-primary">EDITAR</button>
        <button type="button" name="button" id="btn_view" class="btn btn-sm btn-info">VER</button>
        <a type="button" href="<?php echo base_url(); ?>pedidos/add" id="btn_add" class="btn btn-sm btn-success">AGREGAR</a>
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
                    <table id="tablaPedidos" class="table table-striped">

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<div class="modal fade" id="verModal" role="dialog">
    <div class="modal-dialog modal-large">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Información del Pedido</h5>
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
                                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                            <div class="nk-int-st">
                                              <label class="view_label" for="">Cliente</label>
                                              <p id="cliente" class="view_p"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="nk-int-st">
                                              <label class="view_label" for="">Teléfono:</label>
                                              <p id="telefono" class="view_p"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="nk-int-st">
                                              <label class="view_label" for="">Fecha Pedido:</label>
                                              <p id="fecha_pedido" class="view_p"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="nk-int-st">
                                              <label class="view_label" for="">Fecha Entrega:</label>
                                              <p id="fecha_entrega" class="view_p"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="nk-int-st">
                                              <label class="view_label" for="">Dirección</label>
                                              <p id="direccion" class="view_p"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="nk-int-st">
                                              <label class="view_label" for="">Refrencia</label>
                                              <p id="referencia" class="view_p"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <div class="nk-int-st">
                                              <label class="view_label" for="">Importe</label>
                                              <p id="importe" class="view_p"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <div class="nk-int-st">
                                              <label class="view_label" for="">Efectivo</label>
                                              <p id="efectivo" class="view_p"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <div class="nk-int-st">
                                              <label class="view_label" for="">Vuelto</label>
                                              <p id="vuelto" class="view_p"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <div class="nk-int-st">
                                              <label class="view_label" for="">Estado</label>
                                              <p id="estado" class="view_p"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="nk-int-st">
                                                <table class="table table-striped">
                                                  <thead>
                                                    <tr>
                                                      <th>Cantidad</th>
                                                      <th>Producto</th>
                                                      <th>P. Unitario</th>
                                                      <th>Subtotal</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody id="cuerpo">

                                                  </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="estadoModal" role="dialog">
<form id="formularioEstado" method="POST">
    <div class="modal-dialog modal-large">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modificar Pedido</h5>
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
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="nk-int-st">
                                              <input type="hidden" id="cod" name="cod">
                                              <label for="motorizado">Seleccionar Estado: </label>
                                              <select class="form-control input-sm" name="condicion" id="condicion">
                                                <option value="1">En proceso</option>
                                                <option value="2">Entregado</option>
                                                <option value="0">Cancelado</option>
                                              </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="nk-int-st">
                                          <label for="motorizado">Motorizado</label>
                                          <select class="form-control input-sm" name="motorizado" id="motorizado">

                                          </select>
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
