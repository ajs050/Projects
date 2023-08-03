<?php
/**
 * Template Name: Zoho Properties
 */
get_header();
$html = '';
$filter = '';
$sorting = '';
$property_id = '';
$access_token = '';
$class = '';
$price_range = '';
$class_listing_heading = '';
$class_pagination = '';
$array = array();

$access_token_url = 'https://accounts.zoho.com/oauth/v2/token?refresh_token=1000.f1e198da476a7ed2e9fb9566cf45b540.bfaca9cf1d47c3c371e725d4c6bdbc37&client_id=1000.YJYUSNNC6G8N0AGXPEPR3OLVX9VCCL&client_secret=67d2192bfd2424722fb05a90ec3e5aa3c1bbf6068a&grant_type=refresh_token';
$property_database_url = 'https://www.zohoapis.com/crm/v2/propertydatabase';

$json_get_data = get_data_via_zoho_api( $access_token_url, false , "POST" );

$get_data = json_decode($json_get_data);
$access_token = $get_data->access_token;

// code gets runs for detail page
if( isset( $_GET['id'] ) ) {
    
    $property_id = $_GET['id'];
    if( !empty($access_token) && !empty( $property_id ) ) { 
        $property_database_url = 'https://www.zohoapis.com/crm/v2/propertydatabase/'.$property_id ;
        $json_get_data = get_data_via_zoho_api( $property_database_url, $access_token, 'GET' );
        $get_data = json_decode($json_get_data);

        if( empty($get_data) ) {
            global $wp;
            $listing_url =  home_url( $wp->request );
            wp_redirect($listing_url);
        } 
        $class_listing_heading = "hide-heading";

        $street_view = isset($get_data->data[0]->Street_View) ? $get_data->data[0]->Street_View : "";
        $listing_price = isset($get_data->data[0]->Listing_Price) ? $get_data->data[0]->Listing_Price : "";
        $property_type = isset($get_data->data[0]->Property_Type) ? $get_data->data[0]->Property_Type : "";
        $city = isset($get_data->data[0]->City) ? $get_data->data[0]->City : "";
        $state = isset($get_data->data[0]->State) ? $get_data->data[0]->State : "";
        $bed = isset($get_data->data[0]->Beds) ? $get_data->data[0]->Beds : "";
        $bath = isset($get_data->data[0]->Baths) ? $get_data->data[0]->Baths : "";
        $square_feet = isset($get_data->data[0]->Square_Feet) ? $get_data->data[0]->Square_Feet : "";
        $rehab_estimate = isset($get_data->data[0]->Rehab_Estimate) ? $get_data->data[0]->Rehab_Estimate : "";
        $resale_value = isset($get_data->data[0]->Resale_Value) ? $get_data->data[0]->Resale_Value : "";
        $monthly_rental_value = isset($get_data->data[0]->Rental_Value) ? $get_data->data[0]->Rental_Value : "";
        $str_daily_value = isset($get_data->data[0]->STRDailyValue) ? $get_data->data[0]->STRDailyValue : ""; 
            
        $on_img_error = get_stylesheet_directory_uri()."/images/streetview.jpeg" ;

        $class = 'detail';
        $html .= '
            <div class="detail-property">
                    <div class="detail-property-heading-wrapper">
                      <h2>'.$property_type.'</h2>
                      <button id="request_more_info">Request More Info</button>
                    </div>
                    <div class="detail-top">
                       <div class="street-view">
                          <img src="'.$street_view.'" onerror=src="'.$on_img_error.'">
                       </div>
                       <div class="detail-data">
                          <div class="table-detail-data">
                            <div>
                                <div>
                                  <div>Listing Price</div>
                                  <div>'.$listing_price.'</div>
                                </div>
                                <div>
                                  <div>Property Type</div>
                                  <div id="detail_property_form_name">'.$property_type.'</div>
                                </div>
                                <div>
                                  <div>City</div>
                                  <div>'.$city.'</div>
                                </div>
                                <div>
                                  <div>State</div>
                                  <div>'.$state.'</div>
                                </div>
                                <div>   
                                  <div>Bed</div>
                                  <div>'.$bed.'</div>
                                </div>    
                                <div>
                                  <div>Bath</div>
                                  <div>'.$bath.'</div>
                                </div>    
                                <div>
                                  <div>Square Feet</div>
                                  <div>'.$square_feet.'</div>
                                </div>
                                <div>    
                                  <div>Estimated Rehab Cost</div>
                                  <div id="estimated_rehab_cost" >'.$rehab_estimate.'</div>
                                </div>
                                <div>    
                                  <div>Estimated Resale Value</div>
                                  <div>'.$resale_value.'</div>
                                </div>    
                                <div> 
                                  <div>Estimated Monthly Rental Value</div>
                                  <div>'.$monthly_rental_value.'</div>
                                </div>
                                <div>    
                                  <div> Estimated Daily Rental Value</div>
                                  <div>'.$str_daily_value.'</div>
                                </div>
                                <div style="display:none">
                                    <div>Property Id</div>
                                    <div id="detail_property_form_id">'.$property_id.'</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="detail-form">
                      <div class="detail-popup-property-form detail-property-form">
                        <div class="detail-property-box">
                          <div class="detail-popupinner">
                            '.do_shortcode('[contact-form-7 id="4315" title="Property Form"]').'
                          </div>
                        </div>
                      </div>
                    </div>
            </div> 
        ';
    }
}

// code get runs for listing page 
if ( !empty($access_token) && empty($property_id) ) {
  
  //delete_transient(  "active_zoho_properties" );

  if ( false === ( $value = get_transient(  "active_zoho_properties" ) ) ) {
    // this code runs when there is no valid transient set
    // echo "transient not set";
    $page = 1;
    $property_database_url = $property_database_url."/search?criteria=((Status:equals:Active))";

    function pulling_all_properties( $property_database_url, $access_token, $page, $page_no, $array ) {

      $temp_property_database_url = $property_database_url;
      // modifiy query if their is more record than 200
      if( !empty($page_no) ) {
        $property_database_url = $property_database_url.$page_no;
      }

      $json_get_data = get_data_via_zoho_api( $property_database_url, $access_token, 'GET' );
      $get_data = json_decode($json_get_data, true);

      // code if there is more then 200 records
	  foreach( $get_data['data'] as $json_response_key => $json_response_values ) {
		array_push( $array, $json_response_values );
	  }
		
      $more_record = $get_data['info']['more_records'];
      if( $more_record == 1 ) {
        $page++;
        $page_no = "&page=".$page;
        $temp_store = pulling_all_properties( $temp_property_database_url, $access_token, $page, $page_no, $array );
        return $temp_store;
      } else {
        return $array;
      }
    }
    $temp_array = pulling_all_properties( $property_database_url, $access_token, $page, $page_no = "", $array = [] ); 

    set_transient( "active_zoho_properties", $temp_array, 1 * HOUR_IN_SECONDS );
  } else {
    echo "i am here";
    $temp_array = get_transient(  "active_zoho_properties" );
  }
  
  $class = 'properties';
  $class_pagination = 'holder';

  $state_json = file_get_contents('state.json', 1);
  $state = json_decode($state_json);
  $select_states = '';

  foreach( $state as $key => $values ) {
      $select_states .= '
          <option value="'.$key.'">'.$key.' - '.$values.'</option>
      ';
  }

  // sorting & filter select option html
  $filter = '
      <div class="filter_box"><div class="fliter">
      <label for="sort_by">Sort By:</label>
      <select id="sort_by" class="sorting">
          <optgroup label="Any">
              <option value="Newest">Newest First</option>
              <option value="Oldest">Oldest First</option>
              <option value="Max">Max Price</option>
              <option value="Min">Min Price</option>
          </optgroup>
      </select>

      <label for="beds">Beds:</label>
      <select id="beds" class="filter-beds">
          <optgroup label="All">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
          </optgroup>
      </select>

      <label for="baths">Baths:</label>
      <select id="baths" class="filter-baths">
          <optgroup label="All">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
          </optgroup>
      </select>

      <label for="states">States:</label>
      <select id="states" class="filter-states">
          <optgroup label="Any">
              <option value="">Any</option>
              '.$select_states.'
          </optgroup>
      </select>

      <label for="cities">Cities:</label>

      <select id="cities" class="filter-cities" multiple>
          <option value="null">All</option>
      </select>
      </div></div>
  ';
    
  // price range slider html
  $price_range = '
      <div class="container-price">
      <div class="range-area">
          <div class="row">
          <div class="col-sm-12">
              <div id="slider-range"></div>
          </div>
          </div>
          <div class="row slider-labels">
          <div class="col-xs-6 caption">
              <strong style="display: none" >Min:</strong> <span style="display: none" id="slider-range-value1"></span>
              <strong>Min:</strong> $<input type="number" id="input-slider-range-value1"></input>
          </div>
          <div class="col-xs-6 text-right caption">
              <strong style="display: none">Max:</strong> <span style="display: none" id="slider-range-value2"></span>
              <strong>Max:</strong> $<input type="number" id="input-slider-range-value2"></input>
          </div>
          </div>
          <div id="error_min_value"></div>
          <div class="row">
          <div class="col-sm-12">
              <form>
              <input type="hidden" name="min-value" value="">
              <input type="hidden" name="max-value" value="">
              </form>
          </div>
          </div>
          </div>
          <div class="filter-button">
              <button id="filter_button">Filter</button>
          </div>
      </div>
  ';

  $array = json_decode(json_encode($temp_array), true);

  function sortByOrder($a, $b) {
      $datetime1 = strtotime($a['Modified_Time']);
      $datetime2 = strtotime($b['Modified_Time']);
      return $datetime1 - $datetime2;
  }    
  usort($array, 'sortByOrder');
  $get_data = array_reverse($array);

  $temp_count = 0;
  foreach( $get_data  as $key => $sub_values ) {

      global $wp;
      $link = home_url( $wp->request );

      $street_view = isset($sub_values['Street_View']) ? $sub_values['Street_View']: "";
      $property_type = isset($sub_values['Property_Type']) ? $sub_values['Property_Type']: "";
      $listing_price = isset($sub_values['Listing_Price']) ? "$".$sub_values['Listing_Price'].".00": "NA";
      // $currency_symbol = isset($sub_values['currency_symbol']) ? $sub_values['currency_symbol']: "";
      $beds = isset($sub_values['Beds']) ? $sub_values['Beds']: "NA";
      $baths = isset($sub_values['Baths']) ? $sub_values['Baths']: "NA";
      $square_feet = isset($sub_values['Square_Feet']) ? $sub_values['Square_Feet']." sqft": "NA";
      $city = isset($sub_values['City']) ? $sub_values['City']: "NA";
      $state = isset($sub_values['State']) ? $sub_values['State']: "NA";
      $id = isset($sub_values['id']) ? $sub_values['id']: "";
      $property_status = isset($sub_values['Status']) ? $sub_values['Status']: "";

      $property_name_bed = '';
      if( !empty( $beds ) ) {
          $property_name_bed = $beds." Bed";
      } 
      $property_name_bath= '';
      if( !empty( $baths ) ) {
          $property_name_bath = $baths." Bath";
      }

      // code to add seperator (|) for the text below the image
      if( !empty( $property_name_bed ) && !empty( $property_name_bath ) && !empty( $square_feet ) ) {
          $property_name_bath = '| '.$property_name_bath; 
          $square_feet = '| '.$square_feet; 
      } elseif(!empty( $square_feet ) && (!empty( $property_name_bed ) || !empty( $property_name_bath)) ) {
          $square_feet = '| '.$square_feet;
      }
      elseif(!empty( $property_name_bath ) && (!empty( $property_name_bed ) || !empty( $square_feet)) ) {
          $property_name_bath = '| '.$property_name_bath;
      }

      // code to add seperator for the text in image
      if( !empty( $listing_price ) && !empty( $city ) && !empty( $state ) ) {
          $city = '• '.$city; 
          $state = ', '.$state;
      } elseif(!empty( $state ) && (!empty( $listing_price ) || !empty( $city)) ) {
          $state = ', '.$state;
      }
      elseif(!empty( $city ) && (!empty( $listing_price ) || !empty( $state)) ) {
          $city = '• '.$city;
      }

      // code to add (,) in listing price
      if ( strlen($listing_price) > 10 ) {
          $sub_listing_price = substr_replace( $listing_price, ',', '-6' , 0);
          $listing_price = substr_replace( $sub_listing_price, ',', '-10' , 0);
      } elseif ( strlen($listing_price) > 5 ) {
          $listing_price = substr_replace( $listing_price, ',', '-6' , 0);
      }

      $on_img_error = get_stylesheet_directory_uri()."/images/streetview.jpeg" ;
      
      if(!empty($id ) && $property_status == "Active") {
          $html .= '
              <a href="'.$link.'/?id='.$id.'">
                  <div class="single-property">
                      <input type="checkbox" name="propertyCheckbox" value="select" style="display:none" class="property-checkbox" data-target-id="'.$id.'" data-target-name="'.$property_type.'" onclick="getCheckedBoxes()"/>
                      <div class="property-image">
                          <img src="'.$street_view.'" onerror=src="'.$on_img_error.'">
                      </div>
                      <div class="property-name">
                      <div class="image-text">
                          <div class="top-left-description">
                              <span>'.$property_type.'</span>
                          </div>
                          <span class="image-text-price">'.$listing_price.'</span>
                          <span class="image-text-sqft">'.$city.' '.$state.'</span>
                      </div>
                          <span class="bottom-description">'.$property_name_bed.' '.$property_name_bath.' '.$square_feet.'</span>
                      </div>
                  </div>
              </a>
          ';
      }
  }
}
$listing_page_title = get_the_title();
$template = '
            <div class="container zoho-product">
                <div class="listing-page-heading '.$class_listing_heading.'">
                    <h1>
                        Daily Dose of Deals
                    </h1>
                    <h2>
                        Off-Market Property Search
                    </h2>
                </div>
                <div class="hide-filter-on-mobile">
                    <button id="hide_filter_mobile" class="'.$class_listing_heading.'">CLICK HERE TO SEARCH BY SPECIFIC AREA AND CRITERIA</button>
                </div>
                <div class="mobile-toggle"><div class="sort-by">'.$sorting.'</div>
                <div>'.$filter.'</div>
                <div class="price-range">
                    '.$price_range.'
                </div>
                <div class="search-parameter-list"></div></div>
                
                <div class="click-here '.$class_listing_heading.'">
                  <span id="click_here_text">If you want to inquire on multiple properties please click here. <br>Once you have selected all properties of interest, please click submit to get information.</span>
                  <div class="multi-select-buttons">
                    <button  id="click_here">Click Here</button>
                    <button  id="submit_property_form" disabled>Submit</button>
                    <div class="cancle-button-multi-select-properties" style="display:none" onclick="cancle_inquire()">
                        <button id="cancle_multi_select">Cancel</button>
                    </div>
                  </div>
                </div>
                <div id="itemContainer" class="'.$class.'">
                    '. $html .'
                </div>
                <div class="'.$class_pagination.'"></div>
            </div>'
        ;

echo $template;
?>
<style type="text/css">

.listing-page-heading {
    
    text-align: center;
}

.listing-page-heading h1 {
    text-align: center;
    font-size: 39px;
}

.listing-page-heading h2 {
    text-align: center;
    font-size: 22px;
}
  .holder {
    margin: 15px 0;
  }

  .holder a {
    font-size: 12px;
    cursor: pointer;
    margin: 0 5px;
    color: #333;
  }

  .holder a:hover {
    background-color: #222;
    color: #fff;
  }

  .holder a.jp-previous { margin-right: 15px; }
  .holder a.jp-next { margin-left: 15px; }

  .holder a.jp-current, a.jp-current:hover {
    color: #FF4242;
    font-weight: bold;
  }

  .holder a.jp-disabled, a.jp-disabled:hover {
    color: #bbb;
  }

  .holder a.jp-current, a.jp-current:hover,
  .holder a.jp-disabled, a.jp-disabled:hover {
    cursor: default;
    background: none;
  }

  .holder span { margin: 0 5px; }

  /*loader*/
.spin-spinning {
    position: static;
    display: inline-block;
    opacity: 1;
    z-index: 500000;
}
.spin{
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    width: 100vw;
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background: rgb(0 0 0 / 80%);
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    color: rgba(0,0,0,0.65);
    font-size: 14px;
    font-variant: tabular-nums;
    line-height: 1.5;
    -webkit-font-feature-settings: 'tnum';
    font-feature-settings: 'tnum';
    color: #1890ff;
    text-align: center;
    vertical-align: middle;
    -webkit-transition: -webkit-transform .3s cubic-bezier(.78, .14, .15, .86);
    transition: -webkit-transform .3s cubic-bezier(.78, .14, .15, .86);
    transition: transform .3s cubic-bezier(.78, .14, .15, .86);
    transition: transform .3s cubic-bezier(.78, .14, .15, .86), -webkit-transform .3s cubic-bezier(.78, .14, .15, .86);
}
.spin-lg .spin-dot{
    font-size: 0.8rem;
    /*margin-bottom: 30%;*/
}
.spin-dot-spin {
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
    -webkit-animation: antRotate 1.2s infinite linear;
    animation: antRotate 1.2s infinite linear;
}
.spin-dot {
    position: absolute;
    display: inline-block;
    font-size: 20px;
    width: 1em;
    height: 1em;
}
.spin-lg .spin-dot i {
    width: 50px;
    height: 50px;
}
.spin-dot-item:nth-child(1) {
    top: 0;
    left: 0;
    opacity: 1;
    background-color: #693;
}
.spin-dot-item:nth-child(2) {
    top: 0;
    right: 0;
    opacity: 1;
    -webkit-animation-delay: .4s;
    animation-delay: .4s;
    background-color: #3e5b81;
}
.spin-dot-item:nth-child(3) {
    right: 0;
    bottom: 0;
    opacity: 1;
    -webkit-animation-delay: .8s;
    animation-delay: .8s;
    background-color: #693;
}
.spin-dot-item:nth-child(4) {
    bottom: 0;
    left: 0;
    opacity: 1;
    -webkit-animation-delay: 1.2s;
    animation-delay: 1.2s;
    background-color: #3e5b81;
}
.spin-dot-item {
    position: absolute;
    display: block;
    width: 9px;
    height: 9px;
    background-color: #669933;
    border-radius: 100%;
    -webkit-transform: scale(.75);
    -ms-transform: scale(.75);
    transform: scale(.85);
    -webkit-transform-origin: 50% 50%;
    -ms-transform-origin: 50% 50%;
    transform-origin: 50% 50%;
    opacity: .3;
    -webkit-animation: antSpinMove 1s infinite linear alternate;
    animation: antSpinMove 1s infinite linear alternate;
}
.tips{
    font-size: 0.3rem;
    margin-bottom: 30%;
    margin-top: 0.5rem;
}

/* new css start */
.filter_box {
  background: #f1f1f1;
  border: 1px solid #ccc;
  display: inline-block;
  width: 100%;
 
  padding: 15px;
  border-radius: 9px;
}
.filter_box .fliter {
    margin-top:0;
    display: flex;
    flex: 1;
    justify-content: space-between;
    align-items: center;
    font-size: 15px;
}

.search-parameter-label + div {
  margin-left: 11px;
  color: #333;
}

.fliter label {
  white-space: nowrap;
  margin-right: 11px;
}
.search-parameter-list {
  margin-top: 15px;
  font-size: 15px;
}
.noUi-connect {
  background: #693 !important;
 
}

.search-parameter-label {
  font-weight: 600;
  width: auto;
  white-space: nowrap;
}

.search-parameter {
  display: flex;
}

.noUi-horizontal .noUi-handle {
  background-color: #693 !important;
}

.col-xs-6.caption {
  color: #000;
}

.filter_box .fliter button.ui-multiselect.ui-widget.ui-state-default.ui-corner-all {
  padding: 10px 12px;
  font-size: 14px;
  font-weight: 500;
  border: none !important;
  color: rgba(114,153,75,0.9);
  margin-right: 10px;
  background: #fff;
  border-radius: 5px;
  text-align: left;
}

#reset {
  background: #693;
  border: none;
  padding: 5px 11px;
  display: inline-block;
  color: #fff;
  font-size: 14px;
font-weight: 500;
text-transform: uppercase;
cursor: pointer;
margin-top: 5px;
margin-bottom: 5px;
}

.search-parameter-list {
  margin-top: 15px;
  font-size: 15px;
  padding: 0 0px 10px;
  border-bottom: 1px solid #f1f1f1;
}

.col-xs-6.text-right.caption {
  text-align: right;
}

.holder > a {
  background: #fff;
  box-shadow: 2px 2px 3px rgba(0,0,0,0.2);
  padding: 0px 11px;
}

body .holder > a:hover{
    background: #3e5b81;
  color: #fff;
}
body .holder {
  margin: 15px 0 24px;
  display: flex;
  justify-content: center;
}

body .holder > a.jp-current {
  background: #3e5b81;
  color: #fff;
}


/*detail page css*/

.detail-top {
    display: flex;
    flex: 1;
    justify-content: space-between;
    flex-wrap: wrap;
}

.detail-property .detail-top .street-view {
    width: 50%;
}

.detail-property .detail-top .detail-form { width: 100%; }

.detail-property .detail-top .detail-data{
    width: 50%;
}

.single-property {
    position: relative;
}

.single-property input[type="checkbox"] {
    position: absolute;
    z-index: 50;
    width: 15px;
    height: 25px;
    margin-left: 7px;
}

.click-here {
    width: 100%;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    background: #eee;
    padding: 10px;
    font-size: 14px;
    color: #3d5a80;
    border-radius: 10px;
}

.click-here button {
    background: #693;
    color: #fff;
    border: none;
    font-size: 14px;
    font-weight: 500;
    text-transform: uppercase;
    cursor: pointer;
    padding: 6px;
    margin-left: 6px;
}

#request_more_info{
  background: #693;
    color: #fff;
    border: none;
    font-size: 14px;
    font-weight: 500;
    text-transform: uppercase;
    cursor: pointer;
    padding: 6px;
    margin-bottom: 20px;
}

.click-here button[disabled] {
    opacity: 0.5
}

.popup-property-form {
    background: rgba(0,0,0,0.5);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 500000;
}

.popup-property-form > div {
    display: flex;
    width: 100%;
     height: 100%; 
    align-items: center;
    justify-content: center;
}

.popup-property-form > div  form {
    background: #fff;
    padding: 15px ;
    max-height: 700px;
    overflow: auto;
    width:580px
}

.popup-property-form > div  form div label {
   width: 100%;
   margin-top:10px 
}

.popup-property-form > div form div span input[type="text"], .popup-property-form > div form div span input[type="email"], .popup-property-form > div form div span textarea  {
    width: 100%;
    border-color: #cecece;
    min-height: 30px;
}
.popup-property-form > div form div.name span {
    width: 50%;
    padding: 0 5px 0 0;
}
.popup-property-form > div form div.name span:last-child {
    padding-right: 0px;
}
.popup-property-form > div form div span {
    width: 100%;
    margin: 0;
}

.popup-property-form input[type="submit"] {
        color: #FFFFFF!important;
    border-width: 0px!important;
    font-size: 15px;
    background-color: #669933!important;
}

.checkbox-pro {
    margin-top: 12px;
}

body .popup-property-form .select-hours,  body .popup-property-form .select-minutes, body .popup-property-form .select-time-format {
  display: flex !important;
  flex-wrap: nowrap;
  margin-right: 13px;
  position: static;
}

.popup-property-form > div  form div {
    display: flex;
    flex-wrap: wrap;
    position: relative;
}

button#close {
    position: absolute;
    right: 4px;
    /* padding-top: 5px; */
    top: 5px;
    background: none;
    border: none;
    padding: 5px;
    cursor: pointer;
}

.popupinner {
    position: relative;
}

.wpcf7-not-valid-tip {
  position: absolute;
  bottom: -25px;
  
}
.wpcf7-form-control-wrap {
    position: static;
}

body .popup-property-form .name div {
  width: 49%;
  display: inline-block !important;
  position: relative;
}

.popup-property-form .email, .popup-property-form .phone {
   position: relative;
}

.popup-property-form .name div span:first-child {
    font-family: Open Sans;
font-size: 11px;
color: #888888;
font-style: normal;
font-weight: 400;
}

.hide-filter-on-mobile {
    margin:10px 0;
}

.hide-filter-on-mobile button {
  background: #693;
  color: #fff;
  border: none;
  font-size: 14px;
  font-weight: 500;
  text-transform: uppercase;
  cursor: pointer;
  padding: 6px;
  margin-left: 6px;
}

@media(min-width:768px) {
    .hide-filter-on-mobile {
      display: none;
    }
}

@media(max-width:767px) {
  .filter_box {
    
  }

  .mobile-toggle {
    display: none;
  }

  .mobile-toggle.open {
    display: block;
    margin-bottom:10px;
    margin-top:10px;
  }

  .filter_box .fliter {
    margin-top: 0 !important;
  }

  .search-parameter {
    display: flex;
    flex-wrap: wrap;
    line-height: 25px;
    margin-bottom: 16px;
  }

  .search-parameter-label + div {
    margin-left: 0;
 }
 body .holder > a {
    display:none;
 }
 body .holder > a.jp-previous,
 body .holder > a.jp-next {
    display: inline;
    padding: 6px;
 }
}

/* new css stop */


@keyframes antRotate{to{-webkit-transform:rotate(405deg)}}


</style>

 <script>
        jQuery(document).ready(function() {
            jQuery('#hide_filter_mobile').click(function() {
                if(jQuery('.mobile-toggle').hasClass('open')){
                  jQuery('.mobile-toggle').removeClass('open')
                }else{
                  jQuery('.mobile-toggle').addClass('open')
                }
            });
        });
    </script>

<script>

  /* Download lazy load plugin and make sure you add it in the head of your page. */

  /* when document is ready */
  jQuery(function() {

    /* initiate plugin */
    jQuery("div.holder").jPages({
        containerID : "itemContainer",
        animation   : "fadeInUp",
        perPage      : 18,
        startPage    : 1,
        startRange   : 1,
        midRange     : 5,
        endRange     : 1
    });
  });
  </script>
<?php

echo '<div class="popup-property-form" style="display:none"><div class="popup-box"><div class="popupinner"> <button color="white" id="close">X</button>'.do_shortcode('[contact-form-7 id="4315" title="Property Form"]').'</div></div></div>';
wp_enqueue_style("jpagecss", get_stylesheet_directory_uri()."/jpage/css/jPages.css");
wp_enqueue_script('jpagecss-script', get_template_directory_uri() . '/jpage/js/jPages.js', array('jquery-ui-core'), null, true);
wp_enqueue_script('loading-script', get_template_directory_uri() . '/js/loading.js', array('jquery-ui-core'), null, true);

the_content();
get_footer();
?>