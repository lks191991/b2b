			</hr>
			
	<div class="bg-row row p-2">
			 <div class="form-group col-md-12 mt-3">
			<a class="btn btn-danger btn-sm float-right remove-btn" href="javascript:void(0)">Remove <i class="fas fa-trash"></i></a>
			</div>
			  
			   
			  <div class="col-md-12">
                <table class="table table-bordered">
                  <thead>
				   <tr>
                    <th>Room Type</th>
					<th><input type="text" id="room_type{{$rowCount}}"  name="room_type[]"  class="form-control"  required  /></th>
					<th colspan="4"></th>
                  </tr>
				   <tr>
                    <th>Number of Rooms</th>
					<th ><input type="text" id="nom_of_room{{$rowCount}}"  name="nom_of_room[]"  class="form-control onlynumbr" required  /></th>
					<th colspan="4"></th>
                  </tr>
				  <tr>
                    <th>Meal Plan</th>
					<th >
						<select name="mealplan[]" id="mealplan{{$rowCount}}" class="form-control" required  >
						
							<option value="">--Select--</option>
							<option value="Room Only">Room Only</option>
							<option value="Breakfast">Breakfast</option>
							<option value="Breakfast and Lunch or Dinner">Breakfast and Lunch or Dinner</option>
							<option value="MAP">MAP</option>
							<option value="All Meals">All Meals</option>
							</select>
						</th>
					<th colspan="4"></th>
                  </tr>
                  <tr>
					<th></th>
                    <th>Single</th>
					<th>Double</th>
					<th>Extra Bed</th>
                    <th>CWB</th>
                    <th>CNB</th>
                  </tr>
				   <tr>
                    <th>Number of Pax</th>
					<td><input type="text" id="nop_s{{$rowCount}}"  required name="nop_s[]"  class="form-control onlynumbrf psingle" data-inputnumber="{{$rowCount}}"  /></td>
					<td><input type="text" id="nop_d{{$rowCount}}"  name="nop_d[]"  class="form-control onlynumbrf pdouble" data-inputnumber="{{$rowCount}}" value="0" /></td>
					<td><input type="text" id="nop_eb{{$rowCount}}"   name="nop_eb[]"  class="form-control onlynumbrf peb" data-inputnumber="{{$rowCount}}" value="0" /></td>
                    <td><input type="text" id="nop_cwb{{$rowCount}}" name="nop_cwb[]"  class="form-control onlynumbrf pcwb" data-inputnumber="{{$rowCount}}" value="0" /></td>
                    <td><input type="text" id="nop_cnb{{$rowCount}}"  name="nop_cnb[]"  class="form-control onlynumbrf pcnb" data-inputnumber="{{$rowCount}}" value="0" /></td>
                  </tr>
				  <tr>
                    <th>Net Rate</th>
					<td><input type="text" id="nr_s{{$rowCount}}" required name="nr_s[]"  class="form-control onlynumbrf psingle" data-inputnumber="{{$rowCount}}" /></td>
					<td><input type="text" id="nr_d{{$rowCount}}"  name="nr_d[]"  class="form-control onlynumbrf pdouble" data-inputnumber="{{$rowCount}}" value="0"   /></td>
					<td><input type="text" id="nr_eb{{$rowCount}}"  name="nr_eb[]"  class="form-control onlynumbrf peb "  data-inputnumber="{{$rowCount}}" value="0"  /></td>
                    <td><input type="text" id="nr_cwb{{$rowCount}}" name="nr_cwb[]"  class="form-control onlynumbrf pcwb" data-inputnumber="{{$rowCount}}"  value="0" /></td>
                    <td><input type="text" id="nr_cnb{{$rowCount}}"  name="nr_cnb[]"  class="form-control onlynumbrf pcnb" data-inputnumber="{{$rowCount}}" value="0"  /></td>
                  </tr>
				   <tr>
                    <th>Per Pax to be autocalculated</th>
					<td><input type="text" id="ppa_s{{$rowCount}}"  name="ppa_s[]" readonly class="form-control onlynumbrf " data-inputnumber="{{$rowCount}}" value="0" /></td>
					<td><input type="text" id="ppa_d{{$rowCount}}"  name="ppa_d[]"  readonly class="form-control onlynumbrf "  data-inputnumber="{{$rowCount}}" value="0" /></td>
					<td><input type="text" id="ppa_eb{{$rowCount}}"  name="ppa_eb[]"  value="0"readonly class="form-control onlynumbrf" data-inputnumber="{{$rowCount}}"  /></td>
                    <td><input type="text" id="ppa_cwb{{$rowCount}}" name="ppa_cwb[]"  readonly class="form-control onlynumbrf" data-inputnumber="{{$rowCount}}" value="0" /></td>
                    <td><input type="text" id="ppa_cnb{{$rowCount}}"  name="ppa_cnb[]"  readonly class="form-control onlynumbrf" data-inputnumber="{{$rowCount}}" value="0" /></td>
                  </tr>
				   <tr>
                    <th>Mark Up in % (Default Value (5%)</th>
					<td><input type="text" id="markup_p_s{{$rowCount}}" required name="markup_p_s[]"  class="form-control onlynumbrf psingle" value="5" data-inputnumber="{{$rowCount}}" /></td>
					<td><input type="text" id="markup_p_d{{$rowCount}}" value="5" name="markup_p_d[]"  class="form-control onlynumbrf pdouble" data-inputnumber="{{$rowCount}}"  /></td>
					<td><input type="text" id="markup_p_eb{{$rowCount}}" value="5"  name="markup_p_eb[]"  class="form-control onlynumbrf peb" data-inputnumber="{{$rowCount}}"  /></td>
                    <td><input type="text" id="markup_p_cwb{{$rowCount}}" value="5" name="markup_p_cwb[]"  class="form-control onlynumbrf pcwb" data-inputnumber="{{$rowCount}}" /></td>
                    <td><input type="text" id="markup_p_cnb{{$rowCount}}" value="5" name="markup_p_cnb[]"  class="form-control onlynumbrf pcnb" data-inputnumber="{{$rowCount}}" /></td>
                  </tr>
				   <tr>
                    <th>Mark up Value</th>
					<td><input type="text" id="markup_v_s{{$rowCount}}"  name="markup_v_s[]"  class="form-control onlynumbrf " readonly data-inputnumber="{{$rowCount}}" value="0" /></td>
					<td><input type="text" id="markup_v_d{{$rowCount}}"  name="markup_v_d[]"  class="form-control onlynumbrf " readonly data-inputnumber="{{$rowCount}}" value="0" /></td>
					<td><input type="text" id="markup_v_eb{{$rowCount}}"  name="markup_v_eb[]"  class="form-control onlynumbrf" readonly data-inputnumber="{{$rowCount}}"  value="0" /></td>
                    <td><input type="text" id="markup_v_cwb{{$rowCount}}" name="markup_v_cwb[]"  class="form-control onlynumbrf" readonly data-inputnumber="{{$rowCount}}" value="0" /></td>
                    <td><input type="text" id="markup_v_cnb{{$rowCount}}"  name="markup_v_cnb[]"  class="form-control onlynumbrf" readonly data-inputnumber="{{$rowCount}}" value="0" /></td>
                  </tr>
				  </table>
              </div>
			 </div>	
 
 
  
