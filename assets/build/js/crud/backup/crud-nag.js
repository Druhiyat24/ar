var save_method; //for save method string
var table;
let dt_dari_book_inv
let dt_sampai_book_inv
let dt_dari
let dt_sampai
let dt_dari_so
let dt_sampai_so
let dt_dari_inv
let dt_sampai_inv
let dt_dari_inv_dd
let dt_sampai_inv_dd
let dt_dari_so_prof
let dt_sampai_so_prof
let dt_dari_prof_inv
let dt_sampai_prof_inv
let dt_dari_rtn_inv
let dt_sampai_rtn_inv
let dt_dari_rtn_sjbpb
let dt_sampai_rtn_sjbpb
let dt_dari_approv
let dt_sampai_approv
let dt_dari_invkwt
let dt_sampai_invkwt
let dt_dari_kwt
let dt_sampai_kwt
let dt_dari_alk
let dt_sampai_alk
let dt_dari_debnote
let dt_sampai_debnote
let dt_dari_memo
let dt_sampai_memo
let dt_dari_sj
let dt_sampai_sj
var Toast
var base_url = '<?php echo base_url();?>';

//Load Date 
$(document).ready(function () {
	$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
		dt_dari_inv = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_inv = picker.endDate.format('YYYY-MM-DD');
        // 
        dt_dari_prof_inv = picker.startDate.format('YYYY-MM-DD');
        dt_sampai_prof_inv = picker.endDate.format('YYYY-MM-DD');		
		//
		dt_dari_inv_dd = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_inv_dd = picker.endDate.format('YYYY-MM-DD');	
		//	
		dt_dari_so = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_so = picker.endDate.format('YYYY-MM-DD');	
		//
		dt_dari_approv = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_approv = picker.endDate.format('YYYY-MM-DD');
		//
		dt_dari_rtn_sjbpb   = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_rtn_sjbpb = picker.endDate.format('YYYY-MM-DD');
		//
		dt_dari_rtn_inv = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_rtn_inv = picker.endDate.format('YYYY-MM-DD');
		//
		dt_dari_so_prof = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_so_prof = picker.endDate.format('YYYY-MM-DD');
		//
		dt_dari_book_inv = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_book_inv = picker.endDate.format('YYYY-MM-DD');

		dt_dari_kwt = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_kwt = picker.endDate.format('YYYY-MM-DD');

		dt_dari_alk = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_alk = picker.endDate.format('YYYY-MM-DD');

		dt_dari_invkwt = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_invkwt = picker.endDate.format('YYYY-MM-DD');

		dt_dari_sj = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_sj = picker.endDate.format('YYYY-MM-DD');

		//
		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));

	});	
});


$(document).ready(function () {
	$('input[name="cobacoba"]').on('apply.daterangepicker', function (ev, picker) {

		dt_dari_alk = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_alk = picker.endDate.format('YYYY-MM-DD');

		dt_dari_invkwt = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_invkwt = picker.endDate.format('YYYY-MM-DD');
		//
		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));

	});	
});

$(document).ready(function () {
	$('input[name="cobacoba3"]').on('apply.daterangepicker', function (ev, picker) {

		dt_dari_debnote = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_debnote = picker.endDate.format('YYYY-MM-DD');
		//
		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));

	});	
});


$(document).ready(function () {
	$('input[name="tgl_fil_memo"]').on('apply.daterangepicker', function (ev, picker) {

		dt_dari_memo = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_memo = picker.endDate.format('YYYY-MM-DD');
		//
		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));

	});	
});

$(document).ready(function () {
	$('input[name="reservation"]').on('apply.daterangepicker', function (ev, picker) {      
		dt_dari = picker.startDate.format('YYYY-MM-DD');
		dt_sampai = picker.endDate.format('YYYY-MM-DD');	
		//
		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));

	});	
});

//
//Cari TOP
$(document).ready(function () {

	// $("select").change(function () {
	// 	$(this).parent().parent().removeClass('has-error');
	// 	$(this).next().empty();
	// });
	//
	// TOP Create Invoice
	document.querySelector("#find_top").addEventListener("click", function(){		
		cari_top()
	})	
});

//Cari Proforma TOP
$(document).ready(function () {		
	// TOP Proforma Invoice
	document.querySelector("#prof_find_top").addEventListener("click", function(){		
		cari_prof_top()
	})
});

//Alert
$(document).ready(function () {		
	// Alert 
	Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 3000
	});
	//
	$('.swalDefaultError').click(function() {
		
	});	
});

function muncul_pesan() { 
	Toast.fire({
		icon: 'error',
		title: 'Sory!!!, File Tidak Bisa di Update'
	})
}

function message_validation(title){ 
	Toast.fire({
		icon: 'info',
		title: title
	})
}

// function get_kode_booking_invoice(kode) 
// {	
// 	$.ajax({
// 		url: "get_kode_book_invoice/" + kode,		
// 		type: "GET",
// 		dataType: "JSON",
// 		success: function (id) {

// 			$('[name="inv_book_number"]').val(id);

// 		},
// 		error: function (jqXHR, textStatus, errorThrown) {
// 			alert('Error get data from ajax');
// 		}
// 	});
// }

function modal_book_invoice() {	
	
	let shipp_book  = $('[name="shipp"]').val();	
	let doc_type    = $('[name="doc_type"]').val();	
	let doc_number  = $('[name="doc_number"]').val();	
	let val         = $('[name="val"]').val();
	let profit_center = $('[name="profit_center"]').val();

       	//Message Validation
       	if (profit_center == "") {
       		let title = "profit center is required!"
       		message_validation(title);		 
       		$("#profit_center").focus();			  
       		return false;
       	}

       	if (shipp_book == "") {
       		let title = "Shipp is required!"
       		message_validation(title);		 
       		$("#shipp").focus();			  
       		return false;
       	}

       	if (doc_type == "") {
       		let title = "Document type is required!"
       		message_validation(title);			
       		$("#doc_type").focus();			  
       		return false;
       	}

       	if (doc_number == "") {		
       		let title = "Document number is required!"
       		message_validation(title);		
       		$("#doc_number").focus();			  
       		return false;
       	}

       	if (val == "") {			
       		let title = "Value is required!"
       		message_validation(title);		
       		$("#val").focus();			  
       		return false;
       	}

       	$('#modal-add-booking-invoice').modal('show')	 	  

       	$idbook = $('[name="inv_book_number"]').val()	
       	$idcust = $('[name="customer"]').val()	
       	$typeshipp = $('[name="shipp"]').val()	
       	$doc_type = $('[name="doc_type"]').val()
       	$doc_number = $('[name="doc_number"]').val()
       	$typevalue    = $('[name="val"]').val()
       	$typecomm = $('[name="type"]').val()
       	$mdl_pc = $('[name="profit_center"]').val()		
	//
	$('[name="id_inv"]').val($idbook);
	$('[name="id_cust"]').val($idcust);
	$('[name="type_shipp"]').val($typeshipp);
	$('[name="type_doc"]').val($doc_type);
	$('[name="type_doc_number"]').val($doc_number);
	$('[name="type_val"]').val($typevalue);
	$('[name="type_comm"]').val($typecomm)
	$('[name="mdl_pc"]').val($mdl_pc);		
}



function getType(id, shipp, status) {
	
    //Cek status shipp local	
    if (status != "DRAFT") { 
    	muncul_pesan();
    } else {
	//	
	$('.form-group').removeClass('has-error'); // clear error class
	$('.help-block').empty(); // clear error string
	//Ajax Load data from ajax
	$.ajax({
		url: "getType/" + id,
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			
			$('[name="id_book_inv"]').val(data.id);	
			$('[name="doc_number_mdl"]').val(data.doc_number);	
			$('[name="type_mdl"]').val(data.id_type);
			$('[name="no_inv"]').val(data.no_invoice);
			$('[name="docum_type"]').val(data.doc_type);
			$('[name="amount"]').val(data.value);
			//
			$('#modal-update').modal('show'); // show bootstrap modal when complete loaded
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

	//Before Filter Shipp Local
	//
	// $('.form-group').removeClass('has-error'); // clear error class
	// $('.help-block').empty(); // clear error string
	
	// //Ajax Load data from ajax
	// $.ajax({
	// 	url: "getType/" + id,
	// 	type: "GET",
	// 	dataType: "JSON",
	// 	success: function (data) {

	// 		$('[name="id_book_inv"]').val(data.id);	
	// 		$('[name="peb_mdl"]').val(data.peb);	
	// 		$('[name="type_mdl"]').val(data.id_type);
	// 		$('[name="no_inv"]').val(data.no_invoice);
	// 		//
	// 		$('#modal-update').modal('show'); // show bootstrap modal when complete loaded

	// 	},
	// 	error: function (jqXHR, textStatus, errorThrown) {
	// 		alert('Error get data from ajax');
	// 	}
	// });
	
}

function loadbookinvoice(){
	
	$('#table-booking-invoice tbody tr').remove();	

		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_book_inv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_book_inv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_book_inv = "undefined";
			dt_sampai_book_inv = "undefined";
		});

		var id_customer = $('#book_customer').val();
		var status = $('#book_status').val();

		$.ajax({		
			url: "loadbookinvoice/" + dt_dari_book_inv + "/" + dt_sampai_book_inv + "/" + id_customer + "/" + status + "/",		
			type: "GET",
			dataType: "JSON",
			success: function (response) {
				
				var trHTML = '';
				$.each(response, function (i, item) {
					trHTML += '<tr>';					
					trHTML += '<td>' + item.no_invoice + "</td>";
					trHTML += '<td>' + item.customer + "</td>";			
					trHTML += '<td>' + item.shipp + "</td>";				
					trHTML += '<td>' + item.tanggal + "</td>";
					trHTML += '<td>' + item.type + "</td>";
					trHTML += '<td>' + item.status + "</td>";
					trHTML += '<td>' + item.doc_type + "</td>";
					trHTML += '<td>' + item.doc_number + "</td>";
					trHTML += '<td>' + item.value + "</td>";	
					trHTML += '<td><button type="button" class="btn btn-sm btn-primary swalDefaultError" href="javascript:void(0)" onclick="getType(\'' + item.id + '\',\'' + item.shipp + '\', \'' + item.status + '\')">Update</button> ' + '' + ' <button type="button" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="cancel_booking_invoice(\'' + item.id + '\',\'' + item.no_invoice + '\',\'' + item.status + '\')">Cancel</button></td>';			

					trHTML += '</tr>';
				});

				$('#table-booking-invoice').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	
	}

	function cancel_booking_invoice(id, no_invoice, status){ 

		let status_inv  = status;		
    //Status Post And Approved Tidak Bisa Di Cancel
    if (status_inv == "POST" || status_inv == "APPROVED") {
    	let title = "Invoice status POST dan APPROVED tidak bisa di cancel!"
    	message_validation(title);	    		  
    	return false;
    }

    $('#txt_cancel_book').val(no_invoice);
    $('#id_book_inv').val(id);
    $('#modal-cancel-book').modal('show');  

}

function cancel_invoice(id, no_invoice, status){ 

	let status_inv  = status;		

	$('#txt_cancel_book').val(no_invoice);
	$('#id_book_inv').val(id);
	$('#modal-cancel-inv').modal('show');  

}

//ubah september
function cari_bi() {

	$('#table-add-bi tbody tr').remove();	

		//Date range picker
		$('input[name="reservation"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari = picker.startDate.format('YYYY-MM-DD');
			dt_sampai = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari = "undefined";
			dt_sampai = "undefined";
		});

		$.ajax({		
			url: "cari_bi/" + dt_dari + "/" + dt_sampai + "/",		
			type: "GET",
			dataType: "JSON",
			success: function (response) {
				
				var trHTML = '';
				$.each(response, function (i, item) {
					if (item.eqv_idr != '0') {
						trHTML += '<tr>';	
						trHTML += '<td><button id="add_bi" name="add_bi" type="button" class="btn btn-success btn-sm" onclick="add_no_bi()">Add</td>';
						trHTML += '<td>' + item.doc_num + "</td>";
						trHTML += '<td>' + item.customer + "</td>";			
						trHTML += '<td>' + item.date + "</td>";
						trHTML += '<td>' + item.id_bank + "</td>";
						trHTML += '<td>' + item.bank + "</td>";
						trHTML += '<td>' + item.akun + "</td>";
						trHTML += '<td>' + item.curr + "</td>";
						trHTML += '<td align="right">' + item.amount + "</td>";
						trHTML += '<td align="right">' + item.rate + "</td>";
						trHTML += '<td align="right">' + item.eqv_idr + "</td>";
						trHTML += '<td>' + item.Id_Supplier + "</td>";
						trHTML += '</tr>';
					}else{
					}
				});


				$('#table-add-bi').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	
	}

	function cari_book_inv() {

		$('#table-add-bookinvoice tbody tr').remove();	

		//Date range picker
		$('input[name="reservation"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari = picker.startDate.format('YYYY-MM-DD');
			dt_sampai = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari = "undefined";
			dt_sampai = "undefined";
		});

		$.ajax({		
			url: "cari_book_inv/" + dt_dari + "/" + dt_sampai + "/",		
			type: "GET",
			dataType: "JSON",
			success: function (response) {
				
				var trHTML = '';
				$.each(response, function (i, item) {
					trHTML += '<tr>';	
					trHTML += '<td><button id="add_book_inv" name="add_book_inv" type="button" class="btn btn-success btn-sm" onclick="add_no_book_inv()">Add</td>';
					trHTML += '<td>' + item.no_invoice + "</td>";
					trHTML += '<td>' + item.customer + "</td>";			
					trHTML += '<td>' + item.shipp + "</td>";
					trHTML += '<td>' + item.doc_type + "</td>";
					trHTML += '<td>' + item.doc_number + "</td>";
					trHTML += '<td>' + item.tanggal + "</td>";
					trHTML += '<td>' + item.type + "</td>";
					trHTML += '<td>' + item.status + "</td>";
					trHTML += '<td>' + item.id_customer + "</td>";
					trHTML += '<td>' + item.id + "</td>";
					trHTML += '<td align="right">' + item.amount + "</td>";
					trHTML += '<td align="right">' + item.profit_center + "</td>";
					trHTML += '</tr>';
				});

				$('#table-add-bookinvoice').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	
	}

	function add_no_book_inv() {

		var table = document.getElementById("table-add-bookinvoice");
		var rows = table.getElementsByTagName("tr");	
		for (i = 0; i < rows.length; i++) {
			var currentRow = table.rows[i];
			var createClickHandler = function(row) {
				return function() {
		  // Var Cell	
		  var no_inv_cell     = row.getElementsByTagName("td")[1];
		  var cust_cell       = row.getElementsByTagName("td")[2];
		  var shipp_cell      = row.getElementsByTagName("td")[3];
		  var doc_type_cell   = row.getElementsByTagName("td")[4];
		  var doc_number_cell = row.getElementsByTagName("td")[5];
		  var type_cell       = row.getElementsByTagName("td")[7];	
		  var id_cust_cell    = row.getElementsByTagName("td")[9];
		  var id_inv_cell     = row.getElementsByTagName("td")[10];	
		  var amount_cell     = row.getElementsByTagName("td")[11];
		  var profit_center     = row.getElementsByTagName("td")[12].innerHTML;			
		  //
		  var no_inv     = no_inv_cell.innerHTML;	
		  var cust       = cust_cell.innerHTML;
		  var shipp      = shipp_cell.innerHTML;
		  var doc_type   = doc_type_cell.innerHTML;
		  var doc_number = doc_number_cell.innerHTML;
		  var type       = type_cell.innerHTML; 
		  var id_cust    = id_cust_cell.innerHTML; 
		  var id_inv     = id_inv_cell.innerHTML; 
		  var amount     = amount_cell.innerHTML; 
		  //
		  document.getElementById("inv_number1").value = no_inv;
		  document.getElementById("profit_ctr_h").value = profit_center;
		  document.getElementById("cust").value = cust;
		  document.getElementById("shipp").value = shipp;
		  document.getElementById("doc_type").value = doc_type;
		  document.getElementById("doc_number").value = doc_number;
		  document.getElementById("type").value = type;	
		  document.getElementById("id_cust").value = id_cust;	
		  document.getElementById("id_inv").value = id_inv;	 
		  document.getElementById("amount").value = amount;	 	  
		  
		};
	};
	currentRow.onclick = createClickHandler(currentRow);
}	

$('#modal-add-no-booking-invoice').modal('hide');	

}


//ubah september
function add_no_bi() {
	
	var pay_type  = $('#pay_type').val();
	var table = document.getElementById("table-add-bi");
	var rows = table.getElementsByTagName("tr");
	for (i = 0; i < rows.length; i++) {
		var currentRow = table.rows[i];
		var createClickHandler = function(row) {
			return function() {
		  // Var Cell	
		  var no_bi_cell     	= row.getElementsByTagName("td")[1];
		  var cust_cell       	= row.getElementsByTagName("td")[2];
		  var date_cell      	= row.getElementsByTagName("td")[3];
		  var id_bank_cell   	= row.getElementsByTagName("td")[4];
		  var bank_cell 		= row.getElementsByTagName("td")[5];
		  var akun_cell       	= row.getElementsByTagName("td")[6];	
		  var curr_cell    		= row.getElementsByTagName("td")[7];
		  var amount_cell     	= row.getElementsByTagName("td")[8];	
		  var rate_cell     	= row.getElementsByTagName("td")[9];		
		  var eqv_idr_cell     	= row.getElementsByTagName("td")[10];	
		  var id_cust_cell      = row.getElementsByTagName("td")[11];	
		  //
		  var no_bi     	= no_bi_cell.innerHTML;	
		  var cust       	= cust_cell.innerHTML;
		  var date      	= date_cell.innerHTML;
		  var id_bank   	= id_bank_cell.innerHTML;
		  var bank 			= bank_cell.innerHTML;
		  var akun       	= akun_cell.innerHTML; 
		  var curr    		= curr_cell.innerHTML; 
		  var amount     	= amount_cell.innerHTML; 
		  var rate     		= rate_cell.innerHTML; 
		  var eqv_idr     	= eqv_idr_cell.innerHTML; 
		  var id_cust      	= id_cust_cell.innerHTML;

		  if(curr == 'IDR' && pay_type == 'USD'){
		  	$('input[name=rate]').prop('readonly', false);
		  }else{
		  	$('input[name=rate]').prop('readonly', true);
		  }
		  //
		  ubahnomor_alo(date);
		  document.getElementById("alo_date").value = date;
		  document.getElementById("cust").value = cust;
		  document.getElementById("customer").value = id_cust;
		  document.getElementById("doc_number").value = no_bi;
		  document.getElementById("id_bank").value = id_bank;
		  document.getElementById("bank").value = bank;
		  document.getElementById("acc").value = akun;
		  document.getElementById("rate").value = rate;
		  document.getElementById("currn").value = curr;		
		  document.getElementById("pl_rate").value =formatMoney(rate);	
		  document.getElementById("rate_h").value = rate;	 
		  document.getElementById("am_awal").value = amount;
		  document.getElementById("pl_awal").value =formatMoney(amount);
		  document.getElementById("pl_akhir").value = eqv_idr;
		  document.getElementById("am_akhir").value =formatMoney(eqv_idr); 	  
		  
		};
	};
	currentRow.onclick = createClickHandler(currentRow);
}	

$('#modal-add-no-bi').modal('hide');	

}

//ubah september
function gantitype(curr){
	var currn  = $('#currn').val();
	if(currn == 'IDR' && curr == 'USD'){
		$('input[name=rate]').prop('readonly', false);
	}else{
		$('input[name=rate]').prop('readonly', true);
		document.getElementById("rate").value = 1;
		document.getElementById("pl_rate").value =formatMoney(1);
		document.getElementById("rate_h").value = 1;
	}

}

function clear_component() {
	//cari_book_inv();
	$('#inv_number1').val("");
	$('#cust').val("");
	$('#shipp').val("");
	$('#doc_type').val("");
	$('#doc_number').val("");
	$('#amount').val("");
	$('#type').val("");
	$('#id_cust').val("");
	$('#table-add-bookinvoice tbody tr').remove();
	$('#table-sj tbody tr').remove();
	$('#top').val("");
	$('#top_time').val("");
	$('#so_number1').val("");
	$('#id_sj').val("");
	$('#id_inv').val("");
	$('#id_top').val("");
	//Clear Value : Total, Discount, Down Payment, Return, Total With Out Tax, VAT, Grand Total
	$('#total').val("");
	$('#discount').val("");
	$('#dp').val("");
	$('#return').val("");
	$('#twot').val("");
	$('#vat').val("");
	$('#grandtotal').val("");	
	
}

function modal_clear_component() {

	//Hapus Table invoice detail temporary
	delete_invoice_detail_temporary()	
	//Clear Value : Total, Discount, Down Payment, Return, Total With Out Tax, VAT, Grand Total
	$('#mdl_total').val("");
	$('#mdl_discount').val("");
	$('#mdl_dp').val("");
	$('#mdl_return').val("");
	$('#mdl_twot').val("");
	$('#mdl_vat').val("");
	$('#mdl_grandtotal').val("");		
	
}

function cari_top() {
	
	//Clear Component
	$('#tbl_top tbody tr').remove();
	$('#top').val("");
	$('#top_time').val("");
	$('#id_top').val("");
	//
	var id_cust = $('[name="id_cust"]').val()		
	var formData = {
		"id_cust": id_cust,
	};
    //
    $.ajax({		
    	url: "cari_top/",		
    	type: "POST",
    	data: formData,
    	dataType: "JSON",
    	success: function (response) {

    		var trHTML = '';
    		$.each(response, function (i, item) {
    			trHTML += '<tr>';	
    			trHTML += '<td><button id="add_top" name="add_top" type="button" class="btn btn-info btn-sm" onclick="add_top()" >Add</td>';
    			trHTML += '<td>' + item.customer + "</td>";
    			trHTML += '<td>' + item.type + "</td>";			
    			trHTML += '<td>' + item.top + "</td>";
    			trHTML += '<td>' + item.status + "</td>";	
    			trHTML += '<td>' + item.id + "</td>";			
    			trHTML += '</tr>';

    		});

    		$('#tbl_top').append(trHTML);				

    	},
    	error: function (jqXHR, textStatus, errorThrown) {
    		alert('Error get data from ajax');
    	}
    });	
}

function add_top() { 
	var table = document.getElementById("tbl_top");
	var rows = table.getElementsByTagName("tr");	
	for (i = 0; i < rows.length; i++) {
		var currentRow = table.rows[i];
		var createClickHandler = function(row) {
			return function() {
		  // Var Cell	
		  var type_cell     = row.getElementsByTagName("td")[2];
		  var top_cell      = row.getElementsByTagName("td")[3];
		  var id_cell       = row.getElementsByTagName("td")[5];				
		  //
		  var type   = type_cell.innerHTML;	
		  var top    = top_cell.innerHTML;
		  var id     = id_cell.innerHTML;		 
		  //
		  document.getElementById("top").value = type;
		  document.getElementById("top_time").value = top;	 
		  document.getElementById("id_top").value = id;	 	 	  
		  
		};

	};
	currentRow.onclick = createClickHandler(currentRow);
}	

$('#modal-add-top').modal('hide');

}

function add_id_for_so() {

	$cust = $('[name="cust"]').val()	
	$idcust = $('[name="id_cust"]').val()	
	let inv_number = $('[name="inv_number1"]').val();
	let parts = inv_number.split('/');
	let kode_pc = $('[name="profit_ctr_h"]').val();
	//
	$('[name="custm"]').val($cust);
	$('[name="id_custm"]').val($idcust);
	$('[name="profit_ctr"]').val(kode_pc);
	//
	$('#example4 tbody tr').remove();	
	$('#table-sj tbody tr').remove();
	//
	$('#so_number1').val("");
	//$('#id_sj').val("");
	//Clear Value : Total, Discount, Down Payment, Return, Total With Out Tax, VAT, Grand Total
	$('#total').val("");
	$('#discount').val("");
	$('#dp').val("");
	$('#return').val("");
	$('#twot').val("");
	$('#vat').val("");
	$('#grandtotal').val("");	
	//
	$('#table-sj-2 tbody tr').remove();	
	//
	modal_clear_component();

}

function cari_so() {
	
	$('#example4 tbody tr').remove();	
	$('#table-sj-2 tbody tr').remove();	
	// modal_clear_component();

		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_so = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_so = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_so = "undefined";
			dt_sampai_so = "undefined";
		});

		var buyer       = $('#buyer').val();
		var id_customer = $('#id_custm').val();
		var profit_center = $('#profit_ctr').val();

		$.ajax({		
			url: "cari_so/" + dt_dari_so + "/" + dt_sampai_so + "/" + id_customer + "/" + buyer + "/" + profit_center + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) {
					trHTML += '<tr>';
				//trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_sj" id="pilih_sj" class="flat" value = ' + item.id_so + ' onclick="tambah_sj()"></td>';									
				trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_sj" id="pilih_sj" class="flat" value = ' + item.id_so + ' onclick="tambah_sj(' + item.id_so + ')"></td>';									
				trHTML += '<td>' + item.so_no + "</td>";
				trHTML += '<td>' + item.so_date + "</td>";	
				trHTML += '<td>' + item.supplier + "</td>";
				trHTML += '<td>' + item.buyerno + "</td>";
				trHTML += '<td>' + item.so_type + "</td>";	
				trHTML += '<td>' + item.id_so + "</td>";			
				trHTML += '</tr>';
			});

				$('#example4').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	

	}

// function add_so(){ 
	
// 	var table = document.getElementById("example4");
// 	var rows = table.getElementsByTagName("tr");		
// 	for (i = 0; i < rows.length; i++) {
// 	  var currentRow = table.rows[i];
// 	  var createClickHandler = function(row) {
// 		return function() {
// 		  // Var Cell	
// 		  var so_cell        = row.getElementsByTagName("td")[0];
// 		  var id_sj_cell     = row.getElementsByTagName("td")[5];
// 		  // 			
// 		  var so      = so_cell.innerHTML;	
// 		  var id_sj   = id_sj_cell.innerHTML;		  	
// 		  //
// 		  document.getElementById("so_number1").value = so;	 	 	 
// 		  document.getElementById("id_sj").value = id_sj;	

// 		  add_sj(id_sj); //Tambah Detail SO Dari Surat Jalan Atau Bppb

// 		};

// 	  };
// 	  currentRow.onclick = createClickHandler(currentRow);
// 	}		

// 	$('#modal-add-so').modal('hide');	

// }

//ubah desember
function tambah_sj() { 

	var cek_so = document.getElementsByName("pilih_sj");	
	for (var i = 0; i < cek_so.length; i++) {
		    //Ceklist		
		    if (cek_so[i].checked) {		

		    	$('#table-sj-2 tbody tr').remove();
				// modal_clear_component();

				var profit_center = $('#profit_ctr').val();
				
				$.ajax({		
					url: "cari_sj/" + cek_so[i].value + "/" + profit_center + "/",							
					type: "GET",
					dataType: "JSON",
					success: function (response) {

						var trHTML = '';
						$.each(response, function (i, item) {
							trHTML += '<tr>';	
							trHTML += '<td>' + item.id_bppb + "</td>";			
							trHTML += '<td>' + item.no_so + "</td>";
							trHTML += '<td>' + item.sj + "</td>";							
							//trHTML += '<td>' + item.bppbdate + "</td>";
							trHTML += '<td><input type="text" id="cek_tgl" name="cek_tgl" style="border:none; width:120px;" value = ' + item.bppbdate + ' readonly></td>';									
							trHTML += '<td>' + item.shipping_number + "</td>";		
							trHTML += '<td>' + item.ws + "</td>";	
							trHTML += '<td>' + item.styleno + "</td>";	
							trHTML += '<td>' + item.product_group + "</td>";
							trHTML += '<td>' + item.product_item + "</td>";	
							trHTML += '<td>' + item.color + "</td>";
							trHTML += '<td>' + item.size + "</td>";
							trHTML += '<td>' + item.curr + "</td>";	
							trHTML += '<td>' + item.uom + "</td>";
							trHTML += '<td>' + item.qty + "</td>";
							trHTML += '<td>' + item.unit_price + "</td>";				
							trHTML += '<td><input type="text" class="form-control" id="mdl_disc" name="mdl_disc" style="width: 80%; text-align: center" onkeypress="javascript:return isNumber(event)" oninput="modal_input_discount(value)" readonly autocomplete="off"></td>';		
							trHTML += '<td class="totalsj" align="right">' + item.total_price + "</td>";	
							trHTML += '<td><input type="checkbox" name="mdl_cek_sj" id="mdl_cek_sj" class="flat" value = ' + item.total_price + ' onclick="modal_sum_total_sj(value = ' +  item.total_price + ')"></td>';
							trHTML += '<td hidden> <input type="text" class="form-control" id="mdl_grade" name="mdl_grade" value = ' + item.grade + ' style="width: 80%; text-align: center"  readonly autocomplete="off"></td>';
							trHTML += '<td hidden> <input type="text" class="form-control" id="mdl_tgl_inv" name="mdl_tgl_inv" value = ' + item.bppbdate + ' style="width: 80%; text-align: center"  readonly autocomplete="off"></td>';
							trHTML += '<td hidden> <input type="text" class="form-control" id="mdl_curr" name="mdl_curr" value = ' + item.curr + ' style="width: 80%; text-align: center"  readonly autocomplete="off"></td>';									
							trHTML += '</tr>';
						});

						$('#table-sj-2').append(trHTML);				
						
					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Error get data from ajax');
					}
				});

			} else { 
				$('#table-sj-2 tbody tr').remove();
				// modal_clear_component();
			}					
		}
	}


//ubah september
// '.$row["product_item"].' '.$row["styleno"].' ('.$row["color"].','.$row["size"].')</p></td>
function tambah_dataso() { 

	var cek_so = document.getElementsByName("pilih_so_proforma");	
	var tipe = $('#prof_tipe').val();
	for (var i = 0; i < cek_so.length; i++) {
		    //Ceklist		
		    if (cek_so[i].checked) {		

		    	$('#table-so-detail tbody tr').remove();
				// modal_clear_component();
				
				$.ajax({		
					url: "cari_dataso/" + cek_so[i].value + "/" + tipe + "/",							
					type: "GET",
					dataType: "JSON",
					success: function (response) {

						var trHTML = '';
						$.each(response, function (i, item) {
							trHTML += '<tr>';	
							trHTML += '<td>' + item.id_sodet + "</td>";			
							trHTML += '<td>' + item.so_no + "</td>";
							trHTML += '<td>' + item.product_item +' '+ item.styleno +' ('+ item.color +','+ item.size +')'+ "</td>";							
							trHTML += '<td>' + item.curr + "</td>";		
							trHTML += '<td>' + item.qty + "</td>";	
							trHTML += '<td>' + item.unit + "</td>";	
							trHTML += '<td>' + item.price + "</td>";
							trHTML += '<td class="totalsodet" align="right">' + item.hasilkali + "</td>";	
							trHTML += '<td><input type="checkbox" name="mdl_cek_sodet" id="mdl_cek_sodet" class="flat" value = ' + item.hasilkali + ' onclick="modal_sum_total_sodet(value = ' +  item.hasilkali + ')"></td>';									
							trHTML += '</tr>';
						});

						$('#table-so-detail').append(trHTML);				
						
					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Error get data from ajax');
					}
				});

			} else { 
				$('#table-so-detail tbody tr').remove();
				// modal_clear_component();
			}					
		}
	}

//ubah desember
function add_data_invoice() { 

	let no_invoice   = $('[name="inv_number1"]').val();
	let profit_ctr   = $('[name="profit_ctr_h"]').val();
	let type_so   	 = $('[name="type_so"]').val();
	let top          = $('[name="top"]').val();
	let shipp 		 = $('[name="shipp"]').val();
	let type 		 = $('[name="type"]').val();
	let id_cust 	 = $('[name="id_cust"]').val();
	let cust 	 	 = $('[name="cust"]').val();
	let grade 	 	 = $('[name="grade"]').val();
	let inv_date 	 = $('[name="inv_date"]').val();
	let vat 		 = $('[name="vat"]').val();
	let diskon 		 = $('[name="discount"]').val();
	let curr		 = $('[name="inv_curr"]').val();
	var kata1		 = "PENJUALAN";
	var kata2		 = "KE";
	let parts 		 = no_invoice.split('/');
	let kode_pc 	 = parts[2];

	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related Party';
	}else{
		cust_ctg = 'Third Party';
	}

	if (no_invoice == "") {
		alert("Invoice Number is required");
		$("#inv_number1").focus();	
		return false;
	}

	if (top == "") {
		alert("Top is required");
		$("#top").focus();	
		return false;
	}  
	
	$no_invoice = $('[name="inv_number1"]').val()	
	$id_inv     = $('[name="id_inv"]').val()	
	$pph     = $('[name="pph"]').val()
	var keter = kata1 +' '+type_so +' '+kata2 +' '+cust;

	getcoa();
	getcoa_credit();
	getcoa_dp();
	getcoa_pot();
	getcoa_ppn();
	getrate();

	//
	$('[name="no_inv_post"]').val($no_invoice);
	$('[name="id_inv_post"]').val($id_inv);
	$('[name="pph_post"]').val($pph);
	$('[name="keterangan"]').val(keter);

	$('[name="txt_shipp"]').val(shipp);
	$('[name="txt_type_so"]').val(type_so);
	$('[name="txt_type"]').val(type);
	$('[name="txt_cust_ctg"]').val(cust_ctg);
	$('[name="txt_grade"]').val(grade);
	$('[name="txt_inv_date"]').val(inv_date);
	$('[name="txt_vat"]').val(vat);
	$('[name="txt_pot"]').val(diskon);
	$('[name="txt_curr"]').val(curr);
	$('[name="txt_mdl_pc"]').val(profit_ctr);
	console.log(keter);

	// $('#modal-simpan-invoice').modal('show')	

}

function resolveAfter5Seconds() {
	return new Promise(resolve => {
		setTimeout(() => {
			let no_invoice   = $('[name="inv_number1"]').val();
			let profit_ctr   = $('[name="profit_ctr_h"]').val();
			let type_so   	 = $('[name="type_so"]').val();
			let top          = $('[name="top"]').val();
			let shipp 		 = $('[name="shipp"]').val();
			let type 		 = $('[name="type"]').val();
			let id_cust 	 = $('[name="id_cust"]').val();
			let grade 	 	 = $('[name="grade"]').val();
			let inv_date 	 = $('[name="inv_date"]').val();
			let vat 		 = $('[name="vat"]').val();
			let diskon 		 = $('[name="discount"]').val();
			let curr		 = $('[name="inv_curr"]').val();

			if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
				cust_ctg = 'Related Party';
			}else{
				cust_ctg = 'Third Party';
			}

			if (no_invoice == "") {
				return false;
			}

			if (top == "") {
				return false;
			}

			$('#modal-simpan-invoice').modal('show');
		}, 5000);
	});
}

async function asyncCall() {
	add_data_invoice();
	const result = await resolveAfter5Seconds();
	console.log(result);

}

// //ubah september
// async function tunggu_coa(){

//    var result = await add_data_invoice()
//    console.log(result);

//    $('#modal-simpan-invoice').modal('show');
// }


// function add_data_invoice() { 

// 	let no_invoice   = $('[name="inv_number1"]').val();
// 	let top          = $('[name="top"]').val();
//        if (no_invoice == "") {
//           alert("Invoice Number is required");
// 		  $("#inv_number1").focus();	
//           return false;
//   		}

// 		if (top == "") {
// 		  alert("Top is required");
// 		  $("#top").focus();	
// 		  return false;
// 		}  

// 	$no_invoice = $('[name="inv_number1"]').val()	
// 	$id_inv     = $('[name="id_inv"]').val()	
// 	$pph     = $('[name="pph"]').val()
// 	//
// 	$('[name="no_inv_post"]').val($no_invoice);
// 	$('[name="id_inv_post"]').val($id_inv);
// 	$('[name="pph_post"]').val($pph);

// 	$('#modal-simpan-invoice').modal('show')	

// }

//ubah desember
function getcoa() 
{	

	let no_invoice   = $('[name="inv_number1"]').val();
	let type_so   	 = $('[name="type_so"]').val();
	let top          = $('[name="top"]').val();
	let shipp 		 = $('[name="shipp"]').val();
	let type 		 = $('[name="type"]').val();
	let id_cust 	 = $('[name="id_cust"]').val();
	let grade 	 	 = $('[name="grade"]').val();
	let inv_date 	 = $('[name="inv_date"]').val();
	let vat 		 = $('[name="vat"]').val();
	let diskon 		 = $('[name="discount"]').val();
	let curr		 = $('[name="inv_curr"]').val();
	let parts 		 = no_invoice.split('/');
	let kode_pc 	 = $('[name="profit_ctr_h"]').val();

	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related';
	}else{
		cust_ctg = 'Third';
	}

	console.log(type_so + ' ' + shipp + ' ' + cust_ctg + ' ' + grade + ' ' + kode_pc);

	$.ajax({
		url: "getcoa/" + type_so + "/" + shipp + "/" + cust_ctg + "/" + grade + "/" + kode_pc + "/",		
		type: "GET",
		dataType: "JSON",
		success: function (data) {

			$('[name="no_coa_deb"]').val(data.no_coa);
			$('[name="nama_coa_deb"]').val(data.nama_coa);
			console.log( data.no_coa );

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

//ubah desember
function getcoa_credit() 
{	

	let no_invoice   = $('[name="inv_number1"]').val();
	let type_so   	 = $('[name="type_so"]').val();
	let top          = $('[name="top"]').val();
	let shipp 		 = $('[name="shipp"]').val();
	let type 		 = $('[name="type"]').val();
	let id_cust 	 = $('[name="id_cust"]').val();
	let grade 	 	 = $('[name="grade"]').val();
	let inv_date 	 = $('[name="inv_date"]').val();
	let vat 		 = $('[name="vat"]').val();
	let diskon 		 = $('[name="discount"]').val();
	let curr		 = $('[name="inv_curr"]').val();
	let kode_pc 	 = $('[name="profit_ctr_h"]').val();

	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related';
	}else{
		cust_ctg = 'Third';
	}

	console.log(type_so + ' ' + shipp + ' ' + cust_ctg + ' ' + grade + ' ' + kode_pc);

	$.ajax({
		url: "getcoa_credit/" + type_so + "/" + shipp + "/" + cust_ctg + "/" + grade + "/" + kode_pc + "/",		
		type: "GET",
		dataType: "JSON",
		success: function (data) {

			$('[name="no_coa_cre"]').val(data.no_coa);
			$('[name="nama_coa_cre"]').val(data.nama_coa);
			console.log( data.no_coa );

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

//ubah desember
function getcoa_dp() 
{	

	let no_invoice   = $('[name="inv_number1"]').val();
	let type_so   	 = $('[name="type_so"]').val();
	let top          = $('[name="top"]').val();
	let shipp 		 = $('[name="shipp"]').val();
	let type 		 = $('[name="type"]').val();
	let id_cust 	 = $('[name="id_cust"]').val();
	let grade 	 	 = $('[name="grade"]').val();
	let inv_date 	 = $('[name="inv_date"]').val();
	let vat 		 = $('[name="vat"]').val();
	let diskon 		 = $('[name="discount"]').val();
	let curr		 = $('[name="inv_curr"]').val();
	let kode_pc 	 = $('[name="profit_ctr_h"]').val();

	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related';
	}else{
		cust_ctg = 'Third';
	}

	console.log(type_so + ' ' + shipp + ' ' + cust_ctg + ' ' + grade + ' ' + kode_pc);

	$.ajax({
		url: "getcoa_dp/" + type_so + "/" + shipp + "/" + cust_ctg + "/" + grade + "/" + kode_pc + "/",		
		type: "GET",
		dataType: "JSON",
		success: function (data) {

			$('[name="no_coa_dp"]').val(data.no_coa);
			$('[name="nama_coa_dp"]').val(data.nama_coa);
			console.log( data.no_coa );

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

//ubah desember
function getcoa_pot() 
{	

	let no_invoice   = $('[name="inv_number1"]').val();
	let type_so   	 = $('[name="type_so"]').val();
	let top          = $('[name="top"]').val();
	let shipp 		 = $('[name="shipp"]').val();
	let type 		 = $('[name="type"]').val();
	let id_cust 	 = $('[name="id_cust"]').val();
	let grade 	 	 = $('[name="grade"]').val();
	let inv_date 	 = $('[name="inv_date"]').val();
	let vat 		 = $('[name="vat"]').val();
	let diskon 		 = $('[name="discount"]').val();
	let curr		 = $('[name="inv_curr"]').val();
	let kode_pc 	 = $('[name="profit_ctr_h"]').val();

	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related';
	}else{
		cust_ctg = 'Third';
	}

	console.log(type_so + ' ' + shipp + ' ' + cust_ctg + ' ' + grade + ' ' + kode_pc);

	$.ajax({
		url: "getcoa_pot/" + type_so + "/" + shipp + "/" + cust_ctg + "/" + grade + "/" + kode_pc + "/",		
		type: "GET",
		dataType: "JSON",
		success: function (data) {

			$('[name="no_coa_pot"]').val(data.no_coa);
			$('[name="nama_coa_pot"]').val(data.nama_coa);
			console.log( data.no_coa );

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

//ubah desember
function getcoa_ppn() 
{	

	let no_invoice   = $('[name="inv_number1"]').val();
	let type_so   	 = $('[name="type_so"]').val();
	let top          = $('[name="top"]').val();
	let shipp 		 = $('[name="shipp"]').val();
	let type 		 = $('[name="type"]').val();
	let id_cust 	 = $('[name="id_cust"]').val();
	let grade 	 	 = $('[name="grade"]').val();
	let inv_date 	 = $('[name="inv_date"]').val();
	let vat 		 = $('[name="vat"]').val();
	let diskon 		 = $('[name="discount"]').val();
	let curr		 = $('[name="inv_curr"]').val();
	let kode_pc 	 = $('[name="profit_ctr_h"]').val();

	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related';
	}else{
		cust_ctg = 'Third';
	}

	console.log(type_so + ' ' + shipp + ' ' + cust_ctg + ' ' + grade + ' ' + kode_pc);

	$.ajax({
		url: "getcoa_ppn/" + type_so + "/" + shipp + "/" + cust_ctg + "/" + grade + "/" + kode_pc + "/",		
		type: "GET",
		dataType: "JSON",
		success: function (data) {

			$('[name="no_coa_ppn"]').val(data.no_coa);
			$('[name="nama_coa_ppn"]').val(data.nama_coa);
			console.log( data.no_coa );

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

//ubah desember
function getrate() 
{	

	let no_invoice   = $('[name="inv_number1"]').val();
	let type_so   	 = $('[name="type_so"]').val();
	let top          = $('[name="top"]').val();
	let shipp 		 = $('[name="shipp"]').val();
	let type 		 = $('[name="type"]').val();
	let id_cust 	 = $('[name="id_cust"]').val();
	let grade 	 	 = $('[name="grade"]').val();
	let inv_date 	 = $('[name="inv_date"]').val();
	let vat 		 = $('[name="vat"]').val();
	let diskon 		 = $('[name="discount"]').val();
	let curr		 = $('[name="inv_curr"]').val();

	console.log(inv_date);

	$.ajax({
		url: "getrate/" + inv_date + "/",		
		type: "GET",
		dataType: "JSON",
		success: function (data) {

			$('[name="inv_rate"]').val(data.rate);
			console.log( data.rate );

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}


//ubah desember
function save_invoice() {
	
	let vat 		 = $('[name="vat"]').val();
	let diskon 		 = $('[name="discount"]').val();
	let dp		 	 = $('[name="dp"]').val();
	let profit_ctr	 = $('[name="txt_mdl_pc"]').val();
	update_invoice_header();
	update_status_bppb();
	at_debit_inv();
	if (diskon >= 1) {		
		at_pot_inv();
	}
	if (dp >= 1) {		
		at_dp_inv();
	}
	at_credit_inv();
	if (vat >= 1) {		
		at_ppn_inv();
	}
	simpan_invoice_detail();
	simpan_invoice_pot();


	// console.log(vat + ' ' + diskon + ' ' + dp);	
	//	
	$('#modal-simpan-invoice').modal('hide');
	
}

//ubah desember
function at_debit_inv() { 
	

	var data = [];
	var cust_ctg = '';
	var rate = 0;
	var total_idr = 0;

	var id_cust 	 	= $('[name="id_cust"]').val();
	var buyer 	 		= $('[name="cust"]').val();
	var inv_rate 	 	= $('[name="inv_rate"]').val();
	var inv_curr 	 	= $('[name="inv_curr"]').val();
	var total 	 	= $('[name="grandtotal"]').val();
	var keterangan 	 	= $('[name="keterangan"]').val();
	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related Party';
	}else{
		cust_ctg = 'Third Party';
	}

	if (inv_curr == 'IDR') {
		rate = 1;
		total_idr = total * rate;
	}else{
		rate = inv_rate;
		total_idr = total * rate;
	}

	data.push({		
		"no_journal": $('#inv_number1').val(),
		"tgl_journal": $('#inv_date').val(),
		"type_journal": 'Invoice',
		"no_coa": $('#no_coa_deb').val(),
		"nama_coa": $('#nama_coa_deb').val(),		
		"no_costcenter":'-',
		"nama_costcenter": '-',
		"reff_doc": '-',
		"reff_date": '',
		"buyer": buyer,
		"no_ws": '',
		"curr": $('#inv_curr').val(),
		"rate": rate,
		"debit": $('#grandtotal').val(),
		"credit": '0',
		"debit_idr":total_idr,			
		"credit_idr":'0',
		"status": 'POST',
		"keterangan": keterangan,
		"create_by": '',
		"create_date": '',
		"approve_by":'',	
		"approve_date": '',					
		"cancel_by":'',
		"cancel_date": '', 									

	})		

	var formData = {
		'data_table': data
	}

	console.log(formData);
	
	$.ajax({						
		url: "at_debit_inv/",		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {		

			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Update Invoice Header'
			} else {
				msg = 'Error Update Invoice Header'
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Update Invoice Header' + jqXHR.text
		}
	});

}

//ubah desember
function at_pot_inv() { 
	

	var data = [];
	var cust_ctg = '';
	var rate = 0;
	var total_idr = 0;

	var id_cust 	 	= $('[name="id_cust"]').val();
	var buyer 	 		= $('[name="cust"]').val();
	var inv_rate 	 	= $('[name="inv_rate"]').val();
	var inv_curr 	 	= $('[name="inv_curr"]').val();
	var total 	 	= $('[name="discount"]').val();
	var keterangan 	 	= $('[name="keterangan"]').val();
	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related Party';
	}else{
		cust_ctg = 'Third Party';
	}

	if (inv_curr == 'IDR') {
		rate = 1;
		total_idr = total * rate;
	}else{
		rate = inv_rate;
		total_idr = total * rate;
	}

	data.push({		
		"no_journal": $('#inv_number1').val(),
		"tgl_journal": $('#inv_date').val(),
		"type_journal": 'Invoice',
		"no_coa": $('#no_coa_pot').val(),
		"nama_coa": $('#nama_coa_pot').val(),		
		"no_costcenter":'-',
		"nama_costcenter": '-',
		"reff_doc": '-',
		"reff_date": '',
		"buyer": buyer,
		"no_ws": '',
		"curr": $('#inv_curr').val(),
		"rate": rate,
		"debit": $('#discount').val(),
		"credit": '0',
		"debit_idr":total_idr,			
		"credit_idr":'0',
		"status": 'POST',
		"keterangan": keterangan,
		"create_by": '',
		"create_date": '',
		"approve_by":'',	
		"approve_date": '',					
		"cancel_by":'',
		"cancel_date": '', 									

	})		

	var formData = {
		'data_table': data
	}

	console.log(formData);
	
	$.ajax({						
		url: "at_pot_inv/",		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {		

			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Update Invoice Header'
			} else {
				msg = 'Error Update Invoice Header'
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Update Invoice Header' + jqXHR.text
		}
	});

}


//ubah desember
function at_dp_inv() { 
	

	var data = [];
	var cust_ctg = '';
	var rate = 0;
	var total_idr = 0;

	var id_cust 	 	= $('[name="id_cust"]').val();
	var buyer 	 		= $('[name="cust"]').val();
	var inv_rate 	 	= $('[name="inv_rate"]').val();
	var inv_curr 	 	= $('[name="inv_curr"]').val();
	var total 	 	= $('[name="dp"]').val();
	var keterangan 	 	= $('[name="keterangan"]').val();
	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related Party';
	}else{
		cust_ctg = 'Third Party';
	}

	if (inv_curr == 'IDR') {
		rate = 1;
		total_idr = total * rate;
	}else{
		rate = inv_rate;
		total_idr = total * rate;
	}

	data.push({		
		"no_journal": $('#inv_number1').val(),
		"tgl_journal": $('#inv_date').val(),
		"type_journal": 'Invoice',
		"no_coa": $('#no_coa_dp').val(),
		"nama_coa": $('#nama_coa_dp').val(),		
		"no_costcenter":'-',
		"nama_costcenter": '-',
		"reff_doc": '-',
		"reff_date": '',
		"buyer": buyer,
		"no_ws": '',
		"curr": $('#inv_curr').val(),
		"rate": rate,
		"debit": $('#dp').val(),
		"credit": '0',
		"debit_idr":total_idr,			
		"credit_idr":'0',
		"status": 'POST',
		"keterangan": keterangan,
		"create_by": '',
		"create_date": '',
		"approve_by":'',	
		"approve_date": '',					
		"cancel_by":'',
		"cancel_date": '', 									

	})		

	var formData = {
		'data_table': data
	}

	console.log(formData);
	
	$.ajax({						
		url: "at_dp_inv/",		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {		

			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Update Invoice Header'
			} else {
				msg = 'Error Update Invoice Header'
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Update Invoice Header' + jqXHR.text
		}
	});

}

//ubah desember
function at_credit_inv() { 
	

	var data = [];
	var cust_ctg = '';
	var rate = 0;
	var total_idr = 0;

	var id_cust 	 	= $('[name="id_cust"]').val();
	var buyer 	 		= $('[name="cust"]').val();
	var inv_rate 	 	= $('[name="inv_rate"]').val();
	var inv_curr 	 	= $('[name="inv_curr"]').val();
	var total 	 	= $('[name="total"]').val();
	var keterangan 	 	= $('[name="keterangan"]').val();
	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related Party';
	}else{
		cust_ctg = 'Third Party';
	}

	if (inv_curr == 'IDR') {
		rate = 1;
		total_idr = total * rate;
	}else{
		rate = inv_rate;
		total_idr = total * rate;
	}

	data.push({		
		"no_journal": $('#inv_number1').val(),
		"tgl_journal": $('#inv_date').val(),
		"type_journal": 'Invoice',
		"no_coa": $('#no_coa_cre').val(),
		"nama_coa": $('#nama_coa_cre').val(),		
		"no_costcenter":'-',
		"nama_costcenter": '-',
		"reff_doc": '-',
		"reff_date": '',
		"buyer": buyer,
		"no_ws": '',
		"curr": $('#inv_curr').val(),
		"rate": rate,
		"debit": '0',
		"credit": $('#total').val(),
		"debit_idr":'0',			
		"credit_idr":total_idr,
		"status": 'POST',
		"keterangan": keterangan,
		"create_by": '',
		"create_date": '',
		"approve_by":'',	
		"approve_date": '',					
		"cancel_by":'',
		"cancel_date": '', 									

	})		

	var formData = {
		'data_table': data
	}

	console.log(formData);
	
	$.ajax({						
		url: "at_credit_inv/" ,		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {		

			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Update Invoice Header'
			} else {
				msg = 'Error Update Invoice Header'
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Update Invoice Header' + jqXHR.text
		}
	});

}


//ubah desember
function at_ppn_inv() { 
	

	var data = [];
	var cust_ctg = '';
	var rate = 0;
	var total_idr = 0;

	var id_cust 	 	= $('[name="id_cust"]').val();
	var buyer 	 		= $('[name="cust"]').val();
	var inv_rate 	 	= $('[name="inv_rate"]').val();
	var inv_curr 	 	= $('[name="inv_curr"]').val();
	var total 	 	= $('[name="vat"]').val();
	var keterangan 	 	= $('[name="keterangan"]').val();
	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related Party';
	}else{
		cust_ctg = 'Third Party';
	}

	if (inv_curr == 'IDR') {
		rate = 1;
		total_idr = total * rate;
	}else{
		rate = inv_rate;
		total_idr = total * rate;
	}

	data.push({		
		"no_journal": $('#inv_number1').val(),
		"tgl_journal": $('#inv_date').val(),
		"type_journal": 'Invoice',
		"no_coa": $('#no_coa_ppn').val(),
		"nama_coa": $('#nama_coa_ppn').val(),		
		"no_costcenter":'-',
		"nama_costcenter": '-',
		"reff_doc": '-',
		"reff_date": '',
		"buyer": buyer,
		"no_ws": '',
		"curr": $('#inv_curr').val(),
		"rate": rate,
		"debit": '0',
		"credit": $('#vat').val(),
		"debit_idr":'0',			
		"credit_idr":total_idr,
		"status": 'POST',
		"keterangan": keterangan,
		"create_by": '',
		"create_date": '',
		"approve_by":'',	
		"approve_date": '',					
		"cancel_by":'',
		"cancel_date": '', 									

	})		

	var formData = {
		'data_table': data
	}

	console.log(formData);
	
	$.ajax({						
		url: "at_ppn_inv/" ,		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {		

			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Update Invoice Header'
			} else {
				msg = 'Error Update Invoice Header'
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Update Invoice Header' + jqXHR.text
		}
	});

}


function update_invoice_header() { 
	
	var id_inv  = $('[name="id_inv"]').val()		
	var no_inv  = $('[name="inv_number1"]').val()	
	var pph     = $('[name="pph"]').val()	
	var id_top  = $('[name="id_top"]').val()			
	var id_bank = $('[name="id_bank"]').val()
	var type_so = $('[name="type_so"]').val()
	var no_coa = $('[name="no_coa_deb"]').val()
	var nama_coa = $('[name="nama_coa_deb"]').val()

	var formData = {
		"id_inv": id_inv,
		"inv_number1": no_inv,
		"pph": pph,
		"id_top": id_top,
		"id_bank": id_bank,		
		"type_so": type_so,
		"no_coa_deb": no_coa,		
		"nama_coa_deb": nama_coa,	

	};
	
	$.ajax({						
		url: "update_invoice_header/",		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {		

			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Update Invoice Header'
			} else {
				msg = 'Error Update Invoice Header'
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Update Invoice Header' + jqXHR.text
		}
	});

}
//ubah september
function update_status_bppb() { 

	var table = document.getElementById("table-sj");
	for (var i = 1; i < (table.rows.length); i++) {	
				//   
				var id_bppb = table.rows[i].cells[0].innerHTML
				var curr = table.rows[i].cells[11].innerHTML
				var no_invoice = $('[name="id_inv"]').val()
                //
                var formData = {
                	"id_bppb": id_bppb,
                	"curr": curr,
                	"no_invoice": no_invoice,

                };
				//
				$.ajax({						
					url: "update_status_bppb/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Bppb'
						} else {
							msg = 'Error Update Bppb'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Bppb' + jqXHR.text
					}
				});   	
				//					
			}				
		}

		function simpan_invoice_detail() 
		{ 	
	// return new Promise(resolve => {		
	// 	setTimeout(() => {
	// 		var msg
	// 		var data = [];		

	// 		$("#table-sj input[name='cek_pilih_sj']:checked").each(function () {			
	// 			var rows = $(this).closest("tr")[0];	

	// 			data.push({		
	// 				"id_book_invoice": $('#id_inv').val(),
	// 				"so_number": rows.cells[0].innerHTML,
	// 				"bppb_number": rows.cells[1].innerHTML,	
	// 				"sj_date": rows.cells[2].innerHTML,					
	// 				"shipp_number": rows.cells[3].innerHTML,
	// 				"ws": rows.cells[4].innerHTML,
	// 				"style_name": rows.cells[5].innerHTML,
	// 				"prd_grp": rows.cells[6].innerHTML,
	// 				"curr": rows.cells[7].innerHTML,
	// 				"uom": rows.cells[8].innerHTML,
	// 				"qty": rows.cells[9].innerHTML,
	// 				"unit_price": rows.cells[10].innerHTML,			
	// 				"disc": rows.cells[11].innerHTML,	
	// 				"total_price": rows.cells[12].innerHTML, 									

	// 			})		

	// 		})

	// 		var fdata = {
	// 			'data_table': data
	// 		}
	// 		$.ajax({				
	// 			url: "simpan_invoice_detail/",
	// 			type: "POST",
	// 			data: fdata,
	// 			dataType: "JSON",
	// 			success: function (data) {

	// 				if (data.status) //if success close modal and reload ajax table
	// 				{
	// 					msg = 'Success Input Detail'
	// 				} else {
	// 					msg = 'Error Input Detail'
	// 				}
	// 				// Delete Table Invoice Detail Temporary
	// 				delete_invoice_detail_temporary();
    //                 // Reload Page
	// 				window.location.href = window.location.href;

	// 			},
	// 			error: function (jqXHR, textStatus, errorThrown) {
	// 				msg = 'Error Input Detail' + jqXHR.text
	// 			}
	// 		});
	// 		resolve({
	// 			msg: msg,
	// 		});

	// 	}, 100);
	// });
	//
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		

			var table = document.getElementById("table-sj");
			for (var i = 1; i < (table.rows.length); i++) {
				
				data.push({		
					"id_book_invoice": $('#id_inv').val(),
					"id_bppb": table.rows[i].cells[0].innerHTML,
					"so_number": table.rows[i].cells[1].innerHTML,
					"bppb_number": table.rows[i].cells[2].innerHTML,	
					"sj_date": table.rows[i].cells[3].innerHTML,					
					"shipp_number":table.rows[i].cells[4].innerHTML,
					"ws": table.rows[i].cells[5].innerHTML,
					"styleno": table.rows[i].cells[6].innerHTML,
					"product_group": table.rows[i].cells[7].innerHTML,
					"product_item": table.rows[i].cells[8].innerHTML,
					"color": table.rows[i].cells[9].innerHTML,
					"size": table.rows[i].cells[10].innerHTML,
					"curr": table.rows[i].cells[11].innerHTML,
					"uom": table.rows[i].cells[12].innerHTML,
					"qty": table.rows[i].cells[13].innerHTML,
					"unit_price": table.rows[i].cells[14].innerHTML,			
					"disc": table.rows[i].cells[15].innerHTML,	
					"total_price": table.rows[i].cells[16].innerHTML, 									

				})		
			}

			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_invoice_detail/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});  

}

function simpan_invoice_pot() { 

	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		
            //
            var id_book_invoice = $('#id_inv').val();
            var total           = $('#total').val();
            var discount        = $('#discount').val();
            var dp              = $('#dp').val();
            var retur           = $('#return').val();
            var twot            = $('#twot').val();
            var vat             = $('#vat').val();
            var grand_total     = $('#grandtotal').val();
			//			
			data.push({		
				"id_book_invoice": id_book_invoice,
				"total": total,
				"discount": discount,	
				"dp": dp,					
				"retur": retur,
				"twot": twot,
				"vat": vat,	
				"grand_total": grand_total,																
			})	
			
			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_invoice_pot/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					// Delete Table Invoice Detail Temporary
					delete_invoice_detail_temporary();
					// Print Preview Invoice
					let id_invoice = $('[name="id_inv"]').val();
					print_invoice(id_invoice);
                    // Reload Page
                    window.location.href = window.location.href;

                },
                error: function (jqXHR, textStatus, errorThrown) {
                	msg = 'Error Input Detail' + jqXHR.text
                }
            });
			resolve({
				msg: msg,
			});

		}, 100);
	});

}

function cari_invoice() { 

	$('#table-invoice tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_inv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_inv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_inv   = "undefined";
			dt_sampai_inv = "undefined";
		});

		var id_customer = $('#customer').val();	

		

		$.ajax({		
			url: "cari_invoice/" + dt_dari_inv + "/" + dt_sampai_inv + "/" + id_customer + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 					
					if(item.status == 'POST' ){				
						trHTML += '<tr>';					
						trHTML += '<td>' + item.no_invoice + "</td>";
						trHTML += '<td>' + item.customer + "</td>";	
						trHTML += '<td>' + item.shipp + "</td>";
						trHTML += '<td>' + item.doc_type + "</td>";
						trHTML += '<td>' + item.doc_number + "</td>";
						trHTML += '<td>' + item.inv_date + "</td>";
						trHTML += '<td>' + item.tgl_inv + "</td>";	
						trHTML += '<td>' + item.type + "</td>";	
						trHTML += '<td>' + item.status + "</td>";
						trHTML += '<td align="right">' + item.amount + "</td>";
						trHTML += '<td><button id="inv_detail" name="inv_detail" type="button" class="btn btn-info btn-sm" onclick="cari_inv_detail(' + item.id + ')" >Cek Detail</button> ' + '' 
						+ ' <button id="print_inv" name="print_inv" type="button" class="btn btn-primary btn-sm" onclick="print_invoice(' + item.id + ')"><i class="fa fa-print"></i> Print</button> ' + ''
						+ '<button id="export_to_excel_invoice" name="export_to_excel_invoice" type="button" class="btn btn-primary btn-sm" onclick="export_to_excel_invoice(' + item.id + ')"><i class="fa fa-download"></i> Export To Xls</button> ' + ''				
						+ ' <button type="button" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="cancel_invoice(\'' + item.id + '\',\'' + item.no_invoice + '\',\'' + item.status + '\')">Cancel</button></td> </td>';

						trHTML += '</tr>';
					}else{
						trHTML += '<tr>';					
						trHTML += '<td>' + item.no_invoice + "</td>";
						trHTML += '<td>' + item.customer + "</td>";	
						trHTML += '<td>' + item.shipp + "</td>";
						trHTML += '<td>' + item.doc_type + "</td>";
						trHTML += '<td>' + item.doc_number + "</td>";
						trHTML += '<td>' + item.inv_date + "</td>";
						trHTML += '<td>' + item.tgl_inv + "</td>";	
						trHTML += '<td>' + item.type + "</td>";	
						trHTML += '<td>' + item.status + "</td>";
						trHTML += '<td align="right">' + item.amount + "</td>";
						trHTML += '<td><button id="inv_detail" name="inv_detail" type="button" class="btn btn-info btn-sm" onclick="cari_inv_detail(' + item.id + ')" >Cek Detail</button> ' + '' 
						+ ' <button id="print_inv" name="print_inv" type="button" class="btn btn-primary btn-sm" onclick="print_invoice(' + item.id + ')"><i class="fa fa-print"></i> Print</button> ' + ''
						+ '<button id="export_to_excel_invoice" name="export_to_excel_invoice" type="button" class="btn btn-primary btn-sm" onclick="export_to_excel_invoice(' + item.id + ')"><i class="fa fa-download"></i> Export To Xls</button> </td>';

						trHTML += '</tr>';
					}
				});

				$('#table-invoice').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	

	}

	function cari_inv_detail(id_inv) { 

		$('#table-inv-detail tbody tr').remove();		
		$('#modal-inv-detail').modal('show');
		$.ajax({		
			url: "cari_inv_detail/" + id_inv + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 			
					trHTML += '<tr>';										
					trHTML += '<td>' + item.so_number + "</td>";
					trHTML += '<td>' + item.bppb_Number + "</td>";	
					trHTML += '<td>' + item.shipp_number + "</td>";
					trHTML += '<td>' + item.ws + "</td>";
					trHTML += '<td>' + item.styleno + "</td>";
					trHTML += '<td>' + item.product_group + "</td>";
					trHTML += '<td>' + item.product_item + "</td>";
					trHTML += '<td>' + item.color + "</td>";
					trHTML += '<td>' + item.size + "</td>";
					trHTML += '<td>' + item.curr + "</td>";
					trHTML += '<td>' + item.uom + "</td>";
					trHTML += '<td>' + item.qty + "</td>";
					trHTML += '<td>' + item.unit_price + "</td>";	
					trHTML += '<td>' + item.disc + "</td>";				
					trHTML += '<td align="right">' + item.total_price + "</td>";				
					trHTML += '</tr>';
                //
                $('#inv_number_list').val(item.no_invoice)
				//				
			});

				$('#table-inv-detail').append(trHTML);

				cari_inv_pot(id_inv);						

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	

	}

	function cari_inv_pot(id_inv_pot){ 

		$('#mdl_total_det').val("");
		$('#mdl_discount_det').val("");
		$('#mdl_dp_det').val("");
		$('#mdl_return_det').val("");
		$('#mdl_twot_det').val("");
		$('#mdl_vat_det').val("");
		$('#mdl_grandtotal_det').val("");	

		$.ajax({		
			url: "cari_inv_pot/" + id_inv_pot + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {							

				$.each(response, function (i, item) { 

					$('#mdl_total_det').val(item.total);
					$('#mdl_discount_det').val(item.discount);
					$('#mdl_dp_det').val(item.dp);
					$('#mdl_return_det').val(item.retur);
					$('#mdl_twot_det').val(item.twot);
					$('#mdl_vat_det').val(item.vat);
					$('#mdl_grandtotal_det').val(item.grand_total);	

				});

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	

	}

	function isNumber(evt) {

		var iKeyCode = (evt.which) ? evt.which : evt.keyCode
		if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
			return false;
		return true;	

	}

	function tampil_tanggal_1(){		
		$('[name="date1"]').val("");		
		$('#modal-show-date1').modal('show');	
	}

	function tampil_tanggal_2(){		
		$('[name="date2"]').val("");		
		$('#modal-show-date2').modal('show');	
	}

	function tambah_tanggal_1(){	
		$date1 = $('[name="reservationdate"]').val()
		$('[name="date1"]').val($date1);	    	
		$('#modal-show-date1').modal('hide');
	}

	function tambah_tanggal_2(){	
		$date2 = $('[name="reservationdate2"]').val()
		$('[name="date2"]').val($date2);	    	
		$('#modal-show-date2').modal('hide');
	}

//ubah desember
function modal_sum_total_sj(){

	add_value_tgl();
	
	var hanya_baca = document.getElementsByName("mdl_disc");
	var mdl_grade = document.getElementsByName("mdl_grade");
	var mdl_tgl_inv = document.getElementsByName("mdl_tgl_inv");
	var mdl_curr = document.getElementsByName("mdl_curr");		
	var input = document.getElementsByName("mdl_cek_sj");
	var total = 0;	
	var grade = '';
	var tgl_inv = '';
	var curr = '';	
	//    	
	for (var i = 0; i < input.length; i++) {
		for (var i = 0; i < mdl_grade.length; i++) {	
			for (var i = 0; i < hanya_baca.length;  i++){
				if (input[i].checked) {		
					hanya_baca[i].readOnly = false;			
					total += parseFloat(input[i].value);
					grade = mdl_grade[i].value;
					tgl_inv = mdl_tgl_inv[i].value;
					curr = mdl_curr[i].value;
				} else {				
					hanya_baca[i].readOnly = true;
					hanya_baca[i].value = '';
					modal_input_discount();
					
				}			

			}
		}

	}
  	// alert(grade);
  	var discount = $('[name="mdl_discount"]').val();
  	var dp = $('[name="mdl_dp"]').val(); 
  	var retur = $('[name="mdl_return"]').val(); 
  	document.getElementsByName("grade_nya")[0].value = grade;	
  	document.getElementsByName("tanggal_nya")[0].value = tgl_inv;
  	document.getElementsByName("curr_nya")[0].value = curr;	 		
  	document.getElementsByName("mdl_total")[0].value = total.toFixed(2);	
  	document.getElementsByName("mdl_grandtotal")[0].value = (total-discount-dp-retur).toFixed(2);
  	document.getElementsByName("mdl_twot")[0].value = (total-discount-dp-retur).toFixed(2);

  }

//ubah september

function modal_sum_total_sodet(){
	
	var input = document.getElementsByName("mdl_cek_sodet");
	var total = 0;	
	//    	
	for (var i = 0; i < input.length; i++) {
		if (input[i].checked) {				
			total += parseFloat(input[i].value);

		} else {				

		}			

	}


	document.getElementsByName("mdl_total_sodet")[0].value = total.toFixed(2);	
	document.getElementsByName("mdl_total_sodet_h")[0].value = formatMoney(total.toFixed(2));	

}

function modal_input_discount(value){ 

	var input = document.getElementsByName("mdl_cek_sj");
	var total = 0;	
	//
	var arr = document.getElementsByName('mdl_disc');
	var tot = 0;
	for(var i = 0; i < arr.length; i++){
		for (var i = 0; i < input.length; i++) {
			if (input[i].checked) {
				total = parseFloat(input[i].value);
				if(parseFloat(arr[i].value))
					tot += parseFloat(arr[i].value) / 100 * total;	   

			} 
		}	        
	}		
	document.getElementById('mdl_discount').value = tot.toFixed(2);
	//Grand Total
	var total_sj = $('[name="mdl_total"]').val();
	var discount = $('[name="mdl_discount"]').val();
	var dp = $('[name="mdl_dp"]').val(); 
	var retur = $('[name="mdl_return"]').val(); 			
	document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur).toFixed(2);
	document.getElementsByName("mdl_twot")[0].value = (total_sj- discount-dp-retur).toFixed(2);

}

function modal_input_dp(){ 
	var total_sj = $('[name="mdl_total"]').val();
	var discount = $('[name="mdl_discount"]').val();
	var dp = $('[name="mdl_dp"]').val(); 
	document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp).toFixed(2);
	document.getElementsByName("mdl_twot")[0].value = (total_sj- discount-dp).toFixed(2);
}

function modal_input_retur() { 
	var total_sj = $('[name="mdl_total"]').val();
	var discount = $('[name="mdl_discount"]').val();
	var dp = $('[name="mdl_dp"]').val(); 
	var retur = $('[name="mdl_return"]').val(); 
	document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur).toFixed(2);
	document.getElementsByName("mdl_twot")[0].value = (total_sj- discount-dp-retur).toFixed(2);
}

//ubah september
function modal_input_dpcbd() { 
	var total_sj = $('[name="mdl_total"]').val();
	var discount = $('[name="mdl_discount"]').val();
	var dp = $('[name="mdl_dp"]').val() || 0; 
	var retur = $('[name="mdl_return"]').val() || 0; 
	var dp_cbd = $('[name="mdl_dpcbd"]').val(); 
	document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur-dp_cbd).toFixed(2);
	document.getElementsByName("mdl_twot")[0].value = (total_sj- discount-dp-retur-dp_cbd).toFixed(2);
	// alert(dp_cbd);
}

function modal_input_vat(){ 

	var vat = 0.12; 
    //
    if ($('[name="check_vat"]').is(':checked')) {			
    	var total_sj = $('[name="mdl_total"]').val();
    	var discount = $('[name="mdl_discount"]').val();
    	var dp = $('[name="mdl_dp"]').val(); 
    	var retur = $('[name="mdl_return"]').val(); 	
    	var twot = (total_sj- discount-dp-retur).toFixed(2) * vat;
    	document.getElementsByName("mdl_vat")[0].value = (twot).toFixed(2);
			//document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur-twot).toFixed(2);	
			document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur+twot).toFixed(2);	
		} else { 		
			var total_sj = $('[name="mdl_total"]').val();
			var discount = $('[name="mdl_discount"]').val();
			var dp = $('[name="mdl_dp"]').val(); 
			var retur = $('[name="mdl_return"]').val(); 
			document.getElementsByName("mdl_vat")[0].value = "0.00";
			document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur).toFixed(2);
		}
	}

	function modal_input_vat_baru(){ 

		var vat = 0.11; 
    //
    if ($('[name="check_vat_baru"]').is(':checked')) {			
    	var total_sj = $('[name="mdl_total"]').val();
    	var discount = $('[name="mdl_discount"]').val();
    	var dp = $('[name="mdl_dp"]').val(); 
    	var retur = $('[name="mdl_return"]').val(); 	
    	var twot = (total_sj- discount-dp-retur).toFixed(2) * vat;
    	document.getElementsByName("mdl_vat")[0].value = (twot).toFixed(2);
			//document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur-twot).toFixed(2);	
			document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur+twot).toFixed(2);	
		} else { 		
			var total_sj = $('[name="mdl_total"]').val();
			var discount = $('[name="mdl_discount"]').val();
			var dp = $('[name="mdl_dp"]').val(); 
			var retur = $('[name="mdl_return"]').val(); 
			document.getElementsByName("mdl_vat")[0].value = "0.00";
			document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur).toFixed(2);
		}
	}

//ubah desember
function duplicate_data_so(){ 
	
	//Tambah Data Potongan Invoice
	var total       = $('[name="mdl_total"]').val();
	var discount    = $('[name="mdl_discount"]').val();
	var dp          = $('[name="mdl_dp"]').val(); 
	var retur       = $('[name="mdl_return"]').val(); 
	var twot        = $('[name="mdl_twot"]').val(); 
	var vat         = $('[name="mdl_vat"]').val(); 
	var grand_total = $('[name="mdl_grandtotal"]').val(); 
	var grade_nya 	= $('[name="grade_nya"]').val();
	var tanggal_nya = $('[name="tanggal_nya"]').val();
	var curr_nya 	= $('[name="curr_nya"]').val(); 	
	$('[name="total"]').val(total);
	$('[name="discount"]').val(discount);
	$('[name="dp"]').val(dp); 
	$('[name="return"]').val(retur); 
	$('[name="twot"]').val(twot); 
	$('[name="vat"]').val(vat); 
	$('[name="grandtotal"]').val(grand_total);
	$('[name="grade"]').val(grade_nya); 
	$('[name="inv_date"]').val(tanggal_nya); 
	$('[name="inv_curr"]').val(curr_nya); 	
	//Hapus Temporary Table Detail SJ
	//Simpan Table SJ Temp
	// delete_invoice_detail_temporary()	
	simpan_invoice_detail_temporary();	

}


//ubah desember
function cari_dpcbd_invoice_post(){ 
	
	$('#table-approval-invoicedp tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_approv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_approv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_approv   = "undefined";
			dt_sampai_approv = "undefined";
		});

		$.ajax({		
			url: "cari_dpcbd_invoice_post/" + dt_dari_approv + "/" + dt_sampai_approv + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 					
					trHTML += '<tr>';					
					trHTML += '<td>' + item.no_pi + "</td>";					
					trHTML += '<td>' + item.date_pi + "</td>";	
					trHTML += '<td>' + item.customer + "</td>";
					trHTML += '<td>' + item.shipp + "</td>";
					trHTML += '<td>' + item.peb + "</td>";
					trHTML += '<td>' + item.type + "</td>";	
					trHTML += '<td>' + item.no_faktur_pajak + "</td>";	
					trHTML += '<td>' + item.status + "</td>";
					trHTML += '<td>' + item.amount + "</td>";	
					trHTML += '<td>' + item.id + "</td>";					
					trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_invdp_approv" id="pilih_invdp_approv" class="flat" value = ' + item.id + '></td>';										
				//trHTML += '<td><button id="approv_inv" name="approv_inv" type="button" class="btn btn-warning btn-sm" onclick="approve_invoice(\'' + item.no_invoice + '\' , \'' + item.id + '\')"><i class="fa fa-stamp"></i> Approved</td>';
				trHTML += '</tr>';

			});

				$('#table-approval-invoicedp').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	
	}

//ubah desember
function check_approv_dpinvoice(ele) { 

	var checkboxes = document.getElementsByTagName('input');
	if (ele.checked) {
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].type == 'checkbox'  && !(checkboxes[i].disabled) ) {
				checkboxes[i].checked = true;
			}
		}
	} else {
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].type == 'checkbox') {
				checkboxes[i].checked = false;
			}
		}
	}
}

//ubah desember
function modal_show_approve_invoicedp() { 

	var cek_inv = document.getElementsByName("pilih_invdp_approv");	
	for (var i = 0; i < cek_inv.length; i++) {
		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {				   
		    	$('#modal-approve-invoicedp').modal('show');  
		    } 
		}	
	}

//ubah desember
function approve_invoicedp(){
	//
	var cek_inv = document.getElementsByName("pilih_invdp_approv");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
				//   
				var id_inv = cek_inv[i].value
                //
                var formData = {
                	"id_inv": id_inv,			
                };
				//
				$.ajax({						
					url: "approve_invoicedp/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				$('#modal-approve-invoicedp').modal('hide');
				console.log(id_inv);  
				// window.location.reload();
				// cari_invoice_post();

				//
			} 
		}

	}

//ubah desember
async function refresh_invdp(){
	var result = await approve_invoicedp()
	console.log(result);
	var cek_inv = document.getElementsByName("pilih_invdp_approv");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
		    	var coba = parseInt(i + 1);		
		    }
		}
		alert("Invoice DP & CBD Successfully Approved");
		cari_dpcbd_invoice_post();
	}

//  async function refresh(){
//    var result = await approve_invoice()
//    console.log(result);
//    alert("Approve Successfully");
//    cari_invoice_post();
// }

function simpan_invoice_detail_temporary() {
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		

			$("#table-sj-2 input[name='mdl_cek_sj']:checked").each(function () {
				var rows = $(this).closest("tr")[0];

				$(this).closest('tr').find("input[name='mdl_disc']").each(function() {				
					var mdl_disc = this.value	

					$(this).closest('tr').find("input[name='cek_tgl']").each(function() {				
						var tgl_sj = this.value	

						data.push({			
							"id_bppb": rows.cells[0].innerHTML,				
							"so_number": rows.cells[1].innerHTML,
							"bppb_number": rows.cells[2].innerHTML,	
							"sj_date": tgl_sj,						
							"shipp_number": rows.cells[4].innerHTML,
							"ws": rows.cells[5].innerHTML,
							"styleno": rows.cells[6].innerHTML,
							"product_group": rows.cells[7].innerHTML,
							"product_item": rows.cells[8].innerHTML,
							"color": rows.cells[9].innerHTML,
							"size": rows.cells[10].innerHTML,
							"curr": rows.cells[11].innerHTML,
							"uom": rows.cells[12].innerHTML,
							"qty": rows.cells[13].innerHTML,
							"unit_price": rows.cells[14].innerHTML,			
							"disc": mdl_disc,
							"total_price": rows.cells[16].innerHTML, 				
						})	

					});

				});

			});

			console.log(data);
			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_invoice_detail_temporary/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}

					//Load Data SJ Temporary
					load_invoice_detail_temporary();                   		
					$('#modal-add-so').modal('hide');

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});
}

function load_invoice_detail_temporary() { 	

	$('#table-sj tbody tr').remove();
	$.ajax({		
		url: "load_invoice_detail_temporary/",							
		type: "GET",
		dataType: "JSON",
		success: function (response) {
			var trHTML = '';
			$.each(response, function (i, item) {
				trHTML += '<tr>';
				trHTML += '<td>' + item.id_bppb + "</td>";				
				trHTML += '<td>' + item.so_number + "</td>";
				trHTML += '<td>' + item.bppb_number + "</td>";							
				trHTML += '<td>' + item.sj_date + "</td>";						
				trHTML += '<td>' + item.shipp_number + "</td>";		
				trHTML += '<td>' + item.ws + "</td>";	
				trHTML += '<td>' + item.styleno + "</td>";	
				trHTML += '<td>' + item.product_group + "</td>";	
				trHTML += '<td>' + item.product_item + "</td>";
				trHTML += '<td>' + item.color + "</td>";
				trHTML += '<td>' + item.size + "</td>";
				trHTML += '<td>' + item.curr + "</td>";	
				trHTML += '<td>' + item.uom + "</td>";
				trHTML += '<td>' + item.qty + "</td>";
				trHTML += '<td>' + item.unit_price + "</td>";
				trHTML += '<td>' + item.disc + "</td>";	
				trHTML += '<td align="right">' + item.total_price + "</td>";	
						// trHTML += '<td><input type="checkbox" name="cek_pilih_sj" id="cek_pilih_sj" class="flat" checked></td>';												
						trHTML += '</tr>';
					});
			$('#table-sj').append(trHTML);						
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});  	  

}

function delete_invoice_detail_temporary() { 

	$.ajax({						
		url: "delete_invoice_detail_temporary/",
		type: "GET",				
		dataType: "JSON",
		success: function (data) {
			
			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Delete Table Temporary'			     
			} else {
				msg = 'Error Delete Table Temporary'				
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Delete Table Temporary' + jqXHR.text			
		}
	});
	
}

function cari_invoice_post(){ 
	
	$('#table-approval-invoice tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_approv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_approv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_approv   = "undefined";
			dt_sampai_approv = "undefined";
		});

		$.ajax({		
			url: "cari_invoice_post/" + dt_dari_approv + "/" + dt_sampai_approv + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 					
					trHTML += '<tr>';					
					trHTML += '<td>' + item.no_invoice + "</td>";					
					trHTML += '<td>' + item.customer + "</td>";	
					trHTML += '<td>' + item.shipp + "</td>";
					trHTML += '<td>' + item.doc_type + "</td>";
					trHTML += '<td>' + item.doc_number + "</td>";
					trHTML += '<td>' + item.inv_date + "</td>";	
					trHTML += '<td>' + item.type + "</td>";	
					trHTML += '<td>' + item.status + "</td>";	
					trHTML += '<td>' + item.id + "</td>";					
					trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_inv_approv" id="pilih_inv_approv" class="flat" value = ' + item.id + '></td>';										
				//trHTML += '<td><button id="approv_inv" name="approv_inv" type="button" class="btn btn-warning btn-sm" onclick="approve_invoice(\'' + item.no_invoice + '\' , \'' + item.id + '\')"><i class="fa fa-stamp"></i> Approved</td>';
				trHTML += '</tr>';

			});

				$('#table-approval-invoice').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	
	}

//ubah september
function cari_proforma_invoice_post(){ 
	
	$('#table-approval-profinvoice tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_approv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_approv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_approv   = "undefined";
			dt_sampai_approv = "undefined";
		});

		$.ajax({		
			url: "cari_proforma_invoice_post/" + dt_dari_approv + "/" + dt_sampai_approv + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 					
					trHTML += '<tr>';					
					trHTML += '<td>' + item.no_pi + "</td>";					
					trHTML += '<td>' + item.date_pi + "</td>";	
					trHTML += '<td>' + item.customer + "</td>";
					trHTML += '<td>' + item.shipp + "</td>";
					trHTML += '<td>' + item.peb + "</td>";
					trHTML += '<td>' + item.type + "</td>";	
					trHTML += '<td>' + item.no_faktur_pajak + "</td>";	
					trHTML += '<td>' + item.status + "</td>";
					trHTML += '<td>' + item.amount + "</td>";	
					trHTML += '<td>' + item.id + "</td>";					
					trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_profinv_approv" id="pilih_profinv_approv" class="flat" value = ' + item.id + '></td>';										
				//trHTML += '<td><button id="approv_inv" name="approv_inv" type="button" class="btn btn-warning btn-sm" onclick="approve_invoice(\'' + item.no_invoice + '\' , \'' + item.id + '\')"><i class="fa fa-stamp"></i> Approved</td>';
				trHTML += '</tr>';

			});

				$('#table-approval-profinvoice').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	
	}


//ubah september
function cari_debitnote_post(){ 
	
	$('#table-approval-debitnote tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_approv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_approv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_approv   = "undefined";
			dt_sampai_approv = "undefined";
		});

		$.ajax({		
			url: "cari_debitnote_post/" + dt_dari_approv + "/" + dt_sampai_approv + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 					
					trHTML += '<tr>';					
					trHTML += '<td>' + item.no_dn + "</td>";	
					trHTML += '<td>' + item.tgl_dn + "</td>";
					trHTML += '<td>' + item.Supplier + "</td>";
					trHTML += '<td>' + item.attn + "</td>";
					trHTML += '<td>' + item.from_curr + "</td>";	
					trHTML += '<td>' + item.to_curr + "</td>";	
					trHTML += '<td>' + item.amount + "</td>";
					trHTML += '<td>' + item.eqv_curr + "</td>";	
					trHTML += '<td>' + item.status + "</td>";					
					trHTML += '<td>' + item.id + "</td>";					
					trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_debitnote_approv" id="pilih_debitnote_approv" class="flat" value = ' + item.id + '></td>';										
				//trHTML += '<td><button id="approv_inv" name="approv_inv" type="button" class="btn btn-warning btn-sm" onclick="approve_invoice(\'' + item.no_invoice + '\' , \'' + item.id + '\')"><i class="fa fa-stamp"></i> Approved</td>';
				trHTML += '</tr>';

			});

				$('#table-approval-debitnote').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	
	}

	function check_approv_invoice(ele) { 

		var checkboxes = document.getElementsByTagName('input');
		if (ele.checked) {
			for (var i = 0; i < checkboxes.length; i++) {
				if (checkboxes[i].type == 'checkbox'  && !(checkboxes[i].disabled) ) {
					checkboxes[i].checked = true;
				}
			}
		} else {
			for (var i = 0; i < checkboxes.length; i++) {
				if (checkboxes[i].type == 'checkbox') {
					checkboxes[i].checked = false;
				}
			}
		}
	}

//ubah september
function check_approv_profinvoice(ele) { 

	var checkboxes = document.getElementsByTagName('input');
	if (ele.checked) {
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].type == 'checkbox'  && !(checkboxes[i].disabled) ) {
				checkboxes[i].checked = true;
			}
		}
	} else {
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].type == 'checkbox') {
				checkboxes[i].checked = false;
			}
		}
	}
}


//ubah september
function check_approv_debitnote(ele) { 

	var checkboxes = document.getElementsByTagName('input');
	if (ele.checked) {
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].type == 'checkbox'  && !(checkboxes[i].disabled) ) {
				checkboxes[i].checked = true;
			}
		}
	} else {
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].type == 'checkbox') {
				checkboxes[i].checked = false;
			}
		}
	}
}

//ubah september
function pilihsemua(){
	$('#cek_sodet').bind('click', function() {
		var checkedState = this.checked;
		$('#table-so-detail :checkbox').each(function() {
			this.checked = checkedState;
			modal_sum_total_sodet();

		});
	});
}

//ubah september
function modal_show_approve_profinvoice() { 

	var cek_inv = document.getElementsByName("pilih_profinv_approv");	
	for (var i = 0; i < cek_inv.length; i++) {
		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {				   
		    	$('#modal-approve-profinvoice').modal('show');  
		    } 
		}	
	}

//ubah september
function modal_show_approve_debitnote() { 

	var cek_inv = document.getElementsByName("pilih_debitnote_approv");	
	for (var i = 0; i < cek_inv.length; i++) {
		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {				   
		    	$('#modal-approve-debitnote').modal('show');  
		    } 
		}	
	}

	function modal_show_approve_invoice() { 

		var cek_inv = document.getElementsByName("pilih_inv_approv");	
		for (var i = 0; i < cek_inv.length; i++) {
		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {				   
		    	$('#modal-approve-invoice').modal('show');  
		    } 
		}	
	}

	function approve_invoice(){
	//
	var cek_inv = document.getElementsByName("pilih_inv_approv");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
				//   
				var id_inv = cek_inv[i].value
                //
                var formData = {
                	"id_inv": id_inv,			
                };
				//
				$.ajax({						
					url: "approve_invoice/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				$('#modal-approve-invoice').modal('hide');
				console.log(id_inv);  
				// window.location.reload();
				// cari_invoice_post();

				//
			} 
		}

	}

//ubah september
function approve_profinvoice(){
	//
	var cek_inv = document.getElementsByName("pilih_profinv_approv");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
				//   
				var id_inv = cek_inv[i].value
                //
                var formData = {
                	"id_inv": id_inv,			
                };
				//
				$.ajax({						
					url: "approve_profinvoice/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				$('#modal-approve-profinvoice').modal('hide');
				console.log(id_inv);  
				// window.location.reload();
				// cari_invoice_post();

				//
			} 
		}

	}

//ubah september
function approve_debitnote(){
	//
	var cek_inv = document.getElementsByName("pilih_debitnote_approv");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
				//   
				var id_inv = cek_inv[i].value
                //
                var formData = {
                	"id_inv": id_inv,			
                };
				//
				$.ajax({						
					url: "approve_debitnote/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				$('#modal-approve-debitnote').modal('hide');
				console.log(id_inv);  
				// window.location.reload();
				// cari_invoice_post();

				//
			} 
		}

	}

//  async function refresh(){
//    var result = await approve_invoice()
//    console.log(result);
//    alert("Approve Successfully");
//    cari_invoice_post();
// }

async function refresh(){
	var result = await approve_invoice()
	console.log(result);
	var cek_inv = document.getElementsByName("pilih_inv_approv");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
		    	var coba = parseInt(i + 1);		
		    }
		}
		alert(" Invoice Successfully Approved");
		cari_invoice_post();
	}

//ubah september
async function refresh_pi(){
	var result = await approve_profinvoice()
	console.log(result);
	var cek_inv = document.getElementsByName("pilih_profinv_approv");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
		    	var coba = parseInt(i + 1);		
		    }
		}
		alert(" Proforma Invoice Successfully Approved");
		cari_proforma_invoice_post();
	}


//ubah september
async function refresh_dn(){
	var result = await approve_debitnote()
	console.log(result);
	var cek_inv = document.getElementsByName("pilih_debitnote_approv");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
		    	var coba = parseInt(i + 1);		
		    }
		}
		alert(" Debit Note Successfully Approved");
		cari_debitnote_post();
	}


// function sum_total_sj(){

// 	var hanya_baca = document.getElementsByName("disc");	
// 	var input = document.getElementsByName("cek_sj");
//   	var total = 0;	
// 	//    	
//     for (var i = 0; i < input.length; i++) {
// 		for (var i = 0; i < hanya_baca.length;  i++){
//        		if (input[i].checked) {		
//   				hanya_baca[i].readOnly = false;			
// 				total += parseFloat(input[i].value);

//     		} else {				
// 				hanya_baca[i].readOnly = true;
// 				hanya_baca[i].value = '';
// 				input_discount();

// 			}			

// 		}

//   	}
// 	var discount = $('[name="discount"]').val();
//   	document.getElementsByName("total")[0].value = total.toFixed(2);	
// 	document.getElementsByName("grandtotal")[0].value = (total - discount).toFixed(2);

// }

// function input_discount(value){ 

// 	var input = document.getElementsByName("cek_sj");
//   	var total = 0;	
// 	//
// 	var arr = document.getElementsByName('disc');
//     var tot=0;
//     for(var i = 0; i < arr.length; i++){
// 		for (var i = 0; i < input.length; i++) {
// 			if (input[i].checked) {
// 				   total = parseFloat(input[i].value);
// 			   if(parseInt(arr[i].value))
//             	   tot += parseInt(arr[i].value) / 100 * total;	   

// 			 } 
// 		   }	        
//     }		
//     document.getElementById('discount').value = tot.toFixed(2);
// 	//Grand Total
// 	var total_sj = $('[name="total"]').val();
// 	var discount = $('[name="discount"]').val();		
// 	document.getElementsByName("grandtotal")[0].value = (total_sj- discount).toFixed(2);

// }

function add_value_tgl() { 
	
	var cek_sj_1 = document.getElementsByName("mdl_cek_sj");
	var cek_tgl_1 = document.getElementsByName("cek_tgl");		
	//	
	for (var i = 0; i < cek_sj_1.length; i++) {	
		for (var i = 0; i < cek_tgl_1.length; i++) { 
			// 	
			if (cek_sj_1[i].checked) {								
				cek_tgl_sj(cek_tgl_1[i].value);
			} 
		}	
	}
}

function cek_tgl_sj($tgl){ 

	var cek_sj_2 = document.getElementsByName("mdl_cek_sj");
	var cek_tgl_2 = document.getElementsByName("cek_tgl");	
	//
	for (var i = 0; i < cek_sj_2.length; i++) {
		for (var i = 0; i < cek_tgl_2.length; i++) {	
          //
          if (cek_tgl_2[i].value != $tgl ) {			
          	cek_sj_2[i].style.display = "none";		
          }
      }	
  }
}

function print_invoice(id) {

	//var id_bank = $('#bank').val(); 	
	//window.open("http://localhost/ar-nag/arnag/report_invoice/" + id + "/" );  
	//window.open("http://localhost/ar-nag/arnag/report_invoice2/" + id + "/" ); 
	//window.open("http://10.10.2.179/ar-nag/arnag/report_invoice3/" + id + "/" + id_bank + "/" );  	
	window.open(".../../report_invoice3/" + id + "/" );  	

}

function export_to_excel_invoice($id) { 			
	window.open(".../../export_excel_invoice/" + $id + "/");  
}

function export_list_invoice() { 		
	var id_customer = $('#customer').val();	
	window.open(".../../export_excel_list_invoice/" + dt_dari_inv  + "/" + dt_sampai_inv  + "/" + "/" + id_customer + "/" ); 
}

//ubah september
function export_alokasi() { 
	var id_customer = $('#customer').val();	
	window.open(".../../export_excel_list_invoice/" + dt_dari_kwt  + "/" + dt_sampai_kwt  + "/" + "/" + id_customer + "/" ); 
}


function export_book_invoice() { 		
	var id_customer = $('#book_customer').val();
	var status = $('#book_status').val();
	window.open(".../../export_excel_book_invoice/" + dt_dari_inv  + "/" + dt_sampai_inv  + "/" + "/" + id_customer + "/"+ "/" + status + "/" ); 
}

//Update Duedate
function cari_invoice_dd() { 
	$('#example2 tbody tr').remove();	
	//Date range picker
	$('input[name="reservation2"]').daterangepicker({
		autoUpdateInput: false,
		locale: {
			cancelLabel: 'Clear'
		}
	});

	$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
		dt_dari_inv_dd = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_inv_dd = picker.endDate.format('YYYY-MM-DD');
		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
	});

	$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
		$(this).val('');
		dt_dari_inv_dd   = "undefined";
		dt_sampai_inv_dd = "undefined";
	});

	var id_customer = $('#customer_dd').val();	

	$.ajax({		
		url: "cari_invoice_duedate/" + dt_dari_inv_dd + "/" + dt_sampai_inv_dd + "/" + id_customer + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {

			var trHTML = '';
			$.each(response, function (i, item) { 					
				trHTML += '<tr>';					
				trHTML += '<td>' + item.no_invoice + "</td>";
				trHTML += '<td>' + item.customer + "</td>";	
				trHTML += '<td>' + item.shipp + "</td>";
				trHTML += '<td>' + item.doc_type + "</td>";
				trHTML += '<td>' + item.doc_number + "</td>";
				trHTML += '<td>' + item.tanggal + "</td>";	
				trHTML += '<td>' + item.type + "</td>";	
				trHTML += '<td>' + item.status + "</td>";	
				trHTML += '<td>' + item.id + "</td>";					
				trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_inv_dd" id="pilih_inv_dd" class="flat"></td>';												
				trHTML += '</tr>';
			});

			$('#example2').append(trHTML);				

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	
}

function save_duedate() { 

	let kb_date = $('[name="tgl_kontrabon"]').val();	
	if (kb_date == "") {
		alert("Kontrabon date is required");
		$("#tgl_kontrabon").focus();		  
		return false;
	}

	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		
			var id_inv = "";

			$("#example2 input[name='pilih_inv_dd']:checked").each(function () {
				var rows = $(this).closest("tr")[0];
				//Set Now Date
				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth() + 1; 
				var yyyy = today.getFullYear();	
				today = yyyy+'-'+mm+'-'+dd;
				//
				var no_duedate = $('#doc_dd').val();				
				var kontrabon_date = $('#tgl_kontrabon').val();
				var catatan = $('#cat_dd').val();
				var status = "DONE"				
				//ID Book Invoice
				id_inv = rows.cells[8].innerHTML
				//
				data.push({							
					"no_duedate": no_duedate,
					"id_invoice": rows.cells[8].innerHTML,	
					"no_invoice": rows.cells[0].innerHTML,	
					"input_date": today,				
					"kontrabon_date": kontrabon_date,
					"catatan": catatan,		
					"status": status,												
				})								
			});

			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "save_duedate/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}

					//Update duedate bookinvoice
					update_duedate_bookinvoice(id_inv);										                 		
					$('#modal-update-duedate').modal('hide');
					//Reload Page
					location.reload();

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});

}

function update_duedate_bookinvoice(id_inv) { 

	var no_duedate  = $('[name="doc_dd"]').val()
	//
	var formData = {
		"no_duedate": no_duedate,							
	};
	
	$.ajax({						
		url: "update_duedate_bookinvoice/" + id_inv + "/",		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {		

			if (data.status) //if success close modal and reload ajax table
			{
				msg = ''
			} else {
				msg = ''
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			//alert('Error Update Book Invoice ' + jqXHR.text)
		}
	});

}

function reload_page_duedate() { 
	location.reload();	
}

//Proforma Invoice
function get_kode_proforma_invoice(kode) 
{	
	$.ajax({
		url: "get_kode_proforma_invoice/" + kode,		
		type: "GET",
		dataType: "JSON",
		success: function (id) {

			$('[name="prof_inv_number"]').val(id);

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

//ubah september
function get_kode_proforma_invoice_cbd(kode) 
{
	var type_pi  = $('[name="prof_type_pi"]').val();
	if (type_pi != '') {
		$.ajax({
			url: "get_kode_proforma_invoice_cbd/" + kode + "/" + type_pi + "/",		
			type: "GET",
			dataType: "JSON",
			success: function (id) {

				$('[name="prof_inv_number"]').val(id);

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	}else{
		alert("Please Choose Type PI");
		$('[name="prof_shipp_cbd"]').val("");
		$('[name="prof_peb"]').val("");
	}
}

//ubah september
function get_kode_cbd(kode){
	$('[name="prof_shipp_cbd"]').val("");
	$('[name="prof_peb"]').val("");
	if (kode == 'D') {
		$('[name="prof_check_dp"]').prop('disabled', false);
	}else{
		$('[name="prof_check_dp"]').prop('disabled', true);
		$('[name="prof_check_dp"]').prop('checked', false);
		$('[name="pilih_dp_prof"]').prop('disabled', true);
		$('[name="prof_dp"]').prop('readonly', true);
		$('[name="prof_dp"]').val("");
		$('[name="prof_dp_h"]').val("");
		$('[name="prof_dp_h2"]').val("");
	}

	$.ajax({
		url: "get_kode_cbd/" + kode,		
		type: "GET",
		dataType: "JSON",
		success: function (id) {

			$('[name="prof_inv_number"]').val(id);

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}


function cari_prof_top() {

	//Clear Component
	$('#tbl_prof_top tbody tr').remove();
	$('#prof_top').val("");
	$('#prof_top_time').val("");
	$('#prof_id_top').val("");
	//		
	var id_cust = $('[name="prof_customer"]').val()		
	var formData = {
		"id_cust": id_cust,		
	};
    //
    $.ajax({		
    	url: "cari_prof_top/" + id_cust + "/",		
    	type: "POST",		
    	data: formData,
    	dataType: "JSON",
    	success: function (response) {

    		var trHTML = '';
    		$.each(response, function (i, item) {
    			trHTML += '<tr>';	
    			trHTML += '<td><button id="prof_add_top" name="prof_add_top" type="button" class="btn btn-info btn-sm" onclick="add_prof_top()" >Add</td>';
    			trHTML += '<td>' + item.customer + "</td>";
    			trHTML += '<td>' + item.type + "</td>";			
    			trHTML += '<td>' + item.top + "</td>";
    			trHTML += '<td>' + item.status + "</td>";	
    			trHTML += '<td>' + item.id + "</td>";			
    			trHTML += '</tr>';

    		});

    		$('#tbl_prof_top').append(trHTML);				

    	},
    	error: function (jqXHR, textStatus, errorThrown) {
    		alert('Error get data from ajax');
    	}
    });	
}

function add_prof_top() { 
	var table = document.getElementById("tbl_prof_top");
	var rows = table.getElementsByTagName("tr");	
	for (i = 0; i < rows.length; i++) {
		var currentRow = table.rows[i];
		var createClickHandler = function(row) {
			return function() {
		  // Var Cell	
		  var type_cell     = row.getElementsByTagName("td")[2];
		  var top_cell      = row.getElementsByTagName("td")[3];
		  var id_cell       = row.getElementsByTagName("td")[5];				
		  //
		  var type   = type_cell.innerHTML;	
		  var top    = top_cell.innerHTML;
		  var id     = id_cell.innerHTML;		 
		  //
		  document.getElementById("prof_top").value = type;
		  document.getElementById("prof_top_time").value = top;	 
		  document.getElementById("prof_id_top").value = id;	 	 	  
		  
		};

	};
	currentRow.onclick = createClickHandler(currentRow);
}	

$('#modal-add-prof-top').modal('hide');

}

//ubah september

function add_id_for_proforma_inv(){ 	
	
	delete_invoice_detail_proforma_temporary();
    //
    $('#table-proforma-sodet tbody tr').remove();	
    $('#table-proforma-invoice tbody tr').remove();	
    $('[name="prof_grandtotal"]').val("");
    $('[name="prof_dp"]').val("");
    $('[name="prof_diskon"]').val("");
    $('[name="id_ppn_prof"]').val("");
    $('[name="prof_twot"]').val("");
    $('[name="prof_twot2"]').val("");
    $('[name="prof_twot_h"]').val("");
    $('[name="prof_taxes"]').val("");
    $('[name="prof_taxes_h"]').val("");
    $('[name="prof_grandtotal_h"]').val("");
    $('[name="prof_dp_h"]').val("");
    $('[name="prof_dp"]').prop('readonly', true);
    $('[name="prof_check_dp"]').prop('checked', false);
	//
	$cust_prof = $("#prof_customer :selected").text(); 	
	$idcust_prof = $('[name="prof_customer"]').val()	
	//
	$('[name="prof_custm"]').val($cust_prof);
	$('[name="prof_id_custm"]').val($idcust_prof);

}
//ubah september
function cari_so_proforma(){ 
	
	$('#example4 tbody tr').remove();	
	$('#table-proforma-invoice tbody tr').remove();	
	pilihsemua();

	$("#cek_sodet").prop("checked", false);
	
	//Date range picker
	$('input[name="reservation2"]').daterangepicker({
		autoUpdateInput: false,
		locale: {
			cancelLabel: 'Clear'
		}
	});
	
	$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
		dt_dari_so_prof = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_so_prof = picker.endDate.format('YYYY-MM-DD');
		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
	});
	
	$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
		$(this).val('');
		dt_dari_so_prof = "undefined";
		dt_sampai_so_prof = "undefined";
	});

	var id_customer = $('#prof_id_custm').val();
		//<input type="checkbox" name="pilih_sj" id="pilih_sj" class="flat" value = ' + item.id_so + ' onclick="tambah_sj(' + item.id_so + ')">

		$.ajax({		
			url: "cari_so_proforma/" + dt_dari_so_prof + "/" + dt_sampai_so_prof + "/" + id_customer + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) {
					trHTML += '<tr>';				
					trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_so_proforma" id="pilih_so_proforma" value = ' + item.id_so + ' onclick="tambah_dataso(' + item.id_so + ')" class="flat"></td>';									
					trHTML += '<td>' + item.so_no + "</td>";
					trHTML += '<td>' + item.so_date + "</td>";			
					trHTML += '<td>' + item.Supplier + "</td>";
					trHTML += '<td>' + item.buyerno + "</td>";
					trHTML += '<td align="center">' + item.curr + "</td>";
					trHTML += '<td align="right">' + item.qty + "</td>";	
					trHTML += '<td align="right">' + item.unit_price + "</td>";	
					trHTML += '<td align="right">' + item.total_price + "</td>";
					trHTML += '<td align="center">' + item.id_so + "</td>";					
					trHTML += '</tr>';
				});

				$('#example4').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	


	}


	function cari_so_proforma_cbd(){ 

		$('#example4 tbody tr').remove();	
		$('#table-proforma-invoice tbody tr').remove();
		pilihsemua();

		$("#cek_sodet").prop("checked", false);

	//Date range picker
	$('input[name="reservation2"]').daterangepicker({
		autoUpdateInput: false,
		locale: {
			cancelLabel: 'Clear'
		}
	});
	
	$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
		dt_dari_so_prof = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_so_prof = picker.endDate.format('YYYY-MM-DD');
		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
	});
	
	$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
		$(this).val('');
		dt_dari_so_prof = "undefined";
		dt_sampai_so_prof = "undefined";
	});

	var id_customer = $('#prof_id_custm').val();
		//<input type="checkbox" name="pilih_sj" id="pilih_sj" class="flat" value = ' + item.id_so + ' onclick="tambah_sj(' + item.id_so + ')">

		$.ajax({		
			url: "cari_so_proforma_cbd/" + dt_dari_so_prof + "/" + dt_sampai_so_prof + "/" + id_customer + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) {
					trHTML += '<tr>';				
					trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_so_proforma" id="pilih_so_proforma" value = ' + item.id_so + ' onclick="tambah_dataso(' + item.id_so + ')" class="flat"></td>';									
					trHTML += '<td>' + item.so_no + "</td>";
					trHTML += '<td>' + item.so_date + "</td>";			
					trHTML += '<td>' + item.Supplier + "</td>";
					trHTML += '<td>' + item.buyerno + "</td>";
					trHTML += '<td align="center">' + item.curr + "</td>";
					trHTML += '<td align="right">' + item.qty + "</td>";	
					trHTML += '<td align="right">' + item.unit_price + "</td>";	
					trHTML += '<td align="right">' + item.total_price + "</td>";
					trHTML += '<td align="center">' + item.id_so + "</td>";					
					trHTML += '</tr>';
				});

				$('#example4').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	


	}
//ubah september
function duplicate_data_so_proforma(){ 

	delete_invoice_detail_proforma_temporary()
	delete_so_detail_proforma_temporary()
	simpan_invoice_detail_proforma_temporary()
	simpan_so_detail_proforma_temporary()


}

function simpan_invoice_detail_proforma_temporary(){
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];	
			
			$("#example4 input[name='pilih_so_proforma']:checked").each(function () {
				var rows = $(this).closest("tr")[0];
				//
				var qty = rows.cells[6].innerHTML; 
				var unit_price = rows.cells[7].innerHTML;
				var total_price = rows.cells[8].innerHTML;
				//
				qty = qty.replace(/,/g, '');
				unit_price = unit_price.replace(/,/g, '');
				total_price = total_price.replace(/,/g, '');
                //
                data.push({							
					//"id_invoice_proforma": rows.cells[0].innerHTML,
					"so_no": rows.cells[1].innerHTML,	
					"so_date": rows.cells[2].innerHTML,						
					"buyerno": rows.cells[4].innerHTML,
					"curr": rows.cells[5].innerHTML,
					"qty": qty,
					"unit_price": unit_price,					
					"total_price": total_price,
					"id_so": rows.cells[9].innerHTML,									
				})			 

            });

			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_invoice_detail_proforma_temporary/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}

					//Load Data SO Proforma Temporary
					load_invoice_detail_proforma_temporary();                   		
					$('#modal-add-so-proforma').modal('hide');

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});
}

//ubah september
function simpan_so_detail_proforma_temporary(){
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];	
			
			$("#table-so-detail input[name='mdl_cek_sodet']:checked").each(function () {
				var rows = $(this).closest("tr")[0];
				//
				var id_so_det = rows.cells[0].innerHTML;
				var no_so = rows.cells[1].innerHTML;
				var produk_det = rows.cells[2].innerHTML;
				var curr = rows.cells[3].innerHTML;
				var qty = rows.cells[4].innerHTML;
				var uom = rows.cells[5].innerHTML;
				var price = rows.cells[6].innerHTML;
				var total = rows.cells[7].innerHTML; 
				// var unit_price = rows.cells[7].innerHTML;
				// var total_price = rows.cells[8].innerHTML;
				// //
				// qty = qty.replace(/,/g, '');
				// unit_price = unit_price.replace(/,/g, '');
				// total_price = total_price.replace(/,/g, '');
                //
                data.push({							
                	"id_so_det": id_so_det,	
                	"no_so": no_so,						
                	"produk_det": produk_det,
                	"curr": curr,
                	"qty": qty,
                	"uom": uom,				
                	"price": price,
                	"total": total,									
                })	
				// alert(id_so_det + no_so + produk_det + curr + qty + uom + price + total);		 

			});

			var fdata = {
				'data_table': data
			}

			$.ajax({				
				url: "simpan_so_detail_proforma_temporary/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}

					//Load Data SO Proforma Temporary
					load_so_detail_proforma_temporary();                   		
					$('#modal-add-so-proforma').modal('hide');

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});
}

function load_invoice_detail_proforma_temporary(){ 

	$('#table-proforma-invoice tbody tr').remove();
	//
	$.ajax({		
		url: "load_invoice_detail_proforma_temporary/",							
		type: "GET",
		dataType: "JSON",
		success: function (response) {
			var trHTML = '';
			$.each(response, function (i, item) {
				trHTML += '<tr>';		
				trHTML += '<td>' + item.id_so + "</td>";		
				trHTML += '<td>' + item.so_no + "</td>";
				trHTML += '<td>' + item.so_date + "</td>";										    					
				trHTML += '<td>' + item.buyerno + "</td>";		
				trHTML += '<td align="center">' + item.curr + "</td>";	
				trHTML += '<td align="right">' + item.qty + "</td>";	
				trHTML += '<td align="right">' + item.unit_price + "</td>";	
				trHTML += '<td align="right">' + item.total_price + "</td>";											
				trHTML += '</tr>';

			});
			$('#table-proforma-invoice').append(trHTML);
                        //Grand Total SO Proforma
                        sum_grandtotal_proforma(); 

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    	alert('Error get data from ajax');
                    }
                });  	  	

}

//ubah september
function load_so_detail_proforma_temporary(){ 

	$('#table-proforma-sodet tbody tr').remove();
	//
	$.ajax({		
		url: "load_so_detail_proforma_temporary/",							
		type: "GET",
		dataType: "JSON",
		success: function (response) {
			var trHTML = '';
			$.each(response, function (i, item) {
				trHTML += '<tr>';		
				trHTML += '<td>' + item.id_so_det + "</td>";		
				trHTML += '<td>' + item.no_so + "</td>";
				trHTML += '<td>' + item.produk_det + "</td>";										    					
				trHTML += '<td>' + item.curr + "</td>";	
				trHTML += '<td align="right">' + item.qty + "</td>";		
				trHTML += '<td align="center">' + item.uom + "</td>";	
				trHTML += '<td align="right">' + item.unit_price + "</td>";	
				trHTML += '<td align="right">' + item.total_price + "</td>";											
				trHTML += '</tr>';

			});
			$('#table-proforma-sodet').append(trHTML);
                        //Grand Total SO Proforma
                        sum_grandtotal_proforma(); 

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    	alert('Error get data from ajax');
                    }
                });  	  	

}

function delete_invoice_detail_proforma_temporary(){ 

	$.ajax({						
		url: "delete_invoice_detail_proforma_temporary/",
		type: "GET",				
		dataType: "JSON",
		success: function (data) {
			
			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Delete Table Temporary'			     
			} else {
				msg = 'Error Delete Table Temporary'				
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Delete Table Temporary' + jqXHR.text			
		}
	});
	
}

//ubah september 
function delete_so_detail_proforma_temporary(){ 

	$.ajax({						
		url: "delete_so_detail_proforma_temporary/",
		type: "GET",				
		dataType: "JSON",
		success: function (data) {
			
			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Delete Table Temporary'			     
			} else {
				msg = 'Error Delete Table Temporary'				
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Delete Table Temporary' + jqXHR.text			
		}
	});
	
}
//ubah september
function sum_grandtotal_proforma(){
    //
    $.ajax({		
    	url: "sum_grandtotal_proforma/",							
    	type: "GET",
    	dataType: "JSON",
    	success: function (response) {				
    		$.each(response, function (i, item) {

    			$('[name="prof_grandtotal"]').val(item.grand_total);
    			$('[name="prof_grandtotal_h"]').val(formatMoney(item.grand_total));
    			$('[name="prof_twot"]').val(item.grand_total);
    			$('[name="prof_twot2"]').val(item.grand_total);
    			$('[name="prof_twot_h"]').val(formatMoney(item.grand_total));

    		});	
					//							
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert('Error get data from ajax');
				}
			});  	  
}

//ubah september
function add_data_proforma_invoice(){ 
	let x   = $('[name="prof_shipp"]').val();
	let peb = $('[name="prof_peb"]').val();
	let total = $('[name="prof_grandtotal"]').val();
	if (x == "") {
		alert("Shipp is required");
		return false;
	}

	if (x == "Export" && peb == "" ){
		alert("PEB Export is required");
		return false;
	}

	if (total == "" || total == "0") {
		alert("Grand Total Can't be Zero, Please Add Data SO");
		$('[name="prof_so_number2"]').focus();
		return false;
	}

	var no_proforma_invoice = $('[name="prof_inv_number"]').val()	
		 // alert(no_proforma_invoice);
		 //
		 $('[name="prof_no_inv_mdl"]').val(no_proforma_invoice);
		 $('#modal-simpan-proforma-invoice').modal('show');  		
		}

//ubah desember
function add_data_proforma_invoice_cbd(){ 
	let y   = $('[name="prof_type_pi"]').val();
	let x   = $('[name="prof_shipp_cbd"]').val();
	let peb = $('[name="prof_peb"]').val();
	let total = $('[name="prof_grandtotal"]').val();
	let dp = $('[name="prof_dp"]').val();
	if (y == "") {
		alert("Type Shipp is required");
		$('[name="prof_type_pi"]').focus();
		return false;
	}

	if (x == "") {
		alert("Shipp is required");
		$('[name="prof_shipp_cbd"]').focus();
		return false;
	}

	if (x == "Export" && peb == "" ){
		alert("PEB Export is required");
		$('[name="prof_peb"]').focus();
		return false;
	}

	if (total == "" || total == "0") {
		alert("Grand Total Can't be Zero, Please Add Data SO");
		$('[name="prof_so_number2"]').focus();
		return false;
	}

	if (y == "DP" && dp <= 1) {
		alert("Please Input DP");
		$('[name="prof_dp"]').focus();
		return false;
	}

	getcoa4();
	getcoa_ppn4();

	var no_proforma_invoice = $('[name="prof_inv_number"]').val()	
		 // alert(no_proforma_invoice);
		 //
		 $('[name="prof_no_inv_mdl"]').val(no_proforma_invoice);
		 $('#modal-simpan-proforma-invoice').modal('show');  		
		}

//ubah desember
function getcoa4() 
{	

	let shipp 		 = $('[name="prof_shipp_cbd"]').val();
	console.log(shipp);

	$.ajax({
		url: "getcoa4/" + shipp + "/",		
		type: "GET",
		dataType: "JSON",
		success: function (data) {

			$('[name="no_coa_deb4"]').val(data.no_coa);
			$('[name="nama_coa_deb4"]').val(data.nama_coa);
			console.log( data.no_coa );

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}
//ubah desember
function getcoa_ppn4() 
{	

	let shipp 		 = $('[name="prof_shipp_cbd"]').val();
	console.log(shipp);

	$.ajax({
		url: "getcoa_ppn4/" + shipp + "/",		
		type: "GET",
		dataType: "JSON",
		success: function (data) {

			$('[name="no_coa_ppn4"]').val(data.no_coa);
			$('[name="nama_coa_ppn4"]').val(data.nama_coa);
			console.log( data.no_coa );

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}


//ubah september
function input_dp_proforma_invoice() { 	
	
	var persen = 0.75;
	var nilai = $('[name="prof_grandtotal"]').val();
	var nilai_input_dp = $('[name="prof_dp"]').val();		
	var grandtotal = nilai.replace(/,/g, '')
	var hasil_persen = grandtotal * persen;
	//
	if (nilai_input_dp > hasil_persen){ 
		alert("Sory total DP lebih besar dari 75% (" + hasil_persen + ") Grand Total SO");
		$('[name="prof_dp"]').val(hasil_persen);
		$('[name="prof_dp_h"]').val(formatMoney(hasil_persen));
	} else{	
		$('[name="prof_dp_h"]').val(formatMoney(nilai_input_dp));
	}
}

//ubah september
function input_dp_proforma_invoice2() { 	
	
	var persen = 0.75;
	var persen_h = 75;
	var nilai = $('[name="prof_grandtotal"]').val();
	var nilai_input_dp = $('[name="prof_dp"]').val();
	var patokan = $('[name="pilih_dp_prof"]').val();		
	var grandtotal = nilai.replace(/,/g, '')
	var hasil_persen = grandtotal * persen;
	var hasil_persen_h = grandtotal * (nilai_input_dp / 100);
	//
	if (patokan == '%') {
		if (nilai_input_dp > persen_h){ 
			alert("Sorry total DP tidak bisa lebih dari 75% Grand Total SO");
			$('[name="prof_dp"]').val(persen_h);
			$('[name="prof_dp_h"]').val(formatMoney(hasil_persen));
			$('[name="prof_dp_h2"]').val(hasil_persen.toFixed(2));
		} else{	
			$('[name="prof_dp_h"]').val(formatMoney(hasil_persen_h));
			$('[name="prof_dp_h2"]').val(hasil_persen_h.toFixed(2));
		}
	}else{
		if (nilai_input_dp > hasil_persen){ 
			alert("Sorry total DP lebih besar dari 75% (" + hasil_persen + ") Grand Total SO");
			$('[name="prof_dp"]').val(hasil_persen.toFixed(2));
			$('[name="prof_dp_h"]').val(formatMoney(hasil_persen));
			$('[name="prof_dp_h2"]').val(hasil_persen.toFixed(2));
		} else{	
			$('[name="prof_dp_h"]').val(formatMoney(nilai_input_dp));
			$('[name="prof_dp_h2"]').val(nilai_input_dp.toFixed(2));
		}
	}
}

//ubah september
function ganti_dp(ganti) { 	
	
	$('[name="prof_dp"]').val("");
	$('[name="prof_dp_h"]').val("");
	$('[name="prof_dp_h2"]').val("");

}


//ubah september
function input_diskon_proforma() { 	
	var hasil_diskon = 0;
	var total = 0;
	var hasil_ppn = 0;
	var twot = 0;
	var nol = 0;
	var input_diskon = 0;
	var prof_ppn =parseFloat($('[name="id_ppn_prof"]').val()) || 0;
	var nilai =parseFloat($('[name="prof_twot2"]').val()) || 0;
	var patokan = $('[name="pilih_diskn_prof"]').val();
	var input_diskon_ =parseFloat($('[name="prof_diskon"]').val()) || 0;

	if (input_diskon_ >=1) {
		input_diskon = input_diskon_;
	}else{
		input_diskon = 0;
		$('[name="prof_diskon"]').val('');
	}
	
	if (patokan == '%') {
		if (input_diskon > 100){
			$('[name="prof_diskon"]').val("100")
			hasil_diskon = nilai * 1;
			twot = parseFloat(nilai - hasil_diskon);
		}else{
			hasil_diskon = nilai * (input_diskon/100);
			twot = parseFloat(nilai - hasil_diskon);
		}
	}else{
		if (input_diskon > nilai){
			$('[name="prof_diskon"]').val(nilai.toFixed(2))
			hasil_diskon = nilai;
			twot = parseFloat(nilai - hasil_diskon);
		}else{
			hasil_diskon = input_diskon;
			twot = parseFloat(nilai - hasil_diskon);
		}
	}

	hasil_ppn = parseFloat(twot * (prof_ppn/100));
	total = (twot + (twot * (prof_ppn/100)));
	
	//
	
	$('[name="prof_twot"]').val(twot.toFixed(2));
	$('[name="prof_twot_h"]').val(formatMoney(twot.toFixed(2)));	
	$('[name="prof_taxes"]').val(hasil_ppn.toFixed(2));
	$('[name="prof_taxes_h"]').val(formatMoney(hasil_ppn.toFixed(2)));
	$('[name="prof_grandtotal"]').val(total.toFixed(2));
	$('[name="prof_grandtotal_h"]').val(formatMoney(total.toFixed(2)));
	$('[name="prof_dp"]').val("");
	$('[name="prof_dp_h"]').val("");
	

}

//ubah september
function hitung_ppn(ppn) { 	
	var total = 0;
	var hasil_ppn = 0;
	var ppn_h = ppn;
	var nilai = parseFloat($('[name="prof_twot"]').val());
	hasil_ppn = parseFloat(nilai * (ppn_h/100));
	total = (nilai + (nilai * (ppn_h/100)));
	//
	$('[name="prof_taxes"]').val(hasil_ppn.toFixed(2));
	$('[name="prof_taxes_h"]').val(formatMoney(hasil_ppn.toFixed(2)));
	$('[name="prof_grandtotal"]').val(total.toFixed(2));
	$('[name="prof_grandtotal_h"]').val(formatMoney(total.toFixed(2)));
	$('[name="prof_dp"]').val("");
	$('[name="prof_dp_h"]').val("");
	// alert(total);
}


//ubah september
function ganti_diskon(ganti) { 	
	var total = 0;
	var hasil_ppn = 0;
	var g_diskon = ganti;
	var prof_ppn =parseFloat($('[name="id_ppn_prof"]').val()) || 0;
	var nilai =parseFloat($('[name="prof_twot2"]').val()) || 0;
	var patokan = $('[name="pilih_diskn_prof"]').val();
	var input_diskon =parseFloat($('[name="prof_diskon"]').val()) || 0;	

	if (g_diskon == '%') {
		if (input_diskon > 100){
			$('[name="prof_diskon"]').val("100")
			hasil_diskon = nilai * 1;
			twot = parseFloat(nilai - hasil_diskon);
		}else{
			hasil_diskon = nilai * (input_diskon/100);
			twot = parseFloat(nilai - hasil_diskon);
		}
	}else{
		if (input_diskon > nilai){
			$('[name="prof_diskon"]').val(nilai.toFixed(2))
			hasil_diskon = nilai;
			twot = parseFloat(nilai - hasil_diskon);
		}else{
			hasil_diskon = input_diskon;
			twot = parseFloat(nilai - hasil_diskon);
		}
	}	
	hasil_ppn = parseFloat(twot * (prof_ppn/100));
	total = (twot + (twot * (prof_ppn/100)));
	//
	
	$('[name="prof_twot"]').val(twot.toFixed(2));
	$('[name="prof_twot_h"]').val(formatMoney(twot.toFixed(2)));	
	$('[name="prof_taxes"]').val(hasil_ppn.toFixed(2));
	$('[name="prof_taxes_h"]').val(formatMoney(hasil_ppn.toFixed(2)));
	$('[name="prof_grandtotal"]').val(total.toFixed(2));
	$('[name="prof_grandtotal_h"]').val(formatMoney(total.toFixed(2)));
	$('[name="prof_dp"]').val("");
	$('[name="prof_dp_h"]').val("");
	
	// alert(total);
}


function save_proforma_invoice(){ 

	simpan_proforma_invoice_header()	

}
//ubah september
function simpan_proforma_invoice_header() { 
	
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		
            //
            var no_proforma_inv    = $('#prof_inv_number').val();
            var id_customer        = $('#prof_customer').val();
            var shipp              = $('#prof_shipp').val();
            var peb                = $('#prof_peb').val();
            var id_type            = $('#prof_type').val();
            var status             = "POST";                        
            var type_barang        = $('#prof_material_type').val();
            var id_top             = $('#prof_id_top').val();
            var id_bank            = $('#id_bank_prof').val();
            var type_so            = $('#type_so_prof').val();
            var twot               = $('#prof_twot').val();
            var ppn                = $('#prof_taxes').val();
            var total              = $('#prof_grandtotal').val();
            var dp                 = $('#prof_dp').val();
            var diskon             = $('#prof_diskon').val();
            var type_diskon        = $('#pilih_diskn_prof').val();
            var percentage_ppn     = $('#id_ppn_prof').val();
			//					
			//Set Now Date Proforma Invoice
			var tgl_proforma_inv   = new Date();		
			var dd = tgl_proforma_inv.getDate();
			var mm = tgl_proforma_inv.getMonth() + 1; 
			var yyyy = tgl_proforma_inv.getFullYear();	
			tgl_proforma_inv = yyyy+'-'+mm+'-'+dd;
			//			
			data.push({		
				"no_proforma_invoice": no_proforma_inv,
				"id_customer": id_customer,
				"shipp": shipp,	
				"peb": peb,					
				"id_type": id_type,
				"status": status,
				"tgl_proforma_inv": tgl_proforma_inv,	
				"type_barang": type_barang,		
				"id_top": id_top,	
				"id_bank": id_bank,		
				"type_so": type_so,
				"twot": twot,	
				"ppn": ppn,		
				"total": total,	
				"dp": dp,
				"diskon": diskon,	
				"type_diskon": type_diskon,		
				"percentage_ppn": percentage_ppn,												
			})	
			
			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_proforma_invoice_header/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}		
					
					//Simpan Proforma Invoice Detail
					simpan_proforma_invoice_detail()
					update_proforma_invoice_sodet()
					simpan_proforma_invoice_detail_so()	
				    //Hide Modal
				    $('#modal-simpan-proforma-invoice').modal('hide'); 
					//Reload Page
					window.location.reload();

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});

}


//ubah desember
function save_proforma_invoice_cbd(){ 

	simpan_proforma_invoice_header_cbd();
	var dp = $('#id_ppn_prof').val();
	at_credit_dpcbd();
	if (dp > 0) {		
		at_dp_dpcbd();
	}	

}

//ubah desember
function at_credit_dpcbd() { 
	

	var data = [];
	var cust_ctg = '';
	var total = 0;
	var total_ppn = 0;
	var total_pi = 0;

	var type_inv 	 	= $('[name="prof_type_pi"]').val();
	var ppn 	 		= $('[name="id_ppn_prof"]').val();

	if (type_inv == 'CBD') {
		total_pi = $('[name="prof_twot"]').val();
	}else{
		total_pi = $('[name="prof_dp_h2"]').val();
	}

	if (ppn == '0') {
		total_ppn = $('[name="prof_taxes"]').val();
	}else{
		total_ppn = total_pi * (ppn/100);
	}

	if (type_inv == 'CBD') {
		total = total_pi;
	}else{
		total = total_pi - total_ppn;
	}

	console.log(total_pi)
	data.push({		
		"no_inv": $('#prof_inv_number').val(),
		"no_coa": $('#no_coa_deb4').val(),
		"nama_coa": $('#nama_coa_deb4').val(),
		"total": total,																							
	})		

	var formData = {
		'data_table': data
	}

	console.log(formData);
	
	$.ajax({						
		url: "at_credit_dpcbd/" ,		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {		

			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Update Invoice Header'
			} else {
				msg = 'Error Update Invoice Header'
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Update Invoice Header' + jqXHR.text
		}
	});

}

//ubah desember
function at_dp_dpcbd() { 
	

	var data = [];
	var cust_ctg = '';
	var total = 0;
	var total_ppn = 0;

	var type_inv 	 	= $('[name="prof_type_pi"]').val();
	var ppn 	 		= $('[name="id_ppn_prof"]').val();
	var nilai_dp    	= $('[name="prof_dp_h2"]').val();

	if (type_inv == 'CBD') {
		total_ppn = $('[name="prof_taxes"]').val();
	}else{
		total_ppn = nilai_dp * (ppn/100);
	}


	data.push({		
		"no_inv": $('#prof_inv_number').val(),
		"no_coa": $('#no_coa_ppn4').val(),
		"nama_coa": $('#nama_coa_ppn4').val(),
		"total": total_ppn,																							
	})		

	var formData = {
		'data_table': data
	}

	console.log(formData);
	
	$.ajax({						
		url: "at_credit_dpcbd/" ,		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {		

			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Update Invoice Header'
			} else {
				msg = 'Error Update Invoice Header'
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Update Invoice Header' + jqXHR.text
		}
	});

}


//ubah september
function simpan_proforma_invoice_header_cbd() { 
	
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		
            //
            var no_proforma_inv    = $('#prof_inv_number').val();
            var id_customer        = $('#prof_customer').val();
            var shipp              = $('#prof_shipp').val();
            var peb                = $('#prof_peb').val();
            var id_type            = $('#prof_type').val();
            var status             = "POST";                        
            var type_barang        = $('#prof_material_type').val();
            var id_top             = $('#prof_id_top').val();
            var id_bank            = $('#id_bank_prof').val();
            var type_so            = $('#type_so_prof').val();
            var twot               = $('#prof_twot').val();
            var ppn                = $('#prof_taxes').val();
            var total              = $('#prof_grandtotal').val();
            var dp                 = $('#prof_dp').val();
            var diskon             = $('#prof_diskon').val();
            var type_diskon        = $('#pilih_diskn_prof').val();
            var percentage_ppn     = $('#id_ppn_prof').val();
            var tipe_dp     	   = $('#pilih_dp_prof').val();
            var value_dp     	   = $('#prof_dp_h2').val();
			//					
			//Set Now Date Proforma Invoice
			var tgl_proforma_inv   = new Date();		
			var dd = tgl_proforma_inv.getDate();
			var mm = tgl_proforma_inv.getMonth() + 1; 
			var yyyy = tgl_proforma_inv.getFullYear();	
			tgl_proforma_inv = yyyy+'-'+mm+'-'+dd;
			//			
			data.push({		
				"no_proforma_invoice": no_proforma_inv,
				"id_customer": id_customer,
				"shipp": shipp,	
				"peb": peb,					
				"id_type": id_type,
				"status": status,
				"tgl_proforma_inv": tgl_proforma_inv,	
				"type_barang": type_barang,		
				"id_top": id_top,	
				"id_bank": id_bank,		
				"type_so": type_so,
				"twot": twot,	
				"ppn": ppn,		
				"total": total,	
				"dp": dp,
				"diskon": diskon,	
				"type_diskon": type_diskon,		
				"percentage_ppn": percentage_ppn,
				"tipe_dp": tipe_dp,		
				"value_dp": value_dp,												
			})	
			
			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_proforma_invoice_header_cbd/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}		
					
					//Simpan Proforma Invoice Detail
					simpan_proforma_invoice_detail_cbd()
					update_proforma_invoice_sodet_cbd()
					simpan_proforma_invoice_detail_so_cbd()	
				    //Hide Modal
				    $('#modal-simpan-proforma-invoice').modal('hide'); 
					//Reload Page
					window.location.reload();

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});

}

function simpan_proforma_invoice_detail(){ 

	var msg
	var data = [];		
	var table = document.getElementById("table-proforma-invoice");
	for (var i = 1; i < (table.rows.length); i++) {
				//
				var qty_det = table.rows[i].cells[5].innerHTML; 
				var unit_price_det = table.rows[i].cells[6].innerHTML;
				var total_price_det = table.rows[i].cells[7].innerHTML;
				//				
				qty_det = qty_det.replace(/,/g, '');
				unit_price_det = unit_price_det.replace(/,/g, '');
				total_price_det = total_price_det.replace(/,/g, '');
				//				
				data.push({		
					"no_invoice_proforma": $('#prof_inv_number').val(),
					"so_no": table.rows[i].cells[1].innerHTML,
					"so_date": table.rows[i].cells[2].innerHTML,
					"buyerno": table.rows[i].cells[3].innerHTML,					
					"curr":table.rows[i].cells[4].innerHTML,
					"qty": qty_det,
					"unit_price": unit_price_det,
					"total_price": total_price_det,
					"id_so": table.rows[i].cells[0].innerHTML,			

				})		
			}

			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_proforma_invoice_detail/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}						

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			
		}

//ubah september
function simpan_proforma_invoice_detail_so(){ 

	var msg
	var data = [];		
	var table = document.getElementById("table-proforma-sodet");
	for (var i = 1; i < (table.rows.length); i++) {
				//
				var qty_det = table.rows[i].cells[4].innerHTML; 
				var unit_price_det = table.rows[i].cells[6].innerHTML;
				var total_price_det = table.rows[i].cells[7].innerHTML;
				//				
				qty_det = qty_det.replace(/,/g, '');
				unit_price_det = unit_price_det.replace(/,/g, '');
				total_price_det = total_price_det.replace(/,/g, '');
				//				
				data.push({		
					"no_invoice_proforma": $('#prof_inv_number').val(),
					"id_so_det": table.rows[i].cells[0].innerHTML,
					"no_so": table.rows[i].cells[1].innerHTML,
					"produk_detail": table.rows[i].cells[2].innerHTML,					
					"curr":table.rows[i].cells[3].innerHTML,
					"qty": qty_det,
					"uom": table.rows[i].cells[5].innerHTML,		
					"unit_price": unit_price_det,
					"total_price": total_price_det,			

				})		
			}

			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_proforma_invoice_detail_so/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}						

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			
		}
//ubah september
function update_proforma_invoice_sodet() { 

	var table = document.getElementById("table-proforma-sodet");
	for (var i = 1; i < (table.rows.length); i++) {
				//   
				var id_sodet = table.rows[i].cells[0].innerHTML
				var prof_inv_number =  $('#prof_inv_number').val()
                //
                var formData = {
                	"id_sodet": id_sodet,
                	"prof_inv_number": prof_inv_number,

                };
				//
				$.ajax({						
					url: "update_pi_sodet/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Bppb'
						} else {
							msg = 'Error Update Bppb'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Bppb' + jqXHR.text
					}
				});   	
				//					
			}				
		}

//ubah september
function update_proforma_invoice_sodet_cbd() { 

	var table = document.getElementById("table-proforma-sodet");
	for (var i = 1; i < (table.rows.length); i++) {
				//   
				var id_sodet = table.rows[i].cells[0].innerHTML
				var prof_inv_number =  $('#prof_inv_number').val()
                //
                var formData = {
                	"id_sodet": id_sodet,
                	"prof_inv_number": prof_inv_number,

                };
				//
				$.ajax({						
					url: "update_pi_sodet_cbd/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Bppb'
						} else {
							msg = 'Error Update Bppb'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Bppb' + jqXHR.text
					}
				});   	
				//					
			}				
		}

//ubah september
function simpan_proforma_invoice_detail_cbd(){ 

	var msg
	var data = [];		
	var table = document.getElementById("table-proforma-invoice");
	for (var i = 1; i < (table.rows.length); i++) {
				//
				var qty_det = table.rows[i].cells[5].innerHTML; 
				var unit_price_det = table.rows[i].cells[6].innerHTML;
				var total_price_det = table.rows[i].cells[7].innerHTML;
				//				
				qty_det = qty_det.replace(/,/g, '');
				unit_price_det = unit_price_det.replace(/,/g, '');
				total_price_det = total_price_det.replace(/,/g, '');
				//				
				data.push({		
					"no_invoice_proforma": $('#prof_inv_number').val(),
					"so_no": table.rows[i].cells[1].innerHTML,
					"so_date": table.rows[i].cells[2].innerHTML,
					"buyerno": table.rows[i].cells[3].innerHTML,					
					"curr":table.rows[i].cells[4].innerHTML,
					"qty": qty_det,
					"unit_price": unit_price_det,
					"total_price": total_price_det,
					"id_so": table.rows[i].cells[0].innerHTML,			

				})		
			}

			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_proforma_invoice_detail_cbd/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}						

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			
		}

//ubah september
function ubah_header1(kata){
	$('[name="h_header1"]').val(kata);
	if (kata == '') {
		$('input[name=inputan3]').prop('readonly', true);
		$('input[name=inputan3]').val("");	
	}else{
		$('input[name=inputan3]').prop('readonly', false);
	}
}

//ubah september
function ubah_header2(kata){
	$('[name="h_header2"]').val(kata);
	if (kata == '') {
		$('input[name=inputan4]').prop('readonly', true);
		$('input[name=inputan4]').val("");	
	}else{
		$('input[name=inputan4]').prop('readonly', false);
	}
}

//ubah september
function ubah_header3(kata){
	$('[name="h_header3"]').val(kata);
	if (kata == '') {
		$('input[name=inputan5]').prop('readonly', true);
		$('input[name=inputan5]').val("");	
	}else{
		$('input[name=inputan5]').prop('readonly', false);
	}
}

//ubah september
function simpan_proforma_invoice_detail_so_cbd(){ 

	var msg
	var data = [];		
	var table = document.getElementById("table-proforma-sodet");
	for (var i = 1; i < (table.rows.length); i++) {
				//
				var qty_det = table.rows[i].cells[4].innerHTML; 
				var unit_price_det = table.rows[i].cells[6].innerHTML;
				var total_price_det = table.rows[i].cells[7].innerHTML;
				//				
				qty_det = qty_det.replace(/,/g, '');
				unit_price_det = unit_price_det.replace(/,/g, '');
				total_price_det = total_price_det.replace(/,/g, '');
				//				
				data.push({		
					"no_invoice_proforma": $('#prof_inv_number').val(),
					"id_so_det": table.rows[i].cells[0].innerHTML,
					"no_so": table.rows[i].cells[1].innerHTML,
					"produk_detail": table.rows[i].cells[2].innerHTML,					
					"curr":table.rows[i].cells[3].innerHTML,
					"qty": qty_det,
					"uom": table.rows[i].cells[5].innerHTML,		
					"unit_price": unit_price_det,
					"total_price": total_price_det,			

				})		
			}

			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_proforma_invoice_detail_so_cbd/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}						

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			
		}


		function cari_proforma_invoice(){ 

			$('#table-list-proforma-invoice tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_prof_inv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_prof_inv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_prof_inv   = "undefined";
			dt_sampai_prof_inv = "undefined";
		});

		var id_customer = $('#list_prof_customer').val();	

		$.ajax({		
			url: "cari_proforma_invoice/" + dt_dari_prof_inv + "/" + dt_sampai_prof_inv + "/" + id_customer + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 					
					trHTML += '<tr>';					
					trHTML += '<td>' + item.id + "</td>";
					trHTML += '<td>' + item.no_pi + "</td>";	
					trHTML += '<td>' + item.date_pi + "</td>";
					trHTML += '<td>' + item.customer + "</td>";
					trHTML += '<td>' + item.shipp + "</td>";	
					trHTML += '<td>' + item.peb + "</td>";	
					trHTML += '<td>' + item.type + "</td>";	
					trHTML += '<td>' + item.status + "</td>";	
					trHTML += '<td>' + item.no_faktur_pajak + "</td>";	
					trHTML += '<td align="right">' + item.amount + "</td>";	
					trHTML += '<td><button id="faktur_pjk" name="faktur_pjk" type="button" class="btn btn-info btn-sm" onclick="update_faktur_pjk(' + item.id + ')" >Update</button> ' + '' + ' <button id="print_inv_pi" name="print_inv_pi" type="button" class="btn btn-primary btn-sm" onclick="print_proforma_invoice(' + item.id + ')"><i class="fa fa-print"></i> Print</button></td>';					
				// trHTML += '<td><button id="export_to_excel" name="export_to_excel" type="button" class="btn btn-primary btn-sm" onclick="export_to_excel_pi(' + item.id + ')"><i class="fa fa-download"></i> Export To Xls</button></td>';					

				trHTML += '</tr>';
			});

				$('#table-list-proforma-invoice').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	

	}

//ubah september
function cari_proforma_invoice_cbd(){ 
	
	$('#table-list-proforma-invoice tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_prof_inv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_prof_inv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_prof_inv   = "undefined";
			dt_sampai_prof_inv = "undefined";
		});

		var id_customer = $('#list_prof_customer').val();	

		$.ajax({		
			url: "cari_proforma_invoice_cbd/" + dt_dari_prof_inv + "/" + dt_sampai_prof_inv + "/" + id_customer + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 					
					trHTML += '<tr>';					
					trHTML += '<td>' + item.id + "</td>";
					trHTML += '<td>' + item.no_pi + "</td>";	
					trHTML += '<td>' + item.date_pi + "</td>";
					trHTML += '<td>' + item.customer + "</td>";
					trHTML += '<td>' + item.shipp + "</td>";	
					trHTML += '<td>' + item.peb + "</td>";	
					trHTML += '<td>' + item.type + "</td>";	
					trHTML += '<td>' + item.status + "</td>";	
					trHTML += '<td>' + item.no_faktur_pajak + "</td>";	
					trHTML += '<td align="right">' + item.amount + "</td>";	
					trHTML += '<td><button id="faktur_pjk" name="faktur_pjk" type="button" class="btn btn-info btn-sm" onclick="update_faktur_pjk_cbd(' + item.id + ')" >Update</button> ' + '' + ' <button id="print_inv_pi" name="print_inv_pi" type="button" class="btn btn-primary btn-sm" onclick="print_proforma_invoice_cbd(' + item.id + ')"><i class="fa fa-print"></i> Print</button></td>';					
				// trHTML += '<td><button id="export_to_excel" name="export_to_excel" type="button" class="btn btn-primary btn-sm" onclick="export_to_excel_pi(' + item.id + ')"><i class="fa fa-download"></i> Export To Xls</button></td>';					

				trHTML += '</tr>';
			});

				$('#table-list-proforma-invoice').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	

	}

//ubah september
function cari_debit_note(){ 
	
	$('#table-list-debit-note tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_prof_inv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_prof_inv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_prof_inv   = "undefined";
			dt_sampai_prof_inv = "undefined";
		});

		var id_customer = $('#list_prof_customer').val();	

		$.ajax({		
			url: "cari_debit_note/" + dt_dari_prof_inv + "/" + dt_sampai_prof_inv + "/" + id_customer + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 
					if(item.status == 'POST'){					
						trHTML += '<tr>';					
						trHTML += '<td>' + item.no_dn + "</td>";	
						trHTML += '<td>' + item.tgl_dn + "</td>";
						trHTML += '<td>' + item.type_dn + "</td>";
						trHTML += '<td>' + item.Supplier + "</td>";
						trHTML += '<td>' + item.attn + "</td>";	
						trHTML += '<td>' + item.from_curr + "</td>";	
						trHTML += '<td>' + item.to_curr + "</td>";	
						trHTML += '<td>' + item.amount + "</td>";	
						trHTML += '<td align="right">' + item.eqv_curr + "</td>";	
						trHTML += '<td align="right">' + item.status + "</td>";	
						trHTML += '<td><button id="print_inv_pi" name="print_inv_pi" type="button" class="btn btn-primary btn-sm" onclick="print_debit_note(\'' + item.id + '\',\'' + item.type_dn + '\')"><i class="fa fa-print"></i> Print</button>' + ''
						+ ' <button type="button" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="cancel_dn(\'' + item.no_dn + '\',\'' + item.id + '\', \'' + item.status + '\')">Cancel</button></td>';					
				// trHTML += '<td><button id="export_to_excel" name="export_to_excel" type="button" class="btn btn-primary btn-sm" onclick="export_to_excel_pi(' + item.id + ')"><i class="fa fa-download"></i> Export To Xls</button></td>';					

				trHTML += '</tr>';
			}else if(item.status == 'APPROVED'){
				trHTML += '<tr>';					
				trHTML += '<td>' + item.no_dn + "</td>";	
				trHTML += '<td>' + item.tgl_dn + "</td>";
				trHTML += '<td>' + item.type_dn + "</td>";
				trHTML += '<td>' + item.Supplier + "</td>";
				trHTML += '<td>' + item.attn + "</td>";	
				trHTML += '<td>' + item.from_curr + "</td>";	
				trHTML += '<td>' + item.to_curr + "</td>";	
				trHTML += '<td>' + item.amount + "</td>";	
				trHTML += '<td align="right">' + item.eqv_curr + "</td>";	
				trHTML += '<td align="right">' + item.status + "</td>";	
				trHTML += '<td><button id="print_inv_pi" name="print_inv_pi" type="button" class="btn btn-primary btn-sm" onclick="print_debit_note(\'' + item.id + '\',\'' + item.type_dn + '\')"><i class="fa fa-print"></i> Print</button></td>';					
				// trHTML += '<td><button id="export_to_excel" name="export_to_excel" type="button" class="btn btn-primary btn-sm" onclick="export_to_excel_pi(' + item.id + ')"><i class="fa fa-download"></i> Export To Xls</button></td>';					
				trHTML += '</tr>';
			}else{
				trHTML += '<tr>';					
				trHTML += '<td>' + item.no_dn + "</td>";	
				trHTML += '<td>' + item.tgl_dn + "</td>";
				trHTML += '<td>' + item.type_dn + "</td>";
				trHTML += '<td>' + item.Supplier + "</td>";
				trHTML += '<td>' + item.attn + "</td>";	
				trHTML += '<td>' + item.from_curr + "</td>";	
				trHTML += '<td>' + item.to_curr + "</td>";	
				trHTML += '<td>' + item.amount + "</td>";	
				trHTML += '<td align="right">' + item.eqv_curr + "</td>";	
				trHTML += '<td align="right">' + item.status + "</td>";	
				trHTML += '<td style="text-align: center;"><i><b>Canceled</b></i></td>';				
				// trHTML += '<td><button id="export_to_excel" name="export_to_excel" type="button" class="btn btn-primary btn-sm" onclick="export_to_excel_pi(' + item.id + ')"><i class="fa fa-download"></i> Export To Xls</button></td>';					
				trHTML += '</tr>';
			}
		});

				$('#table-list-debit-note').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	

	}

//ubah september
function cancel_dn(no_dn,id, status){ 

	let status_inv  = status;		

	$('#txt_cancel_book').val(no_dn);
	$('#id_debnote').val(no_dn);
	// $('#id_bppb').val(shipp_number);
	$('#modal-cancel-dn').modal('show');  

}

function update_faktur_pjk(id) { 
	
	$('[name="id_inv_prof"]').val(id);	
	$('#modal-update-faktur-pjk').modal('show');  

}

function update_faktur_pjk_cbd(id) { 
	
	$('[name="id_inv_prof"]').val(id);	
	$('#modal-update-faktur-pjk_cbd').modal('show');  

}

function print_proforma_invoice($id) {

	window.open(".../../report_proforma_invoice/" + $id + "/");  	

}
//ubah september
function print_proforma_invoice_cbd($id) {

	window.open(".../../report_proforma_invoice_cbd/" + $id + "/");  	

}

//ubah september
function print_debit_note($id,$type) {
	if ($type == 'MEMO') {
		window.open(".../../report_debit_note_memo/" + $id + "/");  	
	}else{
		window.open(".../../report_debit_note/" + $id + "/");  		
	}		

}

function export_to_excel_pi($id){ 

	window.open(".../../excel_pi_invoice/" + $id + "/");  

}

function export_list_pi() { 
	var id_customer = $('#list_prof_customer').val();	
	window.open(".../../export_excel_list_pi/" + dt_dari_prof_inv  + "/" + dt_sampai_prof_inv + "/" + "/" + id_customer + "/" ); 
}

//ubah september
function export_list_pi_cbd() { 
	var id_customer = $('#list_prof_customer').val();	
	window.open(".../../export_excel_list_pi_cbd/" + dt_dari_prof_inv  + "/" + dt_sampai_prof_inv + "/" + "/" + id_customer + "/" ); 
}

//Return Invoice
function get_kode_return_invoice(kode) { 
	$.ajax({
		url: "get_kode_return_invoice/" + kode,		
		type: "GET",
		dataType: "JSON",
		success: function (id) {

			$('[name="rtn_inv_number"]').val(id);

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

function add_id_for_return_inv(){ 	


	$('#example4 tbody tr').remove();	
	$('#table-return-invoice tbody tr').remove();	
	$('#table-return-invoice-mdl tbody tr').remove();	
	//
	$cust_rtn = $("#rtn_customer :selected").text(); 	
	$idcust_rtn = $('[name="rtn_customer"]').val()	
	//
	$('[name="rtn_custm"]').val($cust_rtn);
	$('[name="rtn_id_custm"]').val($idcust_rtn);

}

function add_data_return_invoice(){ 
	let shipp = $('[name="rtn_shipp"]').val();
	let nrp   = $('[name="rtn_nrp"]').val();
	if (shipp == "") {
		alert("Shipp is required");
		$("#rtn_shipp").focus();
		return false;
	}
		//
		if (nrp == "") {
			alert("Nrp is required");
			$("#rtn_nrp").focus();
			return false;
		}

		$no_return_invoice = $('[name="rtn_inv_number"]').val()		
		//
		$('[name="rtn_no_inv_mdl"]').val($no_return_invoice);
		$('#modal-simpan-return-invoice').modal('show');  		
	}

	function cari_sjbpb_return(){ 

		$('#table-return-invoice-mdl tbody tr').remove();	

	//Date range picker
	$('input[name="reservation2"]').daterangepicker({
		autoUpdateInput: false,
		locale: {
			cancelLabel: 'Clear'
		}
	});
	
	$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
		dt_dari_rtn_sjbpb   = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_rtn_sjbpb = picker.endDate.format('YYYY-MM-DD');
		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
	});
	
	$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
		$(this).val('');
		dt_dari_rtn_sjbpb = "undefined";
		dt_sampai_rtn_sjbpb = "undefined";
	});

	var id_customer = $('#rtn_id_custm').val();

	$.ajax({		
		url: "cari_sjbpb_return/" + dt_dari_rtn_sjbpb + "/" + dt_sampai_rtn_sjbpb + "/" + id_customer + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {

			var trHTML = '';
			$.each(response, function (i, item) {
				trHTML += '<tr>';				
				trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_sjbpb_rtn" id="pilih_sjbpb_rtn" class="flat"></td>';									
				trHTML += '<td hidden="hidden">' + item.id + "</td>";
				trHTML += '<td>' + item.bpb_number + "</td>";	
				trHTML += '<td>' + item.sj_number + "</td>";
				trHTML += '<td>' + item.bpbdate+ "</td>";
				trHTML += '<td align="center">' + item.curr + "</td>";
				trHTML += '<td align="right">' + item.qty + "</td>";	
				trHTML += '<td align="right">' + item.price + "</td>";	
				trHTML += '<td align="right">' + item.total_price + "</td>";						
				trHTML += '</tr>';
			});

			$('#table-return-invoice-mdl').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	

}

function duplicate_data_sjbpb_return(){ 

	delete_invoice_detail_return_temporary()
	simpan_invoice_detail_return_temporary()
}

function simpan_invoice_detail_return_temporary(){ 
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		

			$("#table-return-invoice-mdl input[name='pilih_sjbpb_rtn']:checked").each(function () {
				var rows = $(this).closest("tr")[0];
				//
				var qty = rows.cells[6].innerHTML; 
				var price = rows.cells[7].innerHTML;
				var total_price = rows.cells[8].innerHTML;
				//
				qty = qty.replace(/,/g, '');
				price = price.replace(/,/g, '');
				total_price = total_price.replace(/,/g, '');
                //
                data.push({												
                	"id_bpb": rows.cells[1].innerHTML,	
                	"bpb_number": rows.cells[2].innerHTML,						
                	"sj_number": rows.cells[3].innerHTML,
                	"bpbdate": rows.cells[4].innerHTML,
                	"curr": rows.cells[5].innerHTML,
                	"qty": qty,
                	"price": price,					
                	"total_price": total_price,													
                })		 

            });

			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_invoice_detail_return_temporary/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}

					//Load Data Invoice Return Temporary
					load_invoice_detail_return_temporary();                   		
					$('#modal-add-sjbpb-return').modal('hide');

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});
}

function load_invoice_detail_return_temporary(){ 

	$('#table-return-invoice tbody tr').remove();
	$.ajax({		
		url: "load_invoice_detail_return_temporary/",							
		type: "GET",
		dataType: "JSON",
		success: function (response) {
			var trHTML = '';
			$.each(response, function (i, item) {
				trHTML += '<tr>';		
				trHTML += '<td hidden="hidden">' + item.id_bpb + "</td>";		
				trHTML += '<td>' + item.bpb_number + "</td>";
				trHTML += '<td>' + item.sj_number + "</td>";										    					
				trHTML += '<td>' + item.bpbdate + "</td>";		
				trHTML += '<td align="center">' + item.curr + "</td>";	
				trHTML += '<td align="right">' + item.qty + "</td>";	
				trHTML += '<td align="right">' + item.price + "</td>";	
				trHTML += '<td align="right">' + item.total_price + "</td>";											
				trHTML += '</tr>';
			});
			$('#table-return-invoice').append(trHTML);						
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});  	  	

}

function delete_invoice_detail_return_temporary(){ 

	$.ajax({						
		url: "delete_invoice_detail_return_temporary/",
		type: "GET",				
		dataType: "JSON",
		success: function (data) {
			
			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Delete Table Temporary'			     
			} else {
				msg = 'Error Delete Table Temporary'				
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Delete Table Temporary' + jqXHR.text			
		}
	});
	
}

function save_return_invoice(){ 
	
	simpan_return_invoice_header()	

}

function simpan_return_invoice_header() { 
	
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		
            //
            var no_return_inv      = $('#rtn_inv_number').val();
            var id_customer        = $('#rtn_customer').val();
            var shipp              = $('#rtn_shipp').val();
            var peb                = $('#rtn_peb').val();
            var id_type            = $('#rtn_type').val();
            var status             = "POST";       
            var nrp                = $('#rtn_nrp').val();
            var asal_inv           = $('#rtn_inv_asal').val();    
            var id_bank            = $('#id_bank_return').val();      
           	//
			//Set Now Date Return Invoice
			var tgl_rtn_inv  = new Date();		
			var dd = tgl_rtn_inv.getDate();
			var mm = tgl_rtn_inv.getMonth() + 1; 
			var yyyy = tgl_rtn_inv.getFullYear();	
			tgl_rtn_inv = yyyy+'-'+mm+'-'+dd;
			//			
			data.push({		
				"no_return_invoice": no_return_inv,
				"id_customer": id_customer,
				"shipp": shipp,	
				"peb": peb,					
				"id_type": id_type,
				"status": status,
				"nrp": nrp,
				"no_invoice_asal": asal_inv,	
				"tgl_return_inv": tgl_rtn_inv,		
				"id_bank": id_bank,															
			})	
			
			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_return_invoice_header/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}		
					
					//Simpan Return Invoice Detail
					simpan_return_invoice_detail()	
				    //Hide Modal
				    $('#modal-simpan-return-invoice').modal('hide'); 
					//Reload Page
					window.location.reload();

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});
}

function simpan_return_invoice_detail(){ 

	var msg
	var data = [];		
	var table = document.getElementById("table-return-invoice");
	for (var i = 1; i < (table.rows.length); i++) {
		//
		var qty_det         = table.rows[i].cells[5].innerHTML; 
		var price_det       = table.rows[i].cells[6].innerHTML;
		var total_price_det = table.rows[i].cells[7].innerHTML;
		//				
		qty_det             = qty_det.replace(/,/g, '');
		price_det           = price_det.replace(/,/g, '');
		total_price_det     = total_price_det.replace(/,/g, '');
		//				
		data.push({		
			"id_bpb"                : table.rows[i].cells[0].innerHTML,
			"no_invoice_return"     : $('#rtn_inv_number').val(),
			"bpb_number"            : table.rows[i].cells[1].innerHTML,
			"sj_number"			    : table.rows[i].cells[2].innerHTML,
			"bpbdate"				: table.rows[i].cells[3].innerHTML,					
			"curr"					: table.rows[i].cells[4].innerHTML,
			"qty"					: qty_det,
			"price"			        : price_det,
			"total_price"			: total_price_det,				

		})		
	}

	var fdata = {
		'data_table': data
	}
	$.ajax({				
		url: "simpan_return_invoice_detail/",
		type: "POST",
		data: fdata,
		dataType: "JSON",
		success: function (data) {
			
			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Input Detail'
			} else {
				msg = 'Error Input Detail'
			}						

		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Input Detail' + jqXHR.text
		}
	});

}

function cari_return_invoice() { 
	
	$('#table-list-return-invoice tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_rtn_inv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_rtn_inv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});		

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_rtn_inv   = "undefined";
			dt_sampai_rtn_inv = "undefined";
		});

		var id_customer = $('#list_rtn_customer').val();					

		$.ajax({		
			url: "cari_return_invoice/" + dt_dari_rtn_inv + "/" + dt_sampai_rtn_inv + "/" + id_customer + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 			

					trHTML += '<tr>';					
					trHTML += '<td>' + item.id + "</td>";
					trHTML += '<td>' + item.no_return_invoice + "</td>";	
					trHTML += '<td>' + item.tgl_return_inv + "</td>";
					trHTML += '<td>' + item.customer + "</td>";
					trHTML += '<td>' + item.shipp + "</td>";	
					trHTML += '<td>' + item.peb + "</td>";	
					trHTML += '<td>' + item.type + "</td>";	
					trHTML += '<td>' + item.status + "</td>";	
					trHTML += '<td>' + item.nrp + "</td>";	
					trHTML += '<td>' + item.no_invoice_asal + "</td>";	
					trHTML += '<td align="right">' + item.amount + "</td>";		
					trHTML += '<td><button id="print_return_inv" name="print_return_inv" type="button" class="btn btn-primary btn-sm" onclick="print_return_invoice(' + item.id + ')"><i class="fa fa-print"></i> Print</button> ' + '' + '<button id="export_to_excel_return_invoice" name="export_to_excel_return_invoice" type="button" class="btn btn-primary btn-sm" onclick="export_to_excel_return_invoice(' + item.id + ')"><i class="fa fa-download"></i> Export To Xls</button></td>';									

					trHTML += '</tr>';
				});

				$('#table-list-return-invoice').append(trHTML);		

			// var rowCount = document.getElementById('table-list-return-invoice').rows.length;
			// if (rowCount == 1) { 
			// 	alert("Data Tidak Ditemukan");
			// }			
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	

	}

	function print_return_invoice($id) {

		window.open(".../../report_return_invoice/" + $id + "/" );  	
		
	}

	function export_to_excel_return_invoice($id){ 

		window.open(".../../excel_return_invoice/" + $id + "/" );  

	}

	function export_list_return(){
		var id_customer = $('#list_rtn_customer').val();	
		window.open(".../../export_excel_list_return/" + dt_dari_rtn_inv  + "/" + dt_sampai_rtn_inv + "/" + "/" + id_customer + "/" ); 

	}

//Debit Note

function save_debitnote() { 
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		
			
				//Set Now Date
				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth() + 1; 
				var yyyy = today.getFullYear();	
				today = yyyy+'-'+mm+'-'+dd;
				//
				var no_debitnote    = $('#dn_number').val();				
				var id_customer     = $('#dn_customer').val();
				var input_date      = today;
				var doc_date        = $('#doc_date').val();
				var coa             = $('#dn_coa').val();
				var value           = $('#dn_value').val();
				var desc            = $('#dn_desc').val();
				var duedate         = $('#dn_duedate').val(); 
				var status          = "DONE"
				//
				data.push({							
					"no_debitnote" : no_debitnote,
					"id_customer"  : id_customer,	
					"input_date"   : input_date,	
					"doc_date"     : doc_date,
					"coa"          : coa,	
					"value"        : value,		
					"description"  : desc,	
					"duedate"      : duedate,					
					"status"       : status,												
				})							

				var fdata = {
					'data_table': data
				}
				$.ajax({				
					url: "save_debitnote/",
					type: "POST",
					data: fdata,
					dataType: "JSON",
					success: function (data) {

					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}

					$('#modal-debit-note').modal('hide');
					//Reload Page
					location.reload();

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
				resolve({
					msg: msg,
				});

			}, 100);
	});

}

function reload_page_debitnote() { 
	location.reload();	
}

//User Role

function user_change(name) { 
	
	$("input:radio[name=pilih_user]:checked").each(function() {
		$('[name="txt_username"]').val(name);
	});

}

function simpan_userrole() { 

	delete_before_userrole();
	save_userrole();

}

function delete_before_userrole() { 

	var namauser = 	$('[name="txt_username"]').val();	
	
	$.ajax({						
		url: "delete_before_userrole/" + namauser + "/",
		type: "GET",				
		dataType: "JSON",
		success: function (data) {
			
			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Delete Table Temporary'			     
			} else {
				msg = 'Error Delete Table Temporary'				
			}

		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Delete Table Temporary' + jqXHR.text			
		}
	});

}

function save_userrole() { 
	
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		

			$("#table-menu input[name='pilih_menu']:checked").each(function () {
				var rows = $(this).closest("tr")[0];
				//			
				var namauser = 	$('[name="txt_username"]').val();				
				data.push({			
					"user": namauser,										
					"menu_id": rows.cells[3].innerHTML,	
					"base_url": rows.cells[2].innerHTML,		
				})		 

			});

			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "save_userrole/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					
					// window.location.replace("logout_user_acces");

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			window.location.reload();
			resolve({
				msg: msg,
			});

		}, 100);
	});
}

function checkallmenu(ele) { 

	var checkboxes = document.getElementsByTagName('input');
	if (ele.checked) {
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].type == 'checkbox'  && !(checkboxes[i].disabled) ) {
				checkboxes[i].checked = true;
			}
		}
	} else {
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].type == 'checkbox') {
				checkboxes[i].checked = false;
			}
		}
	}

}

function add_id_for_kwt() {

	$cust = $('[name="customer"]').val()	
	//
	$('[name="custmr"]').val($cust);
	//
	$('#tabelkwt tbody tr').remove();	
	$('#table-inv-kwt tbody tr').remove();
	//
	$('#so_number1').val("");
	//$('#id_sj').val("");
	//Clear Value : Total, Discount, Down Payment, Return, Total With Out Tax, VAT, Grand Total
	$('#total').val("");
	$('#total1').val("");
	$('#terbilang').val("");
	$('#val_kwt').val("");
	$('#val_kwt1').val("");
	// $('#vat').val("");
	// $('#grandtotal').val("");	
	//
	$('#table-inv-kwt tbody tr').remove();	
	//
	cari_data_inv();
	modal_clear_component();

}

function cari_data_inv() { 

	$('#table-inv-kwt tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_invkwt = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_invkwt = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_invkwt   = "undefined";
			dt_sampai_invkwt = "undefined";
		});

		var id_customer = $('#customer').val();

		console.log(dt_dari_invkwt + ' ' + dt_sampai_invkwt);

		$.ajax({		
			url: "cari_invoice_kwt/" + dt_dari_invkwt + "/" + dt_sampai_invkwt + "/" + id_customer + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 								
					trHTML += '<tr>';					
					trHTML += '<td>' + item.no_invoice + "</td>";
					trHTML += '<td>' + item.inv_date + "</td>";
					trHTML += '<td>' + item.customer + "</td>";	
					trHTML += '<td>' + item.shipp + "</td>";	
					trHTML += '<td>' + item.doc_type + "</td>";
					trHTML += '<td>' + item.doc_number + "</td>";
					trHTML += '<td>' + item.type + "</td>";	
					trHTML += '<td>' + item.amount1 + "</td>";
					trHTML += '<td><input type="checkbox" name="mdl_cek_kwt" id="mdl_cek_kwt" class="flat"  onclick="modal_sum_total_kwt(value = ' +  item.amount1 + ');"></td>';

					trHTML += '</tr>';
				});

				$('#table-inv-kwt').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	

	}


	function terbilang(angka){

		var bilne=["","Satu","Dua","Tiga","Empat","Lima","Enam","Tujuh","Delapan","Sembilan","Sepuluh","Sebelas"];

		if(angka < 12){

			return bilne[angka];

		}else if(angka < 20){

			return terbilang(angka-10)+" Belas";

		}else if(angka < 100){

			return terbilang(Math.floor(parseInt(angka)/10))+" Puluh "+terbilang(parseInt(angka)%10);

		}else if(angka < 200){

			return "Seratus "+terbilang(parseInt(angka)-100);

		}else if(angka < 1000){

			return terbilang(Math.floor(parseInt(angka)/100))+" Ratus "+terbilang(parseInt(angka)%100);

		}else if(angka < 2000){

			return "Seribu "+terbilang(parseInt(angka)-1000);

		}else if(angka < 1000000){

			return terbilang(Math.floor(parseInt(angka)/1000))+" Ribu "+terbilang(parseInt(angka)%1000);

		}else if(angka < 1000000000){

			return terbilang(Math.floor(parseInt(angka)/1000000))+" Juta "+terbilang(parseInt(angka)%1000000);

		}else if(angka < 1000000000000){

			return terbilang(Math.floor(parseInt(angka)/1000000000))+" Milyar "+terbilang(parseInt(angka)%1000000000);

		}else if(angka < 1000000000000000){

			return terbilang(Math.floor(parseInt(angka)/1000000000000))+" Trilyun "+terbilang(parseInt(angka)%1000000000000);

		}

	}


	function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
		try {
			decimalCount = Math.abs(decimalCount);
			decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

			const negativeSign = amount < 0 ? "-" : "";

			let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
			let j = (i.length > 3) ? i.length % 3 : 0;

			return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
		} catch (e) {
			console.log(e)
		}
	}


	function modal_sum_total_kwt(){
		
		var input_kwt = document.getElementsByName("mdl_cek_kwt");
		var total = 0;

	//    	
	for (var i = 0; i < input_kwt.length; i++) {
		if (input_kwt[i].checked) {				
			total += parseFloat(input_kwt[i].value);

		}
		type: "POST";					
	}

	document.getElementsByName("val_kwt")[0].value = total;
	document.getElementsByName("val_kwt1")[0].value = formatMoney(total);

}

function add_data_kwitansi() { 

	let no_kwt   = $('[name="kwt_number"]').val();
	let ttl          = $('[name="total"]').val();
	if (ttl == "") {
		alert("Please Add Data Invoice!");
		$("#total").focus();	
		return false;
	} 
	
	$no_kwt = $('[name="kwt_number"]').val()	

	//
	$('[name="kwt_no"]').val($no_kwt);


	$('#modal-simpan-kwt').modal('show');	

}

function duplicate_data_kwt(){ 
	
	//Tambah Data Potongan Invoice
	var total       = $('[name="val_kwt"]').val();

	var pch=total.split(".");

	var hsldec="";

	if(pch.length>1){

		for(i=0;i<pch.length;i++){

			if(i==pch.length-1){

				hsldec += terbilang(pch[i]);

			}else{

				hsldec += terbilang(pch[i]) + " koma ";

			}

		}

	}else{

		hsldec=terbilang(total);

	}

	$("#out").html(hsldec);

	$('[name="total"]').val(total)
	$('[name="total1"]').val(formatMoney(total));
	$('[name="terbilang"]').val(hsldec + 'Rupiah');


	//Hapus Temporary Table Detail SJ
	//Simpan Table SJ Temp
	delete_kwt_detail_temporary();	
	simpan_kwt_detail_temporary();	

}

function delete_kwt_detail_temporary() { 

	$.ajax({						
		url: "delete_kwt_detail_temporary/",
		type: "GET",				
		dataType: "JSON",
		success: function (data) {
			
			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Delete Table Temporary'			     
			} else {
				msg = 'Error Delete Table Temporary'				
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Delete Table Temporary' + jqXHR.text			
		}
	});
	
}

function simpan_kwt_detail_temporary() {
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		

			$("#table-inv-kwt input[name='mdl_cek_kwt']:checked").each(function () {
				var rows = $(this).closest("tr")[0];

				// $(this).closest('tr').find("input[name='mdl_disc']").each(function() {				
				// var mdl_disc = this.value	
				
				// $(this).closest('tr').find("input[name='cek_tgl']").each(function() {				
				// 	var tgl_sj = this.value	

				data.push({			
					"no_invoice": rows.cells[0].innerHTML,				
					"invoice_date": rows.cells[1].innerHTML,
					"customer": rows.cells[2].innerHTML,	
					"shipp": rows.cells[3].innerHTML,
					"doc_type": rows.cells[4].innerHTML,
					"doc_number": rows.cells[5].innerHTML,
					"type": rows.cells[6].innerHTML,
					"amount": rows.cells[7].innerHTML,			
				})	

			  // });

		   //  });

		});

			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_kwt_detail_temporary/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}

					//Load Data SJ Temporary
					load_kwt_detail_temporary();                   		
					$('#modal-add-so').modal('hide');

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});
}


function load_kwt_detail_temporary() { 	

	$('#table-inv-kwt tbody tr').remove();
	$.ajax({		
		url: "load_kwt_detail_temporary/",							
		type: "GET",
		dataType: "JSON",
		success: function (response) {
			var trHTML = '';
			$.each(response, function (i, item) {
				trHTML += '<tr>';
				trHTML += '<td>' + item.no_invoice + "</td>";
				trHTML += '<td>' + item.invoice_date + "</td>";
				trHTML += '<td>' + item.customer + "</td>";	
				trHTML += '<td>' + item.shipp + "</td>";	
				trHTML += '<td>' + item.doc_type + "</td>";
				trHTML += '<td>' + item.doc_number + "</td>";
				trHTML += '<td>' + item.type + "</td>";	
				trHTML += '<td><input type="text" value="'+ item.tipestyle +'" class="form-control" id="stylein" name="stylein" style="width: 100%; text-align: center;"  autocomplete="off"></td>';
						// trHTML += '<td>' + item.styleno +' '+ item.color + "</td>";		
						// trHTML += '<td><input type="checkbox" name="cek_pilih_sj" id="cek_pilih_sj" class="flat" checked></td>';												
						trHTML += '</tr>';
					});
			$('#tabelkwt').append(trHTML);						
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});  	  

}

function save_kwitansi() {
	
	simpan_kwt_detail();
	update_status_kwt_inv();
	update_status_kwt_inv2();
	simpankwitansi();	
	//	
	$('#modal-simpan-kwt').modal('hide');
	
}

function simpan_kwt_detail() 
{ 	
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		

			var table = document.getElementById("tabelkwt");
			for (var i = 1; i < (table.rows.length); i++) {

				var style = document.getElementById("tabelkwt").rows[i].cells[7].children[0].value;
				
				data.push({		
					"no_kwitansi": $('#kwt_number').val(),
					"no_invoice": table.rows[i].cells[0].innerHTML,
					"invoice_date": table.rows[i].cells[1].innerHTML,
					"customer": table.rows[i].cells[2].innerHTML,	
					"shipp": table.rows[i].cells[3].innerHTML,					
					"doc_type":table.rows[i].cells[4].innerHTML,
					"doc_number": table.rows[i].cells[5].innerHTML,
					"type": table.rows[i].cells[6].innerHTML,
					"style": style,								

				})		
			}

			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_kwt_detail/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});  

}

function update_status_kwt_inv() { 

	var table = document.getElementById("tabelkwt");
	for (var i = 1; i < (table.rows.length); i++) {	
				//   
				var no_invoice = table.rows[i].cells[0].innerHTML
				var no_kwt = $('[name="kwt_number"]').val()
                //
                var formData = {
                	"no_invoice": no_invoice,
                	"no_kwt": no_kwt,			
                };
				//
				$.ajax({						
					url: "update_status_kwt_inv/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Bppb'
						} else {
							msg = 'Error Update Bppb'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Bppb' + jqXHR.text
					}
				});   	
				//					
			}				
		}

		function update_status_kwt_inv2() { 

			var table = document.getElementById("tabelkwt");
			for (var i = 1; i < (table.rows.length); i++) {	
				//   
				var no_invoice = table.rows[i].cells[0].innerHTML
				var no_kwt = $('[name="kwt_number"]').val()
                //
                var formData = {
                	"no_invoice": no_invoice,
                	"no_kwt": no_kwt,			
                };
				//
				$.ajax({						
					url: "update_status_kwt_inv2/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Bppb'
						} else {
							msg = 'Error Update Bppb'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Bppb' + jqXHR.text
					}
				});   	
				//					
			}				
		}

		function cari_kwitansi() { 

			$('#table-kwitansi tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_kwt = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_kwt = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_kwt   = "undefined";
			dt_sampai_kwt = "undefined";
		});

		var customer = $('#customer').val();	
		console.log(dt_sampai_kwt, dt_dari_kwt);

		

		$.ajax({		
			url: "cari_kwitansi/" + dt_dari_kwt + "/" + dt_sampai_kwt + "/" + customer + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 					
					if(item.status == 'POST' ){				
						trHTML += '<tr>';					
						trHTML += '<td onclick="view_kwt(\'' + item.id + '\',\'' + item.no_kwt + '\')">' + item.no_kwt + "</td>";
						trHTML += '<td>' + item.tgl_kwt + "</td>";	
						trHTML += '<td>' + item.supp + "</td>";
						trHTML += '<td>' + item.curr +' '+ item.total + "</td>";
						trHTML += '<td>' + item.bilang + "</td>";
						trHTML += '<td>' + item.status + "</td>";	
						trHTML += '<td><button type="button" class="btn btn-sm btn-primary swalDefaultError" href="javascript:void(0)" onclick="getType3(\'' + item.supp + '\',\'' + item.no_kwt + '\',\'' + item.total + '\',\'' + item.bilang + '\')">Update</button> ' + '' 
						+ ' <button id="print_inv" name="print_inv" type="button" class="btn btn-primary btn-sm" onclick="print_kwitansi(' + item.id + ')"><i class="fa fa-print"></i> Print</button> ' + ''
						+ ' <button type="button" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="cancel_kwt(\'' + item.no_kwt + '\', \'' + item.status + '\')">Cancel</button></td> </td>';

						trHTML += '</tr>';
					}else{
						trHTML += '<tr>';					
						trHTML += '<td onclick="view_kwt(\'' + item.id + '\',\'' + item.no_kwt + '\')">' + item.no_kwt + "</td>";
						trHTML += '<td>' + item.tgl_kwt + "</td>";	
						trHTML += '<td>' + item.supp + "</td>";
						trHTML += '<td>' + item.curr +' '+ item.total + "</td>";
						trHTML += '<td>' + item.bilang + "</td>";
						trHTML += '<td>' + item.status + "</td>";
						trHTML += '<td style="text-align: center;"><i><b>Canceled</b></i></td>';

						trHTML += '</tr>';
					}
				});

				$('#table-kwitansi').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	

	}

	function cancel_kwt(no_kwt, status){ 

		let status_inv  = status;		

		$('#txt_cancel_book').val(no_kwt);
		$('#id_kwitansi').val(no_kwt);
	// $('#id_bppb').val(shipp_number);
	$('#modal-cancel-kwt').modal('show');  

}

function print_kwitansi(id) {

	//var id_bank = $('#bank').val(); 	
	//window.open("http://localhost/ar-nag/arnag/report_invoice/" + id + "/" );  
	//window.open("http://localhost/ar-nag/arnag/report_invoice2/" + id + "/" ); 
	//window.open("http://10.10.2.179/ar-nag/arnag/report_invoice3/" + id + "/" + id_bank + "/" );  	
	window.open(".../../report_kwitansi/" + id + "/" );  	

}

function getType3(supp, no_kwt, total, bilang) {
	

	$('.form-group').removeClass('has-error'); // clear error class
	$('.help-block').empty(); // clear error string
	//Ajax Load data from ajax
	$.ajax({
		url: "getType3/" + no_kwt,
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			
			$('[name="no_kwt"]').val(no_kwt);
			$('[name="amount"]').val(total);
			$('[name="terbilang"]').val(bilang);
			$('#update-kwt').modal('show'); // show bootstrap modal when complete loaded
			//
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

function view_kwt(id, kwt){ 
	
	var no_kwt  = id;

	$('#txt_view').val(kwt);
	// $('#id_kwitansi').val(no_kwt);
	// $('#id_bppb').val(shipp_number);
	cari_view_kwitansi(no_kwt);
	// $('#modal-view-kwt').modal('show');  

}

function cari_view_kwitansi(no_kwt) { 

	$('#table-view-kwt tbody tr').remove();	
		//Date range picker		

		$.ajax({		
			url: "cari_view_kwitansi/" + no_kwt + "/" ,					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 								
					trHTML += '<tr>';					
					trHTML += '<td>' + item.no_invoice + "</td>";
					trHTML += '<td>' + item.invoice_date + "</td>";	
					trHTML += '<td>' + item.customer + "</td>";
					trHTML += '<td>' + item.shipp + "</td>";
					trHTML += '<td>' + item.doc_type + "</td>";
					trHTML += '<td>' + item.doc_number + "</td>";
					trHTML += '<td>' + item.type + "</td>";	
					trHTML += '<td>' + item.style + "</td>";
					trHTML += '<td><button type="button" class="btn btn-sm btn-primary swalDefaultError" href="javascript:void(0)" onclick="getType4(\'' + item.id_detail + '\',\'' + item.no_invoice + '\',\'' + item.style + '\')">Update</button> ';
					trHTML += '</tr>';
				// trHTML += '<td>' + item.curr +' '+ item.total + "</td>";

			});


				$('#table-view-kwt').append(trHTML);	
				$('#modal-view-kwt').modal('show');			

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	

	}

//ubah september
function get_alamat(kode){
// alert(kode);
$('.form-group').removeClass('has-error'); // clear error class
	$('.help-block').empty(); // clear error string
	//Ajax Load data from ajax
	$.ajax({
		url: "get_alamat/" + kode,
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			
			$('[name="alamat"]').val(data.alamat);
			$('[name="nama_supp"]').val(data.Supplier);
			// $('[name="terbilang"]').val(bilang);
			// $('#update-kwt').modal('show'); // show bootstrap modal when complete loaded
			//
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}




//ubah september
function ubahnomor_alo(kode){
// alert(kode);
$('.form-group').removeClass('has-error'); // clear error class
	$('.help-block').empty(); // clear error string
	//Ajax Load data from ajax
	// alert(kode);
	$.ajax({
		url: "ubahnomor_alo/" + kode,
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			
			$('[name="alk_number"]').val(data.nomor);
			// $('[name="amount"]').val(total);
			// $('[name="terbilang"]').val(bilang);
			// $('#update-kwt').modal('show'); // show bootstrap modal when complete loaded
			//
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

//ubah september
function ubahnomor_kwt(kode){
// alert(kode);
$('.form-group').removeClass('has-error'); // clear error class
	$('.help-block').empty(); // clear error string
	//Ajax Load data from ajax
	// alert(kode);
	$.ajax({
		url: "ubahnomor_kwt/" + kode,
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			
			$('[name="kwt_number"]').val(data.nomor);
			// $('[name="amount"]').val(total);
			// $('[name="terbilang"]').val(bilang);
			// $('#update-kwt').modal('show'); // show bootstrap modal when complete loaded
			//
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}


function getType4(id, no_inv, style) {
	

	$('.form-group').removeClass('has-error'); // clear error class
	$('.help-block').empty(); // clear error string
	//Ajax Load data from ajax
	$.ajax({
		url: "getType3/" + id,
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			
			$('[name="id"]').val(id);
			$('[name="no_inv"]').val(no_inv);
			$('[name="style"]').val(style);
			$('#update-inv-style').modal('show'); // show bootstrap modal when complete loaded
			//
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}


async function update_style2(){
	await update_style();
	console.log("hasil");
	update_style3();
}

function update_style3() {
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg = ''
			var no_kwt  	= $('[name="txt_view"]').val();

			$('#update-inv-style').modal('hide');
			cari_view_kwitansi(no_kwt);

			resolve({
				msg: msg,
			});

		}, 2000);
	});
	
}


function update_style() { 

	// return new Promise(resolve => {		
	// 	setTimeout(() => {
	// 		var msg

	var id  	= $('[name="id"]').val()
	var no_inv  = $('[name="no_inv"]').val()
	var style  	= $('[name="style"]').val()
	//
	var formData = {
		"id"	: id,
		"no_inv": no_inv,
		"style"	: style,							
	};
	
	$.ajax({						
		url: "update_style/",		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {		

			if (data.status) //if success close modal and reload ajax table
			{
				msg = ''
			} else {
				msg = ''
			}

			$('#update-inv-style').modal('hide');
			// cari_view_kwitansi();                   		
		},
		error: function (jqXHR, textStatus, errorThrown) {
			//alert('Error Update Book Invoice ' + jqXHR.text)
		}
	});

	// resolve({
	// 			msg: msg,
	// 		});

	// 	}, 2000);
	// });

}

function modal_input_price(){ 
	var table = document.getElementById("table-sj");
	var tota = 0;
	var totall = 0;
	for (var i = 1; i < (table.rows.length); i++) {

		var qty = document.getElementById("table-sj").rows[i].cells[13].children[0].value;
		var price = document.getElementById("table-sj").rows[i].cells[14].children[0].value;
		var dis = $('[name="diskon"]').val();
		tota += parseFloat(qty * price);
		totall = parseFloat(tota - dis);

		document.getElementById("table-sj").rows[i].cells[16].children[0].value = (qty * price).toFixed(2);
		document.getElementsByName("total_h")[0].value = tota.toFixed(2);
		document.getElementsByName("amount")[0].value = tota.toFixed(2);
		document.getElementsByName("amount_h")[0].value =formatMoney(tota.toFixed(2));
		document.getElementsByName("twot")[0].value = totall.toFixed(2);
		document.getElementsByName("grandtotal")[0].value = totall.toFixed(2);

	}
}

function modal_input_disk(){ 
	var table = document.getElementById("table-sj");
	var tota = $('[name="total_h"]').val(); 
	var diskon = 0;
	var tota_l = 0;
	for (var i = 1; i < (table.rows.length); i++) {

		var disk = document.getElementById("table-sj").rows[i].cells[15].children[0].value;
		var total = document.getElementById("table-sj").rows[i].cells[16].children[0].value;
		diskon += parseFloat(disk * total / 100);
		tota_l = tota - diskon;


		document.getElementsByName("diskon")[0].value = diskon.toFixed(2);
		document.getElementsByName("twot")[0].value = tota_l.toFixed(2);
		document.getElementsByName("grandtotal")[0].value = tota_l.toFixed(2);
		document.getElementsByName("amount")[0].value = tota_l.toFixed(2);
		document.getElementsByName("amount_h")[0].value =formatMoney(tota_l.toFixed(2));

	}
}

function modal_input_disk(){ 
	var table = document.getElementById("table-sj");
	var tota = $('[name="total_h"]').val(); 
	var diskon = 0;
	var tota_l = 0;
	for (var i = 1; i < (table.rows.length); i++) {

		var disk = document.getElementById("table-sj").rows[i].cells[15].children[0].value;
		var total = document.getElementById("table-sj").rows[i].cells[16].children[0].value;
		diskon += parseFloat(disk * total / 100);
		tota_l = tota - diskon;


		document.getElementsByName("diskon")[0].value = diskon.toFixed(2);
		document.getElementsByName("twot")[0].value = tota_l.toFixed(2);
		document.getElementsByName("grandtotal")[0].value = tota_l.toFixed(2);
		document.getElementsByName("amount")[0].value = tota_l.toFixed(2);
		document.getElementsByName("amount_h")[0].value =formatMoney(tota_l.toFixed(2));

	}
}

function modal_inputdp(){ 
	var total = $('[name="total_h"]').val();
	var discount = $('[name="diskon"]').val();
	var dp = $('[name="dp"]').val(); 
	document.getElementsByName("twot")[0].value = (total - discount - dp).toFixed(2);
	document.getElementsByName("grandtotal")[0].value = (total - discount - dp).toFixed(2);
	document.getElementsByName("amount")[0].value = (total - discount - dp).toFixed(2);
	document.getElementsByName("amount_h")[0].value =formatMoney((total - discount - dp).toFixed(2));
}

function modal_inputretur() { 
	var total = $('[name="total_h"]').val();
	var discount = $('[name="diskon"]').val();
	var dp = $('[name="dp"]').val();  
	var retur = $('[name="return"]').val(); 
	document.getElementsByName("grandtotal")[0].value = (total- discount-dp-retur).toFixed(2);
	document.getElementsByName("twot")[0].value = (total- discount-dp-retur).toFixed(2);
	document.getElementsByName("amount")[0].value = (total- discount-dp-retur).toFixed(2);
	document.getElementsByName("amount_h")[0].value =formatMoney((total- discount-dp-retur).toFixed(2));
}

function modal_inputvat(){ 

	var vat = 0.12; 
    //
    if ($('[name="checkvat"]').is(':checked')) {			
    	var total = $('[name="total_h"]').val();
    	var discount = $('[name="diskon"]').val();
    	var dp = $('[name="dp"]').val();  
    	var retur = $('[name="return"]').val(); 	
    	var twot = (total- discount-dp-retur).toFixed(2) * vat;
    	document.getElementsByName("vat")[0].value = (twot).toFixed(2);
			//document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur-twot).toFixed(2);	
			document.getElementsByName("grandtotal")[0].value = (total- discount-dp-retur+twot).toFixed(2);	
			document.getElementsByName("amount")[0].value = (total- discount-dp-retur +twot).toFixed(2);
			document.getElementsByName("amount_h")[0].value =formatMoney((total- discount-dp-retur +twot).toFixed(2));
		} else { 		
			var total = $('[name="total_h"]').val();
			var discount = $('[name="diskon"]').val();
			var dp = $('[name="dp"]').val();  
			var retur = $('[name="return"]').val();
			document.getElementsByName("vat")[0].value = "0.00";
			document.getElementsByName("grandtotal")[0].value = (total- discount-dp-retur).toFixed(2);
			document.getElementsByName("amount")[0].value = (total- discount-dp-retur).toFixed(2);
			document.getElementsByName("amount_h")[0].value =formatMoney((total- discount-dp-retur).toFixed(2));
		}
	}

	function modal_inputvat_baru(){ 

		var vat = 0.11; 
    //
    if ($('[name="checkvat_baru"]').is(':checked')) {			
    	var total = $('[name="total_h"]').val();
    	var discount = $('[name="diskon"]').val();
    	var dp = $('[name="dp"]').val();  
    	var retur = $('[name="return"]').val(); 	
    	var twot = (total- discount-dp-retur).toFixed(2) * vat;
    	document.getElementsByName("vat")[0].value = (twot).toFixed(2);
			//document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur-twot).toFixed(2);	
			document.getElementsByName("grandtotal")[0].value = (total- discount-dp-retur+twot).toFixed(2);	
			document.getElementsByName("amount")[0].value = (total- discount-dp-retur +twot).toFixed(2);
			document.getElementsByName("amount_h")[0].value =formatMoney((total- discount-dp-retur +twot).toFixed(2));
		} else { 		
			var total = $('[name="total_h"]').val();
			var discount = $('[name="diskon"]').val();
			var dp = $('[name="dp"]').val();  
			var retur = $('[name="return"]').val();
			document.getElementsByName("vat")[0].value = "0.00";
			document.getElementsByName("grandtotal")[0].value = (total- discount-dp-retur).toFixed(2);
			document.getElementsByName("amount")[0].value = (total- discount-dp-retur).toFixed(2);
			document.getElementsByName("amount_h")[0].value =formatMoney((total- discount-dp-retur).toFixed(2));
		}
	}


	function add_data_invoice_nb() { 

		getcoa2();
		getcoa_credit2();
		getcoa_dp2();
		getcoa_pot2();
		getcoa_ppn2();
		getrate2();
		getbuyer();  

		$no_invoice = $('[name="inv_num"]').val()	
		$id_inv     = $('[name="id_num"]').val()	
	// $pph     = $('[name="pph"]').val()
	//
	$('[name="no_inv_post"]').val($no_invoice);
	$('[name="id_num_post"]').val($id_inv);
	// $('[name="pph_post"]').val($pph);

	// $('#modal-simpan-invoice_nb').modal('show')	

}

function resolveAfter3Seconds() {
	return new Promise(resolve => {
		setTimeout(() => {

			$('#modal-simpan-invoice_nb').modal('show');
		}, 3000);
	});
}

async function asyncCall2() {
	add_data_invoice_nb();
	const result = await resolveAfter3Seconds();
	console.log(result);

}

function getbuyer() 
{	


	let id_cust 	 = $('[name="cust"]').val();
	let type_so   	 = $('[name="type_so"]').val();
	var type 		 = type_so.toUpperCase();
	var kata1		 = "PENJUALAN";
	var kata2		 = "KE";
	var keter 		 = kata1 +' '+type +' '+kata2;


	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related';
	}else{
		cust_ctg = 'Third';
	}

	console.log(id_cust);

	$.ajax({
		url: "getbuyer/" + id_cust + "/",		
		type: "GET",
		dataType: "JSON",
		success: function (data) {

			$('[name="keterangan"]').val(data.Supplier);
			$('[name="buyer"]').val(keter +' '+ data.Supplier);
			// console.log( data.no_coa );

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

//ubah desember
function getcoa2() 
{	

	let no_invoice   = $('[name="inv_num"]').val();
	let type_so   	 = $('[name="type_so"]').val();
	let shipp 		 = $('[name="shipp"]').val();
	let type 		 = $('[name="type"]').val();
	let id_cust 	 = $('[name="cust"]').val();
	// let grade 	 	 = $('[name="grade"]').val();
	let inv_date 	 = $('[name="invoice_date"]').val();
	let vat 		 = $('[name="vat"]').val();
	let diskon 		 = $('[name="diskon"]').val();
	let curr		 = $('[name="inv_curr"]').val();

	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related';
	}else{
		cust_ctg = 'Third';
	}

	console.log(type_so + ' ' + shipp + ' ' + cust_ctg);

	$.ajax({
		url: "getcoa2/" + type_so + "/" + shipp + "/" + cust_ctg + "/",		
		type: "GET",
		dataType: "JSON",
		success: function (data) {

			$('[name="no_coa_deb2"]').val(data.no_coa);
			$('[name="nama_coa_deb2"]').val(data.nama_coa);
			console.log( data.no_coa );

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

//ubah desember
function getcoa_credit2() 
{	

	let no_invoice   = $('[name="inv_num"]').val();
	let type_so   	 = $('[name="type_so"]').val();
	let shipp 		 = $('[name="shipp"]').val();
	let type 		 = $('[name="type"]').val();
	let id_cust 	 = $('[name="cust"]').val();
	// let grade 	 	 = $('[name="grade"]').val();
	let inv_date 	 = $('[name="invoice_date"]').val();
	let vat 		 = $('[name="vat"]').val();
	let diskon 		 = $('[name="diskon"]').val();
	let curr		 = $('[name="inv_curr"]').val();

	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related';
	}else{
		cust_ctg = 'Third';
	}

	console.log(type_so + ' ' + shipp + ' ' + cust_ctg );

	$.ajax({
		url: "getcoa_credit2/" + type_so + "/" + shipp + "/" + cust_ctg + "/",		
		type: "GET",
		dataType: "JSON",
		success: function (data) {

			$('[name="no_coa_cre2"]').val(data.no_coa);
			$('[name="nama_coa_cre2"]').val(data.nama_coa);
			console.log( data.no_coa );

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

//ubah desember
function getcoa_dp2() 
{	

	let no_invoice   = $('[name="inv_num"]').val();
	let type_so   	 = $('[name="type_so"]').val();
	let shipp 		 = $('[name="shipp"]').val();
	let type 		 = $('[name="type"]').val();
	let id_cust 	 = $('[name="cust"]').val();
	// let grade 	 	 = $('[name="grade"]').val();
	let inv_date 	 = $('[name="invoice_date"]').val();
	let vat 		 = $('[name="vat"]').val();
	let diskon 		 = $('[name="diskon"]').val();
	let curr		 = $('[name="inv_curr"]').val();

	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related';
	}else{
		cust_ctg = 'Third';
	}

	console.log(type_so + ' ' + shipp + ' ' + cust_ctg);

	$.ajax({
		url: "getcoa_dp2/" + type_so + "/" + shipp + "/" + cust_ctg + "/",		
		type: "GET",
		dataType: "JSON",
		success: function (data) {

			$('[name="no_coa_dp2"]').val(data.no_coa);
			$('[name="nama_coa_dp2"]').val(data.nama_coa);
			console.log( data.no_coa );

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

//ubah desember
function getcoa_pot2() 
{	

	let no_invoice   = $('[name="inv_num"]').val();
	let type_so   	 = $('[name="type_so"]').val();
	let shipp 		 = $('[name="shipp"]').val();
	let type 		 = $('[name="type"]').val();
	let id_cust 	 = $('[name="cust"]').val();
	// let grade 	 	 = $('[name="grade"]').val();
	let inv_date 	 = $('[name="invoice_date"]').val();
	let vat 		 = $('[name="vat"]').val();
	let diskon 		 = $('[name="diskon"]').val();
	let curr		 = $('[name="inv_curr"]').val();

	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related';
	}else{
		cust_ctg = 'Third';
	}

	console.log(type_so + ' ' + shipp + ' ' + cust_ctg);

	$.ajax({
		url: "getcoa_pot2/" + type_so + "/" + shipp + "/" + cust_ctg + "/",		
		type: "GET",
		dataType: "JSON",
		success: function (data) {

			$('[name="no_coa_pot2"]').val(data.no_coa);
			$('[name="nama_coa_pot2"]').val(data.nama_coa);
			console.log( data.no_coa );

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

//ubah desember
function getcoa_ppn2() 
{	

	let no_invoice   = $('[name="inv_num"]').val();
	let type_so   	 = $('[name="type_so"]').val();
	let shipp 		 = $('[name="shipp"]').val();
	let type 		 = $('[name="type"]').val();
	let id_cust 	 = $('[name="cust"]').val();
	// let grade 	 	 = $('[name="grade"]').val();
	let inv_date 	 = $('[name="invoice_date"]').val();
	let vat 		 = $('[name="vat"]').val();
	let diskon 		 = $('[name="diskon"]').val();
	let curr		 = $('[name="inv_curr"]').val();

	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related';
	}else{
		cust_ctg = 'Third';
	}

	console.log(type_so + ' ' + shipp + ' ' + cust_ctg);

	$.ajax({
		url: "getcoa_ppn2/" + type_so + "/" + shipp + "/" + cust_ctg + "/",		
		type: "GET",
		dataType: "JSON",
		success: function (data) {

			$('[name="no_coa_ppn2"]').val(data.no_coa);
			$('[name="nama_coa_ppn2"]').val(data.nama_coa);
			console.log( data.no_coa );

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

//ubah desember
function getrate2() 
{	

	let inv_date 	 = $('[name="invoice_date"]').val();

	console.log(inv_date);

	$.ajax({
		url: "getrate/" + inv_date + "/",		
		type: "GET",
		dataType: "JSON",
		success: function (data) {

			$('[name="inv_rate"]').val(data.rate);
			console.log( data.rate );

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}


//ubah desember
function save_invoice_nb() {

	let vat 		 = $('[name="vat"]').val();
	let diskon 		 = $('[name="diskon"]').val();
	let dp		 	 = $('[name="dp"]').val();
	
	simpan_invoice_nb();
	at_debit_inv2();
	if (diskon >= 1) {		
		at_pot_inv2();
	}
	if (dp >= 1) {		
		at_dp_inv2();
	}
	at_credit_inv2();
	if (vat >= 1) {		
		at_ppn_inv2();
	}
	simpan_invoice_nb_detail();
	simpan_invoice_nb_pot();	
	//	
	$('#modal-simpan-invoice_nb').modal('hide');
	
}

//ubah desember
function ganticurr_nb(curr){
	var curren = curr;
	document.getElementById("inv_curr").value = curren;

}

//ubah desember
function at_debit_inv2() { 
	

	var data = [];
	var cust_ctg = '';
	var rate = 0;
	var total_idr = 0;

	var id_cust 	 	= $('[name="cust"]').val();
	var inv_rate 	 	= $('[name="inv_rate"]').val();
	var inv_curr 	 	= $('[name="inv_curr"]').val();
	var total 	 		= $('[name="grandtotal"]').val();
	var buyer 	 		= $('[name="buyer"]').val();
	var keterangan 	 	= $('[name="keterangan"]').val();
	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related Party';
	}else{
		cust_ctg = 'Third Party';
	}

	if (inv_curr == 'IDR') {
		rate = 1;
		total_idr = total * rate;
	}else{
		rate = inv_rate;
		total_idr = total * rate;
	}

	data.push({		
		"no_journal": $('#inv_num').val(),
		"tgl_journal": $('#invoice_date').val(),
		"type_journal": 'Invoice Manual',
		"no_coa": $('#no_coa_deb2').val(),
		"nama_coa": $('#nama_coa_deb2').val(),		
		"no_costcenter":'-',
		"nama_costcenter": '-',
		"reff_doc": '-',
		"reff_date": '',
		"buyer": buyer,
		"no_ws": '',
		"curr": $('#inv_curr').val(),
		"rate": rate,
		"debit": $('#grandtotal').val(),
		"credit": '0',
		"debit_idr":total_idr,			
		"credit_idr":'0',
		"status": 'POST',
		"keterangan": keterangan,
		"create_by": '',
		"create_date": '',
		"approve_by":'',	
		"approve_date": '',					
		"cancel_by":'',
		"cancel_date": '', 									

	})		

	var formData = {
		'data_table': data
	}

	console.log(formData);
	
	$.ajax({						
		url: "at_debit_inv/",		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {		

			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Update Invoice Header'
			} else {
				msg = 'Error Update Invoice Header'
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Update Invoice Header' + jqXHR.text
		}
	});

}

//ubah desember
function at_pot_inv2() { 
	

	var data = [];
	var cust_ctg = '';
	var rate = 0;
	var total_idr = 0;

	var id_cust 	 	= $('[name="cust"]').val();
	var inv_rate 	 	= $('[name="inv_rate"]').val();
	var inv_curr 	 	= $('[name="inv_curr"]').val();
	var total 	 	= $('[name="diskon"]').val();
	var buyer 	 		= $('[name="buyer"]').val();
	var keterangan 	 	= $('[name="keterangan"]').val();
	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related Party';
	}else{
		cust_ctg = 'Third Party';
	}

	if (inv_curr == 'IDR') {
		rate = 1;
		total_idr = total * rate;
	}else{
		rate = inv_rate;
		total_idr = total * rate;
	}

	data.push({		
		"no_journal": $('#inv_num').val(),
		"tgl_journal": $('#invoice_date').val(),
		"type_journal": 'Invoice Manual',
		"no_coa": $('#no_coa_pot2').val(),
		"nama_coa": $('#nama_coa_pot2').val(),		
		"no_costcenter":'-',
		"nama_costcenter": '-',
		"reff_doc": '-',
		"reff_date": '',
		"buyer": buyer,
		"no_ws": '',
		"curr": $('#inv_curr').val(),
		"rate": rate,
		"debit": $('#diskon').val(),
		"credit": '0',
		"debit_idr":total_idr,			
		"credit_idr":'0',
		"status": 'POST',
		"keterangan": keterangan,
		"create_by": '',
		"create_date": '',
		"approve_by":'',	
		"approve_date": '',					
		"cancel_by":'',
		"cancel_date": '', 									

	})		

	var formData = {
		'data_table': data
	}

	console.log(formData);
	
	$.ajax({						
		url: "at_pot_inv/",		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {		

			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Update Invoice Header'
			} else {
				msg = 'Error Update Invoice Header'
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Update Invoice Header' + jqXHR.text
		}
	});

}


//ubah desember
function at_dp_inv2() { 
	

	var data = [];
	var cust_ctg = '';
	var rate = 0;
	var total_idr = 0;

	var id_cust 	 	= $('[name="cust"]').val();
	var inv_rate 	 	= $('[name="inv_rate"]').val();
	var inv_curr 	 	= $('[name="inv_curr"]').val();
	var total 	 	= $('[name="dp"]').val();
	var buyer 	 		= $('[name="buyer"]').val();
	var keterangan 	 	= $('[name="keterangan"]').val();
	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related Party';
	}else{
		cust_ctg = 'Third Party';
	}

	if (inv_curr == 'IDR') {
		rate = 1;
		total_idr = total * rate;
	}else{
		rate = inv_rate;
		total_idr = total * rate;
	}

	data.push({		
		"no_journal": $('#inv_num').val(),
		"tgl_journal": $('#invoice_date').val(),
		"type_journal": 'Invoice Manual',
		"no_coa": $('#no_coa_dp2').val(),
		"nama_coa": $('#nama_coa_dp2').val(),		
		"no_costcenter":'-',
		"nama_costcenter": '-',
		"reff_doc": '-',
		"reff_date": '',
		"buyer": buyer,
		"no_ws": '',
		"curr": $('#inv_curr').val(),
		"rate": rate,
		"debit": $('#dp').val(),
		"credit": '0',
		"debit_idr":total_idr,			
		"credit_idr":'0',
		"status": 'POST',
		"keterangan": keterangan,
		"create_by": '',
		"create_date": '',
		"approve_by":'',	
		"approve_date": '',					
		"cancel_by":'',
		"cancel_date": '', 									

	})		

	var formData = {
		'data_table': data
	}

	console.log(formData);
	
	$.ajax({						
		url: "at_dp_inv/",		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {		

			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Update Invoice Header'
			} else {
				msg = 'Error Update Invoice Header'
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Update Invoice Header' + jqXHR.text
		}
	});

}

//ubah desember
function at_credit_inv2() { 
	

	var data = [];
	var cust_ctg = '';
	var rate = 0;
	var total_idr = 0;

	var id_cust 	 	= $('[name="cust"]').val();
	var inv_rate 	 	= $('[name="inv_rate"]').val();
	var inv_curr 	 	= $('[name="inv_curr"]').val();
	var total 	 	= $('[name="total_h"]').val();
	var buyer 	 		= $('[name="buyer"]').val();
	var keterangan 	 	= $('[name="keterangan"]').val();
	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related Party';
	}else{
		cust_ctg = 'Third Party';
	}

	if (inv_curr == 'IDR') {
		rate = 1;
		total_idr = total * rate;
	}else{
		rate = inv_rate;
		total_idr = total * rate;
	}

	data.push({		
		"no_journal": $('#inv_num').val(),
		"tgl_journal": $('#invoice_date').val(),
		"type_journal": 'Invoice Manual',
		"no_coa": $('#no_coa_cre2').val(),
		"nama_coa": $('#nama_coa_cre2').val(),		
		"no_costcenter":'-',
		"nama_costcenter": '-',
		"reff_doc": '-',
		"reff_date": '',
		"buyer": buyer,
		"no_ws": '',
		"curr": $('#inv_curr').val(),
		"rate": rate,
		"debit": '0',
		"credit": $('#total_h').val(),
		"debit_idr":'0',			
		"credit_idr":total_idr,
		"status": 'POST',
		"keterangan": keterangan,
		"create_by": '',
		"create_date": '',
		"approve_by":'',	
		"approve_date": '',					
		"cancel_by":'',
		"cancel_date": '', 									

	})		

	var formData = {
		'data_table': data
	}

	console.log(formData);
	
	$.ajax({						
		url: "at_credit_inv/" ,		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {		

			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Update Invoice Header'
			} else {
				msg = 'Error Update Invoice Header'
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Update Invoice Header' + jqXHR.text
		}
	});

}


//ubah desember
function at_ppn_inv2() { 
	

	var data = [];
	var cust_ctg = '';
	var rate = 0;
	var total_idr = 0;

	var id_cust 	 	= $('[name="cust"]').val();
	var inv_rate 	 	= $('[name="inv_rate"]').val();
	var inv_curr 	 	= $('[name="inv_curr"]').val();
	var total 	 	= $('[name="vat"]').val();
	var buyer 	 		= $('[name="buyer"]').val();
	var keterangan 	 	= $('[name="keterangan"]').val();
	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related Party';
	}else{
		cust_ctg = 'Third Party';
	}

	if (inv_curr == 'IDR') {
		rate = 1;
		total_idr = total * rate;
	}else{
		rate = inv_rate;
		total_idr = total * rate;
	}

	data.push({		
		"no_journal": $('#inv_num').val(),
		"tgl_journal": $('#invoice_date').val(),
		"type_journal": 'Invoice Manual',
		"no_coa": $('#no_coa_ppn2').val(),
		"nama_coa": $('#nama_coa_ppn2').val(),		
		"no_costcenter":'-',
		"nama_costcenter": '-',
		"reff_doc": '-',
		"reff_date": '',
		"buyer": buyer,
		"no_ws": '',
		"curr": $('#inv_curr').val(),
		"rate": rate,
		"debit": '0',
		"credit": $('#vat').val(),
		"debit_idr":'0',			
		"credit_idr":total_idr,
		"status": 'POST',
		"keterangan": keterangan,
		"create_by": '',
		"create_date": '',
		"approve_by":'',	
		"approve_date": '',					
		"cancel_by":'',
		"cancel_date": '', 									

	})		

	var formData = {
		'data_table': data
	}

	console.log(formData);
	
	$.ajax({						
		url: "at_ppn_inv/" ,		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {		

			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Update Invoice Header'
			} else {
				msg = 'Error Update Invoice Header'
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Update Invoice Header' + jqXHR.text
		}
	});

}


//ubah desember
function simpan_invoice_nb() { 

	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		
            //
            var no_inv 			= $('#inv_num').val();
            var inv_date        = $('#invoice_date').val();
            var customer        = $('#cust').val();
            var top_type        = $('#top').val();
            var top           	= $('#top_time').val();
            var shipp           = $('#shipp').val();
            var doc_type        = $('#doc_type').val();
            var doc_number     	= $('#doc_number').val();
            var type           	= $('#type').val();
            var amount          = $('#amount').val();
            var bank            = $('#id_bank').val();
            var pph     		= $('#pph').val();
            var type_so     	= $('#type_so').val();
            var status      	= "POST";
            var create_date		= $('#date_inv').val();
            var no_coa     		= $('#no_coa_deb2').val();
            var nama_coa     	= $('#nama_coa_deb2').val();
			//			
			data.push({		
				"no_inv": no_inv,
				"inv_date": inv_date,
				"customer": customer,	
				"top_type": top_type,					
				"top": top,
				"shipp": shipp,
				"doc_type": doc_type,	
				"doc_number": doc_number,	
				"type": type,
				"amount": amount,
				"bank": bank,
				"pph": pph,
				"type_so" : type_so,
				"status": status,
				"create_date": create_date,
				"no_coa": no_coa,
				"nama_coa": nama_coa,															
			})	
			
			var fdata = {
				'data_table': data,
				"no_inv": no_inv
			}
			$.ajax({				
				url: "simpan_invoice_nb/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					// Delete Table Invoice Detail Temporary
					// delete_invoice_detail_temporary();
					// // Print Preview Invoice
					// let id_invoice = $('[name="id_num"]').val();
					// print_invoice_nb(id_invoice);
                    // Reload Page
                    window.location.href = window.location.href;

                },
                error: function (jqXHR, textStatus, errorThrown) {
                	msg = 'Error Input Detail' + jqXHR.text
                }
            });
			resolve({
				msg: msg,
			});

		}, 100);
	});

}


function cari_invoice_nb() { 

	$('#table-invoice-nb tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_inv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_inv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_inv   = "undefined";
			dt_sampai_inv = "undefined";
		});

		var id_customer = $('#customer').val();	

		

		$.ajax({		
			url: "cari_invoice_nb/" + dt_dari_inv + "/" + dt_sampai_inv + "/" + id_customer + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 					
					if(item.status == 'POST' ){				
						trHTML += '<tr>';					
						trHTML += '<td>' + item.no_invoice + "</td>";
						trHTML += '<td>' + item.customer + "</td>";	
						trHTML += '<td>' + item.shipp + "</td>";
						trHTML += '<td>' + item.doc_type + "</td>";
						trHTML += '<td>' + item.doc_number + "</td>";
						trHTML += '<td>' + item.inv_date + "</td>";
						trHTML += '<td>' + item.tgl_inv + "</td>";	
						trHTML += '<td>' + item.type + "</td>";	
						trHTML += '<td>' + item.status + "</td>";
						trHTML += '<td align="right">' + item.amount + "</td>";
						trHTML += '<td><button id="inv_detail" name="inv_detail" type="button" class="btn btn-info btn-sm" onclick="cari_inv_detail_nb(' + item.id + ')" >Cek Detail</button> ' + '' 
						+ ' <button id="print_inv" name="print_inv" type="button" class="btn btn-primary btn-sm" onclick="print_invoice_nb(' + item.id + ')"><i class="fa fa-print"></i> Print</button> ' + ''
						+ '<button id="export_to_excel_invoice_nb" name="export_to_excel_invoice_nb" type="button" class="btn btn-primary btn-sm" onclick="export_to_excel_invoice_nb(' + item.id + ')"><i class="fa fa-download"></i> Export To Xls</button> ' + ''				
						+ ' <button type="button" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="cancel_invoice_nb(\'' + item.id + '\',\'' + item.no_invoice + '\',\'' + item.status + '\')">Cancel</button></td> </td>';

						trHTML += '</tr>';
					}else{
						trHTML += '<tr>';					
						trHTML += '<td>' + item.no_invoice + "</td>";
						trHTML += '<td>' + item.customer + "</td>";	
						trHTML += '<td>' + item.shipp + "</td>";
						trHTML += '<td>' + item.doc_type + "</td>";
						trHTML += '<td>' + item.doc_number + "</td>";
						trHTML += '<td>' + item.inv_date + "</td>";
						trHTML += '<td>' + item.tgl_inv + "</td>";	
						trHTML += '<td>' + item.type + "</td>";	
						trHTML += '<td>' + item.status + "</td>";
						trHTML += '<td align="right">' + item.amount + "</td>";
						trHTML += '<td><button id="inv_detail" name="inv_detail" type="button" class="btn btn-info btn-sm" onclick="cari_inv_detail_nb(' + item.id + ')" >Cek Detail</button> ' + '' 
						+ ' <button id="print_inv" name="print_inv" type="button" class="btn btn-primary btn-sm" onclick="print_invoice_nb(' + item.id + ')"><i class="fa fa-print"></i> Print</button> ' + ''
						+ '<button id="export_to_excel_invoice_nb" name="export_to_excel_invoice_nb" type="button" class="btn btn-primary btn-sm" onclick="export_to_excel_invoice_nb(' + item.id + ')"><i class="fa fa-download"></i> Export To Xls</button> </td>';

						trHTML += '</tr>';
					}
				});

				$('#table-invoice-nb').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	

	}

	function cari_inv_detail_nb(id_inv) { 

		$('#table-inv-detail-nb tbody tr').remove();		
		$('#modal-inv-detail-nb').modal('show');
		$.ajax({		
			url: "cari_inv_detail_nb/" + id_inv + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 			
					trHTML += '<tr>';										
					trHTML += '<td>' + item.so_number + "</td>";
					trHTML += '<td>' + item.bppb_Number + "</td>";	
					trHTML += '<td>' + item.shipp_number + "</td>";
					trHTML += '<td>' + item.ws + "</td>";
					trHTML += '<td>' + item.styleno + "</td>";
					trHTML += '<td>' + item.product_group + "</td>";
					trHTML += '<td>' + item.product_item + "</td>";
					trHTML += '<td>' + item.color + "</td>";
					trHTML += '<td>' + item.size + "</td>";
					trHTML += '<td>' + item.curr + "</td>";
					trHTML += '<td>' + item.uom + "</td>";
					trHTML += '<td>' + item.qty + "</td>";
					trHTML += '<td>' + item.unit_price + "</td>";	
					trHTML += '<td>' + item.disc + "</td>";				
					trHTML += '<td align="right">' + item.total_price + "</td>";				
					trHTML += '</tr>';
                //
                $('#inv_number_list-nb').val(item.no_invoice)
				//				
			});

				$('#table-inv-detail-nb').append(trHTML);

				cari_inv_nb_pot(id_inv);						

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	

	}


	function export_to_excel_invoice_nb($id) { 			
		window.open(".../../export_excel_invoice_nb/" + $id + "/");  
	}

	function cancel_invoice_nb(id, no_invoice, status){ 

		let status_inv  = status;		

		$('#txt_cancel_book').val(no_invoice);
		$('#id_book_inv').val(no_invoice);
		$('#modal-cancel-inv-nb').modal('show');  

	}

	function export_list_invoice_nb() { 		
		var id_customer = $('#customer').val();	
		window.open(".../../export_excel_list_invoice_nb/" + dt_dari_inv  + "/" + dt_sampai_inv  + "/" + "/" + id_customer + "/" ); 
	}


	function simpan_invoice_nb_pot() { 

		return new Promise(resolve => {		
			setTimeout(() => {
				var msg
				var data = [];		
            //
            var no_inv 					= $('#inv_num').val();
            var total           = $('#total_h').val();
            var diskon        	= $('#diskon').val();
            var dp              = $('#dp').val();
            var retur           = $('#return').val();
            var twot            = $('#twot').val();
            var vat             = $('#vat').val();
            var grand_total     = $('#grandtotal').val();
			//			
			data.push({		
				"no_inv": no_inv,
				"total": total,
				"diskon": diskon,	
				"dp": dp,					
				"retur": retur,
				"twot": twot,
				"vat": vat,	
				"grand_total": grand_total,																
			})	
			
			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_invoice_nb_pot/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					// Delete Table Invoice Detail Temporary
					// delete_invoice_detail_temporary();
					// // Print Preview Invoice
					let id_invoice = $('[name="id_num_post"]').val();
					print_invoice_nb(id_invoice);
                    // Reload Page
                    window.location.href = window.location.href;

                },
                error: function (jqXHR, textStatus, errorThrown) {
                	msg = 'Error Input Detail' + jqXHR.text
                }
            });
			resolve({
				msg: msg,
			});

		}, 100);
		});

	}

	function print_invoice_nb(id) {

	//var id_bank = $('#bank').val(); 	
	//window.open("http://localhost/ar-nag/arnag/report_invoice/" + id + "/" );  
	//window.open("http://localhost/ar-nag/arnag/report_invoice2/" + id + "/" ); 
	//window.open("http://10.10.2.179/ar-nag/arnag/report_invoice3/" + id + "/" + id_bank + "/" );  	
	window.open(".../../report_invoice4/" + id + "/" );  	

}

function simpan_invoice_nb_detail() 
{ 	
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		

			var table = document.getElementById("table-sj");
			for (var i = 1; i < (table.rows.length); i++) {

				var id_bppb = document.getElementById("table-sj").rows[i].cells[0].children[0].value;
				var no_so = document.getElementById("table-sj").rows[i].cells[1].children[0].value;
				var no_bppb = document.getElementById("table-sj").rows[i].cells[2].children[0].value;
				var sj_date = document.getElementById("table-sj").rows[i].cells[3].children[0].value;
				var no_shipp = document.getElementById("table-sj").rows[i].cells[4].children[0].value;
				var no_ws = document.getElementById("table-sj").rows[i].cells[5].children[0].value;
				var no_style = document.getElementById("table-sj").rows[i].cells[6].children[0].value;
				var prod_grup = document.getElementById("table-sj").rows[i].cells[7].children[0].value;
				var prod_item  = document.getElementById("table-sj").rows[i].cells[8].children[0].value;
				var color = document.getElementById("table-sj").rows[i].cells[9].children[0].value;
				var size = document.getElementById("table-sj").rows[i].cells[10].children[0].value;
				var curr = document.getElementById("table-sj").rows[i].cells[11].children[0].value;
				var uom = document.getElementById("table-sj").rows[i].cells[12].children[0].value;
				var qty = document.getElementById("table-sj").rows[i].cells[13].children[0].value;
				var unit_price = document.getElementById("table-sj").rows[i].cells[14].children[0].value;
				var diskon = document.getElementById("table-sj").rows[i].cells[15].children[0].value;
				var total = document.getElementById("table-sj").rows[i].cells[16].children[0].value;
				var status      = "POST";
				
				data.push({		
					"no_inv": $('#inv_num').val(),
					"id_bppb": id_bppb,
					"no_so": no_so,	
					"no_bppb": no_bppb,					
					"sj_date":sj_date,
					"no_shipp": no_shipp,
					"no_ws": no_ws,
					"no_style": no_style,
					"prod_grup": prod_grup,
					"prod_item": prod_item,
					"color": color,
					"size": size,	
					"curr": curr,					
					"uom":uom,
					"qty": qty,
					"unit_price": unit_price,
					"diskon": diskon,
					"total": total,
					"status": status,								

				})		
			}

			var fdata = {
				'data_table': data
			}

			$.ajax({				
				url: "simpan_invoice_nb_detail/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});  

}

function input_rate(){ 
	var rat = $('[name="rate"]').val();
	document.getElementsByName("pl_rate")[0].value = formatMoney(rat);
}

function modal_input_amt(){ 
	var table = document.getElementById("table-sj");
	var tota = 0;
	var totall = 0;
	var price_h = 0;
	for (var i = 1; i < (table.rows.length); i++) {

		var price = document.getElementById("table-sj").rows[i].cells[7].children[0].value;
		var outstan = $('[name="am_awal"]').val();
		if (price == '') {
			price_h = 0;
		}else{
			price_h = price;
		}
		tota += parseFloat(price_h);
		totall = parseFloat(outstan - tota);

		document.getElementsByName("out_alok")[0].value = totall.toFixed(2);
		document.getElementsByName("total_alokasi")[0].value = tota.toFixed(2);

	}
}


//ubah september
function modal_input_amt_dn(){ 
	var table = document.getElementById("table-dn");
	var tota = 0;
	var totall = 0;
	var hasilkali = 0;
	var rate_idr = 1;
	for (var i = 2; i < (table.rows.length); i++) {

		var price = document.getElementById("table-dn").rows[i].cells[6].children[0].value || 0;
		var rate = document.getElementById("table-dn").rows[i].cells[7].children[0].value;
		var curr1 = $('[name="curr1"]').val();
		var curr2 = $('[name="curr2"]').val();
		tota += parseFloat(price);
		if (curr1 == "IDR" && curr2 == 'USD') {
			totall += parseFloat(price / rate); 
			hasilkali = parseFloat(price / rate); 
		}else if (curr1 == "USD" && curr2 == 'IDR') {
			totall += parseFloat(price * rate); 
			hasilkali = parseFloat(price * rate); 
		}else if(curr1 == curr2){
			totall += parseFloat(price * 1); 
			hasilkali = parseFloat(price * 1); 
			document.getElementById("table-dn").rows[i].cells[7].children[0].value = rate_idr.toFixed(0);
		}

		document.getElementsByName("total_value")[0].value = formatMoney(tota.toFixed(2));
		document.getElementsByName("total_value_h")[0].value = tota.toFixed(2);
		document.getElementsByName("total_value_idr")[0].value = formatMoney(totall.toFixed(2));
		document.getElementsByName("total_value_idr_h")[0].value = totall.toFixed(2);
		document.getElementById("table-dn").rows[i].cells[8].children[0].value = hasilkali.toFixed(2);
	// document.getElementById("table-dn").rows[i].cells[4].children[0].readonly = false;

}
}

//ubah september
function hitungRow(){ 
	var table = document.getElementById("table-dn");
	var tota = 0;
	var totall = 0;
	var hasilkali = 0;
	var rate_idr = 1;
	for (var i = 2; i < (table.rows.length); i++) {

		var price = document.getElementById("table-dn").rows[i].cells[6].children[0].value || 0;
		var rate = document.getElementById("table-dn").rows[i].cells[7].children[0].value;
		var curr1 = $('[name="curr1"]').val();
		var curr2 = $('[name="curr2"]').val();
		tota += parseFloat(price);
		if (curr1 == "IDR" && curr2 == 'USD') {
			totall += parseFloat(price / rate); 
			hasilkali = parseFloat(price / rate); 
		}else if (curr1 == "USD" && curr2 == 'IDR') {
			totall += parseFloat(price * rate); 
			hasilkali = parseFloat(price * rate); 
		}else if(curr1 == curr2){
			totall += parseFloat(price * 1); 
			hasilkali = parseFloat(price * 1); 
			document.getElementById("table-dn").rows[i].cells[7].children[0].value = rate_idr.toFixed(0);
		}

		document.getElementsByName("total_value")[0].value = formatMoney(tota.toFixed(2));
		document.getElementsByName("total_value_h")[0].value = tota.toFixed(2);
		document.getElementsByName("total_value_idr")[0].value = formatMoney(totall.toFixed(2));
		document.getElementsByName("total_value_idr_h")[0].value = totall.toFixed(2);
		document.getElementById("table-dn").rows[i].cells[8].children[0].value = hasilkali.toFixed(2);

	}
}
//ubah september
function modal_input_rate_dn(){ 
	var table = document.getElementById("table-dn");
	var tota = 0;
	var totall = 0;
	var hasilkali = 0;
	var rate_idr = 1;
	for (var i = 2; i < (table.rows.length); i++) {

		var price = document.getElementById("table-dn").rows[i].cells[6].children[0].value || 0;
		var rate = document.getElementById("table-dn").rows[i].cells[7].children[0].value;
		var curr1 = $('[name="curr1"]').val();
		var curr2 = $('[name="curr2"]').val();
		tota += parseFloat(price);
		if (curr1 == "IDR" && curr2 == 'USD') {
			totall += parseFloat(price / rate); 
			hasilkali = parseFloat(price / rate); 
		}else if (curr1 == "USD" && curr2 == 'IDR') {
			totall += parseFloat(price * rate); 
			hasilkali = parseFloat(price * rate); 
		}else if(curr1 == curr2){
			totall += parseFloat(price * 1); 
			hasilkali = parseFloat(price * 1); 
			document.getElementById("table-dn").rows[i].cells[7].children[0].value = rate_idr.toFixed(0);
		}

		document.getElementsByName("total_value")[0].value = formatMoney(tota.toFixed(2));
		document.getElementsByName("total_value_h")[0].value = tota.toFixed(2);
		document.getElementsByName("total_value_idr")[0].value = formatMoney(totall.toFixed(2));
		document.getElementsByName("total_value_idr_h")[0].value = totall.toFixed(2);
		document.getElementById("table-dn").rows[i].cells[8].children[0].value = hasilkali.toFixed(2);

	}
}

function input_awal(){ 
	var table = document.getElementById("table-sj");
	var tota = 0;
	var totall = 0;
	var cr = $('[name="currn"]').val();
	if (cr == 'USD') {
		var rate = $('[name="rate"]').val();
	}else{
		var rate = $('[name="rate_h"]').val();
	}
	var amt = $('[name="am_awal"]').val();
	for (var i = 1; i < (table.rows.length); i++) {

		var price = document.getElementById("table-sj").rows[i].cells[7].children[0].value;
		var outstan = $('[name="am_awal"]').val();
		tota += parseFloat(price);
		totall = parseFloat(outstan - tota);

		document.getElementsByName("out_alok")[0].value = totall.toFixed(2);

	}
	document.getElementsByName("am_akhir")[0].value = formatMoney(rate * amt);
	document.getElementsByName("pl_awal")[0].value = formatMoney(amt);
	document.getElementsByName("pl_akhir")[0].value = (rate * amt);
}


function add_id_() {

	$cust = $('[name="customer"]').val();
	$name_cust = $('[name="cust"]').val();

	var cr = $('[name="currn"]').val();
	var paywith = $('[name="pay_type"]').val();
	$pwith = paywith;

	if (cr == 'USD') {
		$rate = $('[name="rate"]').val();
	}else{
		$rate = $('[name="rate_h"]').val();
	}

	if (paywith == 'USD') {
		$alo = $('[name="am_awal"]').val();
	}else{
		$alo = $('[name="pl_akhir"]').val()
	}

	console.log(paywith);

	//
	$('[name="custmr"]').val($cust);
	$('[name="nama_custmr"]').val($name_cust);
	$('[name="rates"]').val($rate);
	$('[name="pwith"]').val($pwith);
	$('[name="val_alo"]').val($alo);
	$('[name="val_alo1"]').val(formatMoney($alo));
	$('[name="ost_alo"]').val(formatMoney($alo));
	//
	$('#tabelkwt tbody tr').remove();	
	//
	$('#so_number1').val("");
	//$('#id_sj').val("");
	//Clear Value : Total, Discount, Down Payment, Return, Total With Out Tax, VAT, Grand Total
	$('#total').val("");
	$('#total1').val("");
	$('#terbilang').val("");
	$('#val_kwt').val("");
	$('#val_kwt1').val("");
	// $('#vat').val("");
	// $('#grandtotal').val("");	
	//
	//
	delete_invoice_detail_alo();
	cari_data_inv();
	modal_clear_component();

}

function simpan_data_alokasi() { 

	let doc_num   = $('[name="doc_number"]').val();
	let bank      = $('[name="bank"]').val();
	let account   = $('[name="acc"]').val();
	let outstand   = $('[name="out_alok"]').val();
	if (doc_num == "") {
		alert("Document Number is required");
		$("#doc_number").focus();	
		return false;
	}
	
	$no_invoice = $('[name="alk_number"]').val()	

	$('[name="no_alokasi"]').val($no_invoice);
	if (outstand >= 0) {
		$('#modal-simpan-alokasi').modal('show')	
	}else{
		alert("Outstanding Can't be minus");
	}

}

//ubah desember
function simpan_data_dn() { 

	// update_memo_det();

	var date   = $('[name="dn_date"]').val();
	var duedate   = $('[name="dn_duedate"]').val();
	let attn   = $('[name="txt_attn"]').val();
	let total   = $('[name="total_value_h"]').val();
	// alert(duedate);
	if (duedate < date) {
		alert("Due Date can't be smaller than Debit Note Date");
		$("#dn_duedate").focus();	
		return false;
	} 

	if (attn == "") {
		alert("Attn is required");
		$("#txt_attn").focus();	
		return false;
	}  
	
	$no_invoice = $('[name="dn_number"]').val()	

	$('[name="no_debinote"]').val($no_invoice);
	if (total == 0 || total == '') {
		alert("Amount Can't be Zero");
	}else{
		getcoa3();
		$('#modal-simpan-dn').modal('show')	
	}


}

//ubah desember
function getcoa3() 
{	

	// let no_invoice   = $('[name="inv_num"]').val();
	// let type_so   	 = $('[name="type_so"]').val();
	// let shipp 		 = $('[name="shipp"]').val();
	// let type 		 = $('[name="type"]').val();
	let id_cust 	 = $('[name="customer"]').val();
	// let grade 	 	 = $('[name="grade"]').val();
	// let inv_date 	 = $('[name="invoice_date"]').val();
	// let vat 		 = $('[name="vat"]').val();
	// let diskon 		 = $('[name="diskon"]').val();
	// let curr		 = $('[name="inv_curr"]').val();

	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related';
	}else{
		cust_ctg = 'Third';
	}

	console.log(cust_ctg);

	$.ajax({
		url: "getcoa3/" + cust_ctg + "/",		
		type: "GET",
		dataType: "JSON",
		success: function (data) {

			$('[name="no_coa_deb3"]').val(data.no_coa);
			$('[name="nama_coa_deb3"]').val(data.nama_coa);
			console.log( data.no_coa );

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

function cari_data_invoic() { 

	$('#table-inv-alok tbody tr').remove();	
		//Date range picker
		$('input[name="cobacoba"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="cobacoba"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_invkwt = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_invkwt = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="cobacoba"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_invkwt   = "undefined";
			dt_sampai_invkwt = "undefined";
		});

		var id_customer = $('#custmr').val();
		var rate = $('#rates').val();
		var pwith = $('#pwith').val();

		console.log(dt_dari_invkwt + ' ' + dt_sampai_invkwt + ' ' + rate + ' ' + pwith);

		$.ajax({		
			url: "cari_invoice_alo/" + dt_dari_invkwt + "/" + dt_sampai_invkwt + "/" + id_customer + "/" + rate + "/" + pwith + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 								
					trHTML += '<tr>';					
					trHTML += '<td>' + item.no_invoice + "</td>";
					trHTML += '<td>' + item.inv_date + "</td>";
					trHTML += '<td>' + item.duedate + "</td>";	
					trHTML += '<td>' + item.curr + "</td>";
					trHTML += '<td style="display:none;">' + item.amount1 + "</td>";
					trHTML += '<td style="display:none;">' + item.amountrate + "</td>";
					trHTML += '<td>' + item.amount + "</td>";
					trHTML += '<td>' + item.amountrate1 + "</td>";		
					trHTML += '<td><input type="text" min="0" class="form-control" id="mdl_amo" name="mdl_amo" style="width: 80%; text-align: right" oninput="modal_input_amo(value)" readonly autocomplete="off"></td>';
					trHTML += '<td><input type="checkbox" name="mdl_cek_kwt" id="mdl_cek_kwt" class="flat"  onclick="modal_sum_total_alo(value = ' +  item.amount1 + '); modal_get_amount(value = ' +  item.amount1 + ')"></td>';

					trHTML += '</tr>';
				});

				$('#table-inv-alok').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	

	}

	function modal_sum_total_alo(){
		
		var input_kwt = document.getElementsByName("mdl_cek_kwt");
		var hanya_baca = document.getElementsByName("mdl_amo");	
		var total = 0;

	//    	
	for (var i = 0; i < input_kwt.length; i++) {
		for (var i = 0; i < hanya_baca.length;  i++){
			if (input_kwt[i].checked) {
				hanya_baca[i].readOnly = false;				
				total += parseFloat(input_kwt[i].value);

			}else {				
				hanya_baca[i].readOnly = true;
				hanya_baca[i].value = '';
				// modal_input_amo();

			}
			type: "POST";					
		}
	}

  	// document.getElementsByName("val_kwt")[0].value = total;
  	// document.getElementsByName("val_kwt1")[0].value = formatMoney(total);

  }

//ubah september -
function modal_get_amount(){


	var input_kwt = document.getElementsByName("mdl_cek_kwt");
	var totmdl_amo = document.getElementsByName("mdl_amo");
	var val_alo = $('#val_alo').val();	
	var total = 0;
	var totalas = 0;
	var ost = 0;

	//    	
    		// alert(totmdl_amo);
    		for (var i = 0; i < input_kwt.length; i++) {
    			if (input_kwt[i].checked) {	
    				if(totmdl_amo[i].value == ''){
    					total = parseFloat(input_kwt[i].value);
    				}else{		
    					total = parseFloat(totmdl_amo[i].value);
    				}
    				totalas += parseFloat(input_kwt[i].value);

    				document.getElementsByName("mdl_amo")[i].value = total;		  	
    			}
    			type: "POST";					
    		}
    		ost = val_alo - totalas;


    		document.getElementsByName("val_kwt")[0].value = totalas;
    		document.getElementsByName("val_kwt1")[0].value = formatMoney(totalas);
    		document.getElementsByName("ost_alo")[0].value = formatMoney(ost);

    	}


    	function modal_input_amo(value){ 


    		var input = document.getElementsByName("mdl_cek_kwt");
    		var pwith = $('#pwith').val();
    		var val_alo = $('#val_alo').val();
    		var total = 0;
    		var ost = 0;	
	//
	var table = document.getElementById("table-inv-alok");
	var arr = document.getElementsByName('mdl_amo');
	var tot = 0;
	var amou = 0;
	for(var i = 0; i < arr.length; i++){
		for (var i = 0; i < input.length; i++) {
			for (var i = 0; i + 1 < table.rows.length; i++) {
				if (pwith == "USD") {
					if (input[i].checked) {
						total = parseFloat(input[i].value);
						amou = table.rows[i + 1].cells[4].innerHTML;
						if(parseFloat(arr[i].value) > table.rows[i + 1].cells[4].innerHTML || parseFloat(arr[i].value) < 1){
							arr[i].value = table.rows[i + 1].cells[4].innerHTML;
							tot += parseFloat(table.rows[i + 1].cells[4].innerHTML);
							ost = val_alo - tot;
						}else if(arr[i].value == ''){
							arr[i].value = '';
							tot += parseFloat(arr[i].value);
							ost = val_alo - tot;
						}else{
							arr[i].value = arr[i].value;	 
							tot += parseFloat(arr[i].value);
							ost = val_alo - tot;
						} 
					} 
				}
				else{
					if (input[i].checked) {
						total = parseFloat(input[i].value);
						amou = table.rows[i + 1].cells[5].innerHTML;
						if(parseFloat(arr[i].value) > table.rows[i + 1].cells[5].innerHTML || parseFloat(arr[i].value) < 1){
							arr[i].value = table.rows[i + 1].cells[5].innerHTML;
							tot += parseFloat(table.rows[i + 1].cells[5].innerHTML);
							ost = val_alo - tot;
						}else if(arr[i].value == ''){
							arr[i].value = '';
							tot += parseFloat(arr[i].value);
							ost = val_alo - tot;
						}else{
							arr[i].value = arr[i].value;	 
							tot += parseFloat(arr[i].value);
							ost = val_alo - tot;
						} 
					} 
				}
			}	        
		}	
	}	

	document.getElementsByName("val_kwt")[0].value = tot;
	document.getElementsByName("val_kwt1")[0].value = formatMoney(tot); 
	document.getElementsByName("ost_alo")[0].value = formatMoney(ost); 			
}

//ubah desember
function duplicate_data_alo(){ 

	var saldo    = $('[name="val_alo"]').val();
	var pay      = $('[name="val_kwt"]').val();
	var total = saldo - pay;
	console.log(saldo);
	console.log(pay);
	console.log(total);
	$('[name="out_alok"]').val(total.toFixed(2));
	$('[name="out_alok_h"]').val(total);
	$('[name="total_alokasi"]').val(pay);
 	// delete_invoice_detail_alo();
 	simpan_invoice_detail_alo();


 }


 function delete_invoice_detail_alo(){ 

 	$.ajax({						
 		url: "delete_invoice_detail_alo/",
 		type: "GET",				
 		dataType: "JSON",
 		success: function (data) {

			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Delete Table Temporary'			     
			} else {
				msg = 'Error Delete Table Temporary'				
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Delete Table Temporary' + jqXHR.text			
		}
	});

 }


 function simpan_invoice_detail_alo(){
 	return new Promise(resolve => {		
 		setTimeout(() => {
 			var msg
 			var data 	= [];

 			$("#table-inv-alok input[name='mdl_cek_kwt']:checked").each(function () {
 				var rows = $(this).closest("tr")[0];
				//
				$(this).closest('tr').find("input[name='mdl_amo']").each(function() {				
					var amnt = this.value	
                //
                data.push({							
					//"id_invoice_proforma": rows.cells[0].innerHTML,
					"ref_number": rows.cells[0].innerHTML,	
					"ref_date": rows.cells[1].innerHTML,						
					"due_date": rows.cells[2].innerHTML,
					"curr": rows.cells[3].innerHTML,
					"total": rows.cells[4].innerHTML,
					"eqp_idr": rows.cells[5].innerHTML,					
					"amount": amnt,	
					"rate": $('[name="rate"]').val(),								
				})	
            });		 

			});

 			var fdata = {
 				'data_table': data
 			}
 			console.log(fdata);
 			$.ajax({				
 				url: "simpan_invoice_detail_alo/",
 				type: "POST",
 				data: fdata,
 				dataType: "JSON",
 				success: function (data) {

					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}

					//Load Data SO Proforma Temporary
					load_invoice_detail_alo();                   		
					$('#modal-add-so').modal('hide');

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
 			resolve({
 				msg: msg,
 			});

 		}, 100);
 	});
 }


//ubah desember
function load_invoice_detail_alo(){ 

	$('#table-sj tbody tr').remove();


	var coa = "<select class='form-control select2bs4' name='coa' id='coa' style='width: 300px'> <option value='-' > - </option> <option value = '1.01.01'> 1.01.01 KAS KECIL PABRIK </option><option value = '1.01.02'> 1.01.02 KAS KECIL KANTOR </option><option value = '1.01.03'> 1.01.03 KAS BESAR </option><option value = '1.10.01'> 1.10.01 BCA 008-997-1979 </option><option value = '1.10.02'> 1.10.02 BCA 008-998-1982 </option><option value = '1.10.11'> 1.10.11 BNI 442-244-2000 </option><option value = '1.20.01'> 1.20.01 OBLIGASI </option><option value = '1.30.01'> 1.30.01 PIUTANG USAHA PIHAK KETIGA - LOKAL </option><option value = '1.30.02'> 1.30.02 PIUTANG USAHA PIHAK KETIGA - EKSPOR </option><option value = '1.31.01'> 1.31.01 PIUTANG USAHA GIRO MUNDUR PIHAK KETIGA  - LOKAL </option><option value = '1.31.02'> 1.31.02 PIUTANG USAHA GIRO MUNDUR PIHAK KETIGA  - EKSPOR </option><option value = '1.32.01'> 1.32.01 PIUTANG USAHA PIHAK BERELASI - LOKAL </option><option value = '1.32.02'> 1.32.02 PIUTANG USAHA PIHAK BERELASI - EKSPOR </option><option value = '1.33.01'> 1.33.01 PIUTANG USAHA GIRO MUNDUR PIHAK BERELASI - LOKAL </option><option value = '1.33.02'> 1.33.02 PIUTANG USAHA GIRO MUNDUR PIHAK BERELASI - EKSPOR </option><option value = '1.34.01'> 1.34.01 PIUTANG LAIN-LAIN - BAHAN BAKU/BAHAN PEMBANTU </option><option value = '1.34.02'> 1.34.02 PIUTANG LAIN-LAIN - MESIN </option><option value = '1.34.03'> 1.34.03 PIUTANG LAIN-LAIN - SPAREPARTS </option><option value = '1.34.51'> 1.34.51 PIUTANG LAIN-LAIN - KARYAWAN </option><option value = '1.34.61'> 1.34.61 PIUTANG LAIN-LAIN - PPH 23 </option><option value = '1.34.99'> 1.34.99 PIUTANG LAIN-LAIN </option><option value = '1.35.01'> 1.35.01 PIUTANG LAIN-LAIN - BAHAN BAKU/BAHAN PEMBANTU </option><option value = '1.35.02'> 1.35.02 PIUTANG LAIN-LAIN - MESIN </option><option value = '1.35.03'> 1.35.03 PIUTANG LAIN-LAIN - SPAREPARTS </option><option value = '1.35.51'> 1.35.51 PIUTANG LAIN-LAIN - DIREKSI </option><option value = '1.35.99'> 1.35.99 PIUTANG LAIN-LAIN </option><option value = '1.36.01'> 1.36.01 PERSEDIAAN CHEMICAL </option><option value = '1.36.11'> 1.36.11 PERSEDIAAN BENANG GREY </option><option value = '1.36.12'> 1.36.12 PERSEDIAAN BENANG WARNA </option><option value = '1.36.21'> 1.36.21 PERSEDIAAN KAIN GREY </option><option value = '1.36.22'> 1.36.22 PERSEDIAAN KAIN MATANG </option><option value = '1.37.01'> 1.37.01 PERSEDIAAN CHEMICAL </option><option value = '1.37.11'> 1.37.11 PERSEDIAAN BENANG GREY </option><option value = '1.37.12'> 1.37.12 PERSEDIAAN BENANG WARNA </option><option value = '1.37.21'> 1.37.21 PERSEDIAAN KAIN GREY </option><option value = '1.37.22'> 1.37.22 PERSEDIAAN KAIN MATANG </option><option value = '1.38.01'> 1.38.01 PERSEDIAAN DUS </option><option value = '1.38.11'> 1.38.11 PERSEDIAAN PLASTIK </option><option value = '1.38.21'> 1.38.21 PERSEDIAAN CONES & KLONGSONG </option><option value = '1.38.31'> 1.38.31 PERSEDIAAN LABEL </option><option value = '1.38.41'> 1.38.41 PERSEDIAAN AKSESORIS GARMENT </option><option value = '1.38.99'> 1.38.99 PERSEDIAAN LAIN-LAIN </option><option value = '1.39.01'> 1.39.01 PERSEDIAAN DUS </option><option value = '1.39.11'> 1.39.11 PERSEDIAAN PLASTIK </option><option value = '1.39.21'> 1.39.21 PERSEDIAAN CONES & KLONGSONG </option><option value = '1.39.31'> 1.39.31 PERSEDIAAN LABEL </option><option value = '1.39.41'> 1.39.41 PERSEDIAAN AKSESORIS GARMENT </option><option value = '1.39.99'> 1.39.99 PERSEDIAAN LAIN-LAIN </option><option value = '1.40.01'> 1.40.01 PERSEDIAAN BARANG DALAM PROSES - PERSIAPAN - FOB </option><option value = '1.40.02'> 1.40.02 PERSEDIAAN BARANG DALAM PROSES - PRODUKSI - FOB </option><option value = '1.40.03'> 1.40.03 PERSEDIAAN BARANG DALAM PROSES - FINISHING - FOB </option><option value = '1.40.11'> 1.40.11 PERSEDIAAN BARANG DALAM PROSES - PERSIAPAN - CMT </option><option value = '1.40.12'> 1.40.12 PERSEDIAAN BARANG DALAM PROSES - PRODUKSI - CMT </option><option value = '1.40.13'> 1.40.13 PERSEDIAAN BARANG DALAM PROSES - FINISHING - CMT </option><option value = '1.40.21'> 1.40.21 PERSEDIAAN BARANG DALAM PROSES DI PEMAKLOON - FOB </option><option value = '1.40.31'> 1.40.31 PERSEDIAAN BARANG DALAM PROSES DI PEMAKLOON - CMT </option><option value = '1.40.41'> 1.40.41 PERSEDIAAN KAIN DI PEMAKLOON </option><option value = '1.40.51'> 1.40.51 PERSEDIAAN AKSESORIS DI PEMAKLOON </option><option value = '1.40.61'> 1.40.61 PERSEDIAAN BARANG JADI DI PEMAKLOON </option><option value = '1.41.01'> 1.41.01 PERSEDIAAN BARANG DALAM PROSES - PERSIAPAN - FOB </option><option value = '1.41.02'> 1.41.02 PERSEDIAAN BARANG DALAM PROSES - PRODUKSI - FOB </option><option value = '1.41.03'> 1.41.03 PERSEDIAAN BARANG DALAM PROSES - FINISHING - FOB </option><option value = '1.41.11'> 1.41.11 PERSEDIAAN BARANG DALAM PROSES - PERSIAPAN - CMT </option><option value = '1.41.12'> 1.41.12 PERSEDIAAN BARANG DALAM PROSES - PRODUKSI - CMT </option><option value = '1.41.13'> 1.41.13 PERSEDIAAN BARANG DALAM PROSES - FINISHING - CMT </option><option value = '1.41.21'> 1.41.21 PERSEDIAAN BARANG DALAM PROSES DI PEMAKLOON - FOB </option><option value = '1.41.31'> 1.41.31 PERSEDIAAN BARANG DALAM PROSES DI PEMAKLOON - CMT </option><option value = '1.41.41'> 1.41.41 PERSEDIAAN KAIN DI PEMAKLOON </option><option value = '1.41.51'> 1.41.51 PERSEDIAAN AKSESORIS DI PEMAKLOON </option><option value = '1.41.61'> 1.41.61 PERSEDIAAN BARANG JADI DI PEMAKLOON </option><option value = '1.42.01'> 1.42.01 PERSEDIAAN BENANG WARNA </option><option value = '1.42.02'> 1.42.02 PERSEDIAAN BENANG WARNA CMT </option><option value = '1.42.11'> 1.42.11 PERSEDIAAN GREY </option><option value = '1.42.12'> 1.42.12 PERSEDIAAN GREY CMT </option><option value = '1.42.21'> 1.42.21 PERSEDIAAN KAIN </option><option value = '1.42.22'> 1.42.22 PERSEDIAAN KAIN CMT </option><option value = '1.42.31'> 1.42.31 PERSEDIAAN PAKAIAN JADI FOB </option><option value = '1.42.32'> 1.42.32 PERSEDIAAN PAKAIAN JADI CMT </option><option value = '1.43.01'> 1.43.01 PERSEDIAAN BENANG WARNA </option><option value = '1.43.02'> 1.43.02 PERSEDIAAN BENANG WARNA CMT </option><option value = '1.43.11'> 1.43.11 PERSEDIAAN GREY </option><option value = '1.43.12'> 1.43.12 PERSEDIAAN GREY CMT </option><option value = '1.43.21'> 1.43.21 PERSEDIAAN KAIN </option><option value = '1.43.22'> 1.43.22 PERSEDIAAN KAIN CMT </option><option value = '1.43.31'> 1.43.31 PERSEDIAAN PAKAIAN JADI FOB </option><option value = '1.43.32'> 1.43.32 PERSEDIAAN PAKAIAN JADI CMT </option><option value = '1.44.01'> 1.44.01 PERSEDIAAN SPAREPARTS - MECHANICAL </option><option value = '1.44.02'> 1.44.02 PERSEDIAAN SPAREPARTS - ELECTRICAL </option><option value = '1.44.03'> 1.44.03 PERSEDIAAN SPAREPARTS - TOOLS </option><option value = '1.44.04'> 1.44.04 PERSEDIAAN SPAREPARTS - LIQUID </option><option value = '1.44.05'> 1.44.05 PERSEDIAAN SPAREPARTS - FACTORY SUPPLIES </option><option value = '1.45.01'> 1.45.01 PERSEDIAAN SPAREPARTS - MECHANICAL </option><option value = '1.45.02'> 1.45.02 PERSEDIAAN SPAREPARTS - ELECTRICAL </option><option value = '1.45.03'> 1.45.03 PERSEDIAAN SPAREPARTS - TOOLS </option><option value = '1.45.04'> 1.45.04 PERSEDIAAN SPAREPARTS - LIQUID </option><option value = '1.45.05'> 1.45.05 PERSEDIAAN SPAREPARTS - FACTORY SUPPLIES </option><option value = '1.46.01'> 1.46.01 PERSEDIAAN BATUBARA </option><option value = '1.46.02'> 1.46.02 PERSEDIAAN SOLAR PABRIK </option><option value = '1.46.03'> 1.46.03 PERSEDIAAN ELPIJI </option><option value = '1.47.01'> 1.47.01 PERSEDIAAN BATUBARA </option><option value = '1.47.02'> 1.47.02 PERSEDIAAN SOLAR PABRIK </option><option value = '1.47.03'> 1.47.03 PERSEDIAAN ELPIJI </option><option value = '1.48.01'> 1.48.01 PERSEDIAAN ATK </option><option value = '1.48.02'> 1.48.02 PERSEDIAAN UMUM </option><option value = '1.49.01'> 1.49.01 PERSEDIAAN ATK </option><option value = '1.49.02'> 1.49.02 PERSEDIAAN UMUM </option><option value = '1.50.01'> 1.50.01 UANG MUKA PEMBELIAN ASET TETAP </option><option value = '1.50.11'> 1.50.11 UANG MUKA PEMBELIAN BAHAN BAKU / BAHAN PEMBANTU </option><option value = '1.50.21'> 1.50.21 UANG MUKA PEMBELIAN SPAREPARTS </option><option value = '1.50.81'> 1.50.81 UANG MUKA PEMBELIAN JASA </option><option value = '1.50.99'> 1.50.99 UANG MUKA PEMBELIAN LAIN-LAIN </option><option value = '1.51.01'> 1.51.01 BIAYA DIBAYAR DIMUKA - SEWA </option><option value = '1.51.02'> 1.51.02 BIAYA DIBAYAR DIMUKA - ASURANSI </option><option value = '1.51.99'> 1.51.99 BIAYA DIBAYAR DIMUKA - LAIN-LAIN </option><option value = '1.52.01'> 1.52.01 PAJAK DIBAYAR DIMUKA PPH PASAL 22 </option><option value = '1.52.02'> 1.52.02 PAJAK DIBAYAR DIMUKA PPH PASAL 23 </option><option value = '1.52.03'> 1.52.03 PAJAK DIBAYAR DIMUKA PPH PASAL 25 </option><option value = '1.52.04'> 1.52.04 PAJAK DIBAYAR DIMUKA PPN MASUKAN </option><option value = '1.52.05'> 1.52.05 PAJAK DIBAYAR DIMUKA PPH PASAL 4 AYAT 2 </option><option value = '1.52.06'> 1.52.06 PAJAK DIBAYAR DIMUKA PPH PASAL 21 </option><option value = '1.52.07'> 1.52.07 PAJAK DIBAYAR DIMUKA PPN MASUKAN (UNBILLED) </option><option value = '1.53.01'> 1.53.01 PPH BADAN LB PASAL 28A </option><option value = '1.54.01'> 1.54.01 PEMBELIAN DIBAYAR DIMUKA ASET TETAP </option><option value = '1.54.11'> 1.54.11 PEMBELIAN DIBAYAR DIMUKA BAHAN BAKU / BAHAN PEMBANTU </option><option value = '1.54.21'> 1.54.21 PEMBELIAN DIBAYAR DIMUKA SPAREPARTS </option><option value = '1.54.81'> 1.54.81 PEMBELIAN DIBAYAR DIMUKA JASA </option><option value = '1.54.99'> 1.54.99 PEMBELIAN DIBAYAR DIMUKA LAIN-LAIN </option><option value = '1.60.01'> 1.60.01 TANAH </option><option value = '1.61.01'> 1.61.01 BANGUNAN </option><option value = '1.62.01'> 1.62.01 INSTALASI LISTRIK </option><option value = '1.62.02'> 1.62.02 INSTALASI AIR </option><option value = '1.63.01'> 1.63.01 MESIN </option><option value = '1.64.01'> 1.64.01 PERALATAN PABRIK </option><option value = '1.65.01'> 1.65.01 KENDARAAN </option><option value = '1.66.01'> 1.66.01 PERALATAN KANTOR </option><option value = '1.66.02'> 1.66.02 PERALATAN IT </option><option value = '1.69.01'> 1.69.01 PERANGKAT LUNAK </option><option value = '1.71.01'> 1.71.01 AKUMULASI PENYUSUTAN BANGUNAN </option><option value = '1.72.01'> 1.72.01 AKUMULASI PENYUSUTAN INSTALASI LISTRIK </option><option value = '1.72.02'> 1.72.02 AKUMULASI PENYUSUTAN INSTALASI AIR </option><option value = '1.73.01'> 1.73.01 AKUMULASI PENYUSUTAN MESIN </option><option value = '1.74.01'> 1.74.01 AKUMULASI PENYUSUTAN PERALATAN PABRIK </option><option value = '1.75.01'> 1.75.01 AKUMULASI PENYUSUTAN KENDARAAN </option><option value = '1.76.01'> 1.76.01 AKUMULASI PENYUSUTAN PERALATAN KANTOR </option><option value = '1.76.02'> 1.76.02 AKUMULASI PENYUSUTAN PERALATAN IT </option><option value = '1.79.01'> 1.79.01 AKUMULASI AMORTISASI PERANGKAT LUNAK </option><option value = '1.80.01'> 1.80.01 ASET DALAM PENYELESAIAN - BANGUNAN </option><option value = '1.80.11'> 1.80.11 ASET DALAM PENYELESAIAN - INSTALASI LISTRIK </option><option value = '1.80.12'> 1.80.12 ASET DALAM PENYELESAIAN - INSTALASI AIR </option><option value = '1.80.91'> 1.80.91 ASET DALAM PENYELESAIAN - PERANGKAT LUNAK </option><option value = '1.90.01'> 1.90.01 POS SILANG </option><option value = '2.10.01'> 2.10.01 GR/IR - CHEMICAL </option><option value = '2.10.02'> 2.10.02 GR/IR - BENANG </option><option value = '2.10.03'> 2.10.03 GR/IR - KAIN GREY </option><option value = '2.10.04'> 2.10.04 GR/IR - KAIN MATANG </option><option value = '2.10.05'> 2.10.05 GR/IR - PAKAIAN JADI </option><option value = '2.10.06'> 2.10.06 GR/IR - BAHAN PEMBANTU </option><option value = '2.10.07'> 2.10.07 GR/IR - SPAREPARTS </option><option value = '2.10.08'> 2.10.08 GR/IR - BAHAN BAKAR </option><option value = '2.10.09'> 2.10.09 GR/IR - ATK </option><option value = '2.10.10'> 2.10.10 GR/IR - MESIN </option><option value = '2.10.11'> 2.10.11 GR/IR - MAKLOON </option><option value = '2.10.49'> 2.10.49 GR/IR - LAIN-LAIN </option><option value = '2.10.51'> 2.10.51 UTANG USAHA - CHEMICAL </option><option value = '2.10.52'> 2.10.52 UTANG USAHA - BENANG </option><option value = '2.10.53'> 2.10.53 UTANG USAHA - KAIN GREY </option><option value = '2.10.54'> 2.10.54 UTANG USAHA - KAIN MATANG </option><option value = '2.10.55'> 2.10.55 UTANG USAHA - PAKAIAN JADI </option><option value = '2.10.56'> 2.10.56 UTANG USAHA - BAHAN PEMBANTU </option><option value = '2.10.57'> 2.10.57 UTANG USAHA - SPAREPARTS </option><option value = '2.10.58'> 2.10.58 UTANG USAHA - BAHAN BAKAR </option><option value = '2.10.59'> 2.10.59 UTANG USAHA - ATK </option><option value = '2.10.60'> 2.10.60 UTANG USAHA - MESIN </option><option value = '2.10.61'> 2.10.61 UTANG USAHA - MAKLOON </option><option value = '2.10.99'> 2.10.99 UTANG USAHA - LAIN-LAIN </option><option value = '2.11.01'> 2.11.01 GR/IR - CHEMICAL </option><option value = '2.11.02'> 2.11.02 GR/IR - BENANG </option><option value = '2.11.03'> 2.11.03 GR/IR - KAIN GREY </option><option value = '2.11.04'> 2.11.04 GR/IR - KAIN MATANG </option><option value = '2.11.05'> 2.11.05 GR/IR - PAKAIAN JADI </option><option value = '2.11.06'> 2.11.06 GR/IR - BAHAN PEMBANTU </option><option value = '2.11.07'> 2.11.07 GR/IR - SPAREPARTS </option><option value = '2.11.08'> 2.11.08 GR/IR - BAHAN BAKAR </option><option value = '2.11.09'> 2.11.09 GR/IR - ATK </option><option value = '2.11.10'> 2.11.10 GR/IR - MESIN </option><option value = '2.11.11'> 2.11.11 GR/IR - MAKLOON </option><option value = '2.11.49'> 2.11.49 GR/IR - LAIN-LAIN </option><option value = '2.11.51'> 2.11.51 UTANG USAHA - CHEMICAL </option><option value = '2.11.52'> 2.11.52 UTANG USAHA - BENANG </option><option value = '2.11.53'> 2.11.53 UTANG USAHA - KAIN GREY </option><option value = '2.11.54'> 2.11.54 UTANG USAHA - KAIN MATANG </option><option value = '2.11.55'> 2.11.55 UTANG USAHA - PAKAIAN JADI </option><option value = '2.11.56'> 2.11.56 UTANG USAHA - BAHAN PEMBANTU </option><option value = '2.11.57'> 2.11.57 UTANG USAHA - SPAREPARTS </option><option value = '2.11.58'> 2.11.58 UTANG USAHA - BAHAN BAKAR </option><option value = '2.11.59'> 2.11.59 UTANG USAHA - ATK </option><option value = '2.11.60'> 2.11.60 UTANG USAHA - MESIN </option><option value = '2.11.61'> 2.11.61 UTANG USAHA - MAKLOON </option><option value = '2.11.99'> 2.11.99 UTANG USAHA - LAIN-LAIN </option><option value = '2.12.01'> 2.12.01 GR/IR - CHEMICAL </option><option value = '2.12.02'> 2.12.02 GR/IR - BENANG </option><option value = '2.12.03'> 2.12.03 GR/IR - KAIN GREY </option><option value = '2.12.04'> 2.12.04 GR/IR - KAIN MATANG </option><option value = '2.12.05'> 2.12.05 GR/IR - PAKAIAN JADI </option><option value = '2.12.06'> 2.12.06 GR/IR - BAHAN PEMBANTU </option><option value = '2.12.07'> 2.12.07 GR/IR - SPAREPARTS </option><option value = '2.12.08'> 2.12.08 GR/IR - BAHAN BAKAR </option><option value = '2.12.09'> 2.12.09 GR/IR - ATK </option><option value = '2.12.10'> 2.12.10 GR/IR - MESIN </option><option value = '2.12.11'> 2.12.11 GR/IR - MAKLOON </option><option value = '2.12.49'> 2.12.49 GR/IR - LAIN-LAIN </option><option value = '2.12.51'> 2.12.51 UTANG USAHA - CHEMICAL </option><option value = '2.12.52'> 2.12.52 UTANG USAHA - BENANG </option><option value = '2.12.53'> 2.12.53 UTANG USAHA - KAIN GREY </option><option value = '2.12.54'> 2.12.54 UTANG USAHA - KAIN MATANG </option><option value = '2.12.55'> 2.12.55 UTANG USAHA - PAKAIAN JADI </option><option value = '2.12.56'> 2.12.56 UTANG USAHA - BAHAN PEMBANTU </option><option value = '2.12.57'> 2.12.57 UTANG USAHA - SPAREPARTS </option><option value = '2.12.58'> 2.12.58 UTANG USAHA - BAHAN BAKAR </option><option value = '2.12.59'> 2.12.59 UTANG USAHA - ATK </option><option value = '2.12.60'> 2.12.60 UTANG USAHA - MESIN </option><option value = '2.12.61'> 2.12.61 UTANG USAHA - MAKLOON </option><option value = '2.12.99'> 2.12.99 UTANG USAHA - LAIN-LAIN </option><option value = '2.13.01'> 2.13.01 GR/IR - CHEMICAL </option><option value = '2.13.02'> 2.13.02 GR/IR - BENANG </option><option value = '2.13.03'> 2.13.03 GR/IR - KAIN GREY </option><option value = '2.13.04'> 2.13.04 GR/IR - KAIN MATANG </option><option value = '2.13.05'> 2.13.05 GR/IR - PAKAIAN JADI </option><option value = '2.13.06'> 2.13.06 GR/IR - BAHAN PEMBANTU </option><option value = '2.13.07'> 2.13.07 GR/IR - SPAREPARTS </option><option value = '2.13.08'> 2.13.08 GR/IR - BAHAN BAKAR </option><option value = '2.13.09'> 2.13.09 GR/IR - ATK </option><option value = '2.13.10'> 2.13.10 GR/IR - MESIN </option><option value = '2.13.11'> 2.13.11 GR/IR - MAKLOON </option><option value = '2.13.49'> 2.13.49 GR/IR - LAIN-LAIN </option><option value = '2.13.51'> 2.13.51 UTANG USAHA - CHEMICAL </option><option value = '2.13.52'> 2.13.52 UTANG USAHA - BENANG </option><option value = '2.13.53'> 2.13.53 UTANG USAHA - KAIN GREY </option><option value = '2.13.54'> 2.13.54 UTANG USAHA - KAIN MATANG </option><option value = '2.13.55'> 2.13.55 UTANG USAHA - PAKAIAN JADI </option><option value = '2.13.56'> 2.13.56 UTANG USAHA - BAHAN PEMBANTU </option><option value = '2.13.57'> 2.13.57 UTANG USAHA - SPAREPARTS </option><option value = '2.13.58'> 2.13.58 UTANG USAHA - BAHAN BAKAR </option><option value = '2.13.59'> 2.13.59 UTANG USAHA - ATK </option><option value = '2.13.60'> 2.13.60 UTANG USAHA - MESIN </option><option value = '2.13.61'> 2.13.61 UTANG USAHA - MAKLOON </option><option value = '2.13.99'> 2.13.99 UTANG USAHA - LAIN-LAIN </option><option value = '2.14.99'> 2.14.99 UTANG LAIN-LAIN </option><option value = '2.15.01'> 2.15.01 UTANG LAIN-LAIN - DIREKSI </option><option value = '2.15.99'> 2.15.99 UTANG LAIN-LAIN </option><option value = '2.20.01'> 2.20.01 OVERDRAFT BCA 008-997-1979 </option><option value = '2.20.02'> 2.20.02 OVERDRAFT BCA 008-998-1982 </option><option value = '2.50.01'> 2.50.01 UANG MUKA PENJUALAN EKSPOR </option><option value = '2.50.02'> 2.50.02 UANG MUKA PENJUALAN LOKAL </option><option value = '2.51.01'> 2.51.01 BIAYA YANG MASIH HARUS DIBAYAR - LISTRIK </option><option value = '2.51.02'> 2.51.02 BIAYA YANG MASIH HARUS DIBAYAR - AIR </option><option value = '2.51.11'> 2.51.11 BIAYA YANG MASIH HARUS DIBAYAR - TELP </option><option value = '2.51.12'> 2.51.12 BIAYA YANG MASIH HARUS DIBAYAR - INTERNET </option><option value = '2.51.21'> 2.51.21 BIAYA YANG MASIH HARUS DIBAYAR - GAJI </option><option value = '2.51.22'> 2.51.22 BIAYA YANG MASIH HARUS DIBAYAR - THR </option><option value = '2.51.31'> 2.51.31 BIAYA YANG MASIH HARUS DIBAYAR - BPJS </option><option value = '2.51.41'> 2.51.41 BIAYA YANG MASIH HARUS DIBAYAR - SEWA </option><option value = '2.51.51'> 2.51.51 BIAYA YANG MASIH HARUS DIBAYAR - EMKL </option><option value = '2.51.61'> 2.51.61 BIAYA YANG MASIH HARUS DIBAYAR - FOTOKOPI </option><option value = '2.52.01'> 2.52.01 PAJAK YANG MASIH HARUS DIBAYAR - PPH PASAL 21 </option><option value = '2.52.02'> 2.52.02 PAJAK YANG MASIH HARUS DIBAYAR - PPH PASAL 4 (2) </option><option value = '2.52.03'> 2.52.03 PAJAK YANG MASIH HARUS DIBAYAR - PPN </option><option value = '2.52.04'> 2.52.04 PAJAK YANG MASIH HARUS DIBAYAR - PPH PASAL 25/29 </option><option value = '2.52.05'> 2.52.05 PAJAK YANG MASIH HARUS DIBAYAR - PPH PASAL 23 </option><option value = '2.52.06'> 2.52.06 PAJAK YANG MASIH HARUS DIBAYAR - PBB </option><option value = '2.53.01'> 2.53.01 PPN KELUARAN </option><option value = '2.60.01'> 2.60.01 UTANG BANK JANGKA PANJANG </option><option value = '3.10.01'> 3.10.01 MODAL SAHAM </option><option value = '3.20.01'> 3.20.01 TAMBAHAN MODAL DISETOR (AMNESTI PAJAK) </option><option value = '3.30.01'> 3.30.01 LABA DITAHAN </option><option value = '3.40.01'> 3.40.01 LABA TAHUN BERJALAN </option><option value = '4.01.01'> 4.01.01 PENJUALAN BENANG GREY </option><option value = '4.01.02'> 4.01.02 PENJUALAN BENANG WARNA </option><option value = '4.01.51'> 4.01.51 PENJUALAN BENANG GREY - B GRADE </option><option value = '4.01.52'> 4.01.52 PENJUALAN BENANG WARNA - B GRADE </option><option value = '4.02.01'> 4.02.01 PENJUALAN KAIN GREY </option><option value = '4.02.51'> 4.02.51 PENJUALAN KAIN GREY - B GRADE </option><option value = '4.03.01'> 4.03.01 PENJUALAN KAIN STRIPPER </option><option value = '4.03.51'> 4.03.51 PENJUALAN KAIN STRIPPER - B GRADE </option><option value = '4.04.01'> 4.04.01 PENJUALAN KAIN MATANG </option><option value = '4.04.51'> 4.04.51 PENJUALAN KAIN MATANG - B GRADE </option><option value = '4.05.01'> 4.05.01 PENJUALAN PAKAIAN JADI EKSPOR - FOB </option><option value = '4.05.02'> 4.05.02 PENJUALAN PAKAIAN JADI EKSPOR - CMT </option><option value = '4.05.51'> 4.05.51 PENJUALAN PAKAIAN JADI EKSPOR FOB - B GRADE </option><option value = '4.05.52'> 4.05.52 PENJUALAN PAKAIAN JADI EKSPOR CMT - B GRADE </option><option value = '4.06.01'> 4.06.01 PENJUALAN PAKAIAN JADI LOKAL FOB </option><option value = '4.06.02'> 4.06.02 PENJUALAN PAKAIAN JADI LOKAL CMT </option><option value = '4.06.51'> 4.06.51 PENJUALAN PAKAIAN JADI LOKAL FOB - B GRADE </option><option value = '4.06.52'> 4.06.52 PENJUALAN PAKAIAN JADI LOKAL CMT - B GRADE </option><option value = '4.07.01'> 4.07.01 PENJUALAN LAINNYA - DYESTUFF </option><option value = '4.07.02'> 4.07.02 PENJUALAN LAINNYA - CHEMICAL </option><option value = '4.07.03'> 4.07.03 PENJUALAN LAINNYA - ACCESSORIES </option><option value = '4.07.04'> 4.07.04 PENJUALAN LAINNYA - SAMPAH </option><option value = '4.10.01'> 4.10.01 PENJUALAN BENANG GREY </option><option value = '4.10.02'> 4.10.02 PENJUALAN BENANG WARNA </option><option value = '4.10.51'> 4.10.51 PENJUALAN BENANG GREY - B GRADE </option><option value = '4.10.52'> 4.10.52 PENJUALAN BENANG WARNA - B GRADE </option><option value = '4.11.01'> 4.11.01 PENJUALAN KAIN GREY </option><option value = '4.11.51'> 4.11.51 PENJUALAN KAIN GREY - B GRADE </option><option value = '4.12.01'> 4.12.01 PENJUALAN KAIN STRIPPER </option><option value = '4.12.51'> 4.12.51 PENJUALAN KAIN STRIPPER - B GRADE </option><option value = '4.13.01'> 4.13.01 PENJUALAN KAIN MATANG </option><option value = '4.13.51'> 4.13.51 PENJUALAN KAIN MATANG - B GRADE </option><option value = '4.14.01'> 4.14.01 PENJUALAN PAKAIAN JADI EKSPOR - FOB </option><option value = '4.14.02'> 4.14.02 PENJUALAN PAKAIAN JADI EKSPOR - CMT </option><option value = '4.14.51'> 4.14.51 PENJUALAN PAKAIAN JADI EKSPOR FOB - B GRADE </option><option value = '4.14.52'> 4.14.52 PENJUALAN PAKAIAN JADI EKSPOR CMT - B GRADE </option><option value = '4.15.01'> 4.15.01 PENJUALAN PAKAIAN JADI LOKAL FOB </option><option value = '4.15.02'> 4.15.02 PENJUALAN PAKAIAN JADI LOKAL CMT </option><option value = '4.15.51'> 4.15.51 PENJUALAN PAKAIAN JADI LOKAL FOB - B GRADE </option><option value = '4.15.52'> 4.15.52 PENJUALAN PAKAIAN JADI LOKAL CMT - B GRADE </option><option value = '4.16.01'> 4.16.01 PENJUALAN LAINNYA - DYESTUFF </option><option value = '4.16.02'> 4.16.02 PENJUALAN LAINNYA - CHEMICAL </option><option value = '4.16.03'> 4.16.03 PENJUALAN LAINNYA - ACCESSORIES </option><option value = '4.16.04'> 4.16.04 PENJUALAN LAINNYA - SAMPAH </option><option value = '4.20.01'> 4.20.01 JASA DYEING BENANG </option><option value = '4.21.01'> 4.21.01 JASA DYEING KAIN </option><option value = '4.22.01'> 4.22.01 JASA KNITTING </option><option value = '4.23.01'> 4.23.01 JASA JAHIT PAKAIAN JADI EKSPOR CMT </option><option value = '4.24.01'> 4.24.01 JASA JAHIT PAKAIAN JADI LOKAL CMT </option><option value = '4.25.01'> 4.25.01 JASA LAINNYA </option><option value = '4.30.01'> 4.30.01 JASA DYEING BENANG </option><option value = '4.31.01'> 4.31.01 JASA DYEING KAIN </option><option value = '4.32.01'> 4.32.01 JASA KNITTING </option><option value = '4.33.01'> 4.33.01 JASA JAHIT PAKAIAN JADI EKSPOR CMT </option><option value = '4.34.01'> 4.34.01 JASA JAHIT PAKAIAN JADI LOKAL CMT </option><option value = '4.35.01'> 4.35.01 JASA LAINNYA </option><option value = '4.40.01'> 4.40.01 RETUR PENJUALAN BENANG GREY </option><option value = '4.40.02'> 4.40.02 RETUR PENJUALAN BENANG WARNA </option><option value = '4.40.51'> 4.40.51 RETUR PENJUALAN BENANG GREY - B GRADE </option><option value = '4.40.52'> 4.40.52 RETUR PENJUALAN BENANG WARNA - B GRADE </option><option value = '4.41.01'> 4.41.01 RETUR PENJUALAN KAIN GREY </option><option value = '4.41.51'> 4.41.51 RETUR PENJUALAN KAIN GREY - B GRADE </option><option value = '4.42.01'> 4.42.01 RETUR PENJUALAN KAIN STRIPPER </option><option value = '4.42.51'> 4.42.51 RETUR PENJUALAN KAIN STRIPPER - B GRADE </option><option value = '4.43.01'> 4.43.01 RETUR PENJUALAN KAIN MATANG </option><option value = '4.43.51'> 4.43.51 RETUR PENJUALAN KAIN MATANG - B GRADE </option><option value = '4.44.01'> 4.44.01 RETUR PENJUALAN PAKAIAN JADI EKSPOR </option><option value = '4.44.51'> 4.44.51 RETUR PENJUALAN PAKAIAN JADI EKSPOR - B GRADE </option><option value = '4.45.01'> 4.45.01 RETUR PENJUALAN PAKAIAN JADI LOKAL </option><option value = '4.45.51'> 4.45.51 RETUR PENJUALAN PAKAIAN JADI LOKAL - B GRADE </option><option value = '4.46.01'> 4.46.01 RETUR PENJUALAN LAINNYA - DYESTUFF </option><option value = '4.46.02'> 4.46.02 RETUR PENJUALAN LAINNYA - CHEMICAL </option><option value = '4.46.03'> 4.46.03 RETUR PENJUALAN LAINNYA - ACCESSORIES </option><option value = '4.46.04'> 4.46.04 RETUR PENJUALAN LAINNYA - SAMPAH </option><option value = '4.47.01'> 4.47.01 JASA DYEING BENANG </option><option value = '4.48.01'> 4.48.01 JASA DYEING KAIN </option><option value = '4.49.01'> 4.49.01 JASA KNITTING </option><option value = '4.50.01'> 4.50.01 JASA JAHIT PAKAIAN JADI EKSPOR CMT </option><option value = '4.51.01'> 4.51.01 JASA JAHIT PAKAIAN JADI LOKAL CMT </option><option value = '4.52.01'> 4.52.01 JASA LAINNYA </option><option value = '4.55.01'> 4.55.01 RETUR PENJUALAN BENANG </option><option value = '4.55.02'> 4.55.02 RETUR PENJUALAN BENANG WARNA </option><option value = '4.55.51'> 4.55.51 RETUR PENJUALAN BENANG - B GRADE </option><option value = '4.55.52'> 4.55.52 RETUR PENJUALAN BENANG WARNA - B GRADE </option><option value = '4.56.01'> 4.56.01 RETUR PENJUALAN KAIN GREY </option><option value = '4.56.51'> 4.56.51 RETUR PENJUALAN KAIN GREY - B GRADE </option><option value = '4.57.01'> 4.57.01 RETUR PENJUALAN KAIN STRIPPER </option><option value = '4.57.51'> 4.57.51 RETUR PENJUALAN KAIN STRIPPER - B GRADE </option><option value = '4.58.01'> 4.58.01 RETUR PENJUALAN KAIN MATANG </option><option value = '4.58.51'> 4.58.51 RETUR PENJUALAN KAIN MATANG - B GRADE </option><option value = '4.59.01'> 4.59.01 RETUR PENJUALAN PAKAIAN JADI EKSPOR </option><option value = '4.59.51'> 4.59.51 RETUR PENJUALAN PAKAIAN JADI EKSPOR - B GRADE </option><option value = '4.60.01'> 4.60.01 RETUR PENJUALAN PAKAIAN JADI LOKAL </option><option value = '4.60.51'> 4.60.51 RETUR PENJUALAN PAKAIAN JADI LOKAL - B GRADE </option><option value = '4.61.01'> 4.61.01 RETUR PENJUALAN LAINNYA - DYESTUFF </option><option value = '4.61.02'> 4.61.02 RETUR PENJUALAN LAINNYA - CHEMICAL </option><option value = '4.61.03'> 4.61.03 RETUR PENJUALAN LAINNYA - ACCESSORIES </option><option value = '4.61.04'> 4.61.04 RETUR PENJUALAN LAINNYA - SAMPAH </option><option value = '4.62.01'> 4.62.01 RETUR PENDAPATAN JASA DYEING BENANG </option><option value = '4.63.01'> 4.63.01 RETUR PENDAPATAN JASA DYEING KAIN </option><option value = '4.64.01'> 4.64.01 RETUR PENDAPATAN JASA KNITTING </option><option value = '4.65.01'> 4.65.01 RETUR PENDAPATAN JASA JAHIT PAKAIAN JADI EKSPOR CMT </option><option value = '4.66.01'> 4.66.01 RETUR PENDAPATAN JASA JAHIT PAKAIAN JADI LOKAL CMT </option><option value = '4.67.01'> 4.67.01 RETUR PENDAPATAN JASA LAINNYA </option><option value = '4.70.01'> 4.70.01 POTONGAN PENJUALAN BENANG </option><option value = '4.70.11'> 4.70.11 POTONGAN PENJUALAN BENANG WARNA </option><option value = '4.70.21'> 4.70.21 POTONGAN PENJUALAN BENANG - B GRADE </option><option value = '4.70.31'> 4.70.31 POTONGAN PENJUALAN BENANG WARNA - B GRADE </option><option value = '4.71.01'> 4.71.01 POTONGAN PENJUALAN KAIN GREY </option><option value = '4.71.11'> 4.71.11 POTONGAN PENJUALAN KAIN GREY - B GRADE </option><option value = '4.72.01'> 4.72.01 POTONGAN PENJUALAN KAIN STRIPPER </option><option value = '4.72.51'> 4.72.51 POTONGAN PENJUALAN KAIN STRIPPER - B GRADE </option><option value = '4.73.01'> 4.73.01 POTONGAN PENJUALAN KAIN MATANG </option><option value = '4.73.51'> 4.73.51 POTONGAN PENJUALAN KAIN MATANG - B GRADE </option><option value = '4.74.01'> 4.74.01 POTONGAN PENJUALAN PAKAIAN JADI EKSPOR </option><option value = '4.74.51'> 4.74.51 POTONGAN PENJUALAN PAKAIAN JADI EKSPOR - B GRADE </option><option value = '4.75.01'> 4.75.01 POTONGAN PENJUALAN PAKAIAN JADI LOKAL </option><option value = '4.75.51'> 4.75.51 POTONGAN PENJUALAN PAKAIAN JADI LOKAL - B GRADE </option><option value = '4.76.01'> 4.76.01 POTONGAN PENJUALAN LAINNYA - DYESTUFF </option><option value = '4.76.02'> 4.76.02 POTONGAN PENJUALAN LAINNYA - CHEMICAL </option><option value = '4.76.03'> 4.76.03 POTONGAN PENJUALAN LAINNYA - ACCESSORIES </option><option value = '4.76.04'> 4.76.04 POTONGAN PENJUALAN LAINNYA - SAMPAH </option><option value = '4.77.01'> 4.77.01 POTONGAN JASA DYEING BENANG </option><option value = '4.78.01'> 4.78.01 POTONGAN JASA DYEING KAIN </option><option value = '4.79.01'> 4.79.01 POTONGAN JASA KNITTING </option><option value = '4.80.01'> 4.80.01 POTONGAN JASA JAHIT PAKAIAN JADI EKSPOR CMT </option><option value = '4.81.01'> 4.81.01 POTONGAN JASA JAHIT PAKAIAN JADI LOKAL CMT </option><option value = '4.82.01'> 4.82.01 POTONGAN JASA LAINNYA </option><option value = '4.85.01'> 4.85.01 POTONGAN PENJUALAN BENANG </option><option value = '4.85.02'> 4.85.02 POTONGAN PENJUALAN BENANG WARNA </option><option value = '4.85.51'> 4.85.51 POTONGAN PENJUALAN BENANG - B GRADE </option><option value = '4.85.52'> 4.85.52 POTONGAN PENJUALAN BENANG WARNA - B GRADE </option><option value = '4.86.01'> 4.86.01 POTONGAN PENJUALAN KAIN GREY </option><option value = '4.86.51'> 4.86.51 POTONGAN PENJUALAN KAIN GREY - B GRADE </option><option value = '4.87.01'> 4.87.01 POTONGAN PENJUALAN KAIN STRIPPER </option><option value = '4.87.51'> 4.87.51 POTONGAN PENJUALAN KAIN STRIPPER - B GRADE </option><option value = '4.88.01'> 4.88.01 POTONGAN PENJUALAN KAIN MATANG </option><option value = '4.88.51'> 4.88.51 POTONGAN PENJUALAN KAIN MATANG - B GRADE </option><option value = '4.89.01'> 4.89.01 POTONGAN PENJUALAN PAKAIAN JADI EKSPOR </option><option value = '4.89.51'> 4.89.51 POTONGAN PENJUALAN PAKAIAN JADI EKSPOR - B GRADE </option><option value = '4.90.01'> 4.90.01 POTONGAN PENJUALAN PAKAIAN JADI LOKAL </option><option value = '4.90.51'> 4.90.51 POTONGAN PENJUALAN PAKAIAN JADI LOKAL - B GRADE </option><option value = '4.91.01'> 4.91.01 POTONGAN PENJUALAN LAINNYA - DYESTUFF </option><option value = '4.91.02'> 4.91.02 POTONGAN PENJUALAN LAINNYA - CHEMICAL </option><option value = '4.91.03'> 4.91.03 POTONGAN PENJUALAN LAINNYA - ACCESSORIES </option><option value = '4.91.04'> 4.91.04 POTONGAN PENJUALAN LAINNYA - SAMPAH </option><option value = '4.92.01'> 4.92.01 POTONGAN JASA DYEING BENANG </option><option value = '4.93.01'> 4.93.01 POTONGAN JASA DYEING KAIN </option><option value = '4.94.01'> 4.94.01 POTONGAN JASA KNITTING </option><option value = '4.95.01'> 4.95.01 POTONGAN JASA JAHIT PAKAIAN JADI EKSPOR CMT </option><option value = '4.96.01'> 4.96.01 POTONGAN JASA JAHIT PAKAIAN JADI LOKAL CMT </option><option value = '4.97.01'> 4.97.01 POTONGAN JASA LAINNYA </option><option value = '5.01.01'> 5.01.01 HARGA POKOK PENJUALAN BENANG GREY </option><option value = '5.01.02'> 5.01.02 HARGA POKOK PENJUALAN BENANG WARNA </option><option value = '5.01.51'> 5.01.51 HARGA POKOK PENJUALAN BENANG GREY - B GRADE </option><option value = '5.01.52'> 5.01.52 HARGA POKOK PENJUALAN BENANG WARNA - B GRADE </option><option value = '5.02.01'> 5.02.01 HARGA POKOK PENJUALAN KAIN GREY </option><option value = '5.02.51'> 5.02.51 HARGA POKOK PENJUALAN KAIN GREY - B GRADE </option><option value = '5.03.01'> 5.03.01 HARGA POKOK PENJUALAN KAIN STRIPPER </option><option value = '5.03.51'> 5.03.51 HARGA POKOK PENJUALAN KAIN STRIPPER - B GRADE </option><option value = '5.04.01'> 5.04.01 HARGA POKOK PENJUALAN KAIN MATANG </option><option value = '5.04.51'> 5.04.51 HARGA POKOK PENJUALAN KAIN MATANG - B GRADE </option><option value = '5.05.01'> 5.05.01 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR - FOB </option><option value = '5.05.02'> 5.05.02 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR - CMT </option><option value = '5.05.51'> 5.05.51 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR FOB - B GRADE </option><option value = '5.05.52'> 5.05.52 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR CMT - B GRADE </option><option value = '5.06.01'> 5.06.01 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL FOB </option><option value = '5.06.02'> 5.06.02 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL CMT </option><option value = '5.06.51'> 5.06.51 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL FOB - B GRADE </option><option value = '5.06.52'> 5.06.52 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL CMT - B GRADE </option><option value = '5.07.01'> 5.07.01 HARGA POKOK PENJUALAN LAINNYA - DYESTUFF </option><option value = '5.07.02'> 5.07.02 HARGA POKOK PENJUALAN LAINNYA - CHEMICAL </option><option value = '5.07.03'> 5.07.03 HARGA POKOK PENJUALAN LAINNYA - ACCESSORIES </option><option value = '5.07.04'> 5.07.04 HARGA POKOK PENJUALAN LAINNYA - SAMPAH </option><option value = '5.08.01'> 5.08.01 HARGA POKOK PENDAPATAN JASA DYEING BENANG </option><option value = '5.09.01'> 5.09.01 HARGA POKOK PENDAPATAN JASA DYEING KAIN </option><option value = '5.10.01'> 5.10.01 HARGA POKOK PENDAPATAN JASA KNITTING </option><option value = '5.11.01'> 5.11.01 HARGA POKOK PENDAPATAN JASA JAHIT PAKAIAN JADI EKSPOR CMT </option><option value = '5.12.01'> 5.12.01 HARGA POKOK PENDAPATAN JASA JAHIT PAKAIAN JADI LOKAL CMT </option><option value = '5.13.01'> 5.13.01 HARGA POKOK PENDAPATAN JASA LAINNYA </option><option value = '5.14.01'> 5.14.01 HARGA POKOK PENJUALAN BENANG GREY </option><option value = '5.14.02'> 5.14.02 HARGA POKOK PENJUALAN BENANG WARNA </option><option value = '5.14.51'> 5.14.51 HARGA POKOK PENJUALAN BENANG GREY - B GRADE </option><option value = '5.14.52'> 5.14.52 HARGA POKOK PENJUALAN BENANG WARNA - B GRADE </option><option value = '5.15.01'> 5.15.01 HARGA POKOK PENJUALAN KAIN GREY </option><option value = '5.15.51'> 5.15.51 HARGA POKOK PENJUALAN KAIN GREY - B GRADE </option><option value = '5.16.01'> 5.16.01 HARGA POKOK PENJUALAN KAIN STRIPPER </option><option value = '5.16.51'> 5.16.51 HARGA POKOK PENJUALAN KAIN STRIPPER - B GRADE </option><option value = '5.17.01'> 5.17.01 HARGA POKOK PENJUALAN KAIN MATANG </option><option value = '5.17.51'> 5.17.51 HARGA POKOK PENJUALAN KAIN MATANG - B GRADE </option><option value = '5.18.01'> 5.18.01 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR - FOB </option><option value = '5.18.02'> 5.18.02 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR - CMT </option><option value = '5.18.51'> 5.18.51 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR FOB - B GRADE </option><option value = '5.18.52'> 5.18.52 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR CMT - B GRADE </option><option value = '5.19.01'> 5.19.01 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL FOB </option><option value = '5.19.02'> 5.19.02 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL CMT </option><option value = '5.19.51'> 5.19.51 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL FOB - B GRADE </option><option value = '5.19.52'> 5.19.52 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL CMT - B GRADE </option><option value = '5.20.01'> 5.20.01 HARGA POKOK PENJUALAN LAINNYA - DYESTUFF </option><option value = '5.20.02'> 5.20.02 HARGA POKOK PENJUALAN LAINNYA - CHEMICAL </option><option value = '5.20.03'> 5.20.03 HARGA POKOK PENJUALAN LAINNYA - ACCESSORIES </option><option value = '5.20.04'> 5.20.04 HARGA POKOK PENJUALAN LAINNYA - SAMPAH </option><option value = '5.21.01'> 5.21.01 HARGA POKOK PENDAPATAN JASA DYEING BENANG </option><option value = '5.22.01'> 5.22.01 HARGA POKOK PENDAPATAN JASA DYEING KAIN </option><option value = '5.23.01'> 5.23.01 HARGA POKOK PENDAPATAN JASA KNITTING </option><option value = '5.24.01'> 5.24.01 HARGA POKOK PENDAPATAN JASA JAHIT PAKAIAN JADI EKSPOR CMT </option><option value = '5.25.01'> 5.25.01 HARGA POKOK PENDAPATAN JASA JAHIT PAKAIAN JADI LOKAL CMT </option><option value = '5.26.01'> 5.26.01 HARGA POKOK PENDAPATAN JASA LAINNYA </option><option value = '5.27.01'> 5.27.01 BB - CHEMICAL </option><option value = '5.27.02'> 5.27.02 BB - CHEMICAL DYESTUFF </option><option value = '5.27.03'> 5.27.03 BB - CHEMICAL CALLATOR </option><option value = '5.27.04'> 5.27.04 BB - CHEMICAL DYEING </option><option value = '5.27.05'> 5.27.05 BB - CHEMICAL FINISHING </option><option value = '5.28.01'> 5.28.01 BB - BENANG </option><option value = '5.28.02'> 5.28.02 BB - BENANG GREY </option><option value = '5.28.03'> 5.28.03 BB - BENANG WARNA </option><option value = '5.29.01'> 5.29.01 BB - GREY </option><option value = '5.30.01'> 5.30.01 BB - KAIN MATANG </option><option value = '5.31.01'> 5.31.01 BB - CHEMICAL </option><option value = '5.31.02'> 5.31.02 BB - CHEMICAL DYESTUFF </option><option value = '5.31.03'> 5.31.03 BB - CHEMICAL CALLATOR </option><option value = '5.31.04'> 5.31.04 BB - CHEMICAL DYEING </option><option value = '5.31.05'> 5.31.05 BB - CHEMICAL FINISHING </option><option value = '5.32.01'> 5.32.01 BB - BENANG </option><option value = '5.32.02'> 5.32.02 BB - BENANG GREY </option><option value = '5.32.03'> 5.32.03 BB - BENANG WARNA </option><option value = '5.33.01'> 5.33.01 BB - GREY </option><option value = '5.34.01'> 5.34.01 BB - KAIN MATANG </option><option value = '5.35.01'> 5.35.01 BP - DUS </option><option value = '5.35.02'> 5.35.02 BP - PLASTIK </option><option value = '5.35.03'> 5.35.03 BP - CONES </option><option value = '5.35.04'> 5.35.04 BP - AKSESORIS - SEWING </option><option value = '5.35.05'> 5.35.05 BP - AKSESORIS - PACKING </option><option value = '5.36.01'> 5.36.01 BP - DUS </option><option value = '5.36.02'> 5.36.02 BP - PLASTIK </option><option value = '5.36.03'> 5.36.03 BP - CONES </option><option value = '5.36.04'> 5.36.04 BP - AKSESORIS - SEWING </option><option value = '5.36.05'> 5.36.05 BP - AKSESORIS - PACKING </option><option value = '5.40.01'> 5.40.01 BEBAN GAJI & UPAH TENAGA KERJA LANGSUNG </option><option value = '5.41.01'> 5.41.01 BEBAN TUNJANGAN TENAGA KERJA LANGSUNG </option><option value = '5.42.01'> 5.42.01 BEBAN LEMBUR TENAGA KERJA LANGSUNG </option><option value = '5.43.01'> 5.43.01 BPJS KETENAGAKERJAAN TENAGA KERJA LANGSUNG </option><option value = '5.43.02'> 5.43.02 BPJS KESEHATAN TENAGA KERJA LANGSUNG </option><option value = '5.44.01'> 5.44.01 THR TENAGA KERJA LANGSUNG </option><option value = '5.44.02'> 5.44.02 BONUS TENAGA KERJA LANGSUNG </option><option value = '5.45.01'> 5.45.01 BEBAN MANFAAT KARYAWAN TENAGA KERJA LANGSUNG </option><option value = '5.50.01'> 5.50.01 BEBAN GAJI & UPAH TENAGA KERJA TIDAK LANGSUNG </option><option value = '5.51.01'> 5.51.01 BEBAN TUNJANGAN TENAGA KERJA TIDAK LANGSUNG </option><option value = '5.52.01'> 5.52.01 BEBAN LEMBUR TENAGA KERJA TIDAK LANGSUNG </option><option value = '5.53.01'> 5.53.01 BPJS KETENAGAKERJAAN TENAGA KERJA TIDAK LANGSUNG </option><option value = '5.53.02'> 5.53.02 BPJS KESEHATAN TENAGA KERJA TIDAK LANGSUNG </option><option value = '5.54.01'> 5.54.01 THR TENAGA KERJA TIDAK LANGSUNG </option><option value = '5.54.02'> 5.54.02 BONUS TENAGA KERJA TIDAK LANGSUNG </option><option value = '5.55.01'> 5.55.01 BEBAN MANFAAT KARYAWAN TENAGA KERJA TIDAK LANGSUNG </option><option value = '5.69.01'> 5.69.01 BEBAN MAKLOON DYEING BENANG </option><option value = '5.69.02'> 5.69.02 BEBAN MAKLOON DYEING KAIN </option><option value = '5.69.03'> 5.69.03 BEBAN MAKLOON KNITTING </option><option value = '5.69.04'> 5.69.04 BEBAN MAKLOON PAKAIAN JADI </option><option value = '5.69.05'> 5.69.05 BEBAN MAKLOON PRINTING </option><option value = '5.69.06'> 5.69.06 BEBAN MAKLOON EMBRODEIRY </option><option value = '5.69.07'> 5.69.07 BEBAN MAKLOON WASHING </option><option value = '5.69.08'> 5.69.08 BEBAN MAKLOON KNITTING VIETER BAND </option><option value = '5.69.09'> 5.69.09 BEBAN MAKLOON BUBUT </option><option value = '5.69.10'> 5.69.10 BEBAN MAKLOON PAINTING </option><option value = '5.69.11'> 5.69.11 BEBAN MAKLOON LASER CUTTING </option><option value = '5.69.12'> 5.69.12 BEBAN MAKLOON BONDING </option><option value = '5.69.13'> 5.69.13 BEBAN MAKLOON HEATSEAL </option><option value = '5.69.14'> 5.69.14 BEBAN MAKLOON QUILTING </option><option value = '5.69.97'> 5.69.97 BEBAN MAKLOON KAIN </option><option value = '5.69.98'> 5.69.98 BEBAN MAKLOON AKSESORIS </option><option value = '5.69.99'> 5.69.99 BEBAN MAKLOON LAINNYA </option><option value = '5.70.01'> 5.70.01 BEBAN ENERGI - BATUBARA </option><option value = '5.70.02'> 5.70.02 BEBAN ENERGI - SOLAR </option><option value = '5.70.03'> 5.70.03 BEBAN ENERGI - ELPIJI </option><option value = '5.71.01'> 5.71.01 CHEMICAL IPAL </option><option value = '5.71.02'> 5.71.02 BEBAN BUANG LUMPUR </option><option value = '5.71.03'> 5.71.03 BEBAN BUANG ABU - LUMPUR </option><option value = '5.71.04'> 5.71.04 BEBAN BUANG ABU - BATU BARA </option><option value = '5.71.05'> 5.71.05 BEBAN UJI LAB LIMBAH AIR </option><option value = '5.71.99'> 5.71.99 BEBAN PENGOLAHAN LIMBAH LAINNYA </option><option value = '5.72.01'> 5.72.01 BEBAN SPAREPARTS </option><option value = '5.73.01'> 5.73.01 BEBAN IMPOR MESIN </option><option value = '5.73.02'> 5.73.02 BEBAN IMPOR SPAREPARTS </option><option value = '5.73.03'> 5.73.03 BEBAN IMPOR BAHAN BAKU </option><option value = '5.73.04'> 5.73.04 BEBAN IMPOR BAHAN PEMBANTU </option><option value = '5.74.01'> 5.74.01 BEBAN PENGUJIAN KAIN </option><option value = '5.74.99'> 5.74.99 BEBAN PENGUJIAN DAN PENELITIAN LAINNYA </option><option value = '5.75.01'> 5.75.01 BEBAN SEWA TANAH & BANGUNAN </option><option value = '5.75.02'> 5.75.02 BEBAN SEWA MESIN </option><option value = '5.76.01'> 5.76.01 BEBAN LISTRIK PABRIK </option><option value = '5.77.01'> 5.77.01 BEBAN TELEPON PABRIK </option><option value = '5.77.02'> 5.77.02 BEBAN INTERNET PABRIK </option><option value = '5.78.01'> 5.78.01 BEBAN IURAN AIR PJT </option><option value = '5.78.02'> 5.78.02 BEBAN PAJAK AIR PERMUKAAN </option><option value = '5.78.99'> 5.78.99 BEBAN AIR PABRIK LAINNYA </option><option value = '5.80.01'> 5.80.01 BEBAN PEMELIHARAAN BANGUNAN </option><option value = '5.80.11'> 5.80.11 BEBAN PEMELIHARAAN INSTALASI LISTRIK </option><option value = '5.80.12'> 5.80.12 BEBAN PEMELIHARAAN INSTALASI AIR </option><option value = '5.80.21'> 5.80.21 BEBAN PEMELIHARAAN MESIN </option><option value = '5.80.31'> 5.80.31 BEBAN PEMELIHARAAN PERALATAN PABRIK </option><option value = '5.80.41'> 5.80.41 BEBAN PEMELIHARAAN KENDARAAN </option><option value = '5.81.01'> 5.81.01 BEBAN ASURANSI BANGUNAN </option><option value = '5.81.11'> 5.81.11 BEBAN ASURANSI INSTALASI LISTRIK </option><option value = '5.81.12'> 5.81.12 BEBAN ASURANSI INSTALASI AIR </option><option value = '5.81.21'> 5.81.21 BEBAN ASURANSI MESIN </option><option value = '5.81.31'> 5.81.31 BEBAN ASURANSI PERALATAN PABRIK </option><option value = '5.81.41'> 5.81.41 BEBAN ASURANSI KENDARAAN </option><option value = '5.82.01'> 5.82.01 BEBAN KEPERLUAN KANTOR </option><option value = '5.82.02'> 5.82.02 BEBAN PEMAKAIAN ATK </option><option value = '5.82.03'> 5.82.03 BEBAN FOTOKOPI </option><option value = '5.83.01'> 5.83.01 TRAINING KARYAWAN PABRIK </option><option value = '5.83.02'> 5.83.02 SERAGAM DAN PERLENGKAPAN KERJA KARYAWAN </option><option value = '5.83.03'> 5.83.03 BEBAN KESEHATAN KARYAWAN </option><option value = '5.83.04'> 5.83.04 BEBAN KECELAKAAN KERJA </option><option value = '5.84.01'> 5.84.01 BEBAN TRANSPORTASI </option><option value = '5.84.02'> 5.84.02 BEBAN PERJALANAN DINAS </option><option value = '5.84.03'> 5.84.03 BEBAN EKSPEDISI ANGKUTAN </option><option value = '5.85.01'> 5.85.01 BEBAN KEPERLUAN PABRIK </option><option value = '5.86.01'> 5.86.01 BEBAN PERIZINAN </option><option value = '5.86.02'> 5.86.02 BEBAN RETRIBUSI </option><option value = '5.86.03'> 5.86.03 BEBAN IURAN </option><option value = '5.86.04'> 5.86.04 BEBAN SUMBANGAN </option><option value = '5.87.01'> 5.87.01 BEBAN PENYUSUTAN BANGUNAN </option><option value = '5.87.11'> 5.87.11 BEBAN PENYUSUTAN INSTALASI LISTRIK </option><option value = '5.87.12'> 5.87.12 BEBAN PENYUSUTAN INSTALASI AIR </option><option value = '5.87.21'> 5.87.21 BEBAN PENYUSUTAN MESIN </option><option value = '5.87.31'> 5.87.31 BEBAN PENYUSUTAN PERALATAN PABRIK </option><option value = '5.87.41'> 5.87.41 BEBAN PENYUSUTAN KENDARAAN </option><option value = '5.87.51'> 5.87.51 BEBAN PENYUSUTAN PERALATAN KANTOR </option><option value = '5.87.52'> 5.87.52 BEBAN PENYUSUTAN PERALATAN IT </option><option value = '5.87.91'> 5.87.91 BEBAN AMORTISASI PERANGKAT LUNAK </option><option value = '5.99.01'> 5.99.01 BEBAN PABRIK LAINNYA </option><option value = '5.99.10'> 5.99.10 BEBAN PENYESUAIAN PERSEDIAAN KAIN </option><option value = '5.99.11'> 5.99.11 BEBAN PENYESUAIAN PERSEDIAAN AKSESORIS </option><option value = '5.99.12'> 5.99.12 BEBAN PENYESUAIAN PERSEDIAAN DALAM PROSES </option><option value = '5.99.13'> 5.99.13 BEBAN PENYESUAIAN PERSEDIAAN BARANG JADI </option><option value = '5.99.99'> 5.99.99 BIAYA PRODUKSI BULAN BERJALAN </option><option value = '6.01.01'> 6.01.01 BEBAN GAJI & UPAH </option><option value = '6.02.02'> 6.02.02 BEBAN TUNJANGAN </option><option value = '6.03.03'> 6.03.03 BEBAN LEMBUR </option><option value = '6.04.01'> 6.04.01 BEBAN BPJS KETENAGAKERJAAN </option><option value = '6.04.02'> 6.04.02 BEBAN BPJS KESEHATAN </option><option value = '6.05.01'> 6.05.01 BEBAN THR </option><option value = '6.05.02'> 6.05.02 BEBAN BONUS </option><option value = '6.06.01'> 6.06.01 BEBAN MANFAAT KARYAWAN </option><option value = '6.10.01'> 6.10.01 BEBAN PROMOSI DAN IKLAN </option><option value = '6.11.01'> 6.11.01 BEBAN EKSPEDISI ANGKUTAN </option><option value = '6.12.01'> 6.12.01 BEBAN EKSPOR </option><option value = '6.12.02'> 6.12.02 BEBAN LC </option><option value = '6.13.01'> 6.13.01 BEBAN PIUTANG TIDAK TERTAGIH </option><option value = '6.14.01'> 6.14.01 BEBAN KLAIM PENJUALAN </option><option value = '6.14.02'> 6.14.02 BEBAN PINALTI PENJUALAN </option><option value = '6.14.03'> 6.14.03 BEBAN KOMISI PENJUALAN </option><option value = '6.15.01'> 6.15.01 BEBAN SAMPEL </option><option value = '6.15.02'> 6.15.02 BEBAN ENTERTAINMENT </option><option value = '6.16.01'> 6.16.01 BEBAN PEMELIHARAAN BANGUNAN </option><option value = '6.16.11'> 6.16.11 BEBAN PEMELIHARAAN INSTALASI LISTRIK </option><option value = '6.16.12'> 6.16.12 BEBAN PEMELIHARAAN INSTALASI AIR </option><option value = '6.16.21'> 6.16.21 BEBAN PEMELIHARAAN MESIN </option><option value = '6.16.41'> 6.16.41 BEBAN PEMELIHARAAN KENDARAAN </option><option value = '6.16.51'> 6.16.51 BEBAN PEMELIHARAAN PERALATAN KANTOR </option><option value = '6.17.01'> 6.17.01 BEBAN PENYUSUTAN BANGUNAN </option><option value = '6.17.11'> 6.17.11 BEBAN PENYUSUTAN INSTALASI LISTRIK </option><option value = '6.17.12'> 6.17.12 BEBAN PENYUSUTAN INSTALASI AIR </option><option value = '6.17.21'> 6.17.21 BEBAN PENYUSUTAN MESIN </option><option value = '6.17.41'> 6.17.41 BEBAN PENYUSUTAN KENDARAAN </option><option value = '6.17.51'> 6.17.51 BEBAN PENYUSUTAN PERALATAN KANTOR </option><option value = '6.17.52'> 6.17.52 BEBAN PENYUSUTAN PERALATAN IT </option><option value = '6.17.91'> 6.17.91 BEBAN AMORTISASI PERANGKAT LUNAK </option><option value = '6.18.01'> 6.18.01 BEBAN ASURANSI BANGUNAN </option><option value = '6.18.11'> 6.18.11 BEBAN ASURANSI INSTALASI LISTRIK </option><option value = '6.18.12'> 6.18.12 BEBAN ASURANSI INSTALASI AIR </option><option value = '6.18.21'> 6.18.21 BEBAN ASURANSI MESIN </option><option value = '6.18.41'> 6.18.41 BEBAN ASURANSI KENDARAAN </option><option value = '6.18.51'> 6.18.51 BEBAN ASURANSI PERALATAN KANTOR </option><option value = '6.19.01'> 6.19.01 BEBAN KEPERLUAN KANTOR </option><option value = '6.19.02'> 6.19.02 BEBAN PEMAKAIAN ATK </option><option value = '6.19.03'> 6.19.03 BEBAN FOTOKOPI </option><option value = '6.20.01'> 6.20.01 BEBAN TRAINING KARYAWAN </option><option value = '6.21.01'> 6.21.01 BEBAN TRANSPORTASI </option><option value = '6.21.02'> 6.21.02 BEBAN PERJALANAN DINAS </option><option value = '6.22.01'> 6.22.01 BEBAN RUMAH TANGGA KANTOR </option><option value = '6.23.01'> 6.23.01 BEBAN PERIZINAN </option><option value = '6.23.02'> 6.23.02 BEBAN RETRIBUSI </option><option value = '6.23.03'> 6.23.03 BEBAN IURAN </option><option value = '6.23.04'> 6.23.04 BEBAN SUMBANGAN </option><option value = '6.24.01'> 6.24.01 BEBAN SEWA KANTOR </option><option value = '6.25.01'> 6.25.01 BEBAN LISTRIK KANTOR </option><option value = '6.26.01'> 6.26.01 BEBAN TELEPON KANTOR </option><option value = '6.26.02'> 6.26.02 BEBAN INTERNET KANTOR </option><option value = '6.28.01'> 6.28.01 BEBAN JASA PROFESIONAL </option><option value = '6.27.01'> 6.27.01 BEBAN AIR KANTOR </option><option value = '6.29.01'> 6.29.01 BEBAN PENJUALAN LAINNYA </option><option value = '7.30.01'> 7.30.01 BEBAN GAJI & UPAH </option><option value = '7.31.01'> 7.31.01 BEBAN TUNJANGAN </option><option value = '7.32.01'> 7.32.01 BEBAN LEMBUR </option><option value = '7.33.01'> 7.33.01 BEBAN BPJS KETENAGAKERJAAN </option><option value = '7.33.02'> 7.33.02 BEBAN BPJS KESEHATAN </option><option value = '7.34.01'> 7.34.01 BEBAN THR </option><option value = '7.34.02'> 7.34.02 BEBAN BONUS </option><option value = '7.35.01'> 7.35.01 BEBAN MANFAAT KARYAWAN </option><option value = '7.40.01'> 7.40.01 BEBAN PAJAK </option><option value = '7.41.01'> 7.41.01 BEBAN JASA PROFESIONAL </option><option value = '7.42.01'> 7.42.01 BEBAN ENTERTAINMENT </option><option value = '7.43.01'> 7.43.01 BEBAN SEWA KANTOR </option><option value = '7.43.02'> 7.43.02 BEBAN SEWA PERALATAN KANTOR </option><option value = '7.44.01'> 7.44.01 BEBAN LISTRIK KANTOR </option><option value = '7.45.01'> 7.45.01 BEBAN TELEPON KANTOR </option><option value = '7.45.02'> 7.45.02 BEBAN INTERNET KANTOR </option><option value = '7.46.01'> 7.46.01 BEBAN AIR KANTOR </option><option value = '7.47.01'> 7.47.01 BEBAN PEMELIHARAAN BANGUNAN </option><option value = '7.47.11'> 7.47.11 BEBAN PEMELIHARAAN INSTALASI LISTRIK </option><option value = '7.47.12'> 7.47.12 BEBAN PEMELIHARAAN INSTALASI AIR </option><option value = '7.47.21'> 7.47.21 BEBAN PEMELIHARAAN MESIN </option><option value = '7.47.41'> 7.47.41 BEBAN PEMELIHARAAN KENDARAAN </option><option value = '7.47.51'> 7.47.51 BEBAN PEMELIHARAAN PERALATAN KANTOR </option><option value = '7.48.01'> 7.48.01 BEBAN PENYUSUTAN BANGUNAN </option><option value = '7.48.11'> 7.48.11 BEBAN PENYUSUTAN INSTALASI LISTRIK </option><option value = '7.48.12'> 7.48.12 BEBAN PENYUSUTAN INSTALASI AIR </option><option value = '7.48.21'> 7.48.21 BEBAN PENYUSUTAN MESIN </option><option value = '7.48.41'> 7.48.41 BEBAN PENYUSUTAN KENDARAAN </option><option value = '7.48.51'> 7.48.51 BEBAN PENYUSUTAN PERALATAN KANTOR </option><option value = '7.48.52'> 7.48.52 BEBAN PENYUSUTAN PERALATAN IT </option><option value = '7.48.91'> 7.48.91 BEBAN AMORTISASI PERANGKAT LUNAK </option><option value = '7.49.01'> 7.49.01 BEBAN ASURANSI BANGUNAN </option><option value = '7.49.11'> 7.49.11 BEBAN ASURANSI INSTALASI LISTRIK </option><option value = '7.49.12'> 7.49.12 BEBAN ASURANSI INSTALASI AIR </option><option value = '7.49.21'> 7.49.21 BEBAN ASURANSI MESIN </option><option value = '7.49.41'> 7.49.41 BEBAN ASURANSI KENDARAAN </option><option value = '7.49.51'> 7.49.51 BEBAN ASURANSI PERALATAN KANTOR </option><option value = '7.50.01'> 7.50.01 BEBAN KEPERLUAN KANTOR </option><option value = '7.50.02'> 7.50.02 BEBAN PEMAKAIAN ATK </option><option value = '7.50.03'> 7.50.03 BEBAN FOTOKOPI </option><option value = '7.51.01'> 7.51.01 BEBAN TRAINING KARYAWAN </option><option value = '7.52.01'> 7.52.01 BEBAN TRANSPORTASI </option><option value = '7.52.02'> 7.52.02 BEBAN PERJALANAN DINAS </option><option value = '7.53.01'> 7.53.01 BEBAN RUMAH TANGGA KANTOR </option><option value = '7.54.01'> 7.54.01 BEBAN PERIZINAN </option><option value = '7.54.02'> 7.54.02 BEBAN RETRIBUSI </option><option value = '7.54.03'> 7.54.03 BEBAN IURAN </option><option value = '7.54.04'> 7.54.04 BEBAN SUMBANGAN </option><option value = '7.99.01'> 7.99.01 BEBAN ADMINISTRASI & UMUM LAINNYA </option><option value = '8.01.01'> 8.01.01 LABA / (RUGI) PENJUALAN ASET TETAP </option><option value = '8.02.01'> 8.02.01 PENJUALAN SPAREPARTS </option><option value = '8.03.01'> 8.03.01 PENJUALAN LAIN-LAIN </option><option value = '8.04.01'> 8.04.01 PENDAPATAN JASA GIRO </option><option value = '8.05.01'> 8.05.01 PENDAPATAN SEWA </option><option value = '8.06.01'> 8.06.01 PENDAPATAN LAIN-LAIN </option><option value = '8.50.01'> 8.50.01 BEBAN BUNGA BANK </option><option value = '8.50.02'> 8.50.02 BEBAN BUNGA PEMEGANG SAHAM/DIREKSI </option><option value = '8.50.99'> 8.50.99 BEBAN BUNGA LAIN-LAIN </option><option value = '8.51.01'> 8.51.01 BEBAN ADMINISTRASI BANK </option><option value = '8.51.02'> 8.51.02 BEBAN PROVISI BANK </option><option value = '8.51.03'> 8.51.03 BEBAN ADMINISTRASI REKENING </option><option value = '8.52.01'> 8.52.01 LABA / (RUGI) SELISIH KURS </option><option value = '8.53.01'> 8.53.01 PEMBULATAN </option><option value = '8.54.01'> 8.54.01 BEBAN LAIN-LAIN </option><option value = '9.10.01'> 9.10.01 PAJAK KINI </option><option value = '9.10.02'> 9.10.02 PAJAK TANGGUHAN </option> </select>";
	var cost = "<select class='form-control select2bs4' name='cost' id='cost' style='width: 250px'> <option value='-' > - </option> <option value='01'> CUTTING </option><option value='02'> DISTRIBUTION </option><option value='03'> HEAT SEAL </option><option value='11'> SEWING </option><option value='12'> BARTEX </option><option value='21'> STEAM </option><option value='22'> FINISHING </option><option value='23'> PACKING </option><option value='31'> QUALITY CONTROL </option><option value='32'> MECHANIC </option><option value='33'> PPIC </option><option value='34'> LABORATORY </option><option value='35'> INDUSTRIAL ENGINERING </option><option value='36'> EXPEDITION </option><option value='37'> FABRICS WAREHOUSE </option><option value='38'> ACCESSORIES WAREHOUSE </option><option value='39'> FINISHED GOOD WAREHOUSE </option><option value='40'> SPAREPART WAREHOUSE </option><option value='41'> SPOT CLEANING </option><option value='60'> MANAGEMENT - FACTORY </option><option value='61'> MARKETING - TEAM A </option><option value='62'> MARKETING - TEAM B </option><option value='63'> MARKETING - TEAM C </option><option value='71'> EXPORT & IMPORT </option><option value='72'> PURCHASING </option><option value='73'> RESEARCH & DEVELOPMENT </option><option value='74'> SAMPLE ROOM </option><option value='81'> FINANCE, ACCOUNTING & TAX </option><option value='82'> INTERNAL AUDIT </option><option value='83'> HUMAN RESOURCE & DEVELOPMENT </option><option value='84'> GENERAL AFFAIR </option><option value='85'> INFORMATION TECHNOLOGY </option><option value='86'> COMPLIANCE </option><option value='87'> SYSTEM DEVELOPMENT </option><option value='99'> DIRECTOR </option> </select>";
	$.ajax({		
		url: "load_invoice_detail_alo/",							
		type: "GET",
		dataType: "JSON",
		success: function (response) {
			var trHTML = '';
			$.each(response, function (i, item) {
				trHTML += '<tr>';		
				trHTML += '<td width = "300px"><input type="hidden" value="'+ item.no_coa +'" class="form-control" id="stylein" name="stylein" style="width: 300px;" autocomplete="off" readonly>'+item.coa+'</td>';		
				trHTML += '<td style="width: 300px;"><input type="text" value="-" class="form-control" style="width: 250px;"  autocomplete="off" readonly></td>';
				trHTML += '<td><input type="text" value="'+ item.ref_number +'" class="form-control" id="stylein" name="stylein" style="width: 180px; text-align: center;"  autocomplete="off" readonly></td>';
				trHTML += '<td><input type="text" value="'+ item.ref_date +'" class="form-control" id="stylein" name="stylein" style="width: 150px; text-align: center;"  autocomplete="off" readonly></td>';
				trHTML += '<td><input type="text" value="'+ item.due_date +'" class="form-control" id="stylein" name="stylein" style="width: 150px; text-align: center;"  autocomplete="off" readonly></td>';
				trHTML += '<td><input type="text" value="'+ item.total +'" class="form-control" id="stylein" name="stylein" style="width: 180px; text-align: center;"  autocomplete="off" readonly></td>';
				trHTML += '<td><input type="text" value="'+ item.eqp_idr +'" class="form-control" id="stylein" name="stylein" style="width: 180px; text-align: center;"  autocomplete="off" readonly></td>';
				trHTML += '<td><input type="text" value="'+ item.amount +'" class="form-control" id="stylein" name="stylein" style="width: 180px; text-align: center;" oninput="modal_input_amt(value)" autocomplete="off"></td>';										    					
				trHTML += '<td ><input type="text" class="form-control" style="width: 300px;text-align: center;" id="desc" name="desc"  autocomplete="off"></td>';
						// trHTML += '<td><input type="text" value="'+ item.nama_coa +'" class="form-control" id="stylein" name="stylein" style="width: 180px; text-align: center;"  autocomplete="off" readonly></td>';											
						trHTML += '</tr>';

					});
			$('#table-sj').append(trHTML);
                        //Grand Total SO Proforma
						// sum_grandtotal_proforma(); 

					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Error get data from ajax');
					}
				});  	  	

}

//ubah desember
function save_alokasi() {
	
	simpanalokasi();	
	simpan_alokasi_detail();
	at_debit_alokasi();
	at_credit_alokasi();
	//	
	$('#modal-simpan-alokasi').modal('hide');
	
}

//ubah desember
function at_debit_alokasi() { 
	

	var data = [];
	var cust_ctg = '';
	var rate = 0;
	var total_idr = 0;

	var id_cust 	 	= $('[name="customer"]').val();
	var inv_rate 	 	= $('[name="rate"]').val();
	var inv_curr 	 	= $('[name="pay_type"]').val();
	var total 	 	= $('[name="total_alokasi"]').val();
	var buyer 	 		= $('[name="cust"]').val();
	var kata1 		= "PELUNASAN PIUTANG USAHA DARI";
	var keter 		 = kata1 +' '+buyer;
	if (id_cust == '524' || id_cust == '804' || id_cust == '366') {
		cust_ctg = 'Related Party';
	}else{
		cust_ctg = 'Third Party';
	}

	if (inv_curr == 'IDR') {
		rate = 1;
		total_idr = total * rate;
	}else{
		rate = inv_rate;
		total_idr = total * rate;
	}

	data.push({		
		"no_journal": $('#alk_number').val(),
		"tgl_journal": $('#alo_date').val(),
		"type_journal": 'Alokasi',
		"no_coa": '1.90.02',
		"nama_coa": 'POS SILANG PIUTANG USAHA',		
		"no_costcenter":'-',
		"nama_costcenter": '-',
		"reff_doc": '-',
		"reff_date": '',
		"buyer": buyer,
		"no_ws": '',
		"curr": $('#pay_type').val(),
		"rate": rate,
		"debit": $('#total_alokasi').val(),
		"credit": '0',
		"debit_idr":total_idr,			
		"credit_idr":'0',
		"status": 'POST',
		"keterangan": keter,
		"create_by": '',
		"create_date": '',
		"approve_by":'',	
		"approve_date": '',					
		"cancel_by":'',
		"cancel_date": '', 									

	})		

	var formData = {
		'data_table': data
	}

	console.log(formData);
	
	$.ajax({						
		url: "at_debit_inv/",		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {

			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Update Invoice Header'
			} else {
				msg = 'Error Update Invoice Header'
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Update Invoice Header' + jqXHR.text
		}
	});

}

//ubah desember
function update_coaname() { 

	$.ajax({						
		url: "update_coaname/",
		type: "GET",				
		dataType: "JSON",
		success: function (data) {
			
			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success update Table Temporary'			     
			} else {
				msg = 'Error update Table Temporary'				
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Delete Table Temporary' + jqXHR.text			
		}
	});
	
}


//ubah desember
function at_credit_alokasi() 
{ 	
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];
			rate = 0;
			total_idr = 0;
			var keterangan = '';		

			var inv_rate 	 	= $('[name="rate"]').val();
			var inv_curr 	 	= $('[name="pay_type"]').val();
			var buyer 	 		= $('[name="cust"]').val();
			var kata1 		= "PELUNASAN PIUTANG USAHA DARI";
			var keter 		 = kata1 +' '+buyer;
			var table = document.getElementById("table-sj");
			for (var i = 1; i < (table.rows.length); i++) {

				var coa = document.getElementById("table-sj").rows[i].cells[0].children[0].value;
				var cost_center = document.getElementById("table-sj").rows[i].cells[1].children[0].value;
				var no_ref = document.getElementById("table-sj").rows[i].cells[2].children[0].value;
				var ref_date = document.getElementById("table-sj").rows[i].cells[3].children[0].value;
				var due_date = document.getElementById("table-sj").rows[i].cells[4].children[0].value;
				var total = document.getElementById("table-sj").rows[i].cells[5].children[0].value;
				var eqp_idr = document.getElementById("table-sj").rows[i].cells[6].children[0].value;
				var amount = document.getElementById("table-sj").rows[i].cells[7].children[0].value;
				var amount2 = amount * -1;
				var keterangan2 = document.getElementById("table-sj").rows[i].cells[8].children[0].value;
				var status      = "POST";

				if(amount >= 1){
					if (inv_curr == 'IDR') {
						rate = 1;
						total_idr = amount * rate;
					}else{
						rate = inv_rate;
						total_idr = amount * rate;
					}
				}else{

					if (inv_curr == 'IDR') {
						rate = 1;
						total_idr = amount2 * rate;
					}else{
						rate = inv_rate;
						total_idr = amount2 * rate;
					}
				}


				if (keterangan2 == '' || keterangan2 == '-') {
					keterangan = keter;
				}else{
					keterangan = keterangan2;
				}
				
				if (amount >= 1) {
					data.push({		
						"no_journal": $('#alk_number').val(),
						"tgl_journal": $('#alo_date').val(),
						"type_journal": 'Alokasi',
						"no_coa": coa,
						"nama_coa": '-',		
						"no_costcenter":cost_center,
						"nama_costcenter": '-',
						"reff_doc": no_ref,
						"reff_date": ref_date,
						"buyer": buyer,
						"no_ws": '',
						"curr": $('#pay_type').val(),
						"rate": rate,
						"debit": '0',
						"credit": amount,
						"debit_idr":'0',			
						"credit_idr":total_idr,
						"status": 'POST',
						"keterangan": keterangan,
						"create_by": '',
						"create_date": '',
						"approve_by":'',	
						"approve_date": '',					
						"cancel_by":'',
						"cancel_date": '', 									

					})	
				}else{
					data.push({		
						"no_journal": $('#alk_number').val(),
						"tgl_journal": $('#alo_date').val(),
						"type_journal": 'Alokasi',
						"no_coa": coa,
						"nama_coa": '-',		
						"no_costcenter":cost_center,
						"nama_costcenter": '-',
						"reff_doc": '-',
						"reff_date": '',
						"buyer": buyer,
						"no_ws": '',
						"curr": $('#pay_type').val(),
						"rate": rate,
						"debit": amount2,
						"credit": '0',
						"debit_idr":total_idr,			
						"credit_idr":'0',
						"status": 'POST',
						"keterangan": keterangan,
						"create_by": '',
						"create_date": '',
						"approve_by":'',	
						"approve_date": '',					
						"cancel_by":'',
						"cancel_date": '', 									

					})	
				}	
			}

			var formData = {
				'data_table': data
			}

			console.log(formData);

			$.ajax({				
				url: "at_credit_inv/",
				type: "POST",
				data: formData,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}

					update_coaname();	
					
				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});  

}

//ubah september
function save_dn() {

	
	simpandn_h();	
	simpandn_det();
	// update_memo_h();
	update_memo_det();
	update_req_dn();
	//	
	$('#modal-simpan-dn').modal('hide');
	
}

	// let array = $('#no_req').val();

	// for (let i = 0; i < array.length; i++) {
 //  		console.log(array[i]);
	// }


	function update_req_dn(){
		let array = $('#no_req').val();
		for (let i = 0; i < array.length; i++) {
	//
	var dn_number 	 		= $('[name="dn_number"]').val();
	var no_req 	 			= array[i];

	var formData = {
		"dn_number": dn_number,
		"no_req": no_req,			
	};
				//
				$.ajax({						
					url: "update_req_dn/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				// $('#modal-approve-invoice-manual').modal('hide');
				// console.log(id_inv);  
				// window.location.reload();
				// cari_invoice_post();
			}

		}

		function update_memo_h(){
	//
	var dn_number 	 		= $('[name="dn_number"]').val();
	var nm_memo 	 		= $('[name="nm_memo"]').val();

	var formData = {
		"dn_number": dn_number,
		"nm_memo": nm_memo,			
	};
				//
				$.ajax({						
					url: "update_memo_h/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				// $('#modal-approve-invoice-manual').modal('hide');
				// console.log(id_inv);  
				// window.location.reload();
				// cari_invoice_post();

			}

//ubah september
function simpanalokasi() { 

	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		
            //
            var no_alk 			= $('#alk_number').val();
            var tgl_alk     = $('#alo_date').val();
            var customer    = $('#customer').val();
            var doc_number  = $('#doc_number').val();
            var bank   			= $('#id_bank').val();
            var account 		= $('#acc').val();
            var curr     		= $('#currn').val();
            var rate        = $('#rate').val();
            var amount      = $('#am_awal').val();
            var eqp_idr     = $('#pl_akhir').val();
            var sisa     = $('#out_alok').val();
            var status      = "POST"
			//			
			data.push({		
				"no_alk": no_alk,
				"tgl_alk": tgl_alk,
				"customer": customer,	
				"doc_number": doc_number,					
				"bank": bank,
				"account": account,
				"curr": curr,
				"rate": rate,	
				"amount": amount,					
				"eqp_idr": eqp_idr,
				"sisa": sisa,
				"status": status,															
			})	
			
			var fdata = {
				'data_table': data,
				'no_alk': no_alk
			}
			$.ajax({				
				url: "simpanalokasi/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					// Delete Table Invoice Detail Temporary
					delete_kwt_detail_temporary();
					// Print Preview Invoice
					// let no_kwt= $('[name="kwt_no"]').val();
					// print_kwitansi(no_kwt);
     //                // Reload Page
     window.location.href = window.location.href;

 },
 error: function (jqXHR, textStatus, errorThrown) {
 	msg = 'Error Input Detail' + jqXHR.text
 }
});
			resolve({
				msg: msg,
			});

		}, 100);
	});

}


//ubah desember

function simpandn_h() { 

	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		
            //
            var no_dn 			= $('#dn_number').val();
            var tgl_dn     		= $('#dn_date').val();
            var due_date     	= $('#dn_duedate').val();
            var customer    	= $('#customer').val();
            var attn  			= $('#txt_attn').val();
            var from_curr   	= $('#curr1').val();
            var to_curr 		= $('#curr2').val();
            var alamat     		= $('#alamat').val();
            var header1        	= $('#txt_header1').val();
            var header2      	= $('#txt_header2').val();
            var header3     	= $('#txt_header3').val();
            var amount      	= $('#total_value_h').val();
            var eqv_curr     	= $('#total_value_idr_h').val();
            var status      	= "POST";
            var akun     		= $('#akun').val();
            var no_coa      	= "1.34.99";
            var nama_coa     	= "PIUTANG LAIN-LAIN PIHAK KETIGA - LAIN-LAIN";
            var profit_center   = $('#profit_center_dn').val();
			//			
			data.push({		
				"no_dn": no_dn,
				"tgl_dn": tgl_dn,
				"due_date": due_date,
				"customer": customer,	
				"attn": attn,					
				"from_curr": from_curr,
				"to_curr": to_curr,
				"alamat": alamat,
				"header1": header1,	
				"header2": header2,					
				"header3": header3,
				"amount": amount,					
				"eqv_curr": eqv_curr,
				"status": status,
				"akun": akun,
				"no_coa": no_coa,
				"nama_coa": nama_coa,
				"profit_center": profit_center,															
			})	
			
			var fdata = {
				'data_table': data,
				'no_dn': no_dn
			}
			$.ajax({				
				url: "simpandn_h/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					// Delete Table Invoice Detail Temporary
					// delete_kwt_detail_temporary();
					// Print Preview Invoice
					// let no_kwt= $('[name="kwt_no"]').val();
					// print_kwitansi(no_kwt);
     //                // Reload Page
     window.location.href = window.location.href;

 },
 error: function (jqXHR, textStatus, errorThrown) {
 	msg = 'Error Input Detail' + jqXHR.text
 }
});
			resolve({
				msg: msg,
			});

		}, 100);
	});

}
//ubah september
function simpandn_det() 
{ 	
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		

			var table = document.getElementById("table-dn");
			for (var i = 2; i < (table.rows.length); i++) {

				var deskripsi = document.getElementById("table-dn").rows[i].cells[0].children[0].value;
				var supplier = document.getElementById("table-dn").rows[i].cells[1].children[0].value;
				var supplier_invoice = document.getElementById("table-dn").rows[i].cells[2].children[0].value;
				var header1 = document.getElementById("table-dn").rows[i].cells[3].children[0].value;
				var header2 = document.getElementById("table-dn").rows[i].cells[4].children[0].value;
				var header3 = document.getElementById("table-dn").rows[i].cells[5].children[0].value;
				var value = document.getElementById("table-dn").rows[i].cells[6].children[0].value;
				var rate = document.getElementById("table-dn").rows[i].cells[7].children[0].value;
				var amount = document.getElementById("table-dn").rows[i].cells[8].children[0].value;
				var nm_memo = document.getElementById("table-dn").rows[i].cells[12].children[0].value || '';
				var no_coa = document.getElementById("table-dn").rows[i].cells[9].children[0].value;
				var id_memo_det = document.getElementById("table-dn").rows[i].cells[13].children[0].value || '';

				
				data.push({		
					"no_dn": $('#dn_number').val(),
					"deskripsi": deskripsi,
					"supplier": supplier,
					"supplier_invoice": supplier_invoice,	
					"header1": header1,					
					"header2":header2,
					"header3": header3,
					"value": value,
					"rate": rate,
					"amount": amount,
					"nm_memo": nm_memo,
					"no_coa": no_coa,
					"id_memo_det": id_memo_det,

				})		
			}

			var fdata = {
				'data_table': data
			}

			console.log(data);

			$.ajax({				
				url: "simpandn_det/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});  

}


function simpan_alokasi_detail() 
{ 	
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		

			var table = document.getElementById("table-sj");
			for (var i = 1; i < (table.rows.length); i++) {

				var coa = document.getElementById("table-sj").rows[i].cells[0].children[0].value;
				var cost_center = document.getElementById("table-sj").rows[i].cells[1].children[0].value;
				var no_ref = document.getElementById("table-sj").rows[i].cells[2].children[0].value;
				var ref_date = document.getElementById("table-sj").rows[i].cells[3].children[0].value;
				var due_date = document.getElementById("table-sj").rows[i].cells[4].children[0].value;
				var total = document.getElementById("table-sj").rows[i].cells[5].children[0].value;
				var eqp_idr = document.getElementById("table-sj").rows[i].cells[6].children[0].value;
				var amount = document.getElementById("table-sj").rows[i].cells[7].children[0].value;
				var keterangan = document.getElementById("table-sj").rows[i].cells[8].children[0].value;
				var status      = "POST";
				
				data.push({		
					"no_alk": $('#alk_number').val(),
					"coa": coa,
					"cost_center": cost_center,
					"no_ref": no_ref,	
					"ref_date": ref_date,					
					"due_date":due_date,
					"total": total,
					"eqp_idr": eqp_idr,
					"amount": amount,
					"keterangan": keterangan,
					"status": status,								

				})		
			}

			var fdata = {
				'data_table': data
			}

			$.ajax({				
				url: "simpan_alokasi_detail/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});  

}

function cari_alokasi() { 

	$('#table-kwitansi tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_kwt = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_kwt = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_kwt   = "undefined";
			dt_sampai_kwt = "undefined";
		});

		var customer = $('#customer').val();	
		console.log(dt_sampai_kwt, dt_dari_kwt);

		

		$.ajax({		
			url: "cari_alokasi/" + dt_dari_kwt + "/" + dt_sampai_kwt + "/" + customer + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 								
					trHTML += '<tr>';					
					trHTML += '<td onclick="view_alok(\'' + item.id + '\',\'' + item.no_alk + '\')">' + item.no_alk + "</td>";
					trHTML += '<td>' + item.tgl_alk + "</td>";	
					trHTML += '<td>' + item.supplier + "</td>";
					trHTML += '<td>' + item.doc_number + "</td>";
					trHTML += '<td>' + item.bank + "</td>";
					trHTML += '<td>' + item.account + "</td>";	
					trHTML += '<td>' + item.curr + "</td>";
					trHTML += '<td>' + item.rate + "</td>";
					trHTML += '<td>' + item.amount + "</td>";
					trHTML += '<td>' + item.eqp_idr + "</td>";
					trHTML += '<td>' + item.tanggal_input + "</td>";
					trHTML += '<td>' + item.nama + "</td>";	
					trHTML += '<td><button id="print_inv" name="print_inv" type="button" class="btn btn-primary btn-sm" onclick="print_alokasi(' + item.id + ')"><i class="fa fa-print"></i> Print</button> </td>';
				// trHTML += '<td><button type="button" class="btn btn-sm btn-primary swalDefaultError" href="javascript:void(0)" onclick="getType3(\'' + item.supp + '\',\'' + item.no_kwt + '\',\'' + item.total + '\',\'' + item.bilang + '\')">Update</button> ' + '' 
				// + ' <button id="print_inv" name="print_inv" type="button" class="btn btn-primary btn-sm" onclick="print_kwitansi(' + item.id + ')"><i class="fa fa-print"></i> Print</button> ' + ''
				// + ' <button type="button" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="cancel_kwt(\'' + item.no_kwt + '\', \'' + item.status + '\')">Cancel</button></td> </td>';
				
				trHTML += '</tr>';

			});

				$('#table-kwitansi').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	

	}

	function export_list_alokasi() { 		
		var id_customer = $('#customer').val();	
		window.open(".../../export_excel_list_alokasi/" + dt_dari_kwt  + "/" + dt_sampai_kwt  + "/" + "/" + id_customer + "/" ); 
	}


	function view_alok(id, kwt){ 

		var no_kwt  = id;

		$('#txt_view').val(kwt);
	// $('#id_kwitansi').val(no_kwt);
	// $('#id_bppb').val(shipp_number);
	cari_view_alokasi(no_kwt);
	// $('#modal-view-kwt').modal('show');  

}

function cari_view_alokasi(no_kwt) { 

	$('#table-view-kwt tbody tr').remove();	
		//Date range picker		

		$.ajax({		
			url: "cari_view_alokasi/" + no_kwt + "/" ,					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 								
					trHTML += '<tr>';					
					trHTML += '<td>' + item.coa_name + "</td>";
					trHTML += '<td>' + item.cost_name + "</td>";	
					trHTML += '<td>' + item.supplier + "</td>";
					trHTML += '<td>' + item.no_ref + "</td>";
					trHTML += '<td>' + item.ref_date + "</td>";
					trHTML += '<td>' + item.due_date + "</td>";
					trHTML += '<td>' + item.curr + "</td>";
					trHTML += '<td>' + item.eqp_idr + "</td>";
					trHTML += '<td>' + item.amount + "</td>";
					trHTML += '<td>' + item.ost + "</td>";	
					trHTML += '<td>' + item.keterangan + "</td>";
					trHTML += '</tr>';
				// trHTML += '<td>' + item.curr +' '+ item.total + "</td>";

			});


				$('#table-view-kwt').append(trHTML);	
				$('#modal-view-kwt').modal('show');			

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	

	}

	function print_alokasi(id) {

	//var id_bank = $('#bank').val(); 	
	//window.open("http://localhost/ar-nag/arnag/report_invoice/" + id + "/" );  
	//window.open("http://localhost/ar-nag/arnag/report_invoice2/" + id + "/" ); 
	//window.open("http://10.10.2.179/ar-nag/arnag/report_invoice3/" + id + "/" + id_bank + "/" );  	
	window.open(".../../report_invoice5/" + id + "/" );  	

}

function cari_kartu_ar() { 

	$('#table-sales-local tbody tr').remove();
	$('#table-sales-export tbody tr').remove();
	$('#table-summary-sales tbody tr').remove();
	$('#table-dn-local tbody tr').remove();
	$('#table-dn-export tbody tr').remove();
	$('#table-summary-dn tbody tr').remove();
	$('#table-summary-sales-dn tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_inv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_inv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_inv   = "undefined";
			dt_sampai_inv = "undefined";
		});

		var id_cus = $('#customer').val();
		const currentMonth = new Date(dt_sampai_inv);
		var tahun  = currentMonth.getFullYear()
		var bulan1 = currentMonth.getMonth();
		var bulan2 = currentMonth.getMonth() + 1;
		var bulan3 = currentMonth.getMonth() + 2;
		var bulan4 = currentMonth.getMonth() + 3;
		var bulan5 = currentMonth.getMonth() + 4;
		var bulan6 = currentMonth.getMonth() + 5;
		if (bulan1 > 11) {
			var tahun_1 = tahun +1;
		}else{
			var tahun_1 = tahun;
		}
		if (bulan2 > 11) {
			var tahun_2 = tahun +1;
		}else{
			var tahun_2 = tahun;
		}
		if (bulan3 > 11) {
			var tahun_3 = tahun +1;
		}else{
			var tahun_3 = tahun;
		}
		if (bulan4 > 11) {
			var tahun_4 = tahun +1;
		}else{
			var tahun_4 = tahun;
		}
		if (bulan5 > 11) {
			var tahun_5 = tahun +1;
		}else{
			var tahun_5 = tahun;
		}
		if (bulan6 > 11) {
			var tahun_6 = tahun +1;
		}else{
			var tahun_6 = tahun;
		}
		const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		var bulan_1 =  months[bulan1]; 
		var bulan_2 =  months[bulan2]; 
		var bulan_3 =  months[bulan3]; 
		var bulan_4 =  months[bulan4]; 
		var bulan_5 =  months[bulan5]; 
		var bulan_6 =  months[bulan6]; 		

		$.ajax({		
			url: "cari_summary_ar/" + dt_dari_inv + "/" + dt_sampai_inv + "/" + id_cus + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				bayar = 0;
				bayar_ = 0;
				sal_awl = 0;
				sal_awl_ = 0;
				tambah = 0;
				tambah_ = 0;
				total = 0;
				total_ = 0;
				byr_idr = 0;
				byr_usd = 0;
				ahr_usd = 0;
				ahr_idr = 0;
				eqv_idr = 0;
				sum_foreign_curr = 0;
				sum_eqv_idr = 0;
				sum_not_due = 0;
				sum_amt_aging_1 = 0;
				sum_amt_aging_2 = 0;
				sum_amt_aging_3 = 0;
				sum_amt_aging_4 = 0;
				sum_amt_aging_5 = 0;
				sum_amt_aging_6 = 0;
				sum_amt_aging_7 = 0;
				sum_tot_aging = 0;
				sum_ready_due = 0;
				sum_jml_bln1 = 0;
				sum_jml_bln2 = 0;
				sum_jml_bln3 = 0;
				sum_jml_bln4 = 0;
				sum_jml_bln5 = 0;
				sum_jml_bln6 = 0;
				sum_tot_aging2 = 0;

				trHTML += '<tr>';
				trHTML += '<th colspan="23">Account Receivable</th>';
				trHTML += '</tr>';
				trHTML += '<tr>';
				trHTML += '<th colspan="23">Local Sales</th>';
				trHTML += '</tr>';
				$.each(response, function (i, item) {
					if (item.foreign_curr <= 0 && item.eqv_idr <= 0 ) {

					}	else{	

						if (item.shipp == 'Local') {
							sum_foreign_curr += parseFloat(item.foreign_curr); 
							sum_eqv_idr += parseFloat(item.eqv_idr);
							sum_not_due += parseFloat(item.not_due);
							sum_amt_aging_1 += parseFloat(item.amt_aging_1);
							sum_amt_aging_2 += parseFloat(item.amt_aging_2);
							sum_amt_aging_3 += parseFloat(item.amt_aging_3);
							sum_amt_aging_4 += parseFloat(item.amt_aging_4);
							sum_amt_aging_5 += parseFloat(item.amt_aging_5);
							sum_amt_aging_6 += parseFloat(item.amt_aging_6);
							sum_amt_aging_7 += parseFloat(item.amt_aging_7);
							sum_tot_aging += parseFloat(item.tot_aging);
							sum_ready_due += parseFloat(item.ready_due);
							sum_jml_bln1 += parseFloat(item.jml_bln1);
							sum_jml_bln2 += parseFloat(item.jml_bln2);
							sum_jml_bln3 += parseFloat(item.jml_bln3);
							sum_jml_bln4 += parseFloat(item.jml_bln4);
							sum_jml_bln5 += parseFloat(item.jml_bln5);
							sum_jml_bln6 += parseFloat(item.jml_bln6);
							sum_tot_aging2 += parseFloat(item.tot_aging2);

							trHTML += '<tr>';					
							trHTML += '<td>' + item.customer + "</td>";
							trHTML += '<td>' + item.curr + "</td>";
							trHTML += '<td>' + formatMoney(item.foreign_curr) + "</td>";
							trHTML += '<td>' + formatMoney(item.eqv_idr) + "</td>";	
							trHTML += '<td></td>';
							trHTML += '<td>' + formatMoney(item.not_due) + "</td>";
							trHTML += '<td>' + formatMoney(item.amt_aging_1) + "</td>";
							trHTML += '<td>' + formatMoney(item.amt_aging_2) + "</td>";
							trHTML += '<td>' + formatMoney(item.amt_aging_3) + "</td>";
							trHTML += '<td>' + formatMoney(item.amt_aging_4) + "</td>";
							trHTML += '<td>' + formatMoney(item.amt_aging_5) + "</td>";
							trHTML += '<td>' + formatMoney(item.amt_aging_6) + "</td>";
							trHTML += '<td>' + formatMoney(item.amt_aging_7) + "</td>";
							trHTML += '<td>' + formatMoney(item.tot_aging) + "</td>";
							trHTML += '<td></td>';
							trHTML += '<td>' + formatMoney(item.ready_due) + "</td>";
							trHTML += '<td>' + formatMoney(item.jml_bln1) + "</td>";
							trHTML += '<td>' + formatMoney(item.jml_bln2) + "</td>";
							trHTML += '<td>' + formatMoney(item.jml_bln3) + "</td>";
							trHTML += '<td>' + formatMoney(item.jml_bln4) + "</td>";
							trHTML += '<td>' + formatMoney(item.jml_bln5) + "</td>";
							trHTML += '<td>' + formatMoney(item.jml_bln6) + "</td>";
							trHTML += '<td>' + formatMoney(item.tot_aging2) + "</td>";
							trHTML += '</tr>';
						}			
					}
				});
				trHTML += '<tr>';					
				trHTML += '<th colspan="2">Total Account Receivable Local</th>';
				trHTML += '<th>' + formatMoney(sum_foreign_curr) + "</th>";
				trHTML += '<th>' + formatMoney(sum_eqv_idr) + "</th>";	
				trHTML += '<td></td>';
				trHTML += '<th>' + formatMoney(sum_not_due) + "</th>";
				trHTML += '<th>' + formatMoney(sum_amt_aging_1) + "</th>";
				trHTML += '<th>' + formatMoney(sum_amt_aging_2) + "</th>";
				trHTML += '<th>' + formatMoney(sum_amt_aging_3) + "</th>";
				trHTML += '<th>' + formatMoney(sum_amt_aging_4) + "</th>";
				trHTML += '<th>' + formatMoney(sum_amt_aging_5) + "</th>";
				trHTML += '<th>' + formatMoney(sum_amt_aging_6) + "</th>";
				trHTML += '<th>' + formatMoney(sum_amt_aging_7) + "</th>";
				trHTML += '<th>' + formatMoney(sum_tot_aging) + "</th>";
				trHTML += '<td></td>';
				trHTML += '<th>' + formatMoney(sum_ready_due) + "</th>";
				trHTML += '<th>' + formatMoney(sum_jml_bln1) + "</th>";
				trHTML += '<th>' + formatMoney(sum_jml_bln2) + "</th>";
				trHTML += '<th>' + formatMoney(sum_jml_bln3) + "</th>";
				trHTML += '<th>' + formatMoney(sum_jml_bln4) + "</th>";
				trHTML += '<th>' + formatMoney(sum_jml_bln5) + "</th>";
				trHTML += '<th>' + formatMoney(sum_jml_bln6) + "</th>";
				trHTML += '<th>' + formatMoney(sum_tot_aging2) + "</th>";
				trHTML += '</tr>';

				$('#table-sales-local').append(trHTML);	
				$('#bulan_1').val(bulan_1 + ' ' + tahun_1);
				$('#bulan_2').val(bulan_2 + ' ' + tahun_2);
				$('#bulan_3').val(bulan_3 + ' ' + tahun_3);
				$('#bulan_4').val(bulan_4 + ' ' + tahun_4);
				$('#bulan_5').val(bulan_5 + ' ' + tahun_5);
				$('#bulan_6').val(bulan_6 + ' ' + tahun_6);			
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(errorThrown);
			}
		});	


$.ajax({		
	url: "cari_summary_ar/" + dt_dari_inv + "/" + dt_sampai_inv + "/" + id_cus + "/",					
	type: "GET",
	dataType: "JSON",
	success: function (response) {

		var trHTML = '';
		bayar = 0;
		bayar_ = 0;
		sal_awl = 0;
		sal_awl_ = 0;
		tambah = 0;
		tambah_ = 0;
		total = 0;
		total_ = 0;
		byr_idr = 0;
		byr_usd = 0;
		ahr_usd = 0;
		ahr_idr = 0;
		eqv_idr = 0;
		sum_foreign_curr = 0;
		sum_eqv_idr = 0;
		sum_not_due = 0;
		sum_amt_aging_1 = 0;
		sum_amt_aging_2 = 0;
		sum_amt_aging_3 = 0;
		sum_amt_aging_4 = 0;
		sum_amt_aging_5 = 0;
		sum_amt_aging_6 = 0;
		sum_amt_aging_7 = 0;
		sum_tot_aging = 0;
		sum_ready_due = 0;
		sum_jml_bln1 = 0;
		sum_jml_bln2 = 0;
		sum_jml_bln3 = 0;
		sum_jml_bln4 = 0;
		sum_jml_bln5 = 0;
		sum_jml_bln6 = 0;
		sum_tot_aging2 = 0;

		trHTML += '<tr>';
		trHTML += '<th colspan="23"></th>';
		trHTML += '</tr>';
		trHTML += '<tr>';
		trHTML += '<th colspan="23">Export Sales</th>';
		trHTML += '</tr>';
		$.each(response, function (i, item) {
			if (item.foreign_curr <= 0 && item.eqv_idr <= 0 ) {

			}	else{	

				if (item.shipp == 'Export') {
					sum_foreign_curr += parseFloat(item.foreign_curr); 
					sum_eqv_idr += parseFloat(item.eqv_idr);
					sum_not_due += parseFloat(item.not_due);
					sum_amt_aging_1 += parseFloat(item.amt_aging_1);
					sum_amt_aging_2 += parseFloat(item.amt_aging_2);
					sum_amt_aging_3 += parseFloat(item.amt_aging_3);
					sum_amt_aging_4 += parseFloat(item.amt_aging_4);
					sum_amt_aging_5 += parseFloat(item.amt_aging_5);
					sum_amt_aging_6 += parseFloat(item.amt_aging_6);
					sum_amt_aging_7 += parseFloat(item.amt_aging_7);
					sum_tot_aging += parseFloat(item.tot_aging);
					sum_ready_due += parseFloat(item.ready_due);
					sum_jml_bln1 += parseFloat(item.jml_bln1);
					sum_jml_bln2 += parseFloat(item.jml_bln2);
					sum_jml_bln3 += parseFloat(item.jml_bln3);
					sum_jml_bln4 += parseFloat(item.jml_bln4);
					sum_jml_bln5 += parseFloat(item.jml_bln5);
					sum_jml_bln6 += parseFloat(item.jml_bln6);
					sum_tot_aging2 += parseFloat(item.tot_aging2);

					trHTML += '<tr>';					
					trHTML += '<td>' + item.customer + "</td>";
					trHTML += '<td>' + item.curr + "</td>";
					trHTML += '<td>' + formatMoney(item.foreign_curr) + "</td>";
					trHTML += '<td>' + formatMoney(item.eqv_idr) + "</td>";	
					trHTML += '<td></td>';
					trHTML += '<td>' + formatMoney(item.not_due) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_1) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_2) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_3) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_4) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_5) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_6) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_7) + "</td>";
					trHTML += '<td>' + formatMoney(item.tot_aging) + "</td>";
					trHTML += '<td></td>';
					trHTML += '<td>' + formatMoney(item.ready_due) + "</td>";
					trHTML += '<td>' + formatMoney(item.jml_bln1) + "</td>";
					trHTML += '<td>' + formatMoney(item.jml_bln2) + "</td>";
					trHTML += '<td>' + formatMoney(item.jml_bln3) + "</td>";
					trHTML += '<td>' + formatMoney(item.jml_bln4) + "</td>";
					trHTML += '<td>' + formatMoney(item.jml_bln5) + "</td>";
					trHTML += '<td>' + formatMoney(item.jml_bln6) + "</td>";
					trHTML += '<td>' + formatMoney(item.tot_aging2) + "</td>";
					trHTML += '</tr>';
				}			
			}
		});
		trHTML += '<tr>';					
		trHTML += '<th colspan="2">Total Account Receivable Export</th>';
		trHTML += '<th>' + formatMoney(sum_foreign_curr) + "</th>";
		trHTML += '<th>' + formatMoney(sum_eqv_idr) + "</th>";	
		trHTML += '<td></td>';
		trHTML += '<th>' + formatMoney(sum_not_due) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_1) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_2) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_3) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_4) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_5) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_6) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_7) + "</th>";
		trHTML += '<th>' + formatMoney(sum_tot_aging) + "</th>";
		trHTML += '<td></td>';
		trHTML += '<th>' + formatMoney(sum_ready_due) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln1) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln2) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln3) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln4) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln5) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln6) + "</th>";
		trHTML += '<th>' + formatMoney(sum_tot_aging2) + "</th>";
		trHTML += '</tr>';

		$('#table-sales-export').append(trHTML);			
	},
	error: function (jqXHR, textStatus, errorThrown) {
		alert(errorThrown);
	}
});	


$.ajax({		
	url: "cari_summary_ar/" + dt_dari_inv + "/" + dt_sampai_inv + "/" + id_cus + "/",					
	type: "GET",
	dataType: "JSON",
	success: function (response) {

		var trHTML = '';
		bayar = 0;
		bayar_ = 0;
		sal_awl = 0;
		sal_awl_ = 0;
		tambah = 0;
		tambah_ = 0;
		total = 0;
		total_ = 0;
		byr_idr = 0;
		byr_usd = 0;
		ahr_usd = 0;
		ahr_idr = 0;
		eqv_idr = 0;
		sum_foreign_curr = 0;
		sum_eqv_idr = 0;
		sum_not_due = 0;
		sum_amt_aging_1 = 0;
		sum_amt_aging_2 = 0;
		sum_amt_aging_3 = 0;
		sum_amt_aging_4 = 0;
		sum_amt_aging_5 = 0;
		sum_amt_aging_6 = 0;
		sum_amt_aging_7 = 0;
		sum_tot_aging = 0;
		sum_ready_due = 0;
		sum_jml_bln1 = 0;
		sum_jml_bln2 = 0;
		sum_jml_bln3 = 0;
		sum_jml_bln4 = 0;
		sum_jml_bln5 = 0;
		sum_jml_bln6 = 0;
		sum_tot_aging2 = 0;

		trHTML += '<tr>';
		trHTML += '<th colspan="23"></th>';
		trHTML += '</tr>';
		$.each(response, function (i, item) {
			if (item.foreign_curr <= 0 && item.eqv_idr <= 0 ) {

			}	else{	

				sum_foreign_curr += parseFloat(item.foreign_curr); 
				sum_eqv_idr += parseFloat(item.eqv_idr);
				sum_not_due += parseFloat(item.not_due);
				sum_amt_aging_1 += parseFloat(item.amt_aging_1);
				sum_amt_aging_2 += parseFloat(item.amt_aging_2);
				sum_amt_aging_3 += parseFloat(item.amt_aging_3);
				sum_amt_aging_4 += parseFloat(item.amt_aging_4);
				sum_amt_aging_5 += parseFloat(item.amt_aging_5);
				sum_amt_aging_6 += parseFloat(item.amt_aging_6);
				sum_amt_aging_7 += parseFloat(item.amt_aging_7);
				sum_tot_aging += parseFloat(item.tot_aging);
				sum_ready_due += parseFloat(item.ready_due);
				sum_jml_bln1 += parseFloat(item.jml_bln1);
				sum_jml_bln2 += parseFloat(item.jml_bln2);
				sum_jml_bln3 += parseFloat(item.jml_bln3);
				sum_jml_bln4 += parseFloat(item.jml_bln4);
				sum_jml_bln5 += parseFloat(item.jml_bln5);
				sum_jml_bln6 += parseFloat(item.jml_bln6);
				sum_tot_aging2 += parseFloat(item.tot_aging2);
			}
		});
		trHTML += '<tr>';					
		trHTML += '<th colspan="3">Total Account Receivable</th>';
		trHTML += '<th>' + formatMoney(sum_eqv_idr) + "</th>";	
		trHTML += '<td></td>';
		trHTML += '<th>' + formatMoney(sum_not_due) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_1) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_2) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_3) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_4) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_5) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_6) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_7) + "</th>";
		trHTML += '<th>' + formatMoney(sum_tot_aging) + "</th>";
		trHTML += '<td></td>';
		trHTML += '<th>' + formatMoney(sum_ready_due) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln1) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln2) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln3) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln4) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln5) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln6) + "</th>";
		trHTML += '<th>' + formatMoney(sum_tot_aging2) + "</th>";
		trHTML += '</tr>';

		$('#table-summary-sales').append(trHTML);			
	},
	error: function (jqXHR, textStatus, errorThrown) {
		alert(errorThrown);
	}
});	

$.ajax({		
	url: "cari_summary_dn/" + dt_dari_inv + "/" + dt_sampai_inv + "/" + id_cus + "/",					
	type: "GET",
	dataType: "JSON",
	success: function (response) {

		var trHTML = '';
		bayar = 0;
		bayar_ = 0;
		sal_awl = 0;
		sal_awl_ = 0;
		tambah = 0;
		tambah_ = 0;
		total = 0;
		total_ = 0;
		byr_idr = 0;
		byr_usd = 0;
		ahr_usd = 0;
		ahr_idr = 0;
		eqv_idr = 0;
		sum_foreign_curr = 0;
		sum_eqv_idr = 0;
		sum_not_due = 0;
		sum_amt_aging_1 = 0;
		sum_amt_aging_2 = 0;
		sum_amt_aging_3 = 0;
		sum_amt_aging_4 = 0;
		sum_amt_aging_5 = 0;
		sum_amt_aging_6 = 0;
		sum_amt_aging_7 = 0;
		sum_tot_aging = 0;
		sum_ready_due = 0;
		sum_jml_bln1 = 0;
		sum_jml_bln2 = 0;
		sum_jml_bln3 = 0;
		sum_jml_bln4 = 0;
		sum_jml_bln5 = 0;
		sum_jml_bln6 = 0;
		sum_tot_aging2 = 0;

		trHTML += '<tr>';
		trHTML += '<th colspan="23"></th>';
		trHTML += '</tr>';
		trHTML += '<tr>';
		trHTML += '<th colspan="23">Other Receivable (Debit Note)</th>';
		trHTML += '</tr>';
		trHTML += '<tr>';
		trHTML += '<th colspan="23">Local Debit Note</th>';
		trHTML += '</tr>';
		$.each(response, function (i, item) {
			console.log(item);
			if (item.foreign_curr <= 0 && item.eqv_idr <= 0 ) {

			}	else{	

				if (item.from_curr == 'IDR') {
					sum_foreign_curr += parseFloat(item.foreign_curr); 
					sum_eqv_idr += parseFloat(item.eqv_idr);
					sum_not_due += parseFloat(item.not_due);
					sum_amt_aging_1 += parseFloat(item.amt_aging_1);
					sum_amt_aging_2 += parseFloat(item.amt_aging_2);
					sum_amt_aging_3 += parseFloat(item.amt_aging_3);
					sum_amt_aging_4 += parseFloat(item.amt_aging_4);
					sum_amt_aging_5 += parseFloat(item.amt_aging_5);
					sum_amt_aging_6 += parseFloat(item.amt_aging_6);
					sum_amt_aging_7 += parseFloat(item.amt_aging_7);
					sum_tot_aging += parseFloat(item.tot_aging);
					sum_ready_due += parseFloat(item.ready_due);
					sum_jml_bln1 += parseFloat(item.jml_bln1);
					sum_jml_bln2 += parseFloat(item.jml_bln2);
					sum_jml_bln3 += parseFloat(item.jml_bln3);
					sum_jml_bln4 += parseFloat(item.jml_bln4);
					sum_jml_bln5 += parseFloat(item.jml_bln5);
					sum_jml_bln6 += parseFloat(item.jml_bln6);
					sum_tot_aging2 += parseFloat(item.tot_aging2);

					trHTML += '<tr>';					
					trHTML += '<td>' + item.customer + "</td>";
					trHTML += '<td>' + item.from_curr + "</td>";
					trHTML += '<td>' + formatMoney(item.foreign_curr) + "</td>";
					trHTML += '<td>' + formatMoney(item.eqv_idr) + "</td>";	
					trHTML += '<td></td>';
					trHTML += '<td>' + formatMoney(item.not_due) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_1) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_2) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_3) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_4) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_5) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_6) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_7) + "</td>";
					trHTML += '<td>' + formatMoney(item.tot_aging) + "</td>";
					trHTML += '<td></td>';
					trHTML += '<td>' + formatMoney(item.ready_due) + "</td>";
					trHTML += '<td>' + formatMoney(item.jml_bln1) + "</td>";
					trHTML += '<td>' + formatMoney(item.jml_bln2) + "</td>";
					trHTML += '<td>' + formatMoney(item.jml_bln3) + "</td>";
					trHTML += '<td>' + formatMoney(item.jml_bln4) + "</td>";
					trHTML += '<td>' + formatMoney(item.jml_bln5) + "</td>";
					trHTML += '<td>' + formatMoney(item.jml_bln6) + "</td>";
					trHTML += '<td>' + formatMoney(item.tot_aging2) + "</td>";
					trHTML += '</tr>';
				}			
			}
		});
		trHTML += '<tr>';					
		trHTML += '<th colspan="2">Total Other Receivable Local</th>';
		trHTML += '<th>' + formatMoney(sum_foreign_curr) + "</th>";
		trHTML += '<th>' + formatMoney(sum_eqv_idr) + "</th>";	
		trHTML += '<td></td>';
		trHTML += '<th>' + formatMoney(sum_not_due) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_1) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_2) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_3) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_4) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_5) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_6) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_7) + "</th>";
		trHTML += '<th>' + formatMoney(sum_tot_aging) + "</th>";
		trHTML += '<td></td>';
		trHTML += '<th>' + formatMoney(sum_ready_due) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln1) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln2) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln3) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln4) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln5) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln6) + "</th>";
		trHTML += '<th>' + formatMoney(sum_tot_aging2) + "</th>";
		trHTML += '</tr>';

		$('#table-dn-local').append(trHTML);			
	},
	error: function (jqXHR, textStatus, errorThrown) {
		alert(errorThrown);
	}
});

$.ajax({		
	url: "cari_summary_dn/" + dt_dari_inv + "/" + dt_sampai_inv + "/" + id_cus + "/",					
	type: "GET",
	dataType: "JSON",
	success: function (response) {

		var trHTML = '';
		bayar = 0;
		bayar_ = 0;
		sal_awl = 0;
		sal_awl_ = 0;
		tambah = 0;
		tambah_ = 0;
		total = 0;
		total_ = 0;
		byr_idr = 0;
		byr_usd = 0;
		ahr_usd = 0;
		ahr_idr = 0;
		eqv_idr = 0;
		sum_foreign_curr = 0;
		sum_eqv_idr = 0;
		sum_not_due = 0;
		sum_amt_aging_1 = 0;
		sum_amt_aging_2 = 0;
		sum_amt_aging_3 = 0;
		sum_amt_aging_4 = 0;
		sum_amt_aging_5 = 0;
		sum_amt_aging_6 = 0;
		sum_amt_aging_7 = 0;
		sum_tot_aging = 0;
		sum_ready_due = 0;
		sum_jml_bln1 = 0;
		sum_jml_bln2 = 0;
		sum_jml_bln3 = 0;
		sum_jml_bln4 = 0;
		sum_jml_bln5 = 0;
		sum_jml_bln6 = 0;
		sum_tot_aging2 = 0;

		trHTML += '<tr>';
		trHTML += '<th colspan="23"></th>';
		trHTML += '</tr>';
		trHTML += '<tr>';
		trHTML += '<th colspan="23">Export Debit Note</th>';
		trHTML += '</tr>';
		$.each(response, function (i, item) {
			console.log(item);
			if (item.foreign_curr <= 0 && item.eqv_idr <= 0 ) {

			}	else{	

				if (item.from_curr == 'USD') {
					sum_foreign_curr += parseFloat(item.foreign_curr); 
					sum_eqv_idr += parseFloat(item.eqv_idr);
					sum_not_due += parseFloat(item.not_due);
					sum_amt_aging_1 += parseFloat(item.amt_aging_1);
					sum_amt_aging_2 += parseFloat(item.amt_aging_2);
					sum_amt_aging_3 += parseFloat(item.amt_aging_3);
					sum_amt_aging_4 += parseFloat(item.amt_aging_4);
					sum_amt_aging_5 += parseFloat(item.amt_aging_5);
					sum_amt_aging_6 += parseFloat(item.amt_aging_6);
					sum_amt_aging_7 += parseFloat(item.amt_aging_7);
					sum_tot_aging += parseFloat(item.tot_aging);
					sum_ready_due += parseFloat(item.ready_due);
					sum_jml_bln1 += parseFloat(item.jml_bln1);
					sum_jml_bln2 += parseFloat(item.jml_bln2);
					sum_jml_bln3 += parseFloat(item.jml_bln3);
					sum_jml_bln4 += parseFloat(item.jml_bln4);
					sum_jml_bln5 += parseFloat(item.jml_bln5);
					sum_jml_bln6 += parseFloat(item.jml_bln6);
					sum_tot_aging2 += parseFloat(item.tot_aging2);

					trHTML += '<tr>';					
					trHTML += '<td>' + item.customer + "</td>";
					trHTML += '<td>' + item.from_curr + "</td>";
					trHTML += '<td>' + formatMoney(item.foreign_curr) + "</td>";
					trHTML += '<td>' + formatMoney(item.eqv_idr) + "</td>";	
					trHTML += '<td></td>';
					trHTML += '<td>' + formatMoney(item.not_due) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_1) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_2) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_3) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_4) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_5) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_6) + "</td>";
					trHTML += '<td>' + formatMoney(item.amt_aging_7) + "</td>";
					trHTML += '<td>' + formatMoney(item.tot_aging) + "</td>";
					trHTML += '<td></td>';
					trHTML += '<td>' + formatMoney(item.ready_due) + "</td>";
					trHTML += '<td>' + formatMoney(item.jml_bln1) + "</td>";
					trHTML += '<td>' + formatMoney(item.jml_bln2) + "</td>";
					trHTML += '<td>' + formatMoney(item.jml_bln3) + "</td>";
					trHTML += '<td>' + formatMoney(item.jml_bln4) + "</td>";
					trHTML += '<td>' + formatMoney(item.jml_bln5) + "</td>";
					trHTML += '<td>' + formatMoney(item.jml_bln6) + "</td>";
					trHTML += '<td>' + formatMoney(item.tot_aging2) + "</td>";
					trHTML += '</tr>';
				}			
			}
		});
		trHTML += '<tr>';					
		trHTML += '<th colspan="2">Total Other Receivable Export</th>';
		trHTML += '<th>' + formatMoney(sum_foreign_curr) + "</th>";
		trHTML += '<th>' + formatMoney(sum_eqv_idr) + "</th>";	
		trHTML += '<td></td>';
		trHTML += '<th>' + formatMoney(sum_not_due) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_1) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_2) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_3) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_4) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_5) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_6) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_7) + "</th>";
		trHTML += '<th>' + formatMoney(sum_tot_aging) + "</th>";
		trHTML += '<td></td>';
		trHTML += '<th>' + formatMoney(sum_ready_due) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln1) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln2) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln3) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln4) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln5) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln6) + "</th>";
		trHTML += '<th>' + formatMoney(sum_tot_aging2) + "</th>";
		trHTML += '</tr>';

		$('#table-dn-export').append(trHTML);			
	},
	error: function (jqXHR, textStatus, errorThrown) {
		alert(errorThrown);
	}
});

$.ajax({		
	url: "cari_summary_dn/" + dt_dari_inv + "/" + dt_sampai_inv + "/" + id_cus + "/",					
	type: "GET",
	dataType: "JSON",
	success: function (response) {

		var trHTML = '';
		bayar = 0;
		bayar_ = 0;
		sal_awl = 0;
		sal_awl_ = 0;
		tambah = 0;
		tambah_ = 0;
		total = 0;
		total_ = 0;
		byr_idr = 0;
		byr_usd = 0;
		ahr_usd = 0;
		ahr_idr = 0;
		eqv_idr = 0;
		sum_foreign_curr = 0;
		sum_eqv_idr = 0;
		sum_not_due = 0;
		sum_amt_aging_1 = 0;
		sum_amt_aging_2 = 0;
		sum_amt_aging_3 = 0;
		sum_amt_aging_4 = 0;
		sum_amt_aging_5 = 0;
		sum_amt_aging_6 = 0;
		sum_amt_aging_7 = 0;
		sum_tot_aging = 0;
		sum_ready_due = 0;
		sum_jml_bln1 = 0;
		sum_jml_bln2 = 0;
		sum_jml_bln3 = 0;
		sum_jml_bln4 = 0;
		sum_jml_bln5 = 0;
		sum_jml_bln6 = 0;
		sum_tot_aging2 = 0;

		trHTML += '<tr>';
		trHTML += '<th colspan="23"></th>';
		trHTML += '</tr>';
		$.each(response, function (i, item) {
			if (item.foreign_curr <= 0 && item.eqv_idr <= 0 ) {

			}	else{	

				sum_foreign_curr += parseFloat(item.foreign_curr); 
				sum_eqv_idr += parseFloat(item.eqv_idr);
				sum_not_due += parseFloat(item.not_due);
				sum_amt_aging_1 += parseFloat(item.amt_aging_1);
				sum_amt_aging_2 += parseFloat(item.amt_aging_2);
				sum_amt_aging_3 += parseFloat(item.amt_aging_3);
				sum_amt_aging_4 += parseFloat(item.amt_aging_4);
				sum_amt_aging_5 += parseFloat(item.amt_aging_5);
				sum_amt_aging_6 += parseFloat(item.amt_aging_6);
				sum_amt_aging_7 += parseFloat(item.amt_aging_7);
				sum_tot_aging += parseFloat(item.tot_aging);
				sum_ready_due += parseFloat(item.ready_due);
				sum_jml_bln1 += parseFloat(item.jml_bln1);
				sum_jml_bln2 += parseFloat(item.jml_bln2);
				sum_jml_bln3 += parseFloat(item.jml_bln3);
				sum_jml_bln4 += parseFloat(item.jml_bln4);
				sum_jml_bln5 += parseFloat(item.jml_bln5);
				sum_jml_bln6 += parseFloat(item.jml_bln6);
				sum_tot_aging2 += parseFloat(item.tot_aging2);
			}
		});
		trHTML += '<tr>';					
		trHTML += '<th colspan="3">Total Other Receivable</th>';
		trHTML += '<th>' + formatMoney(sum_eqv_idr) + "</th>";	
		trHTML += '<td></td>';
		trHTML += '<th>' + formatMoney(sum_not_due) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_1) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_2) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_3) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_4) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_5) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_6) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_7) + "</th>";
		trHTML += '<th>' + formatMoney(sum_tot_aging) + "</th>";
		trHTML += '<td></td>';
		trHTML += '<th>' + formatMoney(sum_ready_due) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln1) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln2) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln3) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln4) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln5) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln6) + "</th>";
		trHTML += '<th>' + formatMoney(sum_tot_aging2) + "</th>";
		trHTML += '</tr>';

		$('#table-summary-dn').append(trHTML);			
	},
	error: function (jqXHR, textStatus, errorThrown) {
		alert(errorThrown);
	}
});	


$.ajax({		
	url: "cari_summary_all/" + dt_dari_inv + "/" + dt_sampai_inv + "/" + id_cus + "/",					
	type: "GET",
	dataType: "JSON",
	success: function (response) {

		var trHTML = '';
		bayar = 0;
		bayar_ = 0;
		sal_awl = 0;
		sal_awl_ = 0;
		tambah = 0;
		tambah_ = 0;
		total = 0;
		total_ = 0;
		byr_idr = 0;
		byr_usd = 0;
		ahr_usd = 0;
		ahr_idr = 0;
		eqv_idr = 0;
		sum_foreign_curr = 0;
		sum_eqv_idr = 0;
		sum_not_due = 0;
		sum_amt_aging_1 = 0;
		sum_amt_aging_2 = 0;
		sum_amt_aging_3 = 0;
		sum_amt_aging_4 = 0;
		sum_amt_aging_5 = 0;
		sum_amt_aging_6 = 0;
		sum_amt_aging_7 = 0;
		sum_tot_aging = 0;
		sum_ready_due = 0;
		sum_jml_bln1 = 0;
		sum_jml_bln2 = 0;
		sum_jml_bln3 = 0;
		sum_jml_bln4 = 0;
		sum_jml_bln5 = 0;
		sum_jml_bln6 = 0;
		sum_tot_aging2 = 0;

		trHTML += '<tr>';
		trHTML += '<th colspan="23"></th>';
		trHTML += '</tr>';
		$.each(response, function (i, item) {
			if (item.foreign_curr <= 0 && item.eqv_idr <= 0 ) {

			}	else{	

				sum_foreign_curr += parseFloat(item.foreign_curr); 
				sum_eqv_idr += parseFloat(item.eqv_idr);
				sum_not_due += parseFloat(item.not_due);
				sum_amt_aging_1 += parseFloat(item.amt_aging_1);
				sum_amt_aging_2 += parseFloat(item.amt_aging_2);
				sum_amt_aging_3 += parseFloat(item.amt_aging_3);
				sum_amt_aging_4 += parseFloat(item.amt_aging_4);
				sum_amt_aging_5 += parseFloat(item.amt_aging_5);
				sum_amt_aging_6 += parseFloat(item.amt_aging_6);
				sum_amt_aging_7 += parseFloat(item.amt_aging_7);
				sum_tot_aging += parseFloat(item.tot_aging);
				sum_ready_due += parseFloat(item.ready_due);
				sum_jml_bln1 += parseFloat(item.jml_bln1);
				sum_jml_bln2 += parseFloat(item.jml_bln2);
				sum_jml_bln3 += parseFloat(item.jml_bln3);
				sum_jml_bln4 += parseFloat(item.jml_bln4);
				sum_jml_bln5 += parseFloat(item.jml_bln5);
				sum_jml_bln6 += parseFloat(item.jml_bln6);
				sum_tot_aging2 += parseFloat(item.tot_aging2);
			}
		});
		trHTML += '<tr>';					
		trHTML += '<th colspan="3">Grand Total Receivable</th>';
		trHTML += '<th>' + formatMoney(sum_eqv_idr) + "</th>";	
		trHTML += '<td></td>';
		trHTML += '<th>' + formatMoney(sum_not_due) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_1) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_2) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_3) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_4) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_5) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_6) + "</th>";
		trHTML += '<th>' + formatMoney(sum_amt_aging_7) + "</th>";
		trHTML += '<th>' + formatMoney(sum_tot_aging) + "</th>";
		trHTML += '<td></td>';
		trHTML += '<th>' + formatMoney(sum_ready_due) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln1) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln2) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln3) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln4) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln5) + "</th>";
		trHTML += '<th>' + formatMoney(sum_jml_bln6) + "</th>";
		trHTML += '<th>' + formatMoney(sum_tot_aging2) + "</th>";
		trHTML += '</tr>';

		$('#table-summary-sales-dn').append(trHTML);			
	},
	error: function (jqXHR, textStatus, errorThrown) {
		alert(errorThrown);
	}
});	

}

function cari_kartu_ar2() { 

	$('#table-kartu_ar2 tbody tr').remove();
		// $('#bulan_1').val("");
		// $('#bulan_2').val('');
		// $('#bulan_3').val('');
		// $('#bulan_4').val('');
		// $('#bulan_5').val('');
		// $('#bulan_6').val('');	
		//Date range picker
		$('input[name="cobacoba"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="cobacoba"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_alk = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_alk = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="cobacoba"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_alk   = "undefined";
			dt_sampai_alk = "undefined";
		});

		var id_cus = $('#customer').val();
		const currentMonth = new Date(dt_sampai_alk);
		var tahun  = currentMonth.getFullYear()
		var bulan1 = currentMonth.getMonth();
		var bulan2 = currentMonth.getMonth() + 1;
		var bulan3 = currentMonth.getMonth() + 2;
		var bulan4 = currentMonth.getMonth() + 3;
		var bulan5 = currentMonth.getMonth() + 4;
		var bulan6 = currentMonth.getMonth() + 5;
		if (bulan1 > 11) {
			var tahun_1 = tahun +1;
		}else{
			var tahun_1 = tahun;
		}
		if (bulan2 > 11) {
			var tahun_2 = tahun +1;
		}else{
			var tahun_2 = tahun;
		}
		if (bulan3 > 11) {
			var tahun_3 = tahun +1;
		}else{
			var tahun_3 = tahun;
		}
		if (bulan4 > 11) {
			var tahun_4 = tahun +1;
		}else{
			var tahun_4 = tahun;
		}
		if (bulan5 > 11) {
			var tahun_5 = tahun +1;
		}else{
			var tahun_5 = tahun;
		}
		if (bulan6 > 11) {
			var tahun_6 = tahun +1;
		}else{
			var tahun_6 = tahun;
		}
		const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		var bulan_1 =  months[bulan1]; 
		var bulan_2 =  months[bulan2]; 
		var bulan_3 =  months[bulan3]; 
		var bulan_4 =  months[bulan4]; 
		var bulan_5 =  months[bulan5]; 
		var bulan_6 =  months[bulan6]; 		

		$.ajax({		
			url: "cari_kartu_ar2/" + dt_dari_alk + "/" + dt_sampai_alk + "/" + id_cus + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				bayar = 0;
				bayar_ = 0;
				sal_awl = 0;
				sal_awl_ = 0;
				tambah = 0;
				tambah_ = 0;
				total = 0;
				total_ = 0;
				byr_idr = 0;
				byr_usd = 0;
				ahr_usd = 0;
				ahr_idr = 0;
				eqv_idr = 0;
				amt_aging_0 = 0;
				amt_aging_1 = 0;
				amt_aging_2 = 0;
				amt_aging_3 = 0;
				amt_aging_4 = 0;
				amt_aging_5 = 0;
				amt_aging_6 = 0;
				amt_aging_7 = 0;
				tot_aging = 0;
				rate = 0;
				tot_aging2 = 0;
				readydue = 0;
				jml_bln1 = 0;
				jml_bln2 = 0;
				jml_bln3 = 0;
				jml_bln4 = 0;
				jml_bln5 = 0;
				jml_bln6 = 0;
				kata = '';
				eqv_idr_ = 0;
				amt_aging_0_ = 0;
				amt_aging_1_ = 0;
				amt_aging_2_ = 0;
				amt_aging_3_ = 0;
				amt_aging_4_ = 0;
				amt_aging_5_ = 0;
				amt_aging_6_ = 0;
				amt_aging_7_ = 0;
				tot_aging_ = 0;
				readydue_ = 0;
				jml_bln1_ = 0;
				jml_bln2_ = 0;
				jml_bln3_ = 0;
				jml_bln4_ = 0;
				jml_bln5_ = 0;
				jml_bln6_ = 0;
				tot_aging__ = 0;

				$.each(response, function (i, item) { 
					if(item.inv_date >= dt_dari_alk){
						sal_awl = 0;
					}	
					else{
						sal_awl = parseFloat(item.amount1 - item.bayar2);
					}

					if(item.inv_date >= dt_dari_alk){
						tambah = parseFloat(item.amount1 - item.bayar2);
					}	
					else{
						tambah = 0;
					}

					total = (sal_awl + tambah) - item.bayar;
					total_ += total;
					bayar = parseFloat(item.bayar);
					bayar_ += bayar;
					console.log(item.bayar);
					tambah_ += tambah;
					kata = 'Total';

					if(item.curr == 'USD'){
						eqv_idr =((sal_awl + tambah) - item.bayar) * item.rate;
						rate = item.rate;
					}	
					else{
						eqv_idr = (sal_awl + tambah) - item.bayar;
						rate = 1;
					}

					if (item.jml_bln1 > 0 && item.duedate > dt_dari_alk) {
						jml_bln1 = eqv_idr;
					}else{
						jml_bln1 = 0;
					}
					if (item.jml_bln2 <= 0) {
						jml_bln2 = 0;
					}else{
						jml_bln2 = eqv_idr;
					}
					if (item.jml_bln3 <= 0) {
						jml_bln3 = 0;
					}else{
						jml_bln3 = eqv_idr;
					}
					if (item.jml_bln4 <= 0) {
						jml_bln4 = 0;
					}else{
						jml_bln4 = eqv_idr;
					}
					if (item.jml_bln5 <= 0) {
						jml_bln5 = 0;
					}else{
						jml_bln5 = eqv_idr;
					}
					if (item.jml_bln6 <= 0) {
						jml_bln6 = 0;
					}else{
						jml_bln6 = eqv_idr;
					}

					if (total <= '0') {
						amt_aging_0 = 0;
						amt_aging_1 = 0;
						amt_aging_2 = 0;
						amt_aging_3 = 0;
						amt_aging_4 = 0;
						amt_aging_5 = 0;
						amt_aging_6 = 0;
						amt_aging_7 = 0;
						tot_aging = 0;
						tot_aging2 = 0;
						readydue = 0;

					}else{
						if(item.duedate <= dt_dari_alk){
							readydue = eqv_idr;
						}else{
							readydue = 0;
						}
						tot_aging2 = eqv_idr;
						if (item.diff_top <= 0) {
							amt_aging_0 = eqv_idr;
							amt_aging_1 = 0;
							amt_aging_2 = 0;
							amt_aging_3 = 0;
							amt_aging_4 = 0;
							amt_aging_5 = 0;
							amt_aging_6 = 0;
							amt_aging_7 = 0;
							tot_aging = eqv_idr;
						}

						if (item.diff_top > 0 && item.diff_top <= 30) {
							amt_aging_0 = 0;
							amt_aging_1 = eqv_idr;
							amt_aging_2 = 0;
							amt_aging_3 = 0;
							amt_aging_4 = 0;
							amt_aging_5 = 0;
							amt_aging_6 = 0;
							amt_aging_7 = 0;
							tot_aging = eqv_idr;
						}

						if (item.diff_top > 30 && item.diff_top <= 60) {
							amt_aging_0 = 0;
							amt_aging_1 = 0;
							amt_aging_2 = eqv_idr;
							amt_aging_3 = 0;
							amt_aging_4 = 0;
							amt_aging_5 = 0;
							amt_aging_6 = 0;
							amt_aging_7 = 0;
							tot_aging = eqv_idr;
						}

						if (item.diff_top > 60 && item.diff_top <= 90) {
							amt_aging_0 = 0;
							amt_aging_1 = 0;
							amt_aging_2 = 0;
							amt_aging_3 = eqv_idr;
							amt_aging_4 = 0;
							amt_aging_5 = 0;
							amt_aging_6 = 0;
							amt_aging_7 = 0;
							tot_aging = eqv_idr;
						}

						if (item.diff_top > 90 && item.diff_top <= 120) {
							amt_aging_0 = 0;
							amt_aging_1 = 0;
							amt_aging_2 = 0;
							amt_aging_3 = 0;
							amt_aging_4 = eqv_idr;
							amt_aging_5 = 0;
							amt_aging_6 = 0;
							amt_aging_7 = 0;
							tot_aging = eqv_idr;
						}

						if (item.diff_top > 120 && item.diff_top <= 180) {
							amt_aging_0 = 0;
							amt_aging_1 = 0;
							amt_aging_2 = 0;
							amt_aging_3 = 0;
							amt_aging_4 = 0;
							amt_aging_5 = eqv_idr;
							amt_aging_6 = 0;
							amt_aging_7 = 0;
							tot_aging = eqv_idr;
						}

						if (item.diff_top > 180 && item.diff_top <= 360) {
							amt_aging_0 = 0;
							amt_aging_1 = 0;
							amt_aging_2 = 0;
							amt_aging_3 = 0;
							amt_aging_4 = 0;
							amt_aging_5 = 0;
							amt_aging_6 = eqv_idr;
							amt_aging_7 = 0;
							tot_aging = eqv_idr;
						}

						if (item.diff_top > 360) {
							amt_aging_0 = 0;
							amt_aging_1 = 0;
							amt_aging_2 = 0;
							amt_aging_3 = 0;
							amt_aging_4 = 0;
							amt_aging_5 = 0;
							amt_aging_6 = 0;
							amt_aging_7 = eqv_idr;
							tot_aging = eqv_idr;
						}

					}

					amt_aging_0_ += amt_aging_0;
					amt_aging_1_ += amt_aging_1;
					amt_aging_2_ += amt_aging_2;
					amt_aging_3_ += amt_aging_3;
					amt_aging_4_ += amt_aging_4;
					amt_aging_5_ += amt_aging_5;
					amt_aging_6_ += amt_aging_6;
					amt_aging_7_ += amt_aging_7;
					tot_aging_ = amt_aging_0_ + amt_aging_1_ + amt_aging_2_ + amt_aging_3_ + amt_aging_4_ + amt_aging_5_ + amt_aging_6_ + amt_aging_7_;
					readydue_ += readydue;
					jml_bln1_ += jml_bln1;
					jml_bln2_ += jml_bln2;
					jml_bln3_ += jml_bln3;
					jml_bln4_ += jml_bln4;
					jml_bln5_ += jml_bln5;
					jml_bln6_ += jml_bln6;
					tot_aging__ = readydue_ + jml_bln1_ + jml_bln2_ + jml_bln3_ + jml_bln4_ + jml_bln5_ + jml_bln6_;


			// ahr_usd = (sal_usd + tot_usd) - byr_usd;
			// ahr_idr = (sal_idr + tot_idr) - byr_idr;

			if (sal_awl <= 0 && tambah <= 0 && item.bayar <= 0 && total <= 0) {

			}	else{

				eqv_idr_ += eqv_idr;
				sal_awl_ += sal_awl;				

				trHTML += '<tr>';					
				trHTML += '<td>' + item.customer + "</td>";
				trHTML += '<td>' + item.no_invoice + "</td>";	
				trHTML += '<td>' + item.inv_date + "</td>";
				trHTML += '<td>' + item.shipp + "</td>";
				trHTML += '<td>' + item.duedate + "</td>";
				trHTML += '<td>' + item.top + "</td>";
				trHTML += '<td>' + item.curr + "</td>";
				trHTML += '<td>' + formatMoney(rate) + "</td>";
				trHTML += '<td>' + formatMoney(sal_awl) + "</td>";
				trHTML += '<td>' + formatMoney(tambah) + "</td>";	
				trHTML += '<td>' + formatMoney(item.bayar) + "</td>";	
				trHTML += '<td>' + formatMoney(total) + "</td>";
				trHTML += '<td>' + formatMoney(eqv_idr) + "</td>";
				trHTML += '<td>' + formatMoney(amt_aging_0) + "</td>";
				trHTML += '<td>' + formatMoney(amt_aging_1) + "</td>";
				trHTML += '<td>' + formatMoney(amt_aging_2) + "</td>";
				trHTML += '<td>' + formatMoney(amt_aging_3) + "</td>";
				trHTML += '<td>' + formatMoney(amt_aging_4) + "</td>";
				trHTML += '<td>' + formatMoney(amt_aging_5) + "</td>";
				trHTML += '<td>' + formatMoney(amt_aging_6) + "</td>";
				trHTML += '<td>' + formatMoney(amt_aging_7) + "</td>";
				trHTML += '<td>' + formatMoney(tot_aging) + "</td>";
				trHTML += '<td></td>';
				trHTML += '<td>' + formatMoney(readydue) + "</td>";
				trHTML += '<td>' + formatMoney(jml_bln1) + "</td>";
				trHTML += '<td>' + formatMoney(jml_bln2) + "</td>";
				trHTML += '<td>' + formatMoney(jml_bln3) + "</td>";
				trHTML += '<td>' + formatMoney(jml_bln4) + "</td>";
				trHTML += '<td>' + formatMoney(jml_bln5) + "</td>";
				trHTML += '<td>' + formatMoney(jml_bln6) + "</td>";
				trHTML += '<td>' + formatMoney(tot_aging) + "</td>";
				trHTML += '</tr>';
			}
		});
trHTML += '<tr>';					
trHTML += '<th colspan="8" style="text-align: center">' +kata+ "</th>";
trHTML += '<th>' + formatMoney(sal_awl_) + "</th>";
trHTML += '<th>' + formatMoney(tambah_) + "</th>";	
trHTML += '<th>' + formatMoney(bayar_) + "</th>";	
trHTML += '<th>' + formatMoney(total_) + "</th>";
trHTML += '<th>' + formatMoney(eqv_idr_) + "</th>";
trHTML += '<th>' + formatMoney(amt_aging_0_) + "</th>";
trHTML += '<th>' + formatMoney(amt_aging_1_) + "</th>";
trHTML += '<th>' + formatMoney(amt_aging_2_) + "</th>";	
trHTML += '<th>' + formatMoney(amt_aging_3_) + "</th>";	
trHTML += '<th>' + formatMoney(amt_aging_4_) + "</th>";
trHTML += '<th>' + formatMoney(amt_aging_5_) + "</th>";
trHTML += '<th>' + formatMoney(amt_aging_6_) + "</th>";	
trHTML += '<th>' + formatMoney(amt_aging_7_) + "</th>";	
trHTML += '<th>' + formatMoney(tot_aging_) + "</th>";
trHTML += '<th></th>';
trHTML += '<th>' + formatMoney(readydue_) + "</th>";
trHTML += '<th>' + formatMoney(jml_bln1_) + "</th>";	
trHTML += '<th>' + formatMoney(jml_bln2_) + "</th>";	
trHTML += '<th>' + formatMoney(jml_bln3_) + "</th>";
trHTML += '<th>' + formatMoney(jml_bln4_) + "</th>";
trHTML += '<th>' + formatMoney(jml_bln5_) + "</th>";	
trHTML += '<th>' + formatMoney(jml_bln6_) + "</th>";	
trHTML += '<th>' + formatMoney(tot_aging__) + "</th>";
trHTML += '</tr>';

$('#table-kartu_ar2').append(trHTML);	
$('#bulan_1').val(bulan_1 + ' ' + tahun_1);
$('#bulan_2').val(bulan_2 + ' ' + tahun_2);
$('#bulan_3').val(bulan_3 + ' ' + tahun_3);
$('#bulan_4').val(bulan_4 + ' ' + tahun_4);
$('#bulan_5').val(bulan_5 + ' ' + tahun_5);
$('#bulan_6').val(bulan_6 + ' ' + tahun_6);			
},
error: function (jqXHR, textStatus, errorThrown) {
	alert(errorThrown);
}
});	

}

//ubah september
function cari_mutasi_invoice_dp() { 

	$('#table-mutasi_invoicedp tbody tr').remove();	
		//Date range picker
		$('input[name="cobacoba"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="cobacoba"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_alk = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_alk = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="cobacoba"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_alk   = "undefined";
			dt_sampai_alk = "undefined";
		});

		var id_cus = $('#customer').val();	
		console.log(dt_dari_alk + dt_sampai_alk)

		

		$.ajax({		
			url: "cari_mutasi_invoice_dp/" + dt_dari_alk + "/" + dt_sampai_alk + "/" + id_cus + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				bayar = 0;
				bayar2 = 0;
				bayar_ = 0;
				sal_awl = 0;
				sal_awl_ = 0;
				tambah = 0;
				tambah_ = 0;
				total = 0;
				total_ = 0;
				byr_idr = 0;
				byr_usd = 0;
				ahr_usd = 0;
				ahr_idr = 0;
				kata = '';
				$.each(response, function (i, item) {
					if (item.bayar2 == '') {
						bayar2 = 0;
					}else{
						bayar2 = item.bayar2;
					}

					if(item.inv_date >= dt_dari_alk){
						sal_awl = 0;
					}	
					else{
						sal_awl = parseFloat(item.amount1 - bayar2);
					}

					if(item.inv_date >= dt_dari_alk){
						tambah = parseFloat(item.amount1 - bayar2);
					}	
					else{
						tambah = 0;
					}

					sal_awl_ += sal_awl;
					total = (sal_awl + tambah) - item.bayar;
					total_ += total;
					bayar = parseFloat(item.bayar);
					bayar_ += bayar;
					tambah_ += tambah;
					kata = 'Total';


			// ahr_usd = (sal_usd + tot_usd) - byr_usd;
			// ahr_idr = (sal_idr + tot_idr) - byr_idr;

			if (sal_awl == '0' && tambah == '0' && item.bayar == '0' && total == '0') {

			}	else{				

				trHTML += '<tr>';					
				trHTML += '<td>' + item.customer + "</td>";
				trHTML += '<td>' + item.no_invoice + "</td>";	
				trHTML += '<td>' + item.inv_date + "</td>";
				trHTML += '<td>' + item.duedate + "</td>";
				trHTML += '<td>' + item.top + "</td>";
				trHTML += '<td>' + item.curr + "</td>";
				trHTML += '<td>' + formatMoney(item.amount1) + "</td>";
				trHTML += '<td>' + formatMoney(tambah) + "</td>";	
				trHTML += '<td>' + formatMoney(item.bayar) + "</td>";	
				trHTML += '<td>' + formatMoney(total) + "</td>";
				trHTML += '</tr>';
			}
		});
			// trHTML += '<tr>';					
			// 	trHTML += '<td colspan="5" style="text-align: center">' +kata+ "</td>";
			// 	trHTML += '<td>' + formatMoney(sal_awl_) + "</td>";
			// 	trHTML += '<td>' + formatMoney(tambah_) + "</td>";	
			// 	trHTML += '<td>' + formatMoney(bayar_) + "</td>";	
			// 	trHTML += '<td>' + formatMoney(total_) + "</td>";
			// 	trHTML += '</tr>';

			$('#table-mutasi_invoicedp').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	

	}


//ubah september
function cari_mutasi_debit_note() { 

	$('#table-mutasi_debitnote tbody tr').remove();	
		//Date range picker
		$('input[name="cobacoba3"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="cobacoba3"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_debnote = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_debnote = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="cobacoba3"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_debnote   = "undefined";
			dt_sampai_debnote = "undefined";
		});

		var id_cus = $('#customer').val();	
		console.log(dt_dari_debnote + dt_sampai_debnote + id_cus);
		const currentMonth = new Date(dt_sampai_debnote);
		var tahun  = currentMonth.getFullYear()
		var bulan1 = currentMonth.getMonth();
		var bulan2 = currentMonth.getMonth() + 1;
		var bulan3 = currentMonth.getMonth() + 2;
		var bulan4 = currentMonth.getMonth() + 3;
		var bulan5 = currentMonth.getMonth() + 4;
		var bulan6 = currentMonth.getMonth() + 5;
		if (bulan1 > 11) {
			var tahun_1 = tahun +1;
		}else{
			var tahun_1 = tahun;
		}
		if (bulan2 > 11) {
			var tahun_2 = tahun +1;
		}else{
			var tahun_2 = tahun;
		}
		if (bulan3 > 11) {
			var tahun_3 = tahun +1;
		}else{
			var tahun_3 = tahun;
		}
		if (bulan4 > 11) {
			var tahun_4 = tahun +1;
		}else{
			var tahun_4 = tahun;
		}
		if (bulan5 > 11) {
			var tahun_5 = tahun +1;
		}else{
			var tahun_5 = tahun;
		}
		if (bulan6 > 11) {
			var tahun_6 = tahun +1;
		}else{
			var tahun_6 = tahun;
		}
		const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		var bulan_1 =  months[bulan1]; 
		var bulan_2 =  months[bulan2]; 
		var bulan_3 =  months[bulan3]; 
		var bulan_4 =  months[bulan4]; 
		var bulan_5 =  months[bulan5]; 
		var bulan_6 =  months[bulan6]; 	

		

		$.ajax({		
			url: "cari_mutasi_debit_note/" + dt_dari_debnote + "/" + dt_sampai_debnote + "/" + id_cus + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				bayar = 0;
				bayar2 = 0;
				bayar_ = 0;
				sal_awl = 0;
				sal_awl_ = 0;
				tambah = 0;
				tambah_ = 0;
				total = 0;
				total_ = 0;
				byr_idr = 0;
				byr_usd = 0;
				ahr_usd = 0;
				ahr_idr = 0;
				kata = '';
				eqv_idr = 0;
				amt_aging_0 = 0;
				amt_aging_1 = 0;
				amt_aging_2 = 0;
				amt_aging_3 = 0;
				amt_aging_4 = 0;
				amt_aging_5 = 0;
				amt_aging_6 = 0;
				amt_aging_7 = 0;
				tot_aging = 0;
				tot_aging2 = 0;
				readydue = 0;
				jml_bln1 = 0;
				jml_bln2 = 0;
				jml_bln3 = 0;
				jml_bln4 = 0;
				jml_bln5 = 0;
				jml_bln6 = 0;

				eqv_idr_ = 0;
				amt_aging_0_ = 0;
				amt_aging_1_ = 0;
				amt_aging_2_ = 0;
				amt_aging_3_ = 0;
				amt_aging_4_ = 0;
				amt_aging_5_ = 0;
				amt_aging_6_ = 0;
				amt_aging_7_ = 0;
				tot_aging_ = 0;
				readydue_ = 0;
				jml_bln1_ = 0;
				jml_bln2_ = 0;
				jml_bln3_ = 0;
				jml_bln4_ = 0;
				jml_bln5_ = 0;
				jml_bln6_ = 0;
				tot_aging__ = 0;
				$.each(response, function (i, item) {
					console.log(item);
					if (item.bayar2 == '') {
						bayar2 = 0;
					}else{
						bayar2 = item.bayar2;
					}

					if(item.inv_date >= dt_dari_debnote){
						sal_awl = 0;
					}	
					else{
						sal_awl = parseFloat(item.amount1 - bayar2);
					}

					if(item.inv_date >= dt_dari_debnote){
						tambah = parseFloat(item.amount1 - bayar2);
					}	
					else{
						tambah = 0;
					}

					sal_awl_ += sal_awl;
					total = (sal_awl + tambah) - item.bayar;
					total_ += total;
					bayar = parseFloat(item.bayar);
					bayar_ += bayar;
					tambah_ += tambah;
					kata = 'Total';

					eqv_idr =((sal_awl + tambah) - item.bayar) * item.rate;

					if (total <= '0') {
						amt_aging_0 = 0;
						amt_aging_1 = 0;
						amt_aging_2 = 0;
						amt_aging_3 = 0;
						amt_aging_4 = 0;
						amt_aging_5 = 0;
						amt_aging_6 = 0;
						amt_aging_7 = 0;
						tot_aging = 0;
						tot_aging2 = 0;
						readydue = 0;

					}else{
						if(item.duedate < dt_sampai_debnote){
							readydue = eqv_idr;
						}else{
							readydue = 0;
						}
						tot_aging2 = eqv_idr;
						if (item.diff_top <= 0) {
							amt_aging_0 = eqv_idr;
							amt_aging_1 = 0;
							amt_aging_2 = 0;
							amt_aging_3 = 0;
							amt_aging_4 = 0;
							amt_aging_5 = 0;
							amt_aging_6 = 0;
							amt_aging_7 = 0;
							tot_aging = eqv_idr;
						}

						if (item.diff_top > 0 && item.diff_top <= 30) {
							amt_aging_0 = 0;
							amt_aging_1 = eqv_idr;
							amt_aging_2 = 0;
							amt_aging_3 = 0;
							amt_aging_4 = 0;
							amt_aging_5 = 0;
							amt_aging_6 = 0;
							amt_aging_7 = 0;
							tot_aging = eqv_idr;
						}

						if (item.diff_top > 30 && item.diff_top <= 60) {
							amt_aging_0 = 0;
							amt_aging_1 = 0;
							amt_aging_2 = eqv_idr;
							amt_aging_3 = 0;
							amt_aging_4 = 0;
							amt_aging_5 = 0;
							amt_aging_6 = 0;
							amt_aging_7 = 0;
							tot_aging = eqv_idr;
						}

						if (item.diff_top > 60 && item.diff_top <= 90) {
							amt_aging_0 = 0;
							amt_aging_1 = 0;
							amt_aging_2 = 0;
							amt_aging_3 = eqv_idr;
							amt_aging_4 = 0;
							amt_aging_5 = 0;
							amt_aging_6 = 0;
							amt_aging_7 = 0;
							tot_aging = eqv_idr;
						}

						if (item.diff_top > 90 && item.diff_top <= 120) {
							amt_aging_0 = 0;
							amt_aging_1 = 0;
							amt_aging_2 = 0;
							amt_aging_3 = 0;
							amt_aging_4 = eqv_idr;
							amt_aging_5 = 0;
							amt_aging_6 = 0;
							amt_aging_7 = 0;
							tot_aging = eqv_idr;
						}

						if (item.diff_top > 120 && item.diff_top <= 180) {
							amt_aging_0 = 0;
							amt_aging_1 = 0;
							amt_aging_2 = 0;
							amt_aging_3 = 0;
							amt_aging_4 = 0;
							amt_aging_5 = eqv_idr;
							amt_aging_6 = 0;
							amt_aging_7 = 0;
							tot_aging = eqv_idr;
						}

						if (item.diff_top > 180 && item.diff_top <= 360) {
							amt_aging_0 = 0;
							amt_aging_1 = 0;
							amt_aging_2 = 0;
							amt_aging_3 = 0;
							amt_aging_4 = 0;
							amt_aging_5 = 0;
							amt_aging_6 = eqv_idr;
							amt_aging_7 = 0;
							tot_aging = eqv_idr;
						}

						if (item.diff_top > 360) {
							amt_aging_0 = 0;
							amt_aging_1 = 0;
							amt_aging_2 = 0;
							amt_aging_3 = 0;
							amt_aging_4 = 0;
							amt_aging_5 = 0;
							amt_aging_6 = 0;
							amt_aging_7 = eqv_idr;
							tot_aging = eqv_idr;
						}

					}

					if (item.jml_bln1 > 0 && item.duedate >= dt_sampai_debnote) {
						jml_bln1 = eqv_idr;
					}else{
						jml_bln1 = 0;
					}
					if (item.jml_bln2 <= 0) {
						jml_bln2 = 0;
					}else{
						jml_bln2 = eqv_idr;
					}
					if (item.jml_bln3 <= 0) {
						jml_bln3 = 0;
					}else{
						jml_bln3 = eqv_idr;
					}
					if (item.jml_bln4 <= 0) {
						jml_bln4 = 0;
					}else{
						jml_bln4 = eqv_idr;
					}
					if (item.jml_bln5 <= 0) {
						jml_bln5 = 0;
					}else{
						jml_bln5 = eqv_idr;
					}
					if (item.jml_bln6 <= 0) {
						jml_bln6 = 0;
					}else{
						jml_bln6 = eqv_idr;
					}


					eqv_idr_ += eqv_idr;
					amt_aging_0_ += amt_aging_0;
					amt_aging_1_ += amt_aging_1;
					amt_aging_2_ += amt_aging_2;
					amt_aging_3_ += amt_aging_3;
					amt_aging_4_ += amt_aging_4;
					amt_aging_5_ += amt_aging_5;
					amt_aging_6_ += amt_aging_6;
					amt_aging_7_ += amt_aging_7;
					tot_aging_ = amt_aging_0_ + amt_aging_1_ + amt_aging_2_ + amt_aging_3_ + amt_aging_4_ + amt_aging_5_ + amt_aging_6_ + amt_aging_7_;
					readydue_ += readydue;
					jml_bln1_ += jml_bln1;
					jml_bln2_ += jml_bln2;
					jml_bln3_ += jml_bln3;
					jml_bln4_ += jml_bln4;
					jml_bln5_ += jml_bln5;
					jml_bln6_ += jml_bln6;
					tot_aging__ = readydue_ + jml_bln1_ + jml_bln2_ + jml_bln3_ + jml_bln4_ + jml_bln5_ + jml_bln6_;


			// ahr_usd = (sal_usd + tot_usd) - byr_usd;
			// ahr_idr = (sal_idr + tot_idr) - byr_idr;

			if (sal_awl <= 0 && tambah <= 0 && item.bayar <= 0 && total <= 0) {

			}	else{				

				trHTML += '<tr>';					
				trHTML += '<td>' + item.customer + "</td>";
				trHTML += '<td>' + item.no_invoice + "</td>";	
				trHTML += '<td>' + item.inv_date + "</td>";
				trHTML += '<td>' + item.supplier + "</td>";
				trHTML += '<td>' + item.attn + "</td>";	
				trHTML += '<td>' + item.duedate + "</td>";
				trHTML += '<td>' + item.top + "</td>";
				trHTML += '<td>' + item.from_curr + "</td>";
				trHTML += '<td>' + formatMoney(item.rate) + "</td>";
				trHTML += '<td>' + formatMoney(sal_awl) + "</td>";
				trHTML += '<td>' + formatMoney(tambah) + "</td>";	
				trHTML += '<td>' + formatMoney(item.bayar) + "</td>";	
				trHTML += '<td>' + formatMoney(total) + "</td>";
				trHTML += '<td>' + formatMoney(eqv_idr) + "</td>";
				trHTML += '<td>' + formatMoney(amt_aging_0) + "</td>";
				trHTML += '<td>' + formatMoney(amt_aging_1) + "</td>";
				trHTML += '<td>' + formatMoney(amt_aging_2) + "</td>";
				trHTML += '<td>' + formatMoney(amt_aging_3) + "</td>";
				trHTML += '<td>' + formatMoney(amt_aging_4) + "</td>";
				trHTML += '<td>' + formatMoney(amt_aging_5) + "</td>";
				trHTML += '<td>' + formatMoney(amt_aging_6) + "</td>";
				trHTML += '<td>' + formatMoney(amt_aging_7) + "</td>";
				trHTML += '<td>' + formatMoney(tot_aging) + "</td>";
				trHTML += '<td></td>';
				trHTML += '<td>' + formatMoney(readydue) + "</td>";
				trHTML += '<td>' + formatMoney(jml_bln1) + "</td>";
				trHTML += '<td>' + formatMoney(jml_bln2) + "</td>";
				trHTML += '<td>' + formatMoney(jml_bln3) + "</td>";
				trHTML += '<td>' + formatMoney(jml_bln4) + "</td>";
				trHTML += '<td>' + formatMoney(jml_bln5) + "</td>";
				trHTML += '<td>' + formatMoney(jml_bln6) + "</td>";
				trHTML += '<td>' + formatMoney(tot_aging) + "</td>";
				trHTML += '</tr>';
			}
		});
trHTML += '<tr>';					
trHTML += '<th colspan="9" style="text-align: center">' +kata+ "</th>";
trHTML += '<th>' + formatMoney(sal_awl_) + "</th>";
trHTML += '<th>' + formatMoney(tambah_) + "</th>";	
trHTML += '<th>' + formatMoney(bayar_) + "</th>";	
trHTML += '<th>' + formatMoney(total_) + "</th>";
trHTML += '<th>' + formatMoney(eqv_idr_) + "</th>";
trHTML += '<th>' + formatMoney(amt_aging_0_) + "</th>";
trHTML += '<th>' + formatMoney(amt_aging_1_) + "</th>";
trHTML += '<th>' + formatMoney(amt_aging_2_) + "</th>";	
trHTML += '<th>' + formatMoney(amt_aging_3_) + "</th>";	
trHTML += '<th>' + formatMoney(amt_aging_4_) + "</th>";
trHTML += '<th>' + formatMoney(amt_aging_5_) + "</th>";
trHTML += '<th>' + formatMoney(amt_aging_6_) + "</th>";	
trHTML += '<th>' + formatMoney(amt_aging_7_) + "</th>";	
trHTML += '<th>' + formatMoney(tot_aging_) + "</th>";
trHTML += '<th></th>';
trHTML += '<th>' + formatMoney(readydue_) + "</th>";
trHTML += '<th>' + formatMoney(jml_bln1_) + "</th>";	
trHTML += '<th>' + formatMoney(jml_bln2_) + "</th>";	
trHTML += '<th>' + formatMoney(jml_bln3_) + "</th>";
trHTML += '<th>' + formatMoney(jml_bln4_) + "</th>";
trHTML += '<th>' + formatMoney(jml_bln5_) + "</th>";	
trHTML += '<th>' + formatMoney(jml_bln6_) + "</th>";	
trHTML += '<th>' + formatMoney(tot_aging__) + "</th>";
trHTML += '</tr>';

$('#table-mutasi_debitnote').append(trHTML);	
$('#bulan_1').val(bulan_1 + ' ' + tahun_1);
$('#bulan_2').val(bulan_2 + ' ' + tahun_2);
$('#bulan_3').val(bulan_3 + ' ' + tahun_3);
$('#bulan_4').val(bulan_4 + ' ' + tahun_4);
$('#bulan_5').val(bulan_5 + ' ' + tahun_5);
$('#bulan_6').val(bulan_6 + ' ' + tahun_6);			

},
error: function (jqXHR, textStatus, errorThrown) {
	alert('Error get data from ajax');
}
});	

}


function cari_invoice_manual_post(){ 
	
	$('#table-approval-invoice-manual tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_approv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_approv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_approv   = "undefined";
			dt_sampai_approv = "undefined";
		});

		$.ajax({		
			url: "cari_invoice_manual_post/" + dt_dari_approv + "/" + dt_sampai_approv + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 					
					trHTML += '<tr>';					
					trHTML += '<td>' + item.no_invoice + "</td>";					
					trHTML += '<td>' + item.customer + "</td>";	
					trHTML += '<td>' + item.shipp + "</td>";
					trHTML += '<td>' + item.doc_type + "</td>";
					trHTML += '<td>' + item.doc_number + "</td>";
					trHTML += '<td>' + item.inv_date + "</td>";	
					trHTML += '<td>' + item.type + "</td>";	
					trHTML += '<td>' + item.status + "</td>";	
					trHTML += '<td>' + item.id + "</td>";					
					trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_inv_mnl_approv" id="pilih_inv_mnl_approv" class="flat" value = ' + item.id + '></td>';										
				//trHTML += '<td><button id="approv_inv" name="approv_inv" type="button" class="btn btn-warning btn-sm" onclick="approve_invoice(\'' + item.no_invoice + '\' , \'' + item.id + '\')"><i class="fa fa-stamp"></i> Approved</td>';
				trHTML += '</tr>';

			});

				$('#table-approval-invoice-manual').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	
	}


	function approve_invoice_manual(){
	//
	var cek_inv = document.getElementsByName("pilih_inv_mnl_approv");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
				//   
				var id_inv = cek_inv[i].value
                //
                var formData = {
                	"id_inv": id_inv,			
                };
				//
				$.ajax({						
					url: "approve_invoice_manual/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				$('#modal-approve-invoice-manual').modal('hide');
				console.log(id_inv);  
				// window.location.reload();
				// cari_invoice_post();

				//
			} 
		}

	}

//  async function refresh(){
//    var result = await approve_invoice()
//    console.log(result);
//    alert("Approve Successfully");
//    cari_invoice_post();
// }

async function refresh_manual(){
	var result = await approve_invoice_manual()
	console.log(result);
	var cek_inv = document.getElementsByName("pilih_inv_mnl_approv");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
		    	var coba = parseInt(i + 1);		
		    }
		}
		alert(" Invoice Successfully Approved");
		cari_invoice_manual_post();
	}


	function modal_show_approve_invoice_manual() { 

		var cek_inv = document.getElementsByName("pilih_inv_mnl_approv");	
		for (var i = 0; i < cek_inv.length; i++) {
		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {				   
		    	$('#modal-approve-invoice-manual').modal('show');  
		    } 
		}	
	}


	function check_approv_invoice_manual(ele) { 

		var checkboxes = document.getElementsByTagName('input');
		if (ele.checked) {
			for (var i = 0; i < checkboxes.length; i++) {
				if (checkboxes[i].type == 'checkbox'  && !(checkboxes[i].disabled) ) {
					checkboxes[i].checked = true;
				}
			}
		} else {
			for (var i = 0; i < checkboxes.length; i++) {
				if (checkboxes[i].type == 'checkbox') {
					checkboxes[i].checked = false;
				}
			}
		}
	}


	function export_kartu_ar2() { 		
		var id_cus = $('#customer').val();
		const currentMonth = new Date(dt_sampai_alk);
		var tahun  = currentMonth.getFullYear()
		var bulan1 = currentMonth.getMonth();
		var bulan2 = currentMonth.getMonth() + 1;
		var bulan3 = currentMonth.getMonth() + 2;
		var bulan4 = currentMonth.getMonth() + 3;
		var bulan5 = currentMonth.getMonth() + 4;
		var bulan6 = currentMonth.getMonth() + 5;
		if (bulan1 > 11) {
			var tahun_1 = tahun +1;
		}else{
			var tahun_1 = tahun;
		}
		if (bulan2 > 11) {
			var tahun_2 = tahun +1;
		}else{
			var tahun_2 = tahun;
		}
		if (bulan3 > 11) {
			var tahun_3 = tahun +1;
		}else{
			var tahun_3 = tahun;
		}
		if (bulan4 > 11) {
			var tahun_4 = tahun +1;
		}else{
			var tahun_4 = tahun;
		}
		if (bulan5 > 11) {
			var tahun_5 = tahun +1;
		}else{
			var tahun_5 = tahun;
		}
		if (bulan6 > 11) {
			var tahun_6 = tahun +1;
		}else{
			var tahun_6 = tahun;
		}
		const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		var bulan_1 =  months[bulan1]; 
		var bulan_2 =  months[bulan2]; 
		var bulan_3 =  months[bulan3]; 
		var bulan_4 =  months[bulan4]; 
		var bulan_5 =  months[bulan5]; 
		var bulan_6 =  months[bulan6]; 

		$('#bulan_1').append(bulan_1 + ' ' + tahun_1);
		$('#bulan_2').append(bulan_2 + ' ' + tahun_2);
		$('#bulan_3').append(bulan_3 + ' ' + tahun_3);
		$('#bulan_4').append(bulan_4 + ' ' + tahun_4);
		$('#bulan_5').append(bulan_5 + ' ' + tahun_5);
		$('#bulan_6').append(bulan_6 + ' ' + tahun_6);		
		window.open(".../../export_excel_kartu_ar2/" + dt_dari_alk  + "/" + dt_sampai_alk  + "/" + "/" + id_cus + "/" + bulan_1  + "/" + bulan_2  + "/" + bulan_3  + "/" + bulan_4  + "/" + bulan_5  + "/" + bulan_6  + "/" + tahun_1  + "/" + tahun_2  + "/" + tahun_3  + "/" + tahun_4  + "/" + tahun_5  + "/" + tahun_6  + "/"); 
	}

//ubah september
function export_mutasi_debit_note() { 		
	var id_cus = $('#customer').val();	
	const currentMonth = new Date(dt_sampai_debnote);
	var tahun  = currentMonth.getFullYear()
	var bulan1 = currentMonth.getMonth();
	var bulan2 = currentMonth.getMonth() + 1;
	var bulan3 = currentMonth.getMonth() + 2;
	var bulan4 = currentMonth.getMonth() + 3;
	var bulan5 = currentMonth.getMonth() + 4;
	var bulan6 = currentMonth.getMonth() + 5;
	if (bulan1 > 11) {
		var tahun_1 = tahun +1;
	}else{
		var tahun_1 = tahun;
	}
	if (bulan2 > 11) {
		var tahun_2 = tahun +1;
	}else{
		var tahun_2 = tahun;
	}
	if (bulan3 > 11) {
		var tahun_3 = tahun +1;
	}else{
		var tahun_3 = tahun;
	}
	if (bulan4 > 11) {
		var tahun_4 = tahun +1;
	}else{
		var tahun_4 = tahun;
	}
	if (bulan5 > 11) {
		var tahun_5 = tahun +1;
	}else{
		var tahun_5 = tahun;
	}
	if (bulan6 > 11) {
		var tahun_6 = tahun +1;
	}else{
		var tahun_6 = tahun;
	}
	const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	var bulan_1 =  months[bulan1]; 
	var bulan_2 =  months[bulan2]; 
	var bulan_3 =  months[bulan3]; 
	var bulan_4 =  months[bulan4]; 
	var bulan_5 =  months[bulan5]; 
	var bulan_6 =  months[bulan6]; 

	$('#bulan_1').append(bulan_1 + ' ' + tahun_1);
	$('#bulan_2').append(bulan_2 + ' ' + tahun_2);
	$('#bulan_3').append(bulan_3 + ' ' + tahun_3);
	$('#bulan_4').append(bulan_4 + ' ' + tahun_4);
	$('#bulan_5').append(bulan_5 + ' ' + tahun_5);
	$('#bulan_6').append(bulan_6 + ' ' + tahun_6);		
	window.open(".../../export_excel_mutasi_debit_note/" + dt_dari_debnote  + "/" + dt_sampai_debnote  + "/" + "/" + id_cus + "/" + bulan_1  + "/" + bulan_2  + "/" + bulan_3  + "/" + bulan_4  + "/" + bulan_5  + "/" + bulan_6  + "/" + tahun_1  + "/" + tahun_2  + "/" + tahun_3  + "/" + tahun_4  + "/" + tahun_5  + "/" + tahun_6  + "/"); 
}

//ubah september
function export_mutasi_invoice_dp() { 		
	var id_cus = $('#customer').val();	
	window.open(".../../export_excel_mutasi_invoicedp/" + dt_dari_alk  + "/" + dt_sampai_alk  + "/" + "/" + id_cus + "/" ); 
}

function export_kartu_ar() { 		
	var id_customer = $('#customer').val();	
	const currentMonth = new Date(dt_sampai_inv);
	var tahun  = currentMonth.getFullYear()
	var bulan1 = currentMonth.getMonth();
	var bulan2 = currentMonth.getMonth() + 1;
	var bulan3 = currentMonth.getMonth() + 2;
	var bulan4 = currentMonth.getMonth() + 3;
	var bulan5 = currentMonth.getMonth() + 4;
	var bulan6 = currentMonth.getMonth() + 5;
	if (bulan1 > 11) {
		var tahun_1 = tahun +1;
	}else{
		var tahun_1 = tahun;
	}
	if (bulan2 > 11) {
		var tahun_2 = tahun +1;
	}else{
		var tahun_2 = tahun;
	}
	if (bulan3 > 11) {
		var tahun_3 = tahun +1;
	}else{
		var tahun_3 = tahun;
	}
	if (bulan4 > 11) {
		var tahun_4 = tahun +1;
	}else{
		var tahun_4 = tahun;
	}
	if (bulan5 > 11) {
		var tahun_5 = tahun +1;
	}else{
		var tahun_5 = tahun;
	}
	if (bulan6 > 11) {
		var tahun_6 = tahun +1;
	}else{
		var tahun_6 = tahun;
	}
	const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	var bulan_1 =  months[bulan1]; 
	var bulan_2 =  months[bulan2]; 
	var bulan_3 =  months[bulan3]; 
	var bulan_4 =  months[bulan4]; 
	var bulan_5 =  months[bulan5]; 
	var bulan_6 =  months[bulan6]; 

	$('#bulan_1').append(bulan_1 + ' ' + tahun_1);
	$('#bulan_2').append(bulan_2 + ' ' + tahun_2);
	$('#bulan_3').append(bulan_3 + ' ' + tahun_3);
	$('#bulan_4').append(bulan_4 + ' ' + tahun_4);
	$('#bulan_5').append(bulan_5 + ' ' + tahun_5);
	$('#bulan_6').append(bulan_6 + ' ' + tahun_6);		
	window.open(".../../export_excel_kartu_ar/" + dt_dari_inv  + "/" + dt_sampai_inv  + "/" + "/" + id_customer + "/" + bulan_1  + "/" + bulan_2  + "/" + bulan_3  + "/" + bulan_4  + "/" + bulan_5  + "/" + bulan_6  + "/" + tahun_1  + "/" + tahun_2  + "/" + tahun_3  + "/" + tahun_4  + "/" + tahun_5  + "/" + tahun_6  + "/"); 
}


function cari_invoice_appv(){ 
	
	$('#table-approval-invoice tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_approv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_approv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_approv   = "undefined";
			dt_sampai_approv = "undefined";
		});

		$.ajax({		
			url: "cari_invoice_appv/" + dt_dari_approv + "/" + dt_sampai_approv + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 					
					trHTML += '<tr>';					
					trHTML += '<td>' + item.no_invoice + "</td>";					
					trHTML += '<td>' + item.customer + "</td>";	
					trHTML += '<td>' + item.shipp + "</td>";
					trHTML += '<td>' + item.doc_type + "</td>";
					trHTML += '<td>' + item.doc_number + "</td>";
					trHTML += '<td>' + item.inv_date + "</td>";	
					trHTML += '<td>' + item.type + "</td>";	
					trHTML += '<td>' + item.status + "</td>";	
					trHTML += '<td>' + item.id + "</td>";					
					trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_inv_reverse" id="pilih_inv_approv" class="flat" value = ' + item.id + '></td>';										
				//trHTML += '<td><button id="approv_inv" name="approv_inv" type="button" class="btn btn-warning btn-sm" onclick="approve_invoice(\'' + item.no_invoice + '\' , \'' + item.id + '\')"><i class="fa fa-stamp"></i> Approved</td>';
				trHTML += '</tr>';

			});

				$('#table-approval-invoice').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	
	}


	function modal_show_reverse_invoice() { 

		var cek_inv = document.getElementsByName("pilih_inv_reverse");	
		for (var i = 0; i < cek_inv.length; i++) {
		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {				   
		    	$('#modal-reverse-invoice').modal('show');  
		    } 
		}	
	}

	function modal_show_reverse_alokasi() { 

		var cek_inv = document.getElementsByName("pilih_alokasi_approv");	
		for (var i = 0; i < cek_inv.length; i++) {
		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {				   
		    	$('#modal-reverse-alokasi').modal('show');  
		    } 
		}	
	}


	async function refresh_rvs(){
		var result = await rvs_invoice()
		console.log(result);
		var cek_inv = document.getElementsByName("pilih_inv_reverse");	
		for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
		    	var coba = parseInt(i + 1);		
		    }
		}
		alert("Invoice Successfully Reverse");
   // cari_invoice_appv();
}

async function refresh_rvs_alk(){
	var result = await rvs_alokasi()
	console.log(result);
	var cek_inv = document.getElementsByName("pilih_alokasi_approv");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
		    	var coba = parseInt(i + 1);		
		    }
		}
		alert("Alokasi Successfully Reverse");
   // cari_invoice_appv();
}


function rvs_alokasi(){
	//
	var cek_inv = document.getElementsByName("pilih_alokasi_approv");	
	var keter = $('[name="keter"]').val()	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
				//   
				var id_inv = cek_inv[i].value
                //
                var formData = {
                	"id_inv": id_inv,
                	"keter": keter,			
                };
				//
				$.ajax({						
					url: "rvs_alokasi/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				$('#modal-reverse-alokasi').modal('hide');
				console.log(id_inv);  
				window.location.reload();
				// cari_invoice_post();

				//
			} 
		}

	}


	function rvs_invoice(){
	//
	var cek_inv = document.getElementsByName("pilih_inv_reverse");	
	var keter = $('[name="keter"]').val()	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
				//   
				var id_inv = cek_inv[i].value
                //
                var formData = {
                	"id_inv": id_inv,
                	"keter": keter,			
                };
				//
				$.ajax({						
					url: "rvs_invoice/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				$('#modal-reverse-invoice').modal('hide');
				console.log(id_inv);  
				window.location.reload();
				// cari_invoice_post();

				//
			} 
		}

	}


	function cari_invoice_manual_appv(){ 

		$('#table-approval-invoice-manual tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_approv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_approv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_approv   = "undefined";
			dt_sampai_approv = "undefined";
		});

		$.ajax({		
			url: "cari_invoice_manual_appv/" + dt_dari_approv + "/" + dt_sampai_approv + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 					
					trHTML += '<tr>';					
					trHTML += '<td>' + item.no_invoice + "</td>";					
					trHTML += '<td>' + item.customer + "</td>";	
					trHTML += '<td>' + item.shipp + "</td>";
					trHTML += '<td>' + item.doc_type + "</td>";
					trHTML += '<td>' + item.doc_number + "</td>";
					trHTML += '<td>' + item.inv_date + "</td>";	
					trHTML += '<td>' + item.type + "</td>";	
					trHTML += '<td>' + item.status + "</td>";	
					trHTML += '<td>' + item.id + "</td>";					
					trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_inv_mnl_rvs" id="pilih_inv_mnl_approv" class="flat" value = ' + item.no_invoice + '></td>';										
				//trHTML += '<td><button id="approv_inv" name="approv_inv" type="button" class="btn btn-warning btn-sm" onclick="approve_invoice(\'' + item.no_invoice + '\' , \'' + item.id + '\')"><i class="fa fa-stamp"></i> Approved</td>';
				trHTML += '</tr>';

			});

				$('#table-approval-invoice-manual').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	
	}


	function modal_show_reverse_invoice_manual() { 

		var cek_inv = document.getElementsByName("pilih_inv_mnl_rvs");	
		for (var i = 0; i < cek_inv.length; i++) {
		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {				   
		    	$('#modal-reverse-invoice-manual').modal('show');  
		    } 
		}	
	}


	async function refresh_manual_rvs(){
		var result = await reverse_invoice_manual()
		console.log(result);
		var cek_inv = document.getElementsByName("pilih_inv_mnl_rvs");	
		for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
		    	var coba = parseInt(i + 1);		
		    }
		}
		alert(" Invoice Successfully Reverse");
   // cari_invoice_manual_appv();
}


function reverse_invoice_manual(){
	//
	var cek_inv = document.getElementsByName("pilih_inv_mnl_rvs");
	var keter = $('[name="keter"]').val()	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
				//   
				var id_inv = cek_inv[i].value
                //
                var formData = {
                	"id_inv": id_inv,
                	"keter": keter,			
                };
				//
				$.ajax({						
					url: "reverseinvoice_manual/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				$('#modal-reverse-invoice-manual').modal('hide');
				console.log(id_inv);  
				window.location.reload();
				// cari_invoice_post();

				//
			} 
		}

	}


	function cari_kwt_appv(){ 

		$('#table-kwt-rvs tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_approv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_approv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_approv   = "undefined";
			dt_sampai_approv = "undefined";
		});

		$.ajax({		
			url: "cari_kwt_appv/" + dt_dari_approv + "/" + dt_sampai_approv + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 					
					trHTML += '<tr>';					
					trHTML += '<td>' + item.no_kwt + "</td>";					
					trHTML += '<td>' + item.tgl_kwt + "</td>";	
					trHTML += '<td>' + item.supp + "</td>";
					trHTML += '<td>' + item.curr + ' '+ item.total + "</td>";
					trHTML += '<td>' + item.bilang + "</td>";
					trHTML += '<td>' + item.status + "</td>";	
					trHTML += '<td>' + item.id + "</td>";					
					trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_kwt_rvs" id="pilih_kwt_rvs" class="flat" value = ' + item.no_kwt + '></td>';										
				//trHTML += '<td><button id="approv_inv" name="approv_inv" type="button" class="btn btn-warning btn-sm" onclick="approve_invoice(\'' + item.no_invoice + '\' , \'' + item.id + '\')"><i class="fa fa-stamp"></i> Approved</td>';
				trHTML += '</tr>';

			});

				$('#table-kwt-rvs').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	
	}

	function modal_show_reverse_kwt() { 

		var cek_inv = document.getElementsByName("pilih_kwt_rvs");	
		for (var i = 0; i < cek_inv.length; i++) {
		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {				   
		    	$('#modal-reverse-kwt').modal('show');  
		    } 
		}	
	}

	async function refresh_rvs_kwt(){
		var result = await reverse_kwt()
		console.log(result);
		var cek_inv = document.getElementsByName("pilih_kwt_rvs");	
		for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
		    	var coba = parseInt(i + 1);		
		    }
		}
		alert(" Invoice Successfully Reverse");
   // cari_invoice_manual_appv();
}


function reverse_kwt(){
	//
	var cek_inv = document.getElementsByName("pilih_kwt_rvs");
	var keter = $('[name="keter"]').val()	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
				//   
				var id_inv = cek_inv[i].value
                //
                var formData = {
                	"id_inv": id_inv,
                	"keter": keter,			
                };
				//
				$.ajax({						
					url: "reverse_kwt/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				$('#modal-reverse-kwt').modal('hide');
				console.log(id_inv);  
				window.location.reload();
				// cari_invoice_post();

				//
			} 
		}

	}


	function cari_alokasi_appv(){ 

		$('#table-alokasi-rvs tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_approv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_approv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_approv   = "undefined";
			dt_sampai_approv = "undefined";
		});

		$.ajax({		
			url: "cari_alokasi_appv/" + dt_dari_approv + "/" + dt_sampai_approv + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 					
					trHTML += '<tr>';					
					trHTML += '<td>' + item.no_alk + "</td>";					
					trHTML += '<td>' + item.tgl_alk + "</td>";	
					trHTML += '<td>' + item.supplier + "</td>";
					trHTML += '<td>' + item.doc_number + "</td>";
					trHTML += '<td>' + item.bank + "</td>";	
					trHTML += '<td>' + item.account + "</td>";	
					trHTML += '<td>' + item.curr + "</td>";	
					trHTML += '<td>' + item.amount + "</td>";	
					trHTML += '<td>' + item.id + "</td>";					
					trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_alokasi_approv" id="pilih_alokasi_approv" class="flat" value = ' + item.no_alk + '></td>';										
				//trHTML += '<td><button id="approv_inv" name="approv_inv" type="button" class="btn btn-warning btn-sm" onclick="approve_invoice(\'' + item.no_invoice + '\' , \'' + item.id + '\')"><i class="fa fa-stamp"></i> Approved</td>';
				trHTML += '</tr>';

			});

				$('#table-alokasi-rvs').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	
	}



	function simpankwitansi() { 

		return new Promise(resolve => {		
			setTimeout(() => {
				var msg
				var data = [];		
            //
            var no_kwt 		= $('#kwt_number').val();
            var tgl_kwt     = $('#kwt_date').val();
            var supp        = $('#customer').val();
            var total       = $('#total').val();
            var terbilang   = $('#terbilang').val();
            var status      = "POST"
			//			
			data.push({		
				"no_kwt": no_kwt,
				"tgl_kwt": tgl_kwt,
				"supp": supp,	
				"total": total,					
				"terbilang": terbilang,
				"status": status,															
			})	
			
			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpankwitansi/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					// Delete Table Invoice Detail Temporary
					delete_kwt_detail_temporary();
					// Print Preview Invoice
					let no_kwt= $('[name="kwt_no"]').val();
					print_kwitansi(no_kwt);
                    // Reload Page
                    window.location.href = window.location.href;

                },
                error: function (jqXHR, textStatus, errorThrown) {
                	msg = 'Error Input Detail' + jqXHR.text
                }
            });
			resolve({
				msg: msg,
			});

		}, 100);
		});

	}


	function add_memo() {

		$cust = $('#nama_supp').val();
		$idcust = $('[name="customer"]').val()	
	//\
	// alert($cust);
	$('[name="no_memo"]').val('');
	$('[name="custm"]').val($cust);
	$('[name="id_custm"]').val($idcust);
	//
	// $('#table-dn tbody tr').remove();	
	// $('#table-sj tbody tr').remove();
	// //
	// $('#so_number1').val("");
	// //$('#id_sj').val("");
	// //Clear Value : Total, Discount, Down Payment, Return, Total With Out Tax, VAT, Grand Total
	// $('#total').val("");
	// $('#discount').val("");
	// $('#dp').val("");
	// $('#return').val("");
	// $('#twot').val("");
	// $('#vat').val("");
	// $('#grandtotal').val("");	
	// //
	// $('#table-sj-2 tbody tr').remove();	
	// //
	delete_memo_temp();

}


function delete_memo_temp(){

				//
				$.ajax({						
					url: "delete_memo_temp/",		
				});   	

			}

			function cari_data_memo() { 

				$('#table-inv-memo tbody tr').remove();	
		//Date range picker
		$('input[name="tgl_fil_memo"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="tgl_fil_memo"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_memo = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_memo = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="tgl_fil_memo"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_memo   = "undefined";
			dt_sampai_memo = "undefined";
		});

		var id_customer = $('#id_custm').val();

		console.log(dt_dari_memo + ' ' + dt_sampai_memo + ' ' + id_customer);

		$.ajax({		
			url: "cari_invoice_memo/" + dt_dari_memo + "/" + dt_sampai_memo + "/" + id_customer + "/" ,					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 								
					trHTML += '<tr>';					
					trHTML += '<td>' + item.id + "</td>";
					trHTML += '<td>' + item.supplier + "</td>";
					trHTML += '<td>' + item.nm_memo + "</td>";	
					trHTML += '<td>' + item.tgl_memo + "</td>";
					trHTML += '<td>' + item.no_invoice + "</td>";
					trHTML += '<td>' + item.curr + "</td>";
					trHTML += '<td>' + item.grand_total + "</td>";		
					trHTML += '<td><input type="checkbox" name="mdl_cek_memo" id="mdl_cek_memo" class="flat"  onclick="modal_sum_total_memo(value = ' +  item.grand_total + ')"></td>';
					trHTML += '<td hidden>' + item.id_supplier + "</td>";

					trHTML += '</tr>';
				});

				$('#table-inv-memo').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	

	}


	function modal_sum_total_memo(){
		
		var input_memo = document.getElementsByName("mdl_cek_memo");
	// var hanya_baca = document.getElementsByName("mdl_amo");	
	var total = 0;

	for (var i = 0; i < input_memo.length; i++) {
		if (input_memo[i].checked) {	
			total += parseFloat(input_memo[i].value);

		}else {				

		}
		type: "POST";
	}
    // alert(total);					

    document.getElementsByName("val_memo")[0].value = total;
    document.getElementsByName("val_memo_h")[0].value = formatMoney(total);

}


function duplicate_data_memo(){ 

	var ttl_memo    = $('[name="val_memo"]').val();
	var ttl_memo_h 	= formatMoney(ttl_memo);
	console.log(ttl_memo);

	$('[name="total_value"]').val(ttl_memo_h);
	$('[name="total_value_h"]').val(ttl_memo);
	$('[name="total_value_idr"]').val(ttl_memo_h);
	$('[name="total_value_idr_h"]').val(ttl_memo);
 	// delete_invoice_detail_alo();
 	simpan_invoice_detail_memo();


 }


 function simpan_invoice_detail_memo(){
 	return new Promise(resolve => {		
 		setTimeout(() => {
 			var msg
 			var data = [];	

 			$("#table-inv-memo input[name='mdl_cek_memo']:checked").each(function () {
 				var rows = $(this).closest("tr")[0];
				//
                //
                data.push({							
					//"id_invoice_proforma": rows.cells[0].innerHTML,
					"id": rows.cells[0].innerHTML,	
					"id_supplier": rows.cells[8].innerHTML,						
					"supplier": rows.cells[1].innerHTML,
					"nm_memo": rows.cells[2].innerHTML,
					"memo_date": rows.cells[3].innerHTML,
					"no_invoice": rows.cells[4].innerHTML,					
					"curr": rows.cells[5].innerHTML,
					"total": rows.cells[6].innerHTML,								
				});		 

            });

 			var fdata = {
 				'data_table': data
 			}
 			console.log(fdata);
 			$.ajax({				
 				url: "simpan_invoice_detail_memo/",
 				type: "POST",
 				data: fdata,
 				dataType: "JSON",
 				success: function (data) {

					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}

					//Load Data SO Proforma Temporary
					load_invoice_detail_memo();                   		
					$('#modal-add-memo').modal('hide');

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
 			resolve({
 				msg: msg,
 			});

 		}, 100);
 	});
 }




 function load_invoice_detail_memo(){ 

	// $('#table-dn tbody tr').remove();

	var coa = "<input style='width: 250px;' class='form-control' value='1.34.04' list='nm_coa' name='nm_coa'> <datalist id='nm_coa'> <option value = '-'>-</option><option value = '1.01.01'>1.01.01 KAS KECIL PABRIK</option> <option value = '1.01.02'>1.01.02 KAS KECIL KANTOR</option> <option value = '1.01.03'>1.01.03 KAS BESAR</option> <option value = '1.10.01'>1.10.01 BCA 008-997-1979</option> <option value = '1.10.02'>1.10.02 BCA 008-998-1982</option> <option value = '1.10.11'>1.10.11 BNI 442-244-2000</option> <option value = '1.10.21'>1.10.21 CIMB NIAGA 800-17781-4600</option> <option value = '1.10.81'>1.10.81 BCA 008-403-6249</option> <option value = '1.20.01'>1.20.01 OBLIGASI</option> <option value = '1.30.01'>1.30.01 PIUTANG USAHA PIHAK KETIGA - LOKAL</option> <option value = '1.30.02'>1.30.02 PIUTANG USAHA PIHAK KETIGA - EKSPOR</option> <option value = '1.32.01'>1.32.01 PIUTANG USAHA PIHAK BERELASI - LOKAL</option> <option value = '1.32.02'>1.32.02 PIUTANG USAHA PIHAK BERELASI - EKSPOR</option> <option value = '1.34.01'>1.34.01 PIUTANG LAIN-LAIN PIHAK KETIGA - LOKAL</option> <option value = '1.34.02'>1.34.02 PIUTANG LAIN-LAIN PIHAK KETIGA - EKSPOR</option> <option value = '1.34.03'>1.34.03 PIUTANG LAIN-LAIN PIHAK KETIGA - SPAREPARTS</option> <option value = '1.34.51'>1.34.51 PIUTANG LAIN-LAIN PIHAK KETIGA - KARYAWAN</option> <option value = '1.34.61'>1.34.61 PIUTANG LAIN-LAIN PIHAK KETIGA - PPH 23</option> <option value = '1.34.99'>1.34.99 PIUTANG LAIN-LAIN PIHAK KETIGA - LAIN-LAIN</option> <option value = '1.35.01'>1.35.01 PIUTANG LAIN-LAIN PIHAK BERELASI - LOKAL</option> <option value = '1.35.02'>1.35.02 PIUTANG LAIN-LAIN PIHAK BERELASI - EKSPOR</option> <option value = '1.35.03'>1.35.03 PIUTANG LAIN-LAIN PIHAK BERELASI - SPAREPARTS</option> <option value = '1.35.51'>1.35.51 PIUTANG LAIN-LAIN PIHAK BERELASI - DIREKSI</option> <option value = '1.35.99'>1.35.99 PIUTANG LAIN-LAIN PIHAK BERELASI - LAIN-LAIN</option> <option value = '1.36.01'>1.36.01 PERSEDIAAN KAIN</option> <option value = '1.38.01'>1.38.01 PERSEDIAAN AKSESORIS</option> <option value = '1.40.01'>1.40.01 PERSEDIAAN BARANG DALAM PROSES</option> <option value = '1.41.01'>1.41.01 PERSEDIAAN BARANG DALAM PROSES DI PEMAKLOON</option> <option value = '1.41.02'>1.41.02 PERSEDIAAN KAIN DI PEMAKLOON</option> <option value = '1.41.03'>1.41.03 PERSEDIAAN AKSESORIS DI PEMAKLOON</option> <option value = '1.41.04'>1.41.04 PERSEDIAAN BARANG JADI DI PEMAKLOON</option> <option value = '1.42.01'>1.42.01 PERSEDIAAN PAKAIAN JADI</option> <option value = '1.44.01'>1.44.01 PERSEDIAAN SPAREPARTS</option> <option value = '1.45.01'>1.45.01 PERSEDIAAN ATK</option> <option value = '1.45.02'>1.45.02 PERSEDIAAN UMUM</option> <option value = '1.49.01'>1.49.01 UANG MUKA PEMBELIAN LOKAL - ASET TETAP</option> <option value = '1.49.11'>1.49.11 UANG MUKA PEMBELIAN LOKAL - BAHAN BAKU / BAHAN PEMBANTU</option> <option value = '1.49.21'>1.49.21 UANG MUKA PEMBELIAN LOKAL - SPAREPARTS</option> <option value = '1.49.81'>1.49.81 UANG MUKA PEMBELIAN LOKAL - JASA</option> <option value = '1.49.99'>1.49.99 UANG MUKA PEMBELIAN LOKAL - LAIN-LAIN</option> <option value = '1.50.01'>1.50.01 UANG MUKA PEMBELIAN IMPORT - ASET TETAP</option> <option value = '1.50.11'>1.50.11 UANG MUKA PEMBELIAN IMPORT - BAHAN BAKU / BAHAN PEMBANTU</option> <option value = '1.50.21'>1.50.21 UANG MUKA PEMBELIAN IMPORT - SPAREPARTS</option> <option value = '1.50.81'>1.50.81 UANG MUKA PEMBELIAN IMPORT - JASA</option> <option value = '1.50.99'>1.50.99 UANG MUKA PEMBELIAN IMPORT - LAIN-LAIN</option> <option value = '1.51.01'>1.51.01 BIAYA DIBAYAR DIMUKA - SEWA</option> <option value = '1.51.02'>1.51.02 BIAYA DIBAYAR DIMUKA - ASURANSI</option> <option value = '1.51.99'>1.51.99 BIAYA DIBAYAR DIMUKA - LAIN-LAIN</option> <option value = '1.52.01'>1.52.01 PAJAK DIBAYAR DIMUKA PPH PASAL 22</option> <option value = '1.52.02'>1.52.02 PAJAK DIBAYAR DIMUKA PPH PASAL 23</option> <option value = '1.52.03'>1.52.03 PAJAK DIBAYAR DIMUKA PPH PASAL 25</option> <option value = '1.52.04'>1.52.04 PAJAK DIBAYAR DIMUKA PPN MASUKAN</option> <option value = '1.52.05'>1.52.05 PAJAK DIBAYAR DIMUKA PPH PASAL 4 AYAT 2</option> <option value = '1.52.06'>1.52.06 PAJAK DIBAYAR DIMUKA PPH PASAL 21</option> <option value = '1.52.07'>1.52.07 PAJAK DIBAYAR DIMUKA PPN MASUKAN (UNBILLED)</option> <option value = '1.53.01'>1.53.01 PPH BADAN LB PASAL 28A</option> <option value = '1.60.01'>1.60.01 TANAH</option> <option value = '1.60.11'>1.60.11 BANGUNAN</option> <option value = '1.60.21'>1.60.21 INSTALASI LISTRIK</option> <option value = '1.60.22'>1.60.22 INSTALASI AIR</option> <option value = '1.60.31'>1.60.31 MESIN</option> <option value = '1.60.41'>1.60.41 PERALATAN PABRIK</option> <option value = '1.60.51'>1.60.51 KENDARAAN</option> <option value = '1.60.61'>1.60.61 PERALATAN KANTOR</option> <option value = '1.60.62'>1.60.62 PERALATAN IT</option> <option value = '1.61.01'>1.61.01 PERANGKAT LUNAK</option> <option value = '1.70.01'>1.70.01 AKUMULASI PENYUSUTAN BANGUNAN</option> <option value = '1.70.11'>1.70.11 AKUMULASI PENYUSUTAN INSTALASI LISTRIK</option> <option value = '1.70.12'>1.70.12 AKUMULASI PENYUSUTAN INSTALASI AIR</option> <option value = '1.70.21'>1.70.21 AKUMULASI PENYUSUTAN MESIN</option> <option value = '1.70.31'>1.70.31 AKUMULASI PENYUSUTAN PERALATAN PABRIK</option> <option value = '1.70.41'>1.70.41 AKUMULASI PENYUSUTAN KENDARAAN</option> <option value = '1.70.51'>1.70.51 AKUMULASI PENYUSUTAN PERALATAN KANTOR</option> <option value = '1.70.52'>1.70.52 AKUMULASI PENYUSUTAN PERALATAN IT</option> <option value = '1.71.01'>1.71.01 AKUMULASI AMORTISASI PERANGKAT LUNAK</option> <option value = '1.80.01'>1.80.01 ASET DALAM PENYELESAIAN - BANGUNAN</option> <option value = '1.80.11'>1.80.11 ASET DALAM PENYELESAIAN - INSTALASI LISTRIK</option> <option value = '1.80.12'>1.80.12 ASET DALAM PENYELESAIAN - INSTALASI AIR</option> <option value = '1.80.91'>1.80.91 ASET DALAM PENYELESAIAN - PERANGKAT LUNAK</option> <option value = '1.90.01'>1.90.01 POS SILANG</option> <option value = '2.10.01'>2.10.01 GR/IR PIHAK KETIGA - KAIN</option> <option value = '2.10.02'>2.10.02 GR/IR PIHAK KETIGA - AKSESORIS</option> <option value = '2.10.03'>2.10.03 GR/IR PIHAK KETIGA - PAKAIAN JADI</option> <option value = '2.10.04'>2.10.04 GR/IR PIHAK KETIGA - ATK</option> <option value = '2.10.05'>2.10.05 GR/IR PIHAK KETIGA - SPAREPARTS</option> <option value = '2.10.06'>2.10.06 GR/IR PIHAK KETIGA - MAKLOON</option> <option value = '2.10.07'>2.10.07 GR/IR PIHAK KETIGA - MESIN</option> <option value = '2.10.99'>2.10.99 GR/IR PIHAK KETIGA - LAIN-LAIN</option> <option value = '2.11.01'>2.11.01 UTANG USAHA PIHAK KETIGA - KAIN</option> <option value = '2.11.02'>2.11.02 UTANG USAHA PIHAK KETIGA - AKSESORIS</option> <option value = '2.11.03'>2.11.03 UTANG USAHA PIHAK KETIGA - PAKAIAN JADI</option> <option value = '2.11.04'>2.11.04 UTANG USAHA PIHAK KETIGA - ATK</option> <option value = '2.11.05'>2.11.05 UTANG USAHA PIHAK KETIGA - SPAREPARTS</option> <option value = '2.11.06'>2.11.06 UTANG USAHA PIHAK KETIGA - MAKLOON</option> <option value = '2.11.07'>2.11.07 UTANG USAHA PIHAK KETIGA - MESIN</option> <option value = '2.11.99'>2.11.99 UTANG USAHA PIHAK KETIGA - LAIN-LAIN</option> <option value = '2.12.01'>2.12.01 GR/IR PIHAK BERELASI - KAIN</option> <option value = '2.12.02'>2.12.02 GR/IR PIHAK BERELASI - AKSESORIS</option> <option value = '2.12.03'>2.12.03 GR/IR PIHAK BERELASI - PAKAIAN JADI</option> <option value = '2.12.04'>2.12.04 GR/IR PIHAK BERELASI - ATK</option> <option value = '2.12.05'>2.12.05 GR/IR PIHAK BERELASI - SPAREPARTS</option> <option value = '2.12.06'>2.12.06 GR/IR PIHAK BERELASI - MAKLOON</option> <option value = '2.12.07'>2.12.07 GR/IR PIHAK BERELASI - MESIN</option> <option value = '2.12.99'>2.12.99 GR/IR PIHAK BERELASI - LAIN-LAIN</option> <option value = '2.13.01'>2.13.01 UTANG USAHA PIHAK BERELASI - KAIN</option> <option value = '2.13.02'>2.13.02 UTANG USAHA PIHAK BERELASI - AKSESORIS</option> <option value = '2.13.03'>2.13.03 UTANG USAHA PIHAK BERELASI - PAKAIAN JADI</option> <option value = '2.13.04'>2.13.04 UTANG USAHA PIHAK BERELASI - ATK</option> <option value = '2.13.05'>2.13.05 UTANG USAHA PIHAK BERELASI - SPAREPARTS</option> <option value = '2.13.06'>2.13.06 UTANG USAHA PIHAK BERELASI - MAKLOON</option> <option value = '2.13.07'>2.13.07 UTANG USAHA PIHAK BERELASI - MESIN</option> <option value = '2.13.99'>2.13.99 UTANG USAHA PIHAK BERELASI - LAIN-LAIN</option> <option value = '2.18.99'>2.18.99 UTANG LAIN-LAIN</option> <option value = '2.18.01'>2.18.01 UTANG LAIN-LAIN - DIREKSI</option> <option value = '2.19.99'>2.19.99 UTANG LAIN-LAIN</option> <option value = '2.20.01'>2.20.01 OVERDRAFT BCA 008-997-1979</option> <option value = '2.20.02'>2.20.02 OVERDRAFT BCA 008-998-1982</option> <option value = '2.40.01'>2.40.01 UANG MUKA PENJUALAN LOKAL</option> <option value = '2.40.02'>2.40.02 UANG MUKA PENJUALAN EKSPOR</option> <option value = '2.51.01'>2.51.01 BIAYA YANG MASIH HARUS DIBAYAR - LISTRIK</option> <option value = '2.51.02'>2.51.02 BIAYA YANG MASIH HARUS DIBAYAR - AIR</option> <option value = '2.51.11'>2.51.11 BIAYA YANG MASIH HARUS DIBAYAR - TELP</option> <option value = '2.51.12'>2.51.12 BIAYA YANG MASIH HARUS DIBAYAR - INTERNET</option> <option value = '2.51.21'>2.51.21 BIAYA YANG MASIH HARUS DIBAYAR - GAJI</option> <option value = '2.51.22'>2.51.22 BIAYA YANG MASIH HARUS DIBAYAR - THR</option> <option value = '2.51.31'>2.51.31 BIAYA YANG MASIH HARUS DIBAYAR - BPJS</option> <option value = '2.51.41'>2.51.41 BIAYA YANG MASIH HARUS DIBAYAR - SEWA</option> <option value = '2.51.51'>2.51.51 BIAYA YANG MASIH HARUS DIBAYAR - EMKL</option> <option value = '2.51.61'>2.51.61 BIAYA YANG MASIH HARUS DIBAYAR - FOTOKOPI</option> <option value = '2.52.01'>2.52.01 PAJAK YANG MASIH HARUS DIBAYAR - PPH PASAL 21</option> <option value = '2.52.02'>2.52.02 PAJAK YANG MASIH HARUS DIBAYAR - PPH PASAL 4 (2)</option> <option value = '2.52.03'>2.52.03 PAJAK YANG MASIH HARUS DIBAYAR - PPN</option> <option value = '2.52.04'>2.52.04 PAJAK YANG MASIH HARUS DIBAYAR - PPH PASAL 25/29</option> <option value = '2.52.05'>2.52.05 PAJAK YANG MASIH HARUS DIBAYAR - PPH PASAL 23</option> <option value = '2.52.06'>2.52.06 PAJAK YANG MASIH HARUS DIBAYAR - PBB</option> <option value = '2.53.01'>2.53.01 PPN KELUARAN</option> <option value = '2.60.01'>2.60.01 UTANG BANK JANGKA PANJANG</option> <option value = '3.10.01'>3.10.01 MODAL SAHAM</option> <option value = '3.20.01'>3.20.01 TAMBAHAN MODAL DISETOR (AMNESTI PAJAK)</option> <option value = '3.30.01'>3.30.01 LABA DITAHAN</option> <option value = '3.40.01'>3.40.01 LABA TAHUN BERJALAN</option> <option value = '4.01.01'>4.01.01 PENJUALAN PAKAIAN JADI EKSPOR PIHAK KETIGA - A GRADE</option> <option value = '4.01.02'>4.01.02 PENJUALAN PAKAIAN JADI EKSPOR PIHAK KETIGA - B GRADE</option> <option value = '4.02.01'>4.02.01 PENJUALAN PAKAIAN JADI LOKAL PIHAK KETIGA - A GRADE</option> <option value = '4.02.02'>4.02.02 PENJUALAN PAKAIAN JADI LOKAL PIHAK KETIGA - B GRADE</option> <option value = '4.09.01'>4.09.01 PENJUALAN LAINNYA PIHAK KETIGA - KAIN</option> <option value = '4.09.02'>4.09.02 PENJUALAN LAINNYA PIHAK KETIGA - AKSESORIS</option> <option value = '4.09.03'>4.09.03 PENJUALAN LAINNYA PIHAK KETIGA - SCRAP / MAJUN</option> <option value = '4.11.01'>4.11.01 PENJUALAN PAKAIAN JADI EKSPOR PIHAK BERELASI - A GRADE</option> <option value = '4.11.02'>4.11.02 PENJUALAN PAKAIAN JADI EKSPOR PIHAK BERELASI - B GRADE</option> <option value = '4.12.01'>4.12.01 PENJUALAN PAKAIAN JADI LOKAL PIHAK BERELASI - A GRADE</option> <option value = '4.12.02'>4.12.02 PENJUALAN PAKAIAN JADI LOKAL PIHAK BERELASI - B GRADE</option> <option value = '4.19.01'>4.19.01 PENJUALAN LAINNYA PIHAK BERELASI - KAIN</option> <option value = '4.19.02'>4.19.02 PENJUALAN LAINNYA PIHAK BERELASI - AKSESORIS</option> <option value = '4.19.03'>4.19.03 PENJUALAN LAINNYA PIHAK BERELASI - SCRAP / MAJUN</option> <option value = '4.21.01'>4.21.01 PENJUALAN JASA JAHIT PAKAIAN JADI EKSPOR CMT PIHAK KETIGA - A GRADE</option> <option value = '4.21.02'>4.21.02 PENJUALAN JASA JAHIT PAKAIAN JADI EKSPOR CMT PIHAK KETIGA - B GRADE</option> <option value = '4.22.01'>4.22.01 PENJUALAN JASA JAHIT PAKAIAN JADI LOKAL CMT PIHAK KETIGA - A GRADE</option> <option value = '4.22.03'>4.22.03 PENJUALAN JASA JAHIT PAKAIAN JADI LOKAL CMT PIHAK KETIGA - B GRADE</option> <option value = '4.29.01'>4.29.01 PENJUALAN JASA LAINNYA</option> <option value = '4.31.01'>4.31.01 PENJUALAN JASA JAHIT PAKAIAN JADI EKSPOR CMT PIHAK BERELASI - A GRADE</option> <option value = '4.31.02'>4.31.02 PENJUALAN JASA JAHIT PAKAIAN JADI EKSPOR CMT PIHAK BERELASI - B GRADE</option> <option value = '4.32.01'>4.32.01 PENJUALAN JASA JAHIT PAKAIAN JADI LOKAL CMT PIHAK BERELASI - A GRADE</option> <option value = '4.32.02'>4.32.02 PENJUALAN JASA JAHIT PAKAIAN JADI LOKAL CMT PIHAK BERELASI - B GRADE</option> <option value = '4.39.01'>4.39.01 PENJUALAN JASA LAINNYA</option> <option value = '4.41.01'>4.41.01 RETUR PENJUALAN PAKAIAN JADI EKSPOR PIHAK KETIGA - A GRADE</option> <option value = '4.41.02'>4.41.02 RETUR PENJUALAN PAKAIAN JADI EKSPOR PIHAK KETIGA - B GRADE</option> <option value = '4.42.01'>4.42.01 RETUR PENJUALAN PAKAIAN JADI LOKAL PIHAK KETIGA - A GRADE</option> <option value = '4.42.02'>4.42.02 RETUR PENJUALAN PAKAIAN JADI LOKAL PIHAK KETIGA - B GRADE</option> <option value = '4.49.01'>4.49.01 RETUR PENJUALAN LAINNYA PIHAK KETIGA - KAIN</option> <option value = '4.49.02'>4.49.02 RETUR PENJUALAN LAINNYA PIHAK KETIGA - AKSESORIS</option> <option value = '4.49.03'>4.49.03 RETUR PENJUALAN LAINNYA PIHAK KETIGA - SCRAP / MAJUN</option> <option value = '4.51.01'>4.51.01 RETUR PENJUALAN PAKAIAN JADI EKSPOR PIHAK BERELASI - A GRADE</option> <option value = '4.51.02'>4.51.02 RETUR PENJUALAN PAKAIAN JADI EKSPOR PIHAK BERELASI - B GRADE</option> <option value = '4.52.01'>4.52.01 RETUR PENJUALAN PAKAIAN JADI LOKAL PIHAK BERELASI - A GRADE</option> <option value = '4.52.02'>4.52.02 RETUR PENJUALAN PAKAIAN JADI LOKAL PIHAK BERELASI - B GRADE</option> <option value = '4.59.01'>4.59.01 RETUR PENJUALAN LAINNYA PIHAK BERELASI - KAIN</option> <option value = '4.59.02'>4.59.02 RETUR PENJUALAN LAINNYA PIHAK BERELASI - AKSESORIS</option> <option value = '4.59.03'>4.59.03 RETUR PENJUALAN LAINNYA PIHAK BERELASI - SCRAP / MAJUN</option> <option value = '4.61.01'>4.61.01 POTONGAN PENJUALAN PAKAIAN JADI EKSPOR PIHAK KETIGA - A GRADE</option> <option value = '4.61.02'>4.61.02 POTONGAN PENJUALAN PAKAIAN JADI EKSPOR PIHAK KETIGA - B GRADE</option> <option value = '4.62.01'>4.62.01 POTONGAN PENJUALAN PAKAIAN JADI LOKAL PIHAK KETIGA - A GRADE</option> <option value = '4.62.02'>4.62.02 POTONGAN PENJUALAN PAKAIAN JADI LOKAL PIHAK KETIGA - B GRADE</option> <option value = '4.69.01'>4.69.01 POTONGAN PENJUALAN LAINNYA PIHAK KETIGA - KAIN</option> <option value = '4.69.02'>4.69.02 POTONGAN PENJUALAN LAINNYA PIHAK KETIGA - AKSESORIS</option> <option value = '4.69.03'>4.69.03 POTONGAN PENJUALAN LAINNYA PIHAK KETIGA - SCRAP / MAJUN</option> <option value = '4.71.01'>4.71.01 POTONGAN PENJUALAN PAKAIAN JADI EKSPOR PIHAK BERELASI - A GRADE</option> <option value = '4.71.02'>4.71.02 POTONGAN PENJUALAN PAKAIAN JADI EKSPOR PIHAK BERELASI - B GRADE</option> <option value = '4.72.01'>4.72.01 POTONGAN PENJUALAN PAKAIAN JADI LOKAL PIHAK BERELASI - A GRADE</option> <option value = '4.72.02'>4.72.02 POTONGAN PENJUALAN PAKAIAN JADI LOKAL PIHAK BERELASI - B GRADE</option> <option value = '4.79.01'>4.79.01 POTONGAN PENJUALAN LAINNYA PIHAK BERELASI - KAIN</option> <option value = '4.79.02'>4.79.02 POTONGAN PENJUALAN LAINNYA PIHAK BERELASI - AKSESORIS</option> <option value = '4.79.03'>4.79.03 POTONGAN PENJUALAN LAINNYA PIHAK BERELASI - SCRAP / MAJUN</option> <option value = '4.81.01'>4.81.01 POTONGAN PENJUALAN JASA JAHIT PAKAIAN JADI EKSPOR CMT PIHAK KETIGA - A GRADE</option> <option value = '4.81.02'>4.81.02 POTONGAN PENJUALAN JASA JAHIT PAKAIAN JADI EKSPOR CMT PIHAK KETIGA - B GRADE</option> <option value = '4.82.01'>4.82.01 POTONGAN PENJUALAN JASA JAHIT PAKAIAN JADI LOKAL CMT PIHAK KETIGA - A GRADE</option> <option value = '4.82.02'>4.82.02 POTONGAN PENJUALAN JASA JAHIT PAKAIAN JADI LOKAL CMT PIHAK KETIGA - B GRADE</option> <option value = '4.89.01'>4.89.01 POTONGAN PENJUALAN JASA LAINNYA</option> <option value = '4.91.01'>4.91.01 POTONGAN PENJUALAN JASA JAHIT PAKAIAN JADI EKSPOR CMT PIHAK BERELASI - A GRADE</option> <option value = '4.91.02'>4.91.02 POTONGAN PENJUALAN JASA JAHIT PAKAIAN JADI EKSPOR CMT PIHAK BERELASI - B GRADE</option> <option value = '4.92.01'>4.92.01 POTONGAN PENJUALAN JASA JAHIT PAKAIAN JADI LOKAL CMT PIHAK BERELASI - A GRADE</option> <option value = '4.92.02'>4.92.02 POTONGAN PENJUALAN JASA JAHIT PAKAIAN JADI LOKAL CMT PIHAK BERELASI - B GRADE</option> <option value = '4.99.01'>4.99.01 POTONGAN PENJUALAN JASA LAINNYA</option> <option value = '5.01.01'>5.01.01 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR PIHAK KETIGA - A GRADE</option> <option value = '5.01.02'>5.01.02 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR PIHAK KETIGA - B GRADE</option> <option value = '5.02.01'>5.02.01 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL PIHAK KETIGA - A GRADE</option> <option value = '5.02.02'>5.02.02 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL PIHAK KETIGA - B GRADE</option> <option value = '5.09.01'>5.09.01 HARGA POKOK PENJUALAN LAINNYA PIHAK KETIGA - KAIN</option> <option value = '5.09.02'>5.09.02 HARGA POKOK PENJUALAN LAINNYA PIHAK KETIGA - AKSESORIS</option> <option value = '5.09.03'>5.09.03 HARGA POKOK PENJUALAN LAINNYA PIHAK KETIGA - SCRAP / MAJUN</option> <option value = '5.11.01'>5.11.01 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR PIHAK BERELASI - A GRADE</option> <option value = '5.11.02'>5.11.02 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR PIHAK BERELASI - B GRADE</option> <option value = '5.12.01'>5.12.01 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL PIHAK BERELASI - A GRADE</option> <option value = '5.12.02'>5.12.02 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL PIHAK BERELASI - B GRADE</option> <option value = '5.19.01'>5.19.01 HARGA POKOK PENJUALAN LAINNYA PIHAK BERELASI - KAIN</option> <option value = '5.19.02'>5.19.02 HARGA POKOK PENJUALAN LAINNYA PIHAK BERELASI - AKSESORIS</option> <option value = '5.19.03'>5.19.03 HARGA POKOK PENJUALAN LAINNYA PIHAK BERELASI - SCRAP / MAJUN</option> <option value = '5.21.01'>5.21.01 HARGA POKOK PENJUALAN JASA JAHIT PAKAIAN JADI EKSPOR CMT PIHAK KETIGA - A GRADE</option> <option value = '5.21.02'>5.21.02 HARGA POKOK PENJUALAN JASA JAHIT PAKAIAN JADI EKSPOR CMT PIHAK KETIGA - B GRADE</option> <option value = '5.22.01'>5.22.01 HARGA POKOK PENJUALAN JASA JAHIT PAKAIAN JADI LOKAL CMT PIHAK KETIGA - A GRADE</option> <option value = '5.22.02'>5.22.02 HARGA POKOK PENJUALAN JASA JAHIT PAKAIAN JADI LOKAL CMT PIHAK KETIGA - B GRADE</option> <option value = '5.29.01'>5.29.01 HARGA POKOK PENJUALAN JASA LAINNYA</option> <option value = '5.31.01'>5.31.01 HARGA POKOK PENJUALAN JASA JAHIT PAKAIAN JADI EKSPOR CMT PIHAK BERELASI - A GRADE</option> <option value = '5.31.02'>5.31.02 HARGA POKOK PENJUALAN JASA JAHIT PAKAIAN JADI EKSPOR CMT PIHAK BERELASI - B GRADE</option> <option value = '5.32.01'>5.32.01 HARGA POKOK PENJUALAN JASA JAHIT PAKAIAN JADI LOKAL CMT PIHAK BERELASI - A GRADE</option> <option value = '5.32.02'>5.32.02 HARGA POKOK PENJUALAN JASA JAHIT PAKAIAN JADI LOKAL CMT PIHAK BERELASI - B GRADE</option> <option value = '5.39.01'>5.39.01 HARGA POKOK PENJUALAN JASA LAINNYA</option> <option value = '5.40.01'>5.40.01 BIAYA PEMAKAIAN KAIN</option> <option value = '5.40.02'>5.40.02 BIAYA PEMAKAIAN AKSESORIS</option> <option value = '5.50.01'>5.50.01 BEBAN GAJI & UPAH TENAGA KERJA LANGSUNG</option> <option value = '5.51.01'>5.51.01 BEBAN TUNJANGAN TENAGA KERJA LANGSUNG</option> <option value = '5.52.01'>5.52.01 BEBAN LEMBUR TENAGA KERJA LANGSUNG</option> <option value = '5.53.01'>5.53.01 BPJS KETENAGAKERJAAN TENAGA KERJA LANGSUNG</option> <option value = '5.53.02'>5.53.02 BPJS KESEHATAN TENAGA KERJA LANGSUNG</option> <option value = '5.54.01'>5.54.01 THR TENAGA KERJA LANGSUNG</option> <option value = '5.54.02'>5.54.02 BONUS TENAGA KERJA LANGSUNG</option> <option value = '5.55.01'>5.55.01 BEBAN MANFAAT KARYAWAN TENAGA KERJA LANGSUNG</option> <option value = '5.60.01'>5.60.01 BEBAN GAJI & UPAH TENAGA KERJA TIDAK LANGSUNG</option> <option value = '5.61.01'>5.61.01 BEBAN TUNJANGAN TENAGA KERJA TIDAK LANGSUNG</option> <option value = '5.62.01'>5.62.01 BEBAN LEMBUR TENAGA KERJA TIDAK LANGSUNG</option> <option value = '5.63.01'>5.63.01 BPJS KETENAGAKERJAAN TENAGA KERJA TIDAK LANGSUNG</option> <option value = '5.63.02'>5.63.02 BPJS KESEHATAN TENAGA KERJA TIDAK LANGSUNG</option> <option value = '5.64.01'>5.64.01 THR TENAGA KERJA TIDAK LANGSUNG</option> <option value = '5.64.02'>5.64.02 BONUS TENAGA KERJA TIDAK LANGSUNG</option> <option value = '5.65.01'>5.65.01 BEBAN MANFAAT KARYAWAN TENAGA KERJA TIDAK LANGSUNG</option> <option value = '5.69.01'>5.69.01 BEBAN MAKLOON DYEING BENANG</option> <option value = '5.69.02'>5.69.02 BEBAN MAKLOON DYEING KAIN</option> <option value = '5.69.03'>5.69.03 BEBAN MAKLOON KNITTING</option> <option value = '5.69.04'>5.69.04 BEBAN MAKLOON PAKAIAN JADI</option> <option value = '5.69.05'>5.69.05 BEBAN MAKLOON PRINTING</option> <option value = '5.69.06'>5.69.06 BEBAN MAKLOON EMBRODEIRY</option> <option value = '5.69.07'>5.69.07 BEBAN MAKLOON WASHING</option> <option value = '5.69.08'>5.69.08 BEBAN MAKLOON KNITTING VIETER BAND</option> <option value = '5.69.09'>5.69.09 BEBAN MAKLOON BUBUT</option> <option value = '5.69.10'>5.69.10 BEBAN MAKLOON PAINTING</option> <option value = '5.69.11'>5.69.11 BEBAN MAKLOON LASER CUTTING</option> <option value = '5.69.12'>5.69.12 BEBAN MAKLOON BONDING</option> <option value = '5.69.13'>5.69.13 BEBAN MAKLOON HEATSEAL</option> <option value = '5.69.14'>5.69.14 BEBAN MAKLOON QUILTING</option> <option value = '5.69.97'>5.69.97 BEBAN MAKLOON KAIN</option> <option value = '5.69.98'>5.69.98 BEBAN MAKLOON AKSESORIS</option> <option value = '5.69.99'>5.69.99 BEBAN MAKLOON LAINNYA</option> <option value = '5.70.01'>5.70.01 BEBAN ENERGI - BATUBARA</option> <option value = '5.70.02'>5.70.02 BEBAN ENERGI - SOLAR</option> <option value = '5.70.03'>5.70.03 BEBAN ENERGI - ELPIJI</option> <option value = '5.71.01'>5.71.01 CHEMICAL IPAL</option> <option value = '5.71.02'>5.71.02 BEBAN BUANG LUMPUR</option> <option value = '5.71.03'>5.71.03 BEBAN BUANG ABU - LUMPUR</option> <option value = '5.71.04'>5.71.04 BEBAN BUANG ABU - BATU BARA</option> <option value = '5.71.05'>5.71.05 BEBAN UJI LAB LIMBAH AIR</option> <option value = '5.71.99'>5.71.99 BEBAN PENGOLAHAN LIMBAH LAINNYA</option> <option value = '5.72.01'>5.72.01 BEBAN SPAREPARTS</option> <option value = '5.73.01'>5.73.01 BEBAN IMPOR MESIN</option> <option value = '5.73.02'>5.73.02 BEBAN IMPOR SPAREPARTS</option> <option value = '5.73.03'>5.73.03 BEBAN IMPOR BAHAN BAKU</option> <option value = '5.73.04'>5.73.04 BEBAN IMPOR BAHAN PEMBANTU</option> <option value = '5.74.01'>5.74.01 BEBAN PENGUJIAN KAIN</option> <option value = '5.74.99'>5.74.99 BEBAN PENGUJIAN DAN PENELITIAN LAINNYA</option> <option value = '5.75.01'>5.75.01 BEBAN SEWA TANAH & BANGUNAN</option> <option value = '5.75.02'>5.75.02 BEBAN SEWA MESIN</option> <option value = '5.75.03'>5.75.03 BEBAN SEWA PERANGKAT LUNAK</option> <option value = '5.76.01'>5.76.01 BEBAN LISTRIK PABRIK</option> <option value = '5.77.01'>5.77.01 BEBAN TELEPON PABRIK</option> <option value = '5.77.02'>5.77.02 BEBAN INTERNET PABRIK</option> <option value = '5.78.01'>5.78.01 BEBAN IURAN AIR PJT</option> <option value = '5.78.02'>5.78.02 BEBAN PAJAK AIR PERMUKAAN</option> <option value = '5.78.99'>5.78.99 BEBAN AIR PABRIK LAINNYA</option> <option value = '5.80.01'>5.80.01 BEBAN PEMELIHARAAN BANGUNAN</option> <option value = '5.80.11'>5.80.11 BEBAN PEMELIHARAAN INSTALASI LISTRIK</option> <option value = '5.80.12'>5.80.12 BEBAN PEMELIHARAAN INSTALASI AIR</option> <option value = '5.80.21'>5.80.21 BEBAN PEMELIHARAAN MESIN</option> <option value = '5.80.31'>5.80.31 BEBAN PEMELIHARAAN PERALATAN PABRIK</option> <option value = '5.80.41'>5.80.41 BEBAN PEMELIHARAAN KENDARAAN</option> <option value = '5.80.51'>5.80.51 BEBAN PEMELIHARAAN PERALATAN KANTOR</option> <option value = '5.80.61'>5.80.61 BEBAN PEMELIHARAAN PERALATAN IT</option> <option value = '5.81.01'>5.81.01 BEBAN ASURANSI BANGUNAN</option> <option value = '5.81.11'>5.81.11 BEBAN ASURANSI INSTALASI LISTRIK</option> <option value = '5.81.12'>5.81.12 BEBAN ASURANSI INSTALASI AIR</option> <option value = '5.81.21'>5.81.21 BEBAN ASURANSI MESIN</option> <option value = '5.81.31'>5.81.31 BEBAN ASURANSI PERALATAN PABRIK</option> <option value = '5.81.41'>5.81.41 BEBAN ASURANSI KENDARAAN</option> <option value = '5.81.51'>5.81.51 BEBAN ASURANSI PERALATAN KANTOR</option> <option value = '5.81.61'>5.81.61 BEBAN ASURANSI PERALATAN IT</option> <option value = '5.81.71'>5.81.71 BEBAN ASURANSI KENDARAAN</option> <option value = '5.82.01'>5.82.01 BEBAN KEPERLUAN KANTOR</option> <option value = '5.82.02'>5.82.02 BEBAN PEMAKAIAN ATK</option> <option value = '5.82.03'>5.82.03 BEBAN FOTOKOPI</option> <option value = '5.83.01'>5.83.01 TRAINING KARYAWAN PABRIK</option> <option value = '5.83.02'>5.83.02 SERAGAM DAN PERLENGKAPAN KERJA KARYAWAN</option> <option value = '5.83.03'>5.83.03 BEBAN KESEHATAN KARYAWAN</option> <option value = '5.83.04'>5.83.04 BEBAN KECELAKAAN KERJA</option> <option value = '5.84.01'>5.84.01 BEBAN TRANSPORTASI</option> <option value = '5.84.02'>5.84.02 BEBAN PERJALANAN DINAS</option> <option value = '5.84.03'>5.84.03 BEBAN EKSPEDISI ANGKUTAN</option> <option value = '5.85.01'>5.85.01 BEBAN KEPERLUAN PABRIK</option> <option value = '5.86.01'>5.86.01 BEBAN PERIZINAN</option> <option value = '5.86.02'>5.86.02 BEBAN RETRIBUSI</option> <option value = '5.86.03'>5.86.03 BEBAN IURAN</option> <option value = '5.86.04'>5.86.04 BEBAN SUMBANGAN</option> <option value = '5.87.01'>5.87.01 BEBAN PENYUSUTAN BANGUNAN</option> <option value = '5.87.11'>5.87.11 BEBAN PENYUSUTAN INSTALASI LISTRIK</option> <option value = '5.87.12'>5.87.12 BEBAN PENYUSUTAN INSTALASI AIR</option> <option value = '5.87.21'>5.87.21 BEBAN PENYUSUTAN MESIN</option> <option value = '5.87.31'>5.87.31 BEBAN PENYUSUTAN PERALATAN PABRIK</option> <option value = '5.87.41'>5.87.41 BEBAN PENYUSUTAN KENDARAAN</option> <option value = '5.87.51'>5.87.51 BEBAN PENYUSUTAN PERALATAN KANTOR</option> <option value = '5.87.52'>5.87.52 BEBAN PENYUSUTAN PERALATAN IT</option> <option value = '5.87.91'>5.87.91 BEBAN AMORTISASI PERANGKAT LUNAK</option> <option value = '5.97.01'>5.97.01 BEBAN PEMBULATAN</option> <option value = '5.97.02'>5.97.02 BEBAN SELISIH HARGA</option> <option value = '5.97.99'>5.97.99 BEBAN PABRIK LAINNYA</option> <option value = '5.98.99'>5.98.99 BIAYA PRODUKSI BULAN BERJALAN</option> <option value = '5.99.01'>5.99.01 BEBAN PENYESUAIAN PERSEDIAAN KAIN</option> <option value = '5.99.11'>5.99.11 BEBAN PENYESUAIAN PERSEDIAAN AKSESORIS</option> <option value = '5.99.21'>5.99.21 BEBAN PENYESUAIAN PERSEDIAAN DALAM PROSES</option> <option value = '5.99.31'>5.99.31 BEBAN PENYESUAIAN PERSEDIAAN BARANG JADI</option> <option value = '6.01.01'>6.01.01 BEBAN GAJI & UPAH</option> <option value = '6.02.02'>6.02.02 BEBAN TUNJANGAN</option> <option value = '6.03.03'>6.03.03 BEBAN LEMBUR</option> <option value = '6.04.01'>6.04.01 BEBAN BPJS KETENAGAKERJAAN</option> <option value = '6.04.02'>6.04.02 BEBAN BPJS KESEHATAN</option> <option value = '6.05.01'>6.05.01 BEBAN THR</option> <option value = '6.05.02'>6.05.02 BEBAN BONUS</option> <option value = '6.06.01'>6.06.01 BEBAN MANFAAT KARYAWAN</option> <option value = '6.10.01'>6.10.01 BEBAN PROMOSI DAN IKLAN</option> <option value = '6.11.01'>6.11.01 BEBAN EKSPEDISI ANGKUTAN</option> <option value = '6.12.01'>6.12.01 BEBAN EKSPOR</option> <option value = '6.12.02'>6.12.02 BEBAN LC</option> <option value = '6.13.01'>6.13.01 BEBAN PIUTANG TIDAK TERTAGIH</option> <option value = '6.14.01'>6.14.01 BEBAN KLAIM PENJUALAN</option> <option value = '6.14.02'>6.14.02 BEBAN PINALTI PENJUALAN</option> <option value = '6.14.03'>6.14.03 BEBAN KOMISI PENJUALAN</option> <option value = '6.15.01'>6.15.01 BEBAN SAMPEL</option> <option value = '6.15.02'>6.15.02 BEBAN ENTERTAINMENT</option> <option value = '6.16.01'>6.16.01 BEBAN PEMELIHARAAN BANGUNAN</option> <option value = '6.16.11'>6.16.11 BEBAN PEMELIHARAAN INSTALASI LISTRIK</option> <option value = '6.16.12'>6.16.12 BEBAN PEMELIHARAAN INSTALASI AIR</option> <option value = '6.16.21'>6.16.21 BEBAN PEMELIHARAAN MESIN</option> <option value = '6.16.41'>6.16.41 BEBAN PEMELIHARAAN KENDARAAN</option> <option value = '6.16.51'>6.16.51 BEBAN PEMELIHARAAN PERALATAN KANTOR</option> <option value = '6.16.52'>6.16.52 BEBAN PEMELIHARAAN PERALATAN IT</option> <option value = '6.17.01'>6.17.01 BEBAN PENYUSUTAN BANGUNAN</option> <option value = '6.17.11'>6.17.11 BEBAN PENYUSUTAN INSTALASI LISTRIK</option> <option value = '6.17.12'>6.17.12 BEBAN PENYUSUTAN INSTALASI AIR</option> <option value = '6.17.21'>6.17.21 BEBAN PENYUSUTAN MESIN</option> <option value = '6.17.41'>6.17.41 BEBAN PENYUSUTAN KENDARAAN</option> <option value = '6.17.51'>6.17.51 BEBAN PENYUSUTAN PERALATAN KANTOR</option> <option value = '6.17.52'>6.17.52 BEBAN PENYUSUTAN PERALATAN IT</option> <option value = '6.17.91'>6.17.91 BEBAN AMORTISASI PERANGKAT LUNAK</option> <option value = '6.18.01'>6.18.01 BEBAN ASURANSI BANGUNAN</option> <option value = '6.18.11'>6.18.11 BEBAN ASURANSI INSTALASI LISTRIK</option> <option value = '6.18.12'>6.18.12 BEBAN ASURANSI INSTALASI AIR</option> <option value = '6.18.21'>6.18.21 BEBAN ASURANSI MESIN</option> <option value = '6.18.41'>6.18.41 BEBAN ASURANSI KENDARAAN</option> <option value = '6.18.51'>6.18.51 BEBAN ASURANSI PERALATAN KANTOR</option> <option value = '6.18.52'>6.18.52 BEBAN ASURANSI PERALATAN IT</option> <option value = '6.19.01'>6.19.01 BEBAN KEPERLUAN KANTOR</option> <option value = '6.19.02'>6.19.02 BEBAN PEMAKAIAN ATK</option> <option value = '6.19.03'>6.19.03 BEBAN FOTOKOPI</option> <option value = '6.20.01'>6.20.01 BEBAN TRAINING KARYAWAN</option> <option value = '6.21.01'>6.21.01 BEBAN TRANSPORTASI</option> <option value = '6.21.02'>6.21.02 BEBAN PERJALANAN DINAS</option> <option value = '6.22.01'>6.22.01 BEBAN RUMAH TANGGA KANTOR</option> <option value = '6.23.01'>6.23.01 BEBAN PERIZINAN</option> <option value = '6.23.02'>6.23.02 BEBAN RETRIBUSI</option> <option value = '6.23.03'>6.23.03 BEBAN IURAN</option> <option value = '6.23.04'>6.23.04 BEBAN SUMBANGAN</option> <option value = '6.24.01'>6.24.01 BEBAN SEWA KANTOR</option> <option value = '6.25.01'>6.25.01 BEBAN LISTRIK KANTOR</option> <option value = '6.26.01'>6.26.01 BEBAN TELEPON KANTOR</option> <option value = '6.26.02'>6.26.02 BEBAN INTERNET KANTOR</option> <option value = '6.28.01'>6.28.01 BEBAN JASA PROFESIONAL</option> <option value = '6.27.01'>6.27.01 BEBAN AIR KANTOR</option> <option value = '6.29.01'>6.29.01 BEBAN PENJUALAN LAINNYA</option> <option value = '7.30.01'>7.30.01 BEBAN GAJI & UPAH</option> <option value = '7.31.01'>7.31.01 BEBAN TUNJANGAN</option> <option value = '7.32.01'>7.32.01 BEBAN LEMBUR</option> <option value = '7.33.01'>7.33.01 BEBAN BPJS KETENAGAKERJAAN</option> <option value = '7.33.02'>7.33.02 BEBAN BPJS KESEHATAN</option> <option value = '7.34.01'>7.34.01 BEBAN THR</option> <option value = '7.34.02'>7.34.02 BEBAN BONUS</option> <option value = '7.35.01'>7.35.01 BEBAN MANFAAT KARYAWAN</option> <option value = '7.40.01'>7.40.01 BEBAN PAJAK</option> <option value = '7.41.01'>7.41.01 BEBAN JASA PROFESIONAL</option> <option value = '7.42.01'>7.42.01 BEBAN ENTERTAINMENT</option> <option value = '7.43.01'>7.43.01 BEBAN SEWA KANTOR</option> <option value = '7.43.02'>7.43.02 BEBAN SEWA PERALATAN KANTOR</option> <option value = '7.44.01'>7.44.01 BEBAN LISTRIK KANTOR</option> <option value = '7.45.01'>7.45.01 BEBAN TELEPON KANTOR</option> <option value = '7.45.02'>7.45.02 BEBAN INTERNET KANTOR</option> <option value = '7.46.01'>7.46.01 BEBAN AIR KANTOR</option> <option value = '7.47.01'>7.47.01 BEBAN PEMELIHARAAN BANGUNAN</option> <option value = '7.47.11'>7.47.11 BEBAN PEMELIHARAAN INSTALASI LISTRIK</option> <option value = '7.47.12'>7.47.12 BEBAN PEMELIHARAAN INSTALASI AIR</option> <option value = '7.47.21'>7.47.21 BEBAN PEMELIHARAAN MESIN</option> <option value = '7.47.41'>7.47.41 BEBAN PEMELIHARAAN KENDARAAN</option> <option value = '7.47.51'>7.47.51 BEBAN PEMELIHARAAN PERALATAN KANTOR</option> <option value = '7.47.52'>7.47.52 BEBAN PEMELIHARAAN PERALATAN IT</option> <option value = '7.48.01'>7.48.01 BEBAN PENYUSUTAN BANGUNAN</option> <option value = '7.48.11'>7.48.11 BEBAN PENYUSUTAN INSTALASI LISTRIK</option> <option value = '7.48.12'>7.48.12 BEBAN PENYUSUTAN INSTALASI AIR</option> <option value = '7.48.21'>7.48.21 BEBAN PENYUSUTAN MESIN</option> <option value = '7.48.41'>7.48.41 BEBAN PENYUSUTAN KENDARAAN</option> <option value = '7.48.51'>7.48.51 BEBAN PENYUSUTAN PERALATAN KANTOR</option> <option value = '7.48.52'>7.48.52 BEBAN PENYUSUTAN PERALATAN IT</option> <option value = '7.48.91'>7.48.91 BEBAN AMORTISASI PERANGKAT LUNAK</option> <option value = '7.49.01'>7.49.01 BEBAN ASURANSI BANGUNAN</option> <option value = '7.49.11'>7.49.11 BEBAN ASURANSI INSTALASI LISTRIK</option> <option value = '7.49.12'>7.49.12 BEBAN ASURANSI INSTALASI AIR</option> <option value = '7.49.21'>7.49.21 BEBAN ASURANSI MESIN</option> <option value = '7.49.41'>7.49.41 BEBAN ASURANSI KENDARAAN</option> <option value = '7.49.51'>7.49.51 BEBAN ASURANSI PERALATAN KANTOR</option> <option value = '7.49.52'>7.49.52 BEBAN ASURANSI PERALATAN IT</option> <option value = '7.50.01'>7.50.01 BEBAN KEPERLUAN KANTOR</option> <option value = '7.50.02'>7.50.02 BEBAN PEMAKAIAN ATK</option> <option value = '7.50.03'>7.50.03 BEBAN FOTOKOPI</option> <option value = '7.51.01'>7.51.01 BEBAN TRAINING KARYAWAN</option> <option value = '7.52.01'>7.52.01 BEBAN TRANSPORTASI</option> <option value = '7.52.02'>7.52.02 BEBAN PERJALANAN DINAS</option> <option value = '7.53.01'>7.53.01 BEBAN RUMAH TANGGA KANTOR</option> <option value = '7.54.01'>7.54.01 BEBAN PERIZINAN</option> <option value = '7.54.02'>7.54.02 BEBAN RETRIBUSI</option> <option value = '7.54.03'>7.54.03 BEBAN IURAN</option> <option value = '7.54.04'>7.54.04 BEBAN SUMBANGAN</option> <option value = '7.99.01'>7.99.01 BEBAN ADMINISTRASI & UMUM LAINNYA</option> <option value = '8.01.01'>8.01.01 LABA / (RUGI) PENJUALAN ASET TETAP</option> <option value = '8.07.01'>8.07.01 PENDAPATAN LAIN-LAIN</option> <option value = '8.02.01'>8.02.01 LABA / (RUGI) DISPOSISI ASET TETAP</option> <option value = '8.03.01'>8.03.01 PENJUALAN SPAREPARTS</option> <option value = '8.04.01'>8.04.01 PENJUALAN LAIN-LAIN</option> <option value = '8.05.01'>8.05.01 PENDAPATAN JASA GIRO</option> <option value = '8.06.01'>8.06.01 PENDAPATAN SEWA</option> <option value = '8.50.01'>8.50.01 BEBAN BUNGA BANK</option> <option value = '8.50.02'>8.50.02 BEBAN BUNGA PEMEGANG SAHAM/DIREKSI</option> <option value = '8.50.99'>8.50.99 BEBAN BUNGA LAIN-LAIN</option> <option value = '8.51.01'>8.51.01 BEBAN ADMINISTRASI BANK</option> <option value = '8.51.02'>8.51.02 BEBAN PROVISI BANK</option> <option value = '8.51.03'>8.51.03 BEBAN ADMINISTRASI REKENING</option> <option value = '8.52.01'>8.52.01 LABA / (RUGI) SELISIH KURS SUDAH TEREALISASI</option> <option value = '8.52.02'>8.52.02 LABA / (RUGI) SELISIH KURS BELUM TEREALISASI</option> <option value = '8.53.01'>8.53.01 PEMBULATAN</option> <option value = '8.54.01'>8.54.01 BEBAN LAIN-LAIN</option> <option value = '9.10.01'>9.10.01 PAJAK KINI</option> <option value = '9.10.02'>9.10.02 PAJAK TANGGUHAN</option> <option value = '1.90.02'>1.90.02 POS SILANG PIUTANG USAHA</option> <option value = '2.51.99'>2.51.99 BIAYA YANG MASIH HARUS DIBAYAR - LAIN-LAIN</option> <option value = '5.97.03'>5.97.03 BEBAN SELISIH KUANTITAS</option> <option value = '1.42.02'>1.42.02 PERSEDIAAN PAKAIAN JADI DEADSTOCK</option> <option value = '2.19.01'>2.19.01 UTANG LAIN-LAIN DIREKSI</option> <option value = '1.10.82'>1.10.82 BCA 008-412-6311</option> <option value = '7.40.02'>7.40.02 BEBAN PAJAK BUMI DAN BANGUNAN</option> <option value = '5.73.99'>5.73.99 BEBAN IMPOR LAIN-LAIN</option> <option value = '1.10.31'>1.10.31 MANDIRI 130-0002077777</option> <option value = '6.12.03'>6.12.03 BEBAN PREMI CUSTOM BOND</option> <option value = '5.85.02'>5.85.02 BEBAN ENTERTAINMENT</option> <option value = '2.18.02'>2.18.02 UTANG LAIN-LAIN - FORWARDER</option> <option value = '1.34.04'>1.34.04 PIUTANG LAIN-LAIN PIHAK KETIGA - FORWARDER</option></datalist>";

	$.ajax({		
		url: "load_invoice_detail_memo/",							
		type: "GET",
		dataType: "JSON",
		success: function (response) {
			var trHTML = '';
			$.each(response, function (i, item) {
				trHTML += '<tr>';		
				trHTML += '<td><input style="width: 300px;word-wrap: break-word;" type="text" class="form-control" name="inputan0" placeholder="" autocomplete="off">';		
				trHTML += '<td><input style="width: 250px;" class="form-control" value="'+ item.supplier +'" list="supp" name="supp"> <datalist id="supp"><option value="'+ item.supplier +'">'+ item.supplier +'</option></datalist></td>';
				trHTML += '<td><input style="width: 200px" type="text" class="form-control" name="inputan2" value="'+ item.no_invoice +'" placeholder="" autocomplete="off"></td>';
				trHTML += '<td><input style="width: 200px" type="text" class="form-control" id="inputan3" name="inputan3" placeholder="" autocomplete="off" readonly></td>';
				trHTML += '<td><input style="width: 200px" type="text" class="form-control" id="inputan4" name="inputan4" placeholder="" autocomplete="off" readonly></td>';
				trHTML += '<td><input style="width: 200px" type="text" class="form-control" id="inputan5" name="inputan5" placeholder="" autocomplete="off" readonly></td>';
				trHTML += '<td><input  type="text" class="form-control" id="amt" name="amt" value="'+ item.total +'" style="text-align:right; width: 150px;" oninput="modal_input_amt_dn(value)" autocomplete="off"></td>';
				trHTML += '<td><input  type="text" class="form-control" id="amt_rate" name="amt_rate" style="text-align:right; width: 150px;" value="1" onkeypress="javascript:return isNumber(event)" oninput="modal_input_rate_dn(value)" autocomplete="off"></td>';										    					
				trHTML += '<td ><input style="width: 150px;text-align: right;" type="text" class="form-control" name="inputan8" value="'+ item.total +'" placeholder="" autocomplete="off" readonly></td>';
				trHTML += '<td>' + coa + '</td>';		
				trHTML += '<td><input name="chk_a[]" type="checkbox" class="checkall_a" value=""/></td>';											
				trHTML += '<td hidden><input type="checkbox" name="id_memo_det" id="id_memo_det" class="flat" value = ' + item.id + ' checked></td>';
				trHTML += '<td hidden><input style="width: 200px" type="text" class="form-control" name="text" value="'+ item.nm_memo +'" placeholder="" autocomplete="off"></td>';
				trHTML += '<td hidden><input style="width: 200px" type="text" class="form-control" name="text" value="'+ item.id +'" placeholder="" autocomplete="off"></td>';
				trHTML += '</tr>';

			});
			$('#table-dn').append(trHTML);
                        //Grand Total SO Proforma
						// sum_grandtotal_proforma(); 

					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Error get data from ajax');
					}
				});  	  	

}




function update_memo_det(){
	//
	var cek_inv = document.getElementsByName("id_memo_det");	
	var dn_number    = $('[name="dn_number"]').val();
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
				//   
				var id_memo_det = cek_inv[i].value
                //
                var formData = {
                	"dn_number": dn_number,
                	"id_memo_det": id_memo_det,			
                };
                console.log(formData);
				//
				$.ajax({						
					url: "update_memo_det/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				// $('#modal-approve-invoicedp').modal('hide');
				// console.log(id_inv);  
				// window.location.reload();
				// cari_invoice_post();

				//
			} 
		}

	}

	function export_list_dn() { 
		var id_customer = $('#list_prof_customer').val();	
		window.open(".../../export_excel_list_dn/" + dt_dari_prof_inv  + "/" + dt_sampai_prof_inv + "/" + "/" + id_customer + "/" ); 
	}


	function cari_dn_appv(){ 

		$('#table-dn-rvs tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_approv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_approv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_approv   = "undefined";
			dt_sampai_approv = "undefined";
		});

		$.ajax({		
			url: "cari_dn_appv/" + dt_dari_approv + "/" + dt_sampai_approv + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {

				var trHTML = '';
				$.each(response, function (i, item) { 					
					trHTML += '<tr>';					
					trHTML += '<td>' + item.no_dn + "</td>";					
					trHTML += '<td>' + item.tgl_dn + "</td>";	
					trHTML += '<td>' + item.Supplier + "</td>";
					trHTML += '<td>' + item.attn + "</td>";
					trHTML += '<td>' + item.to_curr + ' '+ item.eqv_curr + "</td>";
					trHTML += '<td>' + item.status + "</td>";	
					trHTML += '<td>' + item.id + "</td>";					
					trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_dn_rvs" id="pilih_dn_rvs" class="flat" value = ' + item.no_dn + '></td>';										
				//trHTML += '<td><button id="approv_inv" name="approv_inv" type="button" class="btn btn-warning btn-sm" onclick="approve_invoice(\'' + item.no_invoice + '\' , \'' + item.id + '\')"><i class="fa fa-stamp"></i> Approved</td>';
				trHTML += '</tr>';

			});

				$('#table-dn-rvs').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	
	}


	function modal_show_reverse_dn() { 

		var cek_inv = document.getElementsByName("pilih_dn_rvs");	
		for (var i = 0; i < cek_inv.length; i++) {
		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {				   
		    	$('#modal-reverse-dn').modal('show');  
		    } 
		}	
	}

	async function refresh_rvs_dn(){
		var result = await reverse_dn()
		console.log(result);
		var cek_inv = document.getElementsByName("pilih_dn_rvs");	
		for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
		    	var coba = parseInt(i + 1);		
		    }
		}
		alert(" Debitnote Successfully Reverse");
   // cari_invoice_manual_appv();
}


function reverse_dn(){
	//
	var cek_inv = document.getElementsByName("pilih_dn_rvs");
	var keter = $('[name="keter"]').val()	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
				//   
				var id_inv = cek_inv[i].value
                //
                var formData = {
                	"id_inv": id_inv,
                	"keter": keter,			
                };
				//
				$.ajax({						
					url: "reverse_dn/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				$('#modal-reverse-dn').modal('hide');
				console.log(id_inv);  
				window.location.reload();
				// cari_invoice_post();

				//
			} 
		}

	}


	function cari_sj_noncom(){ 

		$('#table-update_sj tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_sj = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_sj = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_sj   = "undefined";
			dt_sampai_sj = "undefined";
		});

		console.log(dt_dari_sj);

		$.ajax({		
			url: "cari_sj_noncom/" + dt_dari_sj + "/" + dt_sampai_sj + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {
				console.log(response);

				var trHTML = '';
				$.each(response, function (i, item) { 					
					trHTML += '<tr>';					
					trHTML += '<td>' + item.supplier + "</td>";					
					trHTML += '<td>' + item.no_so + "</td>";	
					trHTML += '<td>' + item.so_date + "</td>";
					trHTML += '<td>' + item.shipping_number + "</td>";
					trHTML += '<td>' + item.bppbdate + "</td>";
					trHTML += '<td>' + item.invno + "</td>";
					trHTML += '<td>' + item.curr + "</td>";	
					trHTML += '<td>' + item.qty_pcs + "</td>";
					trHTML += '<td>' + item.unit_price + "</td>";	
					trHTML += '<td>' + item.total + "</td>";	
					trHTML += '<td>' + item.id_bppb + "</td>";					
					trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_no_fg" id="pilih_no_fg" class="flat" value = ' + item.id_bppb + '></td>';										
				//trHTML += '<td><button id="approv_inv" name="approv_inv" type="button" class="btn btn-warning btn-sm" onclick="approve_invoice(\'' + item.no_invoice + '\' , \'' + item.id + '\')"><i class="fa fa-stamp"></i> Approved</td>';
				trHTML += '</tr>';

			});

				$('#table-update_sj').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	
	}


	function modal_show_update_nofg() { 

		var cek_inv = document.getElementsByName("pilih_no_fg");	
		for (var i = 0; i < cek_inv.length; i++) {
		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {				   
		    	$('#modal-update_nofg').modal('show');  
		    } 
		}	
	}


	async function set_update_fg(){
		var result = await update_nofg()
		console.log(result);
		var cek_inv = document.getElementsByName("pilih_no_fg");	
		for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
		    if (cek_inv[i].checked) {	
		    	var coba = parseInt(i + 1);		
		    }
		}
		alert(" Update Successfully");
		cari_sj_noncom();
	}

	function update_nofg(){
	//
	var cek_sj = document.getElementsByName("pilih_no_fg");	
	for (var i = 0; i < cek_sj.length; i++) {

		    //Ceklist Invoice		
		    if (cek_sj[i].checked) {	
				//   
				var id_bppb = cek_sj[i].value
                //
                var formData = {
                	"id_bppb": id_bppb,			
                };
				//
				$.ajax({						
					url: "update_nofg/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		

						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update SJ'
						} else {
							msg = 'Error Update SJ'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				$('#modal-update_nofg').modal('hide');
				console.log(id_bppb);  
				// window.location.reload();
				// cari_invoice_post();

				//
			} 
		}

	}


	function cari_sj_noncom2(){ 

		$('#table-report_sj_notyet tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_sj = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_sj = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_sj   = "undefined";
			dt_sampai_sj = "undefined";
		});

		console.log(dt_dari_sj);

		$.ajax({		
			url: "cari_sj_noncom/" + dt_dari_sj + "/" + dt_sampai_sj + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {
				console.log(response);

				var trHTML = '';
				var kata = '';
				var jml_total = 0;
				var total_idr = 0;
				var rate = 0;
				$.each(response, function (i, item) { 
					kata = 'Total';
					if (item.curr == 'USD') {
						rate = parseFloat(item.rate);
					}else{
						rate = 1;
					}
					total_idr  = (parseFloat(item.total_price) * rate).toFixed(2);	
					jml_total += parseFloat(item.ttl_price);					
					trHTML += '<tr>';					
					trHTML += '<td>' + item.supplier + "</td>";					
					trHTML += '<td>' + item.no_so + "</td>";	
					trHTML += '<td>' + item.so_date + "</td>";
					trHTML += '<td>' + item.shipping_number + "</td>";
					trHTML += '<td>' + item.bppbdate + "</td>";
					trHTML += '<td>' + item.invno + "</td>";
					trHTML += '<td>' + item.styleno + "</td>";	
					trHTML += '<td>' + item.product_group + "</td>";	
					trHTML += '<td>' + item.product_item + "</td>";	
					trHTML += '<td>' + item.color + "</td>";	
					trHTML += '<td>' + item.size + "</td>";	
					trHTML += '<td>' + item.curr + "</td>";	
					trHTML += '<td>' + item.qty + "</td>";
					trHTML += '<td>' + item.uom + "</td>";
					trHTML += '<td>' + item.unit_price + "</td>";	
					trHTML += '<td>' + item.total + "</td>";
					trHTML += '<td>' + total_idr + "</td>";	
					trHTML += '<td> Not Yet</td>';					
					trHTML += '</tr>';
				});

				trHTML += '<tr>';					
				trHTML += '<th colspan="16" style="text-align: center">' +kata+ "</th>";
				trHTML += '<th>' + formatMoney(jml_total) + "</th>";
				trHTML += '<th style="text-align: center"></th>';
				trHTML += '</tr>';

				$('#table-report_sj_notyet').append(trHTML);				

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});	
	}



	function export_sj_noncom2() { 		
		window.open(".../../export_sj_noncom2/" + dt_dari_sj  + "/" + dt_sampai_sj  + "/"); 
	}

