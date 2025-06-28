  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2021 <a href="#">NIRWANA GROUP</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>User : </b><?= $user['username']; ?>
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!--- MODAL LOGOUT --->
<div class="modal fade" id="logoutModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><b><?= ucfirst($user['username']); ?></b> ,Ready to Leave?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Select "Logout" below if you are ready to end your current session.</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="<?= base_url('auth/Logout'); ?>">Logout</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!--  -->
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?= base_url('assets/'); ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?= base_url('assets/'); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="<?= base_url('assets/'); ?>dist/js/adminlte.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url('assets/'); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url('assets/'); ?>plugins/toastr/toastr.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets/'); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- OPTIONAL SCRIPTS -->
<script src="<?= base_url('assets/'); ?>plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('assets/'); ?>dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= base_url('assets/'); ?>dist/js/pages/dashboard3.js"></script>
<!-- date-range-picker -->
<script src="<?= base_url('assets/'); ?>plugins/select2/js/select2.full.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/selectpicker/bootstrap-select.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/moment/moment.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!---  crud nag --->
<script src="<?php echo base_url('assets/build/js/crud/crud-nag.js') ?>"></script>
<script src="<?php echo base_url('assets/build/js/crud/crud-nag-report.js') ?>"></script>
<script src="<?= base_url('assets/'); ?>plugins/apexchart/apexcharts.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/apexchart/apexcharts.min.js"></script>
<script type="module" src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.esm.js"></script>
<script nomodule src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.js"></script>

<!-- Toast Informasi -->

<script type="text/javascript">
  function showdata_slsytd(){
    $('#modal_slsytd').modal("show");  
  }
</script>

<script type="text/javascript">
  function showdata_slscm(){
    $('#modal_slscm').modal("show");  
  }
</script>

<script type="text/javascript">
  function showdata_slsytd2(){
    $('#modal_slsytd2').modal("show");  
  }
</script>

<script type="text/javascript">
  function showdata_slsni(){
    $('#modal_slsni').modal("show");  
  }
</script> 

<script type="text/javascript">
  function showdata_slscm2(){
    $('#modal_slscm2').modal("show");  
  }
</script> 

<script type="text/javascript">
  function showdata_total_ar(){
    $('#modal_total_ar').modal("show");  
  }
  function showdata_total_overdue(){
    $('#modal_total_overdue').modal("show");  
  }
  function showdata_total_notdue(){
    $('#modal_total_notdue').modal("show");  
  }
</script>

<script type="text/javascript">
  data  = <?= ($ar_ekspor + $ar_ekspor_ni); ?>;
  data2 = <?= ($ar_lokal + $ar_lokal_ni); ?>;
  val_data = 'Sales Export <br>IDR <?= number_format(($ar_ekspor + $ar_ekspor_ni),2); ?>';
  val_data2 = 'Sales Local <br>IDR <?= number_format(($ar_lokal + $ar_lokal_ni),2); ?>';
  var options = {
    series: [data,data2],
    chart: {
      width: 350,
      type: 'pie',
    },
    colors: ['#008B8B', '#DC143C'],
    labels: [val_data,val_data2],
    responsive: [{
      breakpoint: 480,
      options: {
        chart: {
          width: 320
        },
        legend: {
          position: 'bottom'
        }
      }
    }]
  };

  var chart = new ApexCharts(document.querySelector("#chart"), options);
  chart.render();

  function cari_ar_lokal_ekspor (option){
    filter = option;
    console.log(option);
    if (filter == 'ALL') {
      data  = <?= ($ar_ekspor + $ar_ekspor_ni); ?>;
      data2 = <?= ($ar_lokal + $ar_lokal_ni); ?>;
      val_data = 'Sales Export <br>IDR <?= number_format(($ar_ekspor + $ar_ekspor_ni),2); ?>';
      val_data2 = 'Sales Local <br>IDR <?= number_format(($ar_lokal + $ar_lokal_ni),2); ?>';
    }else if(filter == 'invoice'){
      data  = <?= $ar_ekspor; ?>;
      data2 = <?= $ar_lokal; ?>;
      val_data = 'Sales Export <br>IDR <?= number_format($ar_ekspor,2); ?>';
      val_data2 = 'Sales Local <br>IDR <?= number_format($ar_lokal,2); ?>';
    }else if(filter == 'no_invoice'){
      data  = <?= $ar_ekspor_ni; ?>;
      data2 = <?= $ar_lokal_ni; ?>;
      val_data = 'Sales Export <br>IDR <?= number_format($ar_ekspor_ni,2); ?>';
      val_data2 = 'Sales Local <br>IDR <?= number_format($ar_lokal_ni,2); ?>';
    }

    chart.updateOptions({
      series: [data,data2],
      labels: [val_data,val_data2],
    });
  }
</script>

<script type="text/javascript">
  data  = <?= ($ar_fob + $ar_fob_ni); ?>;
  data2 = <?= ($ar_cmt + $ar_cmt_ni); ?>;
  val_data = 'Sales FOB <br>IDR <?= number_format(($ar_fob + $ar_fob_ni),2); ?>';
  val_data2 = 'Sales CMT <br>IDR <?= number_format(($ar_cmt + $ar_cmt_ni),2); ?>';
  var options = {
    series: [data,data2],
    chart: {
      width: 350,
      type: 'pie',
    },
    colors: ['#008B8B', '#DC143C'],
    labels: [val_data,val_data2],
    responsive: [{
      breakpoint: 480,
      options: {
        chart: {
          width: 320
        },
        legend: {
          position: 'bottom'
        }
      }
    }]
  };

  var chart2 = new ApexCharts(document.querySelector("#chart2"), options);
  chart2.render();


  function cari_ar_fob_cmt (option){
    filter = option;
    console.log(option);
    if (filter == 'ALL') {
      data  = <?= ($ar_fob + $ar_fob_ni); ?>;
      data2 = <?= ($ar_cmt + $ar_cmt_ni); ?>;
      val_data = 'Sales FOB <br>IDR <?= number_format(($ar_fob + $ar_fob_ni),2); ?>';
      val_data2 = 'Sales CMT <br>IDR <?= number_format(($ar_cmt + $ar_cmt_ni),2); ?>';
    }else if(filter == 'invoice'){
      data  = <?= $ar_fob; ?>;
      data2 = <?= $ar_cmt; ?>;
      val_data = 'Sales FOB <br>IDR <?= number_format($ar_fob,2); ?>';
      val_data2 = 'Sales CMT <br>IDR <?= number_format($ar_cmt,2); ?>';
    }else if(filter == 'no_invoice'){
      data  = <?= $ar_fob_ni; ?>;
      data2 = <?= $ar_cmt_ni; ?>;
      val_data = 'Sales FOB <br>IDR <?= number_format($ar_fob_ni,2); ?>';
      val_data2 = 'Sales CMT <br>IDR <?= number_format($ar_cmt_ni,2); ?>';
    }

    chart2.updateOptions({
      series: [data,data2],
      labels: [val_data,val_data2],
    });
  }
</script>

<script type="text/javascript">
 var filter_top5 = 'ALL';

 var salesData = {
  '01': { values: [<?= $top_5_sales_val_01; ?>], names: [<?= $top_5_sales_name_01; ?>] },
  '02': { values: [<?= $top_5_sales_val_02; ?>], names: [<?= $top_5_sales_name_02; ?>] },
  '03': { values: [<?= $top_5_sales_val_03; ?>], names: [<?= $top_5_sales_name_03; ?>] },
  '04': { values: [<?= $top_5_sales_val_04; ?>], names: [<?= $top_5_sales_name_04; ?>] },
  '05': { values: [<?= $top_5_sales_val_05; ?>], names: [<?= $top_5_sales_name_05; ?>] },
  '06': { values: [<?= $top_5_sales_val_06; ?>], names: [<?= $top_5_sales_name_06; ?>] },
  '07': { values: [<?= $top_5_sales_val_07; ?>], names: [<?= $top_5_sales_name_07; ?>] },
  '08': { values: [<?= $top_5_sales_val_08; ?>], names: [<?= $top_5_sales_name_08; ?>] },
  '09': { values: [<?= $top_5_sales_val_09; ?>], names: [<?= $top_5_sales_name_09; ?>] },
  '10': { values: [<?= $top_5_sales_val_10; ?>], names: [<?= $top_5_sales_name_10; ?>] },
  '11': { values: [<?= $top_5_sales_val_11; ?>], names: [<?= $top_5_sales_name_11; ?>] },
  '12': { values: [<?= $top_5_sales_val_12; ?>], names: [<?= $top_5_sales_name_12; ?>] },
  'ALL': { values: [<?= $top_5_sales_val; ?>], names: [<?= $top_5_sales_name; ?>] }
};

function change_top_5_sales(option) {
  filter_top5 = option;

    // Get the data for the selected filter
    var databar = salesData[filter_top5]?.values || [];
    var kategoribar = salesData[filter_top5]?.names || [];

    // Update the chart with the selected data
    chart3.updateOptions({
      series: [{
        name: 'Sales value',
        data: databar
      }],
      xaxis: {
        categories: kategoribar,
        position: 'bottom',
        colors: ['#008B8B', '#DC143C', '#008B8B', '#DC143C', '#008B8B'],
      },
    });
  }

  var selected_pc = "<?= $selected_pc ?>";

  var options = {
    series: [{
      name: 'Sales value',
      data: [<?= $top_5_sales_val; ?>]
    }],
    colors: ['#008B8B'],
    chart: {
      height: 350,
      type: 'bar',
      events: {
        click: function(event, chartContext, config, val) {
              // The last parameter config contains additional information like `seriesIndex` and `dataPointIndex` for cartesian charts
              // alert(config.dataPointIndex);
              if (config.dataPointIndex >= 0) {
              //   url: "load_prediksi2/";
              // $('#myModal').modal('show');
              if (config.dataPointIndex == 0) {
                var event_id = config.config.xaxis.categories[0];
              }else if(config.dataPointIndex == 1) {
                var event_id = config.config.xaxis.categories[1];
              }else if(config.dataPointIndex == 2) {
                var event_id = config.config.xaxis.categories[2];
              }else if(config.dataPointIndex == 3) {
                var event_id = config.config.xaxis.categories[3];
              }else if(config.dataPointIndex == 4) {
                var event_id = config.config.xaxis.categories[4];
              }
              if (!filter_top5) {
                bulan = 'ALL';
              }else{
                bulan = filter_top5;
              }
              console.log(event_id);
              console.log(bulan);
              $.ajax({  
                url : "<?= base_url('Landingpage/load_det_sales5') ?>", 
                method:"POST",  
                data:{event_id:event_id,bulan:bulan, selected_pc:selected_pc},  
                success:function(data){
                  // alert(event_id);  
                  $('#det_sales5').html(data);  
                  $('#mysales5').modal("show");  
                }  
              });
            }
          }
        }
      },

      plotOptions: {
        bar: {
          borderRadius: 10,
          dataLabels: {
              position: 'top', // top, center, bottom
            },
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return "IDR " + val.toLocaleString('en-US');
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        
        xaxis: {
          categories: [<?= $top_5_sales_name; ?>],
          position: 'bottom',
          colors: ['#008B8B', '#DC143C', '#008B8B', '#DC143C', '#008B8B'],
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          crosshairs: {
            fill: {
              type: 'gradient',
              gradient: {
                colorFrom: '#D8E3F0',
                colorTo: '#BED1E6',
                stops: [0, 100],
                opacityFrom: 0.4,
                opacityTo: 0.5,
              }
            }
          },
          tooltip: {
            enabled: true,
          }
        },
        yaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
            formatter: function (val) {
              return "IDR " + val.toLocaleString('en-US');
            }
          }

        },
      };

      var chart3 = new ApexCharts(document.querySelector("#chart3"), options);
      chart3.render();
    </script>

    <script type="text/javascript">
      function change_sales_ytd_mtm() {
    // Ambil nilai tahun dari elemen <select>
    var filter_sym = document.getElementById('filter_chart4').value;
    var selected_pc = "<?= $selected_pc ?>";

    // Lakukan AJAX request ke server untuk mendapatkan data berdasarkan tahun
    $.ajax({
        url: "<?= base_url('Landingpage/cari_sales_data') ?>", // Sesuaikan dengan URL fungsi controller Anda
        method: "POST",
        data: { year: filter_sym, selected_pc: selected_pc },
        success: function(response) {
            // Parse response menjadi array data
            console.log(response);
            var databar = JSON.parse(response);

            // Update chart dengan data baru
            chart4.updateOptions({
              series: [{
                name: 'Sales',
                data: databar
              }],
              chart: {
                height: 500,
                type: 'bar',
                events: {
                  click: function(event, chartContext, config) {
                    if (config.dataPointIndex >= 0) {
                                // Tentukan bulan dan event ID
                                var months = [
                                "January", "February", "March", "April", "May", "June",
                                "July", "August", "September", "October", "November", "December"
                                ];
                                var event_id = (config.dataPointIndex + 1).toString().padStart(2, '0');
                                var text_judul = `Sales ${months[config.dataPointIndex]} ${filter_sym}`;

                                // Lakukan AJAX request untuk detail
                                $.ajax({
                                  url: "<?= base_url('Landingpage/load_det_motm2') ?>",
                                  method: "POST",
                                  data: { event_id: event_id, year: filter_sym },
                                  success: function(data) {
                                    $('#jdl_motm').html(text_judul);
                                    $('#det_motm').html(data);
                                    $('#mymotm').modal("show");
                                  }
                                });
                              }
                            }
                          }
                        },
                        title: {
                          text: `Sales Year To Date ${filter_sym}`,
                          floating: true,
                          offsetY: 483,
                          align: 'center',
                          style: {
                            color: '#444'
                          }
                        },
                      });
          },
          error: function(error) {
            console.error("Error fetching data:", error);
          }
        });
  }

  var currentYear = new Date().getFullYear();


  var options = {
    series: [{
      name: 'Sales',
      data: [<?= $sales_ytd_mtm; ?>]
    }],
    chart: {
      height: 500,
      type: 'bar',
      events: {
        click: function(event, chartContext, config, val) {
              // The last parameter config contains additional information like `seriesIndex` and `dataPointIndex` for cartesian charts
              // alert(config.dataPointIndex);
              if (config.dataPointIndex >= 0) {
              //   url: "load_prediksi2/";
              // $('#myModal').modal('show');
              if (config.dataPointIndex == 0) {
                var event_id = '01';
                var text_judul = `Sales January ${currentYear}`
              }else if(config.dataPointIndex == 1) {
                var event_id = '02';
                var text_judul = `Sales February ${currentYear}`
              }else if(config.dataPointIndex == 2) {
                var event_id = '03';
                var text_judul = `Sales March ${currentYear}`
              }else if(config.dataPointIndex == 3) {
                var event_id = '04';
                var text_judul = `Sales April ${currentYear}`
              }else if(config.dataPointIndex == 4) {
                var event_id = '05';
                var text_judul = `Sales May ${currentYear}`
              }else if(config.dataPointIndex == 5) {
                var event_id = '06';
                var text_judul = `Sales June ${currentYear}`
              }else if(config.dataPointIndex == 6) {
                var event_id = '07';
                var text_judul = `Sales July ${currentYear}`
              }else if(config.dataPointIndex == 7) {
                var event_id = '08';
                var text_judul = `Sales August ${currentYear}`
              }else if(config.dataPointIndex == 8) {
                var event_id = '09';
                var text_judul = `Sales September ${currentYear}`
              }else if(config.dataPointIndex == 9) {
                var event_id = '10';
                var text_judul = `Sales October ${currentYear}`
              }else if(config.dataPointIndex == 10) {
                var event_id = '11';
                var text_judul = `Sales November ${currentYear}`
              }else if(config.dataPointIndex ==11) {
                var event_id = '12';
                var text_judul = `Sales December ${currentYear}`
              }

              console.log(event_id);
              $.ajax({  
                url : "<?= base_url('Landingpage/load_det_motm') ?>", 
                method:"POST",  
                data:{event_id:event_id, selected_pc: selected_pc},  
                success:function(data){
                  // alert(event_id);  
                  $('#jdl_motm').html(text_judul); 
                  $('#det_motm').html(data);  
                  $('#mymotm').modal("show");  
                }  
              });
            }
          }
        }
      },
      plotOptions: {
        bar: {
          borderRadius: 10,
          dataLabels: {
              position: 'top', // top, center, bottom
            },
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return "IDR " + val.toLocaleString('en-US');
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        
        xaxis: {
          categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          position: 'top',
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          crosshairs: {
            fill: {
              type: 'gradient',
              gradient: {
                colorFrom: '#D8E3F0',
                colorTo: '#BED1E6',
                stops: [0, 100],
                opacityFrom: 0.4,
                opacityTo: 0.5,
              }
            }
          },
          tooltip: {
            enabled: true,
          }
        },
        yaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
            formatter: function (val) {
              return "IDR " + val.toLocaleString('en-US');
            }
          }

        },
        title: {
          text: `Sales Year To Date ${currentYear}`,
          floating: true,
          offsetY: 483,
          align: 'center',
          style: {
            color: '#444'
          }
        }
      };

      var chart4 = new ApexCharts(document.querySelector("#chart4"), options);
      chart4.render();
    </script>

    <script type="text/javascript">
      var selected_pc = "<?= $selected_pc ?>";
      var options = {
        series: [{
          name: 'Sales',
          data: [<?= $overdue_aging; ?>]
        }],
        colors: ['#FF7F50'],
        chart: {
          height: 500,
          type: 'bar',
          color: '#008B8B',
          events: {
            click: function(event, chartContext, config, val) {
              // The last parameter config contains additional information like `seriesIndex` and `dataPointIndex` for cartesian charts
              // alert(config.dataPointIndex);
              if (config.dataPointIndex >= 0) {
              //   url: "load_prediksi2/";
              // $('#myModal').modal('show');
              var event_id = config.dataPointIndex;
              $.ajax({  
                url : "<?= base_url('Landingpage/load_det_overdue') ?>", 
                method:"POST",  
                data:{event_id:event_id, selected_pc:selected_pc},  
                success:function(data){
                  // alert(event_id);  
                  $('#det_overdue').html(data);  
                  $('#myModal').modal("show");  
                }  
              });
            }
          }
        }
      },
      plotOptions: {
        bar: {
          borderRadius: 10,
          dataLabels: {
              position: 'top', // top, center, bottom
            },
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return "IDR " + val.toLocaleString('en-US');
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        
        xaxis: {
          categories: ['Not Due', '1-30', '31-60', '61-90', '91-120', '121-180', '181-360', '>360'],
          position: 'bottom',
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          crosshairs: {
            fill: {
              type: 'gradient',
              gradient: {
                colorFrom: '#D8E3F0',
                colorTo: '#BED1E6',
                stops: [0, 100],
                opacityFrom: 0.4,
                opacityTo: 0.5,
              }
            }
          },
          tooltip: {
            enabled: true,
          }
        },
        yaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
            formatter: function (val) {
              return "IDR " + val.toLocaleString('en-US');
            }
          }

        },
        // title: {
        //   text: 'Sales Year To Date 2023',
        //   floating: true,
        //   offsetY:483,
        //   align: 'center',
        //   style: {
        //     color: '#444'
        //   }
        // }
      };

      var chart5 = new ApexCharts(document.querySelector("#chart5"), options);
      chart5.render();
    </script>

 <!--  <script type="text/javascript">
    var options = {
          series: [{
          name: 'Overdue',
          color: '#FF7F50',
          data: [<?= $overdue_aging; ?>],
        }],
          chart: {
          type: 'bar',
          height: 500,
          color: '#008B8B',
          events: {
            click: function(event, chartContext, config, val) {
              // The last parameter config contains additional information like `seriesIndex` and `dataPointIndex` for cartesian charts
              // alert(config.dataPointIndex);
              if (config.dataPointIndex >= 0) {
              //   url: "load_prediksi2/";
              // $('#myModal').modal('show');
              var event_id = config.dataPointIndex;
                $.ajax({  
                  url : "<?= base_url('Landingpage/load_det_overdue') ?>", 
                  method:"POST",  
                  data:{event_id:event_id},  
                  success:function(data){
                  // alert(event_id);  
                  $('#det_overdue').html(data);  
                   $('#myModal').modal("show");  
                }  
              });
              }
            }
          }
        },
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: true,
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function (val) {
              return "IDR " + val.toLocaleString('en-US');
            },
            offsetX: 0,
            style: {
                  color: '#373d3f',
                  fontSize: '11px',
                  fontFamily: undefined,
                  fontWeight: 600,
                },
        },
        xaxis: {
          categories: ['>360', '181-360', '121-180', '91-120', '61-90', '31-60', '1-30', 'Not Due'
          ],
          labels: {
    formatter: function (value) {
      return value.toLocaleString('en-US');
    }
  },
        },

         yaxis: {
          labels: {
            show: false,
            formatter: function (val) {
              return "IDR " + val.toLocaleString('en-US');
            }
          }
        
        }

        };

        var chart5 = new ApexCharts(document.querySelector("#chart5"), options);
        chart5.render();

        // function cobashow (){
        //   console.log('test');
        // }
      </script> -->

      <script>
        $(".apexcharts-yaxis").click(function(){
          var selecteddate = $(this).text();
          alert(selecteddate);
    // do something
  });
</script>

<script type="text/javascript">
  function animateValue(obj, start, end, duration) {
    let startTimestamp = null;
    const step = (timestamp) => {
      if (!startTimestamp) startTimestamp = timestamp;
      const progress = Math.min((timestamp - startTimestamp) / duration, 1);
      obj.innerHTML = Math.floor(progress * (end - start) + start);
      if (progress < 1) {
        window.requestAnimationFrame(step);
      }
    };
    window.requestAnimationFrame(step);
  }

  const obj = document.getElementById("value");
  animateValue(obj, 0, <?= $sls_ytd_inv; ?>, 2000);
</script>
<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    $('.toastrDefaultSuccess').click(function() {
      toastr.success('Data Berhasil Disimpan.')
    });

    $('.toastsDefaultDanger').click(function() {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Info',
        body: 'Data has been successfully canceled!'
      })
    });

  });
</script>

<!-- Select2 -->
<script>
  $(function() {
      //Initialize Select2 Elements
      $('.select2').select2()
      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
    });
  </script>

  <script type="text/javascript">
   $(document).ready(function() {
    $('.select2supp').select2({
      dropdownAutoWidth : true
    });
  });
</script>

<script >
  $('#addRow').click( function() {      
   var tableID = "table-sj";
   var table = document.getElementById(tableID);
   var rowCount = table.rows.length;
   var row = table.insertRow(rowCount);

   var element1 = "<tr><td><input  type='text' class='form-control' id='id_bppb' name='id_bppb' style='text-align:left; width: 250px;'></td><td><input  type='text' class='form-control' id='so_num' name='so_num' style='text-align:left; width: 250px;' ></td><td><input  type='text' class='form-control' id='bppb_num' name='bppb_num' style='text-align:left; width: 250px;' ></td><td><input  type='text' class='form-control' id='sjdate' name='sjdate' value='<?php echo date('Y-m-d'); ?>' style='text-align:left; width: 180px;' ></td><td><input  type='text' class='form-control' id='shipp_num' name='shipp_num' style='text-align:left; width: 250px;' ></td><td><input  type='text' class='form-control' id='ws' name='ws' style='text-align:left; width: 250px;' ></td><td><input  type='text' class='form-control' id='style' name='style' style='text-align:left; width: 250px;' ></td><td><input  type='text' class='form-control' id='prod_grup' name='prod_grup' style='text-align:left; width: 250px;' ></td><td><input  type='text' class='form-control' id='prod_item' name='prod_item' style='text-align:left; width: 250px;' ></td><td><input  type='text' class='form-control' id='color' name='color' style='text-align:left; width: 250px;' ></td><td><input  type='text' class='form-control' id='size' name='size' style='text-align:left; width: 100px;' ></td><td><select class='form-control select2bs4' name='curr' id='curr' style='width: 150px'> <option value='IDR' > IDR </option> <option value='USD' > USD </option> </select></td><td><input  type='text' class='form-control' id='uom' name='uom' style='text-align:left; width: 100px;' ></td><td><input  type='text' class='form-control' id='qty' name='qty' style='text-align:left; width: 150px;' ></td><td><input  type='text' class='form-control' id='price' name='price' style='text-align:right;width: 150px;' placeholder='0.00' onkeypress='javascript:return isNumber(event)' oninput='modal_input_price(value)'></td><td><input  type='text' class='form-control' id='disc' name='disc' style='text-align:right; width: 150px;' onkeypress='javascript:return isNumber(event)' oninput='modal_input_disk(value)'></td><td><input  type='text' class='form-control' id='total' name='total' style='text-align:right; width: 200px;' placeholder='0.00' readonly></td></tr>";
   row.innerHTML = element1; 
 }); 

  $('#deleteRow').click( function() {  
    var tableID = "table-sj";
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    console.log(rowCount);
    if(rowCount != 1) {   
     rowCount = rowCount - 1;
     table.deleteRow(rowCount);
   }   
 }); 
</script>

<script>
  $(function() {
    $('.selectpicker').selectpicker();
  });
</script>

<script >
  $('#add').click( function() {      
   var tableID = "table-sj";
   var table = document.getElementById(tableID);
   var rowCount = table.rows.length;
   var row = table.insertRow(rowCount);

   $(function() {
    $('.selectpicker').selectpicker();
  });

   $(document).ready(function() {
    $('.select2alok').select2({
      dropdownAutoWidth : true
    });
  });

   $(document).ready(function () {
    $('.tanggal').datepicker({
      format: "yyyy-mm-dd",
      autoclose:true,
      todayHighlight: true
    });
  });

   $coa = '';
   var element1 = '<tr> <td><select class="form-control select2alok" name="coa" style="width: 300px;" data-width="300px" data-live-search="true" data-size="5"> <option value="-" > - </option> <?php foreach ($coa as $coa) : ?> <option value="<?= $coa["id_coa"]; ?>"><?= $coa["id_coa"]; ?> <?= $coa["coa_name"]; ?> </option><?php endforeach; ?> </select></td> <td><select class="form-control select2alok" name="cost" id="cost" style="width: 250px" data-width="250px" data-live-search="true" data-size="5"> <option value="-" > - </option> <?php foreach ($cost_center as $cc) : ?> <option value="<?= $cc["code_cost"]; ?>"><?= $cc["cost_name"]; ?> </option><?php endforeach; ?> </select></td> <td><input  type="text" class="form-control" id="ref_number" name="ref_number" style="text-align:center; width: 180px;" autocomplete="off"></td> <td><input  type="text" class="form-control tanggal" id="ref_date" name="ref_date" value="<?php echo date("Y-m-d"); ?>" style="text-align:center; width: 150px;"  autocomplete="off"></td> <td><input  type="text" class="form-control tanggal" id="due_date" name="due_date" value="<?php echo date("Y-m-d"); ?>" style="text-align:center; width: 150px;"  autocomplete="off"></td> <td><input  type="text" class="form-control" id="total" name="total" style="text-align:center; width: 180px;"  autocomplete="off"></td> <td><input  type="text" class="form-control" id="discount" name="discount" style="text-align:center; width: 180px;"  autocomplete="off"></td> <td><input  type="text" class="form-control" id="amt" name="amt" style="text-align:center; width: 180px;" oninput="modal_input_amt(value)" autocomplete="off"></td> <td><input  type="text" class="form-control" id="discount" name="discount" style="text-align:center; width: 300px;"  autocomplete="off"></td><td><select class="form-control select2alok" name="profit_center" style="width: 300px;" data-width="300px" data-live-search="true" data-size="5"> <?php foreach ($profit_center as $pc) : ?> <option value="<?= $pc["kode_pc"]; ?>"> <?= $pc["nama_pc"]; ?> </option><?php endforeach; ?> </select></td> </tr>';
   row.innerHTML = element1; 
 }); 

  $('#delete').click( function() {  
    var tableID = "table-sj";
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    console.log(rowCount);
    if(rowCount != 1) {   
     rowCount = rowCount - 1;
     table.deleteRow(rowCount);
   }   
 }); 

</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('.select2_alkcoa').select2({
      dropdownAutoWidth : true
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#cr_usd').click(function() {
      $("#currn").val("USD");
        //Clear Value And Item Select
        document.getElementById('pay_type').innerText = null;
        //Add Value And Item In Select
        $('#pay_type').append($('<option>', {
          value: 'USD',
          text: 'USD'
        }));
        $('#pay_type').append($('<option>', {
          value: 'IDR',
          text: 'IDR'
        }));
      });

    $('#cr_idr').click(function() {
      $("#currn").val("IDR");
        //Clear Value And Item Select
        document.getElementById('pay_type').innerText = null;
        //Add Value And Item In Select       
        $('#pay_type').append($('<option>', {
          value: 'IDR',
          text: 'IDR'
        }));
      });
  });
</script>


<script>
  $(document).ready(function() {
    $('#cr_idr').click(function() {
      $("#currn").val("IDR");
      $("#rate").val("-");
      $("#pl_rate").val("");
      $("#am_awal").val("");
      $("#pl_awal").val("");
      $("#am_akhir").val("");
      $("#pl_akhir").val("");
      $("#rate_h").val("1");
      $("#rate").prop("readonly", true);
    });

    $('#cr_usd').click(function() {
      $("#currn").val("USD");
      $("#rate").val("");
      $("#pl_rate").val("");
      $("#am_awal").val("");
      $("#pl_awal").val("");
      $("#am_akhir").val("");
      $("#pl_akhir").val("");
      $("#rate").prop("readonly", false);
    });

  });
</script>

<!-- Type Shipp -->
<script>
  $(document).ready(function() {
    $('#L').click(function() {
      $("#shipp").val("Local");
        //Clear Value And Item Select
        document.getElementById('doc_type').innerText = null;
        //Add Value And Item In Select
        $('#doc_type').append($('<option>', {
          value: '',
          text: ''
        }));
        $('#doc_type').append($('<option>', {
          value: 'BC 4.1',
          text: 'BC 4.1'
        }));
        $('#doc_type').append($('<option>', {
          value: 'BC 25',
          text: 'BC 25'
        }));
        $('#doc_type').append($('<option>', {
          value: 'BC 27',
          text: 'BC 27'
        }));
      });

    $('#E').click(function() {
      $("#shipp").val("Export");
        //Clear Value And Item Select
        document.getElementById('doc_type').innerText = null;
        //Add Value And Item In Select       
        $('#doc_type').append($('<option>', {
          value: 'PEB',
          text: 'PEB'
        }));
      });
  });
</script>



<!-- Type Shipp Proforma -->
<script>
  $(document).ready(function() {
    $('#prof_L').click(function() {
      $("#prof_shipp").val("Local");
      $("#prof_peb").val("");
      $("#prof_peb").prop("readonly", true);
    });

    $('#prof_E').click(function() {
      $("#prof_shipp").val("Export");
      $("#prof_peb").prop("readonly", false);
    });

  });
</script>

<!-- ubah september -->
<script>
  $(document).ready(function() {
    $('#prof_L_cbd').click(function() {
      $("#prof_shipp_cbd").val("Local");
      $("#prof_peb").val("");
      $("#prof_peb").prop("readonly", true);
    });

    $('#prof_E_cbd').click(function() {
      $("#prof_shipp_cbd").val("Export");
      $("#prof_peb").prop("readonly", false);
    });

  });
</script>

<!--   ubah september -->
<script>
  $(document).ready(function() {
    $('#prof_C').click(function() {
      $("#prof_type_pi").val("CBD");
    });

    $('#prof_D').click(function() {
      $("#prof_type_pi").val("DP");
    });

  });
</script>

<!-- Type Shipp Return Invoice -->
<script>
  $(document).ready(function() {
    $('#rtn_L').click(function() {
      $("#rtn_shipp").val("Local");
      $("#rtn_peb").val("");
      $("#rtn_peb").prop("readonly", true);
    });

    $('#rtn_E').click(function() {
      $("#rtn_shipp").val("Export");
      $("#rtn_peb").prop("readonly", false);
    });

  });
</script>

<!-- DataTable example1  -->
<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<!-- DataTable example3  -->
<script>
  $(function() {
    $("#example3").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
    $('#example').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<!-- DataTable example4  -->
<!--   <script>
    $(function() {
      $("#example4").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
      $('#example').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script> -->

  <!-- Date Range Picker -->
  <script>
    $(function() {
      //Date range picker
      $('#reservation').daterangepicker()
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
          format: 'MM/DD/YYYY hh:mm A'
        }
      })
    })
  </script>

  <!-- Date Range Picker 2 -->
  <script>
    $(function() {
      //Date range picker
      $('#reservation2').daterangepicker()

      //Date range picker with time picker
      $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        // startDate: '05-05-2022',
        locale: {
          format: 'MM/DD/YYYY hh:mm A'
        }
      })
    })
  </script>


  <script>
    $(function() {
      //Date range picker
      $('#tgl_fil_memo').daterangepicker({
        minDate: '04/01/2022',
      })
    })
  </script>  

  <script>
    $(function() {
      //Date range picker
      $('#cobacoba').daterangepicker({
        minDate: '04/01/2022',
      })
    })
  </script>

  <script>
    $(function() {
      //Date range picker
      $('#cobacoba3').daterangepicker({
        minDate: '12/01/2022',
      })
    })
  </script>

  <!-- Date Range Picker 3 -->
  <script>
    $(function() {
      //Date range picker
      $('#reservationdate').datetimepicker({
        format: 'YYYY-MM-DD'
      });
    })
  </script>

  <script type="text/javascript">
    $(document).ready(function () {
      $('.tanggal').datepicker({
        format: "yyyy-mm-dd",
        autoclose:true
      });
    });
  </script>

  <!-- Date Range Picker 4 -->
  <script>
    $(function() {
      //Date range picker
      $('#reservationdate2').datetimepicker({
        format: 'YYYY-MM-DD'
      });
    })
  </script>

  <script>
    $(document).ready(function () {
      $('#profit_center').on('change', function () {
        selectedProfitCenter = $(this).val();

        $.ajax({
          url: "get_kode_book_invoice/" + selectedProfitCenter,
          type: "GET",
          dataType: "JSON",
          success: function (response) {
                rawInvoice = response; // contoh: "0052//NAG/0525"
                updateInvoiceNumber();
              },
              error: function () {
                alert('Gagal mengambil kode invoice dari server.');
              }
            });
      });
    });


    function get_kode_booking_invoice(shipCode) {
    selectedShipping = shipCode; // 'L' atau 'E'
    $('#shipp').val(shipCode);   // tampilkan di input readonly
    updateInvoiceNumber();
  }

let selectedShipping = '';        // 'L' atau 'E'
let selectedProfitCenter = '';    // 'NAG', 'NAK', dst
let rawInvoice = '';              // "0052//NAG/0525" dari server

function updateInvoiceNumber() {
  if (!rawInvoice) return;

    // Ambil prefix dan suffix dari invoice mentah
    const parts = rawInvoice.split('/');
    const prefix = parts[0];        // 0052
    const suffix = parts[3] || '';  // 0525
    const profit = selectedProfitCenter || parts[2]; // fallback ke yg ada di rawInvoice

    // Susun invoice baru
    let invoice = prefix;
    if (selectedShipping) invoice += '/' + selectedShipping;
    invoice += '/' + profit;
    if (suffix) invoice += '/' + suffix;

    $('#inv_book_number').val(invoice);
  }
</script>

<script>
function updateDN() {
    var pc = document.getElementById('profit_center_dn').value;
    var input = document.getElementById('dn_number');
    var current = input.value;

    // Jika sudah ada NAG atau NAK di tengah, ganti
    if (current.includes('/NAG/')) {
        input.value = current.replace('/NAG/', '/' + pc + '/');
    } else if (current.includes('/NAK/')) {
        input.value = current.replace('/NAK/', '/' + pc + '/');
    } else {
        // Kalau tidak ada, selipkan setelah DN
        var parts = current.split('/');
        if (parts.length >= 1 && parts[0] === 'DN') {
            // Pastikan tidak ada PC sebelumnya
            if (parts.length === 4) {
                parts[1] = pc; // ganti bagian ke-2
            } else {
                parts.splice(1, 0, pc); // selipkan
            }
            input.value = parts.join('/');
        }
    }
}
</script>




  </body>

  </html>