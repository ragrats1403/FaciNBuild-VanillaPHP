/*$("#reserModal").on('shown.bs.modal', function () {
    alert('The modal is fully shown.');
});
*/
//dynamic fetch data with drop down menu
function dynamicEq(){
    const myNode =  document.getElementById('container2');
    while (myNode.firstChild) {
    myNode.removeChild(myNode.lastChild);
    }
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

        //removeChild();
}
//test container remove
function removeChild(){
    const myNode =  document.getElementById('container1');
    while (myNode.firstChild) {
    myNode.removeChild(myNode.lastChild);
  }

}


//remove [Equipments meant to be added to reservation]
function removeAddedEq(){
    const myNode =  document.getElementById('container2');
    while (myNode.firstChild) {
    myNode.removeChild(myNode.lastChild);
    }
}


//dynamic add and list the equipment chosen to reservation the inside div
$(document).on('click', '.addresBtn', function(event){
    //var value = document.getElementById("id").value;
    //alert("test");
    //var quantitytxt = eq.value;
    var id = $(this).data('id');
    var nid = 'a'+id;
    var hiddenid = 'fbh'+id;
    var hiddeneqn = 'fbe'+id;
    var hiddenval = 'fbv'+id;
    var hiddenfaci = 'fbf'+id;
    var value = document.getElementById(nid).value;
    //var checkval = document.getElementById("hid").value;
    if(document.getElementById(hiddenid)==null){
        $.ajax({
            url: "functions/getequipment.php",
            data: {
                id:id,
            },
            type: 'POST',
            success: function(data) {
                var json = JSON.parse(data);
                var eqname = json.equipmentname;
                var container = document.getElementById('container2');
                var newDiv = document.createElement('div');
                var divCol = document.createElement('div');
    
                //variables for hidden inputs for getting values
                var hid = document.createElement('input');
                var heqname = document.createElement('input');
                var hvalue = document.createElement('input');
                var hfaci = document.createElement('input');
                
                //assigning attributes and values to each variable[to get them for backend]
            
                hid.type = 'hidden';
                hid.id = hiddenid;
                hid.value = json.id;
    
                heqname.type = 'hidden';
                heqname.id = hiddeneqn;
                heqname.value = json.equipmentname;
    
                hvalue.type = 'hidden';
                hvalue.id = hiddenval;
                hvalue.value = value;
    
                hfaci.type = 'hidden';
                hfaci.id = hiddenfaci;
                hfaci.value = json.facility;
    
                
    
    
                divCol2 = document.createElement('div');
                newDiv.className = "row";
                divCol.className = "col-md-2";
                divCol2.className = "col-md-2";
                var btn = document.createElement('button');
                btn.className = "btn btn-sm btn-danger removeEq"+value;
                btn.setAttribute("onclick","removeAddedEq();");
                btn.style.marginTop = '3px';
                btn.innerHTML = "Remove";
                var textbox = document.createElement('text');
                //var joinedtxt = json.equipmentname + '';
                textbox.className = "form-control input-sm col-xs-1 disabled";
                textbox.innerHTML = eqname +' x '+ value;
    
    
                divCol.appendChild(textbox);
                divCol2.appendChild(btn);
                newDiv.appendChild(divCol);
                newDiv.appendChild(divCol2);
                container.appendChild(newDiv);
                container.appendChild(hid);
                container.appendChild(heqname);
                container.appendChild(hvalue);
                container.appendChild(hfaci);
                
    
            }
        }); 
    }
    else{
        alert("This equipment is already added to the reservation form!");
    }
    
    

});
function testClick(){

var testarr = [...document.querySelectorAll('[id^="fbh"]')].map(elm => elm.id);
var testarr2 = [...document.querySelectorAll('[id^="fbe"]')].map(elm => elm.id);
var testarr3 = [...document.querySelectorAll('[id^="fbv"]')].map(elm => elm.id);
for(i = 0; i<=testarr.length-1; i++ ){

    
    console.log(document.getElementById(testarr[i]).value);
    console.log(document.getElementById(testarr2[i]).value);
    console.log(document.getElementById(testarr3[i]).value);
    

}
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

    if (checkbox.checked == true) {
        button.classList.remove("disabled");
    }
    else {
        button.classList.add("disabled");
    }
}

//add ons click
function myFunction(divId) {
    var x = document.getElementById(divId);
    if (x.style.display === "block") {
        x.style.display = "none";
    } else {
        x.style.display = "block";
    }
    var now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('dateminor').value = now.toISOString().substring(0,10);
}

//modal events

$("#reserModal").on("hidden.bs.modal", function () {
    const myNode =  document.getElementById('container2');
    while (myNode.firstChild) {
    myNode.removeChild(myNode.lastChild);
    }
    $('#testtable').DataTable().clear().destroy();
    
  });

  



