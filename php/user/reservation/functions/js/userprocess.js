//edit button control
$(document).on("click", ".editBtn", function (event) {
  var id = $(this).data("id");
  var trid = $(this).closest("tr").attr("reservationid");
  const myNode =  document.getElementById('container4');
    while (myNode.firstChild ) {
    myNode.removeChild(myNode.lastChild);
  } 
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
  document.getElementById("_inputFeedback").disabled = true;
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
      //var itemwdesc = json.item + json.item_desc;
      $("#trid").val(trid);
      $("#_ID").val(id);
      $("#_facility").val(json.facility);
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
      $("#_inputFeedback").val(json.feedback);
      $("#_fdapprovedby").val(json.fdapprovedby);
      $("#_saoapprovedby").val(json.saoapprovedby);
      $("#test").modal("show");
        var en = json.eventname;
            
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
              //console.log(jsonreseq);
              //console.log(data[0].eqid);
                
                for(var i = 0; i<len-1; i++)
                {
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
                  btn.className = "btn btn-sm btn-danger disabled removeEq"+nid;
                  btn.setAttribute("onclick","removeAddedEq2(this);");
                  btn.style.marginTop = '3px';
                  btn.innerHTML = "Remove";
                  var textbox = document.createElement('text');
                  textbox.className = "form-control input-sm col-xs-1 disabled";
                  textbox.innerHTML = equipn +' x '+ equipq;

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
  var requestedby = $("#requestedby").val();
  var e = document.getElementById("faci");
  document.getElementById("termscond-create").disabled = true;
  var chkbx = document.getElementById("flexCheckDefault");

  var faci = e.options[e.selectedIndex].text;
    if(computedaysdiff(datefiled, actualdate) <= 4 )
    {
      var computeval = computedaysdiff(datefiled, actualdate);
      $('#alert2').css('display', 'block');
      $('#strongId1').html("Please Note that you need to reserve 5 days before the desired reservation day\nReservation Day(s) Count:"+computeval+" Day(s) Away.");
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
                  //alert("Someone is using the facility within that time! \nCheck Calendar of Activities for approved schedules. ");
                  myFunctionPrompt("alert4");
                  $('#reserModal').scrollTop(0);
                  document.getElementById("termscond-create").disabled = false;
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
                          chkbx.checked = false;
                                var checkbox = document.getElementById("flexCheckDefault");
                                if (checkbox.checked == true) {
                                  var department = $("#_department").val();
                                  var date = $("#dateminor").val();
                                  var quantity = $("#_quantity_").val();
                                  var description = $("#_itemdesc_").val();
                                  var purpose = $("#_purpose_").val();
                                  $.ajax({
                                    url: "functions/addons.php",
                                    data: {
                                      department: department,
                                      date: date,
                                      quantity: quantity,
                                      description: description,
                                      purpose: purpose,
                                      eventname: eventname,
                                      actualdate: actualdate,
                                      reqparty: reqparty,
                                      requestedby: requestedby,
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
                                    chkbx.checked = false;
                                    console.log("equipment added to reservation!");
                                  }
                                },
                              });
                          }
                          

                          //force remove end
                          //update table list
                          table = $("#datatable").DataTable();
                          table.draw();
                          myFunctionPrompt("alert1");
                          $('#reserModal').scrollTop(0);
                          //force remove faded background  -Ragrats
                          document.getElementById("termscond-create").disabled = false;
                        }
                      },
                    });
                  } else {
                    $('#alert5').css('display', 'block');
                    $('#strongId5').html('Please fill all the Required fields');	
                    document.getElementById("termscond-create").disabled = false;
                  }
              }
          });
      } else {
          // do something if there is no conflict
          
          checkReservationConflict(timein, timeout, actualdate, faci, function(result) {
            // Do something with the result, which will be a boolean value
            document.getElementById("termscond-create").disabled = true;
            if (result) {
                // Handle case where there is a conflict
                //alert("Someone is using the facility within that time! \nCheck Calendar of Activities for approved schedules. ");
                $('#alert4').css('display', 'block');
                $('#strongId3').html('Someone is using the facility within that time! \nCheck Calendar of Activities for approved schedules.');	
                $('#reserModal').scrollTop(0);
                document.getElementById("termscond-create").disabled = false;
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
                                var checkbox = document.getElementById("flexCheckDefault");
                                if (checkbox.checked == true) {
                                  var department = $("#_department").val();
                                  var date = $("#dateminor").val();
                                  var quantity = $("#_quantity_").val();
                                  var description = $("#_itemdesc_").val();
                                  var purpose = $("#_purpose_").val();
                                  $.ajax({
                                    url: "functions/addons.php",
                                    data: {
                                      department: department,
                                      date: date,
                                      quantity: quantity,
                                      description: description,
                                      purpose: purpose,
                                      eventname: eventname,
                                      actualdate: actualdate,
                                      reqparty: reqparty,
                                      requestedby: requestedby,
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
                                
                              }
                            },
                          });
                        }
                        //$('#department').val('');
                        /*var now = new Date();
                                  now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                                  document.getElementById('datemajorjr').value = now.toISOString().slice(0,16);*/

                        //force remove end
                        //update table list
                        table = $("#datatable").DataTable();
                        table.draw();
                        myFunctionPrompt("alert1");
                        $('#reserModal').scrollTop(0);
                      }
                    },
                  });
                } else {
                  $('#alert5').css('display', 'block');
                  $('#strongId5').html('Please fill all the Required fields');	
                  document.getElementById("termscond-create").disabled = false;
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

//delete pending reservation
$(document).on("click", ".deleteBtn", function (event) {
  event.preventDefault();
  var id = $(this).data("id");
  $('#deletemodal').modal('show');
  
  $('#deletemodal').on('click', '.btn-danger', function() {
    $.ajax({
      url: "functions/delete_data.php",
      data: {
        id: id,
      },
      type: "POST",
      success: function (data) {
        var json = JSON.parse(data);
        var status = json.status;
        if (status == "success") {
          $("#" + id).closest("tr").remove();
        } else {
          alert("failed");
          return;
        }
      },
    });
    $('#deletemodal').modal('hide');
  });
  
  $('#deletemodal').on('click', '#close-modal', function() {
    $('#deletemodal').modal('hide');
  });
});


