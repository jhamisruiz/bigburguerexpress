<script>
    <?php echo $grilla; ?>
</script>

  <div class="container single_product_container">
    <div class="row head">
      <div class=" col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <h5>DETALLES DEL PRODUCTO</h5>
      </div>
      <div class=" col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <select class="form-control" id="categories" name="categories">
        </select>
      </div>
      <div class="btn-group col-lg-3 col-md-3 col-sm-3 col-xs-12" role="group">
          <button type="button" name="button" id="btn_delete" class="btn btn-sm btn-danger">ELIMINAR</button>
          <button type="button" name="button" id="btn_edit" class="btn btn-sm btn-warning">EDITAR</button>
          <button type="button" name="button" id="btn_add" class="btn btn-sm btn-success">AGREGAR</button>
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
                    <table id="tablaProductos" class="table table-striped">

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="productoModal" role="dialog">
<form id="formularioDatos" method="POST" enctype="multipart/form-data">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Datos del Producto</h5>
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
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                            <div class="nk-int-st">
                                                <input type="hidden" id="id" name="id">
                                                <input type="text" id="nombre" name="nombre" class="form-control input-sm" placeholder="Nombre del producto">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <div class="nk-int-st">
                                                <input type="number" id="precio" name="precio" class="form-control input-sm" placeholder="Precio" step=".01">
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <div class="nk-int-st">
                                                <input type="number" id="orden" name="orden" class="form-control input-sm" placeholder="Orden">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-example-int form-horizental">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="nk-int-st">
                                              <textarea class="form-control input-sm" id="descripcion" name="descripcion" rows="3" cols="80" placeholder="Detalles del producto"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-example-int form-horizental">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                            <div class="nk-int-st">
                                              <label for="imagen">Imagen del producto</label>
                                              <input type="file" id="archivo" name="archivo" class="form-control input-sm">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-example-int form-horizental">
                                <div class="form-group">
                                    <div class="row">
                                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                          <div class="nk-int-st">
                                            <label for="id_categoria">Categorías de Producto</label>
                                            <select class="form-control input-sm custom-select" name="id_categoria[]" id="id_categoria" multiple>
                                              <?php
                                                foreach ($categorias as $categoria) {
                                              ?>
                                                <option value="<?php echo $categoria->id ?>"><?php echo $categoria->descripcion ?></option>
                                              <?php  }  ?>

                                            </select>
                                          </div>
                                      </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="nk-int-st">
                                              <label for="selectAtributos ">Atributos del Producto</label>
                                              <select class="form-control input-sm custom-select" name="selectAtributos[]" id="selectAtributos" multiple>
                                                <?php
                                                  foreach ($atributos as $atributo) {
                                                ?>
                                                  <option value="<?php echo $atributo->id ?>"><?php echo $atributo->titulo ?></option>
                                                <?php  }  ?>
                                              </select>
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
