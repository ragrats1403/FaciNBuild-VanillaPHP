$("#reserModal").on('shown.bs.modal', function () {
    alert('The modal is fully shown.');
});


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
"bJQueryUI": true,
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
    'target': [0, 3],
    'orderable': false,
}],
scrollY: 200,
scrollCollapse: true,
paging: false 

});
}



//dynamic add option inside div
function addOption(){
    var container = document.getElementById('container');
    var select = document.createElement('select');
    select.className = "form-control input-sm col-xs-1";
    for(i = 0, i<=5; i++;){
        var option = document.createElement('option');
        option.innerHTML = i;
        select.appendChild(option);
    }
    container.appendChild(select);
    
    }   


