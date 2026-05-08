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

function number_format(number, decimals) {
    number = parseFloat(number).toFixed(decimals);
    return number.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

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
            let total_qty_bill = 0;
            let total_total_bill = 0;
            let total_other_bill = 0;
            let total_diskon_bill = 0;
            let total_twot_bill = 0;
            let total_dp_bill = 0;
            let total_vat_bill = 0;
            let total_grand_total_bill = 0;
            let total_total_bill_idr = 0;
            let total_other_bill_idr = 0;
            let total_diskon_bill_idr = 0;
            let total_twot_bill_idr = 0;
            let total_dp_bill_idr = 0;
            let total_vat_bill_idr = 0;
            let total_grand_total_bill_idr = 0;
            let total_qty_ship = 0;
            let total_total_ship = 0;
            let total_other_ship = 0;
            let total_diskon_ship = 0;
            let total_twot_ship = 0;
            let total_dp_ship = 0;
            let total_vat_ship = 0;
            let total_grand_total_ship = 0;
            let total_total_ship_idr = 0;
            let total_other_ship_idr = 0;
            let total_diskon_ship_idr = 0;
            let total_twot_ship_idr = 0;
            let total_dp_ship_idr = 0;
            let total_vat_ship_idr = 0;
            let total_grand_total_ship_idr = 0;
            let total_net_sales = 0;
            let total_vat_sales = 0;
            let total_grand_total_sales = 0;

            $.each(response, function (i, item) {

                total_qty_bill += parseFloat(item.qty_bill);
                total_total_bill += parseFloat(item.total_bill);
                total_other_bill += parseFloat(item.other_bill);
                total_diskon_bill += parseFloat(item.diskon_bill);
                total_twot_bill += parseFloat(item.twot_bill);
                total_dp_bill += parseFloat(item.dp_bill);
                total_vat_bill += parseFloat(item.vat_bill);
                total_grand_total_bill += parseFloat(item.grand_total_bill);
                total_total_bill_idr += parseFloat(item.total_bill_idr);
                total_other_bill_idr += parseFloat(item.other_bill_idr);
                total_diskon_bill_idr += parseFloat(item.diskon_bill_idr);
                total_twot_bill_idr += parseFloat(item.twot_bill_idr);
                total_dp_bill_idr += parseFloat(item.dp_bill_idr);
                total_vat_bill_idr += parseFloat(item.vat_bill_idr);
                total_grand_total_bill_idr += parseFloat(item.grand_total_bill_idr);
                total_qty_ship += parseFloat(item.qty_ship);
                total_total_ship += parseFloat(item.total_ship);
                total_other_ship += parseFloat(item.other_ship);
                total_diskon_ship += parseFloat(item.diskon_ship);
                total_twot_ship += parseFloat(item.twot_ship);
                total_dp_ship += parseFloat(item.dp_ship);
                total_vat_ship += parseFloat(item.vat_ship);
                total_grand_total_ship += parseFloat(item.grand_total_ship);
                total_total_ship_idr += parseFloat(item.total_ship_idr);
                total_other_ship_idr += parseFloat(item.other_ship_idr);
                total_diskon_ship_idr += parseFloat(item.diskon_ship_idr);
                total_twot_ship_idr += parseFloat(item.twot_ship_idr);
                total_dp_ship_idr += parseFloat(item.dp_ship_idr);
                total_vat_ship_idr += parseFloat(item.vat_ship_idr);
                total_grand_total_ship_idr += parseFloat(item.grand_total_ship_idr);
                total_net_sales += parseFloat(item.net_sales);
                total_vat_sales += parseFloat(item.vat_sales);
                total_grand_total_sales += parseFloat(item.grand_total_sales);

                trHTML += '<tr>';
                trHTML += '<td>' + (i + 1) + '</td>';					
                trHTML += '<td>' + item.customer + "</td>";
                trHTML += '<td>' + item.no_invoice + "</td>";	
                trHTML += '<td>' + item.tgl_inv + "</td>"; 
                trHTML += '<td>' + item.relasi + "</td>";	
                trHTML += '<td>' + item.cus_ctg + "</td>";
                trHTML += '<td>' + item.nama_pc + "</td>";
                trHTML += '<td>' + item.top + "</td>";   
                trHTML += '<td>' + item.type_so + "</td>"; 
                trHTML += '<td>' + item.shipp + "</td>"; 
                trHTML += '<td>' + item.type + "</td>";
                trHTML += '<td>' + item.no_faktur + "</td>";
                trHTML += '<td>' + item.tgl_faktur + "</td>";   
                trHTML += '<td>' + item.curr + "</td>";    
                trHTML += '<td align="right">' + number_format(item.rate,2) + "</td>";

                trHTML += '<td align="right">' + number_format(item.qty_bill,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.total_bill,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.other_bill,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.diskon_bill,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.twot_bill,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.dp_bill,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.vat_bill,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.grand_total_bill,2) + "</td>";

                trHTML += '<td align="right">' + number_format(item.qty_bill,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.total_bill_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.other_bill_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.diskon_bill_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.twot_bill_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.dp_bill_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.vat_bill_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.grand_total_bill_idr,2) + "</td>";

                trHTML += '<td align="right">' + number_format(item.qty_ship,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.total_ship,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.other_ship,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.diskon_ship,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.twot_ship,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.dp_ship,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.vat_ship,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.grand_total_ship,2) + "</td>";

                trHTML += '<td align="right">' + number_format(item.qty_ship,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.total_ship_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.other_ship_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.diskon_ship_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.twot_ship_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.dp_ship_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.vat_ship_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.grand_total_ship_idr,2) + "</td>";

                trHTML += '<td style="width:50px;background-color:#FFFFFF;border-top:1px solid #FFFFFF;border-bottom:1px solid #FFFFFF;">' + '' + "</td>";
                trHTML += '<td align="right">' + number_format(item.net_sales,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.vat_sales,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.grand_total_sales,2) + "</td>";

                trHTML += '</tr>';
            });

                trHTML += '<tr style="border-top: double 3px #000;">';
                trHTML += '<td style="text-align: right; font-weight: bold;"></td>';
                trHTML += '<td style="text-align: center; font-weight: bold;">TOTAL</td>';
                trHTML += '<td style="text-align: center; font-weight: bold;"></td>';
                trHTML += '<td style="text-align: center; font-weight: bold;"></td>';
                trHTML += '<td style="text-align: center; font-weight: bold;"></td>';
                trHTML += '<td style="text-align: center; font-weight: bold;"></td>';
                trHTML += '<td style="text-align: center; font-weight: bold;"></td>';
                trHTML += '<td style="text-align: center; font-weight: bold;"></td>';
                trHTML += '<td style="text-align: center; font-weight: bold;"></td>';
                trHTML += '<td style="text-align: center; font-weight: bold;"></td>';
                trHTML += '<td style="text-align: center; font-weight: bold;"></td>';
                trHTML += '<td style="text-align: center; font-weight: bold;"></td>';
                trHTML += '<td style="text-align: center; font-weight: bold;"></td>';
                trHTML += '<td style="text-align: center; font-weight: bold;"></td>';
                trHTML += '<td style="text-align: center; font-weight: bold;"></td>';
                trHTML += '<td align="right"><b>' + number_format(total_qty_bill, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_total_bill, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_other_bill, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_diskon_bill, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_twot_bill, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_dp_bill, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_vat_bill, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_grand_total_bill, 2) + '</b></td>';

                trHTML += '<td align="right"><b>' + number_format(total_qty_bill, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_total_bill_idr, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_other_bill_idr, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_diskon_bill_idr, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_twot_bill_idr, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_dp_bill_idr, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_vat_bill_idr, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_grand_total_bill_idr, 2) + '</b></td>';

                trHTML += '<td align="right"><b>' + number_format(total_qty_ship, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_total_ship, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_other_ship, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_diskon_ship, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_twot_ship, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_dp_ship, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_vat_ship, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_grand_total_ship, 2) + '</b></td>';

                trHTML += '<td align="right"><b>' + number_format(total_qty_ship, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_total_ship_idr, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_other_ship_idr, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_diskon_ship_idr, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_twot_ship_idr, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_dp_ship_idr, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_vat_ship_idr, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_grand_total_ship_idr, 2) + '</b></td>';
                trHTML += '<td style="width:50px;background-color:#FFFFFF;border-top:1px solid #FFFFFF;border-bottom:1px solid #FFFFFF;">' + '' + '</td>';
                trHTML += '<td align="right"><b>' + number_format(total_net_sales, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_vat_sales, 2) + '</b></td>';
                trHTML += '<td align="right"><b>' + number_format(total_grand_total_sales, 2) + '</b></td>';
                trHTML += '</tr>';

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
                trHTML += '<td>' + (i + 1) + '</td>';			
                trHTML += '<td>' + item.customer + "</td>";
                trHTML += '<td>' + item.no_invoice + "</td>";
                trHTML += '<td>' + item.tgl_inv + "</td>";
                trHTML += '<td>' + item.bppb_number + "</td>";
                trHTML += '<td>' + item.sj_date + "</td>";
                trHTML += '<td>' + item.grp + "</td>";
                trHTML += '<td>' + item.ws + "</td>";
                trHTML += '<td>' + item.styleno + "</td>";
                trHTML += '<td>' + item.produk + "</td>";
                trHTML += '<td>' + item.type_so + "</td>";
                trHTML += '<td>' + item.shipp + "</td>";
                trHTML += '<td>' + item.inv_type + "</td>";
                trHTML += '<td>' + item.no_faktur + "</td>";
                trHTML += '<td>' + item.tgl_faktur + "</td>";
                trHTML += '<td>' + item.curr + "</td>";
                trHTML += '<td>' + item.rate + "</td>";
                trHTML += '<td align="right">' + number_format(item.qty_bill,2) + "</td>";
                trHTML += '<td >' + item.uom_bill + "</td>";
                trHTML += '<td align="right">' + number_format(item.price_bill,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.total_bill,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.total_bill_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.qty_ship,2) + "</td>";
                trHTML += '<td >' + item.uom_ship + "</td>";
                trHTML += '<td align="right">' + number_format(item.price_ship,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.total_ship,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.total_ship_idr,2) + "</td>";
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

    $('#table-aging-ar tbody tr').remove(); 
    //Date range picker

    var id_customer = $('#sr_customer').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val(); 
    console.log(id_customer, start_date, end_date);

    $.ajax({        
        url: "cari_aging_jatem/" + id_customer + "/" + start_date + "/" + end_date + "/",                  
        type: "GET",
        dataType: "JSON",
        success: function (response) {

            var trHTML = '';
            let total_total = 0;
            let total_bln6 = 0;
            let total_bln5 = 0;
            let total_bln4 = 0;
            let total_bln3 = 0;
            let total_bln2 = 0;
            let total_bln1 = 0;
            let total_readydue = 0;
            let total_jatem1 = 0;
            let total_jatem31 = 0;
            let total_jatem61 = 0;
            let total_jatem91 = 0;

            $.each(response, function (i, item) {
                total_total += parseFloat(item.total);
                total_bln6 += parseFloat(item.hasil_bln6);
                total_bln5 += parseFloat(item.hasil_bln5);
                total_bln4 += parseFloat(item.hasil_bln4);
                total_bln3 += parseFloat(item.hasil_bln3);
                total_bln2 += parseFloat(item.hasil_bln2);
                total_bln1 += parseFloat(item.hasil_bln1);
                total_readydue += parseFloat(item.readydue);
                total_jatem1 += parseFloat(item.jatem1);
                total_jatem31 += parseFloat(item.jatem31);
                total_jatem61 += parseFloat(item.jatem61);
                total_jatem91 += parseFloat(item.jatem91);

                trHTML += '<tr>';
                trHTML += '<td align="center">' + (i + 1) + '</td>';
                trHTML += '<td>' + item.kode_customer + '</td>';
                trHTML += '<td>' + item.id_customer_show + '</td>';
                trHTML += '<td>' + item.customer + '</td>';
                trHTML += '<td>' + item.top + '</td>';
                trHTML += '<td align="right">' + number_format(item.total, 2) + '</td>';
                trHTML += '<td align="right">' + number_format(item.hasil_bln6, 2) + '</td>';
                trHTML += '<td align="right">' + number_format(item.hasil_bln5, 2) + '</td>';
                trHTML += '<td align="right">' + number_format(item.hasil_bln4, 2) + '</td>';
                trHTML += '<td align="right">' + number_format(item.hasil_bln3, 2) + '</td>';
                trHTML += '<td align="right">' + number_format(item.hasil_bln2, 2) + '</td>';
                trHTML += '<td align="right">' + number_format(item.hasil_bln1, 2) + '</td>';
                trHTML += '<td align="right">' + number_format(item.readydue, 2) + '</td>';
                trHTML += '<td align="center">' + item.ar_day + '</td>';
                trHTML += '<td align="right">' + number_format(item.jatem1, 2) + '</td>';
                trHTML += '<td align="right">' + number_format(item.jatem31, 2) + '</td>';
                trHTML += '<td align="right">' + number_format(item.jatem61, 2) + '</td>';
                trHTML += '<td align="right">' + number_format(item.jatem91, 2) + '</td>';
                trHTML += '</tr>';
            });

            trHTML += '<tr style="border-top: double 3px #000;">';
            trHTML += '<td colspan="5" style="text-align: center; font-weight: bold;">TOTAL</td>';
            trHTML += '<td align="right"><b>' + number_format(total_total, 2) + '</b></td>';
            trHTML += '<td align="right"><b>' + number_format(total_bln6, 2) + '</b></td>';
            trHTML += '<td align="right"><b>' + number_format(total_bln5, 2) + '</b></td>';
            trHTML += '<td align="right"><b>' + number_format(total_bln4, 2) + '</b></td>';
            trHTML += '<td align="right"><b>' + number_format(total_bln3, 2) + '</b></td>';
            trHTML += '<td align="right"><b>' + number_format(total_bln2, 2) + '</b></td>';
            trHTML += '<td align="right"><b>' + number_format(total_bln1, 2) + '</b></td>';
            trHTML += '<td align="right"><b>' + number_format(total_readydue, 2) + '</b></td>';
            trHTML += '<td></td>';
            trHTML += '<td align="right"><b>' + number_format(total_jatem1, 2) + '</b></td>';
            trHTML += '<td align="right"><b>' + number_format(total_jatem31, 2) + '</b></td>';
            trHTML += '<td align="right"><b>' + number_format(total_jatem61, 2) + '</b></td>';
            trHTML += '<td align="right"><b>' + number_format(total_jatem91, 2) + '</b></td>';
            trHTML += '</tr>';

            $('#table-aging-ar').append(trHTML);                

        },
        error: function (jqXHR, textStatus, errorThrown) {
            // alert('Error get data from ajax');
        }
    }); 
}

function export_aging_jatem(){ 
    var id_customer = $('#sr_customer').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val(); 
    window.open(".../../export_aging_jatem/" + id_customer + "/" + start_date + "/" + "/" + end_date + "/" );      
}


function cari_mut_ar(){ 

    $('#table-mut-ar tbody tr').remove(); 
    //Date range picker

    var id_customer = $('#sr_customer').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val(); 
    console.log(id_customer, start_date, end_date);

    $.ajax({        
        url: "cari_mut_ar/" + id_customer + "/" + start_date + "/" + end_date + "/",                  
        type: "GET",
        dataType: "JSON",
        success: function (response) {

            var trHTML = '';
            let total_sal_awl = 0;
            let total_tambah = 0;
            let total_tambah_ll = 0;
            let total_pelunasan = 0;
            let total_retur = 0;
            let total_pph_23 = 0;
            let total_other = 0;
            let total_sal_akhir = 0;

            $.each(response, function (i, item) {
                total_sal_awl += parseFloat(item.sal_awl);
                total_tambah += parseFloat(item.tambah);
                total_tambah_ll += parseFloat(item.tambah_ll);
                total_pelunasan += parseFloat(item.pelunasan);
                total_retur += parseFloat(item.retur);
                total_pph_23 += parseFloat(item.pph_23);
                total_other += parseFloat(item.other);
                total_sal_akhir += parseFloat(item.sal_akhir);

                trHTML += '<tr>';
                trHTML += '<td align="center">' + (i + 1) + '</td>';
                trHTML += '<td>' + item.kode_customer + '</td>';
                trHTML += '<td>' + item.id_customer_show + '</td>';
                trHTML += '<td>' + item.customer + '</td>';
                trHTML += '<td>' + item.top + '</td>';
                trHTML += '<td align="right">' + number_format(item.sal_awl, 2) + '</td>';
                trHTML += '<td align="right">' + number_format(item.tambah, 2) + '</td>';
                trHTML += '<td align="right">' + number_format(item.tambah_ll, 2) + '</td>';
                trHTML += '<td align="right">' + number_format(item.pelunasan, 2) + '</td>';
                trHTML += '<td align="right">' + number_format(item.retur, 2) + '</td>';
                trHTML += '<td align="right">' + number_format(item.pph_23, 2) + '</td>';
                trHTML += '<td align="right">' + number_format(item.other, 2) + '</td>';
                trHTML += '<td align="right">' + number_format(item.sal_akhir, 2) + '</td>';
                trHTML += '<td>' + item.ar_day + '</td>';
                trHTML += '</tr>';
            });

            trHTML += '<tr style="border-top: double 3px #000;">';
            trHTML += '<td colspan="5" style="text-align: center; font-weight: bold;">TOTAL</td>';
            trHTML += '<td align="right"><b>' + number_format(total_sal_awl, 2) + '</b></td>';
            trHTML += '<td align="right"><b>' + number_format(total_tambah, 2) + '</b></td>';
            trHTML += '<td align="right"><b>' + number_format(total_tambah_ll, 2) + '</b></td>';
            trHTML += '<td align="right"><b>' + number_format(total_pelunasan, 2) + '</b></td>';
            trHTML += '<td align="right"><b>' + number_format(total_retur, 2) + '</b></td>';
            trHTML += '<td align="right"><b>' + number_format(total_pph_23, 2) + '</b></td>';
            trHTML += '<td align="right"><b>' + number_format(total_other, 2) + '</b></td>';
            trHTML += '<td align="right"><b>' + number_format(total_sal_akhir, 2) + '</b></td>';
            trHTML += '<td></td>';
            trHTML += '</tr>';

            $('#table-mut-ar').append(trHTML);                

        },
        error: function (jqXHR, textStatus, errorThrown) {
            // alert('Error get data from ajax');
        }
    }); 
}


function cari_sales_report_detail_material() { 

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
        url: "cari_sales_report_detail_material/" + periode_dari_mt + "/" + periode_sampai_mt + "/" + id_customer_mt + "/" + shipp_mt + "/" + type_mt + "/" + curr_mt + "/" + type_so_mt + "/",                    
        type: "GET",
        dataType: "JSON",
        success: function (response) {

            var trHTML = '';
            $.each(response, function (i, item) {                   
                trHTML += '<tr>';       
                trHTML += '<td>' + (i + 1) + '</td>';           
                trHTML += '<td>' + item.customer + "</td>";
                trHTML += '<td>' + item.no_invoice + "</td>";
                trHTML += '<td>' + item.tgl_inv + "</td>";
                trHTML += '<td>' + item.bppb_number + "</td>";
                trHTML += '<td>' + item.sj_date + "</td>";
                trHTML += '<td>' + item.grp + "</td>";
                trHTML += '<td>' + item.ws + "</td>";
                trHTML += '<td>' + item.styleno + "</td>";
                trHTML += '<td>' + item.produk + "</td>";
                trHTML += '<td>' + item.type_so + "</td>";
                trHTML += '<td>' + item.shipp + "</td>";
                trHTML += '<td>' + item.inv_type + "</td>";
                trHTML += '<td>' + item.no_faktur + "</td>";
                trHTML += '<td>' + item.tgl_faktur + "</td>";
                trHTML += '<td>' + item.curr + "</td>";
                trHTML += '<td>' + item.rate + "</td>";

                trHTML += '<td align="right">' + number_format(item.qty_bill,2) + "</td>";
                trHTML += '<td >' + item.uom_bill + "</td>";
                trHTML += '<td align="right">' + number_format(item.price_bill,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.gross_bill,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.other_bill,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.diskon_bill,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.net_bill,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.dp_bill,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.vat_bill,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.total_bill,2) + "</td>";

                trHTML += '<td align="right">' + number_format(item.qty_ship,2) + "</td>";
                trHTML += '<td >' + item.uom_ship + "</td>";
                trHTML += '<td align="right">' + number_format(item.price_ship,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.gross_ship,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.other_ship,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.diskon_ship,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.net_ship,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.dp_ship,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.vat_ship,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.total_ship,2) + "</td>";

                trHTML += '<td align="right">' + number_format(item.qty_bill,2) + "</td>";
                trHTML += '<td >' + item.uom_bill + "</td>";
                trHTML += '<td align="right">' + number_format(item.price_bill_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.gross_bill_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.other_bill_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.diskon_bill_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.net_bill_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.dp_bill_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.vat_bill_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.total_bill_idr,2) + "</td>";

                trHTML += '<td align="right">' + number_format(item.qty_ship,2) + "</td>";
                trHTML += '<td >' + item.uom_ship + "</td>";
                trHTML += '<td align="right">' + number_format(item.price_ship_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.gross_ship_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.other_ship_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.diskon_ship_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.net_ship_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.dp_ship_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.vat_ship_idr,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.total_ship_idr,2) + "</td>";
                trHTML += '</tr>';
            });



            $('#table-sales-report-material').append(trHTML);               

        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    }); 
}

function export_sales_report_detail_material(){ 
    var id_customer_mt = $('#sr_customer_mt').val();
    var shipp_mt = $('#sr_type_mt').val();
    var type_mt = $('#sr_type_inv_mt').val(); 
    var curr_mt = $('#sr_curr_mt').val();
    var type_so_mt = $('#sr_order_type_mt').val();
    window.open(".../../export_sales_report_detail_material/" + periode_dari_mt + "/" + periode_sampai_mt + "/" + "/" + id_customer_mt + "/" + shipp_mt + "/" + type_mt + "/" + curr_mt + "/" + type_so_mt + "/" ); 
}

function export_mut_ar(){ 
    var id_customer = $('#sr_customer').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val(); 
    window.open(".../../export_mut_ar/" + id_customer + "/" + start_date + "/" + "/" + end_date + "/" );      
}

function renderProjectionHeader(from, to) {

    let start = new Date(from);
    let end   = new Date(to);

    let dates = [];

    // generate tanggal
    let bulanEng = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

while(start <= end){
    let d = new Date(start);

    let tgl = d.getDate(); // tanpa 0 depan
    let bln = bulanEng[d.getMonth()];
    let thn = d.getFullYear();

    dates.push(tgl + ' ' + bln + ' ' + thn);

    start.setDate(start.getDate() + 1);
}

    let colCount = dates.length;

    let thead = `
        <tr>
            <th style="width:30px;background-color: #FFE4C4;" rowspan="2">No</th>
            <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Customer</th>
            <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Reff Number</th>
            <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Reff Date</th>
            <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Category</th>
            <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Due Date</th>
            <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Due Date Update</th>
            <th style="width:200px;background-color: #FFE4C4;" rowspan="2">TOP</th>
            <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Curr</th>
            <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Total</th>
            <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Rate</th>
            <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Total IDR</th>
            <th style="background-color: #90EE90;" colspan="${colCount}">Duedate Projection</th>
        </tr>
        <tr>
    `;

    dates.forEach(function(tgl){
        thead += `<th style="width:150px;background-color: #90EE90;">${tgl}</th>`;
    });

    thead += `</tr>`;

    $('#table-projection-report thead').html(thead);

    return dates.length; // penting untuk dipakai di bawah
}

function formatTgl(dateStr){
    if(!dateStr) return '';

    let d = new Date(dateStr + 'T00:00:00'); // aman timezone

    let bulanEng = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

    let tgl = d.getDate();
    let bln = bulanEng[d.getMonth()];
    let thn = d.getFullYear();

    return tgl + ' ' + bln + ' ' + thn;
}

function cari_projection_report(){ 

    $('#table-projection-report tbody tr').remove(); 
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
    var from = $('#filter_from').val();
    var to = $('#filter_to').val();  
    console.log(id_customer, from, to);

    let totalHari = renderProjectionHeader(from, to);

    $.ajax({        
        url: "cari_projection_report/" + id_customer + "/" + from + "/" + to + "/",                  
        type: "GET",
        dataType: "JSON",
        success: function (response) {

            let trHTML = '';
            let total_amount = 0;
            let total_amount_idr = 0;
            let totals = {};

            // =========================
            // LOOP DATA
            // =========================
            $.each(response, function (i, item) {

                total_amount += parseFloat(item.amount || 0);
                total_amount_idr += parseFloat(item.amount_idr || 0);

                trHTML += '<tr>';
                trHTML += '<td>' + (i + 1) + '</td>';                   
                trHTML += '<td>' + item.customer + "</td>";
                trHTML += '<td>' + item.no_invoice + "</td>";   
                trHTML += '<td>' + formatTgl(item.inv_date) + "</td>"; 
                trHTML += '<td>' + item.shipp + "</td>";   
                trHTML += '<td>' + formatTgl(item.duedate) + "</td>";   
                trHTML += '<td>' + formatTgl(item.duedate_update) + "</td>"; 
                trHTML += '<td>' + item.top + "</td>"; 
                trHTML += '<td>' + item.curr + "</td>";    

                trHTML += '<td align="right">' + number_format(item.amount,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.rate,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.amount_idr,2) + "</td>";

                // =========================
                // KOLOM DINAMIS
                // =========================
                for(let j = 1; j <= totalHari; j++){
                    let key = 'data' + j;
                    let val = parseFloat(item[key]) || 0;

                    trHTML += '<td align="right">' + number_format(val,2) + "</td>";

                    if(!totals[key]) totals[key] = 0;
                    totals[key] += val;
                }

                trHTML += '</tr>';
            });

            // =========================
            // TOTAL ROW
            // =========================
            trHTML += '<tr style="border-top: double 3px #000;">';

            trHTML += '<td></td>';
            trHTML += '<td align="center"><b>TOTAL</b></td>';

            for(let i = 0; i < 7; i++){
                trHTML += '<td></td>';
            }

            trHTML += '<td align="right"><b>' + number_format(total_amount, 2) + '</b></td>';
            trHTML += '<td></td>';
            trHTML += '<td align="right"><b>' + number_format(total_amount_idr, 2) + '</b></td>';

            // TOTAL DINAMIS
            for(let j = 1; j <= totalHari; j++){
                let key = 'data' + j;
                let val = totals[key] || 0;

                trHTML += '<td align="right"><b>' + number_format(val, 2) + '</b></td>';
            }

            trHTML += '</tr>';

            $('#table-projection-report tbody').html(trHTML);
        },
        error: function () {
            alert('Error get data from ajax');
        }
    }); 
}

function export_projection_report(){

    let id_customer = $('#sr_customer').val();
    let from = $('#filter_from').val();
    let to   = $('#filter_to').val();

    if(!from || !to){
        alert('Tanggal harus diisi!');
        return;
    }

    let url = "cari_projection_report/" + id_customer + "/" + from + "/" + to;

    window.open(url, '_blank');
}
