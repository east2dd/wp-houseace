<?php
/*
Template Name: Quote landing
*/
?>

<?php get_header(); ?>

 

     
<style>
	
	/*-------------------------------*/
    /*      Code snippet by          */
    /*      @maridlcrmn              */
    /*-------------------------------*/


    section {
        min-height: 100%;
        padding-top: 150px;
        padding-bottom: 150px;
    }

    .quote {
        color: rgba(0,0,0,.1);
        text-align: center;
        margin-bottom: 30px;
    }

  
</style>
<!-- Page -->
<!-- Hero -->
  
		
			<section class="section bg-white">
				<div class="container">
 			  <div class="row text-center">
           <div class="col-md-10 col-md-offset-1">
             <div class="row">
              <div class="panel panel-bordered btn-raised">
               <div class="panel-heading bg-red-600 ">
                <div class="col-md-6">
                <div class="navbar-brand pull-left">
          <a href="<?php bloginfo('url'); ?>">
            <img class="navbar-brand-logo" src="<?php bloginfo('template_url'); ?>/assets/images/housewt.png" title="Houseace">
         </a> <div class="font-size-10 white inline">Estimator</div>
                  </div></div>
                 <div class="col-md-6 white">
                     <div class="col-md-6 col-xs-6">
                     <label for="postcode">Postcode:</label>
                     <input id="postcode" class="form-control" type="number"/>
                   </div>
                     <div class="col-md-6 col-xs-6">
                     <label for="postcode">Sale Price:</label>
                     <input id="postcode" class="form-control" type="number"/>
                   </div>
                 </div>
                 
             <hr>
                 <div class="row white padding-bottom-10">
                   <div class="col-md-12">
                      <div class="col-md-1 col-xs-6">
                     <label for="beds">Beds:</label>
                     <input id="beds" class="form-control" type="number"/>
                   </div>
                      <div class="col-md-1 col-xs-6">
                     <label for="baths">Baths:</label>
                     <input id="baths" class="form-control" type="number"/>
                   </div>
                      <div class="col-md-1 col-xs-6">
                     <label for="living">Living:</label>
                     <input id="living" class="form-control" type="number"/>
                   </div>
                      <div class="col-md-1 col-xs-6">
                     <label for="toilets">toilets:</label>
                     <input id="toilets" class="form-control" type="number"/>
                   </div>
                     <div class="col-md-3 col-xs-6">
                     <label for="type">Dwelling Type</label>
                     <select id="area" class="form-control">
                       <option>House</option>
                       <option>Unit</option>
                       <option>Apartment</option>
                        </select>
                     </div>
                     <div class="col-md-3 col-xs-6">
                     <label for="type">Levels</label>
                     <select id="area" class="form-control">
                       <option>1</option>
                       <option>2</option>
                       <option>3</option>
                        </select>
                     </div>
                     <div class="col-md-2 col-xs-6">
                     <label for="area">Floor Area:</label>
                     <input id="area" class="form-control" type="number"/>
                     </div>
                   </div>
                     </div>
               </div>  
                <div class="bg-blue-grey-700">
                  <div class="row white padding-10">
                    <div class="col-md-1">
                      <div class="font-size-20 font-weight-600 text-center">
                        Area
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="font-size-20 font-weight-600 text-center">
                        Project
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="font-size-20 font-weight-600 text-center">
                        Quality
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="font-size-20 font-weight-600 text-center">
                        Budget Range
                      </div>
                    </div>
                  </div>
                </div>
               <div class="">
                   <div class="bg-grey-200">
                  <div class="row black padding-10">
                    <div class="col-md-1">
                       <div class="font-size-20 font-weight-600 text-center">
                        Area
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="font-size-20 font-weight-600 text-center">
                        Painting
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="font-size-20 font-weight-600 text-center">
                        Current Condition
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        Low
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        High
                      </div>
                    </div>
                  </div>
                   </div>
                  <div class="row black padding-10">
                    <div class="col-md-1">
                      <input type="number" class="form-control"/>
                    </div>
                    <div class="col-md-3">
                      <div class="font-size-20 font-weight-600 text-center">
                        Interior Painting
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="col-md-4">
                        <input type="radio" name="quality" value="poor"><br>Poor
                      </div>
                       <div class="col-md-4">
                         <input type="radio" name="quality" value="average"><br/>Average</div>
                       <div class="col-md-4">
                         <input type="radio" name="quality" value="great"> <br/>Great</div>
                       </div>
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        $5000
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        $7000
                      </div>
                    </div>
                  </div>
                 <div class="row black padding-10">
                    <div class="col-md-1">
                      <input type="number" class="form-control"/>
                    </div>
                    <div class="col-md-3">
                      <div class="font-size-20 font-weight-600 text-center">
                        Exterior Painting
                      </div>
                    </div>
                   <div class="col-md-4">
                      <div class="col-md-4">
                        <input type="radio" name="quality" value="poor"><br>Poor
                      </div>
                       <div class="col-md-4">
                         <input type="radio" name="quality" value="average"><br/>Average</div>
                       <div class="col-md-4">
                         <input type="radio" name="quality" value="great"> <br/>Great</div>
                       </div>
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        $6000
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        $9000
                      </div>
                    </div>
                  </div>
                 <div class="row black padding-10">
                    <div class="col-md-1">
                      <input type="number" class="form-control"/>
                    </div>
                    <div class="col-md-3">
                      <div class="font-size-20 font-weight-600 text-center">
                        Roof Painting
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="col-md-4">
                        <input type="radio" name="quality" value="poor"><br>Poor
                      </div>
                       <div class="col-md-4">
                         <input type="radio" name="quality" value="average"><br/>Average</div>
                       <div class="col-md-4">
                         <input type="radio" name="quality" value="great"> <br/>Great</div>
                       </div>
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        $3000
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        $5000
                      </div>
                    </div>
                  </div>
                 <div class="bg-grey-200">
                  <div class="row black padding-10">
                    <div class="col-md-1">
                       <div class="font-size-20 font-weight-600 text-center">
                        Area
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="font-size-20 font-weight-600 text-center">
                        Renovation Type
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="font-size-20 font-weight-600 text-center">
                        Desired Quality
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        Low
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        High
                      </div>
                    </div>
                  </div>
                   </div>
                  <div class="row black padding-10">
                    <div class="col-md-1">
                      <input type="number" class="form-control"/>
                    </div>
                    <div class="col-md-3">
                      <div class="font-size-20 font-weight-600 text-center">
                        Bathroom Renovation
                      </div>
                    </div>
                     <div class="col-md-4">
                      <div class="col-md-4">
                        <input type="radio" name="quality" value="poor"><br>Economy
                      </div>
                       <div class="col-md-4">
                         <input type="radio" name="quality" value="average"><br/>Mid-range</div>
                       <div class="col-md-4">
                         <input type="radio" name="quality" value="great"> <br/>Luxury</div>
                       </div> 
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        $5000
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        $7000
                      </div>
                    </div>
                  </div>
                 <div class="row black padding-10">
                    <div class="col-md-1">
                      <input type="number" class="form-control"/>
                    </div>
                    <div class="col-md-3">
                      <div class="font-size-20 font-weight-600 text-center">
                        Kitchen Renovation
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="col-md-4">
                        <input type="radio" name="quality" value="poor"><br>Economy
                      </div>
                       <div class="col-md-4">
                         <input type="radio" name="quality" value="average"><br/>Mid-range</div>
                       <div class="col-md-4">
                         <input type="radio" name="quality" value="great"> <br/>Luxury</div>
                       </div> 
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        $6000
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        $9000
                      </div>
                    </div>
                  </div>
                 <div class="row black padding-10">
                    <div class="col-md-1">
                      <input type="number" class="form-control"/>
                    </div>
                    <div class="col-md-3">
                      <div class="font-size-20 font-weight-600 text-center">
                        Laundry Renovation
                      </div>
                    </div>
                     <div class="col-md-4">
                      <div class="col-md-4">
                        <input type="radio" name="quality" value="poor"><br>Economy
                      </div>
                       <div class="col-md-4">
                         <input type="radio" name="quality" value="average"><br/>Mid-range</div>
                       <div class="col-md-4">
                         <input type="radio" name="quality" value="great"> <br/>Luxury</div>
                       </div> 
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        $3000
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        $5000
                      </div>
                    </div>
                  </div>
                      <div class="bg-grey-200">
                  <div class="row black padding-10">
                    <div class="col-md-1">
                       <div class="font-size-20 font-weight-600 text-center">
                        Area
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="font-size-20 font-weight-600 text-center">
                        Flooring
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="font-size-20 font-weight-600 text-center">
                        Desired Quality
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        Low
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        High
                      </div>
                    </div>
                  </div>
                   </div>
                  <div class="row black padding-10">
                    <div class="col-md-1">
                      <input type="number" class="form-control"/>
                    </div>
                    <div class="col-md-3">
                      <div class="font-size-20 font-weight-600 text-center">
                        Timber Polished
                      </div>
                    </div>
                      <div class="col-md-4">
                      <div class="col-md-4">
                        <input type="radio" name="quality" value="poor"><br>Economy
                      </div>
                       <div class="col-md-4">
                         <input type="radio" name="quality" value="average"><br/>Mid-range</div>
                       <div class="col-md-4">
                         <input type="radio" name="quality" value="great"> <br/>Luxury</div>
                       </div> 
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        $5000
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        $7000
                      </div>
                    </div>
                  </div>
                 <div class="row black padding-10">
                    <div class="col-md-1">
                      <input type="number" class="form-control"/>
                    </div>
                    <div class="col-md-3">
                      <div class="font-size-20 font-weight-600 text-center">
                        Tiled Floors
                      </div>
                    </div>
                      <div class="col-md-4">
                      <div class="col-md-4">
                        <input type="radio" name="quality" value="poor"><br>Economy
                      </div>
                       <div class="col-md-4">
                         <input type="radio" name="quality" value="average"><br/>Mid-range</div>
                       <div class="col-md-4">
                         <input type="radio" name="quality" value="great"> <br/>Luxury</div>
                       </div> 
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        $6000
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        $9000
                      </div>
                    </div>
                  </div>
                 <div class="row black padding-10">
                    <div class="col-md-1">
                      <input type="number" class="form-control"/>
                    </div>
                    <div class="col-md-3">
                      <div class="font-size-20 font-weight-600 text-center">
                        Carpet Flooring
                      </div>
                    </div>
                     <div class="col-md-4">
                      <div class="col-md-4">
                        <input type="radio" name="quality" value="poor"><br>Economy
                      </div>
                       <div class="col-md-4">
                         <input type="radio" name="quality" value="average"><br/>Mid-range</div>
                       <div class="col-md-4">
                         <input type="radio" name="quality" value="great"> <br/>Luxury</div>
                       </div> 
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        $3000
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="font-size-20 font-weight-600 text-center">
                        $5000
                      </div>
                    </div>
                  </div>
             
                 </div>
                <div class="panel-footer bg-blue-grey-700">
                  <div class="font-size-30 font-weight-600 white">Total Estimate: $200030.00</div><br>
                  <small>**All pricing data is pulled from previous projects from the houseace platform, this is only a price guide and there is liability to these prices</small>
               <hr>
                  <div class="row">
                <div class="font-size-30 font-weight-600 white">Price Assumptions</div>
                <div class="col-md-6">
                <div class="font-size-30 font-weight-600 white">Rent Increase: 5-7%</div>
                </div>
                 <div class="col-md-6">
                <div class="font-size-30 font-weight-600 white">Value Increase: 10-12%</div>
                </div>
                </div>
                </div>
                <div class="padding-20">
                  <a class="btn btn-primary btn-block btn-raised btn-lg" href="/add_quote">Get an Instant Quote</a>
                </div>
               </div>
             </div>
       </div>
     </div>
          
				</div>

			
			</section>
        
			

<?php get_footer(); ?>