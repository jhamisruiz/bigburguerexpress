<script type="text/javascript">
  var arrayProductos= <?php echo json_encode($productos); ?>;
  var precioDelivery= <?php echo json_encode($precio_delivery); ?>;
</script>

<div class="container single_product_container">
  <div class="row">
    <div class="col-lg-6">
      <div class="row">
          <div class="col-md-11 col-sm-11">
            <h4 class="grayText">Datos de entrega: </h4>
          </div>
      </div>
        <div class="row">
            <div class="col-md-11 col-sm-11">
              <label for="cliente" class="grayText">*Nombre Completo:</label>
              <input class="form_input input_email input_ph" type="text" name="nombre" id="nombre" placeholder="Nombre completo" required="required">
            </div>
        </div>
        <div class="row">
            <div class="col-md-11 col-sm-11">
              <label for="telefono" class="grayText">*Teléfono:</label>
              <input class="form_input input_email input_ph" type="text" name="telefono" id="telefono" placeholder="Teléfono" required="required">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6">
              <label for="direccion" class="grayText">*Método de Pago:</label>
              <select class="form_input" name="pago" id="pago">
                  <option value="Efectivo">Pago en Efectivo</option>
                  <option value="POS">Pago en POS</option>
              </select>
            </div>
            <div class="col-md-5 col-sm-5" id="divEfectivo">
              <label for="direccion" class="grayText">Pagaré con:</label>
              <input class="form_input input_email input_ph" type="text"  name="efectivo" id="efectivo" value=0 required="required">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-11 col-sm-11">
              <label for="direccion" class="grayText">*Dirección de entrega:</label>
              <input class="form_input input_email input_ph" type="text" name="direccion" id="direccion" placeholder="Direccin de entrega" required="required">
            </div>
        </div>
        <div class="row">
            <div class="col-md-11 col-sm-11">
              <label for="referencia" class="grayText">Referencia:</label>
              <input class="form_input input_email input_ph" type="text" name="referencia" id="referencia" placeholder="Referencia del Lugar">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6">
              <label for="direccion" class="grayText">*Fecha de Entrega:</label>
              <input class="form_input input_email input_ph" type="date" name="fecha_entrega" id="fecha_entrega">
            </div>
            <div class="col-md-5 col-sm-5" id="divEfectivo">
              <label for="direccion" class="grayText">*Hora de Entrega:</label>
              <input class="form_input input_email input_ph" type="time" name="hora_entrega" id="hora_entrega">
            </div>
        </div>
    </div>
    <div class="col-lg-6">
      <div class="row">
        <div class="col-md-12 col-sm-12">
              <h4 class="grayText">Detalles del pedido </h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 col-sm-12">
          <table class="table tablaDetalle">
            <thead>
              <tr>
                <th><center>Cantidad</center></th>
                <th>Producto</th>
                <th><center>Subtotal</center></th>
              </tr>
            </thead>
              <?php
                $total=0;
                foreach ($productos as $key => $producto) {
              ?>
              <tr>
                <td><center><?php echo $producto->cantidad; ?></center></td>
                <td><?php echo $producto->nombre; ?>
                  <?php foreach ($producto->atributos as $atributo ): ?>
                    <p class="atributos"><?php echo $atributo; ?></p>
                  <?php endforeach; ?>
                  <?php if($producto->nota != ""){
                    echo "<hr>";
                    echo '<p class="notaD">'.$producto->nota.'</p></td>';
                  } ?>
                <td><center><?php echo "S/   " . number_format($producto->cantidad * $producto->precio, 2); ?><button value="<?php echo $key; ?>" type="button" class="close deleteProduct">&times;</button></center></td>
                <?php $total+=($producto->cantidad * $producto->precio); ?>
              </tr>
              <?php  } ?>
              <?php if(sizeof($productos) > 0){ ?>
               <tr>
                 <td></td>
                 <th><center>Delivery</center></th>
                 <th><center>S/<span id=""><?php echo " ".number_format($precio_delivery,2); ?></span></center></th>
               </tr>

             <?php
                $total+=$precio_delivery;
              }
              ?>

            <tr>
              <td></td>
              <th><center>TOTAL</center></th>
              <th><center>S/<span id="totalPed"><?php echo " ".number_format($total ,2); ?></span></center></th>
            </tr>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 col-sm-12">
          <button id="confirmPedido" class="btn btn-success btn-block btn-lg" style="background-color:#00ae00;">Confirmar y enviar por WhatsApp</button>
        </div>
      </div>
    </div>
  </div>
</div>
