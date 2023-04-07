$("#datatable").DataTable({
    serverSide: true,
    processing: true,
    paging: true,
    order: [],
    ajax: {
      url: "dfunctions/fetch_data.php",
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