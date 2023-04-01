/*$("#reserModal").on('shown.bs.modal', function () {
    alert('The modal is fully shown.');
});
*/

//dynamic fetch data with drop down menu
function dynamicEq(){
var e = document.getElementById("faci");
var faci = e.options[e.selectedIndex].text;
$('#testtable').DataTable().clear().destroy();
$('#testtable').DataTable({
'searching':false,
'autoWidth': false,
'serverSide': true,
'processing': true,
'bJQueryUI': true,
'info': false,
'paging': true,
'order': [],
'ajax': {
    'url': 'functions/fetch_eq.php',
    'type': 'post',
    'data':{
        faci:faci,
    },
},
'fnCreatedRow': function(nRow, aData, iDataIndex) {
    $(nRow).attr('id', aData[0]);
},
'columnDefs': [{
    'target': [0, 2],
    'orderable': false,
}],
scrollY: 200,
scrollCollapse: true,
paging: false 

});
}



//dynamic add option inside div
$(document).on('click', '.addBtn', function(event){
    //var value = document.getElementById("id").value;
    //alert("test");
    //var quantitytxt = eq.value;
    var id = $(this).data('id');
    var value = document.getElementById(id).value;

    $.ajax({
        url: "functions/getequipment.php",
        data: {
            id:id,
        },
        type: 'POST',
        success: function(data) {
            var json = JSON.parse(data);
            var eqname = json.equipmentname;
            var container = document.getElementById('container');
            var newDiv = document.createElement('div');
            newDiv.className = "row justify-content-center";
            var btn = document.createElement('button');
            btn.className = "btn btn-sm btn-danger remove"+value;
            //btn.value = "Remove";
            var textbox = document.createElement('text');
            //var joinedtxt = json.equipmentname + '';
            textbox.className = "form-control input-sm col-xs-1 disabled";
            textbox.innerHTML = eqname +' x '+ value;
            newDiv.appendChild(textbox);
            newDiv.appendChild(btn);
            container.appendChild(newDiv);

        }
    });
    

});



function addOption(){
        
    


/*
    var container = document.getElementById('container');
    var textbox = document.createElement('text');
    textbox.className = "form-control input-sm col-xs-1 disabled";
    //textbox.disabled = true;
        //var option = document.createElement('option');
    textbox.innerHTML = "test";
        //select.appendChild(option);
  
    container.appendChild(textbox);
   */ 
}   


//date auto fill
var now = new Date();
now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
document.getElementById('datefiled').value = now.toISOString().substring(0,10);
//date end

//terms and conditions checkbox
function updateButtonState() {
    var checkbox = document.getElementById("termscond");
    var button = document.getElementById("termscond-create");

    if (checkbox.checked) {
        button.classList.remove("disabled");
    } else {
        button.classList.add("disabled");
    }
}