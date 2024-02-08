  <div class="container single_product_container">
    <div class="row">
      <div class="col-10">
        <h5>DATOS DE LA EMPRESA</h5>
      </div>
      <div class="col-2">

      </div>
    </div>
  </div>

<br><br>

<div class="data-table-area">
  <div class="container">
    <form method="POST" id="formularioDatos" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-9 col-sm-12 offset-md-2">
              <label for="logo">Nombre de la Empresa:</label>
              <input class="form_input input_email input_ph" type="text" name="nombre" id="nombre" placeholder="Nombre de la Empresa" required="required">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-12 offset-md-2">
              <label for="logo">Correo Electrónico:</label>
              <input class="form_input input_email input_ph" type="email" name="email" id="email" placeholder="Email" required="required">
            </div>
            <br>
            <div class="col-md-4 col-sm-12">
              <label for="logo">Teléfono:</label>
              <input class="form_input input_email input_ph" type="text" name="telefono" id="telefono" placeholder="Teléfono" required="required">
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 col-sm-12  offset-md-2">
              <label for="logo">Dirección:</label>
              <input class="form_input input_email input_ph" type="text" name="direccion" id="direccion" placeholder="Dirección" required="required">
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 col-sm-12  offset-md-2">
              <label for="logo">Logo de la Empresa:</label>
              <input class="form_input input_email input_ph" type="file" name="archivo" id="archivo">
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-sm-12  offset-md-2">
              <label for="logo">Costo de delivery:</label>
              <input class="form_input input_email input_ph" type="number" name="delivery" id="delivery" placeholder="Costo Delivery" step=".01">
            </div>
            <div class="col-md-2 col-sm-6">
              <label for="logo">Horario de Apertura:</label>
              <input class="form_input input_email input_ph" type="time" name="horario_entrada" id="horario_entrada">
            </div>
            <div class="col-md-2 col-sm-6">
              <label for="logo">Horario de Cierre:</label>
              <input class="form_input input_email input_ph" type="time" name="horario_salida" id="horario_salida">
            </div>
            <div class="col-md-3 col-sm-6">
              <label for="logo">Tiempo de espera: (min)</label>
              <input class="form_input input_email input_ph" type="number" name="tiempo_espera" id="tiempo_espera" value="0">
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 col-sm-12  offset-md-2">
              <button type="submit" name="button" id="btn_edit" class="btn btn-sm btn-success btn-margin">ACTUALIZAR</button>
            </div>
        </div>
    </form>
  </div>
</div>
