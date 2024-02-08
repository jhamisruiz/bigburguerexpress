
  	<div class="new_arrivals">
  		<div class="container">
  			<div class="row">
  				<div class="col text-center">
  					<div class="section_title new_arrivals_title">
  						<h2>Nuestra Carta</h2>
  					</div>
  				</div>
  			</div>
  			<div class="row align-items-center">
  				<div class="col text-center">
  					<div class="new_arrivals_sorting">
  						<ul class="arrivals_grid_sorting clearfix button-group filters-button-group">
                <?php
                  foreach ($categorias as $categoria) {
                    echo '<li class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center" data-filter=".'.str_replace(' ', '', $categoria->descripcion).'">'.$categoria->descripcion.'</li>';
                  }
                 ?>
  						</ul>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>
<br><br>
<div class="container">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div id="main_menu" class="box_style_2">
          <h2 class="inner" id="tableTittle" ></h2>
          <table class="table cart-list">
            <thead>
            <tr>
              <th>Producto</th>
              <th><center>Precio</center></th>
              <th><center>Agregar</center></th>
            </tr>
            </thead>
            <tbody class="product-grids" data-isotope='{ "itemSelector": ".product-items" }'>
              <?php
                foreach ($productos as $producto) {
              ?>
                <tr class="product-items <?php echo $producto->categorias ?>">
                  <td>
                    <div class="rstl_img">
                      <a href="#menu_12">
                        <img src="<?php echo base_url(); ?>public/uploads/productos/<?php echo $producto->imagen ?>">
                      </a>
                    </div>
                    <div class="rstl_img_contant">
                      <h5><?php echo $producto->nombre ?></h5>
                      <p><?php echo $producto->descripcion ?></p>
                    </div>
                  </td>
                  <td><center><strong><?php echo "S/ ".$producto->precio ?></strong></center></td>
                  <td class="options">
                    <a class="btn_add" value="<?php echo $producto->id ?>" href=""><i class="fa fa-plus-square-o"></i></a>
                  </td>
                </tr>
            <?php }   ?>

            </tbody>
          </table>
          <hr>
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
