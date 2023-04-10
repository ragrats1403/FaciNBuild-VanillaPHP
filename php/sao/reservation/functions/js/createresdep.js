/*$("#reserModal").on('shown.bs.modal', function () {
    alert('The modal is fully shown.');
});
*/

function computedaysdiff(d1, d2){
    var date1 = new Date(d1);
    var date2 = new Date(d2);

    var diffInMilliseconds = Math.abs(date2 - date1);
    var diffInDays = Math.ceil(diffInMilliseconds / (1000 * 60 * 60 * 24));

    //console.log(diffInDays);

    return diffInDays;
}


function checkdateconflict(adate, timestart, timeend, facility, callback) {
    var actualdate = adate;
    var tstart = timestart;
    var tend = timeend;
    var faci = facility;

    $.ajax({
        url: "functions/checkdateconflict.php",
        data: {
            facility: faci,
            actualdate: actualdate,
            timestart: tstart,
            timeend: tend,
        },
        type: 'POST',
        success: function(data) {
            var json = JSON.parse(data);

            if (json.countval > 0) {
                callback(true);
            } else {
                callback(false);
            }
        }
    });
}
function checkReservationConflict(timestart, timeend, adate, rfacility, callback) {
    var tstart = timestart;
var tend = timeend;
const date = new Date(adate);
var actualdate = adate;
var facility = rfacility;

// convert date and time values to strings
const datestartString = `${date.toISOString().substr(0, 10)}T${tstart}`;
const dateendString = `${date.toISOString().substr(0, 10)}T${tend}`;

$.ajax({
    url: "functions/checkresconflict.php",
    data: {
        datestart: datestartString,
        dateend: dateendString,
        actualdate: actualdate,
        facility: facility,
    },
    type: 'POST',
    success: function(data) {
        var json = JSON.parse(data);
        console.log(json.tcount);
        if (json.tcount > 0) {
            callback(true);
        } else {
            callback(false);
        }
    }
});
}
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
        "bPaginate": false,
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
function removeAddedEq(e){

    e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
}

function removeAddedEq2(){
    e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode); 
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
            url: "functions/addselectedeq.php",
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
                btn.className = "btn btn-sm btn-danger removeEq";
                btn.id = "btn"+value;
                btn.setAttribute("onClick","removeAddedEq(this);");
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
                newDiv.appendChild(hid);
                newDiv.appendChild(heqname);
                newDiv.appendChild(hvalue);
                newDiv.appendChild(hfaci);
                container.appendChild(newDiv);

                
    
            }
        }); 
    }
    else{
        alert("This equipment is already added to the reservation form!");
    }
    
    

});


//date auto fill
var now = new Date();
now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
document.getElementById('datefiled').value = now.toISOString().substring(0,10);
//date end

function bodyonload(){
        //date auto fill
    var now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('datefiled').value = now.toISOString().substring(0,10);
    //date end

}
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
function myFunction(divID) {
    var x = document.getElementById(divID);
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
  
  
  $("#test").on("hidden.bs.modal", function () {
    const myNode =  document.getElementById('container4');
    while (myNode.firstChild ) {
    myNode.removeChild(myNode.lastChild);
        
            var x = document.getElementById("_myDIV");
            x.style.display = "none";
            document.getElementById("_dept").disabled = true //department
            document.getElementById("_dateresm").disabled = true //date
            document.getElementById("_minorqres").disabled = true //quantity
            document.getElementById("_minoritemres").disabled = true//itemname
            document.getElementById("_minoritemdesc").disabled = true//itemdescription
            document.getElementById("_minorpurpose").disabled = true//purpose
            $("#_dept").val('');
            $("#_dateresm").val('');
            $("#_minorqres").val('');
            $("#_minoritemres").val('');
            $("#_minoritemdesc").val('');
            $("#_minorpurpose").val('');
            document.getElementById("_flexCheckDefault").checked = true;
    }
    
  });



  



