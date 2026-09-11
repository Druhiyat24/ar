let id_customer;

function number_format(number, decimals) {
    number = parseFloat(number).toFixed(decimals);
    return number.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

//Sales Report
function cari_sales_report(){

	$('#table-sales-report tbody tr').remove();

    var from = $('#filter_from').val();
    var to = $('#filter_to').val();
    var id_customer = $('#sr_customer').val();
    var shipp = $('#sr_type').val();
    var type = $('#sr_type_inv').val();
    var curr = $('#sr_curr').val();
    var type_so = $('#sr_order_type').val();
    console.log(id_customer, shipp, type, curr, type_so);

    $.ajax({
        url: "cari_sales_report/" + from + "/" + to + "/" + id_customer + "/" + shipp + "/" + type + "/" + curr + "/" + type_so + "/",					
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
    var from = $('#filter_from').val();
    var to = $('#filter_to').val();

    window.open(".../../sales_report/" + from + "/" + to + "/" + "/" + id_customer + "/" + shipp + "/" + type + "/" + curr + "/" + type_so + "/" );

}

//Sales Report Per Material
function cari_sales_report_material() {

	$('#table-sales-report-material tbody tr').remove();

    var from = $('#filter_from').val();
    var to = $('#filter_to').val();
    var id_customer_mt = $('#sr_customer_mt').val();
    var shipp_mt = $('#sr_type_mt').val();
    var type_mt = $('#sr_type_inv_mt').val();
    var curr_mt = $('#sr_curr_mt').val();
    var type_so_mt = $('#sr_order_type_mt').val();

    console.log(id_customer_mt, shipp_mt, type_mt, curr_mt, type_so_mt);

    $.ajax({
        url: "cari_sales_report_material/" + from + "/" + to + "/" + id_customer_mt + "/" + shipp_mt + "/" + type_mt + "/" + curr_mt + "/" + type_so_mt + "/",					
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

    var from = $('#filter_from').val();
    var to = $('#filter_to').val();

    $.ajax({
        url: "cari_outstanding_pi/" + from + "/" + to + "/",					
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
    var from = $('#filter_from').val();
    var to = $('#filter_to').val();
    window.open(".../../report_outstanding_pi/" + from + "/" + to + "/" );
}

//Export To Excel
//Sales Report
function export_sales_report(){
    var id_customer = $('#sr_customer').val();
    var shipp = $('#sr_type').val();
    var type = $('#sr_type_inv').val();
    var curr = $('#sr_curr').val();
    var type_so = $('#sr_order_type').val();
    var from = $('#filter_from').val();
    var to = $('#filter_to').val();
    window.open(".../../export_sales_report/" + from + "/" + to + "/" + "/" + id_customer + "/" + shipp + "/" + type + "/" + curr + "/" + type_so + "/" );
}

//Sales Report Per Material
function export_sales_report_material(){
    var id_customer_mt = $('#sr_customer_mt').val();
    var shipp_mt = $('#sr_type_mt').val();
    var type_mt = $('#sr_type_inv_mt').val();
    var curr_mt = $('#sr_curr_mt').val();
    var type_so_mt = $('#sr_order_type_mt').val();
    var from = $('#filter_from').val();
    var to = $('#filter_to').val();
    window.open(".../../export_sales_report_material/" + from + "/" + to + "/" + "/" + id_customer_mt + "/" + shipp_mt + "/" + type_mt + "/" + curr_mt + "/" + type_so_mt + "/" );
}

function print_sales_report_material(){
    var id_customer_mt = $('#sr_customer_mt').val();
    var shipp_mt = $('#sr_type_mt').val();
    var type_mt = $('#sr_type_inv_mt').val();
    var curr_mt = $('#sr_curr_mt').val();
    var type_so_mt = $('#sr_order_type_mt').val();
    var from = $('#filter_from').val();
    var to = $('#filter_to').val();

    window.open(".../../sales_report_material/" + from + "/" + to + "/" + "/" + id_customer_mt + "/" + shipp_mt + "/" + type_mt + "/" + curr_mt + "/" + type_so_mt + "/" );

}

//Outstanding PI
function export_outstanding_pi(){
    var from = $('#filter_from').val();
    var to = $('#filter_to').val();
    window.open(".../../export_outstanding_pi/" + from + "/" + to + "/" );
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

    var from = $('#filter_from').val();
    var to = $('#filter_to').val();
    var id_customer_mt = $('#sr_customer_mt').val();
    var shipp_mt = $('#sr_type_mt').val();
    var type_mt = $('#sr_type_inv_mt').val();
    var curr_mt = $('#sr_curr_mt').val();
    var type_so_mt = $('#sr_order_type_mt').val();

    console.log(id_customer_mt, shipp_mt, type_mt, curr_mt, type_so_mt);

    $.ajax({
        url: "cari_sales_report_detail_material/" + from + "/" + to + "/" + id_customer_mt + "/" + shipp_mt + "/" + type_mt + "/" + curr_mt + "/" + type_so_mt + "/",                    
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
    var from = $('#filter_from').val();
    var to = $('#filter_to').val();
    window.open(".../../export_sales_report_detail_material/" + from + "/" + to + "/" + "/" + id_customer_mt + "/" + shipp_mt + "/" + type_mt + "/" + curr_mt + "/" + type_so_mt + "/" );
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
            <th style="width:30px;" rowspan="2">No</th>
            <th style="width:200px;" rowspan="2">Customer</th>
            <th style="width:200px;" rowspan="2">Invoice No</th>
            <th style="width:200px;" rowspan="2">Invoice Date</th>
            <th style="width:200px;" rowspan="2">Destination</th>
            <th style="width:150px;" rowspan="2">Order Type</th>
            <th style="width:200px;" rowspan="2">Due Date</th>
            <th style="width:200px;" rowspan="2">Expected Collection Date</th>
            <th style="width:200px;" rowspan="2">Payment Term</th>
            <th style="width:200px;" rowspan="2">Currency</th>
            <th style="width:200px;" rowspan="2">Invoice Amount</th>
            <th style="width:200px;" rowspan="2">Rate</th>
            <th class="grp-recv" colspan="5">Receivable Amount</th>
            <th class="grp-proj" colspan="${colCount}">Projected Cash Inflow from Accounts Receivable</th>
        </tr>
        <tr>
            <th class="sub-recv" style="width:150px;">Tax Base</th>
            <th class="sub-recv" style="width:150px;">VAT</th>
            <th class="sub-recv" style="width:150px;">Total Invoice</th>
            <th class="sub-recv" style="width:150px;">Income Tax Art 23</th>
            <th class="sub-recv" style="width:150px;">Collection Amount</th>
    `;

    dates.forEach(function(tgl){
        thead += `<th class="sub-proj" style="width:150px;">${tgl}</th>`;
    });

    thead += `</tr>`;

    $('#table-projection-report thead').html(thead);

    // Hitung top row-2 via fungsi di view
    if (typeof fixProjHeaderRow2 === 'function') {
        setTimeout(fixProjHeaderRow2, 0);
    }

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

// Overlay-nya sendiri menutup tabel secara visual, tapi kontainer scroll di
// belakangnya (#proj-table-wrap) tetap bisa digulir lewat wheel/scrollbar
// selama masih loading - kelihatan aneh. Kunci overflow-nya sementara pas
// loading tampil, kembalikan lagi setelah selesai.
function _showProjLoader() {
    var wrap = document.getElementById('proj-table-wrap');
    // Overlay loader diposisikan absolute di dalam area scroll, jadi ikut
    // tergeser. Kalau tabel sedang digeser, kartu loader-nya keluar layar dan
    // yang terlihat cuma sisa lapisan putihnya - balikkan dulu ke kiri-atas.
    wrap.scrollTop  = 0;
    wrap.scrollLeft = 0;
    document.getElementById('proj-loader').classList.add('show');
    wrap.style.overflow = 'hidden';
}
function _hideProjLoader() {
    document.getElementById('proj-loader').classList.remove('show');
    document.getElementById('proj-table-wrap').style.overflow = 'auto';
}

function cari_projection_report(){

    $('#table-projection-report tbody tr').remove();
    $('#table-projection-report tfoot').empty();

    var id_customer = $('#sr_customer').val();
    var from        = $('#filter_from').val();
    var to          = $('#filter_to').val();
    var type        = $('#filter_type').val() || 'daily';

    // ── Validasi tanggal sesuai type ──
    if (from && to) {
        var dFrom = new Date(from + 'T00:00:00');
        var dTo   = new Date(to   + 'T00:00:00');
        var diffDays = Math.round((dTo - dFrom) / (1000 * 60 * 60 * 24));

        if (type === 'weekly') {
            // Harus Minggu s/d Sabtu (7 hari, diff = 6)
            var isSun  = dFrom.getDay() === 0; // Sunday
            var isSab  = dTo.getDay()   === 6; // Saturday
            var is7day = diffDays === 6;
            if (!isSun || !isSab || !is7day) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Date Range',
                    html: 'Weekly type requires a <b>Sunday to Saturday</b> range (exactly 7 days).<br>' +
                          '<small class="text-muted">From must be Sunday, To must be Saturday.</small>',
                    confirmButtonColor: '#3949ab'
                });
                return;
            }
        } else if (type === 'monthly') {
            // Harus hari pertama s/d hari terakhir bulan yang sama
            var isFirstDay = dFrom.getDate() === 1;
            var sameMonth  = dFrom.getMonth()     === dTo.getMonth() &&
                             dFrom.getFullYear()  === dTo.getFullYear();
            var lastDay    = new Date(dTo.getFullYear(), dTo.getMonth() + 1, 0).getDate();
            var isLastDay  = dTo.getDate() === lastDay;
            if (!isFirstDay || !sameMonth || !isLastDay) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Date Range',
                    html: 'Monthly type requires a <b>full month</b> range (1st to last day of the same month).',
                    confirmButtonColor: '#3949ab'
                });
                return;
            }
        }
    }

    let totalHari = renderProjectionHeader(from, to);

    _showProjLoader();

    $.ajax({
        url: "cari_projection_report/" + id_customer + "/" + from + "/" + to + "/" + type + "/",
        type: "GET",
        dataType: "JSON",
        success: function (response) {

            let trHTML = '';
            let total_amount = 0;
            let total_amount_idr = 0;
            let total_tax_base = 0;
            let total_tax_vat = 0;
            let total_invoice = 0;
            let total_income_tax_23 = 0;
            let total_collection_amount = 0;
            let totals = {};

            // =========================
            // LOOP DATA
            // =========================
            // Simpan tiap baris supaya modal detail bisa langsung menampilkan
            // headernya tanpa request ulang ke server.
            if (typeof PROJ_ROWS !== 'undefined') { PROJ_ROWS = {}; }

            $.each(response, function (i, item) {

                if (typeof PROJ_ROWS !== 'undefined') { PROJ_ROWS[item.no_invoice] = item; }

                total_amount += parseFloat(item.amount || 0);
                total_amount_idr += parseFloat(item.amount_idr || 0);
                total_tax_base += parseFloat(item.tax_base || 0);
                total_tax_vat += parseFloat(item.tax_vat || 0);
                total_invoice += parseFloat(item.total_invoice || 0);
                total_income_tax_23 += parseFloat(item.income_tax_23 || 0);
                total_collection_amount += parseFloat(item.collection_amount || 0);

                trHTML += '<tr>';
                trHTML += '<td>' + (i + 1) + '</td>';                   
                trHTML += '<td>' + item.customer + "</td>";
                trHTML += '<td><a href="javascript:void(0)" class="inv-link" data-no="' +
                          item.no_invoice + '">' + item.no_invoice + '</a></td>';
                trHTML += '<td>' + formatTgl(item.inv_date) + "</td>"; 
                trHTML += '<td>' + item.shipp + "</td>";
                trHTML += '<td>' + (item.type_so || '-') + "</td>";
                trHTML += '<td>' + formatTgl(item.duedate) + "</td>";
                trHTML += '<td>' + formatTgl(item.duedate_update) + "</td>"; 
                trHTML += '<td>' + item.top + "</td>"; 
                trHTML += '<td>' + item.curr + "</td>";    

                trHTML += '<td align="right">' + number_format(item.amount,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.rate,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.tax_base,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.tax_vat,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.total_invoice,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.income_tax_23,2) + "</td>";
                trHTML += '<td align="right">' + number_format(item.collection_amount,2) + "</td>";

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
            // TOTAL ROW - ditaruh di tfoot supaya nempel di bawah waktu discroll
            // dan tidak ikut kesaring waktu pakai kotak Search.
            // =========================
            let tfHTML = '';

            if (response.length) {
                tfHTML += '<tr>';

                tfHTML += '<td></td>';
                tfHTML += '<td align="center">TOTAL</td>';

                for(let i = 0; i < 8; i++){
                    tfHTML += '<td></td>';
                }

                tfHTML += '<td align="right">' + number_format(total_amount, 2) + '</td>';
                tfHTML += '<td></td>';
                tfHTML += '<td align="right">' + number_format(total_tax_base, 2) + '</td>';
                tfHTML += '<td align="right">' + number_format(total_tax_vat, 2) + '</td>';
                tfHTML += '<td align="right">' + number_format(total_invoice, 2) + '</td>';
                tfHTML += '<td align="right">' + number_format(total_income_tax_23, 2) + '</td>';
                tfHTML += '<td align="right">' + number_format(total_collection_amount, 2) + '</td>';

                // TOTAL DINAMIS
                for(let j = 1; j <= totalHari; j++){
                    let key = 'data' + j;
                    let val = totals[key] || 0;

                    tfHTML += '<td align="right">' + number_format(val, 2) + '</td>';
                }

                tfHTML += '</tr>';
            }

            $('#table-projection-report tbody').html(trHTML);
            $('#table-projection-report tfoot').html(tfHTML);

            $('#proj-row-count')
                .text(response.length.toLocaleString('en-US') + ' rows')
                .toggle(response.length > 0);

            // Teks yang masih ada di kotak Search diterapkan lagi ke data yang
            // baru (sekaligus menghitung ulang posisi kolom beku).
            if (typeof applyProjSearch === 'function') {
                applyProjSearch();
            } else if (typeof setProjFreezeOffsets === 'function') {
                setProjFreezeOffsets();
            }
            if (typeof fixProjHeaderRow2 === 'function') {
                fixProjHeaderRow2();
            }

            _hideProjLoader();
        },
        error: function () {
            _hideProjLoader();
            Swal.fire({ icon: 'error', title: 'Error', text: 'Error get data from ajax' });
        }
    });
}

function export_projection_report(){

    let id_customer = $('#sr_customer').val();
    let from        = $('#filter_from').val();
    let to          = $('#filter_to').val();
    let type        = $('#filter_type').val() || 'daily';

    if(!from || !to){
        alert('Tanggal harus diisi!');
        return;
    }

    let url = "export_projection_report/" + id_customer + "/" + from + "/" + to + "/" + type;

    window.open(url, '_blank');
}

function save_history_projection_report(){
    let id_customer = $('#sr_customer').val();
    let from        = $('#filter_from').val();
    let to          = $('#filter_to').val();
    let type        = $('#filter_type').val() || 'daily';

    if (!from || !to) {
        Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Tanggal From dan To harus diisi!' });
        return;
    }

    let fromDate = new Date(from);
    let toDate   = new Date(to);
    let diffDays = Math.round((toDate - fromDate) / (1000 * 60 * 60 * 24)) + 1;

    if (type === 'weekly') {
        if (diffDays !== 7) {
            Swal.fire({ icon: 'error', title: 'Validasi Weekly', text: 'Periode Weekly harus tepat 7 hari. Saat ini ' + diffDays + ' hari.' });
            return;
        }
    }

    if (type === 'monthly') {
        let lastDay = new Date(fromDate.getFullYear(), fromDate.getMonth() + 1, 0);
        if (fromDate.getDate() !== 1) {
            Swal.fire({ icon: 'error', title: 'Validasi Monthly', text: 'Tanggal From harus dimulai dari tanggal 1.' });
            return;
        }
        if (fromDate.getFullYear() !== toDate.getFullYear() || fromDate.getMonth() !== toDate.getMonth()) {
            Swal.fire({ icon: 'error', title: 'Validasi Monthly', text: 'Monthly hanya diperbolehkan dalam 1 bulan yang sama.' });
            return;
        }
        if (toDate.getDate() !== lastDay.getDate()) {
            Swal.fire({ icon: 'error', title: 'Validasi Monthly', text: 'Tanggal To harus akhir bulan (tanggal ' + lastDay.getDate() + ').' });
            return;
        }
    }

    Swal.fire({
        title: 'Save History',
        text: 'Simpan data projection sebagai history ' + type + ' (' + from + ' s/d ' + to + ')?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal'
    }).then(function(result) {
        if (result.isConfirmed) {
            $.ajax({
                url: 'save_history_projection_report/' + id_customer + '/' + from + '/' + to + '/',
                type: 'POST',
                data: { type: type },
                dataType: 'JSON',
                success: function(res) {
                    if (res.status === 'success') {
                        Swal.fire({ icon: 'success', title: 'Tersimpan!', text: 'Doc Number: ' + res.doc_number });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: res.message || 'Tidak ada data untuk disimpan.' });
                    }
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan saat menyimpan.' });
                }
            });
        }
    });
}
