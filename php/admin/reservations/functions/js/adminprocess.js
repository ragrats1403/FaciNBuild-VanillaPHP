//table display start
        var dpt = "<?php echo $_SESSION['department'];?>";
        $('#datatable').DataTable({
    'serverSide': true,
    'processing': true,
    'paging': true,
    'order': [],
    'responsive': true,
    'ajax': {
        'url': 'functions/fetch_data.php',
        'type': 'post',
        'data': {
            'dpt': dpt,
        },
    },
    'fnCreatedRow': function(nRow, aData, iDataIndex) {
        $(nRow).attr('id', aData[0]);
        if (aData[6] === 'Approved') {
            $(nRow).css('background-color', '#a7d9ae');
        }
        if (aData[6] === 'Declined') {
            $(nRow).css('background-color', '#e09b8d');
        }
        if (aData[6] === 'Pending') {
            $(nRow).css('background-color', '#d9d2a7');
        }
    },
    'columnDefs': [{
        'targets': [0, 4],
        'orderable': false,
    }],
    scrollY: 670,
    'scrollCollapse': true,
    'paging': false,
});
//table display end

//edit button control
$(document).on("click", ".editBtn", function (event) {
  var id = $(this).data("id");
  var trid = $(this).closest("tr").attr("reservationid");
  const myNode =  document.getElementById('container4');
    while (myNode.firstChild ) {
    myNode.removeChild(myNode.lastChild);
  } 
  document.getElementById("_flexCheckDefault").checked = false;
  document.getElementById("_facility").disabled = true;
  document.getElementById("_eventname").disabled = true;
  document.getElementById("_datefiled").disabled = true;
  document.getElementById("_actualdate").disabled = true;
  document.getElementById("_timein").disabled = true;
  document.getElementById("_timeout").disabled = true;
  document.getElementById("_reqparty").disabled = true;
  document.getElementById("_purpose").disabled = true;
  document.getElementById("_numparticipants").disabled = true;
  document.getElementById("_stageperformers").disabled = true;
  document.getElementById("_adviser").disabled = true;
  document.getElementById("_chairdeandep").disabled = true;
  var x = document.getElementById("_myDIV1");
  x.style.display = "none";

  $.ajax({
    url: "functions/get_reservation_details.php",
    data: {
      id: id,
    },
    type: "POST",
    success: function (data) {
      var json = JSON.parse(data);
      var x = document.getElementById("_facility");
      var option = document.createElement("option");
      option.text = json.facility;
      option.hidden = true;
      option.disabled = true;
      option.selected = true;
      x.add(option);
      $("#trid").val(trid);
      $("#_ID").val(id);
      //$("#_facility").val(json.facility);
      $("#_eventname").val(json.eventname);
      $("#_datefiled").val(json.datefiled);
      $("#_actualdate").val(json.actualdateofuse);
      $("#_timein").val(json.timestart);
      $("#_timeout").val(json.timeend);
      $("#_reqparty").val(json.requestingparty);
      $("#_purpose").val(json.purposeofactivity);
      $("#_numparticipants").val(json.participants);
      $("#_stageperformers").val(json.stageperformers);
      $("#_adviser").val(json.adviser);
      $("#_chairdeandep").val(json.chairperson);
      $("#_statustext").val(json.status);
      $("#_step1").val(json.fdstatus);
      $("#_step2").val(json.saostatus);
      if(json.status = "Approved")
      {
        document.getElementById("appAllBtn").hidden = true;
        document.getElementById("decAllBtn").hidden = true;
        document.getElementById("step1a").hidden = true;
        document.getElementById("step1d").hidden = true;
        document.getElementById("step2a").hidden = true;
        document.getElementById("step2d").hidden = true;
      }
      $("#test").modal("show");
        var en = json.eventname;
        var adu = json.actualdateofuse; 
        var rp = json.requestingparty;
            $.ajax({
                url: "functions/get_addon_details.php",
                data: {
                eventname: en,
                actualdate: adu,
                reqsource: rp,
                },
                type: "POST",
                success: function (data) {
                var jsonfaddon = JSON.parse(data);           
                  if(jsonfaddon!=null){ 
                    document.getElementById("_flexCheckDefault").checked = true;
                    var x = document.getElementById("_myDIV1");
                    x.style.display = "block";
                    document.getElementById("_dept").disabled = true //department
                    document.getElementById("_dateresm").disabled = true //date
                    document.getElementById("_minorqres").disabled = true //quantity
                    document.getElementById("_minoritemres").disabled = true//itemname
                    document.getElementById("_minoritemdesc").disabled = true//itemdescription
                    document.getElementById("_minorpurpose").disabled = true//purpose
                    $("#_dept").val(jsonfaddon.department);
                    $("#_dateresm").val(jsonfaddon.datesubmitted);
                    $("#_minorqres").val(jsonfaddon.quantity);
                    $("#_minoritemres").val(jsonfaddon.item);
                    $("#_minoritemdesc").val(jsonfaddon.item_desc);
                    $("#_minorpurpose").val(jsonfaddon.purpose);
                    $("#_addonstat").val(jsonfaddon.bdstatus);
                    $("#_addonID").val(jsonfaddon.minorjobid);
                  }
                },
            });
          var eqdatesubmit = json.datefiled;
          var tstart = json.timestart;
          var tend = json.timeend;
          var dateuse = json.actualdateofuse;  



          $.ajax({
            url: "functions/getequipment.php",
            data: {
                eventname: en,
                actualdate: dateuse,
                datesubmitted: eqdatesubmit,
                timestart: tstart,
                timeend: tend,
            },
            type: "POST",
            success: function(data) {
                var jsonreseq = JSON.parse(data);
                var len = data.length;
        
                for (var i = 0; i < len - 1; i++) {
                    var equipn = jsonreseq[i][0];
                    var equipq = jsonreseq[i][1];
                    var container = document.getElementById('container4');
                    var newDiv = document.createElement('div');
                    var divCol = document.createElement('div');
                    var nid = jsonreseq[i][1];
                    divCol2 = document.createElement('div');
                    newDiv.className = "row";
                    divCol.className = "col-md-2";
                    divCol2.className = "col-md-2";
                    var btn = document.createElement('button');
                    var uniqueID = "fbe" + i + "_" + nid;
                    btn.className = "btn btn-sm btn-danger disabled removeEq";
                    btn.id = uniqueID;
                    btn.setAttribute("onclick","removeAddedEq2(this);");
                    btn.style.marginTop = '3px';
                    btn.innerHTML = "Remove";
                    var textbox = document.createElement('text');
                    textbox.className = "form-control input-sm col-xs-1 disabled";
                    textbox.innerHTML = equipn + ' x ' + equipq;
        
                    divCol.appendChild(textbox);
                    divCol2.appendChild(btn);
                    newDiv.appendChild(divCol);
                    newDiv.appendChild(divCol2);
                    container.appendChild(newDiv);
                }
            },
        });

    },
  });
  //$('#test').modal('show');
});


//closeinfomodal
$("#closemodal").click(function () {
  $("#myModal").modal("hide");
});

//create reservation

$(document).on("click", ".submitBtn", function (event) {
  event.preventDefault();
  var eventname = $("#eventname_").val();
  var datefiled = $("#datefiled").val();
  var actualdate = $("#actualdate").val();
  var timein = $("#timein").val();
  var timeout = $("#timeout").val();
  var reqparty = $("#reqparty").val();
  var purpose = $("#purpose").val();
  var numparticipants = $("#numparticipants").val();
  var stageperf = $("#stageperformers").val();
  var adviser = $("#adviser").val();
  var chairman = $("#chairdeandep").val();
  var e = document.getElementById("faci");

  var faci = e.options[e.selectedIndex].text;
    if(computedaysdiff(datefiled, actualdate) <= 4 )
    {
      var computeval = computedaysdiff(datefiled, actualdate);
      alert("Please Note that you need to reserve 5 days before the desired reservation day\nReservation Day(s) Count:"+computeval+" Day(s) Away.");
    }
    else
    {
    }

    checkdateconflict(actualdate, timein, timeout, faci, function(confirm) {
      if (confirm) {
          // do something if there is a conflict
            checkReservationConflict(timein, timeout, actualdate, faci, function(result) {
              // Do something with the result, which will be a boolean value
              if (result) {
                  // Handle case where there is a conflict
                  alert("Someone is using the facility within that time! \nCheck Calendar of Activities for approved schedules. ");
              } else {
                  // Handle case where there is no conflict
                  if (
                    eventname != "" &&
                    datefiled != "" &&
                    actualdate != "" &&
                    timein != "" &&
                    timeout != "" &&
                    reqparty != "" &&
                    purpose != "" &&
                    numparticipants != "" &&
                    stageperf != "" &&
                    adviser != "" &&
                    chairman != ""
                  ) {
                    $.ajax({
                      url: "functions/add_data.php", 
                      data: {
                        eventname: eventname,
                        datefiled: datefiled,
                        actualdate: actualdate,
                        timein: timein,
                        timeout: timeout,
                        reqparty: reqparty,
                        purpose: purpose,
                        numparticipants: numparticipants,
                        stageperf: stageperf,
                        adviser: adviser,
                        chairman: chairman,
                        faci: faci,
                      },
                      type: "POST",
                      success: function (data) {
                        var json = JSON.parse(data);
                        var status = json.status;
                        if ((status = "success")) {
                          //equipment additionals
                            var testarr = [...document.querySelectorAll('[id^="fbh"]')].map(
                              (elm) => elm.id
                            );
                            var testarr2 = [...document.querySelectorAll('[id^="fbe"]')].map(
                              (elm) => elm.id
                            );
                            var testarr3 = [...document.querySelectorAll('[id^="fbv"]')].map(
                              (elm) => elm.id
                            );
                            for (i = 0; i <= testarr.length - 1; i++) {
                              var eid = document.getElementById(testarr[i]).value; //id
                              var ename = document.getElementById(testarr2[i]).value; //name
                              var eqval = document.getElementById(testarr3[i]).value; //value
                              $.ajax({
                                url: "functions/addeqreserve.php",
                                data: {
                                  eventname: eventname,
                                  dateofusage: actualdate,
                                  datesubmitted: datefiled,
                                  timestart: timein,
                                  timeend: timeout,
                                  quantity: eqval,
                                  facility: faci,
                                  eqid: eid,
                                  eqname: ename,
                                },
                                type: "POST",
                                success: function (data) {
                                  var eqjson = JSON.parse(data);
                                  var status = eqjson.status;
                                  if (status == "success") {
                                    console.log("equipment added to reservation!");
                                    var checkbox = document.getElementById("flexCheckDefault");
                                    if (checkbox.checked == true) {
                                      var department = $("#_department").val();
                                      var date = $("#dateminor").val();
                                      var quantity = $("#_quantity_").val();
                                      var itemname = $("#_item_").val();
                                      var description = $("#_itemdesc_").val();
                                      var purpose = $("#_purpose_").val();
                                      $.ajax({
                                        url: "functions/addons.php",
                                        data: {
                                          department: department,
                                          date: date,
                                          quantity: quantity,
                                          itemname: itemname,
                                          description: description,
                                          purpose: purpose,
                                          eventname: eventname,
                                          actualdate: actualdate,
                                          reqparty: reqparty,
                                        },
                                        type: "POST",
                                        success: function (data) {
                                          var addonjson = JSON.parse(data);
                                          var status = addonjson.status;
                                          if (status == "success") {
                                            console.log("Addons added to reservation!");                          
                                          }
                                        },
                                      });
                                    } else {
                                    }
                                  }
                                },
                              });
                          }
                          //$('#department').val('');
                          /*var now = new Date();
                                    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                                    document.getElementById('datemajorjr').value = now.toISOString().slice(0,16);*/
                          $("#eventname").val("");
                          $("#actualdate").val("");
                          $("#timein").val("");
                          $("#timeout").val("");
                          $("#eventname_").val("");
                          $("#purpose").val("");
                          $("#numparticipants").val("");
                          $("#stageperformers").val("");
                          $("#adviser").val("");
                          $("#chairdeandep").val("");
                          $("#reserModal").modal("hide");
                          //force remove faded background  -Ragrats
                          $("body").removeClass("modal-open");
                          $(".modal-backdrop").remove();
                          //force remove end
                          //update table list
                          table = $("#datatable").DataTable();
                          table.draw();
                          alert("Successfully Requested Reservation!");
                        }
                      },
                    });
                  } else {
                    alert("Please fill all the Required fields");
                  }
              }
          });
      } else {
          // do something if there is no conflict
          checkReservationConflict(timein, timeout, actualdate, faci, function(result) {
            // Do something with the result, which will be a boolean value
            if (result) {
                // Handle case where there is a conflict
                alert("Someone is using the facility within that time! \nCheck Calendar of Activities for approved schedules. ");
            } else {
                // Handle case where there is no conflict
                if (
                  eventname != "" &&
                  datefiled != "" &&
                  actualdate != "" &&
                  timein != "" &&
                  timeout != "" &&
                  reqparty != "" &&
                  purpose != "" &&
                  numparticipants != "" &&
                  stageperf != "" &&
                  adviser != "" &&
                  chairman != ""
                ) {
                  $.ajax({
                    url: "functions/add_data.php", 
                    data: {
                      eventname: eventname,
                      datefiled: datefiled,
                      actualdate: actualdate,
                      timein: timein,
                      timeout: timeout,
                      reqparty: reqparty,
                      purpose: purpose,
                      numparticipants: numparticipants,
                      stageperf: stageperf,
                      adviser: adviser,
                      chairman: chairman,
                      faci: faci,
                    },
                    type: "POST",
                    success: function (data) {
                      var json = JSON.parse(data);
                      var status = json.status;
                      if ((status = "success")) {
                        //equipment additionals
                        var testarr = [...document.querySelectorAll('[id^="fbh"]')].map(
                          (elm) => elm.id
                        );
                        var testarr2 = [...document.querySelectorAll('[id^="fbe"]')].map(
                          (elm) => elm.id
                        );
                        var testarr3 = [...document.querySelectorAll('[id^="fbv"]')].map(
                          (elm) => elm.id
                        );
                        for (i = 0; i <= testarr.length - 1; i++) {
                          var eid = document.getElementById(testarr[i]).value; //id
                          var ename = document.getElementById(testarr2[i]).value; //name
                          var eqval = document.getElementById(testarr3[i]).value; //value
                          $.ajax({
                            url: "functions/addeqreserve.php",
                            data: {
                              eventname: eventname,
                              dateofusage: actualdate,
                              datesubmitted: datefiled,
                              timestart: timein,
                              timeend: timeout,
                              quantity: eqval,
                              facility: faci,
                              eqid: eid,
                              eqname: ename,
                            },
                            type: "POST",
                            success: function (data) {
                              var eqjson = JSON.parse(data);
                              var status = eqjson.status;
                              if (status == "success") {
                                console.log("equipment added to reservation!");
                                var checkbox = document.getElementById("flexCheckDefault");
                                if (checkbox.checked == true) {
                                  var department = $("#_department").val();
                                  var date = $("#dateminor").val();
                                  var quantity = $("#_quantity_").val();
                                  var itemname = $("#_item_").val();
                                  var description = $("#_itemdesc_").val();
                                  var purpose = $("#_purpose_").val();
                                  $.ajax({
                                    url: "functions/addons.php",
                                    data: {
                                      department: department,
                                      date: date,
                                      quantity: quantity,
                                      itemname: itemname,
                                      description: description,
                                      purpose: purpose,
                                      eventname: eventname,
                                      actualdate: actualdate,
                                      reqparty: reqparty,
                                    },
                                    type: "POST",
                                    success: function (data) {
                                      var addonjson = JSON.parse(data);
                                      var status = addonjson.status;
                                      if (status == "success") {
                                        console.log("Addons added to reservation!");                          
                                      }
                                    },
                                  });
                                } else {
                                }
                              }
                            },
                          });
                        }
                        //$('#department').val('');
                        /*var now = new Date();
                                  now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                                  document.getElementById('datemajorjr').value = now.toISOString().slice(0,16);*/
                        $("#eventname").val("");
                        $("#actualdate").val("");
                        $("#timein").val("");
                        $("#timeout").val("");
                        $("#eventname_").val("");
                        $("#purpose").val("");
                        $("#numparticipants").val("");
                        $("#stageperformers").val("");
                        $("#adviser").val("");
                        $("#chairdeandep").val("");
                        $("#reserModal").modal("hide");
                        //force remove faded background  -Ragrats
                        $("body").removeClass("modal-open");
                        $(".modal-backdrop").remove();
                        //force remove end
                        //update table list
                        table = $("#datatable").DataTable();
                        table.draw();
                        alert("Successfully Requested Reservation!");
                      }
                    },
                  });
                } else {
                  alert("Please fill all the Required fields");
                }
            }
        });
      }
  });
    //alert(testarr.length);
    /*
    if(checkdateconflict(actualdate, timein, timeout, faci)==true)
    {
      alert("true test");
      if(checkreservationConflict(timein, timeout, actualdate, faci)==false){
        alert("no conflicts");
      }
      else{
        alert("Someone is using the facility within that time! \nCheck Calendar of Activities for approved schedules. ");
      }
    }
    else{
      alert("false test");
    }
*/
});
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
//delete pending reservation
$(document).on("click", ".deleteBtn", function (event) {
  //alert("test");
  //confirm('test');

  event.preventDefault();
  var id = $(this).data("id");
  if (confirm("Are you sure to delete this request?")) {
    $.ajax({
      url: "functions/delete_data.php",
      data: {
        id: id,
      },
      type: "POST",
      success: function (data) {
        var json = JSON.parse(data);
        var status = json.status;
        //var table = $('#datatable').DataTable();

        if (status == "success") {
          $("#" + id)
            .closest("tr")
            .remove();
          //table.draw();
        } else {
          alart("failed");
          return;
        }
      },
    });
  } else {
    return null;
  }
});



//Admin Buttons for Approval
//minorjobaddon admin approval
$(document).on('click', '.aoapproveBtn', function(event){

  //var status = "Approved";
  //var id = $('#_addonID').val();
  var id = document.getElementById("_addonID").value;
  var trid = $('#trid').val();
  $.ajax({
      url: "functions/aoapprove.php",
      data: {
          id: id,
          
      },
      type: 'POST',
      success: function(data) {
          var json = JSON.parse(data);
          var status = json.status;
          if (status == 'success') {
              table = $('#datatable').DataTable();
              table.draw();
              alert('Add-on Approved Successfully!');
             
              /*table = $('#datatable').DataTable();
              var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
              var row = table.row("[id='" + trid + "']");
              row.row("[id='" + trid + "']").data([department, date, button]);*/
              $('#_addonstat').val('Approved');
              //$('#test').modal('hide');
          } else { 
              alert('failed');
          }
      }
  });
});


$(document).on('click', '.approveAll', function(event){

  //var status = "Approved";
  var id = $('#_ID').val();
  var aoid = document.getElementById("_addonID").value;
  $.ajax({
      url: "functions/approveall.php",
      data: {
          id: id,
          aoid: aoid,
          
      },
      type: 'POST',
      success: function(data) {
          var json = JSON.parse(data);
          var status = json.status;
          if (status == 'success') {
              table = $('#datatable').DataTable();
              table.draw();
              alert('Approved Successfully!');
          
              /*table = $('#datatable').DataTable();
              var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
              var row = table.row("[id='" + trid + "']");
              row.row("[id='" + trid + "']").data([department, date, button]);*/
              $('#_step1').val('Approved');
              $('#_addonstat').val('Approved');
              $('#_step2').val('Approved');
              $('#_statustext').val('Approved')
          } else { 
              alert('failed');
          }
      }
  });
  //alert('test');
});

$(document).on('click', '.step1approveBtn', function(event){

  //var status = "Approved";
  var id = $('#_ID').val();
  var trid = $('#trid').val();
  $.ajax({
      url: "functions/step1approve.php",
      data: {
          id: id,
          
      },
      type: 'POST',
      success: function(data) {
          var json = JSON.parse(data);
          var status = json.status;
          if (status == 'success') {
              table = $('#datatable').DataTable();
              table.draw();
              alert('Step 1 Approved Successfully!');
          
              /*table = $('#datatable').DataTable();
              var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
              var row = table.row("[id='" + trid + "']");
              row.row("[id='" + trid + "']").data([department, date, button]);*/
              $('#_step1').val('Approved');
          } else { 
              alert('failed');
          }
      }
  });
  //alert('test');
});

$(document).on('click', '.step2approveBtn', function(event){

  //var status = "Approved";
  var id = $('#_ID').val();
  var trid = $('#trid').val();
  $.ajax({
      url: "functions/step2approve.php",
      data: {
          id: id,
          
      },
      type: 'POST',
      success: function(data) {
          var json = JSON.parse(data);
          var status = json.status;
          if (status == 'success') {
              table = $('#datatable').DataTable();
              table.draw();
              alert('Step 2 Approved Successfully!');
          
              /*table = $('#datatable').DataTable();
              var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
              var row = table.row("[id='" + trid + "']");
              row.row("[id='" + trid + "']").data([department, date, button]);*/
              $('#_step2').val('Approved');
          } else { 
              alert('failed');
          }
      }
  });
//alert('test');
});
//Admin Buttons for Approval End


//Admin Buttons for Decline

$(document).on('click', '.declineAll', function(event){

  //var status = "Approved";
  var id = $('#_ID').val();
  var aoid = document.getElementById("_addonID").value;
  $.ajax({
      url: "functions/declineall.php",
      data: {
          id: id,
          aoid: aoid,
          
      },
      type: 'POST',
      success: function(data) {
          var json = JSON.parse(data);
          var status = json.status;
          if (status == 'success') {
              table = $('#datatable').DataTable();
              table.draw();
              alert('Declined Successfully!');
          
              /*table = $('#datatable').DataTable();
              var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
              var row = table.row("[id='" + trid + "']");
              row.row("[id='" + trid + "']").data([department, date, button]);*/
              $('#_step1').val('Declined');
              $('#_addonstat').val('Declined');
              $('#_step2').val('Declined');
              $('#_statustext').val('Declined')
          } else { 
              alert('failed');
          }
      }
  });
  //alert('test');
});


//minorjobaddon admin decline
$(document).on('click', '.aodeclineBtn', function(event){
  var id = document.getElementById("_addonID").value;
  var trid = $('#trid').val();
  $.ajax({
      url: "functions/aodecline.php",
      data: {
          id: id,
          
      },
      type: 'POST',
      success: function(data) {
          var json = JSON.parse(data);
          var status = json.status;
          if (status == 'success') {
              table = $('#datatable').DataTable();
              table.draw();
              alert('Successfully Declined Add-on!');

          
              /*table = $('#datatable').DataTable();
              var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
              var row = table.row("[id='" + trid + "']");
              row.row("[id='" + trid + "']").data([department, date, button]);*/
              //$('#_itemdesc_').text('');
              $('#_addonstat').val('Declined');
              //$('#test').modal('hide');
          } else { 
              alert('failed');
          }
      }
      });
});

$(document).on('click', '.step1declineBtn', function(event){
  var id = $('#_ID').val();
  var trid = $('#trid').val();
  $.ajax({
      url: "functions/step1decline.php",
      data: {
          id: id,
          
      },
      type: 'POST',
      success: function(data) {
          var json = JSON.parse(data);
          var status = json.status;
          if (status == 'success') {
              table = $('#datatable').DataTable();
              table.draw();
              alert('Step 1 Declined Successfully!');

          
              /*table = $('#datatable').DataTable();
              var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
              var row = table.row("[id='" + trid + "']");
              row.row("[id='" + trid + "']").data([department, date, button]);*/
              //$('#_itemdesc_').text('');
              $('#_step1').val('Declined');
          } else { 
              alert('failed');
          }
      }
      });
});

$(document).on('click', '.step2declineBtn', function(event){
  var id = $('#_ID').val();
  var trid = $('#trid').val();
  $.ajax({
      url: "functions/step2decline.php",
      data: {
          id: id,
          
      },
      type: 'POST',
      success: function(data) {
          var json = JSON.parse(data);
          var status = json.status;
          if (status == 'success') {
              table = $('#datatable').DataTable();
              table.draw();
              alert('Step 2 Declined Successfully!');

          
              /*table = $('#datatable').DataTable();
              var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
              var row = table.row("[id='" + trid + "']");
              row.row("[id='" + trid + "']").data([department, date, button]);*/
              //$('#_itemdesc_').text('');
              $('#_step2').val('Declined');
          } else { 
              alert('failed');
          }
      }
      });
});
//Admin Buttons for Decline End




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





//remove [Equipments meant to be added to reservation]
function removeAddedEq(e){
  e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
  }
//more info eq

var testarr = [];
$(document).on('click', '.editResBtn', function(event){
  var updatebtn = document.getElementById("uResBtn");
  updatebtn.classList.remove("disabled");
  var testarr = [...document.querySelectorAll('#container4 button[id^="fbe"]')].map(elm => elm.id);
  console.log(testarr);

    for (i = 0; i <= testarr.length; i++) {
      console.log(testarr[i]);
      var val = document.getElementById(testarr[i]).value;//eq
      //document.getElementById(val).disabled = false;
      var eqbtn = document.getElementById(testarr[i]);
          eqbtn.classList.remove("disabled");
          eqbtn.classList.remove("disabled");
  }
  document.getElementById("_facility").disabled = false;
  document.getElementById("_eventname").disabled = false;
  document.getElementById("_datefiled").disabled = false;
  document.getElementById("_actualdate").disabled = false;
  document.getElementById("_timein").disabled = false;
  document.getElementById("_timeout").disabled = false;
  document.getElementById("_reqparty").disabled = false;
  document.getElementById("_purpose").disabled = false;
  document.getElementById("_numparticipants").disabled = false;
  document.getElementById("_stageperformers").disabled = false;
  document.getElementById("_adviser").disabled = false;
  document.getElementById("_chairdeandep").disabled = false;

  document.getElementById("_dept").disabled = false //department
  document.getElementById("_dateresm").disabled = false //date
  document.getElementById("_minorqres").disabled = false //quantity
  document.getElementById("_minoritemres").disabled = false//itemname
  document.getElementById("_minoritemdesc").disabled = false//itemdescription
  document.getElementById("_minorpurpose").disabled = false//purpose

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

function removeAddedEq2(e){

  e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
}
//cleanvalues when closed
function closeModalforInfo(){
  const myNode =  document.getElementById('container4');
  const len = myNode.childElementCount;
  //console.log(myNode.childElementCount);
  for(var i = 0;  i < len; i++){
      removeAddedEq2();
      }

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
          $("#test").trigger("reset");
}

//modal events

$("#reserModal").on("hidden.bs.modal", function () {
  const myNode =  document.getElementById('container2');
  const len = myNode.childElementCount;
  for(var i = 0; i<len+1; i++){
      myNode.removeChild(myNode.firstChild);
  }
  $('#testtable').DataTable().clear().destroy();
  
});


$("#test").on("hidden.bs.modal", function () {
  const myNode =  document.getElementById('container4');
  const len = myNode.childElementCount;
  for(var i = 0; i<len+1; i++){
      myNode.removeChild(myNode.firstChild);
  }

          var x = document.getElementById("_myDIV1");
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
  
});







