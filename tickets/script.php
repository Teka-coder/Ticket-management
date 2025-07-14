  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.min.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.min.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  
  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>
  <script src="../assets/js/sweetalert2.min.js"></script>
  <script src="../assets/js/sweetalert2.all.min.js"></script>
  <script src="../assets/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
  <?php 
$rem="Remove";
  ?>
  <script>
const loadUnSelectedValues = function() {
  $('[name="unselected[]"]').remove(); // cleaning all
  $('select[name="accessory[]"] option').each(function() {
    if($(this).is(':selected')) return; // skipping selected
    $('#single_transfer_form2').append('<input type="hidden" name="unselected[]" value="'+$(this).val()+'" />');
  });
}

// init
loadUnSelectedValues();

$('select[name="accessory[]"]').on('change', function() {
    loadUnSelectedValues();
});
    
    function showAlert(){
    var myText='Not available yet';
    alert(myText);
  }   
 function ShowHideFormDiv() {
        var chkAll = document.getElementById("chkAll");
         var chkSel = document.getElementById("chkSel");
        var dvTransfer = document.getElementById("dvTransferform");
        var dvTransfer2 = document.getElementById("dvTransferform2");

        dvTransfer.style.display = chkAll.checked ? "block" : "none";
        dvTransfer2.style.display = chkSel.checked ? "block" : "none";
       

    }
     function ShowHideTransferType() {
        var cAll = document.getElementById("All");
         var cSel = document.getElementById("Sel");
        var transferType1 = document.getElementById("Type1");
        var transferType2 = document.getElementById("Type2");
       //var input=document.getElementById("selectivetype");

        transferType1.style.display = cAll.checked ? "block" : "none";
        transferType2.style.display = cSel.checked ? "block" : "none";
       // input.required=cSel.checked? "true" : "false";

    }
      window.onload = function () {
    for(var f in document.getElementsById("selection_form"))
        f.reset();
}
//     function validateAccessory(){
//        var valid = true;
//          $(".info").html("");
//         $(".input-field").css('border', '#e0dfdf 1px solid');
//       var acc = $("#selective").val();
// if (acc == "") {
//               // $(".info").css('strong', 'color: red;', -1);
//                 $("#inputAcce-info").html("accessory field req*.");
//                 $("#selective").css('border', '#e66262 1px solid');
//                  valid = false;
//             }
//              return valid;
//     }
     function SelectType() {
     
         var search = document.getElementById("search");
        var selectdiv = document.getElementById("selectDiv");
        var searchdiv = document.getElementById("searchDiv");
        var selectitem=document.getElementById("selectItem");
        var searchitem=document.getElementById("searchItem");
  if (search.checked == true){
         selectdiv.classList.add("d-none");
         searchdiv.classList.remove("d-none");
         selectitem.value="";
         selectitem.required=false;
         searchitem.required=true;
         
  
  }else{ 
    searchdiv.classList.add("d-none");
    selectdiv.classList.remove("d-none");
    searchitem.value="";
    selectitem.required=true;
    searchitem.required=false;
  
   
  }

    }
function accessoryFunction() {
  var checkBox = document.getElementById("accessoryCheck");
  if (checkBox.checked == true){
         document.getElementById("accessorydiv").classList.remove("d-none");
        // document.getElementById("accessory_name_1").required = true;
        //  document.getElementById("accessory_SN_1").required = true;
        //   document.getElementById("accessory_status_1").required = true;
  
  }else{ 
    document.getElementById("accessorydiv").classList.add("d-none");
    // document.getElementById("accessory_name_1").required = false;
    // document.getElementById("accessory_SN_1").required = false;
    // document.getElementById("accessory_status_1").required = false;
  }
}
function componentFunction() {
  var checkBox = document.getElementById("componentCheck");
  if (checkBox.checked == true){
         document.getElementById("componentsdiv").classList.remove("d-none");
  
  }else{ 
    document.getElementById("componentsdiv").classList.add("d-none");
  }
}
function cameraFunction() {
  var checkBox = document.getElementById("cameraCheck");
  if (checkBox.checked == true){
         document.getElementById("cameradiv").classList.remove("d-none");
  }else{ 
    document.getElementById("cameradiv").classList.add("d-none");
  }
}
var temp_camera = document.getElementById("camera_0").innerHTML;
var counter_camera = 1;
function initiateMore() {
  counter_camera++;
  const div = document.createElement("div");
  div.className = "row";
  div.innerHTML = "<hr>"+temp_camera.replaceAll("_1","_"+counter_camera)+"<span class='col-1' onclick='removeCamera(this)'><i class='btn btn-danger bi bi-trash' ></i></span>";
    document.getElementById("custom-camera-container").append(div);
          }
function removeCamera(minusElement){
   minusElement.parentElement.remove();
}
function importcsv() {
  var checkBox = document.getElementById("csvCheck");
  if (checkBox.checked == true){
         document.getElementById("csvdiv").classList.remove("d-none");
  
  }else{ 
    document.getElementById("csvdiv").classList.add("d-none");
  }
}


// function addMore(){
//       var new_chq_no = parseInt($('#total_chq').val())+1;
//       var new_input="<input type='text' id='new_"+new_chq_no+"'>";
//       $('#new_chq').append(new_input);
//       $('#total_chq').val(new_chq_no)
//     }
// function removeField(){
//       var last_chq_no = $('#total_chq').val();
//       if(last_chq_no>1){
//         $('#new_'+last_chq_no).remove();
//         $('#total_chq').val(last_chq_no-1);
//       }
//     }

function fill_modal2(){
 var modal=document.getElementById('cardBody');
 var xhr =new XMLHttpRequest();
 xhr.onload=function(){
   modal.innerHTML=xhr.responseText;
 }
 xhr.open("GET","add-accessories-view.php?modal=''");
 xhr.send();
}
function showRecentTransfer(){
 var modal=document.getElementById('cardBody');
 var xhr =new XMLHttpRequest();
 xhr.onload=function(){
   modal.innerHTML=xhr.responseText;
 }
 // xhr.open("GET","all-transfer-by-item.php?modal=''");
 // xhr.send();
}
function delete_record(e){

Swal.fire({
  title: 'Are you sure to delete '+e.name+'?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {

let xhr=new XMLHttpRequest();
xhr.onload=function(){
}
xhr.open("GET","delete-items-action.php?delete_item="+e.id)
xhr.send();
    Swal.fire('Deleted!', e.name+' has been deleted.','success')

  }

})
}
function roll_back(e){

Swal.fire({
  title: 'Are you sure to deactivate '+e.name+'?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, reset it!'
}).then((result) => {
  if (result.isConfirmed) {

let xhr=new XMLHttpRequest();
xhr.onload=function(){
}
xhr.open("POST","roll-back-action.php?roll_item="+e.id)
xhr.send();
    Swal.fire('Status reset!', e.name+' is now Out of use','success')

  }

})
}
function printQrcode(e){
  Swal.fire({
  title: e.name,
  text: 'You can scan here!',
  imageUrl: '../QR_code/'+e.id,
  imageWidth: 400,
  imageHeight: 400,
  imageAlt: 'Qr code of'+e.name,
})
    }
//     window.onload = function () {
//   var form = document.getElementById('form1');
//   form.button.onclick = function (){
//     for(var i=0; i < form.elements.length; i++){
//       if(form.elements[i].value === '' && form.elements[i].hasAttribute('required')){
//         alert('There are some required fields!');
//         return false;
//       }
//     }
//     form.submit();
//   }; 
// };
 function validateAddForm() {
            var valid = true;

            $(".info").html("");
            $(".input-field").css('border', '#e0dfdf 1px solid');
            var asset = $("#inputAsset").val();
             var ware = $("#inputWH").val();
            var sn = $("#inputSN").val();
            var custodian = $("#inputCustodian").val();
            var tagpn = $("#inputTagPn").val();
            var comp = $("#inputCompany").val();
            var checkBox = document.getElementById("accessoryCheck");
            var compcheckBox = document.getElementById("componentCheck");
            var accname = $("#accessory_name_1").val();
            var accsn=$("#accessory_SN_1").val();
            var desc=$("#inputDesc").val();
            var name=$("#inputItemname").val();
            var compname=$("#component_name_1").val();
            var compdesc=$("#component_desc_1").val();
            if (asset == "") {
              // $(".info").css('strong', 'color: red;', -1);
                $("#inputAsset-info").html("Asset type req*");
                $("#inputAsset").css('border', '#e66262 1px solid');
                valid = false;
            }
            if (sn == "") {
                $("#inputSN-info").html("Serial number req*");
                $("#inputSN").css('border', '#e66262 1px solid');
                valid = false;
            }
             if (ware == "") {
                $("#inputWH-info").html("Warehouse req*");
                $("#inputWH").css('border', '#e66262 1px solid');
                valid = false;
            }
            // if (!sn.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/))
            // {
            //     $("#inputSN-info").html("Invalid Serial Number.");
            //     $("#inputSN").css('border', '#e66262 1px solid');
            //     valid = false;
            // }

            if (custodian == "") {
                $("#inputCustodian-info").html("Custodian field req*");
                $("#inputCustodian").css('border', '#e66262 1px solid');
                valid = false;
            }
            if (tagpn == "") {
                $("#inputTagPn-info").html("TAG/PN req*");
                $("#inputTagPn").css('border', '#e66262 1px solid');
                valid = false;
            }
            if (checkBox.checked==true) {
                if (accsn == "") {
                $("#acc-info").html("Field with red box can't be empty !");
                $("#accessory_SN_1").css('border', '#e66262 1px solid');
                valid = false;
            }
                if (accname == "") {
                $("#acc-info").html("Field with red box can't be empty !");
                $("#accessory_name_1").css('border', '#e66262 1px solid');
                valid = false;
            }
            }
                 if (compcheckBox.checked==true) {
                if (compname == "") {
                $("#comp-info").html("Field with red box can't be empty !");
                $("#component_name_1").css('border', '#e66262 1px solid');
                valid = false;
            }
                if (compdesc == "") {
                $("#comp-info").html("Field with red box can't be empty !");
                $("#component_desc_1").css('border', '#e66262 1px solid');
                valid = false;
            }
            }
         
             if (comp == "") {
                $("#company-info").html("Company req*");
                $("#inputCompany").css('border', '#e66262 1px solid');
                valid = false;
            }
            if (desc == "") {
                $("#inputDesc-info").html("Description req*");
                $("#inputDesc").css('border', '#e66262 1px solid');
                valid = false;
            }
                 if (name == "") {
                $("#inputName-info").html("Item name req*");
                $("#inputItemname").css('border', '#e66262 1px solid');
                valid = false;
            }
            return valid;
        }


function resetStatus(e){

Swal.fire({
  title: 'Reset status to Active?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, reset it!'
}).then((result) => {
  if (result.isConfirmed) {

let xhr=new XMLHttpRequest();
xhr.onload=function(){
}
xhr.open("GET","reset-action.php?reset_item="+e.id)
//window.location=e.name;
xhr.send();

    Swal.fire(
      'Reset!',
      e.value+' Status has been reset.',
      'success',
      
    ).then(function() {
      location.reload();
    })
  }
    else{
        Swal.fire(
        "Thanks!",
        "Status not reset!",
        "error"
        ).then((result)=>{
          location.reload();
        })
        }
})
}

</script>
