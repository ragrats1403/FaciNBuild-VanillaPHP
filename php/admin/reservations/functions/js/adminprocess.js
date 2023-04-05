//table display start
$("#datatable").DataTable({
  serverSide: true,
  processing: true,
  paging: true,
  order: [],
  ajax: {
    url: "functions/fetch_data.php",
    type: "post",
  },
  fnCreatedRow: function (nRow, aData, iDataIndex) {
    $(nRow).attr("id", aData[0]);
  },
  columnDefs: [
    {
      target: [0, 3],
      orderable: false,
    },
  ],
  scrollY: 200,
  scrollCollapse: true,
  paging: false,
});

//table display end
//minorjobaddon admin approval
$(document).on('click', '.aoapproveBtn', function(event){

  //var status = "Approved";
  //var id = $('#_addonID').val();
  var id = document.getElementById("_addonID").value;
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

//minorjobaddon admin decline
$(document).on('click', '.aodeclineBtn', function(event){
  var id = document.getElementById("_addonID").value;
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


//edit button control
$(document).on("click", ".editBtn", function (event) {
  var id = $(this).data("id");
  var trid = $(this).closest("tr").attr("reservationid");
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
                  btn.setAttribute("onclick","removeAddedEq2();");
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
