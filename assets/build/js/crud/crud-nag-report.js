let periode_dari;
let periode_sampai;
let periode_dari_mt;
let periode_sampai_mt;
let periode_dari_pi;
let periode_sampai_pi;
let id_customer;
//
$(document).ready(function () {

    $('input[name="reservation"]').on('apply.daterangepicker', function (ev, picker) {
        periode_dari  = picker.startDate.format('YYYY-MM-DD');
        periode_sampai = picker.endDate.format('YYYY-MM-DD');
        //
        periode_dari_mt  = picker.startDate.format('YYYY-MM-DD');
        periode_sampai_mt = picker.endDate.format('YYYY-MM-DD');
        //
        periode_dari_pi  = picker.startDate.format('YYYY-MM-DD');
        periode_sampai_pi = picker.endDate.format('YYYY-MM-DD');
        //
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
       
    });
	
});

//Sales Report
function cari_sales_report(){ 
       
	$('#table-sales-report tbody tr').remove();	
    //Date range picker
    $('input[name="reservation"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('input[name="reservation"]').on('apply.daterangepicker', function (ev, picker) {
       periode_dari = picker.startDate.format('YYYY-MM-DD');
       periode_sampai = picker.endDate.format('YYYY-MM-DD');
       $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    $('input[name="reservation"]').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
        periode_dari   = "undefined";
        periode_sampai = "undefined";
    });

    var id_customer = $('#sr_customer').val();
    var shipp = $('#sr_type').val();
    var type = $('#sr_type_inv').val();	
    var curr = $('#sr_curr').val();
    var type_so = $('#sr_order_type').val(); 
    console.log(id_customer, shipp, type, curr, type_so);
                        
        $.ajax({		
            url: "cari_sales_report/" + periode_dari + "/" + periode_sampai + "/" + id_customer + "/" + shipp + "/" + type + "/" + curr + "/" + type_so + "/",					
            type: "GET",
            dataType: "JSON",
            success: function (response) {
                                    
            var trHTML = '';
            $.each(response, function (i, item) { 					
                    trHTML += '<tr>';					
                    trHTML += '<td>' + item.customer + "</td>";
                    trHTML += '<td>' + item.no_invoice + "</td>";	
                    trHTML += '<td>' + item.tgl_inv + "</td>";
                    trHTML += '<td>' + '' + "</td>";
                    trHTML += '<td>' + item.no_faktur + "</td>";
                    trHTML += '<td>' + item.tgl_faktur + "</td>";   
                    trHTML += '<td>' + item.top + "</td>";        
                    trHTML += '<td>' + item.type_so + "</td>";               
                    trHTML += '<td>' + item.shipp + "</td>";
                    trHTML += '<td>' + item.type + "</td>";	
                    trHTML += '<td align="right">' + item.qty + "</td>"; 
                    trHTML += '<td align="right">' + item.qty_ship + "</td>";   
                    trHTML += '<td>' + item.curr + "</td>";	
                    trHTML += '<td>' + item.rate + "</td>";    
                    trHTML += '<td align="right">' + item.total + "</td>";
                    trHTML += '<td align="right">' + item.total_ship + "</td>";
                    trHTML += '<td align="right">' + item.total2 + "</td>";
                    trHTML += '<td align="right">' + item.total2_ship + "</td>";
                    trHTML += '<td>' + item.vat + "</td>";	
                    // trHTML += '<td>' + '' + "</td>";
                    // trHTML += '<td>' + item.no_faktur + "</td>";
                    // trHTML += '<td>' + item.tgl_faktur + "</td>";
                                                               
                    trHTML += '</tr>';
                });

                    $('#table-sales-report').append(trHTML);				
        
            },
                   error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error get data from ajax');
            }
        });	
}

function print_sales_report(){ 
    var id_customer = $('#sr_customer').val();
    var shipp = $('#sr_type').val();
    var type = $('#sr_type_inv').val(); 
    var curr = $('#sr_curr').val();
    var type_so = $('#sr_order_type').val();
       
    window.open(".../../sales_report/" + periode_dari + "/" + periode_sampai + "/" + "/" + id_customer + "/" + shipp + "/" + type + "/" + curr + "/" + type_so + "/" );      

}

//Sales Report Per Material
function cari_sales_report_material() { 
      
	$('#table-sales-report-material tbody tr').remove();	
    //Date range picker
    $('input[name="reservation"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('input[name="reservation"]').on('apply.daterangepicker', function (ev, picker) {
       periode_dari_mt = picker.startDate.format('YYYY-MM-DD');
       periode_sampai_mt = picker.endDate.format('YYYY-MM-DD');
       $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    $('input[name="reservation"]').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
        periode_dari_mt   = "undefined";
        periode_sampai_mt = "undefined";
    });

    var id_customer_mt = $('#sr_customer_mt').val();
    var shipp_mt = $('#sr_type_mt').val();
    var type_mt = $('#sr_type_inv_mt').val(); 
    var curr_mt = $('#sr_curr_mt').val();
    var type_so_mt = $('#sr_order_type_mt').val(); 

    console.log(id_customer_mt, shipp_mt, type_mt, curr_mt, type_so_mt);

        $.ajax({		
            url: "cari_sales_report_material/" + periode_dari_mt + "/" + periode_sampai_mt + "/" + id_customer_mt + "/" + shipp_mt + "/" + type_mt + "/" + curr_mt + "/" + type_so_mt + "/",					
            type: "GET",
            dataType: "JSON",
            success: function (response) {
                                    
            var trHTML = '';
            $.each(response, function (i, item) { 					
                    trHTML += '<tr>';					
                    trHTML += '<td>' + item.customer + "</td>";
                    trHTML += '<td>' + item.no_invoice + "</td>";	
                    trHTML += '<td>' + item.tgl_inv + "</td>";
                    trHTML += '<td>' + item.bppb_number + "</td>";
                    trHTML += '<td>' + item.sj_date + "</td>";
                    trHTML += '<td>' + item.grp + "</td>";
                    trHTML += '<td>' + item.material + "</td>";
                    trHTML += '<td>' + item.styleno + "</td>";
                    trHTML += '<td>' + item.produk + "</td>";
                    trHTML += '<td align="right">' + item.qty + "</td>";
                    trHTML += '<td>' + item.uom + "</td>";
                    trHTML += '<td align="right">' + item.unit_price + "</td>";
                    trHTML += '<td>' + item.type_ + "</td>";
                    trHTML += '<td>' + item.inv_type + "</td>";
                    trHTML += '<td>' + item.type_so + "</td>";
                    trHTML += '<td>' + item.curr + "</td>";
                    trHTML += '<td>' + item.rate + "</td>";
                    trHTML += '<td align="right">' + item.total_price + "</td>";
                    trHTML += '<td>' + item.total2 + "</td>";
                    // trHTML += '<td>' + '' + "</td>";
                    trHTML += '<td>' + item.no_faktur + "</td>";
                    trHTML += '<td>' + item.tgl_faktur + "</td>";
                                                               
                    trHTML += '</tr>';
                });

                    $('#table-sales-report-material').append(trHTML);				
        
            },
                   error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error get data from ajax');
            }
        });	
}


//Outstanding PI
function cari_outstanding_pi(){ 
    
	$('#table-outstanding-pi tbody tr').remove();	
    //Date range picker
    $('input[name="reservation"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('input[name="reservation"]').on('apply.daterangepicker', function (ev, picker) {
       periode_dari_pi = picker.startDate.format('YYYY-MM-DD');
       periode_sampai_pi = picker.endDate.format('YYYY-MM-DD');
       $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    $('input[name="reservation"]').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
        periode_dari_pi   = "undefined";
        periode_sampai_pi = "undefined";
    });

    //var id_customer = $('#sr_customer').val();	
                        
        $.ajax({		
            url: "cari_outstanding_pi/" + periode_dari_pi + "/" + periode_sampai_pi + "/",					
            type: "GET",
            dataType: "JSON",
            success: function (response) {
                                    
            var trHTML = '';
            $.each(response, function (i, item) { 					
                    trHTML += '<tr>';					
                    trHTML += '<td>' + item.customer + "</td>";
                    trHTML += '<td>' + item.no_proforma_invoice + "</td>";	
                    trHTML += '<td>' + item.tgl_proforma_inv + "</td>";
                    trHTML += '<td>' + item.shipp + "</td>";
                    trHTML += '<td>' + item.type_barang + "</td>";
                    trHTML += '<td align="center">' + item.top + "</td>";
                    trHTML += '<td>' + item.duedate + "</td>"; 
                    trHTML += '<td align="center">' + item.curr + "</td>";  
                    trHTML += '<td align="right">' + item.total_price + "</td>";                             
                                                               
                    trHTML += '</tr>';
                });

                    $('#table-outstanding-pi').append(trHTML);				
        
            },
                   error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error get data from ajax');
            }
        });	
}

function print_outstanding_pi() { 
    window.open(".../../report_outstanding_pi/" + periode_dari_pi + "/" + periode_sampai_pi + "/" ); 
}

//Export To Excel
//Sales Report
function export_sales_report(){ 
    var id_customer = $('#sr_customer').val();
    var shipp = $('#sr_type').val();
    var type = $('#sr_type_inv').val(); 
    var curr = $('#sr_curr').val();
    var type_so = $('#sr_order_type').val();
    window.open(".../../export_sales_report/" + periode_dari + "/" + periode_sampai + "/" + "/" + id_customer + "/" + shipp + "/" + type + "/" + curr + "/" + type_so + "/" );      
}

//Sales Report Per Material
function export_sales_report_material(){ 
    var id_customer_mt = $('#sr_customer_mt').val();
    var shipp_mt = $('#sr_type_mt').val();
    var type_mt = $('#sr_type_inv_mt').val(); 
    var curr_mt = $('#sr_curr_mt').val();
    var type_so_mt = $('#sr_order_type_mt').val();
    window.open(".../../export_sales_report_material/" + periode_dari_mt + "/" + periode_sampai_mt + "/" + "/" + id_customer_mt + "/" + shipp_mt + "/" + type_mt + "/" + curr_mt + "/" + type_so_mt + "/" ); 
}

function print_sales_report_material(){ 
    var id_customer_mt = $('#sr_customer_mt').val();
    var shipp_mt = $('#sr_type_mt').val();
    var type_mt = $('#sr_type_inv_mt').val(); 
    var curr_mt = $('#sr_curr_mt').val();
    var type_so_mt = $('#sr_order_type_mt').val();
    
    //window.open("http://10.10.2.179/ar-nag/report/sales_report_material/" + periode_dari_mt + "/" + periode_sampai_mt + "/" ); 
    window.open(".../../sales_report_material/" + periode_dari_mt + "/" + periode_sampai_mt + "/" + "/" + id_customer_mt + "/" + shipp_mt + "/" + type_mt + "/" + curr_mt + "/" + type_so_mt + "/" ); 

}

//Outstanding PI
function export_outstanding_pi(){ 
    window.open(".../../export_outstanding_pi/" + periode_dari_pi + "/" + periode_sampai_pi + "/" ); 
}

function cari_aging_jatem(){ 
       
    $('#table-sales-report tbody tr').remove(); 
    //Date range picker

    var id_customer = $('#sr_customer').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val(); 
    console.log(id_customer, start_date, end_date);
                        
        // $.ajax({        
        //     url: "cari_aging_jatem/" + periode_dari + "/" + periode_sampai + "/" + id_customer + "/" + shipp + "/" + type + "/" + curr + "/" + type_so + "/",                  
        //     type: "GET",
        //     dataType: "JSON",
        //     success: function (response) {
                                    
        //     var trHTML = '';
        //     $.each(response, function (i, item) {                   
        //             trHTML += '<tr>';                   
        //             trHTML += '<td>' + item.customer + "</td>";
        //             trHTML += '<td>' + item.no_invoice + "</td>";   
        //             trHTML += '<td>' + item.tgl_inv + "</td>";
        //             trHTML += '<td>' + '' + "</td>";
        //             trHTML += '<td>' + item.no_faktur + "</td>";
        //             trHTML += '<td>' + item.tgl_faktur + "</td>";   
        //             trHTML += '<td>' + item.top + "</td>";        
        //             trHTML += '<td>' + item.type_so + "</td>";               
        //             trHTML += '<td>' + item.shipp + "</td>";
        //             trHTML += '<td>' + item.type + "</td>"; 
        //             trHTML += '<td align="right">' + item.qty + "</td>"; 
        //             trHTML += '<td align="right">' + item.qty_ship + "</td>";   
        //             trHTML += '<td>' + item.curr + "</td>"; 
        //             trHTML += '<td>' + item.rate + "</td>";    
        //             trHTML += '<td align="right">' + item.total + "</td>";
        //             trHTML += '<td align="right">' + item.total_ship + "</td>";
        //             trHTML += '<td align="right">' + item.total2 + "</td>";
        //             trHTML += '<td align="right">' + item.total2_ship + "</td>";
        //             trHTML += '<td>' + item.vat + "</td>";                                        
        //             trHTML += '</tr>';
        //         });

        //             $('#table-sales-report').append(trHTML);                
        
        //     },
        //            error: function (jqXHR, textStatus, errorThrown) {
        //                 alert('Error get data from ajax');
        //     }
        // }); 
}

