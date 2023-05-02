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
      $("#_inputFeedback").val(json.feedback);
      $("#_fdapprovedby").val(json.fdapprovedby);
      $("#_saoapprovedby").val(json.saoapprovedby);
      if(json.fdstatus != 'Pending')
      {
        document.getElementById("_inputFeedback").disabled = true;
        document.getElementById("step1a").hidden = true;
        document.getElementById("step1d").hidden = true;
        document.getElementById("_fdapprovedby").disabled = true;
      }
      else{
        document.getElementById("_inputFeedback").disabled = false;
        document.getElementById("step1a").hidden = false;
        document.getElementById("step1d").hidden = false;
        document.getElementById("_fdapprovedby").disabled = false;
      }
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
                  btn.className = "btn btn-sm btn-danger disabled removeEq";
                  btn.id = "fbe"+nid;
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
  var eventname = $("#eventname").val();
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

  //alert(testarr.length);
  if (
    eventname != "" &&
    datefiled != "" &&
    actualdate != "" &&
    timein != "" &&
    timeout != "" &&
    reqparty != "" &&
    department != "" &&
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
          $("#reqparty").val("");
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
  var dept = $("#_reqparty").val();
  var feedb = $("#_inputFeedback").val();
  var fdapprove = $("#_fdapprovedby").val();
  var actualdate =  $("#_actualdate").val();
  var timein = $("#_timein").val();
  var timeout = $("#_timeout").val();
  var e = document.getElementById("_facility");
  var faci = e.options[e.selectedIndex].text;
  checkdateconflict(actualdate, timein, timeout, faci, function(confirm) {
    if(confirm)
    {
      checkReservationConflict(timein, timeout, actualdate, faci, function(result){
        if(result)
        {
          alert("Someone already reserved the facility within that day on the same time! \nCheck Calendar of Activities for approved schedules. ");
        }
        else
        {
          if(fdapprove != '')
            {
              $.ajax({
                url: "functions/step1approve.php",
                data: {
                  id: id,
                  dept: dept,
                  feedb: feedb,
                  fdapprove: fdapprove,
                    
                },
                type: 'POST',
                success: function(data) {
                    var json = JSON.parse(data);
                    var status = json.status;
                    if (status == 'success') {
                        table = $('#datatable').DataTable();
                        table.draw();
                        $('#approvedmodal').modal('show');
                    
                        /*table = $('#datatable').DataTable();
                        var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
                        var row = table.row("[id='" + trid + "']");
                        row.row("[id='" + trid + "']").data([department, date, button]);*/
                        $('#_step1').val('Approved');
                        $('#test').modal('hide');
                        $('body').removeClass('modal-open');
                    } else { 
                        alert('failed');
                    }
                }
            });
            }
            else
            {
              alert("Please fill out required fields!");
            }
        }
      });
    }
    else{
      checkReservationConflict(timein, timeout, actualdate, faci, function(result){
        if(result)
        {
          alert("Someone already reserved the facility within that day on the same time! \nCheck Calendar of Activities for approved schedules. ");
        }
        else
        {
          if(fdapprove != '')
            {
              $.ajax({
                url: "functions/step1approve.php",
                data: {
                  id: id,
                  dept: dept,
                  feedb: feedb,
                  fdapprove: fdapprove,
                    
                },
                type: 'POST',
                success: function(data) {
                    var json = JSON.parse(data);
                    var status = json.status;
                    if (status == 'success') {
                        table = $('#datatable').DataTable();
                        table.draw();
                        $('#approvedmodal').modal('show');
                    
                        /*table = $('#datatable').DataTable();
                        var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
                        var row = table.row("[id='" + trid + "']");
                        row.row("[id='" + trid + "']").data([department, date, button]);*/
                        $('#_step1').val('Approved');
                        $('#test').modal('hide');
                        $('body').removeClass('modal-open');
                    } else { 
                        alert('failed');
                    }
                }
            });
            }
            else
            {
              $('#alert1').css('display', 'block');
              $('#strongId').html('Please fill out required fields!');
            }
        }
      });
    }
  });
  
  //alert('test');
});

$(document).on('click', '.step2approveBtn', function(event){

  //var status = "Approved";
  var id = $('#_ID').val();
  var trid = $('#trid').val();
  var dept = $("#_reqparty").val();
  var feedb = $("#_inputFeedback").val();
  $.ajax({
      url: "functions/step2approve.php",
      data: {
          id: id,
          dept: dept,
          feedb: feedb,
          
      },
      type: 'POST',
      success: function(data) {
          var json = JSON.parse(data);
          var status = json.status;
          if (status == 'success') {
              table = $('#datatable').DataTable();
              table.draw();
              $('#declinemodal').modal('show');
          
              /*table = $('#datatable').DataTable();
              var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
              var row = table.row("[id='" + trid + "']");
              row.row("[id='" + trid + "']").data([department, date, button]);*/
              $('#_statustext').val('Approved');
              $('#_step2').val('Approved');
              $('#test').modal('hide');
              $('body').removeClass('modal-open');
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
  var dept = $("#_reqparty").val();
  var feedb = $("#_inputFeedback").val();
  if(feedb != '')
  {
    $.ajax({
      url: "functions/step1decline.php",
      data: {
        id: id,
        dept: dept,
        feedb: feedb,
          
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
              $('#_statustext').val('Declined');
              $('#_step1').val('Declined');
              $('#test').modal('hide');
              $('body').removeClass('modal-open');
              $('.modal-backdrop').remove();
          } else { 
              alert('failed');
          }
      }
      });
  }
  else
  {
    $('#alert1').css('display', 'block');
    $('#strongId').html('Please provide a feedback when declining a request!');
  }
  
});

$(document).on('click', '.step2declineBtn', function(event){
  var id = $('#_ID').val();
  var trid = $('#trid').val();
  var dept = $("#_reqparty").val();
  var feedb = $("#_inputFeedback").val();
  $.ajax({
      url: "functions/step2decline.php",
      data: {
          id: id,
          dept: dept,
          feedb: feedb,
          
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
              $('#_statustext').val('Declined');
              $('#_step2').val('Declined');
              $('#test').modal('hide');
              $('body').removeClass('modal-open');
              $('.modal-backdrop').remove();
          } else { 
              alert('failed');
          }
      }
      });
});
//Admin Buttons for Decline End

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