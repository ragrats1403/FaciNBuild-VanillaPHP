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

function removeChild(){
    const myNode =  document.getElementById('container1');
    while (myNode.firstChild) {
    myNode.removeChild(myNode.lastChild);
  }

}

function removeAddedEq(){
    const myNode =  document.getElementById('container2');
    while (myNode.firstChild) {
    myNode.removeChild(myNode.lastChild);
    }
}


//dynamic add option inside div
$(document).on('click', '.addresBtn', function(event){
    //var value = document.getElementById("id").value;
    //alert("test");
    //var quantitytxt = eq.value;
    var id = $(this).data('id');
    var nid = 'a'+id;
    var hiddenid = 'h'+id;
    var hiddeneqn = 'e'+id;
    var hiddenval = 'v'+id;
    var hiddenfaci = 'f'+id;
    var value = document.getElementById(nid).value;
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
    

});


  


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



//modal events




$("#reserModal").on("hidden.bs.modal", function () {
    const myNode =  document.getElementById('container2');
    while (myNode.firstChild) {
    myNode.removeChild(myNode.lastChild);
    }
    $('#testtable').DataTable().clear().destroy();
    
  });