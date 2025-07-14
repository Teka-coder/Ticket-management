  <?php 
  include '../connection.php';


?> 

   <div class="alert alert-success fade show col-sm-12 col-md-6 col-lg-12 col-xl-12 row" role="alert" style="margin:5px">
  
   <div class="col-sm-12 col-md-6 col-lg-8 col-xl-8" >
                <h5 class="card-title">Fill out all the required field carefully!</h5>
                <span class="text-danger">Fields with (*) are required</span> 
              </div>
              <div class="row col-sm-12 col-md-6 col-lg-4 col-xl-4">
          <div class="col-sm-12 col-md-6 col-lg-12 col-xl-12">                          
               <div class="input-group-desc">
               <!--  <label for="csvCheck" class="form-label"><b>Upload CSV file</b></label> -->
                <label class="form-check-label text-primary" for="csvCheck">
               <input class="form-check-input" type="checkbox" onclick="importcsv()" id="csvCheck" wfd-id="id9">
                <b>Upload CSV</b>
                </label>
                  </div>
       </div>
          
         
  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none" id="csvdiv" >
 <form action="import-csv.php" method="post" enctype="multipart/form-data">
   <div class="row">
    <!--  <label for="inputcsv" class="form-label col-sm-12 col-md-12 col-lg-12 col-xl-12"><b>Ticket Excel Form</b></label> -->
  <div class="col-sm-12 col-md-6 col-lg-9 col-xl-9">
  <input type="file" class="form-control" id="inputcsv" name="csvfile" style="margin-bottom: 5px;" >
  </div>
              
   <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3"> 
     <button type="submit" name="import" class="btn btn-success rounded-pill">Import</button>
   </div>
 </div>
</form>
                  </div>
                 
    </div>
  </div>
 
   
              <!-- session alerts here -->
 <form class="row g-3" method="POST" enctype="multipart/form-data" action="add-items-action.php" name="frmAdd" onsubmit="return validateAddForm()" id="form1" autocomplete="on">

  <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
  <label for="inputItemname" class="form-label"><b>Ticket ID</b></label>
  <span id="inputName-info" class="info text-danger">*</span><br />
  <input type="text" class="form-control" id="inputItemname" name="ticketid" >
  </div>
  <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
  <label for="inputCity" class="form-label"><b>Price</b></label>
  <input type="number" class="form-control" id="inputAcquisition" name="ticketprice" min="0">
  </div>

  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
  <label for="inputDesc" class="form-label"><b>General Remark (VIP/Normal)</b></label>
   <span id="inputDesc-info" class="info text-danger">*</span><br />
  <textarea class="form-control" id="inputDesc" name="generalremark" placeholder="Write remark here..eg(VIP,Normal)" ></textarea>
  </div>
<hr>
  
  <div class="text-center">
    <button type="submit" class="btn btn-primary" name="submit" style="float: right; cursor: pointer;">Add Ticket</button>
    <button type="reset" class="btn btn-secondary" style="float: right; margin-right: 10px; cursor: pointer;">Clear</button>
  </div>
</form><!-- End Multi Columns Form -->

<script type="text/javascript">
  var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();

if (dd < 10) {
   dd = '0' + dd;
}

if (mm < 10) {
   mm = '0' + mm;
} 
    
today = yyyy + '-' + mm + '-' + dd;
document.getElementById("inputacqdate").setAttribute("max", today);
document.getElementById("inputexp").setAttribute("max", "2028-01-01");
document.getElementById("inputacqdate").setAttribute("min", today);
document.getElementById("inputexp").setAttribute("min", "2024-01-01");

var temp_item = document.getElementById("item_0").innerHTML;
var temp_comp = document.getElementById("comp_0").innerHTML;
//var targetinput = document.getElementById("item_0").getElementsByClassName("input-acc")[0];
//var targetinput = document.getElementsByClassName("input-acc");
var counter_item = 1;
function addMore() {
  counter_item++;
 // const hr=document.createElement("hr");
 // hr.innerHTML="<span class='moreacc-info info text-danger'>*</span><br />";
  const div = document.createElement("div");
  div.className = "row";
  div.innerHTML = "<hr>"+temp_item.replaceAll("_1","_"+counter_item)+"<span class='col-1' onclick='removeField(this)'><i class='btn btn-danger bi bi-trash' ></i></span>";
   //document.getElementById("custom-input-container").append(hr);
    document.getElementById("custom-input-container").append(div);
          }
function removeField(minusElement){
   minusElement.parentElement.remove();
}
var counter_comp=1;
function addMore2() {
  counter_comp++;
 // const hr=document.createElement("hr");
 // hr.innerHTML="<span class='moreacc-info info text-danger'>*</span><br />";
  const div = document.createElement("div");
  div.className = "row";
  div.innerHTML = "<hr>"+temp_comp.replaceAll("_1","_"+counter_comp)+"<span class='col-1' onclick='removeButton(this)'><i class='btn btn-danger bi bi-trash' ></i></span>";
   //document.getElementById("custom-input-container").append(hr);
    document.getElementById("custom-input-container2").append(div);
          }
function removeButton(minusElement){
   minusElement.parentElement.remove();
}
</script>

 