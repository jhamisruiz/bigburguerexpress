<script>
    <?php echo $grilla; ?>
</script>
  <div class="container single_product_container">
    <div class="row">
      <div class="col-8">
        <h5>REPORTE DE VENTAS DIARIO</h5>
      </div>
    </div>
  </div>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-12 offset-md-3">
        <div class="breadcomb-area">
        	<div class="container">
        		<div class="row">
        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        				<div class="breadcomb-list">
        					<div class="row">
        						<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        							<div class="form-group">
        								<label class="control-label" for="customer">Filtrar por:</label>
        								<br>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" id="rango1" name="rango" value="single">
          								<label class="form-check-label" for="rango1">Fecha</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" id="rango2" name="rango" value="range">
          								<label class="form-check-label" for="rango2">Rango de fechas</label>
                        </div>
        							</div>
        						</div>
        						<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        							<div id="event_period" class="form-group" style="display: none;">
        								<input type="text" id="start" class="actual_range form-control">
        								<input type="text" id="end" class="actual_range form-control">
        								<div style="padding: 5px 0px" class="btn-group" role="group">
        									<button class="btn btn-success" id="btn_date_apply">Aplicar</button>
        									<button class="btn btn-danger" id="btn_date_clear">Quitar</button>
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

<br><br>

<div class="data-table-area">
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <table id="tablaReportes" class="table table-striped">
                      <tfoot>
                           <tr>
                             <th></th>
                             <th></th>
                             <th></th>
                             <th></th>
                             <th></th>
                              <th colspan="1" style="text-align:left" id="total">Total:</th>
                           </tr>
                       </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
