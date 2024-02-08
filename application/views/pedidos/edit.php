<script type="text/javascript">
  var productos_carrito= <?php echo json_encode($productos_carrito); ?>;
  var precioDelivery= <?php echo json_encode($precio_delivery); ?>;
</script>

  <div class="container single_product_container">
    <div class="row">
      <div class=" col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <h5>AGREGAR PEDIDO</h5>
      </div>
    </div>
  </div>

<br><br>
<div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="nk-int-st">
                  <label for="motorizado">Nombre Completo:</label>
                  <input class="form_input" type="text" name="nombre" id="nombre" value="<?php echo $pedido->cliente ?>">
                  <input type="hidden" name="idPedido" id="idPedido" value="<?php echo $pedido->id ?>">
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="nk-int-st">
                  <label for="motorizado">Telefono:</label>
                  <input class="form_input" type="text" name="telefono" id="telefono" value="<?php echo $pedido->telefono ?>">
              </div>
            </div>
          </div>
          <br>
          <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="nk-int-st">
                      <label for="motorizado">Direccion:</label>
                      <input class="form_input" type="text" name="direccion" id="direccion" value="<?php echo $pedido->direccion ?>">
                  </div>
                </div>
          </div>
          <br>
          <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="nk-int-st">
                      <label for="motorizado">Referencia:</label>
                      <input class="form_input" type="text" name="referencia" id="referencia" value="<?php echo $pedido->referencia ?>">
                  </div>
                </div>
          </div>
          <br>
          <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="nk-int-st">
                      <label for="motorizado">Metodo de pago:</label>
                      <select class="form_input" name="pago" id="pago" value="<?php echo $pedido->metodo_pago ?>">
                          <option value="Efectivo">Pago en Efectivo</option>
                          <option value="POS">Pago en POS</option>
                      </select>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="divEfectivo">
                    <div class="nk-int-st">
                      <label for="motorizado">Pagaré con:</label>
                      <input class="form_input" type="text"  name="efectivo" id="efectivo" value="<?php echo $pedido->efectivo ?>" required="required">
                  </div>
                </div>
          </div>
          <div class="row">
              <div class="col-md-6 col-sm-6">
                <label for="direccion" class="grayText">*Fecha de Entrega:</label>
                <input class="form_input input_email input_ph" type="date" name="fecha_entrega" id="fecha_entrega" value="<?php echo $pedido->fecha_entrega ?>">
              </div>
              <div class="col-md-5 col-sm-5" id="divEfectivo">
                <label for="direccion" class="grayText">*Hora de Entrega:</label>
                <input class="form_input input_email input_ph" type="time" name="hora_entrega" id="hora_entrega" value="<?php echo $pedido->hora_entrega ?>">
              </div>
          </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="nk-int-st">
                <label for="motorizado">Agregar Productos:</label>
                <select class="form_input" name="pro" id="pro">
                  <option value="">-- Seleccionar Producto --</option>
                  <?php
                    foreach ($productos as $producto) {
                  ?>
                    <option value="<?php echo $producto->id ?>"><?php echo "S/ ".$producto->precio ." > ". $producto->nombre ?></option>
                  <?php  }  ?>
                </select>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <br>
            <table class="table tablaDetalle">
                <thead>
                  <tr>
                    <th><center>Cantidad</center></th>
                    <th><center>Producto</center></th>
                    <th><center>Subtotal</center></th>
                  </tr>
                </thead>
                <tbody id="cuerpo">

                </tbody>
            </table>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <button id="EditPedido" class="btn btn-success btn-block btn-lg">Editar Pedido</button>
          </div>
        </div>
      </div>

    </div>
</div>

<div class="modal fade" id="modalProducto" role="dialog">
<form id="formularioDatos" method="POST">
    <div class="modal-dialog modal-large">
        <div class="modal-content">
            <div class="modal-body">
              <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <input type="hidden" name="id" id="id">
                  <input type="hidden" name="precio" id="precio">
                  <span class="tituloProducto"></span>
                  <p class="descripcionProducto"></p>
                  </div>
              </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-example-wrap mg-t-30">
                            <div class="form-example-int form-horizental">
                                <div class="form-group">
                                    <div class="row">
                                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                            <label class="labelCantidad" for="cantidad">Cantidad: </label>
                                      </div>
                                      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                            <input type="number" id="cantidad" name="cantidad" class="form-control input-sm" value="1" min="1">
                                      </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="nk-int-st">
                                                <label for="cantidad">Nota Adicional: </label>
                                                <textarea class="form-control input-sm" id="nota" name="nota" rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="divAtributos">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="btn btn-success btn-block btn-lg" id="botonAgregar">
                          <div class="precioProducto">
                            S/ <span class="subTotalPro"></span>
                          </div>
                          <div class="vertical-separator">

                          </div>
                          <div class="textoAgregar">
                            Agregar al pedido
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
